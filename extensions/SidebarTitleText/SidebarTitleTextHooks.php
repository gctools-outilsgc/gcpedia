<?php
/**
 * Allow adding a title text to custom sidebar menu items
 */

class SidebarTitleTextHooks {
	/**
	 * @param Skin $skin
	 * @param &$bar
	 * @return bool true
	 */
	public static function onSkinBuildSidebar( Skin $skin, &$bar ) {
        foreach ($bar as $mkey => $menu) {
            foreach ($menu as $ikey => $menuItem) {
                if ( strpos($menuItem["text"], "|") ){
                    $parts = explode("|", $menuItem["text"], 2);
                    $bar[$mkey][$ikey]["text"] = SidebarTitleTextHooks::menuItemText($skin, $parts[0]);
                    $bar[$mkey][$ikey]["title"] = SidebarTitleTextHooks::menuItemText($skin, $parts[1]);
                }
            }
        }
		return;
	}

    private static function menuItemText( Skin $skin, string $text ){
        $message = $skin->msg( $text );
        // parse as an i18n message if it's registered as such
        if ( $message->exists() ) {
            return $message->text();
        }

        return $text;
    }
}


