<?php

/**
 * Contains the actual database backend logic for merging users
 *
 */
class MergeUser {
	/**
	 * @var User
	 */
	private $oldUser, $newUser;

	/**
	 * @var IUserMergeLogger
	 */
	private $logger;

	/** @var integer */
	private $flags;

	const USE_MULTI_COMMIT = 1; // allow begin/commit; useful for jobs

	/**
	 * @param User $oldUser
	 * @param User $newUser
	 * @param IUserMergeLogger $logger
	 * @param int $flags Bitfield (Supports MergeUser::USE_*)
	 */
	public function __construct(
		User $oldUser,
		User $newUser,
		IUserMergeLogger $logger,
		$flags = 0
	) {
		$this->newUser = $newUser;
		$this->oldUser = $oldUser;
		$this->logger = $logger;
		$this->flags = $flags;
	}

	/**
	 * @param User $performer
	 */
	public function merge( User $performer ) {
		$this->mergeEditcount();
		$this->mergeDatabaseTables();
		$this->logger->addMergeEntry( $performer, $this->oldUser, $this->newUser );
	}

	/**
	 * @param User $performer
	 * @param callable $msg something that returns a Message object
	 *
	 * @return array Array of failed page moves, see MergeUser::movePages
	 */
	public function delete( User $performer, /* callable */ $msg ) {
		$failed = $this->movePages( $performer, $msg );
		$this->deleteUser();
		$this->logger->addDeleteEntry( $performer, $this->oldUser );

		return $failed;
	}

	/**
	 * Adds edit count of both users
	 */
	private function mergeEditcount() {
		$dbw = wfGetDB( DB_MASTER );
		$this->begin( $dbw );

		$totalEdits = $dbw->selectField(
			'user',
			'SUM(user_editcount)',
			array( 'user_id' => array( $this->newUser->getId(), $this->oldUser->getId() ) ),
			__METHOD__
		);

		$totalEdits = intval( $totalEdits );

		# don't run queries if neither user has any edits
		if ( $totalEdits > 0 ) {
			# update new user with total edits
			$dbw->update( 'user',
				array( 'user_editcount' => $totalEdits ),
				array( 'user_id' => $this->newUser->getId() ),
				__METHOD__
			);

			# clear old user's edits
			$dbw->update( 'user',
				array( 'user_editcount' => 0 ),
				array( 'user_id' => $this->oldUser->getId() ),
				__METHOD__
			);
		}

		$this->commit( $dbw );
	}

	private function mergeBlocks( DatabaseBase $dbw ) {
		$this->begin( $dbw );

		// Pull blocks directly from master
		$rows = $dbw->select(
			'ipblocks',
			'*',
			array(
				'ipb_user' => array( $this->oldUser->getId(), $this->newUser->getId() ),
			)
		);

		$newBlock = false;
		$oldBlock = false;
		foreach ( $rows as $row ) {
			if ( $row->ipb_user == $this->oldUser->getId() ) {
				$oldBlock = $row;
			} elseif ( $row->ipb_user == $this->newUser->getId() ) {
				$newBlock = $row;
			}
		}

		if ( !$newBlock && !$oldBlock ) {
			// No one is blocked, yaaay
			return;
		} elseif ( $newBlock && !$oldBlock ) {
			// Only the new user is blocked, so nothing to do.
			return;
		} elseif ( $oldBlock && !$newBlock ) {
			// Just move the old block to the new username
			$dbw->update(
				'ipblocks',
				array( 'ipb_user' => $this->newUser->getId() ),
				array( 'ipb_id' => $oldBlock->ipb_id ),
				__METHOD__
			);
			return;
		}

		// Okay, lets pick the "strongest" block, and re-apply it to
		// the new user.
		$oldBlockObj = Block::newFromRow( $oldBlock );
		$newBlockObj = Block::newFromRow( $newBlock );

		$winner = $this->chooseBlock( $oldBlockObj, $newBlockObj );
		if ( $winner->getId() === $newBlockObj->getId() ) {
			$oldBlockObj->delete();
		} else { // Old user block won
			$newBlockObj->delete(); // Delete current new block
			$dbw->update(
				'ipblocks',
				array( 'ipb_user' => $this->newUser->getId() ),
				array( 'ipb_id' => $winner->getId() ),
				__METHOD__
			);
		}

		$this->commit( $dbw );
	}

