<?php
//functions.php
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function isEducator($userId) {
    $pdo = dbConnect();
    $stmt = $pdo->prepare('SELECT role FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user && $user['role'] === 'educator';
};

function getStudents($class_id, $term_id, $searchQuery = '') {
    global $pdo;
    $sql = "
        SELECT DISTINCT s.student_id, s.name, t.term_number, t.id as term_id, ay.year_name
        FROM students s
        JOIN student_scores ss ON s.student_id = ss.student_id
        JOIN terms t ON ss.term_id = t.id
        JOIN academic_years ay ON t.academic_year_id = ay.id
        WHERE s.class_id = ? AND t.id = ? AND (s.student_id LIKE ? OR s.name LIKE ?)
        ORDER BY s.name
    ";
    $stmt = $pdo->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $stmt->execute([$class_id, $term_id, $searchParam, $searchParam]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
