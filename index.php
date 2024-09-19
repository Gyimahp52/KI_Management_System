<?php
session_start();
require 'includes/dbconnection.php'; 

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Login function that handles both username for students and email for others
function login($usernameOrEmail, $password) {
    $pdo = dbConnect();
    
    // Step 1: Check if the user exists as a student (username login) or as a non-student (email login)
    $stmt = $pdo->prepare('SELECT id, email, password, role FROM users WHERE (role = "student" AND username = ?) OR (role != "student" AND email = ?)');
    $stmt->execute([sanitizeInput($usernameOrEmail), sanitizeInput($usernameOrEmail)]);
    $user = $stmt->fetch();

    // Step 2: Verify the password and manage session accordingly
    if ($user && password_verify($password, $user['password'])) {
        // Store session data
        if ($user['role'] == 'student') {
            $_SESSION['user_username'] = $usernameOrEmail; // Use username for students
        } else {
            $_SESSION['user_email'] = $user['email']; // Use email for others
        }
        $_SESSION['role'] = $user['role'];

        // Set a session token for added security
        $_SESSION['token'] = bin2hex(random_bytes(32));

        return $user['role']; // Return role for further processing
    } else {
        return false; // Login failed
    }
}

// Initialize error variable
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if both username/email and password are provided
    if (empty($usernameOrEmail) || empty($password)) {
        $error = 'Username/Email and password are required.';
    } else {
        // Attempt to log in the user
        $role = login($usernameOrEmail, $password);
        if ($role) {
            // Redirect based on the user's role
            switch ($role) {
                case 'admin':
                    header('Location: admin/adminDashboard.php');
                    break;
                case 'educator':
                    header('Location: educator/educator.php');
                    break;
                case 'student':
                    header('Location: student/student.php');
                    break;
                default:
                    header('Location: index.php');
                    break;
            }
            exit();
        } else {
            echo "<script>alert('Invalid Details');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
   
    <link rel="stylesheet" href="css/login.css"> 
    <script src="js/login.js" defer></script>
</head>
<body style="background-image: url(images/web3.png) !important; background-repeat:no-repeat;  background-size: cover;">
    <!-- Login form -->
    <div class="login-container">
        <img src="images/ki_logo.png" alt="ki_logo">
        <form action="index.php" id="loginForm" method="post">
            <h2>Login</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button class="btn-login" type="submit">Login</button>
        </form>
    </div>

    <!-- Chatbot button -->
    <button class="chatbot-toggler attention-grabber">
        <strong>Chat KIE </strong> 
    </button>

    <!-- Chatbot container -->
    <div class="chatbot">
        <header>
            <h2>KI Chatbot</h2>
            <span class="close-btn material-symbols-outlined">close</span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <img src="/images/ki_logo.png" alt="Company Logo" class="company-logo">
                <p>Hi there 👋<br>How can I help you today?</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Enter a message..." spellcheck="false" required></textarea>
            <span id="send-btn" class="material-symbols-rounded">send</span>
        </div>
    </div>
</body>
</html>
