<?php
//educator_dashboard
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';
require_once 'includes/base_url.php';

// Dynamically get the base URL

// 

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


// Fetch educator's school_id, profile_pic, name, and other details from the educators table
$stmt = $pdo->prepare('SELECT school_id, profile_pic, name, gender, phone_number, emergency_contact, dob, location FROM educators WHERE email = ?');
$stmt->execute([$educatorEmail]);
$educator = $stmt->fetch(PDO::FETCH_ASSOC);

// Check for Educator
if (!$educator) {
    // Redirect to an error page if the educator is not found
    header('Location: error.php');
    exit();
}

// Store the school_id in the session
$_SESSION['school_id'] = $educator['school_id'];

// Fetch the school name from the schools table using the school_id
$schoolId = $educator['school_id'];
$stmtSchool = $pdo->prepare('SELECT school_name FROM schools WHERE id = ?');
$stmtSchool->execute([$schoolId]);
$school = $stmtSchool->fetch(PDO::FETCH_ASSOC);

if ($school) {
    // Add the school_name to the educator array
    $educator['school_name'] = $school['school_name'];
} else {
    // Handle the case where the school is not found
    $educator['school_name'] = 'Unknown School';
}

$schoolId = $educator['school_id'];
$educatorName = $educator['name'];
$classId = isset($_GET['class_id']) ? intval($_GET['class_id']) : null;
// $term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}



$classes = $studentScoreService->getClasses($schoolId);
$themes = getThemes($schoolId);
print_r($educator)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Educator's Dashboard</title>
  <link rel="stylesheet" href="assets/css/educator.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900&display=swap" />
  <link rel="stylesheet" href="assets/css/custom.css">

  <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/images/site.webmanifest">
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
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
.cst-margn {
    margin-bottom: 0.5rem !important;
    margin-top: 3rem !important;
}
table {
    text-align: center !important;

    margin-right: 3rem !important;
}

.menu, ol, ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
    flex-direction: column;
}

.flex-col {
    align-items: center;
}

.profile-img{
  width: 20rem  !important;
  height: 10rem !important;
}

.c-flex{
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
}

.heading-1{
  font-size: 1.7rem !important;
  font-weight: 700 !important;
}
.heading-2{
  font-size: 1.4rem !important;
  font-weight: 500 !important;
}
.margin-top{
  margin-top: 1rem;
}
.margin-top-2{
  margin-top: 3.5rem;
}
.heading-3{
  font-size: 1.2rem !important;
  margin-top: 2.7rem !important;
}
    
.c-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* adjust the number of columns */
}

.hver{
  cursor: pointer;
}
  </style>
</head>
<body class="bg-[#F8F9FB] font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="flex flex-col sidebar w-64 bg-white p-4">
      <div class="c-flex items-center">
      <div class="profile-img w-24 h-24 bg-cover bg-center rounded-full mb-4 cst-margn flex items-center justify-center">
      <?php if (!empty($educator['profile_pic'])): ?>
        <img src="<?php echo htmlspecialchars(BASE_URL . 'admin/' . $educator['profile_pic']); ?>" 
             alt="Profile Picture" 
             class="w-full h-full object-cover rounded-full"
             >
    <?php else: ?>
        <img class="w-full h-full object-cover rounded-full" src="<?php echo htmlspecialchars(BASE_URL . 'educator/assets/images/placeholders/user.png'); ?>">
    <?php endif; ?>
</div>

        <h1 class="heading-1 text-xl font-bold text-[#141C24]"><?php echo htmlspecialchars($educator['name']); ?></h1>

        <p class="margin-top heading-2 text-sm text-[#3F5374]">KI Coach</p>
      </div>
      <nav class="mt-8">
        <ul>
          <li class="mb-4">
            <a href="#" id="profile-btn" class="heading-3 flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Profile</a>
          </li>
          <li class="mb-4">
            <a href="class.php" id="classes-btn" class="heading-3 flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Classes</a>
          </li>
          <li class="mb-4">
            <a href="#" id="photos-btn" class="heading-3 flex items-center px-4 py-2 text-sm font-medium text-[#141C24] hover:bg-[#E4E9F1] rounded-lg">Photos</a>
          </li>
        </ul>
      </nav>
      <button id="logout-btn" class="logout-btn w-full mt-8 py-2 bg-[#F4C753] text-[#141C24] text-sm font-bold rounded-lg">Logout</button>
    </div>

    <!-- Main content -->
    <div class="p-2 flex" id="main-content">
    
    <div class="c-width" id="class-cards" <?php echo $classId ? 'style="display: none;"' : ''; ?>>
      <h1 class="text-4xl font-bold text-[#141C24] mb-6">Classes</h1>
      <a href="dashboard.php">dashboard</a>
      <a href="classes.php">classes</a>
      <!-- classes Card -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="class-list">
          <?php foreach ($classes as $class): ?>
            <div class="hver class-item flex items-center gap-4 bg-white p-4 rounded-lg shadow hover:bg-[#E4E9F1] card" data-class-id="<?= $class['class_id'] ?>">
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
      

      <!-- Student Scores Table (hidden initially) -->
      <div id="student-scores" <?php echo $classId ? '' : 'style="display: none;"'; ?>>
        <div class="mb-4 margin-top-2">
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
  </div>


