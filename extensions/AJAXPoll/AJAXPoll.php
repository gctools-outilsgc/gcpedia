<?php
/**
 * AJAX Poll extension for MediaWiki
 * Created by Dariusz Siedlecki, based on the work by Eric David.
 * Licensed under the GFDL.
 *
 * <poll>
 * Question
 * Answer 1
 * Answer 2
 * Answer ...
 * Answer n
 * </poll>
 *
 * to allow the viewing of the poll results even without having voted
 * <poll show-results-before-voting>
 * Question
 * Answer 1
 * Answer 2
 * Answer ...
 * Answer n
 * </poll>
 *
 * If the first line after <poll> is "STATS",
 * then some statistics about the wiki and its polls will be displayed.
 * These statistics are not localizable and this whole feature will probably be
 * removed (or at least refactored, but probably removed) in the future.
 * <poll>
 * STATS
 * </poll>
 *
 * @file
 * @ingroup Extensions
 * @author Dariusz Siedlecki <datrio@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Thomas Gries
 * @maintainer Thomas Gries
 * @link http://www.mediawiki.org/wiki/Extension:AJAX_Poll Documentation
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'AJAX Poll',
	'version' => '1.88.0 20140330',
	'author' => array( 'Dariusz Siedlecki', 'Jack Phoenix', 'Thomas Gries' ),
	'descriptionmsg' => 'ajaxpoll-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AJAX_Poll',
);

// Internationalization + AJAX function
$dir = dirname( __FILE__ );
$wgMessagesDirs['AJAXPoll'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['AJAXPoll'] = $dir . '/AJAXPoll.i18n.php';
$wgAutoloadClasses['AJAXPoll'] = $dir . '/AJAXPoll_body.php';
$wgAjaxExportList[] = 'AJAXPoll::submitVote';
$wgHooks['ParserFirstCallInit'][] = 'AJAXPoll::onParserInit';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'AJAXPoll::onLoadExtensionSchemaUpdates';

$myResourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . "/resources",
	'remoteExtPath' => 'AJAXPoll/resources',
	'group' => 'ext.ajaxpoll',
);
$wgResourceModules['ext.ajaxpoll'] = $myResourceTemplate + array(
	'scripts' => array(
		'ajaxpoll.js',
	),
	'styles' => array(
		'ajaxpoll.css',
	),
	'dependencies' => array(
	),
	'messages' => array(
		'ajaxpoll-submitting',
	)
);

# new user rights
$wgAvailableRights[] = 'ajaxpoll-vote';
$wgAvailableRights[] = 'ajaxpoll-view-results';
$wgAvailableRights[] = 'ajaxpoll-view-results-before-vote';

# The 'ajaxpoll-view-results-before-vote' group permission allows the specified
# group members to view poll results even without having voted
# but only if the high-level group permission 'ajaxpoll-vote' allows to view
# results in general.
#
# This 'ajaxpoll-view-results-before-vote' can be overwritten with the specific
# per-poll setting "show-results-before-voting" which takes precedence over the
# group permission.
#
# permission 'ajaxpoll-view-results' >>
# >> per-poll setting "show-results-before-voting" (if present)
# >> permission 'ajaxpoll-view-results-before-vote'
#

# anons
# default: anons cannot vote and will never see results
$wgGroupPermissions['*']['ajaxpoll-vote'] = false;
$wgGroupPermissions['*']['ajaxpoll-view-results'] = false;
$wgGroupPermissions['*']['ajaxpoll-view-results-before-vote'] = false;

# users
# default: users can vote and can see poll results - when they have voted
$wgGroupPermissions['user']['ajaxpoll-vote'] = true;
$wgGroupPermissions['user']['ajaxpoll-view-results'] = true;

# tracking category for Special:TrackingCategories
$wgTrackingCategories[] = 'ajaxpoll-tracking-category';
