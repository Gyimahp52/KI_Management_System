<?php
session_start();
require_once 'function.php';


//ajax_handler.php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     switch ($_POST['action']) {
      
//         case 'createClass':
//             echo createClass($_POST['schoolId'], $_POST['name']) ? "Class created successfully" : "Failed to create class";
//             break;
      
//         case 'createSchool':
//             $logo = $_FILES['logo']['name'];
//             $target_dir = "uploads/";
//             $target_file = $target_dir . basename($_FILES["logo"]["name"]);
//             move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
//             echo createSchool($_POST['schoolName'], $_POST['region'], $_POST['town'], $_POST['educator'], $logo) ? "School created successfully" : "Failed to create school";
//             break;

//         case 'createStudent':
//             $passport_picture = '';
//             if (!empty($_FILES['passport_picture']['name'])) {
//                 $passport_picture = $_FILES['passport_picture']['name'];
//                 $target_dir = "uploads/";
//                 $target_file = $target_dir . basename($_FILES["passport_picture"]["name"]);
//                 if (move_uploaded_file($_FILES["passport_picture"]["tmp_name"], $target_file)) {
//                     $upload_success = true;
//                 } else {
//                     echo "Failed to upload passport picture";
//                     $upload_success = false;
//                 }
//             } else {
//                 $upload_success = true;
//             }
        
//             if ($upload_success) {
//                 $result = createStudent(
//                     $_POST['schoolId'],
//                     $_POST['classId'],
//                     $_POST['name'],
//                     $_POST['dob'],
//                     $_POST['gender'],
//                     $_POST['hand'],
//                     $_POST['foot'],
//                     $_POST['eye_sight'],
//                     $_POST['medical_condition'],
//                     $_POST['height'],
//                     $_POST['weight'],
//                     $_POST['parent_name'],
//                     $_POST['parent_phone'],
//                     $_POST['parent_whatsapp'],
//                     $_POST['parent_email'],
//                     $passport_picture,
//                     $_POST['password']
//                 );
//                 echo $result;
                
//             }
//             break;
//         case 'updateStudent':
//             echo updateStudent($_POST['studentId'], $_POST['name'], $_POST['dob'], $_POST['gender'], $_POST['hand'], $_POST['foot'], $_POST['eye_sight'], $_POST['medical_condition'], $_POST['height'], $_POST['weight'], $_POST['parent_name'], $_POST['parent_phone'], $_POST['parent_whatsapp'], $_POST['parent_email']) ? "Student updated successfully" : "Failed to update student";
//             break;
//         case 'deleteStudent':
//             echo deleteStudent($_POST['studentId']) ? "Student deleted successfully " : "Failed to delete student";
//             echo "<script>setTimeout(function(){ window.location.reload(); }, 2000);</script>";
//             break;
//         case 'updateSchool':
//             echo updateSchool($_POST['schoolId'], $_POST['name']) ? "School updated successfully" : "Failed to update school";
//             break;
//         case 'deleteSchool':
//             echo deleteSchool($_POST['schoolId']) ? "School deleted successfully" : "Failed to delete school";
//             break;
//         case 'updateClass':
//             echo updateClass($_POST['classId'], $_POST['name']) ? "Class updated successfully" : "Failed to update class";
//             break;
//         case 'deleteClass':
//             echo deleteClass($_POST['classId']) ? "Class deleted successfully" : "Failed to delete class";
//             break;
       
//     }
// }

// elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     switch ($_GET['action']) {
//         case 'getTable':
//             $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//             $perPage = 10;
//             switch ($_GET['type']) {
//                 case 'schools':
//                     $schools = getSchools($page, $perPage);
//                     $total = getTotal('schools');
//                     $totalPages = ceil($total / $perPage);
                    
