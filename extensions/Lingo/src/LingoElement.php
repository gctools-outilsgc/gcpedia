<?php

/**
 * File holding the LingoElement class.
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
 * This class represents a term-definition pair.
 * One term may be related to several definitions.
 *
 * @ingroup Lingo
 */
class LingoElement {
	const ELEMENT_TERM = 0;
	const ELEMENT_DEFINITION = 1;
	const ELEMENT_SOURCE = 2;
	const ELEMENT_LINK = 3;
	const ELEMENT_STYLE = 4;

	const ELEMENT_FIELDCOUNT = 5;  // number of fields stored for each element; (last field's index) + 1

	private $mFullDefinition = null;
	private $mDefinitions = array();
	private $mTerm = null;
	private $mHasBeenDisplayed = false;

	static private $mLinkTemplate = null;

	public function __construct( &$term, &$definition = null ) {

		$this->mTerm = $term;

		if ( $definition ) {
			$this->addDefinition( $definition );
		}
	}

	public function addDefinition( &$definition ) {
		$this->mDefinitions[] = array_pad( $definition, self::ELEMENT_FIELDCOUNT, null );
	}

	public function getFullDefinition( DOMDocument &$doc ) {

		global $wgexLingoDisplayOnce;

		wfProfileIn( __METHOD__ );

		// return textnode if
		if ( $wgexLingoDisplayOnce && $this->mHasBeenDisplayed ) {
			return $doc->createTextNode($this->mTerm);
		}

		// only create if not yet created
		if ( $this->mFullDefinition === null || $this->mFullDefinition->ownerDocument !== $doc ) {

			// if there is only one link available, just insert the link
			if ( count( $this->mDefinitions ) === 1
				&& !is_string( $this->mDefinitions[0][self::ELEMENT_DEFINITION] )
				&& is_string( $this->mDefinitions[0][self::ELEMENT_LINK] ) ) {

				$this->mFullDefinition = $this->getFullDefinitionAsLink( $doc );

			} else { // else insert the complete tooltip

				$this->mFullDefinition = $this->getFullDefinitionAsTooltip( $doc );
			}

			$this->mHasBeenDisplayed = true;
		}

		wfProfileOut( __METHOD__ );

		return $this->mFullDefinition->cloneNode( true );
	}

	public function getCurrentKey() {
		return key( $this->mDefinitions );
	}

	public function getTerm( $key ) {
		return $this->mDefinitions[$key][self::ELEMENT_TERM];
	}

	public function getSource( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_SOURCE];
	}

	public function getDefinition( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_DEFINITION];
	}

	public function getLink( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_LINK];
	}

	public function getStyle( &$key ) {
		return $this->mDefinitions[$key][self::ELEMENT_STYLE];
	}

	public function next() {
		next( $this->mDefinitions );
	}

	private function getLinkTemplate( DOMDocument &$doc ) {
		// create template if it does not yet exist
		if ( !self::$mLinkTemplate || ( self::$mLinkTemplate->ownerDocument !== $doc ) ) {
			global $wgScriptPath;

			$linkimage = $doc->createElement( 'img' );
			$linkimage->setAttribute( 'src', $wgScriptPath . '/extensions/Lingo/styles/linkicon.png' );

			self::$mLinkTemplate = $doc->createElement( 'a' );
			self::$mLinkTemplate->appendChild( $linkimage );
		}

		return self::$mLinkTemplate->cloneNode( true );
	}

	/**
	 * @param DOMDocument $doc
	 *
	 * @return DOMElement
	 * @throws MWException
	 */
	protected function getFullDefinitionAsLink( DOMDocument &$doc ) {

		// create Title object for target page
		$target = Title::newFromText( $this->mDefinitions[ 0 ][ self::ELEMENT_LINK ] );

		// create link element
		$link = $doc->createElement( 'a', $this->mDefinitions[ 0 ][ self::ELEMENT_TERM ] );

		// set the link target
		$link->setAttribute( 'href', $target->getLinkUrl() );
		$link = $this->addClassAttributeToLink( $target, $link );
		$link = $this->addTitleAttributeToLink( $target, $link );

		return $link;
	}

	/**
	 * @param DOMDocument $doc
	 *
	 * @return string
	 * @throws MWException
	 */
	protected function getFullDefinitionAsTooltip( DOMDocument &$doc ) {

		// Wrap term and definition in <span> tags
		$span = $doc->createElement( 'span' );
		$span->setAttribute( 'class', 'mw-lingo-tooltip ' . $this->mDefinitions[ 0 ][ self::ELEMENT_STYLE ] );

		// Wrap term in <span> tag, hidden
		wfSuppressWarnings();
		$spanTerm = $doc->createElement( 'span', htmlentities( $this->mTerm, ENT_COMPAT, 'UTF-8' ) );

		wfRestoreWarnings();
		$spanTerm->setAttribute( 'class', 'mw-lingo-tooltip-abbr' );

		// Wrap definition in a <span> tag
		$spanDefinition = $doc->createElement( 'span' );
		$spanDefinition->setAttribute( 'class', 'mw-lingo-tooltip-tip ' . $this->mDefinitions[ 0 ][ self::ELEMENT_STYLE ] );

		foreach ( $this->mDefinitions as $definition ) {
			wfSuppressWarnings();
			$element = $doc->createElement( 'span', htmlentities( $definition[ self::ELEMENT_DEFINITION ], ENT_COMPAT, 'UTF-8' ) );
			$element->setAttribute( 'class', 'mw-lingo-tooltip-definition ' . $this->mDefinitions[ 0 ][ self::ELEMENT_STYLE ] );
			wfRestoreWarnings();
			if ( $definition[ self::ELEMENT_LINK ] ) {
				$linkedTitle = Title::newFromText( $definition[ self::ELEMENT_LINK ] );
				if ( $linkedTitle ) {
					$link = $this->getLinkTemplate( $doc );
					$link->setAttribute( 'href', $linkedTitle->getFullURL() );
					$element->appendChild( $link );
				}
			}
			$spanDefinition->appendChild( $element );
		}

		// insert term and definition
		$span->appendChild( $spanTerm );
		$span->appendChild( $spanDefinition );
		return $span;
	}

	/**
	 * @param $target
	 * @param $link
	 */
	protected function &addTitleAttributeToLink( $target, &$link ) {

		if ( $target->getPrefixedText() === '' ) {
			// A link like [[#Foo]].  This used to mean an empty title
			// attribute, but that's silly.  Just don't output a title.
		} elseif ( $target->isKnown() ) {
			$link->setAttribute( 'title', $target->getPrefixedText() );
		} else {
			$link->setAttribute( 'title', wfMessage( 'red-link-title', $target->getPrefixedText() )->text() );
		}

		return $link;
	}

	/**
	 * @param $target
	 * @param $link
	 */
	protected function &addClassAttributeToLink( $target, &$link ) {

		// TODO: should this be more elaborate? See Linker::linkAttribs
		// Cleanest would probably be to use Linker::link and parse it
		// back into a DOMElement, but we are in a somewhat time-critical
		// part here.
		$classes = '';

		if ( !$target->isKnown() ) {
			$classes .= 'new ';
		}

		if ( $target->isExternal() ) {
			$classes .= 'extiw ';
		}

		// set style
		$classes .= $this->mDefinitions[ 0 ][ self::ELEMENT_STYLE ];

		if ( $classes !== '' ) {
			$link->setAttribute( 'class', $classes );
		}

		return $link;
	}

}
