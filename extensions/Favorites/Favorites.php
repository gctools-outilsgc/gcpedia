<?php
/*
 Copyright (C) 2015 Jeremy Lemley

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
		'name' => 'Favorites',
		'author' => 'Jeremy Lemley',
		'descriptionmsg' => 'favorites-desc',
		'version' => '1.1.2',
		'url' => "http://www.mediawiki.org/wiki/Extension:Favorites",
);

// Take credit for your work.
$wgExtensionCredits['api'][] = array(
		'path' => __FILE__,
		'name' => 'Favorites API',
		'author' => 'Jeremy Lemley',
		'descriptionmsg' => 'favorites-api-desc',
		'version' => '1.1.2',

);


$dir = dirname(__FILE__) . '/';

$wgResourceModules['ext.favorites'] = array(
		'scripts' => array('/modules/page.favorite.ajax.js','/modules/favorites.js'),
		'dependencies' => array(
				'mediawiki.api',
		'user.tokens'),
		'localBasePath' => __DIR__,
		'remoteExtPath' => 'Favorites',
		'messages' => array(
				'favoriteerrortext',
				'tooltip-ca-favorite',
				'tooltip-ca-unfavorite',
				'favoriteing',
				'unfavoriteing',
				'favoritethispage',
				'unfavoritethispage',
				'favorite',
				'unfavorite',
				'addedfavoritetext',
				'removedfavoritetext'
		)
		
);

//Resource loader for js and css
$wgResourceModules['ext.favorites.style'] = array(
		'styles' => '/modules/favorites.css',
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'Favorites',
		'position' => 'top'

);


// Set up i18n
$wgMessagesDirs['Favorites'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['MyExtensionAlias'] = __DIR__ . '/SpecialFavorites.alias.php'; 


// Classes
$wgAutoloadClasses['Favorites'] = $dir . 'Favorites_body.php';
$wgAutoloadClasses['FavoriteAction'] = $dir . 'FavoritesActions.php';
$wgAutoloadClasses['SpecialFavoritelist'] = $dir . 'SpecialFavoritelist.php';
$wgAutoloadClasses['ViewFavorites'] = $dir . 'SpecialFavoritelist.php';
$wgAutoloadClasses['FavoritelistEditor'] = $dir . 'FavoritelistEditor.php';
$wgAutoloadClasses['FavParser'] =  $dir . 'FavParser.php';
$wgAutoloadClasses['FavoritesHooks'] = $dir . 'FavoritesHooks.php';

// API
$wgAutoloadClasses['ApiFavorite'] = $dir . 'api/ApiFavorite.php';
$wgAPIModules['favorite'] = 'ApiFavorite';

// Hooks
$wgHooks['SkinTemplateNavigation'][] = 'FavoritesHooks::onSkinTemplateNavigation';
//$wgHooks['SkinTemplateNavigation'][] = 'getFavoritesLinks';
$wgHooks['UnknownAction'][] = 'FavoritesHooks::onUnknownAction';
//$wgHooks['UnknownAction'][] = 'favActions';
$wgHooks['BeforePageDisplay'][] = 'FavoritesHooks::onBeforePageDisplay';
//$wgHooks['BeforePageDisplay'][] = 'onBeforePageDisplay';
$wgHooks['ParserFirstCallInit'][] = 'FavoritesHooks::onParserFirstCallInit';
//$wgHooks['ParserFirstCallInit'][] = 'ParseFavorites';
$wgHooks['TitleMoveComplete'][] = 'FavoritesHooks::onTitleMoveComplete';
$wgHooks['ArticleDeleteComplete'][] = 'FavoritesHooks::onArticleDeleteComplete';
$wgHooks['PersonalUrls'][] = 'FavoritesHooks::onPersonalUrls';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'FavoritesHooks::onLoadExtensionSchemaUpdates';

// Special Page
$wgSpecialPages['Favoritelist'] = 'SpecialFavoritelist';


$wgFavoritesPersonalURL = false;
$wgUseIconFavorite = false;

