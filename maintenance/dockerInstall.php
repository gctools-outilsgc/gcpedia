<?php

// environment variables from docker-compose
if (getenv('DBHOST') != '')
	$dbhost = getenv('DBHOST');
else
	$dbhost = 'gcpedia-db';

if (getenv('HOST') != '')
  $host = getenv('HOST');
else
  $host = 'localhost';
if (getenv('PORT') != '')
  $port = ":".getenv('PORT');
else
  $port = '';

if (getenv('USESAML') != '')
	$saml = getenv('USESAML');
else
	$saml = false;
echo "Using dbhost: $dbhost   and host: $host \n";

// first run regular cli install script
shell_exec("php /var/www/html/docker_gcpedia/maintenance/install.php --confpath=/var/www/html/docker_gcpedia/ \
 --dbserver={$dbhost} --dbtype=mysql --dbuser=wiki --dbpass=gcpedia --dbname=wiki \
 --scriptpath=/docker_gcpedia --server='http://{$host}{$port}' --lang=en  \
 --pass=adminpassword 'GCpedia' 'admin' ");
echo "basic setup complete\n";

// then add extensions; some require extra configuration so this will get a bit long...
$local_settings = fopen("/var/www/html/docker_gcpedia/LocalSettings.php", 'a');		// a for append

// using single brackets as a simple way to prevent parsing of variable names, etc.
fwrite($local_settings, returnLocalSettingsText());
if ($saml) fwrite($local_settings, returnLocalSettingsSAMLText());
fclose($local_settings);
echo "LocalSettings.php setup complete\n";

shell_exec("php /var/www/html/docker_gcpedia/maintenance/update.php");		// some extensions being added will need db changes, update.php will handle that

echo "DB update complete\n  Install Complete!\n";

function returnLocalSettingsText(){
  return <<< 'EOD'
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

$wgGroupPermissions['sysop']['deletelogentry'] = true;
$wgGroupPermissions['sysop']['deleterevision'] = true;


////  extensions

wfLoadExtension( "ParserFunctions" );

$wgUseAjax = true;
require_once "$IP/extensions/AjaxShowEditors/AjaxShowEditors.php";
require_once "$IP/extensions/awards/awards.php";
require_once "$IP/extensions/customUserCreateForm/customUserCreateForm.php";
require_once "$IP/extensions/EmailUpdate/EmailUpdate.php";
$wgGroupPermissions["sysop"]["emailupdate"] = true;
require_once "$IP/extensions/MagicNoNumberedHeadings/MagicNoNumberedHeadings.php";
require_once "$IP/extensions/MagicNumberedHeadings/MagicNumberedHeadings.php";

$wgEnableAPI = true;
require_once "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php";
$wgULSGeoService = false;
require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );
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


// Collection extension
require_once "$IP/extensions/Collection/Collection.php";
$wgCollectionMWServeURL = "mwlib:8899";

$wgCollectionPODPartners = false;
$wgCollectionFormats = array(
      "rl" => "PDF", # enabled by default
    "odf" => "ODT",
//    "docbook" => "DocBook XML",
//    "xhtml" => "XHTML 1.0 Transitional",
//    "epub" => "e-book (EPUB)",
//    "zim" => "Kiwix (OpenZIM)",
);

$wgGroupPermissions["user"]["collectionsaveascommunitypage"] = true;
$wgGroupPermissions["user"]["collectionsaveasuserpage"]      = true;

$wgCollectionMaxArticles = 250;     // max # of articles per book


## Video Enableing Extensions
require_once("$IP/extensions/FramedVideo/FramedVideo.php");
include_once('extensions/wikiFlvPlayer/wikiFlvPlayer.php');
require_once('extensions/ExtVideo/ExtVideo.php');


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

require_once "$IP/extensions/LookupUser/LookupUser.php";
$wgGroupPermissions['sysop']['lookupuser'] = true;


require_once "$IP/extensions/CategoryTree/CategoryTree.php";
require_once("$IP/extensions/CSS/CSS.php");
require_once("$IP/extensions/EditUser/EditUser.php");
$wgGroupPermissions['bureaucrat']['edituser'] = true;
$wgGroupPermissions['sysop']['edituser-exempt'] = true;

require_once( "$IP/extensions/NewUserPage/NewUserPage.php" );

require_once( "$IP/extensions/CategoryWatch/CategoryWatch.php" );
require_once("extensions/tag_cloud.php");

require_once "$IP/extensions/RSS/RSS.php";
$wgRSSUrlWhitelist = array("*");
$wgRSSUrlNumberOfAllowedRedirects = 1;

require_once("$IP/extensions/EmailUpdate/EmailUpdate.php");
$wgGroupPermissions['sysop']['emailupdate'] = true;

require_once( "$IP/extensions/Multilang/multilang.php" );

require_once("$IP/extensions/MobileFrontend/MobileFrontend.php");

require_once("$IP/extensions/GC_Messages/GC_Messages.php");

require_once( "$IP/extensions/GCRandomImage/GCRandomImage.php" );

require_once("{$IP}/extensions/Poll/Poll.php");
//wfLoadExtension( 'AJAXPoll' );
require_once("$IP/extensions/AJAXPoll/AJAXPoll.php");

/* Disclaimer */
require_once("$IP/extensions/GC_tcDisclaimer/disclaimer.php");
$wgDisclaimReset = 162; //time to reset disclaimer, in days

# Add a Star icon for selecting favorites:
# $wgUseIconFavorite = true; 
# Add a "My Favorites" link to the personal URLs area:
require_once("$IP/extensions/Favorites/Favorites.php");
$wgFavoritesPersonalURL = true;
$wgUseIconFavorite = true;

require_once( "$IP/extensions/ReplaceText/ReplaceText.php" );
$wgGroupPermissions['bureaucrat']['replacetext'] = true;
require_once "$IP/extensions/wikiFlvPlayer/wikiFlvPlayer.php";

require_once "$IP/extensions/UserMerge/UserMerge.php";
$wgGroupPermissions['sysop']['usermerge'] = true;
$wgUserMergeUnmergeable = array( 'sysop', 'awesomeusers' );
 
$wgShowSQLErrors = true;
$wgShowExceptionDetails = true;

wfLoadExtension( 'MsCalendar' );

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