<?php

// environment variables from docker-compose
$dbhost = (getenv('DBHOST') != '') ? getenv('DBHOST') : 'gcpedia-db';
$dbname = (getenv('DBNAME') != '') ? getenv('DBNAME') : 'wiki';
$dbuser = (getenv('DBUSER') != '') ? getenv('DBUSER') : 'wiki';
$dbpass = (getenv('DBPASS') != '') ? getenv('DBPASS') : 'gcpedia';
$dbtype = (getenv('DBTYPE') != '') ? getenv('DBTYPE') : 'mysql';

$dsn = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    echo "MariaDB server is reachable and accepting connections.\n";
    exit(0); // success exit code
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
    exit(1); // error exit code
}
?>