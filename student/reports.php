<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<?php
//student_dashboard
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';
require_once 'includes/base_url.php';
require_once 'includes/graph_svg.php';


// Set the default timezone to Africa/Accra (Ghana)
date_default_timezone_set('Africa/Accra');

$pdo = dbConnect();

$studentScoreService = new StudentScoreService($pdo);


$message = '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
// Check if the user is logged in and is an student
if (!isset($_SESSION['user_username']) || $_SESSION['role'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

$student_id = $_SESSION['user_username'];
// var_dump($student_id);

// Fetch students's profile details
$stmt = $pdo->prepare(" SELECT s.*, c.class_name, sc.school_name FROM students s
    JOIN classes c ON s.class_id = c.class_id
    JOIN schools sc ON c.school_id = sc.id
    WHERE s.student_id = ? ");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);


// print_r($student);

// Check for student
if (!$student) {
TODO: // add 404 Redirect to an error page if the student is not found 
    header('Location: error.php');
    exit();
}



// $classId = isset($_GET['class_id']) ? intval($_GET['class_id']) : null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}


//REPORT DATA
$Term = getCurrentTerm($pdo);
$term_id = $Term['term_id'];

// Fetch assigned SEL themes and scores
$stmt = $pdo->prepare("
    SELECT st.theme_name, st.competency, st.character_strength, ss.score
    FROM sel_themes st
    JOIN student_scores ss ON st.id = ss.theme_id
    WHERE ss.student_id = ? AND ss.term_id = ?
");
$stmt->execute([$student_id, $term_id]);
$sel_themes = $stmt->fetchAll(PDO::FETCH_ASSOC);


$calcAge = $student['dob'];
$dob = new DateTime($calcAge);;
$today = new DateTime('now');  
if($dob->format('Y-m-d\TH:i:s.v') < 0 || $dob->format('Y-m-d\TH:i:s.v') == null){
    $age = null;
  
}else{
    $age = $today->diff($dob)->y; 
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
    <link rel="manifest" href="assets/img/site.webmanifest">
    <title>Reports Dashboard</title>

    <!--     Fonts and icons     -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
      rel="stylesheet"
    />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
     <!-- ION ICONS -->
     <link
      href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
      rel="stylesheet"
    />
    <!-- TOAST R -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script
      src="https://kit.fontawesome.com/42d5adcbca.js"
      crossorigin="anonymous"
    ></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link
      id="pagestyle"
      href="./assets/css/argon-dashboard.css?v=2.0.4"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/view_report.css">
    <!-- <link rel="stylesheet" href="assets/css/adminDashboard.css"> -->

    <link rel="stylesheet" href="https://unpkg.com/transition-style">

    <style>

        .class-card:hover{
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .card {

            margin: 0.8rem !important; 
        }

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

        #pagination {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
            margin-bottom: 1.2rem;
          }
          .page-btn {
    display: inline-block;
    padding: 8px 12px;
    margin: 0 5px;
    font-size: 14px;
    font-weight: 500;
    color: #ffffff;
    background-color: #007bff; /* Bootstrap primary color */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.page-btn:hover {
    background-color: #0f63f5; /* Darker primary color on hover */
    transform: scale(1.05); /* Slight zoom effect */
}

.page-btn.active {
    background-color: #0056b3; /* Active button color */
    color: #ffffff; /* Keep the text white */
    pointer-events: none; /* Disable click */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); /* Subtle shadow for emphasis */
}

.page-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Focus ring for accessibility */
}

.page-btn:disabled {
    background-color: #e0e0e0; /* Disabled button color */
    color: #888888;
    cursor: not-allowed;
}



          .page-btn {
              margin: 0 5px;
              padding: 5px 10px;
          }

          .page-btn.active {
              background-color: #0f2ef5;
              color: white;
          }


          .student-report-container {
              font-family: Arial, sans-serif;
              max-width: 800px;
              margin: 0 auto;
              padding: 20px;
          }

          .report-header {
              text-align: center;
              margin-bottom: 20px;
              border-bottom: 2px solid #f0f0f0;
          }

          .sel-themes-table {
              width: 100%;
              border-collapse: collapse;
          }

          .sel-themes-table th, 
          .sel-themes-table td {
              border: 1px solid #ddd;
              padding: 8px;
              text-align: left;
          }

          .info-grid {
              display: grid;
              grid-template-columns: repeat(2, 1fr);
              gap: 10px;
          }

          .report-footer {
              margin-top: 20px;
              text-align: center;
              font-size: 0.8em;
              color: #777;
          }

          ion-icon {
            font-size: 100px;
          }


          /* #logout-modal {
              display: none; 
              opacity: 0;
              transition: opacity 0.3s ease;
          } */

          /* #logout-modal:not(.hidden) {
              display: block;
              opacity: 1;
          } */

          .sidenav {
 
    z-index: 10; 
}

    </style>
</head>

  <body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside
      class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
      id="sidenav-main"
    >
      <div class="sidenav-header">
        <i
          class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
          aria-hidden="true"
          id="iconSidenav"
        ></i>
        <a
          class="navbar-brand m-0"
          href="#"
          target="_blank"
        >
          <img
            src="./assets/img/ki_logo.png"
            class="navbar-brand-img h-100"
            alt="main_logo"
          />
          <span class="ms-1 font-weight-bold">Reports Dashboard</span>
        </a>
      </div>
      <hr class="horizontal dark mt-0" />
      <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="index.php">
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
                <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reports.php">
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
                <i
                  class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"
                ></i>
              </div>
              <span class="nav-link-text ms-1">Reports</span>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
                <i
                  class="ni ni-credit-card text-success text-sm opacity-10"
                ></i>
              </div>
              <span class="nav-link-text ms-1">Reports2</span>
            </a>
          </li> -->

          <li class="nav-item mt-3">
            <h6
              class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6"
            >
              Settings
            </h6>
          </li>
          <li class="nav-item">
            <div class="nav-link">
              <a href="#" id="profile-btn">profile</a>
            </div>
            <div class="nav-link">
              <div
                class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
              <ion-icon name="power-outline"></ion-icon>
              </div>
              <button id="logout-btn" class="logout-btn btn btn-danger btn-sm mt-3">Logout</button>
            </div>
          </li>
        </ul>
      </div>
     
    </aside>

    <!-- MAIN -->
    <main class="main-content position-relative border-radius-lg">
      <!-- Navbar -->
    <nav
        class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl"
        id="navbarBlur"
        data-scroll="false"
      >
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol
              class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5"
            >
              <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-white" href="javascript:;">Pages</a>
              </li>
              <li
                class="breadcrumb-item text-sm text-white active"
                aria-current="page"
              >
                Dashboard
              </li>
            </ol>
          </nav>
          <div
            class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4"
            id="navbar"
          >
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              <div class="input-group">
                <span class="input-group-text text-body"
                  ><i class="fas fa-search" aria-hidden="true"></i
                ></span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Type here..."
                />
              </div>
            </div>
            <ul class="navbar-nav justify-content-end">
              <li class="nav-item d-flex align-items-center">
                <a
                  href="javascript:;"
                  class="nav-link text-white font-weight-bold px-0"
                >
                  <!-- <i class="fa fa-user me-sm-1"></i> -->
                  <!-- <span class="d-sm-inline d-none">Sign In</span> -->
                </a>
              </li>
              <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a
                  href="javascript:;"
                  class="nav-link text-white p-0"
                  id="iconNavbarSidenav"
                >
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                  </div>
                </a>
              </li>
              <li class="nav-item px-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0">
                  <i
                    class="fa fa-cog fixed-plugin-button-nav cursor-pointer"
                  ></i>
                </a>
              </li>
              <li class="nav-item dropdown pe-2 d-flex align-items-center">
                <a
                  href="javascript:;"
                  class="nav-link text-white p-0"
                  id="dropdownMenuButton"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="fa fa-bell cursor-pointer"></i>
                </a>

              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
    <div class="container-fluid py-4">

        <!-- classes CARD -->
        <div class="row mt-">
          <div class="col-lg-9 mb-lg-0 mb-4" >
          <div transition-style="in:wipe:bottom-right" id="class-cards"  class="card  z-index-2" style="max-height: 45rem; overflow: hidden; ">

            <div transition-style="in:diamond:center" class="card-body p-3" style="overflow-y: auto;">
              <div class="chart">
                <!-- <div class="report-btn">
                  <h2>View This Term's Report</h2>
                  <button>Click Here</button>
                </div> -->

                <div class="report-view" >
                  
                <div id="report-view" class="">
                  <h4>Report for <?php echo htmlspecialchars($Term['term_number']) ;?>st Term <?php echo htmlspecialchars($Term['year_name']) ;?> Academic Year</h4>
                  <div class="report-container ">
                      <!-- <button class="close-btn" onclick="closeReport()"><strong>X</strong></button> -->
                      <div id="report-content">
                        <!-- Page 1 -->
                        <div id="report-page-1" class="page-1">
                            <h1 style="font-size: 2rem"><u>KIE STUDENT PROGRESS REPORT</u></h1>
                            <p style="text-align: left;">Kinesthetic Intelligence Education personal progress report for <strong><span id="student-name"><?php echo htmlspecialchars($student['name']); ?></span></strong> at <strong><span id="student-school"><?php echo htmlspecialchars($student['school_name']); ?></span></strong>. The Kinesthetic Intelligence Education (KIE) student personal progress report provides a comprehensive assessment of each student’s development over the 12-week program, which focused on one Social Emotional Learning (SEL) theme per week. These themes were designed to enhance students’ overall Emotional Intelligence. The report evaluates each student’s marginal improvements in mastering these skills, offering valuable insights into their growth and areas for further development. This progress assessment aims to encourage continuous learning and promote personal growth in alignment with Open Mind Africa’s mission to develop well-rounded, emotionally intelligent individuals.</p>
                            <div class="flex-column">
                              <div><h2>Personal Information</h2></div>
                              <div class="d-flex flex-row">
                              <div class="left-side">              
                                    <p><strong>Name:</strong> <span id="student-name-info"><?php echo htmlspecialchars($student['name']); ?></span></p>
                                    <p><strong>Age:</strong> <?php echo htmlspecialchars($age ?? 'N/A'); ?> YEARS</p>
                                    <p><strong>School:</strong> <span id="student-school-info"><?php echo htmlspecialchars($student['school_name']); ?></span></p>
                                    <p><strong>Class:</strong> <span id="student-class-info"><?php echo htmlspecialchars($student['class_name']); ?></span></p>
                                    <p><strong>Height:</strong> <?php echo htmlspecialchars($student['height'] ?? 'N/A'); ?> cm</p>
                                    <p><strong>Weight:</strong> <?php echo htmlspecialchars($student['weight'] ?? 'N/A'); ?> kg</p>
                              </div>
                              <div class="right-side">
                                  <p><strong>Foot:</strong> <?php echo htmlspecialchars($student['foot'] ?? 'N/A'); ?> </p>
                                  <p><strong>Hand:</strong> <?php echo htmlspecialchars($student['hand'] ?? 'N/A'); ?></p>
                                  <p><strong>Eyesight:</strong> <?php echo htmlspecialchars($student['eye_sight'] ?? 'N/A'); ?></p>
                                  <p><strong>Heart Rate:</strong> <?php echo htmlspecialchars($student['heart_rate'] ?? 'N/A'); ?></p>
                                  <p><strong>Medical Condition:</strong> <?php echo htmlspecialchars($student['medical_condition'] ?? 'N/A'); ?></p>
                              </div>
                            </div>
                            </div>
                            </div>
                            <section class="data-tables">
                              <h2>1. Student KEQ Field Data</h2>
                              <table>
                                  <tr>
                                    <th>Metrics</th>
                                    <?php foreach ($sel_themes as $theme): ?>
                                    <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
                                    <?php endforeach; ?>
                                  </tr>
                                  <tr>
                                    <td>KEQ</td>
                                    <?php foreach ($sel_themes as $theme): ?>
                                    <td><?php echo htmlspecialchars($theme['score']); ?></td>
                                    <?php endforeach; ?>
                                  </tr>
                              </table>
                            </section>
                            <div class="graph-descriptio">
                              <h3>GRAPH DESCRIPTION</h3>
                              <ul>
                                  <li>Each student starts from the green base line of 50% and work their way up.</li>
                                  <li>The blue area represents the marginal percentage improvement this term.</li>
                                  <li>The yellow area represents the target they are working towards over a period.</li>
                                  <li>Students are expected to have a termly marginal improvement over a period.</li>
                              </ul>
                            </div>
                            
                            <!-- Placeholder for KEQ Bar Chart -->
                           <div class=""><?php echo generateKEQBarChart($sel_themes, $student['name']); ?></div> 
                        </div>
                        <!-- Page 2 -->
                        <div id="report-page-2" class="page-2">
                            <h3>RESULTS ANALYSIS</h3>
                            <ul>
                              <li><strong>Strength Recognition:</strong> Keep an eye on 8% - 10% marginal improvement. This is one of your ward's strengths. Be aware of this skill especially in challenging situations at home. We will keep working on it.</li>
                              <li><strong>Skill Development:</strong> Next keep an eye on 5% - 7% marginal improvement. Your ward has some ability in this skill but with more practice we could get better.</li>
                              <li><strong>Developmental Focus:</strong> Now look at 2% - 4% marginal improvement. This skill will take your ward more time to develop and strengthen. The K.I coach will focus more attention to help your ward to develop this skill.</li>
                            </ul>
                            <h2>Social Emotional Learning Competencies (SEL)</h2>
                            <table>
                              <tr>
                                  <th>Metrics</th>
                                  <?php foreach ($sel_themes as $theme): ?>
                                  <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
                                  <?php endforeach; ?>
                              </tr>
                              <tr>
                                  <td>KEQ</td>
                                  <?php foreach ($sel_themes as $theme): ?>
                                  <td><?php echo htmlspecialchars($theme['score']); ?></td>
                                  <?php endforeach; ?>
                              </tr>
                              <tr>
                                  <td>SEL</td>
                                  <?php foreach ($sel_themes as $theme): ?>
                                  <td><?php echo htmlspecialchars($theme['competency']); ?></td>
                                  <?php endforeach; ?>
                              </tr>
                            </table>
                            <!-- Placeholder for SEL Pie Chart -->
                            <?php echo generateSELPieChart($sel_themes, $student['name']); ?>
                            <h3>RESULTS ANALYSIS</h3>
                            <ul>
                              <li><strong>Thematic Exposure:</strong> Each term students explore a minimum of two character development themes related to the five SEL competencies.</li>
                              <li><strong>Metric Evaluation:</strong> Internal metrics assess their performance on each competency with a maximum achievable score of 20% for each totaling 100%.</li>
                              <li><strong>Focus on Improvement:</strong> The emphasis is on fostering continuous marginal improvement each term rather than solely achieving high scores.</li>
                              <li><strong>Understanding Scores:</strong> An SEL score above 15 indicates robust emotional intelligence while a score below 10 signals opportunities for ongoing improvement.</li>
                            </ul>
                        </div>
                        <!-- Page 3 -->
                        <div id="report-page-3">
                            <h2>Character Strengths (CS)</h2>
                            <table>
                              <tr>
                                  <th>Metrics</th>
                                  <?php foreach ($sel_themes as $theme): ?>
                                  <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
                                  <?php endforeach; ?>
                              </tr>
                              <tr>
                                  <td>KEQ</td>
                                  <?php foreach ($sel_themes as $theme): ?>
                                  <td><?php echo htmlspecialchars($theme['score']); ?></td>
                                  <?php endforeach; ?>
                              </tr>
                              <tr>
                                  <td>SEL</td>
                                  <?php foreach ($sel_themes as $theme): ?>
                                  <td><?php echo htmlspecialchars($theme['character_strength']); ?></td>
                                  <?php endforeach; ?>
                              </tr>
                            </table>
                            <!-- Placeholder for CS Bar Chart -->          
                            <?php echo generateCharacterStrengthsBarChart($sel_themes, $student['name']); ?>
                            <h3>RESULTS ANALYSIS</h3>
                            <ul>
                              <li>Your child is actively developing their character strengths of Will Heart and Mind aiming for a maximum score of 10 points in each category over time.</li>
                              <li>Achieving a score between 8 - 10 signifies high strength in the respective area. Encourage your child to keep honing these strengths as they play a vital role in academic success and overall personal development.</li>
                              <li>Scores falling within 5 - 7 indicate a medium level of strength. Your child possesses some ability in these areas and with consistent effort and practice they can further enhance their capabilities.</li>
                              <li>A score of 2 – 4 is positive feedback. The K.I coach will provide additional attention to support your child in developing these character strengths more fully. Your engagement and encouragement are crucial during this developmental process.</li>
                            </ul>
                            <footer>
                              <p><strong>Joseph A. Adams</strong> <br><strong>Founder, K.I. Education LLC</strong></p>
                              <div class="contact-info">
                                  <p class="link"><strong>hi@kiedu.net</strong></p>
                                  <p class="ki_number">054 396 1150</p>
                                  <p class="ki_link"><strong>www.kiedu.net</strong></p>
                              </div>
                            </footer>
                        </div>
                  </div>
                  </div>
                </div>

                </div>
              </div>
            </div>
        </div>
      </div>

      <div class="hold">  
      </div>
    </div>

          
        <div class="row mt-4">
          <div class="row">
            <!-- STUDENT LIST TABLE -->
              <div transition-style="in:diamond:center" id="student-table" class="col-12 " style="display: none;" >
                <div class="card mb-4">
                  <div class="d-flex justify-content-between card-header pb-0">
                  <button class="backbtn btn btn-secondary btn-sm" id="back-button">Back</button>
                  <h6 class="mb-2">View this term Score</h6>
                  <h2 id="class-name" class="class-name" style="padding-left: 1.2rem" style="display: none"></h2>
                  <form id="search-form" class="search-bar" onsubmit="return false;">
                      <input type="hidden" name="class_id" value="<?php echo $classId; ?>" style="display:none">
                      <input type="text" name="search" id="student-search" class="form-control std-search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
                  </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                     <form id="score-form" action="">

                    <table id="students-table" class="input-table table align-items-center mb-0">
                      <thead>
                          <tr>
                              <th class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-9">#</th>
                              <th class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Student ID</th>
                              <th class="text-center align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                              <th class="text-center align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class</th>
                              <th class="text-center align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                          </tr>
                      </thead>
                      <tbody id="student-list">
                          <!-- Students will be dynamically added here -->
                      </tbody>
                    </table>
                    </form>
                  </div>
                </div>
                 
                <div id="pagination"></div>
              </div>
            </div>
              
          </div>
          </div>
        </div>
       
      </div>
    </main>
    <div class="fixed-plugin">
      <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
      </a>
      <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
          <div class="float-start">
            <h5 class="mt-3 mb-0">View Setttings</h5>
            <p>change your view colors here</p>
          </div>
          <div class="float-end mt-4">
            <button
              class="btn btn-link text-dark p-0 fixed-plugin-close-button"
            >
              <i class="fa fa-close"></i>
            </button>
          </div>
          <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1" />
        <div class="card-body pt-sm-3 pt-0 overflow-auto">
          <!-- Sidebar Backgrounds -->
          <div>
            <h6 class="mb-0">Sidebar Colors</h6>
          </div>
          <a href="javascript:void(0)" class="switch-trigger background-color">
            <div class="badge-colors my-2 text-start">
              <span
                class="badge filter bg-gradient-primary active"
                data-color="primary"
                onclick="sidebarColor(this)"
              ></span>
              <span
                class="badge filter bg-gradient-dark"
                data-color="dark"
                onclick="sidebarColor(this)"
              ></span>
              <span
                class="badge filter bg-gradient-info"
                data-color="info"
                onclick="sidebarColor(this)"
              ></span>
              <span
                class="badge filter bg-gradient-success"
                data-color="success"
                onclick="sidebarColor(this)"
              ></span>
              <span
                class="badge filter bg-gradient-warning"
                data-color="warning"
                onclick="sidebarColor(this)"
              ></span>
              <span
                class="badge filter bg-gradient-danger"
                data-color="danger"
                onclick="sidebarColor(this)"
              ></span>
            </div>
          </a>
          <!-- Sidenav Type -->
          <div class="mt-3">
            <h6 class="mb-0">Sidenav Type</h6>
            <p class="text-sm">Choose between 2 different sidenav types.</p>
          </div>
          <div class="d-flex">
            <button
              class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2"
              data-class="bg-white"
              onclick="sidebarType(this)"
            >
              White
            </button>
            <button
              class="btn bg-gradient-primary w-100 px-3 mb-2"
              data-class="bg-default"
              onclick="sidebarType(this)"
            >
              Dark
            </button>
          </div>
          <p class="text-sm d-xl-none d-block mt-2">
            You can change the sidenav type just on desktop view.
          </p>
          <!-- Navbar Fixed -->
          <div class="d-flex my-3">
            <h6 class="mb-0">Navbar Fixed</h6>
            <div class="form-check form-switch ps-0 ms-auto my-auto">
              <input
                class="form-check-input mt-1 ms-auto"
                type="checkbox"
                id="navbarFixed"
                onclick="navbarFixed(this)"
              />
            </div>
          </div>
          <hr class="horizontal dark my-sm-4" />
          <div class="mt-2 mb-5 d-flex">
            <h6 class="mb-0">Light / Dark</h6>
            <div class="form-check form-switch ps-0 ms-auto my-auto">
              <input
                class="form-check-input mt-1 ms-auto"
                type="checkbox"
                id="dark-version"
                onclick="darkMode(this)"
              />
            </div>

        </div>
      </div>
    </div>

<!-- Logout Confirmation Modal (Bootstrap) -->
<div class="modal fade" id="logout-modal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" id="confirm-logout" class="btn btn-danger">Yes</button>
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

    <!--   Core JS Files   -->
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/chartjs.min.js"></script>

    <script>
      var win = navigator.platform.indexOf("Win") > -1;
      if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
          damping: "0.5",
        };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
      }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
        <!-- <script src="script.js"></script> -->
        <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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




// GET PROFILEDATA
$('#profile-btn').click(function() {
console.log('profile clicked')
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

   // Logout button click handler
    // Show confirmation modal when logout button is clicked
    $('#logout-btn').click(function(e) {
        e.preventDefault();
        // Show the Bootstrap modal
        $('#logout-modal').modal('show');
    });

    // Confirm logout action
    $('#confirm-logout').click(function() {
        // Redirect to logout page (or perform AJAX logout)
        window.location.href = 'logout.php';
    });
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
