<?php

// check if install is needed
if( file_exists("/var/www/html/docker_gcpedia/LocalSettings.php") )
  exit("\nLocalSettings.php found, not running install.\n\n");

$enabled = getenv('DOCKER') != ''; //are we in a Docker container?
if (!$enabled) {
  echo "This script should be run only in a properly configured Docker container environment.\n";
  exit(1);
}

// environment variables from docker-compose
$dbhost = (getenv('DBHOST') != '') ? getenv('DBHOST') : 'gcpedia-db';
$host = (getenv('HOST') != '') ? getenv('HOST') : 'localhost';
$port = (getenv('PORT') != '') ? ":".getenv('PORT') : '';
$saml = (getenv('USESAML') != '') ? getenv('USESAML') : false;
$oauth = (getenv('OAUTH') != '') ? getenv('OAUTH') : false;
$openid = (getenv('OPENID') != '') ? getenv('OPENID') : false;

echo "Using dbhost: $dbhost   and host: $host \n";

// wait for db to be ready
echo "Connecting to database..";
$etmp = error_reporting(E_ERROR);     // don't need all the connection errors...

do{
  echo ".";
  sleep(1); // wait for the db container
  $dbconnect = mysqli_connect($dbhost, 'wiki', 'gcpedia');
}while(!$dbconnect);

echo "Connected!";
mysqli_close($dbconnect);
error_reporting($etmp);     // revert error reporting to default

// first run regular cli install script
shell_exec("php /var/www/html/docker_gcpedia/maintenance/install.php --confpath=/var/www/html/docker_gcpedia/ \
 --dbserver={$dbhost} --dbtype=mysql --dbuser=wiki --dbpass=gcpedia --dbname=wiki \
 --scriptpath='' --server='http://{$host}{$port}' --lang=en  \
 --pass=adminpassword 'GCpedia' 'admin' ");
echo "basic setup complete\n";

// create an htaccess file for short urls
$htaccess = fopen("/var/www/html/docker_gcpedia/.htaccess", 'a');   // a for append
fwrite($htaccess, htaccessText());
fclose($htaccess);

// then add extensions; some require extra configuration so this will get a bit long...
$local_settings = fopen("/var/www/html/docker_gcpedia/LocalSettings.php", 'a');		// a for append

// using single brackets as a simple way to prevent parsing of variable names, etc.
fwrite($local_settings, returnLocalSettingsText());
if ($saml) fwrite($local_settings, returnLocalSettingsSAMLText());
if ($oauth) fwrite($local_settings, returnLocalSettingsOAuthText());
if ($openid) fwrite($local_settings, returnLocalSettingsOpenIDText());
fclose($local_settings);
echo "LocalSettings.php setup complete\n";

shell_exec("php /var/www/html/docker_gcpedia/maintenance/update.php");		// some extensions being added will need db changes, update.php will handle that

echo "DB update complete\n  Install Complete!\n";

function returnLocalSettingsText(){
  return <<< 'EOD'
include('/super/secrets.php');
include('./config.php');
EOD;
}
function returnLocalSettingsSAMLText(){
	return <<< 'EOD'
require_once("$IP/extensions/mwSimpleSamlAuth/SimpleSamlAuth.php");

//$wgSessionName = ini_get('session.name');
// SAML_OPTIONAL // SAML_LOGIN_ONLY // SAML_REQUIRED //
$wgSamlRequirement = SAML_OPTIONAL;
// Should users be created if they don't exist in the database yet?
$wgSamlCreateUser = true;

// SAML attributes
$wgSamlUsernameAttr = 'GCPedia_user';
$wgSamlRealnameAttr = 'cn';
$wgSamlMailAttr = 'GCPedia_email';

// SimpleSamlPhp settings
$wgSamlSspRoot = '/sites/simplesamlphp';
$wgSamlAuthSource = 'elgg-idp';
$wgSamlPostLogoutRedirect = NULL;

// Array: [MediaWiki group][SAML attribute name][SAML expected value]
// If the SAML assertion matches, the user is added to the MediaWiki group
$wgSamlGroupMap = array(
   'sysop' => array(
        'groups' => array('admin'),
    ),
);
EOD;
}
function returnLocalSettingsOAuthText(){
  return <<< 'EOD'

wfLoadExtension( 'MW-OAuth2Client' );

$wgOAuth2Client['client']['id'] = '';
$wgOAuth2Client['client']['secret'] = '';

$wgOAuth2Client['configuration']['authorize_endpoint'] = '';
$wgOAuth2Client['configuration']['access_token_endpoint'] = '';
$wgOAuth2Client['configuration']['api_endpoint'] = '';
$wgOAuth2Client['configuration']['redirect_uri'] = '';
EOD;
}
function returnLocalSettingsOpenIDText(){
  return <<< 'EOD'

wfLoadExtension( 'PluggableAuth' );
wfLoadExtension( 'OpenIDConnect' );

$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['autocreateaccount'] = true;
$wgOpenIDConnect_UseEmailNameAsUserName = true;

$wgOpenIDConnect_Config[''] = [
    'clientID' => '',
    'clientsecret' => '',
    'scope' => ['openid', 'profile', 'email']
];
EOD;
}
function htaccessText(){
  return <<< 'EOD'
RewriteEngine On
RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-f
RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI} !-d
RewriteRule ^(.*)$ %{DOCUMENT_ROOT}/index.php [L]
EOD;
}
