<?php
/**
 * Vector - Modern version of MonoBook with fresh look and many usability
 * improvements.
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
 * @ingroup Skins
 */

/**
 * SkinTemplate class for Vector skin
 * @ingroup Skins
 */
class SkinVector extends SkinTemplate {
	public $skinname = 'vector';
	public $stylename = 'Vector';
	public $template = 'VectorTemplate';
	/**
	 * @var Config
	 */
	private $vectorConfig;

	public function __construct() {
		$this->vectorConfig = ConfigFactory::getDefaultInstance()->makeConfig( 'vector' );
	}

	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param OutputPage $out Object to initialize
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		if ( $this->vectorConfig->get( 'VectorResponsive' ) ) {
			$out->addMeta( 'viewport', 'width=device-width, initial-scale=1' );
			$out->addModuleStyles( 'skins.vector.styles.responsive' );
		}
		$this->addMetaTags();
		
		// Append CSS which includes IE only behavior fixes for hover support -
		// this is better than including this in a CSS file since it doesn't
		// wait for the CSS file to load before fetching the HTC file.
		$min = $this->getRequest()->getFuzzyBool( 'debug' ) ? '' : '.min';
		$out->addHeadItem( 'csshover',
			'<!--[if lt IE 7]><style type="text/css">body{behavior:url("' .
				htmlspecialchars( $this->getConfig()->get( 'LocalStylePath' ) ) .
				"/{$this->stylename}/csshover{$min}.htc\")}</style><![endif]-->"
		);
		global $wgScriptPath;
$out->addHeadItem( 'gcpcss',
			'<link rel="stylesheet" href="' . $wgScriptPath . '/skins/Vector/GCWeb/css/gcpedia.css">
			 <link rel="stylesheet" href="' . $wgScriptPath . '/skins/Vector/GCWeb/css/theme.css">
			 <link rel="stylesheet" href="' . $wgScriptPath . '/skins/Vector/GCWeb/css/rcb.css">
			 <link href="' . $wgScriptPath . '/skins/Vector/GCWeb/assets/favicon.ico" rel="icon" type="image/x-icon">'
		);
		$out->addModules( array( 'skins.vector.js' ) );
	}
	
	public function addMetaTags() {
		$out = $this->getOutput();
		$title = $this->getSkin()->getTitle();
		
		$category_array = $out->getCategories();
		$category_string = (is_array($category_array)) ? implode(",", $category_array) : '';
		$timestamp = $this->getOutput()->getRevisionTimestamp();
		$timestamp = preg_replace( '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', "$1-$2-$3 $4:$5:$6", $timestamp);
		$language = $_GET['setlang'];
		$namespace = $title->getNsText();
		
		if (!$language) $language = 'en';
		
		$out->addMeta( 'platform', 'gcpedia' );
		$out->addMeta( 'dcterms.language', $language );
		$out->addMeta( 'dcterms.title', $this->getTitle() );
		$out->addMeta( 'dcterms.type', $namespace );
		$out->addMeta( 'dcterms.modified', $timestamp );
		$out->addMeta( 'dcterms.description', strip_tags($out->mBodytext) );
		
		if ( $title->inNamespace(NS_USER) )
			$out->addMeta( 'dcterms.keywords', str_replace( '.', ' ', $title->getRootText() ) );
	}

	/**
	 * Loads skin and user CSS files.
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		$styles = array( 'mediawiki.skinning.interface', 'skins.vector.styles' );
		Hooks::run( 'SkinVectorStyleModules', array( $this, &$styles ) );
		$out->addModuleStyles( $styles );
	}

	/**
	 * Override to pass our Config instance to it
	 */
	public function setupTemplate( $classname, $repository = false, $cache_dir = false ) {
		return new $classname( $this->vectorConfig );
	}
}
