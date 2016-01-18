<?php
if ( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Return a list of Editors currently editing the article.
 * Based on an idea by Tim Starling.
 *
 * @author Ashar Voultoiz <hashar@altern.org>
 * @author Tim Starling
 */
class AjaxShowEditorsAPI extends ApiBase {
	/**
	 * Returns an array of allowed parameters (parameter name) => (default
	 * value) or (parameter name) => (array with PARAM_* constants as keys)
	 * Don't call this function directly: use getFinalParams() to allow
	 * hooks to modify parameters as needed.
	 *
	 * Some derived classes may choose to handle an integer $flags parameter
	 * in the overriding methods. Callers of this method can pass zero or
	 * more OR-ed flags like GET_VALUES_FOR_HELP.
	 *
	 * @return array
	 */
	protected function getAllowedParams( /* $flags = 0 */ ) {
		// int $flags is not declared because it causes "Strict standards"
		// warning. Most derived classes do not implement it.
		return array(
			'articleId' => 0,
			'username' => '');
	}
	
	public function execute() {
		// extract request parameters
		$params = $this->extractRequestParams();
		$articleId = $params['articleId'];
		$username = $params['username'];
		
		$articleId = intval( $articleId );

		// Validate request
		$title = Title::newFromID( $articleId );
		if ( !( $title ) ) { $this->getResult()->addValue( null, $this->getModuleName(), wfMsg( 'ajax-se-pagedoesnotexist' ) ); return wfMsg( 'ajax-se-pagedoesnotexist' ); }

		if ( User::idFromName( $username ) === null ) { $this->getResult()->addValue( null, $this->getModuleName(), wfMsg( 'ajax-se-usernotfound' ) ); return wfMsg( 'ajax-se-usernotfound' ); }

		// When did the user started editing ?
		$dbr = wfGetDB( DB_SLAVE );
		$userStarted = $dbr->selectField( 'editings',
			'editings_started',
			array(
				'editings_user' => $username,
				'editings_page' => $title->getArticleID(),
			),
			__METHOD__
		);

		// He just started editing, assume NOW
		if ( !$userStarted ) { $userStarted = $dbr->timestamp(); }

		# Either create a new entry or update the touched timestamp.
		# This is done using a unique index on the database :
		# `editings_page_started` (`editings_page`,`editings_user`,`editings_started`)

		$dbw = wfGetDB( DB_MASTER );
		$dbw->replace( 'editings',
			array( 'editings_page', 'editings_user', 'editings_started' ),
			array(
				'editings_page' => $title->getArticleID() ,
				'editings_user' => $username,
				'editings_started' => $userStarted ,
				'editings_touched' => $dbw->timestamp(),
			), __METHOD__
		);

		// Now we get the list of all watching users
		$dbr = & wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'editings',
			array( 'editings_user', 'editings_started', 'editings_touched' ),
			array( 'editings_page' => $title->getArticleID() ),
			__METHOD__
		);

		$l = class_exists('DummyLinker') ? new DummyLinker : new Linker;

		$wikitext = '';
		$unix_now = wfTimestamp( TS_UNIX );
		$first = 1;
		while ( $editor = $dbr->fetchObject( $res ) ) {

			// Check idling time
			$idle = $unix_now - wfTimestamp( TS_UNIX, $editor->editings_touched );

			global $wgAjaxShowEditorsTimeout ;
			if ( $idle >= $wgAjaxShowEditorsTimeout ) {
				$dbw->delete( 'editings',
					array(
						'editings_page' => $title->getArticleID(),
						'editings_user' => $editor->editings_user,
					),
					__METHOD__
				);
				continue; // we will not show the user
			}

			if ( $first ) { $first = 0; }
			else { $wikitext .= ' ~  '; }

			$since = wfTimestamp( TS_DB, $editor->editings_started );
			$wikitext .= $since;

			$wikitext .= ' ' . $l->makeLinkObj(
					Title::makeTitle( NS_USER, $editor->editings_user ),
					htmlspecialchars( $editor->editings_user )
				);

			$wikitext .= ' ' . wfMsg( 'ajax-se-idling', '<span>' . $idle . '</span>' );
		}
		$this->getResult()->addValue( null, $this->getModuleName(), $wikitext );
		return 1;
	}
}