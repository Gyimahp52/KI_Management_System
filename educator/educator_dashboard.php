<?php
//educator_dashboard
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';

$pdo = dbConnect();

$studentScoreService = new StudentScoreService($pdo);


$message = '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
// Check if the user is logged in and is an educator
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'educator') {
    header('Location: index.php');
    exit();
}

$educatorEmail = $_SESSION['user_email'];

// Fetch educator's school_id
$stmt = $pdo->prepare('SELECT e.school_id FROM educators e JOIN users u ON e.email = u.email WHERE u.email = ?');
$stmt->execute([$educatorEmail]);
$educator = $stmt->fetch(PDO::FETCH_ASSOC);


// Check for Educator
if (!$educator) {
    header('Location: error.php');
    exit();
}

$schoolId = $educator['school_id'];
$classId = isset($_GET['class_id']) ? intval($_GET['class_id']) : null;
// $term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}



$classes = $studentScoreService->getClasses($schoolId);
$themes = getThemes($schoolId);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educator Dashboard</title>
    <link rel="stylesheet" href="css/educator_dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
            .pagination-link {
                display: inline-block;
                padding: 5px 10px;
                margin: 0 2px;
                border: 1px solid #ddd;
                color: #333;
                text-decoration: none;
            }

            .pagination-link.active {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
            }

            #pagination {
                margin-top: 20px;
                text-align: center;
            }
    </style>
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
        <div id="class-cards" <?php echo $classId ? 'style="display: none;"' : ''; ?>>
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

       <div id="student-scores" <?php echo $classId ? '' : 'style="display: none;"'; ?>>
            <button id="back-button">Back to Classes</button>
            <h2 id="class-name"></h2>
            <form method="GET" class="search-bar">
                <input type="hidden" name="class_id" value="<?php echo $classId; ?>">
                <input type="text" name="search" id="student-search" class="form-control search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
            </form>
            <form id="score-form">
                <table id="students-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <?php foreach ($themes as $theme): ?>
                                <th><?= htmlspecialchars($theme['theme_name']) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody id="student-list">
                        <!-- Student rows will be dynamically added here -->
                    </tbody>
                </table>
                <div id="pagination"></div>
                <button type="submit" id="submit-scores">Submit Scores</button>
            </form>
        </div>
    </main>

    <script>
    $(document).ready(function() {
        var currentClassId = <?php echo $classId ?: 'null'; ?>;

        $('.card').click(function() {
            var classId = $(this).data('class-id');
            loadStudents(classId, 1);
        });

        $('#back-button').click(function() {
            $('#student-scores').hide();
            $('#class-cards').show();
            history.pushState(null, '', 'educator_dashboard.php');
        });

        $('#score-form').submit(function(e) {
            e.preventDefault();
            submitScores();
        });

        function loadStudents(classId, page) {
            $.ajax({
                url: 'get_students.php',
                method: 'GET',
                data: { 
                    class_id: classId, 
                    page: page,
                    search: $('#student-search').val()
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#class-name').text(data.className);
                    $('#student-list').html(data.studentsHtml);
                    $('#pagination').html(data.pagination);
                    $('#class-cards').hide();
                    $('#student-scores').show();
                    currentClassId = classId;
                    history.pushState(null, '', 'educator_dashboard.php?class_id=' + classId + '&page=' + page);
                }
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
                    loadStudents(currentClassId, 1);
                }
            });
        }

        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadStudents(currentClassId, page);
        });

        // Load students if class_id is set in URL
        if (currentClassId) {
            loadStudents(currentClassId, <?php echo $page; ?>);
        }
    });

// live search
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