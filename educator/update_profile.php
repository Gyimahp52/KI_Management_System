<?php
session_start();
require_once 'includes/dbconnection.php';

$pdo = dbConnect();
$educatorEmail = $_SESSION['user_email'];

// Handle file upload for profile picture
$profilePic = $_FILES['profile_pic']['name'];
if ($profilePic) {
    $targetDir = "uploads/profile_pics/";
    $targetFile = $targetDir . basename($_FILES['profile_pic']['name']);
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile);
}

// Prepare SQL to update educator's profile
$stmt = $pdo->prepare('UPDATE educators SET location = ?, phone_number = ?, emergency_contact = ?, profile_pic = ? WHERE email = ?');
$stmt->execute([
    $_POST['location'],
    $_POST['phone_number'],
    $_POST['emergency_contact'],
    $profilePic ? $targetFile : null,
    $educatorEmail
]);

// Handle password change if fields are filled
if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if the old password is correct
    $stmt = $pdo->prepare('SELECT password FROM users WHERE email = ?');
    $stmt->execute([$educatorEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($oldPassword, $user['password'])) {
        // Check if new password matches confirmation
        if ($newPassword === $confirmPassword) {
            // Update password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
            $stmt->execute([$hashedPassword, $educatorEmail]);
            echo 'Password updated successfully!';
        } else {
            echo 'New password and confirmation do not match.';
        }
    } else {
        echo 'Incorrect old password.';
    }
} else {
    echo 'Profile updated successfully without password change.';
}
?>
