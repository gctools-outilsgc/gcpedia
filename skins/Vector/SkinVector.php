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
	private $responsiveMode = false;

	public function __construct() {
		$this->vectorConfig = \MediaWiki\MediaWikiServices::getInstance()->getConfigFactory()
			->makeConfig( 'vector' );
	}

	/** @inheritDoc */
	public function getPageClasses( $title ) {
		$className = parent::getPageClasses( $title );
		if ( $this->vectorConfig->get( 'VectorExperimentalPrintStyles' ) ) {
			$className .= ' vector-experimental-print-styles';
		}
		return $className;
	}


	public function addMetaTags() {
		$out = $this->getOutput();

		$category_array = $out->getCategories();
		$category_string = (is_array($category_array)) ? implode(",", $category_array) : '';
		$timestamp = $this->getOutput()->getRevisionTimestamp();
		$timestamp = preg_replace( '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', "$1-$2-$3 $4:$5:$6", $timestamp);
		$language = $_GET['setlang'];
		if (!$language) $language = 'en';

		$out->addMeta( 'platform', 'gcpedia' );
		$out->addMeta( 'dcterms.language', $language );
		$out->addMeta( 'dcterms.title', $this->getTitle() );
		$out->addMeta( 'dcterms.type', $category_string );
		$out->addMeta( 'dcterms.modified', $timestamp );
		$out->addMeta( 'dcterms.description', strip_tags($out->mBodytext) );
	}

	/**
	 * Enables the responsive mode
	 */
	public function enableResponsiveMode() {
		if ( !$this->responsiveMode ) {
			$out = $this->getOutput();
			$out->addMeta( 'viewport', 'width=device-width, initial-scale=1' );
			$out->addModuleStyles( 'skins.vector.styles.responsive' );
			$this->responsiveMode = true;
		}
	}

	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param OutputPage $out Object to initialize
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );

		if ( $this->vectorConfig->get( 'VectorResponsive' ) ) {
			$this->enableResponsiveMode();
		}

		$this->addMetaTags();

		// Print styles are feature flagged.
		// This flag can be removed when T169732 is resolved.
		if ( $this->vectorConfig->get( 'VectorExperimentalPrintStyles' ) ) {
			// Note, when deploying (T169732) we'll want to fold the stylesheet into
			// skins.vector.styles and remove this module altogether.
			$out->addModuleStyles( 'skins.vector.styles.experimental.print' );
		}

		$out->addModules( 'skins.vector.js' );
	}

	/**
	 * Loads skin and user CSS files.
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		$styles = [ 'mediawiki.skinning.interface', 'skins.vector.styles' ];
		Hooks::run( 'SkinVectorStyleModules', [ $this, &$styles ] );
		$out->addModuleStyles( $styles );
	}

	/**
	 * Override to pass our Config instance to it
	 * @param string $classname
	 * @param bool|string $repository
	 * @param bool|string $cache_dir
	 * @return QuickTemplate
	 */
	public function setupTemplate( $classname, $repository = false, $cache_dir = false ) {
		return new $classname( $this->vectorConfig );
	}

	/**
	 * Whether the logo should be preloaded with an HTTP link header or not
	 * @since 1.29
	 * @return bool
	 */
	public function shouldPreloadLogo() {
		return true;
	}
}
