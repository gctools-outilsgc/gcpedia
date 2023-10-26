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


    public static function onSkinAfterPortlet( $skin, $portletName, &$html ) {
        if ($portletName === "gctools"){
            $html = <<< EOT
            <nav>
                <ul id="tool-links" class="" style="list-style:none; padding:5px; margin: 0 auto; font-weight:bold;">
                    <li style="float:left; margin: 3px 2%;"><a href="https://account-compte.gccollab.ca" style="color:#6b5088;"><span><img style="width:25px; display:inline-block; margin-right:3px;" src="extensions/SkinTweaksGCwiki/resources/images/mini_wiki_icon.png" alt=""></span>{$skin->msg( 'wet:baraccount' )}</a></li>
                    <li style="float:left; margin: 3px 2%;"><a href="https://gccollab.ca/" style="color:#6b5088;"><span><img style="width:25px; display:inline-block; margin-right:3px;" src="extensions/SkinTweaksGCwiki/resources/images/mini_collab_icon.png" alt=""></span>GCcollab</a></li>
                    <li style="float:left; margin: 3px 2%;"><a href="https://message.gccollab.ca/" style="color:#6b5088;"><span><img style="width:25px; display:inline-block; margin-right:3px;" src="extensions/SkinTweaksGCwiki/resources/images/message_icon.png" alt=""></span>GCmessage</a></li>
                </ul>
            </nav>
            EOT;
        }
        return true;
    }

    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        $fipHeader = '<div class="collab-fip-header" style="height:35px; clear:both; background-color:white;">
		<object type="image/svg+xml" tabindex="-1" role="img" data="extensions/SkinTweaksGCwiki/resources/images/sig-alt-en.svg" aria-label="Symbol of the Government of Canada" style="height:25px; float:left; padding:5px 10px;"></object>
	</div>';

        $out->prependHTML($fipHeader);
        $out->addModuleStyles( [ 'ext.skintweaksgcwiki.styles' ] );
        return true;
    }

    public static function onSkinAfterContent( &$data, Skin $skin ) { 
        error_log( "BLABLABLA........" . $data );
        return true;
    }

}


