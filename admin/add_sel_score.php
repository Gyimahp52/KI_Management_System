<?php
// add_sel_score.php

require_once 'db_connection.php';

// Initialize variables
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$errors = [];
$success_message = '';

// Function definitions
function getStudent($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    return $stmt->fetch();
}

function getAssignedThemes($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT st.* FROM sel_themes st
        JOIN school_themes sct ON st.id = sct.theme_id
        JOIN classes c ON c.school_id = sct.school_id
        JOIN students s ON s.class_id = c.class_id
        WHERE s.student_id = ?
    ");
    $stmt->execute([$student_id]);
    return $stmt->fetchAll();
}

function getExistingScores($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT theme_id, score, date_assessed 
        FROM student_scores 
        WHERE student_id = ? 
        ORDER BY date_assessed DESC
    ");
    $stmt->execute([$student_id]);
    return $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
}

// Validate student ID
if ($student_id <= 0) {
    die("Invalid student ID");
}

$student = getStudent($student_id);
if (!$student) {
    die("Student not found");
}

$themes = getAssignedThemes($student_id);
$existing_scores = getExistingScores($student_id);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $scores = $_POST['scores'] ?? [];
    $date_assessed = $_POST['date_assessed'] ?? '';

    $stmt = $pdo->query("SELECT id FROM terms WHERE start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY start_date DESC LIMIT 1");
    $current_term_id = $stmt->fetchColumn();

    if (!$current_term_id) {
        $errors[] = "No active term found. Please check the term dates.";
    }

    // Validate input
    if (empty($date_assessed) || !strtotime($date_assessed)) {
        $errors[] = "Please enter a valid assessment date.";
    }

    foreach ($scores as $theme_id => $score) {
        if ($score !== '' && (!is_numeric($score) || $score < 0 || $score > 100)) {
            $errors[] = "Invalid score for theme ID $theme_id. Scores must be between 0 and 100.";
        }
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();


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
        
        foreach ($scores as $theme_id => $score) {
            if ($score !== '') {
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

            $pdo->commit();
            $success_message = "Scores updated successfully.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = "An error occurred while saving the scores: " . $e->getMessage();
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit Student SEL Scores</title>
</head>
<body>
    <h1>Add/Edit SEL Scores</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div style="color: green;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <h2>Student: <?php echo htmlspecialchars($student['name']); ?></h2>

    <form method="POST">
        <label for="date_assessed">Date Assessed:</label>
        <input type="date" id="date_assessed" name="date_assessed" required><br><br>

        <?php foreach ($themes as $theme): ?>
            <label for="score_<?php echo $theme['id']; ?>"><?php echo htmlspecialchars($theme['theme_name']); ?>:</label>
            <input type="number" id="score_<?php echo $theme['id']; ?>" name="scores[<?php echo $theme['id']; ?>]" 
                   min="0" max="100" step="0.01" value="<?php echo isset($existing_scores[$theme['id']][0]['score']) ? htmlspecialchars($existing_scores[$theme['id']][0]['score']) : ''; ?>"><br>
            <?php if (!empty($existing_scores[$theme['id']])): ?>
                <small>Previous scores: 
                <?php foreach (array_slice($existing_scores[$theme['id']], 0, 3) as $score): ?>
                    <?php echo htmlspecialchars($score['score']) . ' (' . htmlspecialchars($score['date_assessed']) . ') '; ?>
                <?php endforeach; ?>
                </small><br>
            <?php endif; ?>
            <br>
        <?php endforeach; ?>

        <input type="submit" value="Save Scores">
    </form>

    <a href="student_sel_scores.php">Back to Student List</a>
</body>
</html>


let's remove the add or view score. rathe we want to fetch