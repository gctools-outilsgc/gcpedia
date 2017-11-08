<?php
/**
 * OAuth2Client.php
 * Based on TwitterLogin by David Raison, which is based on the guideline published by Dave Challis at http://blogs.ecs.soton.ac.uk/webteam/2010/04/13/254/
 * @license: LGPL (GNU Lesser General Public License) http://www.gnu.org/licenses/lgpl.html
 *
 * @file OAuth2Client.php
 * @ingroup OAuth2Client
 *
 * @author Joost de Keijzer
 * @author Nischay Nahata for Schine GmbH
 *
 * Uses the OAuth2 library https://github.com/thephpleague/oauth2-client
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is a MediaWiki extension, and must be run from within MediaWiki.' );
}
class OAuth2ClientHooks {
	public static function onPersonalUrls( array &$personal_urls, Title $title ) {

		global $wgOAuth2Client, $wgUser, $wgRequest;
		if( $wgUser->isLoggedIn() ) return true;


		# Due to bug 32276, if a user does not have read permissions,
		# $this->getTitle() will just give Special:Badtitle, which is
		# not especially useful as a returnto parameter. Use the title
		# from the request instead, if there was one.
		# see SkinTemplate->buildPersonalUrls()
		$page = Title::newFromURL( $wgRequest->getVal( 'title', '' ) );

		$service_name = isset( $wgOAuth2Client['configuration']['service_name'] ) && 0 < strlen( $wgOAuth2Client['configuration']['service_name'] ) ? $wgOAuth2Client['configuration']['service_name'] : 'OAuth2';
		if( isset( $wgOAuth2Client['configuration']['service_login_link_text'] ) && 0 < strlen( $wgOAuth2Client['configuration']['service_login_link_text'] ) ) {
			$service_login_link_text = $wgOAuth2Client['configuration']['service_login_link_text'];
		} else {
			$service_login_link_text = wfMessage('oauth2client-header-link-text', $service_name)->text();
		}

		$inExt = ( null == $page || ('OAuth2Client' == substr( $page->getText(), 0, 12) ) || strstr($page->getText(), 'Logout') );
		$personal_urls['anon_oauth_login'] = array(
			'text' => $service_login_link_text,
			//'class' => ,
			'active' => false,
		);
		if( $inExt ) {
			$personal_urls['anon_oauth_login']['href'] = Skin::makeSpecialUrlSubpage( 'OAuth2Client', 'redirect' );
		} else {
			# Due to bug 32276, if a user does not have read permissions,
			# $this->getTitle() will just give Special:Badtitle, which is
			# not especially useful as a returnto parameter. Use the title
			# from the request instead, if there was one.
			# see SkinTemplate->buildPersonalUrls()
			$personal_urls['anon_oauth_login']['href'] = Skin::makeSpecialUrlSubpage(
				'OAuth2Client',
				'redirect',
				wfArrayToCGI( array( 'returnto' => $page ) )
			);
		}

		if( isset( $personal_urls['anonlogin'] ) ) {
			if( $inExt ) {
				$personal_urls['anonlogin']['href'] = Skin::makeSpecialUrl( 'Userlogin' );
			}
		}
		return true;
	}

}
