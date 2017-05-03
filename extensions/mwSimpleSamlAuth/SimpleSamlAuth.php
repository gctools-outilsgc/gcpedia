<?php
/**
 * SimpleSamlAuth - LGPL 3.0 licensed
 * Copyright (C) 2015  Jørn Åne
 *
 * SAML authentication MediaWiki extension using SimpleSamlPhp.
 *
 * @file
 * @ingroup Extensions
 * @defgroup SimpleSamlAuth
 *
 * @link https://www.mediawiki.org/wiki/Extension:SimpleSamlAuth Documentation
 * @link https://www.mediawiki.org/wiki/Extension_talk:SimpleSamlAuth Support
 * @link https://github.com/jornane/mwSimpleSamlAuth Source Code
 *
 * @license http://www.gnu.org/licenses/lgpl.html LGPL (GNU Lesser General Public License)
 * @copyright (C) 2015, Jørn Åne
 * @author Jørn Åne
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is a MediaWiki extension, and must be run from within MediaWiki.\n" );
}

$GLOBALS['wgExtensionMessagesFiles']['SimpleSamlAuth'] =
	__DIR__ . DIRECTORY_SEPARATOR . 'SimpleSamlAuth.i18n.php';
$GLOBALS['wgAutoloadClasses']['SimpleSamlAuth'] =
	__DIR__ . DIRECTORY_SEPARATOR . 'SimpleSamlAuth.class.php';

$GLOBALS['wgExtensionCredits']['other'][] = array(
	'path' => __FILE__,
	'name' => 'SimpleSamlAuth',
	'version' => 'GIT-master',
	'author' => 'Jørn Åne',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SimpleSamlAuth',
	'license-name' => 'LGPL-3.0+',
	'descriptionmsg' => 'simplesamlauth-desc'
);

$GLOBALS['wgHooks']['UserLoadFromSession'][]    = 'SimpleSamlAuth::hookLoadSession';
$GLOBALS['wgHooks']['GetPreferences'][]         = 'SimpleSamlAuth::hookGetPreferences';
$GLOBALS['wgHooks']['SpecialPage_initList'][]   = 'SimpleSamlAuth::hookSpecialPage_initList';
$GLOBALS['wgHooks']['UserLoginForm'][]          = 'SimpleSamlAuth::hookLoginForm';
$GLOBALS['wgHooks']['UserLogoutComplete'][]     = 'SimpleSamlAuth::hookUserLogout';
$GLOBALS['wgHooks']['PersonalUrls'][]           = 'SimpleSamlAuth::hookPersonalUrls';
$GLOBALS['wgHooks']['MediaWikiPerformAction'][] = 'SimpleSamlAuth::hookMediaWikiPerformAction';

define( 'SAML_OPTIONAL', 0 );
define( 'SAML_LOGIN_ONLY', 1 );
define( 'SAML_REQUIRED', 2 );

$GLOBALS['wgSamlRequirement'] = SAML_OPTIONAL;
$GLOBALS['wgSamlCreateUser'] = false;
$GLOBALS['wgSamlConfirmMail'] = false;

$GLOBALS['wgSamlAuthSource'] = 'default-sp';
$GLOBALS['wgSamlSspRoot'] = rtrim( __DIR__, DIRECTORY_SEPARATOR )
			   . DIRECTORY_SEPARATOR
			   . 'simplesamlphp'
			   . DIRECTORY_SEPARATOR;
$GLOBALS['wgSamlPostLogoutRedirect'] = null;

$GLOBALS['wgSamlGroupMap'] = array(
	'sysop' => array(
		'groups' => array( 'admin' ),
	),
);

$GLOBALS['wgSamlUsernameAttr'] = 'uid';
$GLOBALS['wgSamlRealnameAttr'] = 'cn';
$GLOBALS['wgSamlMailAttr'] = 'mail';
