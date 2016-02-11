<?php
/**
 * @defgroup Templates Templates
 * @file
 * @ingroup Templates
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

/**
 * HTML template for Special:Book
 * @ingroup Templates
 */
class CollectionPageTemplate extends QuickTemplate {
	public function execute() {
		$data = array(
			'collectionTitle' => $this->data['collection']['title'],
			'collectionSubtitle' => $this->data['collection']['subtitle'],
		);
		$fields = array(
			'collectionTitle' => array(
				'type' => 'text',
				'label-message' => 'coll-title',
				'id' => 'titleInput',
				'size' => '',
				'name' => 'collectionTitle',
			),
			'collectionSubtitle' => array(
				'type' => 'text',
				'label-message' => 'coll-subtitle',
				'id' => 'subtitleInput',
				'size' => '',
				'name' => 'collectionSubtitle',
			),
		);
		foreach ( $this->data['settings'] as $fieldname => $descriptor ) {
			if ( isset( $descriptor['options'] ) && is_array( $descriptor['options'] ) ) {
				$options = array();
				foreach ( $descriptor['options'] as $msg => $value ) {
					$msg = wfMessage( $msg )->text();
					$options[$msg] = $value;
				}
				$descriptor['options'] = $options;
			}
			$descriptor['id'] = "coll-input-setting-$fieldname";
			$descriptor['name'] = $fieldname;
			$fields[$fieldname] = $descriptor;
			if ( isset( $this->data['collection']['settings'][$fieldname] ) ) {
				$data[$fieldname] = $this->data['collection']['settings'][$fieldname];
			}
		}

		$context = new DerivativeContext( $this->data['context'] );
		$context->setRequest( new FauxRequest( $data ) );
		$form = new HTMLForm( $fields, $context );
		$form->setMethod( 'post' )
			->addHiddenField( 'bookcmd', 'set_titles' )
			->suppressDefaultSubmit()
			->setTitle( SpecialPage::getTitleFor( 'Book' ) )
			->setId( 'mw-collection-title-form' )
			->setTableId( 'mw-collection-title-table' )
			->setFooterText(
				'<noscript>' .
				'<input type="submit" value="' . $this->msg( 'coll-update' ) . '" />' .
				'</noscript>'
			)
			->prepareForm();
?>

<div class="collection-column collection-column-left">

<?php echo $form->getHTML( '' ) ?>

<div id="collectionListContainer">
<?php
$listTemplate = new CollectionListTemplate();
$listTemplate->set( 'collection', $this->data['collection'] );
$listTemplate->execute();
?>
</div>
<div style="display:none">
	<span id="newChapterText"><?php $this->msg( 'coll-new_chapter' ) ?></span>
	<span id="renameChapterText"><?php $this->msg( 'coll-rename_chapter' ) ?></span>
	<span id="clearCollectionConfirmText"><?php $this->msg( 'coll-clear_collection_confirm' ) ?></span>
</div>

</div>

<div class="collection-column collection-column-right">
<?php if ( $this->data['podpartners'] ) { ?>
	<div class="collection-column-right-box" id="coll-orderbox">
		<h2><span class="mw-headline"><?php $this->msg( 'coll-book_title' ) ?></span></h2>
		<?php
$this->msgWiki( 'coll-book_text' );
		?>
	<ul>
<?php
foreach ( $this->data['podpartners'] as $partnerKey => $partnerData ) {
	$infopage = false;
	$partnerClasses = "";
	$about_partner = wfMessage( 'coll-about_pp', $partnerData['name'] )->escaped();
	if ( isset( $partnerData['infopagetitle'] ) ) {
		$infopage = Title::newFromText( wfMessage( $partnerData['infopagetitle'] )->inContentLanguage()->text() );
		if ( $infopage && $infopage->exists() ) {
			$partnerClasses = " coll-more_info collapsed";
 		}
	}
?>
	<li class="collection-partner<?php echo $partnerClasses ?>">
		<div>
			<div><a class="coll-partnerlink" href="<?php echo htmlspecialchars( $partnerData['url'] ) ?>"><?php echo $about_partner; ?></a></div>
<?php
	if ( $infopage && $infopage->exists() ) { ?>
			<div class="coll-order_info" style="display:none;">
<?php
	echo $GLOBALS['wgOut']->parse( '{{:' . $infopage . '}}' );
?>
			</div>
<?php   }					?>
			<div class="collection-order-button">
				<form action="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book' ) ) ?>" method="post">
					<input type="hidden" name="bookcmd" value="post_zip" />
					<input type="hidden" name="partner" value="<?php echo htmlspecialchars( $partnerKey ) ?>" />
					<input type="submit" value="<?php echo wfMessage( 'coll-order_from_pp', $partnerData['name'] )->escaped() ?>" class="order" <?php if ( count( $this->data['collection']['items'] ) == 0 ) { ?> disabled="disabled"<?php } ?> />
				</form>
			</div>
		</div>
	</li>
<?php
} /* foreach */
?>
	</ul></div>
<?php
} /* if */
?>

	<div class="collection-column-right-box" id="coll-downloadbox">
		<h2><span class="mw-headline"><?php $this->msg( 'coll-download_title' ) ?></span></h2>
		<?php if ( count( $this->data['formats'] ) == 1 ) {
			$writer = array_rand( $this->data['formats'] );
			echo wfMessage( 'coll-download_as_text', $this->data['formats'][$writer] )->parseAsBlock();
			$buttonLabel = wfMessage( 'coll-download_as', $this->data['formats'][$writer] )->escaped();
		} else {
			$this->msgWiki( 'coll-download_text' );
			$buttonLabel = wfMessage( 'coll-download' )->escaped();
		} ?>
		<form id="downloadForm" action="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book' ) ) ?>" method="post">
			<table style="width:100%; background-color: transparent;"><tr><td><tbody><tr><td>
			<?php if ( count( $this->data['formats'] ) == 1 ) { ?>
				<input type="hidden" name="writer" value="<?php echo htmlspecialchars( $writer ) ?>" />
			<?php } else { ?>
				<label for="formatSelect"><?php $this->msg( 'coll-format_label' ) ?></label>
				<select id="formatSelect" name="writer">
					<?php foreach ( $this->data['formats'] as $writer => $name ) {
						// Give grep a chance to find the usages:
						// coll-format-rl, coll-format-epub, coll-format-odf,
						// coll-format-zim, coll-format-docbook, coll-format-okawix_zeno
					?>
					<option value="<?php echo htmlspecialchars( $writer ) ?>"><?php echo wfMessage( 'coll-format-' . $writer )->escaped() ?></option>
					<?php	} ?>
				</select>
			<?php } ?>
			</td><td id="collection-download-button">
			<input type="hidden" name="bookcmd" value="render" />
			<input type="hidden" name="returnto" value="<?php echo SpecialPage::getTitleFor( 'Book' )->getPrefixedText(); ?>" />
			<input id="downloadButton" type="submit" value="<?php echo $buttonLabel ?>"<?php if ( count( $this->data['collection']['items'] ) == 0 ) { ?> disabled="disabled"<?php } ?> />
			</td></tr></tbody></table>
		</form>
	</div>

	<?php
		if ( $GLOBALS['wgUser']->isLoggedIn() ) {
			$canSaveUserPage = $GLOBALS['wgUser']->isAllowed( 'collectionsaveasuserpage' );
			$canSaveCommunityPage = $GLOBALS['wgUser']->isAllowed( 'collectionsaveascommunitypage' );
		} else {
			$canSaveUserPage = false;
			$canSaveCommunityPage = false;
		}
		if ( $GLOBALS['wgEnableWriteAPI'] && ( $canSaveUserPage || $canSaveCommunityPage ) ) {
	?>
	<div class="collection-column-right-box" id="coll-savebox">
		<h2><span class="mw-headline"><?php $this->msg( 'coll-save_collection_title' ) ?></span></h2>
		<?php
				$this->msgWiki( 'coll-save_collection_text' );
		?>
			<form id="saveForm" action="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book' ) ) ?>" method="post">
				<table style="width:100%; background-color: transparent;"><tbody>
				<?php if ( $canSaveUserPage ) { ?>
				<tr><td>
				<?php if ( $canSaveCommunityPage ) { ?>
				<input id="personalCollType" type="radio" name="colltype" value="personal" checked="checked" />
				<?php } else { ?>
				<input type="hidden" name="colltype" value="personal" />
				<?php } ?>
				<label for="personalCollTitle"><a href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Prefixindex', 'prefix=' . wfUrlencode( $this->data['user-book-prefix'] ) ) ) ?>"><?php echo htmlspecialchars( $this->data['user-book-prefix'] ) ?></a></label>
				</td>
				<td id="collection-save-input">
				<input id="personalCollTitle" type="text" name="pcollname" />
				</td></tr>
				<?php } // if ($canSaveUserPage) ?>
				<?php if ( $canSaveCommunityPage ) { ?>
				<tr><td>
				<?php if ( $canSaveUserPage ) { ?>
				<input id="communityCollType" type="radio" name="colltype" value="community" />
				<?php } else { ?>
				<input type="hidden" name="colltype" value="community" />
				<?php } ?>
				<label for="communityCollTitle"><a href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Prefixindex', 'prefix=' . wfUrlencode( $this->data['community-book-prefix'] ) ) ) ?>"><?php echo htmlspecialchars( $this->data['community-book-prefix'] ) ?></a></label>
				</td>
				<td id="collection-save-button">
				<input id="communityCollTitle" type="text" name="ccollname" disabled="disabled" />
				</td></tr>
				<?php } // if ($canSaveCommunityPage) ?>
				<tr><td>&#160;</td><td id="collection-save-button">
				<input id="saveButton" type="submit" value="<?php $this->msg( 'coll-save_collection' ) ?>"<?php if ( count( $this->data['collection']['items'] ) == 0 ) { ?> disabled="disabled"<?php } ?> />
				</tr></tbody></table>
				<input name="token" type="hidden" value="<?php echo htmlspecialchars( $GLOBALS['wgUser']->getEditToken() ) ?>" />
				<input name="bookcmd" type="hidden" value="save_collection" />
			</form>

		<?php
		if ( !wfMessage( 'coll-bookscategory' )->inContentLanguage()->isDisabled() ) {
			$this->msgWiki( 'coll-save_category' );
		}
		?>
	</div>
	<?php } ?>

</div>



<?php
	}
}

