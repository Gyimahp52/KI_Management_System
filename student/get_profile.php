<?php
// Debug information at the beginning of the file
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../includes/dbconnection.php'; // Make sure this path is correct!

// Debug session information
file_put_contents('debug_log.txt', 'Session data: ' . print_r($_SESSION, true) . "\n", FILE_APPEND);

// Check if the user is logged in
if (!isset($_SESSION['user_username'])) {
    // Log this issue and send an error response
    file_put_contents('debug_log.txt', 'No user_username in session' . "\n", FILE_APPEND);
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$pdo = dbConnect();
$student_id = $_SESSION['user_username'];

// Log the student ID we're using
file_put_contents('debug_log.txt', 'Looking up student_id: ' . $student_id . "\n", FILE_APPEND);

try {
    // Fetch the student's details from the database
    $stmt = $pdo->prepare('
                        SELECT student_id, class_id, name, dob, gender, hand, foot, eye_sight, 
                        medical_condition, height, weight, parent_name, parent_phone, 
                        parent_whatsapp, parent_email, passport_picture 
                        FROM students WHERE student_id = ?
                          ');
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Log what we found
    file_put_contents('debug_log.txt', 'Query results: ' . print_r($student, true) . "\n", FILE_APPEND);
    
    if (!$student) {
        // No student found with this ID
        http_response_code(404);
        echo json_encode(['error' => 'Student not found']);
        exit;
    }

    // Add the full path to the passport picture if it exists
    if (!empty($student['passport_picture'])) {
        $student['passport_picture'] = 'student/' . $student['passport_picture'];
    }

    // Return the details as a JSON response
    header('Content-Type: application/json');
    echo json_encode($student);
} catch (PDOException $e) {
    // Log the database error
    file_put_contents('debug_log.txt', 'Database error: ' . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
?>