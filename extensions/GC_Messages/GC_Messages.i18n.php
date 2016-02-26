<?php

$messages = array();

// ctrl+f: "12345"
// to skip to french ($messaged['fr'])
$messages['en'] = array(
/*
The sidebar for MonoBook is generated from this message, lines that do not
begin with * or ** are discarded, furthermore lines that do begin with ** and
do not contain | are also discarded, but do not depend on this behaviour for
future releases. Also note that since each list value is wrapped in a unique
XHTML id it should only appear once and include characters that are legal
XHTML id names.
*/
'sidebar' => '
* navigation
** mainpage|mainpage-description
** portal-url|portal
** currentevents-url|currentevents
** recentchanges-url|recentchanges
** randompage-url|randompage
** helppage|help
* SEARCH
* TOOLBOX
* LANGUAGES', # do not translate or duplicate this message to other languages

# User preference toggles
'tog-underline'               => 'Link underlining:',
'tog-justify'                 => 'Justify paragraphs',
'tog-hideminor'               => 'Hide minor edits in recent changes',
'tog-hidepatrolled'           => 'Hide patrolled edits in recent changes',
'tog-newpageshidepatrolled'   => 'Hide patrolled pages from new page list',
'tog-extendwatchlist'         => 'Expand watchlist to show all changes, not just the most recent',
'tog-usenewrc'                => 'Group changes by page in recent changes and watchlist (requires JavaScript)',
'tog-numberheadings'          => 'Auto-number headings',
'tog-showtoolbar'             => 'Show edit toolbar (requires JavaScript)',
'tog-editondblclick'          => 'Edit pages on double click (requires JavaScript)',
'tog-editsection'             => 'Enable section editing via [edit] links',
'tog-editsectiononrightclick' => 'Enable section editing by right clicking on section titles (requires JavaScript)',
'tog-showtoc'                 => 'Show table of contents (for pages with more than 3 headings)',
'tog-rememberpassword'        => 'Remember my login on this browser (for a maximum of $1 {{PLURAL:$1|day|days}})',
'tog-watchcreations'          => 'Add pages I create and files I upload to my watchlist',
'tog-watchdefault'            => 'Add pages and files I edit to my watchlist',
'tog-watchmoves'              => 'Add pages and files I move to my watchlist',
'tog-watchdeletion'           => 'Add pages and files I delete to my watchlist',
'tog-minordefault'            => 'Mark all edits minor by default',
'tog-previewontop'            => 'Show preview before edit box',
'tog-previewonfirst'          => 'Show preview on first edit',
'tog-nocache'                 => 'Disable browser page caching',
'tog-enotifwatchlistpages'    => 'E-mail me when a page or file on my watchlist is changed',
'tog-enotifusertalkpages'     => 'E-mail me when my user talk page is changed',
'tog-enotifminoredits'        => 'E-mail me also for minor edits of pages and files',
'tog-enotifrevealaddr'        => 'Reveal my e-mail address in notification e-mails',
'tog-shownumberswatching'     => 'Show the number of watching users',
'tog-oldsig'                  => 'Existing signature:',
'tog-fancysig'                => 'Treat signature as wikitext (without an automatic link)',
'tog-externaleditor'          => 'Use external editor by default (for experts only, needs special settings on your computer. [//www.mediawiki.org/wiki/Manual:External_editors More information.])',
'tog-externaldiff'            => 'Use external diff by default (for experts only, needs special settings on your computer. [//www.mediawiki.org/wiki/Manual:External_editors More information.])',
'tog-showjumplinks'           => 'Enable "jump to" accessibility links',
'tog-uselivepreview'          => 'Use live preview (requires JavaScript) (experimental)',
'tog-forceeditsummary'        => 'Prompt me when entering a blank edit summary',
'tog-watchlisthideown'        => 'Hide my edits from the watchlist',
'tog-watchlisthidebots'       => 'Hide bot edits from the watchlist',
'tog-watchlisthideminor'      => 'Hide minor edits from the watchlist',
'tog-watchlisthideliu'        => 'Hide edits by logged in users from the watchlist',
'tog-watchlisthideanons'      => 'Hide edits by anonymous users from the watchlist',
'tog-watchlisthidepatrolled'  => 'Hide patrolled edits from the watchlist',
'tog-ccmeonemails'            => 'Send me copies of e-mails I send to other users',
'tog-diffonly'                => 'Do not show page content below diffs',
'tog-showhiddencats'          => 'Show hidden categories',
'tog-noconvertlink'           => 'Disable link title conversion', # only translate this message to other languages if you have to change it
'tog-norollbackdiff'          => 'Omit diff after performing a rollback',

'underline-always'  => 'Always',
'underline-never'   => 'Never',
'underline-default' => 'Skin or browser default',

# Font style option in Special:Preferences
'editfont-style'     => 'Edit area font style:',
'editfont-default'   => 'Browser default',
'editfont-monospace' => 'Monospaced font',
'editfont-sansserif' => 'Sans-serif font',
'editfont-serif'     => 'Serif font',

# Dates
'sunday'        => 'Sunday',
'monday'        => 'Monday',
'tuesday'       => 'Tuesday',
'wednesday'     => 'Wednesday',
'thursday'      => 'Thursday',
'friday'        => 'Friday',
'saturday'      => 'Saturday',
'sun'           => 'Sun',
'mon'           => 'Mon',
'tue'           => 'Tue',
'wed'           => 'Wed',
'thu'           => 'Thu',
'fri'           => 'Fri',
'sat'           => 'Sat',
'january'       => 'January',
'february'      => 'February',
'march'         => 'March',
'april'         => 'April',
'may_long'      => 'May',
'june'          => 'June',
'july'          => 'July',
'august'        => 'August',
'september'     => 'September',
'october'       => 'October',
'november'      => 'November',
'december'      => 'December',
'january-gen'   => 'January',
'february-gen'  => 'February',
'march-gen'     => 'March',
'april-gen'     => 'April',
'may-gen'       => 'May',
'june-gen'      => 'June',
'july-gen'      => 'July',
'august-gen'    => 'August',
'september-gen' => 'September',
'october-gen'   => 'October',
'november-gen'  => 'November',
'december-gen'  => 'December',
'jan'           => 'Jan',
'feb'           => 'Feb',
'mar'           => 'Mar',
'apr'           => 'Apr',
'may'           => 'May',
'jun'           => 'Jun',
'jul'           => 'Jul',
'aug'           => 'Aug',
'sep'           => 'Sep',
'oct'           => 'Oct',
'nov'           => 'Nov',
'dec'           => 'Dec',

# Categories related messages
'pagecategories'                 => '{{PLURAL:$1|Category|Categories}}',
'pagecategorieslink'             => 'Special:Categories', # do not translate or duplicate this message to other languages
'category_header'                => 'Pages in category "$1"',
'subcategories'                  => 'Subcategories',
'category-media-header'          => 'Media in category "$1"',
'category-empty'                 => "''This category currently contains no pages or media.''",
'hidden-categories'              => '{{PLURAL:$1|Hidden category|Hidden categories}}',
'hidden-category-category'       => 'Hidden categories',
'category-subcat-count'          => '{{PLURAL:$2|This category has only the following subcategory.|This category has the following {{PLURAL:$1|subcategory|$1 subcategories}}, out of $2 total.}}',
'category-subcat-count-limited'  => 'This category has the following {{PLURAL:$1|subcategory|$1 subcategories}}.',
'category-article-count'         => '{{PLURAL:$2|This category contains only the following page.|The following {{PLURAL:$1|page is|$1 pages are}} in this category, out of $2 total.}}',
'category-article-count-limited' => 'The following {{PLURAL:$1|page is|$1 pages are}} in the current category.',
'category-file-count'            => '{{PLURAL:$2|This category contains only the following file.|The following {{PLURAL:$1|file is|$1 files are}} in this category, out of $2 total.}}',
'category-file-count-limited'    => 'The following {{PLURAL:$1|file is|$1 files are}} in the current category.',
'listingcontinuesabbrev'         => 'cont.',
'index-category'                 => 'Indexed pages',
'noindex-category'               => 'Noindexed pages',
'broken-file-category'           => 'Pages with broken file links',
'categoryviewer-pagedlinks'      => '($1) ($2)', # only translate this message to other languages if you have to change it

'linkprefix' => '/^(.*?)([a-zA-Z\\x80-\\xff]+)$/sD', # only translate this message to other languages if you have to change it

'about'         => 'About',
'article'       => 'Content page',
'newwindow'     => '(opens in new window)',
'cancel'        => 'Cancel',
'moredotdotdot' => 'More...',
'mypage'        => 'Page',
'mytalk'        => 'Talk',
'anontalk'      => 'Talk for this IP address',
'navigation'    => 'Navigation',
'and'           => '&#32;and',

# Cologne Blue skin
'qbfind'         => 'Find',
'qbbrowse'       => 'Browse',
'qbedit'         => 'Edit',
'qbpageoptions'  => 'This page',
'qbpageinfo'     => 'Context',
'qbmyoptions'    => 'My pages',
'qbspecialpages' => 'Special pages',
'faq'            => 'FAQ',
'faqpage'        => 'Project:FAQ',
'sitetitle'      => '{{SITENAME}}', # do not translate or duplicate this message to other languages
'sitesubtitle'   => '', # do not translate or duplicate this message to other languages

# Vector skin
'vector-action-addsection'       => 'Add topic',
'vector-action-delete'           => 'Delete',
'vector-action-move'             => 'Move',
'vector-action-protect'          => 'Protect',
'vector-action-undelete'         => 'Undelete',
'vector-action-unprotect'        => 'Change protection',
'vector-simplesearch-preference' => 'Enable simplified search bar (Vector skin only)',
'vector-view-create'             => 'Create',
'vector-view-edit'               => 'Edit',
'vector-view-history'            => 'View history',
'vector-view-view'               => 'Read',
'vector-view-viewsource'         => 'View source',
'actions'                        => 'Actions',
'namespaces'                     => 'Namespaces',
'variants'                       => 'Variants',

'errorpagetitle'    => 'Error',
'returnto'          => 'Return to $1.',
'tagline'           => 'From {{SITENAME}}',
'help'              => 'Help',
'search'            => 'Search',
'searchbutton'      => 'Search',
'go'                => 'Go',
'searcharticle'     => 'Go',
'history'           => 'Page history',
'history_short'     => 'History',
'updatedmarker'     => 'updated since my last visit',
'printableversion'  => 'Printable version',
'permalink'         => 'Permanent link',
'print'             => 'Print',
'view'              => 'View',
'edit'              => 'Edit',
'create'            => 'Create',
'editthispage'      => 'Edit this page',
'create-this-page'  => 'Create this page',
'delete'            => 'Delete',
'deletethispage'    => 'Delete this page',
'undelete_short'    => 'Undelete {{PLURAL:$1|one edit|$1 edits}}',
'viewdeleted_short' => 'View {{PLURAL:$1|one deleted edit|$1 deleted edits}}',
'protect'           => 'Protect',
'protect_change'    => 'change',
'protectthispage'   => 'Protect this page',
'unprotect'         => 'Change protection',
'unprotectthispage' => 'Change protection of this page',
'newpage'           => 'New page',
'talkpage'          => 'Discuss this page',
'talkpagelinktext'  => 'Talk',
'specialpage'       => 'Special page',
'personaltools'     => 'Personal tools',
'postcomment'       => 'New section',
'addsection'        => '+', # do not translate or duplicate this message to other languages
'articlepage'       => 'View content page',
'talk'              => 'Discussion',
'views'             => 'Views',
'toolbox'           => 'Toolbox',
'userpage'          => 'View user page',
'projectpage'       => 'View project page',
'imagepage'         => 'View file page',
'mediawikipage'     => 'View message page',
'templatepage'      => 'View template page',
'viewhelppage'      => 'View help page',
'categorypage'      => 'View category page',
'viewtalkpage'      => 'View discussion',
'otherlanguages'    => 'In other languages',
'redirectedfrom'    => '(Redirected from $1)',
'redirectpagesub'   => 'Redirect page',
'talkpageheader'    => '-', # do not translate or duplicate this message to other languages
'lastmodifiedat'    => 'This page was last modified on $1, at $2.',
'viewcount'         => 'This page has been accessed {{PLURAL:$1|once|$1 times}}.',
'protectedpage'     => 'Protected page',
'jumpto'            => 'Jump to:',
'jumptonavigation'  => 'navigation',
'jumptosearch'      => 'search',
'view-pool-error'   => 'Sorry, the servers are overloaded at the moment.
Too many users are trying to view this page.
Please wait a while before you try to access this page again.

$1',
'pool-timeout'      => 'Timeout waiting for the lock',
'pool-queuefull'    => 'Pool queue is full',
'pool-errorunknown' => 'Unknown error',

# All link text and link target definitions of links into project namespace that get used by other message strings, with the exception of user group pages (see grouppage) and the disambiguation template definition (see disambiguations).
'aboutsite'            => 'About {{SITENAME}}',
'aboutpage'            => 'Project:About',
'copyright'            => 'Content is available under $1.',
'copyrightpage'        => '{{ns:project}}:Copyrights',
'currentevents'        => 'Current events',
'currentevents-url'    => 'Project:Current events',
'disclaimers'          => 'Disclaimers',
'disclaimerpage'       => 'Project:General disclaimer',
'edithelp'             => 'Editing help',
'edithelppage'         => 'Help:Editing',
'helppage'             => 'Help:Contents',
'mainpage'             => 'Main Page',
'mainpage-description' => 'Main page',
'policy-url'           => 'Project:Policy',
'portal'               => 'Community portal',
'portal-url'           => 'Project:Community portal',
'privacy'              => 'Privacy policy',
'privacypage'          => 'Project:Privacy policy',

'badaccess'        => 'Permission error',
'badaccess-group0' => 'You are not allowed to execute the action you have requested.',
'badaccess-groups' => 'The action you have requested is limited to users in {{PLURAL:$2|the group|one of the groups}}: $1.',

'versionrequired'     => 'Version $1 of MediaWiki required',
'versionrequiredtext' => 'Version $1 of MediaWiki is required to use this page.
See [[Special:Version|version page]].',

'ok'                           => 'OK',
'pagetitle'                    => '$1 - {{SITENAME}}', # only translate this message to other languages if you have to change it
'pagetitle-view-mainpage'      => '{{SITENAME}}', # only translate this message to other languages if you have to change it
'backlinksubtitle'             => '← $1', # only translate this message to other languages if you have to change it
'retrievedfrom'                => 'Retrieved from "$1"',
'youhavenewmessages'           => 'You have $1 ($2).',
'newmessageslink'              => 'new messages',
'newmessagesdifflink'          => 'last change',
'youhavenewmessagesfromusers'  => 'You have $1 from {{PLURAL:$3|another user|$3 users}} ($2).',
'youhavenewmessagesmanyusers'  => 'You have $1 from many users ($2).',
'newmessageslinkplural'        => '{{PLURAL:$1|a new message|new messages}}',
'newmessagesdifflinkplural'    => 'last {{PLURAL:$1|change|changes}}',
'youhavenewmessagesmulti'      => 'You have new messages on $1',
'newtalkseparator'             => ',&#32;', # do not translate or duplicate this message to other languages
'editsection'                  => 'edit',
'editsection-brackets'         => '[$1]', # only translate this message to other languages if you have to change it
'editold'                      => 'edit',
'viewsourceold'                => 'view source',
'editlink'                     => 'edit',
'viewsourcelink'               => 'view source',
'editsectionhint'              => 'Edit section: $1',
'toc'                          => 'Contents',
'showtoc'                      => 'show',
'hidetoc'                      => 'hide',
'collapsible-collapse'         => 'Collapse',
'collapsible-expand'           => 'Expand',
'thisisdeleted'                => 'View or restore $1?',
'viewdeleted'                  => 'View $1?',
'restorelink'                  => '{{PLURAL:$1|one deleted edit|$1 deleted edits}}',
'feedlinks'                    => 'Feed:',
'feed-invalid'                 => 'Invalid subscription feed type.',
'feed-unavailable'             => 'Syndication feeds are not available',
'site-rss-feed'                => '$1 RSS feed',
'site-atom-feed'               => '$1 Atom feed',
'page-rss-feed'                => '"$1" RSS feed',
'page-atom-feed'               => '"$1" Atom feed',
'feed-atom'                    => 'Atom', # only translate this message to other languages if you have to change it
'feed-rss'                     => 'RSS', # only translate this message to other languages if you have to change it
'sitenotice'                   => '-', # do not translate or duplicate this message to other languages
'anonnotice'                   => '-', # do not translate or duplicate this message to other languages
'newsectionheaderdefaultlevel' => '== $1 ==', # do not translate or duplicate this message to other languages
'red-link-title'               => '$1 (page does not exist)',
'sort-descending'              => 'Sort descending',
'sort-ascending'               => 'Sort ascending',

# Short words for each namespace, by default used in the namespace tab in monobook
'nstab-main'      => 'Page',
'nstab-user'      => 'User page',
'nstab-media'     => 'Media page',
'nstab-special'   => 'Special page',
'nstab-project'   => 'Project page',
'nstab-image'     => 'File',
'nstab-mediawiki' => 'Message',
'nstab-template'  => 'Template',
'nstab-help'      => 'Help page',
'nstab-category'  => 'Category',
'mainpage-nstab'  => '', # do not translate or duplicate this message to other languages

# Main script and global functions
'nosuchaction'      => 'No such action',
'nosuchactiontext'  => 'The action specified by the URL is invalid.
You might have mistyped the URL, or followed an incorrect link.
This might also indicate a bug in the software used by {{SITENAME}}.',
'nosuchspecialpage' => 'No such special page',
'nospecialpagetext' => '<strong>You have requested an invalid special page.</strong>

A list of valid special pages can be found at [[Special:SpecialPages|{{int:specialpages}}]].',

# General errors
'error'                         => 'Error',
'databaseerror'                 => 'Database error',
'dberrortext'                   => 'A database query syntax error has occurred.
This may indicate a bug in the software.
The last attempted database query was:
<blockquote><code>$1</code></blockquote>
from within function "<code>$2</code>".
Database returned error "<samp>$3: $4</samp>".',
'dberrortextcl'                 => 'A database query syntax error has occurred.
The last attempted database query was:
"$1"
from within function "$2".
Database returned error "$3: $4"',
'laggedslavemode'               => "'''Warning:''' Page may not contain recent updates.",
'readonly'                      => 'Database locked',
'enterlockreason'               => 'Enter a reason for the lock, including an estimate of when the lock will be released',
'readonlytext'                  => 'The database is currently locked to new entries and other modifications, probably for routine database maintenance, after which it will be back to normal.

The administrator who locked it offered this explanation: $1',
'missing-article'               => 'The database did not find the text of a page that it should have found, named "$1" $2.

This is usually caused by following an outdated diff or history link to a page that has been deleted.

If this is not the case, you may have found a bug in the software.
Please report this to an [[Special:ListUsers/sysop|administrator]], making note of the URL.',
'missingarticle-rev'            => '(revision#: $1)',
'missingarticle-diff'           => '(Diff: $1, $2)',
'readonly_lag'                  => 'The database has been automatically locked while the slave database servers catch up to the master',
'internalerror'                 => 'Internal error',
'internalerror_info'            => 'Internal error: $1',
'fileappenderrorread'           => 'Could not read "$1" during append.',
'fileappenderror'               => 'Could not append "$1" to "$2".',
'filecopyerror'                 => 'Could not copy file "$1" to "$2".',
'filerenameerror'               => 'Could not rename file "$1" to "$2".',
'filedeleteerror'               => 'Could not delete file "$1".',
'directorycreateerror'          => 'Could not create directory "$1".',
'filenotfound'                  => 'Could not find file "$1".',
'fileexistserror'               => 'Unable to write to file "$1": File exists.',
'unexpected'                    => 'Unexpected value: "$1"="$2".',
'formerror'                     => 'Error: Could not submit form.',
'badarticleerror'               => 'This action cannot be performed on this page.',
'cannotdelete'                  => 'The page or file "$1" could not be deleted.
It may have already been deleted by someone else.',
'cannotdelete-title'            => 'Cannot delete page "$1"',
'delete-hook-aborted'           => 'Deletion aborted by hook.
It gave no explanation.',
'badtitle'                      => 'Bad title',
'badtitletext'                  => 'The requested page title was invalid, empty, or an incorrectly linked inter-language or inter-wiki title.
It may contain one or more characters that cannot be used in titles.',
'perfcached'                    => 'The following data is cached and may not be up to date. A maximum of {{PLURAL:$1|one result is|$1 results are}} available in the cache.',
'perfcachedts'                  => 'The following data is cached, and was last updated $1. A maximum of {{PLURAL:$4|one result is|$4 results are}} available in the cache.',
'querypage-no-updates'          => 'Updates for this page are currently disabled.
Data here will not presently be refreshed.',
'wrong_wfQuery_params'          => 'Incorrect parameters to wfQuery()<br />
Function: $1<br />
Query: $2',
'viewsource'                    => 'View source',
'viewsource-title'              => 'View source for $1',
'actionthrottled'               => 'Action throttled',
'actionthrottledtext'           => 'As an anti-spam measure, you are limited from performing this action too many times in a short space of time, and you have exceeded this limit.
Please try again in a few minutes.',
'protectedpagetext'             => 'This page has been protected to prevent editing or other actions.',
'viewsourcetext'                => 'You can view and copy the source of this page:',
'viewyourtext'                  => "You can view and copy the source of '''your edits''' to this page:",
'protectedinterface'            => 'This page provides interface text for the software on this wiki, and is protected to prevent abuse.
To add or change translations for all wikis, please use [//translatewiki.net/ translatewiki.net], the MediaWiki localisation project.',
'editinginterface'              => "'''Warning:''' You are editing a page that is used to provide interface text for the software.
Changes to this page will affect the appearance of the user interface for other users on this wiki.
To add or change translations for all wikis, please use [//translatewiki.net/ translatewiki.net], the MediaWiki localisation project.",
'sqlhidden'                     => '(SQL query hidden)',
'cascadeprotected'              => 'This page has been protected from editing because it is included in the following {{PLURAL:$1|page, which is|pages, which are}} protected with the "cascading" option turned on:
$2',
'namespaceprotected'            => "You do not have permission to edit pages in the '''$1''' namespace.",
'customcssprotected'            => "You do not have permission to edit this CSS page because it contains another user's personal settings.",
'customjsprotected'             => "You do not have permission to edit this JavaScript page because it contains another user's personal settings.",
'ns-specialprotected'           => 'Special pages cannot be edited.',
'titleprotected'                => 'This title has been protected from creation by [[User:$1|$1]].
The reason given is "\'\'$2\'\'".',
'filereadonlyerror'             => 'Unable to modify the file "$1" because the file repository "$2" is in read-only mode.

The administrator who locked it offered this explanation: "$3".',
'invalidtitle-knownnamespace'   => 'Invalid title with namespace "$2" and text "$3"',
'invalidtitle-unknownnamespace' => 'Invalid title with unknown namespace number $1 and text "$2"',
'exception-nologin'             => 'Not logged in',
'exception-nologin-text'        => 'This page or action requires you to be logged in on this wiki.',

# Virus scanner
'virus-badscanner'     => "Bad configuration: Unknown virus scanner: ''$1''",
'virus-scanfailed'     => 'scan failed (code $1)',
'virus-unknownscanner' => 'unknown antivirus:',

# Login and logout pages
'logouttext'                 => "'''You are now logged out.'''

You can continue to use {{SITENAME}} anonymously, or you can [[Special:UserLogin|log in again]] as the same or as a different user.
Note that some pages may continue to be displayed as if you were still logged in, until you clear your browser cache.",
'welcomecreation'            => '== Welcome, $1! ==
Your account has been created.
Do not forget to change your [[Special:Preferences|{{SITENAME}} preferences]].',
'yourname'                   => 'Username:',
'yourpassword'               => 'Password:',
'yourpasswordagain'          => 'Retype password:',
'remembermypassword'         => 'Remember my login on this browser (for a maximum of $1 {{PLURAL:$1|day|days}})',
'securelogin-stick-https'    => 'Stay connected to HTTPS after login',
'yourdomainname'             => 'Your domain:',
'password-change-forbidden'  => 'You cannot change passwords on this wiki.',
'externaldberror'            => 'There was either an authentication database error or you are not allowed to update your external account.',
'login'                      => 'Log in',
'nav-login-createaccount'    => 'Log in / create account',
'loginprompt'                => 'You must have cookies enabled to log in to {{SITENAME}}.',
'userlogin'                  => 'Log in / create account',
'userloginnocreate'          => 'Log in',
'logout'                     => 'Log out',
'userlogout'                 => 'Log out',
'userlogout-summary'         => '', # do not translate or duplicate this message to other languages
'notloggedin'                => 'Not logged in',
'nologin'                    => "Don't have an account? $1.",
'nologinlink'                => 'Create an account',
'createaccount'              => 'Create account',
'gotaccount'                 => 'Already have an account? $1.',
'gotaccountlink'             => 'Log in',
'userlogin-resetlink'        => 'Forgotten your login details?',
'createaccountmail'          => 'By e-mail',
'createaccountreason'        => 'Reason:',
'badretype'                  => 'The passwords you entered do not match.',
'userexists'                 => 'Username entered already in use.
Please choose a different name.',
'loginerror'                 => 'Login error',
'createaccounterror'         => 'Could not create account: $1',
'nocookiesnew'               => 'The user account was created, but you are not logged in.
{{SITENAME}} uses cookies to log in users.
You have cookies disabled.
Please enable them, then log in with your new username and password.',
'nocookieslogin'             => '{{SITENAME}} uses cookies to log in users.
You have cookies disabled.
Please enable them and try again.',
'nocookiesfornew'            => 'The user account was not created, as we could not confirm its source.
Ensure you have cookies enabled, reload this page and try again.',
'nocookiesforlogin'          => '{{int:nocookieslogin}}', # only translate this message to other languages if you have to change it
'noname'                     => 'You have not specified a valid username.',
'loginsuccesstitle'          => 'Login successful',
'loginsuccess'               => "'''You are now logged in to {{SITENAME}} as \"\$1\".'''",
'nosuchuser'                 => 'There is no user by the name "$1".
Usernames are case sensitive.
Check your spelling, or [[Special:UserLogin/signup|create a new account]].',
'nosuchusershort'            => 'There is no user by the name "$1".
Check your spelling.',
'nouserspecified'            => 'You have to specify a username.',
'login-userblocked'          => 'This user is blocked. Login not allowed.',
'wrongpassword'              => 'Incorrect password entered.
Please try again.',
'wrongpasswordempty'         => 'Password entered was blank.
Please try again.',
'passwordtooshort'           => 'Passwords must be at least {{PLURAL:$1|1 character|$1 characters}}.',
'password-name-match'        => 'Your password must be different from your username.',
'password-login-forbidden'   => 'The use of this username and password has been forbidden.',
'mailmypassword'             => 'E-mail new password',
'passwordremindertitle'      => 'New temporary password for {{SITENAME}}',
'passwordremindertext'       => 'Someone (probably you, from IP address $1) requested a new
password for {{SITENAME}} ($4). A temporary password for user
"$2" has been created and was set to "$3". If this was your
intent, you will need to log in and choose a new password now.
Your temporary password will expire in {{PLURAL:$5|one day|$5 days}}.

If someone else made this request, or if you have remembered your password,
and you no longer wish to change it, you may ignore this message and
continue using your old password.',
'noemail'                    => 'There is no e-mail address recorded for user "$1".',
'noemailcreate'              => 'You need to provide a valid e-mail address',
'passwordsent'               => 'A new password has been sent to the e-mail address registered for "$1".
Please log in again after you receive it.',
'blocked-mailpassword'       => 'Your IP address is blocked from editing, and so is not allowed to use the password recovery function to prevent abuse.',
'eauthentsent'               => 'A confirmation e-mail has been sent to the nominated e-mail address.
Before any other e-mail is sent to the account, you will have to follow the instructions in the e-mail, to confirm that the account is actually yours.',
'throttled-mailpassword'     => 'A password reminder has already been sent, within the last {{PLURAL:$1|hour|$1 hours}}.
To prevent abuse, only one password reminder will be sent per {{PLURAL:$1|hour|$1 hours}}.',
'loginstart'                 => '', # do not translate or duplicate this message to other languages
'loginend'                   => '', # do not translate or duplicate this message to other languages
'loginend-https'             => '', # do not translate or duplicate this message to other languages
'signupstart'                => '{{int:loginstart}}', # do not translate or duplicate this message to other languages
'signupend'                  => '{{int:loginend}}', # do not translate or duplicate this message to other languages
'signupend-https'            => '', # do not translate or duplicate this message to other languages
'mailerror'                  => 'Error sending mail: $1',
'acct_creation_throttle_hit' => 'Visitors to this wiki using your IP address have created {{PLURAL:$1|1 account|$1 accounts}} in the last day, which is the maximum allowed in this time period.
As a result, visitors using this IP address cannot create any more accounts at the moment.',
'emailauthenticated'         => 'Your e-mail address was authenticated on $2 at $3.',
'emailnotauthenticated'      => 'Your e-mail address is not yet authenticated.
No e-mail will be sent for any of the following features.',
'noemailprefs'               => 'Specify an e-mail address in your preferences for these features to work.',
'emailconfirmlink'           => 'Confirm your e-mail address',
'invalidemailaddress'        => 'The e-mail address cannot be accepted as it appears to have an invalid format.
Please enter a well-formatted address or empty that field.',
'cannotchangeemail'          => 'Account e-mail addresses cannot be changed on this wiki.',
'emaildisabled'              => 'This site cannot send e-mails.',
'accountcreated'             => 'Account created',
'accountcreatedtext'         => 'The user account for $1 has been created.',
'createaccount-title'        => 'Account creation for {{SITENAME}}',
'createaccount-text'         => 'Someone created an account for your e-mail address on {{SITENAME}} ($4) named "$2", with password "$3".
You should log in and change your password now.

You may ignore this message, if this account was created in error.',
'usernamehasherror'          => 'Username cannot contain hash characters',
'login-throttled'            => 'You have made too many recent login attempts.
Please wait before trying again.',
'login-abort-generic'        => 'Your login was unsuccessful - Aborted',
'loginlanguagelabel'         => 'Language: $1',
'loginlanguagelinks'         => '* {{#language:de}}|de
* {{#language:en}}|en
* {{#language:eo}}|eo
* {{#language:fr}}|fr
* {{#language:es}}|es
* {{#language:it}}|it
* {{#language:nl}}|nl', # do not translate or duplicate this message to other languages
'suspicious-userlogout'      => 'Your request to log out was denied because it looks like it was sent by a broken browser or caching proxy.',

# E-mail sending
'pear-mail-error'        => '$1', # do not translate or duplicate this message to other languages
'php-mail-error'         => '$1', # do not translate or duplicate this message to other languages
'php-mail-error-unknown' => "Unknown error in PHP's mail() function.",
'user-mail-no-addy'      => 'Tried to send e-mail without an e-mail address.',

# Change password dialog
'resetpass'                 => 'Change password',
'resetpass_announce'        => 'You logged in with a temporary e-mailed code.
To finish logging in, you must set a new password here:',
'resetpass_text'            => '<!-- Add text here -->', # only translate this message to other languages if you have to change it
'resetpass_header'          => 'Change account password',
'oldpassword'               => 'Old password:',
'newpassword'               => 'New password:',
'retypenew'                 => 'Retype new password:',
'resetpass_submit'          => 'Set password and log in',
'resetpass_success'         => 'Your password has been changed successfully!
Now logging you in...',
'resetpass_forbidden'       => 'Passwords cannot be changed',
'resetpass-no-info'         => 'You must be logged in to access this page directly.',
'resetpass-submit-loggedin' => 'Change password',
'resetpass-submit-cancel'   => 'Cancel',
'resetpass-wrong-oldpass'   => 'Invalid temporary or current password.
You may have already successfully changed your password or requested a new temporary password.',
'resetpass-temp-password'   => 'Temporary password:',

# Special:PasswordReset
'passwordreset'                    => 'Reset password',
'passwordreset-text'               => 'Complete this form to receive an e-mail reminder of your account details.',
'passwordreset-legend'             => 'Reset password',
'passwordreset-disabled'           => 'Password resets have been disabled on this wiki.',
'passwordreset-pretext'            => '{{PLURAL:$1||Enter one of the pieces of data below}}',
'passwordreset-username'           => 'Username:',
'passwordreset-domain'             => 'Domain:',
'passwordreset-capture'            => 'View the resulting e-mail?',
'passwordreset-capture-help'       => 'If you check this box, the e-mail (with the temporary password) will be shown to you as well as being sent to the user.',
'passwordreset-email'              => 'E-mail address:',
'passwordreset-emailtitle'         => 'Account details on {{SITENAME}}',
'passwordreset-emailtext-ip'       => 'Someone (probably you, from IP address $1) requested a reminder of your
account details for {{SITENAME}} ($4). The following user {{PLURAL:$3|account is|accounts are}}
associated with this e-mail address:

$2

{{PLURAL:$3|This temporary password|These temporary passwords}} will expire in {{PLURAL:$5|one day|$5 days}}.
You should log in and choose a new password now. If someone else made this
request, or if you have remembered your original password, and you no longer
wish to change it, you may ignore this message and continue using your old
password.',
'passwordreset-emailtext-user'     => 'User $1 on {{SITENAME}} requested a reminder of your account details for {{SITENAME}}
($4). The following user {{PLURAL:$3|account is|accounts are}} associated with this e-mail address:

$2

{{PLURAL:$3|This temporary password|These temporary passwords}} will expire in {{PLURAL:$5|one day|$5 days}}.
You should log in and choose a new password now. If someone else made this
request, or if you have remembered your original password, and you no longer
wish to change it, you may ignore this message and continue using your old
password.',
'passwordreset-emailelement'       => 'Username: $1
Temporary password: $2',
'passwordreset-emailsent'          => 'A reminder e-mail has been sent.',
'passwordreset-emailsent-capture'  => 'A reminder e-mail has been sent, which is shown below.',
'passwordreset-emailerror-capture' => 'A reminder e-mail was generated, which is shown below, but sending it to the user failed: $1',

# Special:ChangeEmail
'changeemail'          => 'Change e-mail address',
'changeemail-summary'  => '', # do not translate or duplicate this message to other languages
'changeemail-header'   => 'Change account e-mail address',
'changeemail-text'     => 'Complete this form to change your e-mail address. You will need to enter your password to confirm this change.',
'changeemail-no-info'  => 'You must be logged in to access this page directly.',
'changeemail-oldemail' => 'Current e-mail address:',
'changeemail-newemail' => 'New e-mail address:',
'changeemail-none'     => '(none)',
'changeemail-submit'   => 'Change e-mail',
'changeemail-cancel'   => 'Cancel',

# Edit page toolbar
'bold_sample'     => 'Bold text',
'bold_tip'        => 'Bold text',
'italic_sample'   => 'Italic text',
'italic_tip'      => 'Italic text',
'link_sample'     => 'Link title',
'link_tip'        => 'Internal link',
'extlink_sample'  => 'http://www.example.com link title',
'extlink_tip'     => 'External link (remember http:// prefix)',
'headline_sample' => 'Headline text',
'headline_tip'    => 'Level 2 headline',
'nowiki_sample'   => 'Insert non-formatted text here',
'nowiki_tip'      => 'Ignore wiki formatting',
'image_sample'    => 'Example.jpg', # only translate this message to other languages if you have to change it
'image_tip'       => 'Embedded file',
'media_sample'    => 'Example.ogg', # only translate this message to other languages if you have to change it
'media_tip'       => 'File link',
'sig_tip'         => 'Your signature with timestamp',
'hr_tip'          => 'Horizontal line (use sparingly)',

# Edit pages
'summary'                          => 'Summary:',
'subject'                          => 'Subject/headline:',
'minoredit'                        => 'This is a minor edit',
'watchthis'                        => 'Watch this page',
'savearticle'                      => 'Save page',
'preview'                          => 'Preview',
'showpreview'                      => 'Show preview',
'showlivepreview'                  => 'Live preview',
'showdiff'                         => 'Show changes',
'anoneditwarning'                  => "'''Warning:''' You are not logged in.
Your IP address will be recorded in this page's edit history.",
'anonpreviewwarning'               => "''You are not logged in. Saving will record your IP address in this page's edit history.''",
'missingsummary'                   => "'''Reminder:''' You have not provided an edit summary.
If you click \"{{int:savearticle}}\" again, your edit will be saved without one.",
'missingcommenttext'               => 'Please enter a comment below.',
'missingcommentheader'             => "'''Reminder:''' You have not provided a subject/headline for this comment.
If you click \"{{int:savearticle}}\" again, your edit will be saved without one.",
'summary-preview'                  => 'Summary preview:',
'subject-preview'                  => 'Subject/headline preview:',
'blockedtitle'                     => 'User is blocked',
'blockedtext'                      => "'''Your username or IP address has been blocked.'''

The block was made by $1.
The reason given is ''$2''.

* Start of block: $8
* Expiry of block: $6
* Intended blockee: $7

You can contact $1 or another [[{{MediaWiki:Grouppage-sysop}}|administrator]] to discuss the block.
You cannot use the 'e-mail this user' feature unless a valid e-mail address is specified in your [[Special:Preferences|account preferences]] and you have not been blocked from using it.
Your current IP address is $3, and the block ID is #$5.
Please include all above details in any queries you make.",
'autoblockedtext'                  => 'Your IP address has been automatically blocked because it was used by another user, who was blocked by $1.
The reason given is:

:\'\'$2\'\'

* Start of block: $8
* Expiry of block: $6
* Intended blockee: $7

You may contact $1 or one of the other [[{{MediaWiki:Grouppage-sysop}}|administrators]] to discuss the block.

Note that you may not use the "e-mail this user" feature unless you have a valid e-mail address registered in your [[Special:Preferences|user preferences]] and you have not been blocked from using it.

Your current IP address is $3, and the block ID is #$5.
Please include all above details in any queries you make.',
'blockednoreason'                  => 'no reason given',
'whitelistedittext'                => 'You have to $1 to edit pages.',
'confirmedittext'                  => 'You must confirm your e-mail address before editing pages.
Please set and validate your e-mail address through your [[Special:Preferences|user preferences]].',
'nosuchsectiontitle'               => 'Cannot find section',
'nosuchsectiontext'                => 'You tried to edit a section that does not exist.
It may have been moved or deleted while you were viewing the page.',
'loginreqtitle'                    => 'Login required',
'loginreqlink'                     => 'log in',
'loginreqpagetext'                 => 'You must $1 to view other pages.',
'accmailtitle'                     => 'Password sent.',
'accmailtext'                      => "A randomly generated password for [[User talk:$1|$1]] has been sent to $2.

The password for this new account can be changed on the ''[[Special:ChangePassword|change password]]'' page upon logging in.",
'newarticle'                       => '(New)',
'newarticletext'                   => "You have followed a link to a page that does not exist yet.
To create the page, start typing in the box below (see the [[{{MediaWiki:Helppage}}|help page]] for more info).
If you are here by mistake, click your browser's '''back''' button.",
'newarticletextanon'               => '{{int:newarticletext}}', # do not translate or duplicate this message to other languages
'talkpagetext'                     => '<!-- MediaWiki:talkpagetext -->', # do not translate or duplicate this message to other languages
'anontalkpagetext'                 => "----''This is the discussion page for an anonymous user who has not created an account yet, or who does not use it.
We therefore have to use the numerical IP address to identify him/her.
Such an IP address can be shared by several users.
If you are an anonymous user and feel that irrelevant comments have been directed at you, please [[Special:UserLogin/signup|create an account]] or [[Special:UserLogin|log in]] to avoid future confusion with other anonymous users.''",
'noarticletext'                    => 'There is currently no text in this page.
You can [[Special:Search/{{PAGENAME}}|search for this page title]] in other pages,
<span class="plainlinks">[{{fullurl:{{#Special:Log}}|page={{FULLPAGENAMEE}}}} search the related logs],
or [{{fullurl:{{FULLPAGENAME}}|action=edit}} edit this page]</span>.',
'noarticletext-nopermission'       => 'There is currently no text in this page.
You can [[Special:Search/{{PAGENAME}}|search for this page title]] in other pages, or <span class="plainlinks">[{{fullurl:{{#Special:Log}}|page={{FULLPAGENAMEE}}}} search the related logs]</span>, but you do not have permission to create this page.',
'noarticletextanon'                => '{{int:noarticletext}}', # do not translate or duplicate this message to other languages
'missing-revision'                 => 'The revision #$1 of the page named "{{PAGENAME}}" does not exist.

This is usually caused by following an outdated history link to a page that has been deleted.
Details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].',
'userpage-userdoesnotexist'        => 'User account "$1" is not registered.
Please check if you want to create/edit this page.',
'userpage-userdoesnotexist-view'   => 'User account "$1" is not registered.',
'blocked-notice-logextract'        => 'This user is currently blocked.
The latest block log entry is provided below for reference:',
'clearyourcache'                   => "'''Note:''' After saving, you may have to bypass your browser's cache to see the changes.
* '''Firefox / Safari:''' Hold ''Shift'' while clicking ''Reload'', or press either ''Ctrl-F5'' or ''Ctrl-R'' (''⌘-R'' on a Mac)
* '''Google Chrome:''' Press ''Ctrl-Shift-R'' (''⌘-Shift-R'' on a Mac)
* '''Internet Explorer:''' Hold ''Ctrl'' while clicking ''Refresh'', or press ''Ctrl-F5''
* '''Opera:''' Clear the cache in ''Tools → Preferences''",
'usercssyoucanpreview'             => "'''Tip:''' Use the \"{{int:showpreview}}\" button to test your new CSS before saving.",
'userjsyoucanpreview'              => "'''Tip:''' Use the \"{{int:showpreview}}\" button to test your new JavaScript before saving.",
'usercsspreview'                   => "'''Remember that you are only previewing your user CSS.'''
'''It has not yet been saved!'''",
'userjspreview'                    => "'''Remember that you are only testing/previewing your user JavaScript.'''
'''It has not yet been saved!'''",
'sitecsspreview'                   => "'''Remember that you are only previewing this CSS.'''
'''It has not yet been saved!'''",
'sitejspreview'                    => "'''Remember that you are only previewing this JavaScript code.'''
'''It has not yet been saved!'''",
'userinvalidcssjstitle'            => "'''Warning:''' There is no skin \"\$1\".
Custom .css and .js pages use a lowercase title, e.g. {{ns:user}}:Foo/vector.css as opposed to {{ns:user}}:Foo/Vector.css.",
'updated'                          => '(Updated)',
'note'                             => "'''Note:'''",
'previewnote'                      => "'''Remember that this is only a preview.'''
Your changes have not yet been saved!",
'continue-editing'                 => 'Go to editing area',
'previewconflict'                  => 'This preview reflects the text in the upper text editing area as it will appear if you choose to save.',
'session_fail_preview'             => "'''Sorry! We could not process your edit due to a loss of session data.'''
Please try again.
If it still does not work, try [[Special:UserLogout|logging out]] and logging back in.",
'session_fail_preview_html'        => "'''Sorry! We could not process your edit due to a loss of session data.'''

''Because {{SITENAME}} has raw HTML enabled, the preview is hidden as a precaution against JavaScript attacks.''

'''If this is a legitimate edit attempt, please try again.'''
If it still does not work, try [[Special:UserLogout|logging out]] and logging back in.",
'token_suffix_mismatch'            => "'''Your edit has been rejected because your client mangled the punctuation characters in the edit token.'''
The edit has been rejected to prevent corruption of the page text.
This sometimes happens when you are using a buggy web-based anonymous proxy service.",
'edit_form_incomplete'             => "'''Some parts of the edit form did not reach the server; double-check that your edits are intact and try again.'''",
'editing'                          => 'Editing $1',
'creating'                         => 'Creating $1',
'editingsection'                   => 'Editing $1 (section)',
'editingcomment'                   => 'Editing $1 (new section)',
'editconflict'                     => 'Edit conflict: $1',
'explainconflict'                  => "Someone else has changed this page since you started editing it.
The upper text area contains the page text as it currently exists.
Your changes are shown in the lower text area.
You will have to merge your changes into the existing text.
'''Only''' the text in the upper text area will be saved when you press \"{{int:savearticle}}\".",
'yourtext'                         => 'Your text',
'storedversion'                    => 'Stored revision',
'nonunicodebrowser'                => "'''Warning: Your browser is not Unicode compliant.'''
A workaround is in place to allow you to safely edit pages: Non-ASCII characters will appear in the edit box as hexadecimal codes.",
'editingold'                       => "'''Warning: You are editing an out-of-date revision of this page.'''
If you save it, any changes made since this revision will be lost.",
'yourdiff'                         => 'Differences',
'copyrightwarning'                 => "Please note that all contributions to {{SITENAME}} are considered to be released under the $2 (see $1 for details).
If you do not want your writing to be edited mercilessly and redistributed at will, then do not submit it here.<br />
You are also promising us that you wrote this yourself, or copied it from a public domain or similar free resource.
'''Do not submit copyrighted work without permission!'''",
'copyrightwarning2'                => "Please note that all contributions to {{SITENAME}} may be edited, altered, or removed by other contributors.
If you do not want your writing to be edited mercilessly, then do not submit it here.<br />
You are also promising us that you wrote this yourself, or copied it from a public domain or similar free resource (see $1 for details).
'''Do not submit copyrighted work without permission!'''",
'editpage-head-copy-warn'          => '-', # do not translate or duplicate this message to other languages
'editpage-tos-summary'             => '-', # do not translate or duplicate this message to other languages
'longpage-hint'                    => '-', # do not translate or duplicate this message to other languages
'longpageerror'                    => "'''Error: The text you have submitted is {{PLURAL:$1|one kilobyte|$1 kilobytes}} long, which is longer than the maximum of {{PLURAL:$2|one kilobyte|$2 kilobytes}}.'''
It cannot be saved.",
'readonlywarning'                  => "'''Warning: The database has been locked for maintenance, so you will not be able to save your edits right now.'''
You may wish to copy and paste your text into a text file and save it for later.

The administrator who locked it offered this explanation: $1",
'protectedpagewarning'             => "'''Warning: This page has been protected so that only users with administrator privileges can edit it.'''
The latest log entry is provided below for reference:",
'semiprotectedpagewarning'         => "'''Note:''' This page has been protected so that only registered users can edit it.
The latest log entry is provided below for reference:",
'cascadeprotectedwarning'          => "'''Warning:''' This page has been protected so that only users with administrator privileges can edit it because it is included in the following cascade-protected {{PLURAL:$1|page|pages}}:",
'titleprotectedwarning'            => "'''Warning: This page has been protected so that [[Special:ListGroupRights|specific rights]] are needed to create it.'''
The latest log entry is provided below for reference:",
'templatesused'                    => '{{PLURAL:$1|Template|Templates}} used on this page:',
'templatesusedpreview'             => '{{PLURAL:$1|Template|Templates}} used in this preview:',
'templatesusedsection'             => '{{PLURAL:$1|Template|Templates}} used in this section:',
'template-protected'               => '(protected)',
'template-semiprotected'           => '(semi-protected)',
'hiddencategories'                 => 'This page is a member of {{PLURAL:$1|1 hidden category|$1 hidden categories}}:',
'edittools'                        => '<!-- Text here will be shown below edit and upload forms. -->', # only translate this message to other languages if you have to change it
'edittools-upload'                 => '-', # only translate this message to other languages if you have to change it
'nocreatetitle'                    => 'Page creation limited',
'nocreatetext'                     => '{{SITENAME}} has restricted the ability to create new pages.
You can go back and edit an existing page, or [[Special:UserLogin|log in or create an account]].',
'nocreate-loggedin'                => 'You do not have permission to create new pages.',
'sectioneditnotsupported-title'    => 'Section editing not supported',
'sectioneditnotsupported-text'     => 'Section editing is not supported in this page.',
'permissionserrors'                => 'Permissions errors',
'permissionserrorstext'            => 'You do not have permission to do that, for the following {{PLURAL:$1|reason|reasons}}:',
'permissionserrorstext-withaction' => 'You do not have permission to $2, for the following {{PLURAL:$1|reason|reasons}}:',
'recreate-moveddeleted-warn'       => "'''Warning: You are recreating a page that was previously deleted.'''

You should consider whether it is appropriate to continue editing this page.
The deletion and move log for this page are provided here for convenience:",
'moveddeleted-notice'              => 'This page has been deleted.
The deletion and move log for the page are provided below for reference.',
'log-fulllog'                      => 'View full log',
'edit-hook-aborted'                => 'Edit aborted by hook.
It gave no explanation.',
'edit-gone-missing'                => 'Could not update the page.
It appears to have been deleted.',
'edit-conflict'                    => 'Edit conflict.',
'edit-no-change'                   => 'Your edit was ignored because no change was made to the text.',
'edit-already-exists'              => 'Could not create a new page.
It already exists.',
'addsection-preload'               => '', # do not translate or duplicate this message to other languages
'addsection-editintro'             => '', # do not translate or duplicate this message to other languages
'defaultmessagetext'               => 'Default message text',

# Parser/template warnings
'expensive-parserfunction-warning'        => "'''Warning:''' This page contains too many expensive parser function calls.

It should have less than $2 {{PLURAL:$2|call|calls}}, there {{PLURAL:$1|is now $1 call|are now $1 calls}}.",
'expensive-parserfunction-category'       => 'Pages with too many expensive parser function calls',
'post-expand-template-inclusion-warning'  => "'''Warning:''' Template include size is too large.
Some templates will not be included.",
'post-expand-template-inclusion-category' => 'Pages where template include size is exceeded',
'post-expand-template-argument-warning'   => "'''Warning:''' This page contains at least one template argument that has a too large expansion size.
These arguments have been omitted.",
'post-expand-template-argument-category'  => 'Pages containing omitted template arguments',
'parser-template-loop-warning'            => 'Template loop detected: [[$1]]',
'parser-template-recursion-depth-warning' => 'Template recursion depth limit exceeded ($1)',
'language-converter-depth-warning'        => 'Language converter depth limit exceeded ($1)',
'node-count-exceeded-category'            => 'Pages where node-count is exceeded',
'node-count-exceeded-warning'             => 'Page exceeded the node-count',
'expansion-depth-exceeded-category'       => 'Pages where expansion depth is exceeded',
'expansion-depth-exceeded-warning'        => 'Page exceeded the expansion depth',
'parser-unstrip-loop-warning'             => 'Unstrip loop detected',
'parser-unstrip-recursion-limit'          => 'Unstrip recursion limit exceeded ($1)',
'converter-manual-rule-error'             => 'Error detected in manual language conversion rule',

# "Undo" feature
'undo-success' => 'The edit can be undone.
Please check the comparison below to verify that this is what you want to do, and then save the changes below to finish undoing the edit.',
'undo-failure' => 'The edit could not be undone due to conflicting intermediate edits.',
'undo-norev'   => 'The edit could not be undone because it does not exist or was deleted.',
'undo-summary' => 'Undo revision $1 by [[Special:Contributions/$2|$2]] ([[User talk:$2|talk]])',

# Account creation failure
'cantcreateaccounttitle' => 'Cannot create account',
'cantcreateaccount-text' => "Account creation from this IP address ('''$1''') has been blocked by [[User:$3|$3]].

The reason given by $3 is ''$2''",

# History pages
'viewpagelogs'           => 'View logs for this page',
'nohistory'              => 'There is no edit history for this page.',
'currentrev'             => 'Latest revision',
'currentrev-asof'        => 'Latest revision as of $1',
'revisionasof'           => 'Revision as of $1',
'revision-info'          => 'Revision as of $1 by $2',
'revision-info-current'  => '-', # do not translate or duplicate this message to other languages
'revision-nav'           => '($1) $2{{int:pipe-separator}}$3 ($4){{int:pipe-separator}}$5 ($6)', # do not translate or duplicate this message to other languages
'previousrevision'       => '← Older revision',
'nextrevision'           => 'Newer revision →',
'currentrevisionlink'    => 'Latest revision',
'cur'                    => 'cur',
'next'                   => 'next',
'last'                   => 'prev',
'page_first'             => 'first',
'page_last'              => 'last',
'histlegend'             => "Diff selection: Mark the radio boxes of the revisions to compare and hit enter or the button at the bottom.<br />
Legend: '''({{int:cur}})''' = difference with latest revision, '''({{int:last}})''' = difference with preceding revision, '''{{int:minoreditletter}}''' = minor edit.",
'history-fieldset-title' => 'Browse history',
'history-show-deleted'   => 'Deleted only',
'history_copyright'      => '-', # do not translate or duplicate this message to other languages
'histfirst'              => 'Earliest',
'histlast'               => 'Latest',
'historysize'            => '({{PLURAL:$1|1 byte|$1 bytes}})',
'historyempty'           => '(empty)',

# Revision feed
'history-feed-title'          => 'Revision history',
'history-feed-description'    => 'Revision history for this page on the wiki',
'history-feed-item-nocomment' => '$1 at $2',
'history-feed-empty'          => 'The requested page does not exist.
It may have been deleted from the wiki, or renamed.
Try [[Special:Search|searching on the wiki]] for relevant new pages.',

# Revision deletion
'rev-deleted-comment'         => '(edit summary removed)',
'rev-deleted-user'            => '(username removed)',
'rev-deleted-event'           => '(log action removed)',
'rev-deleted-user-contribs'   => '[username or IP address removed - edit hidden from contributions]',
'rev-deleted-text-permission' => "This page revision has been '''deleted'''.
Details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].",
'rev-deleted-text-unhide'     => "This page revision has been '''deleted'''.
Details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].
You can still [$1 view this revision] if you wish to proceed.",
'rev-suppressed-text-unhide'  => "This page revision has been '''suppressed'''.
Details can be found in the [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} suppression log].
You can still [$1 view this revision] if you wish to proceed.",
'rev-deleted-text-view'       => "This page revision has been '''deleted'''.
You can view it; details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].",
'rev-suppressed-text-view'    => "This page revision has been '''suppressed'''.
You can view it; details can be found in the [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} suppression log].",
'rev-deleted-no-diff'         => "You cannot view this diff because one of the revisions has been '''deleted'''.
Details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].",
'rev-suppressed-no-diff'      => "You cannot view this diff because one of the revisions has been '''deleted'''.",
'rev-deleted-unhide-diff'     => "One of the revisions of this diff has been '''deleted'''.
Details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].
You can still [$1 view this diff] if you wish to proceed.",
'rev-suppressed-unhide-diff'  => "One of the revisions of this diff has been '''suppressed'''.
Details can be found in the [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} suppression log].
You can still [$1 view this diff] if you wish to proceed.",
'rev-deleted-diff-view'       => "One of the revisions of this diff has been '''deleted'''.
You can view this diff; details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].",
'rev-suppressed-diff-view'    => "One of the revisions of this diff has been '''suppressed'''.
You can view this diff; details can be found in the [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} suppression log].",
'rev-delundel'                => 'show/hide',
'rev-showdeleted'             => 'show',
'revisiondelete'              => 'Delete/undelete revisions',
'revdelete-nooldid-title'     => 'Invalid target revision',
'revdelete-nooldid-text'      => 'You have either not specified a target revision(s) to perform this
function, the specified revision does not exist, or you are attempting to hide the current revision.',
'revdelete-nologtype-title'   => 'No log type given',
'revdelete-nologtype-text'    => 'You have not specified a log type to perform this action on.',
'revdelete-nologid-title'     => 'Invalid log entry',
'revdelete-nologid-text'      => 'You have either not specified a target log event to perform this function or the specified entry does not exist.',
'revdelete-no-file'           => 'The file specified does not exist.',
'revdelete-show-file-confirm' => 'Are you sure you want to view a deleted revision of the file "<nowiki>$1</nowiki>" from $2 at $3?',
'revdelete-show-file-submit'  => 'Yes',
'revdelete-selected'          => "'''{{PLURAL:$2|Selected revision|Selected revisions}} of [[:$1]]:'''",
'logdelete-selected'          => "'''{{PLURAL:$1|Selected log event|Selected log events}}:'''",
'revdelete-text'              => "'''Deleted revisions and events will still appear in the page history and logs, but parts of their content will be inaccessible to the public.'''
Other administrators on {{SITENAME}} will still be able to access the hidden content and can undelete it again through this same interface, unless additional restrictions are set.",
'revdelete-confirm'           => 'Please confirm that you intend to do this, that you understand the consequences, and that you are doing this in accordance with [[{{MediaWiki:Policy-url}}|the policy]].',
'revdelete-suppress-text'     => "Suppression should '''only''' be used for the following cases:
* Potentially libelous information
* Inappropriate personal information
*: ''home addresses and telephone numbers, social security numbers, etc.''",
'revdelete-legend'            => 'Set visibility restrictions',
'revdelete-hide-text'         => 'Hide revision text',
'revdelete-hide-image'        => 'Hide file content',
'revdelete-hide-name'         => 'Hide action and target',
'revdelete-hide-comment'      => 'Hide edit summary',
'revdelete-hide-user'         => "Hide editor's username/IP address",
'revdelete-hide-restricted'   => 'Suppress data from administrators as well as others',
'revdelete-radio-same'        => '(do not change)',
'revdelete-radio-set'         => 'Yes',
'revdelete-radio-unset'       => 'No',
'revdelete-suppress'          => 'Suppress data from administrators as well as others',
'revdelete-unsuppress'        => 'Remove restrictions on restored revisions',
'revdelete-log'               => 'Reason:',
'revdelete-submit'            => 'Apply to selected {{PLURAL:$1|revision|revisions}}',
'revdelete-success'           => "'''Revision visibility successfully updated.'''",
'revdelete-failure'           => "'''Revision visibility could not be updated:'''
$1",
'logdelete-success'           => "'''Log visibility successfully set.'''",
'logdelete-failure'           => "'''Log visibility could not be set:'''
$1",
'revdel-restore'              => 'change visibility',
'revdel-restore-deleted'      => 'deleted revisions',
'revdel-restore-visible'      => 'visible revisions',
'pagehist'                    => 'Page history',
'deletedhist'                 => 'Deleted history',
'revdelete-hide-current'      => 'Error hiding the item dated $2, $1: This is the current revision.
It cannot be hidden.',
'revdelete-show-no-access'    => 'Error showing the item dated $2, $1: This item has been marked "restricted".
You do not have access to it.',
'revdelete-modify-no-access'  => 'Error modifying the item dated $2, $1: This item has been marked "restricted".
You do not have access to it.',
'revdelete-modify-missing'    => 'Error modifying item ID $1: It is missing from the database!',
'revdelete-no-change'         => "'''Warning:''' The item dated $2, $1 already had the requested visibility settings.",
'revdelete-concurrent-change' => 'Error modifying the item dated $2, $1: Its status appears to have been changed by someone else while you attempted to modify it.
Please check the logs.',
'revdelete-only-restricted'   => 'Error hiding the item dated $2, $1: You cannot suppress items from view by administrators without also selecting one of the other visibility options.',
'revdelete-reason-dropdown'   => '*Common delete reasons
** Copyright violation
** Inappropriate comment or personal information
** Inappropriate username
** Potentially libelous information',
'revdelete-otherreason'       => 'Other/additional reason:',
'revdelete-reasonotherlist'   => 'Other reason',
'revdelete-edit-reasonlist'   => 'Edit delete reasons',
'revdelete-offender'          => 'Revision author:',

# Suppression log
'suppressionlog'     => 'Suppression log',
'suppressionlogtext' => 'Below is a list of deletions and blocks involving content hidden from administrators.
See the [[Special:BlockList|block list]] for the list of currently operational bans and blocks.',

# History merging
'mergehistory'                     => 'Merge page histories',
'mergehistory-header'              => 'This page lets you merge revisions of the history of one source page into a newer page.
Make sure that this change will maintain historical page continuity.',
'mergehistory-box'                 => 'Merge revisions of two pages:',
'mergehistory-from'                => 'Source page:',
'mergehistory-into'                => 'Destination page:',
'mergehistory-list'                => 'Mergeable edit history',
'mergehistory-merge'               => 'The following revisions of [[:$1]] can be merged into [[:$2]].
Use the radio button column to merge in only the revisions created at and before the specified time.
Note that using the navigation links will reset this column.',
'mergehistory-go'                  => 'Show mergeable edits',
'mergehistory-submit'              => 'Merge revisions',
'mergehistory-empty'               => 'No revisions can be merged.',
'mergehistory-success'             => '$3 {{PLURAL:$3|revision|revisions}} of [[:$1]] successfully merged into [[:$2]].',
'mergehistory-fail'                => 'Unable to perform history merge, please recheck the page and time parameters.',
'mergehistory-no-source'           => 'Source page $1 does not exist.',
'mergehistory-no-destination'      => 'Destination page $1 does not exist.',
'mergehistory-invalid-source'      => 'Source page must be a valid title.',
'mergehistory-invalid-destination' => 'Destination page must be a valid title.',
'mergehistory-autocomment'         => 'Merged [[:$1]] into [[:$2]]',
'mergehistory-comment'             => 'Merged [[:$1]] into [[:$2]]: $3',
'mergehistory-same-destination'    => 'Source and destination pages cannot be the same',
'mergehistory-reason'              => 'Reason:',
'mergehistory-revisionrow'         => '$1 ($2) $3 . . $4 $5 $6', # only translate this message to other languages if you have to change it

# Merge log
'mergelog'           => 'Merge log',
'pagemerge-logentry' => 'merged [[$1]] into [[$2]] (revisions up to $3)',
'revertmerge'        => 'Unmerge',
'mergelogpagetext'   => 'Below is a list of the most recent merges of one page history into another.',

# Diffs
'history-title'               => 'Revision history of "$1"',
'difference-title'            => 'Difference between revisions of "$1"',
'difference-title-multipage'  => 'Difference between pages "$1" and "$2"',
'difference-multipage'        => '(Difference between pages)',
'lineno'                      => 'Line $1:',
'compareselectedversions'     => 'Compare selected revisions',
'showhideselectedversions'    => 'Show/hide selected revisions',
'editundo'                    => 'undo',
'diff-multi'                  => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} by {{PLURAL:$2|one user|$2 users}} not shown)',
'diff-multi-manyusers'        => '({{PLURAL:$1|One intermediate revision|$1 intermediate revisions}} by more than $2 {{PLURAL:$2|user|users}} not shown)',
'difference-missing-revision' => '{{PLURAL:$2|One revision|$2 revisions}} of this difference ($1) {{PLURAL:$2|was|were}} not found.

This is usually caused by following an outdated diff link to a page that has been deleted.
Details can be found in the [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} deletion log].',

# Search results
'search-summary'                   => '', # do not translate or duplicate this message to other languages
'searchresults'                    => 'Search results',
'searchresults-title'              => 'Search results for "$1"',
'searchresulttext'                 => 'For more information about searching {{SITENAME}}, see [[{{MediaWiki:Helppage}}|{{int:help}}]].',
'searchsubtitle'                   => 'You searched for \'\'\'[[:$1]]\'\'\' ([[Special:Prefixindex/$1|all pages starting with "$1"]]{{int:pipe-separator}}[[Special:WhatLinksHere/$1|all pages that link to "$1"]])',
'searchsubtitleinvalid'            => "You searched for '''$1'''",
'toomanymatches'                   => 'Too many matches were returned, please try a different query',
'titlematches'                     => 'Page title matches',
'notitlematches'                   => 'No page title matches',
'textmatches'                      => 'Page text matches',
'notextmatches'                    => 'No page text matches',
'prevn'                            => 'previous {{PLURAL:$1|$1}}',
'nextn'                            => 'next {{PLURAL:$1|$1}}',
'prevn-title'                      => 'Previous $1 {{PLURAL:$1|result|results}}',
'nextn-title'                      => 'Next $1 {{PLURAL:$1|result|results}}',
'shown-title'                      => 'Show $1 {{PLURAL:$1|result|results}} per page',
'viewprevnext'                     => 'View ($1 {{int:pipe-separator}} $2) ($3)',
'searchmenu-legend'                => 'Search options',
'searchmenu-exists'                => "'''There is a page named \"[[:\$1]]\" on this wiki.'''",
'searchmenu-new'                   => "'''Create the page \"[[:\$1]]\" on this wiki!'''",
'searchmenu-new-nocreate'          => '', # do not translate or duplicate this message to other languages
'searchhelp-url'                   => 'Help:Contents',
'searchmenu-prefix'                => '[[Special:PrefixIndex/$1|Browse pages with this prefix]]',
'searchmenu-help'                  => '[[{{MediaWiki:Searchhelp-url}}|{{int:help}}]]?', # do not translate or duplicate this message to other languages
'searchprofile-articles'           => 'Content pages',
'searchprofile-project'            => 'Help and Project pages',
'searchprofile-images'             => 'Multimedia',
'searchprofile-everything'         => 'Everything',
'searchprofile-advanced'           => 'Advanced',
'searchprofile-articles-tooltip'   => 'Search in $1',
'searchprofile-project-tooltip'    => 'Search in $1',
'searchprofile-images-tooltip'     => 'Search for files',
'searchprofile-everything-tooltip' => 'Search all of content (including talk pages)',
'searchprofile-advanced-tooltip'   => 'Search in custom namespaces',
'search-result-size'               => '$1 ({{PLURAL:$2|1 word|$2 words}})',
'search-result-category-size'      => '{{PLURAL:$1|1 member|$1 members}} ({{PLURAL:$2|1 subcategory|$2 subcategories}}, {{PLURAL:$3|1 file|$3 files}})',
'search-result-score'              => 'Relevance: $1%',
'search-redirect'                  => '(redirect $1)',
'search-section'                   => '(section $1)',
'search-suggest'                   => 'Did you mean: $1',
'search-interwiki-caption'         => 'Sister projects',
'search-interwiki-default'         => '$1 results:',
'search-interwiki-custom'          => '', # do not translate or duplicate this message to other languages
'search-interwiki-more'            => '(more)',
'search-relatedarticle'            => 'Related',
'mwsuggest-disable'                => 'Disable AJAX suggestions',
'searcheverything-enable'          => 'Search in all namespaces',
'searchrelated'                    => 'related',
'searchall'                        => 'all',
'showingresults'                   => "Showing below up to {{PLURAL:$1|'''1''' result|'''$1''' results}} starting with #'''$2'''.",
'showingresultsnum'                => "Showing below {{PLURAL:$3|'''1''' result|'''$3''' results}} starting with #'''$2'''.",
'showingresultsheader'             => "{{PLURAL:$5|Result '''$1''' of '''$3'''|Results '''$1 - $2''' of '''$3'''}} for '''$4'''",
'nonefound'                        => "'''Note''': Only some namespaces are searched by default.
Try prefixing your query with ''all:'' to search all content (including talk pages, templates, etc), or use the desired namespace as prefix.",
'search-nonefound'                 => 'There were no results matching the query.',
'powersearch'                      => 'Advanced search',
'powersearch-legend'               => 'Advanced search',
'powersearch-ns'                   => 'Search in namespaces:',
'powersearch-redir'                => 'List redirects',
'powersearch-field'                => 'Search for',
'powersearch-togglelabel'          => 'Check:',
'powersearch-toggleall'            => 'All',
'powersearch-togglenone'           => 'None',
'search-external'                  => 'External search',
'searchdisabled'                   => '{{SITENAME}} search is disabled.
You can search via Google in the meantime.
Note that their indexes of {{SITENAME}} content may be out of date.',
'googlesearch'                     => '<form method="get" action="//www.google.com/search" id="googlesearch">
	<input type="hidden" name="domains" value="{{SERVER}}" />
	<input type="hidden" name="num" value="50" />
	<input type="hidden" name="ie" value="$2" />
	<input type="hidden" name="oe" value="$2" />

	<input type="text" name="q" size="31" maxlength="255" value="$1" />
	<input type="submit" name="btnG" value="$3" />
  <div>
	<input type="radio" name="sitesearch" id="gwiki" value="{{SERVER}}" checked="checked" /><label for="gwiki">{{SITENAME}}</label>
	<input type="radio" name="sitesearch" id="gWWW" value="" /><label for="gWWW">WWW</label>
  </div>
</form>', # do not translate or duplicate this message to other languages

# OpenSearch description
'opensearch-desc' => '{{SITENAME}} ({{CONTENTLANGUAGE}})', # do not translate or duplicate this message to other languages

# Quickbar
'qbsettings'                => 'Quickbar',
'qbsettings-none'           => 'None',
'qbsettings-fixedleft'      => 'Fixed left',
'qbsettings-fixedright'     => 'Fixed right',
'qbsettings-floatingleft'   => 'Floating left',
'qbsettings-floatingright'  => 'Floating right',
'qbsettings-directionality' => 'Fixed, depending on the script directionality of your language',

# Preferences page
'preferences'                   => 'Preferences',
'preferences-summary'           => '', # do not translate or duplicate this message to other languages
'mypreferences'                 => 'Preferences',
'prefs-edits'                   => 'Number of edits:',
'prefsnologin'                  => 'Not logged in',
'prefsnologintext'              => 'You must be <span class="plainlinks">[{{fullurl:{{#Special:UserLogin}}|returnto=$1}} logged in]</span> to set user preferences.',
'changepassword'                => 'Change password',
'changepassword-summary'        => '', # do not translate or duplicate this message to other languages
'prefs-skin'                    => 'Skin',
'skin-preview'                  => 'Preview',
'datedefault'                   => 'No preference',
'prefs-beta'                    => 'Beta features',
'prefs-datetime'                => 'Date and time',
'prefs-labs'                    => 'Labs features',
'prefs-user-pages'              => 'User pages',
'prefs-personal'                => 'User profile',
'prefs-rc'                      => 'Recent changes',
'prefs-watchlist'               => 'Watchlist',
'prefs-watchlist-days'          => 'Days to show in watchlist:',
'prefs-watchlist-days-max'      => 'Maximum $1 {{PLURAL:$1|day|days}}',
'prefs-watchlist-edits'         => 'Maximum number of changes to show in expanded watchlist:',
'prefs-watchlist-edits-max'     => 'Maximum number: 1000',
'prefs-watchlist-token'         => 'Watchlist token:',
'prefs-misc'                    => 'Misc',
'prefs-resetpass'               => 'Change password',
'prefs-changeemail'             => 'Change e-mail address',
'prefs-setemail'                => 'Set an e-mail address',
'prefs-email'                   => 'E-mail options',
'prefs-rendering'               => 'Appearance',
'saveprefs'                     => 'Save',
'resetprefs'                    => 'Clear unsaved changes',
'restoreprefs'                  => 'Restore all default settings',
'prefs-editing'                 => 'Editing',
'prefs-edit-boxsize'            => 'Size of the edit window.',
'rows'                          => 'Rows:',
'columns'                       => 'Columns:',
'searchresultshead'             => 'Search',
'resultsperpage'                => 'Hits per page:',
'stub-threshold'                => 'Threshold for <a href="#" class="stub">stub link</a> formatting (bytes):',
'stub-threshold-disabled'       => 'Disabled',
'recentchangesdays'             => 'Days to show in recent changes:',
'recentchangesdays-max'         => 'Maximum $1 {{PLURAL:$1|day|days}}',
'recentchangescount'            => 'Number of edits to show by default:',
'prefs-help-recentchangescount' => 'This includes recent changes, page histories, and logs.',
'prefs-help-watchlist-token'    => "Filling in this field with a secret key will generate an RSS feed for your watchlist.
Anyone who knows the key in this field will be able to read your watchlist, so choose a secure value.
Here's a randomly-generated value you can use: $1",
'savedprefs'                    => 'Your preferences have been saved.',
'timezonelegend'                => 'Time zone:',
'localtime'                     => 'Local time:',
'timezoneuseserverdefault'      => 'Use wiki default ($1)',
'timezoneuseoffset'             => 'Other (specify offset)',
'timezoneoffset'                => 'Offset¹:',
'servertime'                    => 'Server time:',
'guesstimezone'                 => 'Fill in from browser',
'timezoneregion-africa'         => 'Africa',
'timezoneregion-america'        => 'America',
'timezoneregion-antarctica'     => 'Antarctica',
'timezoneregion-arctic'         => 'Arctic',
'timezoneregion-asia'           => 'Asia',
'timezoneregion-atlantic'       => 'Atlantic Ocean',
'timezoneregion-australia'      => 'Australia',
'timezoneregion-europe'         => 'Europe',
'timezoneregion-indian'         => 'Indian Ocean',
'timezoneregion-pacific'        => 'Pacific Ocean',
'allowemail'                    => 'Enable e-mail from other users',
'prefs-searchoptions'           => 'Search',
'prefs-namespaces'              => 'Namespaces',
'defaultns'                     => 'Otherwise search in these namespaces:',
'default'                       => 'default',
'prefs-files'                   => 'Files',
'prefs-custom-css'              => 'Custom CSS',
'prefs-custom-js'               => 'Custom JavaScript',
'prefs-common-css-js'           => 'Shared CSS/JavaScript for all skins:',
'prefs-reset-intro'             => 'You can use this page to reset your preferences to the site defaults.
This cannot be undone.',
'prefs-emailconfirm-label'      => 'E-mail confirmation:',
'prefs-textboxsize'             => 'Size of editing window',
'youremail'                     => 'E-mail:',
'username'                      => 'Username:',
'uid'                           => 'User ID:',
'prefs-memberingroups'          => 'Member of {{PLURAL:$1|group|groups}}:',
'prefs-memberingroups-type'     => '$1', # only translate this message to other languages if you have to change it
'prefs-registration'            => 'Registration time:',
'prefs-registration-date-time'  => '$1', # only translate this message to other languages if you have to change it
'yourrealname'                  => 'Real name:',
'yourlanguage'                  => 'Language:',
'yourvariant'                   => 'Content language variant:',
'prefs-help-variant'            => 'Your preferred variant or orthography to display the content pages of this wiki in.',
'yournick'                      => 'New signature:',
'prefs-help-signature'          => 'Comments on talk pages should be signed with "<nowiki>~~~~</nowiki>", which will be converted into your signature and a timestamp.',
'badsig'                        => 'Invalid raw signature.
Check HTML tags.',
'badsiglength'                  => 'Your signature is too long.
It must not be more than $1 {{PLURAL:$1|character|characters}} long.',
'yourgender'                    => 'Gender:',
'gender-unknown'                => 'Undisclosed',
'gender-male'                   => 'Male',
'gender-female'                 => 'Female',
'prefs-help-gender'             => 'Optional: Used for gender-correct addressing by the software.
This information will be public.',
'email'                         => 'E-mail',
'prefs-help-realname'           => 'Real name is optional.
If you choose to provide it, this will be used for giving you attribution for your work.',
'prefs-help-email'              => 'E-mail address is optional, but is needed for password resets, should you forget your password.',
'prefs-help-email-others'       => 'You can also choose to let others contact you by e-mail through a link on your user or talk page.
Your e-mail address is not revealed when other users contact you.',
'prefs-help-email-required'     => 'E-mail address is required.',
'prefs-info'                    => 'Basic information',
'prefs-i18n'                    => 'Internationalisation',
'prefs-signature'               => 'Signature',
'prefs-dateformat'              => 'Date format',
'prefs-timeoffset'              => 'Time offset',
'prefs-advancedediting'         => 'Advanced options',
'prefs-advancedrc'              => 'Advanced options',
'prefs-advancedrendering'       => 'Advanced options',
'prefs-advancedsearchoptions'   => 'Advanced options',
'prefs-advancedwatchlist'       => 'Advanced options',
'prefs-displayrc'               => 'Display options',
'prefs-displaysearchoptions'    => 'Display options',
'prefs-displaywatchlist'        => 'Display options',
'prefs-diffs'                   => 'Diffs',

# User preference: e-mail validation using jQuery
'email-address-validity-valid'   => 'E-mail address appears valid',
'email-address-validity-invalid' => 'Enter a valid e-mail address',

# User rights
'userrights'                     => 'User rights management',
'userrights-summary'             => '', # do not translate or duplicate this message to other languages
'userrights-lookup-user'         => 'Manage user groups',
'userrights-user-editname'       => 'Enter a username:',
'editusergroup'                  => 'Edit user groups',
'editinguser'                    => "Changing user rights of user '''[[User:$1|$1]]''' $2",
'userrights-editusergroup'       => 'Edit user groups',
'saveusergroups'                 => 'Save user groups',
'userrights-groupsmember'        => 'Member of:',
'userrights-groupsmember-auto'   => 'Implicit member of:',
'userrights-groups-help'         => 'You may alter the groups this user is in:
* A checked box means the user is in that group.
* An unchecked box means the user is not in that group.
* A * indicates that you cannot remove the group once you have added it, or vice versa.',
'userrights-reason'              => 'Reason:',
'userrights-no-interwiki'        => 'You do not have permission to edit user rights on other wikis.',
'userrights-nodatabase'          => 'Database $1 does not exist or is not local.',
'userrights-nologin'             => 'You must [[Special:UserLogin|log in]] with an administrator account to assign user rights.',
'userrights-notallowed'          => 'Your account does not have permission to add or remove user rights.',
'userrights-changeable-col'      => 'Groups you can change',
'userrights-unchangeable-col'    => 'Groups you cannot change',
'userrights-irreversible-marker' => '$1*', # only translate this message to other languages if you have to change it

# Groups
'group'               => 'Group:',
'group-user'          => 'Users',
'group-autoconfirmed' => 'Autoconfirmed users',
'group-bot'           => 'Bots',
'group-sysop'         => 'Administrators',
'group-bureaucrat'    => 'Bureaucrats',
'group-suppress'      => 'Oversights',
'group-all'           => '(all)',

'group-user-member'          => '{{GENDER:$1|user}}',
'group-autoconfirmed-member' => '{{GENDER:$1|autoconfirmed user}}',
'group-bot-member'           => '{{GENDER:$1|bot}}',
'group-sysop-member'         => '{{GENDER:$1|administrator}}',
'group-bureaucrat-member'    => '{{GENDER:$1|bureaucrat}}',
'group-suppress-member'      => '{{GENDER:$1|oversight}}',

'grouppage-user'          => '{{ns:project}}:Users',
'grouppage-autoconfirmed' => '{{ns:project}}:Autoconfirmed users',
'grouppage-bot'           => '{{ns:project}}:Bots',
'grouppage-sysop'         => '{{ns:project}}:Administrators',
'grouppage-bureaucrat'    => '{{ns:project}}:Bureaucrats',
'grouppage-suppress'      => '{{ns:project}}:Oversight',

# Rights
'right-read'                  => 'Read pages',
'right-edit'                  => 'Edit pages',
'right-createpage'            => 'Create pages (which are not discussion pages)',
'right-createtalk'            => 'Create discussion pages',
'right-createaccount'         => 'Create new user accounts',
'right-minoredit'             => 'Mark edits as minor',
'right-move'                  => 'Move pages',
'right-move-subpages'         => 'Move pages with their subpages',
'right-move-rootuserpages'    => 'Move root user pages',
'right-movefile'              => 'Move files',
'right-suppressredirect'      => 'Not create redirects from source pages when moving pages',
'right-upload'                => 'Upload files',
'right-reupload'              => 'Overwrite existing files',
'right-reupload-own'          => 'Overwrite existing files uploaded by oneself',
'right-reupload-shared'       => 'Override files on the shared media repository locally',
'right-upload_by_url'         => 'Upload files from a URL',
'right-purge'                 => 'Purge the site cache for a page without confirmation',
'right-autoconfirmed'         => 'Edit semi-protected pages',
'right-bot'                   => 'Be treated as an automated process',
'right-nominornewtalk'        => 'Not have minor edits to discussion pages trigger the new messages prompt',
'right-apihighlimits'         => 'Use higher limits in API queries',
'right-writeapi'              => 'Use of the write API',
'right-delete'                => 'Delete pages',
'right-bigdelete'             => 'Delete pages with large histories',
'right-deletelogentry'        => 'Delete and undelete specific log entries',
'right-deleterevision'        => 'Delete and undelete specific revisions of pages',
'right-deletedhistory'        => 'View deleted history entries, without their associated text',
'right-deletedtext'           => 'View deleted text and changes between deleted revisions',
'right-browsearchive'         => 'Search deleted pages',
'right-undelete'              => 'Undelete a page',
'right-suppressrevision'      => 'Review and restore revisions hidden from administrators',
'right-suppressionlog'        => 'View private logs',
'right-block'                 => 'Block other users from editing',
'right-blockemail'            => 'Block a user from sending e-mail',
'right-hideuser'              => 'Block a username, hiding it from the public',
'right-ipblock-exempt'        => 'Bypass IP blocks, auto-blocks and range blocks',
'right-proxyunbannable'       => 'Bypass automatic blocks of proxies',
'right-unblockself'           => 'Unblock themselves',
'right-protect'               => 'Change protection levels and edit protected pages',
'right-editprotected'         => 'Edit protected pages (without cascading protection)',
'right-editinterface'         => 'Edit the user interface',
'right-editusercssjs'         => "Edit other users' CSS and JavaScript files",
'right-editusercss'           => "Edit other users' CSS files",
'right-edituserjs'            => "Edit other users' JavaScript files",
'right-rollback'              => 'Quickly rollback the edits of the last user who edited a particular page',
'right-markbotedits'          => 'Mark rolled-back edits as bot edits',
'right-noratelimit'           => 'Not be affected by rate limits',
'right-import'                => 'Import pages from other wikis',
'right-importupload'          => 'Import pages from a file upload',
'right-patrol'                => "Mark others' edits as patrolled",
'right-autopatrol'            => "Have one's own edits automatically marked as patrolled",
'right-patrolmarks'           => 'View recent changes patrol marks',
'right-unwatchedpages'        => 'View a list of unwatched pages',
'right-mergehistory'          => 'Merge the history of pages',
'right-userrights'            => 'Edit all user rights',
'right-userrights-interwiki'  => 'Edit user rights of users on other wikis',
'right-siteadmin'             => 'Lock and unlock the database',
'right-override-export-depth' => 'Export pages including linked pages up to a depth of 5',
'right-sendemail'             => 'Send e-mail to other users',
'right-passwordreset'         => 'View password reset e-mails',

# User rights log
'rightslog'                  => 'User rights log',
'rightslogtext'              => 'This is a log of changes to user rights.',
'rightslogentry'             => 'changed group membership for $1 from $2 to $3',
'rightslogentry-autopromote' => 'was automatically promoted from $2 to $3',
'rightsnone'                 => '(none)',

# Associated actions - in the sentence "You do not have permission to X"
'action-read'                 => 'read this page',
'action-edit'                 => 'edit this page',
'action-createpage'           => 'create pages',
'action-createtalk'           => 'create discussion pages',
'action-createaccount'        => 'create this user account',
'action-minoredit'            => 'mark this edit as minor',
'action-move'                 => 'move this page',
'action-move-subpages'        => 'move this page, and its subpages',
'action-move-rootuserpages'   => 'move root user pages',
'action-movefile'             => 'move this file',
'action-upload'               => 'upload this file',
'action-reupload'             => 'overwrite this existing file',
'action-reupload-shared'      => 'override this file on a shared repository',
'action-upload_by_url'        => 'upload this file from a URL',
'action-writeapi'             => 'use the write API',
'action-delete'               => 'delete this page',
'action-deleterevision'       => 'delete this revision',
'action-deletedhistory'       => "view this page's deleted history",
'action-browsearchive'        => 'search deleted pages',
'action-undelete'             => 'undelete this page',
'action-suppressrevision'     => 'review and restore this hidden revision',
'action-suppressionlog'       => 'view this private log',
'action-block'                => 'block this user from editing',
'action-protect'              => 'change protection levels for this page',
'action-rollback'             => 'quickly rollback the edits of the last user who edited a particular page',
'action-import'               => 'import this page from another wiki',
'action-importupload'         => 'import this page from a file upload',
'action-patrol'               => "mark others' edit as patrolled",
'action-autopatrol'           => 'have your edit marked as patrolled',
'action-unwatchedpages'       => 'view the list of unwatched pages',
'action-mergehistory'         => 'merge the history of this page',
'action-userrights'           => 'edit all user rights',
'action-userrights-interwiki' => 'edit user rights of users on other wikis',
'action-siteadmin'            => 'lock or unlock the database',
'action-sendemail'            => 'send e-mails',

# Recent changes
'nchanges'                          => '$1 {{PLURAL:$1|change|changes}}',
'recentchanges'                     => 'Recent changes',
'recentchanges-url'                 => 'Special:RecentChanges', # do not translate or duplicate this message to other languages
'recentchanges-legend'              => 'Recent changes options',
'recentchanges-summary'             => 'Track the most recent changes to the wiki on this page.',
'recentchangestext'                 => '-', # do not translate or duplicate this message to other languages
'recentchanges-feed-description'    => 'Track the most recent changes to the wiki in this feed.',
'recentchanges-label-newpage'       => 'This edit created a new page',
'recentchanges-label-minor'         => 'This is a minor edit',
'recentchanges-label-bot'           => 'This edit was performed by a bot',
'recentchanges-label-unpatrolled'   => 'This edit has not yet been patrolled',
'rcnote'                            => "Below {{PLURAL:$1|is '''1''' change|are the last '''$1''' changes}} in the last {{PLURAL:$2|day|'''$2''' days}}, as of $5, $4.",
'rcnotefrom'                        => "Below are the changes since '''$2''' (up to '''$1''' shown).",
'rclistfrom'                        => 'Show new changes starting from $1',
'rcshowhideminor'                   => '$1 minor edits',
'rcshowhidebots'                    => '$1 bots',
'rcshowhideliu'                     => '$1 logged-in users',
'rcshowhideanons'                   => '$1 anonymous users',
'rcshowhidepatr'                    => '$1 patrolled edits',
'rcshowhidemine'                    => '$1 my edits',
'rclinks'                           => 'Show last $1 changes in last $2 days<br />$3',
'diff'                              => 'diff',
'hist'                              => 'hist',
'hide'                              => 'Hide',
'show'                              => 'Show',
'minoreditletter'                   => 'm',
'newpageletter'                     => 'N',
'boteditletter'                     => 'b',
'unpatrolledletter'                 => '!', # only translate this message to other languages if you have to change it
'number_of_watching_users_RCview'   => '[$1]', # do not translate or duplicate this message to other languages
'number_of_watching_users_pageview' => '[$1 watching {{PLURAL:$1|user|users}}]',
'rc_categories'                     => 'Limit to categories (separate with "|")',
'rc_categories_any'                 => 'Any',
'rc-change-size'                    => '$1', # only translate this message to other languages if you have to change it
'rc-change-size-new'                => '$1 {{PLURAL:$1|byte|bytes}} after change',
'newsectionsummary'                 => '/* $1 */ new section',
'rc-enhanced-expand'                => 'Show details (requires JavaScript)',
'rc-enhanced-hide'                  => 'Hide details',
'rc-old-title'                      => 'originally created as "$1"',

# Recent changes linked
'recentchangeslinked'          => 'Related changes',
'recentchangeslinked-feed'     => 'Related changes',
'recentchangeslinked-toolbox'  => 'Related changes',
'recentchangeslinked-title'    => 'Changes related to "$1"',
'recentchangeslinked-noresult' => 'No changes on linked pages during the given period.',
'recentchangeslinked-summary'  => "This is a list of changes made recently to pages linked from a specified page (or to members of a specified category).
Pages on [[Special:Watchlist|your watchlist]] are '''bold'''.",
'recentchangeslinked-page'     => 'Page name:',
'recentchangeslinked-to'       => 'Show changes to pages linked to the given page instead',

# Upload
'upload'                      => 'Upload file',
'uploadbtn'                   => 'Upload file',
'reuploaddesc'                => 'Cancel upload and return to the upload form',
'upload-tryagain'             => 'Submit modified file description',
'uploadnologin'               => 'Not logged in',
'uploadnologintext'           => 'You must be [[Special:UserLogin|logged in]] to upload files.',
'upload_directory_missing'    => 'The upload directory ($1) is missing and could not be created by the webserver.',
'upload_directory_read_only'  => 'The upload directory ($1) is not writable by the webserver.',
'uploaderror'                 => 'Upload error',
'upload-summary'              => '', # do not translate or duplicate this message to other languages
'upload-recreate-warning'     => "'''Warning: A file by that name has been deleted or moved.'''

The deletion and move log for this page are provided here for convenience:",
'uploadtext'                  => "Use the form below to upload files.
To view or search previously uploaded files go to the [[Special:FileList|list of uploaded files]], (re)uploads are also logged in the [[Special:Log/upload|upload log]], deletions in the [[Special:Log/delete|deletion log]].

To include a file in a page, use a link in one of the following forms:
* '''<code><nowiki>[[</nowiki>{{ns:file}}<nowiki>:File.jpg]]</nowiki></code>''' to use the full version of the file
* '''<code><nowiki>[[</nowiki>{{ns:file}}<nowiki>:File.png|200px|thumb|left|alt text]]</nowiki></code>''' to use a 200 pixel wide rendition in a box in the left margin with 'alt text' as description
* '''<code><nowiki>[[</nowiki>{{ns:media}}<nowiki>:File.ogg]]</nowiki></code>''' for directly linking to the file without displaying the file",
'upload-permitted'            => 'Permitted file types: $1.',
'upload-preferred'            => 'Preferred file types: $1.',
'upload-prohibited'           => 'Prohibited file types: $1.',
'uploadfooter'                => '-', # do not translate or duplicate this message to other languages
'uploadlog'                   => 'upload log',
'uploadlogpage'               => 'Upload log',
'uploadlogpagetext'           => 'Below is a list of the most recent file uploads.
See the [[Special:NewFiles|gallery of new files]] for a more visual overview.',
'filename'                    => 'Filename',
'filedesc'                    => 'Summary',
'fileuploadsummary'           => 'Summary:',
'filereuploadsummary'         => 'File changes:',
'filestatus'                  => 'Copyright status:',
'filesource'                  => 'Source:',
'uploadedfiles'               => 'Uploaded files',
'ignorewarning'               => 'Ignore warning and save file anyway',
'ignorewarnings'              => 'Ignore any warnings',
'minlength1'                  => 'Filenames must be at least one letter.',
'illegalfilename'             => 'The filename "$1" contains characters that are not allowed in page titles.
Please rename the file and try uploading it again.',
'filename-toolong'            => 'Filenames may not be longer than 240 bytes.',
'badfilename'                 => 'Filename has been changed to "$1".',
'filetype-mime-mismatch'      => 'File extension ".$1" does not match the detected MIME type of the file ($2).',
'filetype-badmime'            => 'Files of the MIME type "$1" are not allowed to be uploaded.',
'filetype-bad-ie-mime'        => 'Cannot upload this file because Internet Explorer would detect it as "$1", which is a disallowed and potentially dangerous file type.',
'filetype-unwanted-type'      => "'''\".\$1\"''' is an unwanted file type.
Preferred {{PLURAL:\$3|file type is|file types are}} \$2.",
'filetype-banned-type'        => '\'\'\'".$1"\'\'\' {{PLURAL:$4|is not a permitted file type|are not permitted file types}}.
Permitted {{PLURAL:$3|file type is|file types are}} $2.',
'filetype-missing'            => 'The file has no extension (like ".jpg").',
'empty-file'                  => 'The file you submitted was empty.',
'file-too-large'              => 'The file you submitted was too large.',
'filename-tooshort'           => 'The filename is too short.',
'filetype-banned'             => 'This type of file is banned.',
'verification-error'          => 'This file did not pass file verification.',
'hookaborted'                 => 'The modification you tried to make was aborted by an extension.',
'illegal-filename'            => 'The filename is not allowed.',
'overwrite'                   => 'Overwriting an existing file is not allowed.',
'unknown-error'               => 'An unknown error occurred.',
'tmp-create-error'            => 'Could not create temporary file.',
'tmp-write-error'             => 'Error writing temporary file.',
'large-file'                  => 'It is recommended that files are no larger than $1;
this file is $2.',
'largefileserver'             => 'This file is bigger than the server is configured to allow.',
'emptyfile'                   => 'The file you uploaded seems to be empty.
This might be due to a typo in the filename.
Please check whether you really want to upload this file.',
'windows-nonascii-filename'   => 'This wiki does not support filenames with special characters.',
'fileexists'                  => 'A file with this name exists already, please check <strong>[[:$1]]</strong> if you are not sure if you want to change it.
[[$1|thumb]]',
'filepageexists'              => 'The description page for this file has already been created at <strong>[[:$1]]</strong>, but no file with this name currently exists.
The summary you enter will not appear on the description page.
To make your summary appear there, you will need to manually edit it.
[[$1|thumb]]',
'fileexists-extension'        => 'A file with a similar name exists: [[$2|thumb]]
* Name of the uploading file: <strong>[[:$1]]</strong>
* Name of the existing file: <strong>[[:$2]]</strong>
Please choose a different name.',
'fileexists-thumbnail-yes'    => "The file seems to be an image of reduced size ''(thumbnail)''.
[[$1|thumb]]
Please check the file <strong>[[:$1]]</strong>.
If the checked file is the same image of original size it is not necessary to upload an extra thumbnail.",
'file-thumbnail-no'           => "The filename begins with <strong>$1</strong>.
It seems to be an image of reduced size ''(thumbnail)''.
If you have this image in full resolution upload this one, otherwise change the filename please.",
'fileexists-forbidden'        => 'A file with this name already exists, and cannot be overwritten.
If you still want to upload your file, please go back and use a new name.
[[File:$1|thumb|center|$1]]',
'fileexists-shared-forbidden' => 'A file with this name exists already in the shared file repository.
If you still want to upload your file, please go back and use a new name.
[[File:$1|thumb|center|$1]]',
'file-exists-duplicate'       => 'This file is a duplicate of the following {{PLURAL:$1|file|files}}:',
'file-deleted-duplicate'      => "A file identical to this file ([[:$1]]) has previously been deleted.
You should check that file's deletion history before proceeding to re-upload it.",
'uploadwarning'               => 'Upload warning',
'uploadwarning-text'          => 'Please modify the file description below and try again.',
'savefile'                    => 'Save file',
'uploadedimage'               => 'uploaded "[[$1]]"',
'overwroteimage'              => 'uploaded a new version of "[[$1]]"',
'uploaddisabled'              => 'Uploads disabled.',
'copyuploaddisabled'          => 'Upload by URL disabled.',
'uploadfromurl-queued'        => 'Your upload has been queued.',
'uploaddisabledtext'          => 'File uploads are disabled.',
'php-uploaddisabledtext'      => 'File uploads are disabled in PHP.
Please check the file_uploads setting.',
'uploadscripted'              => 'This file contains HTML or script code that may be erroneously interpreted by a web browser.',
'uploadvirus'                 => 'The file contains a virus!
Details: $1',
'uploadjava'                  => 'The file is a ZIP file that contains a Java .class file.
Uploading Java files is not allowed because they can cause security restrictions to be bypassed.',
'upload-source'               => 'Source file',
'sourcefilename'              => 'Source filename:',
'sourceurl'                   => 'Source URL:',
'destfilename'                => 'Destination filename:',
'upload-maxfilesize'          => 'Maximum file size: $1',
'upload-description'          => 'File description',
'upload-options'              => 'Upload options',
'watchthisupload'             => 'Watch this file',
'filewasdeleted'              => 'A file of this name has been previously uploaded and subsequently deleted.
You should check the $1 before proceeding to upload it again.',
'filename-bad-prefix'         => "The name of the file you are uploading begins with '''\"\$1\"''', which is a non-descriptive name typically assigned automatically by digital cameras.
Please choose a more descriptive name for your file.",
'filename-prefix-blacklist'   => ' #<!-- leave this line exactly as it is --> <pre>
# Syntax is as follows:
#   * Everything from a "#" character to the end of the line is a comment
#   * Every non-blank line is a prefix for typical filenames assigned automatically by digital cameras
CIMG # Casio
DSC_ # Nikon
DSCF # Fuji
DSCN # Nikon
DUW # some mobile phones
IMG # generic
JD # Jenoptik
MGP # Pentax
PICT # misc.
 #</pre> <!-- leave this line exactly as it is -->', # only translate this message to other languages if you have to change it
'upload-success-subj'         => 'Successful upload',
'upload-success-msg'          => 'Your upload from [$2] was successful. It is available here: [[:{{ns:file}}:$1]]',
'upload-failure-subj'         => 'Upload problem',
'upload-failure-msg'          => 'There was a problem with your upload from [$2]:

$1',
'upload-warning-subj'         => 'Upload warning',
'upload-warning-msg'          => 'There was a problem with your upload from [$2]. You may return to the [[Special:Upload/stash/$1|upload form]] to correct this problem.',

'upload-proto-error'                => 'Incorrect protocol',
'upload-proto-error-text'           => 'Remote upload requires URLs beginning with <code>http://</code> or <code>ftp://</code>.',
'upload-file-error'                 => 'Internal error',
'upload-file-error-text'            => 'An internal error occurred when attempting to create a temporary file on the server.
Please contact an [[Special:ListUsers/sysop|administrator]].',
'upload-misc-error'                 => 'Unknown upload error',
'upload-misc-error-text'            => 'An unknown error occurred during the upload.
Please verify that the URL is valid and accessible and try again.
If the problem persists, contact an [[Special:ListUsers/sysop|administrator]].',
'upload-too-many-redirects'         => 'The URL contained too many redirects',
'upload-unknown-size'               => 'Unknown size',
'upload-http-error'                 => 'An HTTP error occurred: $1',
'upload-copy-upload-invalid-domain' => 'Copy uploads are not available from this domain.',

# File backend
'backend-fail-stream'        => 'Could not stream file "$1".',
'backend-fail-backup'        => 'Could not backup file "$1".',
'backend-fail-notexists'     => 'The file $1 does not exist.',
'backend-fail-hashes'        => 'Could not get file hashes for comparison.',
'backend-fail-notsame'       => 'A non-identical file already exists at "$1".',
'backend-fail-invalidpath'   => '"$1" is not a valid storage path.',
'backend-fail-delete'        => 'Could not delete file "$1".',
'backend-fail-alreadyexists' => 'The file "$1" already exists.',
'backend-fail-store'         => 'Could not store file "$1" at "$2".',
'backend-fail-copy'          => 'Could not copy file "$1" to "$2".',
'backend-fail-move'          => 'Could not move file "$1" to "$2".',
'backend-fail-opentemp'      => 'Could not open temporary file.',
'backend-fail-writetemp'     => 'Could not write to temporary file.',
'backend-fail-closetemp'     => 'Could not close temporary file.',
'backend-fail-read'          => 'Could not read file "$1".',
'backend-fail-create'        => 'Could not write file "$1".',
'backend-fail-maxsize'       => 'Could not write file "$1" because it is larger than {{PLURAL:$2|one byte|$2 bytes}}.',
'backend-fail-readonly'      => 'The storage backend "$1" is currently read-only. The reason given is: "\'\'$2\'\'"',
'backend-fail-synced'        => 'The file "$1" is in an inconsistent state within the internal storage backends',
'backend-fail-connect'       => 'Could not connect to storage backend "$1".',
'backend-fail-internal'      => 'An unknown error occurred in storage backend "$1".',
'backend-fail-contenttype'   => 'Could not determine the content type of the file to store at "$1".',
'backend-fail-batchsize'     => 'The storage backend was given a batch of $1 file {{PLURAL:$1|operation|operations}}; the limit is $2 {{PLURAL:$2|operation|operations}}.',
'backend-fail-usable'        => 'Could not read or write file "$1" due to insufficient permissions or missing directories/containers.',

# File journal errors
'filejournal-fail-dbconnect' => 'Could not connect to the journal database for storage backend "$1".',
'filejournal-fail-dbquery'   => 'Could not update the journal database for storage backend "$1".',

# Lock manager
'lockmanager-notlocked'        => 'Could not unlock "$1"; it is not locked.',
'lockmanager-fail-closelock'   => 'Could not close lock file for "$1".',
'lockmanager-fail-deletelock'  => 'Could not delete lock file for "$1".',
'lockmanager-fail-acquirelock' => 'Could not acquire lock for "$1".',
'lockmanager-fail-openlock'    => 'Could not open lock file for "$1".',
'lockmanager-fail-releaselock' => 'Could not release lock for "$1".',
'lockmanager-fail-db-bucket'   => 'Could not contact enough lock databases in bucket $1.',
'lockmanager-fail-db-release'  => 'Could not release locks on database $1.',
'lockmanager-fail-svr-acquire' => 'Could not acquire locks on server $1.',
'lockmanager-fail-svr-release' => 'Could not release locks on server $1.',

# ZipDirectoryReader
'zip-file-open-error' => 'An error was encountered when opening the file for ZIP checks.',
'zip-wrong-format'    => 'The specified file was not a ZIP file.',
'zip-bad'             => 'The file is a corrupt or otherwise unreadable ZIP file.
It cannot be properly checked for security.',
'zip-unsupported'     => 'The file is a ZIP file that uses ZIP features not supported by MediaWiki.
It cannot be properly checked for security.',

# Special:UploadStash
'uploadstash'          => 'Upload stash',
'uploadstash-summary'  => 'This page provides access to files that are uploaded or in the process of uploading, but are not yet published to the wiki. These files are not visible to anyone but the user who uploaded them.',
'uploadstash-clear'    => 'Clear stashed files',
'uploadstash-nofiles'  => 'You have no stashed files.',
'uploadstash-badtoken' => 'Performing of that action was unsuccessful, perhaps because your editing credentials expired. Try again.',
'uploadstash-errclear' => 'Clearing the files was unsuccessful.',
'uploadstash-refresh'  => 'Refresh the list of files',
'invalid-chunk-offset' => 'Invalid chunk offset',

# img_auth script messages
'img-auth-accessdenied'     => 'Access denied',
'img-auth-nopathinfo'       => 'Missing PATH_INFO.
Your server is not set up to pass this information.
It may be CGI-based and cannot support img_auth.
See https://www.mediawiki.org/wiki/Manual:Image_Authorization.',
'img-auth-notindir'         => 'Requested path is not in the configured upload directory.',
'img-auth-badtitle'         => 'Unable to construct a valid title from "$1".',
'img-auth-nologinnWL'       => 'You are not logged in and "$1" is not in the whitelist.',
'img-auth-nofile'           => 'File "$1" does not exist.',
'img-auth-isdir'            => 'You are trying to access a directory "$1".
Only file access is allowed.',
'img-auth-streaming'        => 'Streaming "$1".',
'img-auth-public'           => 'The function of img_auth.php is to output files from a private wiki.
This wiki is configured as a public wiki.
For optimal security, img_auth.php is disabled.',
'img-auth-noread'           => 'User does not have access to read "$1".',
'img-auth-bad-query-string' => 'The URL has an invalid query string.',

# HTTP errors
'http-invalid-url'      => 'Invalid URL: $1',
'http-invalid-scheme'   => 'URLs with the "$1" scheme are not supported.',
'http-request-error'    => 'HTTP request failed due to unknown error.',
'http-read-error'       => 'HTTP read error.',
'http-timed-out'        => 'HTTP request timed out.',
'http-curl-error'       => 'Error fetching URL: $1',
'http-host-unreachable' => 'Could not reach URL.',
'http-bad-status'       => 'There was a problem during the HTTP request: $1 $2',

# Some likely curl errors. More could be added from <http://curl.haxx.se/libcurl/c/libcurl-errors.html>
'upload-curl-error6'       => 'Could not reach URL',
'upload-curl-error6-text'  => 'The URL provided could not be reached.
Please double-check that the URL is correct and the site is up.',
'upload-curl-error28'      => 'Upload timeout',
'upload-curl-error28-text' => 'The site took too long to respond.
Please check the site is up, wait a short while and try again.
You may want to try at a less busy time.',

'license'            => 'Licensing:',
'license-header'     => 'Licensing',
'nolicense'          => 'None selected',
'licenses'           => '-', # do not translate or duplicate this message to other languages
'license-nopreview'  => '(Preview not available)',
'upload_source_url'  => ' (a valid, publicly accessible URL)',
'upload_source_file' => ' (a file on your computer)',

# Special:ListFiles
'listfiles-summary'     => 'This special page shows all uploaded files.
When filtered by user, only files where that user uploaded the most recent version of the file are shown.',
'listfiles_search_for'  => 'Search for media name:',
'imgfile'               => 'file',
'listfiles'             => 'File list',
'listfiles_thumb'       => 'Thumbnail',
'listfiles_date'        => 'Date',
'listfiles_name'        => 'Name',
'listfiles_user'        => 'User',
'listfiles_size'        => 'Size',
'listfiles_description' => 'Description',
'listfiles_count'       => 'Versions',

# File description page
'file-anchor-link'                  => 'File',
'filehist'                          => 'File history',
'filehist-help'                     => 'Click on a date/time to view the file as it appeared at that time.',
'filehist-deleteall'                => 'delete all',
'filehist-deleteone'                => 'delete',
'filehist-revert'                   => 'revert',
'filehist-current'                  => 'current',
'filehist-datetime'                 => 'Date/Time',
'filehist-thumb'                    => 'Thumbnail',
'filehist-thumbtext'                => 'Thumbnail for version as of $1',
'filehist-nothumb'                  => 'No thumbnail',
'filehist-user'                     => 'User',
'filehist-dimensions'               => 'Dimensions',
'filehist-filesize'                 => 'File size',
'filehist-comment'                  => 'Comment',
'filehist-missing'                  => 'File missing',
'imagelinks'                        => 'File usage',
'linkstoimage'                      => 'The following {{PLURAL:$1|page links|$1 pages link}} to this file:',
'linkstoimage-more'                 => 'More than $1 {{PLURAL:$1|page links|pages link}} to this file.
The following list shows the {{PLURAL:$1|first page link|first $1 page links}} to this file only.
A [[Special:WhatLinksHere/$2|full list]] is available.',
'nolinkstoimage'                    => 'There are no pages that link to this file.',
'morelinkstoimage'                  => 'View [[Special:WhatLinksHere/$1|more links]] to this file.',
'linkstoimage-redirect'             => '$1 (file redirect) $2',
'duplicatesoffile'                  => 'The following {{PLURAL:$1|file is a duplicate|$1 files are duplicates}} of this file ([[Special:FileDuplicateSearch/$2|more details]]):',
'sharedupload'                      => 'This file is from $1 and may be used by other projects.',
'sharedupload-desc-there'           => 'This file is from $1 and may be used by other projects.
Please see the [$2 file description page] for further information.',
'sharedupload-desc-here'            => 'This file is from $1 and may be used by other projects.
The description on its [$2 file description page] there is shown below.',
'sharedupload-desc-edit'            => 'This file is from $1 and may be used by other projects.
Maybe you want to edit the description on its [$2 file description page] there.',
'sharedupload-desc-create'          => 'This file is from $1 and may be used by other projects.
Maybe you want to edit the description on its [$2 file description page] there.',
'shareddescriptionfollows'          => '-', # do not translate or duplicate this message to other languages
'filepage-nofile'                   => 'No file by this name exists.',
'filepage-nofile-link'              => 'No file by this name exists, but you can [$1 upload it].',
'uploadnewversion-linktext'         => 'Upload a new version of this file',
'shared-repo-from'                  => 'from $1',
'shared-repo'                       => 'a shared repository',
'shared-repo-name-wikimediacommons' => 'Wikimedia Commons', # only translate this message to other languages if you have to change it
'filepage.css'                      => '/* CSS placed here is included on the file description page, also included on foreign client wikis */', # only translate this message to other languages if you have to change it
'upload-disallowed-here'            => 'You cannot overwrite this file.',

# File reversion
'filerevert'                => 'Revert $1',
'filerevert-legend'         => 'Revert file',
'filerevert-intro'          => "You are about to revert the file '''[[Media:$1|$1]]''' to the [$4 version as of $3, $2].",
'filerevert-comment'        => 'Reason:',
'filerevert-defaultcomment' => 'Reverted to version as of $2, $1',
'filerevert-submit'         => 'Revert',
'filerevert-success'        => "'''[[Media:$1|$1]]''' has been reverted to the [$4 version as of $3, $2].",
'filerevert-badversion'     => 'There is no previous local version of this file with the provided timestamp.',

# File deletion
'filedelete'                   => 'Delete $1',
'filedelete-legend'            => 'Delete file',
'filedelete-intro'             => "You are about to delete the file '''[[Media:$1|$1]]''' along with all of its history.",
'filedelete-intro-old'         => "You are deleting the version of '''[[Media:$1|$1]]''' as of [$4 $3, $2].",
'filedelete-comment'           => 'Reason:',
'filedelete-submit'            => 'Delete',
'filedelete-success'           => "'''$1''' has been deleted.",
'filedelete-success-old'       => "The version of '''[[Media:$1|$1]]''' as of $3, $2 has been deleted.",
'filedelete-nofile'            => "'''$1''' does not exist.",
'filedelete-nofile-old'        => "There is no archived version of '''$1''' with the specified attributes.",
'filedelete-otherreason'       => 'Other/additional reason:',
'filedelete-reason-otherlist'  => 'Other reason',
'filedelete-reason-dropdown'   => '*Common delete reasons
** Copyright violation
** Duplicated file',
'filedelete-edit-reasonlist'   => 'Edit delete reasons',
'filedelete-maintenance'       => 'Deletion and restoration of files temporarily disabled during maintenance.',
'filedelete-maintenance-title' => 'Cannot delete file',

# MIME search
'mimesearch'         => 'MIME search',
'mimesearch-summary' => 'This page enables the filtering of files for their MIME type.
Input: contenttype/subtype, e.g. <code>image/jpeg</code>.',
'mimetype'           => 'MIME type:',
'download'           => 'download',

# Unwatched pages
'unwatchedpages'         => 'Unwatched pages',
'unwatchedpages-summary' => '', # do not translate or duplicate this message to other languages

# List redirects
'listredirects'         => 'List of redirects',
'listredirects-summary' => '', # do not translate or duplicate this message to other languages

# Unused templates
'unusedtemplates'         => 'Unused templates',
'unusedtemplates-summary' => '', # do not translate or duplicate this message to other languages
'unusedtemplatestext'     => 'This page lists all pages in the {{ns:template}} namespace that are not included in another page.
Remember to check for other links to the templates before deleting them.',
'unusedtemplateswlh'      => 'other links',

# Random page
'randompage'         => 'Random page',
'randompage-nopages' => 'There are no pages in the following {{PLURAL:$2|namespace|namespaces}}: $1.',
'randompage-url'     => 'Special:Random', # do not translate or duplicate this message to other languages

# Random redirect
'randomredirect'         => 'Random redirect',
'randomredirect-nopages' => 'There are no redirects in the namespace "$1".',

# Statistics
'statistics'                   => 'Statistics',
'statistics-summary'           => '', # do not translate or duplicate this message to other languages
'statistics-header-pages'      => 'Page statistics',
'statistics-header-edits'      => 'Edit statistics',
'statistics-header-views'      => 'View statistics',
'statistics-header-users'      => 'User statistics',
'statistics-header-hooks'      => 'Other statistics',
'statistics-articles'          => 'Content pages',
'statistics-pages'             => 'Pages',
'statistics-pages-desc'        => 'All pages in the wiki, including talk pages, redirects, etc.',
'statistics-files'             => 'Uploaded files',
'statistics-edits'             => 'Page edits since {{SITENAME}} was set up',
'statistics-edits-average'     => 'Average edits per page',
'statistics-views-total'       => 'Views total',
'statistics-views-total-desc'  => 'Views to non-existing pages and special pages are not included',
'statistics-views-peredit'     => 'Views per edit',
'statistics-users'             => 'Registered [[Special:ListUsers|users]]',
'statistics-users-active'      => 'Active users',
'statistics-users-active-desc' => 'Users who have performed an action in the last {{PLURAL:$1|day|$1 days}}',
'statistics-mostpopular'       => 'Most viewed pages',
'statistics-footer'            => '', # do not translate or duplicate this message to other languages

'disambiguations'         => 'Pages linking to disambiguation pages',
'disambiguations-summary' => '', # do not translate or duplicate this message to other languages
'disambiguationspage'     => 'Template:disambig',
'disambiguations-text'    => "The following pages contain at least one link to a '''disambiguation page'''.
They may have to link to a more appropriate page instead.<br />
A page is treated as a disambiguation page if it uses a template that is linked from [[MediaWiki:Disambiguationspage]].",

'doubleredirects'                   => 'Double redirects',
'doubleredirects-summary'           => '', # do not translate or duplicate this message to other languages
'doubleredirectstext'               => 'This page lists pages that redirect to other redirect pages.
Each row contains links to the first and second redirect, as well as the target of the second redirect, which is usually the "real" target page to which the first redirect should point.
<del>Crossed out</del> entries have been solved.',
'double-redirect-fixed-move'        => '[[$1]] has been moved.
It now redirects to [[$2]].',
'double-redirect-fixed-maintenance' => 'Fixing double redirect from [[$1]] to [[$2]].',
'double-redirect-fixer'             => 'Redirect fixer',

'brokenredirects'         => 'Broken redirects',
'brokenredirects-summary' => '', # do not translate or duplicate this message to other languages
'brokenredirectstext'     => 'The following redirects link to non-existent pages:',
'brokenredirects-edit'    => 'edit',
'brokenredirects-delete'  => 'delete',

'withoutinterwiki'         => 'Pages without language links',
'withoutinterwiki-summary' => 'The following pages do not link to other language versions.',
'withoutinterwiki-legend'  => 'Prefix',
'withoutinterwiki-submit'  => 'Show',

'fewestrevisions'         => 'Pages with the fewest revisions',
'fewestrevisions-summary' => '', # do not translate or duplicate this message to other languages

# Miscellaneous special pages
'nbytes'                          => '$1 {{PLURAL:$1|byte|bytes}}',
'ncategories'                     => '$1 {{PLURAL:$1|category|categories}}',
'ninterwikis'                     => '$1 {{PLURAL:$1|interwiki|interwikis}}',
'nlinks'                          => '$1 {{PLURAL:$1|link|links}}',
'nmembers'                        => '$1 {{PLURAL:$1|member|members}}',
'nrevisions'                      => '$1 {{PLURAL:$1|revision|revisions}}',
'nviews'                          => '$1 {{PLURAL:$1|view|views}}',
'nimagelinks'                     => 'Used on $1 {{PLURAL:$1|page|pages}}',
'ntransclusions'                  => 'used on $1 {{PLURAL:$1|page|pages}}',
'specialpage-empty'               => 'There are no results for this report.',
'lonelypages'                     => 'Orphaned pages',
'lonelypages-summary'             => '', # do not translate or duplicate this message to other languages
'lonelypagestext'                 => 'The following pages are not linked from or transcluded into other pages in {{SITENAME}}.',
'uncategorizedpages'              => 'Uncategorized pages',
'uncategorizedpages-summary'      => '', # do not translate or duplicate this message to other languages
'uncategorizedcategories'         => 'Uncategorized categories',
'uncategorizedcategories-summary' => '', # do not translate or duplicate this message to other languages
'uncategorizedimages'             => 'Uncategorized files',
'uncategorizedimages-summary'     => '', # do not translate or duplicate this message to other languages
'uncategorizedtemplates'          => 'Uncategorized templates',
'uncategorizedtemplates-summary'  => '', # do not translate or duplicate this message to other languages
'unusedcategories'                => 'Unused categories',
'unusedcategories-summary'        => '', # do not translate or duplicate this message to other languages
'unusedimages'                    => 'Unused files',
'unusedimages-summary'            => '', # do not translate or duplicate this message to other languages
'popularpages'                    => 'Popular pages',
'popularpages-summary'            => '', # do not translate or duplicate this message to other languages
'wantedcategories'                => 'Wanted categories',
'wantedcategories-summary'        => '', # do not translate or duplicate this message to other languages
'wantedpages'                     => 'Wanted pages',
'wantedpages-summary'             => '', # do not translate or duplicate this message to other languages
'wantedpages-badtitle'            => 'Invalid title in result set: $1',
'wantedfiles'                     => 'Wanted files',
'wantedfiles-summary'             => '', # do not translate or duplicate this message to other languages
'wantedfiletext-cat'              => 'The following files are used but do not exist. Files from foreign repositories may be listed despite existing. Any such false positives will be <del>struck out</del>. Additionally, pages that embed files that do not exist are listed in [[:$1]].',
'wantedfiletext-nocat'            => 'The following files are used but do not exist. Files from foreign repositories may be listed despite existing. Any such false positives will be <del>struck out</del>.',
'wantedtemplates'                 => 'Wanted templates',
'wantedtemplates-summary'         => '', # do not translate or duplicate this message to other languages
'mostlinked'                      => 'Most linked-to pages',
'mostlinked-summary'              => '', # do not translate or duplicate this message to other languages
'mostlinkedcategories'            => 'Most linked-to categories',
'mostlinkedcategories-summary'    => '', # do not translate or duplicate this message to other languages
'mostlinkedtemplates'             => 'Most linked-to templates',
'mostlinkedtemplates-summary'     => '', # do not translate or duplicate this message to other languages
'mostcategories'                  => 'Pages with the most categories',
'mostcategories-summary'          => '', # do not translate or duplicate this message to other languages
'mostimages'                      => 'Most linked-to files',
'mostimages-summary'              => '', # do not translate or duplicate this message to other languages
'mostinterwikis'                  => 'Pages with the most interwikis',
'mostinterwikis-summary'          => '', # do not translate or duplicate this message to other languages
'mostrevisions'                   => 'Pages with the most revisions',
'mostrevisions-summary'           => '', # do not translate or duplicate this message to other languages
'prefixindex'                     => 'All pages with prefix',
'prefixindex-namespace'           => 'All pages with prefix ($1 namespace)',
'prefixindex-summary'             => '', # do not translate or duplicate this message to other languages
'shortpages'                      => 'Short pages',
'shortpages-summary'              => '', # do not translate or duplicate this message to other languages
'longpages'                       => 'Long pages',
'longpages-summary'               => '', # do not translate or duplicate this message to other languages
'deadendpages'                    => 'Dead-end pages',
'deadendpages-summary'            => '', # do not translate or duplicate this message to other languages
'deadendpagestext'                => 'The following pages do not link to other pages in {{SITENAME}}.',
'protectedpages'                  => 'Protected pages',
'protectedpages-indef'            => 'Indefinite protections only',
'protectedpages-summary'          => '', # do not translate or duplicate this message to other languages
'protectedpages-cascade'          => 'Cascading protections only',
'protectedpagestext'              => 'The following pages are protected from moving or editing',
'protectedpagesempty'             => 'No pages are currently protected with these parameters.',
'protectedtitles'                 => 'Protected titles',
'protectedtitles-summary'         => '', # do not translate or duplicate this message to other languages
'protectedtitlestext'             => 'The following titles are protected from creation',
'protectedtitlesempty'            => 'No titles are currently protected with these parameters.',
'listusers'                       => 'User list',
'listusers-summary'               => '', # do not translate or duplicate this message to other languages
'listusers-editsonly'             => 'Show only users with edits',
'listusers-creationsort'          => 'Sort by creation date',
'usereditcount'                   => '$1 {{PLURAL:$1|edit|edits}}',
'usercreated'                     => '{{GENDER:$3|Created}} on $1 at $2',
'newpages'                        => 'New pages',
'newpages-summary'                => '', # do not translate or duplicate this message to other languages
'newpages-username'               => 'Username:',
'ancientpages'                    => 'Oldest pages',
'ancientpages-summary'            => '', # do not translate or duplicate this message to other languages
'move'                            => 'Move',
'movethispage'                    => 'Move this page',
'unusedimagestext'                => 'The following files exist but are not embedded in any page.
Please note that other web sites may link to a file with a direct URL, and so may still be listed here despite being in active use.',
'unusedcategoriestext'            => 'The following category pages exist, although no other page or category makes use of them.',
'notargettitle'                   => 'No target',
'notargettext'                    => 'You have not specified a target page or user to perform this function on.',
'nopagetitle'                     => 'No such target page',
'nopagetext'                      => 'The target page you have specified does not exist.',
'pager-newer-n'                   => '{{PLURAL:$1|newer 1|newer $1}}',
'pager-older-n'                   => '{{PLURAL:$1|older 1|older $1}}',
'suppress'                        => 'Oversight',
'querypage-disabled'              => 'This special page is disabled for performance reasons.',

# Book sources
'booksources'               => 'Book sources',
'booksources-summary'       => '', # do not translate or duplicate this message to other languages
'booksources-search-legend' => 'Search for book sources',
'booksources-isbn'          => 'ISBN:', # only translate this message to other languages if you have to change it
'booksources-go'            => 'Go',
'booksources-text'          => 'Below is a list of links to other sites that sell new and used books, and may also have further information about books you are looking for:',
'booksources-invalid-isbn'  => 'The given ISBN does not appear to be valid; check for errors copying from the original source.',

# Magic words
'rfcurl'    => '//tools.ietf.org/html/rfc$1', # do not translate or duplicate this message to other languages
'pubmedurl' => '//www.ncbi.nlm.nih.gov/pubmed/$1?dopt=Abstract', # do not translate or duplicate this message to other languages

# Special:Log
'specialloguserlabel'        => 'Performer:',
'speciallogtitlelabel'       => 'Target (title or user):',
'log'                        => 'Logs',
'all-logs-page'              => 'All public logs',
'alllogstext'                => 'Combined display of all available logs of {{SITENAME}}.
You can narrow down the view by selecting a log type, the username (case-sensitive), or the affected page (also case-sensitive).',
'logempty'                   => 'No matching items in log.',
'log-title-wildcard'         => 'Search titles starting with this text',
'showhideselectedlogentries' => 'Show/hide selected log entries',

# Special:AllPages
'allpages'                => 'All pages',
'allpages-summary'        => '', # do not translate or duplicate this message to other languages
'alphaindexline'          => '$1 to $2',
'nextpage'                => 'Next page ($1)',
'prevpage'                => 'Previous page ($1)',
'allpagesfrom'            => 'Display pages starting at:',
'allpagesto'              => 'Display pages ending at:',
'allarticles'             => 'All pages',
'allinnamespace'          => 'All pages ($1 namespace)',
'allnotinnamespace'       => 'All pages (not in $1 namespace)',
'allpagesprev'            => 'Previous',
'allpagesnext'            => 'Next',
'allpagessubmit'          => 'Go',
'allpagesprefix'          => 'Display pages with prefix:',
'allpagesbadtitle'        => 'The given page title was invalid or had an inter-language or inter-wiki prefix.
It may contain one or more characters that cannot be used in titles.',
'allpages-bad-ns'         => '{{SITENAME}} does not have namespace "$1".',
'allpages-hide-redirects' => 'Hide redirects',

# SpecialCachedPage
'cachedspecial-viewing-cached-ttl' => 'You are viewing a cached version of this page, which can be up to $1 old.',
'cachedspecial-viewing-cached-ts'  => 'You are viewing a cached version of this page, which might not be completely actual.',
'cachedspecial-refresh-now'        => 'View latest.',

# Special:Categories
'categories'                    => 'Categories',
'categories-summary'            => '', # do not translate or duplicate this message to other languages
'categoriespagetext'            => 'The following {{PLURAL:$1|category contains|categories contain}} pages or media.
[[Special:UnusedCategories|Unused categories]] are not shown here.
Also see [[Special:WantedCategories|wanted categories]].',
'categoriesfrom'                => 'Display categories starting at:',
'special-categories-sort-count' => 'sort by count',
'special-categories-sort-abc'   => 'sort alphabetically',

# Special:DeletedContributions
'deletedcontributions'             => 'Deleted user contributions',
'deletedcontributions-summary'     => '', # do not translate or duplicate this message to other languages
'deletedcontributions-title'       => 'Deleted user contributions',
'sp-deletedcontributions-contribs' => 'contributions',

# Special:LinkSearch
'linksearch'         => 'External links search',
'linksearch-summary' => '', # do not translate or duplicate this message to other languages
'linksearch-pat'     => 'Search pattern:',
'linksearch-ns'      => 'Namespace:',
'linksearch-ok'      => 'Search',
'linksearch-text'    => 'Wildcards such as "*.wikipedia.org" may be used.
Needs at least a top-level domain, for example "*.org".<br />
Supported protocols: <code>$1</code> (defaults to http:// if no protocol is specified).',
'linksearch-line'    => '$1 is linked from $2',
'linksearch-error'   => 'Wildcards may appear only at the start of the hostname.',

# Special:ListUsers
'listusersfrom'      => 'Display users starting at:',
'listusers-submit'   => 'Show',
'listusers-noresult' => 'No user found.',
'listusers-blocked'  => '(blocked)',

# Special:ActiveUsers
'activeusers'            => 'Active users list',
'activeusers-summary'    => '', # do not translate or duplicate this message to other languages
'activeusers-intro'      => 'This is a list of users who had some kind of activity within the last $1 {{PLURAL:$1|day|days}}.',
'activeusers-count'      => '$1 {{PLURAL:$1|action|actions}} in the last {{PLURAL:$3|day|$3 days}}',
'activeusers-from'       => 'Display users starting at:',
'activeusers-hidebots'   => 'Hide bots',
'activeusers-hidesysops' => 'Hide administrators',
'activeusers-noresult'   => 'No users found.',

# Special:Log/newusers
'newuserlogpage'     => 'User creation log',
'newuserlogpagetext' => 'This is a log of user creations.',

# Special:ListGroupRights
'listgrouprights'                      => 'User group rights',
'listgrouprights-summary'              => 'The following is a list of user groups defined on this wiki, with their associated access rights.
There may be [[{{MediaWiki:Listgrouprights-helppage}}|additional information]] about individual rights.',
'listgrouprights-key'                  => '* <span class="listgrouprights-granted">Granted right</span>
* <span class="listgrouprights-revoked">Revoked right</span>',
'listgrouprights-group'                => 'Group',
'listgrouprights-rights'               => 'Rights',
'listgrouprights-helppage'             => 'Help:Group rights',
'listgrouprights-members'              => '(list of members)',
'listgrouprights-right-display'        => '<span class="listgrouprights-granted">$1 <code>($2)</code></span>', # only translate this message to other languages if you have to change it
'listgrouprights-right-revoked'        => '<span class="listgrouprights-revoked">$1 <code>($2)</code></span>', # only translate this message to other languages if you have to change it
'listgrouprights-addgroup'             => 'Add {{PLURAL:$2|group|groups}}: $1',
'listgrouprights-removegroup'          => 'Remove {{PLURAL:$2|group|groups}}: $1',
'listgrouprights-addgroup-all'         => 'Add all groups',
'listgrouprights-removegroup-all'      => 'Remove all groups',
'listgrouprights-addgroup-self'        => 'Add {{PLURAL:$2|group|groups}} to own account: $1',
'listgrouprights-removegroup-self'     => 'Remove {{PLURAL:$2|group|groups}} from own account: $1',
'listgrouprights-addgroup-self-all'    => 'Add all groups to own account',
'listgrouprights-removegroup-self-all' => 'Remove all groups from own account',

# E-mail user
'mailnologin'              => 'No send address',
'mailnologintext'          => 'You must be [[Special:UserLogin|logged in]] and have a valid e-mail address in your [[Special:Preferences|preferences]] to send e-mail to other users.',
'emailuser'                => 'E-mail this user',
'emailuser-title-target'   => 'E-mail this {{GENDER:$1|user}}',
'emailuser-title-notarget' => 'E-mail user',
'emailuser-summary'        => '', # do not translate or duplicate this message to other languages
'emailpage'                => 'E-mail user',
'emailpagetext'            => 'You can use the form below to send an e-mail message to this {{GENDER:$1|user}}.
The e-mail address you entered in [[Special:Preferences|your user preferences]] will appear as the "From" address of the e-mail, so the recipient will be able to reply directly to you.',
'usermailererror'          => 'Mail object returned error:',
'defemailsubject'          => '{{SITENAME}} e-mail from user "$1"',
'usermaildisabled'         => 'User e-mail disabled',
'usermaildisabledtext'     => 'You cannot send e-mail to other users on this wiki',
'noemailtitle'             => 'No e-mail address',
'noemailtext'              => 'This user has not specified a valid e-mail address.',
'nowikiemailtitle'         => 'No e-mail allowed',
'nowikiemailtext'          => 'This user has chosen not to receive e-mail from other users.',
'emailnotarget'            => 'Non-existent or invalid username for recipient.',
'emailtarget'              => 'Enter username of recipient',
'emailusername'            => 'Username:',
'emailusernamesubmit'      => 'Submit',
'email-legend'             => 'Send an e-mail to another {{SITENAME}} user',
'emailfrom'                => 'From:',
'emailto'                  => 'To:',
'emailsubject'             => 'Subject:',
'emailmessage'             => 'Message:',
'emailsend'                => 'Send',
'emailccme'                => 'E-mail me a copy of my message.',
'emailccsubject'           => 'Copy of your message to $1: $2',
'emailsent'                => 'E-mail sent',
'emailsenttext'            => 'Your e-mail message has been sent.',
'emailuserfooter'          => 'This e-mail was sent by $1 to $2 by the "E-mail user" function at {{SITENAME}}.',

# User Messenger
'usermessage-summary'  => 'Leaving system message.',
'usermessage-editor'   => 'System messenger',
'usermessage-template' => 'MediaWiki:UserMessage', # only translate this message to other languages if you have to change it

# Watchlist
'watchlist'            => 'My watchlist',
'watchlist-summary'    => '', # do not translate or duplicate this message to other languages
'mywatchlist'          => 'Watchlist',
'watchlistfor2'        => 'For $1 $2',
'nowatchlist'          => 'You have no items on your watchlist.',
'watchlistanontext'    => 'Please $1 to view or edit items on your watchlist.',
'watchnologin'         => 'Not logged in',
'watchnologintext'     => 'You must be [[Special:UserLogin|logged in]] to modify your watchlist.',
'addwatch'             => 'Add to watchlist',
'addedwatchtext'       => 'The page "[[:$1]]" has been added to your [[Special:Watchlist|watchlist]].
Future changes to this page and its associated talk page will be listed there.',
'removewatch'          => 'Remove from watchlist',
'removedwatchtext'     => 'The page "[[:$1]]" has been removed from [[Special:Watchlist|your watchlist]].',
'watch'                => 'Watch',
'watchthispage'        => 'Watch this page',
'unwatch'              => 'Unwatch',
'unwatchthispage'      => 'Stop watching',
'notanarticle'         => 'Not a content page',
'notvisiblerev'        => 'The last revision by a different user has been deleted',
'watchnochange'        => 'None of your watched items were edited in the time period displayed.',
'watchlist-details'    => '{{PLURAL:$1|$1 page|$1 pages}} on your watchlist, not counting talk pages.',
'wlheader-enotif'      => '* E-mail notification is enabled.',
'wlheader-showupdated' => "* Pages that have been changed since you last visited them are shown in '''bold'''",
'watchmethod-recent'   => 'checking recent edits for watched pages',
'watchmethod-list'     => 'checking watched pages for recent edits',
'watchlistcontains'    => 'Your watchlist contains $1 {{PLURAL:$1|page|pages}}.',
'iteminvalidname'      => "Problem with item '$1', invalid name...",
'wlnote'               => "Below {{PLURAL:$1|is the last change|are the last '''$1''' changes}} in the last {{PLURAL:$2|hour|'''$2''' hours}}, as of $3, $4.",
'wlshowlast'           => 'Show last $1 hours $2 days $3',
'watchlist-options'    => 'Watchlist options',

# Displayed when you click the "watch" button and it is in the process of watching
'watching'       => 'Watching...',
'unwatching'     => 'Unwatching...',
'watcherrortext' => 'An error occurred while changing your watchlist settings for "$1".',

'enotif_mailer'                => '{{SITENAME}} notification mailer',
'enotif_reset'                 => 'Mark all pages visited',
'enotif_newpagetext'           => 'This is a new page.',
'enotif_impersonal_salutation' => '{{SITENAME}} user',
'changed'                      => 'changed',
'created'                      => 'created',
'enotif_subject'               => '{{SITENAME}} page $PAGETITLE has been $CHANGEDORCREATED by $PAGEEDITOR',
'enotif_lastvisited'           => 'See $1 for all changes since your last visit.',
'enotif_lastdiff'              => 'See $1 to view this change.',
'enotif_anon_editor'           => 'anonymous user $1',
'enotif_body'                  => 'Dear $WATCHINGUSERNAME,


The {{SITENAME}} page $PAGETITLE has been $CHANGEDORCREATED on $PAGEEDITDATE by $PAGEEDITOR, see $PAGETITLE_URL for the current revision.

$NEWPAGE

Editor\'s summary: $PAGESUMMARY $PAGEMINOREDIT

Contact the editor:
mail: $PAGEEDITOR_EMAIL
wiki: $PAGEEDITOR_WIKI

There will be no other notifications in case of further activity unless you visit this page. You could also reset the notification flags for all your watched pages on your watchlist.

			 Your friendly {{SITENAME}} notification system

--
To change your e-mail notification settings, visit
{{canonicalurl:{{#special:Preferences}}}}

To change your watchlist settings, visit
{{canonicalurl:{{#special:EditWatchlist}}}}

To delete the page from your watchlist, visit
$UNWATCHURL

Feedback and further assistance:
{{canonicalurl:{{MediaWiki:Helppage}}}}',

# Delete
'deletepage'             => 'Delete page',
'confirm'                => 'Confirm',
'excontent'              => 'content was: "$1"',
'excontentauthor'        => 'content was: "$1" (and the only contributor was "[[Special:Contributions/$2|$2]]")',
'exbeforeblank'          => 'content before blanking was: "$1"',
'exblank'                => 'page was empty',
'delete-confirm'         => 'Delete "$1"',
'delete-legend'          => 'Delete',
'historywarning'         => "'''Warning:''' The page you are about to delete has a history with approximately $1 {{PLURAL:$1|revision|revisions}}:",
'confirmdeletetext'      => 'You are about to delete a page along with all of its history.
Please confirm that you intend to do this, that you understand the consequences, and that you are doing this in accordance with [[{{MediaWiki:Policy-url}}|the policy]].',
'actioncomplete'         => 'Action complete',
'actionfailed'           => 'Action failed',
'deletedtext'            => '"$1" has been deleted.
See $2 for a record of recent deletions.',
'dellogpage'             => 'Deletion log',
'dellogpagetext'         => 'Below is a list of the most recent deletions.',
'deletionlog'            => 'deletion log',
'reverted'               => 'Reverted to earlier revision',
'deletecomment'          => 'Reason:',
'deleteotherreason'      => 'Other/additional reason:',
'deletereasonotherlist'  => 'Other reason',
'deletereason-dropdown'  => '*Common delete reasons
** Author request
** Copyright violation
** Vandalism',
'delete-edit-reasonlist' => 'Edit deletion reasons',
'delete-toobig'          => 'This page has a large edit history, over $1 {{PLURAL:$1|revision|revisions}}.
Deletion of such pages has been restricted to prevent accidental disruption of {{SITENAME}}.',
'delete-warning-toobig'  => 'This page has a large edit history, over $1 {{PLURAL:$1|revision|revisions}}.
Deleting it may disrupt database operations of {{SITENAME}};
proceed with caution.',

# Rollback
'rollback'                   => 'Roll back edits',
'rollback_short'             => 'Rollback',
'rollbacklink'               => 'rollback',
'rollbacklinkcount'          => 'rollback $1 {{PLURAL:$1|edit|edits}}',
'rollbacklinkcount-morethan' => 'rollback more than $1 {{PLURAL:$1|edit|edits}}',
'rollbackfailed'             => 'Rollback failed',
'cantrollback'               => 'Cannot revert edit;
last contributor is only author of this page.',
'alreadyrolled'              => 'Cannot rollback last edit of [[:$1]] by [[User:$2|$2]] ([[User talk:$2|talk]]{{int:pipe-separator}}[[Special:Contributions/$2|{{int:contribslink}}]]);
someone else has edited or rolled back the page already.

The last edit to the page was by [[User:$3|$3]] ([[User talk:$3|talk]]{{int:pipe-separator}}[[Special:Contributions/$3|{{int:contribslink}}]]).',
'editcomment'                => "The edit summary was: \"''\$1''\".",
'revertpage'                 => 'Reverted edits by [[Special:Contributions/$2|$2]] ([[User talk:$2|talk]]) to last revision by [[User:$1|$1]]',
'revertpage-nouser'          => 'Reverted edits by (username removed) to last revision by [[User:$1|$1]]',
'rollback-success'           => 'Reverted edits by $1;
changed back to last revision by $2.',

# Edit tokens
'sessionfailure-title' => 'Session failure',
'sessionfailure'       => 'There seems to be a problem with your login session;
this action has been canceled as a precaution against session hijacking.
Go back to the previous page, reload that page and then try again.',

# Protect
'protectlogpage'              => 'Protection log',
'protectlogtext'              => 'Below is a list of changes to page protections.
See the [[Special:ProtectedPages|protected pages list]] for the list of currently operational page protections.',
'protectedarticle'            => 'protected "[[$1]]"',
'modifiedarticleprotection'   => 'changed protection level for "[[$1]]"',
'unprotectedarticle'          => 'removed protection from "[[$1]]"',
'movedarticleprotection'      => 'moved protection settings from "[[$2]]" to "[[$1]]"',
'protect-title'               => 'Change protection level for "$1"',
'protect-title-notallowed'    => 'View protection level of "$1"',
'prot_1movedto2'              => '[[$1]] moved to [[$2]]',
'protect-badnamespace-title'  => 'Non-protectable namespace',
'protect-badnamespace-text'   => 'Pages in this namespace cannot be protected.',
'protect-legend'              => 'Confirm protection',
'protectcomment'              => 'Reason:',
'protectexpiry'               => 'Expires:',
'protect_expiry_invalid'      => 'Expiry time is invalid.',
'protect_expiry_old'          => 'Expiry time is in the past.',
'protect-unchain-permissions' => 'Unlock further protect options',
'protect-text'                => "Here you may view and change the protection level for the page '''$1'''.",
'protect-locked-blocked'      => "You cannot change protection levels while blocked.
Here are the current settings for the page '''$1''':",
'protect-locked-dblock'       => "Protection levels cannot be changed due to an active database lock.
Here are the current settings for the page '''$1''':",
'protect-locked-access'       => "Your account does not have permission to change page protection levels.

Here are the current settings for the page '''$1''':",
'protect-cascadeon'           => "This page is currently protected because it is included in the following {{PLURAL:$1|page, which has|pages, which have}} cascading protection turned on.
You can change this page's protection level, but it will not affect the cascading protection.",
'protect-default'             => 'Allow all users',
'protect-fallback'            => 'Allow only users with "$1" permission',
'protect-level-autoconfirmed' => 'Allow only autoconfirmed users',
'protect-level-sysop'         => 'Allow only administrators',
'protect-summary-cascade'     => 'cascading',
'protect-expiring'            => 'expires $1 (UTC)',
'protect-expiring-local'      => 'expires $1',
'protect-expiry-indefinite'   => 'indefinite',
'protect-cascade'             => 'Protect pages included in this page (cascading protection)',
'protect-cantedit'            => 'You cannot change the protection levels of this page because you do not have permission to edit it.',
'protect-othertime'           => 'Other time:',
'protect-othertime-op'        => 'other time',
'protect-existing-expiry'     => 'Existing expiry time: $3, $2',
'protect-otherreason'         => 'Other/additional reason:',
'protect-otherreason-op'      => 'Other reason',
'protect-dropdown'            => '*Common protection reasons
** Excessive vandalism
** Excessive spamming
** Counter-productive edit warring
** High traffic page',
'protect-edit-reasonlist'     => 'Edit protection reasons',
'protect-expiry-options'      => '1 hour:1 hour,1 day:1 day,1 week:1 week,2 weeks:2 weeks,1 month:1 month,3 months:3 months,6 months:6 months,1 year:1 year,infinite:infinite',
'restriction-type'            => 'Permission:',
'restriction-level'           => 'Restriction level:',
'minimum-size'                => 'Min size',
'maximum-size'                => 'Max size:',
'pagesize'                    => '(bytes)',

# Restrictions (nouns)
'restriction-edit'   => 'Edit',
'restriction-move'   => 'Move',
'restriction-create' => 'Create',
'restriction-upload' => 'Upload',

# Restriction levels
'restriction-level-sysop'         => 'fully protected',
'restriction-level-autoconfirmed' => 'semi protected',
'restriction-level-all'           => 'any level',

# Undelete
'undelete'                     => 'View deleted pages',
'undelete-summary'             => '', # do not translate or duplicate this message to other languages
'undeletepage'                 => 'View and restore deleted pages',
'undeletepagetitle'            => "'''The following consists of deleted revisions of [[:$1|$1]]'''.",
'viewdeletedpage'              => 'View deleted pages',
'undeletepagetext'             => 'The following {{PLURAL:$1|page has been deleted but is|$1 pages have been deleted but are}} still in the archive and can be restored.
The archive may be periodically cleaned out.',
'undelete-fieldset-title'      => 'Restore revisions',
'undeleteextrahelp'            => "To restore the page's entire history, leave all checkboxes deselected and click '''''{{int:undeletebtn}}'''''.
To perform a selective restoration, check the boxes corresponding to the revisions to be restored, and click '''''{{int:undeletebtn}}'''''.",
'undeleterevisions'            => '$1 {{PLURAL:$1|revision|revisions}} archived',
'undeletehistory'              => 'If you restore the page, all revisions will be restored to the history.
If a new page with the same name has been created since the deletion, the restored revisions will appear in the prior history.',
'undeleterevdel'               => 'Undeletion will not be performed if it will result in the top page or file revision being partially deleted.
In such cases, you must uncheck or unhide the newest deleted revision.',
'undeletehistorynoadmin'       => 'This page has been deleted.
The reason for deletion is shown in the summary below, along with details of the users who had edited this page before deletion.
The actual text of these deleted revisions is only available to administrators.',
'undelete-revision'            => 'Deleted revision of $1 (as of $4, at $5) by $3:',
'undeleterevision-missing'     => 'Invalid or missing revision.
You may have a bad link, or the revision may have been restored or removed from the archive.',
'undelete-nodiff'              => 'No previous revision found.',
'undeletebtn'                  => 'Restore',
'undeletelink'                 => 'view/restore',
'undeleteviewlink'             => 'view',
'undeletereset'                => 'Reset',
'undeleteinvert'               => 'Invert selection',
'undeletecomment'              => 'Reason:',
'undeletedrevisions'           => '{{PLURAL:$1|1 revision|$1 revisions}} restored',
'undeletedrevisions-files'     => '{{PLURAL:$1|1 revision|$1 revisions}} and {{PLURAL:$2|1 file|$2 files}} restored',
'undeletedfiles'               => '{{PLURAL:$1|1 file|$1 files}} restored',
'cannotundelete'               => 'Undelete failed;
someone else may have undeleted the page first.',
'undeletedpage'                => "'''$1 has been restored'''

Consult the [[Special:Log/delete|deletion log]] for a record of recent deletions and restorations.",
'undelete-header'              => 'See [[Special:Log/delete|the deletion log]] for recently deleted pages.',
'undelete-search-title'        => 'Search deleted pages',
'undelete-search-box'          => 'Search deleted pages',
'undelete-search-prefix'       => 'Show pages starting with:',
'undelete-search-submit'       => 'Search',
'undelete-no-results'          => 'No matching pages found in the deletion archive.',
'undelete-filename-mismatch'   => 'Cannot undelete file revision with timestamp $1: Filename mismatch.',
'undelete-bad-store-key'       => 'Cannot undelete file revision with timestamp $1: File was missing before deletion.',
'undelete-cleanup-error'       => 'Error deleting unused archive file "$1".',
'undelete-missing-filearchive' => 'Unable to restore file archive ID $1 because it is not in the database.
It may have already been undeleted.',
'undelete-error'               => 'Error undeleting page',
'undelete-error-short'         => 'Error undeleting file: $1',
'undelete-error-long'          => 'Errors were encountered while undeleting the file:

$1',
'undelete-show-file-confirm'   => 'Are you sure you want to view the deleted revision of the file "<nowiki>$1</nowiki>" from $2 at $3?',
'undelete-show-file-submit'    => 'Yes',
'undelete-revisionrow'         => '$1 $2 ($3) $4 . . $5 $6 $7', # only translate this message to other languages if you have to change it

# Namespace form on various pages
'namespace'                     => 'Namespace:',
'invert'                        => 'Invert selection',
'tooltip-invert'                => 'Check this box to hide changes to pages within the selected namespace (and the associated namespace if checked)',
'namespace_association'         => 'Associated namespace',
'tooltip-namespace_association' => 'Check this box to also include the talk or subject namespace associated with the selected namespace',
'blanknamespace'                => '(Main)',

# Contributions
'contributions'         => 'User contributions',
'contributions-summary' => '', # do not translate or duplicate this message to other languages
'contributions-title'   => 'User contributions for $1',
'mycontris'             => 'Contributions',
'contribsub2'           => 'For $1 ($2)',
'nocontribs'            => 'No changes were found matching these criteria.',
'uctop'                 => '(top)',
'month'                 => 'From month (and earlier):',
'year'                  => 'From year (and earlier):',

'sp-contributions-newbies'             => 'Show contributions of new accounts only',
'sp-contributions-newbies-sub'         => 'For new accounts',
'sp-contributions-newbies-title'       => 'User contributions for new accounts',
'sp-contributions-blocklog'            => 'block log',
'sp-contributions-deleted'             => 'deleted user contributions',
'sp-contributions-uploads'             => 'uploads',
'sp-contributions-logs'                => 'logs',
'sp-contributions-talk'                => 'talk',
'sp-contributions-userrights'          => 'user rights management',
'sp-contributions-blocked-notice'      => 'This user is currently blocked.
The latest block log entry is provided below for reference:',
'sp-contributions-blocked-notice-anon' => 'This IP address is currently blocked.
The latest block log entry is provided below for reference:',
'sp-contributions-search'              => 'Search for contributions',
'sp-contributions-username'            => 'IP address or username:',
'sp-contributions-toponly'             => 'Only show edits that are latest revisions',
'sp-contributions-submit'              => 'Search',
'sp-contributions-explain'             => '', # only translate this message to other languages if you have to change it
'sp-contributions-footer'              => '-', # do not translate or duplicate this message to other languages
'sp-contributions-footer-anon'         => '-', # do not translate or duplicate this message to other languages
'sp-contributions-footer-newbies'      => '-', # do not translate or duplicate this message to other languages

# What links here
'whatlinkshere'            => 'What links here',
'whatlinkshere-title'      => 'Pages that link to "$1"',
'whatlinkshere-summary'    => '', # do not translate or duplicate this message to other languages
'whatlinkshere-page'       => 'Page:',
'linkshere'                => "The following pages link to '''[[:$1]]''':",
'nolinkshere'              => "No pages link to '''[[:$1]]'''.",
'nolinkshere-ns'           => "No pages link to '''[[:$1]]''' in the chosen namespace.",
'isredirect'               => 'redirect page',
'istemplate'               => 'transclusion',
'isimage'                  => 'file link',
'whatlinkshere-prev'       => '{{PLURAL:$1|previous|previous $1}}',
'whatlinkshere-next'       => '{{PLURAL:$1|next|next $1}}',
'whatlinkshere-links'      => '← links',
'whatlinkshere-hideredirs' => '$1 redirects',
'whatlinkshere-hidetrans'  => '$1 transclusions',
'whatlinkshere-hidelinks'  => '$1 links',
'whatlinkshere-hideimages' => '$1 file links',
'whatlinkshere-filters'    => 'Filters',

# Block/unblock
'autoblockid'                     => 'Autoblock #$1',
'block'                           => 'Block user',
'unblock'                         => 'Unblock user',
'unblock-summary'                 => '', # do not translate or duplicate this message to other languages
'blockip'                         => 'Block user',
'blockip-title'                   => 'Block user',
'blockip-legend'                  => 'Block user',
'blockiptext'                     => 'Use the form below to block write access from a specific IP address or username.
This should be done only to prevent vandalism, and in accordance with [[{{MediaWiki:Policy-url}}|policy]].
Fill in a specific reason below (for example, citing particular pages that were vandalized).',
'ipadressorusername'              => 'IP address or username:',
'ipbexpiry'                       => 'Expiry:',
'ipbreason'                       => 'Reason:',
'ipbreasonotherlist'              => 'Other reason',
'ipbreason-dropdown'              => '*Common block reasons
** Inserting false information
** Removing content from pages
** Spamming links to external sites
** Inserting nonsense/gibberish into pages
** Intimidating behaviour/harassment
** Abusing multiple accounts
** Unacceptable username',
'ipb-hardblock'                   => 'Prevent logged-in users from editing from this IP address',
'ipbcreateaccount'                => 'Prevent account creation',
'ipbemailban'                     => 'Prevent user from sending e-mail',
'ipbenableautoblock'              => 'Automatically block the last IP address used by this user, and any subsequent IP addresses they try to edit from',
'ipbsubmit'                       => 'Block this user',
'ipbother'                        => 'Other time:',
'ipboptions'                      => '2 hours:2 hours,1 day:1 day,3 days:3 days,1 week:1 week,2 weeks:2 weeks,1 month:1 month,3 months:3 months,6 months:6 months,1 year:1 year,indefinite:infinite',
'ipbotheroption'                  => 'other',
'ipbotherreason'                  => 'Other/additional reason:',
'ipbhidename'                     => 'Hide username from edits and lists',
'ipbwatchuser'                    => "Watch this user's user and talk pages",
'ipb-disableusertalk'             => 'Prevent this user from editing their own talk page while blocked',
'ipb-change-block'                => 'Re-block the user with these settings',
'ipb-confirm'                     => 'Confirm block',
'badipaddress'                    => 'Invalid IP address',
'blockipsuccesssub'               => 'Block succeeded',
'blockipsuccesstext'              => '[[Special:Contributions/$1|$1]] has been blocked.<br />
See the [[Special:BlockList|block list]] to review blocks.',
'ipb-blockingself'                => 'You are about to block yourself!  Are you sure you want to do that?',
'ipb-confirmhideuser'             => 'You are about to block a user with "hide user" enabled.  This will suppress the user\'s name in all lists and log entries.  Are you sure you want to do that?',
'ipb-edit-dropdown'               => 'Edit block reasons',
'ipb-unblock-addr'                => 'Unblock $1',
'ipb-unblock'                     => 'Unblock a username or IP address',
'ipb-blocklist'                   => 'View existing blocks',
'ipb-blocklist-contribs'          => 'Contributions for $1',
'unblockip'                       => 'Unblock user',
'unblockiptext'                   => 'Use the form below to restore write access to a previously blocked IP address or username.',
'ipusubmit'                       => 'Remove this block',
'unblocked'                       => '[[User:$1|$1]] has been unblocked',
'unblocked-range'                 => '$1 has been unblocked',
'unblocked-id'                    => 'Block $1 has been removed',
'blocklist'                       => 'Blocked users',
'ipblocklist'                     => 'Blocked users',
'ipblocklist-legend'              => 'Find a blocked user',
'blocklist-userblocks'            => 'Hide account blocks',
'blocklist-tempblocks'            => 'Hide temporary blocks',
'blocklist-addressblocks'         => 'Hide single IP blocks',
'blocklist-rangeblocks'           => 'Hide range blocks',
'blocklist-timestamp'             => 'Timestamp',
'blocklist-target'                => 'Target',
'blocklist-expiry'                => 'Expires',
'blocklist-by'                    => 'Blocking admin',
'blocklist-params'                => 'Block parameters',
'blocklist-reason'                => 'Reason',
'blocklist-summary'               => '', # do not translate or duplicate this message to other languages
'ipblocklist-submit'              => 'Search',
'ipblocklist-localblock'          => 'Local block',
'ipblocklist-otherblocks'         => 'Other {{PLURAL:$1|block|blocks}}',
'infiniteblock'                   => 'infinite',
'expiringblock'                   => 'expires on $1 at $2',
'anononlyblock'                   => 'anon. only',
'noautoblockblock'                => 'autoblock disabled',
'createaccountblock'              => 'account creation disabled',
'emailblock'                      => 'e-mail disabled',
'blocklist-nousertalk'            => 'cannot edit own talk page',
'ipblocklist-empty'               => 'The block list is empty.',
'ipblocklist-no-results'          => 'The requested IP address or username is not blocked.',
'blocklink'                       => 'block',
'unblocklink'                     => 'unblock',
'change-blocklink'                => 'change block',
'contribslink'                    => 'contribs',
'emaillink'                       => 'send e-mail',
'autoblocker'                     => 'Autoblocked because your IP address has been recently used by "[[User:$1|$1]]".
The reason given for $1\'s block is "\'\'$2\'\'"',
'blocklogpage'                    => 'Block log',
'blocklog-showlog'                => 'This user has been blocked previously.
The block log is provided below for reference:',
'blocklog-showsuppresslog'        => 'This user has been blocked and hidden previously.
The suppress log is provided below for reference:',
'blocklogentry'                   => 'blocked [[$1]] with an expiry time of $2 $3',
'reblock-logentry'                => 'changed block settings for [[$1]] with an expiry time of $2 $3',
'blocklogtext'                    => 'This is a log of user blocking and unblocking actions.
Automatically blocked IP addresses are not listed.
See the [[Special:BlockList|block list]] for the list of currently operational bans and blocks.',
'unblocklogentry'                 => 'unblocked $1',
'block-log-flags-anononly'        => 'anonymous users only',
'block-log-flags-nocreate'        => 'account creation disabled',
'block-log-flags-noautoblock'     => 'autoblock disabled',
'block-log-flags-noemail'         => 'e-mail disabled',
'block-log-flags-nousertalk'      => 'cannot edit own talk page',
'block-log-flags-angry-autoblock' => 'enhanced autoblock enabled',
'block-log-flags-hiddenname'      => 'username hidden',
'range_block_disabled'            => 'The administrator ability to create range blocks is disabled.',
'ipb_expiry_invalid'              => 'Expiry time invalid.',
'ipb_expiry_temp'                 => 'Hidden username blocks must be permanent.',
'ipb_hide_invalid'                => 'Unable to suppress this account; it may have too many edits.',
'ipb_already_blocked'             => '"$1" is already blocked',
'ipb-needreblock'                 => '$1 is already blocked. Do you want to change the settings?',
'ipb-otherblocks-header'          => 'Other {{PLURAL:$1|block|blocks}}',
'unblock-hideuser'                => 'You cannot unblock this user, as their username has been hidden.',
'ipb_cant_unblock'                => 'Error: Block ID $1 not found. It may have been unblocked already.',
'ipb_blocked_as_range'            => 'Error: The IP address $1 is not blocked directly and cannot be unblocked.
It is, however, blocked as part of the range $2, which can be unblocked.',
'ip_range_invalid'                => 'Invalid IP range.',
'ip_range_toolarge'               => 'Range blocks larger than /$1 are not allowed.',
'blockme'                         => 'Block me',
'proxyblocker'                    => 'Proxy blocker',
'proxyblocker-disabled'           => 'This function is disabled.',
'proxyblockreason'                => 'Your IP address has been blocked because it is an open proxy.
Please contact your Internet service provider or technical support of your organization and inform them of this serious security problem.',
'proxyblocksuccess'               => 'Done.',
'sorbs'                           => 'DNSBL', # only translate this message to other languages if you have to change it
'sorbsreason'                     => 'Your IP address is listed as an open proxy in the DNSBL used by {{SITENAME}}.',
'sorbs_create_account_reason'     => 'Your IP address is listed as an open proxy in the DNSBL used by {{SITENAME}}.
You cannot create an account',
'cant-block-while-blocked'        => 'You cannot block other users while you are blocked.',
'cant-see-hidden-user'            => "The user you are trying to block has already been blocked and hidden.
Since you do not have the hideuser right, you cannot see or edit the user's block.",
'ipbblocked'                      => 'You cannot block or unblock other users because you are yourself blocked',
'ipbnounblockself'                => 'You are not allowed to unblock yourself',
'ipb-default-expiry'              => '', # do not translate or duplicate this message to other languages

# Developer tools
'lockdb'              => 'Lock database',
'unlockdb'            => 'Unlock database',
'lockdbtext'          => 'Locking the database will suspend the ability of all users to edit pages, change their preferences, edit their watchlists, and other things requiring changes in the database.
Please confirm that this is what you intend to do, and that you will unlock the database when your maintenance is done.',
'unlockdbtext'        => 'Unlocking the database will restore the ability of all users to edit pages, change their preferences, edit their watchlists, and other things requiring changes in the database.
Please confirm that this is what you intend to do.',
'lockconfirm'         => 'Yes, I really want to lock the database.',
'unlockconfirm'       => 'Yes, I really want to unlock the database.',
'lockbtn'             => 'Lock database',
'unlockbtn'           => 'Unlock database',
'locknoconfirm'       => 'You did not check the confirmation box.',
'lockdbsuccesssub'    => 'Database lock succeeded',
'unlockdbsuccesssub'  => 'Database lock removed',
'lockdbsuccesstext'   => 'The database has been locked.<br />
Remember to [[Special:UnlockDB|remove the lock]] after your maintenance is complete.',
'unlockdbsuccesstext' => 'The database has been unlocked.',
'lockfilenotwritable' => 'The database lock file is not writable.
To lock or unlock the database, this needs to be writable by the web server.',
'databasenotlocked'   => 'The database is not locked.',
'lockedbyandtime'     => '(by {{GENDER:$1|$1}} on $2 at $3)',

# Move page
'move-page'                    => 'Move $1',
'movepage-summary'             => '', # do not translate or duplicate this message to other languages
'move-page-legend'             => 'Move page',
'movepagetext'                 => "Using the form below will rename a page, moving all of its history to the new name.
The old title will become a redirect page to the new title.
You can update redirects that point to the original title automatically.
If you choose not to, be sure to check for [[Special:DoubleRedirects|double]] or [[Special:BrokenRedirects|broken redirects]].
You are responsible for making sure that links continue to point where they are supposed to go.

Note that the page will '''not''' be moved if there is already a page at the new title, unless it is a redirect and has no past edit history.
This means that you can rename a page back to where it was renamed from if you make a mistake, and you cannot overwrite an existing page.

'''Warning!'''
This can be a drastic and unexpected change for a popular page;
please be sure you understand the consequences of this before proceeding.",
'movepagetext-noredirectfixer' => "Using the form below will rename a page, moving all of its history to the new name.
The old title will become a redirect page to the new title.
Be sure to check for [[Special:DoubleRedirects|double]] or [[Special:BrokenRedirects|broken redirects]].
You are responsible for making sure that links continue to point where they are supposed to go.

Note that the page will '''not''' be moved if there is already a page at the new title, unless it is a redirect and has no past edit history.
This means that you can rename a page back to where it was renamed from if you make a mistake, and you cannot overwrite an existing page.

'''Warning!'''
This can be a drastic and unexpected change for a popular page;
please be sure you understand the consequences of this before proceeding.",
'movepagetalktext'             => "The associated talk page will be automatically moved along with it '''unless:'''
*A non-empty talk page already exists under the new name, or
*You uncheck the box below.

In those cases, you will have to move or merge the page manually if desired.",
'movearticle'                  => 'Move page:',
'moveuserpage-warning'         => "'''Warning:''' You are about to move a user page. Please note that only the page will be moved and the user will ''not'' be renamed.",
'movenologin'                  => 'Not logged in',
'movenologintext'              => 'You must be a registered user and [[Special:UserLogin|logged in]] to move a page.',
'movenotallowed'               => 'You do not have permission to move pages.',
'movenotallowedfile'           => 'You do not have permission to move files.',
'cant-move-user-page'          => 'You do not have permission to move user pages (apart from subpages).',
'cant-move-to-user-page'       => 'You do not have permission to move a page to a user page (except to a user subpage).',
'newtitle'                     => 'To new title:',
'move-watch'                   => 'Watch source page and target page',
'movepagebtn'                  => 'Move page',
'pagemovedsub'                 => 'Move succeeded',
'movepage-moved'               => '\'\'\'"$1" has been moved to "$2"\'\'\'',
'movepage-moved-redirect'      => 'A redirect has been created.',
'movepage-moved-noredirect'    => 'The creation of a redirect has been suppressed.',
'articleexists'                => 'A page of that name already exists, or the name you have chosen is not valid.
Please choose another name.',
'cantmove-titleprotected'      => 'You cannot move a page to this location because the new title has been protected from creation',
'talkexists'                   => "'''The page itself was moved successfully, but the talk page could not be moved because one already exists at the new title.
Please merge them manually.'''",
'movedto'                      => 'moved to',
'movetalk'                     => 'Move associated talk page',
'move-subpages'                => 'Move subpages (up to $1)',
'move-talk-subpages'           => 'Move subpages of talk page (up to $1)',
'movepage-page-exists'         => 'The page $1 already exists and cannot be automatically overwritten.',
'movepage-page-moved'          => 'The page $1 has been moved to $2.',
'movepage-page-unmoved'        => 'The page $1 could not be moved to $2.',
'movepage-max-pages'           => 'The maximum of $1 {{PLURAL:$1|page|pages}} has been moved and no more will be moved automatically.',
'movelogpage'                  => 'Move log',
'movelogpagetext'              => 'Below is a list of all page moves.',
'movesubpage'                  => '{{PLURAL:$1|Subpage|Subpages}}',
'movesubpagetext'              => 'This page has $1 {{PLURAL:$1|subpage|subpages}} shown below.',
'movenosubpage'                => 'This page has no subpages.',
'movereason'                   => 'Reason:',
'revertmove'                   => 'revert',
'delete_and_move'              => 'Delete and move',
'delete_and_move_text'         => '== Deletion required ==
The destination page "[[:$1]]" already exists.
Do you want to delete it to make way for the move?',
'delete_and_move_confirm'      => 'Yes, delete the page',
'delete_and_move_reason'       => 'Deleted to make way for move from "[[$1]]"',
'selfmove'                     => 'Source and destination titles are the same;
cannot move a page over itself.',
'immobile-source-namespace'    => 'Cannot move pages in namespace "$1"',
'immobile-target-namespace'    => 'Cannot move pages into namespace "$1"',
'immobile-target-namespace-iw' => 'Interwiki link is not a valid target for page move.',
'immobile-source-page'         => 'This page is not movable.',
'immobile-target-page'         => 'Cannot move to that destination title.',
'imagenocrossnamespace'        => 'Cannot move file to non-file namespace',
'nonfile-cannot-move-to-file'  => 'Cannot move non-file to file namespace',
'imagetypemismatch'            => 'The new file extension does not match its type',
'imageinvalidfilename'         => 'The target filename is invalid',
'fix-double-redirects'         => 'Update any redirects that point to the original title',
'move-leave-redirect'          => 'Leave a redirect behind',
'protectedpagemovewarning'     => "'''Warning:''' This page has been protected so that only users with administrator privileges can move it.
The latest log entry is provided below for reference:",
'semiprotectedpagemovewarning' => "'''Note:''' This page has been protected so that only registered users can move it.
The latest log entry is provided below for reference:",
'move-over-sharedrepo'         => '== File exists ==
[[:$1]] exists on a shared repository. Moving a file to this title will override the shared file.',
'file-exists-sharedrepo'       => 'The filename chosen is already in use on a shared repository.
Please choose another name.',

# Export
'export'            => 'Export pages',
'export-summary'    => '', # do not translate or duplicate this message to other languages
'exporttext'        => 'You can export the text and editing history of a particular page or set of pages wrapped in some XML.
This can be imported into another wiki using MediaWiki via the [[Special:Import|import page]].

To export pages, enter the titles in the text box below, one title per line, and select whether you want the current revision as well as all old revisions, with the page history lines, or the current revision with the info about the last edit.

In the latter case you can also use a link, for example [[{{#Special:Export}}/{{MediaWiki:Mainpage}}]] for the page "[[{{MediaWiki:Mainpage}}]]".',
'exportall'         => 'Export all pages',
'exportcuronly'     => 'Include only the current revision, not the full history',
'exportnohistory'   => "----
'''Note:''' Exporting the full history of pages through this form has been disabled due to performance reasons.",
'exportlistauthors' => 'Include a full list of contributors for each page',
'export-submit'     => 'Export',
'export-addcattext' => 'Add pages from category:',
'export-addcat'     => 'Add',
'export-addnstext'  => 'Add pages from namespace:',
'export-addns'      => 'Add',
'export-download'   => 'Save as file',
'export-templates'  => 'Include templates',
'export-pagelinks'  => 'Include linked pages to a depth of:',

# Namespace 8 related
'allmessages'                   => 'System messages',
'allmessagesname'               => 'Name',
'allmessagesdefault'            => 'Default message text',
'allmessagescurrent'            => 'Current message text',
'allmessagestext'               => 'This is a list of system messages available in the MediaWiki namespace.
Please visit [//www.mediawiki.org/wiki/Localisation MediaWiki Localisation] and [//translatewiki.net translatewiki.net] if you wish to contribute to the generic MediaWiki localisation.',
'allmessagesnotsupportedDB'     => "This page cannot be used because '''\$wgUseDatabaseMessages''' has been disabled.",
'allmessages-filter-legend'     => 'Filter',
'allmessages-filter'            => 'Filter by customisation state:',
'allmessages-filter-unmodified' => 'Unmodified',
'allmessages-filter-all'        => 'All',
'allmessages-filter-modified'   => 'Modified',
'allmessages-prefix'            => 'Filter by prefix:',
'allmessages-language'          => 'Language:',
'allmessages-filter-submit'     => 'Go',

# Thumbnails
'thumbnail-more'           => 'Enlarge',
'filemissing'              => 'File missing',
'thumbnail_error'          => 'Error creating thumbnail: $1',
'djvu_page_error'          => 'DjVu page out of range',
'djvu_no_xml'              => 'Unable to fetch XML for DjVu file',
'thumbnail-temp-create'    => 'Unable to create temporary thumbnail file',
'thumbnail-dest-create'    => 'Unable to save thumbnail to destination',
'thumbnail_invalid_params' => 'Invalid thumbnail parameters',
'thumbnail_dest_directory' => 'Unable to create destination directory',
'thumbnail_image-type'     => 'Image type not supported',
'thumbnail_gd-library'     => 'Incomplete GD library configuration: Missing function $1',
'thumbnail_image-missing'  => 'File seems to be missing: $1',

# Special:Import
'import'                     => 'Import pages',
'import-summary'             => '', # do not translate or duplicate this message to other languages
'importinterwiki'            => 'Transwiki import',
'import-interwiki-text'      => "Select a wiki and page title to import.
Revision dates and editors' names will be preserved.
All transwiki import actions are logged at the [[Special:Log/import|import log]].",
'import-interwiki-source'    => 'Source wiki/page:',
'import-interwiki-history'   => 'Copy all history revisions for this page',
'import-interwiki-templates' => 'Include all templates',
'import-interwiki-submit'    => 'Import',
'import-interwiki-namespace' => 'Destination namespace:',
'import-interwiki-rootpage'  => 'Destination root page (optional):',
'import-upload-filename'     => 'Filename:',
'import-comment'             => 'Comment:',
'importtext'                 => 'Please export the file from the source wiki using the [[Special:Export|export utility]].
Save it to your computer and upload it here.',
'importstart'                => 'Importing pages...',
'import-revision-count'      => '$1 {{PLURAL:$1|revision|revisions}}',
'importnopages'              => 'No pages to import.',
'imported-log-entries'       => 'Imported $1 {{PLURAL:$1|log entry|log entries}}.',
'importfailed'               => 'Import failed: <nowiki>$1</nowiki>',
'importunknownsource'        => 'Unknown import source type',
'importcantopen'             => 'Could not open import file',
'importbadinterwiki'         => 'Bad interwiki link',
'importnotext'               => 'Empty or no text',
'importsuccess'              => 'Import finished!',
'importhistoryconflict'      => 'Conflicting history revision exists (may have imported this page before)',
'importnosources'            => 'No transwiki import sources have been defined and direct history uploads are disabled.',
'importnofile'               => 'No import file was uploaded.',
'importuploaderrorsize'      => 'Upload of import file failed.
The file is bigger than the allowed upload size.',
'importuploaderrorpartial'   => 'Upload of import file failed.
The file was only partially uploaded.',
'importuploaderrortemp'      => 'Upload of import file failed.
A temporary folder is missing.',
'import-parse-failure'       => 'XML import parse failure',
'import-noarticle'           => 'No page to import!',
'import-nonewrevisions'      => 'All revisions were previously imported.',
'xml-error-string'           => '$1 at line $2, col $3 (byte $4): $5',
'import-upload'              => 'Upload XML data',
'import-token-mismatch'      => 'Loss of session data.
Please try again.',
'import-invalid-interwiki'   => 'Cannot import from the specified wiki.',
'import-error-edit'          => 'Page "$1" is not imported because you are not allowed to edit it.',
'import-error-create'        => 'Page "$1" is not imported because you are not allowed to create it.',
'import-error-interwiki'     => 'Page "$1" is not imported because its name is reserved for external linking (interwiki).',
'import-error-special'       => 'Page "$1" is not imported because it belongs to a special namespace that does not allow pages.',
'import-error-invalid'       => 'Page "$1" is not imported because its name is invalid.',
'import-options-wrong'       => 'Wrong {{PLURAL:$2|option|options}}: <nowiki>$1</nowiki>',
'import-rootpage-invalid'    => 'Given root page is an invalid title.',
'import-rootpage-nosubpage'  => 'Namespace "$1" of the root page does not allow subpages.',

# Import log
'importlogpage'                    => 'Import log',
'importlogpagetext'                => 'Administrative imports of pages with edit history from other wikis.',
'import-logentry-upload'           => 'imported [[$1]] by file upload',
'import-logentry-upload-detail'    => '$1 {{PLURAL:$1|revision|revisions}}',
'import-logentry-interwiki'        => 'transwikied $1',
'import-logentry-interwiki-detail' => '$1 {{PLURAL:$1|revision|revisions}} from $2',

# JavaScriptTest
'javascripttest'                           => 'JavaScript testing',
'javascripttest-backlink'                  => '< $1', # do not translate or duplicate this message to other languages
'javascripttest-disabled'                  => 'This function has not been enabled on this wiki.',
'javascripttest-title'                     => 'Running $1 tests',
'javascripttest-pagetext-noframework'      => 'This page is reserved for running JavaScript tests.',
'javascripttest-pagetext-unknownframework' => 'Unknown testing framework "$1".',
'javascripttest-pagetext-frameworks'       => 'Please choose one of the following testing frameworks: $1',
'javascripttest-pagetext-skins'            => 'Choose a skin to run the tests with:',
'javascripttest-qunit-name'                => 'QUnit', # do not translate or duplicate this message to other languages
'javascripttest-qunit-intro'               => 'See [$1 testing documentation] on mediawiki.org.',
'javascripttest-qunit-heading'             => 'MediaWiki JavaScript QUnit test suite',

# Keyboard access keys for power users
'accesskey-pt-userpage'                 => '.', # do not translate or duplicate this message to other languages
'accesskey-pt-anonuserpage'             => '.', # do not translate or duplicate this message to other languages
'accesskey-pt-mytalk'                   => 'n', # do not translate or duplicate this message to other languages
'accesskey-pt-anontalk'                 => 'n', # do not translate or duplicate this message to other languages
'accesskey-pt-preferences'              => '', # do not translate or duplicate this message to other languages
'accesskey-pt-watchlist'                => 'l', # do not translate or duplicate this message to other languages
'accesskey-pt-mycontris'                => 'y', # do not translate or duplicate this message to other languages
'accesskey-pt-login'                    => 'o', # do not translate or duplicate this message to other languages
'accesskey-pt-anonlogin'                => 'o', # do not translate or duplicate this message to other languages
'accesskey-pt-logout'                   => '', # do not translate or duplicate this message to other languages
'accesskey-ca-talk'                     => 't', # do not translate or duplicate this message to other languages
'accesskey-ca-edit'                     => 'e', # do not translate or duplicate this message to other languages
'accesskey-ca-addsection'               => '+', # do not translate or duplicate this message to other languages
'accesskey-ca-viewsource'               => 'e', # do not translate or duplicate this message to other languages
'accesskey-ca-history'                  => 'h', # do not translate or duplicate this message to other languages
'accesskey-ca-protect'                  => '=', # do not translate or duplicate this message to other languages
'accesskey-ca-unprotect'                => '=', # do not translate or duplicate this message to other languages
'accesskey-ca-delete'                   => 'd', # do not translate or duplicate this message to other languages
'accesskey-ca-undelete'                 => 'd', # do not translate or duplicate this message to other languages
'accesskey-ca-move'                     => 'm', # do not translate or duplicate this message to other languages
'accesskey-ca-watch'                    => 'w', # do not translate or duplicate this message to other languages
'accesskey-ca-unwatch'                  => 'w', # do not translate or duplicate this message to other languages
'accesskey-search'                      => 'f', # do not translate or duplicate this message to other languages
'accesskey-search-go'                   => '', # do not translate or duplicate this message to other languages
'accesskey-search-fulltext'             => '', # do not translate or duplicate this message to other languages
'accesskey-p-logo'                      => '', # do not translate or duplicate this message to other languages
'accesskey-n-mainpage'                  => 'z', # do not translate or duplicate this message to other languages
'accesskey-n-mainpage-description'      => 'z', # do not translate or duplicate this message to other languages
'accesskey-n-portal'                    => '', # do not translate or duplicate this message to other languages
'accesskey-n-currentevents'             => '', # do not translate or duplicate this message to other languages
'accesskey-n-recentchanges'             => 'r', # do not translate or duplicate this message to other languages
'accesskey-n-randompage'                => 'x', # do not translate or duplicate this message to other languages
'accesskey-n-help'                      => '', # do not translate or duplicate this message to other languages
'accesskey-t-whatlinkshere'             => 'j', # do not translate or duplicate this message to other languages
'accesskey-t-recentchangeslinked'       => 'k', # do not translate or duplicate this message to other languages
'accesskey-feed-rss'                    => '', # do not translate or duplicate this message to other languages
'accesskey-feed-atom'                   => '', # do not translate or duplicate this message to other languages
'accesskey-t-contributions'             => '', # do not translate or duplicate this message to other languages
'accesskey-t-emailuser'                 => '', # do not translate or duplicate this message to other languages
'accesskey-t-permalink'                 => '', # do not translate or duplicate this message to other languages
'accesskey-t-print'                     => 'p', # do not translate or duplicate this message to other languages
'accesskey-t-upload'                    => 'u', # do not translate or duplicate this message to other languages
'accesskey-t-specialpages'              => 'q', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-main'               => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-user'               => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-media'              => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-special'            => '', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-project'            => 'a', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-image'              => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-mediawiki'          => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-template'           => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-help'               => 'c', # do not translate or duplicate this message to other languages
'accesskey-ca-nstab-category'           => 'c', # do not translate or duplicate this message to other languages
'accesskey-minoredit'                   => 'i', # do not translate or duplicate this message to other languages
'accesskey-save'                        => 's', # do not translate or duplicate this message to other languages
'accesskey-preview'                     => 'p', # do not translate or duplicate this message to other languages
'accesskey-diff'                        => 'v', # do not translate or duplicate this message to other languages
'accesskey-compareselectedversions'     => 'v', # do not translate or duplicate this message to other languages
'accesskey-watch'                       => 'w', # do not translate or duplicate this message to other languages
'accesskey-upload'                      => 's', # do not translate or duplicate this message to other languages
'accesskey-preferences-save'            => 's', # do not translate or duplicate this message to other languages
'accesskey-summary'                     => 'b', # do not translate or duplicate this message to other languages
'accesskey-userrights-set'              => 's', # do not translate or duplicate this message to other languages
'accesskey-blockip-block'               => 's', # do not translate or duplicate this message to other languages
'accesskey-export'                      => 's', # do not translate or duplicate this message to other languages
'accesskey-import'                      => 's', # do not translate or duplicate this message to other languages
'accesskey-watchlistedit-normal-submit' => 's', # do not translate or duplicate this message to other languages
'accesskey-watchlistedit-raw-submit'    => 's', # do not translate or duplicate this message to other languages

# Tooltip help for the actions
'tooltip-pt-userpage'                 => 'Your user page',
'tooltip-pt-anonuserpage'             => 'The user page for the IP address you are editing as',
'tooltip-pt-mytalk'                   => 'Your talk page',
'tooltip-pt-anontalk'                 => 'Discussion about edits from this IP address',
'tooltip-pt-preferences'              => 'Your preferences',
'tooltip-pt-watchlist'                => 'A list of pages you are monitoring for changes',
'tooltip-pt-mycontris'                => 'A list of your contributions',
'tooltip-pt-login'                    => 'You are encouraged to log in; however, it is not mandatory',
'tooltip-pt-anonlogin'                => 'You are encouraged to log in; however, it is not mandatory',
'tooltip-pt-logout'                   => 'Log out',
'tooltip-ca-talk'                     => 'Discussion about the content page',
'tooltip-ca-edit'                     => 'You can edit this page. Please use the preview button before saving',
'tooltip-ca-addsection'               => 'Start a new section',
'tooltip-ca-viewsource'               => 'This page is protected.
You can view its source',
'tooltip-ca-history'                  => 'Past revisions of this page',
'tooltip-ca-protect'                  => 'Protect this page',
'tooltip-ca-unprotect'                => 'Change protection of this page',
'tooltip-ca-delete'                   => 'Delete this page',
'tooltip-ca-undelete'                 => 'Restore the edits done to this page before it was deleted',
'tooltip-ca-move'                     => 'Move this page',
'tooltip-ca-watch'                    => 'Add this page to your watchlist',
'tooltip-ca-unwatch'                  => 'Remove this page from your watchlist',
'tooltip-search'                      => 'Search {{SITENAME}}',
'tooltip-search-go'                   => 'Go to a page with this exact name if exists',
'tooltip-search-fulltext'             => 'Search the pages for this text',
'tooltip-p-logo'                      => 'Visit the main page',
'tooltip-n-mainpage'                  => 'Visit the main page',
'tooltip-n-mainpage-description'      => 'Visit the main page',
'tooltip-n-portal'                    => 'About the project, what you can do, where to find things',
'tooltip-n-currentevents'             => 'Find background information on current events',
'tooltip-n-recentchanges'             => 'A list of recent changes in the wiki',
'tooltip-n-randompage'                => 'Load a random page',
'tooltip-n-help'                      => 'The place to find out',
'tooltip-t-whatlinkshere'             => 'A list of all wiki pages that link here',
'tooltip-t-recentchangeslinked'       => 'Recent changes in pages linked from this page',
'tooltip-feed-rss'                    => 'RSS feed for this page',
'tooltip-feed-atom'                   => 'Atom feed for this page',
'tooltip-t-contributions'             => 'A list of contributions of this user',
'tooltip-t-emailuser'                 => 'Send an e-mail to this user',
'tooltip-t-upload'                    => 'Upload files',
'tooltip-t-specialpages'              => 'A list of all special pages',
'tooltip-t-print'                     => 'Printable version of this page',
'tooltip-t-permalink'                 => 'Permanent link to this revision of the page',
'tooltip-ca-nstab-main'               => 'View the content page',
'tooltip-ca-nstab-user'               => 'View the user page',
'tooltip-ca-nstab-media'              => 'View the media page',
'tooltip-ca-nstab-special'            => 'This is a special page, you cannot edit the page itself',
'tooltip-ca-nstab-project'            => 'View the project page',
'tooltip-ca-nstab-image'              => 'View the file page',
'tooltip-ca-nstab-mediawiki'          => 'View the system message',
'tooltip-ca-nstab-template'           => 'View the template',
'tooltip-ca-nstab-help'               => 'View the help page',
'tooltip-ca-nstab-category'           => 'View the category page',
'tooltip-minoredit'                   => 'Mark this as a minor edit',
'tooltip-save'                        => 'Save your changes',
'tooltip-preview'                     => 'Preview your changes, please use this before saving!',
'tooltip-diff'                        => 'Show which changes you made to the text',
'tooltip-compareselectedversions'     => 'See the differences between the two selected revisions of this page',
'tooltip-watch'                       => 'Add this page to your watchlist',
'tooltip-watchlistedit-normal-submit' => 'Remove titles',
'tooltip-watchlistedit-raw-submit'    => 'Update watchlist',
'tooltip-recreate'                    => 'Recreate the page even though it has been deleted',
'tooltip-upload'                      => 'Start upload',
'tooltip-rollback'                    => '"Rollback" reverts edit(s) to this page of the last contributor in one click',
'tooltip-undo'                        => '"Undo" reverts this edit and opens the edit form in preview mode. It allows adding a reason in the summary.',
'tooltip-preferences-save'            => 'Save preferences',
'tooltip-summary'                     => 'Enter a short summary',

# Stylesheets
'common.css'              => '/* CSS placed here will be applied to all skins */', # only translate this message to other languages if you have to change it
'standard.css'            => '/* CSS placed here will affect users of the Standard skin */', # only translate this message to other languages if you have to change it
'nostalgia.css'           => '/* CSS placed here will affect users of the Nostalgia skin */', # only translate this message to other languages if you have to change it
'cologneblue.css'         => '/* CSS placed here will affect users of the Cologne Blue skin */', # only translate this message to other languages if you have to change it
'monobook.css'            => '/* CSS placed here will affect users of the MonoBook skin */', # only translate this message to other languages if you have to change it
'myskin.css'              => '/* CSS placed here will affect users of the MySkin skin */', # only translate this message to other languages if you have to change it
'chick.css'               => '/* CSS placed here will affect users of the Chick skin */', # only translate this message to other languages if you have to change it
'simple.css'              => '/* CSS placed here will affect users of the Simple skin */', # only translate this message to other languages if you have to change it
'modern.css'              => '/* CSS placed here will affect users of the Modern skin */', # only translate this message to other languages if you have to change it
'vector.css'              => '/* CSS placed here will affect users of the Vector skin */', # only translate this message to other languages if you have to change it
'print.css'               => '/* CSS placed here will affect the print output */', # only translate this message to other languages if you have to change it
'handheld.css'            => '/* CSS placed here will affect handheld devices based on the skin configured in $wgHandheldStyle */', # only translate this message to other languages if you have to change it
'noscript.css'            => '/* CSS placed here will affect users with JavaScript disabled */', # only translate this message to other languages if you have to change it
'group-autoconfirmed.css' => '/* CSS placed here will affect autoconfirmed users only */', # only translate this message to other languages if you have to change it
'group-bot.css'           => '/* CSS placed here will affect bots only */', # only translate this message to other languages if you have to change it
'group-sysop.css'         => '/* CSS placed here will affect sysops only */', # only translate this message to other languages if you have to change it
'group-bureaucrat.css'    => '/* CSS placed here will affect bureaucrats only */', # only translate this message to other languages if you have to change it

# Scripts
'common.js'              => '/* Any JavaScript here will be loaded for all users on every page load. */', # only translate this message to other languages if you have to change it
'standard.js'            => '/* Any JavaScript here will be loaded for users using the Standard skin */', # only translate this message to other languages if you have to change it
'nostalgia.js'           => '/* Any JavaScript here will be loaded for users using the Nostalgia skin */', # only translate this message to other languages if you have to change it
'cologneblue.js'         => '/* Any JavaScript here will be loaded for users using the Cologne Blue skin */', # only translate this message to other languages if you have to change it
'monobook.js'            => '/* Any JavaScript here will be loaded for users using the MonoBook skin */', # only translate this message to other languages if you have to change it
'myskin.js'              => '/* Any JavaScript here will be loaded for users using the MySkin skin */', # only translate this message to other languages if you have to change it
'chick.js'               => '/* Any JavaScript here will be loaded for users using the Chick skin */', # only translate this message to other languages if you have to change it
'simple.js'              => '/* Any JavaScript here will be loaded for users using the Simple skin */', # only translate this message to other languages if you have to change it
'modern.js'              => '/* Any JavaScript here will be loaded for users using the Modern skin */', # only translate this message to other languages if you have to change it
'vector.js'              => '/* Any JavaScript here will be loaded for users using the Vector skin */', # only translate this message to other languages if you have to change it
'group-autoconfirmed.js' => '/* Any JavaScript here will be loaded for autoconfirmed users only */', # only translate this message to other languages if you have to change it
'group-bot.js'           => '/* Any JavaScript here will be loaded for bots only */', # only translate this message to other languages if you have to change it
'group-sysop.js'         => '/* Any JavaScript here will be loaded for sysops only */', # only translate this message to other languages if you have to change it
'group-bureaucrat.js'    => '/* Any JavaScript here will be loaded for bureaucrats only */', # only translate this message to other languages if you have to change it

# Metadata
'notacceptable' => 'The wiki server cannot provide data in a format your client can read.',

# Attribution
'anonymous'        => 'Anonymous {{PLURAL:$1|user|users}} of {{SITENAME}}',
'siteuser'         => '{{SITENAME}} user $1',
'anonuser'         => '{{SITENAME}} anonymous user $1',
'lastmodifiedatby' => 'This page was last modified $2, $1 by $3.',
'othercontribs'    => 'Based on work by $1.',
'others'           => 'others',
'siteusers'        => '{{SITENAME}} {{PLURAL:$2|user|users}} $1',
'anonusers'        => '{{SITENAME}} anonymous {{PLURAL:$2|user|users}} $1',
'creditspage'      => 'Page credits',
'nocredits'        => 'There is no credits info available for this page.',

# Spam protection
'spamprotectiontitle' => 'Spam protection filter',
'spamprotectiontext'  => 'The text you wanted to save was blocked by the spam filter.
This is probably caused by a link to a blacklisted external site.',
'spamprotectionmatch' => 'The following text is what triggered our spam filter: $1',
'spambot_username'    => 'MediaWiki spam cleanup',
'spam_reverting'      => 'Reverting to last revision not containing links to $1',
'spam_blanking'       => 'All revisions contained links to $1, blanking',
'spam_deleting'       => 'All revisions contained links to $1, deleting',

# Info page
'pageinfo-header'              => '-', # do not translate or duplicate this message to other languages
'pageinfo-title'               => 'Information for "$1"',
'pageinfo-not-current'         => "Sorry, it's impossible to provide this information for old revisions.",
'pageinfo-header-basic'        => 'Basic information',
'pageinfo-header-edits'        => 'Edit history',
'pageinfo-header-restrictions' => 'Page protection',
'pageinfo-header-properties'   => 'Page properties',
'pageinfo-display-title'       => 'Display title',
'pageinfo-default-sort'        => 'Default sort key',
'pageinfo-length'              => 'Page length (in bytes)',
'pageinfo-article-id'          => 'Page ID',
'pageinfo-robot-policy'        => 'Search engine status',
'pageinfo-robot-index'         => 'Indexable',
'pageinfo-robot-noindex'       => 'Not indexable',
'pageinfo-views'               => 'Number of views',
'pageinfo-watchers'            => 'Number of page watchers',
'pageinfo-redirects-name'      => 'Redirects to this page',
'pageinfo-redirects-value'     => '$1', # only translate this message to other languages if you have to change it
'pageinfo-subpages-name'       => 'Subpages of this page',
'pageinfo-subpages-value'      => '$1 ($2 {{PLURAL:$2|redirect|redirects}}; $3 {{PLURAL:$3|non-redirect|non-redirects}})',
'pageinfo-firstuser'           => 'Page creator',
'pageinfo-firsttime'           => 'Date of page creation',
'pageinfo-lastuser'            => 'Latest editor',
'pageinfo-lasttime'            => 'Date of latest edit',
'pageinfo-edits'               => 'Total number of edits',
'pageinfo-authors'             => 'Total number of distinct authors',
'pageinfo-recent-edits'        => 'Recent number of edits (within past $1)',
'pageinfo-recent-authors'      => 'Recent number of distinct authors',
'pageinfo-magic-words'         => 'Magic {{PLURAL:$1|word|words}} ($1)',
'pageinfo-hidden-categories'   => 'Hidden {{PLURAL:$1|category|categories}} ($1)',
'pageinfo-templates'           => 'Transcluded {{PLURAL:$1|template|templates}} ($1)',
'pageinfo-footer'              => '-', # do not translate or duplicate this message to other languages

# Skin names
'skinname-standard'    => 'Classic', # only translate this message to other languages if you have to change it
'skinname-nostalgia'   => 'Nostalgia', # only translate this message to other languages if you have to change it
'skinname-cologneblue' => 'Cologne Blue', # only translate this message to other languages if you have to change it
'skinname-monobook'    => 'MonoBook', # only translate this message to other languages if you have to change it
'skinname-myskin'      => 'MySkin', # only translate this message to other languages if you have to change it
'skinname-chick'       => 'Chick', # only translate this message to other languages if you have to change it
'skinname-simple'      => 'Simple', # only translate this message to other languages if you have to change it
'skinname-modern'      => 'Modern', # only translate this message to other languages if you have to change it
'skinname-vector'      => 'Vector', # only translate this message to other languages if you have to change it

# Patrolling
'markaspatrolleddiff'                 => 'Mark as patrolled',
'markaspatrolledlink'                 => '[$1]', # do not translate or duplicate this message to other languages
'markaspatrolledtext'                 => 'Mark this page as patrolled',
'markedaspatrolled'                   => 'Marked as patrolled',
'markedaspatrolledtext'               => 'The selected revision of [[:$1]] has been marked as patrolled.',
'rcpatroldisabled'                    => 'Recent changes patrol disabled',
'rcpatroldisabledtext'                => 'The recent changes patrol feature is currently disabled.',
'markedaspatrollederror'              => 'Cannot mark as patrolled',
'markedaspatrollederrortext'          => 'You need to specify a revision to mark as patrolled.',
'markedaspatrollederror-noautopatrol' => 'You are not allowed to mark your own changes as patrolled.',

# Patrol log
'patrol-log-page'      => 'Patrol log',
'patrol-log-header'    => 'This is a log of patrolled revisions.',
'log-show-hide-patrol' => '$1 patrol log',

# Image deletion
'deletedrevision'                 => 'Deleted old revision $1',
'filedeleteerror-short'           => 'Error deleting file: $1',
'filedeleteerror-long'            => 'Errors were encountered while deleting the file:

$1',
'filedelete-missing'              => 'The file "$1" cannot be deleted because it does not exist.',
'filedelete-old-unregistered'     => 'The specified file revision "$1" is not in the database.',
'filedelete-current-unregistered' => 'The specified file "$1" is not in the database.',
'filedelete-archive-read-only'    => 'The archive directory "$1" is not writable by the webserver.',

# Browsing diffs
'previousdiff' => '← Older edit',
'nextdiff'     => 'Newer edit →',

# Media information
'mediawarning'                => "'''Warning''': This file type may contain malicious code.
By executing it, your system may be compromised.",
'imagemaxsize'                => "Image size limit:<br />''(for file description pages)''",
'thumbsize'                   => 'Thumbnail size:',
'widthheight'                 => '$1 × $2', # only translate this message to other languages if you have to change it
'widthheightpage'             => '$1 × $2, $3 {{PLURAL:$3|page|pages}}',
'file-info'                   => 'file size: $1, MIME type: $2',
'file-info-size'              => '$1 × $2 pixels, file size: $3, MIME type: $4',
'file-info-size-pages'        => '$1 × $2 pixels, file size: $3, MIME type: $4, $5 {{PLURAL:$5|page|pages}}',
'file-nohires'                => 'No higher resolution available.',
'svg-long-desc'               => 'SVG file, nominally $1 × $2 pixels, file size: $3',
'svg-long-desc-animated'      => 'Animated SVG file, nominally $1 × $2 pixels, file size: $3',
'show-big-image'              => 'Full resolution',
'show-big-image-preview'      => 'Size of this preview: $1.',
'show-big-image-other'        => 'Other {{PLURAL:$2|resolution|resolutions}}: $1.',
'show-big-image-size'         => '$1 × $2 pixels',
'file-info-gif-looped'        => 'looped',
'file-info-gif-frames'        => '$1 {{PLURAL:$1|frame|frames}}',
'file-info-png-looped'        => 'looped',
'file-info-png-repeat'        => 'played $1 {{PLURAL:$1|time|times}}',
'file-info-png-frames'        => '$1 {{PLURAL:$1|frame|frames}}',
'file-no-thumb-animation'     => "'''Note: Due to technical limitations, thumbnails of this file will not be animated.'''",
'file-no-thumb-animation-gif' => "'''Note: Due to technical limitations, thumbnails of high resolution GIF images such as this one will not be animated.'''",

# Special:NewFiles
'newimages'             => 'Gallery of new files',
'imagelisttext'         => "Below is a list of '''$1''' {{PLURAL:$1|file|files}} sorted $2.",
'newimages-summary'     => 'This special page shows the last uploaded files.',
'newimages-legend'      => 'Filter',
'newimages-label'       => 'Filename (or a part of it):',
'showhidebots'          => '($1 bots)',
'noimages'              => 'Nothing to see.',
'ilsubmit'              => 'Search',
'bydate'                => 'by date',
'sp-newimages-showfrom' => 'Show new files starting from $2, $1',

# Video information, used by Language::formatTimePeriod() to format lengths in the above messages
'video-dims'     => '$1, $2 × $3', # only translate this message to other languages if you have to change it
'seconds-abbrev' => '$1 s', # only translate this message to other languages if you have to change it
'minutes-abbrev' => '$1 min', # only translate this message to other languages if you have to change it
'hours-abbrev'   => '$1 h', # only translate this message to other languages if you have to change it
'days-abbrev'    => '$1 d', # only translate this message to other languages if you have to change it
'seconds'        => '{{PLURAL:$1|$1 second|$1 seconds}}',
'minutes'        => '{{PLURAL:$1|$1 minute|$1 minutes}}',
'hours'          => '{{PLURAL:$1|$1 hour|$1 hours}}',
'days'           => '{{PLURAL:$1|$1 day|$1 days}}',
'ago'            => '$1 ago',

# Bad image list
'bad_image_list' => 'The format is as follows:

Only list items (lines starting with *) are considered.
The first link on a line must be a link to a bad file.
Any subsequent links on the same line are considered to be exceptions, i.e. pages where the file may occur inline.',

/*
Short names for language variants used for language conversion links.
To disable showing a particular link, set it to 'disable', e.g.
'variantname-zh-sg' => 'disable',
Variants for Chinese language
*/
'variantname-zh-hans' => 'hans', # only translate this message to other languages if you have to change it
'variantname-zh-hant' => 'hant', # only translate this message to other languages if you have to change it
'variantname-zh-cn'   => 'cn', # only translate this message to other languages if you have to change it
'variantname-zh-tw'   => 'tw', # only translate this message to other languages if you have to change it
'variantname-zh-hk'   => 'hk', # only translate this message to other languages if you have to change it
'variantname-zh-mo'   => 'mo', # only translate this message to other languages if you have to change it
'variantname-zh-sg'   => 'sg', # only translate this message to other languages if you have to change it
'variantname-zh-my'   => 'my', # only translate this message to other languages if you have to change it
'variantname-zh'      => 'zh', # only translate this message to other languages if you have to change it

# Variants for Gan language
'variantname-gan-hans' => 'hans', # only translate this message to other languages if you have to change it
'variantname-gan-hant' => 'hant', # only translate this message to other languages if you have to change it
'variantname-gan'      => 'gan', # only translate this message to other languages if you have to change it

# Variants for Serbian language
'variantname-sr-ec' => 'sr-ec', # only translate this message to other languages if you have to change it
'variantname-sr-el' => 'sr-el', # only translate this message to other languages if you have to change it
'variantname-sr'    => 'sr', # only translate this message to other languages if you have to change it

# Variants for Kazakh language
'variantname-kk-kz'   => 'kk-kz', # only translate this message to other languages if you have to change it
'variantname-kk-tr'   => 'kk-tr', # only translate this message to other languages if you have to change it
'variantname-kk-cn'   => 'kk-cn', # only translate this message to other languages if you have to change it
'variantname-kk-cyrl' => 'kk-cyrl', # only translate this message to other languages if you have to change it
'variantname-kk-latn' => 'kk-latn', # only translate this message to other languages if you have to change it
'variantname-kk-arab' => 'kk-arab', # only translate this message to other languages if you have to change it
'variantname-kk'      => 'kk', # only translate this message to other languages if you have to change it

# Variants for Kurdish language
'variantname-ku-arab' => 'ku-Arab', # only translate this message to other languages if you have to change it
'variantname-ku-latn' => 'ku-Latn', # only translate this message to other languages if you have to change it
'variantname-ku'      => 'ku', # only translate this message to other languages if you have to change it

# Variants for Tajiki language
'variantname-tg-cyrl' => 'tg-Cyrl', # only translate this message to other languages if you have to change it
'variantname-tg-latn' => 'tg-Latn', # only translate this message to other languages if you have to change it
'variantname-tg'      => 'tg', # only translate this message to other languages if you have to change it

# Variants for Inuktitut language
'variantname-ike-cans' => 'ike-Cans', # only translate this message to other languages if you have to change it
'variantname-ike-latn' => 'ike-Latn', # only translate this message to other languages if you have to change it
'variantname-iu'       => 'iu', # only translate this message to other languages if you have to change it

# Variants for Tachelhit language
'variantname-shi-tfng' => 'shi-Tfng', # only translate this message to other languages if you have to change it
'variantname-shi-latn' => 'shi-Latn', # only translate this message to other languages if you have to change it
'variantname-shi'      => 'shi', # only translate this message to other languages if you have to change it

# Metadata
'metadata'                  => 'Metadata',
'metadata-help'             => 'This file contains additional information, probably added from the digital camera or scanner used to create or digitize it.
If the file has been modified from its original state, some details may not fully reflect the modified file.',
'metadata-expand'           => 'Show extended details',
'metadata-collapse'         => 'Hide extended details',
'metadata-fields'           => 'Image metadata fields listed in this message will be included on image page display when the metadata table is collapsed.
Others will be hidden by default.
* make
* model
* datetimeoriginal
* exposuretime
* fnumber
* isospeedratings
* focallength
* artist
* copyright
* imagedescription
* gpslatitude
* gpslongitude
* gpsaltitude',
'metadata-langitem'         => "'''$2:''' $1", # only translate this message to other languages if you have to change it
'metadata-langitem-default' => '$1', # only translate this message to other languages if you have to change it

# EXIF tags
'exif-imagewidth'                  => 'Width',
'exif-imagelength'                 => 'Height',
'exif-bitspersample'               => 'Bits per component',
'exif-compression'                 => 'Compression scheme',
'exif-photometricinterpretation'   => 'Pixel composition',
'exif-orientation'                 => 'Orientation',
'exif-samplesperpixel'             => 'Number of components',
'exif-planarconfiguration'         => 'Data arrangement',
'exif-ycbcrsubsampling'            => 'Subsampling ratio of Y to C',
'exif-ycbcrpositioning'            => 'Y and C positioning',
'exif-xresolution'                 => 'Horizontal resolution',
'exif-yresolution'                 => 'Vertical resolution',
'exif-stripoffsets'                => 'Image data location',
'exif-rowsperstrip'                => 'Number of rows per strip',
'exif-stripbytecounts'             => 'Bytes per compressed strip',
'exif-jpeginterchangeformat'       => 'Offset to JPEG SOI',
'exif-jpeginterchangeformatlength' => 'Bytes of JPEG data',
'exif-whitepoint'                  => 'White point chromaticity',
'exif-primarychromaticities'       => 'Chromaticities of primarities',
'exif-ycbcrcoefficients'           => 'Color space transformation matrix coefficients',
'exif-referenceblackwhite'         => 'Pair of black and white reference values',
'exif-datetime'                    => 'File change date and time',
'exif-imagedescription'            => 'Image title',
'exif-make'                        => 'Camera manufacturer',
'exif-model'                       => 'Camera model',
'exif-software'                    => 'Software used',
'exif-artist'                      => 'Author',
'exif-copyright'                   => 'Copyright holder',
'exif-exifversion'                 => 'Exif version',
'exif-flashpixversion'             => 'Supported Flashpix version',
'exif-colorspace'                  => 'Color space',
'exif-componentsconfiguration'     => 'Meaning of each component',
'exif-compressedbitsperpixel'      => 'Image compression mode',
'exif-pixelydimension'             => 'Image width',
'exif-pixelxdimension'             => 'Image height',
'exif-usercomment'                 => 'User comments',
'exif-relatedsoundfile'            => 'Related audio file',
'exif-datetimeoriginal'            => 'Date and time of data generation',
'exif-datetimedigitized'           => 'Date and time of digitizing',
'exif-subsectime'                  => 'DateTime subseconds',
'exif-subsectimeoriginal'          => 'DateTimeOriginal subseconds',
'exif-subsectimedigitized'         => 'DateTimeDigitized subseconds',
'exif-exposuretime'                => 'Exposure time',
'exif-exposuretime-format'         => '$1 sec ($2)',
'exif-fnumber'                     => 'F Number',
'exif-fnumber-format'              => 'f/$1', # only translate this message to other languages if you have to change it
'exif-exposureprogram'             => 'Exposure Program',
'exif-spectralsensitivity'         => 'Spectral sensitivity',
'exif-isospeedratings'             => 'ISO speed rating',
'exif-shutterspeedvalue'           => 'APEX shutter speed',
'exif-aperturevalue'               => 'APEX aperture',
'exif-brightnessvalue'             => 'APEX brightness',
'exif-exposurebiasvalue'           => 'APEX exposure bias',
'exif-maxaperturevalue'            => 'Maximum land aperture',
'exif-subjectdistance'             => 'Subject distance',
'exif-meteringmode'                => 'Metering mode',
'exif-lightsource'                 => 'Light source',
'exif-flash'                       => 'Flash',
'exif-focallength'                 => 'Lens focal length',
'exif-focallength-format'          => '$1 mm', # only translate this message to other languages if you have to change it
'exif-subjectarea'                 => 'Subject area',
'exif-flashenergy'                 => 'Flash energy',
'exif-focalplanexresolution'       => 'Focal plane X resolution',
'exif-focalplaneyresolution'       => 'Focal plane Y resolution',
'exif-focalplaneresolutionunit'    => 'Focal plane resolution unit',
'exif-subjectlocation'             => 'Subject location',
'exif-exposureindex'               => 'Exposure index',
'exif-sensingmethod'               => 'Sensing method',
'exif-filesource'                  => 'File source',
'exif-scenetype'                   => 'Scene type',
'exif-customrendered'              => 'Custom image processing',
'exif-exposuremode'                => 'Exposure mode',
'exif-whitebalance'                => 'White balance',
'exif-digitalzoomratio'            => 'Digital zoom ratio',
'exif-focallengthin35mmfilm'       => 'Focal length in 35 mm film',
'exif-scenecapturetype'            => 'Scene capture type',
'exif-gaincontrol'                 => 'Scene control',
'exif-contrast'                    => 'Contrast',
'exif-saturation'                  => 'Saturation',
'exif-sharpness'                   => 'Sharpness',
'exif-devicesettingdescription'    => 'Device settings description',
'exif-subjectdistancerange'        => 'Subject distance range',
'exif-imageuniqueid'               => 'Unique image ID',
'exif-gpsversionid'                => 'GPS tag version',
'exif-gpslatituderef'              => 'North or south latitude',
'exif-gpslatitude'                 => 'Latitude',
'exif-gpslongituderef'             => 'East or west longitude',
'exif-gpslongitude'                => 'Longitude',
'exif-gpsaltituderef'              => 'Altitude reference',
'exif-gpsaltitude'                 => 'Altitude',
'exif-gpstimestamp'                => 'GPS time (atomic clock)',
'exif-gpssatellites'               => 'Satellites used for measurement',
'exif-gpsstatus'                   => 'Receiver status',
'exif-gpsmeasuremode'              => 'Measurement mode',
'exif-gpsdop'                      => 'Measurement precision',
'exif-gpsspeedref'                 => 'Speed unit',
'exif-gpsspeed'                    => 'Speed of GPS receiver',
'exif-gpstrackref'                 => 'Reference for direction of movement',
'exif-gpstrack'                    => 'Direction of movement',
'exif-gpsimgdirectionref'          => 'Reference for direction of image',
'exif-gpsimgdirection'             => 'Direction of image',
'exif-gpsmapdatum'                 => 'Geodetic survey data used',
'exif-gpsdestlatituderef'          => 'Reference for latitude of destination',
'exif-gpsdestlatitude'             => 'Latitude destination',
'exif-gpsdestlongituderef'         => 'Reference for longitude of destination',
'exif-gpsdestlongitude'            => 'Longitude of destination',
'exif-gpsdestbearingref'           => 'Reference for bearing of destination',
'exif-gpsdestbearing'              => 'Bearing of destination',
'exif-gpsdestdistanceref'          => 'Reference for distance to destination',
'exif-gpsdestdistance'             => 'Distance to destination',
'exif-gpsprocessingmethod'         => 'Name of GPS processing method',
'exif-gpsareainformation'          => 'Name of GPS area',
'exif-gpsdatestamp'                => 'GPS date',
'exif-gpsdifferential'             => 'GPS differential correction',
'exif-coordinate-format'           => '$1° $2′ $3″ $4', # only translate this message to other languages if you have to change it
'exif-jpegfilecomment'             => 'JPEG file comment',
'exif-keywords'                    => 'Keywords',
'exif-worldregioncreated'          => 'World region that the picture was taken in',
'exif-countrycreated'              => 'Country that the picture was taken in',
'exif-countrycodecreated'          => 'Code for the country that the picture was taken in',
'exif-provinceorstatecreated'      => 'Province or state that the picture was taken in',
'exif-citycreated'                 => 'City that the picture was taken in',
'exif-sublocationcreated'          => 'Sublocation of the city that the picture was taken in',
'exif-worldregiondest'             => 'World region shown',
'exif-countrydest'                 => 'Country shown',
'exif-countrycodedest'             => 'Code for country shown',
'exif-provinceorstatedest'         => 'Province or state shown',
'exif-citydest'                    => 'City shown',
'exif-sublocationdest'             => 'Sublocation of city shown',
'exif-objectname'                  => 'Short title',
'exif-specialinstructions'         => 'Special instructions',
'exif-headline'                    => 'Headline',
'exif-credit'                      => 'Credit/Provider',
'exif-source'                      => 'Source',
'exif-editstatus'                  => 'Editorial status of image',
'exif-urgency'                     => 'Urgency',
'exif-fixtureidentifier'           => 'Fixture name',
'exif-locationdest'                => 'Location depicted',
'exif-locationdestcode'            => 'Code of location depicted',
'exif-objectcycle'                 => 'Time of day that media is intended for',
'exif-contact'                     => 'Contact information',
'exif-writer'                      => 'Writer',
'exif-languagecode'                => 'Language',
'exif-iimversion'                  => 'IIM version',
'exif-iimcategory'                 => 'Category',
'exif-iimsupplementalcategory'     => 'Supplemental categories',
'exif-datetimeexpires'             => 'Do not use after',
'exif-datetimereleased'            => 'Released on',
'exif-originaltransmissionref'     => 'Original transmission location code',
'exif-identifier'                  => 'Identifier',
'exif-lens'                        => 'Lens used',
'exif-serialnumber'                => 'Serial number of camera',
'exif-cameraownername'             => 'Owner of camera',
'exif-label'                       => 'Label',
'exif-datetimemetadata'            => 'Date metadata was last modified',
'exif-nickname'                    => 'Informal name of image',
'exif-rating'                      => 'Rating (out of 5)',
'exif-rightscertificate'           => 'Rights management certificate',
'exif-copyrighted'                 => 'Copyright status',
'exif-copyrightowner'              => 'Copyright owner',
'exif-usageterms'                  => 'Usage terms',
'exif-webstatement'                => 'Online copyright statement',
'exif-originaldocumentid'          => 'Unique ID of original document',
'exif-licenseurl'                  => 'URL for copyright license',
'exif-morepermissionsurl'          => 'Alternative licensing information',
'exif-attributionurl'              => 'When re-using this work, please link to',
'exif-preferredattributionname'    => 'When re-using this work, please credit',
'exif-pngfilecomment'              => 'PNG file comment',
'exif-disclaimer'                  => 'Disclaimer',
'exif-contentwarning'              => 'Content warning',
'exif-giffilecomment'              => 'GIF file comment',
'exif-intellectualgenre'           => 'Type of item',
'exif-subjectnewscode'             => 'Subject code',
'exif-scenecode'                   => 'IPTC scene code',
'exif-event'                       => 'Event depicted',
'exif-organisationinimage'         => 'Organization depicted',
'exif-personinimage'               => 'Person depicted',
'exif-originalimageheight'         => 'Height of image before it was cropped',
'exif-originalimagewidth'          => 'Width of image before it was cropped',

# Make & model, can be wikified in order to link to the camera and model name
'exif-make-value'             => '$1', # do not translate or duplicate this message to other languages
'exif-model-value'            => '$1', # do not translate or duplicate this message to other languages
'exif-software-value'         => '$1', # do not translate or duplicate this message to other languages
'exif-software-version-value' => '$1 (Version $2)', # do not translate or duplicate this message to other languages
'exif-contact-value'          => '$1

$2
<div class="adr">
$3

$4, $5, $6 $7
</div>
$8', # only translate this message to other languages if you have to change it
'exif-subjectnewscode-value'  => '$2 ($1)', # only translate this message to other languages if you have to change it

# EXIF attributes
'exif-compression-1'     => 'Uncompressed',
'exif-compression-2'     => 'CCITT Group 3 1-Dimensional Modified Huffman run length encoding',
'exif-compression-3'     => 'CCITT Group 3 fax encoding',
'exif-compression-4'     => 'CCITT Group 4 fax encoding',
'exif-compression-5'     => 'LZW', # only translate this message to other languages if you have to change it
'exif-compression-6'     => 'JPEG (old)', # only translate this message to other languages if you have to change it
'exif-compression-7'     => 'JPEG', # only translate this message to other languages if you have to change it
'exif-compression-8'     => 'Deflate (Adobe)', # only translate this message to other languages if you have to change it
'exif-compression-32773' => 'PackBits (Macintosh RLE)', # only translate this message to other languages if you have to change it
'exif-compression-32946' => 'Deflate (PKZIP)', # only translate this message to other languages if you have to change it
'exif-compression-34712' => 'JPEG2000', # only translate this message to other languages if you have to change it

'exif-copyrighted-true'  => 'Copyrighted',
'exif-copyrighted-false' => 'Public domain',

'exif-photometricinterpretation-2' => 'RGB', # only translate this message to other languages if you have to change it
'exif-photometricinterpretation-6' => 'YCbCr', # only translate this message to other languages if you have to change it

'exif-unknowndate' => 'Unknown date',

'exif-orientation-1' => 'Normal',
'exif-orientation-2' => 'Flipped horizontally',
'exif-orientation-3' => 'Rotated 180°',
'exif-orientation-4' => 'Flipped vertically',
'exif-orientation-5' => 'Rotated 90° CCW and flipped vertically',
'exif-orientation-6' => 'Rotated 90° CCW',
'exif-orientation-7' => 'Rotated 90° CW and flipped vertically',
'exif-orientation-8' => 'Rotated 90° CW',

'exif-planarconfiguration-1' => 'chunky format',
'exif-planarconfiguration-2' => 'planar format',

'exif-xyresolution-i' => '$1 dpi', # only translate this message to other languages if you have to change it
'exif-xyresolution-c' => '$1 dpc', # only translate this message to other languages if you have to change it

'exif-colorspace-1'     => 'sRGB', # only translate this message to other languages if you have to change it
'exif-colorspace-65535' => 'Uncalibrated',

'exif-componentsconfiguration-0' => 'does not exist',
'exif-componentsconfiguration-1' => 'Y', # only translate this message to other languages if you have to change it
'exif-componentsconfiguration-2' => 'Cb', # only translate this message to other languages if you have to change it
'exif-componentsconfiguration-3' => 'Cr', # only translate this message to other languages if you have to change it
'exif-componentsconfiguration-4' => 'R', # only translate this message to other languages if you have to change it
'exif-componentsconfiguration-5' => 'G', # only translate this message to other languages if you have to change it
'exif-componentsconfiguration-6' => 'B', # only translate this message to other languages if you have to change it

'exif-exposureprogram-0' => 'Not defined',
'exif-exposureprogram-1' => 'Manual',
'exif-exposureprogram-2' => 'Normal program',
'exif-exposureprogram-3' => 'Aperture priority',
'exif-exposureprogram-4' => 'Shutter priority',
'exif-exposureprogram-5' => 'Creative program (biased toward depth of field)',
'exif-exposureprogram-6' => 'Action program (biased toward fast shutter speed)',
'exif-exposureprogram-7' => 'Portrait mode (for closeup photos with the background out of focus)',
'exif-exposureprogram-8' => 'Landscape mode (for landscape photos with the background in focus)',

'exif-subjectdistance-value' => '$1 meters',

'exif-meteringmode-0'   => 'Unknown',
'exif-meteringmode-1'   => 'Average',
'exif-meteringmode-2'   => 'Center weighted average',
'exif-meteringmode-3'   => 'Spot',
'exif-meteringmode-4'   => 'Multi-Spot',
'exif-meteringmode-5'   => 'Pattern',
'exif-meteringmode-6'   => 'Partial',
'exif-meteringmode-255' => 'Other',

'exif-lightsource-0'   => 'Unknown',
'exif-lightsource-1'   => 'Daylight',
'exif-lightsource-2'   => 'Fluorescent',
'exif-lightsource-3'   => 'Tungsten (incandescent light)',
'exif-lightsource-4'   => 'Flash',
'exif-lightsource-9'   => 'Fine weather',
'exif-lightsource-10'  => 'Cloudy weather',
'exif-lightsource-11'  => 'Shade',
'exif-lightsource-12'  => 'Daylight fluorescent (D 5700 – 7100K)',
'exif-lightsource-13'  => 'Day white fluorescent (N 4600 – 5400K)',
'exif-lightsource-14'  => 'Cool white fluorescent (W 3900 – 4500K)',
'exif-lightsource-15'  => 'White fluorescent (WW 3200 – 3700K)',
'exif-lightsource-17'  => 'Standard light A',
'exif-lightsource-18'  => 'Standard light B',
'exif-lightsource-19'  => 'Standard light C',
'exif-lightsource-20'  => 'D55', # only translate this message to other languages if you have to change it
'exif-lightsource-21'  => 'D65', # only translate this message to other languages if you have to change it
'exif-lightsource-22'  => 'D75', # only translate this message to other languages if you have to change it
'exif-lightsource-23'  => 'D50', # only translate this message to other languages if you have to change it
'exif-lightsource-24'  => 'ISO studio tungsten',
'exif-lightsource-255' => 'Other light source',

# Flash modes
'exif-flash-fired-0'    => 'Flash did not fire',
'exif-flash-fired-1'    => 'Flash fired',
'exif-flash-return-0'   => 'no strobe return detection function',
'exif-flash-return-2'   => 'strobe return light not detected',
'exif-flash-return-3'   => 'strobe return light detected',
'exif-flash-mode-1'     => 'compulsory flash firing',
'exif-flash-mode-2'     => 'compulsory flash suppression',
'exif-flash-mode-3'     => 'auto mode',
'exif-flash-function-1' => 'No flash function',
'exif-flash-redeye-1'   => 'red-eye reduction mode',

'exif-focalplaneresolutionunit-2' => 'inches',

'exif-sensingmethod-1' => 'Undefined',
'exif-sensingmethod-2' => 'One-chip color area sensor',
'exif-sensingmethod-3' => 'Two-chip color area sensor',
'exif-sensingmethod-4' => 'Three-chip color area sensor',
'exif-sensingmethod-5' => 'Color sequential area sensor',
'exif-sensingmethod-7' => 'Trilinear sensor',
'exif-sensingmethod-8' => 'Color sequential linear sensor',

'exif-filesource-3' => 'Digital still camera',

'exif-scenetype-1' => 'A directly photographed image',

'exif-customrendered-0' => 'Normal process',
'exif-customrendered-1' => 'Custom process',

'exif-exposuremode-0' => 'Auto exposure',
'exif-exposuremode-1' => 'Manual exposure',
'exif-exposuremode-2' => 'Auto bracket',

'exif-whitebalance-0' => 'Auto white balance',
'exif-whitebalance-1' => 'Manual white balance',

'exif-scenecapturetype-0' => 'Standard',
'exif-scenecapturetype-1' => 'Landscape',
'exif-scenecapturetype-2' => 'Portrait',
'exif-scenecapturetype-3' => 'Night scene',

'exif-gaincontrol-0' => 'None',
'exif-gaincontrol-1' => 'Low gain up',
'exif-gaincontrol-2' => 'High gain up',
'exif-gaincontrol-3' => 'Low gain down',
'exif-gaincontrol-4' => 'High gain down',

'exif-contrast-0' => 'Normal',
'exif-contrast-1' => 'Soft',
'exif-contrast-2' => 'Hard',

'exif-saturation-0' => 'Normal',
'exif-saturation-1' => 'Low saturation',
'exif-saturation-2' => 'High saturation',

'exif-sharpness-0' => 'Normal',
'exif-sharpness-1' => 'Soft',
'exif-sharpness-2' => 'Hard',

'exif-subjectdistancerange-0' => 'Unknown',
'exif-subjectdistancerange-1' => 'Macro',
'exif-subjectdistancerange-2' => 'Close view',
'exif-subjectdistancerange-3' => 'Distant view',

# Pseudotags used for GPSLatitudeRef and GPSDestLatitudeRef
'exif-gpslatitude-n' => 'North latitude',
'exif-gpslatitude-s' => 'South latitude',

# Pseudotags used for GPSLongitudeRef and GPSDestLongitudeRef
'exif-gpslongitude-e' => 'East longitude',
'exif-gpslongitude-w' => 'West longitude',

# Pseudotags used for GPSAltitudeRef
'exif-gpsaltitude-above-sealevel' => '$1 {{PLURAL:$1|meter|meters}} above sea level',
'exif-gpsaltitude-below-sealevel' => '$1 {{PLURAL:$1|meter|meters}} below sea level',

'exif-gpsstatus-a' => 'Measurement in progress',
'exif-gpsstatus-v' => 'Measurement interoperability',

'exif-gpsmeasuremode-2' => '2-dimensional measurement',
'exif-gpsmeasuremode-3' => '3-dimensional measurement',

# Pseudotags used for GPSSpeedRef
'exif-gpsspeed-k' => 'Kilometers per hour',
'exif-gpsspeed-m' => 'Miles per hour',
'exif-gpsspeed-n' => 'Knots',

# Pseudotags used for GPSDestDistanceRef
'exif-gpsdestdistance-k' => 'Kilometers',
'exif-gpsdestdistance-m' => 'Miles',
'exif-gpsdestdistance-n' => 'Nautical miles',

'exif-gpsdop-excellent' => 'Excellent ($1)',
'exif-gpsdop-good'      => 'Good ($1)',
'exif-gpsdop-moderate'  => 'Moderate ($1)',
'exif-gpsdop-fair'      => 'Fair ($1)',
'exif-gpsdop-poor'      => 'Poor ($1)',

'exif-objectcycle-a' => 'Morning only',
'exif-objectcycle-p' => 'Evening only',
'exif-objectcycle-b' => 'Both morning and evening',

# Pseudotags used for GPSTrackRef, GPSImgDirectionRef and GPSDestBearingRef
'exif-gpsdirection-t' => 'True direction',
'exif-gpsdirection-m' => 'Magnetic direction',

'exif-ycbcrpositioning-1' => 'Centered',
'exif-ycbcrpositioning-2' => 'Co-sited',

'exif-dc-contributor' => 'Contributors',
'exif-dc-coverage'    => 'Spatial or temporal scope of media',
'exif-dc-date'        => 'Date(s)',
'exif-dc-publisher'   => 'Publisher',
'exif-dc-relation'    => 'Related media',
'exif-dc-rights'      => 'Rights',
'exif-dc-source'      => 'Source media',
'exif-dc-type'        => 'Type of media',

'exif-rating-rejected' => 'Rejected',

'exif-isospeedratings-overflow' => 'Greater than 65535',

'exif-maxaperturevalue-value' => '$1 APEX (f/$2)', # only translate this message to other languages if you have to change it

'exif-iimcategory-ace' => 'Arts, culture and entertainment',
'exif-iimcategory-clj' => 'Crime and law',
'exif-iimcategory-dis' => 'Disasters and accidents',
'exif-iimcategory-fin' => 'Economy and business',
'exif-iimcategory-edu' => 'Education',
'exif-iimcategory-evn' => 'Environment',
'exif-iimcategory-hth' => 'Health',
'exif-iimcategory-hum' => 'Human interest',
'exif-iimcategory-lab' => 'Labour',
'exif-iimcategory-lif' => 'Lifestyle and leisure',
'exif-iimcategory-pol' => 'Politics',
'exif-iimcategory-rel' => 'Religion and belief',
'exif-iimcategory-sci' => 'Science and technology',
'exif-iimcategory-soi' => 'Social issues',
'exif-iimcategory-spo' => 'Sports',
'exif-iimcategory-war' => 'War, conflict and unrest',
'exif-iimcategory-wea' => 'Weather',

'exif-urgency-normal' => 'Normal ($1)',
'exif-urgency-low'    => 'Low ($1)',
'exif-urgency-high'   => 'High ($1)',
'exif-urgency-other'  => 'User-defined priority ($1)',

# External editor support
'edit-externally'      => 'Edit this file using an external application',
'edit-externally-help' => '(See the [//www.mediawiki.org/wiki/Manual:External_editors setup instructions] for more information)',

# 'all' in various places, this might be different for inflected languages
'watchlistall2' => 'all',
'namespacesall' => 'all',
'monthsall'     => 'all',
'limitall'      => 'all',

# E-mail address confirmation
'confirmemail'              => 'Confirm e-mail address',
'confirmemail_noemail'      => 'You do not have a valid e-mail address set in your [[Special:Preferences|user preferences]].',
'confirmemail_text'         => '{{SITENAME}} requires that you validate your e-mail address before using e-mail features.
Activate the button below to send a confirmation mail to your address.
The mail will include a link containing a code;
load the link in your browser to confirm that your e-mail address is valid.',
'confirmemail_pending'      => 'A confirmation code has already been e-mailed to you;
if you recently created your account, you may wish to wait a few minutes for it to arrive before trying to request a new code.',
'confirmemail_send'         => 'Mail a confirmation code',
'confirmemail_sent'         => 'Confirmation e-mail sent.',
'confirmemail_oncreate'     => 'A confirmation code was sent to your e-mail address.
This code is not required to log in, but you will need to provide it before enabling any e-mail-based features in the wiki.',
'confirmemail_sendfailed'   => '{{SITENAME}} could not send your confirmation mail.
Please check your e-mail address for invalid characters.

Mailer returned: $1',
'confirmemail_invalid'      => 'Invalid confirmation code.
The code may have expired.',
'confirmemail_needlogin'    => 'You need to $1 to confirm your e-mail address.',
'confirmemail_success'      => 'Your e-mail address has been confirmed.
You may now [[Special:UserLogin|log in]] and enjoy the wiki.',
'confirmemail_loggedin'     => 'Your e-mail address has now been confirmed.',
'confirmemail_error'        => 'Something went wrong saving your confirmation.',
'confirmemail_subject'      => '{{SITENAME}} e-mail address confirmation',
'confirmemail_body'         => 'Someone, probably you, from IP address $1,
has registered an account "$2" with this e-mail address on {{SITENAME}}.

To confirm that this account really does belong to you and activate
e-mail features on {{SITENAME}}, open this link in your browser:

$3

If you did *not* register the account, follow this link
to cancel the e-mail address confirmation:

$5

This confirmation code will expire at $4.',
'confirmemail_body_changed' => 'Someone, probably you, from IP address $1,
has changed the e-mail address of the account "$2" to this address on {{SITENAME}}.

To confirm that this account really does belong to you and reactivate
e-mail features on {{SITENAME}}, open this link in your browser:

$3

If the account does *not* belong to you, follow this link
to cancel the e-mail address confirmation:

$5

This confirmation code will expire at $4.',
'confirmemail_body_set'     => 'Someone, probably you, from IP address $1,
has set the e-mail address of the account "$2" to this address on {{SITENAME}}.

To confirm that this account really does belong to you and reactivate
e-mail features on {{SITENAME}}, open this link in your browser:

$3

If the account does *not* belong to you, follow this link
to cancel the e-mail address confirmation:

$5

This confirmation code will expire at $4.',
'confirmemail_invalidated'  => 'E-mail address confirmation canceled',
'invalidateemail'           => 'Cancel e-mail confirmation',

# Scary transclusion
'scarytranscludedisabled' => '[Interwiki transcluding is disabled]',
'scarytranscludefailed'   => '[Template fetch failed for $1]',
'scarytranscludetoolong'  => '[URL is too long]',

# Delete conflict
'deletedwhileediting'      => "'''Warning''': This page was deleted after you started editing!",
'confirmrecreate'          => "User [[User:$1|$1]] ([[User talk:$1|talk]]) deleted this page after you started editing with reason:
: ''$2''
Please confirm that you really want to recreate this page.",
'confirmrecreate-noreason' => 'User [[User:$1|$1]] ([[User talk:$1|talk]]) deleted this page after you started editing.  Please confirm that you really want to recreate this page.',
'recreate'                 => 'Recreate',

'unit-pixel' => 'px', # only translate this message to other languages if you have to change it

# action=purge
'confirm_purge_button' => 'OK',
'confirm-purge-top'    => 'Clear the cache of this page?',
'confirm-purge-bottom' => 'Purging a page clears the cache and forces the most current revision to appear.',

# action=watch/unwatch
'confirm-watch-button'   => 'OK',
'confirm-watch-top'      => 'Add this page to your watchlist?',
'confirm-unwatch-button' => 'OK',
'confirm-unwatch-top'    => 'Remove this page from your watchlist?',

# Separators for various lists, etc.
'semicolon-separator' => ';&#32;', # only translate this message to other languages if you have to change it
'comma-separator'     => ',&#32;', # only translate this message to other languages if you have to change it
'colon-separator'     => ':&#32;', # only translate this message to other languages if you have to change it
'autocomment-prefix'  => '-&#32;', # only translate this message to other languages if you have to change it
'pipe-separator'      => '&#32;|&#32;', # only translate this message to other languages if you have to change it
'word-separator'      => '&#32;', # only translate this message to other languages if you have to change it
'ellipsis'            => '...', # only translate this message to other languages if you have to change it
'percent'             => '$1%', # only translate this message to other languages if you have to change it
'parentheses'         => '($1)', # only translate this message to other languages if you have to change it
'brackets'            => '[$1]', # only translate this message to other languages if you have to change it

# Multipage image navigation
'imgmultipageprev' => '← previous page',
'imgmultipagenext' => 'next page →',
'imgmultigo'       => 'Go!',
'imgmultigoto'     => 'Go to page $1',

# Table pager
'ascending_abbrev'         => 'asc',
'descending_abbrev'        => 'desc',
'table_pager_next'         => 'Next page',
'table_pager_prev'         => 'Previous page',
'table_pager_first'        => 'First page',
'table_pager_last'         => 'Last page',
'table_pager_limit'        => 'Show $1 items per page',
'table_pager_limit_label'  => 'Items per page:',
'table_pager_limit_submit' => 'Go',
'table_pager_empty'        => 'No results',

# Auto-summaries
'autosumm-blank'   => 'Blanked the page',
'autosumm-replace' => 'Replaced content with "$1"',
'autoredircomment' => 'Redirected page to [[$1]]',
'autosumm-new'     => 'Created page with "$1"',

# Autoblock whitelist
'autoblock_whitelist' => 'AOL http://webmaster.info.aol.com/proxyinfo.html
*64.12.96.0/19
*149.174.160.0/20
*152.163.240.0/21
*152.163.248.0/22
*152.163.252.0/23
*152.163.96.0/22
*152.163.100.0/23
*195.93.32.0/22
*195.93.48.0/22
*195.93.64.0/19
*195.93.96.0/19
*195.93.16.0/20
*198.81.0.0/22
*198.81.16.0/20
*198.81.8.0/23
*202.67.64.128/25
*205.188.192.0/20
*205.188.208.0/23
*205.188.112.0/20
*205.188.146.144/30
*207.200.112.0/21', # do not translate or duplicate this message to other languages

# Size units
'size-bytes'      => '$1 B', # only translate this message to other languages if you have to change it
'size-kilobytes'  => '$1 KB', # only translate this message to other languages if you have to change it
'size-megabytes'  => '$1 MB', # only translate this message to other languages if you have to change it
'size-gigabytes'  => '$1 GB', # only translate this message to other languages if you have to change it
'size-terabytes'  => '$1 TB', # only translate this message to other languages if you have to change it
'size-petabytes'  => '$1 PB', # only translate this message to other languages if you have to change it
'size-exabytes'   => '$1 EB', # only translate this message to other languages if you have to change it
'size-zetabytes'  => '$1 ZB', # only translate this message to other languages if you have to change it
'size-yottabytes' => '$1 YB', # only translate this message to other languages if you have to change it

# Bitrate units
'bitrate-bits'      => '$1bps', # only translate this message to other languages if you have to change it
'bitrate-kilobits'  => '$1kbps', # only translate this message to other languages if you have to change it
'bitrate-megabits'  => '$1Mbps', # only translate this message to other languages if you have to change it
'bitrate-gigabits'  => '$1Gbps', # only translate this message to other languages if you have to change it
'bitrate-terabits'  => '$1Tbps', # only translate this message to other languages if you have to change it
'bitrate-petabits'  => '$1Pbps', # only translate this message to other languages if you have to change it
'bitrate-exabits'   => '$1Ebps', # only translate this message to other languages if you have to change it
'bitrate-zetabits'  => '$1Zbps', # only translate this message to other languages if you have to change it
'bitrate-yottabits' => '$1Ybps', # only translate this message to other languages if you have to change it

# Live preview
'livepreview-loading' => 'Loading...',
'livepreview-ready'   => 'Loading... Ready!',
'livepreview-failed'  => 'Live preview failed!
Try normal preview.',
'livepreview-error'   => 'Failed to connect: $1 "$2".
Try normal preview.',

# Friendlier slave lag warnings
'lag-warn-normal' => 'Changes newer than $1 {{PLURAL:$1|second|seconds}} may not be shown in this list.',
'lag-warn-high'   => 'Due to high database server lag, changes newer than $1 {{PLURAL:$1|second|seconds}} may not be shown in this list.',

# Watchlist editor
'editwatchlist-summary'        => '', # do not translate or duplicate this message to other languages
'watchlistedit-numitems'       => 'Your watchlist contains {{PLURAL:$1|1 title|$1 titles}}, excluding talk pages.',
'watchlistedit-noitems'        => 'Your watchlist contains no titles.',
'watchlistedit-normal-title'   => 'Edit watchlist',
'watchlistedit-normal-legend'  => 'Remove titles from watchlist',
'watchlistedit-normal-explain' => 'Titles on your watchlist are shown below.
To remove a title, check the box next to it, and click "{{int:Watchlistedit-normal-submit}}".
You can also [[Special:EditWatchlist/raw|edit the raw list]].',
'watchlistedit-normal-submit'  => 'Remove titles',
'watchlistedit-normal-done'    => '{{PLURAL:$1|1 title was|$1 titles were}} removed from your watchlist:',
'watchlistedit-raw-title'      => 'Edit raw watchlist',
'watchlistedit-raw-legend'     => 'Edit raw watchlist',
'watchlistedit-raw-explain'    => 'Titles on your watchlist are shown below, and can be edited by adding to and removing from the list;
one title per line.
When finished, click "{{int:Watchlistedit-raw-submit}}".
You can also [[Special:EditWatchlist|use the standard editor]].',
'watchlistedit-raw-titles'     => 'Titles:',
'watchlistedit-raw-submit'     => 'Update watchlist',
'watchlistedit-raw-done'       => 'Your watchlist has been updated.',
'watchlistedit-raw-added'      => '{{PLURAL:$1|1 title was|$1 titles were}} added:',
'watchlistedit-raw-removed'    => '{{PLURAL:$1|1 title was|$1 titles were}} removed:',

# Watchlist editing tools
'watchlisttools-view' => 'View relevant changes',
'watchlisttools-edit' => 'View and edit watchlist',
'watchlisttools-raw'  => 'Edit raw watchlist',

# Iranian month names
'iranian-calendar-m1'  => 'Farvardin', # only translate this message to other languages if you have to change it
'iranian-calendar-m2'  => 'Ordibehesht', # only translate this message to other languages if you have to change it
'iranian-calendar-m3'  => 'Khordad', # only translate this message to other languages if you have to change it
'iranian-calendar-m4'  => 'Tir', # only translate this message to other languages if you have to change it
'iranian-calendar-m5'  => 'Mordad', # only translate this message to other languages if you have to change it
'iranian-calendar-m6'  => 'Shahrivar', # only translate this message to other languages if you have to change it
'iranian-calendar-m7'  => 'Mehr', # only translate this message to other languages if you have to change it
'iranian-calendar-m8'  => 'Aban', # only translate this message to other languages if you have to change it
'iranian-calendar-m9'  => 'Azar', # only translate this message to other languages if you have to change it
'iranian-calendar-m10' => 'Dey', # only translate this message to other languages if you have to change it
'iranian-calendar-m11' => 'Bahman', # only translate this message to other languages if you have to change it
'iranian-calendar-m12' => 'Esfand', # only translate this message to other languages if you have to change it

# Hijri month names
'hijri-calendar-m1'  => 'Muharram', # only translate this message to other languages if you have to change it
'hijri-calendar-m2'  => 'Safar', # only translate this message to other languages if you have to change it
'hijri-calendar-m3'  => "Rabi' al-awwal", # only translate this message to other languages if you have to change it
'hijri-calendar-m4'  => "Rabi' al-thani", # only translate this message to other languages if you have to change it
'hijri-calendar-m5'  => 'Jumada al-awwal', # only translate this message to other languages if you have to change it
'hijri-calendar-m6'  => 'Jumada al-thani', # only translate this message to other languages if you have to change it
'hijri-calendar-m7'  => 'Rajab', # only translate this message to other languages if you have to change it
'hijri-calendar-m8'  => "Sha'aban", # only translate this message to other languages if you have to change it
'hijri-calendar-m9'  => 'Ramadan', # only translate this message to other languages if you have to change it
'hijri-calendar-m10' => 'Shawwal', # only translate this message to other languages if you have to change it
'hijri-calendar-m11' => "Dhu al-Qi'dah", # only translate this message to other languages if you have to change it
'hijri-calendar-m12' => 'Dhu al-Hijjah', # only translate this message to other languages if you have to change it

# Hebrew month names
'hebrew-calendar-m1'      => 'Tishrei', # only translate this message to other languages if you have to change it
'hebrew-calendar-m2'      => 'Cheshvan', # only translate this message to other languages if you have to change it
'hebrew-calendar-m3'      => 'Kislev', # only translate this message to other languages if you have to change it
'hebrew-calendar-m4'      => 'Tevet', # only translate this message to other languages if you have to change it
'hebrew-calendar-m5'      => 'Shevat', # only translate this message to other languages if you have to change it
'hebrew-calendar-m6'      => 'Adar', # only translate this message to other languages if you have to change it
'hebrew-calendar-m6a'     => 'Adar I', # only translate this message to other languages if you have to change it
'hebrew-calendar-m6b'     => 'Adar II', # only translate this message to other languages if you have to change it
'hebrew-calendar-m7'      => 'Nisan', # only translate this message to other languages if you have to change it
'hebrew-calendar-m8'      => 'Iyar', # only translate this message to other languages if you have to change it
'hebrew-calendar-m9'      => 'Sivan', # only translate this message to other languages if you have to change it
'hebrew-calendar-m10'     => 'Tamuz', # only translate this message to other languages if you have to change it
'hebrew-calendar-m11'     => 'Av', # only translate this message to other languages if you have to change it
'hebrew-calendar-m12'     => 'Elul', # only translate this message to other languages if you have to change it
'hebrew-calendar-m1-gen'  => 'Tishrei', # only translate this message to other languages if you have to change it
'hebrew-calendar-m2-gen'  => 'Cheshvan', # only translate this message to other languages if you have to change it
'hebrew-calendar-m3-gen'  => 'Kislev', # only translate this message to other languages if you have to change it
'hebrew-calendar-m4-gen'  => 'Tevet', # only translate this message to other languages if you have to change it
'hebrew-calendar-m5-gen'  => 'Shevat', # only translate this message to other languages if you have to change it
'hebrew-calendar-m6-gen'  => 'Adar', # only translate this message to other languages if you have to change it
'hebrew-calendar-m6a-gen' => 'Adar I', # only translate this message to other languages if you have to change it
'hebrew-calendar-m6b-gen' => 'Adar II', # only translate this message to other languages if you have to change it
'hebrew-calendar-m7-gen'  => 'Nisan', # only translate this message to other languages if you have to change it
'hebrew-calendar-m8-gen'  => 'Iyar', # only translate this message to other languages if you have to change it
'hebrew-calendar-m9-gen'  => 'Sivan', # only translate this message to other languages if you have to change it
'hebrew-calendar-m10-gen' => 'Tamuz', # only translate this message to other languages if you have to change it
'hebrew-calendar-m11-gen' => 'Av', # only translate this message to other languages if you have to change it
'hebrew-calendar-m12-gen' => 'Elul', # only translate this message to other languages if you have to change it

# Signatures
'signature'      => '[[{{ns:user}}:$1|$2]] ([[{{ns:user_talk}}:$1|talk]])',
'signature-anon' => '[[{{#special:Contributions}}/$1|$2]]', # do not translate or duplicate this message to other languages
'timezone-utc'   => 'UTC', # only translate this message to other languages if you have to change it

# Core parser functions
'unknown_extension_tag' => 'Unknown extension tag "$1"',
'duplicate-defaultsort' => '\'\'\'Warning:\'\'\' Default sort key "$2" overrides earlier default sort key "$1".',

# Special:Version
'version'                               => 'Version',
'version-summary'                       => '', # do not translate or duplicate this message to other languages
'version-extensions'                    => 'Installed extensions',
'version-specialpages'                  => 'Special pages',
'version-parserhooks'                   => 'Parser hooks',
'version-variables'                     => 'Variables',
'version-antispam'                      => 'Spam prevention',
'version-skins'                         => 'Skins',
'version-api'                           => 'API', # only translate this message to other languages if you have to change it
'version-other'                         => 'Other',
'version-mediahandlers'                 => 'Media handlers',
'version-hooks'                         => 'Hooks',
'version-extension-functions'           => 'Extension functions',
'version-parser-extensiontags'          => 'Parser extension tags',
'version-parser-function-hooks'         => 'Parser function hooks',
'version-hook-name'                     => 'Hook name',
'version-hook-subscribedby'             => 'Subscribed by',
'version-version'                       => '(Version $1)',
'version-svn-revision'                  => '(r$2)', # only translate this message to other languages if you have to change it
'version-license'                       => 'License',
'version-poweredby-credits'             => "This wiki is powered by '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
'version-poweredby-others'              => 'others',
'version-license-info'                  => 'MediaWiki is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public License] along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [//www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online].',
'version-software'                      => 'Installed software',
'version-software-product'              => 'Product',
'version-software-version'              => 'Version',
'version-entrypoints'                   => 'Entry point URLs',
'version-entrypoints-header-entrypoint' => 'Entry point',
'version-entrypoints-header-url'        => 'URL',
'version-entrypoints-articlepath'       => '[https://www.mediawiki.org/wiki/Manual:$wgArticlePath Article path]', # only translate this message to other languages if you have to change it
'version-entrypoints-scriptpath'        => '[https://www.mediawiki.org/wiki/Manual:$wgScriptPath Script path]', # only translate this message to other languages if you have to change it
'version-entrypoints-index-php'         => '[https://www.mediawiki.org/wiki/Manual:index.php index.php]', # do not translate or duplicate this message to other languages
'version-entrypoints-api-php'           => '[https://www.mediawiki.org/wiki/Manual:api.php api.php]', # do not translate or duplicate this message to other languages
'version-entrypoints-load-php'          => '[https://www.mediawiki.org/wiki/Manual:load.php load.php]', # do not translate or duplicate this message to other languages

# Special:FilePath
'filepath'         => 'File path',
'filepath-page'    => 'File:',
'filepath-submit'  => 'Go',
'filepath-summary' => 'This special page returns the complete path for a file.
Images are shown in full resolution, other file types are started with their associated program directly.',

# Special:FileDuplicateSearch
'fileduplicatesearch'           => 'Search for duplicate files',
'fileduplicatesearch-summary'   => 'Search for duplicate files based on hash values.',
'fileduplicatesearch-legend'    => 'Search for a duplicate',
'fileduplicatesearch-filename'  => 'Filename:',
'fileduplicatesearch-submit'    => 'Search',
'fileduplicatesearch-info'      => '$1 × $2 pixel<br />File size: $3<br />MIME type: $4',
'fileduplicatesearch-result-1'  => 'The file "$1" has no identical duplication.',
'fileduplicatesearch-result-n'  => 'The file "$1" has {{PLURAL:$2|1 identical duplication|$2 identical duplications}}.',
'fileduplicatesearch-noresults' => 'No file named "$1" found.',

# Special:SpecialPages
'specialpages'                   => 'Special pages',
'specialpages-summary'           => '', # do not translate or duplicate this message to other languages
'specialpages-note'              => '----
* Normal special pages.
* <span class="mw-specialpagerestricted">Restricted special pages.</span>',
'specialpages-group-maintenance' => 'Maintenance reports',
'specialpages-group-other'       => 'Other special pages',
'specialpages-group-login'       => 'Login / create account',
'specialpages-group-changes'     => 'Recent changes and logs',
'specialpages-group-media'       => 'Media reports and uploads',
'specialpages-group-users'       => 'Users and rights',
'specialpages-group-highuse'     => 'High use pages',
'specialpages-group-pages'       => 'Lists of pages',
'specialpages-group-pagetools'   => 'Page tools',
'specialpages-group-wiki'        => 'Data and tools',
'specialpages-group-redirects'   => 'Redirecting special pages',
'specialpages-group-spam'        => 'Spam tools',

# Special:BlankPage
'blankpage'              => 'Blank page',
'intentionallyblankpage' => 'This page is intentionally left blank.',

# External image whitelist
'external_image_whitelist' => ' #Leave this line exactly as it is<pre>
#Put regular expression fragments (just the part that goes between the //) below
#These will be matched with the URLs of external (hotlinked) images
#Those that match will be displayed as images, otherwise only a link to the image will be shown
#Lines beginning with # are treated as comments
#This is case-insensitive

#Put all regex fragments above this line. Leave this line exactly as it is</pre>',

# Special:Tags
'tags'                    => 'Valid change tags',
'tags-summary'            => '', # do not translate or duplicate this message to other languages
'tag-filter'              => '[[Special:Tags|Tag]] filter:',
'tag-filter-submit'       => 'Filter',
'tags-title'              => 'Tags',
'tags-intro'              => 'This page lists the tags that the software may mark an edit with, and their meaning.',
'tags-tag'                => 'Tag name',
'tags-display-header'     => 'Appearance on change lists',
'tags-description-header' => 'Full description of meaning',
'tags-hitcount-header'    => 'Tagged changes',
'tags-edit'               => 'edit',
'tags-hitcount'           => '$1 {{PLURAL:$1|change|changes}}',

# Special:ComparePages
'comparepages'                => 'Compare pages',
'comparepages-summary'        => '', # do not translate or duplicate this message to other languages
'compare-selector'            => 'Compare page revisions',
'compare-page1'               => 'Page 1',
'compare-page2'               => 'Page 2',
'compare-rev1'                => 'Revision 1',
'compare-rev2'                => 'Revision 2',
'compare-submit'              => 'Compare',
'compare-invalid-title'       => 'The title you specified is invalid.',
'compare-title-not-exists'    => 'The title you specified does not exist.',
'compare-revision-not-exists' => 'The revision you specified does not exist.',

# Database error messages
'dberr-header'      => 'This wiki has a problem',
'dberr-problems'    => 'Sorry!
This site is experiencing technical difficulties.',
'dberr-again'       => 'Try waiting a few minutes and reloading.',
'dberr-info'        => '(Cannot contact the database server: $1)',
'dberr-usegoogle'   => 'You can try searching via Google in the meantime.',
'dberr-outofdate'   => 'Note that their indexes of our content may be out of date.',
'dberr-cachederror' => 'This is a cached copy of the requested page, and may not be up to date.',

# HTML forms
'htmlform-invalid-input'       => 'There are problems with some of your input',
'htmlform-select-badoption'    => 'The value you specified is not a valid option.',
'htmlform-int-invalid'         => 'The value you specified is not an integer.',
'htmlform-float-invalid'       => 'The value you specified is not a number.',
'htmlform-int-toolow'          => 'The value you specified is below the minimum of $1',
'htmlform-int-toohigh'         => 'The value you specified is above the maximum of $1',
'htmlform-required'            => 'This value is required',
'htmlform-submit'              => 'Submit',
'htmlform-reset'               => 'Undo changes',
'htmlform-selectorother-other' => 'Other',

# SQLite database support
'sqlite-has-fts' => '$1 with full-text search support',
'sqlite-no-fts'  => '$1 without full-text search support',

# New logging system
'logentry-delete-delete'              => '$1 deleted page $3',
'logentry-delete-restore'             => '$1 restored page $3',
'logentry-delete-event'               => '$1 changed visibility of {{PLURAL:$5|a log event|$5 log events}} on $3: $4',
'logentry-delete-revision'            => '$1 changed visibility of {{PLURAL:$5|a revision|$5 revisions}} on page $3: $4',
'logentry-delete-event-legacy'        => '$1 changed visibility of log events on $3',
'logentry-delete-revision-legacy'     => '$1 changed visibility of revisions on page $3',
'logentry-suppress-delete'            => '$1 suppressed page $3',
'logentry-suppress-event'             => '$1 secretly changed visibility of {{PLURAL:$5|a log event|$5 log events}} on $3: $4',
'logentry-suppress-revision'          => '$1 secretly changed visibility of {{PLURAL:$5|a revision|$5 revisions}} on page $3: $4',
'logentry-suppress-event-legacy'      => '$1 secretly changed visibility of log events on $3',
'logentry-suppress-revision-legacy'   => '$1 secretly changed visibility of revisions on page $3',
'revdelete-content-hid'               => 'content hidden',
'revdelete-summary-hid'               => 'edit summary hidden',
'revdelete-uname-hid'                 => 'username hidden',
'revdelete-content-unhid'             => 'content unhidden',
'revdelete-summary-unhid'             => 'edit summary unhidden',
'revdelete-uname-unhid'               => 'username unhidden',
'revdelete-restricted'                => 'applied restrictions to administrators',
'revdelete-unrestricted'              => 'removed restrictions for administrators',
'logentry-move-move'                  => '$1 moved page $3 to $4',
'logentry-move-move-noredirect'       => '$1 moved page $3 to $4 without leaving a redirect',
'logentry-move-move_redir'            => '$1 moved page $3 to $4 over redirect',
'logentry-move-move_redir-noredirect' => '$1 moved page $3 to $4 over a redirect without leaving a redirect',
'logentry-patrol-patrol'              => '$1 marked revision $4 of page $3 patrolled',
'logentry-patrol-patrol-auto'         => '$1 automatically marked revision $4 of page $3 patrolled',
'logentry-newusers-newusers'          => 'User account $1 was created',
'logentry-newusers-create'            => 'User account $1 was created',
'logentry-newusers-create2'           => 'User account $3 was created by $1',
'logentry-newusers-autocreate'        => 'User account $1 was created automatically',
'newuserlog-byemail'                  => 'password sent by e-mail',

# For IRC, see bug 34508. Do not change
'revdelete-logentry'          => 'changed revision visibility of "[[$1]]"', # do not translate or duplicate this message to other languages
'logdelete-logentry'          => 'changed event visibility of "[[$1]]"', # do not translate or duplicate this message to other languages
'revdelete-content'           => 'content', # do not translate or duplicate this message to other languages
'revdelete-summary'           => 'edit summary', # do not translate or duplicate this message to other languages
'revdelete-uname'             => 'username', # do not translate or duplicate this message to other languages
'revdelete-hid'               => 'hid $1', # do not translate or duplicate this message to other languages
'revdelete-unhid'             => 'unhid $1', # do not translate or duplicate this message to other languages
'revdelete-log-message'       => '$1 for $2 {{PLURAL:$2|revision|revisions}}', # do not translate or duplicate this message to other languages
'logdelete-log-message'       => '$1 for $2 {{PLURAL:$2|event|events}}', # do not translate or duplicate this message to other languages
'deletedarticle'              => 'deleted "[[$1]]"', # do not translate or duplicate this message to other languages
'suppressedarticle'           => 'suppressed "[[$1]]"', # do not translate or duplicate this message to other languages
'undeletedarticle'            => 'restored "[[$1]]"', # do not translate or duplicate this message to other languages
'patrol-log-line'             => 'marked $1 of $2 patrolled $3', # do not translate or duplicate this message to other languages
'patrol-log-auto'             => '(automatic)', # do not translate or duplicate this message to other languages
'patrol-log-diff'             => 'revision $1', # do not translate or duplicate this message to other languages
'1movedto2'                   => 'moved [[$1]] to [[$2]]', # do not translate or duplicate this message to other languages
'1movedto2_redir'             => 'moved [[$1]] to [[$2]] over redirect', # do not translate or duplicate this message to other languages
'move-redirect-suppressed'    => 'redirect suppressed', # do not translate or duplicate this message to other languages
'newuserlog-create-entry'     => 'New user account', # do not translate or duplicate this message to other languages
'newuserlog-create2-entry'    => 'created new account $1', # do not translate or duplicate this message to other languages
'newuserlog-autocreate-entry' => 'Account created automatically', # do not translate or duplicate this message to other languages

# Feedback
'feedback-bugornote' => 'If you are ready to describe a technical problem in detail please [$1 report a bug].
Otherwise, you can use the easy form below. Your comment will be added to the page "[$3 $2]", along with your username.',
'feedback-subject'   => 'Subject:',
'feedback-message'   => 'Message:',
'feedback-cancel'    => 'Cancel',
'feedback-submit'    => 'Submit Feedback',
'feedback-adding'    => 'Adding feedback to page...',
'feedback-error1'    => 'Error: Unrecognized result from API',
'feedback-error2'    => 'Error: Edit failed',
'feedback-error3'    => 'Error: No response from API',
'feedback-thanks'    => 'Thanks! Your feedback has been posted to the page "[$2 $1]".',
'feedback-close'     => 'Done',
'feedback-bugcheck'  => 'Great! Just check that it is not already one of the [$1 known bugs].',
'feedback-bugnew'    => 'I checked. Report a new bug',

# Search suggestions
'searchsuggest-search'     => 'Search',
'searchsuggest-containing' => 'containing...',

# API errors
'api-error-badaccess-groups'              => 'You are not permitted to upload files to this wiki.',
'api-error-badtoken'                      => 'Internal error: Bad token.',
'api-error-copyuploaddisabled'            => 'Uploading by URL is disabled on this server.',
'api-error-duplicate'                     => 'There {{PLURAL:$1|is [$2 another file]|are [$2 some other files]}} already on the site with the same content.',
'api-error-duplicate-archive'             => 'There {{PLURAL:$1|was [$2 another file]|were [$2 some other files]}} already on the site with the same content, but {{PLURAL:$1|it was|they were}} deleted.',
'api-error-duplicate-archive-popup-title' => 'Duplicate {{PLURAL:$1|file that has|files that have}} already been deleted.',
'api-error-duplicate-popup-title'         => 'Duplicate {{PLURAL:$1|file|files}}.',
'api-error-empty-file'                    => 'The file you submitted was empty.',
'api-error-emptypage'                     => 'Creating new, empty pages is not allowed.',
'api-error-fetchfileerror'                => 'Internal error: Something went wrong while fetching the file.',
'api-error-fileexists-forbidden'          => 'A file with name "$1" already exists, and cannot be overwritten.',
'api-error-fileexists-shared-forbidden'   => 'A file with name "$1" already exists in the shared file repository, and cannot be overwritten.',
'api-error-file-too-large'                => 'The file you submitted was too large.',
'api-error-filename-tooshort'             => 'The filename is too short.',
'api-error-filetype-banned'               => 'This type of file is banned.',
'api-error-filetype-banned-type'          => '$1 {{PLURAL:$4|is not a permitted file type|are not permitted file types}}. Permitted {{PLURAL:$3|file type is|file types are}} $2.',
'api-error-filetype-missing'              => 'The filename is missing an extension.',
'api-error-hookaborted'                   => 'The modification you tried to make was aborted by an extension.',
'api-error-http'                          => 'Internal error: Unable to connect to server.',
'api-error-illegal-filename'              => 'The filename is not allowed.',
'api-error-internal-error'                => 'Internal error: Something went wrong with processing your upload on the wiki.',
'api-error-invalid-file-key'              => 'Internal error: File was not found in temporary storage.',
'api-error-missingparam'                  => 'Internal error: Missing parameters on request.',
'api-error-missingresult'                 => 'Internal error: Could not determine if the copy succeeded.',
'api-error-mustbeloggedin'                => 'You must be logged in to upload files.',
'api-error-mustbeposted'                  => 'Internal error: Request requires HTTP POST.',
'api-error-noimageinfo'                   => 'The upload succeeded, but the server did not give us any information about the file.',
'api-error-nomodule'                      => 'Internal error: No upload module set.',
'api-error-ok-but-empty'                  => 'Internal error: No response from server.',
'api-error-overwrite'                     => 'Overwriting an existing file is not allowed.',
'api-error-stashfailed'                   => 'Internal error: Server failed to store temporary file.',
'api-error-timeout'                       => 'The server did not respond within the expected time.',
'api-error-unclassified'                  => 'An unknown error occurred.',
'api-error-unknown-code'                  => 'Unknown error: "$1".',
'api-error-unknown-error'                 => 'Internal error: Something went wrong when trying to upload your file.',
'api-error-unknown-warning'               => 'Unknown warning: "$1".',
'api-error-unknownerror'                  => 'Unknown error: "$1".',
'api-error-uploaddisabled'                => 'Uploading is disabled on this wiki.',
'api-error-verification-error'            => 'This file might be corrupt, or have the wrong extension.',

# Durations
'duration-seconds'   => '$1 {{PLURAL:$1|second|seconds}}',
'duration-minutes'   => '$1 {{PLURAL:$1|minute|minutes}}',
'duration-hours'     => '$1 {{PLURAL:$1|hour|hours}}',
'duration-days'      => '$1 {{PLURAL:$1|day|days}}',
'duration-weeks'     => '$1 {{PLURAL:$1|week|weeks}}',
'duration-years'     => '$1 {{PLURAL:$1|year|years}}',
'duration-decades'   => '$1 {{PLURAL:$1|decade|decades}}',
'duration-centuries' => '$1 {{PLURAL:$1|century|centuries}}',
'duration-millennia' => '$1 {{PLURAL:$1|millennium|millennia}}',


# WikiEditor Toolbar
'wikieditor-toolbar-tool-strike' => 'Strikeout',
'wikieditor-toolbar-tool-underline' => 'Underline',
'wikieditor-toolbar-tool-center' => 'Center',
'wikieditor-toolbar-align-right' => 'Right',
'wikieditor-toolbar-align-left' => 'Left',
'wikieditor-toolbar-tool-advanced-image' => 'Insert advanced image',
'wikieditor-toolbar-tool-horizontal-line' => 'Insert horizontal line',
'wikieditor-toolbar-tool-math' => 'Add formula',
'wikieditor-toolbar-tool-comment' => 'Hidden Comment',


);


// 12345 - french ctrl-f

$messages['fr'] = array(
# User preference toggles
'tog-underline' => 'Souligner les liens :',
'tog-justify' => 'Justifier les paragraphes',
'tog-hideminor' => 'Masquer les modifications mineures dans les modifications récentes',
'tog-hidepatrolled' => 'Masquer les modifications surveillées dans les modifications récentes',
'tog-newpageshidepatrolled' => 'Masquer les pages surveillées parmi les nouvelles pages',
'tog-extendwatchlist' => 'Étendre la liste de suivi pour afficher toutes les modifications et pas uniquement les plus récentes',
'tog-usenewrc' => 'Grouper les changements dans les modifications récentes et la liste de suivi (nécessite JavaScript)',
'tog-numberheadings' => 'Numéroter automatiquement les titres de section',
'tog-showtoolbar' => "Montrer la barre d'outils de modification (nécessite JavaScript)",
'tog-editondblclick' => 'Modifier des pages sur double-clic (nécessite JavaScript)',
'tog-editsection' => 'Activer les modifications de sections grâce aux liens « [modifier] »',
'tog-editsectiononrightclick' => 'Activer la modification de sections par clic droit sur leurs titres (nécessite JavaScript)',
'tog-showtoc' => 'Afficher la table des matières (pour les pages ayant plus de 3 sections)',
'tog-rememberpassword' => 'Se souvenir de mon identification avec ce navigateur (au maximum $1 {{PLURAL:$1|jour|jours}})',
'tog-watchcreations' => "Ajouter les pages que je crée et les fichiers que j'importe à ma liste de suivi",
'tog-watchdefault' => 'Ajouter les pages et les fichiers que je modifie à ma liste de suivi',
'tog-watchmoves' => 'Ajouter les pages et les fichiers que je renomme à ma liste de suivi',
'tog-watchdeletion' => 'Ajouter les pages et les fichiers que je supprime à ma liste de suivi',
'tog-minordefault' => 'Marquer mes modifications comme mineures par défaut',
'tog-previewontop' => 'Afficher la prévisualisation au-dessus de la zone de modification',
'tog-previewonfirst' => 'Afficher la prévisualisation lors de la première modification',
'tog-nocache' => 'Désactiver le cache des pages par le navigateur',
'tog-enotifwatchlistpages' => "M'avertir par courriel lorsqu'une page ou un fichier de ma liste de suivi est modifiée",
'tog-enotifusertalkpages' => "M'avertir par courriel si ma page de discussion est modifiée",
'tog-enotifminoredits' => "M'avertir par courriel même en cas de modifications mineures des pages ou des fichiers",
'tog-enotifrevealaddr' => 'Afficher mon adresse de courriel dans les courriels de notification',
'tog-shownumberswatching' => "Afficher le nombre d'utilisateurs qui suivent cette page",
'tog-oldsig' => 'Signature existante :',
'tog-fancysig' => 'Traiter la signature comme du wikitexte (sans lien automatique)',
'tog-externaleditor' => "Utiliser par défaut un éditeur de texte externe (pour les utilisateurs avancés, nécessite des réglages spécifiques sur votre ordinateur, [//www.mediawiki.org/wiki/Manual:External_editors/fr plus d'informations]).",
'tog-externaldiff' => "Utiliser un comparateur externe par défaut (pour les utilisateurs avancés, nécessite des réglages sur votre ordinateur, [//www.mediawiki.org/wiki/Manual:External_editors/fr plus d'informations]).",
'tog-showjumplinks' => 'Activer les liens « navigation » et « recherche » en haut de page',
'tog-uselivepreview' => "Utiliser l'aperçu rapide (nécessite JavaScript) (expérimental)",
'tog-forceeditsummary' => "M'avertir lorsque je n'ai pas spécifié de résumé de modification",
'tog-watchlisthideown' => 'Masquer mes propres modifications dans la liste de suivi',
'tog-watchlisthidebots' => 'Masquer les modifications faites par des robots dans la liste de suivi',
'tog-watchlisthideminor' => 'Masquer les modifications mineures dans la liste de suivi',
'tog-watchlisthideliu' => 'Masquer les modifications faites par des utilisateurs inscrits dans la liste de suivi',
'tog-watchlisthideanons' => 'Masquer les modifications anonymes dans la liste de suivi',
'tog-watchlisthidepatrolled' => 'Masquer les modifications surveillées dans la liste de suivi',
'tog-ccmeonemails' => "M'envoyer une copie des courriels que j'envoie aux autres utilisateurs",
'tog-diffonly' => 'Ne pas afficher le contenu des pages sous les diffs',
'tog-showhiddencats' => 'Afficher les catégories cachées',
'tog-noconvertlink' => 'Désactiver la conversion des titres',
'tog-norollbackdiff' => "Ne pas afficher le diff lors d'une révocation",

'underline-always' => 'Toujours',
'underline-never' => 'Jamais',
'underline-default' => 'Valeur par défaut du navigateur ou du thème',

# Font style option in Special:Preferences
'editfont-style' => 'Style de police de la zone de modification :',
'editfont-default' => 'Police du navigateur par défaut',
'editfont-monospace' => 'Police de chasse fixe',
'editfont-sansserif' => 'Police sans empattement',
'editfont-serif' => 'Police avec empattement',

# Dates
'sunday' => 'dimanche',
'monday' => 'lundi',
'tuesday' => 'mardi',
'wednesday' => 'mercredi',
'thursday' => 'jeudi',
'friday' => 'vendredi',
'saturday' => 'samedi',
'sun' => 'dim',
'mon' => 'lun',
'tue' => 'mar',
'wed' => 'mer',
'thu' => 'jeu',
'fri' => 'ven',
'sat' => 'sam',
'january' => 'janvier',
'february' => 'février',
'march' => 'mars',
'april' => 'avril',
'may_long' => 'mai',
'june' => 'juin',
'july' => 'juillet',
'august' => 'août',
'september' => 'septembre',
'october' => 'octobre',
'november' => 'novembre',
'december' => 'décembre',
'january-gen' => 'janvier',
'february-gen' => 'février',
'march-gen' => 'mars',
'april-gen' => 'avril',
'may-gen' => 'mai',
'june-gen' => 'juin',
'july-gen' => 'juillet',
'august-gen' => 'août',
'september-gen' => 'septembre',
'october-gen' => 'octobre',
'november-gen' => 'novembre',
'december-gen' => 'décembre',
'jan' => 'janv',
'feb' => 'fév',
'mar' => 'mars',
'apr' => 'avr',
'may' => 'mai',
'jun' => 'juin',
'jul' => 'juil',
'aug' => 'août',
'sep' => 'sept',
'oct' => 'oct',
'nov' => 'nov',
'dec' => 'déc',

# Categories related messages
'pagecategories' => 'Catégorie{{PLURAL:$1||s}}',
'category_header' => 'Pages dans la catégorie « $1 »',
'subcategories' => 'Sous-catégories',
'category-media-header' => 'Fichiers multimédias dans la catégorie « $1 »',
'category-empty' => "''Cette catégorie ne contient aucune page, sous-catégorie ou fichier multimédia.''",
'hidden-categories' => '{{PLURAL:$1|Catégorie cachée|Catégories cachées}}',
'hidden-category-category' => 'Catégories cachées',
'category-subcat-count' => 'Cette catégorie comprend {{PLURAL:$2|la sous-catégorie|$2 sous-catégories, dont {{PLURAL:$1|celle|les $1}}}} ci-dessous.',
'category-subcat-count-limited' => 'Cette catégorie comprend {{PLURAL:$1|la sous-catégorie|les $1 sous-catégories}} ci-dessous.',
'category-article-count' => 'Cette catégorie contient {{PLURAL:$2|la page suivante|$2 pages, dont {{PLURAL:$1|celle|les $1}} ci-dessous}}.',
'category-article-count-limited' => '{{PLURAL:$1|La page suivante figure|Les $1 pages suivantes figurent}} dans la présente catégorie.',
'category-file-count' => 'Cette catégorie contient {{PLURAL:$2|le fichier suivant|$2 fichiers, dont {{PLURAL:$1|celui|les $1}} ci-dessous}}.',
'category-file-count-limited' => '{{PLURAL:$1|Le fichier suivant figure|Les $1 fichiers suivants figurent}} dans la présente catégorie.',
'listingcontinuesabbrev' => '(suite)',
'index-category' => 'Pages indexées',
'noindex-category' => 'Pages non indexées',
'broken-file-category' => 'Pages avec des liens de fichiers brisés',

'about' => 'À propos',
'article' => 'Page de contenu',
'newwindow' => '(ouvre une nouvelle fenêtre)',
'cancel' => 'Annuler',
'moredotdotdot' => 'Plus...',
'mypage' => 'Page',
'mytalk' => 'Discussion',
'anontalk' => 'Discussion avec cette adresse IP',
'navigation' => 'Navigation',
'and' => '&#32;et',

# Cologne Blue skin
'qbfind' => 'Rechercher',
'qbbrowse' => 'Parcourir',
'qbedit' => 'Modifier',
'qbpageoptions' => 'Cette page',
'qbpageinfo' => 'Contexte',
'qbmyoptions' => 'Mes pages',
'qbspecialpages' => 'Pages spéciales',
'faq' => 'FAQ',
'faqpage' => 'Project:FAQ',

# Vector skin
'vector-action-addsection' => 'Ajouter un sujet',
'vector-action-delete' => 'Supprimer',
'vector-action-move' => 'Renommer',
'vector-action-protect' => 'Protéger',
'vector-action-undelete' => 'Rétablir',
'vector-action-unprotect' => 'Changer la protection',
'vector-simplesearch-preference' => "Activer la barre de recherche simplifiée (seulement pour l'habillage Vector)",
'vector-view-create' => 'Créer',
'vector-view-edit' => 'Modifier',
'vector-view-history' => "Afficher l'historique",
'vector-view-view' => 'Lire',
'vector-view-viewsource' => 'Voir la source',
'actions' => 'Actions',
'namespaces' => 'Espaces de noms',
'variants' => 'Variantes',

'errorpagetitle' => 'Erreur',
'returnto' => 'Revenir à la page $1.',
'tagline' => 'De {{SITENAME}}',
'help' => 'Aide',
'search' => 'Rechercher',
'searchbutton' => 'Rechercher',
'go' => 'Consulter',
'searcharticle' => 'Lire',
'history' => 'Historique de la page',
'history_short' => 'Historique',
'updatedmarker' => 'modifié depuis ma dernière visite',
'printableversion' => 'Version imprimable',
'permalink' => 'Adresse de cette version',
'print' => 'Imprimer',
'view' => 'Lire',
'edit' => 'Modifier',
'create' => 'Créer',
'editthispage' => 'Modifier cette page',
'create-this-page' => 'Créer cette page',
'delete' => 'Supprimer',
'deletethispage' => 'Supprimer cette page',
'undelete_short' => 'Restaurer $1 modification{{PLURAL:$1||s}}',
'viewdeleted_short' => 'Voir {{PLURAL:$1|une modification supprimée|$1 modifications supprimées}}',
'protect' => 'Protéger',
'protect_change' => 'modifier',
'protectthispage' => 'Protéger cette page',
'unprotect' => 'Changer la protection',
'unprotectthispage' => 'Changer la protection de cette page',
'newpage' => 'Nouvelle page',
'talkpage' => 'Discussion sur cette page',
'talkpagelinktext' => 'discuter',
'specialpage' => 'Page spéciale',
'personaltools' => 'Outils personnels',
'postcomment' => 'Nouvelle section',
'articlepage' => 'Voir la page de contenu',
'talk' => 'Discussion',
'views' => 'Affichages',
'toolbox' => 'Boîte à outils',
'userpage' => 'Page utilisateur',
'projectpage' => 'Page méta',
'imagepage' => 'Voir la page du fichier',
'mediawikipage' => 'Voir la page du message',
'templatepage' => 'Voir la page du modèle',
'viewhelppage' => "Voir la page d'aide",
'categorypage' => 'Voir la page de catégorie',
'viewtalkpage' => 'Page de discussion',
'otherlanguages' => 'Autres langues',
'redirectedfrom' => '(Redirigé depuis $1)',
'redirectpagesub' => 'Page de redirection',
'lastmodifiedat' => 'Dernière modification de cette page le $1 à $2.<br />',
'viewcount' => 'Cette page a été consultée $1 fois.',
'protectedpage' => 'Page protégée',
'jumpto' => 'Aller à :',
'jumptonavigation' => 'Navigation',
'jumptosearch' => 'rechercher',
'view-pool-error' => "Désolé, les serveurs sont surchargés en ce moment.
Trop d'utilisateurs cherchent à consulter cette page.
Veuillez attendre un moment avant de retenter l'accès à cette page.

$1",
'pool-timeout' => "Délai dépassé durant l'attente du verrou",
'pool-queuefull' => 'La file de travail est pleine',
'pool-errorunknown' => 'Erreur inconnue',

# All link text and link target definitions of links into project namespace that get used by other message strings, with the exception of user group pages (see grouppage) and the disambiguation template definition (see disambiguations).
'aboutsite' => 'À propos de {{SITENAME}}',
'aboutpage' => 'Project:À propos',
'copyright' => 'Sous licence $1',
'copyrightpage' => '{{ns:project}}:Copyrights',
'currentevents' => 'Actualités',
'currentevents-url' => 'Project:Actualités',
'disclaimers' => 'Avertissements',
'disclaimerpage' => 'Project:Avertissements généraux',
'edithelp' => 'Aide',
'edithelppage' => 'Help:Comment modifier une page',
'helppage' => 'Help:Accueil',
'mainpage' => 'Accueil',
'mainpage-description' => 'Accueil',
'policy-url' => 'Project:Règles',
'portal' => 'Communauté',
'portal-url' => 'Project:Accueil',
'privacy' => 'Politique de confidentialité',
'privacypage' => 'Project:Confidentialité',

'badaccess' => 'Erreur de permission',
'badaccess-group0' => "Vous n'avez pas les droits suffisants pour réaliser l'action demandée.",
'badaccess-groups' => "L'action que vous essayez de réaliser n'est accessible qu'aux utilisateurs {{PLURAL:$2|du groupe|des groupes}} : $1.",

'versionrequired' => 'Version $1 de MediaWiki nécessaire',
'versionrequiredtext' => 'La version $1 de MediaWiki est nécessaire pour utiliser cette page. Consultez [[Special:Version|la page des versions]]',

'ok' => 'Valider',
'retrievedfrom' => 'Récupérée de « $1 »',
'youhavenewmessages' => 'Vous avez $1 ($2).',
'newmessageslink' => 'de nouveaux messages',
'newmessagesdifflink' => 'dernière modification',
'youhavenewmessagesfromusers' => "Vous avez $1 {{PLURAL:$3|d'un autre utilisateur|de $3 autres utilisateurs}} ($2).",
'youhavenewmessagesmanyusers' => 'Vous avez $1 de nombreux utilisateurs ($2).',
'newmessageslinkplural' => '{{PLURAL:$1|un message|de nouveaux messages}}',
'newmessagesdifflinkplural' => '{{PLURAL:$1|dernière modification|dernières modifications}}',
'youhavenewmessagesmulti' => 'Vous avez de nouveaux messages sur $1.',
'editsection' => 'modifier',
'editold' => 'modifier',
'viewsourceold' => 'voir la source',
'editlink' => 'modifier',
'viewsourcelink' => 'voir la source',
'editsectionhint' => 'Modifier la section : $1',
'toc' => 'Sommaire',
'showtoc' => 'afficher',
'hidetoc' => 'masquer',
'collapsible-collapse' => 'masquer',
'collapsible-expand' => 'afficher',
'thisisdeleted' => 'Désirez-vous afficher ou restaurer $1 ?',
'viewdeleted' => 'Voir $1 ?',
'restorelink' => '{{PLURAL:$1|la modification effacée|les $1 modifications effacées}}',
'feedlinks' => 'Flux :',
'feed-invalid' => 'Type de flux invalide.',
'feed-unavailable' => 'Les flux de syndication ne sont pas disponibles',
'site-rss-feed' => 'Flux RSS de $1',
'site-atom-feed' => 'Flux Atom de $1',
'page-rss-feed' => 'Flux RSS de « $1 »',
'page-atom-feed' => 'Flux Atom de « $1 »',
'red-link-title' => '$1 (page inexistante)',
'sort-descending' => 'Tri décroissant',
'sort-ascending' => 'Tri croissant',

# Short words for each namespace, by default used in the namespace tab in monobook
'nstab-main' => 'Page',
'nstab-user' => 'Page utilisateur',
'nstab-media' => 'Média',
'nstab-special' => 'Page spéciale',
'nstab-project' => 'À propos',
'nstab-image' => 'Fichier',
'nstab-mediawiki' => 'Message',
'nstab-template' => 'Modèle',
'nstab-help' => 'Aide',
'nstab-category' => 'Catégorie',

# Main script and global functions
'nosuchaction' => 'Action inconnue',
'nosuchactiontext' => "L'action spécifiée dans l'URL est invalide.
Vous avez peut-être mal entré l'URL ou suivi un lien erroné.
Il peut également s'agir d'un bug dans le logiciel utilisé par {{SITENAME}}.",
'nosuchspecialpage' => 'Page spéciale inexistante',
'nospecialpagetext' => "<strong>Vous avez demandé une page spéciale qui n'existe pas.</strong>

Une liste des pages spéciales valides se trouve sur [[Special:SpecialPages|{{int:specialpages}}]].",

# General errors
'error' => 'Erreur',
'databaseerror' => 'Erreur de la base de données',
'dberrortext' => "Une erreur de syntaxe de la requête dans la base de données est survenue.
Ceci peut indiquer un bogue dans le logiciel.
La dernière requête traitée par la base de données était :
<blockquote><code>$1</code></blockquote>
depuis la fonction « <code>$2</code> ».
La base de données a renvoyé l'erreur « <samp>$3 : $4</samp> ».",
'dberrortextcl' => "Une requête dans la base de données comporte une erreur de syntaxe.
La dernière requête émise était :
« $1 »
dans la fonction « $2 ».
La base de données a renvoyé l'erreur « $3 : $4 ».",
'laggedslavemode' => 'Attention, cette page peut ne pas contenir les toutes dernières modifications effectuées',
'readonly' => 'Base de données verrouillée',
'enterlockreason' => "Indiquez la raison du verrouillage ainsi qu'une estimation de sa durée",
'readonlytext' => "Les ajouts et mises à jour de la base de données sont actuellement bloqués, probablement pour permettre la maintenance de la base, après quoi, tout rentrera dans l'ordre.

L'administrateur ayant verrouillé la base de données a fourni l'explication suivante :<br />$1",
'missing-article' => "La base de données n'a pas trouvé le texte d'une page qu'elle aurait dû trouver, intitulée « $1 » $2.

Généralement, cela survient en suivant un lien vers un diff périmé ou vers l'historique d'une page supprimée.

Si ce n'est pas le cas, il peut s'agir d'un bug dans le programme.
Veuillez le signaler à un [[Special:ListUsers/sysop|administrateur]] sans oublier de lui indiquer l'URL du lien.",
'missingarticle-rev' => '(numéro de version : $1)',
'missingarticle-diff' => '(diff : $1, $2)',
'readonly_lag' => 'La base de données a été automatiquement verrouillée pendant que les serveurs secondaires rattrapent leur retard sur le serveur principal.',
'internalerror' => 'Erreur interne',
'internalerror_info' => 'Erreur interne : $1',
'fileappenderrorread' => "Impossible de lire « $1 » lors de l'insertion",
'fileappenderror' => "Impossible d'ajouter « $1 » à « $2 ».",
'filecopyerror' => 'Impossible de copier le fichier « $1 » vers « $2 ».',
'filerenameerror' => 'Impossible de renommer le fichier « $1 » en « $2 ».',
'filedeleteerror' => 'Impossible de supprimer le fichier « $1 ».',
'directorycreateerror' => 'Impossible de créer le dossier « $1 ».',
'filenotfound' => 'Impossible de trouver le fichier « $1 ».',
'fileexistserror' => "Impossible d'écrire le fichier « $1 » : le fichier existe.",
'unexpected' => 'Valeur inattendue : « $1 » = « $2 ».',
'formerror' => 'Erreur : Impossible de soumettre le formulaire.',
'badarticleerror' => 'Cette action ne peut pas être effectuée sur cette page.',
'cannotdelete' => "Impossible de supprimer la page ou le fichier « $1 ».
La suppression a peut-être déjà été effectuée par quelqu'un d'autre.",
'cannotdelete-title' => 'Impossible de supprimer la page « $1 »',
'delete-hook-aborted' => "Suppression annulée par une extension.
Aucune explication n'a été fournie.",
'badtitle' => 'Mauvais titre',
'badtitletext' => "Le titre de la page demandée est invalide, vide, ou il s'agit d'un titre inter-langue ou inter-projet mal lié. Il contient peut-être un ou plusieurs caractères qui ne peuvent pas être utilisés dans les titres.",
'perfcached' => 'Les données suivantes sont en cache et peuvent ne pas être à jour. Un maximum de {{PLURAL:$1|un résultat|$1 résultats}} est disponible dans le cache.',
'perfcachedts' => 'Les données suivantes sont en cache et ont été mises à jour pour la dernière fois à $1. Un maximum de {{PLURAL:$4|un résultat|$4 résultats}} est disponible dans le cache.',
'querypage-no-updates' => 'Les mises à jour pour cette page sont actuellement désactivées. Les données ci-dessous ne sont pas mises à jour.',
'wrong_wfQuery_params' => 'Paramètres incorrects sur wfQuery()<br />
Fonction : $1<br />
Requête : $2',
'viewsource' => 'Voir le texte source',
'viewsource-title' => 'Voir la source de $1',
'actionthrottled' => 'Action limitée',
'actionthrottledtext' => "Pour lutter contre le spam, l'utilisation de cette action est limitée à un certain nombre de fois dans un laps de temps assez court. Il s'avère que vous avez dépassé cette limite.
Essayez à nouveau dans quelques minutes.",
'protectedpagetext' => "Cette page a été protégée pour empêcher sa modification ou d'autres actions.",
'viewsourcetext' => 'Vous pouvez voir et copier le contenu de la page :',
'viewyourtext' => "Vous pouvez voir et copier le contenu de '''vos modifications''' à cette page :",
'protectedinterface' => "Cette page fournit du texte d'interface pour le logiciel sur ce wiki, et est protégée pour éviter les abus.
Pour ajouter ou modifier des traductions sur tous les wikis, veuillez utiliser [//translatewiki.net/ translatewiki.net], le projet de localisation de MediaWiki.",
'editinginterface' => "'''Attention''': Vous êtes en train de modifier une page utilisée pour créer le texte de l'interface du logiciel. Les changements sur cette page se répercuteront dur l'apparence de l'interface utilisateur pour les autres utilisateurs de ce wiki.
Pour ajouter ou modifier des traductions pour tous les wikis, veuillez utiliser [//translatewiki.net/ translatewiki.net], le projet d'internationalisation de MediaWiki.",
'sqlhidden' => '(Requête SQL cachée)',
'cascadeprotected' => "Cette page est protégée car elle est incluse par {{PLURAL:$1|la page suivante, qui a été protégée|les pages suivantes, qui ont été protégées}} avec l'option « protection en cascade » activée :
$2",
'namespaceprotected' => "Vous n'avez pas la permission de modifier les pages de l'espace de noms « '''$1''' ».",
'customcssprotected' => "Vous n'avez pas la permission de modifier cette page de CSS, car elle contient les paramètres personnels d'un autre utilisateur.",
'customjsprotected' => "Vous n'avez pas la permission de modifier cette page de JavaScript, car elle contient les paramètres personnels d'un autre utilisateur.",
'ns-specialprotected' => "Les pages dans l'espace de noms « {{ns:special}} » ne peuvent pas être modifiées.",
'titleprotected' => "Ce titre a été protégé à la création par [[User:$1|$1]].
Le motif avancé est « ''$2'' ».",
'filereadonlyerror' => "Impossible de modifier le fichier « $1 » parce que le répertoire de fichiers « $2 » est en lecture seule.

L'administrateur qui l'a verrouillé a fourni ce motif: « $3 ».",
'invalidtitle-knownnamespace' => "Titre invalide avec l'espace de noms « $2 » et l'intitulé « $3 »",
'invalidtitle-unknownnamespace' => "Titre invalide avec le numéro d'espace de noms $1 et l'intitulé « $2 » inconnus",
'exception-nologin' => 'Non connecté',
'exception-nologin-text' => "Cette page ou cette action nécessite d'être connecté sur ce wiki.",

# Virus scanner
'virus-badscanner' => "Mauvaise configuration : scanneur de virus inconnu : ''$1''",
'virus-scanfailed' => 'Échec de la recherche (code $1)',
'virus-unknownscanner' => 'antivirus inconnu :',

# Login and logout pages
'logouttext' => "'''Vous êtes à présent déconnecté(e).'''

Vous pouvez continuer à utiliser {{SITENAME}} de façon anonyme, [[Special:UserLogin|vous reconnecter]] sous le même nom ou un autre.
Notez que certaines pages peuvent être encore affichées comme si vous étiez toujours connecté(e), jusqu’à ce que vous effaciez le cache de votre navigateur.",
'welcomecreation' => "== Bienvenue, $1 ! ==

Votre compte a été créé.
N'oubliez pas de personnaliser vos [[Special:Preferences|préférences sur {{SITENAME}}]].",
'yourname' => "Nom d'utilisateur :",
'yourpassword' => 'Mot de passe&nbsp;:',
'yourpasswordagain' => 'Confirmez le mot de passe :',
'remembermypassword' => 'Me reconnecter automatiquement aux prochaines visites avec ce navigateur (au maximum $1&nbsp;{{PLURAL:$1|jour|jours}})',
'securelogin-stick-https' => 'Rester connecté en HTTPS après la connexion',
'yourdomainname' => 'Votre domaine :',
'password-change-forbidden' => 'Vous ne pouvez pas modifier les mots de passe sur ce wiki.',
'externaldberror' => "Une erreur s'est produite avec la base de données d'authentification externe, ou bien vous n'êtes pas autorisé{{GENDER:||e|(e)}} à mettre à jour votre compte externe.",
'login' => 'Connexion',
'nav-login-createaccount' => 'Créer un compte ou se connecter',
'loginprompt' => 'Vous devez activer les cookies pour vous connecter à {{SITENAME}}.',
'userlogin' => 'Créer un compte ou se connecter',
'userloginnocreate' => 'Connexion',
'logout' => 'Se déconnecter',
'userlogout' => 'Déconnexion',
'notloggedin' => 'Non connecté',
'nologin' => "Vous n'êtes pas encore inscrit ? $1.",
'nologinlink' => 'Créer un compte',
'createaccount' => 'Créer un compte',
'gotaccount' => "Vous avez déjà un compte ? '''$1'''.",
'gotaccountlink' => 'Connectez-vous',
'userlogin-resetlink' => 'Vous avez oublié vos détails de connexion ?',
'createaccountmail' => 'par courriel',
'createaccountreason' => 'Motif :',
'badretype' => 'Les mots de passe que vous avez saisis ne correspondent pas.',
'userexists' => "Nom d'utilisateur entré déjà utilisé.
Veuillez choisir un nom différent.",
'loginerror' => 'Erreur de connexion',
'createaccounterror' => 'Impossible de créer le compte : $1',
'nocookiesnew' => "Le compte utilisateur a été créé, mais vous n'êtes pas connecté{{GENDER:||e|(e)}}. {{SITENAME}} utilise des cookies pour la connexion mais vous les avez désactivés. Veuillez les activer et vous reconnecter avec le même nom et le même mot de passe.",
'nocookieslogin' => '{{SITENAME}} utilise des cookies pour la connexion mais vous les avez désactivés. Veuillez les activer et vous reconnecter.',
'nocookiesfornew' => "Le compte utilisateur n'a pas été créé, car nous n'avons pas pu identifier son origine.
Vérifiez que vous avez activé les cookies, rechargez la page et réessayez.",
'noname' => "Vous n'avez pas saisi un nom d'utilisateur valide.",
'loginsuccesstitle' => 'Connexion réussie',
'loginsuccess' => 'Vous êtes maintenant connecté{{GENDER:$1||e|(e)}} à {{SITENAME}} en tant que « $1 ».',
'nosuchuser' => "L'utilisateur « $1 » n'existe pas.
Les noms d'utilisateurs sont sensibles à la casse.
Vérifiez l'orthographe, ou [[Special:UserLogin/signup|créez un nouveau compte]].",
'nosuchusershort' => "Il n'y a pas de contributeur avec le nom « $1 ». Veuillez vérifier l'orthographe.",
'nouserspecified' => "Vous devez saisir un nom d'utilisateur.",
'login-userblocked' => 'Cet utilisateur est bloqué. Connexion non autorisée.',
'wrongpassword' => 'Le mot de passe est incorrect. Veuillez essayer à nouveau.',
'wrongpasswordempty' => "Vous n'avez pas entré de mot de passe. Veuillez essayer à nouveau.",
'passwordtooshort' => 'Votre mot de passe doit contenir au moins $1 caractère{{PLURAL:$1||s}}.',
'password-name-match' => "Votre mot de passe doit être différent de votre nom d'utilisateur.",
'password-login-forbidden' => "L'utilisation de ce nom d'utilisateur et de ce mot de passe a été interdite.",
'mailmypassword' => 'Recevoir un nouveau mot de passe par courriel',
'passwordremindertitle' => 'Nouveau mot de passe temporaire pour {{SITENAME}}',
'passwordremindertext' => "Quelqu'un (probablement vous, ayant l'adresse IP $1) a demandé un nouveau mot de
passe pour {{SITENAME}} ($4 ). Un mot de passe temporaire a été créé pour
l'utilisateur « $2 » et est « $3 ». Si cela était votre intention, vous devrez
vous connecter et choisir un nouveau mot de passe.
Votre mot de passe temporaire expirera dans $5 jour{{PLURAL:$5||s}}.

Si vous n'êtes pas l'auteur de cette demande, ou si vous vous souvenez à présent
de votre ancien mot de passe et que vous ne souhaitez plus en changer, vous
pouvez ignorer ce message et continuer à utiliser votre ancien mot de passe.",
'noemail' => "Aucune adresse de courriel n'a été enregistrée pour l'utilisateur « $1 ».",
'noemailcreate' => 'Vous devez fournir une adresse de courriel valide',
'passwordsent' => "Un nouveau mot de passe a été envoyé à l'adresse de courriel de l'utilisateur « $1 ». Veuillez vous reconnecter après l'avoir reçu.",
'blocked-mailpassword' => 'Votre adresse IP est bloquée en écriture, la fonction de rappel du mot de passe est donc désactivée pour éviter les abus.',
'eauthentsent' => "Un courriel de confirmation a été envoyé à l'adresse indiquée.
Avant qu'un autre courriel ne soit envoyé à ce compte, vous devrez suivre les instructions du courriel et confirmer que le compte est bien le vôtre.",
'throttled-mailpassword' => "Un courriel de rappel de votre mot de passe a déjà été envoyé durant {{PLURAL:$1|la dernière heure|les $1 dernières heures}}. Afin d'éviter les abus, un seul courriel de rappel sera envoyé par {{PLURAL:$1|heure|intervalle de $1 heures}}.",
'mailerror' => "Erreur lors de l'envoi du courriel : $1",
'acct_creation_throttle_hit' => "Quelqu'un utilisant votre adresse IP a créé {{PLURAL:$1|un compte|$1 comptes}} au cours des dernières 24 heures, ce qui constitue la limite autorisée dans cet intervalle de temps.
Par conséquent, la création de compte a été temporairement désactivée pour cette adresse IP.",
'emailauthenticated' => 'Votre adresse de courriel a été authentifiée le $2 à $3.',
'emailnotauthenticated' => "Votre adresse de courriel n'est <strong>pas encore authentifiée</strong>. Aucun courriel ne sera envoyé pour chacune des fonctions suivantes.",
'noemailprefs' => 'Indiquez une adresse de courriel dans vos préférences pour utiliser ces fonctions.',
'emailconfirmlink' => 'Confirmez votre adresse de courriel',
'invalidemailaddress' => 'Cette adresse courriel ne peut pas être acceptée car elle semble avoir un format incorrect.
Entrez une adresse bien formatée ou laissez ce champ vide.',
'cannotchangeemail' => 'Les adresses de courriel des comptes ne peuvent pas être modifiées sur ce wiki.',
'emaildisabled' => 'Ce site ne peut pas envoyer de courriels.',
'accountcreated' => 'Compte créé',
'accountcreatedtext' => 'Le compte utilisateur pour $1 a été créé.',
'createaccount-title' => "Création d'un compte pour {{SITENAME}}",
'createaccount-text' => "Quelqu'un a créé un compte pour votre adresse de courriel sur {{SITENAME}} ($4) intitulé « $2 », avec le mot de passe « $3 ».
Vous devriez ouvrir une session et modifier dès à présent votre mot de passe.

Ignorez ce message si ce compte a été créé par erreur.",
'usernamehasherror' => "Le nom d'utilisateur ne peut pas contenir des caractères de hachage",
'login-throttled' => "Vous avez tenté un trop grand nombre de connexions dernièrement.
Veuillez attendre avant d'essayer à nouveau.",
'login-abort-generic' => 'Votre tentative de connexion a échoué',
'loginlanguagelabel' => 'Langue : $1',
'suspicious-userlogout' => "Votre demande de déconnexion a été refusée car il semble qu'elle a été envoyée par un navigateur cassé ou la mise en cache d'un proxy.",

# E-mail sending
'php-mail-error-unknown' => 'Erreur inconnue dans la fonction mail() de PHP.',
'user-mail-no-addy' => "Tenté d'envoyer un courriel sans adresse de courriel",

# Change password dialog
'resetpass' => 'Changer de mot de passe',
'resetpass_announce' => "Vous vous êtes enregistré{{GENDER:||e|(e)}} avec un mot de passe temporaire envoyé par courriel. Pour terminer l'enregistrement, vous devez entrer un nouveau mot de passe ici :",
'resetpass_text' => '<!-- Ajoutez le texte ici -->',
'resetpass_header' => 'Changer le mot de passe du compte',
'oldpassword' => 'Ancien mot de passe :',
'newpassword' => 'Nouveau mot de passe :',
'retypenew' => 'Confirmer le nouveau mot de passe :',
'resetpass_submit' => 'Changer le mot de passe et se connecter',
'resetpass_success' => 'Votre mot de passe a été changé avec succès ! Connexion en cours…',
'resetpass_forbidden' => 'Les mots de passe ne peuvent pas être changés',
'resetpass-no-info' => 'Vous devez être connecté pour avoir accès à cette page.',
'resetpass-submit-loggedin' => 'Changer de mot de passe',
'resetpass-submit-cancel' => 'Annuler',
'resetpass-wrong-oldpass' => 'Mot de passe actuel ou temporaire invalide.
Vous avez peut-être déjà changé votre mot de passe ou demandé un nouveau mot de passe temporaire.',
'resetpass-temp-password' => 'Mot de passe temporaire :',

# Special:PasswordReset
'passwordreset' => 'Remise à zéro du mot de passe',
'passwordreset-text' => 'Remplissez ce formulaire pour recevoir un courriel de rappel des détails de votre compte.',
'passwordreset-legend' => 'Remise à zéro du mot de passe',
'passwordreset-disabled' => 'La réinitialisation des mots de passe a été désactivée sur ce wiki.',
'passwordreset-pretext' => '{{PLURAL:$1||Entrez un élément de données ci-dessous}}',
'passwordreset-username' => "Nom d'utilisateur :",
'passwordreset-domain' => 'Domaine :',
'passwordreset-capture' => 'Voir le courriel résultant?',
'passwordreset-capture-help' => "Si vous cochez cette case, le courriel (avec le mot de passe temporaire) vous sera affiché en même temps qu'il sera envoyé à l'utilisateur.",
'passwordreset-email' => 'Adresse de courriel :',
'passwordreset-emailtitle' => 'Détails du compte sur {{SITENAME}}',
'passwordreset-emailtext-ip' => "Quelqu'un (probablement vous, depuis l'adresse IP $1) a demandé un rappel des informations de votre compte pour {{SITENAME}} ($4). {{PLURAL:$3|Le compte utilisateur suivant est associé|Les comptes utilisateurs suivants sont associés}} à cette adresse de courriel :

$2

{{PLURAL:$3|Ce mot de passe temporaire expirera|Ces mots de passe temporaires expireront}} dans {{PLURAL:$5|un jour|$5 jours}}. Vous devez maintenant vous connecter et choisir un nouveau mot de passe. Si cette demande ne provient pas de vous, ou que vous vous êtes souvenu de votre mot de passe initial, et ne souhaitez plus le modifier, vous pouvez ignorer ce message et continuer à utiliser votre ancien mot de passe.",
'passwordreset-emailtext-user' => "L'utilisateur $1 sur {{SITENAME}} a demandé un rappel des informations de votre compte pour {{SITENAME}} ($4). {{PLURAL:$3|Le compte utilisateur suivant est associé|Les comptes utilisateurs suivants sont associés}} à cette adresse de courriel :

$2

{{PLURAL:$3|Ce mot de passe temporaire expirera|Ces mots de passe temporaires expireront}} dans {{PLURAL:$5|un jour|$5 jours}}. Vous devez maintenant vous connecter et choisir un nouveau mot de passe. Si cette demande ne provient pas de vous, ou que vous vous êtes souvenu de votre mot de passe initial, et ne souhaitez plus le modifier, vous pouvez ignorer ce message et continuer à utiliser votre ancien mot de passe.",
'passwordreset-emailelement' => "Nom d'utilisateur : $1
Mot de passe temporaire : $2",
'passwordreset-emailsent' => 'Un courriel de rappel a été envoyé.',
'passwordreset-emailsent-capture' => 'Un courriel de rappel a été envoyé, qui est affiché ci-dessous.',
'passwordreset-emailerror-capture' => "Un courriel de rappel a été généré, qui est affiché ci-dessous, mais l'envoi à l'utilisateur a échoué : $1",

# Special:ChangeEmail
'changeemail' => "Changer l'adresse de courriel",
'changeemail-header' => "Changer l'adresse de courriel du compte",
'changeemail-text' => 'Remplissez ce formulaire pour changer votre adresse de courriel. Vous devrez entrer votre mot de passe pour confirmer ce changement.',
'changeemail-no-info' => 'Vous devez être connecté pour pouvoir accéder directement à cette page.',
'changeemail-oldemail' => 'Adresse de courriel actuelle :',
'changeemail-newemail' => 'Nouvelle adresse de courriel :',
'changeemail-none' => '(aucune)',
'changeemail-submit' => "Changer l'adresse de courriel",
'changeemail-cancel' => 'Annuler',

# Edit page toolbar
'bold_sample' => 'Texte gras',
'bold_tip' => 'Texte gras',
'italic_sample' => 'Texte italique',
'italic_tip' => 'Texte italique',
'link_sample' => 'Titre du lien',
'link_tip' => 'Lien interne',
'extlink_sample' => 'http://www.example.com titre du lien',
'extlink_tip' => "Lien externe (n'oubliez pas le préfixe http://)",
'headline_sample' => 'Texte du titre',
'headline_tip' => 'Sous-titre niveau 2',
'nowiki_sample' => 'Entrez le texte non formaté ici',
'nowiki_tip' => 'Ignorer la syntaxe wiki',
'image_sample' => 'Exemple.jpg',
'image_tip' => 'Fichier inséré',
'media_sample' => 'Exemple.ogg',
'media_tip' => 'Lien vers un fichier média',
'sig_tip' => 'Votre signature avec la date',
'hr_tip' => 'Ligne horizontale (ne pas en abuser)',

# Edit pages
'summary' => 'Résumé :',
'subject' => 'Sujet / titre :',
'minoredit' => 'Modification mineure',
'watchthis' => 'Suivre cette page',
'savearticle' => 'Publier',
'preview' => 'Prévisualisation',
'showpreview' => 'Prévisualiser',
'showlivepreview' => 'Aperçu rapide',
'showdiff' => 'Modifications en cours',
'anoneditwarning' => "'''Attention :''' vous n'êtes pas identifié(e). Votre adresse IP sera enregistrée dans l'historique de cette page.",
'anonpreviewwarning' => "''Vous n'êtes pas identifié. Sauvegarder enregistrera votre adresse IP dans l'historique des modifications de la page.''",
'missingsummary' => "'''Rappel :''' vous n'avez pas encore fourni le résumé de votre modification.
Si vous cliquez de nouveau sur le bouton « {{int:savearticle}} », la publication sera faite sans nouvel avertissement.",
'missingcommenttext' => 'Veuillez entrer un commentaire ci-dessous.',
'missingcommentheader' => "'''Rappel :''' vous n'avez pas fourni de sujet ou de titre à ce commentaire.
Si vous cliquez de nouveau sur « {{int:Savearticle}} », votre modification sera enregistrée sans titre.",
'summary-preview' => 'Aperçu du résumé :',
'subject-preview' => 'Prévisualisation du sujet/titre :',
'blockedtitle' => "L'utilisateur est bloqué.",
'blockedtext' => "'''Votre compte utilisateur ou votre adresse IP a été bloqué.'''

Le blocage a été effectué par $1.
La raison invoquée est la suivante : ''$2''.

* Début du blocage : $8
* Expiration du blocage : $6
* Compte bloqué : $7.

Vous pouvez contacter $1 ou un autre [[{{MediaWiki:Grouppage-sysop}}|administrateur]] pour en discuter.
Vous ne pouvez utiliser la fonction « {{MediaWiki:emailpage}} » que si une adresse de courriel valide est spécifiée dans vos [[Special:Preferences|préférences]] et que cette fonctionnalité n'a pas été bloquée.
Votre adresse IP actuelle est $3 et votre identifiant de blocage est $5.
Veuillez préciser ces indications dans toutes les requêtes que vous ferez.",
'autoblockedtext' => "Votre adresse IP a été bloquée automatiquement car elle a été utilisée par un autre utilisateur, lui-même bloqué par $1.
La raison invoquée est :

:''$2''

* Début du blocage : $8
* Expiration du blocage : $6
* Compte bloqué : $7

Vous pouvez contacter $1 ou l'un des autres [[{{MediaWiki:Grouppage-sysop}}|administrateurs]] pour discuter de ce blocage.

Notez que vous ne pourrez utiliser la fonctionnalité d'envoi de courriel que si vous avez une adresse de courriel validée dans vos [[Special:Preferences|préférences]] et que la fonctionnalité n'a pas été désactivée.

Votre adresse IP actuelle est $3, et le numéro de blocage est $5.
Veuillez préciser ces indications dans toutes les requêtes que vous ferez.",
'blockednoreason' => 'aucune raison donnée',
'whitelistedittext' => 'Vous devez être $1 pour avoir la permission de modifier le contenu.',
'confirmedittext' => 'Vous devez confirmer votre adresse de courriel avant de modifier les pages.
Veuillez entrer et valider votre adresse de courriel dans vos [[Special:Preferences|préférences]].',
'nosuchsectiontitle' => 'Impossible de trouver la section',
'nosuchsectiontext' => "Vous avez essayé de modifier une section qui n'existe pas.
Elle a peut-être été déplacée ou supprimée depuis que vous avez lu cette page.",
'loginreqtitle' => 'Connexion nécessaire',
'loginreqlink' => 'connecter',
'loginreqpagetext' => 'Vous devez vous $1 pour voir les autres pages.',
'accmailtitle' => 'Mot de passe envoyé.',
'accmailtext' => "Un mot de passe généré aléatoirement pour [[User talk:$1|$1]] a été envoyé à $2.
Le mot de passe pour ce nouveau compte peut être changé sur la page ''[[Special:ChangePassword|de changement de mot de passe]]'' après s'être connecté.",
'newarticle' => '(Nouveau)',
'newarticletext' => "Vous avez suivi un lien vers une page qui n'existe pas encore ou qui a été [{{fullurl:Special:Log|type=delete&page={{FULLPAGENAMEE}}}} effacée].
Pour créer cette page, entrez votre texte dans la boîte ci-dessous (vous pouvez consulter [[{{MediaWiki:Helppage}}|la page d'aide]] pour plus d'informations).
Si vous êtes arrivé{{GENDER:||e|(e)}} ici par erreur, cliquez sur le bouton '''retour''' de votre navigateur.",
'anontalkpagetext' => "---- ''Vous êtes sur la page de discussion d'un utilisateur anonyme qui n'a pas encore créé de compte ou qui n'en utilise pas. Pour cette raison, nous devons utiliser son adresse IP pour l'identifier. Une adresse IP peut être partagée par plusieurs utilisateurs. Si vous êtes un{{GENDER:||e|}} utilisat{{GENDER:|eur|rice|eur}} anonyme et si vous constatez que des commentaires qui ne vous concernent pas vous ont été adressés, vous pouvez [[Special:UserLogin/signup|créer un compte]] ou [[Special:UserLogin|vous connecter]] afin d'éviter toute confusion future avec d'autres contributeurs anonymes.''",
'noarticletext' => 'Il n\'y a pour l\'instant aucun texte sur cette page.
Vous pouvez [[Special:Search/{{PAGENAME}}|lancer une recherche sur ce titre]] dans les autres pages,
<span class="plainlinks">[{{fullurl:{{#Special:Log}}|page={{FULLPAGENAMEE}}}} rechercher dans les opérations liées]
ou [{{fullurl:{{FULLPAGENAME}}|action=edit}} créer cette page]</span>.',
'noarticletext-nopermission' => 'Il n\'y a pour l\'instant aucun texte sur cette page.
Vous pouvez [[Special:Search/{{PAGENAME}}|faire une recherche sur ce titre]] dans les autres pages,
ou <span class="plainlinks">[{{fullurl:{{#Special:Log}}|page={{FULLPAGENAMEE}}}} rechercher dans les journaux associés]</span>.',
'missing-revision' => "La révision n° $1 de la page intitulée « {{PAGENAME}} » n'existe pas.

Cela survient en général en suivant un lien historique obsolète vers une page qui a été supprimée.
Vous pouvez trouver plus de détails dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des suppressions].",
'userpage-userdoesnotexist' => "Le compte utilisateur « <nowiki>$1</nowiki> » n'est pas enregistré. Veuillez vérifier que vous voulez créer cette page.",
'userpage-userdoesnotexist-view' => "Le compte utilisateur « $1 » n'est pas enregistré.",
'blocked-notice-logextract' => "Cet utilisateur est actuellement bloqué.
La dernière entrée du journal des blocages est indiquée ci-dessous à titre d'information :",
'clearyourcache' => "'''Note :''' après avoir enregistré vos préférences, vous devrez forcer le rechargement complet du cache de votre navigateur pour voir les changements.
* '''Firefox / Safari :''' Maintenez la touche ''Maj'' (''Shift'') en cliquant sur le bouton ''Actualiser'' ou pressez ''Ctrl-F5'' ou ''Ctrl-R'' (''⌘-R'' sur un Mac) ;
* '''Google Chrome :''' Appuyez sur ''Ctrl-Maj-R'' (''⌘-Shift-R'' sur un Mac) ;
* '''Internet Explorer :''' Maintenez la touche ''Ctrl'' en cliquant sur le bouton ''Actualiser'' ou pressez ''Ctrl-F5'' ;
* '''Opera :''' Videz le cache dans ''Outils → Préférences''.",
'usercssyoucanpreview' => "'''Astuce :''' utilisez le bouton « {{int:showpreview}} » pour tester votre nouvelle feuille CSS avant de l'enregistrer.",
'userjsyoucanpreview' => "'''Astuce :''' utilisez le bouton « {{int:showpreview}} » pour tester votre nouvelle feuille JavaScript avant de l'enregistrer.",
'usercsspreview' => "'''Rappelez-vous que vous n'êtes qu'en train de prévisualiser votre propre feuille CSS.'''
'''Elle n'a pas encore été enregistrée !'''",
'userjspreview' => "'''Rappelez-vous que vous êtes en train de visualiser ou de tester votre code JavaScript et qu'il n'a pas encore été enregistré !'''",
'sitecsspreview' => "'''Souvenez-vous que vous êtes seulement en train de prévisualiser cette feuille de style.'''
'''Elle n'a pas encore été enregistrée !'''",
'sitejspreview' => "'''Souvenez-vous que vous êtes seulement en train de prévisualiser ce code JavaScript.'''
'''Il n'a pas encore été enregistré !'''",
'userinvalidcssjstitle' => "'''Attention :''' il n'existe pas d'habillage « $1 ». Rappelez-vous que les pages personnelles avec extensions .css et .js utilisent des titres en minuscules, par exemple {{ns:user}}:Foo/vector.css et non {{ns:user}}:Foo/Vector.css.",
'updated' => '(Mis à jour)',
'note' => "'''Note :'''",
'previewnote' => "'''Rappelez-vous que ce n'est qu'une prévisualisation.'''
Vos modifications n'ont pas encore été enregistrées !",
'continue-editing' => 'Aller à la zone de modification',
'previewconflict' => "Cette prévisualisation montre le texte de la boîte supérieure de modification tel qu'il apparaîtra si vous choisissez de le publier.",
'session_fail_preview' => "'''Nous ne pouvons enregistrer votre modification à cause d'une perte d'informations concernant votre session.'''
Veuillez réessayer.
Si cela échoue de nouveau, essayez en vous [[Special:UserLogout|déconnectant]], puis en vous reconnectant.",
'session_fail_preview_html' => "'''Nous ne pouvons enregistrer votre modification à cause d'une perte d'informations concernant votre session.'''

''Parce que {{SITENAME}} a activé le HTML brut, la prévisualisation a été masquée afin de prévenir les attaques par JavaScript.''

'''Si la tentative de modification était légitime, veuillez réessayer.'''
Si cela échoue de nouveau, [[Special:UserLogout|déconnectez-vous]], puis reconnectez-vous.",
'token_suffix_mismatch' => "'''Votre modification n'a pas été acceptée car votre navigateur a mal codé les caractères de ponctuation dans l'identifiant de modification.'''
Ce rejet est nécessaire pour empêcher la corruption du texte de la page.
Ce problème se produit parfois lorsque vous utilisez un serveur mandataire anonyme problématique basé sur le web.",
'edit_form_incomplete' => "'''Certaines parties du formulaire de modification n'ont pas atteint le serveur, vérifiez que vos modifications sont intactes et essayez à nouveau.'''",
'editing' => 'Modification de $1',
'creating' => 'Création de $1',
'editingsection' => 'Modification de $1 (section)',
'editingcomment' => 'Modification de $1 (nouvelle section)',
'editconflict' => 'Conflit de modification : $1',
'explainconflict' => "Cette page a été changée après que vous ayez commencé à la modifier.
La zone de modification supérieure contient le texte tel qu'il est actuellement enregistré dans la base de données.
Vos modifications apparaissent dans la zone de modification inférieure.
Vous allez devoir fusionner vos modifications dans le texte existant.
'''Seul''' le texte de la zone supérieure sera sauvegardé si vous cliquez sur « {{int:savearticle}} ».",
'yourtext' => 'Votre texte',
'storedversion' => 'La version enregistrée',
'nonunicodebrowser' => "'''Attention : Votre navigateur ne supporte pas l'Unicode.'''
Une solution de rechange a été trouvée pour vous permettre de modifier en toute sûreté une page : les caractères non-ASCII apparaîtront dans votre boîte de modification en tant que codes hexadécimaux. Vous devriez utiliser un navigateur plus récent.",
'editingold' => "'''Attention : vous êtes en train de modifier une ancienne version de cette page.
Si vous la publiez, toutes les modifications effectuées depuis cette version seront perdues.'''",
'yourdiff' => 'Différences',
'copyrightwarning' => "Toutes les contributions à {{SITENAME}} sont considérées comme publiées sous les termes de la $2 (voir $1 pour plus de détails). Si vous ne désirez pas que vos écrits soient modifiés et distribués à volonté, merci de ne pas les soumettre ici.<br />
Vous nous promettez aussi que vous avez écrit ceci vous-même, ou que vous l'avez copié d'une source provenant du domaine public, ou d'une ressource libre. '''N'UTILISEZ PAS DE TRAVAUX SOUS DROIT D'AUTEUR SANS AUTORISATION EXPRESSE !'''",
'copyrightwarning2' => "Toutes les contributions à {{SITENAME}} peuvent être modifiées ou supprimées par d'autres utilisateurs. Si vous ne désirez pas que vos écrits soient modifiés et distribués à volonté, merci de ne pas les soumettre ici.<br />
Vous nous promettez aussi que vous avez écrit ceci vous-même, ou que vous l'avez copié d'une source provenant du domaine public, ou d'une ressource libre. (voir $1 pour plus de détails).
'''N'UTILISEZ PAS DE TRAVAUX SOUS DROIT D'AUTEUR SANS AUTORISATION EXPRESSE !'''",
'longpageerror' => "'''Erreur: Le texte que vous avez soumis fait {{PLURAL:$1|un Kio|$1 Kio}}, ce qui dépasse la limite fixée à {{PLURAL:$2|un Kio|$2 Kio}}.'''
Il ne peut pas être sauvegardé.",
'readonlywarning' => "'''AVERTISSEMENT : la base de données a été verrouillée pour des opérations de maintenance. Vous ne pouvez donc pas publier vos modifications pour l'instant.'''
Vous pouvez copier le texte dans un fichier texte et le conserver pour plus tard.

L'administrateur ayant verrouillé la base de données a donné l'explication suivante : $1",
'protectedpagewarning' => "'''AVERTISSEMENT : cette page est protégée. Seuls les utilisateurs ayant le statut d'administrateur peuvent la modifier.'''<br />
La dernière entrée du journal est affichée ci-dessous pour référence :",
'semiprotectedpagewarning' => "'''Note :''' Cette page a été protégée de telle façon que seuls les contributeurs enregistrés puissent la modifier. La dernière entrée du journal est affichée ci-dessous pour référence :",
'cascadeprotectedwarning' => "'''ATTENTION :''' Cette page a été protégée de manière à ce que seuls les administrateurs puissent l'éditer. Cette protection est héritée par son inclusion par {{PLURAL:$1|la page protégée suivante, qui a|les pages protégées suivantes, qui ont}} la « protection en cascade » activée :",
'titleprotectedwarning' => "'''ATTENTION : Cette page a été protégée de telle manière que des [[Special:ListGroupRights|droits spécifiques]] sont requis pour pouvoir la créer.''' La dernière entrée du journal est affichée ci-dessous pour référence :",
'templatesused' => '{{PLURAL:$1|Modèle utilisé|Modèles utilisés}} par cette page :',
'templatesusedpreview' => '{{PLURAL:$1|Modèle utilisé|Modèles utilisés}} dans cette prévisualisation :',
'templatesusedsection' => '{{PLURAL:$1|Modèle utilisé|Modèles utilisés}} dans cette section :',
'template-protected' => '(protégé)',
'template-semiprotected' => '(semi-protégé)',
'hiddencategories' => '{{PLURAL:$1|Catégorie cachée|Catégories cachées}} dont cette page fait partie :',
'edittools' => '<!-- Tout texte entré ici sera affiché sous les boîtes de modification ou les formulaires de téléversement de fichier. -->',
'nocreatetitle' => 'Création de page limitée',
'nocreatetext' => '{{SITENAME}} a restreint la possibilité de créer de nouvelles pages.
Vous pouvez revenir en arrière et modifier une page existante, ou bien [[Special:UserLogin|vous connecter ou créer un compte]].',
'nocreate-loggedin' => "Vous n'avez pas la permission de créer de nouvelles pages.",
'sectioneditnotsupported-title' => 'Modification de section non prise en charge',
'sectioneditnotsupported-text' => "La modification d'une section n'est pas prise en charge pour cette page.",
'permissionserrors' => 'Erreur de permissions',
'permissionserrorstext' => "Vous n'avez pas la permission d'effectuer l'opération demandée pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :",
'permissionserrorstext-withaction' => "Vous n'êtes pas autorisé{{GENDER:||e|(e)}} à $2, pour {{PLURAL:$1|la raison suivante|les raisons suivantes}} :",
'recreate-moveddeleted-warn' => "'''Attention : vous êtes en train de recréer une page qui a été précédemment supprimée.'''

Assurez-vous qu'il est pertinent de poursuivre les modifications sur cette page. Le journal des suppressions et des déplacements est affiché ci-dessous :",
'moveddeleted-notice' => 'Cette page a été supprimée. Le journal des suppressions et des déplacements est affiché ci-dessous pour référence.',
'log-fulllog' => 'Voir le journal complet',
'edit-hook-aborted' => 'Échec de la modification par une extension.
Cause inconnue',
'edit-gone-missing' => "N'a pas pu mettre à jour la page.
Il semble qu'elle ait été supprimée.",
'edit-conflict' => 'Conflit de modification.',
'edit-no-change' => "Votre modification a été ignorée car aucun changement n'a été fait au texte.",
'edit-already-exists' => "La nouvelle page n'a pas pu être créée.
Elle existe déjà.",
'defaultmessagetext' => 'Message par défaut',

# Parser/template warnings
'expensive-parserfunction-warning' => "Attention : cette page contient de trop nombreux appels à des fonctions coûteuses de l'analyseur syntaxique.

Il devrait y avoir moins de $2 appel{{PLURAL:$2||s}}, alors qu'il y en a maintenant $1.",
'expensive-parserfunction-category' => "Pages avec trop d'appels dispendieux de fonctions de l'analyseur syntaxique",
'post-expand-template-inclusion-warning' => "Attention : Cette page contient trop d'inclusions de modèles. Certaines inclusions ne seront pas effectuées.",
'post-expand-template-inclusion-category' => "Pages contenant trop d'inclusions de modèles",
'post-expand-template-argument-warning' => "Attention : Cette page contient au moins un paramètre de modèle dont l'inclusion est rendue impossible. Après extension, celui-ci aurait produit un résultat trop long, il n'a donc pas été inclus.",
'post-expand-template-argument-category' => 'Pages contenant des paramètres de modèle non évalués',
'parser-template-loop-warning' => 'Modèle en boucle détecté : [[$1]]',
'parser-template-recursion-depth-warning' => 'Limite de profondeur des appels de modèles dépassée ($1)',
'language-converter-depth-warning' => 'Limite de profondeur du convertisseur de langue dépassée ($1)',
'node-count-exceeded-category' => 'Pages où nombre de nœuds est dépassé',
'node-count-exceeded-warning' => 'Page dépassant le nombre de nœuds',
'expansion-depth-exceeded-category' => "Pages où la profondeur d'expansion est dépassée",
'expansion-depth-exceeded-warning' => "Page dépassant la profondeur d'expansion",
'parser-unstrip-loop-warning' => 'Boucle non démontable détectée',
'parser-unstrip-recursion-limit' => 'Limite de récursion non démontable dépassée ($1)',
'converter-manual-rule-error' => 'Erreur détectée dans la règle manuelle de conversion de langue',

# "Undo" feature
'undo-success' => "Cette modification va être défaite. Veuillez vérifier les modifications ci-dessous, puis publier si c'est bien ce que vous voulez faire.",
'undo-failure' => 'Cette modification ne peut pas être défaite : cela entrerait en conflit avec les modifications intermédiaires.',
'undo-norev' => "La modification n'a pas pu être défaite parce qu'elle est inexistante ou qu'elle a été supprimée.",
'undo-summary' => 'Annulation des modifications $1 de [[Special:Contributions/$2|$2]] ([[User talk:$2|discussion]])',

# Account creation failure
'cantcreateaccounttitle' => 'Vous ne pouvez pas créer de compte.',
'cantcreateaccount-text' => "La création de compte depuis cette adresse IP (<b>$1</b>) a été bloquée par [[User:$3|$3]].

La raison donnée était ''$2''.",

# History pages
'viewpagelogs' => 'Voir les opérations sur cette page',
'nohistory' => "Il n'existe pas d'historique pour cette page.",
'currentrev' => 'Version actuelle',
'currentrev-asof' => 'Version actuelle en date du $1',
'revisionasof' => 'Version du $1',
'revision-info' => 'Version du $1 par $2',
'previousrevision' => '← Version précédente',
'nextrevision' => 'Version suivante →',
'currentrevisionlink' => 'Voir la version courante',
'cur' => 'actu',
'next' => 'suivant',
'last' => 'diff',
'page_first' => 'première',
'page_last' => 'dernière',
'histlegend' => 'Légende : ({{int:cur}}) = différence avec la version actuelle, ({{int:last}}) = différence avec la version précédente, <b>{{int:minoreditletter}}</b> = modification mineure',
'history-fieldset-title' => "Naviguer dans l'historique",
'history-show-deleted' => 'Masqués seulement',
'histfirst' => 'première page',
'histlast' => 'dernière page',
'historysize' => '($1 octet{{PLURAL:$1||s}})',
'historyempty' => '(vide)',

# Revision feed
'history-feed-title' => 'Historique des versions',
'history-feed-description' => 'Historique pour cette page sur le wiki',
'history-feed-item-nocomment' => '$1 le $2',
'history-feed-empty' => "La page demandée n'existe pas.
Elle a peut-être été effacée ou renommée.
Essayez de [[Special:Search|rechercher sur le wiki]] pour trouver des pages en rapport.",

# Revision deletion
'rev-deleted-comment' => '(résumé de modification retiré)',
'rev-deleted-user' => '(nom d’utilisateur retiré)',
'rev-deleted-event' => '(entrée retirée)',
'rev-deleted-user-contribs' => '[nom d’utilisateur ou adresse IP retiré - modification masquée sur les contributions]',
'rev-deleted-text-permission' => "Cette version de la page a été '''effacée'''.
Des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des effacements].",
'rev-deleted-text-unhide' => "Cette version de la page a été '''effacée'''.
Des détails sont disponibles dans [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} le journal des effacements].
Vous pouvez toujours [$1 voir cette version] si vous le voulez.",
'rev-suppressed-text-unhide' => "Cette version de la page a été '''supprimée'''.
Des détails sont disponibles dans [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} le journal des suppression].
Vous pouvez toujours [$1 voir cette version] si vous le voulez.",
'rev-deleted-text-view' => "Cette version de la page a été '''effacée'''.
Vous pouvez la visualiser ; des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des effacements].",
'rev-suppressed-text-view' => "Cette version de la page a été '''supprimée'''.
Vous pouvez la visualiser ; des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} journal des suppressions].",
'rev-deleted-no-diff' => "Vous ne pouvez pas voir ce diff parce qu'une des versions a été '''effacée'''.
Des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des effacements].",
'rev-suppressed-no-diff' => "Vous ne pouvez pas voir cette différence car une des révisions a été '''supprimée'''.",
'rev-deleted-unhide-diff' => "Une des révisions de cette différence a été '''effacée'''.
Des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des effacements].
Vous pouvez toujours [$1 voir cette différence] si vous le voulez.",
'rev-suppressed-unhide-diff' => "L'une des révisions de ce diff a été '''supprimée'''.
Des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} journal des suppressions].
Vous pouvez toujours [$1 voir ce diff] si vous souhaitez poursuivre.",
'rev-deleted-diff-view' => "Une des révisions de ce diff a été '''supprimée'''.
Vous pouvez voir ce diff ; des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des suppressions].",
'rev-suppressed-diff-view' => "Une des révisions de ce diff a été '''effacée'''.
Vous pouvez voir ce diff ; des détails sont disponibles dans le [{{fullurl:{{#Special:Log}}/suppress|page={{FULLPAGENAMEE}}}} journal des effacements].",
'rev-delundel' => 'afficher/masquer',
'rev-showdeleted' => 'afficher',
'revisiondelete' => 'Supprimer ou restaurer des événements',
'revdelete-nooldid-title' => 'Version cible non valide',
'revdelete-nooldid-text' => "Vous n'avez pas précisé la version cible de cette fonction, elle n'existe pas, ou il s'agit de la version actuelle.",
'revdelete-nologtype-title' => 'Aucun type de journal spécifié',
'revdelete-nologtype-text' => "Vous n'avez pas spécifié un type de journal sur lequel cette action doit être réalisée.",
'revdelete-nologid-title' => 'Entrée du journal invalide',
'revdelete-nologid-text' => "Vous n'avez pas spécifié une entrée du journal sur laquelle cette action doit être effectuée, ou alors l'événement spécifié n'existe pas.",
'revdelete-no-file' => "Le fichier spécifié n'existe pas.",
'revdelete-show-file-confirm' => 'Êtes-vous sûr de vouloir voir la révision supprimée du fichier « <nowiki>$1</nowiki> » datant du $2 à $3 ?',
'revdelete-show-file-submit' => 'Oui',
'revdelete-selected' => "'''{{PLURAL:$2|Version sélectionnée|Versions sélectionnées}} de '''[[:$1]]''' :'''",
'logdelete-selected' => "'''{{PLURAL:$1|Événement d'historique sélectionné|Événements d'historique sélectionnés}} :'''",
'revdelete-text' => "'''Les versions et événements supprimés seront encore présents dans l'historique de la page et dans les journaux, mais leur contenu textuel sera inaccessible au public.'''
Les autres administrateurs de {{SITENAME}} pourront toujours accéder au contenu caché et le restaurer à travers cette même interface, à moins que des restrictions supplémentaires ne soient mises en place.",
'revdelete-confirm' => 'Confirmez que vous voulez effectuer cette action, que vous en comprenez les conséquences, et que vous le faites en accord avec [[{{MediaWiki:Policy-url}}|les règles]].',
'revdelete-suppress-text' => "La suppression ne doit être utilisée '''que''' dans les cas suivants :
* Informations personnelles inappropriées
*: ''adresse, numéro de téléphone, numéro de sécurité sociale, …''",
'revdelete-legend' => 'Mettre en place des restrictions de visibilité :',
'revdelete-hide-text' => 'Masquer le texte de la version',
'revdelete-hide-image' => 'Masquer le contenu du fichier',
'revdelete-hide-name' => "Masquer l'action et la cible",
'revdelete-hide-comment' => 'Masquer le commentaire de modification',
'revdelete-hide-user' => "Masquer le pseudo ou l'adresse IP du contributeur.",
'revdelete-hide-restricted' => "Supprimer ces données aux administrateurs ainsi qu'aux autres",
'revdelete-radio-same' => '(ne pas changer)',
'revdelete-radio-set' => 'Oui',
'revdelete-radio-unset' => 'Non',
'revdelete-suppress' => 'Masquer également les données pour les administrateurs',
'revdelete-unsuppress' => 'Enlever les restrictions sur les versions restaurées',
'revdelete-log' => 'Motif :',
'revdelete-submit' => 'Appliquer {{PLURAL:$1|à la révision sélectionnée|aux révisions sélectionnées}}',
'revdelete-success' => "'''Visibilité des versions mise à jour avec succès.'''",
'revdelete-failure' => "'''La visibilité de la version n'a pas pu être mise à jour :'''
$1",
'logdelete-success' => "'''Visibilité du journal paramétrée avec succès.'''",
'logdelete-failure' => "'''La visibilité du journal n'a pas pu être définie :'''
$1",
'revdel-restore' => 'modifier la visibilité',
'revdel-restore-deleted' => 'révisions supprimées',
'revdel-restore-visible' => 'révisions visibles',
'pagehist' => 'Historique de la page',
'deletedhist' => 'Historique supprimé',
'revdelete-hide-current' => "Erreur lors de la suppression de l'élément daté du $1 à $2 : il est la révision courante.
Il ne peut pas être supprimé.",
'revdelete-show-no-access' => "Erreur lors de l'affichage de l'élément daté du $1 à $2 : il est marqué comme « restreint ».
Vous n'y avez pas accès.",
'revdelete-modify-no-access' => "Erreur lors de la modification de l'élément daté du $1 à $2 : il est marqué comme « restreint ».
Vous n'y avez pas accès.",
'revdelete-modify-missing' => "Erreur lors de la modification de l'élément avec l'ID $1 : il est manquant dans la base de données !",
'revdelete-no-change' => "'''Attention :''' L'élément daté du $1 à $2 a déjà les paramètres de visibilité demandés.",

'revdelete-concurrent-change' => "Erreur lors de la modification de l'élément daté du $1 à $2 : son statut a été changé par quelqu'un d'autre pendant que vous le modifiez.
Vérifiez les journaux.",
'revdelete-only-restricted' => "Erreur lors de la suppression de l'entrée datée du $1 à $2 : vous ne pouvez pas supprimer ces éléments aux administrateurs sans également sélectionner des autres options de suppression.",
'revdelete-reason-dropdown' => "* Raisons courantes de suppression :
** Violation des droits d'auteurs ;
** Commentaires ou renseignements personnels inappropriés ;
** Informations potentiellement diffamatoires.",
'revdelete-otherreason' => 'Autre raison / raison supplémentaire :',
'revdelete-reasonotherlist' => 'Autre raison',
'revdelete-edit-reasonlist' => 'Modifier les motifs fréquents de suppression',
'revdelete-offender' => 'Auteur de la révision :',

# Suppression log
'suppressionlog' => 'Journal des suppressions',
'suppressionlogtext' => 'Voici la liste des suppressions et des blocages qui portent sur du contenu caché aux administrateurs.
Voir la [[Special:BlockList|liste des blocages]] pour la liste des bannissements et des blocages actuellement opérationnels.',

# History merging
'mergehistory' => 'Fusionner les historiques des pages',
'mergehistory-header' => "Cette page vous permet de fusionner des versions de l'historique d'une page d'origine vers une nouvelle page.
Assurez-vous que cette opération conservera la continuité de l'historique de la page.",
'mergehistory-box' => 'Fusionner les versions de deux pages :',
'mergehistory-from' => "Page d'origine :",
'mergehistory-into' => 'Page de destination :',
'mergehistory-list' => 'Historique fusionnable des modifications',
'mergehistory-merge' => "Les versions suivantes de [[:$1]] peuvent être fusionnées avec [[:$2]]. Utilisez la colonne de boutons radio pour fusionner uniquement les versions créées du début jusqu'à la date indiquée. Notez bien que l'utilisation des liens de navigation réinitialisera cette colonne.",
'mergehistory-go' => 'Voir les modifications qui peuvent être fusionnées',
'mergehistory-submit' => 'Fusionner les versions',
'mergehistory-empty' => 'Aucune version ne peut être fusionnée.',
'mergehistory-success' => '$3 version{{PLURAL:$3||s}} de [[:$1]] fusionnée{{PLURAL:$3||s}} dans [[:$2]].',
'mergehistory-fail' => 'Impossible de procéder à la fusion des historiques. Resélectionner la page ainsi que les paramètres de date.',
'mergehistory-no-source' => "La page d'origine $1 n'existe pas.",
'mergehistory-no-destination' => "La page de destination $1 n'existe pas.",
'mergehistory-invalid-source' => "La page d'origine doit avoir un titre valide.",
'mergehistory-invalid-destination' => 'La page de destination doit avoir un titre valide.',
'mergehistory-autocomment' => '[[:$1]] fusionnée avec [[:$2]]',
'mergehistory-comment' => '[[:$1]] fusionnée avec [[:$2]] : $3',
'mergehistory-same-destination' => "Les pages d'origine et de destination ne peuvent pas être la même",
'mergehistory-reason' => 'Motif :',

# Merge log
'mergelog' => 'Journal des fusions',
'pagemerge-logentry' => "[[$1]] fusionnée avec [[$2]] (versions jusqu'au $3)",
'revertmerge' => 'Séparer',
'mergelogpagetext' => "Voici la liste des fusions de l'historique d'une page dans celui d'une autre les plus récentes.",

# Diffs
'history-title' => '$1 : Historique des versions',
'difference-title' => '$1 : Différence entre versions',
'difference-title-multipage' => 'Différences entre les pages « $1 » et « $2 »',
'difference-multipage' => '(Différence entre les pages)',
'lineno' => 'Ligne $1 :',
'compareselectedversions' => 'Comparer les versions sélectionnées',
'showhideselectedversions' => 'Afficher/masquer les versions sélectionnées',
'editundo' => 'défaire',
'diff-multi' => '({{PLURAL:$1|Une révision intermédiaire|$1 révisions intermédiaires}} par {{PLURAL:$2|un utilisateur|$2 utilisateurs}} {{PLURAL:$1|est masquée|sont masquées}})',
'diff-multi-manyusers' => "({{PLURAL:$1|Une révision intermédiaire|$1 révisions intermédiaires}} par plus {{PLURAL:$2|d'un utilisateur|de $2 utilisateurs}} {{PLURAL:$1|est masquée|sont masquées}})",
'difference-missing-revision' => "{{PLURAL:$2|Une révision|$2 révisions}} de cette différence ($1) {{PLURAL:$2|n'a pas été trouvée|n'ont pas été trouvées}}.

Cela survient en général en suivant un lien de différence obsolète vers une page qui a été supprimée.
Vous pouvez trouver des détails dans le [{{fullurl:{{#Special:Log}}/delete|page={{FULLPAGENAMEE}}}} journal des suppressions].",

# Search results
'searchresults' => 'Résultats de la recherche',
'searchresults-title' => 'Résultats de recherche pour « $1 »',
'searchresulttext' => "Pour plus d'informations sur la recherche dans {{SITENAME}}, voir [[{{MediaWiki:Helppage}}|{{int:help}}]].",
'searchsubtitle' => "Vous avez recherché « '''[[:$1]]''' » ([[Special:Prefixindex/$1|toutes les pages commençant par « $1 »]]{{int:pipe-separator}}[[Special:WhatLinksHere/$1|toutes les pages qui ont un lien vers « $1 »]])",
'searchsubtitleinvalid' => "Vous avez recherché « '''$1''' »",
'toomanymatches' => "Un trop grand nombre d'occurrences a été renvoyé, veuillez soumettre une requête différente.",
'titlematches' => 'Correspondances dans les titres des pages',
'notitlematches' => 'Aucun titre de page ne correspond à la recherche.',
'textmatches' => 'Correspondances dans le texte des pages',
'notextmatches' => 'Aucun texte de page ne correspond à la recherche.',
'prevn' => '{{PLURAL:$1|précédente|$1 précédentes}}',
'nextn' => '{{PLURAL:$1|suivante|$1 suivantes}}',
'prevn-title' => '$1 {{PLURAL:$1|résultat précédent|résultats précédents}}',
'nextn-title' => '$1 {{PLURAL:$1|résultat suivant|résultats suivants}}',
'shown-title' => 'Afficher $1 résultat{{PLURAL:$1||s}} par page',
'viewprevnext' => 'Voir ($1 {{int:pipe-separator}} $2) ($3).',
'searchmenu-legend' => 'Options de recherche',
'searchmenu-exists' => "'''Il existe une page nommée « [[:$1]] » sur ce wiki'''",
'searchmenu-new' => "'''Créer la page « [[:$1|$1]] » sur ce wiki !'''",
'searchhelp-url' => 'Help:Accueil',
'searchmenu-prefix' => '[[Special:PrefixIndex/$1|Rechercher les pages commençant par ce préfixe]]',
'searchprofile-articles' => 'Pages de contenu',
'searchprofile-project' => "Pages d'aide et de projet",
'searchprofile-images' => 'Multimédia',
'searchprofile-everything' => 'Tout',
'searchprofile-advanced' => 'Recherche avancée',
'searchprofile-articles-tooltip' => 'Rechercher dans $1',
'searchprofile-project-tooltip' => 'Rechercher dans $1',
'searchprofile-images-tooltip' => 'Rechercher des fichiers multimédias',
'searchprofile-everything-tooltip' => 'Rechercher dans tout le site (y compris dans les pages de discussion)',
'searchprofile-advanced-tooltip' => 'Choisir les espaces de noms pour la recherche',
'search-result-size' => '$1 ($2 mot{{PLURAL:$2||s}})',
'search-result-category-size' => '$1 membre{{PLURAL:$1||s}} ($2 sous-catégorie{{PLURAL:$2||s}}, $3 fichier{{PLURAL:$3||s}})',
'search-result-score' => 'Pertinence : $1%',
'search-redirect' => '(redirection depuis $1)',
'search-section' => '(section $1)',
'search-suggest' => 'Essayez avec cette orthographe : $1',
'search-interwiki-caption' => 'Projets frères',
'search-interwiki-default' => 'Résultats sur $1 :',
'search-interwiki-more' => '(plus)',
'search-relatedarticle' => 'Relaté',
'mwsuggest-disable' => 'Désactiver les suggestions AJAX',
'searcheverything-enable' => 'Rechercher dans tous les espaces de noms',
'searchrelated' => 'relaté',
'searchall' => 'tout',
'showingresults' => 'Affichage de <b>$1</b> résultat{{PLURAL:$1||s}} à partir du n°<b>$2</b>.',
'showingresultsnum' => 'Affichage de <b>$3</b> résultat{{PLURAL:$3||s}} à partir du n°<b>$2</b>.',
'showingresultsheader' => "{{PLURAL:$5|Résultat '''$1'''|Résultats '''$1–$2'''}} de '''$3''' pour '''$4'''",
'nonefound' => "'''Note''' : par défaut, seuls certains espaces de noms sont utilisés pour la recherche.
Essayez en utilisant le préfixe ''all:'' pour rechercher dans tout le contenu (y compris les pages de discussion, les modèles, etc.) ou bien utilisez l'espace de noms souhaité comme préfixe.",
'search-nonefound' => "Il n'y a aucun résultat correspondant à la requête.",
'powersearch' => 'Rechercher',
'powersearch-legend' => 'Recherche avancée',
'powersearch-ns' => 'Rechercher dans les espaces de noms :',
'powersearch-redir' => 'Afficher les redirections',
'powersearch-field' => 'Rechercher',
'powersearch-togglelabel' => 'Cocher :',
'powersearch-toggleall' => 'Tout',
'powersearch-togglenone' => 'Aucune',
'search-external' => 'Recherche externe',
'searchdisabled' => 'La recherche sur {{SITENAME}} est désactivée. En attendant la réactivation, vous pouvez effectuer une recherche via Google. Attention, leur indexation du contenu de {{SITENAME}} peut ne pas être à jour.',

# Quickbar
'qbsettings' => "Barre d'outils",
'qbsettings-none' => 'Aucune',
'qbsettings-fixedleft' => 'Gauche',
'qbsettings-fixedright' => 'Droite',
'qbsettings-floatingleft' => 'Flottante à gauche',
'qbsettings-floatingright' => 'Flottante à droite',
'qbsettings-directionality' => "Fixe, en fonction de la directivité d'écriture de votre langue",

# Preferences page
'preferences' => 'Préférences',
'mypreferences' => 'Préférences',
'prefs-edits' => 'Nombre de modifications :',
'prefsnologin' => 'Non connecté',
'prefsnologintext' => 'Vous devez être <span class="plainlinks">[{{fullurl:{{#Special:UserLogin}}|returnto=$1}} connecté]</span> pour modifier vos préférences d\'utilisateur.',
'changepassword' => 'Changer de mot de passe',
'prefs-skin' => 'Habillage',
'skin-preview' => 'Prévisualiser',
'datedefault' => 'Aucune préférence',
'prefs-beta' => 'Fonctionnalités bêta',
'prefs-datetime' => 'Date et heure',
'prefs-labs' => 'Fonctionnalités « labs »',
'prefs-user-pages' => 'Pages utilisateur',
'prefs-personal' => 'Informations personnelles',
'prefs-rc' => 'Modifications récentes',
'prefs-watchlist' => 'Liste de suivi',
'prefs-watchlist-days' => 'Nombre de jours à afficher dans la liste de suivi :',
'prefs-watchlist-days-max' => '(maximum $1 jour{{PLURAL:$1||s}})',
'prefs-watchlist-edits' => 'Nombre de modifications à afficher dans la liste de suivi étendue :',
'prefs-watchlist-edits-max' => 'Nombre maximum : 1000',
'prefs-watchlist-token' => 'Jeton pour la liste de suivi :',
'prefs-misc' => 'Préférences diverses',
'prefs-resetpass' => 'Changer de mot de passe',
'prefs-changeemail' => "Changer l'adresse de courriel",
'prefs-setemail' => 'Définir une adresse de courriel',
'prefs-email' => 'Options des courriels',
'prefs-rendering' => 'Apparence',
'saveprefs' => 'Enregistrer les préférences',
'resetprefs' => 'Rétablir les préférences',
'restoreprefs' => 'Restaurer toutes les valeurs par défaut',
'prefs-editing' => 'Modification',
'prefs-edit-boxsize' => 'Taille de la fenêtre de modification.',
'rows' => 'Rangées :',
'columns' => 'Colonnes :',
'searchresultshead' => 'Recherches',
'resultsperpage' => 'Nombre de réponses par page :',
'stub-threshold' => 'Limite supérieure pour les <a href="#" class="stub">liens vers les ébauches</a> (octets) :',
'stub-threshold-disabled' => 'Désactivé',
'recentchangesdays' => 'Nombre de jours à afficher dans les modifications récentes :',
'recentchangesdays-max' => '(maximum $1 jour{{PLURAL:$1||s}})',
'recentchangescount' => 'Nombre de modifications à afficher par défaut :',
'prefs-help-recentchangescount' => "Ceci inclut les modifications récentes, les pages d'historiques et les journaux.",
'prefs-help-watchlist-token' => 'Remplissez ce champ avec une valeur secrète et un flux RSS sera généré pour votre liste de suivi.
Toute personne connaissant ce jeton pourra lire votre liste de suivi, choisissez donc une valeur sécurisée.
Voici une valeur générée aléatoirement que vous pouvez utiliser : $1',
'savedprefs' => 'Les préférences ont été sauvegardées.',
'timezonelegend' => 'Fuseau horaire :',
'localtime' => 'Heure locale :',
'timezoneuseserverdefault' => 'Utiliser la valeur par défaut du wiki ($1)',
'timezoneuseoffset' => 'Autre (spécifier le décalage)',
'timezoneoffset' => 'Décalage horaire¹ :',
'servertime' => 'Heure du serveur :',
'guesstimezone' => 'Utiliser la valeur du navigateur',
'timezoneregion-africa' => 'Afrique',
'timezoneregion-america' => 'Amérique',
'timezoneregion-antarctica' => 'Antarctique',
'timezoneregion-arctic' => 'Arctique',
'timezoneregion-asia' => 'Asie',
'timezoneregion-atlantic' => 'Océan atlantique',
'timezoneregion-australia' => 'Australie',
'timezoneregion-europe' => 'Europe',
'timezoneregion-indian' => 'Océan indien',
'timezoneregion-pacific' => 'Océan pacifique',
'allowemail' => "Autoriser l'envoi de courriels venant d'autres utilisateurs",
'prefs-searchoptions' => 'Recherche',
'prefs-namespaces' => 'Espaces de noms',
'defaultns' => 'Rechercher par défaut dans ces espaces de noms :',
'default' => 'défaut',
'prefs-files' => 'Fichiers',
'prefs-custom-css' => 'CSS personnalisé',
'prefs-custom-js' => 'JavaScript personnalisé',
'prefs-common-css-js' => 'JavaScript et CSS partagé pour tous les habillages :',
'prefs-reset-intro' => 'Vous pouvez utiliser cette page pour restaurer vos préférences aux valeurs par défaut du site. Ceci ne peut pas être défait.',
'prefs-emailconfirm-label' => 'Confirmation du courriel :',
'prefs-textboxsize' => 'Taille de la fenêtre de modification',
'youremail' => 'Courriel :',
'username' => "Nom d'utilisateur :",
'uid' => "Numéro d'utilisateur :",
'prefs-memberingroups' => 'Membre {{PLURAL:$1|du groupe|des groupes}} :',
'prefs-registration' => "Date d'inscription :",
'yourrealname' => 'Nom réel :',
'yourlanguage' => 'Langue :',
'yourvariant' => 'Variante de la langue du contenu :',
'prefs-help-variant' => 'Votre variante ou orthographe préféré dans lequel afficher les pages de contenu de ce wiki.',
'yournick' => 'Signature pour les discussions :',
'prefs-help-signature' => 'Les commentaires sur les pages de discussion doivent être signés avec « <nowiki>~~~~</nowiki> », qui sera converti par votre signature et un horodatage.',
'badsig' => 'Signature brute incorrecte.
Vérifiez les balises HTML.',
'badsiglength' => 'Votre signature est trop longue.
Elle ne doit pas dépasser $1 caractère{{PLURAL:$1||s}}.',
'yourgender' => 'Genre :',
'gender-unknown' => 'Non renseigné',
'gender-male' => 'Masculin',
'gender-female' => 'Féminin',
'prefs-help-gender' => "Facultatif : utilisé pour accorder en genre les messages de l'interface. Cette information sera publique.",
'email' => 'Courriel',
'prefs-help-realname' => 'Facultatif : si vous le spécifiez, il sera utilisé pour vous attribuer vos contributions.',
'prefs-help-email' => "L'adresse de courriel est facultative, mais elle est nécessaire pour réinitialiser votre mot de passe, si vous veniez à l'oublier.",
'prefs-help-email-others' => 'Vous pourriez aussi choisir de laisser les autres vous contacter sur votre page de discussion utilisateur sans que soit nécessaire de révéler votre identité.',
'prefs-help-email-required' => 'Une adresse de courriel est requise.',
'prefs-info' => 'Informations de base',
'prefs-i18n' => 'Internationalisation',
'prefs-signature' => 'Signature',
'prefs-dateformat' => 'Format des dates',
'prefs-timeoffset' => 'Décalage horaire',
'prefs-advancedediting' => 'Options avancées',
'prefs-advancedrc' => 'Options avancées',
'prefs-advancedrendering' => 'Options avancées',
'prefs-advancedsearchoptions' => 'Options avancées',
'prefs-advancedwatchlist' => 'Options avancées',
'prefs-displayrc' => "Options d'affichage",
'prefs-displaysearchoptions' => "Options d'affichage",
'prefs-displaywatchlist' => "Options d'affichage",
'prefs-diffs' => 'Différences',

# User preference: e-mail validation using jQuery
'email-address-validity-valid' => 'Semble valide',
'email-address-validity-invalid' => 'Une adresse valide est nécessaire !',

# User rights
'userrights' => 'Gestion des droits des utilisateurs',
'userrights-lookup-user' => "Gestion des groupes d'utilisateurs",
'userrights-user-editname' => "Entrez un nom d'utilisateur :",
'editusergroup' => "Modification des groupes d'utilisateurs",
'editinguser' => "Modification des droits de l'{{GENDER:$1|utilisateur|utilisatrice}} '''[[User:$1|$1]]''' $2",
'userrights-editusergroup' => "Modifier les groupes de l'utilisateur",
'saveusergroups' => "Enregistrer les groupes de l'utilisateur",
'userrights-groupsmember' => 'Membre de :',
'userrights-groupsmember-auto' => 'Membre implicite de :',
'userrights-groups-help' => "Vous pouvez modifier les groupes auxquels appartient cet utilisateur:
* Une case cochée signifie que l'utilisateur se trouve dans ce groupe.
* Une case non cochée signifie qu'{{GENDER:$1|il|elle}} ne s'y trouve pas.
* Un astérisque (*) indique que vous ne pouvez pas retirer ce groupe une fois que vous l'avez ajouté, ou vice-versa.",
'userrights-reason' => 'Motif :',
'userrights-no-interwiki' => "Vous n'avez pas la permission de modifier des droits d'utilisateurs sur d'autres wikis.",
'userrights-nodatabase' => "La base de donnée « $1 » n'existe pas ou n'est pas locale.",
'userrights-nologin' => "Vous devez vous [[Special:UserLogin|connecter]] avec un compte d'administrateur pour modifier des droits d'utilisateur.",
'userrights-notallowed' => "Votre compte n'a pas la permission de modifier des droits d'utilisateur.",
'userrights-changeable-col' => 'Les groupes que vous pouvez modifier',
'userrights-unchangeable-col' => 'Les groupes que vous ne pouvez pas modifier',

# Groups
'group' => 'Groupe :',
'group-user' => 'Utilisateurs',
'group-autoconfirmed' => 'Utilisateurs enregistrés',
'group-bot' => 'Robots',
'group-sysop' => 'Administrateurs',
'group-bureaucrat' => 'Bureaucrates',
'group-suppress' => 'Superviseurs',
'group-all' => '(tous)',

'group-user-member' => '{{GENDER:$1|utilisateur|utilisatrice}}',
'group-autoconfirmed-member' => '{{GENDER:$1|utilisateur enregistré|utilisatrice enregistrée}}',
'group-bot-member' => '{{GENDER:$1|robot}}',
'group-sysop-member' => '{{GENDER:$1|administrateur|administratrice}}',
'group-bureaucrat-member' => '{{GENDER:$1|bureaucrate}}',
'group-suppress-member' => '{{GENDER:$1|superviseur|superviseuse}}',

'grouppage-user' => '{{ns:project}}:Utilisateurs',
'grouppage-autoconfirmed' => '{{ns:project}}:Utilisateurs enregistrés',
'grouppage-bot' => '{{ns:project}}:Robots',
'grouppage-sysop' => '{{ns:project}}:Administrateurs',
'grouppage-bureaucrat' => '{{ns:project}}:Bureaucrates',
'grouppage-suppress' => '{{ns:project}}:Superviseurs',

# Rights
'right-read' => 'Lire les pages',
'right-edit' => 'Modifier les pages',
'right-createpage' => 'Créer des pages (qui ne sont pas des pages de discussion)',
'right-createtalk' => 'Créer des pages de discussion',
'right-createaccount' => 'Créer des comptes utilisateur',
'right-minoredit' => 'Marquer ses modifications comme mineures',
'right-move' => 'Renommer des pages',
'right-move-subpages' => 'Renommer des pages avec leurs sous-pages',
'right-move-rootuserpages' => "Renommer la page principale d'un utilisateur",
'right-movefile' => 'Renommer des fichiers',
'right-suppressredirect' => "Ne pas créer de redirection depuis le titre d'origine en renommant une page",
'right-upload' => 'Importer des fichiers',
'right-reupload' => 'Écraser un fichier existant',
'right-reupload-own' => "Écraser un fichier que l'on a soi-même importé",
'right-reupload-shared' => 'Écraser localement un fichier présent sur un dépôt partagé',
'right-upload_by_url' => 'Importer un fichier depuis une adresse URL',
'right-purge' => 'Purger le cache des pages sans demande de confirmation',
'right-autoconfirmed' => 'Modifier les pages semi-protégées',
'right-bot' => 'Être traité comme un processus automatisé',
'right-nominornewtalk' => "Ne pas déclencher la notification de nouveau message lorsqu'on effectue une modification mineure sur la page de discussion d'un utilisateur",
'right-apihighlimits' => 'Utiliser des limites plus élevées dans les requêtes API',
'right-writeapi' => "Utiliser l'API de modification du wiki",
'right-delete' => 'Supprimer des pages',
'right-bigdelete' => 'Supprimer des pages ayant un gros historique',
'right-deletelogentry' => 'Supprimer et restaurer une entrée particulière du journal',
'right-deleterevision' => "Supprimer ou restaurer une version particulière d'une page",
'right-deletedhistory' => 'Voir les entrées des historiques supprimées, mais sans leur texte',
'right-deletedtext' => 'Voir le texte supprimé et les différences entre les versions supprimées',
'right-browsearchive' => 'Rechercher des pages supprimées',
'right-undelete' => 'Restaurer une page supprimée',
'right-suppressrevision' => 'Examiner et restaurer les versions masquées aux administrateurs',
'right-suppressionlog' => 'Voir les journaux privés',
'right-block' => "Bloquer en écriture d'autres utilisateurs",
'right-blockemail' => "Empêcher un utilisateur d'envoyer des courriels",
'right-hideuser' => 'Bloquer un utilisateur en masquant son nom au public',
'right-ipblock-exempt' => "Ne pas être affecté par les IP bloquées, les blocages automatiques et les blocages de plages d'IP",
'right-proxyunbannable' => 'Ne pas être affecté par les blocages automatiques de serveurs mandataires',
'right-unblockself' => 'Se débloquer eux-mêmes',
'right-protect' => 'Modifier le niveau de protection des pages et modifier les pages protégées',
'right-editprotected' => 'Modifier les pages protégées (sans protection en cascade)',
'right-editinterface' => "Modifier l'interface utilisateur",
'right-editusercssjs' => "Modifier les fichiers CSS et JavaScript d'autres utilisateurs",
'right-editusercss' => "Modifier les fichiers CSS d'autres utilisateurs",
'right-edituserjs' => "Modifier les fichiers JavaScript d'autres utilisateurs",
'right-rollback' => "Révoquer rapidement les modifications du dernier contributeur d'une page particulière",
'right-markbotedits' => 'Marquer des modifications révoquées comme ayant été faites par un robot.',
'right-noratelimit' => 'Ne pas être affecté par les limites de taux',
'right-import' => "Importer des pages depuis d'autres wikis",
'right-importupload' => 'Importer des pages depuis un fichier',
'right-patrol' => 'Marquer des modifications des autres comme vérifiées',
'right-autopatrol' => 'Avoir ses modifications automatiquement marquées comme surveillées',
'right-patrolmarks' => 'Voir les marquages de surveillance dans les modifications récentes',
'right-unwatchedpages' => 'Voir la liste des pages non suivies',
'right-mergehistory' => 'Fusionner les historiques des pages',
'right-userrights' => "Modifier tous les droits d'un utilisateur",
'right-userrights-interwiki' => "Modifier les droits d'utilisateurs qui sont sur un autre wiki",
'right-siteadmin' => 'Verrouiller ou déverrouiller la base de données',
'right-override-export-depth' => "Exporter les pages en incluant les pages liées jusqu'à une profondeur de 5 niveaux",
'right-sendemail' => 'Envoyer un courriel aux autres utilisateurs',
'right-passwordreset' => 'Voir les courriels de réinitialisation des mots de passe',

# User rights log
'rightslog' => "Journal des modifications de droits d'utilisateurs",
'rightslogtext' => "Voici l'historique des modifications des droits des utilisateurs.",
'rightslogentry' => "a modifié les droits de l'utilisateur « $1 » de $2 à $3",
'rightslogentry-autopromote' => 'a été automatiquement promu de $2 à $3',
'rightsnone' => '(aucun)',

# Associated actions - in the sentence "You do not have permission to X"
'action-read' => 'lire cette page',
'action-edit' => 'modifier cette page',
'action-createpage' => 'créer des pages',
'action-createtalk' => 'créer des pages de discussion',
'action-createaccount' => 'créer ce compte utilisateur',
'action-minoredit' => 'marquer cette modification comme mineure',
'action-move' => 'renommer cette page',
'action-move-subpages' => 'renommer cette page et ses sous-pages',
'action-move-rootuserpages' => "renommer la page principale d'un utilisateur",
'action-movefile' => 'renommer ce fichier',
'action-upload' => 'importer ce fichier',
'action-reupload' => 'écraser ce fichier existant',
'action-reupload-shared' => 'outrepasser localement ce fichier présent sur un dépôt partagé',
'action-upload_by_url' => "importer ce fichier à partir d'une adresse URL",
'action-writeapi' => "utiliser l‘API d'écriture",
'action-delete' => 'supprimer cette page',
'action-deleterevision' => 'supprimer cette version',
'action-deletedhistory' => "voir l'historique supprimé de cette page",
'action-browsearchive' => 'rechercher des pages supprimées',
'action-undelete' => 'restaurer cette page',
'action-suppressrevision' => 'visionner et rétablir cette version supprimée',
'action-suppressionlog' => 'voir ce journal privé',
'action-block' => 'bloquer en écriture cet utilisateur',
'action-protect' => 'modifier les niveaux de protection pour cette page',
'action-rollback' => 'annuler rapidement les modifications du dernier utilisateur qui a modifié une page donnée',
'action-import' => "importer cette page à partir d'un autre wiki",
'action-importupload' => "importer cette page à partir d'un fichier",
'action-patrol' => 'marquer la modification des autres comme relue',
'action-autopatrol' => 'avoir votre modification marquée comme relue',
'action-unwatchedpages' => 'voir la liste des pages non suivies',
'action-mergehistory' => "fusionner l'historique de cette page",
'action-userrights' => "modifier tous les droits d'utilisateur",
'action-userrights-interwiki' => "modifier les droits des utilisateurs sur d'autres wikis",
'action-siteadmin' => 'verrouiller ou déverrouiller la base de données',
'action-sendemail' => 'envoyer des courriels',

# Recent changes
'nchanges' => '$1 modification{{PLURAL:$1||s}}',
'recentchanges' => 'Modifications récentes',
'recentchanges-legend' => 'Options des modifications récentes',
'recentchanges-summary' => 'Piste les changements les plus récents du wiki sur cette page.',
'recentchanges-feed-description' => 'Suivre les dernières modifications de ce wiki dans un flux.',
'recentchanges-label-newpage' => 'Cette modification a créé une nouvelle page',
'recentchanges-label-minor' => 'Cette modification est mineure',
'recentchanges-label-bot' => 'Cette modification a été effectuée par un robot.',
'recentchanges-label-unpatrolled' => "Cette modification n'a pas encore été patrouillée.",
'rcnote' => "Voici {{PLURAL:$1|la dernière modification effectuée|les $1 dernières modifications effectuées}} durant {{PLURAL:$2|la dernière journée|les <b>$2</b> derniers jours}} jusqu'à $5 le $4.",
'rcnotefrom' => "Voici les modifications effectuées depuis le '''$2''' ('''$1''' au maximum).",
'rclistfrom' => 'Afficher les nouvelles modifications depuis le $1.',
'rcshowhideminor' => '$1 les modifications mineures',
'rcshowhidebots' => '$1 les robots',
'rcshowhideliu' => '$1 les utilisateurs inscrits',
'rcshowhideanons' => '$1 les utilisateurs anonymes',
'rcshowhidepatr' => '$1 les modifications surveillées',
'rcshowhidemine' => '$1 mes modifications',
'rclinks' => 'Afficher les $1 dernières modifications effectuées au cours des $2 derniers jours<br />$3.',
'diff' => 'diff',
'hist' => 'hist',
'hide' => 'Masquer',
'show' => 'Afficher',
'minoreditletter' => 'm',
'newpageletter' => 'N',
'boteditletter' => 'b',
'number_of_watching_users_pageview' => '[$1 utilisateur{{PLURAL:$1||s}} en train de suivre]',
'rc_categories' => 'Limite des catégories (séparation avec « | »)',
'rc_categories_any' => 'Toutes',
'rc-change-size-new' => '$1 {{PLURAL:$1|octet|octets}} après changement',
'newsectionsummary' => '/* $1 */ nouvelle section',
'rc-enhanced-expand' => 'Voir les détails (nécessite JavaScript)',
'rc-enhanced-hide' => 'Masquer les détails',
'rc-old-title' => 'créé avec le titre « $1 »',

# Recent changes linked
'recentchangeslinked' => 'Suivi des pages liées',
'recentchangeslinked-feed' => 'Suivi des pages liées',
'recentchangeslinked-toolbox' => 'Suivi des pages liées',
'recentchangeslinked-title' => 'Suivi des pages associées à « $1 »',
'recentchangeslinked-noresult' => "Il n'y a pas de modification des pages liées pendant la période choisie.",
'recentchangeslinked-summary' => "Cette page spéciale montre les modifications récentes sur les pages qui sont liées. Les pages de votre liste de suivi sont '''en gras'''.",
'recentchangeslinked-page' => 'Nom de la page :',
'recentchangeslinked-to' => "Afficher les modifications des pages qui comportent un lien vers la page donnée plutôt que l'inverse",

# Upload
'upload' => 'Importer un fichier',
'uploadbtn' => 'Importer le fichier',
'reuploaddesc' => "Annuler et retourner au formulaire d'import",
'upload-tryagain' => 'Envoyer la description du fichier modifiée',
'uploadnologin' => 'Non connecté(e)',
'uploadnologintext' => 'Vous devez être [[Special:UserLogin|connecté(e)]] pour importer des fichiers sur le serveur.',
'upload_directory_missing' => "Le répertoire d'import de fichier ($1) est introuvable et n'a pas pu être créé par le serveur web.",
'upload_directory_read_only' => "Le répertoire d'import de fichier ($1) n'est pas accessible en écriture depuis le serveur web.",
'uploaderror' => "Erreur lors de l'import",
'upload-recreate-warning' => "'''Attention : Un fichier portant ce nom a été supprimé ou déplacé.'''

Le journal des suppressions et celui des déplacements de cette page sont affichés ici pour informations :",
'uploadtext' => "Utilisez ce formulaire pour importer des fichiers sur le serveur.
Pour voir ou rechercher des images précédemment envoyées, consultez la [[Special:FileList|liste des images]]. L'import est aussi enregistrés dans le [[Special:Log/upload|journal d'import des fichiers]], et les suppressions dans le [[Special:Log/delete|journal des suppressions]].

Pour inclure un fichier dans une page, utilisez un lien de la forme :
* '''<code><nowiki>[[</nowiki>{{ns:file}}<nowiki>:fichier.jpg]]</nowiki></code>''', pour afficher le fichier en pleine résolution (dans le cas d'une image) ;
* '''<code><nowiki>[[</nowiki>{{ns:file}}<nowiki>:fichier.png|200px|thumb|left|texte descriptif]]</nowiki></code>''' pour utiliser une miniature de 200 pixels de large dans une boîte à gauche avec « texte descriptif » comme description ;
* '''<code><nowiki>[[</nowiki>{{ns:media}}<nowiki>:fichier.ogg]]</nowiki></code>''' pour lier directement vers le fichier sans l'afficher.",
'upload-permitted' => 'Formats de fichiers autorisés : $1.',
'upload-preferred' => 'Formats de fichiers préférés : $1.',
'upload-prohibited' => 'Formats de fichiers interdits : $1.',
'uploadlog' => "Journal d'import de fichiers",
'uploadlogpage' => "Journal d'import de fichiers",
'uploadlogpagetext' => 'Voici la liste des derniers fichiers importés sur le serveur.
Voyez la [[Special:NewFiles|galerie des nouvelles images]] pour une présentation plus visuelle.',
'filename' => 'Nom du fichier',
'filedesc' => 'Description',
'fileuploadsummary' => 'Description :',
'filereuploadsummary' => 'Modifications du fichier :',
'filestatus' => "Statut du droit d'auteur :",
'filesource' => 'Source :',
'uploadedfiles' => 'Fichiers importés',
'ignorewarning' => "Ignorer l'avertissement et sauvegarder le fichier quand même",
'ignorewarnings' => 'Ignorer les avertissements',
'minlength1' => 'Le noms de fichiers doivent comprendre au moins une lettre.',
'illegalfilename' => "Le nom de fichier « $1 » contient des caractères interdits dans les titres de pages. Merci de le renommer et de l'importer à nouveau.",
'filename-toolong' => 'Le nom du fichier ne peut pas dépasser 240 octets.',
'badfilename' => 'Le fichier a été renommé en « $1 ».',
'filetype-mime-mismatch' => "L'extension du fichier « .$1 » ne correspond pas au type MIME détecté du fichier ($2).",
'filetype-badmime' => 'Les fichiers du type MIME « $1 » ne peuvent pas être importés.',
'filetype-bad-ie-mime' => "Le fichier ne peut pas être importé parce qu'il serait détecté comme « $1 » par Internet Explorer, ce qui correspond à un type de fichier interdit car potentiellement dangereux.",
'filetype-unwanted-type' => "'''« .$1 »''' est un format de fichier non désiré.
{{PLURAL:$3|Le type de fichier préconisé est|Les types de fichiers préconisés sont}} $2.",
'filetype-banned-type' => "''' « .$1 » '''{{PLURAL:$4|n'est pas un type de fichier autorisé|ne sont pas des types de fichiers autorisés}}. 
{{PLURAL:$3|le type de fichier autorisé est |les types de fichiers autorisés sont}} $2.",
'filetype-missing' => "Le fichier n'a aucune extension (comme « .jpg » par exemple).",
'empty-file' => 'Le fichier que vous avez soumis était vide.',
'file-too-large' => 'Le fichier que vous avez soumis était trop grand.',
'filename-tooshort' => 'Le nom du fichier est trop court.',
'filetype-banned' => 'Ce type de fichier est interdit.',
'verification-error' => 'Ce fichier ne passe pas la vérification des fichiers.',
'hookaborted' => 'La modification que vous avez essayé de faire a été annulée par une extension.',
'illegal-filename' => "Le nom du fichier n'est pas autorisé.",
'overwrite' => "Écraser un fichier existant n'est pas autorisé.",
'unknown-error' => "Une erreur inconnue s'est produite.",
'tmp-create-error' => 'Impossible de créer le fichier temporaire.',
'tmp-write-error' => "Erreur d'écriture du fichier temporaire.",
'large-file' => 'Les fichiers importés ne devraient pas dépasser $1 ; ce fichier fait $2.',
'largefileserver' => 'La taille de ce fichier est supérieure au maximum autorisé.',
'emptyfile' => 'Le fichier que vous voulez importer semble vide.
Ceci peut être dû à une erreur dans le nom du fichier.
Veuillez vérifier que vous désirez vraiment importer ce fichier.',
'windows-nonascii-filename' => 'Ce wiki ne supporte pas les noms de fichiers avec des caractères spéciaux.',
'fileexists' => "Un fichier existe déjà sous ce nom.
Merci de vérifier <strong>[[:$1]]</strong> si vous n'êtes pas certain{{GENDER:||e|}} de vouloir le modifier.
[[$1|thumb]]",
'filepageexists' => "La page de description pour ce fichier a déjà été créée ici <strong>[[:$1]]</strong>, mais aucun fichier n'existe actuellement sous ce nom.
Le résumé que vous allez spécifier n'apparaîtra pas sur la page de description.
Pour que ce soit le cas, vous devrez modifier manuellement la page. [[$1|thumb]]",
'fileexists-extension' => 'Un fichier existe avec un nom proche : [[$2|thumb]]
* Nom du fichier à importer : <strong>[[:$1]]</strong>
* Nom du fichier existant : <strong>[[:$2]]</strong>
Veuillez choisir un autre nom.',
'fileexists-thumbnail-yes' => "Le fichier semble être une image en taille réduite ''(vignette)''. [[$1|thumb]]
Veuillez vérifier le fichier <strong>[[:$1]]</strong>.
Si le fichier vérifié est la même image avec la taille initiale, il n'y a pas besoin d'importer une version réduite.",
'file-thumbnail-no' => "Le nom du fichier commence par <strong>$1</strong>.
Il est possible qu'il s'agisse d'une version réduite ''(vignette)''.
Si vous disposez du fichier en haute résolution, importez-le, sinon veuillez modifier son nom.",
'fileexists-forbidden' => 'Un fichier avec ce nom existe déjà et ne peut pas être écrasé.
Si vous voulez toujours importer votre fichier, veuillez revenir en arrière et utiliser un autre nom. [[File:$1|thumb|center|$1]]',
'fileexists-shared-forbidden' => 'Un fichier portant ce nom existe déjà dans le dépôt de fichiers partagé.
Si vous voulez toujours importer votre fichier, veuillez revenir en arrière et utiliser un autre nom. [[File:$1|thumb|center|$1]]',
'file-exists-duplicate' => 'Ce fichier est un doublon {{PLURAL:$1|du fichier suivant|des fichiers suivants}} :',
'file-deleted-duplicate' => "Un fichier identique à celui-ci ([[:$1]]) a déjà été supprimé. Vous devriez vérifier le journal des suppressions de ce fichier avant de l'importer à nouveau.",
'uploadwarning' => 'Attention !',
'uploadwarning-text' => 'Modifiez la description du fichier et essayez de nouveau.',
'savefile' => 'Sauvegarder le fichier',
'uploadedimage' => 'a importé « [[$1]] »',
'overwroteimage' => 'a importé une nouvelle version de « [[$1]] »',
'uploaddisabled' => "Désolé, l'import de fichiers est désactivé.",
'copyuploaddisabled' => 'Import de fichier par URL désactivé.',
'uploadfromurl-queued' => "Votre fichier a été mis dans la file d'attente.",
'uploaddisabledtext' => "L'import de fichiers est désactivé sur ce wiki.",
'php-uploaddisabledtext' => "L'import de fichiers a été désactivé dans PHP. Vérifiez l'option de configuration file_uploads.",
'uploadscripted' => 'Ce fichier contient du code HTML ou un script qui pourrait être interprété de façon incorrecte par un navigateur web.',
'uploadvirus' => 'Ce fichier contient un virus ! Pour plus de détails, consultez : $1',
'uploadjava' => "C'est un fichier ZIP qui contient un fichier Java .class.
Le téléchargement de fichiers Java n'est pas autorisé, car ils peuvent contourner des restrictions de sécurité.",
'upload-source' => 'Fichier source',
'sourcefilename' => 'Nom du fichier source :',
'sourceurl' => 'URL source :',
'destfilename' => 'Nom sous lequel le fichier sera enregistré :',
'upload-maxfilesize' => 'Taille maximale du fichier : $1',
'upload-description' => 'Description du fichier',
'upload-options' => "Options d'import de fichiers",
'watchthisupload' => 'Suivre ce fichier',
'filewasdeleted' => "Un fichier avec ce nom a déjà été importé, puis supprimé.
Vous devriez vérifier le $1 avant de l'importer à nouveau.",
'filename-bad-prefix' => "Le nom du fichier commence par '''« $1 »''' qui est typiquement un nom attribué automatiquement par les appareils photo numériques.
Veuillez choisir un nom de fichier descriptif.",
'filename-prefix-blacklist' => ' #<!-- laisser cette ligne telle quelle --><pre>
# La syntaxe est la suivante :
#  * Tout ce qui figure entre un caractère "#" jusqu’à la fin de la ligne est un commentaire ;
#  * Toute ligne non vide est un préfixe typique de nom de fichier assigné automatiquement par les appareils numériques :
CIMG # Casio
DSC_ # Nikon
DSCF # Fuji
DSCN # Nikon
DUW # certains téléphones mobiles
IMG # générique
JD # Jenoptik
MGP # Pentax
PICT # divers
 #</pre><!-- laisser cette ligne telle quelle -->',
'upload-success-subj' => 'Import effectué avec succès',
'upload-success-msg' => 'Votre import depuis [$2] a réussi. Il est disponible ici : [[:{{ns:file}}:$1]]',
'upload-failure-subj' => "Problème d'import",
'upload-failure-msg' => 'Il y a eu un problème avec votre import depuis [$2] :

$1',
'upload-warning-subj' => "Avertissement lors de l'import",
'upload-warning-msg' => "Un problème est survenu lors de l'import depuis [$2]. Vous pouvez revenir au [[Special:Upload/stash/$1|formulaire d'import]] pour le résoudre.",

'upload-proto-error' => 'Protocole incorrect',
'upload-proto-error-text' => "L'import requiert des URL commençant par <code>http://</code> ou <code>ftp://</code>.",
'upload-file-error' => 'Erreur interne',
'upload-file-error-text' => 'Une erreur interne est survenue en voulant créer un fichier temporaire sur le serveur. Veuillez contacter un [[Special:ListUsers/sysop|administrateur]].',
'upload-misc-error' => "Erreur d'import inconnue",
'upload-misc-error-text' => "Une erreur inconnue est survenue pendant l'import.
Veuillez vérifier que l'URL est valide et accessible, puis essayer à nouveau.
Si le problème persiste, contactez un [[Special:ListUsers/sysop|administrateur]].",
'upload-too-many-redirects' => "L'URL contient trop de redirections.",
'upload-unknown-size' => 'Taille inconnue',
'upload-http-error' => 'Une erreur HTTP est survenue : $1',
'upload-copy-upload-invalid-domain' => "La copie des téléchargements n'est pas disponible depuis ce domaine.",

# File backend
'backend-fail-stream' => 'Impossible de lire le fichier $1.',
'backend-fail-backup' => 'Impossible de sauvegarder le fichier $1.',
'backend-fail-notexists' => "Le fichier $1 n'existe pas.",
'backend-fail-hashes' => "Impossible d'obtenir les hachages du fichier pour comparaison.",
'backend-fail-notsame' => 'Un fichier différent existe déjà pour $1 .',
'backend-fail-invalidpath' => "$1 n'est pas un chemin de stockage valide.",
'backend-fail-delete' => 'Impossible de supprimer le fichier $1.',
'backend-fail-alreadyexists' => 'Le fichier $1 existe déjà.',
'backend-fail-store' => 'Impossible de stocker le fichier $1 en $2.',
'backend-fail-copy' => 'Impossible de copier le fichier $1 en $2.',
'backend-fail-move' => 'Impossible de déplacer le fichier $1 en $2.',
'backend-fail-opentemp' => "Impossible d'ouvrir le fichier temporaire.",
'backend-fail-writetemp' => "Impossible d'écrire dans le fichier temporaire.",
'backend-fail-closetemp' => 'Impossible de fermer le fichier temporaire.',
'backend-fail-read' => 'Impossible de lire le fichier $1.',
'backend-fail-create' => "Impossible d'écrire le fichier $1.",
'backend-fail-maxsize' => "Impossible d'écrire le fichier $1 parce qu'il est plus grand {{PLURAL:$2|qu'un octet|que $2 octets}}.",
'backend-fail-readonly' => 'Le support de stockage "$1" est actuellement en lecture seule. La raison indiquée est: "$2"',
'backend-fail-synced' => 'Le fichier "$1" est dans un état incohérent dans les supports de stockage internes',
'backend-fail-connect' => 'Impossible de se connecter au support de stockage "$1".',
'backend-fail-internal' => 'Une erreur inconnue s\'est produite dans le support de stockage "$1".',
'backend-fail-contenttype' => 'Impossible de déterminer le type de contenu du fichier à stocker en "$1".',
'backend-fail-batchsize' => 'Le support de stockage a fourni un lot de $1 {{PLURAL:$1|opération|opérations}} de fichier; la limite est $2 {{PLURAL:$2|opération|opérations}}.',
'backend-fail-usable' => "Impossible de lire ou d'écrire le fichier « $1 » en raison de droits insuffisants ou répertoires/conteneurs manquants.",

# File journal errors
'filejournal-fail-dbconnect' => 'Impossible de se connecter à la base de données du journal pour le terminal de stockage "$1".',
'filejournal-fail-dbquery' => 'Impossible de mettre à jour la base de données du journal pour le terminal de stockage "$1".',

# Lock manager
'lockmanager-notlocked' => "Impossible de déverrouiller « $1 » ; elle n'est pas verrouillée.",
'lockmanager-fail-closelock' => 'Impossible de fermer le fichier de verrou pour « $1 ».',
'lockmanager-fail-deletelock' => 'Impossible de supprimer le fichier de verrou pour « $1 ».',
'lockmanager-fail-acquirelock' => "Impossible d'obtenir le verrou pour « $1 ».",
'lockmanager-fail-openlock' => "Impossible d'ouvrir le fichier de verrou pour « $1» .",
'lockmanager-fail-releaselock' => 'Impossible de relâcher le verrou pour « $1 ».',
'lockmanager-fail-db-bucket' => 'Impossible de contacter suffisamment de bases de données de verrouillage dans le godet $1.',
'lockmanager-fail-db-release' => 'Impossible de relâcher les verrous sur la base de données $1.',
'lockmanager-fail-svr-acquire' => "Impossible d'acquérir des verrous sur le serveur $1.",
'lockmanager-fail-svr-release' => 'Impossible de relâcher les verrous sur le serveur $1.',

# ZipDirectoryReader
'zip-file-open-error' => "Une erreur s'est produite lors de l'ouverture du fichier ZIP pour contrôle.",
'zip-wrong-format' => "Le fichier spécifié n'est pas une archive ZIP.",
'zip-bad' => 'Le fichier est une archive ZIP corrompue ou illisible.
Il ne peut pas être correctement vérifié pour la sécurité.',
'zip-unsupported' => 'Le fichier est une archive ZIP qui utilise des caractéristiques non supportées par MediaWiki. 
Sa sécurité ne peut pas être correctement vérifiée.',

# Special:UploadStash
'uploadstash' => "Cache d'import",
'uploadstash-summary' => "Cette page donne accès aux fichiers qui sont importés (ou en cours d'importation), mais ne sont pas encore publiés dans le wiki. Ces fichiers ne sont pas encore visibles, sauf pour l'utilisateur qui les a importés.",
'uploadstash-clear' => 'Effacer les fichiers en cache',
'uploadstash-nofiles' => "Vous n'avez pas de fichiers en cache d'import.",
'uploadstash-badtoken' => "L'exécution de cette action a échoué, peut-être parce que vos informations d'identification ont expiré. Réessayez.",
'uploadstash-errclear' => "L'effacement des fichiers a échoué.",
'uploadstash-refresh' => 'Actualiser la liste des fichiers',
'invalid-chunk-offset' => 'Offset de segment non valide',

# img_auth script messages
'img-auth-accessdenied' => 'Accès refusé',
'img-auth-nopathinfo' => "PATH_INFO manquant.
Votre serveur n'est pas paramétré pour passer cette information.
Il fonctionne peut-être en CGI et ne supporte pas img_auth.
Voyez https://www.mediawiki.org/wiki/Manual:Image_Authorization.",
'img-auth-notindir' => "Le chemin demandé n'est pas le répertoire d'import configuré.",
'img-auth-badtitle' => 'Impossible de construire un titre valide à partir de « $1 ».',
'img-auth-nologinnWL' => "Vous n'êtes pas connecté et « $1 » n'est pas dans la liste blanche.",
'img-auth-nofile' => "Le fichier « $1 » n'existe pas.",
'img-auth-isdir' => "Vous essayez d'accéder au répertoire « $1 ».
Seul l'accès aux fichiers est permis.",
'img-auth-streaming' => 'Lecture en continu de « $1 ».',
'img-auth-public' => "La fonction de img_auth.php est d'afficher des fichiers d'un wiki privé.
Ce wiki est configuré comme un wiki public.
Pour une sécurité optimale, img_auth.php est désactivé.",
'img-auth-noread' => "L'utilisateur n'a pas le droit en lecture sur « $1 ».",
'img-auth-bad-query-string' => "L'URL a une chaîne de requête invalide.",

# HTTP errors
'http-invalid-url' => 'URL incorrecte : $1',
'http-invalid-scheme' => 'Les URL avec le schéma « $1 » ne sont pas supportées.',
'http-request-error' => "Erreur inconnue lors de l'envoi de la requête.",
'http-read-error' => 'Erreur de lecture HTTP.',
'http-timed-out' => 'La requête HTTP a expiré.',
'http-curl-error' => "Erreur lors de la récupération de l'URL : $1",
'http-host-unreachable' => "Impossible d'atteindre l'URL.",
'http-bad-status' => 'Il y a eu un problème lors de la requête HTTP : $1 $2',

# Some likely curl errors. More could be added from <http://curl.haxx.se/libcurl/c/libcurl-errors.html>
'upload-curl-error6' => 'URL injoignable',
'upload-curl-error6-text' => "L'URL fournie ne peut pas être atteinte. Veuillez vérifier que l'URL est correcte et que le site est en ligne.",
'upload-curl-error28' => "Dépassement du délai lors de l'import",
'upload-curl-error28-text' => 'Le site a mis trop longtemps à répondre. Vérifiez que le site est en ligne, attendez un peu et réessayez. Vous pouvez aussi réessayer à une heure de moindre affluence.',

'license' => 'Licence',
'license-header' => "Conditions d'utilisation",
'nolicense' => 'Aucune licence sélectionnée',
'license-nopreview' => '(Prévisualisation non disponible)',
'upload_source_url' => ' (une URL valide et accessible publiquement)',
'upload_source_file' => ' (un fichier sur votre ordinateur)',

# Special:ListFiles
'listfiles-summary' => 'Cette page spéciale permet de lister tous les fichiers importés.
Quand elle est filtrée par utilisateur, seuls les fichiers dont la version la plus récente a été importée par cet utilisateur sont affichés.',
'listfiles_search_for' => 'Rechercher un nom de média :',
'imgfile' => 'fichier',
'listfiles' => 'Liste de fichiers',
'listfiles_thumb' => 'Miniature',
'listfiles_date' => 'Date',
'listfiles_name' => 'Nom',
'listfiles_user' => 'Utilisateur',
'listfiles_size' => 'Taille',
'listfiles_description' => 'Description',
'listfiles_count' => 'Versions',

# File description page
'file-anchor-link' => 'Fichier',
'filehist' => 'Historique du fichier',
'filehist-help' => "Cliquer sur une date et heure pour voir le fichier tel qu'il était à ce moment-là.",
'filehist-deleteall' => 'supprimer tout',
'filehist-deleteone' => 'supprimer',
'filehist-revert' => 'rétablir',
'filehist-current' => 'actuel',
'filehist-datetime' => 'Date et heure',
'filehist-thumb' => 'Vignette',
'filehist-thumbtext' => 'Vignette pour la version du $1',
'filehist-nothumb' => 'Pas de miniature',
'filehist-user' => 'Utilisateur',
'filehist-dimensions' => 'Dimensions',
'filehist-filesize' => 'Taille du fichier',
'filehist-comment' => 'Commentaire',
'filehist-missing' => 'Fichier manquant',
'imagelinks' => 'Utilisation du fichier',
'linkstoimage' => '{{PLURAL:$1|La page suivante utilise|Les $1 pages suivantes utilisent}} ce fichier :',
'linkstoimage-more' => "Plus {{PLURAL:$1|d'une page utilise|de $1 pages utilisent}} ce fichier.
La liste suivante affiche seulement {{PLURAL:$1|la première page qui utilise|les $1 premières pages qui utilisent}} ce fichier.
Une [[Special:WhatLinksHere/$2|liste complète]] est disponible.",
'nolinkstoimage' => "Aucune page n'utilise ce fichier.",
'morelinkstoimage' => 'Voir [[Special:WhatLinksHere/$1|plus de liens]] vers ce fichier.',
'linkstoimage-redirect' => '$1 (redirection de fichier) $2',
'duplicatesoffile' => '{{PLURAL:$1|Le fichier suivant est un duplicata|Les fichiers suivants sont des duplicatas}} de celui-ci ([[Special:FileDuplicateSearch/$2|plus de détails]]) :',
'sharedupload' => "Ce fichier provient de : $1. Il peut être utilisé par d'autres projets.",
'sharedupload-desc-there' => "Ce fichier provient de : $1. Il peut être utilisé par d'autres projets.
Veuillez consulter [$2 sa page de description] pour plus d'informations.",
'sharedupload-desc-here' => "Ce fichier provient de $1. Il peut être utilisé par d'autres projets.
Sa description sur sa [$2 page de description] est affichée ci-dessous.",
'sharedupload-desc-edit' => "Ce fichier provient de : $1. Il peut être utilisé par d'autres projets.
Vous voulez peut-être modifier la description sur sa [$2 page de description].",
'sharedupload-desc-create' => "Ce fichier provient de : $1. Il peut être utilisé par d'autres projets.
Vous voulez peut-être modifier la description sur sa [$2 page de description].",
'filepage-nofile' => 'Aucun fichier de ce nom existe.',
'filepage-nofile-link' => "Aucun fichier de ce nom n'existe, mais vous pouvez [$1 en importer un].",
'uploadnewversion-linktext' => 'Importer une nouvelle version de ce fichier',
'shared-repo-from' => 'de : $1',
'shared-repo' => 'un dépôt partagé',
'shared-repo-name-wikimediacommons' => 'Wikimédia Commons',
'filepage.css' => '/* Les styles CSS placés ici sont inclus dans la page de description du fichier, également incluse sur les clients wikis étrangers */',
'upload-disallowed-here' => 'Vous ne pouvez pas remplacer ce fichier.',

# File reversion
'filerevert' => 'Rétablir $1',
'filerevert-legend' => 'Rétablir le fichier',
'filerevert-intro' => "Vous êtes sur le point de rétablir le fichier '''[[Media:$1|$1]]''' à la [$4 version du $2 à $3].",
'filerevert-comment' => 'Motif :',
'filerevert-defaultcomment' => 'Version du $1 à $2 rétablie',
'filerevert-submit' => 'Rétablir',
'filerevert-success' => "'''[[Media:$1|$1]]''' a été rétabli à [$4 la version du $2 à $3].",
'filerevert-badversion' => "Il n'y a pas localement de version antérieure du fichier qui porte la date indiquée.",

# File deletion
'filedelete' => 'Supprimer $1',
'filedelete-legend' => 'Supprimer le fichier',
'filedelete-intro' => "Vous êtes sur le point de supprimer '''[[Media:$1|$1]]''' ainsi que tout son historique.",
'filedelete-intro-old' => "Vous êtes en train d'effacer la version de '''[[Media:$1|$1]]''' du [$4 $2 à $3].",
'filedelete-comment' => 'Motif :',
'filedelete-submit' => 'Supprimer',
'filedelete-success' => "'''$1''' a été supprimé.",
'filedelete-success-old' => "La version de '''[[Media:$1|$1]]''' du $2 à $3 a été supprimée.",
'filedelete-nofile' => "'''$1''' n'existe pas.",
'filedelete-nofile-old' => "Il n'existe aucune version archivée de '''$1''' avec les attributs indiqués.",
'filedelete-otherreason' => 'Motif autre / supplémentaire :',
'filedelete-reason-otherlist' => 'Autre motif',
'filedelete-reason-dropdown' => "* Motifs fréquents de suppression de fichiers
** Violation du droit d'auteur
** Fichier dupliqué",
'filedelete-edit-reasonlist' => 'Modifier les motifs fréquents de suppression',
'filedelete-maintenance' => 'La suppression et restauration de fichiers est temporairement désactivée durant la maintenance.',
'filedelete-maintenance-title' => 'Impossible de supprimer le fichier',

# MIME search
'mimesearch' => 'Recherche par type de contenu MIME',
'mimesearch-summary' => "Cette page vous permet de lister les fichiers accessibles par ce wiki en fonction de leur type de contenu MIME.
Entrée : ''typedecontenu''/''sous-type'', par exemple <code>image/jpeg</code>.",
'mimetype' => 'Type MIME :',
'download' => 'télécharger',

# Unwatched pages
'unwatchedpages' => "Pages ne faisant partie d'aucune liste de suivi",

# List redirects
'listredirects' => 'Liste des redirections',

# Unused templates
'unusedtemplates' => 'Modèles inutilisés',
'unusedtemplatestext' => "Cette page liste toutes les pages de l'espace de noms « {{ns:template}} » qui ne sont incluses dans aucune autre page.
N'oubliez pas de vérifier s'il n'y a pas d'autres liens vers les modèles avant de les supprimer.",
'unusedtemplateswlh' => 'autres liens',

# Random page
'randompage' => 'Page au hasard',
'randompage-nopages' => "Il n'y a aucune page dans {{PLURAL:$2|l'espace de noms|les espaces de noms}} : $1.",

# Random redirect
'randomredirect' => 'Page de redirection au hasard',
'randomredirect-nopages' => "Il n'y a aucune page de redirection dans l'espace de noms « $1 ».",

# Statistics
'statistics' => 'Statistiques',
'statistics-header-pages' => 'Statistiques des pages',
'statistics-header-edits' => 'Statistiques des modifications',
'statistics-header-views' => 'Statistiques des visites',
'statistics-header-users' => 'Statistiques des utilisateurs',
'statistics-header-hooks' => 'Autres statistiques',
'statistics-articles' => 'Pages de contenu',
'statistics-pages' => 'Pages',
'statistics-pages-desc' => 'Toutes les pages du wiki, y compris les pages de discussion, les redirections, etc.',
'statistics-files' => 'Fichiers importés',
'statistics-edits' => "Modifications de pages depuis l'installation de {{SITENAME}}",
'statistics-edits-average' => 'Nombre moyen de modifications par page',
'statistics-views-total' => 'Visites',
'statistics-views-total-desc' => 'Les vues des pages non existantes et des pages spéciales ne sont pas incluses',
'statistics-views-peredit' => 'Visites par modification',
'statistics-users' => '[[Special:ListUsers|Utilisateurs]] enregistrés',
'statistics-users-active' => 'Utilisateurs actifs',
'statistics-users-active-desc' => 'Utilisateurs ayant fait au moins une action durant {{PLURAL:$1|le dernier jours|les $1 derniers jours}}',
'statistics-mostpopular' => 'Pages les plus consultées',

'disambiguations' => "Pages ayant des liens vers des pages d'homonymie",
'disambiguationspage' => 'Template:Homonymie',
'disambiguations-text' => "Les pages suivantes comportent au moins un lien vers une '''page d'homonymie'''.
Elles devraient plutôt pointer vers le bon article.<br />
Une page est considérée comme une page d'homonymie si elle utilise un modèle lié à [[MediaWiki:Disambiguationspage]]",

'doubleredirects' => 'Doubles redirections',
'doubleredirectstext' => 'Voici une liste des pages qui redirigent vers des pages qui sont elles-mêmes des pages de redirection.
Chaque entrée contient des liens vers la première et la seconde redirections, ainsi que la première ligne de texte de la seconde page, ce qui fournit habituellement la « vraie » page cible, vers laquelle la première redirection devrait rediriger.
Les entrées <del>barrées</del> ont été résolues.',
'double-redirect-fixed-move' => 'Cette redirection, dont la cible [[$1]] a été renommée, mène maintenant vers [[$2]].',
'double-redirect-fixed-maintenance' => 'Corrige la double redirection de [[$1]] vers [[$2]].',
'double-redirect-fixer' => 'Correcteur de redirection',

'brokenredirects' => 'Redirections cassées',
'brokenredirectstext' => 'Ces redirections mènent vers des pages inexistantes :',
'brokenredirects-edit' => 'modifier',
'brokenredirects-delete' => 'supprimer',

'withoutinterwiki' => 'Pages sans liens inter-langues',
'withoutinterwiki-summary' => "Les pages suivantes ne possèdent pas de liens vers d'autres langues :",
'withoutinterwiki-legend' => 'Préfixe',
'withoutinterwiki-submit' => 'Afficher',

'fewestrevisions' => 'Pages les moins modifiées',

# Miscellaneous special pages
'nbytes' => '$1 octet{{PLURAL:$1||s}}',
'ncategories' => '$1 catégorie{{PLURAL:$1||s}}',
'ninterwikis' => '$1 {{PLURAL:$1|interwiki|interwikis}}',
'nlinks' => '$1 {{PLURAL:$1|page liée|pages liées}}',
'nmembers' => '$1 membre{{PLURAL:$1||s}}',
'nrevisions' => '$1 version{{PLURAL:$1||s}}',
'nviews' => '$1 consultation{{PLURAL:$1||s}}',
'nimagelinks' => 'Utilisé sur $1 {{PLURAL:$1|page|pages}}',
'ntransclusions' => 'Utilisé sur $1 {{PLURAL:$1|page|pages}}',
'specialpage-empty' => "Il n'y a aucun résultat à afficher.",
'lonelypages' => 'Pages orphelines',
'lonelypagestext' => "Les pages suivantes ne sont ni pointées, ni incluses par d'autres pages du wiki.",
'uncategorizedpages' => 'Pages sans catégories',
'uncategorizedcategories' => 'Catégories sans catégories',
'uncategorizedimages' => 'Fichiers sans catégories',
'uncategorizedtemplates' => 'Modèles sans catégories',
'unusedcategories' => 'Catégories inutilisées',
'unusedimages' => 'Fichiers orphelins',
'popularpages' => 'Pages les plus consultées',
'wantedcategories' => 'Catégories les plus demandées',
'wantedpages' => 'Pages les plus demandées',
'wantedpages-badtitle' => 'Titre invalide dans les résultats : $1',
'wantedfiles' => 'Fichiers les plus demandés',
'wantedfiletext-cat' => "Les fichiers suivants sont utilisés, mais n'existent pas. Les fichiers d'autres dépôts peuvent être listés malgré qu'ils existent. Tous ces faux positifs seront <del>barrés</del>. En outre, les pages qui intègrent des fichiers qui n'existent pas sont répertoriées dans [[:$1]].",
'wantedfiletext-nocat' => "Les fichiers suivants sont utilisés, mais n'existent pas. Les fichiers d'autres dépôts peuvent être listés malgré qu'ils existent. Tous ces faux positifs seront <del>barrés</del>.",
'wantedtemplates' => 'Modèles demandés',
'mostlinked' => 'Pages les plus liées',
'mostlinkedcategories' => 'Catégories les plus utilisées',
'mostlinkedtemplates' => 'Modèles les plus utilisés',
'mostcategories' => 'Pages utilisant le plus de catégories',
'mostimages' => 'Fichiers les plus utilisés',
'mostinterwikis' => "Pages avec le plus d'interwikis",
'mostrevisions' => 'Pages les plus modifiées',
'prefixindex' => 'Toutes les pages commençant par…',
'prefixindex-namespace' => 'Toutes les pages avec préfixe (espace de noms $1)',
'shortpages' => 'Pages courtes',
'longpages' => 'Pages longues',
'deadendpages' => 'Pages en impasse',
'deadendpagestext' => "Les pages suivantes ne contiennent aucun lien vers d'autres pages du wiki.",
'protectedpages' => 'Pages protégées',
'protectedpages-indef' => 'Uniquement les protections permanentes',
'protectedpages-cascade' => 'Uniquement les protections en cascade',
'protectedpagestext' => 'Les pages suivantes sont protégées contre les modifications ou le déplacement.',
'protectedpagesempty' => "Aucune page n'est protégée de cette façon.",
'protectedtitles' => 'Titres protégés',
'protectedtitlestext' => 'Les titres suivants sont protégés à la création',
'protectedtitlesempty' => "Aucun titre n'est actuellement protégé avec ces paramètres.",
'listusers' => 'Liste des utilisateurs',
'listusers-editsonly' => 'Ne montrer que les utilisateurs ayant au moins une contribution',
'listusers-creationsort' => 'Trier par date de création',
'usereditcount' => '$1 modification{{PLURAL:$1||s}}',
'usercreated' => '{{GENDER:$3|Créé}} le $1 à $2',
'newpages' => 'Nouvelles pages',
'newpages-username' => "Nom d'utilisateur :",
'ancientpages' => 'Pages les plus anciennement modifiées',
'move' => 'Renommer',
'movethispage' => 'Renommer cette page',
'unusedimagestext' => "Les fichiers suivants existent, mais ne sont inclus dans aucune page.
Veuillez noter que d'autres sites peuvent avoir un lien direct vers un fichier, et donc qu'un fichier peut être listé ici alors qu'il est en réalité utilisé sur ces sites.",
'unusedcategoriestext' => 'Les catégories suivantes existent mais aucune page ou catégorie ne les utilise.',
'notargettitle' => 'Pas de cible',
'notargettext' => "Vous n'avez pas indiqué une page ou un utilisateur sur lequel vous souhaitez effectuer cette action.",
'nopagetitle' => 'Aucune telle page cible',
'nopagetext' => "La page cible que vous avez indiquée n'existe pas.",
'pager-newer-n' => '{{PLURAL:$1|plus récente|$1 plus récentes}}',
'pager-older-n' => '{{PLURAL:$1|plus ancienne|$1 plus anciennes}}',
'suppress' => 'Superviser',
'querypage-disabled' => 'Cette page spéciale est désactivée pour des raisons de performances.',

# Book sources
'booksources' => 'Ouvrages de référence',
'booksources-search-legend' => 'Rechercher parmi des ouvrages de référence',
'booksources-isbn' => 'ISBN :',
'booksources-go' => 'Lister',
'booksources-text' => "Voici une liste indicative et non exclusive de liens vers d'autres sites vendant des livres neufs et d'occasion et sur lesquels vous trouverez peut-être des informations sur les ouvrages que vous cherchez :",
'booksources-invalid-isbn' => "L'ISBN donné ne semble pas être correct ; vérifiez si vous avez fait une erreur en copiant la source originale.",

# Special:Log
'specialloguserlabel' => 'Auteur :',
'speciallogtitlelabel' => 'Cible (titre ou utilisateur):',
'log' => "Journaux d'opérations",
'all-logs-page' => 'Tous les journaux publics',
'alllogstext' => "Affichage combiné de tous les journaux disponibles sur {{SITENAME}}.<br />
Vous pouvez personnaliser l'affichage en sélectionnant le type de journal, le nom d'utilisateur ou la page concernée (ces deux derniers étant sensibles à la casse).",
'logempty' => 'Aucune opération correspondante dans les journaux.',
'log-title-wildcard' => 'Chercher parmi les titres commençant par ce texte',
'showhideselectedlogentries' => 'Afficher/masquer les entrées de journal sélectionnées',

# Special:AllPages
'allpages' => 'Toutes les pages',
'alphaindexline' => 'de $1 à $2',
'nextpage' => 'Page suivante ($1)',
'prevpage' => 'Page précédente ($1)',
'allpagesfrom' => 'Afficher les pages à partir de :',
'allpagesto' => "Afficher les pages jusqu'à :",
'allarticles' => 'Toutes les pages',
'allinnamespace' => "Toutes les pages (dans l'espace de noms $1)",
'allnotinnamespace' => "Toutes les pages (hors de l'espace de noms $1)",
'allpagesprev' => 'Précédent',
'allpagesnext' => 'Suivant',
'allpagessubmit' => 'Lister',
'allpagesprefix' => 'Afficher les pages commençant par :',
'allpagesbadtitle' => 'Le titre de page indiqué est incorrect : il contient un préfixe inter-langue ou inter-wiki réservé, ou contient un ou plusieurs caractères inutilisables dans les titres.',
'allpages-bad-ns' => "{{SITENAME}} n'a pas d'espace de noms « $1 ».",
'allpages-hide-redirects' => 'Masquer les redirections',

# SpecialCachedPage
'cachedspecial-viewing-cached-ttl' => "Vous visualisez une version de cette page mise en cache, qui peut être dater d'au plus $1.",
'cachedspecial-viewing-cached-ts' => 'Vous visualisez une version de cette page mise en cache, qui pourrait ne pas être complètement à jour.',
'cachedspecial-refresh-now' => 'Voir le plus récent.',

# Special:Categories
'categories' => 'Liste des catégories',
'categoriespagetext' => '{{PLURAL:$1|La catégorie suivante est utilisée|Les catégories suivantes sont utilisées}} par des pages ou fichiers.
[[Special:UnusedCategories|Les catégories inutilisées]] ne sont pas affichées ici.
Voyez aussi [[Special:WantedCategories|les catégories demandées]].',
'categoriesfrom' => 'Afficher les catégories à partir de :',
'special-categories-sort-count' => "tri par nombre d'éléments",
'special-categories-sort-abc' => 'tri alphabétique',

# Special:DeletedContributions
'deletedcontributions' => 'Contributions supprimées',
'deletedcontributions-title' => 'Contributions supprimées',
'sp-deletedcontributions-contribs' => 'contributions',

# Special:LinkSearch
'linksearch' => 'Recherche de liens externes',
'linksearch-pat' => 'Expression recherchée :',
'linksearch-ns' => 'Espace de noms :',
'linksearch-ok' => 'Rechercher',
'linksearch-text' => "Des caractères jokers comme « *.wikipedia.org » peuvent être utilisés.
Ils nécessitent au moins un domaine de niveau supérieur, par exemple « *.org ».<br />
Protocoles reconnus : <code>$1</code> (http:// par défaut si aucun protocole n'est indiqué).",
'linksearch-line' => '$1 est lié depuis $2',
'linksearch-error' => "Les caractères jokers ne peuvent être utilisés qu'au début du nom de domaine de l'hôte.",

# Special:ListUsers
'listusersfrom' => 'Afficher les utilisateurs à partir de :',
'listusers-submit' => 'Lister',
'listusers-noresult' => 'Aucun utilisateur trouvé. Vérifiez aussi les variantes de casse.',
'listusers-blocked' => '(bloqué{{GENDER:$1||e|(e)}})',

# Special:ActiveUsers
'activeusers' => 'Liste des utilisateurs actifs',
'activeusers-intro' => 'Ceci est une liste des utilisateurs qui ont exercé une quelconque activité au cours {{PLURAL:$1|de la dernière journée|des $1 derniers jours}}.',
'activeusers-count' => '$1 {{PLURAL:$1|modification|modifications}} dans {{PLURAL:$3|le dernier jour|les $3 derniers jours}}',
'activeusers-from' => 'Afficher les utilisateurs depuis :',
'activeusers-hidebots' => 'Masquer les robots',
'activeusers-hidesysops' => 'Masquer les administrateurs',
'activeusers-noresult' => 'Aucun utilisateur trouvé.',

# Special:Log/newusers
'newuserlogpage' => 'Journal des créations de comptes utilisateur',
'newuserlogpagetext' => "Cette page affiche l'historique des créations de comptes utilisateur.",

# Special:ListGroupRights
'listgrouprights' => "Droits des groupes d'utilisateurs",
'listgrouprights-summary' => "Cette page contient une liste des groupes définis sur ce wiki ainsi que les droits d'accès qui leur sont associés.
Des [[{{MediaWiki:Listgrouprights-helppage}}|informations additionnelles]] peuvent exister au sujet des droits individuels.",
'listgrouprights-key' => '*<span class="listgrouprights-granted">Droit octroyé</span>
*<span class="listgrouprights-revoked">Droit révoqué</span>',
'listgrouprights-group' => 'Groupe',
'listgrouprights-rights' => 'Droits associés',
'listgrouprights-helppage' => 'Help:Droits des groupes',
'listgrouprights-members' => '(liste des membres)',
'listgrouprights-addgroup' => 'Ajouter des membres {{PLURAL:$2|au groupe|aux groupes}} : $1',
'listgrouprights-removegroup' => 'Retirer des membres {{PLURAL:$2|du groupe|des groupes}} : $1',
'listgrouprights-addgroup-all' => 'Ajouter des membres à tous les groupes',
'listgrouprights-removegroup-all' => 'Retirer des membres de tous les groupes',
'listgrouprights-addgroup-self' => "Peut s'ajouter {{PLURAL:$2|le groupe|les groupes}} à son propre compte : $1",
'listgrouprights-removegroup-self' => 'Peut se retirer {{PLURAL:$2|le groupe|les groupes}} de son propre compte : $1',
'listgrouprights-addgroup-self-all' => "Peut s'ajouter tous les groupes à son propre compte",
'listgrouprights-removegroup-self-all' => 'Peut se retirer tous les groupes de son propre compte',

# E-mail user
'mailnologin' => "Pas d'adresse d'expéditeur",
'mailnologintext' => "Vous devez être [[Special:UserLogin|identifié]] et avoir indiqué une adresse électronique valide dans vos [[Special:Preferences|préférences]] pour pouvoir envoyer des courriels à d'autres utilisateurs.",
'emailuser' => 'Lui envoyer un courriel',
'emailuser-title-target' => 'Envoyer un courriel à {{GENDER:$1|cet utilisateur|cette utilisatrice}}',
'emailuser-title-notarget' => "Envoyer un courriel à l'utilisateur",
'emailpage' => "Envoyer un courriel à l'utilisateur",
'emailpagetext' => "Vous pouvez utiliser le formulaire ci-dessous pour envoyer un courriel à {{GENDER:$1|cet utilisateur|cette utilisatrice}}.
L'adresse électronique que vous avez indiquée dans [[Special:Preferences|vos préférences]] apparaîtra dans le champ « Expéditeur » de votre message ; ainsi, le destinataire pourra vous répondre directement.",
'usermailererror' => "Erreur dans l'objet du courriel :",
'defemailsubject' => "{{SITENAME}} Courriel de l'utilisateur « $1 »",
'usermaildisabled' => "L'envoi de courriels entre utilisateurs est désactivé",
'usermaildisabledtext' => "Vous ne pouvez pas envoyer de courriels à d'autres utilisateurs sur ce wiki",
'noemailtitle' => 'Aucune adresse de courriel',
'noemailtext' => "Cet utilisateur n'a pas spécifié une adresse de courriel valide.",
'nowikiemailtitle' => 'Pas de courriel autorisé',
'nowikiemailtext' => "Cet utilisateur a choisi de ne pas recevoir de courriel de la part d'autres utilisateurs.",
'emailnotarget' => "Nom d'utilisateur du destinataire inexistant ou invalide.",
'emailtarget' => "Entrez le nom d'utilisateur du destinataire",
'emailusername' => "Nom d'utilisateur :",
'emailusernamesubmit' => 'Soumettre',
'email-legend' => 'Envoyer un courriel à un autre utilisateur de {{SITENAME}}',
'emailfrom' => 'De :',
'emailto' => 'À :',
'emailsubject' => 'Objet :',
'emailmessage' => 'Message :',
'emailsend' => 'Envoyer',
'emailccme' => "M'envoyer par courriel une copie de mon message.",
'emailccsubject' => 'Copie de votre message à $1 : $2',
'emailsent' => 'Courriel envoyé',
'emailsenttext' => 'Votre message a été envoyé par courriel.',
'emailuserfooter' => "Ce courriel a été envoyé par « $1 » à « $2 » par la fonction « Envoyer un courriel à l'utilisateur » de {{SITENAME}}.",

# User Messenger
'usermessage-summary' => 'A laissé un message système.',
'usermessage-editor' => 'Messager du système',

# Watchlist
'watchlist' => 'Liste de suivi',
'mywatchlist' => 'Liste de suivi',
'watchlistfor2' => 'Pour $1 $2',
'nowatchlist' => 'Votre liste de suivi ne référence aucune page.',
'watchlistanontext' => 'Veuillez vous $1 pour visualiser ou modifier les éléments de votre liste de suivi.',
'watchnologin' => 'Non connecté',
'watchnologintext' => 'Vous devez être [[Special:UserLogin|identifié]] pour modifier votre liste de suivi.',
'addwatch' => 'Ajouter à la liste de suivi',
'addedwatchtext' => 'La page « [[:$1]] » a été ajoutée à votre [[Special:Watchlist|liste de suivi]].
Les prochaines modifications de cette page et de la page de discussion associée y seront répertoriées.',
'removewatch' => 'Supprimer de la liste de suivi',
'removedwatchtext' => 'La page « [[:$1]] » a été retirée de votre [[Special:Watchlist|liste de suivi]].',
'watch' => 'Suivre',
'watchthispage' => 'Suivre cette page',
'unwatch' => 'Ne plus suivre',
'unwatchthispage' => 'Ne plus suivre',
'notanarticle' => "Ce n'est pas une page de contenu",
'notvisiblerev' => 'La version a été supprimée',
'watchnochange' => "Aucun des éléments que vous suivez n'a été modifié durant la période affichée.",
'watchlist-details' => 'Votre liste de suivi référence $1 page{{PLURAL:$1||s}}, sans compter les pages de discussion.',
'wlheader-enotif' => '* La notification par courriel est activée.',
'wlheader-showupdated' => "* Les pages qui ont été modifiées depuis votre dernière visite sont affichées en '''gras'''.",
'watchmethod-recent' => 'vérification des modifications récentes pour y trouver des pages suivies',
'watchmethod-list' => 'vérification des pages suivies pour y trouver des modifications récentes',
'watchlistcontains' => 'Votre liste de suivi référence $1 page{{PLURAL:$1||s}}.',
'iteminvalidname' => "Problème avec l'élément « $1 » : le nom est invalide.",
'wlnote' => "Ci-dessous {{PLURAL:$1|figure la dernière modification effectuée|figurent les '''$1''' dernières modifications effectuées}} durant {{PLURAL:$2|la dernière heure|les '''$2''' dernières heures}}, depuis $3, $4.",
'wlshowlast' => 'Montrer les dernières $1 heures, les derniers $2 jours ou bien $3',
'watchlist-options' => 'Options de la liste de suivi',

# Displayed when you click the "watch" button and it is in the process of watching
'watching' => 'Suivi…',
'unwatching' => 'Fin du suivi…',
'watcherrortext' => "Une erreur s'est produite lors de la modification des paramètres de votre liste de suivi pour « $1 ».",

'enotif_mailer' => 'Système de notification par courriel de {{SITENAME}}',
'enotif_reset' => 'Marquer toutes les pages comme visitées',
'enotif_newpagetext' => 'Ceci est une nouvelle page.',
'enotif_impersonal_salutation' => 'Utilisateur de {{SITENAME}}',
'changed' => 'modifiée',
'created' => 'créée',
'enotif_subject' => 'La page $PAGETITLE de {{SITENAME}} a été $CHANGEDORCREATED par $PAGEEDITOR',
'enotif_lastvisited' => 'Voyez $1 pour tous les changements depuis votre dernière visite.',
'enotif_lastdiff' => 'Voyez $1 pour visualiser ces changements.',
'enotif_anon_editor' => 'utilisateur non-enregistré $1',
'enotif_body' => 'Cher $WATCHINGUSERNAME,

La page « $PAGETITLE » de {{SITENAME}} a été $CHANGEDORCREATED le $PAGEEDITDATE par « $PAGEEDITOR », visitez $PAGETITLE_URL pour visualiser la version actuelle.

$NEWPAGE

Résumé du contributeur : $PAGESUMMARY $PAGEMINOREDIT

Contactez ce contributeur :
courriel : $PAGEEDITOR_EMAIL
wiki : $PAGEEDITOR_WIKI

Il n’y aura pas d’autres notifications en cas de changements ultérieurs, à moins que vous ne visitiez cette page.
Vous pouvez aussi réinitialiser les drapeaux de notification pour toutes les pages de votre liste de suivi.

             Votre système de notification de {{SITENAME}}

--
Pour modifier les paramètres de notification par courriel, visitez
{{canonicalurl:{{#special:Preferences}}}}

Pour modifier les paramètres de votre liste de suivi, visitez
{{canonicalurl:{{#special:EditWatchlist}}}}

Pour supprimer la page de votre liste de suivi, visitez
$UNWATCHURL

Retour et assistance :
{{canonicalurl:{{MediaWiki:Helppage}}}}',

# Delete
'deletepage' => 'Supprimer la page',
'confirm' => 'Confirmer',
'excontent' => 'contenait « $1 »',
'excontentauthor' => 'contenait « $1 » (et son seul contributeur était [[Special:Contributions/$2|$2]])',
'exbeforeblank' => 'contenait avant blanchiment « $1 »',
'exblank' => 'la page était vide',
'delete-confirm' => 'Supprimer « $1 »',
'delete-legend' => 'Supprimer',
'historywarning' => "'''Attention :''' la page que vous êtes sur le point de supprimer a un historique avec environ $1 {{PLURAL:$1|version|versions}} :",
'confirmdeletetext' => "Vous êtes sur le point de supprimer une page ou un fichier, ainsi que toutes ses versions antérieures historisées. Veuillez confirmer que c'est bien là ce que vous voulez faire, que vous en comprenez les conséquences et que vous faites ceci en accord avec les [[{{MediaWiki:Policy-url}}|règles internes]].",
'actioncomplete' => 'Action effectuée',
'actionfailed' => "L'action a échoué",
'deletedtext' => '« $1 » a été supprimée.
Voir $2 pour une liste des suppressions récentes.',
'dellogpage' => 'Journal des suppressions de page',
'dellogpagetext' => 'Voici la liste des suppressions les plus récentes.',
'deletionlog' => 'journal des suppressions',
'reverted' => 'Version précédente rétablie',
'deletecomment' => 'Motif :',
'deleteotherreason' => 'Motif autre ou supplémentaire :',
'deletereasonotherlist' => 'Autre motif',
'deletereason-dropdown' => "* Motifs de suppression les plus courants
** Demande de l'auteur
** Violation des droits d'auteur
** Vandalisme",
'delete-edit-reasonlist' => 'Modifier les motifs de suppression de page',
'delete-toobig' => 'Cette page possède un historique important de modifications, dépassant $1 version{{PLURAL:$1||s}}.
La suppression de telles pages a été restreinte pour prévenir des perturbations accidentelles de {{SITENAME}}.',
'delete-warning-toobig' => "Cette page possède un historique important de modifications, dépassant $1 version{{PLURAL:$1||s}}.
La supprimer peut perturber le fonctionnement de la base de données de {{SITENAME}} ;
veuiller ne procéder qu'avec prudence.",

# Rollback
'rollback' => 'Révoquer les modifications',
'rollback_short' => 'Révoquer',
'rollbacklink' => 'révoquer',
'rollbacklinkcount' => 'révoquer $1 {{PLURAL:$1|modification|modifications}}',
'rollbacklinkcount-morethan' => 'révoquer plus de $1 {{PLURAL:$1|modification|modifications}}',
'rollbackfailed' => 'La révocation a échoué',
'cantrollback' => 'Impossible de révoquer la modification ;
le dernier contributeur est le seul auteur de cette page.',
'alreadyrolled' => "Impossible de révoquer la dernière modification de la page « [[:$1]] » effectuée par [[User:$2|$2]] ([[User talk:$2|Discuter]]{{int:pipe-separator}}[[Special:Contributions/$2|{{int:contribslink}}]]) ;
quelqu'un d'autre a déjà modifié ou révoqué la page.

La dernière modification de la page a été effectuée par [[User:$3|$3]] ([[User talk:$3|Discuter]]{{int:pipe-separator}}[[Special:Contributions/$3|{{int:contribslink}}]]).",
'editcomment' => "Le résumé de la modification était : « ''$1'' ».",
'revertpage' => 'Révocation des modifications de [[Special:Contributions/$2|$2]] ([[User talk:$2|discussion]]) vers la dernière version de [[User:$1|$1]]',
'revertpage-nouser' => "Révocation des modifications par (nom d'utilisateur supprimé) à la dernière version par [[User:$1|$1]]",
'rollback-success' => 'Révocation des modifications effectuées par $1 ;
rétablissement de la dernière version par $2.',

# Edit tokens
'sessionfailure-title' => 'Erreur de session',
'sessionfailure' => "Votre session de connexion semble avoir des problèmes ;
cette action a été annulée en prévention d'un piratage de session.
Veuillez cliquer sur « Précédent », rechargez la page d'où vous venez, puis réessayez.",

# Protect
'protectlogpage' => 'Journal des protections',
'protectlogtext' => 'Voici une liste des modifications des protections de pages.
Consultez la [[Special:ProtectedPages|liste des pages protégées]] pour la liste des protections actuellement opérationnelles.',
'protectedarticle' => 'a protégé « [[$1]] »',
'modifiedarticleprotection' => 'a modifié le niveau de protection de « [[$1]] »',
'unprotectedarticle' => 'a supprimé la protection de « [[$1]] »',
'movedarticleprotection' => 'a déplacé les paramètres de protection depuis « [[$2]] » vers « [[$1]] »',
'protect-title' => 'Changer le niveau de protection pour « $1 »',
'protect-title-notallowed' => 'Voir le niveau de protection de « $1 »',
'prot_1movedto2' => '[[$1]] renommé en [[$2]]',
'protect-badnamespace-title' => 'Espace de noms non protégeable',
'protect-badnamespace-text' => 'Les pages dans cet espace de noms ne peuvent pas être protégées.',
'protect-legend' => 'Confirmer la protection',
'protectcomment' => 'Motif :',
'protectexpiry' => "Date d'expiration :",
'protect_expiry_invalid' => "La date d'expiration est invalide.",
'protect_expiry_old' => "La date d'expiration est déjà passée.",
'protect-unchain-permissions' => "Déverrouiller davantage d'options de protection",
'protect-text' => "Vous pouvez consulter et modifier le niveau de protection de la page '''$1'''.",
'protect-locked-blocked' => "Vous ne pouvez pas modifier les niveaux de protection tant que vous êtes bloqué{{GENDER:||e|(e)}}.
Voici les réglages actuels de la page '''$1''' :",
'protect-locked-dblock' => "Le niveau de protection ne peut pas être modifié car la base de données est verrouillée.
Voici les réglages actuels de la page '''$1''' :",
'protect-locked-access' => "Vous n'avez pas les droits nécessaires pour modifier les niveaux de protection de pages.
Voici les réglages actuels de la page '''$1''' :",
'protect-cascadeon' => "Cette page est protégée car incluse dans {{PLURAL:$1|la page suivante, qui a été protégée|les pages suivantes, qui ont été protégées}} avec l'option « protection en cascade » activée. Vous pouvez changer le niveau de protection de cette page sans que cela n'affecte la protection en cascade.",
'protect-default' => 'Autoriser tous les utilisateurs',
'protect-fallback' => 'Autoriser uniquement les utilisateurs avec le droit « $1 »',
'protect-level-autoconfirmed' => 'Autoriser uniquement les utilisateurs auto-confirmés',
'protect-level-sysop' => 'Autoriser uniquement les administrateurs',
'protect-summary-cascade' => 'protection en cascade',
'protect-expiring' => 'expire le $1 (UTC)',
'protect-expiring-local' => 'expire le $1',
'protect-expiry-indefinite' => 'infini',
'protect-cascade' => 'Protéger les pages incluses dans celle-ci (protection en cascade)',
'protect-cantedit' => "Vous ne pouvez pas changer les niveaux de protection de cette page car vous n'avez pas la permission de la modifier.",
'protect-othertime' => "Autre date d'expiration :",
'protect-othertime-op' => "autre date d'expiration",
'protect-existing-expiry' => "Date d'expiration existante : $2 à $3",
'protect-otherreason' => 'Motif autre ou supplémentaire :',
'protect-otherreason-op' => 'Autre motif',
'protect-dropdown' => '* Motifs de protection courants
** Vandalisme excessif
** Pourriels
** Conflits de modifications contre-productives
** Page à fort trafic',
'protect-edit-reasonlist' => 'Modifier les motifs de protection',
'protect-expiry-options' => '1 heure:1 hour,1 jour:1 day,1 semaine:1 week,2 semaines:2 weeks,1 mois:1 month,3 mois:3 months,6 mois:6 months,1 an:1 year,indéfiniment:infinite',
'restriction-type' => 'Autorisation :',
'restriction-level' => 'Niveau de restriction :',
'minimum-size' => 'Taille minimum',
'maximum-size' => 'Taille maximum',
'pagesize' => '(octets)',

# Restrictions (nouns)
'restriction-edit' => 'Modifier',
'restriction-move' => 'Renommer',
'restriction-create' => 'Créer',
'restriction-upload' => 'Import de fichiers',

# Restriction levels
'restriction-level-sysop' => 'protection complète',
'restriction-level-autoconfirmed' => 'semi-protection',
'restriction-level-all' => 'tout niveau',

# Undelete
'undelete' => 'Voir les pages supprimées',
'undeletepage' => 'Voir et restaurer des pages supprimées',
'undeletepagetitle' => "'''La liste suivante contient des versions supprimées de [[:$1|$1]]'''.",
'viewdeletedpage' => 'Voir les pages supprimées',
'undeletepagetext' => "{{PLURAL:$1|La page suivante a été supprimée et se trouve|Les pages suivantes ont été supprimées et se trouvent}} dans la base de données archive, d'où {{PLURAL:$1|elle peut|elles peuvent}} encore être restaurée{{PLURAL:$1||s}}.
L'archive peut être nettoyée périodiquement.",
'undelete-fieldset-title' => 'Restaurer les versions',
'undeleteextrahelp' => "Pour restaurer l'historique complet de cette page, laissez toutes les cases décochées et cliquez sur '''''Restaurer'''''.
Pour effectuer une restauration partielle, cochez les cases correspondant aux versions à rétablir, puis cliquez sur '''''Restaurer'''''.",
'undeleterevisions' => '$1 {{PLURAL:$1|version archivée|versions archivées}}',
'undeletehistory' => "Si vous restaurez la page, toutes les versions seront replacées dans l'historique.
Si une nouvelle page avec le même nom a été créée depuis la suppression, les versions restaurées apparaîtront dans l'historique antérieur et la version courante ne sera pas automatiquement remplacée.",
'undeleterevdel' => 'La restauration ne sera pas effectuée si, au final, la version la plus récente de la page ou du fichier reste partiellement supprimée.
Dans de tels cas, vous devez décocher ou démasquer les versions effacées les plus récentes (en tête de liste).',
'undeletehistorynoadmin' => "Cette page a été supprimée.
Le motif de la suppression est indiqué dans le résumé ci-dessous, avec les détails des utilisateurs qui l'ont modifié avant sa suppression.
Le contenu effectif de ces versions supprimées n'est accessible qu'aux administrateurs.",
'undelete-revision' => 'Version supprimée de $1 (version du $4 à $5) par $3 :',
'undeleterevision-missing' => "Version incorrecte ou manquante.
Vous avez peut-être un mauvais lien, ou la version a pu être restaurée ou supprimée de l'archive.",
'undelete-nodiff' => 'Aucune version précédente trouvée.',
'undeletebtn' => 'Restaurer',
'undeletelink' => 'visualiser/rétablir',
'undeleteviewlink' => 'voir',
'undeletereset' => 'Réinitialiser',
'undeleteinvert' => 'Inverser la sélection',
'undeletecomment' => 'Motif :',
'undeletedrevisions' => '$1 {{PLURAL:$1|version restaurée|versions restaurées}}',
'undeletedrevisions-files' => '$1 version{{PLURAL:$1||s}} et $2 fichier{{PLURAL:$2||s}} restauré{{PLURAL:$2||s}}',
'undeletedfiles' => '$1 {{PLURAL:$1|fichier restauré|fichiers restaurés}}',
'cannotundelete' => 'La restauration a échoué ;
un autre utilisateur a probablement déjà restauré la page.',
'undeletedpage' => "'''La page $1 a été restaurée.'''

Consultez le [[Special:Log/delete|journal des suppressions]] pour obtenir la liste des récentes suppressions et restaurations.",
'undelete-header' => 'Consultez le [[Special:Log/delete|journal des suppressions]] pour lister les pages récemment supprimées.',
'undelete-search-title' => 'Rechercher les pages supprimées',
'undelete-search-box' => 'Rechercher des pages supprimées',
'undelete-search-prefix' => 'Montrer les pages commençant par :',
'undelete-search-submit' => 'Rechercher',
'undelete-no-results' => "Aucune page correspondante n'a été trouvée dans les archives de suppression.",
'undelete-filename-mismatch' => 'Impossible de restaurer la version du fichier datée du $1 : le nom de fichier ne correspond pas.',
'undelete-bad-store-key' => 'Impossible de restaurer la version du fichier datée du $1 : le fichier était absent avant la suppression.',
'undelete-cleanup-error' => "Erreur lors de la suppression du fichier d'archive inutilisé « $1 ».",
'undelete-missing-filearchive' => "Impossible de restaurer le fichier d'archive avec l'identifiant $1 parce qu'il n'est pas dans la base de données.
Il a peut-être déjà été restauré.",
'undelete-error' => "Page d'erreur d'annulation",
'undelete-error-short' => 'Erreur lors de la restauration du fichier : $1',
'undelete-error-long' => 'Des erreurs ont été rencontrées lors de la restauration du fichier :

$1',
'undelete-show-file-confirm' => 'Êtes-vous sûr de vouloir visionner une version supprimée du fichier « <nowiki>$1</nowiki> » datant du $2 à $3 ?',
'undelete-show-file-submit' => 'Oui',

# Namespace form on various pages
'namespace' => 'Espace de noms :',
'invert' => 'Inverser la sélection',
'tooltip-invert' => "Cochez cette case pour cacher les modifications des pages dans l'espace de noms sélectionné (et l'espace de noms associé si coché)",
'namespace_association' => 'Espace de noms associé',
'tooltip-namespace_association' => "Cochez cette case pour inclure également l'espace de noms de discussion associé à l'espace de noms sélectionné",
'blanknamespace' => '(Principal)',

# Contributions
'contributions' => "Contributions de l'utilisateur",
'contributions-title' => "Liste des contributions de l'utilisateur $1",
'mycontris' => 'Contributions',
'contribsub2' => 'Pour $1 ($2)',
'nocontribs' => "Aucune modification correspondant à ces critères n'a été trouvée.",
'uctop' => '(dernière)',
'month' => 'À partir du mois (et précédents) :',
'year' => "À partir de l'année (et précédentes) :",

'sp-contributions-newbies' => 'Ne montrer que les contributions des nouveaux utilisateurs',
'sp-contributions-newbies-sub' => 'Parmi les nouveaux comptes',
'sp-contributions-newbies-title' => "Contributions d'utilisateurs parmi les nouveaux comptes",
'sp-contributions-blocklog' => 'journal des blocages',
'sp-contributions-deleted' => 'contributions supprimées',
'sp-contributions-uploads' => 'imports',
'sp-contributions-logs' => 'journaux',
'sp-contributions-talk' => 'discuter',
'sp-contributions-userrights' => 'gérer les droits',
'sp-contributions-blocked-notice' => "Cet utilisateur est actuellement bloqué. La dernière entrée du journal des blocages est indiquée ci-dessous à titre d'information :",
'sp-contributions-blocked-notice-anon' => "Cette adresse IP est actuellement bloquée.
La dernière entrée du journal des blocages est indiquée ci-dessous à titre d'information :",
'sp-contributions-search' => 'Rechercher les contributions',
'sp-contributions-username' => "Adresse IP ou nom d'utilisateur :",
'sp-contributions-toponly' => 'Ne montrer que les contributions qui sont les dernières des articles',
'sp-contributions-submit' => 'Rechercher',

# What links here
'whatlinkshere' => 'Pages liées',
'whatlinkshere-title' => 'Pages qui pointent vers « $1 »',
'whatlinkshere-page' => 'Page :',
'linkshere' => "Les pages ci-dessous contiennent un lien vers '''[[:$1]]''' :",
'nolinkshere' => "Aucune page ne contient de lien vers '''[[:$1]]'''.",
'nolinkshere-ns' => "Aucune page ne contient de lien vers '''[[:$1]]''' dans l'espace de noms choisi.",
'isredirect' => 'page de redirection',
'istemplate' => 'inclusion',
'isimage' => 'lien vers le fichier',
'whatlinkshere-prev' => '{{PLURAL:$1|précédente|$1 précédentes}}',
'whatlinkshere-next' => '{{PLURAL:$1|suivante|$1 suivantes}}',
'whatlinkshere-links' => '← liens',
'whatlinkshere-hideredirs' => '$1 les redirections',
'whatlinkshere-hidetrans' => '$1 les inclusions',
'whatlinkshere-hidelinks' => '$1 les liens',
'whatlinkshere-hideimages' => '$1 les fichiers liés',
'whatlinkshere-filters' => 'Filtres',

# Block/unblock
'autoblockid' => 'Blocage automatique #$1',
'block' => "Bloquer l'utilisateur",
'unblock' => "Débloquer l'utilisateur",
'blockip' => "Bloquer l'utilisateur",
'blockip-title' => "Bloquer l'utilisateur",
'blockip-legend' => "Bloquer l'utilisateur",
'blockiptext' => "Utilisez le formulaire ci-dessous pour bloquer l'accès aux modifications faites à partir d'une adresse IP spécifique ou d'un nom d'utilisateur.
Une telle mesure ne devrait être prise que pour prévenir le vandalisme et en accord avec les [[{{MediaWiki:Policy-url}}|règles internes]].
Donnez ci-dessous un motif précis (par exemple en citant les pages qui ont été vandalisées).",
'ipadressorusername' => "Adresse IP ou nom d'utilisateur :",
'ipbexpiry' => 'Durée avant expiration :',
'ipbreason' => 'Motif :',
'ipbreasonotherlist' => 'Autre motif',
'ipbreason-dropdown' => "* Motifs de blocage les plus fréquents
** Insertion de fausses informations
** Suppression injustifiée de contenu des pages
** Insertion répétée de liens externes publicitaires (pollupostage)
** Insertion de contenu sans aucun sens et de déchets dans les pages
** Tentative d'intimidation ou harcèlement
** Abus d'utilisation de comptes multiples
** Nom d'utilisateur inacceptable, injurieux ou diffamant",
'ipb-hardblock' => 'Empêcher les utilisateurs connectés de modifier en utilisant cette adresse IP',
'ipbcreateaccount' => 'Empêcher la création de compte',
'ipbemailban' => "Empêcher l'utilisateur d'envoyer des courriels",
'ipbenableautoblock' => "Bloquer automatiquement la dernière adresse IP utilisée par l'utilisateur et toutes ses IPs ultérieures qu'il pourrait essayer",
'ipbsubmit' => 'Bloquer cet utilisateur',
'ipbother' => 'Autre durée :',
'ipboptions' => '2 heures:2 hours,1 jour:1 day,3 jours:3 days,1 semaine:1 week,2 semaines:2 weeks,1 mois:1 month,3 mois:3 months,6 mois:6 months,1 an:1 year,indéfiniment:infinite',
'ipbotheroption' => 'autre',
'ipbotherreason' => 'Motif différent ou supplémentaire :',
'ipbhidename' => "Masquer le nom d'utilisateur des modifications et des listes",
'ipbwatchuser' => 'Suivre les pages utilisateur et de discussion de cet utilisateur',
'ipb-disableusertalk' => 'Empêcher l’utilisateur de modifier sa page de discussion pendant le blocage',
'ipb-change-block' => 'Bloquer à nouveau cet utilisateur avec ces paramètres',
'ipb-confirm' => 'Confirmer le blocage',
'badipaddress' => 'Adresse IP incorrecte',
'blockipsuccesssub' => 'Blocage réussi',
'blockipsuccesstext' => '[[Special:Contributions/$1|$1]] a été bloqué{{GENDER:$1||e|}}.<br />
Consultez la [[Special:BlockList|liste des blocages]] pour revoir les blocages.',
'ipb-blockingself' => 'Vous êtes sur le point de bloquer votre propre compte ! Êtes-vous certain de vouloir faire cela ?',
'ipb-confirmhideuser' => "Vous êtes sur le point de bloquer un utilisateur avec « cacher l'utilisateur » activé. Cela supprime le nom de l'utilisateur dans toutes les listes et les entrées du journal. Êtes-vous sûr de vouloir le faire ?",
'ipb-edit-dropdown' => 'Modifier les motifs de blocage par défaut',
'ipb-unblock-addr' => 'Débloquer $1',
'ipb-unblock' => 'Débloquer un compte utilisateur ou une adresse IP',
'ipb-blocklist' => 'Voir les blocages existants',
'ipb-blocklist-contribs' => 'Contributions pour $1',
'unblockip' => 'Débloquer un utilisateur ou une adresse IP',
'unblockiptext' => "Utilisez le formulaire ci-dessous pour rétablir l'accès aux modifications depuis une adresse IP ou un nom d'utilisateur.",
'ipusubmit' => 'Supprimer ce blocage',
'unblocked' => '[[User:$1|$1]] a été débloqué',
'unblocked-range' => '$1 a été débloqué',
'unblocked-id' => 'Le blocage $1 a été enlevé',
'blocklist' => 'Utilisateurs bloqués',
'ipblocklist' => 'Utilisateurs bloqués',
'ipblocklist-legend' => 'Chercher un utilisateur bloqué',
'blocklist-userblocks' => 'Masquer les blocages de comptes',
'blocklist-tempblocks' => 'Masquer les blocages temporaires',
'blocklist-addressblocks' => "Masquer les blocages d'adresses IP uniques",
'blocklist-rangeblocks' => 'Masquer les blocs de portée',
'blocklist-timestamp' => 'Date et heure',
'blocklist-target' => 'Cible',
'blocklist-expiry' => "Date d'expiration",
'blocklist-by' => 'Administrateur ayant effectué le blocage',
'blocklist-params' => 'Paramètres de blocage',
'blocklist-reason' => 'Motif',
'ipblocklist-submit' => 'Rechercher',
'ipblocklist-localblock' => 'Blocage local',
'ipblocklist-otherblocks' => '{{PLURAL:$1|Autre blocage|Autres blocages}}',
'infiniteblock' => 'permanent',
'expiringblock' => 'expire le $1 à $2',
'anononlyblock' => 'utilisateur non enregistré uniquement',
'noautoblockblock' => 'blocage automatique désactivé',
'createaccountblock' => 'création de compte bloquée',
'emailblock' => 'courriel bloqué',
'blocklist-nousertalk' => 'ne peut modifier sa propre page de discussion',
'ipblocklist-empty' => 'La liste des adresses IP bloquées est actuellement vide.',
'ipblocklist-no-results' => "L'adresse IP ou l'utilisateur demandé n'est pas bloqué.",
'blocklink' => 'bloquer',
'unblocklink' => 'débloquer',
'change-blocklink' => 'modifier le blocage',
'contribslink' => 'contributions',
'emaillink' => 'Envoyer un courriel',
'autoblocker' => 'Vous avez été bloqué automatiquement parce que votre adresse IP a été récemment utilisée par « [[User:$1|$1]] ».
Le motif fourni pour le blocage de $1 est : « $2 ».',
'blocklogpage' => 'Journal des blocages',
'blocklog-showlog' => 'Cet utilisateur a été bloqué précédemment. Le journal des blocages est disponible ci-dessous :',
'blocklog-showsuppresslog' => 'Cet utilisateur a été bloqué et caché précédemment. Le journal des suppressions est disponible ci-dessous :',
'blocklogentry' => 'a bloqué [[$1]] ; expiration : $2 $3',
'reblock-logentry' => 'a modifié les paramètres du blocage de [[$1]] avec une expiration au $2 $3',
'blocklogtext' => "Ceci est le journal des actions de blocages et déblocages d'utilisateurs.
Les adresses IP automatiquement bloquées ne sont pas listées.
Consultez la [[Special:BlockList|liste des blocages]] pour voir les bannissements et blocages effectivement en cours.",
'unblocklogentry' => 'a débloqué $1',
'block-log-flags-anononly' => 'utilisateurs anonymes seulement',
'block-log-flags-nocreate' => 'création de compte interdite',
'block-log-flags-noautoblock' => 'autoblocage des IP désactivé',
'block-log-flags-noemail' => 'envoi de courriel interdit',
'block-log-flags-nousertalk' => 'ne peut modifier sa propre page de discussion',
'block-log-flags-angry-autoblock' => 'autoblocage amélioré activé',
'block-log-flags-hiddenname' => "nom d'utilisateur caché",
'range_block_disabled' => 'Le droit administrateur de créer des blocages de plages IP est désactivé.',
'ipb_expiry_invalid' => "Durée d'expiration incorrecte.",
'ipb_expiry_temp' => "Les blocages de noms d'utilisateurs cachés doivent être permanents.",
'ipb_hide_invalid' => 'Impossible de supprimer ce compte ; il semble avoir trop de modifications.',
'ipb_already_blocked' => '« $1 » est déjà bloqué',
'ipb-needreblock' => '$1 est déjà bloqué. Voulez-vous modifier les paramètres ?',
'ipb-otherblocks-header' => '{{PLURAL:$1|Autre blocage|Autres blocages}}',
'unblock-hideuser' => "Vous ne pouvez pas débloquer cet utilisateur, car son nom d'utilisateur a été masqué.",
'ipb_cant_unblock' => "Erreur : identifiant de blocage $1 non trouvé.
Il est possible qu'un déblocage ait déjà été effectué.",
'ipb_blocked_as_range' => "Erreur : l'adresse IP $1 n'est pas bloquée directement et ne peut donc pas être débloquée.
Elle fait cependant partie de la plage $2 qui, elle, peut être débloquée.",
'ip_range_invalid' => 'Plage IP incorrecte.',
'ip_range_toolarge' => 'Les blocages de plages plus grandes que /$1 ne sont pas autorisées.',
'blockme' => 'Bloquez-moi',
'proxyblocker' => 'Bloqueur de mandataires',
'proxyblocker-disabled' => 'Cette fonction est désactivée.',
'proxyblockreason' => "Votre adresse IP a été bloquée car il s'agit d'un mandataire ouvert.
Veuillez contacter votre fournisseur d'accès Internet ou votre support technique et l'informer de ce sérieux problème de sécurité.",
'proxyblocksuccess' => 'Fait.',
'sorbsreason' => 'Votre adresse IP est listée comme mandataire ouvert dans le DNSBL utilisé par {{SITENAME}}.',
'sorbs_create_account_reason' => 'Votre adresse IP est listée comme mandataire ouvert dans le DNSBL utilisé par {{SITENAME}}.
Vous ne pouvez pas créer un compte.',
'cant-block-while-blocked' => "Vous ne pouvez pas bloquer d'autres utilisateurs tant que vous êtes bloqué{{GENDER:||e|(e)}}.",
'cant-see-hidden-user' => "L'utilisateur que vous tentez de bloquer a déjà été bloqué et masqué. N'ayant pas le droit ''hideuser'', vous ne pouvez pas voir ou modifier le blocage de cet utilisateur.",
'ipbblocked' => "Vous ne pouvez pas bloquer ou débloquer d'autres utilisateurs, parce que vous êtes vous-même bloqué",
'ipbnounblockself' => "Vous n'êtes pas autorisé à vous débloquer vous-même",

# Developer tools
'lockdb' => 'Verrouiller la base de données',
'unlockdb' => 'Déverrouiller la base de données',
'lockdbtext' => "Le verrouillage de la base de données empêchera tous les utilisateurs de modifier des pages, d'enregistrer leurs préférences, de modifier leur liste de suivi et d'effectuer toutes les autres opérations nécessitant des changements dans la base de données.
Veuillez confirmer que c'est bien là ce que vous voulez faire et que vous déverrouillerez la base dès que votre opération de maintenance sera terminée.",
'unlockdbtext' => "Le déverrouillage de la base de données permettra à nouveau à tous les utilisateurs de modifier des pages, de changer leurs préférences, de modifier leur liste de suivi et d'effectuer les autres opérations nécessitant des changements dans la base de données.
Veuillez confirmer que c'est bien là ce que vous voulez faire.",
'lockconfirm' => 'Oui, je confirme que je souhaite verrouiller la base de données.',
'unlockconfirm' => 'Oui, je confirme que je souhaite déverrouiller la base de données.',
'lockbtn' => 'Verrouiller la base de données',
'unlockbtn' => 'Déverrouiller la base de données',
'locknoconfirm' => "Vous n'avez pas coché la case de confirmation.",
'lockdbsuccesssub' => 'Verrouillage de la base de données réussi',
'unlockdbsuccesssub' => 'Verrouillage de la base de données supprimé',
'lockdbsuccesstext' => "La base de données a été verrouillée.<br />
N'oubliez pas de la [[Special:UnlockDB|déverrouiller]] lorsque vous aurez terminé votre opération de maintenance.",
'unlockdbsuccesstext' => 'La base de données a été déverrouillée.',
'lockfilenotwritable' => "Le fichier de verrouillage de la base de données n'est pas inscriptible.
Pour bloquer ou débloquer la base de données, il doit être accessible par le serveur web.",
'databasenotlocked' => "La base de données n'est pas verrouillée.",
'lockedbyandtime' => '(par $1 le $2 à $3)',

# Move page
'move-page' => 'Renommer $1',
'move-page-legend' => 'Renommer une page',
'movepagetext' => "Utilisez le formulaire ci-dessous pour renommer une page, en déplaçant tout son historique vers le nouveau nom. L'ancien titre deviendra une page de redirection vers le nouveau titre. Vous pouvez mettre à jour automatiquement les redirections actuelles qui pointent vers le titre original. Si vous choisissez de ne pas le faire, assurez-vous de vérifier toute [[Special:DoubleRedirects|double redirection]] ou [[Special:BrokenRedirects|redirection cassée]]. Vous avez la responsabilité de vous assurer que les liens continuent de pointer vers leur destination supposée.

Notez que la page ne sera '''pas''' renommée s'il existe déjà une page avec le nouveau titre, sauf si cette dernière a un historique de modifications vierge et est une simple redirection. Ceci permet de renommer une page vers sa position d'origine si le déplacement s'avère erroné.

'''Attention !'''
Ceci peut provoquer un changement radical et imprévu pour une page souvent consultée ; assurez-vous d'en avoir compris les conséquences avant de continuer.",
'movepagetext-noredirectfixer' => "Utilisez le formulaire ci-dessous pour renommer une page, en déplaçant tout son historique vers le nouveau nom.
L'ancien titre deviendra une page de redirection vers le nouveau titre.
Vérifiez bien les [[Special:DoubleRedirects|doubles redirections]] ou les [[Special:BrokenRedirects|redirections cassées]].
Vous avez la responsabilité de vous assurer que les liens continuent de pointer vers leur destination supposée.

Notez que la page ne sera '''pas''' déplacée s'il existe déjà une page avec le nouveau titre, sauf si cette dernière a un historique de modifications vierge et est soit vide, soit une simple redirection. Ceci permet de renommer une page vers sa position d'origine si le déplacement s'avère erroné, et il est impossible d'écraser une page existante.

'''Attention !'''
Ceci peut provoquer un changement radical et imprévu pour une page souvent consultée ; assurez-vous d'en avoir compris les conséquences avant de continuer.",
'movepagetalktext' => "La page de discussion associée, si présente, sera automatiquement renommée '''sauf si :'''
* vous déplacez la page vers un autre espace de noms, ou
* une page de discussion non vide existe déjà sous le nouveau nom, ou
* vous décochez la case ci-dessous.

Dans ces cas-là, vous devrez renommer ou fusionner cette page de discussion manuellement si vous le désirez.",
'movearticle' => 'Renommer la page :',
'moveuserpage-warning' => "'''Attention :''' Vous êtes sur le point de renommer une page d'utilisateur. Veuillez noter que seul la page sera renommée et que l'utilisateur '''ne''' sera '''pas''' renommé.",
'movenologin' => "Vous n'êtes pas identifié{{GENDER:||e|(e)}}.",
'movenologintext' => "Pour pouvoir renommer une page, vous devez être [[Special:UserLogin|identifié{{GENDER:||e|(e)}}]] avec un compte utilisateur enregistré et d'ancienneté suffisante.",
'movenotallowed' => "Vous n'avez pas la permission de renommer les pages.",
'movenotallowedfile' => "Vous n'avez pas la permission de renommer les fichiers.",
'cant-move-user-page' => "Vous n'avez pas la permission de renommer les pages principales d'utilisateurs (en dehors de leurs sous-pages).",
'cant-move-to-user-page' => "Vous n'avez pas la permission de renommer une page vers une page utilisateur (à l'exception d'une sous-page).",
'newtitle' => 'Vers le nouveau titre :',
'move-watch' => 'Suivre les pages originale et nouvelle',
'movepagebtn' => 'Renommer la page',
'pagemovedsub' => 'Renommage réussi',
'movepage-moved' => "'''« $1 » a été renommée en « $2 »'''",
'movepage-moved-redirect' => "Une redirection depuis l'ancien nom a été créée.",
'movepage-moved-noredirect' => "La création d'une redirection depuis l'ancien nom a été annulée.",
'articleexists' => "Il existe déjà une page portant ce titre, ou le titre que vous avez choisi n'est pas correct.
Veuillez en choisir un autre.",
'cantmove-titleprotected' => 'Vous ne pouvez pas déplacer une page vers cet emplacement car la création de page avec ce nouveau titre a été protégée.',
'talkexists' => "'''La page elle-même a été déplacée avec succès, mais la page de discussion n'a pas pu être déplacée car il en existait déjà une sous le nouveau nom. Veuillez les fusionner manuellement.'''",
'movedto' => 'renommé en',
'movetalk' => 'Renommer aussi la page de discussion associée',
'move-subpages' => "Renommer les sous-pages (jusqu'à $1 {{PLURAL:$1|page|pages}})",
'move-talk-subpages' => "Renommer les sous-pages de la page de discussion (jusqu'à $1 pages)",
'movepage-page-exists' => 'La page $1 existe déjà et ne peut pas être écrasée automatiquement.',
'movepage-page-moved' => 'La page $1 a été renommée en $2.',
'movepage-page-unmoved' => "La page $1 n'a pas pu être renommée en $2.",
'movepage-max-pages' => 'Le maximum de $1 {{PLURAL:$1|page renommée|pages renommées}} a été atteint et aucune autre page ne sera renommée automatiquement.',
'movelogpage' => 'Journal des renommages',
'movelogpagetext' => 'Voici la liste de toutes les pages renommées ou déplacées.',
'movesubpage' => 'Sous-page{{PLURAL:$1||s}}',
'movesubpagetext' => 'Cette page a $1 {{PLURAL:$1|sous-page affichée|sous-pages affichées}} ci-dessous.',
'movenosubpage' => "Cette page n'a aucune sous-page.",
'movereason' => 'Motif :',
'revertmove' => 'rétablir',
'delete_and_move' => 'Supprimer et renommer',
'delete_and_move_text' => '== Suppression requise ==
La page de destination « [[:$1]] » existe déjà.
Êtes-vous certain{{GENDER:||e|}} de vouloir la supprimer pour permettre ce renommage ?',
'delete_and_move_confirm' => 'Oui, supprimer la page de destination',
'delete_and_move_reason' => 'Page supprimée pour permettre le renommage depuis « [[$1]] »',
'selfmove' => "Les titres d'origine et de destination sont les mêmes ;
impossible de renommer une page sur elle-même.",
'immobile-source-namespace' => "Vous ne pouvez pas renommer les pages dans l'espace de noms « $1 »",
'immobile-target-namespace' => "Vous ne pouvez pas renommer des pages vers l'espace de noms « $1 »",
'immobile-target-namespace-iw' => 'Les destinations interwikis ne sont pas une cible valide pour les déplacements.',
'immobile-source-page' => "Cette page n'est pas renommable.",
'immobile-target-page' => "Il n'est pas possible de renommer la page vers ce titre.",
'imagenocrossnamespace' => 'Impossible de renommer un fichier vers un espace de noms autre que fichier.',
'nonfile-cannot-move-to-file' => "Impossible de renommer quelque chose d'autre qu'un fichier vers l'espace de noms fichier.",
'imagetypemismatch' => 'La nouvelle extension de ce fichier ne correspond pas à son type.',
'imageinvalidfilename' => 'Le nom du fichier cible est incorrect',
'fix-double-redirects' => 'Mettre à jour les redirections pointant vers le titre original',
'move-leave-redirect' => 'Laisser une redirection vers le nouveau titre',
'protectedpagemovewarning' => "'''Attention :''' Cette page a été protégée afin que seuls les utilisateurs possédant les droits d'administrateur puissent la renommer. La dernière entrée du journal est affichée ci-dessous pour référence :",
'semiprotectedpagemovewarning' => "'''Note :''' Cette page a été protégée afin que seuls les utilisateurs enregistrés puissent la renommer. La dernière entrée du journal est affichée ci-dessous pour référence :",
'move-over-sharedrepo' => '== Le fichier existe ==
[[:$1]] existe déjà sur un dépôt partagé. Renommer ce fichier rendra le fichier sur le dépôt partage inaccessible.',
'file-exists-sharedrepo' => 'Le nom choisi est déjà utilisé par un fichier sur un dépôt partagé.
Choisissez un autre nom.',

# Export
'export' => 'Exporter des pages',
'exporttext' => "Vous pouvez exporter en XML le texte et l'historique d'une page ou d'un ensemble de pages ;
le résultat peut alors être importé dans un autre wiki utilisant le logiciel MediaWiki via la [[Special:Import|page d'importation]].

Pour exporter des pages, entrez leurs titres dans la boîte de texte ci-dessous, à raison d'un titre par ligne. Sélectionnez si vous désirez ou non la version actuelle avec toutes les anciennes versions, avec les lignes de l'historique de la page, ou simplement la page actuelle avec des informations sur la dernière modification.

Dans ce dernier cas vous pouvez aussi utiliser un lien, tel que [[{{#Special:Export}}/{{MediaWiki:Mainpage}}]] pour la page [[{{MediaWiki:Mainpage}}]].",
'exportall' => 'Exporter toutes les pages',
'exportcuronly' => "Exporter uniquement la version courante, sans l'historique complet",
'exportnohistory' => "----
'''Note :''' l'exportation de l'historique complet des pages à l'aide de ce formulaire a été désactivée pour des raisons de performance.",
'exportlistauthors' => 'Inclure une liste complète des contributeurs pour chaque page',
'export-submit' => 'Exporter',
'export-addcattext' => 'Ajouter les pages de la catégorie :',
'export-addcat' => 'Ajouter',
'export-addnstext' => "Ajouter des pages dans l'espace de noms :",
'export-addns' => 'Ajouter',
'export-download' => 'Enregistrer dans un fichier',
'export-templates' => 'Inclure les modèles',
'export-pagelinks' => 'Inclure les pages liées à une profondeur de :',

# Namespace 8 related
'allmessages' => 'Messages système',
'allmessagesname' => 'Nom du message',
'allmessagesdefault' => 'Message par défaut',
'allmessagescurrent' => 'Message actuel',
'allmessagestext' => "Ceci est la liste des messages disponibles dans l'espace MediaWiki.
Veuillez visiter la [//www.mediawiki.org/wiki/Localisation Localisation de MediaWiki] et [//translatewiki.net/ translatewiki.net] si vous désirez contribuer à la localisation générique de MediaWiki.",
'allmessagesnotsupportedDB' => "Cette page '''{{ns:special}}:Allmessages''' n'est pas utilisable car '''\$wgUseDatabaseMessages''' a été désactivé.",
'allmessages-filter-legend' => 'Filtrer',
'allmessages-filter' => 'Filtrer par état de modification :',
'allmessages-filter-unmodified' => 'Non modifié',
'allmessages-filter-all' => 'Tous',
'allmessages-filter-modified' => 'Modifié',
'allmessages-prefix' => 'Filtrer par préfixe :',
'allmessages-language' => 'Langue :',
'allmessages-filter-submit' => 'Appliquer',

# Thumbnails
'thumbnail-more' => 'Agrandir',
'filemissing' => 'Fichier manquant',
'thumbnail_error' => 'Erreur lors de la création de la miniature : $1',
'djvu_page_error' => 'Page DjVu hors limites',
'djvu_no_xml' => 'Impossible de récupérer le XML pour le fichier DjVu',
'thumbnail-temp-create' => 'Impossible de créer le fichier de vignette temporaire',
'thumbnail-dest-create' => "Impossible d'enregistrer la vignette sur la destination",
'thumbnail_invalid_params' => 'Paramètres de la miniature incorrects',
'thumbnail_dest_directory' => 'Impossible de créer le répertoire de destination',
'thumbnail_image-type' => "Type d'image non supporté",
'thumbnail_gd-library' => 'Configuration incomplète de la bibliothèque GD : fonction $1 introuvable',
'thumbnail_image-missing' => 'Le fichier suivant est introuvable : $1',

# Special:Import
'import' => 'Importer des pages',
'importinterwiki' => 'Importation inter-wiki',
'import-interwiki-text' => "Sélectionnez un wiki et un titre de page à importer.
Les dates des versions et les noms des contributeurs seront préservés.
Toutes les actions d'importation inter-wiki sont consignées dans l'[[Special:Log/import|historique des importations]].",
'import-interwiki-source' => 'Wiki et page sources :',
'import-interwiki-history' => "Copier toutes les versions de l'historique de cette page",
'import-interwiki-templates' => 'Inclure tous les modèles',
'import-interwiki-submit' => 'Importer',
'import-interwiki-namespace' => 'Espace de noms de destination :',
'import-interwiki-rootpage' => 'Page racine de destination (optionnelle):',
'import-upload-filename' => 'Nom du fichier :',
'import-comment' => 'Commentaire :',
'importtext' => "Veuillez exporter le fichier depuis le wiki d'origine en utilisant son [[Special:Export|outil d'exportation]].
Sauvegardez-le sur votre disque dur puis importez-le ici.",
'importstart' => 'Importation des pages…',
'import-revision-count' => '$1 version{{PLURAL:$1||s}}',
'importnopages' => 'Aucune page à importer.',
'imported-log-entries' => '$1 {{PLURAL:$1|entrée|entrées}} du journal {{PLURAL:$1|importée|importées}}.',
'importfailed' => "Échec de l'importation : <nowiki>$1</nowiki>",
'importunknownsource' => 'Type inconnu de la source à importer',
'importcantopen' => "Impossible d'ouvrir le fichier à importer",
'importbadinterwiki' => 'Mauvais lien inter-wiki',
'importnotext' => 'Vide ou sans texte',
'importsuccess' => "L'importation a réussi !",
'importhistoryconflict' => "Un conflit a été détecté dans l'historique des versions (cette page a pu être importée auparavant).",
'importnosources' => "Aucune source d'importation inter-wiki n'a été définie et l'import direct d'historiques est désactivé.",
'importnofile' => "Aucun fichier d'importation n'a été envoyé.",
'importuploaderrorsize' => "L'import du fichier a échoué.
Sa taille est supérieure au maximum autorisé pour l'import de fichier.",
'importuploaderrorpartial' => "L'import du fichier échoué.
Son contenu n'a été transféré que partiellement.",
'importuploaderrortemp' => "L'import du fichier a échoué.
Un dossier temporaire est manquant.",
'import-parse-failure' => "Échec lors de l'analyse du XML à importer",
'import-noarticle' => 'Aucune page à importer !',
'import-nonewrevisions' => 'Toutes les versions ont été importées auparavant.',
'xml-error-string' => '$1 à la ligne $2, colonne $3 (octet $4) : $5',
'import-upload' => 'Import de données XML',
'import-token-mismatch' => 'Perte des données de session. Veuillez réessayez.',
'import-invalid-interwiki' => "Impossible d'importer depuis le wiki spécifié.",
'import-error-edit' => "La page « $1 » n'a pas été importée parce que vous n'êtes pas autorisés à la modifier.",
'import-error-create' => "La page « $1 » n'a pas été importée parce que vous n'êtes pas autorisés à la créer.",
'import-error-interwiki' => "La page « $1 » n'est pas importée parce que son nom est réservé pour un lien externe (interwiki).",
'import-error-special' => 'La page " $1 " n\'est pas importée parce qu\'elle appartient à un espace de noms special qui n\'en autorise aucune.',
'import-error-invalid' => "Page « $1 » n'est pas importée parce que son nom n'est pas valide.",
'import-options-wrong' => '{{PLURAL:$2|Mauvaise option|Mauvaises options}}: <nowiki>$1</nowiki>',
'import-rootpage-invalid' => 'La page racine fournie est un titre non valide.',
'import-rootpage-nosubpage' => 'L\'espace de noms "$1" de la page racine n\'autorise pas les sous-pages.',

# Import log
'importlogpage' => 'Journal des importations',
'importlogpagetext' => "Importations administratives de pages d'autres wikis, avec leur historique de modification.",
'import-logentry-upload' => 'a importé [[$1]] par envoi de fichier',
'import-logentry-upload-detail' => '$1 version{{PLURAL:$1||s}}',
'import-logentry-interwiki' => "a importé $1 d'un wiki à l'autre",
'import-logentry-interwiki-detail' => '$1 version{{PLURAL:$1||s}} depuis $2',

# JavaScriptTest
'javascripttest' => 'Test de JavaScript',
'javascripttest-disabled' => "Cette fonction n'a pas été activée sur ce wiki.",
'javascripttest-title' => 'Exécution des tests $1',
'javascripttest-pagetext-noframework' => "Cette page est réservée pour l'exécution des tests JavaScript.",
'javascripttest-pagetext-unknownframework' => 'Structure "$1" inconnue.',
'javascripttest-pagetext-frameworks' => "Veuillez choisir l'une des structures de test suivantes : $1",
'javascripttest-pagetext-skins' => 'Choisissez un habillage avec lequel lancer les tests :',
'javascripttest-qunit-intro' => 'Voir [$1 la documentation de test] sur mediawiki.org.',
'javascripttest-qunit-heading' => 'Suite de test QUnit de JavaScript sur MediaWiki',

# Tooltip help for the actions
'tooltip-pt-userpage' => 'Votre page utilisateur',
'tooltip-pt-anonuserpage' => "La page utilisateur de l'IP avec laquelle vous contribuez",
'tooltip-pt-mytalk' => 'Votre page de discussion',
'tooltip-pt-anontalk' => 'La page de discussion pour les contributions depuis cette adresse IP',
'tooltip-pt-preferences' => 'Vos préférences',
'tooltip-pt-watchlist' => 'La liste des pages dont vous suivez les modifications',
'tooltip-pt-mycontris' => 'La liste de vos contributions',
'tooltip-pt-login' => "Vous êtes encouragé{{GENDER:||e|(e)}} à vous identifier ; ce n'est cependant pas obligatoire.",
'tooltip-pt-anonlogin' => "Vous êtes encouragé{{GENDER:||e|(e)}} à vous identifier ; ce n'est cependant pas obligatoire.",
'tooltip-pt-logout' => 'Se déconnecter',
'tooltip-ca-talk' => 'Discussion au sujet de cette page de contenu',
'tooltip-ca-edit' => "Vous pouvez modifier cette page.
Veuillez utiliser le bouton de prévisualisation avant d'enregistrer.",
'tooltip-ca-addsection' => 'Commencer une nouvelle section',
'tooltip-ca-viewsource' => 'Cette page est protégée.
Vous pouvez toutefois en visualiser la source.',
'tooltip-ca-history' => 'Les versions passées de cette page (avec leurs contributeurs)',
'tooltip-ca-protect' => 'Protéger cette page',
'tooltip-ca-unprotect' => 'Changer la protection de cette page',
'tooltip-ca-delete' => 'Supprimer cette page',
'tooltip-ca-undelete' => 'Rétablir les modifications faites sur cette page avant sa suppression',
'tooltip-ca-move' => 'Renommer cette page',
'tooltip-ca-watch' => 'Ajouter cette page à votre liste de suivi',
'tooltip-ca-unwatch' => 'Retirer cette page de votre liste de suivi',
'tooltip-search' => 'Rechercher dans {{SITENAME}}',
'tooltip-search-go' => 'Aller vers une page portant exactement ce nom si elle existe.',
'tooltip-search-fulltext' => 'Rechercher les pages comportant ce texte.',
'tooltip-p-logo' => 'Page principale',
'tooltip-n-mainpage' => "Visiter la page d'accueil du site",
'tooltip-n-mainpage-description' => "Aller à l'accueil",
'tooltip-n-portal' => 'À propos du projet',
'tooltip-n-currentevents' => "Trouver les informations de fond sur l'actualité du moment",
'tooltip-n-recentchanges' => 'Liste des modifications récentes sur le wiki',
'tooltip-n-randompage' => 'Afficher une page au hasard',
'tooltip-n-help' => 'Aide',
'tooltip-t-whatlinkshere' => 'Liste des pages liées à celle-ci',
'tooltip-t-recentchangeslinked' => 'Liste des modifications récentes des pages liées à celle-ci',
'tooltip-feed-rss' => 'Flux RSS pour cette page',
'tooltip-feed-atom' => 'Flux Atom pour cette page',
'tooltip-t-contributions' => 'Voir la liste des contributions de cet utilisateur',
'tooltip-t-emailuser' => 'Envoyer un courriel à cet utilisateur',
'tooltip-t-upload' => 'Envoyer une image ou fichier média sur le serveur',
'tooltip-t-specialpages' => 'Liste de toutes les pages spéciales',
'tooltip-t-print' => 'Version imprimable de cette page',
'tooltip-t-permalink' => 'Lien permanent vers cette version de la page',
'tooltip-ca-nstab-main' => 'Voir la page de contenu',
'tooltip-ca-nstab-user' => 'Voir la page utilisateur',
'tooltip-ca-nstab-media' => 'Voir la page du média',
'tooltip-ca-nstab-special' => 'Ceci est une page spéciale, vous ne pouvez pas la modifier.',
'tooltip-ca-nstab-project' => 'Voir la page du projet',
'tooltip-ca-nstab-image' => 'Voir la page du fichier',
'tooltip-ca-nstab-mediawiki' => 'Voir le message système',
'tooltip-ca-nstab-template' => 'Voir le modèle',
'tooltip-ca-nstab-help' => "Voir la page d'aide",
'tooltip-ca-nstab-category' => 'Voir la page de la catégorie',
'tooltip-minoredit' => 'Marquer mes modifications comme mineures',
'tooltip-save' => 'Publier vos modifications',
'tooltip-preview' => 'Merci de prévisualiser vos modifications avant de les publier',
'tooltip-diff' => 'Permet de visualiser les changements que vous avez effectués',
'tooltip-compareselectedversions' => 'Afficher les différences entre deux versions de cette page',
'tooltip-watch' => 'Ajouter cette page à votre liste de suivi',
'tooltip-watchlistedit-normal-submit' => 'Enlever les titres',
'tooltip-watchlistedit-raw-submit' => 'Mise à jour de la liste de suivi',
'tooltip-recreate' => 'Recréer la page même si celle-ci a été effacée',
'tooltip-upload' => "Démarrer l'import",
'tooltip-rollback' => '« Révoquer » annule en un clic la ou les modification(s) de cette page par son dernier contributeur.',
'tooltip-undo' => "« Défaire » révoque cette modification et ouvre la fenêtre de modification en mode prévisualisation.
Permet de rétablir la version précédente et d'ajouter un motif dans la boîte de résumé.",
'tooltip-preferences-save' => 'Sauvegarder les préférences',
'tooltip-summary' => 'Entrez un bref résumé',

# Stylesheets
'common.css' => '/* Le CSS placé ici sera appliqué à tous les habillages. */',
'standard.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Standard. */',
'nostalgia.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Nostalgia. */',
'cologneblue.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Cologne Blue. */',
'monobook.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Monobook. */',
'myskin.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage MySkin. */',
'chick.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Chick. */',
'simple.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Simple. */',
'modern.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Modern. */',
'vector.css' => '/* Le CSS placé ici affectera les utilisateurs de l’habillage Vector. */',
'print.css' => '/* Le CSS placé ici affectera les impressions */',
'handheld.css' => '/* Le CSS placé ici affectera les appareils mobiles en fonction de l\'habillage configuré $wgHandheldStyle */',
'noscript.css' => '/* Le CSS placé ici affectera les utilisateurs ayant désactivé Javascript. */',
'group-autoconfirmed.css' => '/* Le CSS placé ici affectera les utilisateurs auto-confirmés seulement. */',
'group-bot.css' => '/* Le CSS placé ici affectera les robots seulement. */',
'group-sysop.css' => '/* Le CSS inclus ici n’affectera que les administrateurs */',
'group-bureaucrat.css' => '/* Le CSS inclus ici n’affectera que les bureaucrates */',

# Scripts
'common.js' => '/* Tout JavaScript ici sera chargé avec chaque page accédée par n’importe quel utilisateur. */',
'standard.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Standard uniquement */',
'nostalgia.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Nostalgie uniquement */',
'cologneblue.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Bleu de cologne uniquement */',
'monobook.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage MonoBook uniquement. */',
'myskin.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Mon habillage uniquement */',
'chick.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Poussin uniquement */',
'simple.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Simple uniquement */',
'modern.js' => '/* Tout JavaScript ici sera chargé avec les pages accédées par les utilisateurs de l’habillage Moderne uniquement */',
'vector.js' => '/* Tout code JavaScript placé ici sera chargé pour les utilisateurs de l’habillage Vector */',
'group-autoconfirmed.js' => '/* Le JavaScript inclus ici n’affectera que les utilisateurs auto-confirmés */',
'group-bot.js' => '/* Le JavaScript inclus ici n’affectera que les robots */',
'group-sysop.js' => '/* Le JavaScript inclus ici n’affectera que les administrateurs */',
'group-bureaucrat.js' => '/* Le JavaScript inclus ici n’affectera que les bureaucrates */',

# Metadata
'notacceptable' => 'Ce serveur wiki ne peut pas fournir les données dans un format que votre client soit capable de lire.',

# Attribution
'anonymous' => '{{PLURAL:$1|Utilisateur non enregistré|Utilisateurs non enregistrés}} sur {{SITENAME}}',
'siteuser' => "{{GENDER:$2|l'utilisateur|l'utilisatrice|l'utilisateur}} $1 de {{SITENAME}}",
'anonuser' => "l'utilisateur anonyme $1 de {{SITENAME}}",
'lastmodifiedatby' => 'Cette page a été modifiée pour la dernière fois le $1 à $2 par $3.',
'othercontribs' => 'Basé sur le travail de $1.',
'others' => 'autres',
'siteusers' => "{{PLURAL:$2|l'utilisateur|les utilisateurs}} $1 de {{SITENAME}}",
'anonusers' => "{{PLURAL:$2|l'utilisateur anonyme|les utilisateurs anonymes}} $1 de {{SITENAME}}",
'creditspage' => 'Crédits de la page',
'nocredits' => "Il n'y a pas d'informations d'attribution disponibles pour cette page.",

# Spam protection
'spamprotectiontitle' => 'Filtre de protection anti-pollution',
'spamprotectiontext' => "La page que vous avez voulu sauvegarder a été bloquée par le filtre anti-pollution. Ceci est probablement dû à l'introduction d'un lien vers un site externe apparaissant sur la liste noire. Cette dernière utilise les expressions rationnelles suivantes :",
'spamprotectionmatch' => "La chaîne de caractères « '''$1''' » a déclenché le détecteur de spam.",
'spambot_username' => 'Nettoyage de spams par MediaWiki',
'spam_reverting' => 'Rétablissement de la dernière version ne contenant pas de lien vers $1',
'spam_blanking' => 'Toutes les versions contenant des liens vers $1 sont blanchies',
'spam_deleting' => 'Toutes les versions contenaient des liens vers $1, suppression',

# Info page
'pageinfo-title' => 'Informations pour « $1 »',
'pageinfo-not-current' => 'Désolé, impossible de fournir cette information pour les anciennes révisions.',
'pageinfo-header-basic' => 'Informations de base',
'pageinfo-header-edits' => 'Historique des modifications',
'pageinfo-header-restrictions' => 'Protection de la page',
'pageinfo-header-properties' => 'Propriétés de la page',
'pageinfo-display-title' => 'Titre affiché',
'pageinfo-default-sort' => 'Clé de tri par défaut',
'pageinfo-length' => 'Taille de la page (en octets)',
'pageinfo-article-id' => 'Numéro de la page',
'pageinfo-robot-policy' => 'Statut de moteur de recherche',
'pageinfo-robot-index' => 'Indexable',
'pageinfo-robot-noindex' => 'Non indexable',
'pageinfo-views' => 'Nombre de vues',
'pageinfo-watchers' => 'Nombre de contributeurs ayant la page dans leur liste de suivi',
'pageinfo-redirects-name' => 'Redirections vers cette page',
'pageinfo-subpages-name' => 'Sous-pages de cette page',
'pageinfo-subpages-value' => '$1 ($2 {{PLURAL:$2|redirection|redirections}}; $3 {{PLURAL:$3|non-redirection|non-redirections}})',
'pageinfo-firstuser' => 'Créateur de la page',
'pageinfo-firsttime' => 'Date de création de la page',
'pageinfo-lastuser' => 'Dernier contributeur',
'pageinfo-lasttime' => 'Date de la dernière modification',
'pageinfo-edits' => 'Nombre total de modifications',
'pageinfo-authors' => "Nombre total d'auteurs distincts",
'pageinfo-recent-edits' => 'Nombre de modifications récentes (dans les derniers $1)',
'pageinfo-recent-authors' => "Nombre d'auteurs distincts récents",
'pageinfo-magic-words' => '{{PLURAL:$1|Mot magique|Mots magiques}} ($1)',
'pageinfo-hidden-categories' => '{{PLURAL:$1|Catégorie cachée|Catégories cachées}} ($1)',
'pageinfo-templates' => '{{PLURAL:$1|Modèle inclu|Modèles inclus}} ($1)',

# Skin names
'skinname-standard' => 'Standard',
'skinname-nostalgia' => 'Nostalgie',
'skinname-cologneblue' => 'Bleu de Cologne',
'skinname-monobook' => 'Monobook',
'skinname-myskin' => 'Mon Interface',
'skinname-chick' => 'Poussin',
'skinname-simple' => 'Simple',
'skinname-modern' => 'Moderne',
'skinname-vector' => 'Vector',

# Patrolling
'markaspatrolleddiff' => 'Marquer comme relue',
'markaspatrolledtext' => 'Marquer cette page comme relue',
'markedaspatrolled' => 'Marquée comme relue',
'markedaspatrolledtext' => 'La version sélectionnée de [[:$1]] a été marquée comme relue.',
'rcpatroldisabled' => "La fonction de relecture des modifications récentes n'est pas activée.",
'rcpatroldisabledtext' => 'La fonctionnalité de relecture des modifications récentes est actuellement désactivée.',
'markedaspatrollederror' => 'Ne peut être marquée comme relue',
'markedaspatrollederrortext' => 'Vous devez sélectionner une version pour pouvoir la marquer comme relue.',
'markedaspatrollederror-noautopatrol' => "Vous n'avez pas le droit de marquer vos propres modifications comme relues.",

# Patrol log
'patrol-log-page' => 'Journal des relectures',
'patrol-log-header' => "Voici l'historique des versions relues.",
'log-show-hide-patrol' => "$1 l'historique des relectures",

# Image deletion
'deletedrevision' => 'Ancienne version $1 supprimée',
'filedeleteerror-short' => 'Erreur lors de la suppression du fichier : $1',
'filedeleteerror-long' => 'Des erreurs ont été rencontrées lors de la suppression du fichier :

$1',
'filedelete-missing' => "Le fichier « $1 » ne peut pas être supprimé parce qu'il n'existe pas.",
'filedelete-old-unregistered' => "La version du fichier spécifiée « $1 » n'est pas dans la base de données.",
'filedelete-current-unregistered' => "Le fichier spécifié « $1 » n'est pas dans la base de données.",
'filedelete-archive-read-only' => "Le dossier d'archivage « $1 » n'est pas modifiable par le serveur.",

# Browsing diffs
'previousdiff' => '← Modification précédente',
'nextdiff' => 'Modification suivante →',

# Media information
'mediawarning' => "'''Attention :''' ce type de fichier peut contenir du code malveillant.
Si vous l'exécutez, votre système peut être compromis.",
'imagemaxsize' => "Taille maximale des images :<br />''(pour les pages de description de fichier)''",
'thumbsize' => 'Taille de la miniature :',
'widthheightpage' => '$1 × $2, $3 page{{PLURAL:$3||s}}',
'file-info' => 'Taille du fichier : $1, type MIME : $2',
'file-info-size' => '$1 × $2 pixels, taille du fichier : $3, type MIME : $4',
'file-info-size-pages' => '$1 × $2 pixels, taille de fichier: $3, type MIME: $4, $5 {{PLURAL:$5|page|pages}}',
'file-nohires' => 'Pas de plus haute résolution disponible.',
'svg-long-desc' => 'Fichier SVG, résolution de $1 × $2 pixels, taille : $3',
'svg-long-desc-animated' => 'Fichier SVG animé, taille $1 x $2 pixels, taille du fichier: $3',
'show-big-image' => 'Image en plus haute résolution',
'show-big-image-preview' => 'Taille de cet aperçu : $1.',
'show-big-image-other' => '{{PLURAL:$2|Autre résolution|Autres résolutions}} : $1.',
'show-big-image-size' => '$1 × $2 pixels',
'file-info-gif-looped' => 'en boucle',
'file-info-gif-frames' => '$1 {{PLURAL:$1|image|images}}',
'file-info-png-looped' => 'en boucle',
'file-info-png-repeat' => 'joué $1 {{PLURAL:$1|fois|fois}}',
'file-info-png-frames' => '$1 {{PLURAL:$1|image|images}}',
'file-no-thumb-animation' => "'''Remarque: En raison de limitations techniques, les vignettes de ce fichier ne seront pas animées.'''",
'file-no-thumb-animation-gif' => "'''Remarque: En raison de limitations techniques, les vignettes d'images GIF en haute résolution telles que celle-ci ne seront pas animées.'''",

# Special:NewFiles
'newimages' => 'Galerie des nouveaux fichiers',
'imagelisttext' => "Voici une liste de '''$1''' fichier{{PLURAL:$1||s}} classée $2.",
'newimages-summary' => 'Cette page spéciale affiche les derniers fichiers importés.',
'newimages-legend' => 'Nom du fichier',
'newimages-label' => 'Nom du fichier (ou une partie de celui-ci) :',
'showhidebots' => '($1 robots)',
'noimages' => 'Aucune image à afficher.',
'ilsubmit' => 'Rechercher',
'bydate' => 'par date',
'sp-newimages-showfrom' => 'Afficher les nouveaux fichiers à partir du $1 à $2',

# Video information, used by Language::formatTimePeriod() to format lengths in the above messages
'days-abbrev' => '$1 j',
'seconds' => '{{PLURAL:$1|$1 seconde|$1 secondes}}',
'minutes' => '{{PLURAL:$1|$1 minute|$1 minutes}}',
'hours' => '{{PLURAL:$1|$1 heure|$1 heures}}',
'days' => '{{PLURAL:$1|$1 jour|$1 jours}}',
'ago' => 'Il y a $1',

# Bad image list
'bad_image_list' => "Le format est le suivant :

Seules les listes d'énumération (commençant par *) sont prises en compte. Le premier lien d'une ligne doit être celui d'une mauvaise image.
Les autres liens sur la même ligne sont considérés comme des exceptions, par exemple des pages sur lesquelles l'image peut apparaître.",

# Metadata
'metadata' => 'Métadonnées',
'metadata-help' => "Ce fichier contient des informations supplémentaires, probablement ajoutées par l'appareil photo numérique ou le numériseur utilisé pour le créer. Si le fichier a été modifié depuis son état original, certains détails peuvent ne pas refléter entièrement l'image modifiée.",
'metadata-expand' => 'Afficher les informations détaillées',
'metadata-collapse' => 'Masquer les informations détaillées',
'metadata-fields' => "Les champs de métadonnées d'image listés dans ce message seront inclus dans la page de description de l'image quand la table de métadonnées sera réduite. Les autres champs seront cachés par défaut.
* make
* model
* datetimeoriginal
* exposuretime
* fnumber
* isospeedratings
* focallength
* artist
* copyright
* imagedescription
* gpslatitude
* gpslongitude
* gpsaltitude",
'metadata-langitem' => "'''$2&nbsp;:''' $1",

# EXIF tags
'exif-imagewidth' => 'Largeur',
'exif-imagelength' => 'Hauteur',
'exif-bitspersample' => 'Bits par composante',
'exif-compression' => 'Type de compression',
'exif-photometricinterpretation' => 'Modèle colorimétrique',
'exif-orientation' => 'Orientation',
'exif-samplesperpixel' => 'Composantes par pixel',
'exif-planarconfiguration' => 'Arrangement des données',
'exif-ycbcrsubsampling' => 'Taux de sous-échantillonnage de Y à C',
'exif-ycbcrpositioning' => 'Positionnement YCbCr',
'exif-xresolution' => 'Résolution horizontale',
'exif-yresolution' => 'Résolution verticale',
'exif-stripoffsets' => "Emplacement des données de l'image",
'exif-rowsperstrip' => 'Nombre de lignes par bande',
'exif-stripbytecounts' => 'Taille en octets par bande',
'exif-jpeginterchangeformat' => 'Position du SOI JPEG',
'exif-jpeginterchangeformatlength' => 'Taille en octets des données JPEG',
'exif-whitepoint' => 'Chromaticité du point blanc',
'exif-primarychromaticities' => 'Chromaticité des primaires',
'exif-ycbcrcoefficients' => 'Coefficients YCbCr',
'exif-referenceblackwhite' => 'Valeurs de référence noir et blanc',
'exif-datetime' => 'Date de modification',
'exif-imagedescription' => "Description de l'image",
'exif-make' => "Fabricant de l'appareil",
'exif-model' => "Modèle de l'appareil",
'exif-software' => 'Logiciel utilisé',
'exif-artist' => 'Auteur',
'exif-copyright' => "Détenteur du droit d'auteur",
'exif-exifversion' => 'Version EXIF',
'exif-flashpixversion' => 'Version FlashPix',
'exif-colorspace' => 'Espace colorimétrique',
'exif-componentsconfiguration' => 'Signification de chaque composante',
'exif-compressedbitsperpixel' => "Mode de compression de l'image",
'exif-pixelydimension' => "Largeur de l'image",
'exif-pixelxdimension' => "Hauteur de l'image",
'exif-usercomment' => "Commentaires de l'utilisateur",
'exif-relatedsoundfile' => 'Fichier audio associé',
'exif-datetimeoriginal' => 'Date de la prise originelle',
'exif-datetimedigitized' => 'Date de la numérisation',
'exif-subsectime' => 'Date de modification',
'exif-subsectimeoriginal' => 'Date de la prise originelle',
'exif-subsectimedigitized' => 'Date de la numérisation',
'exif-exposuretime' => "Temps d'exposition",
'exif-exposuretime-format' => '$1 s ($2 s)',
'exif-fnumber' => 'Ouverture',
'exif-exposureprogram' => "Programme d'exposition",
'exif-spectralsensitivity' => 'Sensibilité spectrale',
'exif-isospeedratings' => 'Sensibilité ISO',
'exif-shutterspeedvalue' => "vitesse d'obturation de l'APEX",
'exif-aperturevalue' => "Ouverture de l'APEX",
'exif-brightnessvalue' => 'Luminance APEX',
'exif-exposurebiasvalue' => "Correction d'exposition",
'exif-maxaperturevalue' => 'Ouverture maximale',
'exif-subjectdistance' => 'Distance du sujet',
'exif-meteringmode' => 'Mode de mesure',
'exif-lightsource' => 'Source de lumière',
'exif-flash' => 'Flash',
'exif-focallength' => 'Longueur focale',
'exif-subjectarea' => 'Emplacement du sujet',
'exif-flashenergy' => 'Énergie du flash',
'exif-focalplanexresolution' => 'Résolution horizontale du plan focal',
'exif-focalplaneyresolution' => 'Résolution verticale du plan focal',
'exif-focalplaneresolutionunit' => 'Unité de résolution du plan focal',
'exif-subjectlocation' => 'Localisation du sujet',
'exif-exposureindex' => "Index d'exposition",
'exif-sensingmethod' => 'Type de capteur',
'exif-filesource' => 'Source du fichier',
'exif-scenetype' => 'Type de scène',
'exif-customrendered' => 'Rendu personnalisé',
'exif-exposuremode' => "Mode d'exposition",
'exif-whitebalance' => 'Balance des blancs',
'exif-digitalzoomratio' => 'Taux de zoom numérique',
'exif-focallengthin35mmfilm' => 'Longueur focale pour un film 35 mm',
'exif-scenecapturetype' => 'Type de capture de la scène',
'exif-gaincontrol' => 'Contrôle du gain',
'exif-contrast' => 'Contraste',
'exif-saturation' => 'Saturation',
'exif-sharpness' => 'Netteté',
'exif-devicesettingdescription' => 'Description de la configuration du dispositif',
'exif-subjectdistancerange' => 'Distance du sujet',
'exif-imageuniqueid' => "Identifiant unique de l'image",
'exif-gpsversionid' => 'Version de la balise GPS',
'exif-gpslatituderef' => 'Référence pour la latitude',
'exif-gpslatitude' => 'Latitude',
'exif-gpslongituderef' => 'Référence pour la longitude',
'exif-gpslongitude' => 'Longitude',
'exif-gpsaltituderef' => "Référence d'altitude (0=altitude, 1=profondeur)",
'exif-gpsaltitude' => 'Altitude',
'exif-gpstimestamp' => 'Heure GPS (horloge atomique)',
'exif-gpssatellites' => 'Satellites utilisés pour la mesure',
'exif-gpsstatus' => 'État du récepteur',
'exif-gpsmeasuremode' => 'Mode de mesure',
'exif-gpsdop' => 'Précision de la mesure',
'exif-gpsspeedref' => 'Unité de vitesse du récepteur GPS',
'exif-gpsspeed' => 'Vitesse du récepteur GPS',
'exif-gpstrackref' => 'Référence pour la direction du mouvement',
'exif-gpstrack' => 'Direction du mouvement',
'exif-gpsimgdirectionref' => "Référence pour la direction de l'image",
'exif-gpsimgdirection' => "Direction de l'image",
'exif-gpsmapdatum' => 'Système géodésique utilisé',
'exif-gpsdestlatituderef' => 'Référence pour la latitude de la destination',
'exif-gpsdestlatitude' => 'Latitude de la destination',
'exif-gpsdestlongituderef' => 'Référence pour la longitude de la destination',
'exif-gpsdestlongitude' => 'Longitude de la destination',
'exif-gpsdestbearingref' => 'Référence pour le relèvement de la destination',
'exif-gpsdestbearing' => 'Relèvement de la destination',
'exif-gpsdestdistanceref' => 'Référence pour la distance à la destination',
'exif-gpsdestdistance' => 'Distance à la destination',
'exif-gpsprocessingmethod' => 'Nom de la méthode de traitement du GPS',
'exif-gpsareainformation' => 'Nom de la zone GPS',
'exif-gpsdatestamp' => 'Date GPS',
'exif-gpsdifferential' => 'Correction différentielle GPS',
'exif-jpegfilecomment' => 'Commentaire de fichier JPEG',
'exif-keywords' => 'Mots-clés',
'exif-worldregioncreated' => 'Région du monde dans laquelle la photo a été prise',
'exif-countrycreated' => 'Pays dans lequel la photo a été prise',
'exif-countrycodecreated' => 'Code du pays dans lequel la photo a été prise',
'exif-provinceorstatecreated' => 'Province ou État dans lequel la photo a été prise',
'exif-citycreated' => 'Ville dans laquelle la photo a été prise',
'exif-sublocationcreated' => 'Partie de la ville dans laquelle la photo a été prise',
'exif-worldregiondest' => 'Région du monde représentée',
'exif-countrydest' => 'Pays représenté',
'exif-countrycodedest' => 'Code du pays représenté',
'exif-provinceorstatedest' => 'Province ou État représenté',
'exif-citydest' => 'Ville représentée',
'exif-sublocationdest' => 'Partie de la ville représentée',
'exif-objectname' => 'Titre court',
'exif-specialinstructions' => 'Instructions spéciales',
'exif-headline' => 'Titre',
'exif-credit' => 'Crédit / fournisseur',
'exif-source' => 'Source',
'exif-editstatus' => "Statut éditorial de l'image",
'exif-urgency' => 'Urgence',
'exif-fixtureidentifier' => 'Nom élément récurrent',
'exif-locationdest' => 'Lieu représenté',
'exif-locationdestcode' => 'Code du lieu représenté',
'exif-objectcycle' => 'Moment de la journée auquel ce média est destiné',
'exif-contact' => 'Informations de contact',
'exif-writer' => 'Auteur',
'exif-languagecode' => 'Langue',
'exif-iimversion' => 'version IIM',
'exif-iimcategory' => 'Catégorie',
'exif-iimsupplementalcategory' => 'Catégories supplémentaires',
'exif-datetimeexpires' => 'Ne pas utiliser après',
'exif-datetimereleased' => 'Paru le',
'exif-originaltransmissionref' => 'Code de localisation de la transmission originale',
'exif-identifier' => 'Identifiant',
'exif-lens' => 'Lentille utilisée',
'exif-serialnumber' => "Numéro de série de l'appareil photo",
'exif-cameraownername' => "Propriétaire de l'appareil photo",
'exif-label' => 'Libellé',
'exif-datetimemetadata' => 'Date de la dernière modification des métadonnées',
'exif-nickname' => "Nom informel de l'image",
'exif-rating' => 'Note (sur 5)',
'exif-rightscertificate' => 'Certificat de gestion des droits',
'exif-copyrighted' => "Statut du droit d'auteur",
'exif-copyrightowner' => "Détenteur du droit d'auteur",
'exif-usageterms' => "Conditions d'utilisation",
'exif-webstatement' => "Déclaration de droits d'auteur en ligne",
'exif-originaldocumentid' => 'Identifiant unique du document original',
'exif-licenseurl' => 'URL de la licence',
'exif-morepermissionsurl' => 'Informations sur les licences alternatives',
'exif-attributionurl' => 'Lors de la réutilisation de ce travail, veuillez lier à',
'exif-preferredattributionname' => 'Lors de la réutilisation de ce travail, veuillez créditer',
'exif-pngfilecomment' => 'Commentaire de fichier PNG',
'exif-disclaimer' => 'Désistement',
'exif-contentwarning' => 'Avertissement sur le contenu',
'exif-giffilecomment' => 'Commentaire de fichier GIF',
'exif-intellectualgenre' => "Type d'élément",
'exif-subjectnewscode' => 'Code du sujet',
'exif-scenecode' => 'Code de scène IPTC',
'exif-event' => 'Événement représenté',
'exif-organisationinimage' => 'Organisation représentée',
'exif-personinimage' => 'Personne représentée',
'exif-originalimageheight' => "Hauteur de l'image avant qu'elle ait été recadrée",
'exif-originalimagewidth' => "Largeur de l'image avant qu'elle ait été recadrée",

# EXIF attributes
'exif-compression-1' => 'Non compressé',
'exif-compression-2' => 'CCITT Groupe 3 Longueur du codage Huffman modifié de dimension 1',
'exif-compression-3' => 'CCITT Groupe 3 codage du fax',
'exif-compression-4' => 'CCITT Groupe 4 codage du fax',
'exif-compression-6' => 'JPEG (ancien)',

'exif-copyrighted-true' => "Soumis au droit d'auteur",
'exif-copyrighted-false' => 'Domaine public',

'exif-unknowndate' => 'Date inconnue',

'exif-orientation-1' => 'Normale',
'exif-orientation-2' => 'Inversée horizontalement',
'exif-orientation-3' => 'Tournée de 180°',
'exif-orientation-4' => 'Inversée verticalement',
'exif-orientation-5' => 'Tournée de 90° dans le sens antihoraire et inversée verticalement',
'exif-orientation-6' => 'Tournée de 90° dans le sens antihoraire',
'exif-orientation-7' => 'Tournée de 90° dans le sens horaire et inversée verticalement',
'exif-orientation-8' => 'Tournée de 90° dans le sens horaire',

'exif-planarconfiguration-1' => 'Données contiguës',
'exif-planarconfiguration-2' => 'Données séparées',

'exif-colorspace-65535' => 'Non calibré',

'exif-componentsconfiguration-0' => "N'existe pas",
'exif-componentsconfiguration-5' => 'V',

'exif-exposureprogram-0' => 'Indéfini',
'exif-exposureprogram-1' => 'Manuel',
'exif-exposureprogram-2' => 'Programme normal',
'exif-exposureprogram-3' => "Priorité à l'ouverture",
'exif-exposureprogram-4' => "Priorité à l'obturateur",
'exif-exposureprogram-5' => 'Programme création (préférence à la profondeur de champ)',
'exif-exposureprogram-6' => "Programme action (préférence à la vitesse d'obturation)",
'exif-exposureprogram-7' => 'Mode portrait (pour clichés de près avec arrière-plan flou)',
'exif-exposureprogram-8' => 'Mode paysage (pour des clichés de paysages nets)',

'exif-subjectdistance-value' => '$1 mètre{{PLURAL:$1||s}}',

'exif-meteringmode-0' => 'Inconnu',
'exif-meteringmode-1' => 'Moyenne',
'exif-meteringmode-2' => 'Moyenne pondérée au centre',
'exif-meteringmode-3' => 'Spot',
'exif-meteringmode-4' => 'Multi-spot',
'exif-meteringmode-5' => 'Modèle',
'exif-meteringmode-6' => 'Partielle',
'exif-meteringmode-255' => 'Autre',

'exif-lightsource-0' => 'Inconnue',
'exif-lightsource-1' => 'Lumière du jour',
'exif-lightsource-2' => 'Fluorescent',
'exif-lightsource-3' => 'Tungstène (lumière incandescente)',
'exif-lightsource-4' => 'Flash',
'exif-lightsource-9' => 'Temps clair',
'exif-lightsource-10' => 'Temps nuageux',
'exif-lightsource-11' => 'Ombre',
'exif-lightsource-12' => 'Éclairage fluorescent « lumière du jour » (D 5700 – 7100 K)',
'exif-lightsource-13' => 'Éclairage fluorescent blanc « jour » (N 4600 – 5400 K)',
'exif-lightsource-14' => 'Éclairage fluorescent blanc « froid » (W 3900 – 4500 K)',
'exif-lightsource-15' => 'Éclairage fluorescent blanc (WW 3200 – 3700 K)',
'exif-lightsource-17' => 'Lumière standard A',
'exif-lightsource-18' => 'Lumière standard B',
'exif-lightsource-19' => 'Lumière standard C',
'exif-lightsource-24' => 'Tungstène ISO de studio',
'exif-lightsource-255' => 'Autre source de lumière',

# Flash modes
'exif-flash-fired-0' => 'Flash non déclenché',
'exif-flash-fired-1' => 'Flash déclenché',
'exif-flash-return-0' => 'aucun stroboscope ne retourne une fonction de détection',
'exif-flash-return-2' => 'le stroboscope ne détecte pas de lumière retournée',
'exif-flash-return-3' => 'le stroboscope détecte un retour de lumière',
'exif-flash-mode-1' => 'lumière du flash obligatoire',
'exif-flash-mode-2' => 'suppression du flash obligatoire',
'exif-flash-mode-3' => 'mode automatique',
'exif-flash-function-1' => 'Pas de fonction de flash',
'exif-flash-redeye-1' => 'Mode anti-yeux rouges',

'exif-focalplaneresolutionunit-2' => 'Pouce',

'exif-sensingmethod-1' => 'Non défini',
'exif-sensingmethod-2' => 'Capteur de couleur à une puce',
'exif-sensingmethod-3' => 'Capteur de couleur à deux puces',
'exif-sensingmethod-4' => 'Capteur de couleur à trois puces',
'exif-sensingmethod-5' => 'Capteur de couleur séquentiel',
'exif-sensingmethod-7' => 'Capteur trilinéaire',
'exif-sensingmethod-8' => 'Capteur de couleur linéaire séquentiel',

'exif-filesource-3' => 'Appareil photo numérique',

'exif-scenetype-1' => 'Image photographiée directement',

'exif-customrendered-0' => 'Procédé normal',
'exif-customrendered-1' => 'Procédé personnalisé',

'exif-exposuremode-0' => 'Automatique',
'exif-exposuremode-1' => 'Manuelle',
'exif-exposuremode-2' => 'Fourchette automatique',

'exif-whitebalance-0' => 'Automatique',
'exif-whitebalance-1' => 'Manuelle',

'exif-scenecapturetype-0' => 'Standard',
'exif-scenecapturetype-1' => 'Paysage',
'exif-scenecapturetype-2' => 'Portrait',
'exif-scenecapturetype-3' => 'Scène de nuit',

'exif-gaincontrol-0' => 'Aucun',
'exif-gaincontrol-1' => 'Gain faiblement positif',
'exif-gaincontrol-2' => 'Gain fortement positif',
'exif-gaincontrol-3' => 'Gain faiblement négatif',
'exif-gaincontrol-4' => 'Gain fortement négatif',

'exif-contrast-0' => 'Normal',
'exif-contrast-1' => 'Faible',
'exif-contrast-2' => 'Fort',

'exif-saturation-0' => 'Normale',
'exif-saturation-1' => 'Faible',
'exif-saturation-2' => 'Élevée',

'exif-sharpness-0' => 'Normale',
'exif-sharpness-1' => 'Douce',
'exif-sharpness-2' => 'Dure',

'exif-subjectdistancerange-0' => 'Inconnue',
'exif-subjectdistancerange-1' => 'Macro',
'exif-subjectdistancerange-2' => 'Rapproché',
'exif-subjectdistancerange-3' => 'Distant',

# Pseudotags used for GPSLatitudeRef and GPSDestLatitudeRef
'exif-gpslatitude-n' => 'Nord',
'exif-gpslatitude-s' => 'Sud',

# Pseudotags used for GPSLongitudeRef and GPSDestLongitudeRef
'exif-gpslongitude-e' => 'Est',
'exif-gpslongitude-w' => 'Ouest',

# Pseudotags used for GPSAltitudeRef
'exif-gpsaltitude-above-sealevel' => '$1 {{PLURAL:$1|mètre|mètres}} au-dessus du niveau de la mer',
'exif-gpsaltitude-below-sealevel' => '$1 {{PLURAL:$1|mètre|mètres}} au-dessous du niveau de la mer',

'exif-gpsstatus-a' => 'Mesure en cours',
'exif-gpsstatus-v' => 'Interfonctionnement de la mesure',

'exif-gpsmeasuremode-2' => 'Mesure à 2 dimensions',
'exif-gpsmeasuremode-3' => 'Mesure à 3 dimensions',

# Pseudotags used for GPSSpeedRef
'exif-gpsspeed-k' => "Kilomètres à l'heure",
'exif-gpsspeed-m' => "Milles à l'heure",
'exif-gpsspeed-n' => 'Nœud',

# Pseudotags used for GPSDestDistanceRef
'exif-gpsdestdistance-k' => 'Kilomètres',
'exif-gpsdestdistance-m' => 'Milles',
'exif-gpsdestdistance-n' => 'Milles marins',

'exif-gpsdop-excellent' => 'Excellente ($1)',
'exif-gpsdop-good' => 'Bonne ($1)',
'exif-gpsdop-moderate' => 'Moyenne ($1)',
'exif-gpsdop-fair' => 'Passable ($1)',
'exif-gpsdop-poor' => 'Mauvaise ($1)',

'exif-objectcycle-a' => 'Matin seulement',
'exif-objectcycle-p' => 'Soirée seulement',
'exif-objectcycle-b' => 'Matin et soir',

# Pseudotags used for GPSTrackRef, GPSImgDirectionRef and GPSDestBearingRef
'exif-gpsdirection-t' => 'Nord vrai',
'exif-gpsdirection-m' => 'Nord magnétique',

'exif-ycbcrpositioning-1' => 'Centré',
'exif-ycbcrpositioning-2' => 'Co-situé',

'exif-dc-contributor' => 'Contributeurs',
'exif-dc-coverage' => 'Portée spatiale ou temporelle du média',
'exif-dc-date' => 'Date(s)',
'exif-dc-publisher' => 'Éditeur',
'exif-dc-relation' => 'Médias connexes',
'exif-dc-rights' => 'Droits',
'exif-dc-source' => 'Média source',
'exif-dc-type' => 'Type de média',

'exif-rating-rejected' => 'Rejeté',

'exif-isospeedratings-overflow' => 'Plus grand que 65535',

'exif-iimcategory-ace' => 'Arts, culture et loisirs',
'exif-iimcategory-clj' => 'Crime et droit',
'exif-iimcategory-dis' => 'Catastrophes et accidents',
'exif-iimcategory-fin' => 'Économie et affaires',
'exif-iimcategory-edu' => 'Éducation',
'exif-iimcategory-evn' => 'Environnement',
'exif-iimcategory-hth' => 'Santé',
'exif-iimcategory-hum' => 'Intérêt humain',
'exif-iimcategory-lab' => 'Travail',
'exif-iimcategory-lif' => 'Mode de vie et de loisirs',
'exif-iimcategory-pol' => 'Politique',
'exif-iimcategory-rel' => 'Religion et croyances',
'exif-iimcategory-sci' => 'Science et technologie',
'exif-iimcategory-soi' => 'Questions sociales',
'exif-iimcategory-spo' => 'Sports',
'exif-iimcategory-war' => 'Guerre, conflit et trouble',
'exif-iimcategory-wea' => 'Météo',

'exif-urgency-normal' => 'Normale ($1)',
'exif-urgency-low' => 'Faible ($1)',
'exif-urgency-high' => 'Haute ($1)',
'exif-urgency-other' => "Urgence définie par l'utilisateur ($1)",

# External editor support
'edit-externally' => 'Modifier ce fichier en utilisant une application externe',
'edit-externally-help' => "(Consulter [//www.mediawiki.org/wiki/Manual:External_editors/fr les instructions d'installation] pour plus d'informations)",

# 'all' in various places, this might be different for inflected languages
'watchlistall2' => 'tout',
'namespacesall' => 'Tous',
'monthsall' => 'tous',
'limitall' => 'tous',

# E-mail address confirmation
'confirmemail' => "Confirmer l'adresse de courriel",
'confirmemail_noemail' => "Vous n'avez pas défini une adresse de courriel valide dans vos [[Special:Preferences|préférences]].",
'confirmemail_text' => 'Ce wiki nécessite la vérification de votre adresse de courriel avant de pouvoir utiliser toute fonction de messagerie.
Utilisez le bouton ci-dessous pour envoyer un courriel de confirmation à votre adresse.
Le courriel inclura un lien comportant un code à usage unique et limité dans le temps ;
chargez ce lien dans votre navigateur pour confirmer que votre adresse de courriel est valide.',
'confirmemail_pending' => 'Un code de confirmation vous a déjà été envoyé par courriel ;
si vous venez de créer votre compte, veuillez attendre quelques minutes que le courriel arrive avant de demander un nouveau code.',
'confirmemail_send' => 'Envoyer un code de confirmation',
'confirmemail_sent' => 'Courriel de confirmation envoyé',
'confirmemail_oncreate' => "Un code de confirmation a été envoyé à votre adresse de courriel.
Ce code n'est pas requis pour vous identifier sur ce wiki, mais vous devrez le fournir pour activer toute fonction de messagerie.",
'confirmemail_sendfailed' => "{{SITENAME}} n'a pas pu vous envoyer le courriel de confirmation.
Veuillez vérifiez que votre adresse de courriel ne comprend aucun caractère incorrect.

Le programme d'envoi de courriel a retourné l'indication suivante : $1",
'confirmemail_invalid' => 'Code de confirmation incorrect.
Celui-ci a peut-être expiré.',
'confirmemail_needlogin' => 'Vous devez vous $1 pour confirmer votre adresse de courriel.',
'confirmemail_success' => 'Votre adresse de courriel a été confirmée.
Vous pouvez maintenant vous [[Special:UserLogin|{{MediaWiki:Loginreqlink}}]] et profiter du wiki.',
'confirmemail_loggedin' => 'Votre adresse de courriel est maintenant confirmée.',
'confirmemail_error' => "Un problème est survenu lors de l'enregistrement de votre confirmation.",
'confirmemail_subject' => "Confirmation d'adresse de courriel pour {{SITENAME}}",
'confirmemail_body' => "Quelqu'un, probablement vous, à partir de l'adresse IP $1,
a enregistré un compte « $2 » avec cette adresse de courriel
sur le site {{SITENAME}}.

Pour confirmer que ce compte vous appartient vraiment et afin
d'activer les fonctions de messagerie sur {{SITENAME}},
veuillez suivre ce lien dans votre navigateur :

$3

Si vous n'avez *pas* enregistré ce compte, n'ouvrez pas ce lien ;
vous pouvez suivre l'autre lien ci-dessous pour annuler la
confirmation de votre adresse courriel :

$5

Ce code de confirmation expirera le $4.",
'confirmemail_body_changed' => "Quelqu'un, probablement vous, à partir de l'adresse IP $1,
a modifié l'adresse de courriel associée au compte « $2 » de {{SITENAME}}
en cette adresse.

Pour confirmer que ce compte vous appartient vraiment et afin
de réactiver les fonctions de messagerie sur {{SITENAME}},
veuillez suivre ce lien dans votre navigateur :

$3

Si ce compte ne vous appartient *pas*, n'ouvrez pas ce lien ;
vous pouvez suivre l'autre lien ci-dessous pour annuler la
confirmation de votre adresse courriel :

$5

Ce code de confirmation expirera le $4.",
'confirmemail_body_set' => "Quelqu'un, probablement vous, de l'adresse IP $1, a modifié l'adresse de courriel du compte « $2 » en celle-ci sur {{SITENAME}}.

Pour confirmer que ce compte vous appartient et réactiver les fonctions de courriel sur {{SITENAME}}, ouvrez ce lien dans votre navigateur Web :

$3

Ce code de confirmation expirera le $4.

Si le compte ne vous appartient PAS, suivez plutôt ce lien pour annuler la confirmation de l'adresse de courriel :

$5",
'confirmemail_invalidated' => "Confirmation de l'adresse courriel annulée",
'invalidateemail' => "Annuler la confirmation de l'adresse de courriel",

# Scary transclusion
'scarytranscludedisabled' => '[La transclusion interwiki est désactivée]',
'scarytranscludefailed' => '[La récupération de modèle a échoué pour $1]',
'scarytranscludetoolong' => "[L'URL est trop longue]",

# Delete conflict
'deletedwhileediting' => "'''Attention''' : cette page a été supprimée après que vous avez commencé à la modifier !",
'confirmrecreate' => "L'utilisateur [[User:$1|$1]] ([[User talk:$1|Discussion]]) a supprimé cette page, alors que vous aviez commencé à l'éditer, pour le motif suivant :
: ''$2''
Veuillez confirmer que vous désirez réellement recréer cette page.",
'confirmrecreate-noreason' => "L'utilisateur [[User:$1|$1]] ([[User talk:$1|Discussion]]) a supprimé cette page, alors que vous aviez commencé à l'éditer. Veuillez confirmer que vous désirez réellement recréer cette page.",
'recreate' => 'Recréer',

# action=purge
'confirm_purge_button' => 'Confirmer',
'confirm-purge-top' => 'Voulez-vous rafraîchir cette page (purger le cache) ?',
'confirm-purge-bottom' => "Purger une page l'efface du cache de rendu et force sa dernière version à être régénérée et affichée.",

# action=watch/unwatch
'confirm-watch-button' => 'Valider',
'confirm-watch-top' => 'Ajouter cette page à votre liste de suivi ?',
'confirm-unwatch-button' => 'Valider',
'confirm-unwatch-top' => 'Supprimer cette page de votre liste de suivi ?',

# Separators for various lists, etc.
'semicolon-separator' => '&nbsp;;&#32;',
'colon-separator' => '&nbsp;:&#32;',
'autocomment-prefix' => '&#32;–&#32;',
'percent' => '$1&nbsp;%',

# Multipage image navigation
'imgmultipageprev' => '← page précédente',
'imgmultipagenext' => 'page suivante →',
'imgmultigo' => 'Accéder !',
'imgmultigoto' => 'Aller à la page $1',

# Table pager
'ascending_abbrev' => 'crois.',
'descending_abbrev' => 'décr.',
'table_pager_next' => 'Page suivante',
'table_pager_prev' => 'Page précédente',
'table_pager_first' => 'Première page',
'table_pager_last' => 'Dernière page',
'table_pager_limit' => 'Afficher $1 éléments par page',
'table_pager_limit_label' => 'Résultats par page :',
'table_pager_limit_submit' => 'Envoyer',
'table_pager_empty' => 'Aucun résultat',

# Auto-summaries
'autosumm-blank' => 'Page blanchie',
'autosumm-replace' => 'Contenu remplacé par « $1 »',
'autoredircomment' => 'Page redirigée vers [[$1]]',
'autosumm-new' => 'Page créée avec « $1 »',

# Size units
'size-bytes' => '$1 o',
'size-kilobytes' => '$1 Kio',
'size-megabytes' => '$1 Mio',
'size-gigabytes' => '$1 Gio',
'size-terabytes' => '$1 Tio',
'size-petabytes' => '$1 Pio',
'size-exabytes' => '$1 Eio',
'size-zetabytes' => '$1 Zio',
'size-yottabytes' => '$1 Yio',

# Live preview
'livepreview-loading' => 'Chargement...',
'livepreview-ready' => 'Chargement … terminé !',
'livepreview-failed' => "L'aperçu rapide a échoué !
Essayez la prévisualisation normale.",
'livepreview-error' => 'Impossible de se connecter : $1 « $2 ».
Essayez la prévisualisation normale.',

# Friendlier slave lag warnings
'lag-warn-normal' => 'Les modifications datant de moins de $1 seconde{{PLURAL:$1||s}} peuvent ne pas apparaître dans cette liste.',
'lag-warn-high' => "En raison d'un retard important du serveur de base de données, les modifications datant de moins de $1 seconde{{PLURAL:$1||s}} peuvent ne pas apparaître dans cette liste.",

# Watchlist editor
'watchlistedit-numitems' => 'Votre liste de suivi contient {{PLURAL:$1|un titre|$1 titres}}, sans compter les pages de discussion.',
'watchlistedit-noitems' => 'Votre liste de suivi ne contient aucun titre.',
'watchlistedit-normal-title' => 'Modifier la liste de suivi',
'watchlistedit-normal-legend' => 'Retirer des titres de la liste de suivi',
'watchlistedit-normal-explain' => 'Les titres de votre liste de suivi sont visibles ci-dessous.
Pour enlever un titre de la liste (et sa page de discussion), cochez la case à côté puis cliquez sur le bouton « {{int:Watchlistedit-normal-submit}} ».
Vous pouvez aussi [[Special:EditWatchlist/raw|modifier la liste en mode brut]].',
'watchlistedit-normal-submit' => 'Retirer les titres sélectionnés',
'watchlistedit-normal-done' => '{{PLURAL:$1|Un titre a été enlevé|$1 titres ont été enlevés}} de votre liste de suivi :',
'watchlistedit-raw-title' => 'Modifier la liste de suivi en mode brut',
'watchlistedit-raw-legend' => 'Modification de la liste de suivi en mode brut',
'watchlistedit-raw-explain' => "Les titres de votre liste de suivi sont affichés ci-dessous et peuvent être modifiés en les ajoutant ou les retirant de la liste (un titre par ligne).
Lorsque vous avez fini, cliquez sur le bouton « {{int:Watchlistedit-raw-submit}} » en bas.
Vous pouvez aussi [[Special:EditWatchlist|utiliser l'éditeur normal]].",
'watchlistedit-raw-titles' => 'Titres :',
'watchlistedit-raw-submit' => 'Mettre à jour la liste de suivi',
'watchlistedit-raw-done' => 'Votre liste de suivi a été mise à jour.',
'watchlistedit-raw-added' => '{{PLURAL:$1|Un titre a été ajouté|$1 titres ont été ajoutés}} :',
'watchlistedit-raw-removed' => '{{PLURAL:$1|Un titre a été retiré|$1 titres ont été retirés}} :',

# Watchlist editing tools
'watchlisttools-view' => 'Liste de suivi',
'watchlisttools-edit' => 'Voir et modifier la liste de suivi',
'watchlisttools-raw' => 'Modifier la liste de suivi en mode brut',

# Iranian month names
'iranian-calendar-m1' => 'Farvardin',
'iranian-calendar-m2' => 'Ordibehesht',
'iranian-calendar-m3' => 'Khordâd',
'iranian-calendar-m4' => 'Tir',
'iranian-calendar-m5' => 'Mordâd',
'iranian-calendar-m6' => 'Shahrivar',
'iranian-calendar-m7' => 'Mehr',
'iranian-calendar-m8' => 'Âbân',
'iranian-calendar-m9' => 'Âzar',
'iranian-calendar-m10' => 'Dey',
'iranian-calendar-m11' => 'Bahman',
'iranian-calendar-m12' => 'Esfand',

# Hijri month names
'hijri-calendar-m1' => 'Mouharram',
'hijri-calendar-m2' => 'Safar',
'hijri-calendar-m3' => 'Rabia al awal',
'hijri-calendar-m4' => 'Rabia ath-thani',
'hijri-calendar-m5' => 'Joumada al oula',
'hijri-calendar-m6' => 'Joumada ath-thania',
'hijri-calendar-m7' => 'Rajab',
'hijri-calendar-m8' => 'Chaabane',
'hijri-calendar-m9' => 'Ramadan',
'hijri-calendar-m10' => 'Chawwal',
'hijri-calendar-m11' => 'Dhou al qi’da',
'hijri-calendar-m12' => 'Dhou al-hijja',

# Hebrew month names
'hebrew-calendar-m1' => 'Tichri',
'hebrew-calendar-m2' => 'Hèchvane',
'hebrew-calendar-m3' => 'Kislev',
'hebrew-calendar-m4' => 'Téveth',
'hebrew-calendar-m5' => 'Schébat',
'hebrew-calendar-m6' => 'Adar',
'hebrew-calendar-m7' => 'Nissane',
'hebrew-calendar-m8' => 'Iyar',
'hebrew-calendar-m9' => 'Sivane',
'hebrew-calendar-m10' => 'Tamouz',
'hebrew-calendar-m11' => 'Av',
'hebrew-calendar-m12' => 'Éloul',
'hebrew-calendar-m1-gen' => 'Tichri',
'hebrew-calendar-m2-gen' => 'Hèchvane',
'hebrew-calendar-m3-gen' => 'Kislev',
'hebrew-calendar-m4-gen' => 'Téveth',
'hebrew-calendar-m5-gen' => 'Schébat',
'hebrew-calendar-m6-gen' => 'Adar',
'hebrew-calendar-m7-gen' => 'Nissane',
'hebrew-calendar-m8-gen' => 'Iyar',
'hebrew-calendar-m9-gen' => 'Sivane',
'hebrew-calendar-m10-gen' => 'Tamouz',
'hebrew-calendar-m11-gen' => 'Av',
'hebrew-calendar-m12-gen' => 'Éloul',

# Signatures
'signature' => '[[{{ns:user}}:$1|$2]] ([[{{ns:user_talk}}:$1|discussion]])',

# Core parser functions
'unknown_extension_tag' => "Balise d'extension « $1 » inconnue",
'duplicate-defaultsort' => 'Attention : la clé de tri par défaut « $2 » écrase la précédente « $1 ».',

# Special:Version
'version' => 'Version',
'version-extensions' => 'Extensions installées',
'version-specialpages' => 'Pages spéciales',
'version-parserhooks' => "Greffons de l'analyseur syntaxique",
'version-variables' => 'Variables',
'version-antispam' => 'Prévention du spam',
'version-skins' => 'Habillages',
'version-other' => 'Divers',
'version-mediahandlers' => 'Manipulateurs de médias',
'version-hooks' => 'Greffons',
'version-extension-functions' => "Fonctions d'extension internes",
'version-parser-extensiontags' => "Balises étendues de l'analyseur syntaxique",
'version-parser-function-hooks' => "Fonctions étendues de l'analyseur syntaxique",
'version-hook-name' => 'Nom du greffon',
'version-hook-subscribedby' => 'Abonnés :',
'version-version' => '(version $1)',
'version-license' => 'Licence',
'version-poweredby-credits' => "Ce wiki fonctionne grâce à '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
'version-poweredby-others' => 'autres',
'version-license-info' => "MediaWiki est un logiciel libre, vous pouvez le redistribuer ou le modifier selon les termes de la Licence Publique Générale GNU telle que publiée par la Free Software Foundation ; soit la version 2 de la Licence, ou (à votre choix) toute version ultérieure.

MediaWiki est distribué dans l'espoir qu'il sera utile, mais SANS AUCUNE GARANTIE, sans même la garantie implicite de COMMERCIALISATION ou D'ADAPTATION À UN USAGE PARTICULIER. Voir la Licence Publique Générale GNU pour plus de détails.

Vous devriez avoir reçu [{{SERVER}}{{SCRIPTPATH}}/COPYING une copie de la Licence Publique Générale GNU] avec ce programme, sinon, écrivez à la Free Software Foundation, Inc., 51, rue Franklin, cinquième étage, Boston, MA 02110-1301, États-Unis ou [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lisez-la en ligne].",
'version-software' => 'Logiciels installés',
'version-software-product' => 'Produit',
'version-software-version' => 'Version',
'version-entrypoints' => "URL des points d'entrée",
'version-entrypoints-header-entrypoint' => "Point d'entrée",
'version-entrypoints-header-url' => 'URL',
'version-entrypoints-articlepath' => '[https://www.mediawiki.org/wiki/Manual:$wgArticlePath Chemin d’article]',
'version-entrypoints-scriptpath' => '[https://www.mediawiki.org/wiki/Manual:$wgScriptPath Chemin de script]',

# Special:FilePath
'filepath' => "Chemin d'accès du fichier",
'filepath-page' => 'Fichier :',
'filepath-submit' => 'Aller',
'filepath-summary' => "Cette page spéciale retourne le chemin d'accès complet d'un fichier.
Les images sont montrées dans leur pleine résolution, les autres fichiers sont chargés et démarrés directement avec leur programme associé.",

# Special:FileDuplicateSearch
'fileduplicatesearch' => 'Recherche de doublons',
'fileduplicatesearch-summary' => "Recherche des copies de fichiers identiques d'après leur empreinte de hachage.",
'fileduplicatesearch-legend' => 'Rechercher un doublon',
'fileduplicatesearch-filename' => 'Nom du fichier :',
'fileduplicatesearch-submit' => 'Rechercher',
'fileduplicatesearch-info' => '$1 × $2 pixels<br />Taille du fichier : $3<br />Type MIME : $4',
'fileduplicatesearch-result-1' => "Le fichier « $1 » n'a aucun doublon.",
'fileduplicatesearch-result-n' => 'Le fichier « $1 » a {{PLURAL:$2|1 doublon|$2 doublons}}.',
'fileduplicatesearch-noresults' => "Aucun fichier nommé « $1 » n'a été trouvé.",

# Special:SpecialPages
'specialpages' => 'Pages spéciales',
'specialpages-note' => '----
* Pages spéciales normales.
* <span class="mw-specialpagerestricted">Pages spéciales restreintes.</span>
* <span class="mw-specialpagecached">Pages spéciales seulement en cache (pourraient être désuètes).</span>',
'specialpages-group-maintenance' => 'Rapports de maintenance',
'specialpages-group-other' => 'Autres pages spéciales',
'specialpages-group-login' => "S'identifier / s'inscrire",
'specialpages-group-changes' => 'Modifications récentes et journaux',
'specialpages-group-media' => 'Rapports et import de fichiers médias',
'specialpages-group-users' => 'Utilisateurs et droits rattachés',
'specialpages-group-highuse' => "Pages d'utilisation intensive",
'specialpages-group-pages' => 'Listes de pages',
'specialpages-group-pagetools' => 'Outils pour les pages',
'specialpages-group-wiki' => 'Données du wiki et outils',
'specialpages-group-redirects' => 'Pages spéciales redirigées',
'specialpages-group-spam' => 'Outils anti-pourriel',

# Special:BlankPage
'blankpage' => 'Page vide',
'intentionallyblankpage' => 'Cette page est laissée intentionellement vide.',

# External image whitelist
'external_image_whitelist' => " #Laisser cette ligne exactement telle quelle.<pre>
#Indiquer les fragments d'expressions rationnelles (juste la partie indiquée entre les //) ci-dessous.
#Ils correspondront avec les URL des images externes.
#Celles qui correspondent s'afficheront comme des images, sinon seul un lien vers l'image sera affiché.
#Les lignes commençant par un # seront considérées comme des commentaires.
#Cette liste n'est pas sensible à la casse.

#Mettez tous les fragments d'expressions rationnelles au-dessus de cette ligne. Laissez cette dernière ligne telle quelle.</pre>",

# Special:Tags
'tags' => 'Balises des modifications valides',
'tag-filter' => 'Filtrer les [[Special:Tags|balises]] :',
'tag-filter-submit' => 'Filtrer',
'tags-title' => 'Balises',
'tags-intro' => 'Cette page liste les balises que le logiciel peut utiliser pour marquer une modification et la signification de chacune.',
'tags-tag' => 'Nom de la balise',
'tags-display-header' => 'Apparence dans les listes de modifications',
'tags-description-header' => 'Description complète de la balise',
'tags-hitcount-header' => 'Modifications balisées',
'tags-edit' => 'modifier',
'tags-hitcount' => '$1 modification{{PLURAL:$1||s}}',

# Special:ComparePages
'comparepages' => 'Comparer des pages',
'compare-selector' => 'Comparer les versions des pages',
'compare-page1' => 'Page 1',
'compare-page2' => 'Page 2',
'compare-rev1' => 'Version 1',
'compare-rev2' => 'Version 2',
'compare-submit' => 'Comparer',
'compare-invalid-title' => "Le titre que vous avez spécifié n'est pas valide.",
'compare-title-not-exists' => "Le titre que vous avez spécifié n'existe pas.",
'compare-revision-not-exists' => "La révision que vous avez spécifié n'existe pas.",

# Database error messages
'dberr-header' => 'Ce wiki a un problème',
'dberr-problems' => 'Désolé ! Ce site rencontre des difficultés techniques.',
'dberr-again' => "Essayez d'attendre quelques minutes et rechargez.",
'dberr-info' => '(Connexion au serveur de base de données impossible : $1)',
'dberr-usegoogle' => 'Vous pouvez essayer de chercher avec Google pendant ce temps.',
'dberr-outofdate' => 'Notez que leurs index de notre contenu peuvent être dépassés.',
'dberr-cachederror' => 'Ceci est une copie cachée de la page demandée et peut être dépassée.',

# HTML forms
'htmlform-invalid-input' => 'Des problèmes sont survenus avec certaines valeurs',
'htmlform-select-badoption' => "La valeur que vous avez spécifiée n'est pas une option valide.",
'htmlform-int-invalid' => "La valeur que vous avec spécifiée n'est pas un entier.",
'htmlform-float-invalid' => "La valeur que vous avez spécifiée n'est pas un nombre.",
'htmlform-int-toolow' => 'La valeur que vous avez spécifiée est plus petite que le minimum de $1',
'htmlform-int-toohigh' => 'La valeur que vous avez spécifiée est plus grande que le maximum de $1',
'htmlform-required' => 'Cette valeur est requise',
'htmlform-submit' => 'Soumettre',
'htmlform-reset' => 'Défaire les modifications',
'htmlform-selectorother-other' => 'Autre',

# SQLite database support
'sqlite-has-fts' => '$1 avec recherche en texte intégral supportée',
'sqlite-no-fts' => '$1 sans recherche en texte intégral supportée',

# New logging system
'logentry-delete-delete' => '$1 a supprimé la page $3',
'logentry-delete-restore' => '$1 a restauré la page $3',
'logentry-delete-event' => "$1 a modifié la visibilité {{PLURAL:$5|d'un événement du journal|de $5 événements du journal}} sur $3: $4",
'logentry-delete-revision' => '$1 a modifié la visibilité {{PLURAL:$5|d’une révision|de $5 révisions}} sur la page $3&nbsp;: $4',
'logentry-delete-event-legacy' => '$1 a modifié la visibilité des événements du journal sur $3',
'logentry-delete-revision-legacy' => '$1 a modifié la visibilité des révisions sur la page $3',
'logentry-suppress-delete' => '$1 a supprimé la page $3',
'logentry-suppress-event' => "$1 a secrètement modifié la visibilité {{PLURAL:$5|d'un événement du journal|de $5 événements du journal}} sur $3: $4",
'logentry-suppress-revision' => "$1 a secrètement modifié la visibilité {{PLURAL:$5|d'une révision|de $5 révisions}} sur la page $3: $4",
'logentry-suppress-event-legacy' => '$1 a secrètement modifié la visibilité des événements du journal sur $3',
'logentry-suppress-revision-legacy' => '$1 a secrètement modifié la visibilité des révisions sur la page $3',
'revdelete-content-hid' => 'contenu masqué',
'revdelete-summary-hid' => 'résumé de modification masqué',
'revdelete-uname-hid' => 'nom d’utilisateur masqué',
'revdelete-content-unhid' => 'contenu affiché',
'revdelete-summary-unhid' => 'résumé de modification affiché',
'revdelete-uname-unhid' => 'nom d’utilisateur affiché',
'revdelete-restricted' => 'restrictions appliquées aux administrateurs',
'revdelete-unrestricted' => 'restrictions retirées pour les administrateurs',
'logentry-move-move' => '$1 a déplacé la page $3 vers $4',
'logentry-move-move-noredirect' => '$1 a déplacé la page $3 vers $4 sans laisser de redirection',
'logentry-move-move_redir' => '$1 a déplacé la page $3 vers $4 par-dessus une redirection',
'logentry-move-move_redir-noredirect' => '$1 a déplacé la page $3 vers $4 par-dessus une redirection sans laisser de redirection',
'logentry-patrol-patrol' => '$1 a marqué la révision $4 de la page $3 comme relue',
'logentry-patrol-patrol-auto' => '$1 a automatiquement marqué la révision $4 de la page $3 comme relue',
'logentry-newusers-newusers' => 'Le compte utilisateur $1 a été créé',
'logentry-newusers-create' => 'Le compte utilisateur $1 a été créé',
'logentry-newusers-create2' => 'Le compte utilisateur $3 a été créé par $1',
'logentry-newusers-autocreate' => 'Le compte $1 a été créé automatiquement',
'newuserlog-byemail' => 'mot de passe envoyé par courriel',

# Feedback
'feedback-bugornote' => "Si vous êtes prêt à décrire un problème technique en détail, veuillez [$1 signaler un bogue].
Sinon, vous pouvez utiliser le formulaire simplifié ci-dessous. Votre commentaire sera ajouté à la page « [$3 $2] », avec votre nom d'utilisateur et le navigateur que vous utilisez.",
'feedback-subject' => 'Objet :',
'feedback-message' => 'Message :',
'feedback-cancel' => 'Annuler',
'feedback-submit' => 'Envoyer vos commentaires',
'feedback-adding' => 'Ajout de vos commentaires à la page...',
'feedback-error1' => "Erreur : Résultat de l'API non reconnu",
'feedback-error2' => 'Erreur : la modification a échoué',
'feedback-error3' => "Erreur : aucune réponse de l'API",
'feedback-thanks' => 'Merci ! Votre commentaire a été publié sur la page "[$2 $1]".',
'feedback-close' => 'Fait',
'feedback-bugcheck' => "Formidable ! Vérifiez simplement que ce n'est pas un des [$1 bogues déjà connus].",
'feedback-bugnew' => "J'ai vérifié. Signaler un nouveau bogue",

# Search suggestions
'searchsuggest-search' => 'Rechercher',
'searchsuggest-containing' => 'contenant...',

# API errors
'api-error-badaccess-groups' => "Vous n'êtes pas autorisé à verser des fichiers sur ce wiki.",
'api-error-badtoken' => 'Erreur interne : mauvais « jeton ».',
'api-error-copyuploaddisabled' => 'Les versements via URL sont désactivés sur ce serveur.',
'api-error-duplicate' => "Il y a déjà {{PLURAL:$1|[$2 un autre fichier présent]|[$2 d'autres fichiers présents]}} sur le site avec le même contenu.",
'api-error-duplicate-archive' => "Il y avait déjà {{PLURAL:$1|[$2 un autre fichier présent]|[$2 d'autres fichiers présents]}} sur le site avec le même contenu, mais {{PLURAL:$1|il a été supprimé|ils ont été supprimés}}.",
'api-error-duplicate-archive-popup-title' => 'Dupliquer {{PLURAL:$1|le fichier|les fichiers}} qui {{PLURAL:$1|a déjà été supprimé|ont déjà été supprimés}}',
'api-error-duplicate-popup-title' => '{{PLURAL:$1|fichier|fichiers}} en double',
'api-error-empty-file' => 'Le fichier que vous avez soumis était vide.',
'api-error-emptypage' => "Création de pages vide n'est pas autorisée.",
'api-error-fetchfileerror' => "Erreur interne : Quelque chose s'est mal passé lors de la récupération du fichier.",
'api-error-fileexists-forbidden' => 'Un fichier nommé "$1" existe déjà, et ne peut pas être écrasé.',
'api-error-fileexists-shared-forbidden' => 'Un fichier nommé "$1" existe déjà dans le répertoire des fichiers partagés, et ne peut pas être écrasé.',
'api-error-file-too-large' => 'Le fichier que vous avez soumis était trop grand.',
'api-error-filename-tooshort' => 'Le nom du fichier est trop court.',
'api-error-filetype-banned' => 'Ce type de fichier est interdit.',
'api-error-filetype-banned-type' => "$1 {{PLURAL:$4|n'est pas un type de fichier autorisé|ne sont pas des types de fichiers autorisés}}. {{PLURAL:$3|Le type de fichier autorisé est |Les types de fichiers autorisés sont}} $2.",
'api-error-filetype-missing' => "L'extension du fichier est manquante.",
'api-error-hookaborted' => 'La modification que vous avez essayé de faire a été annulée par une extension.',
'api-error-http' => 'Erreur interne : ne peut se connecter au serveur.',
'api-error-illegal-filename' => "Le nom du fichier n'est pas autorisé.",
'api-error-internal-error' => "Erreur interne : Quelque chose s'est mal passé lors du traitement de votre import sur le wiki.",
'api-error-invalid-file-key' => 'Erreur interne : aucun fichier trouvé dans le stockage temporaire.',
'api-error-missingparam' => 'Erreur interne : Il manque des paramètres dans la requête.',
'api-error-missingresult' => "Erreur interne : Nous n'avons pas pu déterminer si la copie avait réussi.",
'api-error-mustbeloggedin' => 'Vous devez être connecté pour télécharger des fichiers.',
'api-error-mustbeposted' => 'Erreur interne : cette requête nécessite la méthode HTTP POST.',
'api-error-noimageinfo' => "Le téléversement a réussi, mais le serveur n'a pas donné d'informations sur le fichier.",
'api-error-nomodule' => 'Erreur interne : aucun module de versement défini.',
'api-error-ok-but-empty' => "Erreur interne : Le serveur n'a pas répondu.",
'api-error-overwrite' => "Écraser un fichier existant n'est pas autorisé.",
'api-error-stashfailed' => "Erreur interne : le serveur n'a pas pu enregistrer le fichier temporaire.",
'api-error-timeout' => "Le serveur n'a pas répondu dans le délai imparti.",
'api-error-unclassified' => "Une erreur inconnue s'est produite",
'api-error-unknown-code' => 'Erreur inconnue : « $1 »',
'api-error-unknown-error' => 'Erreur interne : Quelque chose a mal tourné lors du versement de votre fichier.',
'api-error-unknown-warning' => 'Avertissement inconnu : $1',
'api-error-unknownerror' => 'Erreur inconnue : « $1 ».',
'api-error-uploaddisabled' => 'Le téléversement est désactivé sur ce wiki.',
'api-error-verification-error' => 'Ce fichier peut être corrompu, ou son extension est incorrecte.',

# Durations
'duration-seconds' => '$1 seconde{{PLURAL:$1||s}}',
'duration-minutes' => '$1 minute{{PLURAL:$1||s}}',
'duration-hours' => '$1 heure{{PLURAL:$1||s}}',
'duration-days' => '$1 jour{{PLURAL:$1||s}}',
'duration-weeks' => '$1 semaine{{PLURAL:$1||s}}',
'duration-years' => '$1 année{{PLURAL:$1||s}}',
'duration-decades' => '$1 décennie{{PLURAL:$1||s}}',
'duration-centuries' => '$1 siècle{{PLURAL:$1||s}}',
'duration-millennia' => '$1 millénaire{{PLURAL:$1||s}}',

# WikiEditor Toolbar

'wikieditor-toolbar-tool-strike' => 'Rayer',
'wikieditor-toolbar-tool-underline' => 'Souligné',
'wikieditor-toolbar-tool-center' => 'Centré',
'wikieditor-toolbar-align-right' => 'Aligné à la droite',
'wikieditor-toolbar-align-left' => 'Aligne à la gauche',
'wikieditor-toolbar-tool-advanced-image' => 'Image avancé',
'wikieditor-toolbar-tool-horizontal-line' => 'Ligne horizontal',
'wikieditor-toolbar-tool-math' => 'Ajouter formule',
'wikieditor-toolbar-tool-comment' => 'Commentaire caché',


);