/**
 * HTML template for Special:Book collection item list
 * @ingroup Templates
 */
class CollectionListTemplate extends QuickTemplate {
	public function execute() {
		$mediapath = $GLOBALS['wgExtensionAssetsPath'] . '/Collection/images/';
?>

<div class="collection-create-chapter-links">
<a class="makeVisible" style="<?php if ( !isset( $this->data['is_ajax'] ) ) { echo ' display:none;'; } ?>" onclick="return coll_create_chapter()" href="javascript:void(0);"><?php $this->msg( 'coll-create_chapter' ) ?></a>
<?php if ( count( $this->data['collection']['items'] ) > 0 ) { ?>
<a onclick="return coll_sort_items()" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'sort_items' ) ) ) ?>"><?php $this->msg( 'coll-sort_alphabetically' ) ?></a>
<a onclick="return coll_clear_collection()" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'clear_collection' ) ) ) ?>"><?php $this->msg( 'coll-clear_collection' ) ?></a>
<?php } ?>
</div>

<div class="collection-create-chapter-list">

<?php
if ( count( $this->data['collection']['items'] ) == 0 ) { ?>
<em id="emptyCollection"><?php $this->msg( 'coll-empty_collection' ); ?></em>
<?php } else { ?>
<div style="collection-create-chapter-list-text">
<em class="makeVisible" style="display:none; font-size: 95%"><?php $this->msg( 'coll-drag_and_drop' ) ?></em>
</div>
<?php } ?>

