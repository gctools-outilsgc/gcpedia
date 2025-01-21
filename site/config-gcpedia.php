<?php

$wgUsePathInfo = true;

wfLoadSkin('Vector');
$wgLocaltimezone = "America/Montreal";

$wgSitename = "GCpedia";

$wgLogo = '';
$wgFavicon = "$wgScriptPath/extensions/SkinTweaksGCpedia/resources/images/favicon.ico";
$wgLogos = [
    '1x' => "$wgScriptPath/extensions/SkinTweaksGCpedia/resources/images/GCpedia_icon_slogan_Eng.png",
    'variants' => [
        'fr' => [
            '1x' => "$wgScriptPath/extensions/SkinTweaksGCpedia/resources/images/GCpedia_icon_slogan_Fra.png",
        ],
    ],
];

# To enable displayed menu structure when creating sub-pages
$wgNamespacesWithSubpages = array_fill(0, 100, true);

$wgAllowUserCss = true;
$wgAllowUserJs = true;

$wgExtraNamespaces[100] = "Portal";
$wgExtraNamespaces[101] = "Portal_Talk";
$wgNamespacesWithSubpages[100] = true;
$wgNamespacesWithSubpages[101] = true;

$wgExtraNamespaces[102] = "Community";
$wgExtraNamespaces[103] = "Community_Talk";
$wgNamespacesWithSubpages[102] = true;
$wgNamespacesWithSubpages[103] = true;

# Disable EDIT for 'everyone'
$wgGroupPermissions['*']['edit'] = false;

# Disable for users, too: by default 'user' is allowed to edit, even if '*' is not.
//REGULAR USER PERMISSIONS
$wgGroupPermissions['user']['edit'] = true;
$wgGroupPermissions['user']['move'] = true;
$wgGroupPermissions['user']['delete'] = false;
$wgGroupPermissions['user']['undelete'] = true;
$wgGroupPermissions['user']['deletedhistory'] = true;

$wgEnableUploads = true;
$wgFileExtensions = array('pub', 'png', 'gif', 'jpg', 'jpeg', 'pdf', 'xls', 'docx', 'pptx', 'doc', 'ppt', 'svg', 'xml', 'mpg', 'odp', 'odt', 'wmv', 'flv', 'vsd', 'mpp', 'ai', 'zip', 'txt', 'wpd', 'rtf', 'drf', 'xlsx', 'xlsm', 'oft', 'swf', 'ppsx', 'dotx', 'potx');
$wgMaxUploadSize = 1024 * 1024 * 32;

$wgRawHtml = true;
$wgUseAjax = true;
$wgEnableAPI = true;

$wgGroupPermissions['sysop']['deletelogentry'] = true;
$wgGroupPermissions['sysop']['deleterevision'] = true;

$wgVectorUseIconWatch = false;

$wgFooterIcons = [
    "copyright" => [null],
    "poweredby" => [null],
    "canada-fip" => [
        "footer" => [
            "src" => "$wgScriptPath/extensions/SkinTweaksGCpedia/resources/images/wmms-alt.svg",
            "url" => null,
            "alt" => "Symbol of the Government of Canada",
            "width" => 186,
            "height" => 40
        ]
    ]
];

////  extensions
wfLoadExtension("ParserFunctions");

require_once "$IP/extensions/Multilang/multilang.php";

wfLoadExtension("UniversalLanguageSelector");
$wgULSGeoService = false;

wfLoadExtension("WikiEditor");
# Enable WikiEditor toolbar as default (but still allow users to disable)
$wgDefaultUserOptions["usebetatoolbar"] = 1;
$wgDefaultUserOptions["usebetatoolbar-cgd"] = 0;
$wgDefaultUserOptions["wikieditor-preview"] = 0;

wfLoadExtension("Cite");

wfLoadExtension('DeletePagesForGood');
$wgGroupPermissions['*']['deleteperm'] = false;
$wgGroupPermissions['user']['deleteperm'] = false;
$wgGroupPermissions['bureaucrat']['deleteperm'] = true;
$wgGroupPermissions['sysop']['deleteperm'] = false;
$wgGroupPermissions['IMadmin']['deleteperm'] = true;
$wgGroupPermissions['IMadmin']['delete'] = true;
$wgGroupPermissions['IMadmin']['undelete'] = true;

