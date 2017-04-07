<?php

class RaswHooks {
	
	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		$out->addModules( 'ext.rasw' );
	}
	
	public static function onParserFirstCallInit(Parser &$parser) {
	
		$parser->setHook( 'RASW', array( __CLASS__, 'renderRasw' ) );
	
		return true;
	}

	function renderRasw( $input, $argv, $parser ) {
		# The parser function itself
		# The input parameters are wikitext with templates expanded
		# The output should be wikitext too
		//$output = "Parser Output goes here.";
	
		//$favParse = new FavParser();
		//$output = $favParse->wfSpecialFavoritelist( $argv, $parser );
		//$parser->disableCache();
		$output = <<<FIN
<div class="recentactivity">
   <div class="elgg-ajax-loader"></div>
   <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
   <div class="viewport">
      <div class="overview">
      </div>
   </div>
</div>
FIN;
		return $output;
	}
}
