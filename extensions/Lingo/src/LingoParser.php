<?php

/**
 * File holding the LingoParser class.
 *
 * @author Stephan Gambke
 *
 * @file
 * @ingroup Lingo
 */
if ( !defined( 'LINGO_VERSION' ) ) {
	die( 'This file is part of the Lingo extension, it is not a valid entry point.' );
}

/**
 * This class parses the given text and enriches it with definitions for defined
 * terms.
 *
 * Contains a static function to initiate the parsing.
 *
 * @ingroup Lingo
 */
class LingoParser {

	private $mLingoTree = null;

	/**
	 * @var LingoBackend
	 */
	private $mLingoBackend = null;
	private static $parserSingleton = null;

	// The RegEx to split a chunk of text into words
	public static $regex = null;

	public function __construct( LingoMessageLog &$messages = null ) {
		global $wgexLingoBackend;

		$this->mLingoBackend = new $wgexLingoBackend( $messages );
	}

	private static function uniqPrefix( Parser &$parser) {
		if ( defined("Parser::MARKER_PREFIX" )) {
			return Parser::MARKER_PREFIX;
		} else {
			return $parser->uniqPrefix();
		}
	}

	/**
	 *
	 * @param Parser $parser
	 * @param string $text
	 * @return Boolean
	 */
	static function parse( Parser &$parser, &$text ) {
		wfProfileIn( __METHOD__ );
		if ( !self::$parserSingleton ) {
			self::$parserSingleton = new LingoParser();

			// The RegEx to split a chunk of text into words
			// Words are: placeholders for stripped items, sequences of letters and numbers, single characters that are neither letter nor number
			self::$regex = '/' . preg_quote( self::uniqPrefix($parser), '/' ) . '.*?' . preg_quote( Parser::MARKER_SUFFIX, '/' ) . '|[\p{L}\p{N}]+|[^\p{L}\p{N}]/u';
		}

		self::$parserSingleton->realParse( $parser, $text );

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 *
	 * @return LingoBackend the backend used by the parser
	 */
	public function getBackend() {
		return $this->mLingoBackend;
	}

	/**
	 * Returns the list of terms in the glossary
	 *
	 * @return Array an array mapping terms (keys) to descriptions (values)
	 */
	function getLingoArray() {
		wfProfileIn( __METHOD__ );

		// build glossary array only once per request
		if ( !$this->mLingoTree ) {
			$this->buildLingo();
		}

		wfProfileOut( __METHOD__ );

		return $this->mLingoTree->getTermList();
	}

	/**
	 * Returns the list of terms in the glossary as a LingoTree
	 *
	 * @return LingoTree a LingoTree mapping terms (keys) to descriptions (values)
	 */
	function getLingoTree() {
		wfProfileIn( __METHOD__ );

		// build glossary array only once per request
		if ( !$this->mLingoTree ) {

			// use cache if enabled
			if ( $this->mLingoBackend->useCache() ) {

				// Try cache first
				global $wgexLingoCacheType;
				$cache = ($wgexLingoCacheType !== null)?  wfGetCache( $wgexLingoCacheType ):wfGetMainCache();
				$cachekey = wfMemcKey( 'ext', 'lingo', 'lingotree' );
				$cachedLingoTree = $cache->get( $cachekey );

				// cache hit?
				if ( $cachedLingoTree !== false && $cachedLingoTree !== null ) {

					wfDebug( "Cache hit: Got lingo tree from cache.\n" );
					$this->mLingoTree = &$cachedLingoTree;

				} else {

					wfDebug( "Cache miss: Lingo tree not found in cache.\n" );
					$this->mLingoTree =& $this->buildLingo();
					$cache->set( $cachekey, $this->mLingoTree );
					wfDebug( "Cached lingo tree.\n" );
				}
			} else {
				wfDebug( "Caching of lingo tree disabled.\n" );
				$this->mLingoTree =& $this->buildLingo();
			}

		}

		wfProfileOut( __METHOD__ );

		return $this->mLingoTree;
	}

	protected function &buildLingo() {
		wfProfileIn( __METHOD__ );

		$lingoTree = new LingoTree();
		$backend = &$this->mLingoBackend;

		// assemble the result array
		while ( $elementData = $backend->next() ) {
			$lingoTree->addTerm( $elementData[LingoElement::ELEMENT_TERM], $elementData );
		}

		wfProfileOut( __METHOD__ );
		return $lingoTree;
	}

	/**
	 * Parses the given text and enriches applicable terms
	 *
	 * This method currently only recognizes terms consisting of max one word
	 *
	 * @param $parser
	 * @param $text
	 * @return Boolean
	 */
	protected function realParse( &$parser, &$text ) {
		global $wgRequest;

		wfProfileIn( __METHOD__ );

		$action = $wgRequest->getVal( 'action', 'view' );

		if ( $text === null ||
			$text === '' ||
			$action === 'edit' ||
			$action === 'ajax' ||
			isset( $_POST['wpPreview'] )
		) {

			wfProfileOut( __METHOD__ );
			return true;
		}

		// Get array of terms
		$glossary = $this->getLingoTree();

		if ( $glossary == null ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		// Parse HTML from page
		wfProfileIn( __METHOD__ . ' 1 loadHTML' );
		wfSuppressWarnings();

		$doc = new DOMDocument('1.0','utf-8');
		$doc->loadHTML( '<html><head><meta http-equiv="content-type" content="charset=utf-8"/></head><body>' . $text . '</body></html>' );

		wfRestoreWarnings();
		wfProfileOut( __METHOD__ . ' 1 loadHTML' );

		wfProfileIn( __METHOD__ . ' 2 xpath' );
		// Find all text in HTML.
		$xpath = new DOMXpath( $doc );
		$elements = $xpath->query(
				"//*[not(ancestor-or-self::*[@class='noglossary'] or ancestor-or-self::a or ancestor-or-self::script)][text()!=' ']/text()"
		);
		wfProfileOut( __METHOD__ . ' 2 xpath' );

		// Iterate all HTML text matches
		$nb = $elements->length;
		$changedDoc = false;

		for ( $pos = 0; $pos < $nb; $pos++ ) {
			$el = $elements->item( $pos );

			if ( strlen( $el->nodeValue ) < $glossary->getMinTermLength() ) {
				continue;
			}

			wfProfileIn( __METHOD__ . ' 3 lexer' );
			$matches = array();
			preg_match_all(
				self::$regex,
				$el->nodeValue,
				$matches,
				PREG_OFFSET_CAPTURE | PREG_PATTERN_ORDER
			);
			wfProfileOut( __METHOD__ . ' 3 lexer' );

			if ( count( $matches ) == 0 || count( $matches[0] ) == 0 ) {
				continue;
			}

			$lexemes = &$matches[0];
			$countLexemes = count( $lexemes );
			$parent = &$el->parentNode;
			$index = 0;
			$changedElem = false;

			while ( $index < $countLexemes ) {
				wfProfileIn( __METHOD__ . ' 4 findNextTerm' );
				list( $skipped, $used, $definition ) =
					$glossary->findNextTerm( $lexemes, $index, $countLexemes );
				wfProfileOut( __METHOD__ . ' 4 findNextTerm' );

				wfProfileIn( __METHOD__ . ' 5 insert' );
				if ( $used > 0 ) { // found a term
					if ( $skipped > 0 ) { // skipped some text, insert it as is
						$parent->insertBefore(
							$doc->createTextNode(
								substr( $el->nodeValue,
									$currLexIndex = $lexemes[$index][1],
									$lexemes[$index + $skipped][1] - $currLexIndex )
							),
							$el
						);
					}

					$parent->insertBefore( $definition->getFullDefinition( $doc ), $el );

					$changedElem = true;
				} else { // did not find term, just use the rest of the text
					// If we found no term now and no term before, there was no
					// term in the whole element. Might as well not change the
					// element at all.
					// Only change element if found term before
					if ( $changedElem ) {
						$parent->insertBefore(
							$doc->createTextNode(
								substr( $el->nodeValue, $lexemes[$index][1] )
							),
							$el
						);
					} else {
						wfProfileOut( __METHOD__ . ' 5 insert' );
						// In principle superfluous, the loop would run out
						// anyway. Might save a bit of time.
						break;
					}
				}
				wfProfileOut( __METHOD__ . ' 5 insert' );

				$index += $used + $skipped;
			}

			if ( $changedElem ) {
				$parent->removeChild( $el );
				$changedDoc = true;
			}
		}

		if ( $changedDoc ) {
			$this->loadModules( $parser );

			// U - Ungreedy, D - dollar matches only end of string, s - dot matches newlines
			$text = preg_replace( '%(^.*<body>)|(</body>.*$)%UDs', '', $doc->saveHTML() );
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	protected function loadModules( &$parser ) {
		global $wgOut, $wgScriptPath;

		$parserOutput = $parser->getOutput();

		// load scripts
		if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
			$parserOutput->addModules( 'ext.Lingo.Scripts' );

			if ( !$wgOut->isArticle() ) {
				$wgOut->addModules( 'ext.Lingo.Scripts' );
			}
		} else {
			global $wgStylePath;
			$parserOutput->addHeadItem( "<script src='$wgStylePath/common/jquery.min.js'></script>\n", 'ext.Lingo.jq' );
			$parserOutput->addHeadItem( "<script src='$wgScriptPath/extensions/Lingo/libs/Lingo.js'></script>\n", 'ext.Lingo.Scripts' );

			if ( !$wgOut->isArticle() ) {
				$wgOut->addHeadItem( 'ext.Lingo.jq', "<script src='$wgStylePath/common/jquery.min.js'></script>\n" );
				$wgOut->addHeadItem( 'ext.Lingo.Scripts', "<script src='$wgScriptPath/extensions/Lingo/libs/Lingo.js'></script>\n" );
			}
		}

		// load styles
		if ( method_exists( $parserOutput, 'addModuleStyles') ) {
			$parserOutput->addModuleStyles( 'ext.Lingo.Styles' );
			if ( !$wgOut->isArticle() ) {
				$wgOut->addModuleStyles( 'ext.Lingo.Styles' );
			}
		} else {
			$parserOutput->addHeadItem( "<link rel='stylesheet' href='$wgScriptPath/extensions/Lingo/styles/Lingo.css' />\n", 'ext.Lingo.Styles' );
			if ( !$wgOut->isArticle() ) {
				$wgOut->addHeadItem( 'ext.Lingo.Styles', "<link rel='stylesheet' href='$wgScriptPath/extensions/Lingo/styles/Lingo.css' />\n" );
			}
		}
	}

	/**
	 * Purges the lingo tree from the cache.
	 */
	public static function purgeCache () {

		global $wgexLingoCacheType;
		$cache = ($wgexLingoCacheType !== null)?  wfGetCache( $wgexLingoCacheType ):wfGetMainCache();
		$cache->delete( wfMemcKey( 'ext', 'lingo', 'lingotree' ) );

	}
}

