<?php
require_once 'includes/dbconnection.php';
// require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';
// require_once 'includes/base_url.php';



$pdo = dbConnect();

$studentScoreService = new StudentScoreService($pdo);


// Ensure school_id is provided via GET request
if (!isset($_GET['school_id']) || empty($_GET['school_id'])) {
    echo '<div class="error-message">Invalid or missing School ID.</div>';
    exit();
}

$schoolId = intval($_GET['school_id']);
$schoolId = (string) $schoolId;
$schoolId = trim($schoolId);

var_dump($schoolId);


// // Fetch classes for the selected school
// $stmtClasses = $pdo->prepare('SELECT class_id, class_name FROM classes WHERE school_id = ?');
// $stmtClasses->execute([$schoolId]);
// $classes = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);

$classes = $studentScoreService->getClasses($schoolId);
var_dump($classes);

// Generate the UI response
if ($classes) {
    echo '<div class="classes-list">';
    echo '<ul>';
    foreach ($classes as $class) {
        echo 'var_dump(class)';
        echo '<li class="class-item">';
        echo '<a href="class_details.php?class_id=' . $class['id'] . '" class="class-link">';
        echo htmlspecialchars($class['class_name']);
        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';
} else {
    echo '<div class="info-message">No classes found for the selected school.</div>';
}
?>
