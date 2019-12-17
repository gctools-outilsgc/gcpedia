<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Cache
 */

use Liuggio\StatsdClient\Factory\StatsdDataFactoryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Multi-datacenter aware caching interface
 *
 * ### Using WANObjectCache
 *
 * All operations go to the local datacenter cache, except for delete(),
 * touchCheckKey(), and resetCheckKey(), which broadcast to all datacenters.
 *
 * This class is intended for caching data from primary stores.
 * If the get() method does not return a value, then the caller
 * should query the new value and backfill the cache using set().
 * The preferred way to do this logic is through getWithSetCallback().
 * When querying the store on cache miss, the closest DB replica
 * should be used. Try to avoid heavyweight DB master or quorum reads.
 *
 * To ensure consumers of the cache see new values in a timely manner,
 * you either need to follow either the validation strategy, or the
 * purge strategy.
 *
 * The validation strategy refers to the natural avoidance of stale data
 * by one of the following means:
 *
 *   - A) The cached value is immutable.
 *        If the consumer has access to an identifier that uniquely describes a value,
 *        cached value need not change. Instead, the key can change. This also allows
 *        all servers to access their perceived current version. This is important
 *        in context of multiple deployed versions of your application and/or cross-dc
 *        database replication, to ensure deterministic values without oscillation.
 *   - B) Validity is checked against the source after get().
 *        This is the inverse of A. The unique identifier is embedded inside the value
 *        and validated after on retreival. If outdated, the value is recomputed.
 *   - C) The value is cached with a modest TTL (without validation).
 *        If value recomputation is reasonably performant, and the value is allowed to
 *        be stale, one should consider using TTL only – using the value's age as
 *        method of validation.
 *
 * The purge strategy refers to the the approach whereby your application knows that
 * source data has changed and can react by purging the relevant cache keys.
 * As purges are expensive, this strategy should be avoided if possible.
 * The simplest purge method is delete().
 *
 * No matter which strategy you choose, callers must not rely on updates or purges
 * being immediately visible to other servers. It should be treated similarly as
 * one would a database replica.
 *
 * The need for immediate updates should be avoided. If needed, solutions must be
 * sought outside WANObjectCache.
 *
 * ### Deploying WANObjectCache
 *
 * There are two supported ways to set up broadcasted operations:
 *
 *   - A) Set up mcrouter as the underlying cache backend, using a memcached BagOStuff class
 *        for the 'cache' parameter. The 'region' and 'cluster' parameters must be provided
 *        and 'mcrouterAware' must be set to `true`.
 *        Configure mcrouter as follows:
 *          - 1) Use Route Prefixing based on region (datacenter) and cache cluster.
 *               See https://github.com/facebook/mcrouter/wiki/Routing-Prefix and
 *               https://github.com/facebook/mcrouter/wiki/Multi-cluster-broadcast-setup.
 *          - 2) To increase the consistency of delete() and touchCheckKey() during cache
 *               server membership changes, you can use the OperationSelectorRoute to
 *               configure 'set' and 'delete' operations to go to all servers in the cache
 *               cluster, instead of just one server determined by hashing.
 *               See https://github.com/facebook/mcrouter/wiki/List-of-Route-Handles.
 *   - B) Set up dynomite as a cache middleware between the web servers and either memcached
 *        or redis and use it as the underlying cache backend, using a memcached BagOStuff
 *        class for the 'cache' parameter. This will broadcast all key setting operations,
 *        not just purges, which can be useful for cache warming. Writes are eventually
 *        consistent via the Dynamo replication model. See https://github.com/Netflix/dynomite.
 *
 * Broadcasted operations like delete() and touchCheckKey() are intended to run
 * immediately in the local datacenter and asynchronously in remote datacenters.
 *
 * This means that callers in all datacenters may see older values for however many
 * milliseconds that the purge took to reach that datacenter. As with any cache, this
 * should not be relied on for cases where reads are used to determine writes to source
 * (e.g. non-cache) data stores, except when reading immutable data.
 *
 * All values are wrapped in metadata arrays. Keys use a "WANCache:" prefix
 * to avoid collisions with keys that are not wrapped as metadata arrays. The
 * prefixes are as follows:
 *   - a) "WANCache:v" : used for regular value keys
 *   - b) "WANCache:i" : used for temporarily storing values of tombstoned keys
 *   - c) "WANCache:t" : used for storing timestamp "check" keys
 *   - d) "WANCache:m" : used for temporary mutex keys to avoid cache stampedes
 *
 * @ingroup Cache
 * @since 1.26
 */
class WANObjectCache implements IExpiringStore, LoggerAwareInterface {
	/** @var BagOStuff The local datacenter cache */
	protected $cache;
	/** @var MapCacheLRU[] Map of group PHP instance caches */
	protected $processCaches = [];
	/** @bar bool Whether to use mcrouter key prefixing for routing */
	protected $mcrouterAware;
	/** @var string Physical region for mcrouter use */
	protected $region;
	/** @var string Cache cluster name for mcrouter use */
	protected $cluster;
	/** @var LoggerInterface */
	protected $logger;
	/** @var StatsdDataFactoryInterface */
	protected $stats;
	/** @var bool Whether to use "interim" caching while keys are tombstoned */
	protected $useInterimHoldOffCaching = true;
	/** @var callable|null Function that takes a WAN cache callback and runs it later */
	protected $asyncHandler;
	/** @var float Unix timestamp of the oldest possible valid values */
	protected $epoch;

	/** @var int Callback stack depth for getWithSetCallback() */
	private $callbackDepth = 0;
	/** @var mixed[] Temporary warm-up cache */
	private $warmupCache = [];
	/** @var int Key fetched */
	private $warmupKeyMisses = 0;

	/** @var float|null */
	private $wallClockOverride;

	/** Max time expected to pass between delete() and DB commit finishing */
	const MAX_COMMIT_DELAY = 3;
	/** Max replication+snapshot lag before applying TTL_LAGGED or disallowing set() */
	const MAX_READ_LAG = 7;
	/** Seconds to tombstone keys on delete() */
	const HOLDOFF_TTL = 11; // MAX_COMMIT_DELAY + MAX_READ_LAG + 1

	/** Seconds to keep dependency purge keys around */
	const CHECK_KEY_TTL = self::TTL_YEAR;
	/** Seconds to keep interim value keys for tombstoned keys around */
	const INTERIM_KEY_TTL = 1;

	/** Seconds to keep lock keys around */
	const LOCK_TTL = 10;
	/** Seconds to no-op key set() calls to avoid large blob I/O stampedes */
	const COOLOFF_TTL = 1;
	/** Default remaining TTL at which to consider pre-emptive regeneration */
	const LOW_TTL = 30;

	/** Never consider performing "popularity" refreshes until a key reaches this age */
	const AGE_NEW = 60;
	/** The time length of the "popularity" refresh window for hot keys */
	const HOT_TTR = 900;
	/** Hits/second for a refresh to be expected within the "popularity" window */
	const HIT_RATE_HIGH = 1;
	/** Seconds to ramp up to the "popularity" refresh chance after a key is no longer new */
	const RAMPUP_TTL = 30;

	/** Idiom for getWithSetCallback() callbacks to avoid calling set() */
	const TTL_UNCACHEABLE = -1;
	/** Idiom for getWithSetCallback() callbacks to 'lockTSE' logic */
	const TSE_NONE = -1;
	/** Max TTL to store keys when a data sourced is lagged */
	const TTL_LAGGED = 30;
	/** Idiom for delete() for "no hold-off" */
	const HOLDOFF_NONE = 0;
	/** Idiom for set()/getWithSetCallback() for "do not augment the storage medium TTL" */
	const STALE_TTL_NONE = 0;
	/** Idiom for set()/getWithSetCallback() for "no post-expired grace period" */
	const GRACE_TTL_NONE = 0;

	/** Idiom for getWithSetCallback() for "no minimum required as-of timestamp" */
	const MIN_TIMESTAMP_NONE = 0.0;

	/** Tiny negative float to use when CTL comes up >= 0 due to clock skew */
	const TINY_NEGATIVE = -0.000001;
	/** Tiny positive float to use when using "minTime" to assert an inequality */
	const TINY_POSTIVE = 0.000001;

	/** Milliseconds of delay after get() where set() storms are a consideration with 'lockTSE' */
	const SET_DELAY_HIGH_MS = 50;
	/** Min millisecond set() backoff for keys in hold-off (far less than INTERIM_KEY_TTL) */
	const RECENT_SET_LOW_MS = 50;
	/** Max millisecond set() backoff for keys in hold-off (far less than INTERIM_KEY_TTL) */
	const RECENT_SET_HIGH_MS = 100;

	/** Parameter to get()/getMulti() to return extra information by reference */
	const PASS_BY_REF = -1;

	/** Cache format version number */
	const VERSION = 1;

	const FLD_VERSION = 0; // key to cache version number
	const FLD_VALUE = 1; // key to the cached value
	const FLD_TTL = 2; // key to the original TTL
	const FLD_TIME = 3; // key to the cache time
	const FLD_FLAGS = 4; // key to the flags bitfield (reserved number)
	const FLD_HOLDOFF = 5; // key to any hold-off TTL

	const VALUE_KEY_PREFIX = 'WANCache:v:';
	const INTERIM_KEY_PREFIX = 'WANCache:i:';
	const TIME_KEY_PREFIX = 'WANCache:t:';
	const MUTEX_KEY_PREFIX = 'WANCache:m:';
	const COOLOFF_KEY_PREFIX = 'WANCache:c:';

	const PURGE_VAL_PREFIX = 'PURGED:';

	const VFLD_DATA = 'WOC:d'; // key to the value of versioned data
	const VFLD_VERSION = 'WOC:v'; // key to the version of the value present

	const PC_PRIMARY = 'primary:1000'; // process cache name and max key count

	/**
	 * @param array $params
	 *   - cache    : BagOStuff object for a persistent cache
	 *   - logger   : LoggerInterface object
	 *   - stats    : StatsdDataFactoryInterface object
	 *   - asyncHandler : A function that takes a callback and runs it later. If supplied,
	 *       whenever a preemptive refresh would be triggered in getWithSetCallback(), the
	 *       current cache value is still used instead. However, the async-handler function
	 *       receives a WAN cache callback that, when run, will execute the value generation
	 *       callback supplied by the getWithSetCallback() caller. The result will be saved
	 *       as normal. The handler is expected to call the WAN cache callback at an opportune
	 *       time (e.g. HTTP post-send), though generally within a few 100ms. [optional]
	 *   - region: the current physical region. This is required when using mcrouter as the
	 *       backing store proxy. [optional]
	 *   - cluster: name of the cache cluster used by this WAN cache. The name must be the
	 *       same in all datacenters; the ("region","cluster") tuple is what distinguishes
	 *       the counterpart cache clusters among all the datacenter. The contents of
	 *       https://github.com/facebook/mcrouter/wiki/Config-Files give background on this.
	 *       This is required when using mcrouter as the backing store proxy. [optional]
	 *   - mcrouterAware: set as true if mcrouter is the backing store proxy and mcrouter
	 *       is configured to interpret /<region>/<cluster>/ key prefixes as routes. This
	 *       requires that "region" and "cluster" are both set above. [optional]
	 *   - epoch: lowest UNIX timestamp a value/tombstone must have to be valid. [optional]
	 */
	public function __construct( array $params ) {
		$this->cache = $params['cache'];
		$this->region = $params['region'] ?? 'main';
		$this->cluster = $params['cluster'] ?? 'wan-main';
		$this->mcrouterAware = !empty( $params['mcrouterAware'] );
		$this->epoch = $params['epoch'] ?? 1.0;

		$this->setLogger( $params['logger'] ?? new NullLogger() );
		$this->stats = $params['stats'] ?? new NullStatsdDataFactory();
		$this->asyncHandler = $params['asyncHandler'] ?? null;
	}

	/**
	 * @param LoggerInterface $logger
	 */
	public function setLogger( LoggerInterface $logger ) {
		$this->logger = $logger;
	}

	/**
	 * Get an instance that wraps EmptyBagOStuff
	 *
	 * @return WANObjectCache
	 */
	public static function newEmpty() {
		return new static( [ 'cache' => new EmptyBagOStuff() ] );
	}