<ul id="collectionList">

<?php
if ( !isset( $this->data['collection']['items'] ) ) {
	return;
}
foreach ( $this->data['collection']['items'] as $index => $item ) {
	if ( $item['type'] == 'article' ) { ?>
	<li id="item-<?php echo intval( $index ) ?>" class="article">
		<a onclick="return coll_remove_item(<?php echo intval( $index ) ?>)" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'remove_item', 'index' => $index ) ) ) ?>" title="<?php $this->msg( 'coll-remove' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "remove.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-remove' ) ?>" /></a><a>
		<noscript>
		<?php if ( $index == 0 ) { ?>
			<img src="<?php echo htmlspecialchars( $mediapath . "trans.png" ) ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo intval( $index ) . ', -1' ?>)" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'move_item', 'delta' => '-1', 'index' => $index ) ) ) ?>" title="<?php $this->msg( 'coll-move_up' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "up.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-move_up' ) ?>" /></a>
		<?php }
		if ( $index == count( $this->data['collection']['items'] ) - 1 ) { ?>
			<img src="<?php echo htmlspecialchars( $mediapath . "trans.png" ) ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo intval( $index ) . ', 1' ?>)" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'move_item', 'delta' => '1', 'index' => $index ) ) ) ?>" title="<?php $this->msg( 'coll-move_down' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "down.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-move_down' ) ?>" /></a>
		<?php } ?>
		</noscript>
		<?php if ( $item['currentVersion'] == 0 ) {
			$url = $item['url'] . '?oldid=' . $item['revision'];
		} else {
			$url = $item['url'];
		}
		?>
		<a href="<?php echo htmlspecialchars( $url ) ?>" title="<?php $this->msg( 'coll-show' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "show.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-show' ) ?>" /></a>
		<span class="title sortableitem">
		<?php if ( isset( $item['displaytitle'] ) && $item['displaytitle'] != '' ) {
			echo htmlspecialchars( $item['displaytitle'] );
		} else {
			echo htmlspecialchars( $item['title'] );
		} ?>
		</span>
	</li>
	<?php } elseif ( $item['type'] == 'chapter' ) { ?>
	<li id="item-<?php echo intval( $index ) ?>" class="chapter">
		<a onclick="return coll_remove_item(<?php echo intval( $index ) ?>)" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'remove_item', 'index=' => $index ) ) ) ?>" title="<?php $this->msg( 'coll-remove' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "remove.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-remove' ) ?>" /></a>
		<noscript>
		<?php if ( $index == 0 ) { ?>
			<img src="<?php echo htmlspecialchars( $mediapath . "trans.png" ) ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo intval( $index ) . ', -1' ?>)" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'move_item', 'delta' => '-1', 'index' => $index ) ) ) ?>" title="<?php $this->msg( 'coll-move_up' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "up.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-move_up' ) ?>" /></a>
		<?php }
		if ( $index == count( $this->data['collection']['items'] ) - 1 ) { ?>
			<img src="<?php echo htmlspecialchars( $mediapath . "trans.png" ) ?>" width="10" height="10" alt="" />
		<?php } else { ?>
			<a onclick="return coll_move_item(<?php echo intval( $index ) . ', 1' ?>)" href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'move_item', 'delta' => '1', 'index' => $index ) ) ) ?>" title="<?php $this->msg( 'coll-move_down' ) ?>"><img src="<?php echo htmlspecialchars( $mediapath . "down.png" ) ?>" width="10" height="10" alt="<?php $this->msg( 'coll-move_down' ) ?>" /></a>
		<?php } ?>
		</noscript>
		<img src="<?php echo htmlspecialchars( $mediapath . "trans.png" ) ?>" width="10" height="10" alt="" />
		<strong class="title sortableitem" style="margin-left: 0.2em;"><?php echo htmlspecialchars( $item['title'] ) ?></strong>
		<a class="makeVisible" <?php if ( !isset( $this->data['is_ajax'] ) ) { echo 'style="display:none"'; } ?> onclick="<?php echo htmlspecialchars( 'return coll_rename_chapter(' . intval( $index ) . ', ' . Xml::encodeJsVar( $item['title'] ) . ')' ) ?>" href="javascript:void(0)">[<?php $this->msg( 'coll-rename' ) ?>]</a>
	</li>
	<?php }
} ?>
</ul>

