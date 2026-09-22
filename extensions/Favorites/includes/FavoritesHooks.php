<?php

// phpcs:disable MediaWiki.NamingConventions.LowerCamelFunctionsName.FunctionName

use MediaWiki\MediaWikiServices;
use Wikimedia\ArrayUtils\ArrayUtils;

class FavoritesHooks {
	/**
	 * Adds the extension's JS and CSS assets on all page loads for registered users and
	 * only when the namespace index is 0 (NS_MAIN) or greater, i.e. skips NS_SPECIAL.
	 *
	 * @param OutputPage &$out
	 * @param Skin &$skin
	 */
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		if ( $out->getUser()->isRegistered() && $out->getTitle()->getNamespace() <= 0 ) {
			$out->addModules( [
				'ext.favorites',
				'ext.favorites.style'
			] );
		}
	}

	/**
	 * Register the <favorites> hook with the Parser.
	 *
	 * @param Parser &$parser
	 */
	public static function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'favorites', [ __CLASS__, 'renderFavorites' ] );
	}

	/**
	 * Callback for the <favorites> hook registered in onParserFirstCallInit().
	 *
	 * @param string $input
	 * @param array $argv
	 * @param Parser $parser
	 * @return string
	 */
	public static function renderFavorites( $input, $argv, $parser ) {
		$favParse = new FavParser();
		$output = $favParse->wfSpecialFavoritelist( $argv, $parser );
		$parser->getOutput()->updateCacheExpiry( 0 );
		return $output;
	}

	/**
	 * Creates the necessary database table when the user runs
	 * maintenance/update.php.
	 *
	 * @param DatabaseUpdater $updater
	 */
	public static function onLoadExtensionSchemaUpdates( DatabaseUpdater $updater ) {
		$file = 'favorites.sql';
		if ( $updater->getDB()->getType() === 'postgres' ) {
			$file = 'favorites.postgres.sql';
		}
		$updater->addExtensionTable( 'favoritelist', __DIR__ . '/../sql/' . $file );
	}

	/**
	 * Update favoritelists after a page has been moved.
	 *
	 * @param MediaWiki\Linker\LinkTarget $title Old page title
	 * @param MediaWiki\Linker\LinkTarget $nt New page title
	 * @param MediaWiki\User\UserIdentity $userIdentity User who did the move [unused]
	 * @param int $pageId ID of the impacted page [unused]
	 * @param int $redirId
	 * @param string $reason User-supplied reason for the page move [unused]
	 * @param MediaWiki\Revision\RevisionRecord $revision [unused]
	 */
	public static function onPageMoveComplete(
		MediaWiki\Linker\LinkTarget $title,
		MediaWiki\Linker\LinkTarget $nt,
		MediaWiki\User\UserIdentity $userIdentity,
		int $pageId,
		int $redirId,
		string $reason,
		MediaWiki\Revision\RevisionRecord $revision
	) {
		$oldNamespace = $title->getNamespace() & ~1;
		$newNamespace = $nt->getNamespace() & ~1;
		$oldTitle = $title->getDBkey();
		$newTitle = $nt->getDBkey();

		if ( $oldNamespace != $newNamespace || $oldTitle != $newTitle ) {
			Favorites::duplicateEntries( $title, $nt );
		}
	}

	/**
	 * Delete favorite list entries for a page when said page gets deleted.
	 *
	 * @param MediaWiki\Page\ProperPageIdentity $page The page that was deleted
	 * @param MediaWiki\Permissions\Authority $deleter The user who deleted the page [unused]
	 * @param string $reason User-supplied reason for page deletion [unused]
	 * @param int $pageID ID of the deleted page [unused]
	 * @param MediaWiki\Revision\RevisionRecord $deletedRev [unused]
	 * @param ManualLogEntry $logEntry [unused]
	 * @param int $archivedRevisionCount [unused]
	 */
	public static function onPageDeleteComplete(
		MediaWiki\Page\ProperPageIdentity $page,
		MediaWiki\Permissions\Authority $deleter,
		string $reason,
		int $pageID,
		MediaWiki\Revision\RevisionRecord $deletedRev,
		ManualLogEntry $logEntry,
		int $archivedRevisionCount
	) {
		$services = MediaWikiServices::getInstance();
		$dbw = $services->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$title = $services->getTitleFactory()->newFromPageIdentity( $page );
		$dbw->delete(
			'favoritelist',
			[
				'fl_namespace' => $title->getNamespace(),
				'fl_title' => $title->getDBkey()
			],
			__METHOD__
		);
	}

	/**
	 * Add the "My favorites" menu item to the personal tools if enabled in config.
	 *
	 * @param SkinTemplate $sktemplate
	 * @param array &$links
	 */
	public static function onSkinTemplateNavigation__Universal( $sktemplate, &$links ) {
		global $wgFavoritesPersonalURL;

		if ( $wgFavoritesPersonalURL && $sktemplate->getUser()->isRegistered() ) {
			$personal_urls = &$links['user-menu'];
			$url[] = [
				'text' => $sktemplate->msg( 'myfavoritelist' )->text(),
				'href' => SpecialPage::getTitleFor( 'Favoritelist' )->getLocalURL()
			];
			if ( method_exists( ArrayUtils::class, 'insertAfter' ) ) {
				// MW 1.46+
				$personal_urls = ArrayUtils::insertAfter( $personal_urls, $url, 'watchlist' );
			} else {
				$personal_urls = wfArrayInsertAfter( $personal_urls, $url, 'watchlist' );
			}
		}

		$favClass = new Favorites;
		$favClass->favoritesLinks( $sktemplate, $links );
	}
}