	/**
	 * Fetch the value of a key from cache
	 *
	 * If supplied, $curTTL is set to the remaining TTL (current time left):
	 *   - a) INF; if $key exists, has no TTL, and is not invalidated by $checkKeys
	 *   - b) float (>=0); if $key exists, has a TTL, and is not invalidated by $checkKeys
	 *   - c) float (<0); if $key is tombstoned, stale, or existing but invalidated by $checkKeys
	 *   - d) null; if $key does not exist and is not tombstoned
	 *
	 * If a key is tombstoned, $curTTL will reflect the time since delete().
	 *
	 * The timestamp of $key will be checked against the last-purge timestamp
	 * of each of $checkKeys. Those $checkKeys not in cache will have the last-purge
	 * initialized to the current timestamp. If any of $checkKeys have a timestamp
	 * greater than that of $key, then $curTTL will reflect how long ago $key
	 * became invalid. Callers can use $curTTL to know when the value is stale.
	 * The $checkKeys parameter allow mass invalidations by updating a single key:
	 *   - a) Each "check" key represents "last purged" of some source data
	 *   - b) Callers pass in relevant "check" keys as $checkKeys in get()
	 *   - c) When the source data that "check" keys represent changes,
	 *        the touchCheckKey() method is called on them
	 *
	 * Source data entities might exists in a DB that uses snapshot isolation
	 * (e.g. the default REPEATABLE-READ in innoDB). Even for mutable data, that
	 * isolation can largely be maintained by doing the following:
	 *   - a) Calling delete() on entity change *and* creation, before DB commit
	 *   - b) Keeping transaction duration shorter than the delete() hold-off TTL
	 *   - c) Disabling interim key caching via useInterimHoldOffCaching() before get() calls
	 *
	 * However, pre-snapshot values might still be seen if an update was made
	 * in a remote datacenter but the purge from delete() didn't relay yet.
	 *
	 * Consider using getWithSetCallback() instead of get() and set() cycles.
	 * That method has cache slam avoiding features for hot/expensive keys.
	 *
	 * Pass $info as WANObjectCache::PASS_BY_REF to transform it into a cache key info map.
	 * This map includes the following metadata:
	 *   - asOf: UNIX timestamp of the value or null if the key is nonexistant
	 *   - tombAsOf: UNIX timestamp of the tombstone or null if the key is not tombstoned
	 *   - lastCKPurge: UNIX timestamp of the highest check key or null if none provided
	 *
	 * Otherwise, $info will transform into the cached value timestamp.
	 *
	 * @param string $key Cache key made from makeKey() or makeGlobalKey()
	 * @param mixed|null &$curTTL Approximate TTL left on the key if present/tombstoned [returned]
	 * @param array $checkKeys List of "check" keys
	 * @param mixed|null &$info Key info if WANObjectCache::PASS_BY_REF [returned]
	 * @return mixed Value of cache key or false on failure
	 */
	final public function get(
		$key, &$curTTL = null, array $checkKeys = [], &$info = null
	) {
		$curTTLs = self::PASS_BY_REF;
		$infoByKey = self::PASS_BY_REF;
		$values = $this->getMulti( [ $key ], $curTTLs, $checkKeys, $infoByKey );
		$curTTL = $curTTLs[$key] ?? null;
		if ( $info === self::PASS_BY_REF ) {
			$info = [
				'asOf' => $infoByKey[$key]['asOf'] ?? null,
				'tombAsOf' => $infoByKey[$key]['tombAsOf'] ?? null,
				'lastCKPurge' => $infoByKey[$key]['lastCKPurge'] ?? null
			];
		} else {
			$info = $infoByKey[$key]['asOf'] ?? null; // b/c
		}

		return $values[$key] ?? false;
	}

	/**
	 * Fetch the value of several keys from cache
	 *
	 * Pass $info as WANObjectCache::PASS_BY_REF to transform it into a map of cache keys
	 * to cache key info maps, each having the same style as those of WANObjectCache::get().
	 * All the cache keys listed in $keys will have an entry.
	 *
	 * Othwerwise, $info will transform into a map of (cache key => cached value timestamp).
	 * Only the cache keys listed in $keys that exists or are tombstoned will have an entry.
	 *
	 * @see WANObjectCache::get()
	 *
	 * @param array $keys List of cache keys made from makeKey() or makeGlobalKey()
	 * @param mixed|null &$curTTLs Map of (key => TTL left) for existing/tombstoned keys [returned]
	 * @param array $checkKeys List of check keys to apply to all $keys. May also apply "check"
	 *  keys to specific cache keys only by using cache keys as keys in the $checkKeys array.
	 * @param mixed|null &$info Map of (key => info) if WANObjectCache::PASS_BY_REF [returned]
	 * @return array Map of (key => value) for keys that exist and are not tombstoned
	 */
	final public function getMulti(
		array $keys,
		&$curTTLs = [],
		array $checkKeys = [],
		&$info = null
	) {
		$result = [];
		$curTTLs = [];
		$infoByKey = [];

		$vPrefixLen = strlen( self::VALUE_KEY_PREFIX );
		$valueKeys = self::prefixCacheKeys( $keys, self::VALUE_KEY_PREFIX );

		$checkKeysForAll = [];
		$checkKeysByKey = [];
		$checkKeysFlat = [];
		foreach ( $checkKeys as $i => $checkKeyGroup ) {
			$prefixed = self::prefixCacheKeys( (array)$checkKeyGroup, self::TIME_KEY_PREFIX );
			$checkKeysFlat = array_merge( $checkKeysFlat, $prefixed );
			// Are these check keys for a specific cache key, or for all keys being fetched?
			if ( is_int( $i ) ) {
				$checkKeysForAll = array_merge( $checkKeysForAll, $prefixed );
			} else {
				$checkKeysByKey[$i] = $prefixed;
			}
		}

		// Fetch all of the raw values
		$keysGet = array_merge( $valueKeys, $checkKeysFlat );
		if ( $this->warmupCache ) {
			$wrappedValues = array_intersect_key( $this->warmupCache, array_flip( $keysGet ) );
			$keysGet = array_diff( $keysGet, array_keys( $wrappedValues ) ); // keys left to fetch
			$this->warmupKeyMisses += count( $keysGet );
		} else {
			$wrappedValues = [];
		}
		if ( $keysGet ) {
			$wrappedValues += $this->cache->getMulti( $keysGet );
		}
		// Time used to compare/init "check" keys (derived after getMulti() to be pessimistic)
		$now = $this->getCurrentTime();

		// Collect timestamps from all "check" keys
		$purgeValuesForAll = $this->processCheckKeys( $checkKeysForAll, $wrappedValues, $now );
		$purgeValuesByKey = [];
		foreach ( $checkKeysByKey as $cacheKey => $checks ) {
			$purgeValuesByKey[$cacheKey] =
				$this->processCheckKeys( $checks, $wrappedValues, $now );
		}

		// Get the main cache value for each key and validate them
		foreach ( $valueKeys as $vKey ) {
			$key = substr( $vKey, $vPrefixLen ); // unprefix
			list( $value, $curTTL, $asOf, $tombAsOf ) = isset( $wrappedValues[$vKey] )
				? $this->unwrap( $wrappedValues[$vKey], $now )
				: [ false, null, null, null ]; // not found
			// Force dependent keys to be seen as stale for a while after purging
			// to reduce race conditions involving stale data getting cached
			$purgeValues = $purgeValuesForAll;
			if ( isset( $purgeValuesByKey[$key] ) ) {
				$purgeValues = array_merge( $purgeValues, $purgeValuesByKey[$key] );
			}

			$lastCKPurge = null; // timestamp of the highest check key
			foreach ( $purgeValues as $purge ) {
				$lastCKPurge = max( $purge[self::FLD_TIME], $lastCKPurge );
				$safeTimestamp = $purge[self::FLD_TIME] + $purge[self::FLD_HOLDOFF];
				if ( $value !== false && $safeTimestamp >= $asOf ) {
					// How long ago this value was invalidated by *this* check key
					$ago = min( $purge[self::FLD_TIME] - $now, self::TINY_NEGATIVE );
					// How long ago this value was invalidated by *any* known check key
					$curTTL = min( $curTTL, $ago );
				}
			}

			if ( $value !== false ) {
				$result[$key] = $value;
			}
			if ( $curTTL !== null ) {
				$curTTLs[$key] = $curTTL;
			}

			$infoByKey[$key] = ( $info === self::PASS_BY_REF )
				? [ 'asOf' => $asOf, 'tombAsOf' => $tombAsOf, 'lastCKPurge' => $lastCKPurge ]
				: $asOf; // b/c
		}

		$info = $infoByKey;

		return $result;
	}

	/**
	 * @since 1.27
	 * @param array $timeKeys List of prefixed time check keys
	 * @param array $wrappedValues
	 * @param float $now
	 * @return array List of purge value arrays
	 */
	private function processCheckKeys( array $timeKeys, array $wrappedValues, $now ) {
		$purgeValues = [];
		foreach ( $timeKeys as $timeKey ) {
			$purge = isset( $wrappedValues[$timeKey] )
				? $this->parsePurgeValue( $wrappedValues[$timeKey] )
				: false;
			if ( $purge === false ) {
				// Key is not set or malformed; regenerate
				$newVal = $this->makePurgeValue( $now, self::HOLDOFF_TTL );
				$this->cache->add( $timeKey, $newVal, self::CHECK_KEY_TTL );
				$purge = $this->parsePurgeValue( $newVal );
			}
			$purgeValues[] = $purge;
		}
		return $purgeValues;
	}

	/**
	 * Set the value of a key in cache
	 *
	 * Simply calling this method when source data changes is not valid because
	 * the changes do not replicate to the other WAN sites. In that case, delete()
	 * should be used instead. This method is intended for use on cache misses.
	 *
	 * If the data was read from a snapshot-isolated transactions (e.g. the default
	 * REPEATABLE-READ in innoDB), use 'since' to avoid the following race condition:
	 *   - a) T1 starts
	 *   - b) T2 updates a row, calls delete(), and commits
	 *   - c) The HOLDOFF_TTL passes, expiring the delete() tombstone
	 *   - d) T1 reads the row and calls set() due to a cache miss
	 *   - e) Stale value is stuck in cache
	 *
	 * Setting 'lag' and 'since' help avoids keys getting stuck in stale states.
	 *
	 * Be aware that this does not update the process cache for getWithSetCallback()
	 * callers. Keys accessed via that method are not generally meant to also be set
	 * using this primitive method.
	 *
	 * Do not use this method on versioned keys accessed via getWithSetCallback().
	 *
	 * Example usage:
	 * @code
	 *     $dbr = wfGetDB( DB_REPLICA );
	 *     $setOpts = Database::getCacheSetOptions( $dbr );
	 *     // Fetch the row from the DB
	 *     $row = $dbr->selectRow( ... );
	 *     $key = $cache->makeKey( 'building', $buildingId );
	 *     $cache->set( $key, $row, $cache::TTL_DAY, $setOpts );
	 * @endcode
	 *
	 * @param string $key Cache key
	 * @param mixed $value
	 * @param int $ttl Seconds to live. Special values are:
	 *   - WANObjectCache::TTL_INDEFINITE: Cache forever (default)
	 * @param array $opts Options map:
	 *   - lag: seconds of replica DB lag. Typically, this is either the replica DB lag
	 *      before the data was read or, if applicable, the replica DB lag before
	 *      the snapshot-isolated transaction the data was read from started.
	 *      Use false to indicate that replication is not running.
	 *      Default: 0 seconds
	 *   - since: UNIX timestamp of the data in $value. Typically, this is either
	 *      the current time the data was read or (if applicable) the time when
	 *      the snapshot-isolated transaction the data was read from started.
	 *      Default: 0 seconds
	 *   - pending: whether this data is possibly from an uncommitted write transaction.
	 *      Generally, other threads should not see values from the future and
	 *      they certainly should not see ones that ended up getting rolled back.
	 *      Default: false
	 *   - lockTSE: if excessive replication/snapshot lag is detected, then store the value
	 *      with this TTL and flag it as stale. This is only useful if the reads for this key
	 *      use getWithSetCallback() with "lockTSE" set. Note that if "staleTTL" is set
	 *      then it will still add on to this TTL in the excessive lag scenario.
	 *      Default: WANObjectCache::TSE_NONE
	 *   - staleTTL: seconds to keep the key around if it is stale. The get()/getMulti()
	 *      methods return such stale values with a $curTTL of 0, and getWithSetCallback()
	 *      will call the regeneration callback in such cases, passing in the old value
	 *      and its as-of time to the callback. This is useful if adaptiveTTL() is used
	 *      on the old value's as-of time when it is verified as still being correct.
	 *      Default: WANObjectCache::STALE_TTL_NONE.
	 *   - creating: optimize for the case where the key does not already exist.
	 *      Default: false
	 * @note Options added in 1.28: staleTTL
	 * @note Options added in 1.33: creating
	 * @return bool Success
	 */
	final public function set( $key, $value, $ttl = self::TTL_INDEFINITE, array $opts = [] ) {
		$now = $this->getCurrentTime();
		$lockTSE = $opts['lockTSE'] ?? self::TSE_NONE;
		$staleTTL = $opts['staleTTL'] ?? self::STALE_TTL_NONE;
		$age = isset( $opts['since'] ) ? max( 0, $now - $opts['since'] ) : 0;
		$creating = $opts['creating'] ?? false;
		$lag = $opts['lag'] ?? 0;

		// Do not cache potentially uncommitted data as it might get rolled back
		if ( !empty( $opts['pending'] ) ) {
			$this->logger->info(
				'Rejected set() for {cachekey} due to pending writes.',
				[ 'cachekey' => $key ]
			);

			return true; // no-op the write for being unsafe
		}

		$logicalTTL = null; // logical TTL override
		// Check if there's a risk of writing stale data after the purge tombstone expired
		if ( $lag === false || ( $lag + $age ) > self::MAX_READ_LAG ) {
			// Case A: any long-running transaction
			if ( $age > self::MAX_READ_LAG ) {
				if ( $lockTSE >= 0 ) {
					// Store value as *almost* stale to avoid cache and mutex stampedes
					$logicalTTL = self::TTL_SECOND;
					$this->logger->info(
						'Lowered set() TTL for {cachekey} due to snapshot lag.',
						[ 'cachekey' => $key, 'lag' => $lag, 'age' => $age ]
					);
				} else {
					$this->logger->info(
						'Rejected set() for {cachekey} due to snapshot lag.',
						[ 'cachekey' => $key, 'lag' => $lag, 'age' => $age ]
					);

					return true; // no-op the write for being unsafe
				}
			// Case B: high replication lag; lower TTL instead of ignoring all set()s
			} elseif ( $lag === false || $lag > self::MAX_READ_LAG ) {
				if ( $lockTSE >= 0 ) {
					$logicalTTL = min( $ttl ?: INF, self::TTL_LAGGED );
				} else {
					$ttl = min( $ttl ?: INF, self::TTL_LAGGED );
				}
				$this->logger->warning(
					'Lowered set() TTL for {cachekey} due to replication lag.',
					[ 'cachekey' => $key, 'lag' => $lag, 'age' => $age ]
				);
			// Case C: medium length request with medium replication lag
			} elseif ( $lockTSE >= 0 ) {
				// Store value as *almost* stale to avoid cache and mutex stampedes
				$logicalTTL = self::TTL_SECOND;
				$this->logger->info(
					'Lowered set() TTL for {cachekey} due to high read lag.',
					[ 'cachekey' => $key, 'lag' => $lag, 'age' => $age ]
				);
			} else {
				$this->logger->info(
					'Rejected set() for {cachekey} due to high read lag.',
					[ 'cachekey' => $key, 'lag' => $lag, 'age' => $age ]
				);

				return true; // no-op the write for being unsafe
			}
		}

		// Wrap that value with time/TTL/version metadata
		$wrapped = $this->wrap( $value, $logicalTTL ?: $ttl, $now );
		$storeTTL = $ttl + $staleTTL;

		if ( $creating ) {
			$ok = $this->cache->add( self::VALUE_KEY_PREFIX . $key, $wrapped, $storeTTL );
		} else {
			$ok = $this->cache->merge(
				self::VALUE_KEY_PREFIX . $key,
				function ( $cache, $key, $cWrapped ) use ( $wrapped ) {
					// A string value means that it is a tombstone; do nothing in that case
					return ( is_string( $cWrapped ) ) ? false : $wrapped;
				},
				$storeTTL,
				1 // 1 attempt
			);
		}

		return $ok;
	}