</div>

<?php
	}
}

/**
 * HTML template for Special:Book/load_collection/ when overwriting an exisiting collection
 * @ingroup Templates
 */
class CollectionLoadOverwriteTemplate extends QuickTemplate {
	public function execute() {
?>

<?php $this->msgWiki( 'coll-load_overwrite_text' ); ?>

<form action="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book' ) ) ?>" method="post">
	<input name="overwrite" type="submit" value="<?php $this->msg( 'coll-overwrite' ) ?>" />
	<input name="append" type="submit" value="<?php $this->msg( 'coll-append' ) ?>" />
	<input name="cancel" type="submit" value="<?php $this->msg( 'coll-cancel' ) ?>" />
	<input name="bookcmd" type="hidden" value="load_collection" />
	<input name="colltitle" type="hidden" value="<?php echo htmlspecialchars( $this->data['title']->getPrefixedText() ) ?>" />
</form>

<?php
	}
}

/**
 * HTML template for Special:Book/save_collection/ when overwriting an exisiting collection
 * @ingroup Templates
 */
class CollectionSaveOverwriteTemplate extends QuickTemplate {
	public function execute() {
?>

<h2><span class="mw-headline"><?php $this->msg( 'coll-overwrite_title' ) ?></span></h2>

<?php echo wfMessage( 'coll-overwrite_text', $this->data['title']->getPrefixedText() )->parseAsBlock(); ?>

<form action="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book' ) ) ?>" method="post">
	<input name="overwrite" type="submit" value="<?php $this->msg( 'coll-yes' ) ?>" />
	<input name="abort" type="submit" value="<?php $this->msg( 'coll-no' ) ?>" />
	<input name="pcollname" type="hidden" value="<?php echo htmlspecialchars( $this->data['pcollname'] ) ?>" />
	<input name="ccollname" type="hidden" value="<?php echo htmlspecialchars( $this->data['ccollname'] ) ?>" />
	<input name="colltype" type="hidden" value="<?php echo htmlspecialchars( $this->data['colltype'] ) ?>" />
	<input name="token" type="hidden" value="<?php echo htmlspecialchars( $GLOBALS['wgUser']->getEditToken() ) ?>" />
	<input name="bookcmd" type="hidden" value="save_collection" />
</form>

<?php
	}
}

