<?php

include( 'botclasses.php' );

// deletion request category name
$input_file = "/deletelist.final.txt";

// start time
$tstart = time();

$wiki      = new wikipedia;
$wiki->url = "http://127.0.0.1/gcwiki/api.php";


// bot login
$user = '';
$pass = '';
$wiki->login( $user, $pass );

$inlines = file( dirname( __FILE__ ) . $input_file, FILE_IGNORE_NEW_LINES);        // read filename lines into an array
$outlog = fopen( dirname( __FILE__ ) . '/DeleteUnusedFilesPagesLog.txt', 'w' );    // log of deletion progress


// traverse file list and edit each file page, categorizing them
foreach ( $pages as $page ){
	$wiki->delete("File:".$page, "Deleted unused file by bot");
	fwrite( $outlog, $page . "   Page Deleted \r\n");
}
echo "Done";
fwrite( $outlog, "\r\n Script running time: " . (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );

?>