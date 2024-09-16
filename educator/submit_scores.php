<?php
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';

$pdo = dbConnect();



$studentScoreService = new StudentScoreService($pdo);

$students = $studentScoreService->getStudentsWithThemesAndScores($class_id, $searchQuery);

$message = '';

// Check if the user is logged in and is an educator
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'educator') {
    header('Location: index.php');
    exit();
}

$educatorEmail = $_SESSION['user_email'];
// $pdo = dbConnect();

// Fetch educator's school_id
$stmt = $pdo->prepare('SELECT e.school_id FROM educators e JOIN users u ON e.email = u.email WHERE u.email = ?');
$stmt->execute([$educatorEmail]);
$educator = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$educator) {
    header('Location: error.php');
    exit();
}

$schoolId = $educator['school_id'];

$term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}



$classes = $studentScoreService->getClasses($schoolId);

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
foreach ($classes as $class) {
    $class_id = $class['class_id'];  // Extract class_id
    $students = $studentScoreService->getStudentsWithThemesAndScores($class_id, $searchQuery);
    
    // Handle or display results for each class
    // var_dump($students);
}

// $students = $studentScoreService->getStudentsWithThemesAndScores($classes, $searchQuery);
// Fetch SEL themes
// $stmt = $pdo->prepare('SELECT id, theme_name FROM sel_themes');
// $stmt->execute();
// $themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educator Dashboard</title>
    <link rel="stylesheet" href="css/educator_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>Educator Dashboard</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div id="class-cards">
            <h2>Classes</h2>
            <div class="card-container">
                <?php foreach ($classes as $class): ?>
                    <div class="card" data-class-id="<?= $class['class_id'] ?>">
                        <h3><?= htmlspecialchars($class['class_name']) ?></h3>
                        <p>Students: <?= $class['student_count'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="student-scores" style="display: none;">
            <button id="back-button">Back to Classes</button>
            <h2>Student Scores</h2>
            <form method="GET" class="search-bar">
                    <input type="text" name="search" id="student-search" class="form-control search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
                </form>
            <form id="score-form">
                <table  id="students-table">
                    <thead>
                    <th>Student ID</th>
                    <th>Name</th>
                                    <?php 
                            $first_student = reset($students);

                            if ($first_student && is_array($first_student)) {
                                // echo $first_student;
                                foreach ($first_student as $theme) {
                                    // echo $theme;
                                    echo "<th>" . htmlspecialchars($theme['theme_name']) . "</th>";
                                }
                            } else {
                                echo "<th>No themes available</th>";
                            }
                                    ?>
                    </thead>
                    <tbody id="student-list">
                        
                        <!-- Student rows will be dynamically added here -->
                    </tbody>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="#" class="page-link <?= $i === $currentPage ? 'active' : '' ?>" data-page="<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <button type="submit" id="submit-scores">Submit Scores</button>
            </form>
        </div>
    </main>

    <script>
    $(document).ready(function() {
        $('.card').click(function() {
            var classId = $(this).data('class-id');
            loadStudents(classId);
        });

        $('#back-button').click(function() {
            $('#student-scores').hide();
            $('#class-cards').show();
        });

        $('#score-form').submit(function(e) {
            e.preventDefault();
            submitScores();
        });

        // function loadStudents(classId) {
        //     $.ajax({
        //         url: 'get_students.php',
        //         method: 'GET',
        //         data: { class_id: classId },
        //         success: function(response) {
        //             $('#student-list').html(response);
        //             $('#class-cards').hide();
        //             $('#student-scores').show();
        //         }
        //     });
        // }

        function loadStudents(classId, page = 1) {
        $.ajax({
            url: 'get_students.php',
            method: 'GET',
            data: { class_id: classId, page: page },
            success: function(response) {
                $('#student-list').html(response);
                $('#class-cards').hide();
                $('#student-scores').show();
                updatePagination(classId, page);
            }
        });
    }

    function updatePagination(classId, currentPage) {
        $('.pagination').on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadStudents(classId, page);
        });
    }

        function submitScores() {
            var formData = $('#score-form').serialize();
            $.ajax({
                url: 'submit_scores.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Scores submitted successfully');
                    $('#student-scores').hide();
                    $('#class-cards').show();
                }
            });
        }
    });



    document.addEventListener('DOMContentLoaded', function() {
    var studentSearch = document.getElementById('student-search');
    var studentsTable = document.getElementById('students-table');

    if (studentSearch && studentsTable) {
        studentSearch.addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            var rows = studentsTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var studentId = rows[i].cells[0].textContent.toLowerCase();
                var studentName = rows[i].cells[1].textContent.toLowerCase();

                if (studentId.includes(searchQuery) || studentName.includes(searchQuery)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    }
});
    </script>
</body>
</html>