<?php
/**
 *
 *  GCPEDIA Edit count milestone awards module
 *
 */

use MediaWiki\MediaWikiServices;

$wgHooks['ParserBeforeInternalParse'][] = 'award';

// medal templates
$medal[1] = "{{Novice contributor}}";
$medal[2] = "{{Apprentice contributor}}";
$medal[3] = "{{Journeyman contributor}}";
$medal[4] = "{{Yeoman contributor}}";
$medal[5] = "{{Experienced contributor}}";
$medal[6] = "{{Veteran contributor I}}";
$medal[7] = "{{Veteran contributor II}}";
$medal[8] = "{{Veteran contributor III}}";
$medal[9] = "{{Veteran contributor IV}}";
$medal[10] = "{{Senior contributor I}}";
$medal[11] = "{{Senior contributor II}}";
$medal[12] = "{{Senior contributor III}}";
$medal[13] = "{{Master contributor I}}";
$medal[14] = "{{Master contributor II}}";
$medal[15] = "{{Sovereign contributor}}";
$medal[16] = "{{Ultimate contributor}}";
$medal[17] = "{{Vanguard contributor}}";

// gnomejutsu templates
$gnomejutsu[1] = "{{Red belt}}";
$gnomejutsu[2] = "{{White belt}}";
$gnomejutsu[3] = "{{Yellow belt}}";
$gnomejutsu[4] = "{{Orange belt}}";
$gnomejutsu[5] = "{{Green belt}}";
$gnomejutsu[6] = "{{Blue and white belt}}";
$gnomejutsu[7] = "{{Blue belt}}";
$gnomejutsu[8] = "{{Purple belt}}";
$gnomejutsu[9] = "{{Brown and white belt}}";
$gnomejutsu[10] = "{{Brown belt}}";
$gnomejutsu[11] = "{{1st dan black belt}}";
$gnomejutsu[12] = "{{2nd dan black belt}}";
$gnomejutsu[13] = "{{3rd dan black belt}}";
$gnomejutsu[14] = "{{4th dan black belt}}";
$gnomejutsu[15] = "{{5th dan black belt}}";
$gnomejutsu[16] = "{{6th dan black belt}}";
$gnomejutsu[17] = "{{7th dan black belt}}";

// medal userbox templates
$medalbox[1] = "{{Novice contributor userbox}}";
$medalbox[2] = "{{Apprentice contributor userbox}} ";
$medalbox[3] = "{{Journeyman contributor userbox}} ";
$medalbox[4] = "{{Yeoman contributor userbox}}";
$medalbox[5] = "{{Experienced contributor userbox}}";
$medalbox[6] = "{{Veteran contributor I userbox}}";
$medalbox[7] = "{{Veteran contributor II userbox}}";
$medalbox[8] = "{{Veteran contributor III userbox}}";
$medalbox[9] = "{{Veteran contributor IV userbox}}";
$medalbox[10] = "{{Senior contributor I userbox}}";
$medalbox[11] = "{{Senior contributor II userbox}}";
$medalbox[12] = "{{Senior contributor III userbox}}";
$medalbox[13] = "{{Master contributor I userbox}}";
$medalbox[14] = "{{Master contributor II userbox}}";
$medalbox[15] = "{{Sovereign contributor userbox}}";
$medalbox[16] = "{{Ultimate contributor userbox}}";
$medalbox[17] = "{{Vanguard contributor userbox}}";

// badge userbox templates
$badgebox[1] = "{{Red belt userbox}}";
$badgebox[2] = "{{White belt userbox}}";
$badgebox[3] = "{{Yellow belt userbox}}";
$badgebox[4] = "{{Orange belt userbox}}";
$badgebox[5] = "{{Green belt userbox}}";
$badgebox[6] = "{{Blue and white belt userbox}}";
$badgebox[7] = "{{Blue belt userbox}}";
$badgebox[8] = "{{Purple belt userbox}}";
$badgebox[9] = "{{Brown and white belt userbox}}";
$badgebox[10] = "{{Brown belt userbox}}";
$badgebox[11] = "{{1nd dan black belt userbox}}";
$badgebox[12] = "{{2nd dan black belt userbox}}";
$badgebox[13] = "{{3nd dan black belt userbox}}";
$badgebox[14] = "{{4nd dan black belt userbox}}";
$badgebox[15] = "{{5nd dan black belt userbox}}";
$badgebox[16] = "{{6nd dan black belt userbox}}";
$badgebox[17] = "{{7nd dan black belt userbox}}";

