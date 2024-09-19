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

print_r($educator);


// $testEd = $_SESSION[$educator];

$_SESSION['school_id'] = $educator['school_id'];
// Check for Educator
if (!$educator) {
   echo $educator;
    header('Location: error.php');
    exit();
}

$schoolId = $educator['school_id'];
$educatorName = $educator['name'];
echo $educatorName;
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Educator's Dashboard</title>
  <link rel="stylesheet" href="assets/css/educator.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900&display=swap" />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                margin-bottom: 2rem;
            }
            .w-full {
    width: 50% !important;
}
.p-4 {
    padding: .5rem !important;
}
.mb-4 {
    margin-bottom: 0.5rem !important;
    margin-top: 3rem !important;
}
table {
    text-align: center !important;

    margin-right: 3rem !important;
}
  </style>
</head>
<body class="bg-[#F8F9FB] font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="sidebar w-64 bg-white p-4">
      <div class="flex flex-col items-center">
        <div class="profile-pic w-24 h-24 bg-cover bg-center rounded-full mb-4"></div>
        <h1 class="text-xl font-bold text-[#141C24]">Prince Gyimah</h1>
        <p class="text-sm text-[#3F5374]">KI Coach</p>
      </div>
      <nav class="mt-8">
        <ul>
          <li class="mb-4">
            <a href="#" id="profile-btn" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Profile</a>
          </li>
          <li class="mb-4">
            <a href="class.php" id="classes-btn" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Classes</a>
          </li>
          <li class="mb-4">
            <a href="#" id="photos-btn" class="flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Photos</a>
          </li>
        </ul>
      </nav>
      <button class="logout-btn w-full mt-8 py-2 bg-[#F4C753] text-[#141C24] text-sm font-bold rounded-lg" id="logout-btn">Logout</button>
    </div>

    <!-- Main content -->
    <div class="flex- p-2" id="main-content">
    
    <div id="class-cards" <?php echo $classId ? 'style="display: none;"' : ''; ?>>
      <h1 class="text-4xl font-bold text-[#141C24] mb-6">Classes</h1>
      <!-- classes Card -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="class-list">
          <?php foreach ($classes as $class): ?>
            <div class="class-item flex items-center gap-4 bg-white p-4 rounded-lg shadow hover:bg-[#E4E9F1] card" data-class-id="<?= $class['class_id'] ?>">
              <div class="p-3 bg-[#E4E9F1] rounded-lg flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256">
                  <path d="M240,208H224V96a16,16,0,0,0-16-16H144V32a16,16,0,0,0-24.88-13.32L39.12,72A16,16,0,0,0,32,85.34V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM208,96V208H144V96ZM48,85.34,128,32V208H48ZM112,112v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm-32,0v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm0,56v16a8,8,0,0,1-16,0V168a8,8,0,1,1,16,0Zm32,0v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Z"></path>
                </svg>
              </div>
              <div class="min-w-0">
                <p class="text-lg font-medium text-[#141C24] truncate"><?= htmlspecialchars($class['class_name']) ?></p>
                <p class="text-sm text-[#3F5374]">Students: <?= htmlspecialchars($class['student_count']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>
        <!-- Add more classes here as needed -->
    </div>

      <!-- Student Scores Table (hidden initially) -->
      <div id="student-scores" <?php echo $classId ? '' : 'style="display: none;"'; ?>>
        <div class="mb-4">
          <button class="mr-4 px-4 py-2 bg-[#E4E9F1] text-[#141C24] font-medium rounded-lg" id="back-button">Back</button>
          <button class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg" id="submit-scores-button">Submit Scores</button>
        </div>
        <h2 id="class-name" class="p-4"></h2>
        <form id="search-form" class="search-bar" onsubmit="return false;">
            <input type="hidden" name="class_id" value="<?php echo $classId; ?>">
            <input type="text" name="search" id="student-search" class="form-control search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
        </form>


          <form id="score-form" action="">
        <table id="students-table" class=" bg-white rounded-lg shadow overflow-hidden">
          <thead class="bg-[#E4E9F1]">
            <tr>
              <th class="p-4 text-left">#</th>
              <th class="p-4 text-left">Student Name</th>
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
        </form>
      </div>
    </div>
  </div>

  <!-- Notification Modal -->
  <div id="notification-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <h2 class="text-2xl font-bold mb-4">KI Education</h2>
      <p id="notification-message" class="mb-4">Please fill in all the scores.</p>
      <button id="close-notification" class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg">Close</button>
    </div>
  </div>

  <!-- Logout Confirmation Modal -->
  <div id="logout-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <h2 class="text-2xl font-bold mb-4">Logout Confirmation</h2>
      <p class="mb-4">Are you sure you want to logout?</p>
      <button id="confirm-logout" class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg mr-4">Yes</button>
      <button id="cancel-logout" class="px-4 py-2 bg-gray-300 text-[#141C24] font-bold rounded-lg">No</button>
    </div>
  </div>

  <!-- Photo Upload Modal -->
  <div id="upload-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
      <h2 class="text-2xl font-bold mb-4">Upload Photo</h2>
      <input type="file" id="upload-input" accept="image/*" class="mb-4" />
      <button id="upload-button" class="px-4 py-2 bg-[#F4C753] text-[#141C24] font-bold rounded-lg mr-4">Upload</button>
      <button id="cancel-upload" class="px-4 py-2 bg-gray-300 text-[#141C24] font-bold rounded-lg">Cancel</button>
    </div>
  </div>

  <!-- Image Preview Modal -->
  <div id="preview-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center relative">
      <img id="preview-image" src="" alt="Preview" class="mb-4 max-w-xs max-h-96" />
      <button id="close-preview" class="absolute top-2 right-2 bg-[#F4C753] text-[#141C24] font-bold rounded-full w-8 h-8">×</button>
    </div>
  </div>

  <!-- <script src="assets/js/educator.js"></script> -->

  
  <script>

    // document.getElementById('submit-scores-button').addEventListener('click', function(){
    //     document.getElementById('score-form').submit();
    // })
    $(document).ready(function() {
        var currentClassId = <?php echo $classId ?: 'null'; ?>;

        $('#submit-scores-button').click(function() {
            $('#score-form').submit(); // Programmatically submit the form
        });
        
        // Attach a handler to the search form
        $('#student-search').on('input', function() {
              performSearch();
          });

        // Disable default form submission for 'Enter' key in the search bar
        $('#search-form').on('submit', function(e) {
              e.preventDefault();
              performSearch();
          });
      
        // Function to perform the search and update the student list dynamically
        function performSearch() {
            var searchQuery = $('#student-search').val();
            var page = 1; // reset to first page for new search
            loadStudents(currentClassId, page, searchQuery);
          }


        $('.card').click(function() {
            var classId = $(this).data('class-id');
            loadStudents(classId, 1);
        });

        $('#back-button').click(function() {
            $('#student-scores').hide();
            $('#class-cards').show();
            history.pushState(null, '', 'educator.php');
        });

      
        $('#score-form').submit(function(e) {
            e.preventDefault();
            submitScores();
        });

    // Existing function to load students, but now we also pass search query
    function loadStudents(classId, page, searchQuery = '') {
        $.ajax({
            url: 'get_students.php',
            method: 'GET',
            data: { 
                class_id: classId, 
                page: page,
                search: searchQuery
            },
            success: function(response) {
                var data = JSON.parse(response);
                $('#class-name').text(data.className);
                $('#student-list').html(data.studentsHtml);
                $('#pagination').html(data.pagination);
                $('#class-cards').hide();
                $('#student-scores').show();
                currentClassId = classId;
                history.pushState(null, '', 'educator.php?class_id=' + classId + '&page=' + page + '&search=' + searchQuery);
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
//     document.addEventListener('DOMContentLoaded', function() {
//     var studentSearch = document.getElementById('student-search');
//     var studentsTable = document.getElementById('students-table');

//     if (studentSearch && studentsTable) {
//         studentSearch.addEventListener('input', function() {
//             var searchQuery = this.value.toLowerCase();
//             var rows = studentsTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

//             for (var i = 0; i < rows.length; i++) {
//                 var studentId = rows[i].cells[0].textContent.toLowerCase();
//                 var studentName = rows[i].cells[1].textContent.toLowerCase();

//                 if (studentId.includes(searchQuery) || studentName.includes(searchQuery)) {
//                     rows[i].style.display = '';
//                 } else {
//                     rows[i].style.display = 'none';
//                 }
//             }
//         });
//     }
// });
    </script>
</body>
</html>
