<?php
/**
* EditUser extension by Ryan Schmidt
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension to the MediaWiki software and is not a valid access point";
	die( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'EditUser',
	'namemsg'        => 'extensionname-edituser',
	'version'        => '1.8.0',
	'author'         => 'Ryan Schmidt',
	'descriptionmsg' => 'edituser-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:EditUser',
);

// Internationlization files
$wgMessagesDirs['EditUser'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['EditUserAliases'] = __DIR__ . '/EditUser.alias.php';

// Special page classes
$wgAutoloadClasses['EditUser'] = __DIR__ . '/EditUser_body.php';
$wgAutoloadClasses['EditUserPreferencesForm'] = __DIR__ . '/EditUserPreferencesForm.php';
$wgSpecialPages['EditUser'] = 'EditUser';

// Default group permissions
$wgAvailableRights[] = 'edituser';
$wgAvailableRights[] = 'edituser-exempt';
$wgGroupPermissions['bureaucrat']['edituser'] = true;
$wgGroupPermissions['sysop']['edituser-exempt'] = true;
