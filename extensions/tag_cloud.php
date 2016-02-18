<?php
/**
 * Wiki Category Tag Cloud
 * @file
 * @ingroup Extensions
 * @author Daniel Friesen http://daniel.friesen.name
 * @version 1.1
 *
 * Derived from: YetAnotherTagCloud http://orangedino.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is an extension to the MediaWiki package and cannot be run standalone." );
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Wiki Category Tag Cloud',
	'version' => '1.1',
	'author' => '[http://mediawiki.org/wiki/User:Dantman Daniel Friesen]',
	'description' => 'A Category Tag Cloud derived, improved, and fixed from the YetAnotherTagCloud Extension',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiCategoryTagCloud',
);

// Avoid unstubbing $wgParser too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'registerTagCloudExtension';

// Hooked function
$wgHooks['ArticleSave'][] = 'invalidateCache';

function registerTagCloudExtension( &$parser ) {
	$parser->setHook( 'tagcloud', 'renderTagCloud' );
	return true;
}

function invalidateCache( &$article, &$user, &$text, &$summary, $minor, $watchthis, $sectionanchor, &$flags, &$status ) {
	$message = wfMessage( 'tagcloudpages' )->inContentLanguage();

	// If it's empty, do nothing.
	if ( $message->isDisabled() ) {
		return true;
	}

	$titles = explode( "\n", $message->plain() );

	for ( $i = 0; $i < count( $titles ); $i++ ) {
		$t = Title::newFromText( $titles[$i] );
		if( $t ) {
			$t->invalidateCache();
		}
	}

	return true;
}

function renderTagCloud( $input, $params, $parser ) {
	$MIN_SIZE = 77;
	$INCREASE_FACTOR = 100;

	$dbr = wfGetDB( DB_SLAVE );

	$params += array(
		'style' => '',
		'class' => '',
		'linkstyle' => '',
		'linkclass' => '',
	);
	$min_count_input = getBoxExtensionOption( $input, 'min_count' );
	$min_size_input = getBoxExtensionOption( $input, 'min_size' );
	$increase_factor_input = getBoxExtensionOption( $input, 'increase_factor' );
	if ( $min_size_input != null ) {
		$MIN_SIZE = $min_size_input;
	}
	if ( $increase_factor_input != null ) {
		$INCREASE_FACTOR = $increase_factor_input;
	}
	if ( $min_count_input == null ) {
		$min_count_input = 0;
	}

	$excluded_input = getBoxExtensionOption( $input, 'exclude' );

	$exclude_condition = '';
	if ( strlen( $excluded_input ) > 0 ) {
		$excluded_categories = explode( ',', $excluded_input );
		if ( count( $excluded_categories ) > 0 ) {
			$exclude_condition = ' WHERE cl_to NOT IN (';
			for ( $i = 0; $i < count( $excluded_categories ); $i++ ) {
				$exclude_condition = $exclude_condition . "'" . trim( $excluded_categories[$i] ) . "'";
				if ( $i < count( $excluded_categories ) - 1 ) {
					$exclude_condition = $exclude_condition . ',';
				}
			}
			$exclude_condition = $exclude_condition . ')';
		}
	}

	$sql = "SELECT cl_to AS title, COUNT(*) AS count FROM {$dbr->tableName( 'categorylinks' )} " .
		$exclude_condition . " GROUP BY cl_to HAVING COUNT(*) >= $min_count_input ORDER BY cl_to ASC";

	$res = $dbr->query( $sql, __METHOD__ );
	$count = $dbr->numRows( $res );

	$htmlOut = '';
	$htmlOut .= '<div class="tagcloud '.$params['class'].'" style="'.$params['style'].'">';

	$min = 1000000;
	$max = - 1;

	for ( $i = 0; $i < $count; $i++ ) {
		$obj = $dbr->fetchObject( $res );
		$tags[$i][0] = $obj->title;
		$tags[$i][1] = $obj->count;
		if ( $obj->count < $min ) {
			$min = $obj->count;
		}
		if ( $obj->count > $max ) {
			$max = $obj->count;
		}
	}

	for ( $i = 0; $i < $count; $i++ ) {
		$textSize = $MIN_SIZE + ( $INCREASE_FACTOR * ( $tags[$i][1] ) ) / ( $max );
		$title = Title::makeTitle( NS_CATEGORY, $tags[$i][0] );
		$style = 'font-size: '.$textSize.'%; '.$params['linkstyle'];
		$currentRow = '<a class="' . $params['linkclass'] .
			'" style="' . $style . '" href="' . $title->getLocalURL() . '">' .
			$title->getText() . '</a>&#160; ';
		$htmlOut = $htmlOut . $currentRow;
	}
	$htmlOut = $htmlOut . '</div>';
	return $htmlOut;
}

function getBoxExtensionOption( $input, $name, $isNumber = false ) {
	if ( preg_match( "/^\s*$name\s*=\s*(.*)/mi", $input, $matches ) ) {
		if ( $isNumber ) {
			return intval( $matches[1] );
		} else {
			return htmlspecialchars( $matches[1] );
		}
	}
}
