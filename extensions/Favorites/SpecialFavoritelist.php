<?php
/**
 * @file
 * @ingroup SpecialPage Favoritelist
 */

/**
 * Constructor
 *
 * @param $par Parameter
 *        	passed to the page
 */
class SpecialFavoritelist extends SpecialPage {
	
	function __construct() {
		parent::__construct ( 'Favoritelist' );
	}
	function execute($par) {
		$context = $this->getContext();
		$vwfav = new ViewFavorites ($context);
		
		$this->setHeaders ();
		$param = $this->getRequest()->getText ( 'param' );
		
		$vwfav->wfSpecialFavoritelist ( $par );
	}

	protected function getGroupName() {
		return 'other';
	}
}

class ViewFavorites {
	
	private $context;
	private $user;
	private $out;
	private $request;
	private $lang;
	
	
	function __construct($context) {
		$this->context = $context;
		$this->out = $this->context->getOutput();
		$this->request = $this->context->getRequest();
		$this->lang = $this->context->getLanguage();
		$this->user = $this->context->getUser();
	}
	
	function wfSpecialFavoritelist($par) {
		
		global $wgFeedClasses;
		
		// Add feed links
		$flToken = $this->user->getOption ( 'favoritelisttoken' );
		if (! $flToken) {
			$flToken = sha1 ( mt_rand () . microtime ( true ) );
			$this->user->setOption ( 'favoritelisttoken', $flToken );
			$this->user->saveSettings ();
		}
		
		$apiParams = array (
				'action' => 'feedfavoritelist',
				'allrev' => 'allrev',
				'flowner' => $this->user->getName (),
				'fltoken' => $flToken 
		);
		$feedTemplate = wfScript ( 'api' ) . '?';
		
		foreach ( $wgFeedClasses as $format => $class ) {
			$theseParams = $apiParams + array (
					'feedformat' => $format 
			);
			$url = $feedTemplate . wfArrayToCGI ( $theseParams );
			$this->out->addFeedLink ( $format, $url );
		}
		
		$specialTitle = SpecialPage::getTitleFor ( 'Favoritelist' );
		$this->out->setRobotPolicy ( 'noindex,nofollow' );
		
		// Anons don't get a favoritelist
		if ($this->user->isAnon ()) {
			$this->out->setPageTitle ( wfMessage ( 'favoritenologin' ) );
			$llink = Linker::linkKnown ( SpecialPage::getTitleFor ( 'Userlogin' ), wfMessage ( 'loginreqlink' )->text (), array (), array (
					'returnto' => $specialTitle->getPrefixedText () 
			) );
			$this->out->addHTML ( wfMessage ( 'favoritelistanontext', $llink )->text () );
			return;
		}
		
		$this->out->setPageTitle ( wfMessage ( 'favoritelist' ) );
		
		$sub = wfMessage ( 'favoritelistfor', $this->user->getName () )->parse ();
		$sub .= '<br />' . FavoritelistEditor::buildTools ( $this->user->getSkin () );
		$this->out->setSubtitle ( $sub );
		
		if (($mode = FavoritelistEditor::getMode ( $this->request, $par )) !== false) {
			$editor = new FavoritelistEditor ();
			$editor->execute ( $this->user, $this->out, $this->request, $mode );
			return;
		}
		
		$this->viewFavList ( $this->user, $this->out, $this->request, $mode );
	}
	private function viewFavList($user, $output, $request, $mode) {

		$uid = $this->user->getId ();
		$output->setPageTitle ( wfMessage ( 'favoritelist' ) );
		
		if ($request->wasPosted () && $this->checkToken ( $request, $this->user )) {
			$titles = $this->extractTitles ( $request->getArray ( 'titles' ) );
			$this->unfavoriteTitles ( $titles, $user );
			$user->invalidateCache ();
			$output->addHTML ( wfMessage ( 'favoritelistedit-normal-done', $GLOBALS ['wgLang']->formatNum ( count ( $titles ) ) )->parse () );
			$this->showTitles ( $titles, $output, $this->user->getSkin () );
		}
		$this->showNormalForm ( $output, $user );
		
		$dbr = wfGetDB ( DB_SLAVE, 'favoritelist' );
		// $recentchanges = $dbr->tableName( 'recentchanges' );
		
		$favoritelistCount = $dbr->selectField ( 'favoritelist', 'COUNT(fl_user)', array (
				'fl_user' => $uid 
		), __METHOD__ );
		// Adjust for page X, talk:page X, which are both stored separately,
		// but treated together
		// $nitems = floor($favoritelistCount / 2);
		$nitems = $favoritelistCount;
		if ($nitems == 0) {
			$this->out->addWikiMsg ( 'nofavoritelist' );
			return;
		}
	}
	
