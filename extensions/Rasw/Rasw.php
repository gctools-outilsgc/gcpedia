<?php
/*
 Copyright (C) 2017 GaC Hackathon Team

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */
$wgExtensionCredits['specialpage'][] = array(
		'path' => __FILE__,
		'name' => 'RASW',
		'author' => 'GaC Hackathon Team',
		'version' => '0.2',
		'descriptionmsg' => 'rasw-desc',

		//'url' => 'https://www.mediawiki.org/wiki/Extension:RASW',
);

$dir = dirname(__FILE__) . '/';
// Classes
$wgAutoloadClasses['RaswHooks'] = $dir . 'RaswHooks.php';
//Hooks
$wgHooks['ParserFirstCallInit'][] = 'RaswHooks::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'RaswHooks::onBeforePageDisplay';
//API
// Internationlization files
$wgMessagesDirs['Rasw'] = __DIR__ . '/i18n';
// Map module name to class name
$wgAPIListModules['categoryrecentchanges'] = 'ApiQueryCategoryRecentChanges';
// Map class name to filename for autoloading
$wgAutoloadClasses['ApiQueryCategoryRecentChanges'] = $dir . '/api/ApiQueryCategoryRecentChanges.php';
//Resource loader for js and css
$wgResourceModules['ext.rasw'] = array(
		'scripts' => array('/js/moment.js','/js/tinyscrollbar.js','/js/rasw.js'),
		'styles' => '/css/rasw.css',
		'localBasePath' => dirname( __FILE__ ),
		'position' => 'top'

);

