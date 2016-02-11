<?php
/**
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
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
 */

class SpecialCollection extends SpecialPage {
	public $tempfile;

	/**
	 * @param $PODPartners bool|array
	 */
	public function __construct( $PODPartners = false ) {
		parent::__construct( "Book" );
		global $wgCollectionPODPartners;
		if ( $PODPartners ) {
			$this->mPODPartners = $PODPartners;
		} else {
			$this->mPODPartners = $wgCollectionPODPartners;
		}
	}

	/**
	 * @return String
	 */
	public function getDescription() {
		return $this->msg( 'coll-collection' )->escaped();
	}

	/**
	 * @param $par null|string
	 */
	public function execute( $par ) {
		global $wgCollectionMaxArticles;

		$out = $this->getOutput();
		$request = $this->getRequest();
		$user = $this->getUser();

		// support previous URLs (e.g. used in templates) which used the "$par" part
		// (i.e. subpages of the Special page)
		if ( $par ) {
			if ( $request->wasPosted() ) { // don't redirect POST reqs
				// TODO
			}
			$out->redirect( wfAppendQuery(
				SkinTemplate::makeSpecialUrl( 'Book' ),
				$request->appendQueryArray( array( 'bookcmd' => rtrim( $par, '/' ) ), true )
			) );
			return;
		}

		switch ( $request->getVal( 'bookcmd', '' ) ) {
			case 'book_creator':
				$this->renderBookCreatorPage( $request->getVal( 'referer', '' ), $par );
				return;

			case 'start_book_creator':
				$title = Title::newFromText( $request->getVal( 'referer', '' ) );
				if ( is_null( $title ) ) {
					$title = Title::newMainPage();
				}
				if ( $request->getVal( 'confirm' ) ) {
					CollectionSession::enable();
				}
				$out->redirect( $title->getFullURL() );
				return;
			case 'stop_book_creator':
				$title = Title::newFromText( $request->getVal( 'referer', '' ) );
				if ( is_null( $title ) || $title->equals( $this->getPageTitle( $par ) ) ) {
					$title = Title::newMainPage();
				}
				if ( $request->getVal( 'confirm' ) ) {
					CollectionSession::disable();
				} elseif ( !$request->getVal( 'continue' ) ) {
					$this->renderStopBookCreatorPage( $title );
					return;
				}
				$out->redirect( $title->getFullURL() );
				return;
			case 'add_article':
				if ( CollectionSession::countArticles() >= $wgCollectionMaxArticles ) {
					self::limitExceeded();
					return;
				}
				$oldid = $request->getInt( 'oldid', 0 );
				$title = Title::newFromText( $request->getVal( 'arttitle', '' ) );
				if ( !$title ) {
					return;
				}
				if ( self::addArticle( $title, $oldid ) ) {
					if ( $oldid == 0 ) {
						$redirectURL = $title->getFullURL();
					} else {
						$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
					}
					$out->redirect( $redirectURL );
				} else {
					$out->showErrorPage(
						'coll-couldnotaddarticle_title',
						'coll-couldnotaddarticle_msg'
					);
				}
				return;
			case 'remove_article':
				$oldid = $request->getInt( 'oldid', 0 );
				$title = Title::newFromText( $request->getVal( 'arttitle', '' ) );
				if ( !$title ) {
					return;
				}
				if ( self::removeArticle( $title, $oldid ) ) {
					if ( $oldid == 0 ) {
						$redirectURL = $title->getFullURL();
					} else {
						$redirectURL = $title->getFullURL( 'oldid=' . $oldid );
					}
					$out->redirect( $redirectURL );
				} else {
					$out->showErrorPage(
						'coll-couldnotremovearticle_title',
						'coll-couldnotremovearticle_msg'
					);
				}
				return;
			case 'clear_collection':
				CollectionSession::clearCollection();
				$redirect = $request->getVal( 'return_to' );
				$redirectURL = SkinTemplate::makeSpecialUrl( 'Book' );
				if ( !empty( $redirect ) ) {
					$title = Title::newFromText( $redirect );
					if ( $title ) {
						$redirectURL = $title->getFullURL();
					}
				}
				$out->redirect( $redirectURL );
				return;
			case 'set_titles':
				self::setTitles(
					$request->getText( 'collectionTitle', '' ),
					$request->getText( 'collectionSubtitle', '' )
				);
				$out->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'sort_items':
				self::sortItems();
				$out->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'add_category':
				$title = Title::makeTitleSafe( NS_CATEGORY, $request->getVal( 'cattitle', '' ) );
				if ( !$title ) {
					return;
				} elseif ( self::addCategory( $title ) ) {
					self::limitExceeded();
					return;
				} else {
					$out->redirect( $request->getVal( 'return_to', $title->getFullURL() ) );
				}
				return;
			case 'remove_item':
				self::removeItem( $request->getInt( 'index', 0 ) );
				$out->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'move_item':
				self::moveItem( $request->getInt( 'index', 0 ), $request->getInt( 'delta', 0 ) );
				$out->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
				return;
			case 'load_collection':
				$title = Title::newFromText( $request->getVal( 'colltitle', '' ) );
				if ( !$title ) {
					return;
				}
				if ( $request->getVal( 'cancel' ) ) {
					$out->redirect( $title->getFullURL() );
					return;
				}
				if ( !CollectionSession::countArticles()
					 || $request->getVal( 'overwrite' )
					 || $request->getVal( 'append' ) ) {
					$collection = $this->loadCollection( $title, $request->getVal( 'append' ) );
					if ( $collection ) {
						CollectionSession::startSession();
						CollectionSession::setCollection( $collection );
						CollectionSession::enable();
						$out->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
					}
					return;
				}
				$this->renderLoadOverwritePage( $title );
				return;
			case 'order_collection':
				$title = Title::newFromText( $request->getVal( 'colltitle', '' ) );
				if ( !$title ) {
					return;
				}
				$collection = $this->loadCollection( $title );
				$partner = $request->getVal( 'partner', key( $this->mPODPartners ) );
				$this->postZIP( $collection, $partner );
				return;
			case 'save_collection':
				if ( $request->getVal( 'abort' ) ) {
					$out->redirect( SkinTemplate::makeSpecialUrl( 'Book' ) );
					return;
				}
				if ( !$user->matchEditToken( $request->getVal( 'token' ) ) ) {
					return;
				}
				$colltype = $request->getVal( 'colltype' );
				$prefixes = self::getBookPagePrefixes();
				$title = null;
				if ( $colltype == 'personal' ) {
					$collname = $request->getVal( 'pcollname' );
					if ( !$user->isAllowed( 'collectionsaveasuserpage' ) || empty( $collname ) ) {
						return;
					}
					$title = Title::newFromText( $prefixes['user-prefix'] . $collname );
				} elseif ( $colltype == 'community' ) {
					$collname = $request->getVal( 'ccollname' );
					if ( !$user->isAllowed( 'collectionsaveascommunitypage' ) || empty( $collname ) ) {
						return;
					}
					$title = Title::newFromText( $prefixes['community-prefix'] . $collname );
				}
				if ( !$title ) {
					return;
				}
				if ( $this->saveCollection( $title, $request->getBool( 'overwrite' ) ) ) {
					$out->redirect( $title->getFullURL() );
				} else {
					$this->renderSaveOverwritePage(
						$colltype,
						$title,
						$request->getVal( 'pcollname' ),
						$request->getVal( 'ccollname' )
					);
				}
				return;
			case 'render':
				$this->renderCollection(
					CollectionSession::getCollection(),
					SpecialPage::getTitleFor( 'Book' ),
					$request->getVal( 'writer', '' )
				);
				return;
			case 'forcerender':
				$this->forceRenderCollection();
				return;
			case 'rendering':
				$this->renderRenderingPage();
				return;
			case 'download':
				$this->download();
				return;
			case 'render_article':
				$title = Title::newFromText( $request->getVal( 'arttitle', '' ) );
				if ( !$title ) {
					return;
				}
				$oldid = $request->getInt( 'oldid', 0 );
				$collection = $this->makeCollection( $title, $oldid );
				if ( $collection ) {
					$this->applySettings( $collection, $request );
					$this->renderCollection( $collection, $title, $request->getVal( 'writer', 'rl' ) );
				}
				return;
			case 'render_collection':
				$title = Title::newFromText( $request->getVal( 'colltitle', '' ) );
				if ( !$title ) {
					return;
				}
				$collection = $this->loadCollection( $title );
				if ( $collection ) {
					$this->applySettings( $collection, $request );
					$this->renderCollection( $collection, $title, $request->getVal( 'writer', 'rl' ) );
				}
				return;
			case 'post_zip':
				$partner = $request->getVal( 'partner', 'pediapress' );
				$this->postZIP( CollectionSession::getCollection(), $partner );
				return;
			case 'suggest':
				$add = $request->getVal( 'add' );
				$ban = $request->getVal( 'ban' );
				$remove = $request->getVal( 'remove' );
				$addselected = $request->getVal( 'addselected' );

				if ( $request->getVal( 'resetbans' ) ) {
					CollectionSuggest::run( 'resetbans' );
				} elseif ( isset( $add ) ) {
					CollectionSuggest::run( 'add', $add );
				} elseif ( isset( $ban ) ) {
					CollectionSuggest::run( 'ban', $ban );
				} elseif ( isset( $remove ) ) {
					CollectionSuggest::run( 'remove', $remove );
				} elseif ( isset( $addselected ) ) {
					$articleList = $request->getArray( 'articleList' );
					if ( !is_null( $articleList ) ) {
						CollectionSuggest::run( 'addAll', $articleList );
					} else {
						CollectionSuggest::run();
					}
				} else {
					CollectionSuggest::run();
				}
				return;
			case '':
				$this->renderSpecialPage();
				return;
			default:
				$out->showErrorPage( 'coll-unknown_subpage_title', 'coll-unknown_subpage_text' );
		}
	}

