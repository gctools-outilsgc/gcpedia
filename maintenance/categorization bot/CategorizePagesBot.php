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
$files = file( dirname( __FILE__ ) . "/fileList.final.txt", FILE_IGNORE_NEW_LINES);

$outlog = fopen( dirname( __FILE__ ) . '/CategorizationLog.txt', 'w' );    // log of deletion progress


// traverse file list and edit each file page, categorizing them
//echo "Start\n";
foreach ( $files as $fpage ){
	$old_content = $wiki->getpage( "File:" . $fpage );	// all file pages are in the file / image namespace
		
	$wiki->edit( "File:" . $fpage, $old_content ."\n[[Category:Orphaned file - fichier orphelin]]", "Bot edit: orphaned file marked for deletion" );
	fwrite( $outlog, $fpage . "   File categorized \r\n");
}

fwrite( $outlog, "\r\n Script running time: " . (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );

?>