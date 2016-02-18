<?php

/*
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Sebastien Poivre <gizmhail@gmail.com>
 * @copyright Copyright (C) 2008 Sebastien Poivre
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */


if (!defined('MEDIAWIKI')) {
        echo "new user page extension";
        exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
        'path' => __FILE__,
        'name' => 'NewUserPage',
        'author' => 'Author',
        'url' => 'https://www.mediawiki.org/wiki/Extension:NewPage',
        'descriptionmsg' => 'newpage-desc',
        'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';
 
$wgAutoloadClasses['NewUserPage'] = $dir . 'NewUserPage_body.php';
# Location of the SpecialMyExtension class (Tell MediaWiki to load this file)


$wgSpecialPages['NewUserPage'] = 'NewUserPage';
# Tell MediaWiki about the new special page and its class name

$wgHooks['UserLoginComplete'][] = 'NewUserPage::UserLoginComplete';
?>