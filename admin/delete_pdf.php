<?php
// delete_pdf.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    require_once 'db_connction.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $studentId = $_POST['student_id'] ?? '';
    $termId = $_POST['term_id'] ?? '';

    if (empty($studentId) || empty($termId)) {
        throw new Exception('Missing required parameters');
    }

    // Delete PDF from database
    $stmt = $pdo->prepare("DELETE FROM pdf_files WHERE student_id = ? AND term_id = ?");
    $stmt->execute([$studentId, $termId]);

    // Also delete PDF status
    $stmt = $pdo->prepare("DELETE FROM pdf_status WHERE student_id = ? AND term_id = ?");
    $stmt->execute([$studentId, $termId]);

    echo json_encode([
        'status' => 'success',
        'message' => 'PDF deleted successfully',
        'student_id' => $studentId,
        'term_id' => $termId
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