/**
 * HTML template for Special:Book/rendering/ (in progress)
 * @ingroup Templates
 */
class CollectionRenderingTemplate extends QuickTemplate {
	public function execute() {
?>

<span style="display:none" id="renderingStatusText"><?php echo wfMessage( 'coll-rendering_status', '%PARAM%' )->parse() ?></span>
<span style="display:none" id="renderingArticle"><?php echo ' ' . wfMessage( 'coll-rendering_article', '%PARAM%' )->parse() ?></span>
<span style="display:none" id="renderingPage"><?php echo ' ' . wfMessage( 'coll-rendering_page', '%PARAM%' )->parse() ?></span>

<?php echo wfMessage( 'coll-rendering_text' )
			->numParams( number_format( $this->data['progress'], 2, '.', '' ) )
			->params( $this->data['status'] )->parse() ?>

<?php
		if ( CollectionSession::isEnabled() ) {
			$title_string = wfMessage( 'coll-rendering_collection_info_text_article' )->inContentLanguage()->text();
		} else {
			$title_string = wfMessage( 'coll-rendering_page_info_text_article' )->inContentLanguage()->text();
		}
		$t = Title::newFromText( $title_string );
		if ( $t && $t->exists() ) {
			echo $GLOBALS['wgOut']->parse( '{{:' . $t . '}}' );
		}
	}
}

/**
 * HTML template for Special:Book/rendering/ (finished)
 * @ingroup Templates
 */
class CollectionFinishedTemplate extends QuickTemplate {
	public function execute() {

echo wfMessage( 'coll-rendering_finished_text', $this->data['download_url'] )->parseAsBlock();

if ( $this->data['is_cached'] ) {
	$forceRenderURL = SkinTemplate::makeSpecialUrl(
		'Book',
		'bookcmd=forcerender&' . $this->data['query'],
		PROTO_RELATIVE
	);
	echo wfMessage( 'coll-is_cached', $forceRenderURL )->parseAsBlock();
}
$t = Title::newFromText( $this->data['return_to'] );
if ( $t && $t->isKnown() ) {
	echo wfMessage( 'coll-return_to', $t )->parseAsBlock();
}

if ( CollectionSession::isEnabled() ) {
	$title_string = wfMessage( 'coll-finished_collection_info_text_article' )->inContentLanguage()->text();
} else {
	$title_string = wfMessage( 'coll-finished_page_info_text_article' )->inContentLanguage()->text();
}
$t = Title::newFromText( $title_string );
if ( $t && $t->exists() ) {
	echo $GLOBALS['wgOut']->parse( '{{:' . $t . '}}' );
}
?>

<?php
	}
}

