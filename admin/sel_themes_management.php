<?php
// sel_themes_management.php

require_once 'db_connection.php';

// Function to create a new SEL theme
function createSELTheme($theme_name, $competency, $character_strength) {
    global $pdo;
    $sql = "INSERT INTO sel_themes (theme_name, competency, character_strength) VALUES (:theme_name, :competency, :character_strength)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':theme_name' => $theme_name,
        ':competency' => $competency,
        ':character_strength' => $character_strength
    ]);
}

// Function to get all SEL themes
function getAllSELThemes() {
    global $pdo;
    $sql = "SELECT * FROM sel_themes";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}




function startNewTerm($academic_year_id, $term_number, $start_date, $end_date) {
    global $pdo;
    
    try {
        // Check if a term already exists for this academic year and term number
        $stmt = $pdo->prepare("SELECT id FROM terms WHERE academic_year_id = ? AND term_number = ?");
        $stmt->execute([$academic_year_id, $term_number]);
        $existing_term_id = $stmt->fetchColumn();
        
        if ($existing_term_id) {
            // Term already exists, inform the user and return false
            echo "A term with number $term_number already exists for this academic year. Please enter a new term number.";
            return false;
        }
        
        $pdo->beginTransaction();
        
        // Insert new term
        $stmt = $pdo->prepare("INSERT INTO terms (academic_year_id, term_number, start_date, end_date) VALUES (?, ?, ?, ?)");
        if (!$stmt->execute([$academic_year_id, $term_number, $start_date, $end_date])) {
            throw new Exception("Failed to insert new term.");
        }
        $new_term_id = $pdo->lastInsertId();
        
        // Get the current (soon to be previous) term ID
        $stmt = $pdo->prepare("SELECT id FROM terms WHERE id != ? ORDER BY start_date DESC LIMIT 1");
        $stmt->execute([$new_term_id]);
        $previous_term_id = $stmt->fetchColumn();
        
        // Move current student scores to historical scores
        $stmt = $pdo->prepare("
            INSERT INTO historical_student_scores (student_id, theme_id, score, date_assessed, term_id, academic_year_id)
            SELECT ss.student_id, ss.theme_id, ss.score, ss.date_assessed, ss.term_id, ?
            FROM student_scores ss
            WHERE ss.term_id = ?
        ");
        if (!$stmt->execute([$academic_year_id, $previous_term_id])) {
            throw new Exception("Failed to move student scores to historical records.");
        }
        
        // Clear current student scores
        $stmt = $pdo->prepare("DELETE FROM student_scores WHERE term_id = ?");
        if (!$stmt->execute([$previous_term_id])) {
            throw new Exception("Failed to clear current student scores.");
        }
        
        // Move current theme assignments to historical records
        $stmt = $pdo->prepare("
            INSERT INTO historical_school_themes (school_id, theme_id, term_id, academic_year_id)
            SELECT st.school_id, st.theme_id, st.term_id, ?
            FROM school_themes st
            WHERE st.term_id = ?
        ");
        if (!$stmt->execute([$academic_year_id, $previous_term_id])) {
            throw new Exception("Failed to move theme assignments to historical records.");
        }
        
        // Clear current theme assignments
        $stmt = $pdo->prepare("DELETE FROM school_themes WHERE term_id = ?");
        if (!$stmt->execute([$previous_term_id])) {
            throw new Exception("Failed to clear current theme assignments.");
        }
        
        $pdo->commit();
        return $new_term_id;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error starting new term: " . $e->getMessage());
        return false;
    }
}

function assignThemesToSchool($school_id, $theme_ids) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();

        // Get the current term
        $stmt = $pdo->query("SELECT id FROM terms ORDER BY start_date DESC LIMIT 1");
        $current_term_id = $stmt->fetchColumn();

        // Clear existing assignments for this school and term
        $stmt = $pdo->prepare("DELETE FROM school_themes WHERE school_id = ? AND term_id = ?");
        $stmt->execute([$school_id, $current_term_id]);

        // Insert the new theme assignments
        $insert_sql = "INSERT INTO school_themes (school_id, theme_id, term_id) VALUES (:school_id, :theme_id, :term_id)";
        $insert_stmt = $pdo->prepare($insert_sql);
        
        foreach ($theme_ids as $theme_id) {
            $insert_stmt->execute([
                ':school_id' => $school_id,
                ':theme_id' => $theme_id,
                ':term_id' => $current_term_id
            ]);
        }

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        return false;
    }
}