	/**
	 * Purge a key from all datacenters
	 *
	 * This should only be called when the underlying data (being cached)
	 * changes in a significant way. This deletes the key and starts a hold-off
	 * period where the key cannot be written to for a few seconds (HOLDOFF_TTL).
	 * This is done to avoid the following race condition:
	 *   - a) Some DB data changes and delete() is called on a corresponding key
	 *   - b) A request refills the key with a stale value from a lagged DB
	 *   - c) The stale value is stuck there until the key is expired/evicted
	 *
	 * This is implemented by storing a special "tombstone" value at the cache
	 * key that this class recognizes; get() calls will return false for the key
	 * and any set() calls will refuse to replace tombstone values at the key.
	 * For this to always avoid stale value writes, the following must hold:
	 *   - a) Replication lag is bounded to being less than HOLDOFF_TTL; or
	 *   - b) If lag is higher, the DB will have gone into read-only mode already
	 *
	 * Note that set() can also be lag-aware and lower the TTL if it's high.
	 *
	 * Be aware that this does not clear the process cache. Even if it did, callbacks
	 * used by getWithSetCallback() might still return stale data in the case of either
	 * uncommitted or not-yet-replicated changes (callback generally use replica DBs).
	 *
	 * When using potentially long-running ACID transactions, a good pattern is
	 * to use a pre-commit hook to issue the delete. This means that immediately
	 * after commit, callers will see the tombstone in cache upon purge relay.
	 * It also avoids the following race condition:
	 *   - a) T1 begins, changes a row, and calls delete()
	 *   - b) The HOLDOFF_TTL passes, expiring the delete() tombstone
	 *   - c) T2 starts, reads the row and calls set() due to a cache miss
	 *   - d) T1 finally commits
	 *   - e) Stale value is stuck in cache
	 *
	 * Example usage:
	 * @code
	 *     $dbw->startAtomic( __METHOD__ ); // start of request
	 *     ... <execute some stuff> ...
	 *     // Update the row in the DB
	 *     $dbw->update( ... );
	 *     $key = $cache->makeKey( 'homes', $homeId );
	 *     // Purge the corresponding cache entry just before committing
	 *     $dbw->onTransactionPreCommitOrIdle( function() use ( $cache, $key ) {
	 *         $cache->delete( $key );
	 *     } );
	 *     ... <execute some stuff> ...
	 *     $dbw->endAtomic( __METHOD__ ); // end of request
	 * @endcode
	 *
	 * The $ttl parameter can be used when purging values that have not actually changed
	 * recently. For example, a cleanup script to purge cache entries does not really need
	 * a hold-off period, so it can use HOLDOFF_NONE. Likewise for user-requested purge.
	 * Note that $ttl limits the effective range of 'lockTSE' for getWithSetCallback().
	 *
	 * If called twice on the same key, then the last hold-off TTL takes precedence. For
	 * idempotence, the $ttl should not vary for different delete() calls on the same key.
	 *
	 * @param string $key Cache key
	 * @param int $ttl Tombstone TTL; Default: WANObjectCache::HOLDOFF_TTL
	 * @return bool True if the item was purged or not found, false on failure
	 */
	final public function delete( $key, $ttl = self::HOLDOFF_TTL ) {
		if ( $ttl <= 0 ) {
			// Publish the purge to all datacenters
			$ok = $this->relayDelete( self::VALUE_KEY_PREFIX . $key );
		} else {
			// Publish the purge to all datacenters
			$ok = $this->relayPurge( self::VALUE_KEY_PREFIX . $key, $ttl, self::HOLDOFF_NONE );
		}

		$kClass = $this->determineKeyClassForStats( $key );
		$this->stats->increment( "wanobjectcache.$kClass.delete." . ( $ok ? 'ok' : 'error' ) );

		return $ok;
	}

	/**
	 * Fetch the value of a timestamp "check" key
	 *
	 * The key will be *initialized* to the current time if not set,
	 * so only call this method if this behavior is actually desired
	 *
	 * The timestamp can be used to check whether a cached value is valid.
	 * Callers should not assume that this returns the same timestamp in
	 * all datacenters due to relay delays.
	 *
	 * The level of staleness can roughly be estimated from this key, but
	 * if the key was evicted from cache, such calculations may show the
	 * time since expiry as ~0 seconds.
	 *
	 * Note that "check" keys won't collide with other regular keys.
	 *
	 * @param string $key
	 * @return float UNIX timestamp
	 */
	final public function getCheckKeyTime( $key ) {
		return $this->getMultiCheckKeyTime( [ $key ] )[$key];
	}

	/**
	 * Fetch the values of each timestamp "check" key
	 *
	 * This works like getCheckKeyTime() except it takes a list of keys
	 * and returns a map of timestamps instead of just that of one key
	 *
	 * This might be useful if both:
	 *   - a) a class of entities each depend on hundreds of other entities
	 *   - b) these other entities are depended upon by millions of entities
	 *
	 * The later entities can each use a "check" key to invalidate their dependee entities.
	 * However, it is expensive for the former entities to verify against all of the relevant
	 * "check" keys during each getWithSetCallback() call. A less expensive approach is to do
	 * these verifications only after a "time-till-verify" (TTV) has passed. This is a middle
	 * ground between using blind TTLs and using constant verification. The adaptiveTTL() method
	 * can be used to dynamically adjust the TTV. Also, the initial TTV can make use of the
	 * last-modified times of the dependant entities (either from the DB or the "check" keys).
	 *
	 * Example usage:
	 * @code
	 *     $value = $cache->getWithSetCallback(
	 *         $cache->makeGlobalKey( 'wikibase-item', $id ),
	 *         self::INITIAL_TTV, // initial time-till-verify
	 *         function ( $oldValue, &$ttv, &$setOpts, $oldAsOf ) use ( $checkKeys, $cache ) {
	 *             $now = microtime( true );
	 *             // Use $oldValue if it passes max ultimate age and "check" key comparisons
	 *             if ( $oldValue &&
	 *                 $oldAsOf > max( $cache->getMultiCheckKeyTime( $checkKeys ) ) &&
	 *                 ( $now - $oldValue['ctime'] ) <= self::MAX_CACHE_AGE
	 *             ) {
	 *                 // Increase time-till-verify by 50% of last time to reduce overhead
	 *                 $ttv = $cache->adaptiveTTL( $oldAsOf, self::MAX_TTV, self::MIN_TTV, 1.5 );
	 *                 // Unlike $oldAsOf, "ctime" is the ultimate age of the cached data
	 *                 return $oldValue;
	 *             }
	 *
	 *             $mtimes = []; // dependency last-modified times; passed by reference
	 *             $value = [ 'data' => $this->fetchEntityData( $mtimes ), 'ctime' => $now ];
	 *             // Guess time-till-change among the dependencies, e.g. 1/(total change rate)
	 *             $ttc = 1 / array_sum( array_map(
	 *                 function ( $mtime ) use ( $now ) {
	 *                     return 1 / ( $mtime ? ( $now - $mtime ) : 900 );
	 *                 },
	 *                 $mtimes
	 *             ) );
	 *             // The time-to-verify should not be overly pessimistic nor optimistic
	 *             $ttv = min( max( $ttc, self::MIN_TTV ), self::MAX_TTV );
	 *
	 *             return $value;
	 *         },
	 *         [ 'staleTTL' => $cache::TTL_DAY ] // keep around to verify and re-save
	 *     );
	 * @endcode
	 *
	 * @see WANObjectCache::getCheckKeyTime()
	 * @see WANObjectCache::getWithSetCallback()
	 *
	 * @param array $keys
	 * @return float[] Map of (key => UNIX timestamp)
	 * @since 1.31
	 */
	final public function getMultiCheckKeyTime( array $keys ) {
		$rawKeys = [];
		foreach ( $keys as $key ) {
			$rawKeys[$key] = self::TIME_KEY_PREFIX . $key;
		}

		$rawValues = $this->cache->getMulti( $rawKeys );
		$rawValues += array_fill_keys( $rawKeys, false );

		$times = [];
		foreach ( $rawKeys as $key => $rawKey ) {
			$purge = $this->parsePurgeValue( $rawValues[$rawKey] );
			if ( $purge !== false ) {
				$time = $purge[self::FLD_TIME];
			} else {
				// Casting assures identical floats for the next getCheckKeyTime() calls
				$now = (string)$this->getCurrentTime();
				$this->cache->add(
					$rawKey,
					$this->makePurgeValue( $now, self::HOLDOFF_TTL ),
					self::CHECK_KEY_TTL
				);
				$time = (float)$now;
			}

			$times[$key] = $time;
		}

		return $times;
	}

	/**
	 * Purge a "check" key from all datacenters, invalidating keys that use it
	 *
	 * This should only be called when the underlying data (being cached)
	 * changes in a significant way, and it is impractical to call delete()
	 * on all keys that should be changed. When get() is called on those
	 * keys, the relevant "check" keys must be supplied for this to work.
	 *
	 * The "check" key essentially represents a last-modified time of an entity.
	 * When the key is touched, the timestamp will be updated to the current time.
	 * Keys using the "check" key via get(), getMulti(), or getWithSetCallback() will
	 * be invalidated. This approach is useful if many keys depend on a single entity.
	 *
	 * The timestamp of the "check" key is treated as being HOLDOFF_TTL seconds in the
	 * future by get*() methods in order to avoid race conditions where keys are updated
	 * with stale values (e.g. from a lagged replica DB). A high TTL is set on the "check"
	 * key, making it possible to know the timestamp of the last change to the corresponding
	 * entities in most cases. This might use more cache space than resetCheckKey().
	 *
	 * When a few important keys get a large number of hits, a high cache time is usually
	 * desired as well as "lockTSE" logic. The resetCheckKey() method is less appropriate
	 * in such cases since the "time since expiry" cannot be inferred, causing any get()
	 * after the reset to treat the key as being "hot", resulting in more stale value usage.
	 *
	 * Note that "check" keys won't collide with other regular keys.
	 *
	 * @see WANObjectCache::get()
	 * @see WANObjectCache::getWithSetCallback()
	 * @see WANObjectCache::resetCheckKey()
	 *
	 * @param string $key Cache key
	 * @param int $holdoff HOLDOFF_TTL or HOLDOFF_NONE constant
	 * @return bool True if the item was purged or not found, false on failure
	 */
	final public function touchCheckKey( $key, $holdoff = self::HOLDOFF_TTL ) {
		// Publish the purge to all datacenters
		$ok = $this->relayPurge( self::TIME_KEY_PREFIX . $key, self::CHECK_KEY_TTL, $holdoff );

		$kClass = $this->determineKeyClassForStats( $key );
		$this->stats->increment( "wanobjectcache.$kClass.ck_touch." . ( $ok ? 'ok' : 'error' ) );

		return $ok;
	}

