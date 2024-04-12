<?php

// Environment variables from docker-compose
$dbhost = getenv('DBHOST') ?: 'gcpedia-db';
$dbuser = getenv('DBUSER') ?: 'wiki';
$dbpass = getenv('DBPASS') ?: 'gcpedia';
// db is first argument, or nothing
$dbname = $argv[1] ?: '';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable exception throwing

try {
    if (empty($dbname)) {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass);
    } else {
        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    }
    mysqli_close($connection);
    exit(0);
} catch (mysqli_sql_exception $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>