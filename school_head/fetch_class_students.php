<?php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/StudentScoreService.php';

$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

// Get current term ID
$current_term_id = $studentScoreService->getCurrentTermId();

if (!isset($_GET['class_id'])) {
    echo json_encode(['error' => 'Class ID is required']);
    exit;
}

$class_id = intval($_GET['class_id']);
$class_name = $_GET['class_name'] ?? 'Selected Class';

// Fetch students for the class
$students = $studentScoreService->getStudentsForClass($class_id, $current_term_id);

// Generate HTML for students
$html = "<h3>Students in $class_name</h3>";
$html .= "<div class='table-responsive'>";
$html .= "<table class='table table-striped'>";
$html .= "<thead><tr><th>Student ID</th><th>Name</th><th>Actions</th></tr></thead>";
$html .= "<tbody>";

foreach ($students as $student) {
    $html .= "<tr>";
    $html .= "<td>" . htmlspecialchars($student['student_id']) . "</td>";
    $html .= "<td>" . htmlspecialchars($student['name']) . "</td>";
    $html .= "<td>";
    $html .= "<button class='btn btn-sm btn-primary view-report-btn' ";
    $html .= "data-student-id='" . htmlspecialchars($student['student_id']) . "' ";
    $html .= "data-term-id='" . $current_term_id . "'>View Report</button>";
    $html .= "</td>";
    $html .= "</tr>";
}

$html .= "</tbody></table>";
$html .= "</div>";

echo $html;