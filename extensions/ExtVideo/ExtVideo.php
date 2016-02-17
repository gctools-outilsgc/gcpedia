<?php

if ( ! defined( 'MEDIAWIKI' ) )
	die();
 
$wgExtensionFunctions[] = 'wfVideoFlash';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'External FLV Player',
        'description' => 'This FLV extension allows one to load an FLV file from an external server',
        'author' => 'Ryan Brink',
);
 
function wfVideoFlash() {
        global $wgParser;
        $wgParser->setHook('videoflash', 'renderVideoFlash');
}
 
 
# The callback function for converting the input text to HTML output
function renderVideoFlash($input, $args) {

# Specify a default width and height for when one is not given from the user
if (!isset($args['width'])){
	$VideoWidth = '400';
	} else {
	$VideoWidth = $args['width'];
}

if (!isset($args['height'])){	
	$VideoHeight = '320';
	} else {
	$VideoHeight = $args['height'];
}


global $wgFlashPlayer, $wgServer, $wgScriptPath;

# Define the path to the FLV player (flowplayer).  Please change the version number to match the filename you are using
$wgFlashPlayer = $wgServer . $wgScriptPath . '/extensions/ExtVideo/flowplayer-3.0.7.swf';

# Define a variable to use for loading the full information of the video later
$movie = 'config={"playlist":[ {"url":"' . $input . '","autoPlay":false,"fadeInSpeed":0} ] }';

# The HTML output of the function
$output =  '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' . $VideoWidth . '" height="' . $VideoHeight . '"><param name="movie" value="' . $wgFlashPlayer . '" /><param name="allowfullscreen" value="true" /><param name="flashvars" value=\'' . $movie . '\' /><embed type="application/x-shockwave-flash" width="' . $VideoWidth . '" height="' . $VideoHeight . '" allowfullscreen="true" src="' . $wgFlashPlayer . '" flashvars=\'' . $movie . '\' /></object>';

# Print out output variable previously defined
return sprintf($output);
		
 }
?>