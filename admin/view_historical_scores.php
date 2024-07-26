<?php
// view_historical_scores.php

require_once 'db_connection.php';

// Function to get all schools
function getSchools() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, school_name FROM schools ORDER BY school_name");
    return $stmt->fetchAll();
}

// Function to get classes for a school
function getClasses($school_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT class_id, class_name FROM classes WHERE school_id = ? ORDER BY class_name");
    $stmt->execute([$school_id]);
    return $stmt->fetchAll();
}

// Function to get academic years
function getAcademicYears() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, year_name FROM academic_years ORDER BY start_date DESC");
    return $stmt->fetchAll();
}

// Function to get terms for an academic year
function getTerms($academic_year_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, term_number FROM terms WHERE academic_year_id = ? ORDER BY start_date");
    $stmt->execute([$academic_year_id]);
    return $stmt->fetchAll();
}


function getHistoricalScores($class_id, $term_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT s.name AS student_name, st.theme_name, hs.score, hs.date_assessed
        FROM students s
        JOIN historical_student_scores hs ON s.student_id = hs.student_id
        JOIN sel_themes st ON hs.theme_id = st.id
        WHERE s.class_id = ? AND hs.term_id = ?
        ORDER BY s.name, hs.date_assessed DESC
    ");
    $stmt->execute([$class_id, $term_id]);
    return $stmt->fetchAll();
}

$schools = getSchools();
$classes = [];
$academic_years = getAcademicYears();
$terms = [];
$historical_scores = [];

if (isset($_GET['school_id'])) {
    $classes = getClasses($_GET['school_id']);
}

if (isset($_GET['academic_year_id'])) {
    $terms = getTerms($_GET['academic_year_id']);
}

if (isset($_GET['class_id']) && isset($_GET['term_id'])) {
    $historical_scores = getHistoricalScores($_GET['class_id'], $_GET['term_id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical SEL Scores</title>
</head>
<body>
    <h1>Historical SEL Scores</h1>
    
    <form method="GET">
        <select name="school_id" onchange="this.form.submit()">
            <option value="">Select School</option>
            <?php foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>" <?php echo (isset($_GET['school_id']) && $_GET['school_id'] == $school['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($school['school_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($classes)): ?>
        <form method="GET">
            <input type="hidden" name="school_id" value="<?php echo $_GET['school_id']; ?>">
            <select name="class_id">
                <option value="">Select Class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['class_id']; ?>" <?php echo (isset($_GET['class_id']) && $_GET['class_id'] == $class['class_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="academic_year_id" onchange="this.form.submit()">
                <option value="">Select Academic Year</option>
                <?php foreach ($academic_years as $year): ?>
                    <option value="<?php echo $year['id']; ?>" <?php echo (isset($_GET['academic_year_id']) && $_GET['academic_year_id'] == $year['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($year['year_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($terms)): ?>
                <select name="term_id">
                    <option value="">Select Term</option>
                    <?php foreach ($terms as $term): ?>
                        <option value="<?php echo $term['id']; ?>" <?php echo (isset($_GET['term_id']) && $_GET['term_id'] == $term['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($term['term_number']); ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <button type="submit">View Historical Scores</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($historical_scores)): ?>
        <table border="1">
            <tr>
                <th>Student Name</th>
                <th>Theme</th>
                <th>Score</th>
                <th>Date Assessed</th>
            </tr>
            <?php foreach ($historical_scores as $score): ?>
                <tr>
                    <td><?php echo htmlspecialchars($score['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($score['theme_name']); ?></td>
                    <td><?php echo htmlspecialchars($score['score']); ?></td>
                    <td><?php echo htmlspecialchars($score['date_assessed']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_GET['class_id']) && isset($_GET['term_id'])): ?>
        <p>No historical scores found for the selected class and term.</p>
    <?php endif; ?>

</body>
</html>