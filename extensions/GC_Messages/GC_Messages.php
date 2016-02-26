<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => "GC_Messages",
	'description' => "Messages extension to avoid modifying core languages files.",
	'version' => 1.0,
	'url' => "http://www.mediawiki.org/wiki/Manual:Developing_extensions",
);

$wgExtensionMessagesFiles['GC_Messages'] = dirname( __FILE__ ) . '/GC_Messages.i18n.php';