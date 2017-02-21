MsCalendar
==========
The MsCalendar extension enables users to insert calendars into wiki pages.

Installation
------------
To install MsCalendar, add the following to your LocalSettings.php:

wfLoadExtension( 'MsCalendar' );

Then run the update script to create the necessary tables (see https://www.mediawiki.org/wiki/Manual:Update.php).

Usage
-----
To insert a calendar into a wiki page, simply edit a page and add the following wikitext:

<MsCalendar>Name of the calendar</MsCalendar>

You can insert as many calendars as you want, but each must have a unique name.

Configuration
-------------
The events of each day are sorted alphabetically. You can also sort them by id by doing:

<MsCalendar sort="id">Name of the calendar</MsCalendar>

Credits
-------
* Developed and coded by Martin Schwindl (wiki@ratin.de)
* Idea, project management and bug fixing by Martin Keyler (wiki@keyler-consult.de)
* Updated, debugged and enhanced by Luis Felipe Schenone (schenonef@gmail.com)
* Support for multiple calendars by Frédéric Souchon (aka Fraifrai)
* This extension uses jquery.calendario.js v1.0.0 (http://www.codrops.com) - Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php) - Copyright 2012 - Codrops (http://www.codrops.com)