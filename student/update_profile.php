<?php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/base_url.php';

$pdo = dbConnect();
$educatorEmail = $_SESSION['user_email'];

// Fetch current profile pic
$stmt = $pdo->prepare('SELECT profile_pic FROM educators WHERE email = ?');
$stmt->execute([$educatorEmail]);
$currentProfilePic = $stmt->fetchColumn();

// Handle file upload for profile picture
$profilePic = $currentProfilePic; // Default to current profile pic
if (!empty($_FILES['profile_pic']['name'])) {
    $targetDir = realpath(__DIR__ . '/../admin/uploads/') . '/';
    $targetFile = $targetDir . basename($_FILES['profile_pic']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
        exit;
    }

    // Check file size (50000 bytes = 50 KB)
    if ($_FILES["profile_pic"]["size"] > 500000) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, your file is too large.']);
        exit;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
        exit;
    }

    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
        $profilePic = "uploads/" . basename($_FILES['profile_pic']['name']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file.']);
        exit;
    }
}

// Prepare SQL to update educator's profile
$stmt = $pdo->prepare('UPDATE educators SET location = ?, phone_number = ?, emergency_contact = ?, profile_pic = ? WHERE email = ?');
$stmt->execute([
    $_POST['location'],
    $_POST['phone_number'],
    $_POST['emergency_contact'],
    $profilePic,
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
            echo json_encode(['status' => 'success', 'message' => 'Profile and password updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'New password and confirmation do not match.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect old password.']);
    }
} else {
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
}
?>