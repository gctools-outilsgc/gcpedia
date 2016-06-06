<?php
/**
 * Setup for ContactPage extension, a special page that implements a contact form
 * for use by anonymous visitors.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007-2014 Daniel Kinzler, Sam Reed
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 * This PHP entry point is deprecated. Please use wfLoadExtension() and the extension.json file instead.
 * See https://www.mediawiki.org/wiki/Manual:Extension_registration for more details.
 */

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ContactPage',
	'author' => array( 'Daniel Kinzler', 'Sam Reed' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:ContactPage',
	'descriptionmsg' => 'contactpage-desc',
	'version' => 2.2,
	'license-name' => 'GPL-2.0+'
);

// Set up the new special page
$dir = __DIR__ . '/';
$wgMessagesDirs['ContactPage'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['ContactPage'] = $dir . 'ContactPage.i18n.php';
$wgExtensionMessagesFiles['ContactPageAliases'] = $dir . 'ContactPage.alias.php';

$wgAutoloadClasses['SpecialContact'] = $dir . 'ContactPage_body.php';
$wgSpecialPages['Contact'] = 'SpecialContact';

/**
 * Set all fields if adding additional contact forms.
 *
 * If an array key with the form type name isn't set,
 * defaults will be used.
 *
 * Array key should be lowercase.
 *
 * @code
 * $wgContactConfig['formname'] = array(
 *      'RecipientUser' => 'WikiUser',
 *      'SenderEmail' => 'user@email.com',
 *      'SenderName' => 'User Email',
 *      'RequireDetails' => true,
 *      'IncludeIP' => true,
 *      'AdditionalFields' => array(),
 * );
 * @endcode
 */
$wgContactConfig['default'] = array(
	// Username of a registered wiki user who will receive the mails
	'RecipientUser' => null,

	// Email address used as the sender of the contact email, if the visitor does
	// not supply an email address. Defaults to $wgPasswordSender.
	'SenderEmail' => null,

	// The name to be used with SenderEmail.
	// This will be shown in the recipient's email program
	// Defaults to "Contact Form on $wgSitename"
	'SenderName' => 'Contact Form on ' . $wgSitename,

	// If true, users will be required to supply a name and an email address
	// on Special:Contact.
	'RequireDetails' => false,

	// If true, the form will include a checkbox offering to put the IP
	// address of the submitter in the subject line
	'IncludeIP' => false,

	// Display format for the form. See HTMLForm documentation for available
	// values.
	'DisplayFormat' => 'table',

	// Resource loader modules to add to the form display page.
	'RLModules' => array(),

	// Resource loader CSS modules to add to the form display page.
	'RLStyleModules' => array(),

	// Any additional fields to display on the contact form.
	// Uses https://www.mediawiki.org/wiki/HTMLForm notation
	// Using any of your own "AdditionalFields" will replce the large text box
	// Copy the code below into your own config if still wanted
	//
	// 'type' => 'selectandother' currently isn't supported.
	'AdditionalFields' => array(
		'Text' => array(
			'label-message' => 'emailmessage',
			'type' => 'textarea',
			'rows' => 20,
			'cols' => 80,
			'required' => true,
		),
	),
);
