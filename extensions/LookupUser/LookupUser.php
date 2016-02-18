<?php
/**
 * Extension to to retrieve information about a user such as email address and ID.
 *
 * @file
 * @ingroup Extensions
 * @author Tim Starling
 * @copyright © 2006 Tim Starling
 * @licence GNU General Public Licence
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Lookup User',
	'version' => '1.3.1',
	'author' => 'Tim Starling',
	'url' => 'https://www.mediawiki.org/wiki/Extension:LookupUser',
	'descriptionmsg' => 'lookupuser-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgMessagesDirs['LookupUser'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['LookupUser'] = $dir . 'LookupUser.i18n.php';
$wgExtensionMessagesFiles['LookupUserAlias'] = $dir . 'LookupUser.alias.php';
$wgAutoloadClasses['LookupUserPage'] = $dir . 'LookupUser.body.php';
$wgSpecialPages['LookupUser'] = 'LookupUserPage';

// New user right, required to use the special page
$wgAvailableRights[] = 'lookupuser';

// Hooked function
$wgHooks['ContributionsToolLinks'][] = 'efLoadLookupUserLink';

/**
 * Add a link to Special:LookupUser from Special:Contributions/USERNAME
 * if the user has 'lookupuser' permission
 * @return true
 */
function efLoadLookupUserLink( $id, $nt, &$links ) {
	global $wgUser;
	if( $wgUser->isAllowed( 'lookupuser' ) && !User::isIP( $nt->getText() ) ) {
		$links[] = Linker::linkKnown(
			SpecialPage::getTitleFor( 'LookupUser' ),
			wfMsgHtml( 'lookupuser' ),
			array(),
			array( 'target' => $nt->getText() )
		);
	}
	return true;
}
