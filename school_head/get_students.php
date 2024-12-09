<?php
// get_students.php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';

// Function to send JSON response
function sendJsonResponse($data, $success = true) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'data' => $data
    ]);
    exit;
}

// Check authentication
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'school_head') {
    sendJsonResponse(['message' => 'Unauthorized'], false);
}

$pdo = dbConnect();

$classId = $_GET['class_id'] ?? null;
$page = $_GET['page'] ?? 1;
$searchQuery = $_GET['search'] ?? '';
$perPage = 10;
// $currentTerm = getCurrentTerm(); // You'll need to implement this function

if (!$classId) {
    sendJsonResponse(['message' => 'No class specified'], false);
}

try {
    // Get the data
    $students = getStudents($classId, $currentTerm, $searchQuery, $page, $perPage);
    $totalStudents = getStudentCount($classId, $currentTerm, $searchQuery);
    $totalPages = ceil($totalStudents / $perPage);
    $className = getClassName($classId);

    // Create table header
    $theaderHtml = '<thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Academic Year</th>
            <th>Term</th>
        </tr>
    </thead>';

    // Create student rows
    $studentsHtml = '';
    foreach ($students as $student) {
        $studentsHtml .= '<tr>';
        $studentsHtml .= '<td>' . htmlspecialchars($student['student_id']) . '</td>';
        $studentsHtml .= '<td>' . htmlspecialchars($student['name']) . '</td>';
        $studentsHtml .= '<td>' . htmlspecialchars($student['year_name']) . '</td>';
        $studentsHtml .= '<td>' . htmlspecialchars($student['term_number']) . '</td>';
        $studentsHtml .= '</tr>';
    }

    // Create pagination
    $pagination = '';
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $page) ? 'active' : '';
        $pagination .= '<a href="#" class="pagination-link ' . $activeClass . '" data-page="' . $i . '">' . $i . '</a> ';
    }

    sendJsonResponse([
        'className' => $className,
        'theaderHtml' => $theaderHtml,
        'studentsHtml' => $studentsHtml,
        'pagination' => $pagination
    ]);

} catch (Exception $e) {
    sendJsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], false);
}