	/**
	 * @param Block $b1
	 * @param Block $b2
	 * @return Block
	 */
	private function chooseBlock( Block $b1, Block $b2 ) {
		// First, see if one is longer than the other.
		if ( $b1->getExpiry() !== $b2->getExpiry() ) {
			// This works for infinite blocks because:
			// "infinity" > "20141024234513"
			if ( $b1->getExpiry() > $b2->getExpiry() ) {
				return $b1;
			} else {
				return $b2;
			}
		}

		// Next check what they block, in order
		foreach ( array( 'createaccount', 'sendemail', 'editownusertalk' ) as $action ) {
			if ( $b1->prevents( $action ) xor $b2->prevents( $action ) ) {
				if ( $b1->prevents( $action ) ) {
					return $b1;
				} else {
					return $b2;
				}
			}
		}

		// Give up, return the second one.
		return $b2;
	}

	/**
	 * Function to merge database references from one user to another user
	 *
	 * Merges database references from one user ID or username to another user ID or username
	 * to preserve referential integrity.
	 */
	private function mergeDatabaseTables() {
		// Fields to update with the format:
		// array(
		//        tableName, idField, textField,
		//        'batchKey' => unique field, 'options' => array(), 'db' => DatabaseBase
		// );
		// textField, batchKey, db, and options are optional
		$updateFields = array(
			array( 'archive', 'ar_user', 'ar_user_text', 'batchKey' => 'ar_id' ),
			array( 'revision', 'rev_user', 'rev_user_text', 'batchKey' => 'rev_id' ),
			array( 'filearchive', 'fa_user', 'fa_user_text', 'batchKey' => 'fa_id' ),
			array( 'image', 'img_user', 'img_user_text', 'batchKey' => 'img_name' ),
			array( 'oldimage', 'oi_user', 'oi_user_text', 'batchKey' => 'oi_archive_name' ),
			array( 'recentchanges', 'rc_user', 'rc_user_text', 'batchKey' => 'rc_id' ),
			array( 'logging', 'log_user', 'batchKey' =>'log_id' ),
			array( 'ipblocks', 'ipb_by', 'ipb_by_text', 'batchKey' =>'ipb_id' ),
			array( 'watchlist', 'wl_user', 'batchKey' => 'wl_title' ),
			array( 'user_groups', 'ug_user', 'options' => array( 'IGNORE' ) ),
			array( 'user_properties', 'up_user', 'options' => array( 'IGNORE' ) ),
			array( 'user_former_groups', 'ufg_user', 'options' => array( 'IGNORE' ) ),
		);

		Hooks::run( 'UserMergeAccountFields', array( &$updateFields ) );

		$dbw = wfGetDB( DB_MASTER );

		$this->deduplicateWatchlistEntries( $dbw );
		$this->mergeBlocks( $dbw );

		// For readability, flush any trx (though mergeBlocks will manage this)
		if ( $this->flags & self::USE_MULTI_COMMIT ) {
			$dbw->commit( __METHOD__, 'flush' );
		}

		foreach ( $updateFields as $fieldInfo ) {
			$options = isset( $fieldInfo['options'] ) ? $fieldInfo['options'] : array();
			unset( $fieldInfo['options'] );
			$db = isset( $fieldInfo['db'] ) ? $fieldInfo['db'] : $dbw;
			unset( $fieldInfo['db'] );
			$tableName = array_shift( $fieldInfo );
			$idField = array_shift( $fieldInfo );
			$keyField = isset( $fieldInfo['batchKey'] ) ? $fieldInfo['batchKey'] : null;
			unset( $fieldInfo['batchKey'] );

			if ( $db->trxLevel() || $keyField === null ) {
				// Can't batch/wait when in a transaction or when no batch key is given
				$db->update(
					$tableName,
					array( $idField => $this->newUser->getId() )
						+ array_fill_keys( $fieldInfo, $this->newUser->getName() ),
					array( $idField => $this->oldUser->getId() ),
					__METHOD__,
					$options
				);
			} else {
				$limit = 200;
				do {
					$checkSince = microtime( true );
					// Batch and wait for slaves (ORDER BY + LIMIT is not well supported)
					$db->begin();
					// Grab a batch of values on a mostly unique column for this user ID
					$res = $db->select(
						$tableName,
						array( $keyField ),
						array( $idField => $this->oldUser->getId() ),
						__METHOD__,
						array( 'LIMIT' => $limit )
					);
					$keyValues = array();
					foreach ( $res as $row ) {
						$keyValues[] = $row->$keyField;
					}
					// Update only those rows with the given column values
					if ( count( $keyValues ) ) {
						$db->update(
							$tableName,
							array( $idField => $this->newUser->getId() )
								+ array_fill_keys( $fieldInfo, $this->newUser->getName() ),
							array( $idField => $this->oldUser->getId(), $keyField => $keyValues ),
							__METHOD__,
							$options
						);
					}
					$db->commit();
					wfWaitForSlaves( $checkSince, false, '*' );
				} while ( count( $keyValues ) >= $limit );
			}
		}

		$dbw->delete( 'user_newtalk', array( 'user_id' => $this->oldUser->getId() ) );

		Hooks::run( 'MergeAccountFromTo', array( &$this->oldUser, &$this->newUser ) );
	}

