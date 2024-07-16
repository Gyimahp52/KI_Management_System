<?php
require_once 'function.php';


//ajax_handler.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
      
        case 'createClass':
            echo createClass($_POST['schoolId'], $_POST['name']) ? "Class created successfully" : "Failed to create class";
            break;
      
        case 'createSchool':
            $logo = $_FILES['logo']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["logo"]["name"]);
            move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
            echo createSchool($_POST['schoolName'], $_POST['region'], $_POST['town'], $_POST['educator'], $logo) ? "School created successfully" : "Failed to create school";
            break;
        case 'createStudent':
            $passport_picture = $_FILES['passport_picture']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["passport_picture"]["name"]);
            if (move_uploaded_file($_FILES["passport_picture"]["tmp_name"], $target_file)) {
                $result = createStudent($_POST['schoolId'], $_POST['classId'], $_POST['name'], $_POST['dob'], $_POST['gender'], $_POST['hand'], $_POST['foot'], $_POST['eye_sight'], $_POST['medical_condition'], $_POST['height'], $_POST['weight'], $_POST['parent_name'], $_POST['parent_phone'], $_POST['parent_whatsapp'], $_POST['parent_email'], $passport_picture, $_POST['password']);
                echo $result;
            } else {
                echo "Failed to upload passport picture";
            }
            break;
        case 'updateStudent':
            echo updateStudent($_POST['studentId'], $_POST['name'], $_POST['dob'], $_POST['gender'], $_POST['hand'], $_POST['foot'], $_POST['eye_sight'], $_POST['medical_condition'], $_POST['height'], $_POST['weight'], $_POST['parent_name'], $_POST['parent_phone'], $_POST['parent_whatsapp'], $_POST['parent_email']) ? "Student updated successfully" : "Failed to update student";
            break;
        case 'deleteStudent':
            echo deleteStudent($_POST['studentId']) ? "Student deleted successfully" : "Failed to delete student";
            break;
        case 'updateSchool':
            echo updateSchool($_POST['schoolId'], $_POST['name']) ? "School updated successfully" : "Failed to update school";
            break;
        case 'deleteSchool':
            echo deleteSchool($_POST['schoolId']) ? "School deleted successfully" : "Failed to delete school";
            break;
        case 'updateClass':
            echo updateClass($_POST['classId'], $_POST['name']) ? "Class updated successfully" : "Failed to update class";
            break;
        case 'deleteClass':
            echo deleteClass($_POST['classId']) ? "Class deleted successfully" : "Failed to delete class";
            break;
       
    }
}

elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($_GET['action']) {
        case 'getTable':
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $perPage = 10;
            switch ($_GET['type']) {
                case 'schools':
                    $schools = getSchools($page, $perPage);
                    $total = getTotal('schools');
                    $totalPages = ceil($total / $perPage);
                    
                    echo "<table class='table table-striped'>
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
                        echo "<tr>
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
                    echo "</tbody></table>";
                    echo generatePagination($page, $totalPages, 'schools');
                    break;
                case 'students':
                    $students = isset($_GET['classId']) ? getStudents($_GET['classId'], $page, $perPage) : getStudents(null, $page, $perPage);
                    $total = getTotal('students');
                    $totalPages = ceil($total / $perPage);
                    
                    echo "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Parent Name</th>
                                    <th>Parent Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                    foreach ($students as $student) {
                        echo "<tr>
                                <td>{$student['student_id']}</td>
                                <td>{$student['name']}</td>
                                <td>{$student['dob']}</td>
                                <td>{$student['gender']}</td>
                                <td>{$student['parent_name']}</td>
                                <td>{$student['parent_phone']}</td>
                                <td>
                                    <button onclick='editStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
                                    <button onclick='deleteStudent(\"{$student['student_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
                                </td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                    echo generatePagination($page, $totalPages, 'students');
                    break;
                case 'classes':
                    $classes = getClasses(null, $page, $perPage);
                    $total = getTotal('classes');
                    $totalPages = ceil($total / $perPage);
                    
                    echo "<table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Class ID</th>
                                    <th>School ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                    foreach ($classes as $class) {
                        echo "<tr>
                                <td>{$class['class_id']}</td>
                                <td>{$class['school_id']}</td>
                                <td>{$class['class_name']}</td>
                                <td>
                                    <button onclick='editClass(\"{$class['class_id']}\")' class='btn btn-sm btn-primary'>Edit</button>
                                    <button onclick='deleteClass(\"{$class['class_id']}\")' class='btn btn-sm btn-danger'>Delete</button>
                                </td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                    echo generatePagination($page, $totalPages, 'classes');
                    break;
                   
            }
            break;
        
        case 'getClasses':
            echo getClasses($_GET['schoolId']);
            break;
        
        // case 'getStudent':
        //         echo json_encode(getStudent($_GET['studentId']));
        //         break;
        case 'getStudent':
            $student = getStudent($_GET['studentId']);
            if ($student) {
                echo json_encode($student);
            } else {
                echo json_encode(['error' => 'Student not found']);
            }
            break;
    }
}
// ... (keep existing functions)
function generatePagination($currentPage, $totalPages, $type) {
    $html = "<nav><ul class='pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? "active" : "";
        $html .= "<li class='page-item $activeClass'><a class='page-link' href='#' onclick='showTable(\"$type\", $i)'>$i</a></li>";
    }
    $html .= "</ul></nav>";
    return $html;
}