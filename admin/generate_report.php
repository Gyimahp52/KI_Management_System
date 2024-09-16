
<?php


// generate_report.php
require_once 'db_connction.php';
require_once 'microservice_client.php';

header('Content-Type: application/json');  // Ensure response is JSON

try {
    $student_id = filter_input(INPUT_GET, 'student_id', FILTER_SANITIZE_STRING);
    $term_id = filter_input(INPUT_GET, 'term_id', FILTER_VALIDATE_INT);

    if (!$student_id || !$term_id) {
        throw new Exception('Invalid student ID or term ID');
    }

    $stmt = $pdo->prepare("SELECT name FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $student_name = $stmt->fetchColumn();

    if (!$student_name) {
        throw new Exception('Student not found');
    }

    $microserviceClient = new MicroserviceClient();
    $microserviceClient->generatePdf($student_id, $term_id, $student_name);

    echo json_encode(['status' => 'success', 'message' => 'PDF generation task sent to the microservice']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