	/**
	 * Check the edit token from a form submission
	 *
	 * @param $request WebRequest        	
	 * @param $user User        	
	 * @return bool
	 */
	private function checkToken($request, $user) {
		return $user->matchEditToken ( $request->getVal ( 'token' ), 'favorite' );
	}
	
	/**
	 * Extract a list of titles from a blob of text, returning
	 * (prefixed) strings; unfavoritable titles are ignored
	 *
	 * @param $list mixed        	
	 * @return array
	 */
	private function extractTitles($list) {
		$titles = array ();
		if (! is_array ( $list )) {
			$list = explode ( "\n", trim ( $list ) );
			if (! is_array ( $list ))
				return array ();
		}
		foreach ( $list as $text ) {
			$text = trim ( $text );
			if (strlen ( $text ) > 0) {
				$title = Title::newFromText ( $text );
				// if( $title instanceof Title && $title->isFavoritable() )
				$titles [] = $title->getPrefixedText ();
			}
		}
		return array_unique ( $titles );
	}
	
	/**
	 * Print out a list of linked titles
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An
	 *        	array of strings, or Title objects
	 * @param $output OutputPage        	
	 */
	private function showTitles($titles, $output) {
		$talk = wfMessage ( 'talkpagelinktext' )->text ();
		// Do a batch existence check
		$batch = new LinkBatch ();
		foreach ( $titles as $title ) {
			if (! $title instanceof Title)
				$title = Title::newFromText ( $title );
			// if( $title instanceof Title ) {
			// $batch->addObj( $title );
			// $batch->addObj( $title->getTalkPage() );
			// }
		}
		$batch->execute ();
		// Print out the list
		$output->addHTML ( "<ul>\n" );
		foreach ( $titles as $title ) {
			if (! $title instanceof Title)
				$title = Title::newFromText ( $title );
			if ($title instanceof Title) {
				$output->addHTML ( "<li>" . Linker::link ( $title ) . 
				"</li>\n" );
			}
		}
		$output->addHTML ( "</ul>\n" );
	}
	
	/**
	 * Count the number of titles on a user's favoritelist, excluding talk pages
	 *
	 * @param $user User        	
	 * @return int
	 */
	private function countFavoritelist($user) {
		$dbr = wfGetDB ( DB_MASTER );
		$res = $dbr->select ( 'favoritelist', 'COUNT(fl_user) AS count', array (
				'fl_user' => $user->getId () 
		), __METHOD__ );
		$row = $dbr->fetchObject ( $res );
		return ceil ( $row->count ); // Paranoia
	}
	
