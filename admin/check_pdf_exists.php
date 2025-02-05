<?php
// check_pdf_exists.php
require_once 'db_connction.php';
require_once 'StudentScoreService.php';

// Disable error reporting to prevent any PHP notices from being output
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

$student_id = $_GET['student_id'] ?? '';
$term_id = $_GET['term_id'] ?? '';

if (!$student_id || !$term_id) {
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

try {
    $studentScoreService = new StudentScoreService($pdo);
    
    // Check if PDF exists
    $pdfExists = $studentScoreService->checkPdfExists($student_id, $term_id);
    
    // Check the send status
    $sendStatus = $studentScoreService->checkSendStatus($student_id);

    // Return both PDF existence and send status
    echo json_encode([
        'pdfExists' => $pdfExists,
        'sendStatus' => $sendStatus  // Possible values: 'sent', 'fail', null
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'An error occurred while checking statuses']);
}