//                     echo "<table class='table table-striped'>
//                             <thead>
//                                 <tr>
//                                     <th>School ID</th>
//                                     <th>Name</th>
//                                     <th>Region</th>
//                                     <th>Town</th>
//                                     <th>Educator</th>
//                                     <th>Logo</th>
//                                     <th>Actions</th>
//                                 </tr>
//                             </thead>
//                             <tbody>";
//                     foreach ($schools as $school) {
//                         echo "<tr>
//                                 <td>{$school['id']}</td>
//                                 <td>{$school['school_name']}</td>
//                                 <td>{$school['region']}</td>
//                                 <td>{$school['town']}</td>
//                                 <td>{$school['educator']}</td>
//                                 <td><img src='uploads/{$school['school_logo']}' width='50'></td>
//                                 <td>
//                                     <button onclick='editSchool(\"{$school['id']}\")' class='btn btn-sm btn-primary'>Edit</button>
//                                     <button onclick='deleteSchool(\"{$school['id']}\")' class='btn btn-sm btn-danger'>Delete</button>
//                                 </td>
//                               </tr>";
//                     }
//                     echo "</tbody></table>";
//                     echo generatePagination($page, $totalPages, 'schools');
//                     break;
//                 case 'students':
//                     $students = isset($_GET['classId']) ? getStudents($_GET['classId'], $page, $perPage) : getStudents(null, $page, $perPage);
//                     $total = getTotal('students');
//                     $totalPages = ceil($total / $perPage);
                    
//                     echo "<table class='table table-striped'>
//                             <thead>
//                                 <tr>
//                                     <th>Student ID</th>
//                                     <th>Name</th>
//                                     <th>Date of Birth</th>
//                                     <th>Gender</th>
//                                     <th>Parent Name</th>
//                                     <th>Parent Phone</th>
//                                     <th>Actions</th>
//                                 </tr>
//                             </thead>
//                             <tbody>";
//                     foreach ($students as $student) {
//                         echo "<tr>
//                                 <td>{$student['student_id']}</td>
//                                 <td>{$student['name']}</td>
//                                 <td>{$student['dob']}</td>
//                                 <td>{$student['gender']}</td>
//                                 <td>{$student['parent_name']}</td>
//                                 <td>{$student['parent_phone']}</td>
//                                 <td>
//                                     <button onclick='editStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
//                                     <button onclick='deleteStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
//                                 </td>
//                               </tr>";
//                     }
//                     echo "</tbody></table>";
//                     echo generatePagination($page, $totalPages, 'students');
//                     break;
//                 case 'classes':
//                     $classes = getClasses(null, $page, $perPage);
//                     $total = getTotal('classes');
//                     $totalPages = ceil($total / $perPage);
                    
//                     echo "<table class='table table-striped'>
//                             <thead>
//                                 <tr>
//                                     <th>Class ID</th>
//                                     <th>School ID</th>
//                                     <th>Name</th>
//                                     <th>Actions</th>
//                                 </tr>
//                             </thead>
//                             <tbody>";
//                     foreach ($classes as $class) {
//                         echo "<tr>
//                                 <td>{$class['class_id']}</td>
//                                 <td>{$class['school_id']}</td>
//                                 <td>{$class['class_name']}</td>
//                                 <td>
//                                     <button onclick='editClass(\"{$class['class_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
//                                     <button onclick='deleteClass(\"{$class['class_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
//                                 </td>
//                               </tr>";
//                     }
//                     echo "</tbody></table>";
//                     echo generatePagination($page, $totalPages, 'classes');
//                     break;
                   
//             }
//             break;
        
//         case 'getClasses':
//             echo getClasses($_GET['schoolId']);
//             break;
        
      
//         case 'getStudent':
//             $student = getStudent($_GET['studentId']);
//             if ($student) {
//                 echo json_encode($student);
//             } else {
//                 echo json_encode(['error' => 'Student not found']);
//             }
//             break;
//     }
// }

// function generatePagination($currentPage, $totalPages, $type) {
//     $html = "<nav><ul class='pagination'>";
//     for ($i = 1; $i <= $totalPages; $i++) {
//         $activeClass = ($i == $currentPage) ? "active" : "";
//         $html .= "<li class='page-item $activeClass'><a class='page-link' href='#' onclick='showTable(\"$type\", $i)'>$i</a></li>";
//     }
//     $html .= "</ul></nav>";
//     return $html;
// }


// // NEW



// session_start();
// require_once 'functions.php';

