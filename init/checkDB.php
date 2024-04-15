<?php

// Environment variables from docker-compose
$dbhost = getenv('DBHOST') ?: 'gcpedia-db';
$dbuser = getenv('DBUSER') ?: 'wiki';
$dbpass = getenv('DBPASS') ?: 'gcpedia';
// Database name is the first argument, or empty
$dbname = isset($argv[1]) ? $argv[1] : '';

$tableToCheck = isset($argv[2]) ? $argv[2] : 'categorylinks';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable exception throwing

try {
    // Establish connection based on whether a database name was provided
    $connection = empty($dbname) ? mysqli_connect($dbhost, $dbuser, $dbpass) : mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Check the connection
    if (!$connection) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    if (!empty($dbname)) {
        // Check if the specified table exists
        $query = "SHOW TABLES LIKE '$tableToCheck'";
        $result = $connection->query($query);

        if ($result->num_rows < 1) {
            throw new Exception("Table $tableToCheck does not exist.");
        } else {
            echo "Table $tableToCheck exists.\n";
        }
    } else {
        echo "Connected to MySQL server successfully.\n";
    }
    
    // Close the connection
    mysqli_close($connection);
    exit(0);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>