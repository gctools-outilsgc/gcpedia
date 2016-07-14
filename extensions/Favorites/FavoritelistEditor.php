<?php

/**
 * Provides the UI through which users can perform editing
 * operations on their favoritelist
 *
 * @ingroup favoritelist
 */
class FavoritelistEditor {

	/**
	 * Editing modes
	 */
	const EDIT_CLEAR = 1;
	const EDIT_RAW = 2;
	const EDIT_NORMAL = 3;

	/**
	 * Main execution point
	 *
	 * @param $user User
	 * @param $output OutputPage
	 * @param $request WebRequest
	 * @param $mode int
	 */
	public function execute( $user, $output, $request, $mode ) {
		
		if( wfReadOnly() ) {
			$output->readOnlyPage();
			return;
		}
		switch( $mode ) {
			case self::EDIT_CLEAR:
				// The "Clear" link scared people too much.
				// Pass on to the raw editor, from which it's very easy to clear.
			case self::EDIT_RAW:
				$output->setPageTitle( wfMessage( 'favoritelistedit-raw-title' ) );
				if( $request->wasPosted() && $this->checkToken( $request, $user ) ) {
					$wanted = $this->extractTitles( $request->getText( 'titles' ) );
					$current = $this->getFavoritelist( $user );
					if( count( $wanted ) > 0 ) {
						$toFavorite = array_diff( $wanted, $current );
						$toUnfavorite = array_diff( $current, $wanted );
						$this->favoriteTitles( $toFavorite, $user );
						$this->unfavoriteTitles( $toUnfavorite, $user );
						$user->invalidateCache();
						if( count( $toFavorite ) > 0 || count( $toUnfavorite ) > 0 )
							$output->addHTML( wfMessage( 'favoritelistedit-raw-done' )->parse() );
						if( ( $count = count( $toFavorite ) ) > 0 ) {
							$output->addHTML( wfMessage( 'favoritelistedit-raw-added', $count )->parse() );
							$this->showTitles( $toFavorite, $output, $user->getSkin() );
						}
						if( ( $count = count( $toUnfavorite ) ) > 0 ) {
							$output->addHTML( wfMessage( 'favoritelistedit-raw-removed', $count )->parse() );
							$this->showTitles( $toUnfavorite, $output, $user->getSkin() );
						}
					} else {
						$this->clearFavoritelist( $user );
						$user->invalidateCache();
						$output->addHTML( wfMessage( 'favoritelistedit-raw-removed', count( $current ) )->parse() );
						$this->showTitles( $current, $output, $user->getSkin() );
					}
				}
				$this->showRawForm( $output, $user );
				break;
			case self::EDIT_NORMAL:
				$output->setPageTitle( wfMessage( 'favoritelistedit-normal-title' ) );
				if( $request->wasPosted() && $this->checkToken( $request, $user ) ) {
					$titles = $this->extractTitles( $request->getArray( 'titles' ) );
					$this->unfavoriteTitles( $titles, $user );
					$user->invalidateCache();
					$output->addHTML( wfMessage( 'favoritelistedit-normal-done',
						$GLOBALS['wgLang']->formatNum( count( $titles ) ) )->parse() );
					$this->showTitles( $titles, $output, $user->getSkin() );
				}
				$this->showNormalForm( $output, $user );
		}
	}

	/**
	 * Check the edit token from a form submission
	 *
	 * @param $request WebRequest
	 * @param $user User
	 * @return bool
	 */
	private function checkToken( $request, $user ) {
		return $user->matchEditToken( $request->getVal( 'token' ), 'favoritelistedit' );
	}

	/**
	 * Extract a list of titles from a blob of text, returning
	 * (prefixed) strings; unfavoritable titles are ignored
	 *
	 * @param $list mixed
	 * @return array
	 */
	private function extractTitles( $list ) {
		$titles = array();
		if( !is_array( $list ) ) {
			$list = explode( "\n", trim( $list ) );
			if( !is_array( $list ) )
				return array();
		}
		foreach( $list as $text ) {
			$text = trim( $text );
			if( strlen( $text ) > 0 ) {
				$title = Title::newFromText( $text );
				//if( $title instanceof Title && $title->isFavoritable() )
					$titles[] = $title->getPrefixedText();
			}
		}
		return array_unique( $titles );
	}

