<?php 

// send_whatsapp.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    require_once 'db_connction.php';
    require_once 'StudentScoreService.php';
    require_once 'microservice_client.php';

    $studentScoreService = new StudentScoreService($pdo);
    $microserviceClient = new MicroserviceClient();

    function sendWhatsAppReport($studentId, $termId) {
        global $microserviceClient;
        $result = $microserviceClient->sendWhatsAppMessage($studentId, $termId);
        return ['success' => $result, 'error' => $result ? null : 'Failed to send WhatsApp message'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentIds = explode(',', $_POST['student_id'] ?? ''); // Updated to handle multiple student IDs
        $termId = $_POST['term_id'] ?? '';
        $results = [];

        if (empty($studentIds) || empty($termId)) {
            throw new Exception('Missing required parameters');
        }

        foreach ($studentIds as $studentId) {
            $results[] = sendWhatsAppReport($studentId, $termId);
        }

        echo json_encode(['status' => 'success', 'data' => $results]);
    } else {
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
}