wfLoadExtension("CharInsert");
wfLoadExtension("TreeAndMenu");
wfLoadExtension("InputBox");
wfLoadExtension("Gadgets");
wfLoadExtension("ImageMap");
$wgImageMapAllowExternalLinks = false;    // allowing this seems like a bad idea
wfLoadExtension("InputBox");
wfLoadExtension("Lingo");
wfLoadExtension("VisualEditor");

// pdf rendering service
#wfLoadExtension("ElectronPdfService");
#$wgElectronPdfServiceRESTbaseURL = 'https://pdf.gccollab.ca/pdf?accessKey=secret&url=https://wiki.gccollab.ca/';
wfLoadExtension('PdfBook');
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
$wgDLPMaxCacheTime = 60 * 60 * 24;          // How long to cache pages in seconds

wfLoadExtension("LookupUser");
$wgGroupPermissions['sysop']['lookupuser'] = true;

wfLoadExtension("CategoryTree");
wfLoadExtension("CSS");
wfLoadExtension("EditUser");
$wgGroupPermissions['bureaucrat']['edituser'] = true;
$wgGroupPermissions['sysop']['edituser-exempt'] = true;

wfLoadExtension('CategoryWatch');

wfLoadExtension("RSS");
$wgRSSUrlWhitelist = array("*");
$wgRSSUrlNumberOfAllowedRedirects = 1;

// require_once( "$IP/extensions/Multilang/multilang.php" );

wfLoadExtension("MobileFrontend");
$wgMFAutodetectMobileView = true;

require_once ("$IP/extensions/GC_Messages/GC_Messages.php");

# Add a "My Favorites" link to the personal URLs area:
#wfLoadExtension("Favorites");
#$wgFavoritesPersonalURL = true;
# Add a Star icon for selecting favorites:
#$wgUseIconFavorite = false;

wfLoadExtension("ReplaceText");
$wgGroupPermissions['bureaucrat']['replacetext'] = true;

wfLoadExtension("UserMerge");
$wgGroupPermissions['sysop']['usermerge'] = true;
$wgUserMergeUnmergeable = array('sysop', 'awesomeusers');

wfLoadExtension("IframePage");
$wgIframePageSrc = array('GCcollab' => 'https://gccollab.ca/', 'YouTube' => 'https://www.youtube.com/embed/');
$wgIframePageAllowPath = true;

wfLoadExtension("Nuke");
$wgGroupPermissions['sysop']['nuke'] = true;

// activate when it's ready
wfLoadExtension("SkinTweaksGCpedia");

require_once "$IP/extensions/googleAnalytics/googleAnalytics.php";
$wgGoogleAnalyticsAccount = $GAaccount;




require_once "$IP/extensions/EmailUpdate/EmailUpdate.php";
$wgGroupPermissions['*']['emailupdate'] = false;
$wgGroupPermissions['sysop']['emailupdate'] = true;

require_once "$IP/extensions/awards/awards.php";

wfLoadExtension("GCUserCreateForm");

wfLoadExtension("AJAXPoll");
wfLoadExtension("AjaxShowEditors");
wfLoadExtension("MsCalendar");
wfLoadExtension("RandomImage");

wfLoadExtension("Widgets");
$wgEnableTranscode = false;
$wgFFmpegLocation = '/usr/bin/ffmpeg';

wfLoadExtension("SidebarTitleText");

wfLoadExtension("TimedMediaHandler");

$wgEnabledTranscodeSet = [];
$wgFFmpegLocation = '/usr/bin/ffmpeg';
$wgEnableTranscode = false;


wfLoadExtension("DismissableSiteNotice");
// This is the value of the cookie used to keep track of the site notice being dismissed
// increment it when a new one goes up
$wgMajorSiteNoticeID = 0.0;
$wgDismissableSiteNoticeForAnons = true;
