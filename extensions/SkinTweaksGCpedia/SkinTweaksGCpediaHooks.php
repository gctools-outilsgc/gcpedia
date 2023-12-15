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
        return true;
    }


    public static function onAfterFinalPageOutput( $output ) {
        $fipHeader = '';
	
        $out = ob_get_clean();
        // change final html in $out
        ob_start();
        echo $fipHeader . $out;
        return true;
    }

}


