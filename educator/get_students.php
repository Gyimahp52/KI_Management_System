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

$classId = $_GET['class_id'] ?? null;
$page = $_GET['page'] ?? 1;
$searchQuery = $_GET['search'] ?? '';
$perPage = 10;

if (!$classId) {
    exit('No class specified');
}

$className = getClassName($classId);
$currentTerm = $studentScoreService->getCurrentTermId();
$students = getStudents($classId, $currentTerm, $searchQuery, $page, $perPage);
$totalStudents = getStudentCount($classId, $currentTerm, $searchQuery);
$totalPages = ceil($totalStudents / $perPage);

// Fetch themes for the school
$stmt = $pdo->prepare('SELECT school_id FROM classes WHERE class_id = ?');
$stmt->execute([$classId]);
$schoolId = $stmt->fetchColumn();
$themes = getThemes($schoolId);

$studentsHtml = '';
foreach ($students as $student) {
    $studentsHtml .= '<tr>';
    $studentsHtml .= '<td>' . htmlspecialchars($student['student_id']) . '</td>';
    $studentsHtml .= '<td>' . htmlspecialchars($student['name']) . '</td>';
    foreach ($themes as $theme) {
        $score = $studentScoreService->getScore($student['student_id'], $theme['id'], $currentTerm);
        $studentsHtml .= '<td><input class="input-box" type="number" name="scores[' . $student['student_id'] . '][' . $theme['id'] . ']" min="2" max="9" step="1" value="' . htmlspecialchars($score) . '"></td>';
    }
    $studentsHtml .= '</tr>';
}

$pagination = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = ($i == $page) ? 'active' : '';
    $pagination .= '<a href="#" class="pagination-link ' . $activeClass . '" data-page="' . $i . '">' . $i . '</a> ';
}

echo json_encode([
    'className' => $className,
    'studentsHtml' => $studentsHtml,
    'pagination' => $pagination
]);