	/**
	 * Delete a "check" key from all datacenters, invalidating keys that use it
	 *
	 * This is similar to touchCheckKey() in that keys using it via get(), getMulti(),
	 * or getWithSetCallback() will be invalidated. The differences are:
	 *   - a) The "check" key will be deleted from all caches and lazily
	 *        re-initialized when accessed (rather than set everywhere)
	 *   - b) Thus, dependent keys will be known to be stale, but not
	 *        for how long (they are treated as "just" purged), which
	 *        effects any lockTSE logic in getWithSetCallback()
	 *   - c) Since "check" keys are initialized only on the server the key hashes
	 *        to, any temporary ejection of that server will cause the value to be
	 *        seen as purged as a new server will initialize the "check" key.
	 *
	 * The advantage here is that the "check" keys, which have high TTLs, will only
	 * be created when a get*() method actually uses that key. This is better when
	 * a large number of "check" keys are invalided in a short period of time.
	 *
	 * Note that "check" keys won't collide with other regular keys.
	 *
	 * @see WANObjectCache::get()
	 * @see WANObjectCache::getWithSetCallback()
	 * @see WANObjectCache::touchCheckKey()
	 *
	 * @param string $key Cache key
	 * @return bool True if the item was purged or not found, false on failure
	 */
	final public function resetCheckKey( $key ) {
		// Publish the purge to all datacenters
		$ok = $this->relayDelete( self::TIME_KEY_PREFIX . $key );

		$kClass = $this->determineKeyClassForStats( $key );
		$this->stats->increment( "wanobjectcache.$kClass.ck_reset." . ( $ok ? 'ok' : 'error' ) );

		return $ok;
	}

	/**
	 * Method to fetch/regenerate cache keys
	 *
	 * On cache miss, the key will be set to the callback result via set()
	 * (unless the callback returns false) and that result will be returned.
	 * The arguments supplied to the callback are:
	 *   - $oldValue : current cache value or false if not present
	 *   - &$ttl : a reference to the TTL which can be altered
	 *   - &$setOpts : a reference to options for set() which can be altered
	 *   - $oldAsOf : generation UNIX timestamp of $oldValue or null if not present (since 1.28)
	 *
	 * It is strongly recommended to set the 'lag' and 'since' fields to avoid race conditions
	 * that can cause stale values to get stuck at keys. Usually, callbacks ignore the current
	 * value, but it can be used to maintain "most recent X" values that come from time or
	 * sequence based source data, provided that the "as of" id/time is tracked. Note that
	 * preemptive regeneration and $checkKeys can result in a non-false current value.
	 *
	 * Usage of $checkKeys is similar to get() and getMulti(). However, rather than the caller
	 * having to inspect a "current time left" variable (e.g. $curTTL, $curTTLs), a cache
	 * regeneration will automatically be triggered using the callback.
	 *
	 * The $ttl argument and "hotTTR" option (in $opts) use time-dependant randomization
	 * to avoid stampedes. Keys that are slow to regenerate and either heavily used
	 * or subject to explicit (unpredictable) purges, may need additional mechanisms.
	 * The simplest way to avoid stampedes for such keys is to use 'lockTSE' (in $opts).
	 * If explicit purges are needed, also:
	 *   - a) Pass $key into $checkKeys
	 *   - b) Use touchCheckKey( $key ) instead of delete( $key )
	 *
	 * Example usage (typical key):
	 * @code
	 *     $catInfo = $cache->getWithSetCallback(
	 *         // Key to store the cached value under
	 *         $cache->makeKey( 'cat-attributes', $catId ),
	 *         // Time-to-live (in seconds)
	 *         $cache::TTL_MINUTE,
	 *         // Function that derives the new key value
	 *         function ( $oldValue, &$ttl, array &$setOpts ) {
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             return $dbr->selectRow( ... );
	 *        }
	 *     );
	 * @endcode
	 *
	 * Example usage (key that is expensive and hot):
	 * @code
	 *     $catConfig = $cache->getWithSetCallback(
	 *         // Key to store the cached value under
	 *         $cache->makeKey( 'site-cat-config' ),
	 *         // Time-to-live (in seconds)
	 *         $cache::TTL_DAY,
	 *         // Function that derives the new key value
	 *         function ( $oldValue, &$ttl, array &$setOpts ) {
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             return CatConfig::newFromRow( $dbr->selectRow( ... ) );
	 *         },
	 *         [
	 *             // Calling touchCheckKey() on this key invalidates the cache
	 *             'checkKeys' => [ $cache->makeKey( 'site-cat-config' ) ],
	 *             // Try to only let one datacenter thread manage cache updates at a time
	 *             'lockTSE' => 30,
	 *             // Avoid querying cache servers multiple times in a web request
	 *             'pcTTL' => $cache::TTL_PROC_LONG
	 *         ]
	 *     );
	 * @endcode
	 *
	 * Example usage (key with dynamic dependencies):
	 * @code
	 *     $catState = $cache->getWithSetCallback(
	 *         // Key to store the cached value under
	 *         $cache->makeKey( 'cat-state', $cat->getId() ),
	 *         // Time-to-live (seconds)
	 *         $cache::TTL_HOUR,
	 *         // Function that derives the new key value
	 *         function ( $oldValue, &$ttl, array &$setOpts ) {
	 *             // Determine new value from the DB
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             return CatState::newFromResults( $dbr->select( ... ) );
	 *         },
	 *         [
	 *              // The "check" keys that represent things the value depends on;
	 *              // Calling touchCheckKey() on any of them invalidates the cache
	 *             'checkKeys' => [
	 *                 $cache->makeKey( 'sustenance-bowls', $cat->getRoomId() ),
	 *                 $cache->makeKey( 'people-present', $cat->getHouseId() ),
	 *                 $cache->makeKey( 'cat-laws', $cat->getCityId() ),
	 *             ]
	 *         ]
	 *     );
	 * @endcode
	 *
	 * Example usage (key that is expensive with too many DB dependencies for "check keys"):
	 * @code
	 *     $catToys = $cache->getWithSetCallback(
	 *         // Key to store the cached value under
	 *         $cache->makeKey( 'cat-toys', $catId ),
	 *         // Time-to-live (seconds)
	 *         $cache::TTL_HOUR,
	 *         // Function that derives the new key value
	 *         function ( $oldValue, &$ttl, array &$setOpts ) {
	 *             // Determine new value from the DB
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             return CatToys::newFromResults( $dbr->select( ... ) );
	 *         },
	 *         [
	 *              // Get the highest timestamp of any of the cat's toys
	 *             'touchedCallback' => function ( $value ) use ( $catId ) {
	 *                 $dbr = wfGetDB( DB_REPLICA );
	 *                 $ts = $dbr->selectField( 'cat_toys', 'MAX(ct_touched)', ... );
	 *
	 *                 return wfTimestampOrNull( TS_UNIX, $ts );
	 *             },
	 *             // Avoid DB queries for repeated access
	 *             'pcTTL' => $cache::TTL_PROC_SHORT
	 *         ]
	 *     );
	 * @endcode
	 *
	 * Example usage (hot key holding most recent 100 events):
	 * @code
	 *     $lastCatActions = $cache->getWithSetCallback(
	 *         // Key to store the cached value under
	 *         $cache->makeKey( 'cat-last-actions', 100 ),
	 *         // Time-to-live (in seconds)
	 *         10,
	 *         // Function that derives the new key value
	 *         function ( $oldValue, &$ttl, array &$setOpts ) {
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             // Start off with the last cached list
	 *             $list = $oldValue ?: [];
	 *             // Fetch the last 100 relevant rows in descending order;
	 *             // only fetch rows newer than $list[0] to reduce scanning
	 *             $rows = iterator_to_array( $dbr->select( ... ) );
	 *             // Merge them and get the new "last 100" rows
	 *             return array_slice( array_merge( $new, $list ), 0, 100 );
	 *        },
	 *        [
	 *             // Try to only let one datacenter thread manage cache updates at a time
	 *             'lockTSE' => 30,
	 *             // Use a magic value when no cache value is ready rather than stampeding
	 *             'busyValue' => 'computing'
	 *        ]
	 *     );
	 * @endcode
	 *
	 * Example usage (key holding an LRU subkey:value map; this can avoid flooding cache with
	 * keys for an unlimited set of (constraint,situation) pairs, thereby avoiding elevated
	 * cache evictions and wasted memory):
	 * @code
	 *     $catSituationTolerabilityCache = $this->cache->getWithSetCallback(
	 *         // Group by constraint ID/hash, cat family ID/hash, or something else useful
	 *         $this->cache->makeKey( 'cat-situation-tolerability-checks', $groupKey ),
	 *         WANObjectCache::TTL_DAY, // rarely used groups should fade away
	 *         // The $scenarioKey format is $constraintId:<ID/hash of $situation>
	 *         function ( $cacheMap ) use ( $scenarioKey, $constraintId, $situation ) {
	 *             $lruCache = MapCacheLRU::newFromArray( $cacheMap ?: [], self::CACHE_SIZE );
	 *             $result = $lruCache->get( $scenarioKey ); // triggers LRU bump if present
	 *             if ( $result === null || $this->isScenarioResultExpired( $result ) ) {
	 *                 $result = $this->checkScenarioTolerability( $constraintId, $situation );
	 *                 $lruCache->set( $scenarioKey, $result, 3 / 8 );
	 *             }
	 *             // Save the new LRU cache map and reset the map's TTL
	 *             return $lruCache->toArray();
	 *         },
	 *         [
	 *             // Once map is > 1 sec old, consider refreshing
	 *             'ageNew' => 1,
	 *             // Update within 5 seconds after "ageNew" given a 1hz cache check rate
	 *             'hotTTR' => 5,
	 *             // Avoid querying cache servers multiple times in a request; this also means
	 *             // that a request can only alter the value of any given constraint key once
	 *             'pcTTL' => WANObjectCache::TTL_PROC_LONG
	 *         ]
	 *     );
	 *     $tolerability = isset( $catSituationTolerabilityCache[$scenarioKey] )
	 *         ? $catSituationTolerabilityCache[$scenarioKey]
	 *         : $this->checkScenarioTolerability( $constraintId, $situation );
	 * @endcode
	 *
	 * @see WANObjectCache::get()
	 * @see WANObjectCache::set()
	 *
	 * @param string $key Cache key made from makeKey() or makeGlobalKey()
	 * @param int $ttl Seconds to live for key updates. Special values are:
	 *   - WANObjectCache::TTL_INDEFINITE: Cache forever (subject to LRU-style evictions)
	 *   - WANObjectCache::TTL_UNCACHEABLE: Do not cache (if the key exists, it is not deleted)
	 * @param callable $callback Value generation function
	 * @param array $opts Options map:
	 *   - checkKeys: List of "check" keys. The key at $key will be seen as stale when either
	 *      touchCheckKey() or resetCheckKey() is called on any of the keys in this list. This
	 *      is useful if thousands or millions of keys depend on the same entity. The entity can
	 *      simply have its "check" key updated whenever the entity is modified.
	 *      Default: [].
	 *   - graceTTL: If the key is invalidated (by "checkKeys"/"touchedCallback") less than this
	 *      many seconds ago, consider reusing the stale value. The odds of a refresh becomes
	 *      more likely over time, becoming certain once the grace period is reached. This can
	 *      reduce traffic spikes when millions of keys are compared to the same "check" key and
	 *      touchCheckKey() or resetCheckKey() is called on that "check" key. This option is not
	 *      useful for avoiding traffic spikes in the case of the key simply expiring on account
	 *      of its TTL (use "lowTTL" instead).
	 *      Default: WANObjectCache::GRACE_TTL_NONE.
	 *   - lockTSE: If the key is tombstoned or invalidated (by "checkKeys"/"touchedCallback")
	 *      less than this many seconds ago, try to have a single thread handle cache regeneration
	 *      at any given time. Other threads will use stale values if possible. If, on miss,
	 *      the time since expiration is low, the assumption is that the key is hot and that a
	 *      stampede is worth avoiding. Note that if the key falls out of cache then concurrent
	 *      threads will all run the callback on cache miss until the value is saved in cache.
	 *      The only stampede protection in that case is from duplicate cache sets when the
	 *      callback takes longer than WANObjectCache::SET_DELAY_HIGH_MS milliseconds; consider
	 *      using "busyValue" if such stampedes are a problem. Note that the higher "lockTSE" is
	 *      set, the higher the worst-case staleness of returned values can be. Also note that
	 *      this option does not by itself handle the case of the key simply expiring on account
	 *      of its TTL, so make sure that "lowTTL" is not disabled when using this option. Avoid
	 *      combining this option with delete() as it can always cause a stampede due to their
	 *      being no stale value available until after a thread completes the callback.
	 *      Use WANObjectCache::TSE_NONE to disable this logic.
	 *      Default: WANObjectCache::TSE_NONE.
	 *   - busyValue: If no value exists and another thread is currently regenerating it, use this
	 *      as a fallback value (or a callback to generate such a value). This assures that cache
	 *      stampedes cannot happen if the value falls out of cache. This can be used as insurance
	 *      against cache regeneration becoming very slow for some reason (greater than the TTL).
	 *      Default: null.
	 *   - pcTTL: Process cache the value in this PHP instance for this many seconds. This avoids
	 *      network I/O when a key is read several times. This will not cache when the callback
	 *      returns false, however. Note that any purges will not be seen while process cached;
	 *      since the callback should use replica DBs and they may be lagged or have snapshot
	 *      isolation anyway, this should not typically matter.
	 *      Default: WANObjectCache::TTL_UNCACHEABLE.
	 *   - pcGroup: Process cache group to use instead of the primary one. If set, this must be
	 *      of the format ALPHANUMERIC_NAME:MAX_KEY_SIZE, e.g. "mydata:10". Use this for storing
	 *      large values, small yet numerous values, or some values with a high cost of eviction.
	 *      It is generally preferable to use a class constant when setting this value.
	 *      This has no effect unless pcTTL is used.
	 *      Default: WANObjectCache::PC_PRIMARY.
	 *   - version: Integer version number. This lets callers make breaking changes to the format
	 *      of cached values without causing problems for sites that use non-instantaneous code
	 *      deployments. Old and new code will recognize incompatible versions and purges from
	 *      both old and new code will been seen by each other. When this method encounters an
	 *      incompatibly versioned value at the provided key, a "variant key" will be used for
	 *      reading from and saving to cache. The variant key is specific to the key and version
	 *      number provided to this method. If the variant key value is older than that of the
	 *      provided key, or the provided key is non-existant, then the variant key will be seen
	 *      as non-existant. Therefore, delete() calls invalidate the provided key's variant keys.
	 *      The "checkKeys" and "touchedCallback" options still apply to variant keys as usual.
	 *      Avoid storing class objects, as this reduces compatibility (due to serialization).
	 *      Default: null.
	 *   - minAsOf: Reject values if they were generated before this UNIX timestamp.
	 *      This is useful if the source of a key is suspected of having possibly changed
	 *      recently, and the caller wants any such changes to be reflected.
	 *      Default: WANObjectCache::MIN_TIMESTAMP_NONE.
	 *   - hotTTR: Expected time-till-refresh (TTR) in seconds for keys that average ~1 hit per
	 *      second (e.g. 1Hz). Keys with a hit rate higher than 1Hz will refresh sooner than this
	 *      TTR and vise versa. Such refreshes won't happen until keys are "ageNew" seconds old.
	 *      This uses randomization to avoid triggering cache stampedes. The TTR is useful at
	 *      reducing the impact of missed cache purges, since the effect of a heavily referenced
	 *      key being stale is worse than that of a rarely referenced key. Unlike simply lowering
	 *      $ttl, seldomly used keys are largely unaffected by this option, which makes it
	 *      possible to have a high hit rate for the "long-tail" of less-used keys.
	 *      Default: WANObjectCache::HOT_TTR.
	 *   - lowTTL: Consider pre-emptive updates when the current TTL (seconds) of the key is less
	 *      than this. It becomes more likely over time, becoming certain once the key is expired.
	 *      This helps avoid cache stampedes that might be triggered due to the key expiring.
	 *      Default: WANObjectCache::LOW_TTL.
	 *   - ageNew: Consider popularity refreshes only once a key reaches this age in seconds.
	 *      Default: WANObjectCache::AGE_NEW.
	 *   - staleTTL: Seconds to keep the key around if it is stale. This means that on cache
	 *      miss the callback may get $oldValue/$oldAsOf values for keys that have already been
	 *      expired for this specified time. This is useful if adaptiveTTL() is used on the old
	 *      value's as-of time when it is verified as still being correct.
	 *      Default: WANObjectCache::STALE_TTL_NONE
	 *   - touchedCallback: A callback that takes the current value and returns a UNIX timestamp
	 *      indicating the last time a dynamic dependency changed. Null can be returned if there
	 *      are no relevant dependency changes to check. This can be used to check against things
	 *      like last-modified times of files or DB timestamp fields. This should generally not be
	 *      used for small and easily queried values in a DB if the callback itself ends up doing
	 *      a similarly expensive DB query to check a timestamp. Usages of this option makes the
	 *      most sense for values that are moderately to highly expensive to regenerate and easy
	 *      to query for dependency timestamps. The use of "pcTTL" reduces timestamp queries.
	 *      Default: null.
	 * @return mixed Value found or written to the key
	 * @note Options added in 1.28: version, busyValue, hotTTR, ageNew, pcGroup, minAsOf
	 * @note Options added in 1.31: staleTTL, graceTTL
	 * @note Options added in 1.33: touchedCallback
	 * @note Callable type hints are not used to avoid class-autoloading
	 */
	final public function getWithSetCallback( $key, $ttl, $callback, array $opts = [] ) {
		$pcTTL = $opts['pcTTL'] ?? self::TTL_UNCACHEABLE;

		// Try the process cache if enabled and the cache callback is not within a cache callback.
		// Process cache use in nested callbacks is not lag-safe with regard to HOLDOFF_TTL since
		// the in-memory value is further lagged than the shared one since it uses a blind TTL.
		if ( $pcTTL >= 0 && $this->callbackDepth == 0 ) {
			$group = $opts['pcGroup'] ?? self::PC_PRIMARY;
			$procCache = $this->getProcessCache( $group );
			$value = $procCache->has( $key, $pcTTL ) ? $procCache->get( $key ) : false;
		} else {
			$procCache = false;
			$value = false;
		}

		if ( $value === false ) {
			// Fetch the value over the network
			if ( isset( $opts['version'] ) ) {
				$version = $opts['version'];
				$asOf = null;
				$cur = $this->doGetWithSetCallback(
					$key,
					$ttl,
					function ( $oldValue, &$ttl, &$setOpts, $oldAsOf )
					use ( $callback, $version ) {
						if ( is_array( $oldValue )
							&& array_key_exists( self::VFLD_DATA, $oldValue )
							&& array_key_exists( self::VFLD_VERSION, $oldValue )
							&& $oldValue[self::VFLD_VERSION] === $version
						) {
							$oldData = $oldValue[self::VFLD_DATA];
						} else {
							// VFLD_DATA is not set if an old, unversioned, key is present
							$oldData = false;
							$oldAsOf = null;
						}

						return [
							self::VFLD_DATA => $callback( $oldData, $ttl, $setOpts, $oldAsOf ),
							self::VFLD_VERSION => $version
						];
					},
					$opts,
					$asOf
				);
				if ( $cur[self::VFLD_VERSION] === $version ) {
					// Value created or existed before with version; use it
					$value = $cur[self::VFLD_DATA];
				} else {
					// Value existed before with a different version; use variant key.
					// Reflect purges to $key by requiring that this key value be newer.
					$value = $this->doGetWithSetCallback(
						$this->makeGlobalKey( 'WANCache-key-variant', md5( $key ), $version ),
						$ttl,
						$callback,
						// Regenerate value if not newer than $key
						[ 'version' => null, 'minAsOf' => $asOf ] + $opts
					);
				}
			} else {
				$value = $this->doGetWithSetCallback( $key, $ttl, $callback, $opts );
			}

			// Update the process cache if enabled
			if ( $procCache && $value !== false ) {
				$procCache->set( $key, $value );
			}
		}

		return $value;
	}

