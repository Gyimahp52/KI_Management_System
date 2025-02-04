<?php
function dbConnect() {
    // Load configuration from a separate file or environment variables
    $config = require_once 'config.php';

if (!$config || !is_array($config)) {
    // Debug output
    echo "Configuration file not found or invalid.";
    var_dump($config); // This will display what the file returns
    exit; // Stop script execution
}

    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset={$config['db_charset']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => true, // Enable connection pooling
    ];

    try {
        return new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
    } catch (PDOException $e) {
        // Log the error
        error_log("Database connection failed: " . $e->getMessage());
        
        // Display a user-friendly message
        die("Sorry, there was a problem connecting to the database. Please try again later.");
    }
}