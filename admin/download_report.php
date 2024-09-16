<?php
//download_report.php

require_once 'db_connction.php';

$student_id = filter_input(INPUT_GET, 'student_id', FILTER_SANITIZE_STRING);
$term_id = filter_input(INPUT_GET, 'term_id', FILTER_VALIDATE_INT);

if (!$student_id || !$term_id) {
    die("Invalid student ID or term ID");
}

$stmt = $pdo->prepare("SELECT file_name, pdf_content FROM pdf_files WHERE student_id = ? AND term_id = ?");
$stmt->execute([$student_id, $term_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $result['file_name'] . '"');
    echo $result['pdf_content'];
} else {
    die("PDF not found");
}