	/**
	 * @param $referer
	 * @param $par
	 * @return mixed
	 */
	public function renderBookCreatorPage( $referer, $par ) {
		$out = $this->getOutput();
		$out->enableOOUI();

		$this->setHeaders();
		$out->setPageTitle( $this->msg( 'coll-book_creator' ) );

		$out->addWikiMsg( 'coll-book_creator_intro' );

		$out->addModules( 'ext.collection.checkLoadFromLocalStorage' );

		$title = Title::newFromText( $referer );
		if ( is_null( $title ) || $title->equals( $this->getPageTitle( $par ) ) ) {
			$title = Title::newMainPage();
		}

		$form = new OOUI\FormLayout( array(
			'method' => 'POST',
			'action' => SkinTemplate::makeSpecialUrl(
				'Book',
				array(
					'bookcmd' => 'start_book_creator',
					'referer' => $referer,
				)
			),
		) );
		$form->appendContent( new OOUI\ButtonGroupWidget( array(
			'items' => array(
				new OOUI\ButtonInputWidget( array(
					'type' => 'submit',
					'name' => 'confirm',
					'value' => 'yes',
					'flags' => array( 'primary', 'progressive' ),
					'label' => $this->msg( 'coll-start_book_creator' )->text(),
				) ),
				new OOUI\ButtonWidget( array(
					'href' => $title->getLinkURL(),
					'title' => $title->getPrefixedText(),
					'label' => $this->msg( 'coll-cancel' )->text(),
					'noFollow' => true,
				) ),
			),
		) ) );

		$out->addHTML( $form );

		$title_string = $this->msg( 'coll-book_creator_text_article' )->inContentLanguage()->text();
		$t = Title::newFromText( $title_string );
		if ( !is_null( $t ) ) {
			$wikiPage = WikiPage::factory( $t );
			if ( $wikiPage->exists() ) {
				$out->addWikiText( '{{:' . $title_string . '}}' );
				return;
			}
		}
		$out->addWikiMsg( 'coll-book_creator_help' );
	}

