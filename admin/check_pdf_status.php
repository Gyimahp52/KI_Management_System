<?php


// check_pdf_status.php
require_once 'microservice_client.php';

header('Content-Type: application/json');  // Ensure response is JSON

try {
    $student_id = filter_input(INPUT_GET, 'student_id', FILTER_SANITIZE_STRING);
    $term_id = filter_input(INPUT_GET, 'term_id', FILTER_VALIDATE_INT);

    if (!$student_id || !$term_id) {
        throw new Exception('Invalid student ID or term ID');
    }

    $microserviceClient = new MicroserviceClient();
    $status = $microserviceClient->checkPdfStatus($student_id, $term_id);

    // Log the status
    error_log("PDF status for student $student_id, term $term_id: $status");

    echo json_encode(['status' => $status]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
