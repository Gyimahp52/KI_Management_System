<?php
// Including the database connection
//include 'dbconn.php';
include 'db_config.php';

// Function to create a new school
function createSchool($name, $region, $town, $educator, $logoFile = null) {
    global $conn;

    // Generate School ID
    $schoolId = generateSchoolId($name);
    error_log("Generated School ID: " . $schoolId);

    // Check if the generated ID already exists
    $checkStmt = $conn->prepare("SELECT id FROM schools WHERE id = ?");
    $checkStmt->bind_param("s", $schoolId);

    do {
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows == 0) break;
        $schoolId = generateSchoolId($name);
        error_log("Duplicate School ID found. Generated new School ID: " . $schoolId);
    } while (true);

    $checkStmt->close();

    // Handle logo upload
    $logo_path = "";
    if ($logoFile && $logoFile['error'] == 0) {
        $target_dir = "uploads/";
        $logo_path = $target_dir . basename($logoFile["name"]);
        move_uploaded_file($logoFile["tmp_name"], $logo_path);
        error_log("Logo uploaded to: " . $logo_path);
    }

    // Insert new school
    $sql = "INSERT INTO schools (id, region, town, educator, school_name, school_logo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $schoolId, $region, $town, $educator, $name, $logo_path);

    if ($stmt->execute()) {
        $stmt->close();
        error_log("School created successfully with ID: " . $schoolId);
        return ["id" => $schoolId];
    } else {
        error_log("Failed to create school. Error: " . $stmt->error);
        $stmt->close();
        return false;
    }
}

// Function to create a UUID
function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// Function to create a class
function createClass($schoolId, $name) {
    global $conn;

    error_log("Creating class for School ID: " . $schoolId . " with Class Name: " . $name);

    // Check if the school ID exists in the schools table
    $checkStmt = $conn->prepare("SELECT id FROM schools WHERE id = ?");
    $checkStmt->bind_param("s", $schoolId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        $checkStmt->close();
        $errorMessage = "School ID " . $schoolId . " does not exist.";
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }

    $checkStmt->close();

    // Generate UUID for new class
    $classId = generateUUID();
    error_log("Generated Class ID: " . $classId);

    // Insert new class
    $sql = "INSERT INTO classes (class_id, school_id, class_name) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $classId, $schoolId, $name);
    if ($stmt->execute()) {
        error_log("Class created successfully with ID: " . $classId);
        $stmt->close();
        return $classId;
    } else {
        error_log("Failed to create class. Error: " . $stmt->error);
        $stmt->close();
        return false;
    }
}

// Function to create a student
function createStudent($studentId, $password, $passportPicture, $firstName, $lastName, $dateOfBirth, $gender, $hand, $race, $eyeSight, $heightCm, $weightKg, $classId) {
    global $conn;
    error_log("Checking if student with ID: " . $studentId . " already exists.");

    // Check if the student already exists
    $checkSql = "SELECT student_id FROM students WHERE student_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $studentId);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        error_log("Student with ID: " . $studentId . " already exists.");
        $checkStmt->close();
        return false; // Or you can return an error message indicating the student already exists
    }
    $checkStmt->close();

    // Insert new student
    error_log("Creating student with ID: " . $studentId . ", Name: " . $firstName . " " . $lastName);
    $sql = "INSERT INTO students (student_id, password, passport_picture, first_name, last_name, date_of_birth, gender, hand, race, eye_sight, height_cm, weight_kg, class_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssssiiiii", $studentId, $password, $passportPicture, $firstName, $lastName, $dateOfBirth, $gender, $hand, $race, $eyeSight, $heightCm, $weightKg, $classId);

    if ($stmt->execute()) {
        error_log("Student created successfully with ID: " . $studentId);
        $stmt->close();
        return $studentId;
    } else {
        error_log("Failed to create student. Error: " . $stmt->error);
        $stmt->close();
        return false;
    }
}



// Function to get students by school and class
function getStudentsBySchoolAndClass($schoolId, $classId) {
    global $conn;
    error_log("Retrieving students for School ID: " . $schoolId . " and Class ID: " . $classId);
    $sql = "SELECT s.student_id, s.name, c.class_name, sch.school_name
            FROM students s
            JOIN classes c ON s.class_id = c.class_id
            JOIN schools sch ON c.school_id = sch.id
            WHERE sch.id = ? AND c.class_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $schoolId, $classId);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    error_log("Retrieved " . count($students) . " students.");
    return $students;
}

// Function to generate school ID
function generateSchoolId($schoolName) {
    $prefix = strtoupper(substr($schoolName, 0, 3));
    $suffix = str_pad(rand(0, 999), 4, '0', STR_PAD_LEFT);
    return $prefix . $suffix;
}
?>
