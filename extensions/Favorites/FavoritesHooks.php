<?php

class FavoritesHooks {
	public static function onSkinTemplateNavigation(&$sktemplate, &$links) {
	
	
		$favClass = new Favorites;
		$favClass->favoritesLinks($sktemplate, $links);
		//if ( $wgUseAjax && $wgEnableAPI && $wgEnableWriteAPI && $user->isAllowed( 'writeapi' )) {
		//$sktemplate->getOutput()->addModules( 'ext.favorites' );
	
		//}
	
	}
	
	
	public static function onUnknownAction( $action, Page $article ) {
		if ($action == 'favorite' || $action == 'unfavorite') {
			// do something
			$title = $article->getTitle();
	
			$doAction = new FavoriteAction($action,$title,$article);
	
			return false;
		} else {
			// allow other extensions to handle whatever else is out there
			return true;
		}
	}
	
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		$out->addModules( 'ext.favorites' );
		$out->addModules( 'ext.favorites.style' );
	}
	
	public static function onParserFirstCallInit(Parser &$parser) {
	
		$parser->setHook( 'favorites', array( __CLASS__, 'renderFavorites' ) );
	
		return true;
	}

	public static function renderFavorites( $input, $argv, $parser ) {
		# The parser function itself
		# The input parameters are wikitext with templates expanded
		# The output should be wikitext too
		//$output = "Parser Output goes here.";
	
		$favParse = new FavParser();
		$output = $favParse->wfSpecialFavoritelist( $argv, $parser );
		$parser->disableCache();
		return $output;
	}
	
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) { // <= 1.16 support
			global $wgExtNewTables, $wgExtModifiedFields;
			$wgExtNewTables[] = array(
					'favoritelist',
					dirname( __FILE__ ) . '/favorites.sql'
			);
		} else { // >= 1.17 support
			$updater->addExtensionUpdate( array( 'addTable', 'favoritelist',
					dirname( __FILE__ ) . '/favorites.sql', true ) );
		}
		return true;
	}
	
	public static function onTitleMoveComplete( &$title, &$nt, &$user, $pageid, $redirid ) {
		# Update watchlists
		$oldnamespace = $title->getNamespace() & ~1;
		$newnamespace = $nt->getNamespace() & ~1;
		$oldtitle = $title->getDBkey();
		$newtitle = $nt->getDBkey();
	
		if ( $oldnamespace != $newnamespace || $oldtitle != $newtitle ) {
			Favorites::duplicateEntries( $title, $nt );
		}
		return true;
	}
	

	public static function onArticleDeleteComplete(&$article, &$user, $reason, $id ){
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'favoritelist', array(
				'fl_namespace' => $article->mTitle->getNamespace(),
				'fl_title' => $article->mTitle->getDBKey() ),
				__METHOD__ );
		return true;
	}
	
	public static function onPersonalUrls( &$personal_urls, &$wgTitle ) {
		global $wgFavoritesPersonalURL, $wgUser;
	
		if ( $wgFavoritesPersonalURL && $wgUser->isLoggedIn() ) {
			$url['userpage'] = array_shift( $personal_urls );
			$url[] = array_shift( $personal_urls );
			$url[] = array_shift( $personal_urls );
	
			$url[] = array( 'text' => wfMessage( 'myfavoritelist' )->text(),
					'href' => SpecialPage::getTitleFor( 'Favoritelist' )->getLocalURL() );
			$personal_urls = $url + $personal_urls;
		}
	
		return true;
	}
	
}


