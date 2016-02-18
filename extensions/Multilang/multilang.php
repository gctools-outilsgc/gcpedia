<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/*
  Multilanguage extension for MediaWiki version 0.11 using <multilang> tag for
  selective text display depending from user language settings.
  Author: Daniel Arnold <arnomane@gmx.de> after an idea of Eric David
  Copyright: Daniel Arnold (2006)
  License: GPL version 2 or at your option any later version
  Usage 1:
  <multilang>
  @de|Deutsche Version
  @en|English version
  @fr|Version française
  </multilang>
  Usage 2: <multilang /> to show your language settings
  In order to activate the extension copy it into your extension folder and
  include it from your LocalSettings.php with:
  include("extensions/multilang.php");
*/

$wgExtensionFunctions[] = "wfMultilang";
$wgExtensionCredits['parserhook'][] = array(
    'name' => 'Multilang',
    'author' => 'Daniel Arnold, after an idea of Eric David',
    'description' => 'adds <nowiki><multilang></nowiki> tag, for selective display of translated texts',
    'url' => 'http://download.pakanto.org/software/'
);


function wfMultilang() {
        global $wgParser;
        $wgParser->setHook("multilang","renderMultilang");
}


function renderMultilang($input, $argv=array(), $parser) {
	global $wgLang, $wgLanguageCode, $wgMultilangUseBrowserLanguage;

	// The parser cache needs to be disabled as the page output is
	// depending from user settings without any change in the page
	// wiki source code
	$parser->disableCache();

	// wether we use browser or user setting for language detection
	if ($wgMultilangUseBrowserLanguage == true)
	{
		// This code probably does not work with all browsers
		// only tested it with Konqueror
		$browserstring = str_replace(";",",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		$userlanguages = split(",",$browserstring);
	}
	else
	{
		// sadly in current MediaWiki you can only set one user language
		$userlanguages[0] = $wgLang->getCode();

		// second language is wiki default language as fallback
		if ($userlanguages[0] != $wgLanguageCode)
		{
			$userlanguages[1] = $wgLanguageCode;
		}
	}

	// if no text is given only display the language settings of the client
	if ($input == "")
	{
		$languagelist = "";
		for ($i=0;$i<count($userlanguages);$i++)
		{
			$languagelist .= ($i==0?"":", ").$userlanguages[$i];
		}
		return $languagelist;
	}

	// Searching for all @Langcode| sections
	// match has this structure: $match[0][matchnumber][0 = matchingstring, 1 = position];
	$sections = preg_match_all('/^@[^\|]*\|/m', $input, $match, PREG_OFFSET_CAPTURE);
	if ($sections > 0)
	{
		// the last "matching" position is the end of the input string, see below
		$match[0][$sections][1] = strlen($input);
		for ($i=0;$i<count($userlanguages);$i++)
		{
			for ($j=0;$j<$sections;$j++)
			{
				// if we did find the wanted section
				if (strpos($match[0][$j][0],$userlanguages[$i]) != FALSE)
				{
					// cutting out the wanted section
					$rawtext = substr($input,$match[0][$j][1],$match[0][$j+1][1]-$match[0][$j][1]);
					$delimiter = strpos($rawtext,'|');
					$rawtext = substr($rawtext, $delimiter+1);
					// rather complicated call of the parser (necessary in newer
					// MediaWiki versions) so that we get our embedded wiki text
					// converted into HTML
					$output = $parser->parse($rawtext, $parser->mTitle, $parser->mOptions, true, false);
					return $output->getText();
				}
			}
		}
		// fallback to first entry if there is no match (no default
		// language message and no match with user language settings)
		$rawtext = substr($input,$match[0][0][1],($match[0][1][1])-$match[0][0][1]);
		$delimiter = strpos($rawtext,'|');
		$rawtext = substr($rawtext, $delimiter+1);
		$output = $parser->parse($rawtext, $parser->mTitle, $parser->mOptions, true, false);
		return $output->getText();
	}
}

?>