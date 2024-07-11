<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ki_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
?>