/**
 * HTML template for Special:Book/rendering/ (failed)
 * @ingroup Templates
 */
class CollectionFailedTemplate extends QuickTemplate {
	public function execute() {

echo wfMessage( 'coll-rendering_failed_text', $this->data['status'] )->parseAsBlock();

$t = Title::newFromText( $this->data['return_to'] );
if ( $t && $t->isKnown() ) {
	echo wfMessage( 'coll-return_to', $t )->parseAsBlock();
}

if ( CollectionSession::isEnabled() ) {
	$title_string = wfMessage( 'coll-failed_collection_info_text_article' )->inContentLanguage()->text();
} else {
	$title_string = wfMessage( 'coll-failed_page_info_text_article' )->inContentLanguage()->text();
}
$t = Title::newFromText( $title_string );
if ( $t && $t->exists() ) {
	echo $GLOBALS['wgOut']->parse( '{{:' . $t . '}}' );
}
?>

<?php
	}
}

/**
 * Template for suggest feature
 *
 * It needs the two methods getProposalList() and getMemberList()
 * to run with Ajax
 */
class CollectionSuggestTemplate extends QuickTemplate {
	public function execute () {
?>
<div>
	<?php $this->msg( 'coll-suggest_intro_text' ) ?>
	<div id="collectionSuggestStatus" style="text-align: center; margin: 5px auto 10px auto; padding: 0 4px; border: 1px solid #ed9; background-color: #fea; visibility: hidden;">&#160;</div>
	<table style="width: 100%; border-spacing: 10px;"><tbody><tr>
		<td style="padding: 10px; vertical-align: top;">
			<form method="post" action="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'suggest' ) ) ) ?>">
				<strong style="font-size: 1.2em;"><?php $this->msg( 'coll-suggested_articles' ) ?></strong>
				(<a href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'suggest', 'resetbans' => '1' ) ) ) ?>" title="<?php $this->msg( 'coll-suggest_reset_bans_tooltip' ) ?>"><?php $this->msg( 'coll-suggest_reset_bans' ) ?></a>)
				<?php if ( count( $this->data['proposals'] ) > 0 ) { ?>
				<noscript>
				<div id="collection-suggest-add">
					<input type="submit" value="<?php $this->msg( 'coll-suggest_add_selected' ) ?>" name="addselected" />
				</div>
				</noscript>
				<?php } ?>
				<ul id="collectionSuggestions" style="list-style: none; margin-left: 0;">
				<?php echo $this->getProposalList() ?>
				</ul>
			</form>
		</td>
		<td style="width: 45%; vertical-align: top;">
			<div style="padding: 10px; border: 1px solid #aaa; background-color: #f9f9f9;">
				<strong style="font-size: 1.2em;"><?php $this->msg( 'coll-suggest_your_book' ) ?></strong>
				(<span id="coll-num_pages"><?php echo wfMessage( 'coll-n_pages' )->numParams( $this->data['num_pages'] )->escaped() ?></span><?php echo wfMessage( 'pipe-separator' )->plain() ?><a href="<?php echo htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book' ) ) ?>" title="<?php $this->msg( 'coll-show_collection_tooltip' ) ?>"><?php $this->msg( 'coll-suggest_show' ) ?></a>)
				<ul id="collectionMembers" style="list-style: none; margin-left: 0;">
				<?php echo $this->getMemberList(); ?>
				</ul>
			</div>
		</td>
	</tr></tbody></table>
