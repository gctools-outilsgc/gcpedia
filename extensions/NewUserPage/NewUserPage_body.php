<?php
/** \file
* \brief Contains code for the PasswordReset Class (extends SpecialPage).
*/

///Special page class for the Password Reset extension
/**
 * Special page that allows sysops to reset local MW user's
 * passwords
 *
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
class NewUserPage extends SpecialPage {
	function __construct() {
		
		parent::__construct( "NewUserPage", "newuserpage" );
	}

	function execute( $par ) {
		global $wgHooks, $wgMessageCache,$wgNewUserDefaultPageTemplate, $wgRequest, $wgOut, $wgUser;
		$defaultPagetemplate = "NewUserPage";
		$wgNewPageTemplate = "MediaWiki:$defaultPagetemplate";

		$this->setHeaders();

	}

	function UserLoginComplete($user) {
			global $wgNewPageTemplate;
			global $wgOut, $wgUser, $out;
			$userPage = $user->getUserPage();

			if (!$user->isAnon()&&$userPage&&!$userPage->exists()) {
					$article = new Article($userPage);
					$summary = "New user page automatic creation.";
					
					$text = wfMsg('userpage');	

					$flags = EDIT_NEW | EDIT_DEFER_UPDATES | EDIT_AUTOSUMMARY;
					$article->doEdit( $text, $summary, $flags );

					$dbw = wfGetDB( DB_MASTER );
					if (!$article->mTitle->userIsWatching()) {
							$dbw->begin();
							$article->doWatch();
							$dbw->commit();
					}
					
				$wgOut->redirect( $userPage->getFullURL() );
			}
			return true;
	}
	
}
?>