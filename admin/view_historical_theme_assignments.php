<?php
// view_historical_theme_assignments.php

require_once 'db_connection.php';

$school_id = isset($_GET['school_id']) ? intval($_GET['school_id']) : 0;

$stmt = $pdo->prepare("
    SELECT hta.*, s.name as school_name, st.theme_name, t.term_number, ay.year_name
    FROM historical_theme_assignments hta
    JOIN schools s ON hta.school_id = s.id
    JOIN sel_themes st ON hta.theme_id = st.id
    JOIN terms t ON hta.term_id = t.id
    JOIN academic_years ay ON hta.academic_year_id = ay.id
    WHERE hta.school_id = ?
    ORDER BY ay.start_date DESC, t.start_date DESC, st.theme_name
");
$stmt->execute([$school_id]);
$historical_assignments = $stmt->fetchAll();
