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
        $accLink = [
            'text'   => $skin->msg( 'wet:baraccount' ),
            'href'   => 'https://account-compte.gccollab.ca',
            'id'     => 'gt-acc',
            'active' => ''
        ];
        $gccLink = [
            'text'   => "GCcollab",
            'href'   => 'https://gccollab.ca/',
            'id'     => 'gt-gcc',
            'active' => ''
        ];
        $messLink = [
            'text'   => "GCmessage",
            'href'   => 'https://message.gccollab.ca/',
            'id'     => 'gt-mess',
            'active' => ''
        ];
		$bar['gctools'] = [$accLink, $gccLink, $messLink];
		return true;
	}


    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        $out->addModuleStyles( [ 'ext.skintweaksgcwiki.styles' ] );
        return true;
    }


    public static function onAfterFinalPageOutput( $output ) {
        $fipHeader = '<div class="collab-fip-header" style="height:35px; clear:both; background-color:white;">
		<object type="image/svg+xml" tabindex="-1" role="img" data="extensions/SkinTweaksGCwiki/resources/images/sig-alt-en.svg" aria-label="Symbol of the Government of Canada" style="height:25px; float:left; padding:5px 10px;"></object>
	</div>
        <div id="app-brand-name"><span style="font-weight:600">GC</span>wiki</div>';
	
        $out = ob_get_clean();
        // change final html in $out
        ob_start();
        echo $fipHeader . $out;
        return true;
    }

}


