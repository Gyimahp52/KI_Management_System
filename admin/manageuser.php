<?php
// require '../includes/dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Store user in the database
    $pdo = dbConnect();
    $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$username, $hashedPassword, $role]);

    echo 'User registered successfully!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
        <link rel="stylesheet" href="assets/css/adminDashboard.css">
</head>
<body>
<?php include_once('includes/side_bar.php');?>
<?php include_once('includes/header.php');?>

    <form action="add_user.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="role">Role:</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="educator">Educator</option>
            <option value="student">Student</option>
        </select>
        <button type="submit">Register</button>
    </form>
</body>
</html>