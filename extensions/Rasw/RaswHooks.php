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
		$category = $argv['category'];
		$param='';
		if ($category) {
			$param="<div class='rasw-param' id='".$category."'></div>";
		}
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
		return $param.$output;
	}
}
