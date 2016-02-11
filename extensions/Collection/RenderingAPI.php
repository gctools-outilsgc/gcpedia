<?php

/**
 * Base class for API that interacts with book rendering service
 */
abstract class CollectionRenderingAPI {
	/** @var CollectionRenderingAPI */
	private static $inst;

	/** @var string */
	protected $writer;

	public static function instance( $writer = false ) {
		if ( !self::$inst ) {
			self::$inst = new MWServeRenderingAPI( $writer );
		}
		return self::$inst;
	}

	/**
	 * @param string|bool $writer: Writer or false if none specified/needed
	 */
	public function __construct( $writer ) {
		$this->writer = $writer;
	}

	/**
	 * When overridden in derived class, performs a request to the service
	 *
	 * @param string $command
	 * @param array $params
	 * @return CollectionAPIResult
	 */
	protected abstract function makeRequest( $command, array $params );

	/**
	 * Requests a collection to be rendered
	 * @param array $collection
	 *
	 * @return CollectionAPIResult
	 */
	public function render( $collection ) {
		return $this->doRender( array(
				'metabook' => $this->buildJSONCollection( $collection ),
			)
		);
	}

	/**
	 * Requests a queued collection to be immediately rendered
	 *
	 * @param $collectionId
	 * @return CollectionAPIResult
	 */
	public function forceRender( $collectionId ) {
		return $this->doRender( array(
				'collection_id' => $collectionId,
				'force_render' => true
			)
		);
	}

	protected function doRender( array $params ) {
		global $wgScriptPath, $wgScriptExtension, $wgContLang;

		$params['base_url'] = wfExpandUrl( $wgScriptPath, PROTO_CURRENT );
		$params['script_extension'] = $wgScriptExtension;
		$params['language'] = $wgContLang->getCode();
		return $this->makeRequest( 'render', $params );
	}

	/**
	 * Requests the service to create a collection package and send it to an external server
	 * e.g. for printing
	 *
	 * @param $collection
	 * @param $url
	 *
	 * @return CollectionAPIResult
	 */
	public function postZip( $collection, $url ) {
		global $wgScriptPath, $wgScriptExtension;

		return $this->makeRequest( 'zip_post',
			array(
				'metabook' => $this->buildJSONCollection( $collection ),
				'base_url' => wfExpandUrl( $wgScriptPath, PROTO_CURRENT ),
				'script_extension' => $wgScriptExtension,
				'pod_api_url' => $url,
			)
		);
	}

	/**
	 * Returns inromation about a collection's rendering status
	 *
	 * @param $collectionId
	 * @return CollectionAPIResult
	 */
	public function getRenderStatus( $collectionId ) {
		return $this->makeRequest( 'render_status',
			array(
				'collection_id' => $collectionId,
			),
			'CollectionStatusAPIResult'
		);
	}

	/**
	 * Requests a download of rendered collection
	 *
	 * @param $collectionId
	 * @return CollectionAPIResult
	 */
	public function download( $collectionId ) {
		return $this->makeRequest( 'download',
			array(
				'collection_id' => $collectionId,
			)
		);
	}

	/**
	 * @return array
	 */
	protected function getLicenseInfos() {
		global $wgCollectionLicenseName, $wgCollectionLicenseURL, $wgRightsIcon;
		global $wgRightsPage, $wgRightsText, $wgRightsUrl;

		$licenseInfo = array(
			'type' => 'license',
		);

		$fromMsg = wfMessage( 'coll-license_url' )->inContentLanguage();
		if ( !$fromMsg->isDisabled() ) {
			$licenseInfo['mw_license_url'] = $fromMsg->text();
			return array( $licenseInfo );
		}

		if ( $wgCollectionLicenseName ) {
			$licenseInfo['name'] = $wgCollectionLicenseName;
		} else {
			$licenseInfo['name'] = wfMessage( 'coll-license' )->inContentLanguage()->text();
		}

		if ( $wgCollectionLicenseURL ) {
			$licenseInfo['mw_license_url'] = $wgCollectionLicenseURL;
		} else {
			$licenseInfo['mw_rights_icon'] = $wgRightsIcon;
			$licenseInfo['mw_rights_page'] = $wgRightsPage;
			$licenseInfo['mw_rights_url'] = $wgRightsUrl;
			$licenseInfo['mw_rights_text'] = $wgRightsText;
		}

		return array( $licenseInfo );
	}