// function setFlashMessage($type, $message) {
//     $_SESSION['flash'] = ['type' => $type, 'message' => $message];
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     switch ($_POST['action']) {
      
//         case 'createClass':
//             echo createClass($_POST['schoolId'], $_POST['name']) ? "Class created successfully" : "Failed to create class";
//             break;
      
//         case 'createSchool':
//             $logo = $_FILES['logo']['name'];
//             $target_dir = "uploads/";
//             $target_file = $target_dir . basename($_FILES["logo"]["name"]);
//             move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
//             echo createSchool($_POST['schoolName'], $_POST['region'], $_POST['town'], $_POST['educator'], $logo) ? "School created successfully" : "Failed to create school";
//             break;
//     case 'createStudent':
//         // ... (existing code)
//         if ($result) {
//             setFlashMessage('success', 'Student created successfully');
//         } else {
//             setFlashMessage('error', 'Failed to create student');
//         }
//         break;
//     // ... (other cases)
// }

// elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     switch ($_GET['action']) {
//         case 'getTable':
//             $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//             $perPage = 10;
//             $schoolId = isset($_GET['schoolId']) ? $_GET['schoolId'] : null;
//             $classId = isset($_GET['classId']) ? $_GET['classId'] : null;
            
//             switch ($_GET['type']) {
//                 case 'schools':
//                     $schools = getSchools($page, $perPage);
//                     $total = getTotal('schools');
//                     // ... (rest of the schools case remains the same)
//                     break;
//                 case 'students':
//                     $students = getStudents($schoolId, $classId, $page, $perPage);
//                     $total = getTotal('students', $schoolId, $classId);
//                     $totalPages = ceil($total / $perPage);
                    
//                     $html = "<table class='table table-striped'>
//                             <thead>
//                                 <tr>
//                                     <th>Student ID</th>
//                                     <th>Name</th>
//                                     <th>Date of Birth</th>
//                                     <th>Gender</th>
//                                     <th>School</th>
//                                     <th>Class</th>
//                                     <th>Parent Name</th>
//                                     <th>Parent Phone</th>
//                                     <th>Actions</th>
//                                 </tr>
//                             </thead>
//                             <tbody>";
//                     foreach ($students as $student) {
//                         $html .= "<tr>
//                                 <td>{$student['student_id']}</td>
//                                 <td>{$student['name']}</td>
//                                 <td>{$student['dob']}</td>
//                                 <td>{$student['gender']}</td>
//                                 <td>{$student['school_name']}</td>
//                                 <td>{$student['class_name']}</td>
//                                 <td>{$student['parent_name']}</td>
//                                 <td>{$student['parent_phone']}</td>
//                                 <td>
//                                     <button onclick='editStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
//                                     <button onclick='deleteStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
//                                 </td>
//                               </tr>";
//                     }
//                     $html .= "</tbody></table>";
//                     $html .= generatePagination($page, $totalPages, 'students', $schoolId, $classId);
//                     echo $html;
//                     break;
//                 // ... (classes case remains the same)
//             }
//             break;
        
//         // ... (other cases remain the same)
//     }
// }

// function generatePagination($currentPage, $totalPages, $type, $schoolId = null, $classId = null) {
//     $html = "<nav><ul class='pagination'>";
//     for ($i = 1; $i <= $totalPages; $i++) {
//         $activeClass = ($i == $currentPage) ? "active" : "";
//         $params = "\"$type\", $i" . ($schoolId ? ", \"$schoolId\"" : "") . ($classId ? ", \"$classId\"" : "");
//         $html .= "<li class='page-item $activeClass'><a class='page-link' href='#' onclick='showTable($params)'>$i</a></li>";
//     }
//     $html .= "</ul></nav>";
//     return $html;
// }


//---NEW FILE


// session_start();
// require_once 'functions.php';

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
            setFlashMessage($result ? 'success' : 'error', $result ? "Class created successfully" : "Failed to create class");
            respondWithJson(['success' => $result]);
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
            $result = createSchool($_POST['schoolName'], $_POST['region'], $_POST['town'], $_POST['educator'], $logo);
            setFlashMessage($result ? 'success' : 'error', $result ? "School created successfully" : "Failed to create school");
            respondWithJson(['success' => $result]);
            break;

        case 'createStudent':
            $passport_picture = '';
            if (!empty($_FILES['passport_picture']['name'])) {
                $target_dir = "uploads/";
                $passport_picture = uniqid() . '_' . basename($_FILES["passport_picture"]["name"]);
                $target_file = $target_dir . $passport_picture;
                if (!move_uploaded_file($_FILES["passport_picture"]["tmp_name"], $target_file)) {
                    setFlashMessage('error', "Failed to upload passport picture");
                    respondWithJson(['success' => false]);
                }
            }
            $result = createStudent(
                $_POST['schoolId'],
                $_POST['classId'],
                $_POST['name'],
                $_POST['dob'],
                $_POST['gender'],
                $_POST['hand'],
                $_POST['foot'],
                $_POST['eye_sight'],
                $_POST['medical_condition'],
                $_POST['height'],
                $_POST['weight'],
                $_POST['parent_name'],
                $_POST['parent_phone'],
                $_POST['parent_whatsapp'],
                $_POST['parent_email'],
                $passport_picture,
                $_POST['password']
            );
            setFlashMessage($result ? 'success' : 'error', $result ? "Student created successfully" : "Failed to create student");
            respondWithJson(['success' => $result]);
            break;

        case 'updateStudent':
            $result = updateStudent(
                $_POST['studentId'],
                $_POST['name'],
                $_POST['dob'],
                $_POST['gender'],
                $_POST['hand'],
                $_POST['foot'],
                $_POST['eye_sight'],
                $_POST['medical_condition'],
                $_POST['height'],
                $_POST['weight'],
                $_POST['parent_name'],
                $_POST['parent_phone'],
                $_POST['parent_whatsapp'],
                $_POST['parent_email']
            );
            setFlashMessage($result ? 'success' : 'error', $result ? "Student updated successfully" : "Failed to update student");
            respondWithJson(['success' => $result]);
            break;

        case 'deleteStudent':
            $result = deleteStudent($_POST['studentId']);
            setFlashMessage($result ? 'success' : 'error', $result ? "Student deleted successfully" : "Failed to delete student");
            respondWithJson(['success' => $result]);
            break;

        case 'updateSchool':
            $result = updateSchool($_POST['schoolId'], $_POST['name']);
            setFlashMessage($result ? 'success' : 'error', $result ? "School updated successfully" : "Failed to update school");
            respondWithJson(['success' => $result]);
            break;

        case 'deleteSchool':
            $result = deleteSchool($_POST['schoolId']);
            setFlashMessage($result ? 'success' : 'error', $result ? "School deleted successfully" : "Failed to delete school");
            respondWithJson(['success' => $result]);
            break;

        case 'updateClass':
            $result = updateClass($_POST['classId'], $_POST['name']);
            setFlashMessage($result ? 'success' : 'error', $result ? "Class updated successfully" : "Failed to update class");
            respondWithJson(['success' => $result]);
            break;

        case 'deleteClass':
            $result = deleteClass($_POST['classId']);
            setFlashMessage($result ? 'success' : 'error', $result ? "Class deleted successfully" : "Failed to delete class");
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
                                    <th>Educator</th>
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
                                <td>{$school['educator']}</td>
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
                    // $students = getStudents($schoolId, $classId, $page, $perPage);
                    // $total = getTotal('students', $schoolId, $classId);
                    
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
    }
}

