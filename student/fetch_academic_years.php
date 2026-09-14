<?php
session_start();
require_once 'includes/dbconnection.php';
$pdo = dbConnect();

try {
    $stmt = $pdo->prepare('SELECT id, year_name FROM academic_years');
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('No academic years found.');
    }

    $academicYears = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    http_response_code(200);
    echo json_encode($academicYears);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error: ' . $e->getMessage()]);
}
?>