	/**
	 * @param $referer
	 */
	public function renderStopBookCreatorPage( $referer ) {
		$out = $this->getOutput();
		$out->enableOOUI();

		$this->setHeaders();
		$out->setPageTitle( $this->msg( 'coll-book_creator_disable' ) );
		$out->addWikiMsg( 'coll-book_creator_disable_text' );

		$form = new OOUI\FormLayout( array(
			'method' => 'POST',
			'action' => SkinTemplate::makeSpecialUrl(
				'Book',
				array(
					'bookcmd' => 'stop_book_creator',
					'referer' => $referer,
				)
			),
		) );
		$form->appendContent( new OOUI\ButtonGroupWidget( array(
			'items' => array(
				new OOUI\ButtonInputWidget( array(
					'type' => 'submit',
					'name' => 'continue',
					'value' => 'yes',
					'label' => $this->msg( 'coll-book_creator_continue' )->text(),
				) ),
				new OOUI\ButtonInputWidget( array(
					'type' => 'submit',
					'name' => 'confirm',
					'value' => 'yes',
					'label' => $this->msg( 'coll-book_creator_disable' )->text(),
					'flags' => array( 'primary', 'destructive' ),
				) ),
			),
		) ) );

		$out->addHTML( $form );
	}

	/**
	 * @return array
	 */
	public static function getBookPagePrefixes() {
		global $wgUser, $wgCommunityCollectionNamespace;

		$result = array();

		$t = wfMessage( 'coll-user_book_prefix', $wgUser->getName() )->inContentLanguage();
		if ( $t->isDisabled()  ) {
			$userPageTitle = $wgUser->getUserPage()->getPrefixedText();
			$result['user-prefix'] = $userPageTitle . '/'
				. wfMessage( 'coll-collections' )->inContentLanguage()->text() . '/';
		} else {
			$result['user-prefix'] = $t->text();
		}

		$comBookPrefix = wfMessage( 'coll-community_book_prefix' )->inContentLanguage();
		if ( $comBookPrefix->isDisabled() ) {
			$title = Title::makeTitle(
				$wgCommunityCollectionNamespace,
				wfMessage( 'coll-collections' )->inContentLanguage()->text()
			);
			$result['community-prefix'] = $title->getPrefixedText() . '/';
		} else {
			$result['community-prefix'] = $comBookPrefix->text();
		}
		return $result;
	}

	public function renderSpecialPage() {
		global $wgCollectionFormats, $wgCollectionRendererSettings;

		if ( !CollectionSession::hasSession() ) {
			CollectionSession::startSession();
		}

		$out = $this->getOutput();

		$this->setHeaders();
		$out->setPageTitle( $this->msg( 'coll-manage_your_book' )->text() );
		$out->addModules( 'ext.collection' );

		$template = new CollectionPageTemplate();
		$template->set( 'context', $this->getContext() );
		$template->set( 'collection', CollectionSession::getCollection() );
		$template->set( 'podpartners', $this->mPODPartners );
		$template->set( 'settings', $wgCollectionRendererSettings );
		$template->set( 'formats', $wgCollectionFormats );
		$prefixes = self::getBookPagePrefixes();
		$template->set( 'user-book-prefix', $prefixes['user-prefix'] );
		$template->set( 'community-book-prefix', $prefixes['community-prefix'] );
		$out->addTemplate( $template );
	}

	/**
	 * @param $title string
	 * @param $subtitle string
	 */
	public static function setTitles( $title, $subtitle ) {
		$collection = CollectionSession::getCollection();
		$collection['title'] = $title;
		$collection['subtitle'] = $subtitle;
		CollectionSession::setCollection( $collection );
	}

