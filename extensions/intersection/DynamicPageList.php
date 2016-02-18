<?php
/*

 Purpose:       outputs a bulleted list of most recent
                items residing in a category, or a union
                of several categories.

 Contributors: n:en:User:IlyaHaykinson n:en:User:Amgine
 http://en.wikinews.org/wiki/User:Amgine
 http://en.wikinews.org/wiki/User:IlyaHaykinson

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html

 Current feature request list
	 1. Unset cached of calling page
	 2. RSS feed output? (GNSM extension?)

 To install, add following to LocalSettings.php
   include("$IP/extensions/intersection/DynamicPageList.php");

*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'DynamicPageList',
	'version'        => '1.7.0',
	'descriptionmsg' => 'intersection-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Intersection',
	'author'         => array( '[http://en.wikinews.org/wiki/User:Amgine Amgine]', '[http://en.wikinews.org/wiki/User:IlyaHaykinson IlyaHaykinson]' ),
);

// Internationalization file
$wgMessagesDirs['DynamicPageList'] = __DIR__ . '/i18n';

$wgAutoloadClasses['DynamicPageListHooks'] = __DIR__ . '/DynamicPageList.hooks.php';

// Parser tests
// Warning, these only work when run with parserTests.php. There will be
// failures if run via phpunit! (you may want to comment the below line
// out if you're regularly running phpunit tests)
$wgParserTestFiles[] = __DIR__ . '/DynamicPageList.tests.txt';

# Configuration variables. Warning: These use DLP instead of DPL
# for historical reasons (pretend Dynamic list of pages)
$wgDLPmaxCategories = 6;                // Maximum number of categories to look for
$wgDLPMaxResultCount = 200;             // Maximum number of results to allow
$wgDLPAllowUnlimitedResults = false;    // Allow unlimited results
$wgDLPAllowUnlimitedCategories = false; // Allow unlimited categories
// How long to cache pages using DPL's in seconds. Default to 1 day. Set to
// false to not decrease cache time (most efficient), Set to 0 to disable
// cache altogether (inefficient, but results will never be outdated)
$wgDLPMaxCacheTime = 60*60*24;          // How long to cache pages

$wgHooks['ParserFirstCallInit'][] = 'DynamicPageListHooks::onParserFirstCallInit';
