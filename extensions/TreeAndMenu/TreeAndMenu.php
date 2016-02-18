<?php
if ( function_exists( 'wfLoadExtension' ) ) {
	$ext = preg_replace( '%^.+/(.+?)\.php$%', '$1', __FILE__ );
	die(
		"Deprecated PHP entry point used for <i>$ext</i> extension. Please use wfLoadExtension instead, " .
		'see <a href="https://www.mediawiki.org/wiki/Extension_registration">Extension registration</a> for more details.'
	);
	return;
} else {
	die(
		"<b>Fatal error:</b> This version of the <i>$ext</i> extension requires MediaWiki 1.25+, " .
		'either <a href="https://mediawiki.org/wiki/Download">upgrade your MediaWiki</a> or download the extension code from the ' .
		'<a href="https://github.com/OrganicDesign/extensions/tree/MediaWiki-1.24/MediaWiki">1.24 branch</a>.'
	);
}