</div>
<?php
	}

	/**
	 * needed for Ajax functions
	 * @return string
	 */
	public function getProposalList () {
		global $wgScript, $wgExtensionAssetsPath;

		$mediapath = $wgExtensionAssetsPath . '/Collection/images/';
		$baseUrl = $wgScript . "/";

		$prop = $this->data['proposals'];
		$out = '';

		$num = count( $prop );
		if ( $num == 0 ) {
			return "<li>" . wfMessage( 'coll-suggest_empty' )->escaped() . "</li>";
		}

		$artName = $prop[0]['name'];
		$title = Title::newFromText( $artName );
		$url = $title->getLocalUrl();
		$out .= '<li style="margin-bottom: 10px; padding: 4px 4px; background-color: #ddddff; font-size: 1.4em; font-weight: bold;">';
		$out .= '<noscript><input type="checkbox" value="' . htmlspecialchars( $artName ) . '" name="articleList[]" /></noscript>';
		$out .= '<a onclick="' . htmlspecialchars( 'collectionSuggestCall("AddArticle", ' . Xml::encodeJsVar( array( $artName ) ) . '); return false;' ) . '" href="' . htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'suggest', 'add' => $artName ) ) ) . '" title="' . wfMessage( 'coll-add_page_tooltip' )->escaped() . '"><img src="' . htmlspecialchars( $mediapath . 'silk-add.png' ) . '" width="16" height="16" alt=""></a> ';
		$out .= '<a onclick="' . htmlspecialchars( 'collectionSuggestCall("BanArticle", ' . Xml::encodeJsVar( array( $artName ) ) . '); return false;' ) . '" href="' . htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'suggest', 'ban' => $artName ) ) ) . '" title="' . wfMessage( 'coll-suggest_ban_tooltip' )->escaped() . '"><img src="' . htmlspecialchars( $mediapath . 'silk-cancel.png' ) . '" width="16" height="16" alt=""></a> ';
		$out .= '<a href="' . htmlspecialchars( $url ) . '" title="' . htmlspecialchars( $artName ) . '">' . htmlspecialchars( $artName ) . '</a>';
		$out .= '</li>';

		for ( $i = 1; $i < $num; $i++ ) {
			$artName = $prop[$i]['name'];
			$url = $baseUrl . $artName;
			$url = str_replace( " ", "_", $url );
			$out .= '<li style="padding-left: 4px;">';
			$out .= '<noscript><input type="checkbox" value="' . htmlspecialchars( $artName ) . '" name="articleList[]" /></noscript>';
			$out .= '<a onclick="' . htmlspecialchars( 'collectionSuggestCall("AddArticle", ' . Xml::encodeJsVar( array( $artName ) ) . '); return false;' ) . '" href="' . htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'suggest', 'add' => $artName ) ) ) . '" title="' . wfMessage( 'coll-add_page_tooltip' )->escaped() . '"><img src="' . htmlspecialchars( $mediapath . 'silk-add.png' ) . '" width="16" height="16" alt=""></a> ';
			$out .= '<a href="' . htmlspecialchars( $url ) . '" title="' . htmlspecialchars( $artName ) . '">' . htmlspecialchars( $artName ) . '</a>';
			$out .= '</li>';
		}

		return $out;
	}

	/**
	 * needed for Ajax functions
	 * @return string
	 */
	public function getMemberList() {
		$mediapath = $GLOBALS['wgExtensionAssetsPath'] . '/Collection/images/';
		$coll = $this->data['collection'];
		$out = '';

		$num = count( $coll['items'] );
		if ( $num == 0 ) $out .= "<li>" . wfMessage( 'coll-suggest_empty' )->escaped() . "</li>";

		for ( $i = 0; $i < $num; $i++ ) {
			$artName = $coll['items'][$i]['title'];
			if ( $coll['items'][$i]['type'] == 'article' ) {
			  $out .= '<li><a href="' . htmlspecialchars( SkinTemplate::makeSpecialUrl( 'Book', array( 'bookcmd' => 'suggest', 'remove' => $artName ) ) ) . '" onclick="' . htmlspecialchars( 'collectionSuggestCall("RemoveArticle", ' . Xml::encodeJsVar( array( $artName ) ) . '); return false;' ) . '" title="' . wfMessage( 'coll-remove_this_page' )->escaped() . '"><img src="' . htmlspecialchars( $mediapath . 'remove.png' ) . '" width="10" height="10" alt=""></a> ';
				$out .= '<a href="' . htmlspecialchars( $coll['items'][$i]['url'] ) . '" title="' . htmlspecialchars( $artName ) . '">' . htmlspecialchars( $artName ) . '</a></li>';
			}
		}

		return $out;
	}
}