	/**
	 * @param array $settings
	 */
	public static function setSettings( array $settings ) {
		$collection = CollectionSession::getCollection();
		if ( !isset( $collection['settings'] ) ) {
			$collection['settings'] = array();
		}
		$collection['settings'] = $settings + $collection['settings'];
		CollectionSession::setCollection( $collection );
	}

	/**
	 * @param $a array
	 * @param $b array
	 * @return int
	 */
	public static function title_cmp( $a, $b ) {
		return strcasecmp( $a['title'], $b['title'] );
	}

	public static function sortItems() {
		$collection = CollectionSession::getCollection();
		if ( !isset( $collection['items'] ) || !is_array( $collection['items'] ) ) {
			$collection['items'] = array();
			CollectionSession::setCollection( $collection );
			return;
		}
		$articles = array();
		$new_items = array();
		foreach ( $collection['items'] as $item ) {
			if ( $item['type'] == 'chapter' ) {
				usort( $articles, array( __CLASS__, 'title_cmp' ) );
				$new_items = array_merge( $new_items, $articles, array( $item ) );
				$articles = array();
			} elseif ( $item['type'] == 'article' ) {
				$articles[] = $item;
			}
		}
		usort( $articles, array( __CLASS__, 'title_cmp' ) );
		$collection['items'] = array_merge( $new_items, $articles );
		CollectionSession::setCollection( $collection );
	}

	/**
	 * @param $name string
	 */
	public static function addChapter( $name ) {
		$collection = CollectionSession::getCollection();
		if ( !isset( $collection['items'] ) || !is_array( $collection['items'] ) ) {
			$collection['items'] = array();
		}
		array_push( $collection['items'], array(
			'type' => 'chapter',
			'title' => $name,
		) );
		CollectionSession::setCollection( $collection );
	}

	/**
	 * @param $index int
	 * @param $name string
	 */
	public static function renameChapter( $index, $name ) {
		if ( !is_int( $index ) ) {
			return;
		}
		$collection = CollectionSession::getCollection();
		if ( $collection['items'][$index]['type'] != 'chapter' ) {
			return;
		}
		$collection['items'][$index]['title'] = $name;
		CollectionSession::setCollection( $collection );
	}

	/**
	 * @param $namespace int
	 * @param $name string
	 * @param int $oldid
	 * @return bool
	 */
	public static function addArticleFromName( $namespace, $name, $oldid = 0 ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		if ( !$title ) {
			return false;
		}
		return self::addArticle( $title, $oldid );
	}

	/**
	 * @param $title Title
	 * @param $oldid int
	 * @return bool
	 */
	public static function addArticle( $title, $oldid = 0 ) {

		$latest = $title->getLatestRevID();

		$currentVersion = 0;
		if ( $oldid == 0 ) {
			$currentVersion = 1;
			$oldid = $latest;
		}

		$prefixedText = $title->getPrefixedText();

		$index = CollectionSession::findArticle( $prefixedText, $oldid );
		if ( $index != - 1 ) {
			return false;
		}

		if ( !CollectionSession::hasSession() ) {
			CollectionSession::startSession();
		}
		$collection = CollectionSession::getCollection();
		$revision = Revision::newFromTitle( $title, $oldid );
		if ( !$revision ) {
			return false;
		}

		$item = array(
			'type' => 'article',
			'content_type' => 'text/x-wiki',
			'title' => $prefixedText,
			'revision' => strval( $oldid ),
			'latest' => strval( $latest ),
			'timestamp' => wfTimestamp( TS_UNIX, $revision->getTimestamp() ),
			'url' => $title->getCanonicalURL(),
			'currentVersion' => $currentVersion,
		);

		$collection['items'][] = $item;
		CollectionSession::setCollection( $collection );
		return true;
	}

	/**
	 * @param $namespace string
	 * @param $name string
	 * @param $oldid int
	 * @return bool
	 */
	public static function removeArticleFromName( $namespace, $name, $oldid = 0 ) {
		$title = Title::makeTitleSafe( $namespace, $name );
		return self::removeArticle( $title, $oldid );
	}

	/**
	 * @param $title Title
	 * @param $oldid int
	 * @return bool
	 */
	public static function removeArticle( $title, $oldid = 0 ) {
		if ( !CollectionSession::hasSession() || !$title ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		$index = CollectionSession::findArticle( $title->getPrefixedText(), $oldid );
		if ( $index != - 1 ) {
			array_splice( $collection['items'], $index, 1 );
		}
		CollectionSession::setCollection( $collection );
		return true;
	}

	/**
	 * @param $name string
	 * @return bool
	 */
	public static function addCategoryFromName( $name ) {
		$title = Title::makeTitleSafe( NS_CATEGORY, $name );
		return self::addCategory( $title );
	}

	/**
	 * @param $title Title
	 * @return bool
	 */
	public static function addCategory( $title ) {
		global $wgCollectionMaxArticles, $wgCollectionArticleNamespaces;

		$limit = $wgCollectionMaxArticles - CollectionSession::countArticles();
		if ( $limit <= 0 || !$title ) {
			self::limitExceeded();
			return false;
		}
		$db = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'categorylinks' );
		$fields = array( 'page_namespace', 'page_title' );
		$options = array(
			'USE INDEX' => 'cl_sortkey',
			'ORDER BY' => 'cl_type, cl_sortkey',
			'LIMIT' => $limit + 1,
		);
		$where = array(
			'cl_from=page_id',
			'cl_to' => $title->getDBkey(),
		);
		$res = $db->select( $tables, $fields, $where, __METHOD__, $options );

		$count = 0;
		$limitExceeded = false;
		foreach ( $res as $row ) {
			if ( ++$count > $limit ) {
				$limitExceeded = true;
				break;
			}
			if ( in_array( $row->page_namespace, $wgCollectionArticleNamespaces ) ) {
				$articleTitle = Title::makeTitle( $row->page_namespace, $row->page_title );
				if ( CollectionSession::findArticle( $articleTitle->getPrefixedText() ) == - 1 ) {
					self::addArticle( $articleTitle );
				}
			}
		}
		$db->freeResult( $res );
		return $limitExceeded;
	}