function award( &$parser, &$text, &$strip_state )
{
	global $wgTitle;
	global $wgLang;
	global $wgOut;

	if ( substr( $wgTitle, 0, 5 ) == "User:" ){
		
		generateAwards( getUName( substr( $wgTitle, 5, strlen($wgTitle) ) ), $text );
		
	}
	else if ( substr( $wgTitle, 0, 10 ) == "User talk:" ){
		
		generateAwards( getUName( substr( $wgTitle, 10, strlen($wgTitle) ) ), $text );
		
	}
	
	return true;
	
}


function generateAwards( $usename, &$text )
{
	$acode = "<awards>";
	$awoptions;
	global $medal;
	global $gnomejutsu;
	global $medalbox;
	global $badgebox;


	$awoptions['test'] = 'testing';
	
	$dbProvider = MediaWikiServices::getInstance()->getDBLoadBalancerFactory();
	$dbr = $dbProvider->getReplicaDatabase();
	$result = $dbr->newSelectQueryBuilder()
				->select( ['user_editcount'] )
				->from( 'user' )
				->where( [ 'user_name' => $usename ] )
				->caller( __METHOD__ )->fetchRow();;
	

	// Make sure user exists and has edits.
	if( $result != false && $result->user_editcount != 0 ){
		
		$editcount = $result->user_editcount;
		
		// Medals
		$text = str_ireplace( $acode, $medal[calculateAwards( $usename, $editcount, $awoptions )], $text );
		$text = str_ireplace( "<prix>", $medal[calculateAwards( $usename, $editcount, $awoptions )], $text );

		// Gnomejutsu
		$text = str_ireplace( "<gnomejutsu>", $gnomejutsu[calculateAwards( $usename, $editcount, $awoptions )], $text );

		// Medal userboxes
		$text = str_ireplace( "<awards-ub>", $medalbox[calculateAwards( $usename, $editcount, $awoptions )], $text );
		//$text = str_ireplace( "<awards-ub>", "lol, dan was here", $text );
		$text = str_ireplace( "<prix-ub>", $medalbox[calculateAwards( $usename, $editcount, $awoptions )], $text );

		// Gnomejutsu / badge user boxes
		$text = str_ireplace( "<gnomejutsu-ub>", $badgebox[calculateAwards( $usename, $editcount, $awoptions )], $text );
	}
}

/**
 * Uses the title of the page (excluding namespace) to return the username of the user who's awards should be displayed
 */
function getUName( $pagename )
{
	$name = $pagename;
	$pos;
	
	$pos = strpos( $pagename, "/" );
	
	if ( $pos )
		$name = substr( $pagename, 0, $pos );
	
	
	return $name;
}

function calculateAwards( $usename, $editcount, $awoptions )
{
	$GCP = 0;		//GCPEDIA Contribution Points
	$GCPLevel;
	$ptnl;
	
	$bonus = getBonus( $editcount );
	
	if ( $editcount > 0 )
		$GCP = 50 + $editcount * 5 + $bonus;
	
	$GCPLevel = getGCPLevel( $GCP );
	
	return $GCPLevel;
	
}

function getBonus( $editc )
{
	$bonus = 0;
	
	if ( $editc >= 5 )
		$bonus += 6;
	if ( $editc >= 25 )
		$bonus += 30;
	if ( $editc >= 125 )
		$bonus += 150;
	if ( $editc >= 500 )
		$bonus += 600;
	if ( $editc >= 1000 )
		$bonus += 1200;
	if ( $editc >= 2500 )
		$bonus += 3000;
	if ( $editc >= 5000 )
		$bonus += 6000;
	if ( $editc >= 10000 )
		$bonus += 12000;
	if ( $editc >= 20000 )
		$bonus += 24000;
	if ( $editc >= 25000 )
		$bonus += 30000;
	if ( $editc >= 35000 )
		$bonus += 42000;
	if ( $editc >= 50000 )
		$bonus += 60000;
	if ( $editc >= 75000 )
		$bonus += 90000;
	if ( $editc >= 100000 )
		$bonus += 120000;
	if ( $editc >= 250000 )
		$bonus += 300000;
	if ( $editc >= 500000 )
		$bonus += 600000;
	if ( $editc >= 1000000 )
		$bonus += 1200000;
	
	return $bonus;
}


function getGCPLevel( $GCP )
{

	$GCPLevel = 0;
	
	if ( $GCP >= 5 * 8 )
		$GCPLevel++;
	if ( $GCP >= 25 * 8 )
		$GCPLevel++;
	if ( $GCP >= 125 * 8 )
		$GCPLevel++;
	if ( $GCP >= 500 * 8 )
		$GCPLevel++;
	if ( $GCP >= 1000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 2500 * 8 )
		$GCPLevel++;
	if ( $GCP >= 5000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 10000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 20000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 25000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 35000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 50000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 75000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 100000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 250000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 500000 * 8 )
		$GCPLevel++;
	if ( $GCP >= 1000000 * 8 )
		$GCPLevel++;
	
	return $GCPLevel;
}


?>