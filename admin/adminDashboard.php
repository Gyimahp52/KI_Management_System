<?php
// Start the session
session_start();

// Check if the user is logged in and has the role of 'admin'.
// Redirect to login page if not.
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit;
}

$username = $_SESSION['username']; // Assuming the username is stored in the session
$photoUrl = $_SESSION['photo_url']; // Assuming the photo URL is stored in the session


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/admin/adminDashboard.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <div class="user-info">
            <img src="<?php echo htmlspecialchars($photoUrl); ?>" alt="User Photo" class="user-photo">
            <span><?php echo htmlspecialchars($username); ?></span>
        </div>
    </header>
    <nav>
    <ul>
        <li><a href="#">User Management</a></li>
        <li><a href="#" class="menu-item" id="roles-permissions">Roles & Permissions</a></li>
        <li><a href="#">System Settings</a></li>
        <li><a href="#">Reports Overview</a></li>
        <!-- Add more navigation items as needed -->
    </ul>
</nav>

<main>
    <h1>Welcome to the Admin Dashboard</h1>
    <!-- Dashboard specific content goes here -->
    <div class="roles-permissions-form">
        <h2>Roles & Permissions</h2>
        <!-- Add your form elements here -->
        <form>
            <!-- Form fields for roles and permissions -->
            <button type="submit">Save</button>
        </form>
    </div>
</main>
</body>
</html>
