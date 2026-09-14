<?php
session_start();
require_once 'includes/dbconnection.php';
$pdo = dbConnect();

if (!isset($_GET['academic_year_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Academic Year ID is required.']);
    exit;
}

$academicYearId = $_GET['academic_year_id'];

try {
    $stmt = $pdo->prepare('SELECT id, term_number, start_date, end_date 
                            FROM terms 
                            WHERE academic_year_id = ?');
    $stmt->execute([$academicYearId]);
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('No terms found for the selected academic year.');
    }

    $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    http_response_code(200);
    echo json_encode($terms);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>