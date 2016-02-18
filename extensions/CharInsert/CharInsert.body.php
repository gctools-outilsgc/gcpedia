<?php

class CharInsert {
	public static function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'charinsert', 'CharInsert::charInsertHook' );
		return true;
	}

	public static function charInsertHook( $data, $params, Parser $parser ) {
		$data = $parser->mStripState->unstripBoth( $data );
		return implode( "<br />\n",
			array_map( 'CharInsert::charInsertLine',
				explode( "\n", trim( $data ) ) ) );
	}
	public static function charInsertLine( $data ) {
		return implode( "\n",
			array_map( 'CharInsert::charInsertItem',
				preg_split( '/\\s+/', self::charInsertArmor( $data ) ) ) );
	}

	public static function charInsertArmor( $data ) {
		return preg_replace_callback(
			'!<nowiki>(.*?)</nowiki>!i',
			'CharInsert::charInsertNowiki',
			$data );
	}

	public static function charInsertNowiki( $matches ) {
		return str_replace(
			array( '\t', '\r', ' ' ),
			array( '&#9;', '&#12;', '&#32;' ),
			$matches[1] );
	}

	public static function charInsertItem( $data ) {
		$chars = explode( '+', $data );
		if ( count( $chars ) > 1 && $chars[0] !== '' ) {
			return self::charInsertChar( $chars[0], $chars[1] );
		} elseif ( count( $chars ) == 1 ) {
			return self::charInsertChar( $chars[0] );
		} else {
			return self::charInsertChar( '+' );
		}
	}

	public static function charInsertChar( $start, $end = '' ) {
		$estart = self::charInsertJsString( $start );
		$eend = self::charInsertJsString( $end   );
		if ( $eend == '' ) {
			$inline = self::charInsertDisplay( $start );
		} else {
			$inline = self::charInsertDisplay( $start . $end );
		}
		return Xml::element( 'a',
			array(
				'onclick' => "insertTags('$estart','$eend','');return false",
				'href'    => "javascript:void()" ),
			$inline );
	}

	public static function charInsertJsString( $text ) {
		return strtr(
			self::charInsertDisplay( $text ),
			array(
				"\\"   => "\\\\",
				"\""   => "\\\"",
				"'"    => "\\'",
				"\r\n" => "\\n",
				"\r"   => "\\n",
				"\n"   => "\\n",
			) );
	}

	public static function charInsertDisplay( $text ) {
		static $invisibles = array(     '&nbsp;',     '&#160;' );
		static $visibles   = array( '&amp;nbsp;', '&amp;#160;' );
		return Sanitizer::decodeCharReferences(
			str_replace( $invisibles, $visibles, $text ) );
	}

}
