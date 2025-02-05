<?php
require_once 'includes/dbconnection.php';
require_once 'includes/StudentScoreService.php';

session_start();
$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

// Fetch schools for the logged-in educator
$educatorEmail = $_SESSION['user_email'];
$schools = $studentScoreService->getSchoolsForEducator($educatorEmail);

header('Content-Type: application/json');
echo json_encode($schools);