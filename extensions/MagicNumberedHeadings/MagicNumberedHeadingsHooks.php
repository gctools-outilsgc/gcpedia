<?php

class MagicNumberedHeadingsHooks {
	public static function onGetDoubleUnderscoreIDs( &$ids ) {
		$ids[] = 'MAG_NUMBEREDHEADINGS';
	}

	public static function onParserAfterParse( Parser $parser, &$text, StripState $stripState ) {
		if ( $parser->getOutput()->getPageProperty( 'MAG_NUMBEREDHEADINGS' ) !== null ) {
			$parser->getOutput()->addModules( ['ext.magicnumberedheadings'] );
		}
	}
}
