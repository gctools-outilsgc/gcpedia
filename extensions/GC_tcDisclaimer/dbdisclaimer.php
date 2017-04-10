<?php
/**
 *
 * Adds necessary table to the database
 *
 */




$dbr = wfGetDB( DB_SLAVE );

$queryString = "CREATE TABLE IF NOT EXISTS accepted (Username varchar(100), date varchar(10))	";

//$query = "Select count(*) from `accept` where Username = 'test'";

$result = $dbr->query($queryString);


/*
$query = "INSERT INTO `accepted` (Username) VALUES ('Ilia.Salem')";

$result = $dbr->doQuery($query);

*/







?>