	public static function limitExceeded() {
		global $wgOut;

		$wgOut->showErrorPage( 'coll-limit_exceeded_title', 'coll-limit_exceeded_text' );
	}

	/**
	 * @param $index int
	 * @return bool
	 */
	public static function removeItem( $index ) {
		if ( !is_int( $index ) ) {
			return false;
		}
		if ( !CollectionSession::hasSession() ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		array_splice( $collection['items'], $index, 1 );
		CollectionSession::setCollection( $collection );
		return true;
	}

	/**
	 * @param $index
	 * @param $delta
	 * @return bool
	 */
	public static function moveItem( $index, $delta ) {
		if ( !CollectionSession::hasSession() ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		$saved = $collection['items'][$index + $delta];
		$collection['items'][$index + $delta] = $collection['items'][$index];
		$collection['items'][$index] = $saved;
		CollectionSession::setCollection( $collection );
		return true;
	}

	/**
	 * @param $items array
	 */
	public static function setSorting( $items ) {
		if ( !CollectionSession::hasSession() ) {
			return;
		}
		$collection = CollectionSession::getCollection();
		$old_items = $collection['items'];
		$new_items = array();
		foreach ( $items as $new_index => $old_index ) {
			$new_items[$new_index] = isset( $old_items[$old_index] ) ? $old_items[$old_index] : null;
		}
		$collection['items'] = $new_items;
		CollectionSession::setCollection( $collection );
	}

	/**
	 * @param $collection
	 * @param $line
	 * @param $append
	 * @return array|null
	 */
	public function parseCollectionLine( &$collection, $line, $append ) {
		$line = trim( $line );
		if ( !$append && preg_match( '/^===\s*(.*?)\s*===$/', $line, $match ) ) {
			$collection['subtitle'] = $match[ 1 ];
		} elseif ( !$append && preg_match( '/^==\s*(.*?)\s*==$/', $line, $match ) ) {
			$collection['title'] = $match[ 1 ];
		} elseif ( !$append && preg_match( '/^\s*\|\s*setting-([a-zA-Z0-9_-]+)\s*=\s*([^|]*)\s*$/', $line, $match ) ) {
			$collection['settings'][$match[ 1 ]] = $match[ 2 ];
		} elseif ( substr( $line, 0, 1 ) == ';' ) { // chapter
			return array(
				'type' => 'chapter',
				'title' => trim( substr( $line, 1 ) ),
			);
		} elseif ( substr( $line, 0, 1 ) == ':' ) { // article
			$articleTitle = trim( substr( $line, 1 ) );
			if ( preg_match( '/^\[\[:?(.*?)(\|(.*?))?\]\]$/', $articleTitle, $match ) ) {
				$articleTitle = $match[1];
				if ( isset( $match[3] ) ) {
					$displayTitle = $match[3];
				} else {
					$displayTitle = null;
				}
				$oldid = - 1;
				$currentVersion = 1;
			} elseif ( preg_match( '/^\[\{\{fullurl:(.*?)\|oldid=(.*?)\}\}\s+(.*?)\]$/', $articleTitle, $match ) ) {
				$articleTitle = $match[1];
				if ( isset( $match[3] ) ) {
					$displayTitle = $match[3];
				} else {
					$displayTitle = null;
				}
				$oldid = $match[2];
				$currentVersion = 0;
			} else {
				return null;
			}

			$articleTitle = Title::newFromText( $articleTitle );
			if ( !$articleTitle ) {
				return null;
			}
			if ( $oldid < 0 ) {
				$article = new Article( $articleTitle, 0 );
			} else {
				$article = new Article( $articleTitle, $oldid );
			}
			if ( !$article->exists() ) {
				return null;
			}

			$revision = Revision::newFromTitle( $articleTitle, $article->getOldID() );
			if ( !$revision ) {
				return null;
			}
			$latest = $article->getLatest();
			$oldid = $article->getOldID();

			if ( !$oldid ) {
				$oldid = $latest;
			}

			$d = array(
				'type' => 'article',
				'content_type' => 'text/x-wiki',
				'title' => $articleTitle->getPrefixedText(),
				'latest' => $latest,
				'revision' => $oldid,
				'timestamp' => wfTimestamp( TS_UNIX, $revision->getTimestamp() ),
				'url' => $articleTitle->getCanonicalURL(),
				'currentVersion' => $currentVersion,
			);
			if ( $displayTitle ) {
				$d['displaytitle'] = $displayTitle;
			}
			return $d;
		}
		return null;
	}

	/**
	 * @param $title Title
	 * @param $append bool
	 * @return array|bool
	 */
	public function loadCollection( $title, $append = false ) {
		$out = $this->getOutput();

		if ( is_null( $title ) ) {
			$out->showErrorPage( 'coll-notitle_title', 'coll-notitle_msg' );
			return null;
		}

		if ( !$title->exists() ) {
			$out->showErrorPage( 'coll-notfound_title', 'coll-notfound_msg' );
			return false;
		}

		if ( !$append || !CollectionSession::hasSession() ) {
			$collection = array(
				'title' => '',
				'subtitle' => '',
				'settings' => array(),
			);
			$items = array();
		} else {
			$collection = CollectionSession::getCollection();
			$items = $collection['items'];
		}

		$article = new Article( $title );

		foreach ( preg_split( '/[\r\n]+/', $article->getContent() ) as $line ) {
			$item = $this->parseCollectionLine( $collection, $line, $append );
			if ( !is_null( $item ) ) {
				$items[] = $item;
			}
		}
		$collection['items'] = $items;
		return $collection;
	}

	/**
	 * @param $title Title
	 * @param $forceOverwrite bool
	 * @return bool
	 */
	public function saveCollection( $title, $forceOverwrite = false ) {
		$wikiPage = WikiPage::factory( $title );
		if ( $wikiPage->exists() && !$forceOverwrite ) {
			return false;
		}
		$collection = CollectionSession::getCollection();
		$articleText = "{{" . $this->msg( 'coll-savedbook_template' )->inContentLanguage()->text();
		if ( !empty( $collection['settings'] ) ) {
			$articleText .= "\n";
			foreach ( $collection['settings'] as $key => $value ) {
				$articleText .= " | setting-$key = $value\n";
			}
		}
		$articleText .= "}}\n\n";
		if ( $collection['title'] ) {
			$articleText .= '== ' . $collection['title'] . " ==\n";
		}
		if ( $collection['subtitle'] ) {
			$articleText .= '=== ' . $collection['subtitle'] . " ===\n";
		}
		if ( !empty( $collection['items'] ) ) {
			foreach ( $collection['items'] as $item ) {
				if ( $item['type'] == 'chapter' ) {
					$articleText .= ';' . $item['title'] . "\n";
				} elseif ( $item['type'] == 'article' ) {
					if ( $item['currentVersion'] == 1 ) {
						$articleText .= ":[[" . $item['title'];
						if ( isset( $item['displaytitle'] ) && $item['displaytitle'] ) {
							$articleText .= "|" . $item['displaytitle'];
						}
						$articleText .= "]]\n";
					} else {
						$articleText .= ":[{{fullurl:" . $item['title'];
						$articleText .= "|oldid=" . $item['revision'] . "}} ";
						if ( isset( $item['displaytitle'] ) && $item['displaytitle'] ) {
							$articleText .= $item['displaytitle'];
						} else {
							$articleText .= $item['title'];
						}
						$articleText .= "]\n";
					}
				}
				// $articleText .= $item['revision'] . "/" . $item['latest']."\n";
			}
		}
		$t = $this->msg( 'coll-bookscategory' )->inContentLanguage();
		if ( !$t->isDisabled() ) {
			$catTitle = Title::makeTitle( NS_CATEGORY, $t->text() );
			if ( !is_null( $catTitle ) ) {
				$articleText .= "\n[[" . $catTitle->getPrefixedText() . "|" . wfEscapeWikiText( $title->getSubpageText() ) . "]]\n";
			}
		}

		$req = new DerivativeRequest(
			$this->getRequest(),
			array(
				'action' => 'edit',
				'title' => $title->getPrefixedText(),
				'text' => $articleText,
				'token' => $this->getUser()->getEditToken(),
		), true);
		$api = new ApiMain( $req, true );
		$api->execute();
		return true;
	}

	/**
	 * Take an array of arrays, each containing information about one item to be
	 * assembled and exported, and appropriately feed the backend chosen ($writer).
	 * @param $collection array following the collection/Metabook dictionary formats
	 * https://www.mediawiki.org/wiki/Offline_content_generator/metabook.json
	 * https://mwlib.readthedocs.org/en/latest/internals.html#article
	 * @param $referrer Title object, used only to provide a returnto parameter.
	 * @param $writer A writer registered in the appropriate configuration.
	 */
	public function renderCollection( $collection, Title $referrer, $writer ) {
		if ( !$writer ) {
			$writer = 'rl';
		}

		$api = CollectionRenderingAPI::instance( $writer );
		$response = $api->render( $collection );

		if ( !$this->handleResult( $response ) ) {
			return;
		}

		$query = 'bookcmd=rendering'
			. '&return_to=' . urlencode( $referrer->getPrefixedText() )
			. '&collection_id=' . urlencode( $response->get( 'collection_id' ) )
			. '&writer=' . urlencode( $writer );
		if ( $response->get( 'is_cached' ) ) {
			$query .= '&is_cached=1';
		}
		$redirect = SkinTemplate::makeSpecialUrl( 'Book', $query );
		$this->getOutput()->redirect( $redirect );
	}

	public function forceRenderCollection() {
		$request = $this->getRequest();

		$collectionID = $request->getVal( 'collection_id', '' );
		$writer = $request->getVal( 'writer', 'rl' );

		$api = CollectionRenderingAPI::instance( $writer );
		$response = $api->forceRender( $collectionID );

		if ( !$response ) {
			return;
		}

		$query = 'bookcmd=rendering'
			. '&return_to=' . urlencode( $request->getVal( 'return_to', '' ) )
			. '&collection_id=' . urlencode( $response->response['collection_id'] )
			. '&writer=' . urlencode( $response->response['writer'] );
		if ( $response->response['is_cached'] ) {
			$query .= '&is_cached=1';
		}
		$this->getOutput()->redirect( SkinTemplate::makeSpecialUrl( 'Book', $query ) );
	}

	public function renderRenderingPage() {
		$this->setHeaders();
		$request = $this->getRequest();
		$out = $this->getOutput();

		$collectionId = $request->getVal( 'collection_id' );
		$writer = $request->getVal( 'writer' );
		$return_to = $request->getVal( 'return_to', '' );

		$result = CollectionRenderingAPI::instance( $writer )->getRenderStatus( $collectionId, $writer );
		if ( !$this->handleResult( $result ) ) {
			return; // FIXME?
		}

		$query = 'collection_id=' . urlencode( $collectionId )
			. '&writer=' . urlencode( $writer )
			. '&return_to=' . urlencode( $return_to );

		switch ( $result->get( 'state' ) ) {
		case 'pending':
		case 'progress':
			$out->addHeadItem( 'refresh-nojs', '<noscript><meta http-equiv="refresh" content="2" /></noscript>' );
			$out->addInlineScript( 'var collection_id = "' . urlencode( $collectionId ) . '";' );
			$out->addInlineScript( 'var writer = "' . urlencode( $writer ) . '";' );
			$out->addInlineScript( 'var collection_rendering = true;' );
			$out->addModules( 'ext.collection' );
			$out->setPageTitle( $this->msg( 'coll-rendering_title' ) );

			$statusText = $result->get( 'status', 'status' );
			if ( $statusText ) {
				if ( $result->get( 'status', 'article' ) ) {
					$statusText .= ' ' . $this->msg( 'coll-rendering_article', $result->get( 'status', 'article' ) )->text();
				} elseif ( $result->get( 'status', 'page' ) ) {
					$statusText .= ' ';
					$statusText .= $this->msg( 'coll-rendering_page' )->numParams( $result->get( 'status', 'page' ) )->text();
				}
				$status = $this->msg( 'coll-rendering_status', $statusText )->text();
			} else {
				$status = '';
			}

			$template = new CollectionRenderingTemplate();
			$template->set( 'status', $status );
			$progress = $result->get( 'status', 'progress' );
			if ( !$progress ) {
				$progress = 0.00;
			}
			$template->set( 'progress', $progress );
			$out->addTemplate( $template );
			break;
		case 'finished':
			$out->setPageTitle( $this->msg( 'coll-rendering_finished_title' ) );

			$template = new CollectionFinishedTemplate();
			$template->set( 'download_url', wfExpandUrl( SkinTemplate::makeSpecialUrl( 'Book', 'bookcmd=download&' . $query ), PROTO_CURRENT ) );
			$template->set( 'is_cached', $request->getVal( 'is_cached' ) );
			$template->set( 'query', $query );
			$template->set( 'return_to', $return_to );
			$out->addTemplate( $template );
			break;
		case 'failed':
			$out->setPageTitle( $this->msg( 'coll-rendering_failed_title' ) );

			$statusText = $result->get( 'status', 'status' );
			if ( $statusText ) {
				$status = $this->msg( 'coll-rendering_failed_status', $statusText )->text();
			} else {
				$status = '';
			}

			$template = new CollectionFailedTemplate();
			$template->set( 'status', $status );
			$template->set( 'query', $query );
			$template->set( 'return_to', $return_to );
			$out->addTemplate( $template );
			break;
		default:
			throw new Exception( __METHOD__ . "(): unknown state '{$result->get( 'state' )}'");
		}
	}

	public function download() {
		global $wgCollectionContentTypeToFilename;

		$request = $this->getRequest();
		$collectionId = $request->getVal( 'collection_id' );
		$writer = $request->getVal( 'writer' );
		$api = CollectionRenderingAPI::instance( $writer );

		$this->tempfile = tmpfile();
		$r = $api->getRenderStatus( $collectionId, $writer );

		$info = false;
		$url = $r->get( 'url' );
		if ( $url ) {
			$req = MWHttpRequest::factory( $url );
			$req->setCallback( array( $this, 'writeToTempFile' ) );
			if ( $req->execute()->isOK() ) {
				$info = true;
			}
			$content_type = $r->get( 'content_type' );
			$content_length = $r->get( 'content_length' );
			$content_disposition = $r->get( 'content_disposition' );
		} else {
			$info = $api->download( $collectionId, $writer );
			$content_type = $info->get( 'content_type' );
			$content_length = $info->get( 'download_content_length' );
			$content_disposition = null;
			if ( $info->isError() ) {
				$info = false;
			}
		}
		if ( !$info ) {
			$this->getOutput()->showErrorPage( 'coll-download_notfound_title', 'coll-download_notfound_text' );
			return;
		}
		wfResetOutputBuffers();
		header( 'Content-Type: ' . $content_type );
		header( 'Content-Length: ' . $content_length );
		if ( $content_disposition ) {
			header( 'Content-Disposition: ' . $content_disposition );
		} else {
			$ct_enc = explode( ';', $content_type );
			$ct = $ct_enc[0];
			if ( isset( $wgCollectionContentTypeToFilename[$ct] ) ) {
				header( 'Content-Disposition: ' . 'inline; filename=' . $wgCollectionContentTypeToFilename[$ct] );
			}
		}
		fseek( $this->tempfile, 0 );
		fpassthru( $this->tempfile );
		$this->getOutput()->disable();
	}

	/**
	 * @param $res
	 * @param $content
	 * @return int
	 */
	public function writeToTempFile( $res, $content ) {
		return fwrite( $this->tempfile, $content );
	}

	/**
	 * Render a single page: fetch page name and revision information, then
	 * assemble and feed to renderCollection() a single-item $collection.
	 * @param $title Title needs to be full page name aka prefixed title.
	 * @param $oldid int
	 * @param $writer A writer registered in the appropriate configuration.
	 * @return array|null
	 */
	public function makeCollection( $title, $oldid ) {
		if ( is_null( $title ) ) {
			$this->getOutput()->showErrorPage( 'coll-notitle_title', 'coll-notitle_msg' );
			return null;
		}
		$article = array(
			'type' => 'article',
			'content_type' => 'text/x-wiki',
			'title' => $title->getPrefixedText()
		);
		if ( $oldid ) {
			$article['revision'] = strval( $oldid );
		}

		$revision = Revision::newFromTitle( $title, $oldid );
		if ( $revision ) {
			$article['timestamp'] = wfTimestamp( TS_UNIX, $revision->getTimestamp() );
		}
		return array( 'items' => array( $article ) );
	}

	/**
	 * Apply query string parameters to the given collection.
	 * Use defaults specified in $wgCollectionRendererSettings.
	 * @param $collection
	 * @param $request
	 */
	public function applySettings( &$collection, &$request ) {
		global $wgCollectionRendererSettings;
		if ( !isset( $collection['settings'] ) ) {
			$collection['settings'] = array();
		}
		foreach ( $wgCollectionRendererSettings as $key => $desc ) {
			if ( $desc['type'] != 'select') {
				continue;
			}
			$val = $request->getVal( $key );
			if ( !isset( $collections['settings'][$key] ) ) {
				$collection['settings'][$key] = $desc['default'];
			}
			if ( !is_null( $val ) ) {
				foreach ( $desc['options'] as $ignore => $valid ) {
					if ( $val == $valid ) {
						$collection['settings'][$key] = $valid;
					}
				}
			}
		}
	}

	/**
	 * @param $collection
	 * @param $partner
	 */
	public function postZIP( $collection, $partner ) {
		$out = $this->getOutput();
		if ( !isset( $this->mPODPartners[$partner] ) ) {
			$out->showErrorPage( 'coll-invalid_podpartner_title', 'coll-invalid_podpartner_msg' );
			return;
		}

		$api = CollectionRenderingAPI::instance();
		$result = $api->postZip( $collection, $this->mPODPartners[$partner]['posturl'] );
		if ( !$this->handleResult( $result ) ) {
			return;
		}
		if ( $result->get( 'redirect_url' ) ) {
			$out->redirect( $result->get( 'redirect_url' ) );
		}
	}

	/**
	 * @param $colltype
	 * @param $title
	 * @param $pcollname
	 * @param $ccollname
	 */
	private function renderSaveOverwritePage( $colltype, $title, $pcollname, $ccollname ) {
		$this->setHeaders();
		$this->getOutput()->setPageTitle( $this->msg( 'coll-save_collection' ) );

		$template = new CollectionSaveOverwriteTemplate();
		$template->set( 'title', $title );
		$template->set( 'pcollname', $pcollname );
		$template->set( 'ccollname', $ccollname );
		$template->set( 'colltype', $colltype );
		$this->getOutput()->addTemplate( $template );
	}

	/**
	 * @param $title
	 */
	private function renderLoadOverwritePage( $title ) {
		$this->setHeaders();
		$this->getOutput()->setPageTitle( $this->msg( 'coll-load_collection' ) );

		$template = new CollectionLoadOverwriteTemplate();
		$template->set( 'title', $title );
		$this->getOutput()->addTemplate( $template );
	}

	/**
	 * @param CollectionAPIResult $result
	 *
	 * @return bool: Whether the result had errors
	 */
	private function handleResult( $result ) {
		if ( !$result->isError() ) {
			return true;
		}
		$this->getOutput()->showErrorPage(
			'coll-request_failed_title',
			'coll-request_failed_msg'
		);
		return false;
	}

	protected function getGroupName() {
		return 'pagetools';
	}
}
