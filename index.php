<?php
session_start();
require 'includes/dbconnection.php'; 
 //require 'includes/login_function.php'; 
function login($username, $password) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare('SELECT id, password, role FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        return $user['role'];
    } else {
        return false;
    }
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        $role = login($username, $password);
        if ($role) {
            switch ($role) {
                case 'admin':
                    header('Location: admin/adminDashboard.php');
                    break;
                case 'educator':
                    header('Location: admin/educator/educatorDashboard.php');
                    break;
                case 'student':
                    header('Location: admin/studentDashboard.php');
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
<body>
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
