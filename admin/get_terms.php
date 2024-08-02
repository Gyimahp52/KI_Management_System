<?php
// get_terms.php

require_once 'db_connection.php';

if (isset($_GET['academic_year_id'])) {
    $academic_year_id = intval($_GET['academic_year_id']);

    $sql = "SELECT id, term_number FROM terms WHERE academic_year_id = ? ORDER BY start_date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$academic_year_id]);
    $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($terms);
} else {
    header("HTTP/1.0 400 Bad Request");
    echo "Academic year ID is required";
}