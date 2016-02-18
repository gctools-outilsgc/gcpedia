<?php

/**
 * File holding the LingoHooks class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup Lingo
 */
if ( !defined( 'LINGO_VERSION' ) ) {
	die( 'This file is part of the Lingo extension, it is not a valid entry point.' );
}

/**
 * The LingoHooks class.
 * 
 * It contains the hook handlers of the extension
 *
 * @ingroup Lingo
 */
class LingoHooks {

	/**
	 * Hooks into ParserAfterParse.
	 * 
	 * @param Parser $parser
	 * @param String $text
	 * @return Boolean 
	 */
	static function parse( &$parser, &$text ) {

		global $wgexLingoUseNamespaces;

		$title = $parser->getTitle();

		// parse if
		if ( !isset( $parser->mDoubleUnderscores['noglossary'] ) && // __NOGLOSSARY__ not present and
			(
			!$title || // title not set or
			!isset( $wgexLingoUseNamespaces[ $title->getNamespace() ] ) || // namespace not explicitly forbidden (i.e. not in list of namespaces and set to false) or
			$wgexLingoUseNamespaces[$title->getNamespace()] // namespace explicitly allowed
			)
		) {

			// unstrip strip items of the 'general' group
			// this will be done again by parse when this hook returns, but it should not hurt to do this twice
			// Only problem is with other hook handlers that might not expect strip items to be unstripped already
			$text = $parser->mStripState->unstripGeneral( $text );
			LingoParser::parse( $parser, $text );
		}

		return true;
	}

	/**
	 * Deferred setting of description in extension credits
	 *
	 * Setting of description in extension credits has to be deferred to the
	 * SpecialVersionExtensionTypes hook as it uses variable $wgexLingoPage (which
	 * might be set only after inclusion of the extension in LocalSettings) and
	 * function wfMessage not available before.
	 *
	 * @param array $extensionTypes
	 * @return Boolean Always true.
	 */
	static function setCredits( &$extensionTypes ) {

		global $wgExtensionCredits, $wgexLingoPage;
		$wgExtensionCredits['parserhook']['lingo']['description'] =
			wfMessage( 'lingo-desc', $wgexLingoPage ? $wgexLingoPage : wfMessage( 'lingo-terminologypagename' )->inContentLanguage()->text() )->text();

		return true;
	}

	/**
	 * Creates tag hook(s)
	 */
	public static function registerTags(Parser $parser) {
		$parser->setHook( 'noglossary',  'LingoHooks::noglossaryTagRenderer');
		return true;
	}

	/**
	 * Sets hook on 'noglossary' tag
	 * @static
	 * @param $input
	 * @param array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @return string
	 */
	public static function noglossaryTagRenderer( $input, array $args, Parser $parser, PPFrame $frame ) {
		$output = $parser->recursiveTagParse( $input, $frame );
		return '<span class="noglossary">'.$output.'</span>';
	}
}

