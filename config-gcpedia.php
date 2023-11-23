<?php

$wgArticlePath = "/$1";

wfLoadSkin( 'Vector' );
$wgLocaltimezone = "America/Montreal";

$wgSitename = "GCpedia";

$wgLogo = '';
$wgFavicon = "extensions/SkinTweaksGCpedia/resources/images/mini_gcpedia_icon.png";
$wgLogos = [ 
    '1x' =>  'extensions/SkinTweaksGCpedia/resources/images/gcpedia_logo_en_1x.png',
    'variants' => [
		'fr' => [
            '1x' => "extensions/SkinTweaksGCwiki/resources/images/gcpedia_logo_fr_1x.png",
        ],
    ],
];

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
$wgFileExtensions = array('pub','png','gif','jpg','jpeg','pdf','xls','docx','pptx','doc','ppt','svg','xml','mpg','odp','odt','wmv','flv','vsd','mpp','ai','zip','txt','wpd','rtf','drf','xlsx','xlsm', 'oft');

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

require_once "$IP/extensions/MagicNoNumberedHeadings/MagicNoNumberedHeadings.php";
require_once "$IP/extensions/MagicNumberedHeadings/MagicNumberedHeadings.php";

wfLoadExtension( "UniversalLanguageSelector" );
$wgULSGeoService = false;

wfLoadExtension( "WikiEditor" );
# Enable WikiEditor toolbar as default (but still allow users to disable)
$wgDefaultUserOptions["usebetatoolbar"] = 1;
$wgDefaultUserOptions["usebetatoolbar-cgd"] = 0;
$wgDefaultUserOptions["wikieditor-preview"] = 0;

wfLoadExtension( "Cite" );
$wgGroupPermissions["IMadmin"]   ["delete"] = true;
$wgGroupPermissions["IMadmin"]   ["undelete"] = true;

wfLoadExtension( "CharInsert" );
wfLoadExtension( "TreeAndMenu" );
wfLoadExtension( "InputBox" );
wfLoadExtension( "Gadgets" );
wfLoadExtension( "ImageMap" );
$wgImageMapAllowExternalLinks = false;    // allowing this seems like a bad idea
wfLoadExtension( "InputBox" );
wfLoadExtension( "Lingo" );
wfLoadExtension( "VisualEditor" );

// pdf rendering service
#wfLoadExtension("ElectronPdfService");
#$wgElectronPdfServiceRESTbaseURL = 'https://pdf.gccollab.ca/pdf?accessKey=secret&url=https://wiki.gccollab.ca/';
wfLoadExtension( 'PdfBook' );
$wgPdfBookTab = false;
$wgPdfBookDownload = false;

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

wfLoadExtension( "CategoryTree" );
wfLoadExtension("CSS");
wfLoadExtension("EditUser");
$wgGroupPermissions['bureaucrat']['edituser'] = true;
$wgGroupPermissions['sysop']['edituser-exempt'] = true;

wfLoadExtension( 'CategoryWatch' );

wfLoadExtension("RSS");
$wgRSSUrlWhitelist = array("*");
$wgRSSUrlNumberOfAllowedRedirects = 1;

require_once( "$IP/extensions/Multilang/multilang.php" );

wfLoadExtension("MobileFrontend");
$wgMFAutodetectMobileView = true;

require_once("$IP/extensions/GC_Messages/GC_Messages.php");

# Add a "My Favorites" link to the personal URLs area:
#wfLoadExtension("Favorites");
#$wgFavoritesPersonalURL = true;
# Add a Star icon for selecting favorites:
#$wgUseIconFavorite = false;

wfLoadExtension( "ReplaceText" );
$wgGroupPermissions['bureaucrat']['replacetext'] = true;

wfLoadExtension( "UserMerge" );
$wgGroupPermissions['sysop']['usermerge'] = true;
$wgUserMergeUnmergeable = array( 'sysop', 'awesomeusers' );

wfLoadExtension( "IframePage" );
$wgIframePageSrc= array( 'GCcollab' => 'https://gccollab.ca/', 'YouTube' => 'https://www.youtube.com/embed/' );
$wgIframePageAllowPath = true;

wfLoadExtension( "Nuke" );
$wgGroupPermissions['sysop']['nuke'] = true;

// activate when it's ready
#wfLoadExtension( "SkinTweaksGCpedia" );

require_once "$IP/extensions/googleAnalytics/googleAnalytics.php";
$wgGoogleAnalyticsAccount = $GAaccount;




require_once "$IP/extensions/GC_tcDisclaimer/disclaimer.php";
#require_once "$IP/extensions/ROTedits/ROTedits.php";
require_once "$IP/extensions/awards/awards.php";

wfLoadExtension( "AJAXPoll" );
wfLoadExtension( "AjaxShowEditors" );
wfLoadExtension( "MsCalendar" );
wfLoadExtension( "RandomImage" );

/* ????

NewUserPage ? - maintain or drop

customUserCreateForm ? - unmaintained for a long time


mwSimpleSamlAuth ? unmaintained, used for gcconnex - based simple login


***video players***
FramedVideo

*/





#$wgShowSQLErrors = true;
#$wgShowExceptionDetails = true;