function getSchools() {
    global $pdo;
    $sql = "SELECT * FROM schools";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

$schools = getSchools();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_theme'])) {
        $theme_name = $_POST['theme_name'];
        $competency = $_POST['competency'];
        $character_strength = $_POST['character_strength'];
        createSELTheme($theme_name, $competency, $character_strength);
    } elseif (isset($_POST['assign_themes'])) {
        $school_id = $_POST['school_id'];
        $theme_ids = $_POST['theme_ids'];
        assignThemesToSchool($school_id, $theme_ids);
    } elseif (isset($_POST['start_new_term'])) {
        $academic_year_id = $_POST['academic_year_id'];
        $term_number = $_POST['term_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $new_term_id = startNewTerm($academic_year_id, $term_number, $start_date, $end_date);
        if ($new_term_id) {
            echo "New term started successfully. Please assign themes to schools for the new term.";
        } else {
            echo "Error starting new term. Please check the error log for more details.";
        }
    }
}

// Get all SEL themes
$sel_themes = getAllSELThemes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEL Themes Management</title>
</head>
<body>
    <h1>SEL Themes Management</h1>
    
    <h2>Create SEL Theme</h2>
    <form method="POST">
        <input type="text" name="theme_name" placeholder="Theme Name" required>
        <input type="text" name="competency" placeholder="Competency" required>
        <input type="text" name="character_strength" placeholder="Character Strength" required>
        <button type="submit" name="create_theme">Create Theme</button>
    </form>

    <h2>Start New Term</h2>
    <form method="POST">
        <select name="academic_year_id" required>
            <option value="">Select Academic Year</option>
            <?php
            $stmt = $pdo->query("SELECT id, year_name FROM academic_years ORDER BY start_date DESC");
            while ($row = $stmt->fetch()) {
                echo "<option value='{$row['id']}'>{$row['year_name']}</option>";
            }
            ?>
        </select>
        <select name="term_number" required>
            <option value="1">Term 1</option>
            <option value="2">Term 2</option>
            <option value="3">Term 3</option>
        </select>
        <input type="date" name="start_date" required>
        <input type="date" name="end_date" required>
        <button type="submit" name="start_new_term">Start New Term</button>
    </form>

    <h2>Assign SEL Themes to School</h2>
    <form method="POST">
        <select name="school_id" required>
            <option value="">Select School</option>
            <?php foreach ($schools as $school): ?>
                <option value="<?php echo $school['id']; ?>"><?php echo $school['school_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <div>
            <?php foreach ($sel_themes as $theme): ?>
                <label>
                    <input type="checkbox" name="theme_ids[]" value="<?php echo $theme['id']; ?>">
                    <?php echo $theme['theme_name']; ?>
                </label>
            <?php endforeach; ?>
        </div>
        <button type="submit" name="assign_themes">Assign Themes</button>
    </form>

    <h2>Existing SEL Themes</h2>
    <table>
        <tr>
            <th>Theme Name</th>
            <th>Competency</th>
            <th>Character Strength</th>
        </tr>
        <?php foreach ($sel_themes as $theme): ?>
            <tr>
                <td><?php echo $theme['theme_name']; ?></td>
                <td><?php echo $theme['competency']; ?></td>
                <td><?php echo $theme['character_strength']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
