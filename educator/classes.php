<?php
//educator_dashboard
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';
require_once 'includes/base_url.php';



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

// Fetch educator's profile details
$stmt = $pdo->prepare('SELECT id, profile_pic, name, gender, phone_number, emergency_contact, dob, location FROM educators WHERE email = ?');
$stmt->execute([$educatorEmail]);
$educator = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($educator);
// Check for Educator
if (!$educator) {
    // Redirect to an error page if the educator is not found
    header('Location: error.php');
    exit();
}

$educatorId = $educator['id'];

// Fetch all schools assigned to the educator
$stmtSchools = $pdo->prepare('
    SELECT s.id, s.school_name 
    FROM schools s 
    INNER JOIN educator_schools es ON es.school_id = s.id 
    WHERE es.educator_id = ?
');
$stmtSchools->execute([$educatorId]);
$schools = $stmtSchools->fetchAll(PDO::FETCH_ASSOC);
// var_dump($schools);

if (!$schools) {
    $message = 'No schools assigned to you.';
    $schools = [];
}


$educatorName = $educator['name'];
$classId = isset($_GET['class_id']) ? intval($_GET['class_id']) : null;
// $term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}



// Set the default timezone to Africa/Accra (Ghana)
date_default_timezone_set('Africa/Accra');

?>

<!DOCTYPE html>
<html lang="en">
  <s>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Classes</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="assets/css/custom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      /* Add this to your existing CSS file */
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Optional: Disable interactions while loading */
.loading-disabled {
    pointer-events: none;
    opacity: 0.6;
}
    </style>
  </s>
  <body>
    <class="dashboard">
      <!-- SIDE BAR -->
      <div class="sidebar" id="sidebar">
        <div class="sidebar-content">
        <div class="logo">
          <img class="ki-logo" src="<?php echo htmlspecialchars(BASE_URL . 'educator/assets/images/ki-logo.png'); ?>" alt="">
        </div>
        <ul class="menu">
          <li>
            <a href="#">
              <ion-icon
                class="sidebar-icon"
                name="speedometer-outline"
              ></ion-icon>
              <span class="menu-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="#">
              <ion-icon
                class="sidebar-icon"
                name="analytics-outline"
              ></ion-icon>
              <span class="menu-text">Classes</span>
            </a>
          </li>
          <li>
            <a href="#">
              <ion-icon class="sidebar-icon" name="people-outline"></ion-icon>
              <span class="menu-text">Gallery</span>
            </a>
          </li>
        </ul>
        <div class="profile-card">
        <div class="profile-info">
            <?php if (!empty($educator['profile_pic'])): ?>
            <img
            src="<?php echo htmlspecialchars(BASE_URL . 'admin/' . $educator['profile_pic']); ?>" 
            alt="Profile Picture" 
              class="profile-pic" width="20px"
            />
          <?php else: ?>
          <img class="profile-pic" src="<?php echo htmlspecialchars(BASE_URL . 'educator/assets/images/placeholders/user.png'); ?>">
          <?php endif; ?>
            <div class="profile-text">
              <h3 class="ed-name"><?php echo htmlspecialchars($educator['name']); ?></h3>
              <span class="role">Instructor</span>
            </div>
          </div>
          <button  class="logout-btn">
            <ion-icon id="logout-btn" name="log-out-outline"></ion-icon>
          </button>
        </div>
        </div>
      </div>

     <!-- MAIN-CONTENT -->
      <div class="content">
         <!-- MAIN NAV -->
        <header>
          <button id="toggle-btn" class="toggle-btn">
            <ion-icon
              class="toggle-arrow"
              name="arrow-back-circle-outline"
            ></ion-icon>
          </button>
          <div class="search-container">
            <input type="text" placeholder="Search" class="search-input" />
            <button class="search-btn">
              <ion-icon name="search-outline"></ion-icon>
            </button>
          </div>

          <div id="profile-btn" class="settings">
            <ion-icon class="settings-icon" name="settings-outline"></ion-icon>
          </div>
        </header>
<!-- MAIN-DASHBOARD -->
        <main class="main-area">

          <div class="classes-parent">
            <div class="main-header border main-area--header">
              <!-- School Name -->
              <div class="main-area--text">
                
              <?php 
                  // Extract school names and convert to a pipe-separated string
                  $schoolNames = array_map(function($school) {
                    return $school['school_name'];
                  }, $schools);

                  $schoolNamesString = implode('| ', $schoolNames);
                 ?>
                
                <h2 class="school-name"><?php echo htmlspecialchars($schoolNamesString); ?></h2>
                <h2 class="date"><?php echo date('F j, Y, g:i a');?></h2>
              </div>
            </div>
            <div class="main-area--content border">

            <h2>Assigned Schools</h2>
            <form id="schoolForm">
                <label for="school_id">Select a School:</label>
                <select name="school_id" id="school_id">
                    <option value="" disabled selected>Select a School</option>
                    <?php foreach ($schools as $school): ?>
                        <option value="<?= $school['id']; ?>"><?= htmlspecialchars($school['school_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

          <h3>Classes</h3>
          <div id="classesContainer">
              <p>Select a school to see classes.</p>
          </div>


          <div class="hold">  
      <!-- Student Scores Table (hidden initially) -->
      <div id="student-scores" class="student-scores-container" <?php echo $classId ? '' : 'style="display: none;"'; ?>>
        <div class="main-nav--btn">
          <button class="backbtn" id="back-button">Back</button>
          <button class="backbtn success" id="submit-scores-button">Submit Scores</button>
        </div>
        <h2 id="class-name" class="class-name" style="padding-left: 1.2rem"></h2>
        <form id="search-form" class="search-bar" onsubmit="return false;">
            <input type="hidden" name="class_id" value="<?php echo $classId; ?>">
            <input type="text" name="search" id="student-search" class="form-control std-search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
        </form>


        <form id="score-form" action="">
        <div class="table-container">
        <table id="students-table" class="input-table">
          <tbody id="student-list">
                  <!-- Student rows will be dynamically added here -->
          </tbody>
        </table>
        </div>
        <div id="pagination"></div>
        </form>
      </div>
          </div>
          </div>
  
        </div>
        </main>
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


<!-- Logout Confirmation Modal -->
<div id="logout-btn--cancel" class="logout-pop--modal hidden">
    <div class="logout-modal--content">
        <h3 class="logout-modal--title ">Logout Confirmation</h3>
        <p>Are you sure you want to logout?</p>
        <div class="logout-modal--buttons">
            <button id="logout-btn--confirm" class="btn-confirm">Yes</button>
            <button id="logout-btn--cancel" class="btn-cancel">No</button>
        </div>
    </div>
</div>

<div id="loading-spinner" class="spinner-overlay" style="display: none;">
    <div class="spinner"></div>
</div>

    <!-- <script src="script.js"></script> -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
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


  // AJAX request to fetch classes when a school is selected
  $('#school_id').on('change', function () {
            const schoolId = $(this).val();
            if (schoolId) {
                $.ajax({
                    url: 'fetch_classes.php',
                    type: 'GET',
                    data: { school_id: schoolId },
                    success: function (response) {
                        $('#classesContainer').html(response);
                    },
                    error: function () {
                        $('#classesContainer').html('<p>Failed to fetch classes. Please try again.</p>');
                    }
                });
            }
        });
// GET PROFILEDATA
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
        $('#logout-btn--cancel').removeClass('hidden');
    });

    // Confirm logout
    $('#logout-btn--confirm').click(function() {
        window.location.href = 'logout.php';
    });

    // Cancel logout
    $('#logout-btn--cancel .btn-cancel').click(function() {
        $('#logout-btn--cancel').addClass('hidden');
    });


        
//event delegation to handle dynamically loaded cards
$(document).on('click', '.card', function() {
    var classId = $(this).data('class-id');
    // console.log('Class ID clicked:', classId); // Add debugging log
    loadStudents(classId, 1);
});

        $('#back-button').click(function() {
            $('#student-scores').hide();
            $('#class-cards').show();
            history.pushState(null, '', 'classes.php');
        });

      
        $('#score-form').submit(function(e) {
            e.preventDefault();
            submitScores();
        });
        

// Modify the existing loadStudents function in your JavaScript
function loadStudents(classId, page, searchQuery = '') {
  // console.log('Loading students for class:', classId); 
      // Show spinner
      function showSpinner() {
        $('#loading-spinner').show();
        $('#student-scores').addClass('loading-disabled');
    }

    // Hide spinner
    function hideSpinner() {
        $('#loading-spinner').hide();
        $('#student-scores').removeClass('loading-disabled');
    }
        // Show spinner immediately
        showSpinner();
    $.ajax({
        url: 'get_students.php',
        method: 'GET',
        data: { 
            class_id: classId, 
            page: page,
            search: searchQuery
        },
        success: function(response) {
          // console.log('Server response:', response); 
            var data = JSON.parse(response);
            $('#class-name').text(data.className);
            // Clear existing table header and body
            $('#students-table thead').remove();
            $('#student-list').empty();
            
            // Add new table header
            $('#students-table').prepend(data.theaderHtml);
            
            // Add student rows
            $('#student-list').html(data.studentsHtml);
            $('#pagination').html(data.pagination);
            
            $('#class-cards').hide();
            $('#student-scores').show();
            currentClassId = classId;
            
            // Update URL
            history.pushState(null, '', 'classes.php?class_id=' + classId + '&page=' + page + '&search=' + searchQuery);
        },        
        error: function(xhr, status, error) {
            console.error('Error loading students:', error); // Error logging
        },        complete: function() {
            // Always hide spinner, whether success or failure
            hideSpinner();
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
                    toastr.success('Scores submitted successfully');
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


const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggle-btn');
const content = document.querySelector('.content');

toggleBtn.addEventListener('click', () => {
  if (window.innerWidth <= 768) {
    sidebar.classList.toggle('show');
  } else {
    sidebar.classList.toggle('collapsed');
    
    // Delay the margin adjustment slightly
    setTimeout(() => {
      content.style.marginLeft = sidebar.classList.contains('collapsed') 
        ? 'calc(6.4rem + 20px)' 
        : '270px';
    }, 10); // Half of the transition time (300ms / 2)
  }
});
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    sidebar.classList.remove('show');
    content.style.marginLeft = sidebar.classList.contains('collapsed') 
      ? 'calc(6.4rem + 20px)' 
      : '270px';
  } else {
    content.style.marginLeft = '0';
  }
});
    </script>
  </body>
</html>
