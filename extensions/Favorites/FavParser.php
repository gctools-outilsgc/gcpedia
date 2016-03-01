<?php



class FavParser {
	private $mTitle;
	
	function wfSpecialFavoritelist($argv, $parser) {

		$output = '';
		
		$specialTitle = SpecialPage::getTitleFor( 'Favoritelist' );
		$this->mTitle = $parser->getTitle();
		
		if ($this->mTitle->getNamespace() == NS_USER && array_key_exists('userpage', $argv) && $argv['userpage']) {
			$parts = explode( '/', $this->mTitle->getText() );
			$rootPart = $parts[0];
			$user = User::newFromName( $rootPart, true /* don't allow IP users*/ );
			//echo "Userpage: $user";
			$output = $this->viewFavList($user, $output);
			
			$output .= $this->editlink($argv);
			return $output ;
		} else {
			$user = $parser->getUser();
		}
		
		# Anons don't get a favoritelist
		if( $user->isAnon() ) {
			$llink = Linker::linkKnown(
				SpecialPage::getTitleFor( 'Userlogin' ), 
				wfMsg( 'loginreqlink' ),
				array(),
				array( 'returnto' => $specialTitle->getPrefixedText() )
			);
			$output = wfMsgHtml( 'favoritelistanontext', $llink ) ;
			return $output ;
			
		}
	
		$output = $this->viewFavList($user, $output);
		$output .= $this->editlink($argv);
		
		return $output ;
	}

	
	private function viewFavList ($user, $output) {
		$output = $this->showNormalForm( $output, $user );

		return $output;
	}

	/**
	 * Does the user want to display an editlink?
	 *
	 * @param $argv Array of values from the parser
	 * @return Output
	 */
	private function editlink($argv) {
		$output='';
		if ( array_key_exists('editlink', $argv) && $argv['editlink']) {
			# Add an edit link if you want it:
			$output = "<div id='contentSub'><br>" . 
				Linker::link(
					SpecialPage::getTitleFor( 'Favoritelist', 'edit' ),
					wfMessage( "favoritelisttools-edit" )->escaped(),
					array(),
					array(),
					array( 'known', 'noclasses' )
				) . "</div>";
		}
		return $output;
	}
	

	


	/**
	 * Count the number of titles on a user's favoritelist, excluding talk pages
	 *
	 * @param $user User
	 * @return int
	 */
	private function countFavoritelist( $user ) {
		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select( 'favoritelist', 'COUNT(fl_user) AS count', array( 'fl_user' => $user->getId() ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		return ceil( $row->count); 
	}


	/**
	 * Get a list of titles on a user's favoritelist, excluding talk pages,
	 * and return as a two-dimensional array with namespace, title and
	 * redirect status
	 *
	 * @param $user User
	 * @return array
	 */
	private function getFavoritelistInfo( $user ) {
		$titles = array();
		$dbr = wfGetDB( DB_MASTER );
		$uid = intval( $user->getId() );
		list( $favoritelist, $page ) = $dbr->tableNamesN( 'favoritelist', 'page' );
		$sql = "SELECT fl_namespace, fl_title, page_id, page_len, page_is_redirect
			FROM {$favoritelist} LEFT JOIN {$page} ON ( fl_namespace = page_namespace
			AND fl_title = page_title ) WHERE fl_user = {$uid}";
		$res = $dbr->query( $sql, __METHOD__ );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$cache = LinkCache::singleton();
			while( $row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitleSafe( $row->fl_namespace, $row->fl_title );
				if( $title instanceof Title ) {
					// Update the link cache while we're at it
					if( $row->page_id ) {
						$cache->addGoodLinkObj( $row->page_id, $title, $row->page_len, $row->page_is_redirect );
					} else {
						$cache->addBadLinkObj( $title );
					}
					// Ignore non-talk
					if( !$title->isTalkPage() )
						$titles[$row->fl_namespace][$row->fl_title] = $row->page_is_redirect;
				}
			}
		}
		return $titles;
	}


	/**
	 * Show the standard favoritelist 
	 *
	 * @param $output OutputPage
	 * @param $user User
	 */
	private function showNormalForm( $output, $user ) {

		if ( $this->countFavoritelist($user ) > 0 ) {
			$form = $this->buildRemoveList( $user );
			$output .=  $form ;
			return $output;
		} else {
			$output = wfmsg('nofavoritelist');
			return $output;
		}
	}

	/**
	 * Build part of the standard favoritelist 
	 *
	 * @param $user User
	 */
	private function buildRemoveList( $user ) {
		$list = "";
		$list .= "<ul>\n";
		foreach( $this->getFavoritelistInfo( $user ) as $namespace => $pages ) {
			foreach( $pages as $dbkey => $redirect ) {
				$title = Title::makeTitleSafe( $namespace, $dbkey );
				$list .= $this->buildRemoveLine( $title, $redirect );
			}
		}
		$list .= "</ul>\n";
		return $list;
	}



	/**
	 * Build a single list item containing a link 
	 *
	 * @param $title Title
	 * @param $redirect bool
	 * @return string
	 */
	private function buildRemoveLine( $title, $redirect ) {

		$link = Linker::link( $title );
		if( $redirect )
			$link = '<span class="favoritelistredir">' . $link . '</span>';

		return "<li>" . $link . "</li>\n";
		}

}