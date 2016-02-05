<?php

if ( !defined('MEDIAWIKI') ) {
        echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once("\$IP/extensions/EmailUpdate/EmailUpdate.php");
EOT;
        exit( 1 );
}

$wgAvailableRights[] = 'emailupdate';
$wgGroupPermissions['*']['emailupdate'] = false;

# credits
$wgExtensionCredits['specialpage'][] = array(
       'name' => 'EmailUpdate',
       'author' =>'[http://www.gcpedia.gc.ca/wiki/User:Matthew.april Matthew April]', 
       'description' => 'Allows admins to [[Special:EmailUpdate|change a users email]] and send out a confirmation email',
	   'version' => '1.1'
);

# setup
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['EmailUpdate'] = $dir . 'EmailUpdate.body.php';
$wgExtensionMessagesFiles['EmailUpdate'] = $dir . 'EmailUpdate.i18n.php';

# toolbox hook
$emailUpdate = new EmailUpdate;
$wgHooks['SkinTemplateToolboxEnd'][] = array( $emailUpdate, 'emailUpdateToolbox' );

# special page
$wgSpecialPages['EmailUpdate'] = 'EmailUpdate';
$wgSpecialPageGroups['EmailUpdate'] = 'users';