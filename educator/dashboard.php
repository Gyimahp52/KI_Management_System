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

// print_r($educator);
$_SESSION['school_id'] = $educator['school_id'];
// Check for Educator
if (!$educator) {
   echo $educator;
    header('Location: error.php');
    exit();
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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Dashboard with Icons</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <div class="dashboard">
      <div class="sidebar" id="sidebar">
        <div class="logo">
          <h2 class="logo-text">Logo</h2>
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
            <a href="classes.html">
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
          <button class="logout-btn">
            <ion-icon name="log-out-outline"></ion-icon>
          </button>
        </div>
      </div>

      <div class="content">
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

          <div class="settings">
            <ion-icon class="settings-icon" name="settings-outline"></ion-icon>
          </div>
        </header>

        <main>
          <h2>Welcome to the Dashboard</h2>
          <p>This is your main content area.</p>
          <div class="parent">
            <div class="div1 border"></div>
            <div class="div2 border"></div>
            <div class="div3 border"></div>
          </div>
        </main>
      </div>
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
    <script>
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('toggle-btn');
      const toggleArrow = document.getElementsByClassName('toggle-arrow');

      // Toggle sidebar collapse
      toggleBtn.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          sidebar.classList.toggle('show'); // Toggle for mobile
        } else {
          sidebar.classList.toggle('collapsed');
        }
      });

      // Auto-close sidebar when resizing to small screen
      window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
          sidebar.classList.remove('show');
        }
      });
    </script>
  </body>
</html>