	/**
	 * Do the actual I/O for getWithSetCallback() when needed
	 *
	 * @see WANObjectCache::getWithSetCallback()
	 *
	 * @param string $key
	 * @param int $ttl
	 * @param callable $callback
	 * @param array $opts Options map for getWithSetCallback()
	 * @param float|null &$asOf Cache generation timestamp of returned value [returned]
	 * @return mixed
	 * @note Callable type hints are not used to avoid class-autoloading
	 */
	protected function doGetWithSetCallback( $key, $ttl, $callback, array $opts, &$asOf = null ) {
		$lowTTL = $opts['lowTTL'] ?? min( self::LOW_TTL, $ttl );
		$lockTSE = $opts['lockTSE'] ?? self::TSE_NONE;
		$staleTTL = $opts['staleTTL'] ?? self::STALE_TTL_NONE;
		$graceTTL = $opts['graceTTL'] ?? self::GRACE_TTL_NONE;
		$checkKeys = $opts['checkKeys'] ?? [];
		$busyValue = $opts['busyValue'] ?? null;
		$popWindow = $opts['hotTTR'] ?? self::HOT_TTR;
		$ageNew = $opts['ageNew'] ?? self::AGE_NEW;
		$minTime = $opts['minAsOf'] ?? self::MIN_TIMESTAMP_NONE;
		$needsVersion = isset( $opts['version'] );
		$touchedCb = $opts['touchedCallback'] ?? null;
		$initialTime = $this->getCurrentTime();

		$kClass = $this->determineKeyClassForStats( $key );

		// Get the current key value
		$curTTL = self::PASS_BY_REF;
		$curInfo = self::PASS_BY_REF; /** @var array $curInfo */
		$curValue = $this->get( $key, $curTTL, $checkKeys, $curInfo );
		// Apply any $touchedCb invalidation timestamp to get the "last purge timestamp"
		list( $curTTL, $LPT ) = $this->resolveCTL( $curValue, $curTTL, $curInfo, $touchedCb );
		// Keep track of the best candidate value and its timestamp
		$value = $curValue; // return value
		$asOf = $curInfo['asOf']; // return value timestamp

		// Determine if a cached value regeneration is needed or desired
		if (
			$this->isValid( $value, $needsVersion, $asOf, $minTime ) &&
			$this->isAliveOrInGracePeriod( $curTTL, $graceTTL )
		) {
			$preemptiveRefresh = (
				$this->worthRefreshExpiring( $curTTL, $lowTTL ) ||
				$this->worthRefreshPopular( $asOf, $ageNew, $popWindow, $initialTime )
			);

			if ( !$preemptiveRefresh ) {
				$this->stats->increment( "wanobjectcache.$kClass.hit.good" );

				return $value;
			} elseif ( $this->scheduleAsyncRefresh( $key, $ttl, $callback, $opts ) ) {
				$this->stats->increment( "wanobjectcache.$kClass.hit.refresh" );

				return $value;
			}
		}

		$isKeyTombstoned = ( $curInfo['tombAsOf'] !== null );
		if ( $isKeyTombstoned ) {
			// Get the interim key value since the key is tombstoned (write-holed)
			list( $value, $asOf ) = $this->getInterimValue( $key, $needsVersion, $minTime );
			// Update the "last purge time" since the $touchedCb timestamp depends on $value
			$LPT = $this->resolveTouched( $value, $LPT, $touchedCb );
		}

		// Reduce mutex and cache set spam while keys are in the tombstone/holdoff period by
		// checking if $value was genereated by a recent thread much less than a second ago.
		if (
			$this->isValid( $value, $needsVersion, $asOf, $minTime, $LPT ) &&
			$this->isVolatileValueAgeNegligible( $initialTime - $asOf )
		) {
			$this->stats->increment( "wanobjectcache.$kClass.hit.volatile" );

			return $value;
		}

		// Decide if only one thread should handle regeneration at a time
		$useMutex =
			// Note that since tombstones no-op set(), $lockTSE and $curTTL cannot be used to
			// deduce the key hotness because |$curTTL| will always keep increasing until the
			// tombstone expires or is overwritten by a new tombstone. Also, even if $lockTSE
			// is not set, constant regeneration of a key for the tombstone lifetime might be
			// very expensive. Assume tombstoned keys are possibly hot in order to reduce
			// the risk of high regeneration load after the delete() method is called.
			$isKeyTombstoned ||
			// Assume a key is hot if requested soon ($lockTSE seconds) after invalidation.
			// This avoids stampedes when timestamps from $checkKeys/$touchedCb bump.
			( $curTTL !== null && $curTTL <= 0 && abs( $curTTL ) <= $lockTSE ) ||
			// Assume a key is hot if there is no value and a busy fallback is given.
			// This avoids stampedes on eviction or preemptive regeneration taking too long.
			( $busyValue !== null && $value === false );

		$hasLock = false;
		if ( $useMutex ) {
			// Acquire a datacenter-local non-blocking lock
			if ( $this->cache->add( self::MUTEX_KEY_PREFIX . $key, 1, self::LOCK_TTL ) ) {
				// Lock acquired; this thread will recompute the value and update cache
				$hasLock = true;
			} elseif ( $this->isValid( $value, $needsVersion, $asOf, $minTime ) ) {
				// Lock not acquired and a stale value exists; use the stale value
				$this->stats->increment( "wanobjectcache.$kClass.hit.stale" );

				return $value;
			} else {
				// Lock not acquired and no stale value exists
				if ( $busyValue !== null ) {
					// Use the busy fallback value if nothing else
					$miss = is_infinite( $minTime ) ? 'renew' : 'miss';
					$this->stats->increment( "wanobjectcache.$kClass.$miss.busy" );

					return is_callable( $busyValue ) ? $busyValue() : $busyValue;
				}
			}
		}

		if ( !is_callable( $callback ) ) {
			throw new InvalidArgumentException( "Invalid cache miss callback provided." );
		}

		$preCallbackTime = $this->getCurrentTime();
		// Generate the new value from the callback...
		$setOpts = [];
		++$this->callbackDepth;
		try {
			$value = call_user_func_array( $callback, [ $curValue, &$ttl, &$setOpts, $asOf ] );
		} finally {
			--$this->callbackDepth;
		}
		$valueIsCacheable = ( $value !== false && $ttl >= 0 );

		if ( $valueIsCacheable ) {
			$ago = max( $this->getCurrentTime() - $initialTime, 0.0 );
			$this->stats->timing( "wanobjectcache.$kClass.regen_set_delay", 1000 * $ago );

			if ( $isKeyTombstoned ) {
				if ( $this->checkAndSetCooloff( $key, $kClass, $ago, $lockTSE, $hasLock ) ) {
					// Use the interim key value since the key is tombstoned (write-holed)
					$tempTTL = max( self::INTERIM_KEY_TTL, (int)$lockTSE );
					$this->setInterimValue( $key, $value, $tempTTL, $this->getCurrentTime() );
				}
			} elseif ( !$useMutex || $hasLock ) {
				if ( $this->checkAndSetCooloff( $key, $kClass, $ago, $lockTSE, $hasLock ) ) {
					$setOpts['creating'] = ( $curValue === false );
					// Save the value unless a lock-winning thread is already expected to do that
					$setOpts['lockTSE'] = $lockTSE;
					$setOpts['staleTTL'] = $staleTTL;
					// Use best known "since" timestamp if not provided
					$setOpts += [ 'since' => $preCallbackTime ];
					// Update the cache; this will fail if the key is tombstoned
					$this->set( $key, $value, $ttl, $setOpts );
				}
			}
		}

		if ( $hasLock ) {
			$this->cache->changeTTL( self::MUTEX_KEY_PREFIX . $key, (int)$initialTime - 60 );
		}

		$miss = is_infinite( $minTime ) ? 'renew' : 'miss';
		$this->stats->increment( "wanobjectcache.$kClass.$miss.compute" );

		return $value;
	}

