<?php
/**
 * Page history
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Actions
 */

use MediaWiki\MediaWikiServices;
use Wikimedia\Rdbms\ResultWrapper;
use Wikimedia\Rdbms\FakeResultWrapper;

/**
 * This class handles printing the history page for an article. In order to
 * be efficient, it uses timestamps rather than offsets for paging, to avoid
 * costly LIMIT,offset queries.
 *
 * Construct it by passing in an Article, and call $h->history() to print the
 * history.
 *
 * @ingroup Actions
 */
class HistoryAction extends FormlessAction {
	const DIR_PREV = 0;
	const DIR_NEXT = 1;

	/** @var array Array of message keys and strings */
	public $message;

	public function getName() {
		return 'history';
	}

	public function requiresWrite() {
		return false;
	}

	public function requiresUnblock() {
		return false;
	}

	protected function getPageTitle() {
		return $this->msg( 'history-title', $this->getTitle()->getPrefixedText() )->text();
	}

	protected function getDescription() {
		// Creation of a subtitle link pointing to [[Special:Log]]
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();
		$subtitle = $linkRenderer->makeKnownLink(
			SpecialPage::getTitleFor( 'Log' ),
			$this->msg( 'viewpagelogs' )->text(),
			[],
			[ 'page' => $this->getTitle()->getPrefixedText() ]
		);

		$links = [];
		// Allow extensions to add more links
		Hooks::run( 'HistoryPageToolLinks', [ $this->getContext(), $linkRenderer, &$links ] );
		if ( $links ) {
			$subtitle .= ''
				. $this->msg( 'word-separator' )->escaped()
				. $this->msg( 'parentheses' )
					->rawParams( $this->getLanguage()->pipeList( $links ) )
					->escaped();
		}
		return Html::rawElement( 'div', [ 'class' => 'mw-history-subtitle' ], $subtitle );
	}

	/**
	 * @return WikiPage|Article|ImagePage|CategoryPage|Page The Article object we are working on.
	 */
	public function getArticle() {
		return $this->page;
	}

	/**
	 * As we use the same small set of messages in various methods and that
	 * they are called often, we call them once and save them in $this->message
	 */
	private function preCacheMessages() {
		// Precache various messages
		if ( !isset( $this->message ) ) {
			$msgs = [ 'cur', 'last', 'pipe-separator' ];
			foreach ( $msgs as $msg ) {
				$this->message[$msg] = $this->msg( $msg )->escaped();
			}
		}
	}

