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
    </style>
    <title>School Admin Dashboard</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="assets/images/ki-logo.jpeg" alt="Logo" />
        </div>
        <ul class="menu-item">
            <li>
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-school"></i>
                    <span>Schools</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Classes</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." />
                </div>
                <img src="assets/images/profile.jpg" alt="Profile Picture" />
            </div>
        </div>
        <div class="container p-4">
            <div class="row form-section">
                <div class="col-12">
                    <h2>Create New School</h2>
                    <form id="create-school-form" action="db_config.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create_school">
                        <div class="form-group">
                            <label for="schoolId">School ID:</label>
                            <input type="number" class="form-control" id="schoolId" name="schoolId" required>
                        </div>
                        <div class="form-group">
                            <label for="region">Region:</label>
                            <input type="text" class="form-control" id="region" name="region" required>
                        </div>
                        <div class="form-group">
                            <label for="town">Town:</label>
                            <input type="text" class="form-control" id="town" name="town" required>
                        </div>
                        <div class="form-group">
                            <label for="educator">Educator:</label>
                            <input type="text" class="form-control" id="educator" name="educator" required>
                        </div>
                        <div class="form-group">
                            <label for="schoolName">School Name:</label>
                            <input type="text" class="form-control" id="schoolName" name="schoolName" required>
                        </div>
                        <div class="form-group">
                            <label for="schoolLogo">School Logo:</label>
                            <input type="file" class="form-control-file" id="schoolLogo" name="schoolLogo">
                        </div>
                        <button type="submit" class="btn btn-primary">Create School</button>
                    </form>
                </div>
            </div>

            <div class="row form-section">
                <div class="col-12">
                    <h2>Create New Class</h2>
                    <form id="create-class-form" action="db_config.php" method="POST">
                        <input type="hidden" name="action" value="create_class">
                        <div class="form-group">
                            <label for="schoolId">School ID:</label>
                            <input type="number" class="form-control" id="schoolId" name="schoolId" required>
                        </div>
                        <div class="form-group">
                            <label for="className">Class Name:</label>
                            <input type="text" class="form-control" id="className" name="className" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Class</button>
                    </form>
                </div>
            </div>

            <div class="row form-section">
                <div class="col-12">
                    <h2>Create New Student</h2>
                    <form id="create-student-form" action="db_config.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create_student">
                        <div class="form-group">
                            <label for="classId">Class ID:</label>
                            <input type="number" class="form-control" id="classId" name="classId" required>
                        </div>
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="dateOfBirth">Date of Birth:</label>
                            <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hand">Hand:</label>
                            <select class="form-control" id="hand" name="hand" required>
                                <option value="Left">Left</option>
                                <option value="Right">Right</option>
                                <option value="Ambidextrous">Ambidextrous</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foot">Foot:</label>
                            <select class="form-control" id="foot" name="foot" required>
                                <option value="Left">Left</option>
                                <option value="Right">Right</option>
                                <option value="Both">Both</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="eyeSight">Eye Sight:</label>
                            <input type="text" class="form-control" id="eyeSight" name="eyeSight" required>
                        </div>
                        <div class="form-group">
                            <label for="height">Height (cm):</label>
                            <input type="number" class="form-control" id="height" name="height" required>
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight (kg):</label>
                            <input type="number" class="form-control" id="weight" name="weight" required>
                        </div>
                        <div class="form-group">
                            <label for="guardianName">Guardian Name:</label>
                            <input type="text" class="form-control" id="guardianName" name="guardianName" required>
                        </div>
                        <div class="form-group">
                            <label for="guardianPhoneNumber">Guardian Phone Number:</label>
                            <input type="text" class="form-control" id="guardianPhoneNumber" name="guardianPhoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="guardianWhatsAppNumber">Guardian WhatsApp Number:</label>
                            <input type="text" class="form-control" id="guardianWhatsAppNumber" name="guardianWhatsAppNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="guardianEmailAddress">Guardian Email Address:</label>
                            <input type="email" class="form-control" id="guardianEmailAddress" name="guardianEmailAddress" required>
                        </div>
                        <div class="form-group">
                            <label for="passportPicture">Passport Picture:</label>
                            <input type="file" class="form-control-file" id="passportPicture" name="passportPicture">
                        </div>
                        <button type="submit" class="btn btn-primary">Create Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
