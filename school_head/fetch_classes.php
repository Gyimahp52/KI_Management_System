<?php
require_once 'includes/dbconnection.php';
require_once 'includes/StudentScoreService.php';

$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

$school_id = $_GET['school_id'] ?? null;

if ($school_id) {
    $classes = $studentScoreService->getClasses($school_id);
    header('Content-Type: application/json');
    echo json_encode($classes);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'School ID is required']);
}