// function generatePagination($currentPage, $totalPages, $type, $schoolId = null, $classId = null) {
//     $html = "<nav><ul class='pagination'>";
//     for ($i = 1; $i <= $totalPages; $i++) {
//         $activeClass = ($i == $currentPage) ? "active" : "";
//         $params = "\"$type\", $i" . ($schoolId ? ", \"$schoolId\"" : ", null") . ($classId ? ", \"$classId\"" : ", null");
//         $html .= "<li class='page-item $activeClass'><a class='page-link' href='#' onclick='showTable($params)'>$i</a></li>";
//     }
//     $html .= "</ul></nav>";
//     return $html;
// }

// function generatePagination($currentPage, $totalPages, $type, $schoolId = null, $classId = null, $search = null) {
//     $html = "<nav><ul class='pagination'>";
    
//     $range = 2;
//     $showDots = false;
    
//     for ($i = 1; $i <= $totalPages; $i++) {
//         if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)) {
//             $activeClass = ($i == $currentPage) ? "active" : "";
//             $params = json_encode(['type' => $type, 'page' => $i, 'schoolId' => $schoolId, 'classId' => $classId, 'search' => $search]);
//             $html .= "<li class='page-item $activeClass'><a class='page-link' href='#' onclick='showTable($params)'>$i</a></li>";
//             $showDots = true;
//         } elseif ($showDots) {
//             $html .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
//             $showDots = false;
//         }
//     }
    
//     $html .= "</ul></nav>";
//     return $html;
// }
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