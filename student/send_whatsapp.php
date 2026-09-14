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

    function addToQueue($studentIds, $termId) {
        global $microserviceClient;
        
        // Clean up student IDs
        $cleanedIds = array_map('trim', $studentIds);
        $cleanedIds = array_filter($cleanedIds); // Remove empty values
        
        // Use the new queue API endpoint
        $result = $microserviceClient->addToQueue($cleanedIds, $termId);
        return $result;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentIds = explode(',', $_POST['student_id'] ?? '');
        $termId = $_POST['term_id'] ?? '';

        if (empty($studentIds) || empty($termId)) {
            throw new Exception('Missing required parameters');
        }

        // Add students to queue instead of sending directly
        $result = addToQueue($studentIds, $termId);
        
        if ($result && isset($result['status']) && $result['status'] === 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Students added to queue successfully',
                'data' => [[
                    'success' => true,
                    'queueSize' => $result['queueSize'] ?? count($studentIds),
                    'message' => $result['message'] ?? 'Added to queue'
                ]]
            ]);
        } else {
            throw new Exception($result['message'] ?? 'Failed to add students to queue');
        }
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