	/**
	 * @param float $age Age of volatile/interim key in seconds
	 * @return bool Whether the age of a volatile value is negligible
	 */
	private function isVolatileValueAgeNegligible( $age ) {
		return ( $age < mt_rand( self::RECENT_SET_LOW_MS, self::RECENT_SET_HIGH_MS ) / 1e3 );
	}

	/**
	 * @param string $key
	 * @param string $kClass
	 * @param float $elapsed Seconds spent regenerating the value
	 * @param float $lockTSE
	 * @param $hasLock bool
	 * @return bool Whether it is OK to proceed with a key set operation
	 */
	private function checkAndSetCooloff( $key, $kClass, $elapsed, $lockTSE, $hasLock ) {
		// If $lockTSE is set, the lock was bypassed because there was no stale/interim value,
		// and $elapsed indicates that regeration is slow, then there is a risk of set()
		// stampedes with large blobs. With a typical scale-out infrastructure, CPU and query
		// load from $callback invocations is distributed among appservers and replica DBs,
		// but cache operations for a given key route to a single cache server (e.g. striped
		// consistent hashing).
		if ( $lockTSE < 0 || $hasLock ) {
			return true; // either not a priori hot or thread has the lock
		} elseif ( $elapsed <= self::SET_DELAY_HIGH_MS * 1e3 ) {
			return true; // not enough time for threads to pile up
		}

		$this->cache->clearLastError();
		if (
			!$this->cache->add( self::COOLOFF_KEY_PREFIX . $key, 1, self::COOLOFF_TTL ) &&
			// Don't treat failures due to I/O errors as the key being in cooloff
			$this->cache->getLastError() === BagOStuff::ERR_NONE
		) {
			$this->stats->increment( "wanobjectcache.$kClass.cooloff_bounce" );

			return false;
		}

		return true;
	}

	/**
	 * @param mixed $value
	 * @param float|null $curTTL
	 * @param array $curInfo
	 * @param callable|null $touchedCallback
	 * @return array (current time left or null, UNIX timestamp of last purge or null)
	 * @note Callable type hints are not used to avoid class-autoloading
	 */
	protected function resolveCTL( $value, $curTTL, $curInfo, $touchedCallback ) {
		if ( $touchedCallback === null || $value === false ) {
			return [ $curTTL, max( $curInfo['tombAsOf'], $curInfo['lastCKPurge'] ) ];
		}

		if ( !is_callable( $touchedCallback ) ) {
			throw new InvalidArgumentException( "Invalid expiration callback provided." );
		}

		$touched = $touchedCallback( $value );
		if ( $touched !== null && $touched >= $curInfo['asOf'] ) {
			$curTTL = min( $curTTL, self::TINY_NEGATIVE, $curInfo['asOf'] - $touched );
		}

		return [ $curTTL, max( $curInfo['tombAsOf'], $curInfo['lastCKPurge'], $touched ) ];
	}

	/**
	 * @param mixed $value
	 * @param float|null $lastPurge
	 * @param callable|null $touchedCallback
	 * @return float|null UNIX timestamp of last purge or null
	 * @note Callable type hints are not used to avoid class-autoloading
	 */
	protected function resolveTouched( $value, $lastPurge, $touchedCallback ) {
		if ( $touchedCallback === null || $value === false ) {
			return $lastPurge;
		}

		if ( !is_callable( $touchedCallback ) ) {
			throw new InvalidArgumentException( "Invalid expiration callback provided." );
		}

		return max( $touchedCallback( $value ), $lastPurge );
	}

