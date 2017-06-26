<?php

include( 'botclasses.php' );

// start time
$tstart = time();

$wiki      = new wikipedia;
$wiki->url = "http://127.0.0.1/gcwiki/api.php";


// bot login
$user = '';
$pass = '';
$wiki->login( $user, $pass );

// load file list into array
$files = file( dirname( __FILE__ ) . "/testList.txt", FILE_IGNORE_NEW_LINES);

$outlog = fopen( dirname( __FILE__ ) . '/testLog.txt', 'w' );    // log of deletion progress


// traverse file list and edit each file page, categorizing them
foreach ( $files as $fpage ){
	$old_content = $wiki->getpage( $fpage );	// all file pages are in the file / image namespace
		
	$wiki->edit( $fpage, $old_content ."Testing new GCpedia bot\n[[Category:Bot_Edited]]", " Bot edit: testing" );
	fwrite( $outlog, $fpage . "   page edited \r\n");
}

fwrite( $outlog, "\r\n Script running time: " . (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );

?>