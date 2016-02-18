<?php
/**
 * Provides hover-over tool tips on articles from words defined on the
 * Terminology page.
 *
 * @file
 * @defgroup  Lingo
 * @author    Barry Coughlan
 * @copyright 2010 Barry Coughlan
 * @author    Stephan Gambke
 * @version   1.2.0
 * @license   GNU General Public Licence 2.0 or later
 * @see       http://www.mediawiki.org/wiki/Extension:Lingo Documentation
 */

call_user_func( function () {

	if ( !defined( 'MEDIAWIKI' ) ) {
		die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
	}

	define( 'LINGO_VERSION', '1.2.1-dev' );

	// set defaults for settings

	$GLOBALS[ 'wgexLingoBackend' ]            = 'LingoBasicBackend'; // set the backend to access the glossary
	$GLOBALS[ 'wgexLingoPage' ]               = null; // set default for Terminology page (null = take from i18n)
	$GLOBALS[ 'wgexLingoDisplayOnce' ]        = false; // set if glossary terms are to be marked up once or always
	$GLOBALS[ 'wgexLingoCacheType' ]          = null; // set default cache type (null = use main cache)
	$GLOBALS[ 'wgexLingoEnableApprovedRevs' ] = false; // use ApprovedRevs extension


	// set namespaces to be marked up;
	// namespaces to be ignored have to be included in this array and set to false
	// anything not in this array (or in this array and set to true) will be marked up
	$GLOBALS[ 'wgexLingoUseNamespaces' ] = array(
//		NS_MEDIA            => true,
//		NS_SPECIAL          => true,
//		NS_TALK             => false,
//	  ...
	);

	// set extension credits
	// (no description here, it will be set later)
	$GLOBALS[ 'wgExtensionCredits' ][ 'parserhook' ][ 'lingo' ] = array(
			'path'         => __FILE__,
			'name'         => 'Lingo',
			'author'       => array(
				 'Barry Coughlan',
				 '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]',
				 '...'
				 ),
			'url'          => 'https://www.mediawiki.org/wiki/Extension:Lingo',
			'version'      => LINGO_VERSION,
			'license-name' => 'GPL-2.0+'
	);

	// server-local path to this file
	$dir = dirname( __FILE__ );

	// register message files
	$messageFiles = array(
			'Lingo'      => $dir . '/Lingo.i18n.php',
			'LingoMagic' => $dir . '/Lingo.i18n.magic.php',
	);

	$GLOBALS['wgMessagesDirs']['Lingo'] = __DIR__ . "/i18n";
	$GLOBALS[ 'wgExtensionMessagesFiles' ] = array_merge( $GLOBALS[ 'wgExtensionMessagesFiles' ], $messageFiles );

	// register class files with the Autoloader
	$autoloadClasses = array(
			'LingoHooks'        => $dir . '/src/LingoHooks.php',
			'LingoParser'       => $dir . '/src/LingoParser.php',
			'LingoTree'         => $dir . '/src/LingoTree.php',
			'LingoElement'      => $dir . '/src/LingoElement.php',
			'LingoBackend'      => $dir . '/src/LingoBackend.php',
			'LingoBasicBackend' => $dir . '/src/LingoBasicBackend.php',
			'LingoMessageLog'   => $dir . '/src/LingoMessageLog.php',
	);

	$GLOBALS[ 'wgAutoloadClasses' ] = array_merge( $GLOBALS[ 'wgAutoloadClasses' ], $autoloadClasses );

	// register hook handlers
	$hooks = array(
			'ExtensionTypes' => array( 'LingoHooks::setCredits' ), // set credits
			'ParserFirstCallInit'          => array( 'LingoHooks::registerTags' ),
			'ArticlePurge'                 => array( 'LingoBasicBackend::purgeCache' ),
			'ArticleSave'                  => array( 'LingoBasicBackend::purgeCache' ),
			'ParserAfterParse'             => array( 'LingoHooks::parse' ),
	);

	$GLOBALS[ 'wgHooks' ] = array_merge_recursive( $GLOBALS[ 'wgHooks' ], $hooks );

	// register resource modules with the Resource Loader
	$resourceModules = array(
			'ext.Lingo.Styles'  => array(
					'localBasePath' => $dir,
					'remoteExtPath' => 'Lingo',
					'position'	=> 'top',
					'styles'        => 'styles/Lingo.css',
			),

			'ext.Lingo.Scripts' => array(
					'localBasePath' => $dir,
					'remoteExtPath' => 'Lingo',
					'scripts'       => 'libs/Lingo.js',
					'dependencies'  => 'ext.jquery.qtip',
			),

			'ext.jquery.qtip'   => array(
					'localBasePath' => $dir,
					'remoteExtPath' => 'Lingo',
					'scripts'       => 'libs/jquery.qtip.js',
					'styles'        => 'styles/jquery.qtip.css',
			),

	);

	$GLOBALS[ 'wgResourceModules' ] = array_merge( $GLOBALS[ 'wgResourceModules' ], $resourceModules );

	MagicWord::$mDoubleUnderscoreIDs[ ] = 'noglossary';

	unset( $dir );

} );
