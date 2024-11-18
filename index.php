<?php
session_start();

// Display toastr message if it exists and then remove it
$toastr_message = isset($_SESSION['login_toastr']) ? $_SESSION['login_toastr'] : null;
unset($_SESSION['login_toastr']);

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
            $_SESSION['user_username'] = $usernameOrEmail;
        } else {
            $_SESSION['user_email'] = $user['email'];
        }
        $_SESSION['role'] = $user['role'];
        $_SESSION['token'] = bin2hex(random_bytes(32));

        return $user['role'];
    } else {
        return false;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if both username/email and password are provided
    if (empty($usernameOrEmail) || empty($password)) {
        $_SESSION['login_toastr'] = ['type' => 'error', 'message' => 'Username/Email and password are required.'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
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
                    header('Location: educator/classes.php');
                    break;
                case 'student':
                    header('Location: student/index.php');
                    break;
                default:
                    header('Location: index.php');
                    break;
            }
            exit();
        } else {
            $_SESSION['login_toastr'] = ['type' => 'error', 'message' => 'Invalid username or password.'];
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="css/login.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="manifest" href="/images/site.webmanifest">

    <script src="js/login.js" defer></script>
</head>
<body style="background-image: url(images/web3.png) !important; background-repeat:no-repeat;  background-size: cover;">
    <!-- Login form -->
    <div class="login-container">
        <img src="images/ki_logo.png" alt="ki_logo">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="loginForm" method="post">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toastr options
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            <?php if ($toastr_message): ?>
                toastr[<?php echo json_encode($toastr_message['type']); ?>](
                    <?php echo json_encode($toastr_message['message']); ?>
                );
            <?php endif; ?>
        });
    </script>
</body>
</html>