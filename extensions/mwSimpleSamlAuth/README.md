# SAML plugin for MediaWiki

## Glossary
* **SimpleSamlAuth** This extension, uses *SimpleSamlPhp* to allow SAML login in *MediaWiki*.
* **SimpleSamlPhp** Open source lightweight SAML implementation by UNINETT.
* **MediaWiki** Open source Wiki software.

## Requirements
* [SimpleSamlPhp](//simplesamlphp.org) (tested on 1.11 and newer)
* [MediaWiki](//mediawiki.org) (tested on 1.15, 1.16 or newer required for some features)

## Preparation
* Install SimpleSamlPhp on the same domain as your MediaWiki installation.
* In SimpleSamlPhp, use the *Authentication* -> *Test configured authentication sources* feature to ensure that authentication works.
Also make sure that the attributes make sense.

You may keep the attributes page open for later reference,  
for filling out `$wgSamlUsernameAttr`, `$wgSamlRealnameAttr` and `$wgSamlMailAttr`.

If you encounter problems during the preparation, please [look here](http://simplesamlphp.org/support) for support.
*Only* report bugs for SimpleSamlAuth if the **preparation steps** work for you.

## Installation
* Clone this repository into your MediaWikis *extensions* directory, and call it **SimpleSamlAuth**.

```bash
git clone git@github.com:jornane/mwSimpleSamlAuth.git SimpleSamlAuth
```

* Add the following lines to **LocalSettings.php** in your MediaWiki installation:

```php
require_once "$IP/extensions/SimpleSamlAuth/SimpleSamlAuth.php";

// SAML_OPTIONAL // SAML_LOGIN_ONLY // SAML_REQUIRED //
$wgSamlRequirement = SAML_OPTIONAL;
// Should users be created if they don't exist in the database yet?
$wgSamlCreateUser = false;

// SAML attributes
$wgSamlUsernameAttr = 'uid';
$wgSamlRealnameAttr = 'cn';
$wgSamlMailAttr = 'mail';

// SimpleSamlPhp settings
$wgSamlSspRoot = '/usr/share/simplesamlphp';
$wgSamlAuthSource = 'default-sp';
$wgSamlPostLogoutRedirect = NULL;

// Array: [MediaWiki group][SAML attribute name][SAML expected value]
// If the SAML assertion matches, the user is added to the MediaWiki group
$wgSamlGroupMap = array(
	'sysop' => array(
		'groups' => array('admin'),
	),
);
```

## Configuration
Modify the variables starting with *$wgSaml* to configure the extension.
Some important variables:

### $wgSamlRequirement
This variable tells the extension how MediaWiki should behave.  
There are three options; `SAML_OPTIONAL` `SAML_LOGIN_ONLY` `SAML_REQUIRED`:

|                                    | optional | loginonly | required |
|-----------------------------------:|:--------:|:---------:|:--------:|
|           Allow login through SAML |    ✓     |     ✓     |    ✓     |
| Update user's real name and e-mail |    ✓     |     ✓     |    ✓     |
| Prevent creation of local accounts |          |     ✓     |    ✓     |
|   Prevent login with local account |          |     ✓     |    ✓     |
|         Prevent anonymous browsing |          |           |    ✓     |
|       Redirect to login immediatly |          |           |    ✓     |

You can still use the [MediaWiki methods for preventing access](http://www.mediawiki.org/wiki/Manual:Preventing_access) to block certain actions, even if SimpleSamlAuth won't block them. The only exception is that `$wgSamlCreateUser = true` will have priority over `$wgGroupPermissions['*']['createaccount'] = false`.

### $wgSamlAuthSource
This is the name of the AuthSource you configured in SimpleSamlPhp.
You can easily find it by going to the SimpleSamlPhp installation page and going to *Authentication* -> *Test configured authentication sources*.
The word you have to click there is the name of your AuthSource.
For SAML sessions, the standard preconfigured name in SimpleSamlPhp is `default-sp` and this is also what SimpleSamlAuth will guess if you omit the variable.

### $wgSamlPostLogoutRedirect
This is an URL where users are redirected when they log out from the MediaWiki installation.
Generally, for a `SAML_REQUIRED` setup you want to set this to a landing page (intranet, for example).
For any other setup, you may not want to set this, so users can continue browsing the Wiki anonymously after logging out.

### $wgSamlGroupMap
This is a list of rules used to add users to MediaWiki groups based on their SAML attributes.
It is an array of three layers deep:

* Name of the MediaWiki group (for example `sysop`)
* Name of a SAML attribute (for example `groups`)
* Possible value for the SAML attribute (for example `admin`)

```php
$wgSamlGroupMap = array(
	'sysop' => array(
		'groups' => array('admin'),
	),
);
```
An array as illustrated here will add users to the `sysop` MediaWiki group, if they have a SAML attribute named `groups` with at least a value `admin`.
If you want more fine-grained control, look at the [SimpleSamlPhp role module](https://github.com/jornane/sspmod_role).

## Known Issues
### Weird things happen with sessions / I must click Save twice before the page saves
This has to do with the value of `$wgSessionName`. This value must be set to `ini_get('session.name')` if you use PHP sessions in both SimpleSamlPhp and MediaWiki.  From version 0.5, SimpleSamlAuth will take care of this automatically.

### SAML users can edit their e-mail address
Extensions can only disable preferences [since MediaWiki 1.16](http://www.mediawiki.org/wiki/Manual:Hooks/GetPreferences).
Ubuntu 12.04 LTS comes with MediaWiki 1.15.
[WikiMedia recommends against using the Ubuntu-provided version of MediaWiki.](http://www.mediawiki.org/wiki/Manual:Running_MediaWiki_on_Ubuntu)

### E-mail addresses are not automatically confirmed
SimpleSamlAuth will *only* confirm e-mail addresses that it has set itself.
Make sure that you have configured `$wgSamlMailAttr` correctly.

### SAML users overwrite MediaWiki users / SAML users can reset their password and become a local user
There is not really a difference between local accounts and remote accounts in MediaWiki.
[There has been an idea to implement this](http://www.mediawiki.org/wiki/ExternalAuth), but it looks like it's dead now.

If SimpleSamlPhp presents a valid session, SimpleSamlAuth simply finds a local MediaWiki user with a username roughly equal to the value of the username attribute; if it doesn't exist, and if `$wgSamlCreateUser` is set, the user is created.
This newly created user will have no password, but will be able to reset their password if a valid e-mail address has been set.

### Other issue?
Please report it on the project's [GitHub issues page](https://github.com/jornane/mwSimpleSamlAuth/issues).
