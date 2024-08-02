<?php
// student_sel_scores.php

// Include database connection
require_once 'db_connection.php';

// Function to get schools
function getSchools() {
    global $pdo;
    $sql = "SELECT * FROM schools";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Function to get classes for a school
function getClasses($school_id) {
    global $pdo;
    $sql = "SELECT * FROM classes WHERE school_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$school_id]);
    return $stmt->fetchAll();
}

// Function to get students and their assigned themes with latest scores
function getStudentsWithThemesAndScores($class_id) {
    global $pdo;
    $sql = "
        SELECT s.student_id, s.name, 
               st.id AS theme_id, st.theme_name,
               ss.score, ss.date_assessed
        FROM students s
        JOIN classes c ON s.class_id = c.class_id
        JOIN school_themes sct ON c.school_id = sct.school_id
        JOIN sel_themes st ON sct.theme_id = st.id
        LEFT JOIN (
            SELECT student_id, theme_id, score, date_assessed,
                   ROW_NUMBER() OVER (PARTITION BY student_id, theme_id ORDER BY date_assessed DESC) as rn
            FROM student_scores
        ) ss ON s.student_id = ss.student_id AND st.id = ss.theme_id AND ss.rn = 1
        WHERE s.class_id = ?
        ORDER BY s.student_id, st.id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$class_id]);
    return $stmt->fetchAll(PDO::FETCH_GROUP);
}

$schools = getSchools();
$classes = [];
$students = [];

if (isset($_GET['school_id'])) {
    $classes = getClasses($_GET['school_id']);
}

if (isset($_GET['class_id'])) {
    $students = getStudentsWithThemesAndScores($_GET['class_id']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scores = $_POST['scores'] ?? [];
    $date_assessed = date('Y-m-d'); // Current date

    // Get current term
    $stmt = $pdo->query("SELECT id FROM terms WHERE start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY start_date DESC LIMIT 1");
    $current_term_id = $stmt->fetchColumn();

    if (!$current_term_id) {
        die("No active term found. Please check the term dates.");
    }

    $pdo->beginTransaction();

    try {
        $update_stmt = $pdo->prepare("
            UPDATE student_scores 
            SET score = ?, date_assessed = ?
            WHERE student_id = ? AND theme_id = ? AND term_id = ?
        ");
        
        $insert_stmt = $pdo->prepare("
            INSERT INTO student_scores (student_id, theme_id, score, date_assessed, term_id)
            SELECT ?, ?, ?, ?, ?
            WHERE NOT EXISTS (
                SELECT 1 FROM student_scores
                WHERE student_id = ? AND theme_id = ? AND term_id = ?
            )
        ");
        
        foreach ($scores as $student_id => $theme_scores) {
            foreach ($theme_scores as $theme_id => $score) {
                if ($score !== '' && is_numeric($score) && $score >= 2 && $score <= 9) {
                    // Try to update existing score
                    $update_stmt->execute([$score, $date_assessed, $student_id, $theme_id, $current_term_id]);
                    
                    // If no rows were updated, insert a new score
                    if ($update_stmt->rowCount() == 0) {
                        $insert_stmt->execute([
                            $student_id, $theme_id, $score, $date_assessed, $current_term_id,
                            $student_id, $theme_id, $current_term_id
                        ]);
                    }
                }
            }
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("An error occurred while saving the scores: " . $e->getMessage());
    }

    // Refresh the students data after saving
    $students = getStudentsWithThemesAndScores($_GET['class_id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student SEL Scores</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="number"] {
            width: 50px;
        }
        .previous-score {
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Student SEL Scores</h1>
    
    <form method="GET">
        <select name="school_id" onchange="this.form.submit()">
            <option value="">Select School</option>
            <?php foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>" <?php echo (isset($_GET['school_id']) && $_GET['school_id'] == $school['id']) ? 'selected' : ''; ?>><?php echo $school['school_name']; ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($classes)): ?>
        <form method="GET">
            <input type="hidden" name="school_id" value="<?php echo $_GET['school_id']; ?>">
            <select name="class_id" onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?php echo $class['class_id']; ?>" <?php echo (isset($_GET['class_id']) && $_GET['class_id'] == $class['class_id']) ? 'selected' : ''; ?>><?php echo $class['class_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    <?php endif; ?>

    <?php if (!empty($students)): ?>
        <form method="POST">
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <?php 
                    $first_student = reset($students);
                    foreach ($first_student as $theme) {
                        echo "<th>" . htmlspecialchars($theme['theme_name']) . "</th>";
                    }
                    ?>
                </tr>
                <?php foreach ($students as $student_id => $themes): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student_id); ?></td>
                        <td><?php echo htmlspecialchars($themes[0]['name']); ?></td>
                        <?php foreach ($themes as $theme): ?>
                            <td>
                                <input type="number" name="scores[<?php echo $student_id; ?>][<?php echo $theme['theme_id']; ?>]" min="2" max="9" value="<?php echo htmlspecialchars($theme['score'] ?? ''); ?>">
                                <?php if ($theme['score'] !== null): ?>
                                    <div class="previous-score">
                                        Last updated: <?php echo htmlspecialchars($theme['date_assessed']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input type="submit" value="Save Scores">
        </form>
    <?php endif; ?>

</body>
</html>