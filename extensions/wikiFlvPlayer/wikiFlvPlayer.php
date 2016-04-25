<?php
# wikiFlvPlayer will allow you to add mp3 or FLV multimedia file in 
# your wiki articles.

# To activate the extension, include it from your LocalSettings.php with: 
# include("extensions/wikiFlvPlayer/wikiFlvPlayer.php");

/*
 * ----------------------------------------------------------------------------
 *
 * @Version 2.00
 * @Author Paul Y. Gu, <gu.paul@gmail.com>
 * @Copyright paulgu.com 2006 - http://paulgu.com/
 * @License: GPL (http://www.gnu.org/copyleft/gpl.html)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * ----------------------------------------------------------------------------
  Control parameters:

  <wikiflv></wikiflv>
  whatever.flv|whatever.png
  width="320"
  height="180"
  logo="false"
  autostart="false"
  position="none"
  volume="100"
  repeat="false"

 * ----------------------------------------------------------------------------
 *
 * Changelog
 * ============================================================================
 *
 * 1.00 - Initial beta release
 * 1.01 - First public release
 * 2.00 - Bug fix and support absolute path
 */
if (!defined('MEDIAWIKI')) die('Not an entry point.');


$wgExtensionCredits['other'][] = array
  (
   'name' => "Embed FLV Player for Mediawiki",
   'version' => "2.00, September 11, 2009",
   'author' => 'Paul Gu',
   'url' => 'http://paulgu.com',
   'description' => 'Mediawiki FLV Player'
   );

$wgExtensionFunctions[] = "wfFlvPlayerExtension";

function wfFlvPlayerExtension() {
	global $wgParser;
	$wgParser->setHook( "wikiFlv", "fnRenderFlvPlayer" );
}

function fnRenderFlvPlayer( $input, $argv ) {
	// Constructor
	$flvPlayerFile = new MediaWikiFlvPlayer( $input, $argv );
	// render the result
	$result = $flvPlayerFile->render();
	// send the final code to the wiki
	return $result;
}

/*
 * The FlvPlayer class generates code that embeds a flash movie player
 * with reference to the uploaded movie.
 */
class MediaWikiFlvPlayer {

	/* Constructor */
	function MediaWikiFlvPlayer( $input, $argv ) {

		global $wgScriptPath;
		global $MW_FLV_LOGO;
		global $MW_FLV_LOGO_URL;

		// initialize parameters
		$this->wikiFlvPath = $wgScriptPath . '/extensions/wikiFlvPlayer';

		$this->flvfile = '';
		$this->imagefile = '';
		$this->width = '300';
		$this->height = '180';
		$this->position = 'none';
		$this->autostart = 'false';
		$this->volume = '100';
		$this->repeat = 'false';
		if ( !isset($this->recommendations) ) $this->recommendations = '';
		$this->recommendations .= '';

		$this->flowplayerswfobjectpath = $this->wikiFlvPath . '/swfobject.js';
		$this->flowplayerpath = $this->wikiFlvPath . '/player.swf';

		if( $MW_FLV_LOGO != '' )
			$this->logo = $MW_FLV_LOGO;
		else
			$this->logo = $this->wikiFlvPath . '/logo.png'; //video logo

		if( $MW_FLV_LOGO_URL != '' )
			$this->logourl = $MW_FLV_LOGO_URL;
		else
			$this->logourl = "http://paulgu.com";

		// get input args for file name
		if ($input != "") {
			$aParams = explode("|", $input);
			if ( count($aParams) == 1 ) {
				$this->flvfile = trim($aParams[0]);
			} else if( count($aParams) == 2 ) {
				$this->flvfile = trim($aParams[0]);
				$this->imagefile = trim($aParams[1]);
			}
		}
		
		//GCEDIT - check if is set to prevent 'missing index' notices
		if (isset($argv["width"]))
			if ($argv["width"] != "")
				$this->width = $argv["width"];
		if (isset($argv["height"]))
			if ($argv["height"] != "")
				$this->height = $argv["height"];
		if (isset($argv["logo"]))
			if ($argv["logo"] == "false")
				$this->logo = '';
		if (isset($argv["position"]))
			if ($argv["position"] != "")
				$this->position = $argv["position"];
		if (isset($argv["autostart"]))
			if ($argv["autostart"] != "")
				$this->autostart = $argv["autostart"];
		if (isset($argv["volume"]))
			if ($argv["volume"] != "")
				$this->volume = $argv["volume"];
		if (isset($argv["repeat"]))
			if ($argv["repeat"] != "")
				$this->repeat = $argv["repeat"];
		if (isset($argv["recommendations"]))
			if ($argv["recommendations"] != "")
				$this->recommendations = $argv["recommendations"];
	}

