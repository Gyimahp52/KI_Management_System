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
// view_report.php
// $url = $_GET['url'] ?? '/';
// echo "Current route: " . htmlspecialchars($url);
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
// Check if the user is logged in and is a student
if (!isset($_SESSION['user_username']) || $_SESSION['role'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

$student_id = $_SESSION['user_username'];


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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
    <link rel="manifest" href="assets/img/site.webmanifest">
    <title>Reports Dashboard</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Ionicons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
        rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <!-- Option 1: Using CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Toastr Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/view_report.css">

    <!-- Additional Styles -->
    <link rel="stylesheet" href="https://unpkg.com/transition-style">
    <link rel="stylesheet" href="assets/css/student.css">

    <style>
    .class-card:hover {
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

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
        background-color: #007bff;
        /* Bootstrap primary color */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .page-btn:hover {
        background-color: #0f63f5;
        /* Darker primary color on hover */
        transform: scale(1.05);
        /* Slight zoom effect */
    }

    .page-btn.active {
        background-color: #0056b3;
        /* Active button color */
        color: #ffffff;
        /* Keep the text white */
        pointer-events: none;
        /* Disable click */
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        /* Subtle shadow for emphasis */
    }

    /* .page-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
    } */

    /* .page-btn:disabled {
        background-color: #e0e0e0;
        color: #888888;
        cursor: not-allowed;
    } */


    /* 
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
    } */

    ion-icon {
        font-size: 100px;
    }

    /* view report cards style */

    /* .report-btn button {
        transition: transform 0.3s ease;
        border-radius: 10px !important;
    }

    .report-btn button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05) !important;
    }

    .cs-flex {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    @media (max-width: 768px) {
        .report-btn button {
            font-size: 14px !important;
            padding: 12px 20px !important;
        }
    } */

    :root {
    --primary-color: #2a9d8f;
    --secondary-color: #264653;
    --background-color: #f4f4f4;
    --text-color: #333;
    --border-radius: 8px;
    --input-border-color: #e0e0e0;
}

#profile-form-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

#profile-form-modal.hidden {
    opacity: 0;
    visibility: hidden;
}

#profile-form-modal.show {
    opacity: 1;
    visibility: visible;
}

.st-modal-content {
    background-color: white;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 30px;
    position: relative;
    animation: slideInLeft 0.4s ease;
}

@keyframes slideInLeft {
    from {
        transform: translateX(-50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.st-modal-content h2 {
    color: var(--primary-color);
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
}

.st-modal-content h3 {
    color: var(--secondary-color);
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 10px;
    margin: 20px 0 15px;
    font-size: 18px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: var(--text-color);
    font-weight: 600;
}

.form-group input, 
.form-group select, 
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--input-border-color);
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

.form-group input:focus, 
.form-group select:focus, 
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(42, 157, 143, 0.2);
}

.form-group.row {
    display: flex;
    gap: 15px;
}

.form-group.row .col {
    flex: 1;
}

.profile-preview {
    max-width: 200px;
    max-height: 200px;
    object-fit: cover;
    border-radius: var(--border-radius);
    margin-bottom: 10px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
}

.btn.cancel {
    background-color: #f4f4f4;
    color: var(--text-color);
}

.btn.submit {
    background-color: var(--primary-color);
    color: white;
}

.btn:hover {
    opacity: 0.9;
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    .st-modal-content {
        width: 95%;
        padding: 20px;
        margin: 0 10px;
    }

    .form-group.row {
        flex-direction: column;
        gap: 10px;
    }

    .profile-preview {
        max-width: 150px;
        max-height: 150px;
    }
}

/* File Input Styling */
.form-group input[type="file"] {
    border: none;
    padding: 0;
}

/* Additional Accessibility */
.form-group input:disabled {
    background-color: #f4f4f4;
    cursor: not-allowed;
}
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>


    <?php include 'sidebar.html' ?>
    <!-- MAIN -->
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-white" href="javascript:;">Pages</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search"
                                    aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here..." />
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <!-- <i class="fa fa-user me-sm-1"></i> -->
                                <!-- <span class="d-sm-inline d-none">Sign In</span> -->
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">


            <div class="row mt-4">
                <!-- View Reports Card -->
                <div id="reports-card" class="col-lg-9 mb-lg-0 mb-4">
                    <div transition-style="in:wipe:bottom-right" class="card z-index-2"
                        style="max-height: 45rem; overflow: hidden;">
                        <div transition-style="in:diamond:center" class="card-body p-3" style="overflow-y: auto;">
                            <div class="chart">
                                <div class="report-btn text-center mb-4">
                                    <h2>View Reports</h2>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <button onclick="viewCurrentReport()"
                                                class="btn btn-primary btn-block py-3 px-5 rounded-lg shadow">
                                                <i class="fas fa-clock mr-2"></i>View Current Report
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-2">
                                            <button onclick="viewPastReports()"
                                                class="btn btn-outline-secondary btn-block py-3 px-5 rounded-lg shadow">
                                                <i class="fas fa-archive mr-2"></i>View Past Reports
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Card -->
                <div id="filter-card" class="col-lg-9 mb-lg-0 mb-4" style="display: none;">
                    <div transition-style="in:wipe:bottom-right" class="card z-index-2"
                        style="max-height: 45rem; overflow: hidden;">
                        <div transition-style="in:diamond:center" class="card-body p-3" style="overflow-y: auto;">
                            <div class="filter-card-content">
                                <!-- Back Button -->
                                <button onclick="goBackToReports()" class="btn btn-light mb-4 float-left shadow-sm">
                                    <i class="fas fa-arrow-left mr-2"></i>Back
                                </button>

                                <h2 class="text-center mb-4">Past Reports Filter</h2>

                                <!-- Filter Controls -->
                                <div class="row justify-content-center">

                                    <!-- Ensure your dropdowns have unique IDs -->
                                    <div class="filter-card ">
                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <select id="academic_year" onchange="fetchTerms()">
                                                <option value="">Select Academic Year</option>
                                                <!-- Populated via JavaScript -->
                                            </select>
                                        </div>

                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <select id="term">
                                                <option value="">Select Term</option>
                                                <!-- Populated based on academic year selection -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Show Reports Button -->
                                <div class="row justify-content-center mt-5">
                                    <button onclick="showPastReports()" class="btn btn-primary btn-lg shadow">
                                        <i class="fas fa-search mr-2"></i>Show Reports
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hold">
            </div>
        </div>

        </div>

        </div>
        <!-- Report Container (initially hidden) -->
        <div id="report-container" class="col-lg-9 mb-lg-0 mb-4" style="display: none;">
            <div class="card z-index-2" style="max-height: 45rem; overflow: hidden;">
                <div class="card-body p-3">
                    <button id="back-to-filter" onclick="goBackToFilter()" class="btn btn-light mb-4 shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Filter
                    </button>
                    <button id="back-to-report" onclick="goBackToReports()" class="btn btn-light mb-4 shadow-sm"
                        style="display: none;">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </button>
                    <div id="report-content">
                        <iframe id="report-iframe" style="width: 100%; height: 600px; border: none;"></iframe>
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
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
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
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        onclick="sidebarType(this)">
                        White
                    </button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
                        onclick="sidebarType(this)">
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
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)" />
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4" />
                <div class="mt-2 mb-5 d-flex">408
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)" />
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

        <?php include 'student_profile_modal.html' ?>

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
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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

        function viewCurrentReport() {
            const studentId = "<?php echo $student_id; ?>";
            const termId = "<?php echo $Term['term_id']; ?>";


            // Hide reports card and show iframe
            document.getElementById("reports-card").style.display = "none";
            document.getElementById("report-container").style.display = "block";

            const iframe = document.getElementById("report-iframe");
            iframe.src = `view_report.php?student_id=${studentId}&term_id=${termId}`;
            document.getElementById("back-to-filter").style.display = "none";
            document.getElementById("back-to-report").style.display = "block";
        }

        // Function to handle showing past reports based on filter criteria
        function showPastReports() {
            const academicYear = document.getElementById("academic_year").value;
            const term = document.getElementById("term").value;
            const studentId = "<?php echo $student_id; ?>"; // PHP injected student ID

            if (!academicYear || !term) {
                alert("Please select both academic year and term");
                return;
            }

            // Hide filter card and show report container
            document.getElementById("filter-card").style.display = "none";
            document.getElementById("report-container").style.display = "block";

            // Load report in iframe
            const iframe = document.getElementById("report-iframe");
            iframe.src = `view_report_hs.php?student_id=${studentId}&term_id=${term}&historical=1`;
        }
        </script>
        <script src="assets/js/student.js"></script>
</body>

</html>