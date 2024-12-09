<?php
// get_students.php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'school_head') {
    exit('Unauthorized');
}

$pdo = dbConnect();

$classId = $_GET['class_id'] ?? null;
$page = $_GET['page'] ?? 1;
$searchQuery = $_GET['search'] ?? '';
$perPage = 10;

if (!$classId) {
    exit('No class specified');
}

$className = getClassName($classId);

// Modified query to get only student information
function getStudents($classId, $searchQuery, $page, $perPage) {
    global $pdo;
    $offset = ($page - 1) * $perPage;
    
    $query = "SELECT student_id, name 
              FROM students 
              WHERE class_id = :class_id";
    
    if (!empty($searchQuery)) {
        $query .= " AND name LIKE :search";
    }
    
    $query .= " ORDER BY name 
                LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':class_id', $classId, PDO::PARAM_INT);
    
    if (!empty($searchQuery)) {
        $stmt->bindValue(':search', "%$searchQuery%", PDO::PARAM_STR);
    }
    
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStudentCount($classId, $searchQuery) {
    global $pdo;
    
    $query = "SELECT COUNT(*) 
              FROM students 
              WHERE class_id = :class_id";
    
    if (!empty($searchQuery)) {
        $query .= " AND name LIKE :search";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':class_id', $classId, PDO::PARAM_INT);
    
    if (!empty($searchQuery)) {
        $stmt->bindValue(':search', "%$searchQuery%", PDO::PARAM_STR);
    }
    
    $stmt->execute();
    return $stmt->fetchColumn();
}

$students = getStudents($classId, $searchQuery, $page, $perPage);
$totalStudents = getStudentCount($classId, $searchQuery);
$totalPages = ceil($totalStudents / $perPage);

// Simplified table header
$theaderHtml = '<thead><tr><th>#</th><th>Student Name</th></tr></thead>';

// Simplified student rows
$studentsHtml = '';
foreach ($students as $student) {
    $studentsHtml .= '<tr>';
    $studentsHtml .= '<td>' . htmlspecialchars($student['student_id']) . '</td>';
    $studentsHtml .= '<td>' . htmlspecialchars($student['name']) . '</td>';
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
?>