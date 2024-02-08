<?php

// Environment variables from docker-compose
$dbhost = getenv('DBHOST') ?: 'gcpedia-db';
$dbname = getenv('DBNAME') ?: 'wiki';
$dbuser = getenv('DBUSER') ?: 'wiki';
$dbpass = getenv('DBPASS') ?: 'gcpedia';
// No need for $dbtype since we're specifically using mysqli here

// Attempt to connect to the database using mysqli
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if ($connection) {
    echo "MariaDB/MySQL server is reachable and accepting connections.\n";
    mysqli_close($connection);
    exit(0); // success exit code
} else {
    // mysqli_connect_error() gets the last connection error message
    echo "Connection failed: " . mysqli_connect_error() . "\n";
    exit(1); // error exit code
}
?>