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
//$classId = 168;
$page = $_GET['page'] ?? 1;
$searchQuery = $_GET['search'] ?? '';
$perPage = 10;

if (!$classId) {
    exit('No class specified');
}

// Fetch school ID for the class to get themes
$stmt = $pdo->prepare('SELECT school_id FROM classes WHERE class_id = ?');
$stmt->execute([$classId]);
$schoolId = $stmt->fetchColumn();

// Get themes for the school
$class_id = $classId;
$theme_sql = "
        SELECT st.id AS theme_id, st.theme_name, sct.order
        FROM school_themes sct
        JOIN sel_themes st ON sct.theme_id = st.id
        JOIN classes c ON sct.school_id = c.school_id
        WHERE c.class_id = ?
        ORDER BY sct.order
    ";
$theme_stmt = $pdo->prepare($theme_sql);
$theme_stmt->execute([$class_id]);
$themes = $theme_stmt->fetchAll(PDO::FETCH_ASSOC);
//echo "<pre>";
//print_r($themes);
//echo "</pre>";

$className = getClassName($classId);
$currentTerm = $studentScoreService->getCurrentTermId();
$students = getStudents($classId, $currentTerm, $searchQuery, $page, $perPage);
$totalStudents = getStudentCount($classId, $currentTerm, $searchQuery);
$totalPages = ceil($totalStudents / $perPage);

// Generate table header with themes
$theaderHtml = '<thead class=""><tr><th class="">#</th><th class="">Student Name</th>';
foreach ($themes as $theme) {
    $theaderHtml .= '<th>' . htmlspecialchars($theme['theme_name']) . '</th>';
}
$theaderHtml .= '</tr></thead>';

$studentsHtml = '';
foreach ($students as $student) {
    $studentsHtml .= '<tr>';
    $studentsHtml .= '<td>' . htmlspecialchars($student['student_id']) . '</td>';
    $studentsHtml .= '<td>' . htmlspecialchars($student['name']) . '</td>';
    foreach ($themes as $theme) {
        $score = $studentScoreService->getScore($student['student_id'], $theme['theme_id'], $currentTerm);
        $studentsHtml .= '<td><input class="input-box" type="number" name="scores[' . $student['student_id'] . '][' . $theme['theme_id'] . ']" min="2" max="9" step="1" value="' . htmlspecialchars($score) . '"></td>';
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
    'theaderHtml' => $theaderHtml,
    'studentsHtml' => $studentsHtml,
    'pagination' => $pagination
]);