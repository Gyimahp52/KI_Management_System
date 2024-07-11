<?php
include 'db_config.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    switch ($action) {
        case "create_school":
            $schoolName = trim($_POST["schoolName"]);
            $region = trim($_POST["region"]);
            $town = trim($_POST["town"]);
            $educator = trim($_POST["educator"]);
            $logoFile = isset($_FILES['school_logo']) ? $_FILES['school_logo'] : null;

            if (!empty($schoolName) && !empty($region) && !empty($town) && !empty($educator)) {
                $result = createSchool($schoolName, $region, $town, $educator, $logoFile);
                
                if ($result) {
                    $message = "School created with ID: {$result['id']}";
                } else {
                    $message = "Error creating school";
                }
            } else {
                $message = "All fields are required.";
            }
            
            echo "<script>alert('{$message}'); window.location.href = 'school.php';</script>";
            break;

        case "create_class":
            $schoolId = trim($_POST["school_id"]);
            $className = trim($_POST["class_name"]);

            if (!empty($schoolId) && !empty($className)) {
                $classId = createClass($schoolId, $className);
                echo "<script>alert('Class created with ID: {$classId}'); window.location.href = 'school.php';</script>";
            } else {
                echo "<script>alert('All fields are required.'); window.location.href = 'school.php';</script>";
            }
            break;

            case "delete_school":
                $schoolId = trim($_POST["schoolId"]);
    
                if (!empty($schoolId)) {
                    $result = deleteSchool($schoolId);
    
                    if ($result) {
                        $message = "School deleted successfully.";
                    } else {
                        $message = "Error deleting school.";
                    }
                } else {
                    $message = "Invalid school ID.";
                }
    
                echo "<script>alert('{$message}'); window.location.href = 'school.php';</script>";
                break;
    
            case "edit_school":
                $schoolId = trim($_POST["schoolId"]);
                $schoolName = trim($_POST["schoolName"]);
                $region = trim($_POST["region"]);
                $town = trim($_POST["town"]);
                $educator = trim($_POST["educator"]);
                $logoFile = isset($_FILES['schoolLogo']) ? $_FILES['schoolLogo'] : null;
    
                if (!empty($schoolId) && !empty($schoolName) && !empty($region) && !empty($town) && !empty($educator)) {
                    $result = updateSchool($schoolId, $schoolName, $region, $town, $educator, $logoFile);
    
                    if ($result) {
                        $message = "School updated successfully.";
                    } else {
                        $message = "Error updating school.";
                    }
                } else {
                    $message = "All fields are required.";
                }
    
                echo "<script>alert('{$message}'); window.location.href = 'school.php';</script>";
                break;
            
        case 'create_student':
            $studentId = trim($_POST['student_id']);
            $password = trim($_POST['password']);
            $passportPicture = isset($_FILES['passport_picture']) ? file_get_contents($_FILES['passport_picture']['tmp_name']) : null;
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $dateOfBirth = trim($_POST['date_of_birth']);
            $gender = trim($_POST['gender']);
            $hand = trim($_POST['hand']);
            $race = trim($_POST['race']);
            $eyeSight = trim($_POST['eye_sight']);
            $heightCm = trim($_POST['height_cm']);
            $weightKg = trim($_POST['weight_kg']);
            $classId = trim($_POST['class_id']);

            if (!empty($studentId) && !empty($password) && !empty($passportPicture) && !empty($firstName) && !empty($lastName) && !empty($dateOfBirth) && !empty($gender) && !empty($hand) && !empty($race) && !empty($eyeSight) && !empty($heightCm) && !empty($weightKg) && !empty($classId)) {
                $createdStudentId = createStudent($studentId, $password, $passportPicture, $firstName, $lastName, $dateOfBirth, $gender, $hand, $race, $eyeSight, $heightCm, $weightKg, $classId);

                if ($createdStudentId) {
                    echo "<script>alert('Student created with ID: {$createdStudentId}'); window.location.href = 'school.php';</script>";
                } else {
                    echo "<script>alert('Failed to create student. Student might already exist.'); window.location.href = 'school.php';</script>";
                }
            } else {
                echo "<script>alert('All fields are required.'); window.location.href = 'school.php';</script>";
            }
            break;

        default:
            echo "Invalid action";
    }
}
?>
