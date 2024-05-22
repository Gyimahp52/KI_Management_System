<?php
// Database configuration
$servername = "localhost";
$username = "yaw"; // default username for localhost is root
$password = ""; // default password for localhost is empty
$dbName = "student_reports"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $password, $user_type);

// Set parameters and execute
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
$user_type = $_POST['user_type'];

if ($stmt->execute()) {
  echo "New record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
