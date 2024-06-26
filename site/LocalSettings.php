<?php

# Protect against web entry
if (!defined('MEDIAWIKI')) {
	exit;
}


## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "Dev wiki instance";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = (getenv('SCRIPT_PATH') != '') ? getenv('SCRIPT_PATH') : "";
$wgArticlePath = (getenv('ARTICLE_PATH') != '') ? getenv('ARTICLE_PATH') : "/$1";

## The protocol and server name to use in fully-qualified URLs
$host = (getenv('WIKI_HOST') != '') ? getenv('WIKI_HOST') : 'localhost';
$port = (getenv('WIKI_PORT') != '' && getenv('WIKI_PORT') != '80') ? ":" . getenv('WIKI_PORT') : '';
$protocol = (getenv('WIKI_PROTOCOL') != '') ? getenv('WIKI_PROTOCOL') : 'https';
$wgServer = "{$protocol}://{$host}{$port}";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL paths to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogos = ['1x' => "$wgResourceBasePath/resources/assets/wiki.png"];

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

## smtp authentication
$wgPasswordSender = (getenv('WIKI_PASSWORDSENDER') != '') ? getenv('WIKI_PASSWORDSENDER') : '';
if (getenv('WIKI_SMTP_HOST')) {
	$wgSMTP = array(
		'host' => getenv('WIKI_SMTP_HOST'), // could also be an IP address. Where the SMTP server is located
		'port' => getenv('WIKI_SMTP_PORT'),                 // Port to use when connecting to the SMTP server
		'auth' => getenv('WIKI_SMTP_AUTH'),               // Should we use SMTP authentication (true or false)
		'username' => getenv('WIKI_SMTP_USERNAME'),     // Username to use for SMTP authentication (if being used)
		'password' => getenv('WIKI_SMTP_PASSWORD')
	);
}

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = (getenv('DBHOST') != '') ? getenv('DBHOST') : 'gcpedia-db';
$wgDBname = (getenv('DBNAME') != '') ? getenv('DBNAME') : 'wiki';
$wgDBuser = (getenv('DBUSER') != '') ? getenv('DBUSER') : 'wiki';
$wgDBpassword = (getenv('DBPASS') != '') ? getenv('DBPASS') : 'gcpedia';
$wgDBssl = (getenv('DBSSL') != '') ? getenv('DBSSL') : 'false';

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Shared database table
# This has no effect unless $wgSharedDB is also set.
$wgSharedTables[] = "actor";

## Shared memory settings
$wgMainCacheType = (getenv('CACHE_TYPE') == 'CACHE_MEMCACHED') ? CACHE_MEMCACHED : CACHE_ACCEL;

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale. This should ideally be set to an English
## language locale so that the behaviour of C library functions will
## be consistent with typical installations. Use $wgLanguageCode to
## localise the wiki.
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";

$wgSecretKey = (getenv('SECRETKEY') != '') ? getenv('SECRETKEY') : 'Secret123';

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin('MinervaNeue');
wfLoadSkin('MonoBook');
wfLoadSkin('Timeless');
wfLoadSkin('Vector');


# End of automatically generated settings.
# Add more configuration options below.

$GAaccount = (getenv('GAACCOUNT') != '') ? getenv('GAACCOUNT') : 'UA-xxxxxxx-x';

if (getenv('WIKI_DEBUG') === 'true') {
	$wgShowExceptionDetails = true;
	$wgSitename = "Dev wiki instance - DEBUG mode";
}

if (getenv('SITE') == 'gcpedia') {
	require_once ('/site/config-gcpedia.php');
} else if (getenv('SITE') == 'gcwiki') {
	require_once ('/site/config-gcwiki.php');
} else {
	die('SITE env variable not set');
}