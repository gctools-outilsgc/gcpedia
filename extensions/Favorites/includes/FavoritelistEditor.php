<?php

use MediaWiki\Html\Html;
use MediaWiki\Linker\Linker;
use MediaWiki\MediaWikiServices;
use MediaWiki\Title\Title;

/**
 * Provides the UI through which users can perform editing
 * operations on their favoritelist
 *
 * @ingroup favoritelist
 */
class FavoritelistEditor {

	/** Editing modes */

	private const EDIT_CLEAR = 1;
	private const EDIT_RAW = 2;
	private const EDIT_NORMAL = 3;

	/**
	 * Main execution point
	 *
	 * @param User $user
	 * @param OutputPage $output
	 * @param WebRequest $request
	 * @param int $mode
	 * @throws ReadOnlyError
	 */
	public function execute( $user, $output, $request, $mode ) {
		if ( MediaWikiServices::getInstance()->getReadOnlyMode()->isReadOnly() ) {
			throw new ReadOnlyError;
		}
		switch ( $mode ) {
			case self::EDIT_CLEAR:
				// The "Clear" link scared people too much.
				// Pass on to the raw editor, from which it's very easy to clear.
			case self::EDIT_RAW:
				$output->setPageTitle( wfMessage( 'favoritelistedit-raw-title' )->escaped() );
				if ( $request->wasPosted() && $this->checkToken( $request, $user ) ) {
					$wanted = $this->extractTitles( $request->getText( 'titles' ) );
					$current = $this->getFavoritelist( $user );
					if ( count( $wanted ) > 0 ) {
						$toFavorite = array_diff( $wanted, $current );
						$toUnfavorite = array_diff( $current, $wanted );
						$this->favoriteTitles( $toFavorite, $user );
						$this->unfavoriteTitles( $toUnfavorite, $user );
						$user->invalidateCache();
						if ( count( $toFavorite ) > 0 || count( $toUnfavorite ) > 0 ) {
							$output->addHTML( wfMessage( 'favoritelistedit-raw-done' )->parse() );
						}
						if ( ( $count = count( $toFavorite ) ) > 0 ) {
							$output->addHTML( '<br />' . wfMessage( 'favoritelistedit-raw-added', $count )->parse() );
							$this->showTitles( $toFavorite, $output, $output->getSkin() );
						}
						if ( ( $count = count( $toUnfavorite ) ) > 0 ) {
							$output->addHTML( '<br />' . wfMessage( 'favoritelistedit-raw-removed', $count )->parse() );
							$this->showTitles( $toUnfavorite, $output, $output->getSkin() );
						}
					} else {
						$this->clearFavoritelist( $user );
						$user->invalidateCache();
						$output->addHTML( wfMessage( 'favoritelistedit-raw-removed', count( $current ) )->parse() );
						$this->showTitles( $current, $output, $output->getSkin() );
					}
				}
				$this->showRawForm( $output, $user );
				break;
			case self::EDIT_NORMAL:
				$output->setPageTitle( wfMessage( 'favoritelistedit-normal-title' )->escaped() );
				if ( $request->wasPosted() && $this->checkToken( $request, $user ) ) {
					$titles = $this->extractTitles( $request->getArray( 'titles' ) );
					$this->unfavoriteTitles( $titles, $user );
					$user->invalidateCache();
					$output->addHTML( wfMessage(
							'favoritelistedit-normal-done'
						)->numParams( count( $titles ) )->parse() );
					$this->showTitles( $titles, $output, $output->getSkin() );
				}
				$this->showNormalForm( $output, $user );
		}
	}

	/**
	 * Check the edit token from a form submission
	 *
	 * @param WebRequest $request
	 * @param User $user
	 * @return bool
	 */
	private function checkToken( $request, $user ) {
		return $user->matchEditToken( $request->getVal( 'token' ), 'favoritelistedit' );
	}

	/**
	 * Extract a list of titles from a blob of text, returning
	 * (prefixed) strings; unfavoritable titles are ignored
	 *
	 * @param mixed $list
	 * @return array
	 */
	private function extractTitles( $list ) {
		$titles = [];

		if ( !is_array( $list ) ) {
			$list = explode( "\n", trim( $list ) );
			if ( !is_array( $list ) ) {
				return [];
			}
		}

		foreach ( $list as $text ) {
			$text = trim( $text );
			if ( strlen( $text ) > 0 ) {
				$title = Title::newFromText( $text );
				// if( $title instanceof Title && $title->isFavoritable() )
					$titles[] = $title->getPrefixedText();
			}
		}

		return array_unique( $titles );
	}

