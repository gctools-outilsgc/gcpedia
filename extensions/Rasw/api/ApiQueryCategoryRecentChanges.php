<?php
class ApiQueryCategoryRecentChanges extends ApiQueryBase {

	public function __construct( ApiQuery $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'crc' );
	}
	public function execute() {
		$this->run();
	}

	public function executeGenerator( $resultPageSet ) {
		$this->run( $resultPageSet );
	}

	public function run( $resultPageSet = null ) {
		$user = $this->getUser();
		/* Get the parameters of the request. */
		$params = $this->extractRequestParams();
		/* Build our basic query. Namely, something along the lines of:
		 * SELECT * FROM recentchanges WHERE rc_timestamp > $start
		 * 		AND rc_timestamp < $end AND rc_namespace = $namespace
		 */
		$this->addTables( 'page' );
		$this->addFields( array('page_title', 'page_id', 'page_namespace', 'page_touched'));
		$this->addTables('categorylinks');
		$this->addJoinConds( array( 'categorylinks' => array( 'LEFT JOIN', array( 'page_id=cl_from' ) ) ));
		//$index = array( 'page' => 'page_touched' ); // May change
		$this->addTimestampWhereRange( 'page_touched', $params['dir'], $params['start'], $params['end'] );

		if ( !is_null( $params['continue'] ) ) {
			$cont = explode( '|', $params['continue'] );
			$this->dieContinueUsageIf( count( $cont ) != 2 );
			$db = $this->getDB();
			$timestamp = $db->addQuotes( $db->timestamp( $cont[0] ) );
			$id = intval( $cont[1] );
			$this->dieContinueUsageIf( $id != $cont[1] );
			$op = $params['dir'] === 'older' ? '<' : '>';
			$this->addWhere(
				"page_touched $op $timestamp"
			);
		}
//select * from page p join categorylinks c on p.page_id=c.cl_from where c.cl_to="Choir" order by p.page_touched desc;

		$this->addWhereFld( 'cl_to', $params['category'] );
		$order = $params['dir'] === 'older' ? 'DESC' : 'ASC';
		$this->addOption( 'ORDER BY', array(
			"page_touched $order"
		) );
/*
		if ( !is_null( $params['type'] ) ) {
			try {
				$this->addWhereFld( 'rc_type', RecentChange::parseToRCType( $params['type'] ) );
			} catch ( Exception $e ) {
				ApiBase::dieDebug( __METHOD__, $e->getMessage() );
			}
		}
*/
		if ( !is_null( $params['show'] ) ) {
			$show = array_flip( $params['show'] );

			/* Check for conflicting parameters. */
			if ( ( isset( $show['minor'] ) && isset( $show['!minor'] ) )
				|| ( isset( $show['bot'] ) && isset( $show['!bot'] ) )
				|| ( isset( $show['anon'] ) && isset( $show['!anon'] ) )
				|| ( isset( $show['redirect'] ) && isset( $show['!redirect'] ) )
				|| ( isset( $show['patrolled'] ) && isset( $show['!patrolled'] ) )
				|| ( isset( $show['patrolled'] ) && isset( $show['unpatrolled'] ) )
				|| ( isset( $show['!patrolled'] ) && isset( $show['unpatrolled'] ) )
			) {
				$this->dieUsageMsg( 'show' );
			}

			// Don't throw log entries out the window here
			$this->addWhereIf(
				'page_is_redirect = 0 OR page_is_redirect IS NULL',
				isset( $show['!redirect'] )
			);
		}
		$count = 0;
		/* Perform the actual query. */
		$res = $this->select( __METHOD__ );

		$titles = array();

		$result = $this->getResult();

		/* Iterate through the rows, adding data extracted from them to our query result. */
		foreach ( $res as $row ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', "$row->rc_timestamp|$row->rc_id" );
				break;
			}

			if ( is_null( $resultPageSet ) ) {
				/* Extract the data from a single row. */
				$vals = $this->extractRowInfo( $row );

				/* Add that row's data to our final output. */
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $vals );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'continue', "$row->rc_timestamp|$row->rc_id" );
					break;
				}
			} else {
				$titles[] = Title::makeTitle( $row->page_namespace, $row->page_title );
			}
		}
		if ( is_null( $resultPageSet ) ) {
			/* Format the result */
			$result->addIndexedTagName( array( 'query', $this->getModuleName() ), 'rc' );
		} else {
			$resultPageSet->populateFromTitles( $titles );
		}
	}

	// Description
	public function getDescription() {
		return 'Get most recent changes in a given category.';
	}
	/**
	 * Sets internal state to include the desired properties in the output.
	 * @param array $prop Associative array of properties, only keys are used here
	 */
	public function initProperties( $prop ) {
		$this->fld_comment = isset( $prop['comment'] );
		$this->fld_parsedcomment = isset( $prop['parsedcomment'] );
		$this->fld_user = isset( $prop['user'] );
		$this->fld_userid = isset( $prop['userid'] );
		$this->fld_flags = isset( $prop['flags'] );
		$this->fld_timestamp = isset( $prop['timestamp'] );
		$this->fld_title = isset( $prop['title'] );
		$this->fld_ids = isset( $prop['ids'] );
		$this->fld_sizes = isset( $prop['sizes'] );
		$this->fld_redirect = isset( $prop['redirect'] );
		$this->fld_patrolled = isset( $prop['patrolled'] );
		$this->fld_loginfo = isset( $prop['loginfo'] );
		$this->fld_tags = isset( $prop['tags'] );
		$this->fld_sha1 = isset( $prop['sha1'] );
	}

	/**
	 * Extracts from a single sql row the data needed to describe one recent change.
	 *
	 * @param stdClass $row The row from which to extract the data.
	 * @return array An array mapping strings (descriptors) to their respective string values.
	 * @access public
	 */
	public function extractRowInfo( $row ) {
		/* Determine the title of the page that has been changed. */
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$user = $this->getUser();

		/* Our output data. */
		$vals = array();

		$type = intval( $row->rc_type );
		$vals['title'] = $title;
		$vals['pageid'] = $row->page_id;
		$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->page_touched );
		$vals['type'] = RecentChange::parseFromRCType( $type );

		$anyHidden = false;

		/* Create a new entry in the result for the title. */
		if ( $this->fld_title || $this->fld_ids ) {
			if ( $type === RC_LOG && ( $row->rc_deleted & LogPage::DELETED_ACTION ) ) {
				$vals['actionhidden'] = true;
				$anyHidden = true;
			}
			if ( $type !== RC_LOG ||
				LogEventsList::userCanBitfield( $row->rc_deleted, LogPage::DELETED_ACTION, $user )
			) {
				if ( $this->fld_title ) {
					ApiQueryBase::addTitleInfo( $vals, $title );
				}
				if ( $this->fld_ids ) {
					$vals['pageid'] = intval( $row->rc_cur_id );
					$vals['revid'] = intval( $row->rc_this_oldid );
					$vals['old_revid'] = intval( $row->rc_last_oldid );
				}
			}
		}

		if ( $this->fld_ids ) {
			$vals['rcid'] = intval( $row->rc_id );
		}

		/* Add user data and 'anon' flag, if user is anonymous. */
		if ( $this->fld_user || $this->fld_userid ) {
			if ( $row->rc_deleted & Revision::DELETED_USER ) {
				$vals['userhidden'] = true;
				$anyHidden = true;
			}
			if ( Revision::userCanBitfield( $row->rc_deleted, Revision::DELETED_USER, $user ) ) {
				if ( $this->fld_user ) {
					$vals['user'] = $row->rc_user_text;
				}

				if ( $this->fld_userid ) {
					$vals['userid'] = (int)$row->rc_user;
				}

				if ( !$row->rc_user ) {
					$vals['anon'] = true;
				}
			}
		}

		/* Add flags, such as new, minor, bot. */
		if ( $this->fld_flags ) {
			$vals['bot'] = (bool)$row->rc_bot;
			$vals['new'] = $row->rc_type == RC_NEW;
			$vals['minor'] = (bool)$row->rc_minor;
		}

		/* Add sizes of each revision. (Only available on 1.10+) */
		if ( $this->fld_sizes ) {
			$vals['oldlen'] = intval( $row->rc_old_len );
			$vals['newlen'] = intval( $row->rc_new_len );
		}

		/* Add the timestamp. */
		if ( $this->fld_timestamp ) {
			$vals['timestamp'] = wfTimestamp( TS_ISO_8601, $row->page_touched );
		}

		/* Add edit summary / log summary. */
		if ( $this->fld_comment || $this->fld_parsedcomment ) {
			if ( $row->rc_deleted & Revision::DELETED_COMMENT ) {
				$vals['commenthidden'] = true;
				$anyHidden = true;
			}
			if ( Revision::userCanBitfield( $row->rc_deleted, Revision::DELETED_COMMENT, $user ) ) {
				if ( $this->fld_comment && isset( $row->rc_comment ) ) {
					$vals['comment'] = $row->rc_comment;
				}

				if ( $this->fld_parsedcomment && isset( $row->rc_comment ) ) {
					$vals['parsedcomment'] = Linker::formatComment( $row->rc_comment, $title );
				}
			}
		}

		if ( $this->fld_redirect ) {
			$vals['redirect'] = (bool)$row->page_is_redirect;
		}

		/* Add the patrolled flag */
		if ( $this->fld_patrolled ) {
			$vals['patrolled'] = $row->rc_patrolled == 1;
			$vals['unpatrolled'] = ChangesList::isUnpatrolled( $row, $user );
		}

		if ( $this->fld_loginfo && $row->rc_type == RC_LOG ) {
			if ( $row->rc_deleted & LogPage::DELETED_ACTION ) {
				$vals['actionhidden'] = true;
				$anyHidden = true;
			}
			if ( LogEventsList::userCanBitfield( $row->rc_deleted, LogPage::DELETED_ACTION, $user ) ) {
				$vals['logid'] = intval( $row->rc_logid );
				$vals['logtype'] = $row->rc_log_type;
				$vals['logaction'] = $row->rc_log_action;
				$vals['logparams'] = LogFormatter::newFromRow( $row )->formatParametersForApi();
			}
		}

		if ( $this->fld_tags ) {
			if ( $row->ts_tags ) {
				$tags = explode( ',', $row->ts_tags );
				ApiResult::setIndexedTagName( $tags, 'tag' );
				$vals['tags'] = $tags;
			} else {
				$vals['tags'] = array();
			}
		}

		if ( $this->fld_sha1 && $row->rev_sha1 !== null ) {
			if ( $row->rev_deleted & Revision::DELETED_TEXT ) {
				$vals['sha1hidden'] = true;
				$anyHidden = true;
			}
			if ( Revision::userCanBitfield( $row->rev_deleted, Revision::DELETED_TEXT, $user ) ) {
				if ( $row->rev_sha1 !== '' ) {
					$vals['sha1'] = wfBaseConvert( $row->rev_sha1, 36, 16, 40 );
				} else {
					$vals['sha1'] = '';
				}
			}
		}

		if ( $anyHidden && ( $row->rc_deleted & Revision::DELETED_RESTRICTED ) ) {
			$vals['suppressed'] = true;
		}

		return $vals;
	}

	public function getCacheMode( $params ) {
		if ( isset( $params['show'] ) ) {
			foreach ( $params['show'] as $show ) {
				if ( $show === 'patrolled' || $show === '!patrolled' ) {
					return 'private';
				}
			}
		}
		if ( isset( $params['token'] ) ) {
			return 'private';
		}
		if ( $this->userCanSeeRevDel() ) {
			return 'private';
		}
		if ( !is_null( $params['prop'] ) && in_array( 'parsedcomment', $params['prop'] ) ) {
			// formatComment() calls wfMessage() among other things
			return 'anon-public-user-private';
		}

		return 'public';
	}

	public function getAllowedParams() {
		return array(
			'category' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'start' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'end' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'dir' => array(
				ApiBase::PARAM_DFLT => 'older',
				ApiBase::PARAM_TYPE => array(
					'newer',
					'older'
				),
				ApiBase::PARAM_HELP_MSG => 'api-help-param-direction',
			),
			'namespace' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'namespace'
			),
			'user' => array(
				ApiBase::PARAM_TYPE => 'user'
			),
			'excludeuser' => array(
				ApiBase::PARAM_TYPE => 'user'
			),
			'tag' => null,
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => 'title|timestamp|ids',
				ApiBase::PARAM_TYPE => array(
					'user',
					'userid',
					'comment',
					'parsedcomment',
					'flags',
					'timestamp',
					'title',
					'ids',
					'sizes',
					'redirect',
					'patrolled',
					'loginfo',
					'tags',
					'sha1',
				),
				ApiBase::PARAM_HELP_MSG_PER_VALUE => array(),
			),
			'show' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'minor',
					'!minor',
					'bot',
					'!bot',
					'anon',
					'!anon',
					'redirect',
					'!redirect',
					'patrolled',
					'!patrolled',
					'unpatrolled'
				)
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'type' => array(
				ApiBase::PARAM_DFLT => 'edit|new|log',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'edit',
					'external',
					'new',
					'log'
				)
			),
			'toponly' => false,
			'continue' => array(
				ApiBase::PARAM_HELP_MSG => 'api-help-param-continue',
			),
		);
	}

	protected function getExamplesMessages() {
		return array(
			'action=query&list=recentchanges'
				=> 'apihelp-query+recentchanges-example-simple',
			'action=query&generator=recentchanges&grcshow=!patrolled&prop=info'
				=> 'apihelp-query+recentchanges-example-generator',
		);
	}
}
