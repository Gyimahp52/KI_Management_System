<?php
// login.php
//session_start();
//header('Location: /login/login.html');

//$dbHost = 'localhost';
//$dbUsername = 'root'; // Make sure this is correctly filled
//$dbPassword = ''; // Make sure this is correctly filled. If there's no password, you can leave it as an empty string, but it's highly recommended to secure your database with a password.
//$dbName = 'ki_database';

// Create connection
//$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
//if ($conn->connect_error) { 
 //   die("Connection failed: " . $conn->connect_error);
//}
//echo"connected";


//$username = $_POST['username'];
//$password = $_POST['password'];

// Assuming the `password` column in your database stores hashed passwords
//$sql = "SELECT id, username, role, photo_url, password FROM users WHERE username=? LIMIT 1";
//$stmt = $conn->prepare($sql);
//$stmt->bind_param("s", $username);
//$stmt->execute();
//$result = $stmt->get_result();

//if ($row = $result->fetch_assoc()) {
//    if (password_verify($password, $row['password'])) {
        // Password is correct
//        $_SESSION['username'] = $row['username'];
 //       $_SESSION['role'] = $row['role'];
 //       $_SESSION['photo_url'] = $row['photo_url'];
 //       echo json_encode(['success' => true, 'role' => $row['role']]);
//    } else {
        // Invalid password
 //       echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
 //   }
//} else {
    // Username not found
  //  echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
//}

//$conn->close();



