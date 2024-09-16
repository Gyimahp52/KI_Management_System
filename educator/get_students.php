<?php

session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';
$pdo = dbConnect();
$studentScoreService = new StudentScoreService($pdo);

if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'educator') {
    exit('Unauthorized');
}

$classId = $_GET['class_id'] ?? null;
if (!$classId) {
    exit('No class specified');
}





// Fetch students for the class
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$students = $studentScoreService->getStudentsWithThemesAndScores($classId, $searchQuery);

foreach ($students as $student_id => $themes){
    echo '<tr>';
    echo '<td>' . htmlspecialchars($student_id) . '</td>';
    echo '<td>' . htmlspecialchars($themes[0]['name']) . '</td>';
    
    foreach ($themes as $theme){
        echo '<td>';
        echo '<input type="number" name="scores[' . $student_id . '][' . $theme['theme_id'] . ']" min="2" max="9" step="1" class="form-control score-input" value="' . ($theme['score'] !== null ? htmlspecialchars(round($theme['score'])) : '') . '">';
        
        if ($theme['score'] !== null):
            echo '<div class="previous-score">Last updated: ' . htmlspecialchars($theme['date_assessed']) . '</div>';
        endif;

        echo '</td>';
    }
    echo '</tr>';
    }