	/**
	 * Deduplicate watchlist entries
	 * which old (merge-from) and new (merge-to) users are watching
	 */
	private function deduplicateWatchlistEntries( $dbw ) {
		$this->begin( $dbw );

		$res = $dbw->select(
			array(
				'w1' => 'watchlist',
				'w2' => 'watchlist'
			),
			array(
				'w2.wl_namespace',
				'w2.wl_title'
			),
			array(
				'w1.wl_user' => $this->newUser->getID(),
				'w2.wl_user' => $this->oldUser->getID()
			),
			__METHOD__,
			array( 'FOR UPDATE' ),
			array(
				'w2' => array(
					'INNER JOIN',
					array(
						'w1.wl_namespace = w2.wl_namespace',
						'w1.wl_title = w2.wl_title'
					),
				)
			)
		);

		# Construct an array to delete all watched pages of the old user
		# which the new user already watches
		$conds = array();

		foreach ( $res as $result ) {
			$conds[] = $dbw->makeList(
				array(
					'wl_user' => $this->oldUser->getID(),
					'wl_namespace' => $result->wl_namespace,
					'wl_title' => $result->wl_title
				),
				LIST_AND
			);
		}

		if ( count( $conds ) ) {
			# Perform a multi-row delete
			$dbw->delete(
				'watchlist',
				$dbw->makeList( $conds, LIST_OR ),
				__METHOD__
			);
		}

		$this->commit( $dbw );
	}

