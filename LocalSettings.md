## GCpedia LocalSettings.php

This file includes the settings for the extensions used in GCpedia to help set up development instances; some non-extention settings that need to be set are also present.

### Core MediaWiki settings

```php

# Disable EDIT for everyone
$wgGroupPermissions['*']['edit']              = false;

# Disable for users, too: by default 'user' is allowed to edit, even if '*' is not.
//REGULAR USER PERMISSIONS
$wgGroupPermissions['user']['edit']           = true;
$wgGroupPermissions['user']['move']           = true;
$wgGroupPermissions['user']['delete']         = false;
$wgGroupPermissions['user']['undelete']       = true;
$wgGroupPermissions['user']['deletedhistory'] = true;

$wgSitename = "GCpedia";

$wgLocaltimezone = "America/Montreal";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "http://www.gcpedia.gc.ca";							// this can't be 192.168.X.X if you want the visual editor to work

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = true; # UPO
$wgEmailAuthentication = true;



# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";


## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";
$wgFileExtensions = array('pub','png','gif','jpg','jpeg','pdf','xls','docx','pptx','doc','ppt','svg','xml','mpg','swf','odp','odt','wmv','flv','vsd','mpp','ai','zip','txt','wpd','rtf','drf','xlsx','xlsm', 'oft');


# To enable displayed menu structure when creating sub-pages
$wgNamespacesWithSubpages = array_fill(0, 100, true);

$wgAllowUserCss = true;
$wgAllowUserJs  = true;

$wgExtraNamespaces[100] = "Portal";
$wgExtraNamespaces[101] = "Portal_Talk";
$wgNamespacesWithSubpages[100] = true;
$wgNamespacesWithSubpages[101] = true;

$wgExtraNamespaces[102] = "Community";
$wgExtraNamespaces[103] = "Community_Talk";
$wgNamespacesWithSubpages[102] = true;
$wgNamespacesWithSubpages[103] = true;


# MESF Changes
$wgRawHtml = true;
$wgUseAjax = true;


$wgGroupPermissions['sysop']['deletelogentry'] = true;
$wgGroupPermissions['sysop']['deleterevision'] = true;


## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'Vector' );

```


### Extension - related section
This section can be copied and pasted into your LocalSettings.php with only a few modifications where needed.
Insert after the comments:
```php
# End of automatically generated settings.
# Add more configuration options below.
```

