<?php
// get_terms.php

require_once 'db_connction.php';

header('Content-Type: application/json');

if (isset($_GET['academic_year_id']) && is_numeric($_GET['academic_year_id'])) {
    $academic_year_id = intval($_GET['academic_year_id']);

    try {
        $sql = "SELECT id, term_number FROM terms WHERE academic_year_id = ? ORDER BY start_date";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$academic_year_id]);
        $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($terms)) {
            echo json_encode(['error' => 'No terms found for this academic year']);
        } else {
            echo json_encode($terms);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing academic year ID']);
}