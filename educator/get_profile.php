<?php
session_start();
require_once 'includes/dbconnection.php';

$pdo = dbConnect();
$educatorEmail = $_SESSION['user_email'];

// Fetch the educator's details from the database
$stmt = $pdo->prepare('SELECT name, profile_pic, phone_number, emergency_contact, location, email FROM educators WHERE email = ?');
$stmt->execute([$educatorEmail]);
$educator = $stmt->fetch(PDO::FETCH_ASSOC);

// Add the full path to the profile picture
if (!empty($educator['profile_pic'])) {
    $educator['profile_pic'] = 'admin/' . $educator['profile_pic'];
}

// Return the details as a JSON response
echo json_encode($educator);
?>