	/**
	 * @param $collection array
	 * @return string
	 */
	protected function buildJSONCollection( $collection ) {
		global $wgCanonicalServer, $wgScriptPath, $wgScriptExtension;

		$result = array(
			'type' => 'collection',
			'licenses' => $this->getLicenseInfos()
		);

		if ( isset( $collection['title'] ) ) {
			$result['title'] = $collection['title'];
		}
		if ( isset( $collection['subtitle'] ) ) {
			$result['subtitle'] = $collection['subtitle'];
		}
		if ( isset( $collection['settings'] ) ) {
			foreach ( $collection['settings'] as $key => $val ) {
				$result[$key] = $val;
			}
			// compatibility with old mw-serve
			$result['settings'] = $collection['settings'];
		}

		$items = array();
		if ( isset( $collection['items'] ) ) {
			$currentChapter = null;
			foreach ( $collection['items'] as $item ) {
				if ( $item['type'] == 'article' ) {
					if ( is_null( $currentChapter ) ) {
						$items[] = $item;
					} else {
						$currentChapter['items'][] = $item;
					}
				} elseif ( $item['type'] == 'chapter' ) {
					if ( !is_null( $currentChapter ) ) {
						$items[] = $currentChapter;
					}
					$currentChapter = $item;
				}
			}
			if ( !is_null( $currentChapter ) ) {
				$items[] = $currentChapter;
			}
		}
		$result['items'] = $items;

		$result['wikis'] = array(
			array(
				'type' => 'wikiconf',
				'baseurl' => $wgCanonicalServer . $wgScriptPath,
				'script_extension' => $wgScriptExtension,
				'format' => 'nuwiki',
			),
		);

		// Prefer VRS configuration if present.
		$context = RequestContext::getMain();
		$vrs = $context->getConfig()->get( 'VirtualRestConfig' );
		if ( isset( $vrs['modules'] ) && isset( $vrs['modules']['restbase'] ) ) {
			// if restbase is available, use it
			$params = $vrs['modules']['restbase'];
			$domain = preg_replace(
				'/^(https?:\/\/)?([^\/:]+?)(\/|:\d+\/?)?$/',
				'$2',
				$params['domain']
			);
			$url = preg_replace(
				'#/?$#',
				'/' . $domain . '/v1/',
				$params['url']
			);
			for ( $i = 0; $i < count( $result['wikis'] ); $i++ ) {
				$result['wikis'][$i]['restbase1'] = $url;
			}
		} elseif ( isset( $vrs['modules'] ) && isset( $vrs['modules']['parsoid'] ) ) {
			// there's a global parsoid config, use it next
			$params = $vrs['modules']['parsoid'];
			$domain = preg_replace(
				'/^(https?:\/\/)?([^\/:]+?)(\/|:\d+\/?)?$/',
				'$2',
				$params['domain']
			);
			for ( $i = 0; $i < count( $result['wikis'] ); $i++ ) {
				$result['wikis'][$i]['parsoid'] = $params['url'];
				$result['wikis'][$i]['prefix'] = $params['prefix'];
				$result['wikis'][$i]['domain'] = $domain;
			}
		} elseif ( class_exists( 'VisualEditorHooks' ) ) {
			// fall back to Visual Editor configuration globals
			global $wgVisualEditorParsoidURL, $wgVisualEditorParsoidPrefix,
				$wgVisualEditorParsoidDomain, $wgVisualEditorRestbaseURL;
			for ( $i = 0; $i < count( $result['wikis'] ); $i++ ) {
				// Parsoid connection information
				if ($wgVisualEditorParsoidURL) {
					$result['wikis'][$i]['parsoid'] = $wgVisualEditorParsoidURL;
					$result['wikis'][$i]['prefix'] = $wgVisualEditorParsoidPrefix;
					$result['wikis'][$i]['domain'] = $wgVisualEditorParsoidDomain;
				}
				// RESTbase connection information
				if ($wgVisualEditorRestbaseURL) {
					// Strip the trailing "/page/html".
					$restbase1 = preg_replace('|/page/html/?$|', '/', $wgVisualEditorRestbaseURL);
					$result['wikis'][$i]['restbase1'] = $restbase1;
				}
			}
		}

		return FormatJson::encode( $result );
	}
}

