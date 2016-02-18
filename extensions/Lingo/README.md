# Lingo
[![Latest Stable Version](https://poser.pugx.org/mediawiki/lingo/version.png)](https://packagist.org/packages/mediawiki/lingo)
[![Packagist download count](https://poser.pugx.org/mediawiki/lingo/d/total.png)](https://packagist.org/packages/mediawiki/lingo)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:lingo/badge.png)](https://www.versioneye.com/php/mediawiki:lingo)

Lingo is a glossary extension to MediaWiki, that lets you define abbreviations
and their definitions on a wiki page. It displays these definitions whenever an
abbreviation is hovered over in an article.

See http://www.mediawiki.org/wiki/Extension:Lingo for online documentation.

## Requirements

- PHP 5.3.2 or later
- MediaWiki 1.20 or later

## Installation

The recommended way to install this skin is by using [Composer][composer]. Just add the following to the MediaWiki `composer.json` file and run the `php composer.phar install/update` command.

```json
{
	"require": {
		"mediawiki/lingo": "~1.2"
	}
}
```

## Customization

The following settings may be used:

* `$wgexLingoPage` to specify the name of the terminology page
  Example: `$wgexLingoPage = 'Glossary'`;

* `$wgexLingoDisplayOnce` to specify that each term should be annotated only once
  per page
  Example: `$wgexLingoDisplayOnce = true`;

* `$wgexLingoUseNamespaces` to specify what namespaces should or should not be used
  Example: `$wgexLingoUseNamespaces[NS_TALK] = false`;

If you want to use these settings, just include them in LocalSettings.php AFTER
the require_once("$IP/extensions/Lingo/Lingo.php");


## Usage

By default Lingo will mark up any page that is not in a forbidden namespace. To
exclude a page from markup you can include __NOGLOSSARY__ anywhere in the
article. In some cases it may be necessary to exclude portions of a page, e.g.
because Lingo interferes with some JavaScript. This can be achieved by wrapping
the part in an HTML element (e.g. a span or a div) and specify class="noglossary".

### Terminology page

Create the page "Terminology" (no namespace), and insert some entries using
the following syntax:

;FTP:File Transport Protocol
;AAAAA:American Association Against Acronym Abuse
;ACK:Acknowledge
;AFAIK:As Far As I Know
;AWGTHTGTATA:Are We Going To Have To Go Through All This Again
;HTTP:HyperText Transfer Protocol

## Reporting bugs

Comments, questions and suggestions should be sent or posted to:
* the Lingo discussion page: http://www.mediawiki.org/wiki/Extension_talk:Lingo
* the maintainer: http://www.mediawiki.org/wiki/Special:EmailUser/F.trott

## Credits

Lingo is a rewrite of Extension:Terminology, written by BarkerJr with
modifications by Benjamin Kahn. It was originally written by Barry Coughlan and
is currently maintained by Stephan Gambke.

## License

[GNU General Public License 2.0][license] or later.

[composer]: https://getcomposer.org/
[license]: https://www.gnu.org/copyleft/gpl.html
