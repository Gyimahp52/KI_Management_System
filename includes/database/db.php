<?php
$dbHost = 'localhost';
$dbUsername = 'root'; // Make sure this is correctly filled
$dbPassword = ''; // Make sure this is correctly filled. If there's no password, you can leave it as an empty string, but it's highly recommended to secure your database with a password.
$dbName = 'ki_database';

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo"connected";

?>
