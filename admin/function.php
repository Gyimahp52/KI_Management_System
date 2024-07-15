<?php
require_once 'config.php';

function createClass($school_id, $name) {
    global $pdo;
    $class_id = generateUniqueId('classes', 'class_id');
    $stmt = $pdo->prepare("INSERT INTO classes (class_id, school_id, name) VALUES (?, ?, ?)");
    return $stmt->execute([$class_id, $school_id, $name]);
}

function deleteStudent($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM students WHERE student_id = ?");
    return $stmt->execute([$student_id]);
}

// Add these new functions
function updateSchool($school_id, $name) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE schools SET name = ? WHERE school_id = ?");
    return $stmt->execute([$name, $school_id]);
}

function deleteSchool($school_id) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // First, get all classes associated with this school
        $stmt = $pdo->prepare("SELECT class_id FROM classes WHERE school_id = ?");
        $stmt->execute([$school_id]);
        $classes = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Delete all students in these classes
        if (!empty($classes)) {
            $placeholders = implode(',', array_fill(0, count($classes), '?'));
            $stmt = $pdo->prepare("DELETE FROM students WHERE class_id IN ($placeholders)");
            $stmt->execute($classes);
        }
        
        // Delete all classes associated with this school
        $stmt = $pdo->prepare("DELETE FROM classes WHERE school_id = ?");
        $stmt->execute([$school_id]);
        
        // Finally, delete the school
        $stmt = $pdo->prepare("DELETE FROM schools WHERE school_id = ?");
        $stmt->execute([$school_id]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error deleting school: " . $e->getMessage());
        return false;
    }
}

function updateClass($class_id, $name) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
    return $stmt->execute([$name, $class_id]);
}

function deleteClass($class_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM classes WHERE class_id = ?");
    return $stmt->execute([$class_id]);
}

// Modify these functions to include pagination
function getSchools($page = 1, $perPage = 10) {
    global $pdo;
    $offset = ($page - 1) * $perPage;
    $stmt = $pdo->prepare("SELECT * FROM schools LIMIT ? OFFSET ?");
    $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// function getClasses($school_id = null, $page = 1, $perPage = 10) {
//     global $pdo;
//     $offset = ($page - 1) * $perPage;
//     if ($school_id) {
//         $stmt = $pdo->prepare("SELECT * FROM classes WHERE school_id = ? LIMIT ? OFFSET ?");
//         $stmt->bindValue(1, $school_id, PDO::PARAM_STR);
//         $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
//         $stmt->bindValue(3, $offset, PDO::PARAM_INT);
//     } else {
//         $stmt = $pdo->prepare("SELECT * FROM classes LIMIT ? OFFSET ?");
//         $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
//         $stmt->bindValue(2, $offset, PDO::PARAM_INT);
//     }
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
 
// }

function getTotal($table) {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
    return $stmt->fetchColumn();
}


function generateUniqueId($table, $column) {
    global $pdo;
    $id = uniqid();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
    $stmt->execute([$id]);
    if ($stmt->fetchColumn() > 0) {
        return generateUniqueId($table, $column);
    }
    return $id;
}

function generateSchoolId($schoolName) {
    $prefix = strtoupper(substr($schoolName, 0, 3));
    $suffix = str_pad(rand(0, 999), 4, '0', STR_PAD_LEFT);
    return $prefix . $suffix;
}


function createSchool($name, $region, $town, $educator, $logo) {
    global $pdo;
    $school_id = generateSchoolId($name);
    $stmt = $pdo->prepare("INSERT INTO schools (school_id, name, region, town, educator, logo) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$school_id, $name, $region, $town, $educator, $logo]);
}

function createStudent($class_id, $name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email, $passport_picture, $password) {
    global $pdo;
    $student_id = generateUniqueId('students', 'student_id');
    
    // Start transaction
    $pdo->beginTransaction();
    
    try {
        // Insert into students table
        $stmt = $pdo->prepare("INSERT INTO students (student_id, class_id, name, dob, gender, hand, foot, eye_sight, medical_condition, height, weight, parent_name, parent_phone, parent_whatsapp, parent_email, passport_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$student_id, $class_id, $name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email, $passport_picture]);

        // Insert into users table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
        $stmt->execute([$student_id, $hashed_password]);

        // Commit transaction
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        return false;
    }
}

// ... (keep other existing functions)

function getStudents($class_id = null, $page = 1, $perPage = 10) {
    global $pdo;
    $offset = ($page - 1) * $perPage;
    if ($class_id) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE class_id = ? LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $class_id, PDO::PARAM_STR);
        $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM students LIMIT ? OFFSET ?");
        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateStudent($student_id, $name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE students SET name = ?, dob = ?, gender = ?, hand = ?, foot = ?, eye_sight = ?, medical_condition = ?, height = ?, weight = ?, parent_name = ?, parent_phone = ?, parent_whatsapp = ?, parent_email = ? WHERE student_id = ?");
    return $stmt->execute([$name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email, $student_id]);
}


function getStudent($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getClasses($school_id = null, $page = null, $perPage = null) {
    global $pdo;
    
    if ($page !== null && $perPage !== null) {
        // Paginated query for table view
        $offset = ($page - 1) * $perPage;
        if ($school_id) {
            $stmt = $pdo->prepare("SELECT * FROM classes WHERE school_id = ? LIMIT ? OFFSET ?");
            $stmt->bindValue(1, $school_id, PDO::PARAM_STR);
            $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM classes LIMIT ? OFFSET ?");
            $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Non-paginated query for dropdown
        if ($school_id) {
            $stmt = $pdo->prepare("SELECT * FROM classes WHERE school_id = ?");
            $stmt->execute([$school_id]);
        } else {
            $stmt = $pdo->query("SELECT * FROM classes");
        }
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $options = '<option value="">Select Class</option>';
        foreach ($classes as $class) {
            $options .= "<option value='{$class['class_id']}'>{$class['name']}</option>";
        }
        return $options;
    }
}