	/**
	 * @param string $key
	 * @param bool $versioned
	 * @param float $minTime
	 * @return array (cached value or false, cached value timestamp or null)
	 */
	protected function getInterimValue( $key, $versioned, $minTime ) {
		if ( !$this->useInterimHoldOffCaching ) {
			return [ false, null ]; // disabled
		}

		$wrapped = $this->cache->get( self::INTERIM_KEY_PREFIX . $key );
		list( $value ) = $this->unwrap( $wrapped, $this->getCurrentTime() );
		$valueAsOf = $wrapped[self::FLD_TIME] ?? null;
		if ( $this->isValid( $value, $versioned, $valueAsOf, $minTime ) ) {
			return [ $value, $valueAsOf ];
		}

		return [ false, null ];
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param int $tempTTL
	 * @param float $newAsOf
	 */
	protected function setInterimValue( $key, $value, $tempTTL, $newAsOf ) {
		$wrapped = $this->wrap( $value, $tempTTL, $newAsOf );

		$this->cache->merge(
			self::INTERIM_KEY_PREFIX . $key,
			function () use ( $wrapped ) {
				return $wrapped;
			},
			$tempTTL,
			1
		);
	}

	/**
	 * Method to fetch multiple cache keys at once with regeneration
	 *
	 * This works the same as getWithSetCallback() except:
	 *   - a) The $keys argument expects the result of WANObjectCache::makeMultiKeys()
	 *   - b) The $callback argument expects a callback taking the following arguments:
	 *         - $id: ID of an entity to query
	 *         - $oldValue : the prior cache value or false if none was present
	 *         - &$ttl : a reference to the new value TTL in seconds
	 *         - &$setOpts : a reference to options for set() which can be altered
	 *         - $oldAsOf : generation UNIX timestamp of $oldValue or null if not present
	 *        Aside from the additional $id argument, the other arguments function the same
	 *        way they do in getWithSetCallback().
	 *   - c) The return value is a map of (cache key => value) in the order of $keyedIds
	 *
	 * @see WANObjectCache::getWithSetCallback()
	 * @see WANObjectCache::getMultiWithUnionSetCallback()
	 *
	 * Example usage:
	 * @code
	 *     $rows = $cache->getMultiWithSetCallback(
	 *         // Map of cache keys to entity IDs
	 *         $cache->makeMultiKeys(
	 *             $this->fileVersionIds(),
	 *             function ( $id, WANObjectCache $cache ) {
	 *                 return $cache->makeKey( 'file-version', $id );
	 *             }
	 *         ),
	 *         // Time-to-live (in seconds)
	 *         $cache::TTL_DAY,
	 *         // Function that derives the new key value
	 *         function ( $id, $oldValue, &$ttl, array &$setOpts ) {
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             // Load the row for this file
	 *             $queryInfo = File::getQueryInfo();
	 *             $row = $dbr->selectRow(
	 *                 $queryInfo['tables'],
	 *                 $queryInfo['fields'],
	 *                 [ 'id' => $id ],
	 *                 __METHOD__,
	 *                 [],
	 *                 $queryInfo['joins']
	 *             );
	 *
	 *             return $row ? (array)$row : false;
	 *         },
	 *         [
	 *             // Process cache for 30 seconds
	 *             'pcTTL' => 30,
	 *             // Use a dedicated 500 item cache (initialized on-the-fly)
	 *             'pcGroup' => 'file-versions:500'
	 *         ]
	 *     );
	 *     $files = array_map( [ __CLASS__, 'newFromRow' ], $rows );
	 * @endcode
	 *
	 * @param ArrayIterator $keyedIds Result of WANObjectCache::makeMultiKeys()
	 * @param int $ttl Seconds to live for key updates
	 * @param callable $callback Callback the yields entity regeneration callbacks
	 * @param array $opts Options map
	 * @return array Map of (cache key => value) in the same order as $keyedIds
	 * @since 1.28
	 */
	final public function getMultiWithSetCallback(
		ArrayIterator $keyedIds, $ttl, callable $callback, array $opts = []
	) {
		$valueKeys = array_keys( $keyedIds->getArrayCopy() );
		$checkKeys = $opts['checkKeys'] ?? [];
		$pcTTL = $opts['pcTTL'] ?? self::TTL_UNCACHEABLE;

		// Load required keys into process cache in one go
		$this->warmupCache = $this->getRawKeysForWarmup(
			$this->getNonProcessCachedKeys( $valueKeys, $opts, $pcTTL ),
			$checkKeys
		);
		$this->warmupKeyMisses = 0;

		// Wrap $callback to match the getWithSetCallback() format while passing $id to $callback
		$id = null; // current entity ID
		$func = function ( $oldValue, &$ttl, &$setOpts, $oldAsOf ) use ( $callback, &$id ) {
			return $callback( $id, $oldValue, $ttl, $setOpts, $oldAsOf );
		};

		$values = [];
		foreach ( $keyedIds as $key => $id ) { // preserve order
			$values[$key] = $this->getWithSetCallback( $key, $ttl, $func, $opts );
		}

		$this->warmupCache = [];

		return $values;
	}

	/**
	 * Method to fetch/regenerate multiple cache keys at once
	 *
	 * This works the same as getWithSetCallback() except:
	 *   - a) The $keys argument expects the result of WANObjectCache::makeMultiKeys()
	 *   - b) The $callback argument expects a callback returning a map of (ID => new value)
	 *        for all entity IDs in $ids and it takes the following arguments:
	 *          - $ids: a list of entity IDs that require cache regeneration
	 *          - &$ttls: a reference to the (entity ID => new TTL) map
	 *          - &$setOpts: a reference to options for set() which can be altered
	 *   - c) The return value is a map of (cache key => value) in the order of $keyedIds
	 *   - d) The "lockTSE" and "busyValue" options are ignored
	 *
	 * @see WANObjectCache::getWithSetCallback()
	 * @see WANObjectCache::getMultiWithSetCallback()
	 *
	 * Example usage:
	 * @code
	 *     $rows = $cache->getMultiWithUnionSetCallback(
	 *         // Map of cache keys to entity IDs
	 *         $cache->makeMultiKeys(
	 *             $this->fileVersionIds(),
	 *             function ( $id, WANObjectCache $cache ) {
	 *                 return $cache->makeKey( 'file-version', $id );
	 *             }
	 *         ),
	 *         // Time-to-live (in seconds)
	 *         $cache::TTL_DAY,
	 *         // Function that derives the new key value
	 *         function ( array $ids, array &$ttls, array &$setOpts ) {
	 *             $dbr = wfGetDB( DB_REPLICA );
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += Database::getCacheSetOptions( $dbr );
	 *
	 *             // Load the rows for these files
	 *             $rows = [];
	 *             $queryInfo = File::getQueryInfo();
	 *             $res = $dbr->select(
	 *                 $queryInfo['tables'],
	 *                 $queryInfo['fields'],
	 *                 [ 'id' => $ids ],
	 *                 __METHOD__,
	 *                 [],
	 *                 $queryInfo['joins']
	 *             );
	 *             foreach ( $res as $row ) {
	 *                 $rows[$row->id] = $row;
	 *                 $mtime = wfTimestamp( TS_UNIX, $row->timestamp );
	 *                 $ttls[$row->id] = $this->adaptiveTTL( $mtime, $ttls[$row->id] );
	 *             }
	 *
	 *             return $rows;
	 *         },
	 *         ]
	 *     );
	 *     $files = array_map( [ __CLASS__, 'newFromRow' ], $rows );
	 * @endcode
	 *
	 * @param ArrayIterator $keyedIds Result of WANObjectCache::makeMultiKeys()
	 * @param int $ttl Seconds to live for key updates
	 * @param callable $callback Callback the yields entity regeneration callbacks
	 * @param array $opts Options map
	 * @return array Map of (cache key => value) in the same order as $keyedIds
	 * @since 1.30
	 */
	final public function getMultiWithUnionSetCallback(
		ArrayIterator $keyedIds, $ttl, callable $callback, array $opts = []
	) {
		$idsByValueKey = $keyedIds->getArrayCopy();
		$valueKeys = array_keys( $idsByValueKey );
		$checkKeys = $opts['checkKeys'] ?? [];
		$pcTTL = $opts['pcTTL'] ?? self::TTL_UNCACHEABLE;
		unset( $opts['lockTSE'] ); // incompatible
		unset( $opts['busyValue'] ); // incompatible

		// Load required keys into process cache in one go
		$keysGet = $this->getNonProcessCachedKeys( $valueKeys, $opts, $pcTTL );
		$this->warmupCache = $this->getRawKeysForWarmup( $keysGet, $checkKeys );
		$this->warmupKeyMisses = 0;

		// IDs of entities known to be in need of regeneration
		$idsRegen = [];

		// Find out which keys are missing/deleted/stale
		$curTTLs = [];
		$asOfs = [];
		$curByKey = $this->getMulti( $keysGet, $curTTLs, $checkKeys, $asOfs );
		foreach ( $keysGet as $key ) {
			if ( !array_key_exists( $key, $curByKey ) || $curTTLs[$key] < 0 ) {
				$idsRegen[] = $idsByValueKey[$key];
			}
		}

		// Run the callback to populate the regeneration value map for all required IDs
		$newSetOpts = [];
		$newTTLsById = array_fill_keys( $idsRegen, $ttl );
		$newValsById = $idsRegen ? $callback( $idsRegen, $newTTLsById, $newSetOpts ) : [];

		// Wrap $callback to match the getWithSetCallback() format while passing $id to $callback
		$id = null; // current entity ID
		$func = function ( $oldValue, &$ttl, &$setOpts, $oldAsOf )
			use ( $callback, &$id, $newValsById, $newTTLsById, $newSetOpts )
		{
			if ( array_key_exists( $id, $newValsById ) ) {
				// Value was already regerated as expected, so use the value in $newValsById
				$newValue = $newValsById[$id];
				$ttl = $newTTLsById[$id];
				$setOpts = $newSetOpts;
			} else {
				// Pre-emptive/popularity refresh and version mismatch cases are not detected
				// above and thus $newValsById has no entry. Run $callback on this single entity.
				$ttls = [ $id => $ttl ];
				$newValue = $callback( [ $id ], $ttls, $setOpts )[$id];
				$ttl = $ttls[$id];
			}

			return $newValue;
		};

		// Run the cache-aside logic using warmupCache instead of persistent cache queries
		$values = [];
		foreach ( $idsByValueKey as $key => $id ) { // preserve order
			$values[$key] = $this->getWithSetCallback( $key, $ttl, $func, $opts );
		}

		$this->warmupCache = [];

		return $values;
	}

	/**
	 * Set a key to soon expire in the local cluster if it pre-dates $purgeTimestamp
	 *
	 * This sets stale keys' time-to-live at HOLDOFF_TTL seconds, which both avoids
	 * broadcasting in mcrouter setups and also avoids races with new tombstones.
	 *
	 * @param string $key Cache key
	 * @param int $purgeTimestamp UNIX timestamp of purge
	 * @param bool &$isStale Whether the key is stale
	 * @return bool Success
	 * @since 1.28
	 */
	final public function reap( $key, $purgeTimestamp, &$isStale = false ) {
		$minAsOf = $purgeTimestamp + self::HOLDOFF_TTL;
		$wrapped = $this->cache->get( self::VALUE_KEY_PREFIX . $key );
		if ( is_array( $wrapped ) && $wrapped[self::FLD_TIME] < $minAsOf ) {
			$isStale = true;
			$this->logger->warning( "Reaping stale value key '$key'." );
			$ttlReap = self::HOLDOFF_TTL; // avoids races with tombstone creation
			$ok = $this->cache->changeTTL( self::VALUE_KEY_PREFIX . $key, $ttlReap );
			if ( !$ok ) {
				$this->logger->error( "Could not complete reap of key '$key'." );
			}

			return $ok;
		}

		$isStale = false;

		return true;
	}

	/**
	 * Set a "check" key to soon expire in the local cluster if it pre-dates $purgeTimestamp
	 *
	 * @param string $key Cache key
	 * @param int $purgeTimestamp UNIX timestamp of purge
	 * @param bool &$isStale Whether the key is stale
	 * @return bool Success
	 * @since 1.28
	 */
	final public function reapCheckKey( $key, $purgeTimestamp, &$isStale = false ) {
		$purge = $this->parsePurgeValue( $this->cache->get( self::TIME_KEY_PREFIX . $key ) );
		if ( $purge && $purge[self::FLD_TIME] < $purgeTimestamp ) {
			$isStale = true;
			$this->logger->warning( "Reaping stale check key '$key'." );
			$ok = $this->cache->changeTTL( self::TIME_KEY_PREFIX . $key, self::TTL_SECOND );
			if ( !$ok ) {
				$this->logger->error( "Could not complete reap of check key '$key'." );
			}

			return $ok;
		}

		$isStale = false;

		return false;
	}

	/**
	 * @see BagOStuff::makeKey()
	 * @param string $class Key class
	 * @param string|null $component [optional] Key component (starting with a key collection name)
	 * @return string Colon-delimited list of $keyspace followed by escaped components of $args
	 * @since 1.27
	 */
	public function makeKey( $class, $component = null ) {
		return $this->cache->makeKey( ...func_get_args() );
	}

	/**
	 * @see BagOStuff::makeGlobalKey()
	 * @param string $class Key class
	 * @param string|null $component [optional] Key component (starting with a key collection name)
	 * @return string Colon-delimited list of $keyspace followed by escaped components of $args
	 * @since 1.27
	 */
	public function makeGlobalKey( $class, $component = null ) {
		return $this->cache->makeGlobalKey( ...func_get_args() );
	}

	/**
	 * @param array $entities List of entity IDs
	 * @param callable $keyFunc Callback yielding a key from (entity ID, this WANObjectCache)
	 * @return ArrayIterator Iterator yielding (cache key => entity ID) in $entities order
	 * @since 1.28
	 */
	final public function makeMultiKeys( array $entities, callable $keyFunc ) {
		$map = [];
		foreach ( $entities as $entity ) {
			$map[$keyFunc( $entity, $this )] = $entity;
		}

		return new ArrayIterator( $map );
	}

	/**
	 * Get the "last error" registered; clearLastError() should be called manually
	 * @return int ERR_* class constant for the "last error" registry
	 */
	final public function getLastError() {
		$code = $this->cache->getLastError();
		switch ( $code ) {
			case BagOStuff::ERR_NONE:
				return self::ERR_NONE;
			case BagOStuff::ERR_NO_RESPONSE:
				return self::ERR_NO_RESPONSE;
			case BagOStuff::ERR_UNREACHABLE:
				return self::ERR_UNREACHABLE;
			default:
				return self::ERR_UNEXPECTED;
		}
	}

	/**
	 * Clear the "last error" registry
	 */
	final public function clearLastError() {
		$this->cache->clearLastError();
	}

	/**
	 * Clear the in-process caches; useful for testing
	 *
	 * @since 1.27
	 */
	public function clearProcessCache() {
		$this->processCaches = [];
	}

	/**
	 * Enable or disable the use of brief caching for tombstoned keys
	 *
	 * When a key is purged via delete(), there normally is a period where caching
	 * is hold-off limited to an extremely short time. This method will disable that
	 * caching, forcing the callback to run for any of:
	 *   - WANObjectCache::getWithSetCallback()
	 *   - WANObjectCache::getMultiWithSetCallback()
	 *   - WANObjectCache::getMultiWithUnionSetCallback()
	 *
	 * This is useful when both:
	 *   - a) the database used by the callback is known to be up-to-date enough
	 *        for some particular purpose (e.g. replica DB has applied transaction X)
	 *   - b) the caller needs to exploit that fact, and therefore needs to avoid the
	 *        use of inherently volatile and possibly stale interim keys
	 *
	 * @see WANObjectCache::delete()
	 * @param bool $enabled Whether to enable interim caching
	 * @since 1.31
	 */
	final public function useInterimHoldOffCaching( $enabled ) {
		$this->useInterimHoldOffCaching = $enabled;
	}

	/**
	 * @param int $flag ATTR_* class constant
	 * @return int QOS_* class constant
	 * @since 1.28
	 */
	public function getQoS( $flag ) {
		return $this->cache->getQoS( $flag );
	}

	/**
	 * Get a TTL that is higher for objects that have not changed recently
	 *
	 * This is useful for keys that get explicit purges and DB or purge relay
	 * lag is a potential concern (especially how it interacts with CDN cache)
	 *
	 * Example usage:
	 * @code
	 *     // Last-modified time of page
	 *     $mtime = wfTimestamp( TS_UNIX, $page->getTimestamp() );
	 *     // Get adjusted TTL. If $mtime is 3600 seconds ago and $minTTL/$factor left at
	 *     // defaults, then $ttl is 3600 * .2 = 720. If $minTTL was greater than 720, then
	 *     // $ttl would be $minTTL. If $maxTTL was smaller than 720, $ttl would be $maxTTL.
	 *     $ttl = $cache->adaptiveTTL( $mtime, $cache::TTL_DAY );
	 * @endcode
	 *
	 * Another use case is when there are no applicable "last modified" fields in the DB,
	 * and there are too many dependencies for explicit purges to be viable, and the rate of
	 * change to relevant content is unstable, and it is highly valued to have the cached value
	 * be as up-to-date as possible.
	 *
	 * Example usage:
	 * @code
	 *     $query = "<some complex query>";
	 *     $idListFromComplexQuery = $cache->getWithSetCallback(
	 *         $cache->makeKey( 'complex-graph-query', $hashOfQuery ),
	 *         GraphQueryClass::STARTING_TTL,
	 *         function ( $oldValue, &$ttl, array &$setOpts, $oldAsOf ) use ( $query, $cache ) {
	 *             $gdb = $this->getReplicaGraphDbConnection();
	 *             // Account for any snapshot/replica DB lag
	 *             $setOpts += GraphDatabase::getCacheSetOptions( $gdb );
	 *
	 *             $newList = iterator_to_array( $gdb->query( $query ) );
	 *             sort( $newList, SORT_NUMERIC ); // normalize
	 *
	 *             $minTTL = GraphQueryClass::MIN_TTL;
	 *             $maxTTL = GraphQueryClass::MAX_TTL;
	 *             if ( $oldValue !== false ) {
	 *                 // Note that $oldAsOf is the last time this callback ran
	 *                 $ttl = ( $newList === $oldValue )
	 *                     // No change: cache for 150% of the age of $oldValue
	 *                     ? $cache->adaptiveTTL( $oldAsOf, $maxTTL, $minTTL, 1.5 )
	 *                     // Changed: cache for 50% of the age of $oldValue
	 *                     : $cache->adaptiveTTL( $oldAsOf, $maxTTL, $minTTL, .5 );
	 *             }
	 *
	 *             return $newList;
	 *        },
	 *        [
	 *             // Keep stale values around for doing comparisons for TTL calculations.
	 *             // High values improve long-tail keys hit-rates, though might waste space.
	 *             'staleTTL' => GraphQueryClass::GRACE_TTL
	 *        ]
	 *     );
	 * @endcode
	 *
	 * @param int|float $mtime UNIX timestamp
	 * @param int $maxTTL Maximum TTL (seconds)
	 * @param int $minTTL Minimum TTL (seconds); Default: 30
	 * @param float $factor Value in the range (0,1); Default: .2
	 * @return int Adaptive TTL
	 * @since 1.28
	 */
	public function adaptiveTTL( $mtime, $maxTTL, $minTTL = 30, $factor = 0.2 ) {
		if ( is_float( $mtime ) || ctype_digit( $mtime ) ) {
			$mtime = (int)$mtime; // handle fractional seconds and string integers
		}

		if ( !is_int( $mtime ) || $mtime <= 0 ) {
			return $minTTL; // no last-modified time provided
		}

		$age = $this->getCurrentTime() - $mtime;

		return (int)min( $maxTTL, max( $minTTL, $factor * $age ) );
	}

	/**
	 * @return int Number of warmup key cache misses last round
	 * @since 1.30
	 */
	final public function getWarmupKeyMisses() {
		return $this->warmupKeyMisses;
	}

	/**
	 * Do the actual async bus purge of a key
	 *
	 * This must set the key to "PURGED:<UNIX timestamp>:<holdoff>"
	 *
	 * @param string $key Cache key
	 * @param int $ttl How long to keep the tombstone [seconds]
	 * @param int $holdoff HOLDOFF_* constant controlling how long to ignore sets for this key
	 * @return bool Success
	 */
	protected function relayPurge( $key, $ttl, $holdoff ) {
		if ( $this->mcrouterAware ) {
			// See https://github.com/facebook/mcrouter/wiki/Multi-cluster-broadcast-setup
			// Wildcards select all matching routes, e.g. the WAN cluster on all DCs
			$ok = $this->cache->set(
				"/*/{$this->cluster}/{$key}",
				$this->makePurgeValue( $this->getCurrentTime(), self::HOLDOFF_NONE ),
				$ttl
			);
		} else {
			// This handles the mcrouter and the single-DC case
			$ok = $this->cache->set(
				$key,
				$this->makePurgeValue( $this->getCurrentTime(), self::HOLDOFF_NONE ),
				$ttl
			);
		}

		return $ok;
	}

	/**
	 * Do the actual async bus delete of a key
	 *
	 * @param string $key Cache key
	 * @return bool Success
	 */
	protected function relayDelete( $key ) {
		if ( $this->mcrouterAware ) {
			// See https://github.com/facebook/mcrouter/wiki/Multi-cluster-broadcast-setup
			// Wildcards select all matching routes, e.g. the WAN cluster on all DCs
			$ok = $this->cache->delete( "/*/{$this->cluster}/{$key}" );
		} else {
			// Some other proxy handles broadcasting or there is only one datacenter
			$ok = $this->cache->delete( $key );
		}

		return $ok;
	}

	/**
	 * @param string $key
	 * @param int $ttl
	 * @param callable $callback
	 * @param array $opts
	 * @return bool Success
	 */
	private function scheduleAsyncRefresh( $key, $ttl, $callback, $opts ) {
		if ( !$this->asyncHandler ) {
			return false;
		}
		// Update the cache value later, such during post-send of an HTTP request
		$func = $this->asyncHandler;
		$func( function () use ( $key, $ttl, $callback, $opts ) {
			$asOf = null; // unused
			$opts['minAsOf'] = INF; // force a refresh
			$this->doGetWithSetCallback( $key, $ttl, $callback, $opts, $asOf );
		} );

		return true;
	}

	/**
	 * Check if a key is fresh or in the grace window and thus due for randomized reuse
	 *
	 * If $curTTL > 0 (e.g. not expired) this returns true. Otherwise, the chance of returning
	 * true decrease steadily from 100% to 0% as the |$curTTL| moves from 0 to $graceTTL seconds.
	 * This handles widely varying levels of cache access traffic.
	 *
	 * If $curTTL <= -$graceTTL (e.g. already expired), then this returns false.
	 *
	 * @param float $curTTL Approximate TTL left on the key if present
	 * @param int $graceTTL Consider using stale values if $curTTL is greater than this
	 * @return bool
	 */
	protected function isAliveOrInGracePeriod( $curTTL, $graceTTL ) {
		if ( $curTTL > 0 ) {
			return true;
		} elseif ( $graceTTL <= 0 ) {
			return false;
		}

		$ageStale = abs( $curTTL ); // seconds of staleness
		$curGTTL = ( $graceTTL - $ageStale ); // current grace-time-to-live
		if ( $curGTTL <= 0 ) {
			return false; //  already out of grace period
		}

		// Chance of using a stale value is the complement of the chance of refreshing it
		return !$this->worthRefreshExpiring( $curGTTL, $graceTTL );
	}

	/**
	 * Check if a key is nearing expiration and thus due for randomized regeneration
	 *
	 * This returns false if $curTTL >= $lowTTL. Otherwise, the chance of returning true
	 * increases steadily from 0% to 100% as the $curTTL moves from $lowTTL to 0 seconds.
	 * This handles widely varying levels of cache access traffic.
	 *
	 * If $curTTL <= 0 (e.g. already expired), then this returns false.
	 *
	 * @param float $curTTL Approximate TTL left on the key if present
	 * @param float $lowTTL Consider a refresh when $curTTL is less than this
	 * @return bool
	 */
	protected function worthRefreshExpiring( $curTTL, $lowTTL ) {
		if ( $lowTTL <= 0 ) {
			return false;
		} elseif ( $curTTL >= $lowTTL ) {
			return false;
		} elseif ( $curTTL <= 0 ) {
			return false;
		}

		$chance = ( 1 - $curTTL / $lowTTL );

		return mt_rand( 1, 1e9 ) <= 1e9 * $chance;
	}

	/**
	 * Check if a key is due for randomized regeneration due to its popularity
	 *
	 * This is used so that popular keys can preemptively refresh themselves for higher
	 * consistency (especially in the case of purge loss/delay). Unpopular keys can remain
	 * in cache with their high nominal TTL. This means popular keys keep good consistency,
	 * whether the data changes frequently or not, and long-tail keys get to stay in cache
	 * and get hits too. Similar to worthRefreshExpiring(), randomization is used.
	 *
	 * @param float $asOf UNIX timestamp of the value
	 * @param int $ageNew Age of key when this might recommend refreshing (seconds)
	 * @param int $timeTillRefresh Age of key when it should be refreshed if popular (seconds)
	 * @param float $now The current UNIX timestamp
	 * @return bool
	 */
	protected function worthRefreshPopular( $asOf, $ageNew, $timeTillRefresh, $now ) {
		if ( $ageNew < 0 || $timeTillRefresh <= 0 ) {
			return false;
		}

		$age = $now - $asOf;
		$timeOld = $age - $ageNew;
		if ( $timeOld <= 0 ) {
			return false;
		}

		// Lifecycle is: new, ramp-up refresh chance, full refresh chance.
		// Note that the "expected # of refreshes" for the ramp-up time range is half of what it
		// would be if P(refresh) was at its full value during that time range.
		$refreshWindowSec = max( $timeTillRefresh - $ageNew - self::RAMPUP_TTL / 2, 1 );
		// P(refresh) * (# hits in $refreshWindowSec) = (expected # of refreshes)
		// P(refresh) * ($refreshWindowSec * $popularHitsPerSec) = 1
		// P(refresh) = 1/($refreshWindowSec * $popularHitsPerSec)
		$chance = 1 / ( self::HIT_RATE_HIGH * $refreshWindowSec );

		// Ramp up $chance from 0 to its nominal value over RAMPUP_TTL seconds to avoid stampedes
		$chance *= ( $timeOld <= self::RAMPUP_TTL ) ? $timeOld / self::RAMPUP_TTL : 1;

		return mt_rand( 1, 1e9 ) <= 1e9 * $chance;
	}

	/**
	 * Check if $value is not false, versioned (if needed), and not older than $minTime (if set)
	 *
	 * @param array|bool $value
	 * @param bool $versioned
	 * @param float $asOf The time $value was generated
	 * @param float $minTime The last time the main value was generated (0.0 if unknown)
	 * @param float|null $purgeTime The last time the value was invalidated
	 * @return bool
	 */
	protected function isValid( $value, $versioned, $asOf, $minTime, $purgeTime = null ) {
		// Avoid reading any key not generated after the latest delete() or touch
		$safeMinTime = max( $minTime, $purgeTime + self::TINY_POSTIVE );

		if ( $value === false ) {
			return false;
		} elseif ( $versioned && !isset( $value[self::VFLD_VERSION] ) ) {
			return false;
		} elseif ( $safeMinTime > 0 && $asOf < $minTime ) {
			return false;
		}

		return true;
	}

	/**
	 * Do not use this method outside WANObjectCache
	 *
	 * @param mixed $value
	 * @param int $ttl [0=forever]
	 * @param float $now Unix Current timestamp just before calling set()
	 * @return array
	 */
	protected function wrap( $value, $ttl, $now ) {
		return [
			self::FLD_VERSION => self::VERSION,
			self::FLD_VALUE => $value,
			self::FLD_TTL => $ttl,
			self::FLD_TIME => $now
		];
	}

	/**
	 * Do not use this method outside WANObjectCache
	 *
	 * The cached value will be false if absent/tombstoned/malformed
	 *
	 * @param array|string|bool $wrapped
	 * @param float $now Unix Current timestamp (preferrably pre-query)
	 * @return array (cached value or false, current TTL, value timestamp, tombstone timestamp)
	 */
	protected function unwrap( $wrapped, $now ) {
		// Check if the value is a tombstone
		$purge = $this->parsePurgeValue( $wrapped );
		if ( $purge !== false ) {
			// Purged values should always have a negative current $ttl
			$curTTL = min( $purge[self::FLD_TIME] - $now, self::TINY_NEGATIVE );
			return [ false, $curTTL, null, $purge[self::FLD_TIME] ];
		}

		if ( !is_array( $wrapped ) // not found
			|| !isset( $wrapped[self::FLD_VERSION] ) // wrong format
			|| $wrapped[self::FLD_VERSION] !== self::VERSION // wrong version
		) {
			return [ false, null, null, null ];
		}

		if ( $wrapped[self::FLD_TTL] > 0 ) {
			// Get the approximate time left on the key
			$age = $now - $wrapped[self::FLD_TIME];
			$curTTL = max( $wrapped[self::FLD_TTL] - $age, 0.0 );
		} else {
			// Key had no TTL, so the time left is unbounded
			$curTTL = INF;
		}

		if ( $wrapped[self::FLD_TIME] < $this->epoch ) {
			// Values this old are ignored
			return [ false, null, null, null ];
		}

		return [ $wrapped[self::FLD_VALUE], $curTTL, $wrapped[self::FLD_TIME], null ];
	}

	/**
	 * @param array $keys
	 * @param string $prefix
	 * @return string[]
	 */
	protected static function prefixCacheKeys( array $keys, $prefix ) {
		$res = [];
		foreach ( $keys as $key ) {
			$res[] = $prefix . $key;
		}

		return $res;
	}

	/**
	 * @param string $key String of the format <scope>:<class>[:<class or variable>]...
	 * @return string A collection name to describe this class of key
	 */
	protected function determineKeyClassForStats( $key ) {
		$parts = explode( ':', $key );

		return $parts[1] ?? $parts[0]; // sanity
	}

	/**
	 * @param string|array|bool $value Possible string of the form "PURGED:<timestamp>:<holdoff>"
	 * @return array|bool Array containing a UNIX timestamp (float) and holdoff period (integer),
	 *  or false if value isn't a valid purge value
	 */
	protected function parsePurgeValue( $value ) {
		if ( !is_string( $value ) ) {
			return false;
		}

		$segments = explode( ':', $value, 3 );
		if ( !isset( $segments[0] ) || !isset( $segments[1] )
			|| "{$segments[0]}:" !== self::PURGE_VAL_PREFIX
		) {
			return false;
		}

		if ( !isset( $segments[2] ) ) {
			// Back-compat with old purge values without holdoff
			$segments[2] = self::HOLDOFF_TTL;
		}

		if ( $segments[1] < $this->epoch ) {
			// Values this old are ignored
			return false;
		}

		return [
			self::FLD_TIME => (float)$segments[1],
			self::FLD_HOLDOFF => (int)$segments[2],
		];
	}

	/**
	 * @param float $timestamp
	 * @param int $holdoff In seconds
	 * @return string Wrapped purge value
	 */
	protected function makePurgeValue( $timestamp, $holdoff ) {
		return self::PURGE_VAL_PREFIX . (float)$timestamp . ':' . (int)$holdoff;
	}

	/**
	 * @param string $group
	 * @return MapCacheLRU
	 */
	protected function getProcessCache( $group ) {
		if ( !isset( $this->processCaches[$group] ) ) {
			list( , $n ) = explode( ':', $group );
			$this->processCaches[$group] = new MapCacheLRU( (int)$n );
		}

		return $this->processCaches[$group];
	}

	/**
	 * @param array $keys
	 * @param array $opts
	 * @param int $pcTTL
	 * @return array List of keys
	 */
	private function getNonProcessCachedKeys( array $keys, array $opts, $pcTTL ) {
		$keysFound = [];
		if ( isset( $opts['pcTTL'] ) && $opts['pcTTL'] > 0 && $this->callbackDepth == 0 ) {
			$pcGroup = $opts['pcGroup'] ?? self::PC_PRIMARY;
			$procCache = $this->getProcessCache( $pcGroup );
			foreach ( $keys as $key ) {
				if ( $procCache->has( $key, $pcTTL ) ) {
					$keysFound[] = $key;
				}
			}
		}

		return array_diff( $keys, $keysFound );
	}

	/**
	 * @param array $keys
	 * @param array $checkKeys
	 * @return array Map of (cache key => mixed)
	 */
	private function getRawKeysForWarmup( array $keys, array $checkKeys ) {
		if ( !$keys ) {
			return [];
		}

		$keysWarmUp = [];
		// Get all the value keys to fetch...
		foreach ( $keys as $key ) {
			$keysWarmUp[] = self::VALUE_KEY_PREFIX . $key;
		}
		// Get all the check keys to fetch...
		foreach ( $checkKeys as $i => $checkKeyOrKeys ) {
			if ( is_int( $i ) ) {
				// Single check key that applies to all value keys
				$keysWarmUp[] = self::TIME_KEY_PREFIX . $checkKeyOrKeys;
			} else {
				// List of check keys that apply to value key $i
				$keysWarmUp = array_merge(
					$keysWarmUp,
					self::prefixCacheKeys( $checkKeyOrKeys, self::TIME_KEY_PREFIX )
				);
			}
		}

		$warmupCache = $this->cache->getMulti( $keysWarmUp );
		$warmupCache += array_fill_keys( $keysWarmUp, false );

		return $warmupCache;
	}

	/**
	 * @return float UNIX timestamp
	 * @codeCoverageIgnore
	 */
	protected function getCurrentTime() {
		if ( $this->wallClockOverride ) {
			return $this->wallClockOverride;
		}

		$clockTime = (float)time(); // call this first
		// microtime() uses an initial gettimeofday() call added to usage clocks.
		// This can severely drift from time() and the microtime() value of other threads
		// due to undercounting of the amount of time elapsed. Instead of seeing the current
		// time as being in the past, use the value of time(). This avoids setting cache values
		// that will immediately be seen as expired and possibly cause stampedes.
		return max( microtime( true ), $clockTime );
	}

	/**
	 * @param float|null &$time Mock UNIX timestamp for testing
	 * @codeCoverageIgnore
	 */
	public function setMockTime( &$time ) {
		$this->wallClockOverride =& $time;
		$this->cache->setMockTime( $time );
	}
}
