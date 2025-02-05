<?php
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}


// function getStudents($class_id, $term_id, $searchQuery = '', $page = 1, $perPage = 10) {
//     global $pdo;
//     $offset = ($page - 1) * $perPage;
    
//     $sql = "
//         SELECT s.student_id, s.name, t.term_number, t.id as term_id, ay.year_name
//         FROM students s
//         LEFT JOIN student_scores ss ON s.student_id = ss.student_id AND ss.term_id = ?
//         JOIN terms t ON t.id = ?
//         JOIN academic_years ay ON t.academic_year_id = ay.id
//         WHERE s.class_id = ? AND (s.student_id LIKE ? OR s.name LIKE ?)
//         GROUP BY s.student_id, s.name, t.term_number, t.id, ay.year_name
//         ORDER BY s.name
//         LIMIT ? OFFSET ?
//     ";
    
//     $stmt = $pdo->prepare($sql);
//     $searchParam = '%' . $searchQuery . '%';
//     $stmt->execute([$term_id, $term_id, $class_id, $searchParam, $searchParam, $perPage, $offset]);
    
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }


// function getStudentCount($class_id, $term_id, $searchQuery = '') {
//     global $pdo;
    
//     // Count the total number of distinct students in the class for the given term
//     $sql = "
//         SELECT COUNT(DISTINCT s.student_id) as count
//         FROM students s
//         LEFT JOIN student_scores ss ON s.student_id = ss.student_id AND ss.term_id = ?
//         WHERE s.class_id = ? AND (s.student_id LIKE ? OR s.name LIKE ?)
//     ";
    
//     $stmt = $pdo->prepare($sql);
//     $searchParam = '%' . $searchQuery . '%';
//     $stmt->execute([$term_id, $class_id, $searchParam, $searchParam]);
//     return $stmt->fetchColumn();
// }


function getClassName($class_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT class_name FROM classes WHERE class_id = ?");
    $stmt->execute([$class_id]);
    return $stmt->fetchColumn();
}

function getThemes($school_id) {
    global $pdo;
    $sql = "
        SELECT st.id AS theme_id, st.theme_name, sct.order
        FROM school_themes sct
        JOIN sel_themes st ON sct.theme_id = st.id
        JOIN classes c ON sct.school_id = c.school_id
        WHERE c.class_id = ?
        ORDER BY sct.order
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$school_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCurrentTerm($pdo) {
    // Get the latest term based on the most recent end date
    $sql = "
        SELECT 
            t.id AS term_id, 
            t.term_number, 
            t.start_date, 
            t.end_date,
            ay.id AS academic_year_id,
            ay.year_name
        FROM terms t
        JOIN academic_years ay ON t.academic_year_id = ay.id
        ORDER BY t.end_date DESC
        LIMIT 1
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error finding current term: " . $e->getMessage());
        return null;
    }
}

function validateTermSelection($pdo, $requestedTermId = null) {
    // If no term specified, get current term
    if ($requestedTermId === null) {
        $currentTerm = getCurrentTerm($pdo);
        return $currentTerm ? $currentTerm['term_id'] : null;
    }

    // Validate requested term exists
    $sql = "SELECT id FROM terms WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$requestedTermId]);
    
    return $stmt->fetchColumn() ?: null;
}