<!-- Modal for Profile Form -->
<div id="profile-form-modal" class="modal hidden">
  <div class="modal-content slide-in-left">
    <h2>Edit Profile</h2>
    <form id="profile-form" enctype="multipart/form-data">
      <!-- Profile Picture -->
      <div class="form-group">
        <label for="profile-pic">Profile Picture</label>
        <input type="file" name="profile_pic" id="profile-pic">
      </div>

      <!-- Name (non-editable) -->
      <div class="form-group">
        <label for="name">Name (Not Editable)</label>
        <input type="text" name="name" id="name" readonly>
      </div>

      <!-- Location -->
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" name="location" id="location">
      </div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" name="phone_number" id="phone">
      </div>

      <!-- Emergency Contact -->
      <div class="form-group">
        <label for="emergency">Emergency Contact</label>
        <input type="text" name="emergency_contact" id="emergency">
      </div>

      <!-- Email (non-editable) -->
      <div class="form-group">
        <label for="email">Email (Not Editable)</label>
        <input type="email" name="email" id="email" readonly>
      </div>

      <!-- Password Fields -->
      <div class="form-group">
        <label for="old-password">Old Password</label>
        <input type="password" name="old_password" id="old-password">
      </div>
      <div class="form-group">
        <label for="new-password">New Password</label>
        <input type="password" name="new_password" id="new-password">
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm-password">
      </div>

      <!-- Submit and Cancel Buttons -->
      <div class="form-actions">
        <button type="button" id="cancel-profile" class="btn cancel">Cancel</button>
        <button type="submit" class="btn submit">Save Changes</button>
      </div>
    </form>
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
<div id="logout-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Logout Confirmation</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to logout?
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirm-logout" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2">
                    Yes
                </button>
                <button id="cancel-logout" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24">
                    No
                </button>
            </div>
        </div>
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

  <!-- Toastr and Custom JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};


$('#profile-btn').click(function() {
    $.ajax({
        url: 'get_profile.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Populate the form
            $('#name').val(data.name);
            $('#location').val(data.location);
            $('#phone').val(data.phone_number);
            $('#emergency').val(data.emergency_contact);
            $('#email').val(data.email);

            // Display current profile picture
            if (data.profile_pic) {
                $('#current-profile-pic').attr('src', data.profile_pic).show();
            } else {
                $('#current-profile-pic').hide();
            }

            // Show the modal and add the slide-in class
            $('#profile-form-modal').addClass('show');
            $('.modal-content').addClass('slide-in-left');
        }
    });
});

// Handle form submission via AJAX
$('#profile-form').submit(function(e) {
    e.preventDefault();
    
    var formData = new FormData(this);

    $.ajax({
        url: 'update_profile.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message);
                $('#profile-form-modal').removeClass('show');
            } else {
                toastr.error(response.message);
            }
        },
        error: function() {
            toastr.error('There was an error updating the profile.');
        }
    });
});

    // Hide modal when "Cancel" is clicked
    $('#cancel-profile').click(function() {
        $('#profile-form-modal').removeClass('show'); // Hide modal
        $('.modal-content').removeClass('slide-in-left'); // Remove slide-in class
    });




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

          // Logout button click handler
          $('#logout-btn').click(function(e) {
              e.preventDefault();
              
              // Show confirmation modal
              $('#logout-modal').removeClass('hidden');
          });

          // Confirm logout
          $('#confirm-logout').click(function() {
              window.location.href = 'logout.php';
          });

          // Cancel logout
          $('#cancel-logout').click(function() {
              $('#logout-modal').addClass('hidden');
          });


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
