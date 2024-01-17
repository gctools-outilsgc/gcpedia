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
		return;
	}


    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        $out->addModules( [ 'ext.skintweaksgcwiki' ] );
        return;
    }

}


