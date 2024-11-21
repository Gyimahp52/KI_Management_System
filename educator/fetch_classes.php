<?php
require_once 'includes/dbconnection.php';
require_once 'includes/StudentScoreService.php';

$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

// Ensure school_id is provided via GET request
if (!isset($_GET['school_id']) || empty($_GET['school_id'])) {
    echo '<div class="error-message">Invalid or missing School ID.</div>';
    exit();
}

// Retrieve and sanitize school_id
$schoolId = trim($_GET['school_id']);

// Fetch classes
$classes = $studentScoreService->getClasses($schoolId);

// Generate the UI response
if (!empty($classes)) {
    echo '<div id="class-cards" class="card-container">';
    foreach ($classes as $class) {
        echo '<div class="card" data-class-id="' . htmlspecialchars($class['class_id']) . '">';
        echo '    <div class="icon">';
        echo '        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256" class="svg-icon">';
        echo '            <path d="M240,208H224V96a16,16,0,0,0-16-16H144V32a16,16,0,0,0-24.88-13.32L39.12,72A16,16,0,0,0,32,85.34V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM208,96V208H144V96ZM48,85.34,128,32V208H48ZM112,112v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm-32,0v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm0,56v16a8,8,0,0,1-16,0V168a8,8,0,1,1,16,0Zm32,0v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Z"></path>';
        echo '        </svg>';
        echo '    </div>';
        echo '    <div class="card-text">';
        echo '        <h2 class="title">' . htmlspecialchars($class['class_name']) . '</h2>';
        echo '        <p class="subtitle">' . htmlspecialchars($class['student_count']) . ' students</p>';
        echo '    </div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<div class="info-message">No classes found for the selected school.</div>';
}
?>