	/**
	 * Print out a list of linked titles
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $output OutputPage
	 */
	private function showTitles( $titles, $output ) {
		$talk = wfMessage( 'talkpagelinktext' )->text();
		// Do a batch existence check
		$batch = new LinkBatch();
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$batch->addObj( $title );
				//$batch->addObj( $title->getTalkPage() );
			}
		}
		$batch->execute();
		// Print out the list
		$output->addHTML( "<ul>\n" );
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$output->addHTML( "<li>" . Linker::link( $title ) . "</li>\n" );
			}
		}
		$output->addHTML( "</ul>\n" );
	}

	/**
	 * Count the number of titles on a user's favoritelist
	 *
	 * @param $user User
	 * @return int
	 */
	private function countFavoritelist( $user ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'favoritelist', 'COUNT(*) AS count', array( 'fl_user' => $user->getId() ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return ceil( $row->count); 
	}

	/**
	 * Prepare a list of titles on a user's favoritelist
	 * and return an array of (prefixed) strings
	 *
	 * @param $user User
	 * @return array
	 */
	private function getFavoritelist( $user ) {
		$list = array();
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			'favoritelist',
			'*',
			array(
				'fl_user' => $user->getId(),
			),
			__METHOD__
		);
		if( $res->numRows() > 0 ) {
			while( $row = $res->fetchObject() ) {
				$title = Title::makeTitleSafe( $row->fl_namespace, $row->fl_title );
				if( $title instanceof Title && !$title->isTalkPage() )
					$list[] = $title->getPrefixedText();
			}
			$res->free();
		}
		return $list;
	}

	/**
	 * Get a list of titles on a user's favoritelist,
	 * and return as a two-dimensional array with namespace, title and
	 * redirect status
	 *
	 * GCchange - Ilia: To prevent minute + long page table locks when users with 100+ favorites view or edit them 
	 *
	 * @param $user User
	 * @return array
	 */
	private function getFavoritelistInfo( $user ) {
		$titles = array();
		$dbr = wfGetDB( DB_MASTER );
		$uid = intval( $user->getId() );
		/*list( $favoritelist, $page ) = $dbr->tableNamesN( 'favoritelist', 'page' );
		$sql = "SELECT fl_namespace, fl_title, page_id, page_len, page_is_redirect
			FROM {$favoritelist} LEFT JOIN {$page} ON ( fl_namespace = page_namespace
			AND fl_title = page_title ) WHERE fl_user = {$uid}";
		$res = $dbr->query( $sql, __METHOD__ );*/
		$res = $dbr->select(
			array( 'favoritelist' ),
			array( 'fl_namespace', 'fl_title' ),
			array( 'fl_user' => $uid ),
			__METHOD__,
			array( 'ORDER BY' => array( 'fl_namespace', 'fl_title' ) )
		);
		if( $res && $dbr->numRows( $res ) > 0 ) {
			//$cache = LinkCache::singleton();
			while( $row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitleSafe( $row->fl_namespace, $row->fl_title );
				if( $title instanceof Title ) {
					// Update the link cache while we're at it
					/*if( $row->page_id ) {
						$cache->addGoodLinkObj( $row->page_id, $title, $row->page_len, $row->page_is_redirect );
					} else {
						$cache->addBadLinkObj( $title );
					}*/
					// Ignore non-talk
					//if( !$title->isTalkPage() )
						$titles[$row->fl_namespace][$row->fl_title] = 0;//$row->page_is_redirect;
				}
			}
		}
		return $titles;
	}

	/**
	 * Show a message indicating the number of items on the user's favoritelist,
	 * and return this count for additional checking
	 *
	 * @param $output OutputPage
	 * @param $user User
	 * @return int
	 */
	private function showItemCount( $output, $user ) {
		if( ( $count = $this->countFavoritelist( $user ) ) > 0 ) {
			$output->addHTML( wfMessage( 'favoritelistedit-numitems',
				$GLOBALS['wgLang']->formatNum( $count ) )->parse() );
		} else {
			$output->addHTML( wfMessage( 'favoritelistedit-noitems' )->parse() );
		}
		return $count;
	}

	/**
	 * Remove all titles from a user's favoritelist
	 *
	 * @param $user User
	 */
	private function clearFavoritelist( $user ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'favoritelist', array( 'fl_user' => $user->getId() ), __METHOD__ );
	}

	/**
	 * Add a list of titles to a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $user User
	 */
	private function favoriteTitles( $titles, $user ) {
		$dbw = wfGetDB( DB_MASTER );
		$rows = array();
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$rows[] = array(
					'fl_user' => $user->getId(),
					'fl_namespace' => ( $title->getNamespace() | 1 ),
					'fl_title' => $title->getDBkey(),
					'fl_notificationtimestamp' => null,
				);
			}
		}
		$dbw->insert( 'favoritelist', $rows, __METHOD__, 'IGNORE' );
	}

	/**
	 * Remove a list of titles from a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An array of strings, or Title objects
	 * @param $user User
	 */
	private function unfavoriteTitles( $titles, $user ) {
		$dbw = wfGetDB( DB_MASTER );
		foreach( $titles as $title ) {
			if( !$title instanceof Title )
				$title = Title::newFromText( $title );
			if( $title instanceof Title ) {
				$dbw->delete(
					'favoritelist',
					array(
						'fl_user' => $user->getId(),
						'fl_namespace' => ( $title->getNamespace() ),
						'fl_title' => $title->getDBkey(),
					)
				) ;
				$article = new Article($title);
				Hooks::run('UnfavoriteArticleComplete',array(&$user,&$article));
			}
		}
	}

	/**
	 * Show the standard favoritelist editing form
	 *
	 * @param $output OutputPage
	 * @param $user User
	 */
	private function showNormalForm( $output, $user ) {
		
		if( ( $count = $this->showItemCount( $output, $user ) ) > 0 ) {
			$self = SpecialPage::getTitleFor( 'Favoritelist' );
			$form  = Xml::openElement( 'form', array( 'method' => 'post',
				'action' => $self->getLocalUrl( array( 'action' => 'edit' ) ) ) );
			$form .= Html::hidden( 'token', $user->editToken( 'favoritelistedit' ) );
			$form .= "<fieldset>\n<legend>" . wfMessage( 'favoritelistedit-normal-legend' )->text() . "</legend>";
			$form .= wfMessage( 'favoritelistedit-normal-explain' )->parse();
			$form .= $this->buildRemoveList( $user, $user->getSkin() );
			$form .= '<p>' . Xml::submitButton( wfMessage( 'favoritelistedit-normal-submit' ) ) . '</p>';
			$form .= '</fieldset></form>';
			$output->addHTML( $form );
		}
	}

	/**
	 * Build the part of the standard favoritelist editing form with the actual
	 * title selection checkboxes and stuff.  Also generates a table of
	 * contents if there's more than one heading.
	 *
	 * @param $user User
	 */
	private function buildRemoveList( $user ) {
		$list = "";
		$toc = Linker::tocIndent();
		$tocLength = 0;
		foreach( $this->getFavoritelistInfo( $user ) as $namespace => $pages ) {
			$tocLength++;
			$heading = htmlspecialchars( $this->getNamespaceHeading( $namespace ) );
			$anchor = "editfavoritelist-ns" . $namespace;

			$list .= Linker::makeHeadLine( 2, ">", $anchor, $heading, "" );
			$toc .= Linker::tocLine( $anchor, $heading, $tocLength, 1 ) . Linker::tocLineEnd();

			$list .= "\n";
			foreach( $pages as $dbkey => $redirect ) {
				$title = Title::makeTitleSafe( $namespace, $dbkey );
				$list .= $this->buildRemoveLine( $title, $redirect );
			}
			$list .= "\n";
		}
		// ISSUE: omit the TOC if the total number of titles is low?
		if( $tocLength > 1 ) {
			$list = Linker::tocList( $toc ) . $list;
		}
		return $list;
	}

	/**
	 * Get the correct "heading" for a namespace
	 *
	 * @param $namespace int
	 * @return string
	 */
	private function getNamespaceHeading( $namespace ) {
		return $namespace == NS_MAIN
			? wfMessage( 'blanknamespace' )->text()
			: htmlspecialchars( $GLOBALS['wgContLang']->getFormattedNsText( $namespace ) );
	}

	/**
	 * Build a single list item containing a check box selecting a title
	 * and a link to that title, with various additional bits
	 *
	 * @param $title Title
	 * @param $redirect bool
	 * @return string
	 */
	private function buildRemoveLine( $title, $redirect ) {
		global $wgLang;
		# In case the user adds something unusual to their list using the raw editor
		# We moved the Tools array completely into the "if( $title->exists() )" section.
		$showlinks=false; 
		$link = Linker::link( $title );
		if( $redirect )
			$link = '<span class="favoritelistredir">' . $link . '</span>';
		if( $title->exists() ) {
			$showlinks = true;
			//$tools[] = Linker::link( $title->getTalkPage(), wfMessage( 'talkpagelinktext' )->text() );
			$tools[] = Linker::link(
				$title,
				wfMessage( 'history_short' )->text(),
				array(),
				array( 'action' => 'history' ),
				array( 'known', 'noclasses' )
			);
		}
		if( $title->getNamespace() == NS_USER && !$title->isSubpage() ) {
			$tools[] = Linker::link(
				SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
				wfMessage( 'contributions' )->text(),
				array(),
				array(),
				array( 'known', 'noclasses' )
			);
		}
		
		if ($showlinks) {
		return 
			Xml::check( 'titles[]', false, array( 'value' => $title->getPrefixedText() ) )
			. $link . " (" . $wgLang->pipeList( $tools ) . ")" . "\n<br>";
		} else {
			return 
			Xml::check( 'titles[]', false, array( 'value' => $title->getPrefixedText() ) ) 
			. $link . "\n<br>";
		}
		
		}

	/**
	 * Show a form for editing the favoritelist in "raw" mode
	 *
	 * @param $output OutputPage
	 * @param $user User
	 */
	public function showRawForm( $output, $user ) {
		
		$this->showItemCount( $output, $user );
		$self = SpecialPage::getTitleFor( 'Favoritelist' );
		$form  = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $self->getLocalUrl( array( 'action' => 'raw' ) ) ) );
		$form .= Html::hidden( 'token', $user->editToken( 'favoritelistedit' ) );
		$form .= '<fieldset><legend>' . wfMessage( 'favoritelistedit-raw-legend' )->text() . '</legend>';
		$form .= wfMessage( 'favoritelistedit-raw-explain' )->parse();
		$form .= Xml::label( wfMessage( 'favoritelistedit-raw-titles' ), 'titles' );
		$form .= "<br />\n";
		$form .= Xml::openElement( 'textarea', array( 'id' => 'titles', 'name' => 'titles',
			'rows' => $user->getIntOption( 'rows' ), 'cols' => $user->getIntOption( 'cols' ) ) );
		$titles = $this->getFavoritelist( $user );
		foreach( $titles as $title )
			$form .= htmlspecialchars( $title ) . "\n";
		$form .= '</textarea>';
		$form .= '<p>' . Xml::submitButton( wfMessage( 'favoritelistedit-raw-submit' ) ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	/**
	 * Determine whether we are editing the favoritelist, and if so, what
	 * kind of editing operation
	 *
	 * @param $request WebRequest
	 * @param $par mixed
	 * @return int
	 */
	public static function getMode( $request, $par ) {
		$mode = strtolower( $request->getVal( 'action', $par ) );
		switch( $mode ) {
			case 'clear':
				return self::EDIT_CLEAR;
			case 'raw':
				return self::EDIT_RAW;
			case 'edit':
				return self::EDIT_NORMAL;
			default:
				return false;
		}
	}

	/**
	 * Build a set of links for convenient navigation
	 * between favoritelist viewing and editing modes
	 *
	 * @return string
	 */
	public static function buildTools( ) {
		global $wgLang;

		$tools = array();
		$modes = array( 'view' => false, 'edit' => 'edit', 'raw' => 'raw' );
		foreach( $modes as $mode => $subpage ) {
			// can use messages 'favoritelisttools-view', 'favoritelisttools-edit', 'favoritelisttools-raw'
			$tools[] = Linker::link(
				SpecialPage::getTitleFor( 'Favoritelist', $subpage ),
				wfMessage( "favoritelisttools-{$mode}" )->text(),
				array(),
				array(),
				array( 'known', 'noclasses' )
			);
		}
		return $wgLang->pipeList( $tools );
	}
}
