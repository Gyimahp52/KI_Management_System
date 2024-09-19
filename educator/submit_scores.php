<?php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';

if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'educator') {
    exit('Unauthorized');
}

$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

$scores = $_POST['scores'] ?? [];
$currentTerm = $studentScoreService->getCurrentTermId();

if ($studentScoreService->saveScores($scores, $currentTerm)) {
    echo json_encode(['success' => true, 'message' => 'Scores submitted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error submitting scores']);
}