	/* Generate final code */
	function render() {

		global $wgScriptPath, $wgJsMimeType;

		// initialize imageurl
		$this->imageurl = '';

		$pos1 = strpos($this->flvfile, "/");
		if ($pos1 !== false) {
			// use absolute path for file
			$this->fileurl = $wgScriptPath ."/". $this->flvfile;
			$this->fileurl = str_replace('//', '/', $this->fileurl);
		} else {
			// use wiki path for file
			if ($this->flvfile != '') {
				$this->fileurl = $this->getWikiPath($this->flvfile);
			} else {
				$this->fileurl = $this->wikiFlvPath . '/flvdemo.flv';
				$this->imageurl = $this->wikiFlvPath . '/flvdemo.jpg';
			}
		}

		$pos2 = strpos($this->imagefile, "/");
		if ($pos2 !== false) {
			// use absolute path for file
			$this->imageurl = $wgScriptPath ."/". $this->imagefile;
			$this->imageurl = str_replace('//', '/', $this->imageurl);
		} else {
			// use wiki path for file
			if ($this->imagefile != '') {
				$this->imageurl = $this->getWikiPath($this->imagefile);
			}
		}


		if ($this->recommendations != '')
			$this->recommendationsurl = $this->getWikiPath($this->recommendations);

		// get unique player id
		$playerID = $this->rand_string(25);

		// output the necessary styles, script
		$this->code = '';
		//$this->code .= '<style type="text/css">';
		//$this->code .= '   @import "' . $this->wikiFlvPath . '/wikiFlvPlayer.css";';
		//$this->code .= '</style>';
		// initialize the video
		$this->code .= '<script src="' . $this->flowplayerswfobjectpath . '" type="' . $wgJsMimeType . '"></script>';
		$this->code .= '<div id="flvpid-'. $playerID .'" class="wikiFlvPlayer" style="float:'.$this->position.'; width:'.$this->width.'px;">';
		$this->code .= '<a href="http://www.macromedia.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"></a></div>';

		// load the swfobject
		$this->code .= '<script  type="' . $wgJsMimeType . '">';
		$this->code .= '/*<![CDATA[*/';
		$this->code .= 'var so = new SWFObject("'.$this->flowplayerpath.'","player","'.$this->width.'","'.$this->height.'","9");';
		// basic control of the vide
		$this->code .= 'so.addParam("allowfullscreen","true");';
		$this->code .= 'so.addParam("allowscriptaccess","always");';
		$this->code .= 'so.addParam("wmode","opaque");';


		//$this->code .= 'so.addVariable("link","'.$this->logourl.'");'; // link for logo
		$this->code .= 'so.addVariable("file","'.$this->fileurl.'");';
		$this->code .= 'so.addVariable("image","'.$this->imageurl.'");';


		$this->code .= 'so.addVariable("backcolor","0x000000");';
		$this->code .= 'so.addVariable("frontcolor","0xCCCCCC");';
		$this->code .= 'so.addVariable("lightcolor","0xFF9900");';
		$this->code .= 'so.addVariable("screencolor","0x333333");';


		$this->code .= 'so.addVariable("height","'.$this->height.'");';
		//$this->code .= 'so.addVariable("skin","'.$this->wikiFlvPath.'/playcasso.swf");';
		$this->code .= 'so.addVariable("width","'.$this->width.'");';
		

		$this->code .= 'so.addVariable("autostart","'.$this->autostart.'");';
		$this->code .= 'so.addVariable("bufferlength","3");';
		$this->code .= 'so.addVariable("logo","'.$this->logo.'");';
		$this->code .= 'so.addVariable("quality", "true");';
		$this->code .= 'so.addVariable("repeat","'.$this->repeat.'");';
		$this->code .= 'so.addVariable("volume","'.$this->volume.'");';


		// output the video
		$this->code .= 'so.write("flvpid-'. $playerID .'");';
		$this->code .= '/*]]>*/';
		$this->code .= '</script>';

		return $this->code;
	}

	function getWikiPath($file) {
		$title = Title::makeTitleSafe(-2 /*"Image"*/,$file); //GCChange - changed (string)"Image" to (int)-2 to fix for 1.20.3
		$repo = RepoGroup::singleton()->getLocalRepo();
		$img = new LocalFile($title,$repo);
		$path = $img->getViewURL(false);
		return $path;
	}

	function rand_string($len, $chars = 'abcdefghijklmnopqrstuvwxyz0123456789')
	{
		$string = '';
		for ($i = 0; $i < $len; $i++)
		{
			$pos = rand(0, strlen($chars)-1);
			$string .= $chars{$pos};
		}
		return $string;
	}

}
