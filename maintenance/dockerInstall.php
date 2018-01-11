<?php

// environment variables from docker-compose
$dbhost = (getenv('DBHOST') != '') ? getenv('DBHOST') : 'gcpedia-db';
$host = (getenv('HOST') != '') ? getenv('HOST') : 'localhost';
$port = (getenv('PORT') != '') ? ":".getenv('PORT') : '';
$saml = (getenv('USESAML') != '') ? getenv('USESAML') : false;
$oauth = (getenv('OAUTH') != '') ? getenv('OAUTH') : false;
$openid = (getenv('OPENID') != '') ? getenv('OPENID') : false;

echo "Using dbhost: $dbhost   and host: $host \n";

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

$wgArticlePath = "/$1";

wfLoadSkin( 'Vector' );
$wgLocaltimezone = "America/Montreal";
$wgLogo = "";
  
# Disable EDIT for 'everyone'
$wgGroupPermissions['*']['edit']              = false;

# Disable for users, too: by default 'user' is allowed to edit, even if '*' is not.
//REGULAR USER PERMISSIONS
$wgGroupPermissions['user']['edit']           = true;
$wgGroupPermissions['user']['move']           = true;
$wgGroupPermissions['user']['delete']         = false;
$wgGroupPermissions['user']['undelete']       = true;
$wgGroupPermissions['user']['deletedhistory'] = true;

$wgFileExtensions = array('pub','png','gif','jpg','jpeg','pdf','xls','docx','pptx','doc','ppt','svg','xml','mpg','swf','odp','odt','wmv','flv','vsd','mpp','ai','zip','txt','wpd','rtf','drf','xlsx','xlsm', 'oft');

$wgUseAjax = true;
$wgEnableAPI = true;

$wgGroupPermissions['sysop']['deletelogentry'] = true;
$wgGroupPermissions['sysop']['deleterevision'] = true;


////  extensions
wfLoadExtension( "ParserFunctions" );

//require_once "$IP/extensions/AjaxShowEditors/AjaxShowEditors.php";
//require_once "$IP/extensions/customUserCreateForm/customUserCreateForm.php";
require_once "$IP/extensions/EmailUpdate/EmailUpdate.php";
$wgGroupPermissions["sysop"]["emailupdate"] = true;
require_once "$IP/extensions/MagicNoNumberedHeadings/MagicNoNumberedHeadings.php";
require_once "$IP/extensions/MagicNumberedHeadings/MagicNumberedHeadings.php";

require_once "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php";
$wgULSGeoService = false;

wfLoadExtension( "WikiEditor" );
# Enable WikiEditor toolbar as default (but still allow users to disable)
$wgDefaultUserOptions["usebetatoolbar"] = 1;
$wgDefaultUserOptions["usebetatoolbar-cgd"] = 0;
$wgDefaultUserOptions["wikieditor-preview"] = 0;

wfLoadExtension( "Cite" );
wfLoadExtension( "DeletePagesForGood" );
$wgGroupPermissions["*"]         ["deleteperm"] = false;
$wgGroupPermissions["user"]      ["deleteperm"] = false;
$wgGroupPermissions["bureaucrat"]["deleteperm"] = true;
$wgGroupPermissions["sysop"]     ["deleteperm"] = false;
$wgGroupPermissions["IMadmin"]   ["deleteperm"] = true;
$wgGroupPermissions["IMadmin"]   ["delete"] = true;
$wgGroupPermissions["IMadmin"]   ["undelete"] = true;

wfLoadExtension( "Renameuser" );
wfLoadExtension( "CharInsert" );
wfLoadExtension( "TreeAndMenu" );
wfLoadExtension( "InputBox" );
wfLoadExtension( "Gadgets" );
wfLoadExtension( "ImageMap" );
$wgImageMapAllowExternalLinks = true;
wfLoadExtension( "InputBox" );
require_once("$IP/extensions/Lingo/Lingo.php");



/** Visual Editor configuration START **/
wfLoadExtension( "VisualEditor" );

// Enable by default for everybody
$wgDefaultUserOptions["visualeditor-enable"] = 1;

// Don"t allow users to disable it
$wgHiddenPrefs[] = "visualeditor-enable";

// Parsoid link
$wgVirtualRestConfig["modules"]["parsoid"] = array(
  // URL to the Parsoid instance
  // Use port 8142 if you use the Debian package
  "url" => "parsoid:8000",
  // Parsoid "domain", see below (optional)
  "domain" => "localhost",
  // Parsoid "prefix", see below (optional)
  //"prefix" => "gcwiki"
);
// List of skins VisualEditor integration supports
$wgVisualEditorSupportedSkins = array( "vector" );
// Namespaces to enable VisualEditor in
$wgVisualEditorNamespaces =  array( NS_MAIN, NS_USER, NS_PROJECT );

/** Visual Editor configuration END **/

// pdf rendering service
wfLoadExtension("ElectronPdfService");
$wgElectronPdfServiceRESTbaseURL = '/api/rest_v1/page/pdf/';


require_once("$IP/extensions/intersection/DynamicPageList.php");
# Configuration variables. Warning: These use DLP instead of DPL
# for historical reasons (pretend Dynamic list of pages)
$wgDLPmaxCategories = 6;                // Maximum number of categories to look for
$wgDLPMaxResultCount = 200;             // Maximum number of results to allow
$wgDLPAllowUnlimitedResults = false;    // Allow unlimited results
$wgDLPAllowUnlimitedCategories = false; // Allow unlimited categories
// How long to cache pages using DPL's in seconds. Default to 1 day. Set to
// false to use the normal amount of page caching (most efficient), Set to 0 to disable
// cache altogether (inefficient, but results will never be outdated)
$wgDLPMaxCacheTime = 60*60*24;          // How long to cache pages in seconds

wfLoadExtension( "LookupUser" );
$wgGroupPermissions['sysop']['lookupuser'] = true;


require_once "$IP/extensions/CategoryTree/CategoryTree.php";
require_once("$IP/extensions/CSS/CSS.php");
require_once("$IP/extensions/EditUser/EditUser.php");
$wgGroupPermissions['bureaucrat']['edituser'] = true;
$wgGroupPermissions['sysop']['edituser-exempt'] = true;

require_once( "$IP/extensions/CategoryWatch/CategoryWatch.php" );

wfLoadExtension("RSS");
$wgRSSUrlWhitelist = array("*");
$wgRSSUrlNumberOfAllowedRedirects = 1;

require_once("$IP/extensions/EmailUpdate/EmailUpdate.php");
$wgGroupPermissions['sysop']['emailupdate'] = true;

require_once( "$IP/extensions/Multilang/multilang.php" );

wfLoadExtension("MobileFrontend");

require_once("$IP/extensions/GC_Messages/GC_Messages.php");

# Add a "My Favorites" link to the personal URLs area:
require_once("$IP/extensions/Favorites/Favorites.php");
$wgFavoritesPersonalURL = true;
# Add a Star icon for selecting favorites:
$wgUseIconFavorite = true;

require_once( "$IP/extensions/ReplaceText/ReplaceText.php" );
$wgGroupPermissions['bureaucrat']['replacetext'] = true;

wfLoadExtension( "UserMerge" );
$wgGroupPermissions['sysop']['usermerge'] = true;
$wgUserMergeUnmergeable = array( 'sysop', 'awesomeusers' );
 
$wgShowSQLErrors = true;
$wgShowExceptionDetails = true;

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

$wgGroupPermissions['*']['createaccount'] = true;
$wgGroupPermissions['*']['autocreateaccount'] = true;
$wgOpenIDConnect_UseRealNameAsUserName = true;

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
