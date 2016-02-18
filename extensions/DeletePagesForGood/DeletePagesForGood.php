<?php
/**
 * DeletePagesForGood
 *
 * Based on DeletePagePermanently
 *
 * GPL-2.0+
 *
 * BE CAREFUL WHEN USING THIS EXTENSION. ONCE A PAGE IS DELETED, IT CAN NOT BE RESTORED ANY MORE.
*/

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'DeletePagesForGood' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['DeletePagesForGood'] = __DIR__ . '/i18n';
	/* wfWarn(
		'Deprecated PHP entry point used for DeletePagesForGood extension.' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	); */
	return;
} else {
	die( 'This version of the DeletePagesForGood extension requires MediaWiki 1.25+' );
}
