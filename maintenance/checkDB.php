<?php

// Environment variables from docker-compose
$dbhost = getenv('DBHOST') ?: 'gcpedia-db';
$dbname = getenv('DBNAME') ?: 'wiki';
$dbuser = getenv('DBUSER') ?: 'wiki';
$dbpass = getenv('DBPASS') ?: 'gcpedia';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable exception throwing

try {
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    echo "MariaDB/MySQL server is reachable and accepting connections.\n";
    mysqli_close($connection);
    exit(0); // success exit code
} catch (mysqli_sql_exception $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1); // error exit code
}
?>
