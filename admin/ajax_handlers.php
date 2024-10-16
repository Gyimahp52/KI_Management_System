<?php
//ajax_handlers.php
session_start();
require_once 'function.php';


function setFlashMessage($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function respondWithJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'createClass':
            $result = createClass($_POST['schoolId'], $_POST['name']);
            
            if ($result) {
                respondWithJson(['success' => true, 'message' => "Class created successfully"]);
            } else {
                respondWithJson(['success' => false, 'message' => "Failed to create Class"]);
            }
            break;
        
        case 'createSchool':
            $logo = '';
            if (!empty($_FILES['logo']['name'])) {
                $target_dir = "uploads/";
                $logo = uniqid() . '_' . basename($_FILES["logo"]["name"]);
                $target_file = $target_dir . $logo;
                if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    setFlashMessage('error', "Failed to upload logo");
                    respondWithJson(['success' => false]);
                }
            }
            $result = createSchool($_POST['schoolName'], $_POST['region'], $_POST['town'], $logo);

            if ($result) {
                respondWithJson(['success' => true, 'message' => "School created successfully"]);
            } else {
                respondWithJson(['success' => false, 'message' => "Failed to create school"]);
            }
            break;

        case 'createStudent':
            $passport_picture = '';
            if (!empty($_FILES['passport_picture']['name'])) {
                $target_dir = "uploads/";
                $passport_picture = uniqid() . '_' . basename($_FILES["passport_picture"]["name"]);
                $target_file = $target_dir . $passport_picture;
                if (!move_uploaded_file($_FILES["passport_picture"]["tmp_name"], $target_file)) {
                    setFlashMessage('error', "Failed to upload passport picture");
                    respondWithJson(['success' => true]);
                }
            }
            $medical_condition = isset($_POST['medical_condition']) ? $_POST['medical_condition'] : '';
                $result = createStudent(
                    $_POST['schoolId'],
                    $_POST['classId'],
                    $_POST['name'],
                    $_POST['dob'],
                    $_POST['gender'],
                    $_POST['hand'],
                    $_POST['foot'],
                    $_POST['eye_sight'],
                    $medical_condition,  
                    $_POST['height'],
                    $_POST['weight'],
                    $_POST['parent_name'],
                    $_POST['parent_phone'],
                    $_POST['parent_whatsapp'],
                    $_POST['parent_email'],
                    $passport_picture,
                    $_POST['password']
    );
    if (is_string($result) && strpos($result, "successfully") !== false) {
        respondWithJson(['success' => true, 'message' => $result]);
    } else {
        respondWithJson(['success' => false, 'message' => "Failed to create student"]);
    }
    break;

    case 'updateStudent':
        try {

            // Set medical_condition to empty string if not provided
            $medical_condition = isset($_POST['medical_condition']) ? $_POST['medical_condition'] : ''; 

            $result = updateStudent(
                $_POST['studentId'],
                $_POST['name'],
                $_POST['dob'],
                $_POST['gender'],
                $_POST['hand'],
                $_POST['foot'],
                $_POST['eye_sight'],
                $medical_condition,
                $_POST['height'],
                $_POST['weight'],
                $_POST['parent_name'],
                $_POST['parent_phone'],
                $_POST['parent_whatsapp'],
                $_POST['parent_email']
            );
            
            respondWithJson([
                'success' => (bool)$result,
                'message' => $result ? "Student updated successfully" : "Failed to update student"
            ]);
        } catch (Exception $e) {
            respondWithJson([
                'success' => false,
                'message' => "An error occurred: " . $e->getMessage()
            ]);
        }
        break;

        case 'deleteStudent':
            $result = deleteStudent($_POST['studentId']);
            if ($result) {
                respondWithJson(['success' => true, 'message' => "Student deleted successfully"]);
            } else {
                respondWithJson(['success' => false, 'message' => "Failed to delete student"]);
            }
            break;

        case 'updateSchool':
            $result = updateSchool($_POST['schoolId'], $_POST['name']);
            if($result){
                respondWithJson(['success' => true, 'message' => "School upadted successfully"]);
            }else{
                respondWithJson(['success' => false, 'message' => "Failed to update school"]);
            }
            break;

        case 'deleteSchool':
                $result = deleteSchool($_POST['schoolId']);
                $message = $result ? "School deleted successfully" : "Failed to delete school";
                respondWithJson(['success' => $result, 'message' => $message]);
                break;

        case 'updateClass':
            $result = updateClass($_POST['classId'], $_POST['name']);
            $message = $result ? "Class updated successfully" : "Failed to update Class";
            respondWithJson(['success' => $result, 'message' => $message]);
            break;

        case 'deleteClass':
            $result = deleteClass($_POST['classId']);
            $message = $result ? "Class deleted successfully" : "Failed to delete Class";
            respondWithJson(['success' => $result, 'message' => $message]);
            break;
        case 'createUser':
            $userData = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'] ?? '',
                'name' => $_POST['name'] ?? '',
                'gender' => $_POST['gender'] ?? '',
                'phone_number' => $_POST['phone_number'] ?? '',
                'emergency_contact' => $_POST['emergency_contact'] ?? '',
                'dob' => $_POST['dob'] ?? '',
                'location' => $_POST['location'] ?? '',
                // 'profile_pic' => $_POST['profile_pic'] ?? ''
            ];
            $result = createUser($userData);
            respondWithJson($result);
            // $message = $result ? "User Created successfully" : "Failed to Create User";
            // respondWithJson(['success' => $result, 'message' => $message]);
            break;

            case 'updateRole':
                $userId = intval($_POST['userId'] ?? 0);
                $newRole = $_POST['newRole'] ?? '';
                $result = updateUserRole($userId, $newRole);
                respondWithJson(['success' => $result]);
                break;

            case 'deleteUser':
                $userId = $_POST['userId'] ?? 0;
                $result = deleteUser($userId);
                $message = $result ? "User Deleted successfully" : "Failed to Delete User";
                respondWithJson(['success' => $result, 'message' => $message]);
            break;
            case 'updateLastActivity':
                $result = updateLastActivity();
                respondWithJson(['success' => $result]);
                break;
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($_GET['action']) {
        case 'getTable':
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $perPage = 10;
            $schoolId = !empty($_GET['schoolId']) ? $_GET['schoolId'] : null;
            $classId = !empty($_GET['classId']) ? $_GET['classId'] : null;
            $search = !empty($_GET['search']) ? $_GET['search'] : null;
            
            switch ($_GET['type']) {
                case 'schools':
                    $schools = getSchools($page, $perPage);
                    $total = getTotal('schools');
                    $totalPages = ceil($total / $perPage);
                    
                    $html = "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>School ID</th>
                                    <th>Name</th>
                                    <th>Region</th>
                                    <th>Town</th>
                                    <th>Logo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                    foreach ($schools as $school) {
                        $html .= "<tr>
                                <td>{$school['id']}</td>
                                <td>{$school['school_name']}</td>
                                <td>{$school['region']}</td>
                                <td>{$school['town']}</td>
                                <td><img src='uploads/{$school['school_logo']}' width='50'></td>
                                <td>
                                    <button onclick='editSchool(\"{$school['id']}\")' class='btn btn-sm btn-primary'>Edit</button>
                                    <button onclick='deleteSchool(\"{$school['id']}\")' class='btn btn-sm btn-danger'>Delete</button>
                                </td>
                              </tr>";
                    }
                    $html .= "</tbody></table>";
                    $html .= generatePagination($page, $totalPages, 'schools');
                    echo $html;
                    break;

                case 'students':
                   
                    
                        $students = getStudents($schoolId, $classId, $page, $perPage, $search);
                        $total = getTotal('students', $schoolId, $classId, $search);
                    $totalPages = ceil($total / $perPage);
                    
                    $html = "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>School</th>
                                    <th>Class</th>
                                    <th>Parent Name</th>
                                    <th>Parent Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                    foreach ($students as $student) {
                        $html .= "<tr>
                                <td>{$student['student_id']}</td>
                                <td>{$student['name']}</td>
                                <td>{$student['dob']}</td>
                                <td>{$student['gender']}</td>
                                <td>{$student['school_name']}</td>
                                <td>{$student['class_name']}</td>
                                <td>{$student['parent_name']}</td>
                                <td>{$student['parent_phone']}</td>
                                <td>
                                    <button onclick='editStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
                                    <button onclick='deleteStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
                                </td>
                              </tr>";
                    }
                    $html .= "</tbody></table>";
                    // $html .= generatePagination($page, $totalPages, 'students', $schoolId, $classId);
                    $html .= generatePagination($page, $totalPages, $_GET['type'], $schoolId, $classId, $search);
                    echo $html;
                    break;

                case 'classes':
                    $classes = getClasses($schoolId, $page, $perPage);
                    $total = getTotal('classes', $schoolId);
                    $totalPages = ceil($total / $perPage);
                    
                    $html = "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Class ID</th>
                                    <th>School</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                    foreach ($classes as $class) {
                        $html .= "<tr>
                                <td>{$class['class_id']}</td>
                                <td>{$class['school_name']}</td>
                                <td>{$class['class_name']}</td>
                                <td>
                                    <button onclick='editClass(\"{$class['class_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
                                    <button onclick='deleteClass(\"{$class['class_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
                                </td>
                              </tr>";
                    }
                    $html .= "</tbody></table>";
                    $html .= generatePagination($page, $totalPages, 'classes', $schoolId);
                    echo $html;
                    break;
            }
            break;
        
            case 'getClasses':
                $schoolId = isset($_GET['schoolId']) ? $_GET['schoolId'] : null;
                if ($schoolId) {
                    echo getClassesOptions($schoolId);
                } else {
                    echo '<option value="">Select Class</option>';
                }
                break;
        
        case 'getStudent':
            $student = getStudent($_GET['studentId']);
            if ($student) {
                respondWithJson($student);
            } else {
                respondWithJson(['error' => 'Student not found']);
            }
            break;

        case 'getUsers':
            $page = intval($_GET['page'] ?? 1);
            $result = getUsers($page);
            respondWithJson($result);
            break;
    }
}


function generatePagination($currentPage, $totalPages, $type, $schoolId = null, $classId = null, $search = null) {
    $html = "<nav><ul class='pagination'>";
    
    $range = 2;
    $showDots = false;
    
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
            $activeClass = ($i == $currentPage) ? "active" : "";
            $params = http_build_query([
                'type' => $type, 
                'page' => $i, 
                'schoolId' => $schoolId, 
                'classId' => $classId, 
                'search' => $search
            ]);
            $html .= "<li class='page-item $activeClass'><a class='page-link' href='#' onclick='showTable(\"$type\", $i, \"$schoolId\", \"$classId\", \"$search\"); return false;'>$i</a></li>";
            $showDots = true;
        } elseif ($showDots) {
            $html .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
            $showDots = false;
        }
    }
    
    $html .= "</ul></nav>";
    return $html;
}