	/**
	 * Print out a list of linked titles
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param array $titles An array of strings, or Title objects
	 * @param OutputPage $output
	 */
	private function showTitles( $titles, $output ) {
		$talk = wfMessage( 'talkpagelinktext' )->text();

		// Do a batch existence check
		$services = MediaWikiServices::getInstance();
		$batch = $services->getLinkBatchFactory()->newLinkBatch();

		foreach ( $titles as $title ) {
			if ( !$title instanceof Title ) {
				$title = Title::newFromText( $title );
			}

			if ( $title instanceof Title ) {
				$batch->addObj( $title );
				// if ( $title->canHaveTalkPage() ) {
				// 	$batch->addObj( $title->getTalkPage() );
				// }
			}
		}

		$batch->execute();

		// Print out the list
		$output->addHTML( "<ul>\n" );
		foreach ( $titles as $title ) {
			if ( !$title instanceof Title ) {
				$title = Title::newFromText( $title );
			}
			if ( $title instanceof Title ) {
				$output->addHTML( "<li>" . $services->getLinkRenderer()->makeLink( $title ) . "</li>\n" );
			}
		}
		$output->addHTML( "</ul>\n" );
	}

	/**
	 * Count the number of titles on a user's favoritelist
	 *
	 * @param User $user
	 * @return int
	 */
	private function countFavoritelist( $user ) {
		$dbr = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$row = $dbr->selectRow(
			'favoritelist',
			'COUNT(*) AS count',
			[ 'fl_user' => $user->getId() ],
			__METHOD__
		);
		return ceil( $row->count );
	}

	/**
	 * Prepare a list of titles on a user's favoritelist
	 * and return an array of (prefixed) strings
	 *
	 * @param User $user
	 * @return array
	 */
	private function getFavoritelist( $user ) {
		$list = [];
		$dbr = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$res = $dbr->select(
			'favoritelist',
			'*',
			[
				'fl_user' => $user->getId(),
			],
			__METHOD__
		);
		if ( $res->numRows() > 0 ) {
			foreach ( $res as $row ) {
				$title = Title::makeTitleSafe( $row->fl_namespace, $row->fl_title );
				if ( $title instanceof Title && !$title->isTalkPage() ) {
					$list[] = $title->getPrefixedText();
				}
			}
		}
		return $list;
	}

	/**
	 * Show a message indicating the number of items on the user's favoritelist,
	 * and return this count for additional checking
	 *
	 * @param OutputPage $output
	 * @param User $user
	 * @return int
	 */
	private function showItemCount( $output, $user ) {
		if ( ( $count = $this->countFavoritelist( $user ) ) > 0 ) {
			$output->addHTML( wfMessage( 'favoritelistedit-numitems' )->numParams( $count )->parse() );
		} else {
			$output->addHTML( wfMessage( 'favoritelistedit-noitems' )->parse() );
		}
		return $count;
	}

	/**
	 * Remove all titles from a user's favoritelist
	 *
	 * @param User $user
	 */
	private function clearFavoritelist( $user ) {
		$dbw = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$dbw->delete( 'favoritelist', [ 'fl_user' => $user->getId() ], __METHOD__ );
	}

	/**
	 * Add a list of titles to a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param array $titles An array of strings, or Title objects
	 * @param User $user
	 */
	private function favoriteTitles( $titles, $user ) {
		$dbw = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$rows = [];
		foreach ( $titles as $title ) {
			if ( !$title instanceof Title ) {
				$title = Title::newFromText( $title );
			}
			if ( $title instanceof Title ) {
				$rows[] = [
					'fl_user' => $user->getId(),
					'fl_namespace' => $title->getNamespace(),
					'fl_title' => $title->getDBkey(),
					'fl_notificationtimestamp' => null,
				];
			}
		}
		$dbw->insert( 'favoritelist', $rows, __METHOD__, 'IGNORE' );
	}

