<?php
/**
 * The same code was literally duplicated in three separate classes.
 * This mini-class addresses that issue.
 *
 * @file
 * @date 26 October 2023
 */

use MediaWiki\MediaWikiServices;
use MediaWiki\Title\Title;

class FavoriteListInfo {

	/**
	 * Get a list of titles on a user's favoritelist, excluding talk pages,
	 * and return as a two-dimensional array with namespace, title and
	 * redirect status
	 *
	 * @param User|MediaWiki\User\UserIdentity $user
	 * @param array $params If 'ignoreTalkNS' is set to true in this array, we skip the isTalkPage() check
	 *   (SpecialFavoritelist.php and FavParser.php set this, while FavoritelistEditor.php doesn't)
	 * @return Title[]
	 */
	public static function getForUser( $user, $params = [] ) {
		$titles = [];
		$services = MediaWikiServices::getInstance();
		$dbr = $services->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$uid = intval( $user->getId() );

		/* This is from Aaron's patch (6e24a82cac6824c2407240da80e525b9a877aa37) but it lacks
		the LinkCache fields currently.
		$res = $dbr->newSelectQueryBuilder()
			->select( [ 'fl_namespace', 'fl_title', 'page_id', 'page_len', 'page_is_redirect' ] )
			->from( 'favoritelist' )
			->leftJoin( 'page', null, 'fl_namespace = page_namespace AND fl_title = page_title' )
			->where( [ 'fl_user' => $uid ] )
			->fetchResultSet();
		*/
		$res = $dbr->select(
			[ 'favoritelist', 'page' ],
			[
				// SELECTing fl_namespace AS page_namespace and fl_title AS page_title for LinkCache, it needs those
				'page_namespace' => 'fl_namespace',
				'page_title' => 'fl_title',
				'page_id', 'page_len', 'page_is_redirect'
			] + LinkCache::getSelectFields(),
			[ 'fl_user' => $uid ],
			__METHOD__,
			[],
			[ 'page' => [ 'LEFT JOIN', [ 'fl_namespace = page_namespace', 'fl_title = page_title' ] ] ]
		);

		$skipTalk = ( isset( $params['ignoreTalkNS'] ) && $params['ignoreTalkNS'] === true );

		if ( $res->numRows() > 0 ) {
			$cache = $services->getLinkCache();

			foreach ( $res as $row ) {
				$title = Title::makeTitleSafe( $row->page_namespace, $row->page_title );

				if ( $title instanceof Title ) {
					// Update the link cache while we're at it
					if ( $row->page_id ) {
						$cache->addGoodLinkObjFromRow( $title, $row );
					} else {
						$cache->addBadLinkObj( $title );
					}

					// Ignore non-talk
					if ( !$title->isTalkPage() && $skipTalk ) {
						$titles[$row->page_namespace][$row->page_title] = $row->page_is_redirect;
					}
				}
			}
		}

		return $titles;
	}

}