	/**
	 * Print the history page for an article.
	 */
	function onView() {
		$out = $this->getOutput();
		$request = $this->getRequest();

		/**
		 * Allow client caching.
		 */
		if ( $out->checkLastModified( $this->page->getTouched() ) ) {
			return; // Client cache fresh and headers sent, nothing more to do.
		}

		$this->preCacheMessages();
		$config = $this->context->getConfig();

		# Fill in the file cache if not set already
		if ( HTMLFileCache::useFileCache( $this->getContext() ) ) {
			$cache = new HTMLFileCache( $this->getTitle(), 'history' );
			if ( !$cache->isCacheGood( /* Assume up to date */ ) ) {
				ob_start( [ &$cache, 'saveToFileCache' ] );
			}
		}

		// Setup page variables.
		$out->setFeedAppendQuery( 'action=history' );
		$out->addModules( 'mediawiki.action.history' );
		$out->addModuleStyles( [
			'mediawiki.interface.helpers.styles',
			'mediawiki.action.history.styles',
			'mediawiki.special.changeslist',
		] );
		if ( $config->get( 'UseMediaWikiUIEverywhere' ) ) {
			$out = $this->getOutput();
			$out->addModuleStyles( [
				'mediawiki.ui.input',
				'mediawiki.ui.checkbox',
			] );
		}

		// Handle atom/RSS feeds.
		$feedType = $request->getVal( 'feed' );
		if ( $feedType ) {
			$this->feed( $feedType );

			return;
		}

		$this->addHelpLink( '//meta.wikimedia.org/wiki/Special:MyLanguage/Help:Page_history', true );

		// Fail nicely if article doesn't exist.
		if ( !$this->page->exists() ) {
			global $wgSend404Code;
			if ( $wgSend404Code ) {
				$out->setStatusCode( 404 );
			}
			$out->addWikiMsg( 'nohistory' );

			$dbr = wfGetDB( DB_REPLICA );

			# show deletion/move log if there is an entry
			LogEventsList::showLogExtract(
				$out,
				[ 'delete', 'move', 'protect' ],
				$this->getTitle(),
				'',
				[ 'lim' => 10,
					'conds' => [ 'log_action != ' . $dbr->addQuotes( 'revision' ) ],
					'showIfEmpty' => false,
					'msgKey' => [ 'moveddeleted-notice' ]
				]
			);

			return;
		}

		/**
		 * Add date selector to quickly get to a certain time
		 */
		$year = $request->getInt( 'year' );
		$month = $request->getInt( 'month' );
		$tagFilter = $request->getVal( 'tagfilter' );
		$tagSelector = ChangeTags::buildTagFilterSelector( $tagFilter, false, $this->getContext() );

		/**
		 * Option to show only revisions that have been (partially) hidden via RevisionDelete
		 */
		if ( $request->getBool( 'deleted' ) ) {
			$conds = [ 'rev_deleted != 0' ];
		} else {
			$conds = [];
		}
		if ( $this->getUser()->isAllowed( 'deletedhistory' ) ) {
			$checkDeleted = Xml::checkLabel( $this->msg( 'history-show-deleted' )->text(),
				'deleted', 'mw-show-deleted-only', $request->getBool( 'deleted' ) ) . "\n";
		} else {
			$checkDeleted = '';
		}

		// Add the general form
		$action = htmlspecialchars( wfScript() );
		$content = Html::hidden( 'title', $this->getTitle()->getPrefixedDBkey() ) . "\n";
		$content .= Html::hidden( 'action', 'history' ) . "\n";
		$content .= Xml::dateMenu(
			( $year == null ? MWTimestamp::getLocalInstance()->format( 'Y' ) : $year ),
			$month
		) . "\u{00A0}";
		$content .= $tagSelector ? ( implode( "\u{00A0}", $tagSelector ) . "\u{00A0}" ) : '';
		$content .= $checkDeleted . Html::submitButton(
			$this->msg( 'historyaction-submit' )->text(),
			[],
			[ 'mw-ui-progressive' ]
		);
		$out->addHTML(
			"<form action=\"$action\" method=\"get\" id=\"mw-history-searchform\">" .
			Xml::fieldset(
				$this->msg( 'history-fieldset-title' )->text(),
				$content,
				[ 'id' => 'mw-history-search' ]
			) .
			'</form>'
		);

		Hooks::run( 'PageHistoryBeforeList', [ &$this->page, $this->getContext() ] );

		// Create and output the list.
		$pager = new HistoryPager( $this, $year, $month, $tagFilter, $conds );
		$out->addHTML(
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
		$out->preventClickjacking( $pager->getPreventClickjacking() );
	}

	/**
	 * Fetch an array of revisions, specified by a given limit, offset and
	 * direction. This is now only used by the feeds. It was previously
	 * used by the main UI but that's now handled by the pager.
	 *
	 * @param int $limit The limit number of revisions to get
	 * @param int $offset
	 * @param int $direction Either self::DIR_PREV or self::DIR_NEXT
	 * @return ResultWrapper
	 */
	function fetchRevisions( $limit, $offset, $direction ) {
		// Fail if article doesn't exist.
		if ( !$this->getTitle()->exists() ) {
			return new FakeResultWrapper( [] );
		}

		$dbr = wfGetDB( DB_REPLICA );

		if ( $direction === self::DIR_PREV ) {
			list( $dirs, $oper ) = [ "ASC", ">=" ];
		} else { /* $direction === self::DIR_NEXT */
			list( $dirs, $oper ) = [ "DESC", "<=" ];
		}

		if ( $offset ) {
			$offsets = [ "rev_timestamp $oper " . $dbr->addQuotes( $dbr->timestamp( $offset ) ) ];
		} else {
			$offsets = [];
		}

		$page_id = $this->page->getId();

		$revQuery = Revision::getQueryInfo();
		return $dbr->select(
			$revQuery['tables'],
			$revQuery['fields'],
			array_merge( [ 'rev_page' => $page_id ], $offsets ),
			__METHOD__,
			[
				'ORDER BY' => "rev_timestamp $dirs",
				'USE INDEX' => [ 'revision' => 'page_timestamp' ],
				'LIMIT' => $limit
			],
			$revQuery['joins']
		);
	}

	/**
	 * Output a subscription feed listing recent edits to this page.
	 *
	 * @param string $type Feed type
	 */
	function feed( $type ) {
		if ( !FeedUtils::checkFeedOutput( $type ) ) {
			return;
		}
		$request = $this->getRequest();

		$feedClasses = $this->context->getConfig()->get( 'FeedClasses' );
		/** @var RSSFeed|AtomFeed $feed */
		$feed = new $feedClasses[$type](
			$this->getTitle()->getPrefixedText() . ' - ' .
			$this->msg( 'history-feed-title' )->inContentLanguage()->text(),
			$this->msg( 'history-feed-description' )->inContentLanguage()->text(),
			$this->getTitle()->getFullURL( 'action=history' )
		);

		// Get a limit on number of feed entries. Provide a sane default
		// of 10 if none is defined (but limit to $wgFeedLimit max)
		$limit = $request->getInt( 'limit', 10 );
		$limit = min(
			max( $limit, 1 ),
			$this->context->getConfig()->get( 'FeedLimit' )
		);

		$items = $this->fetchRevisions( $limit, 0, self::DIR_NEXT );

		// Generate feed elements enclosed between header and footer.
		$feed->outHeader();
		if ( $items->numRows() ) {
			foreach ( $items as $row ) {
				$feed->outItem( $this->feedItem( $row ) );
			}
		} else {
			$feed->outItem( $this->feedEmpty() );
		}
		$feed->outFooter();
	}

	function feedEmpty() {
		return new FeedItem(
			$this->msg( 'nohistory' )->inContentLanguage()->text(),
			$this->msg( 'history-feed-empty' )->inContentLanguage()->parseAsBlock(),
			$this->getTitle()->getFullURL(),
			wfTimestamp( TS_MW ),
			'',
			$this->getTitle()->getTalkPage()->getFullURL()
		);
	}

	/**
	 * Generate a FeedItem object from a given revision table row
	 * Borrows Recent Changes' feed generation functions for formatting;
	 * includes a diff to the previous revision (if any).
	 *
	 * @param stdClass|array $row Database row
	 * @return FeedItem
	 */
	function feedItem( $row ) {
		$rev = new Revision( $row, 0, $this->getTitle() );

		$text = FeedUtils::formatDiffRow(
			$this->getTitle(),
			$this->getTitle()->getPreviousRevisionID( $rev->getId() ),
			$rev->getId(),
			$rev->getTimestamp(),
			$rev->getComment()
		);
		if ( $rev->getComment() == '' ) {
			$contLang = MediaWikiServices::getInstance()->getContentLanguage();
			$title = $this->msg( 'history-feed-item-nocomment',
				$rev->getUserText(),
				$contLang->timeanddate( $rev->getTimestamp() ),
				$contLang->date( $rev->getTimestamp() ),
				$contLang->time( $rev->getTimestamp() )
			)->inContentLanguage()->text();
		} else {
			$title = $rev->getUserText() .
				$this->msg( 'colon-separator' )->inContentLanguage()->text() .
				FeedItem::stripComment( $rev->getComment() );
		}

		return new FeedItem(
			$title,
			$text,
			$this->getTitle()->getFullURL( 'diff=' . $rev->getId() . '&oldid=prev' ),
			$rev->getTimestamp(),
			$rev->getUserText(),
			$this->getTitle()->getTalkPage()->getFullURL()
		);
	}
}