	/**
	 * Get a list of titles on a user's favoritelist, excluding talk pages,
	 * and return as a two-dimensional array with namespace, title and
	 * redirect status
	 *
	 * GCchange - Ilia: To prevent minute + long page table locks when users with 100+ favorites view or edit them 
	 *
	 * @param $user User        	
	 * @return array
	 */
	private function getFavoritelistInfo($user) {
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
	 * Remove a list of titles from a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param $titles An
	 *        	array of strings, or Title objects
	 * @param $user User        	
	 */
	private function unfavoriteTitles($titles, $user) {
		$dbw = wfGetDB ( DB_MASTER );
		
		foreach ( $titles as $title ) {
			
			if (! $title instanceof Title)
				$title = Title::newFromText ( $title );
			if ($title instanceof Title) {
				
				$dbw->delete ( 'favoritelist', array (
						'fl_user' => $user->getId (),
						'fl_namespace' => ($title->getNamespace () | 1),
						'fl_title' => $title->getDBkey () 
				), __METHOD__ );
				$article = new Article ( $title );
				Hooks::run ( 'UnfavoriteArticleComplete', array (
						&$user,
						&$article 
				) );
			}
		}
	}
	
	/**
	 * Show the standard favoritelist editing form
	 *
	 * @param $output OutputPage        	
	 * @param $user User        	
	 */
	private function showNormalForm($output, $user) {
		
		if (($count = $this->countFavoritelist ( $user )) > 0) {
			$self = SpecialPage::getTitleFor ( 'Favoritelist' );
			$form = Xml::openElement ( 'form', array (
					'method' => 'post',
					'action' => $self->getLocalUrl ( array (
							'action' => 'edit' 
					) ) 
			) );
			$form .= Html::hidden ( 'token', $this->user->getEditToken ( 'favorite' ) );
			// $form .= "<fieldset>\n<legend>" . wfMsgHtml( 'favoritelistedit-normal-legend' ) . "</legend>";
			// $form .= wfMsgExt( 'favoritelistedit-normal-explain', 'parse' );
			$form .= $this->buildRemoveList ( $user, $this->user->getSkin () );
			// $form .= '<p>' . Xml::submitButton( wfMsg( 'favoritelistedit-normal-submit' ) ) . '</p>';
			$form .= '</fieldset></form>';
			$output->addHTML ( $form );
		}
	}
	
	/**
	 * Build the part of the standard favoritelist editing form with the actual
	 * title selection checkboxes and stuff.
	 * Also generates a table of
	 * contents if there's more than one heading.
	 *
	 * @param $user User        	
	 */
	private function buildRemoveList($user) {
		$list = "";
		$toc = Linker::tocIndent ();
		$tocLength = 0;
		foreach ( $this->getFavoritelistInfo ( $user ) as $namespace => $pages ) {
			$tocLength ++;
			$heading = htmlspecialchars ( $this->getNamespaceHeading ( $namespace ) );
			$anchor = "editfavoritelist-ns" . $namespace;
			
			$list .= Linker::makeHeadLine ( 2, ">", $anchor, $heading, "" );
			$toc .= Linker::tocLine ( $anchor, $heading, $tocLength, 1 ) . Linker::tocLineEnd ();
			
			$list .= "<ul>\n";
			foreach ( $pages as $dbkey => $redirect ) {
				$title = Title::makeTitleSafe ( $namespace, $dbkey );
				$list .= $this->buildRemoveLine ( $title, $redirect );
			}
			$list .= "</ul>\n";
		}
		// ISSUE: omit the TOC if the total number of titles is low?
		if ($tocLength > 10) {
			$list = Linker::tocList ( $toc ) . $list;
		}
		
		return $list;
	}
	
	/**
	 * Get the correct "heading" for a namespace
	 *
	 * @param $namespace int        	
	 * @return string
	 */
	private function getNamespaceHeading($namespace) {
		return $namespace == NS_MAIN ? wfMessage ( 'blanknamespace' )->text () : htmlspecialchars ( $GLOBALS ['wgContLang']->getFormattedNsText ( $namespace ) );
	}
	
	/**
	 * Build a single list item containing a check box selecting a title
	 * and a link to that title, with various additional bits
	 *
	 * @param $title Title        	
	 * @param $redirect bool        	
	 * @return string
	 */
	private function buildRemoveLine($title, $redirect) {
		
		// In case the user adds something unusual to their list using the raw editor
		// We moved the Tools array completely into the "if( $title->exists() )" section.
		$showlinks = false;
		$link = Linker::link ( $title );
		if ($redirect)
			$link = '<span class="favoritelistredir">' . $link . '</span>';
		
		if ($title->exists ()) {
			$showlinks = true;
			$tools [] = Linker::link ( $title->getTalkPage (), wfMessage ( 'talkpagelinktext' )->text () );
			$tools [] = Linker::link ( $title, wfMessage ( 'history_short' )->text (), array (), array (
					'action' => 'history' 
			), array (
					'known',
					'noclasses' 
			) );
		}
		if ($title->getNamespace () == NS_USER && ! $title->isSubpage ()) {
			$tools [] = Linker::link ( SpecialPage::getTitleFor ( 'Contributions', $title->getText () ), wfMessage ( 'contributions' )->text (), array (), array (), array (
					'known',
					'noclasses' 
			) );
		}
		
		if ($showlinks) {
			return "<li>" . $link . " (" . $this->lang->pipeList ( $tools ) . ")" . "</li>\n";
		} else {
			return "<li>" . $link . "</li>\n";
		}
	}
}