	/**
	 * Function to merge user pages
	 *
	 * Deletes all pages when merging to Anon
	 * Moves user page when the target user page does not exist or is empty
	 * Deletes redirect if nothing links to old page
	 * Deletes the old user page when the target user page exists
	 *
	 * @todo This code is a duplicate of Renameuser and GlobalRename
	 *
	 * @param User $performer
	 * @param callable $msg Function that returns a Message object
	 * @return array Array of old name (string) => new name (Title) where the move failed
	 */
	private function movePages( User $performer, /* callable */ $msg ) {
		global $wgContLang, $wgUser;

		$oldusername = trim( str_replace( '_', ' ', $this->oldUser->getName() ) );
		$oldusername = Title::makeTitle( NS_USER, $oldusername );
		$newusername = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $this->newUser->getName() ) );

		# select all user pages and sub-pages
		$dbr = wfGetDB( DB_SLAVE );
		$pages = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => array( NS_USER, NS_USER_TALK ),
				'page_title' . $dbr->buildLike( $oldusername->getDBkey() . '/', $dbr->anyString() )
					. ' OR page_title = ' . $dbr->addQuotes( $oldusername->getDBkey() ),
			)
		);

		$message = function( /* ... */ ) use ( $msg ) {
			return call_user_func_array( $msg, func_get_args() );
		};

		// Need to set $wgUser to attribute log properly.
		$oldUser = $wgUser;
		$wgUser = $performer;

		$failedMoves = array();
		foreach ( $pages as $row ) {

			$oldPage = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
			$newPage = Title::makeTitleSafe( $row->page_namespace,
				preg_replace( '!^[^/]+!', $newusername->getDBkey(), $row->page_title ) );

			if ( $this->newUser->getName() === "Anonymous" ) { # delete ALL old pages
				if ( $oldPage->exists() ) {
					$oldPageArticle = new Article( $oldPage, 0 );
					$oldPageArticle->doDeleteArticle(
						$message( 'usermerge-autopagedelete' )->inContentLanguage()->text()
					);
				}
			} elseif ( $newPage->exists()
				&& !$oldPage->isValidMoveTarget( $newPage )
				&& $newPage->getLength() > 0 ) { # delete old pages that can't be moved

				$oldPageArticle = new Article( $oldPage, 0 );
				$oldPageArticle->doDeleteArticle(
					$message( 'usermerge-autopagedelete' )->inContentLanguage()->text()
				);

			} else { # move content to new page
				# delete target page if it exists and is blank
				if ( $newPage->exists() ) {
					$newPageArticle = new Article( $newPage, 0 );
					$newPageArticle->doDeleteArticle(
						$message( 'usermerge-autopagedelete' )->inContentLanguage()->text()
					);
				}

				# move to target location
				$errors = $oldPage->moveTo(
					$newPage,
					false,
					$message(
						'usermerge-move-log',
						$oldusername->getText(),
						$newusername->getText() )->inContentLanguage()->text()
				);
				if ( $errors !== true ) {
					$failedMoves[$oldPage->getPrefixedText()] = $newPage;
				}

				# check if any pages link here
				$res = $dbr->selectField( 'pagelinks',
					'pl_title',
					array( 'pl_title' => $this->oldUser->getName() ),
					__METHOD__
				);
				if ( !$dbr->numRows( $res ) ) {
					# nothing links here, so delete unmoved page/redirect
					$oldPageArticle = new Article( $oldPage, 0 );
					$oldPageArticle->doDeleteArticle(
						$message( 'usermerge-autopagedelete' )->inContentLanguage()->text()
					);
				}
			}
		}

		$wgUser = $oldUser;

		return $failedMoves;
	}


	/**
	 * Function to delete users following a successful mergeUser call.
	 *
	 * Removes rows from the user, user_groups, user_properties
	 * and user_former_groups tables.
	 */
	private function deleteUser() {
		$dbw = wfGetDB( DB_MASTER );

		/**
		 * Format is: table => user_id column
		 *
		 * If you want it to use a different db object:
		 * table => array( user_id colum, 'db' => DatabaseBase );
		 */
		$tablesToDelete = array(
			'user_groups' => 'ug_user',
			'user_properties' => 'up_user',
			'user_former_groups' => 'ufg_user',
		);

		Hooks::run( 'UserMergeAccountDeleteTables', array( &$tablesToDelete ) );

		$tablesToDelete['user'] = 'user_id'; // Make sure this always set and last

		foreach ( $tablesToDelete as $table => $field ) {
			// Check if a different database object was passed (Echo or Flow)
			if ( is_array( $field ) ) {
				$db = isset( $field['db'] ) ? $field['db'] : $dbw;
				$field = $field[0];
			} else {
				$db = $dbw;
			}
			$db->delete(
				$table,
				array( $field => $this->oldUser->getId() )
			);
		}

		Hooks::run( 'DeleteAccount', array( &$this->oldUser ) );

		DeferredUpdates::addUpdate( SiteStatsUpdate::factory( array( 'users' => -1 ) ) );
	}

	private function begin( $dbw ) {
		if ( $this->flags & self::USE_MULTI_COMMIT ) {
			$dbw->begin( __METHOD__ );
		}
	}

	private function commit( $dbw ) {
		if ( $this->flags & self::USE_MULTI_COMMIT ) {
			$dbw->commit( __METHOD__ );
		}
	}
}
