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
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'school_head') {
    header('Location: ../index.php');
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

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
    <link rel="manifest" href="assets/img/site.webmanifest">
    <title>Reports Dashboard</title>

    <!--     Fonts and icons     -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- ION ICONS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css"
        rel="stylesheet" />
    <!-- TOAST R -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/transition-style">

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

    .page-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
        /* Focus ring for accessibility */
    }

    .page-btn:disabled {
        background-color: #e0e0e0;
        /* Disabled button color */
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
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#" target="_blank">
                <img src="./assets/img/ki_logo.png" class="navbar-brand-img h-100" alt="main_logo" />
                <span class="ms-1 font-weight-bold">Reports Dashboard</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0" />
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="school_head.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
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
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                        Settings
                    </h6>
                </li>
                <li class="nav-item">
                    <div class="nav-link">
                        <div
                            class="icon icon-shape icon-md border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
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

            <!-- classes CARD -->
            <div class="row mt-4">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div transition-style="in:wipe:bottom-right" id="class-cards" class="card  z-index-2"
                        style="max-height: 400px; overflow: hidden; ">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">Student Overall Progress</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                                <span class="font-weight-bold">4% more</span> in 2023
                            </p>
                        </div>
                        <div transition-style="in:diamond:center" class="card-body p-3" style="overflow-y: auto;">
                            <div class="chart">
                                <h2>Assigned Schools</h2>
                                <form id="schoolForm">
                                    <label for="school_id">Select a School:</label>
                                    <select name="school_id" id="school_id">
                                        <option value="" disabled selected>Select a School</option>
                                        <?php foreach ($schools as $school): ?>
                                        <option value="<?= $school['id']; ?>">
                                            <?= htmlspecialchars($school['school_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>

                                <h3>Classes</h3>
                                <div id="classesContainer">
                                    <p>Select a school to see classes.</p>
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
                    <div transition-style="in:diamond:center" id="student-table" class="col-12 " style="display: none;">
                        <div class="card mb-4">
                            <div class="d-flex justify-content-between card-header pb-0">
                                <button class="backbtn btn btn-secondary btn-sm" id="back-button">Back</button>
                                <h6 class="mb-2">View this term Score</h6>
                                <h2 id="class-name" class="class-name" style="padding-left: 1.2rem"
                                    style="display: none"></h2>
                                <form id="search-form" class="search-bar" onsubmit="return false;">
                                    <input type="hidden" name="class_id" value="<?php echo $classId; ?>"
                                        style="display:none">
                                    <input type="text" name="search" id="student-search"
                                        class="form-control std-search-input" placeholder="Search by ID or Name"
                                        value="<?php echo htmlspecialchars($searchQuery); ?>">
                                </form>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <form id="score-form" action="">

                                        <table id="students-table" class="input-table table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-9">
                                                        #</th>
                                                    <th
                                                        class="text-uppercase align-middle text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Student ID</th>
                                                    <th
                                                        class="text-center align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Name</th>
                                                    <th
                                                        class="text-center align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Class</th>
                                                    <th
                                                        class="text-center align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Actions</th>
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
                <div class="mt-2 mb-5 d-flex">
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







        // In your main dashboard JavaScript (likely in reportscopy.php)
        $(document).ready(function() {
            // Function to fetch and populate schools
            function loadSchools() {
                $.ajax({
                    url: 'fetch_schools.php', // New endpoint to fetch assigned schools
                    method: 'GET',
                    dataType: 'json',
                    success: function(schools) {
                        var schoolSelect = $('#school_id');
                        schoolSelect.empty();
                        schoolSelect.append(
                            '<option value="" disabled selected>Select a School</option>');
                        schools.forEach(function(school) {
                            schoolSelect.append(
                                `<option value="${school.id}">${school.school_name}</option>`
                            );
                        });
                    },
                    error: function() {
                        toastr.error('Failed to load schools');
                    }
                });
            }

            // Function to fetch classes for a selected school
            function loadClasses(schoolId) {
                $.ajax({
                    url: 'fetch_classes.php',
                    method: 'GET',
                    data: {
                        school_id: schoolId
                    },
                    dataType: 'json',
                    success: function(classes) {
                        var classesContainer = $('#classesContainer');
                        classesContainer.empty();

                        if (classes.length === 0) {
                            classesContainer.html('<p>No classes found for this school.</p>');
                            return;
                        }

                        classes.forEach(function(cls) {
                            var classCard = $(`
                        <div transition-style="in:wipe:down" class="card class-card" data-class-id="${cls.class_id}">
                            <div class="card-body">
                                <h5 class="card-title">${cls.class_name}</h5>
                                <p class="card-text">Students: ${cls.student_count}</p>
                            </div>
                        </div>
                    `);
                            classesContainer.append(classCard);
                        });
                    },
                    error: function() {
                        toastr.error('Failed to load classes');
                    }
                });
            }

            // Function to load students for a class
            //  function loadStudents(classId, page = 1, searchQuery = '') {
            //     console.log('Loading students with params:', {
            //         classId: classId, 
            //         page: page, 
            //         searchQuery: searchQuery
            //     });

            //     // Update the browser's history state
            //     const urlParams = new URLSearchParams({ 
            //         class_id: classId, 
            //         page: page, 
            //         search: searchQuery 
            //     });
            //     const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            //     history.pushState(
            //         { classId, page, searchQuery },  
            //         '',                             
            //         newUrl                          
            //     );

            //     // Perform AJAX request
            //     $.ajax({
            //         url: 'get_students.php',
            //         method: 'GET',
            //         data: { 
            //             class_id: classId, 
            //             page: page, 
            //             search: searchQuery 
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             console.log('Full response:', response);
            //             if (response.success) {
            //                 if (response.data.students && response.data.students.length > 0) {
            //                     $('#class-cards').hide();
            //                     $('#student-table').show();
            //                     renderStudentTable(response.data.students, response.data.termId);
            //                     renderPagination(response.data.total_pages, response.data.current_page);

            //                 } else {
            //                     $('#student-list tbody').html('<tr><td colspan="6">No students found</td></tr>');
            //                     console.log('No students in response');
            //                 }
            //             } else {
            //                 toastr.error(response.data.message);
            //                 console.error('Failed to load students:', response.data.message);
            //             }
            //         },
            //         error: function(xhr, status, error) {
            //             toastr.error('Failed to load students');
            //             console.error('AJAX error:', status, error);
            //             console.error('Response:', xhr.responseText);
            //         }
            //     });
            // }

            // Modify the class card click event to ensure classId is passed correctly
            $(document).on('click', '.class-card', function() {
                var classId = $(this).data('class-id');
                console.log('Selected class ID:', classId);
                loadStudents(classId);
            });

            $('#back-button').click(function() {
                $('#student-table').hide();
                $('#class-cards').show();
                history.pushState(null, '', 'reports.php');
            });

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


            function renderPagination(totalPages, currentPage) {
                // Clear existing pagination
                $('#pagination').empty();

                // Only render pagination if there are multiple pages
                if (totalPages > 1) {
                    // Previous button
                    if (currentPage > 1) {
                        $('#pagination').append(
                            `<button class="page-btn" data-page="${currentPage - 1}">Previous</button>`
                        );
                    }

                    // Page numbers
                    for (let i = 1; i <= totalPages; i++) {
                        $('#pagination').append(
                            `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">
                    ${i}
                 </button>`
                        );
                    }

                    // Next button
                    if (currentPage < totalPages) {
                        $('#pagination').append(
                            `<button class="page-btn" data-page="${currentPage + 1}">Next</button>`
                        );
                    }

                    // Add click event to pagination buttons
                    $('.page-btn').on('click', function() {
                        const page = $(this).data('page');

                        // Try multiple ways to get the class ID
                        const classId =
                            $('.class-card.active').data('class-id') ||
                            // If class card is marked active
                            $('input[name="class_id"]').val() || // From hidden input
                            $('#class-select').val(); // From class select dropdown

                        console.log('Pagination click - Class ID:', classId);

                        const searchQuery = $('#student-search').val() || ''; // Get search query

                        if (!classId) {
                            toastr.error('Please select a class first');
                            return;
                        }

                        loadStudents(classId, page, searchQuery);
                    });
                }
            }

            // Modify class card selection to mark active state
            $(document).on('click', '.class-card', function() {
                // Remove active state from all class cards
                $('.class-card').removeClass('active');

                // Add active state to clicked card
                $(this).addClass('active');

                var classId = $(this).data('class-id');
                console.log('Selected class ID:', classId);
                loadStudents(classId);
            });


            function renderStudentTable(students, termId) {
                const tableBody = $('#student-list');
                tableBody.empty();

                // Debug logging
                console.log('Rendering students:', students);

                if (students.length === 0) {
                    tableBody.html('<tr><td colspan="6" class="text-center">No students found</td></tr>');
                    return;
                }

                // Add termId to each student
                const updatedStudents = students.map(student => ({
                    ...student, // Spread existing properties
                    termId: termId, // Add termId
                }));

                // Render table rows
                updatedStudents.forEach((student, index) => {
                    const row = `
            <tr>
                <td class="align-middle text-center text-sm">${index + 1}</td>
                <td class="align-middle text-center text-sm">${student.student_id || 'N/A'}</td>
                <td class="align-middle text-center text-sm">${student.name || 'Unknown'}</td>
                <td class="align-middle text-center text-sm">${student.class_name || 'N/A'}</td>
                <td class="align-middle text-center text-sm">
                        <a href="view_report.php?student_id=${student.student_id}&term_id=${student.termId}" style="background-color:none; border: none" target="_blank">
                        <span class="badge badge-sm bg-gradient-success">View Report</span></a>
                </td>
            </tr>
        `;
                    tableBody.append(row);
                });
                console.log('Table rows added:', tableBody.find('tr').length);
            }


            // Function to view student report
            function viewStudentReport(studentId, termId) {
                $.ajax({
                    url: 'download_report_pdf',
                    method: 'GET',
                    data: {
                        student_id: studentId,
                        term_id: termId
                    },
                    success: function(reportHtml) {
                        // Create modal dynamically
                        console.log(reportHtml);
                        var modal = $(`
                    <div class="modal fade" id="studentReportModal" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Student Progress Report</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    ${reportHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                        $('body').append(modal);
                        var reportModal = new bootstrap.Modal(document.getElementById(
                            'studentReportModal'));
                        reportModal.show();
                    },
                    error: function() {
                        toastr.error('Failed to load student report');
                    }
                });
            }

            // Event Listeners
            $('#school_id').on('change', function() {
                var schoolId = $(this).val();
                loadClasses(schoolId);
            });

            $(document).on('click', '.class-card', function() {
                var classId = $(this).data('class-id');
                loadStudents(classId);
            });

            //     // Attach a handler to the search form
            //   $('#student-search').on('input', function() {
            //       performSearch();
            //   });

            // // Disable default form submission for 'Enter' key in the search bar
            //   $('#search-form').on('submit', function(e) {
            //       e.preventDefault();
            //       performSearch();
            //   });

            // // Function to perform the search and update the student list dynamically
            //   function performSearch() {
            //     var searchQuery = $('#student-search').val();
            //     var page = 1; // reset to first page for new search
            //     loadStudents(classId, page, searchQuery);
            //   }

            let currentClassId = null;
            let currentPage = 1;

            // Function to perform the search and update the student list dynamically
            function performSearch() {
                const searchQuery = $('#student-search').val().trim();

                // Ensure a class is selected before searching
                if (!currentClassId) {
                    toastr.warning('Please select a class first');
                    return;
                }

                // Reset to first page when performing a new search
                currentPage = 1;

                // Load students with search parameters
                loadStudents(currentClassId, currentPage, searchQuery);
            }

            // Debounce function to prevent excessive API calls
            function debounce(func, delay) {
                let timeoutId;
                return function() {
                    const context = this;
                    const args = arguments;

                    clearTimeout(timeoutId);

                    timeoutId = setTimeout(() => {
                        func.apply(context, args);
                    }, delay);
                };
            }

            // Attach debounced search handler
            $('#student-search').on('input', debounce(function() {
                performSearch();
            }, 300)); // 300ms delay

            // Prevent default form submission
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                performSearch();
            });

            // Modify class card click to update currentClassId
            $(document).on('click', '.class-card', function() {
                currentClassId = $(this).data('class-id');
                console.log('Selected class ID:', currentClassId);

                // Clear previous search
                $('#student-search').val('');

                loadStudents(currentClassId);
            });

            // Modify loadStudents function to handle search more robustly
            function loadStudents(classId, page = 1, searchQuery = '') {
                console.log('Loading students with params:', {
                    classId: classId,
                    page: page,
                    searchQuery: searchQuery
                });

                // Update current tracking variables
                currentClassId = classId;
                currentPage = page;

                // Update URL for better browser history and sharing
                const urlParams = new URLSearchParams({
                    class_id: classId,
                    page: page,
                    search: searchQuery
                });
                const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                history.pushState({
                    classId,
                    page,
                    searchQuery
                }, '', newUrl);

                // AJAX request to fetch students
                $.ajax({
                    url: 'get_students.php',
                    method: 'GET',
                    data: {
                        class_id: classId,
                        page: page,
                        search: searchQuery
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (response.data.students && response.data.students.length > 0) {
                                $('#class-cards').hide();
                                $('#student-table').show();

                                // Render students and pagination
                                renderStudentTable(response.data.students, response.data.termId);
                                renderPagination(
                                    response.data.total_pages,
                                    response.data.current_page,
                                    currentClassId,
                                    searchQuery
                                );

                                // Show/hide "No results" message
                                $('#no-results').toggle(response.data.students.length === 0);
                            } else {
                                // No students found
                                $('#student-list tbody').html(`
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div id="no-results" class="alert alert-info">
                                        No students found matching "${searchQuery}"
                                    </div>
                                </td>
                            </tr>
                        `);
                            }
                        } else {
                            toastr.error(response.data.message || 'Failed to load students');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Failed to load students');
                        console.error('AJAX error:', status, error);
                    }
                });
            }

            // Modify renderPagination to pass additional context
            function renderPagination(totalPages, currentPage, classId, searchQuery) {
                const $pagination = $('#pagination');
                $pagination.empty();

                if (totalPages > 1) {
                    // Previous button
                    if (currentPage > 1) {
                        $pagination.append(
                            `<button class="page-btn" data-page="${currentPage - 1}">Previous</button>`
                        );
                    }

                    // Page numbers
                    for (let i = 1; i <= totalPages; i++) {
                        $pagination.append(
                            `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">
                        ${i}
                     </button>`
                        );
                    }

                    // Next button
                    if (currentPage < totalPages) {
                        $pagination.append(
                            `<button class="page-btn" data-page="${currentPage + 1}">Next</button>`
                        );
                    }

                    // Pagination click handler
                    $('.page-btn').on('click', function() {
                        const page = $(this).data('page');

                        // Use tracked variables if not explicitly passed
                        const pageClassId = classId || currentClassId;
                        const pageSearchQuery = searchQuery || $('#student-search').val() || '';

                        if (!pageClassId) {
                            toastr.error('Please select a class first');
                            return;
                        }

                        loadStudents(pageClassId, page, pageSearchQuery);
                    });
                }
            }

            // Initial load of schools
            loadSchools();
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
                    content.style.marginLeft = sidebar.classList.contains('collapsed') ?
                        'calc(6.4rem + 20px)' :
                        '270px';
                }, 10); // Half of the transition time (300ms / 2)
            }
        });
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                content.style.marginLeft = sidebar.classList.contains('collapsed') ?
                    'calc(6.4rem + 20px)' :
                    '270px';
            } else {
                content.style.marginLeft = '0';
            }
        });
        </script>
</body>

</html>