	/**
	 * Remove a list of titles from a user's favoritelist
	 *
	 * $titles can be an array of strings or Title objects; the former
	 * is preferred, since Titles are very memory-heavy
	 *
	 * @param array $titles An array of strings, or Title objects
	 * @param User $user
	 */
	private function unfavoriteTitles( $titles, $user ) {
		$services = MediaWikiServices::getInstance();
		$dbw = $services->getDBLoadBalancer()->getConnection( DB_PRIMARY );
		$hookContainer = $services->getHookContainer();

		foreach ( $titles as $title ) {
			if ( !$title instanceof Title ) {
				$title = Title::newFromText( $title );
			}

			if ( $title instanceof Title ) {
				$dbw->delete(
					'favoritelist',
					[
						'fl_user' => $user->getId(),
						'fl_namespace' => $title->getNamespace(),
						'fl_title' => $title->getDBkey(),
					],
					__METHOD__
				);
				$article = new Article( $title );
				$hookContainer->run( 'UnfavoriteArticleComplete', [ &$user, &$article ] );
			}
		}
	}

	/**
	 * Show the standard favoritelist editing form
	 *
	 * @param OutputPage $output
	 * @param User $user
	 */
	private function showNormalForm( $output, $user ) {
		if ( $this->showItemCount( $output, $user ) > 0 ) {
			$self = SpecialPage::getTitleFor( 'Favoritelist' );
			$form  = Html::openElement( 'form', [ 'method' => 'post',
				'action' => $self->getLocalUrl( [ 'action' => 'edit' ] ) ] );
			$form .= Html::hidden( 'token', $user->getEditToken( 'favoritelistedit' ) );
			$form .= "<fieldset>\n<legend>" . wfMessage( 'favoritelistedit-normal-legend' )->escaped() . "</legend>";
			$form .= wfMessage( 'favoritelistedit-normal-explain' )->parse();
			$form .= $this->buildRemoveList( $user, $output->getSkin() );
			$form .= '<p>' . Html::submitButton( wfMessage( 'favoritelistedit-normal-submit' ), [] ) . '</p>';
			$form .= '</fieldset></form>';
			$output->addHTML( $form );
		}
	}

	/**
	 * Build the part of the standard favoritelist editing form with the actual
	 * title selection checkboxes and stuff.
	 * Also generates a table of contents if there's more than one heading.
	 *
	 * @param User $user
	 * @return string
	 */
	private function buildRemoveList( $user ) {
		$list = '';
		$toc = Linker::tocIndent();
		$tocLength = 0;

		$favorites = FavoriteListInfo::getForUser( $user );

		foreach ( $favorites as $namespace => $pages ) {
			$tocLength++;
			$heading = htmlspecialchars( $this->getNamespaceHeading( $namespace ) );
			$anchor = 'editfavoritelist-ns' . $namespace;

			$list .= Linker::makeHeadLine( 2, '>', $anchor, $heading, '' );
			$toc .= Linker::tocLine( $anchor, $heading, $tocLength, 1 ) . Linker::tocLineEnd();

			$list .= "\n";
			foreach ( $pages as $dbkey => $redirect ) {
				$title = Title::makeTitleSafe( $namespace, $dbkey );
				$list .= $this->buildRemoveLine( $title, $redirect );
			}
			$list .= "\n";
		}

		// ISSUE: omit the TOC if the total number of titles is low?
		if ( $tocLength > 1 ) {
			$list = Linker::tocList( $toc ) . $list;
		}

		return $list;
	}

	/**
	 * Get the correct "heading" for a namespace
	 *
	 * @param int $namespace
	 * @return string
	 */
	private function getNamespaceHeading( $namespace ) {
		return $namespace == NS_MAIN
			? wfMessage( 'blanknamespace' )->text()
			: htmlspecialchars(
				MediaWikiServices::getInstance()->getContentLanguage()->getFormattedNsText( $namespace )
			);
	}