```php



wfLoadExtension( 'ParserFunctions' );
# Enabled Extensions. Most extensions are enabled by including the base extension file here
# but check specific extension documentation for more details
# The following extensions were automatically enabled:
$wgUseAjax = true;
require_once "$IP/extensions/AjaxShowEditors/AjaxShowEditors.php";
require_once "$IP/extensions/awards/awards.php";
require_once "$IP/extensions/customUserCreateForm/customUserCreateForm.php";
require_once "$IP/extensions/EmailUpdate/EmailUpdate.php";
$wgGroupPermissions['sysop']['emailupdate'] = true;

require_once "$IP/extensions/MagicNoNumberedHeadings/MagicNoNumberedHeadings.php";
require_once "$IP/extensions/MagicNumberedHeadings/MagicNumberedHeadings.php";
require_once "$IP/extensions/ROTedits/ROTedits.php";


# End of automatically generated settings.
# Add more configuration options below.

$wgEnableAPI = true;

require_once "$IP/extensions/UniversalLanguageSelector/UniversalLanguageSelector.php";
$wgULSGeoService = false;

require_once( "$IP/extensions/WikiEditor/WikiEditor.php" );
# Enable WikiEditor toolbar as default (but still allow users to disable)
$wgDefaultUserOptions['usebetatoolbar'] = 1;
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 0;
$wgDefaultUserOptions['wikieditor-preview'] = 0;

wfLoadExtension( 'Cite' );
wfLoadExtension( 'DeletePagesForGood' );
$wgGroupPermissions['*']         ['deleteperm'] = false;
$wgGroupPermissions['user']      ['deleteperm'] = false;
$wgGroupPermissions['bureaucrat']['deleteperm'] = true;
$wgGroupPermissions['sysop']     ['deleteperm'] = false;
$wgGroupPermissions['IMadmin']   ['deleteperm'] = true;
$wgGroupPermissions['IMadmin']   ['delete'] = true;
$wgGroupPermissions['IMadmin']   ['undelete'] = true;

wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'CharInsert' );
wfLoadExtension( 'TreeAndMenu' );
wfLoadExtension( 'InputBox' );
wfLoadExtension( 'Gadgets' );
wfLoadExtension( 'ImageMap' );
$wgImageMapAllowExternalLinks = true;

wfLoadExtension( 'InputBox' );

require_once("$IP/extensions/Lingo/Lingo.php");

/** Visual Editor configuration START **/
wfLoadExtension( 'VisualEditor' );

// Enable by default for everybody
$wgDefaultUserOptions['visualeditor-enable'] = 1;

// Don't allow users to disable it
$wgHiddenPrefs[] = 'visualeditor-enable';

// Parsoid link
$wgVirtualRestConfig['modules']['parsoid'] = array(
  // URL to the Parsoid instance
  // Use port 8142 if you use the Debian package
  'url' => 'http://127.0.0.1:8000',								// Set to the server hosting the parsoid service
  // Parsoid "domain", see below (optional)
  'domain' => 'gcpedia',
  // Parsoid "prefix", see below (optional)
  'prefix' => 'gcwiki'
);
// URL to the Parsoid instance
// MUST NOT end in a slash due to Parsoid bug
// Use port 8142 if you use the Debian package
//$wgVisualEditorParsoidURL = 'http://:8000';

// Interwiki prefix to pass to the Parsoid instance
// Parsoid will be called as $url/$prefix/$pagename
//$wgVisualEditorParsoidPrefix = 'localhost';

// List of skins VisualEditor integration supports
$wgVisualEditorSupportedSkins = array( 'vector' );
// Namespaces to enable VisualEditor in
$wgVisualEditorNamespaces =  array( NS_MAIN, NS_USER, NS_PROJECT );

/** Visual Editor configuration END **/


require_once "$IP/extensions/Collection/Collection.php";
$wgCollectionMWServeURL = "http://127.0.0.1:8899";				// Set to the server hosting the MW pdf parsing service

$wgCollectionPODPartners = false;
$wgCollectionFormats = array(
      'rl' => 'PDF', # enabled by default
    'odf' => 'ODT',
//    'docbook' => 'DocBook XML',
//    'xhtml' => 'XHTML 1.0 Transitional',
//    'epub' => 'e-book (EPUB)',
//    'zim' => 'Kiwix (OpenZIM)',
);

$wgGroupPermissions['user']['collectionsaveascommunitypage'] = true;
$wgGroupPermissions['user']['collectionsaveasuserpage']      = true;

$wgCollectionMaxArticles = 250;			// max # of articles per book


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
wfLoadExtension( 'AJAXPoll' );

/* Disclaimer */
require_once("$IP/extensions/GC_tcDisclaimer/disclaimer.php");
$wgDisclaimReset = 162; //time to reset disclaimer, in days

# Add a Star icon for selecting favorites:
# $wgUseIconFavorite = true; 
# Add a "My Favorites" link to the personal URLs area:
require_once("$IP/extensions/Favorites/Favorites.php");
$wgFavoritesPersonalURL = true;
$wgUseIconFavorite = true;

# Google Analytics 
require_once( "$IP/extensions/googleAnalytics/googleAnalytics.php" );
# Replace xxxxxxx-x with YOUR GoogleAnalytics UA number
$wgGoogleAnalyticsAccount = "XXXXXXXXX";

require_once( "$IP/extensions/ReplaceText/ReplaceText.php" );
$wgGroupPermissions['bureaucrat']['replacetext'] = true;
require_once "$IP/extensions/wikiFlvPlayer/wikiFlvPlayer.php";

require_once "$IP/extensions/UserMerge/UserMerge.php";
$wgGroupPermissions['sysop']['usermerge'] = true;
$wgUserMergeUnmergeable = array( 'sysop', 'awesomeusers' );

## Widgets
require_once("$IP/extensions/Widgets/Widgets.php");
$wgGroupPermissions['sysop']['editwidgets'] = true;


 
$wgShowSQLErrors = true;
$wgShowExceptionDetails = true;

wfLoadExtension( 'MsCalendar' );

```
