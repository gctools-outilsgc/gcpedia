<?php
/**
 * CSS extension - A parser-function for adding CSS to articles via file,
 * article or inline rules.
 */

class SkinTweaksGCwikiHooks {
	/**
	 * @param Skin $skin
	 * @param &$bar
	 * @return bool true
	 */
	public static function onSkinBuildSidebar( Skin $skin, &$bar ) {
		return;
	}


    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        $out->addModuleStyles( [ 'ext.skintweaksgcwiki.styles' ] );
        addMetaTags( $out, $skin );
        
        return;
    }


    public static function onAfterFinalPageOutput( $output ) {
        $fipHeader = '';
	
        $out = ob_get_clean();
        // change final html in $out
        ob_start();
        echo $fipHeader . $out;
        return true;
    }





    public function addMetaTags( OutputPage $out, Skin $skin ) {
		$title = $skin->getTitle();
		
		$category_array = $out->getCategories();
		$category_string = (is_array($category_array)) ? implode(",", $category_array) : '';
		$timestamp = $out->getRevisionTimestamp();
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
}


