<?php
// combined_scores.php

require_once 'db_connction.php';
require_once 'StudentScoreService.php';

session_start(); // Start the session

$studentScoreService = new StudentScoreService($pdo);

// Fetching data for student_sel_scores.php
$schools = $studentScoreService->getSchools();
$classes = [];
$students = [];
$message = '';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}

if (isset($_GET['school_id'])) {
    $classes = $studentScoreService->getClasses($_GET['school_id']);
}

if (isset($_GET['class_id'])) {
    $students = $studentScoreService->getStudentsWithThemesAndScores($_GET['class_id']);
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['view']) && $_POST['view'] === 'enter') {
//     $scores = $_POST['scores'] ?? [];
//     $current_term_id = $studentScoreService->getCurrentTermId();

//     if (!$current_term_id) {
//         $_SESSION['message'] = "Error: No active term found. Please check the term dates.";
//     } else {
//         try {
//             $studentScoreService->saveScores($scores, $current_term_id);
//             $_SESSION['message'] = "Scores saved successfully.";
//         } catch (Exception $e) {
//             $_SESSION['message'] = "Error: An error occurred while saving the scores: " . $e->getMessage();
//         }
//     }

//     // Redirect to the same page with GET request
//     $redirect_url = $_SERVER['PHP_SELF'] . '?school_id=' . $_GET['school_id'] . '&class_id=' . $_GET['class_id'] . '&view=enter';
//     header('Location: ' . $redirect_url);
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['view']) && $_POST['view'] === 'enter') {
    $scores = $_POST['scores'] ?? [];
    $current_term_id = $studentScoreService->getCurrentTermId();

    if (!$current_term_id) {
        $_SESSION['message'] = "Error: No active term found. Please check the term dates.";
    } else {
        try {
            $studentScoreService->saveScores($scores, $current_term_id);
            $_SESSION['message'] = "Scores saved successfully.";
        } catch (Exception $e) {
            $_SESSION['message'] = "Error: An error occurred while saving the scores: " . $e->getMessage();
        }
    }

    // Redirect to prevent form resubmission
    $redirect_url = $_SERVER['PHP_SELF'] . '?school_id=' . $_GET['school_id'] . '&class_id=' . $_GET['class_id'] . '&view=enter';
    header('Location: ' . $redirect_url);
    exit();
}

// Fetching data for view_sel_score.php
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

$viewSchools = getSchools();
$viewClasses = [];
$academic_years = getAcademicYears();
$terms = [];
$viewStudents = [];

if (isset($_GET['view_school_id'])) {
    $viewClasses = getClasses($_GET['view_school_id']);
}

if (isset($_GET['academic_year_id'])) {
    $terms = getTerms($_GET['academic_year_id']);
}

if (isset($_GET['view_class_id']) && isset($_GET['term_id'])) {
    $viewStudents = getStudents($_GET['view_class_id'], $_GET['term_id']);
}

$view = isset($_GET['view']) ? $_GET['view'] : 'enter'; // Default view is 'enter'

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student SEL Scores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .score-input {
            width: 60px;
        }
        .previous-score {
            font-size: 0.8em;
            color: #6c757d;
        }
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
        function toggleView(view) {
            document.getElementById('enter-scores-view').style.display = view === 'enter' ? 'block' : 'none';
            document.getElementById('view-scores-view').style.display = view === 'view' ? 'block' : 'none';
            document.getElementById('current-view').value = view;
        }

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

        window.onload = function() {
            toggleView('<?php echo $view; ?>');
        }
    </script>
</head>
<body>

<?php include_once('includes/side_bar.php');?>


.

    <div class="container mt-5 main-contnt">

        <?php include_once('includes/header.php');?>


        <h1 class="mb-4">Student SEL Scores</h1>

        <div class="mb-3">
            <button class="btn btn-primary" onclick="toggleView('enter')">Enter Scores</button>
            <button class="btn btn-secondary" onclick="toggleView('view')">View Scores</button>
        </div>

        <input type="hidden" id="current-view" name="view" value="<?php echo htmlspecialchars($view); ?>">

        <div id="enter-scores-view" style="display: none;">
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($message, 'Error') === 0 ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="GET" class="mb-3">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="school_id" class="col-form-label">Select School:</label>
                    </div>
                    <div class="col-auto">
                        <select name="school_id" id="school_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select School</option>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?php echo $school['id']; ?>" <?php echo (isset($_GET['school_id']) && $_GET['school_id'] == $school['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($school['school_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="view" value="enter">
                    </div>
                </div>
            </form>

            <?php if (!empty($classes)): ?>
                <form method="GET" class="mb-3">
                    <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id']); ?>">
                    <input type="hidden" name="view" value="enter">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="class_id" class="col-form-label">Select Class:</label>
                        </div>
                        <div class="col-auto">
                            <select name="class_id" id="class_id" class="form-select" onchange="this.form.submit()">
                                <option value="">Select Class</option>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?php echo $class['class_id']; ?>" <?php echo (isset($_GET['class_id']) && $_GET['class_id'] == $class['class_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

            <?php if (!empty($students)): ?>
                <form method="POST">
                    <input type="hidden" name="view" value="enter">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
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
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student_id => $themes): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student_id); ?></td>
                                        <td><?php echo htmlspecialchars($themes[0]['name']); ?></td>
                                        <?php foreach ($themes as $theme): ?>
                                            <td>
                                                <input type="number" name="scores[<?php echo $student_id; ?>][<?php echo $theme['theme_id']; ?>]" min="2" max="9" step="1" class="form-control score-input" value="<?php echo $theme['score'] !== null ? htmlspecialchars(round($theme['score'])) : ''; ?>">
                                                <?php if ($theme['score'] !== null): ?>
                                                    <div class="previous-score">
                                                        Last updated: <?php echo htmlspecialchars($theme['date_assessed']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Scores</button>
                </form>
            <?php endif; ?>
        </div>

        <div id="view-scores-view" style="display: none;">
            <form method="GET">
                <select class="form-select" name="view_school_id" onchange="this.form.submit()">
                    <option value="">Select School</option>
                    <?php foreach ($viewSchools as $school): ?>
                        <option value="<?php echo $school['id']; ?>" <?php echo (isset($_GET['view_school_id']) && $_GET['view_school_id'] == $school['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($school['school_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="view" value="view">
            </form>

            <?php if (!empty($viewClasses)): ?>
                <form method="GET">
                    <input type="hidden" name="view_school_id" value="<?php echo $_GET['view_school_id']; ?>">
                    <input type="hidden" name="view" value="view">
                    <select name="view_class_id" class="form-select">
                        <option value="">Select Class</option>
                        <?php foreach ($viewClasses as $class): ?>
                            <option value="<?php echo $class['class_id']; ?>" <?php echo (isset($_GET['view_class_id']) && $_GET['view_class_id'] == $class['class_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="form-select" name="academic_year_id" id="academic_year_id" onchange="updateTerms()">
                        <option value="">Select Academic Year</option>
                        <?php foreach ($academic_years as $year): ?>
                            <option value="<?php echo $year['id']; ?>" <?php echo (isset($_GET['academic_year_id']) && $_GET['academic_year_id'] == $year['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($year['year_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select class="form-select" name="term_id" id="term_id">
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

            <?php if (!empty($viewStudents)): ?>
                <table>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Term</th>
                        <th>Report</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($viewStudents as $student): ?>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/adminDashboard.js"></script>
<script src="assets/js/scripts.j"></script>
<script src="/admin/assets/js/adminDashboard.js"></script>
</body>
</html>
