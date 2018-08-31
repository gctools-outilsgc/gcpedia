<?php

$wgArticlePath = "/$1";

wfLoadSkin( 'Vector' );
$wgLocaltimezone = "America/Montreal";
$wgLogo = "";

$wgNamespacesWithSubpages[NS_MAIN] = true;
  
# Disable EDIT for 'everyone'
$wgGroupPermissions['*']['edit']              = false;

# Disable for users, too: by default 'user' is allowed to edit, even if '*' is not.
//REGULAR USER PERMISSIONS
$wgGroupPermissions['user']['edit']           = true;
$wgGroupPermissions['user']['move']           = true;
$wgGroupPermissions['user']['delete']         = false;
$wgGroupPermissions['user']['undelete']       = true;
$wgGroupPermissions['user']['deletedhistory'] = true;

$wgEnableUploads = true;
$wgFileExtensions = array('pub','png','gif','jpg','jpeg','pdf','xls','docx','pptx','doc','ppt','svg','xml','mpg','swf','odp','odt','wmv','flv','vsd','mpp','ai','zip','txt','wpd','rtf','drf','xlsx','xlsm', 'oft');

$wgUseAjax = true;
$wgEnableAPI = true;

$wgGroupPermissions['sysop']['deletelogentry'] = true;
$wgGroupPermissions['sysop']['deleterevision'] = true;

$wgVectorUseIconWatch = false;

$wgRightsPage = "wiki:Copyright";
$wgRightsUrl = "http://creativecommons.org/licenses/by/4.0/";
$wgRightsText = "Creative Commons Attribution 4.0 International License";
$wgRightsIcon = "https://i.creativecommons.org/l/by/4.0/88x31.png";

////  extensions
wfLoadExtension( "ParserFunctions" );

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
$wgImageMapAllowExternalLinks = false;    // allowing this seems like a bad idea
wfLoadExtension( "InputBox" );
wfLoadExtension( "Lingo" );



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
  "url" => "localhost:8000",
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
$wgElectronPdfServiceRESTbaseURL = 'https://pdf.gccollab.ca/pdf?accessKey=secret&url=https://wiki.gccollab.ca/';


wfLoadExtension("intersection");
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
wfLoadExtension("CSS");
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
$wgMFAutodetectMobileView = true;

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
 
#$wgShowSQLErrors = true;
#$wgShowExceptionDetails = true;

require_once "$IP/extensions/IframePage/IframePage.php";
$wgIframePageSrc= array( 'GCcollab' => 'https://gccollab.ca/', 'YouTube' => 'https://www.youtube.com/embed/' );
$wgIframePageAllowPath = true;

require_once "$IP/extensions/Nuke/Nuke.php";
$wgGroupPermissions['sysop']['nuke'] = true;

require_once "$IP/extensions/googleAnalytics/googleAnalytics.php";
$wgGoogleAnalyticsAccount = $GAaccount;