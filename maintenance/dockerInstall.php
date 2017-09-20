<?php

// environment variables from docker-compose, etc
$dbhost = 'gcpedia-db';
$host = 'localhost';

// first run regular cli install script
shell_exec("php /var/www/html/maintenance/install.php --confpath=/var/www/html/ \
 --dbserver={$dbhost} --dbtype=mysql --dbuser=wiki --dbpass=gcpedia \
 --scriptpath=/ --server='http://{$host}/'' --lang=en  \
 --pass=adminpassword 'GCpedia' 'admin' ");				// TODO: Add the parameters

// then add extensions; some require extra configuration so the default install is not sufficient
$local_settings = fopen("/var/www/html/LocalSettings.php", 'a');		// a for append

fwrite($local_settings, "wfLoadExtension( 'ParserFunctions' );");
fwrite($local_settings, `$wgUseAjax = true;
require_once "$IP/extensions/AjaxShowEditors/AjaxShowEditors.php";
require_once "$IP/extensions/awards/awards.php";
require_once "$IP/extensions/customUserCreateForm/customUserCreateForm.php";
require_once "$IP/extensions/EmailUpdate/EmailUpdate.php";
$wgGroupPermissions['sysop']['emailupdate'] = true;

require_once "$IP/extensions/MagicNoNumberedHeadings/MagicNoNumberedHeadings.php";
require_once "$IP/extensions/MagicNumberedHeadings/MagicNumberedHeadings.php";
require_once "$IP/extensions/ROTedits/ROTedits.php";`);



fclose($local_settings);