	/**
	 * Build a single list item containing a check box selecting a title
	 * and a link to that title, with various additional bits
	 *
	 * @param Title $title
	 * @param bool $redirect
	 * @return string
	 */
	private function buildRemoveLine( $title, $redirect ) {
		# In case the user adds something unusual to their list using the raw editor
		# We moved the Tools array completely into the "if( $title->exists() )" section.
		$showLinks = false;
		$linkRenderer = MediaWikiServices::getInstance()->getLinkRenderer();

		$link = $linkRenderer->makeLink( $title );
		if ( $redirect ) {
			$link = '<span class="favoritelistredir">' . $link . '</span>';
		}
		if ( $title->exists() ) {
			$showLinks = true;
			// if ( $title->canHaveTalkPage() ) {
			// 	$tools[] = Linker::link( $title->getTalkPage(), wfMessage( 'talkpagelinktext' )->text() );
			// }
			$tools[] = $linkRenderer->makeKnownLink(
				$title,
				wfMessage( 'history_short' )->text(),
				[],
				[ 'action' => 'history' ]
			);
		}
		if ( $title->getNamespace() == NS_USER && !$title->isSubpage() ) {
			$tools[] = $linkRenderer->makeKnownLink(
				SpecialPage::getTitleFor( 'Contributions', $title->getText() ),
				wfMessage( 'contributions' )->text()
			);
		}

		if ( $showLinks ) {
			return Html::check( 'titles[]', false, [ 'value' => $title->getPrefixedText() ] )
				. $link . " (" . RequestContext::getMain()->getLanguage()->pipeList( $tools ) . ")" . "\n<br>";
		} else {
			return Html::check( 'titles[]', false, [ 'value' => $title->getPrefixedText() ] )
				. $link . "\n<br>";
		}
	}

	/**
	 * Show a form for editing the favoritelist in "raw" mode
	 *
	 * @param OutputPage $output
	 * @param User $user
	 */
	public function showRawForm( $output, $user ) {
		$this->showItemCount( $output, $user );
		$self = SpecialPage::getTitleFor( 'Favoritelist' );
		$form  = Html::openElement( 'form', [ 'method' => 'post',
			'action' => $self->getLocalUrl( [ 'action' => 'raw' ] ) ] );
		$form .= Html::hidden( 'token', $user->getEditToken( 'favoritelistedit' ) );
		$form .= '<fieldset><legend>' . wfMessage( 'favoritelistedit-raw-legend' )->text() . '</legend>';
		$form .= wfMessage( 'favoritelistedit-raw-explain' )->parse();
		$form .= "<br /><br />\n";
		$form .= Html::label( wfMessage( 'favoritelistedit-raw-titles' ), 'titles' );
		$form .= "<br />\n";
		$form .= Html::openElement( 'textarea', [ 'id' => 'titles', 'name' => 'titles',
			'rows' => 25, 'cols' => 80 ] );
		$titles = $this->getFavoritelist( $user );
		foreach ( $titles as $title ) {
			$form .= htmlspecialchars( $title ) . "\n";
		}
		$form .= '</textarea>';
		$form .= '<p>' . Html::submitButton( wfMessage( 'favoritelistedit-raw-submit' ), [] ) . '</p>';
		$form .= '</fieldset></form>';
		$output->addHTML( $form );
	}

	/**
	 * Determine whether we are editing the favoritelist, and if so, what
	 * kind of editing operation
	 *
	 * @param WebRequest $request
	 * @param mixed $par
	 * @return int
	 */
	public static function getMode( $request, $par ) {
		$mode = strtolower( $request->getVal( 'action', $par ) );
		switch ( $mode ) {
			case 'clear':
				return self::EDIT_CLEAR;
			case 'raw':
				return self::EDIT_RAW;
			case 'edit':
				return self::EDIT_NORMAL;
			default:
				return false;
		}
	}

	/**
	 * Build a set of links for convenient navigation
	 * between favoritelist viewing and editing modes
	 *
	 * @return string
	 */
	public static function buildTools() {
		$tools = [];
		$modes = [
			'view' => false,
			'edit' => 'edit',
			'raw' => 'raw'
		];
		foreach ( $modes as $mode => $subpage ) {
			// can use messages 'favoritelisttools-view', 'favoritelisttools-edit', 'favoritelisttools-raw'
			$tools[] = MediaWikiServices::getInstance()->getLinkRenderer()->makeKnownLink(
				SpecialPage::getTitleFor( 'Favoritelist', $subpage ),
				wfMessage( "favoritelisttools-{$mode}" )->text()
			);
		}
		return RequestContext::getMain()->getLanguage()->pipeList( $tools );
	}
}
