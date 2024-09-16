<?php

// microservice_client.php
class MicroserviceClient
{
    private $baseUrl = 'http://localhost:3000'; // Assuming the microservice runs on localhost:3000

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
    $url = 'http://localhost:3002/send-whatsapp'; // port of send-whatsapp 
    $data = [
        'studentId' => $studentId,
        'termId' => $termId
    ];
    // var_dump($data);
    
    $response = $this->makeApiCall($url, 'POST', $data);

    if ($response['status'] === 'success') {
        return true;
    } else {
        return false;
    }
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





