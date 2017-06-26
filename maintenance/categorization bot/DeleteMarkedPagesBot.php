<?php

include( 'botclasses.php' );

// deletion request category name
$category = "marked_for_deletion";

// start time
$tstart = time();

$wiki      = new wikipedia;
$wiki->url = "http://127.0.0.1/gcwiki/api.php";


// bot login
$user = '';
$pass = '';
$wiki->login( $user, $pass );

$outlog = fopen( dirname( __FILE__ ) . '/DeleteMarkedPagesLog.txt', 'w' );    // log of deletion progress

$pages = $wiki->categorymembers($category);

// traverse file list and edit each file page, categorizing them
foreach ( $pages as $page ){
	$wiki->delete($page, "Deleted by bot on request");
	fwrite( $outlog, $page . "   Page Deleted \r\n");
}
echo "Done";
fwrite( $outlog, "\r\n Script running time: " . (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );

?>