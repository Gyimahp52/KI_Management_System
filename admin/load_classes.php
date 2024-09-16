<?php
// load_classes.php
require_once 'db_connction.php';
// require_once 'StudentScoreService.php';

if (isset($_GET['school_id'])) {
    $school_id = intval($_GET['school_id']);
    // $classes = $studentScoreService->getClasses($school_id);
    $query = $pdo->prepare("SELECT class_id, class_name FROM classes WHERE school_id = ?");
// $query->execute([$schoolId]);
$classes = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($classes as $class) {
        echo "<option value='{$class['class_id']}'>{$class['class_name']}</option>";
    }
}

