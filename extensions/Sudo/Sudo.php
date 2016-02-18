<?php
/**
 * Sudo
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Friesen (http://danf.ca/mw/)
 * @license https://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link https://www.mediawiki.org/wiki/Extension:Sudo Documentation
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Sudo',
	'version' => '0.3.0',
	'author' => '[http://danf.ca/mw/ Daniel Friesen]',
	'descriptionmsg' => 'sudo-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Sudo',
	'license-name' => 'GPL-2.0+',
);

// Set up i18n and the new special page
$dir = dirname( __FILE__ ) . '/';
$wgMessagesDirs['Sudo'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['Sudo'] = $dir . 'Sudo.i18n.php';
$wgExtensionMessagesFiles['SudoAlias'] = $dir . 'Sudo.alias.php';
$wgAutoloadClasses['SpecialSudo'] = $dir . 'SpecialSudo.php';
$wgSpecialPages['Sudo']           = 'SpecialSudo';

// New user right, required to use Special:Sudo
$wgAvailableRights[] = 'sudo';

// New log type, all sudo actions are logged to this log (Special:Log/sudo)
$wgLogTypes[] = 'sudo';
$wgLogNames['sudo'] = 'sudo-logpagename';
$wgLogHeaders['sudo'] = 'sudo-logpagetext';
$wgLogActions['sudo/sudo'] = 'sudo-logentry';

// Hooked functions
$wgHooks['UserLogoutComplete'][] = 'wfSudoLogout';
$wgHooks['PersonalUrls'][] = 'wfSudoPersonalUrls';

function wfSudoLogout( &$user, &$inject_html ) {
	// Unset wsSudoId when we logout.
	// We don't want to be in a sudo login while logged out.
	unset( $_SESSION['wsSudoId'] );
	return true;
}

function wfSudoPersonalUrls( &$personal_urls, &$title ) {
	// Replace logout link with a unsudo link while in a sudo login.
	if( isset( $_SESSION['wsSudoId'] ) && $_SESSION['wsSudoId'] > 0 ) {
		$personal_urls['logout'] = array(
			'text' => wfMsg( 'sudo-personal-unsudo' ),
			'href' => Skin::makeSpecialUrl( 'Sudo', 'mode=unsudo' ),
			'active' => false
		);
	}
	return true;
}
