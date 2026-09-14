<?php

// microservice_client.php
class MicroserviceClient
{
    private $baseUrl = 'http://localhost:3004'; // PDF microservice runs on localhost:3004
    private $whatsappUrl = 'http://localhost:3005'; // WhatsApp microservice runs on localhost:3005

    public function generatePdf($studentId, $termId, $studentName)
    {
        $url = $this->baseUrl . '/generate-pdf';
        $data = [
            'studentId' => $studentId,
            'termId' => $termId,
            'studentName' => $studentName
        ];

        $response = $this->makeApiCall($url, 'POST', $data);

        if ($response['status'] === 'success') {
            return true;
        } else {
            return false;
        }
    }

    public function sendWhatsAppMessage($studentId, $termId)
    {
        $url = $this->whatsappUrl . '/send-whatsapp'; // Direct send (bypasses queue)
        $data = [
            'studentId' => $studentId,
            'termId' => $termId
        ];
        
        $response = $this->makeApiCall($url, 'POST', $data);

        if ($response['status'] === 'success') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Add students to the queue for bulk sending (NEW METHOD)
     * @param array $studentIds Array of student IDs
     * @param string $termId Term ID
     * @return array Response from the microservice
     */
    public function addToQueue($studentIds, $termId)
    {
        $url = $this->whatsappUrl . '/api/queue/add';
        $data = [
            'students' => $studentIds,
            'termId' => $termId
        ];
        
        $response = $this->makeApiCall($url, 'POST', $data);
        return $response['data'] ?? $response;
    }

    /**
     * Get queue status (NEW METHOD)
     * @return array Queue status
     */
    public function getQueueStatus()
    {
        $url = $this->whatsappUrl . '/api/queue/status';
        $response = $this->makeApiCall($url, 'GET');
        return $response['data'] ?? $response;
    }

    /**
     * Get today's statistics (NEW METHOD)
     * @return array Statistics
     */
    public function getStats()
    {
        $url = $this->whatsappUrl . '/api/stats';
        $response = $this->makeApiCall($url, 'GET');
        return $response['data'] ?? $response;
    }

    /**
     * Get send history (NEW METHOD)
     * @return array History records
     */
    public function getHistory()
    {
        $url = $this->whatsappUrl . '/api/history';
        $response = $this->makeApiCall($url, 'GET');
        return $response['data'] ?? $response;
    }

    /**
     * Clear the queue (NEW METHOD)
     * @return array Response
     */
    public function clearQueue()
    {
        $url = $this->whatsappUrl . '/api/queue/clear';
        $response = $this->makeApiCall($url, 'POST');
        return $response['data'] ?? $response;
    }

    public function checkPdfStatus($studentId, $termId)
    {
        $url = $this->baseUrl . '/check-pdf-status?studentId=' . $studentId . '&termId=' . $termId;
        $response = $this->makeApiCall($url, 'GET');
    
        if ($response['status'] === 'success') {
            $status = strtolower($response['data']['status']);
            // Standardize the status
            if (in_array($status, ['completed', 'success'])) {
                return 'completed';
            } elseif (in_array($status, ['generating', 'in progress'])) {
                return 'generating';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    }
    public function downloadPdf($studentId, $termId)
    {
        $url = $this->baseUrl . '/download-pdf?studentId=' . $studentId . '&termId=' . $termId;
        $response = $this->makeApiCall($url, 'GET');

        if ($response['status'] === 'success') {
            return $response['data'];
        } else {
            return null;
        }
    }

    private function makeApiCall($url, $method, $data = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseData = json_decode($response, true);
        return array('status' => $statusCode >= 200 && $statusCode < 300 ? 'success' : 'error', 'data' => $responseData);
    }
}