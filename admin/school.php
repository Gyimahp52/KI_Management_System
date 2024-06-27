<?php
// db_config.php content
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ki_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['action']) {
        case 'create_school':
            createSchool($conn);
            break;
        case 'create_class':
            createClass($conn);
            break;
        case 'create_student':
            createStudent($conn);
            break;
        default:
            echo "Invalid action.";
    }
    $conn->close();
    exit();
}

function createSchool($conn) {
    $schoolId = $_POST['schoolId'];
    $region = $_POST['region'];
    $town = $_POST['town'];
    $educator = $_POST['educator'];
    $schoolName = $_POST['schoolName'];

    $schoolLogo = null;
    if (isset($_FILES['schoolLogo']) && $_FILES['schoolLogo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $schoolLogo = $uploadDir . basename($_FILES['schoolLogo']['name']);
        move_uploaded_file($_FILES['schoolLogo']['tmp_name'], $schoolLogo);
    }

    $stmt = $conn->prepare("INSERT INTO schools (school_id, region, town, educator, school_name, school_logo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $schoolId, $region, $town, $educator, $schoolName, $schoolLogo);

    if ($stmt->execute()) {
        echo "New school created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

function createClass($conn) {
    $schoolId = $_POST['schoolId'];
    $className = $_POST['className'];

    $stmt = $conn->prepare("INSERT INTO classes (school_id, class_name) VALUES (?, ?)");
    $stmt->bind_param("is", $schoolId, $className);

    if ($stmt->execute()) {
        echo "New class created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

function createStudent($conn) {
    $classId = $_POST['classId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['gender'];
    $hand = $_POST['hand'];
    $foot = $_POST['foot'];
    $eyeSight = $_POST['eyeSight'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $guardianName = $_POST['guardianName'];
    $guardianPhoneNumber = $_POST['guardianPhoneNumber'];
    $guardianWhatsAppNumber = $_POST['guardianWhatsAppNumber'];
    $guardianEmailAddress = $_POST['guardianEmailAddress'];

    $passportPicture = null;
    if (isset($_FILES['passportPicture']) && $_FILES['passportPicture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $passportPicture = $uploadDir . basename($_FILES['passportPicture']['name']);
        move_uploaded_file($_FILES['passportPicture']['tmp_name'], $passportPicture);
    }

    $stmt = $conn->prepare("INSERT INTO students (class_id, passport_picture, first_name, last_name, date_of_birth, gender, hand, foot, eye_sight, height, weight, guardian_name, guardian_phone_number, guardian_whatsapp_number, guardian_email_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssiiisss", $classId, $passportPicture, $firstName, $lastName, $dateOfBirth, $gender, $hand, $foot, $eyeSight, $height, $weight, $guardianName, $guardianPhoneNumber, $guardianWhatsAppNumber, $guardianEmailAddress);

    if ($stmt->execute()) {
        echo "New student created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

@media (max-width: 768px) {
  .sidebar {
    width: 80px;
  }
  .sidebar:hover {
    width: 250px;
  }
  .main-content {
    width: calc(100% - 80px);
  }
  .main-content .header {
    width: calc(100% - 80px);
  }
}
* {
  margin: 0;
  padding: 0;
  border: none;
  outline: none;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
body {
  display: flex;
}
.sidebar {
  background-color: #34495e;
  color: white;
  height: 100vh;
  width: 117px;
  position: sticky;
  top: 0;
  left: 0;
  bottom: 0;
  overflow: hidden;
  padding: 0 1.7rem;
  transition: all 0.3s linear;
  background: 113, 99, 186 255;
  z-index: 2;
}
.sidebar:hover {
  width: 310px;
  transition: 0.5s;
}
.logo {
  position: sticky;
  height: 80px;
  padding: 12px;
}
.menu-item {
  border-radius: 20px;
  padding: 15px 12px;
  border-bottom: 1px solid #2c3e50;
  cursor: pointer;
  text-decoration: none;
  color: white;
  display: block;
  position: relative;
  list-style: none;
}
.menu-item li {
  padding: 0;
  margin: 1px 0;
  border-radius: 8px;
  transition: all 0.5s ease-in-out;
}
.menu-item :hover,
.active {
  background-color: #2980b9;
  border-radius: 10px;
}
.menu-item a {
  font-size: 17px;
  align-items: center;
  text-decoration: none;
  color: white;
  display: flex;
  gap: 1.5rem;
}
.menu-item a span {
  overflow: hidden;
}
.menu-item a i {
  font-size: 1.2rem;
}

.main-content {
  width: calc(100% - 117px);
  padding: 1rem;
  background: #ecf0f1;
  position: relative;
}
.main-content .header {
  position: fixed;
  top: 0;
  right: 5;
  width: 76vw;
  height: 10vh;
  background: white;
  display: flex;
  align-items: normal;
  justify-content: normal;
  box-shadow: 0 30px 8px 0 rgba(0, 0, 0, 0.2);
  z-index: 1;
  border-radius: 25px;
}
.main-content .header .nav {
  width: 100%;
  display: flex;
  align-items: center;
}
.main-content .header .nav .search {
  flex: 3;
  display: flex;
  justify-content: center;
}
.main-content .header .nav .search i {
  padding: 15px;
  margin-right: 2px;
}
.main-content .header .nav .search input[type="text"] {
  border: none;
  background: #f1f1f1;
  padding: 12px;
  width: 400px;
  border-radius: 12px;
  position: sticky;
}
.main-content .header .nav img {
  width: 50px;
  height: 50px;
  cursor: pointer;
  border-radius: 50%;
}
.container {
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin-top: 10vh;
  background-color: rgb(216, 212, 200);
}
.form-section {
  margin-bottom: 20px;
}
.class-list {
  margin-top: 10px;
}
.class-list-item {
  margin-bottom: 5px;
}
.table-container {
  margin-top: 20px;
}
.toast-container {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1000;
}
.landscape-form {
  max-height: 60vh;
  overflow-y: auto;
}
.landscape-form .form-row {
  display: flex;
  flex-wrap: nowrap;
}
.landscape-form .form-group {
  flex: 1;
  padding: 5px;
}
    </style>
    <title>School Registration Form</title>
</head>
<body>
    <!-- Sidebar -->
    <?php include_once('includes/side_bar.php');?>

    <!-- School form body container -->
    <div class="container">
        <h2>School Registration Form</h2>
        <form id="schoolForm" enctype="multipart/form-data" novalidate>
            <input type="hidden" name="action" value="create_school" />
            <div class="form-row form-section">
                <div class="form-group col-md-3">
                    <label for="schoolId">School ID</label>
                    <input type="text" class="form-control" name="schoolId" id="schoolId" placeholder="Enter School ID" required />
                    <div class="invalid-feedback">School ID is required.</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="region">Region</label>
                    <select class="form-control" name="region" id="region" required>
                        <option value="">Select Region</option>
                        <option value="north">northern Region</option>
                        <option value="south">southen Region</option>
                        <option value="greatorAccra">Greater Accra Region</option>
                    </select>
                    <div class="invalid-feedback">Region is required.</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="town">Town</label>
                    <input type="text" class="form-control" name="town" id="town" placeholder="Enter Town" required />
                    <div class="invalid-feedback">Town is required.</div>
                </div>
                <div class="form-group col-md-3">
                    <label for="educator">Educator</label>
                    <select class="form-control" name="educator" id="educator" required>
                        <option value="">Select Educator</option>
                        <option value="bright">bright</option>
                        <option value="killua">killua</option>
                    </select>
                    <div class="invalid-feedback">Educator is required.</div>
                </div>
            </div>
            <div class="form-row form-section">
                <div class="form-group col-md-6">
                    <label for="schoolName">School Name</label>
                    <input type="text" class="form-control" name="schoolName" id="schoolName" placeholder="Enter School Name" required />
                    <div class="invalid-feedback">School Name is required.</div>
                </div>
                <div class="form-group col-md-6">
                    <label for="schoolLogo">School Logo</label>
                    <input type="file" class="form-control-file" name="schoolLogo" id="schoolLogo" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add School</button>
        </form>

        <div id="result" class="mt-4"></div>
        <div class="table-container">
            <h3>School List</h3>
            <table class="table table-striped" id="schoolTable">
                <thead>
                    <tr>
                        <th>School ID</th>
                        <th>Region</th>
                        <th>Town</th>
                        <th>Educator</th>
                        <th>School Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Class Form Modal -->
    <div class="modal fade" id="classFormModal" tabindex="-1" role="dialog" aria-labelledby="classFormModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classFormModalLabel">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="classForm" novalidate>
                        <input type="hidden" name="action" value="create_class" />
                        <div class="form-group">
                            <label for="className">Class Name</label>
                            <input type="text" class="form-control" name="className" id="className" placeholder="Enter Class Name" required />
                            <div class="invalid-feedback">Class Name is required.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Class</button>
                    </form>
                    <div id="classTableContainer" class="mt-3">
                        <h5>Classes</h5>
                        <table class="table table-striped" id="classTable">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Form Modal -->
    <div class="modal fade" id="studentFormModal" tabindex="-1" role="dialog" aria-labelledby="studentFormModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentFormModalLabel">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body landscape-form">
                    <form id="studentForm" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="action" value="create_student" />
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="passportPicture">Passport Picture</label>
                                <input type="file" class="form-control-file" name="passportPicture" id="passportPicture" required />
                                <div class="invalid-feedback">Passport Picture is required.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter First Name" required />
                                <div class="invalid-feedback">First Name is required.</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter Last Name" required />
                                <div class="invalid-feedback">Last Name is required.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dateOfBirth">Date of Birth</label>
                                <input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth" required />
                                <div class="invalid-feedback">Date of Birth is required.</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback">Gender is required.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hand">Hand</label>
                                <select class="form-control" name="hand" id="hand" required>
                                    <option value="">Select</option>
                                    <option value="left">Left dominant</option>
                                    <option value="right">Right dominant</option>
                                    <div class="invalid-feedback">Hand is required.</div>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="foot">Foot</label>
                                <select class="form-control" name="foot" id="foot" required>
                                    <option value="">Select</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                    <div class="invalid-feedback">Foot is required.</div>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="eyeSight">Eye Sight</label>
                                <select class="form-control" name="eyeSight" id="eyeSight" required>
                                    <option value="">Select</option>
                                    <option value="normal">Normal</option>
                                    <option value="short-sighted">Short-sighted</option>
                                    <option value="long-sighted">Long-sighted</option>
                                    <div class="invalid-feedback">Eye Sight is required.</div>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="height">Height (cm)</label>
                                <input type="text" class="form-control" name="height" id="height" placeholder="Enter Height" required />
                                <div class="invalid-feedback">Height is required.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="weight">Weight (kg)</label>
                                <input type="text" class="form-control" name="weight" id="weight" placeholder="Enter Weight" required />
                                <div class="invalid-feedback">Weight is required.</div>
                            </div>
                        </div>
                        <fieldset>
                            <legend>Parent/Guardian Information</legend>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="guardianName">Name</label>
                                    <input type="text" class="form-control" name="guardianName" id="guardianName" placeholder="Enter Name" required />
                                    <div class="invalid-feedback">Name is required.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="guardianPhoneNumber">Phone Number</label>
                                    <input type="text" class="form-control" name="guardianPhoneNumber" id="guardianPhoneNumber" placeholder="Enter Phone Number" required />
                                    <div class="invalid-feedback">Phone Number is required.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="guardianWhatsAppNumber">WhatsApp Number</label>
                                    <input type="text" class="form-control" name="guardianWhatsAppNumber" id="guardianWhatsAppNumber" placeholder="Enter WhatsApp Number" required />
                                    <div class="invalid-feedback">WhatsApp Number is required.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="guardianEmailAddress">Email Address</label>
                                    <input type="email" class="form-control" name="guardianEmailAddress" id="guardianEmailAddress" placeholder="Enter Email Address" required />
                                    <div class="invalid-feedback">Email Address is required.</div>
                                </div>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#schoolForm').on('submit', function(event) {
            event.preventDefault();
            
            const data = new FormData(this);
            $.ajax({
                url: 'school.php',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response);
                    location.reload(); // Reload page to see the new school
                }
            });
        });

        $('#classForm').on('submit', function(event) {
            event.preventDefault();
            
            const data = new FormData(this);
            $.ajax({
                url: 'school.php',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response);
                    $('#classFormModal').modal('hide');
                }
            });
        });

        $('#studentForm').on('submit', function(event) {
            event.preventDefault();
            
            const data = new FormData(this);
            $.ajax({
                url: 'school.php',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response);
                    $('#studentFormModal').modal('hide');
                }
            });
        });
    });
    </script>
</body>
</html>
