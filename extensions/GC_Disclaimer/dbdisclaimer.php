<?php
/**
 *
 * Adds necessary table to the database
 *
 */

$dbr = wfGetDB( DB_SLAVE );

$queryString = "CREATE TABLE IF NOT EXISTS accepted (Username varchar(100), date varchar(10))	";
$result = $dbr->query($queryString);

?>