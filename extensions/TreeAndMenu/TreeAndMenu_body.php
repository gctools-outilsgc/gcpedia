<?php

use MediaWiki\MediaWikiServices;

class TreeAndMenu {

	public static $instance = null;

	/**
	 * Called when the extension is first loaded
	 */
	public static function onRegistration() {
		global $wgExtensionFunctions;
		define( 'TREEANDMENU_TREE', 1 );
		define( 'TREEANDMENU_MENU', 2 );
		self::$instance = new self();
		$wgExtensionFunctions[] = [self::$instance, 'setup'];
	}

	/**
	 * Called at extension setup time, install hooks and module resources
	 */
	public function setup() {
		global $wgOut;

		// Add parser hooks
		$parser = MediaWikiServices::getInstance()->getParser();
		$parser->setFunctionHook( 'tree', [$this, 'expandTree'] );
		$parser->setFunctionHook( 'menu', [$this, 'expandMenu'] );

		// Scripts and styles
		$wgOut->addModules( 'ext.treeandmenu' );
	}

	/**
	 * Expand #tree parser-functions
	 */
	public function expandTree() {
		$args = func_get_args();
		return $this->expandTreeAndMenu( TREEANDMENU_TREE, $args );
	}

	/**
	 * Expand #menu parser-functions
	 */
	public function expandMenu() {
		$args = func_get_args();
		return $this->expandTreeAndMenu( TREEANDMENU_MENU, $args );
	}

	/**
	 * Render a bullet list for either a tree or menu structure
	 */
	private function expandTreeAndMenu( $type, $args ) {
		global $wgJsMimeType, $wgTreeAndMenuPersistIfId;

		// First arg is parser, last is the structure
		$parser = array_shift( $args );
		$bullets = array_pop( $args );

		// Convert other args (except class, id, root) into named opts to pass to JS (JSON values are allowed, name-only treated as bool)
		$opts = [];
		$atts = [];
		foreach( $args as $arg ) {
			if( preg_match( '/^(\\w+?)\\s*=\\s*(.+)$/s', $arg, $m ) ) {
				if( $m[1] == 'class' || $m[1] == 'id' || $m[1] == 'root' ) $atts[$m[1]] = $m[2];
				else $opts[$m[1]] = preg_match( '|^[\[\{]|', $m[2] ) ? json_decode( $m[2] ) : $m[2];
			} else $opts[$arg] = true;
		}

		// If the $wgTreeAndMenuPersistIfId global is set and an ID is present, add the persist extension
		if( array_key_exists( 'id', $atts ) && $wgTreeAndMenuPersistIfId ) {
			if( array_key_exists( 'extensions', $opts ) ) $opts['extensions'][] = 'persist';
			else $opts['extensions'] = ['persist'];
		}

		// Sanitise the bullet structure (remove empty lines and empty bullets)
		$bullets = preg_replace( '|^\*+\s*$|m', '', $bullets );
		$bullets = preg_replace( '|\n+|', "\n", $bullets );

		// If it's a tree, wrap the item in a span so FancyTree treats it as HTML and put nowiki tags around any JSON props
		if( $type == TREEANDMENU_TREE ) {
			$bullets = preg_replace( '|^(\*+)(.+?)$|m', '$1<span>$2</span>', $bullets );
			$bullets = preg_replace( '|^(.*?)(\{.+\})|m', '$1<nowiki>$2</nowiki>', $bullets );
		}

		// Parse the bullets to HTML
		$opt = $parser->getOptions();
		$html = $parser->parse( $bullets, $parser->getTitle(), $opt, true, false )->getText(
			[ 'unwrap' => true ]
		);

		// Determine the class and id attributes
		$class = $type == TREEANDMENU_TREE ? 'fancytree' : 'suckerfish';
		if( array_key_exists( 'class', $atts ) ) $class .= ' ' . Sanitizer::escapeClass( $atts['class'] );
		$id = array_key_exists( 'id', $atts ) ? ' id="' . Sanitizer::escapeClass( $atts['id'] ) . '"' : '';

		// If its a tree, we need to add some code to the ul structure
		if( $type == TREEANDMENU_TREE ) {

			// Mark the structure as tree data, wrap in an unclosable top level if root arg passed (and parse root content)
			$tree = '<ul id="treeData" style="display:none">';
			if( array_key_exists( 'root', $atts ) ) {
				$root = $parser->parse( $atts['root'], $parser->getTitle(), $parser->getOptions(), false, false )->getText(
					[ 'unwrap' => true ]
				);
				$root = $parser->stripOuterParagraph( $root );
				$html = $tree . '<li class="root">' . $root . $html . '</li></ul>';
				if( !array_key_exists( 'minExpandLevel', $opts ) ) $opts['minExpandLevel'] = 2;
			} else $html = preg_replace( '|<ul>|', $tree, $html, 1 );

			// Replace any json: markup in nodes into the li
			$html = preg_replace( '|<li(>\s*\{.*?\"class\":\s*"(.+?)")|', "<li class='$2'$1", $html );
			$html = preg_replace( '|<(li[^>]*)(>\s*\{.*?\"id\":\s*"(.+?)")|', "<$1 id='$3'$2", $html );
			$html = preg_replace( '|<(li[^>]*)>\s*(.+?)\s*(\{.+\})\s*|', "<$1 data-json='$3'>$2", $html );

			// Incorporate options as json encoded data in a div
			$opts = count( $opts ) > 0 ? '<div class="opts" style="display:none">' . json_encode( $opts, JSON_NUMERIC_CHECK ) . '</div>' : '';

			// Assemble it all into a single div
			$html = "<div class=\"$class todo\"$id>$opts$html</div>";
		}

		// If its a menu, just add the class and id attributes to the ul
		else $html = preg_replace( '|<ul>|', "<ul class=\"$class todo\"$id>", $html, 1 );

		// Append script to prepare this tree or menu if page is already loaded
		$html .= "<script type=\"$wgJsMimeType\">if('prepareTAM' in window) window.prepareTAM();</script>";

		return [$html, 'isHTML' => true, 'noparse' => true];
	}

	/**
	 * @param Skin $skin
	 * @param array $bar
	 */
	public static function onSkinBuildSidebar( $skin, &$bar ) {
		global $wgTreeAndMenuSidebarMenuPage, $wgTreeAndMenuSidebarMenuHeading;
		if( $wgTreeAndMenuSidebarMenuPage ) {
			$title = Title::newFromText( $wgTreeAndMenuSidebarMenuPage );
			if( $title && $title->exists() && !$skin->getOutput()->getTitle()->equals( $title ) ) {
				$html = self::getTreeHtmlFromPage( $title, $skin->getOutput() );
				$bar[ $wgTreeAndMenuSidebarMenuHeading ? $wgTreeAndMenuSidebarMenuHeading : 'Outline' ] = $html;
			}
		}
		return true;
	}

	/**
	 * @param Title $title
	 * @param OutputPage $out
	 *
	 * @return string
	 * @throws MWException
	 */
	protected static function getTreeHtmlFromPage( $title, $out ) {
		$content = WikiPage::newFromID( $title->getArticleID() )->getContent();
		if( is_object( $content ) ) $content = $content->getWikitextForTransclusion();
		// For 1.32+
		if( method_exists( $out, 'parseAsContent' ) ) {
			$html = $out->parseAsContent( $content );
		} else {
			$html = $out->parse( $content );
		}
		return $html;
	}
}
