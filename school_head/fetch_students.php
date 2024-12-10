<?php
require_once 'includes/dbconnection.php';
require_once 'includes/StudentScoreService.php';

$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

$class_id = $_GET['class_id'] ?? null;
$page = $_GET['page'] ?? 1;
$searchQuery = $_GET['search'] ?? '';
$current_term_id = $studentScoreService->getCurrentTermId();

if ($class_id) {
    $students = $studentScoreService->getStudentsWithThemesAndScores($class_id, $searchQuery, $page);
    $total_students = $studentScoreService->getStudentCount($class_id, $current_term_id, $searchQuery);
    $total_pages = ceil($total_students / 10);

    $response = [
        'students' => $students,
        'total_pages' => $total_pages,
        'current_term_id' => $current_term_id
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Class ID is required']);
}