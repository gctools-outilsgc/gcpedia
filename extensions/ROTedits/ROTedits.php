<?php
/**
 *
 *  GCPEDIA ROT Edit count extension
 *
 */

$wgHooks['ParserBeforeInternalParse'][] = 'rot';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ROTeditsSchemaUpdates';

function rot( &$parser, &$text, &$strip_state )
{
	global $wgTitle;
	
	if ( substr( $wgTitle, 0, 5 ) == "User:" ){
		getROTCount( getUName( substr( $wgTitle, 5, strlen($wgTitle) ) ), $text );
	}
	else if ( substr( $wgTitle, 0, 10 ) == "User talk:" ){
		getROTCount( getUName( substr( $wgTitle, 10, strlen($wgTitle) ) ), $text );
	}

	return true;

}

function getROTCount( $username, &$text )
{
	$user =  User::newFromName( $username );
	
	// check if this is a real user
	if ( !$user )
		return true;

	$total = $user->getEditCount();
	
	$dbr = wfGetDB( DB_SLAVE );
	$queryString = "SELECT * FROM `rotusers` WHERE `user_name` = \"".$username ."\"";
	$result = $dbr->query($queryString);
	$row = $dbr->fetchRow($result);
	
	if ( $row[0] != $username ){	// user not in rot db
		str_replace( "<ROTedits>", "<ROTedits>", $text, $countreplace );		// only for the count
		str_replace( "<ROTparticipant>", "<ROTparticipant>", $text, $countreplace2 );
		if ( $countreplace + $countreplace2 > 0 ) {
			$queryString2 = "INSERT INTO `rotusers` (user_name, start_editcount) VALUES ( '".$username ."', " . $total . ")";
			$dbr->query($queryString2);
			$result = $dbr->query($queryString);
		}
	}
	
	$rotstart = $row[1];
	
	$rotcount = $total - $rotstart;
	$text = str_replace( "<ROTedits>", $rotcount, $text );
	$text = str_replace( "<ROTparticipant>", "", $text );
	
	// Add stats table tag <ROTstats>
	str_replace( "<ROTstats>", "<ROTstats>", $text, $countreplace );		// only for the count
	if ( $countreplace > 0 ) {
		$querystr = 'SELECT`rotusers`.`user_name` , (`user`.`user_editcount`-`rotusers`.`start_editcount`) AS "ROTedits" FROM`rotusers` LEFT JOIN`user` ON`rotusers`.`user_name`=`user`.`user_name`';
		$dbr->query($querystr);
		$result = $dbr->query($querystr);
		
		$table = "{|border='3px' style='text-align:center;' \n";
		$table .= "!ROT User \n!ROT Edits\n";
		$sum = 0;
		foreach ( $result as $rotusr ){
			$table = $table . "|- \n";
			$table = $table . "|". $rotusr->user_name ." \n";
			$table = $table . "|". $rotusr->ROTedits ." \n";
			$sum = $sum + $rotusr->ROTedits;
		}
		$table = $table . "|- \n";
		$table = $table . "!Total \n";
		$table = $table . "!". $sum ." \n";
		$table = $table . "|}";
		
		$text = str_replace( "<ROTstats>", $table, $text, $countreplace );
	}
	
}

function ROTeditsSchemaUpdates( $updater = null ) {
	if ( $updater === null ) { // <= 1.16 support
		global $wgExtNewTables, $wgExtModifiedFields;
		$wgExtNewTables[] = array(
				'rotusers',
				dirname( __FILE__ ) . '/ROTedits.sql'
		);
	} else { // >= 1.17 support
		$db = $updater->getDB();

		$updater->addExtensionUpdate( array( 'addTable', 'rotusers',
				dirname( __FILE__ ) . '/ROTedits.sql', true ) );
	}
	return true;
}

/**
 * Uses the title of the page (excluding namespace) to return the username of the user who's awards should be displayed
 */
/*function getUName( $pagename )
{
	$name = $pagename;
	$pos;
	
	$pos = strripos( $pagename, "/" );
	
	if ( $pos )
		$name = substr( $pagename, 0, $pos );
	
	
	return $name;
}*/

?>