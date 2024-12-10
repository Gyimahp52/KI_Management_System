<?php
session_start();

require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';

// Authentication check
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'school_head') {
    sendJsonResponse(['message' => 'Unauthorized'], false);
}

// JSON Response function
function sendJsonResponse($data, $success = true) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'data' => $data
    ]);
    exit;
}


function getStudents($pdo, $class_id, $term_id, $searchQuery = '', $page = 1, $perPage = 10) {
    $offset = ($page - 1) * $perPage;

    $sql = "
        SELECT 
            s.student_id, 
            s.name, 
            t.term_number, 
            ay.year_name,
            c.class_name,
            sc.school_name,
            (SELECT COUNT(DISTINCT ss.id) 
             FROM student_scores ss 
             WHERE ss.student_id = s.student_id AND ss.term_id = ?) AS score_count
        FROM students s
        JOIN classes c ON s.class_id = c.class_id
        JOIN schools sc ON c.school_id = sc.id
        JOIN terms t ON t.id = ?
        JOIN academic_years ay ON t.academic_year_id = ay.id
        WHERE 
            s.class_id = ? 
            AND (s.student_id LIKE ? OR s.name LIKE ?)
        ORDER BY s.name
        LIMIT ? OFFSET ?
    ";

    $stmt = $pdo->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $stmt->execute([
        $term_id, 
        $term_id, 
        $class_id, 
        $searchParam, 
        $searchParam, 
        $perPage, 
        $offset
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStudentCount($pdo, $class_id, $term_id, $searchQuery = '') {
    $sql = "
        SELECT COUNT(DISTINCT s.student_id) as count
        FROM students s
        WHERE 
            s.class_id = ? 
            AND (s.student_id LIKE ? OR s.name LIKE ?)
    ";

    $stmt = $pdo->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $stmt->execute([
        $class_id, 
        $searchParam, 
        $searchParam
    ]);

    return $stmt->fetchColumn();
}

try {
    $pdo = dbConnect();

    // Input validation
    $classId = $_GET['class_id'] ?? null;
    $page = max(1, (int)($_GET['page'] ?? 1));
    $searchQuery = $_GET['search'] ?? '';

    // Validate inputs
    if (!$classId) {
        sendJsonResponse(['message' => 'Invalid class selection'], false);
    }

    // Get current term or use specified term
    $termId = validateTermSelection($pdo, $_GET['term_id'] ?? null);
    if (!$termId) {
        sendJsonResponse(['message' => 'No active term found'], false);
    }

    // Fetch students
    $students = getStudents($pdo, $classId, $termId, $searchQuery, $page);
    $totalStudents = getStudentCount($pdo, $classId, $termId, $searchQuery);
    $totalPages = ceil($totalStudents / 10);

    // Prepare response
    $response = [
        'students' => $students,
        'total_pages' => $totalPages,
        'current_page' => $page,
        'total_students' => $totalStudents,
        'termId' => $termId
    ];

    sendJsonResponse($response);

} catch (Exception $e) {
    sendJsonResponse(['message' => 'An error occurred: ' . $e->getMessage()], false);
}