/**
 * API for PediaPress' mw-serve
 */
class MWServeRenderingAPI extends CollectionRenderingAPI {
	protected function makeRequest( $command, array $params ) {
		global $wgCollectionMWServeURL, $wgCollectionMWServeCredentials, $wgCollectionFormatToServeURL, $wgCollectionCommandToServeURL;

		$serveURL = $wgCollectionMWServeURL;
		if ( $this->writer ) {
			if ( isset( $wgCollectionFormatToServeURL[ $this->writer ] ) ) {
				$serveURL = $wgCollectionFormatToServeURL[ $this->writer ];
			}
			$params['writer'] = $this->writer;
		}

		$params['command'] = $command;
		if ( isset( $wgCollectionCommandToServeURL[ $command ] ) ) {
			$serveURL = $wgCollectionCommandToServeURL[ $command ];
		}
		if ( $wgCollectionMWServeCredentials ) {
			$params['login_credentials'] = $wgCollectionMWServeCredentials;
		}
		// If $serveURL has a | in it, we need to use a proxy.
		list( $proxy, $serveURL ) = array_pad( explode( '|', $serveURL, 2 ), -2, '' );

		$response = Http::post( $serveURL, array( 'postData' => $params, 'proxy' => $proxy ), __METHOD__ );
		if ( $response === false ) {
			wfDebugLog( 'collection', "Request to $serveURL resulted in error" );
		}
		return new CollectionAPIResult( $response );
	}
}

/*
class NewRenderingAPI extends CollectionRenderingAPI {}
*/

/**
 * A wrapper for data returned by the API
 */
class CollectionAPIResult {
	/** @var array: Decoded JSON returned by server */
	public $response = array();

	/**
	 * @param string|null $data: Data returned by HTTP request
	 */
	public function __construct( $data ) {
		if ( $data ) {
			$this->response = FormatJson::decode( $data, true );
			if ( $this->response === null ) {
				wfDebugLog( 'collection', "Server returned bogus data: $data" );
				$this->response = null;
			}
			if ( $this->isError() ) {
				wfDebugLog( 'collection', "Server returned error: {$this->getError()}" );
			}
		}
	}

	/**
	 * Returns data for specified key(s)
	 * Has variable number of parameters, e.g. get( 'foo', 'bar', 'baz' )
	 * @param string $key
	 * @return mixed
	 */
	public function get( $key /*, ... */ ) {
		$args = func_get_args();
		$val = $this->response;
		foreach( $args as $arg ) {
			if ( !isset( $val[$arg] ) ) {
				return '';
			}
			$val = $val[$arg];
		}
		return $val;
	}

	/**
	 * @return bool
	 */
	public function isError() {
		return !$this->response
			|| ( isset( $this->response['error'] ) && $this->response['error'] );
	}

	/**
	 * @return string: Internal (not user-facing) error description
	 */
	protected function getError() {
		if ( isset ( $this->response['error'] ) ) {
			return $this->response['error'];
		}
		return '(error unknown)';
	}
}
