<?php
// view_sel_score.php

require_once 'db_connection.php';

function getSchools() {
    global $pdo;
    $sql = "SELECT * FROM schools ORDER BY school_name";
    return $pdo->query($sql)->fetchAll();
}

function getClasses($school_id) {
    global $pdo;
    $sql = "SELECT * FROM classes WHERE school_id = ? ORDER BY class_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$school_id]);
    return $stmt->fetchAll();
}

function getAcademicYears() {
    global $pdo;
    $sql = "SELECT * FROM academic_years ORDER BY start_date DESC";
    return $pdo->query($sql)->fetchAll();
}

function getTerms($academic_year_id) {
    global $pdo;
    $sql = "SELECT * FROM terms WHERE academic_year_id = ? ORDER BY start_date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$academic_year_id]);
    return $stmt->fetchAll();
}

function getStudents($class_id, $term_id) {
    global $pdo;
    $sql = "
        SELECT DISTINCT s.student_id, s.name, t.term_number, t.id as term_id, ay.year_name
        FROM students s
        JOIN student_scores ss ON s.student_id = ss.student_id
        JOIN terms t ON ss.term_id = t.id
        JOIN academic_years ay ON t.academic_year_id = ay.id
        WHERE s.class_id = ? AND t.id = ?
        ORDER BY s.name
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$class_id, $term_id]);
    return $stmt->fetchAll();
}

$schools = getSchools();
$classes = [];
$academic_years = getAcademicYears();
$terms = [];
$students = [];

if (isset($_GET['school_id'])) {
    $classes = getClasses($_GET['school_id']);
}

if (isset($_GET['academic_year_id'])) {
    $terms = getTerms($_GET['academic_year_id']);
}

if (isset($_GET['class_id']) && isset($_GET['term_id'])) {
    $students = getStudents($_GET['class_id'], $_GET['term_id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student SEL Scores</title>
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
        .action-button {
            margin-right: 5px;
        }
    </style>
    <script>
        function updateTerms() {
            var academicYearSelect = document.getElementById('academic_year_id');
            var termSelect = document.getElementById('term_id');
            var selectedAcademicYear = academicYearSelect.value;

            // Clear existing options
            termSelect.innerHTML = '<option value="">Select Term</option>';

            if (selectedAcademicYear) {
                // Use AJAX to fetch terms for the selected academic year
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var terms = JSON.parse(this.responseText);
                        terms.forEach(function(term) {
                            var option = document.createElement('option');
                            option.value = term.id;
                            option.textContent = term.term_number;
                            termSelect.appendChild(option);
                        });
                    }
                };
                xhr.open('GET', 'get_terms.php?academic_year_id=' + selectedAcademicYear, true);
                xhr.send();
            }
        }
    </script>
</head>
<body>
    <h1>View Student SEL Scores</h1>
    
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
            <select name="academic_year_id" id="academic_year_id" onchange="updateTerms()">
                <option value="">Select Academic Year</option>
                <?php foreach ($academic_years as $year): ?>
                    <option value="<?php echo $year['id']; ?>" <?php echo (isset($_GET['academic_year_id']) && $_GET['academic_year_id'] == $year['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($year['year_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <select name="term_id" id="term_id">
                <option value="">Select Term</option>
                <?php if (!empty($terms)): ?>
                    <?php foreach ($terms as $term): ?>
                        <option value="<?php echo $term['id']; ?>" <?php echo (isset($_GET['term_id']) && $_GET['term_id'] == $term['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($term['term_number']); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <input type="submit" value="View Students">
        </form>
    <?php endif; ?>

    <?php if (!empty($students)): ?>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Academic Year</th>
                <th>Term</th>
                <th>Report</th>
                <th>Action</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['year_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['term_number']); ?></td>
                    <td>
                        <a href="view_report.php?student_id=<?php echo $student['student_id']; ?>&term_id=<?php echo $student['term_id']; ?>" class="action-button">View</a>
                    </td>
                    <td>
                        <a href="delete_report.php?student_id=<?php echo $student['student_id']; ?>&term_id=<?php echo $student['term_id']; ?>" class="action-button" onclick="return confirm('Are you sure you want to delete this report?');">Delete</a>
                        <a href="download_report.php?student_id=<?php echo $student['student_id']; ?>&term_id=<?php echo $student['term_id']; ?>" class="action-button">Download</a>
                        <a href="whatsapp_report.php?student_id=<?php echo $student['student_id']; ?>&term_id=<?php echo $student['term_id']; ?>" class="action-button">WhatsApp</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>