<?php

//funtion.php
require_once 'db_connection.php';

function createClass($school_id, $name) {
    $pdo = Database::getConnection();
    // $class_id = generateUniqueId('classes', 'class_id');
    $stmt = $pdo->prepare("INSERT INTO classes (school_id, class_name) VALUES (?, ?)");
    return $stmt->execute([$school_id, $name]);
}

function deleteStudent($student_id) {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("DELETE FROM students WHERE student_id = ?");
    return $stmt->execute([$student_id]);
}

function updateSchool($school_id, $name) {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("UPDATE schools SET school_name = ? WHERE id = ?");
    return $stmt->execute([$name, $school_id]);
}
function deleteSchool($school_id) {
    $pdo = Database::getConnection();
    
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
        $stmt = $pdo->prepare("DELETE FROM schools WHERE id = ?");
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
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
    return $stmt->execute([$name, $class_id]);
}

function deleteClass($class_id) {
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("DELETE FROM classes WHERE class_id = ?");
    return $stmt->execute([$class_id]);
}


// function generateUniqueId($table, $column) {
//     $pdo = Database::getConnection();
//     $id = uniqid();
//     $stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE $column = ?");
//     $stmt->execute([$id]);
//     if ($stmt->fetchColumn() > 0) {
//         return generateUniqueId($table, $column);
//     }
//     return $id;
// }

function generateSchoolId($schoolName) {
    $prefix = strtoupper(substr($schoolName, 0, 3));
    $suffix = str_pad(rand(0, 999), 4, '0', STR_PAD_LEFT);
    return $prefix . $suffix;
}


function generateStudentId($school_name) {
    $prefix = strtoupper(substr($school_name, 0, 2)); // Extract the first two letters and convert to uppercase
    $random_numbers = substr(str_shuffle('0123456789'), 0, 5); // Generate a string of 5 random numbers
    return $prefix . $random_numbers; // Concatenate the prefix and random numbers
}


function createSchool($name, $region, $town, $educator, $logo) {
    global $pdo;
    $school_id = generateSchoolId($name);
    $stmt = $pdo->prepare("INSERT INTO schools (id, school_name, region, town, educator, school_logo) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$school_id, $name, $region, $town, $educator, $logo]);
}



function createStudent($school_id, $class_id, $name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email, $passport_picture, $password) {
    global $pdo;
    
    // Get the school name
    $stmt = $pdo->prepare("SELECT school_name FROM schools WHERE id = ?");
    $stmt->execute([$school_id]);
    $school = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$school) {
        return "Invalid school ID";
    }
    $school_name = $school['school_name'];
    
    // Generate unique student ID
    do {
        $student_id = generateStudentId($school_name);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE student_id = ?");
        $stmt->execute([$student_id]);
    } while ($stmt->fetchColumn() > 0);
    
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
        return "Student created successfully with ID: " . $student_id;
    } catch (Exception $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        error_log("Error creating student: " . $e->getMessage());
        return "Failed to create student: " . $e->getMessage();
    }
}


function updateStudent($studentId, $name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE students SET name = ?, dob = ?, gender = ?, hand = ?, foot = ?, eye_sight = ?, medical_condition = ?, height = ?, weight = ?, parent_name = ?, parent_phone = ?, parent_whatsapp = ?, parent_email = ? WHERE student_id = ?");
    return $stmt->execute([$name, $dob, $gender, $hand, $foot, $eye_sight, $medical_condition, $height, $weight, $parent_name, $parent_phone, $parent_whatsapp, $parent_email, $studentId]);
}



function getStudent($student_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        return null;
    }
    return $student;
}


function getClasses($school_id = null, $page = null, $perPage = null) {
    $pdo = Database::getConnection();
    
    if ($page !== null && $perPage !== null) {
        // Paginated query for table view
        $offset = ($page - 1) * $perPage;
        if ($school_id) {
            $stmt = $pdo->prepare("SELECT c.*, s.school_name FROM classes c JOIN schools s ON c.school_id = s.id WHERE c.school_id = ? LIMIT ? OFFSET ?");
            $stmt->bindValue(1, $school_id, PDO::PARAM_STR);
            $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        } else {
            $stmt = $pdo->prepare("SELECT c.*, s.school_name FROM classes c JOIN schools s ON c.school_id = s.id LIMIT ? OFFSET ?");
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
            $options .= "<option value='{$class['class_id']}'>{$class['class_name']}</option>";
        }
        return $options;
    }
}


//MANAGE SEL THEMES

// functions.php
require_once 'db_connection.php';

function getSchools($page = 1, $perPage = 10) {
    $pdo = Database::getConnection();
    $offset = ($page - 1) * $perPage;
    $stmt = $pdo->prepare("SELECT * FROM schools LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}


function getStudents($schoolId = null, $classId = null, $page = 1, $perPage = 10, $search = null) {
    $pdo = Database::getConnection();
    $offset = ($page - 1) * $perPage;
    $query = "SELECT s.*, c.class_name, sch.school_name 
              FROM students s
              JOIN classes c ON s.class_id = c.class_id
              JOIN schools sch ON c.school_id = sch.id";
    $params = [];
    
    $conditions = [];
    if ($schoolId) {
        $conditions[] = "sch.id = ?";
        $params[] = $schoolId;
    }
    if ($classId) {
        $conditions[] = "c.class_id = ?";
        $params[] = $classId;
    }
    if ($search) {
        $conditions[] = "(s.name LIKE ? OR s.student_id LIKE ? OR s.parent_name LIKE ? OR s.parent_phone LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }
    
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $query .= " ORDER BY s.name ASC LIMIT ? OFFSET ?";
    $params[] = $perPage;
    $params[] = $offset;
    
    $stmt = $pdo->prepare($query);
    
    if (!empty($params)) {
        $stmt->execute($params);
    } else {
        $stmt->execute();
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getTotal($table, $schoolId = null, $classId = null) {
    $pdo = Database::getConnection();
    $query = "SELECT COUNT(*) FROM $table";
    $params = [];
    
    if ($table === 'students') {
        $query = "SELECT COUNT(*) FROM students s
                  JOIN classes c ON s.class_id = c.class_id
                  JOIN schools sch ON c.school_id = sch.id";
        if ($schoolId) {
            $query .= " WHERE sch.id = :schoolId";
            $params[':schoolId'] = $schoolId;
            if ($classId) {
                $query .= " AND c.class_id = :classId";
                $params[':classId'] = $classId;
            }
        } elseif ($classId) {
            $query .= " WHERE c.class_id = :classId";
            $params[':classId'] = $classId;
        }
    }
    
    $stmt = $pdo->prepare($query);
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val);
    }
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getClassesOptions($schoolId) {
    $pdo = Database::getConnection();
    $query = "SELECT class_id, class_name FROM classes WHERE school_id = :schoolId ORDER BY class_name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':schoolId', $schoolId, PDO::PARAM_STR);
    $stmt->execute();
    $classes = $stmt->fetchAll();

    $options = '<option value="">Select Class</option>';
    foreach ($classes as $class) {
        $options .= "<option value='{$class['class_id']}'>{$class['class_name']}</option>";
    }
    return $options;
}

// 