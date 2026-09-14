<?php
session_start();
require_once 'includes/dbconnection.php'; 

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log function to track execution
function logDebug($message) {
    file_put_contents('profile_update_log.txt', date('[Y-m-d H:i:s] ') . $message . "\n", FILE_APPEND);
}

logDebug("Update profile process started");

$pdo = dbConnect();
$student_id = $_SESSION['user_username'];

logDebug("Processing for student ID: $student_id");

// Fetch current passport picture 
$stmt = $pdo->prepare('SELECT passport_picture FROM students WHERE student_id = ?');
$stmt->execute([$student_id]);
$currentPassportPic = $stmt->fetchColumn();

logDebug("Current passport picture: $currentPassportPic");

// Handle file upload for passport picture
$passportPic = $currentPassportPic; // Default to current passport pic
if (!empty($_FILES['passport_picture']['name'])) {
    logDebug("New passport picture being uploaded: " . $_FILES['passport_picture']['name']);
    
    $targetDir = realpath(__DIR__ . '/../uploads/students/') . '/';
    
    // Ensure directory exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
        logDebug("Created directory: $targetDir");
    }
    
    // Generate unique filename to prevent overwrites
    $fileExtension = strtolower(pathinfo($_FILES['passport_picture']['name'], PATHINFO_EXTENSION));
    $newFileName = $student_id . '_' . time() . '.' . $fileExtension;
    $targetFile = $targetDir . $newFileName;
    
    logDebug("Target file: $targetFile");
    
    $uploadOk = 1;
    
    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["passport_picture"]["tmp_name"]);
    if($check !== false) {
        logDebug("File is an image - " . $check["mime"]);
        $uploadOk = 1;
    } else {
        logDebug("File is not an image");
        echo json_encode(['status' => 'error', 'message' => 'File is not an image.']);
        exit;
    }

    // Check file size (500000 bytes = 500 KB)
    if ($_FILES["passport_picture"]["size"] > 500000) {
        logDebug("File is too large: " . $_FILES["passport_picture"]["size"] . " bytes");
        echo json_encode(['status' => 'error', 'message' => 'Sorry, your file is too large.']);
        exit;
    }

    // Allow certain file formats
    if($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg"
    && $fileExtension != "gif" ) {
        logDebug("Invalid file type: $fileExtension");
        echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
        exit;
    }

    if (move_uploaded_file($_FILES['passport_picture']['tmp_name'], $targetFile)) {
        logDebug("File successfully uploaded to: $targetFile");
        $passportPic = "uploads/students/" . $newFileName;
    } else {
        logDebug("File upload failed. Error: " . error_get_last()['message']);
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file.']);
        exit;
    }
}

try {
    // Begin transaction for safer database operations
    $pdo->beginTransaction();
    
    // Prepare SQL to update student's profile
    // Only update fields that are editable in the form and present in the POST data
    $updateFields = [];
    $params = [];
    
    // Map form fields to database columns - include only fields that should be editable
    $editableFields = [
        'name' => 'name',
        'dob' => 'dob',
        'gender'=>'gender',
        'hand' => 'hand',
        'foot' => 'foot',
        'eye_sight' => 'eye_sight',
        'medical_condition' => 'medical_condition',
        'height' => 'height',
        'weight' => 'weight',
        'parent_name' => 'parent_name',
        'parent_phone' => 'parent_phone',
        'parent_whatsapp' => 'parent_whatsapp',
        'parent_email' => 'parent_email'
    ];
    
    foreach ($editableFields as $postField => $dbField) {
        if (isset($_POST[$postField])) {
            $updateFields[] = "$dbField = ?";
            $params[] = $_POST[$postField];
            logDebug("Adding field $dbField with value: " . $_POST[$postField]);
        }
    }
    
    // Add passport picture to update if it was changed
    if ($passportPic !== $currentPassportPic) {
        $updateFields[] = "passport_picture = ?";
        $params[] = $passportPic;
        logDebug("Adding passport_picture field with value: $passportPic");
    }
    
    // Add student_id to parameters array
    $params[] = $student_id;
    
    // Only perform update if there are fields to update
    if (!empty($updateFields)) {
        $sql = "UPDATE students SET " . implode(", ", $updateFields) . " WHERE student_id = ?";
        logDebug("Executing SQL: $sql");
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute($params);
        
        logDebug("Update result: " . ($result ? "Success" : "Failed"));
        
        if (!$result) {
            throw new Exception("Database update failed");
        }
    } else {
        logDebug("No fields to update");
    }
    
    // Handle password change if fields are filled
    if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        logDebug("Password change requested");
        
        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        
        // Check if the old password is correct
        $stmt = $pdo->prepare('SELECT password FROM users WHERE username = ?');
        $stmt->execute([$student_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            logDebug("User not found in users table");
            throw new Exception("User account not found");
        }
        
        if (password_verify($oldPassword, $user['password'])) {
            logDebug("Old password verified successfully");
            
            // Check if new password matches confirmation
            if ($newPassword === $confirmPassword) {
                logDebug("New password and confirmation match");
                
                // Update password in the database
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE username = ?');
                $result = $stmt->execute([$hashedPassword, $student_id]);
                
                if (!$result) {
                    throw new Exception("Password update failed");
                }
                logDebug("Password updated successfully");
            } else {
                logDebug("New password and confirmation don't match");
                throw new Exception("New password and confirmation do not match");
            }
        } else {
            logDebug("Incorrect old password");
            throw new Exception("Incorrect old password");
        }
    }
    
    // Commit transaction if we got this far
    $pdo->commit();
    logDebug("Transaction committed successfully");
    
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
    
} catch (Exception $e) {
    // Roll back transaction on error
    $pdo->rollBack();
    logDebug("Error occurred: " . $e->getMessage());
    logDebug("Transaction rolled back");
    
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>