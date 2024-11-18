<?php
// session_start();
include('includes/auth.php');

include('includes/dbconnection.php');
include 'function.php';

// Validation and Sanitization Functions
function validate_name($name) {
    return preg_match("/^[a-zA-Z-' ]*$/", $name);
}

function validate_phone($phone) {
    return preg_match("/^[0-9]{10}$/", $phone);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}




if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $dbh->beginTransaction();

        // Get the educator's email
        $sql = "SELECT email FROM educators WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $email = $query->fetchColumn();

        // Delete from educators table
        $sql = "DELETE FROM educators WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        // Delete from users table
        $sql = "DELETE FROM users WHERE email = :email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $dbh->commit();
        
        $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Educator deleted successfully.'];
        header("Location: educators.php");
        exit;
    } catch (PDOException $e) {
        $dbh->rollBack();
        $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Error deleting educator: ' . $e->getMessage()];
        header("Location: educators.php");
        exit;
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = sanitize_input($_POST['edit_name']);
    $phone = sanitize_input($_POST['edit_phone']);
    $school = sanitize_input($_POST['edit_school']);

    try {
        $sql = "UPDATE educators SET name = :name, phone_number = :phone, school_id = :school WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':school', $school, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Educator updated successfully.'];
        header("Location: educators.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Error updating educator: ' . $e->getMessage()];
        header("Location: educators.php");
        exit;
    }
}


$form_submitted = false;
if (isset($_POST['submit'])) {
    $required_fields = ['name', 'phone', 'emergency', 'email', 'gender', 'dob', 'location', 'school', 'password'];
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        $_SESSION['toastr'] = ['type' => 'warning', 'message' => 'Missing fields: '.implode(', ', $missing_fields)];
        header("Location: educators.php");
        exit;
    } else {
        $name = sanitize_input($_POST['name']);
        $phone = sanitize_input($_POST['phone']);
        $emerg_phone = sanitize_input($_POST['emergency']);
        $email = sanitize_input($_POST['email']);
        $gender = sanitize_input($_POST['gender']);
        $dob = sanitize_input($_POST['dob']);
        $location = sanitize_input($_POST['location']);
        $school = sanitize_input($_POST['school']);
        $password = $_POST['password']; // Will be hashed later

        $profile_pic = ''; // Default empty value

        // Handle file upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["profile_pic"]["name"];
            $filetype = $_FILES["profile_pic"]["type"];
            $filesize = $_FILES["profile_pic"]["size"];
    
            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!array_key_exists($ext, $allowed)) {
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Error: Please select a valid file format.'];
                header("Location: educators.php");
                exit;
            }
    
            // Verify file size - 1MB maximum
            $maxsize = 1 * 1024 * 1024;
            if ($filesize > $maxsize) {
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Error: File size is larger than the allowed limit.'];
                header("Location: educators.php");
                exit;
            }
    
            // Verify MIME type of the file
            if (in_array($filetype, $allowed)) {
                // Generate a unique filename to prevent overwriting
                $new_filename = uniqid() . '.' . $ext;
                $upload_path = "uploads/" . $new_filename;
                
                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $upload_path)) {
                    $profile_pic = $upload_path;
                    error_log("File uploaded successfully: " . $profile_pic);
                } else {
                    error_log("Failed to move uploaded file. Error: " . error_get_last()['message']);
                    $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Error: Failed to save the uploaded file.'];
                    header("Location: educators.php");
                    exit;
                }
            } else {
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Error: There was a problem uploading your file. Please try again.'];
                header("Location: educators.php");
                exit;
            }
        }

        // Validate inputs
        if (!validate_name($name)) {
            error_log("Invalid name format: " . $name);
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid name format.'];
            header("Location: educators.php");
            exit;
        } elseif (!validate_phone($phone)) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid phone number format. Must be 10 digits.'];
            header("Location: educators.php");
            exit;
        } elseif (!validate_phone($emerg_phone)) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid emergency phone number format. Must be 10 digits.'];
            header("Location: educators.php");
            exit;
        } elseif (!validate_email($email)) {
            $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Invalid email format.'];
            header("Location: educators.php");
            exit;
        } else {
            try {
                // Check if the email or phone number already exists
                $ret = "SELECT email FROM educators WHERE email = :email OR phone_number = :phone";
                $query = $dbh->prepare($ret);
                $query->bindParam(':phone', $phone, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() == 0) {
                    $dbh->beginTransaction();

                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert the new educator's details
                    $sql = "INSERT INTO educators(name, gender, phone_number, emergency_contact, email, dob, location, school_id, profile_pic) VALUES (:name, :gender, :phone, :emerg_phone, :email, :dob, :location, :school, :profile_pic)";
                    $query = $dbh->prepare($sql);

                    $query->bindParam(':name', $name, PDO::PARAM_STR);
                    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $query->bindParam(':emerg_phone', $emerg_phone, PDO::PARAM_STR);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                    $query->bindParam(':location', $location, PDO::PARAM_STR);
                    $query->bindParam(':school', $school, PDO::PARAM_STR);
                    $query->bindParam(':profile_pic', $profile_pic, PDO::PARAM_STR);
                    
                    error_log("Profile pic path before insert: " . $profile_pic);

                    if ($query->execute()) {
                        error_log("Educator inserted successfully with profile pic: " . $profile_pic);
                        $educator_id = $dbh->lastInsertId();

                        // Insert into users table
                        $sql = "INSERT INTO users(email, password, role) VALUES (:email, :password, 'educator')";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':email', $email, PDO::PARAM_STR);
                        $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                        $query->execute();

                        $dbh->commit();
                        
                        $_SESSION['toastr'] = ['type' => 'success', 'message' => 'Educator detail has been added.'];
                        header("Location: educators.php");
                        exit;
                    } else {
                        error_log("Failed to insert educator. Error: " . implode(", ", $query->errorInfo()));
                        throw new PDOException("Failed to insert educator.");
                    }
                } else {
                    $_SESSION['toastr'] = ['type' => 'warning', 'message' => 'Email or Mobile Number already exists. Please try again.'];
                    header("Location: educators.php");
                    exit;
                }
            } catch (PDOException $e) {
                $dbh->rollBack();
                $_SESSION['toastr'] = ['type' => 'error', 'message' => 'Database error occurred: ' . $e->getMessage()];
                error_log("Database error: " . $e->getMessage());
                header("Location: educators.php");
                exit;
            }
        }
    }
}

// Fetch data from the database
// Pagination
$recordsPerPage = 10;


$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;


// Fetch distinct schools for sorting dropdown
$schoolQuery = $dbh->query("
    SELECT DISTINCT s.school_name, s.id
    FROM educators e
    JOIN schools s ON e.school_id = s.id
    ORDER BY s.school_name
");
$schools = $schoolQuery->fetchAll(PDO::FETCH_ASSOC);

// Handle sorting
$sortSchool = isset($_GET['sort_school']) ? (int)$_GET['sort_school'] : 0;
$sortOrder = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'DESC' : 'ASC';
$isSorting = isset($_GET['sort_school']) || isset($_GET['sort_order']);

// Base SQL queries
$sql = "SELECT e.*, s.school_name 
        FROM educators e
        JOIN schools s ON e.school_id = s.id";
$countSql = "SELECT COUNT(*) FROM educators e JOIN schools s ON e.school_id = s.id";

// Filter by school if sorting is applied
$whereConditions = [];
$params = [];
if ($sortSchool) {
    $whereConditions[] = "e.school_id = :sort_school";
    $params[':sort_school'] = $sortSchool;
}

if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(" AND ", $whereConditions);
    $countSql .= " WHERE " . implode(" AND ", $whereConditions);
}

// Handle sorting
if ($isSorting) {
    $sql .= " ORDER BY s.school_name $sortOrder, e.id DESC";
} else {
    $sql .= " ORDER BY e.id DESC";
}

// Fetch total number of educators (with filter applied if any)
$countQuery = $dbh->prepare($countSql);
foreach ($params as $key => $value) {
    $countQuery->bindParam($key, $value, PDO::PARAM_INT);
}
$countQuery->execute();
$total = $countQuery->fetchColumn();
$totalPages = ceil($total / $recordsPerPage);

// Add pagination to the main query
$sql .= " LIMIT :offset, :limit";

// Prepare and execute the main query
$query = $dbh->prepare($sql);
foreach ($params as $key => $value) {
    $query->bindParam($key, $value, PDO::PARAM_INT);
}
$query->bindParam(':offset', $offset, PDO::PARAM_INT);
$query->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
$query->execute();
$educators = $query->fetchAll(PDO::FETCH_OBJ);


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/educators.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/images/site.webmanifest">
    <title>Information Collection Form</title>
    <style>

.password-container {
            position: relative;
            width: 100%;
        }

        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        .password-container ion-icon {
            position: absolute;
            right: 10px;
            top: 74%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .btn{
            margin-top: 5px;
            padding: 5px 20px;
        }
    </style>
</head>

<body>
    <!-- Side bar -->
    <?php include_once('includes/side_bar.php'); ?>
    
    <!-- Main content space -->
    <div class="main-content">
        <?php include_once('includes/header.php'); ?>
        
        <div class="container mt-5">
            <!-- Add new educator button -->
            <ul class="add-educator">
                <li class="list-inline-item">
                    <a href="#" id="addEducatorButton" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add new Educator</span>
                    </a>
                </li>
            </ul>

            <!-- Data collection form -->
            <div class="form-container card p-4 d-none">
                <h2>Educator's details</h2>
                <form id="educatorForm" action="educators.php" method="post" enctype="multipart/form-data">
                    <!-- Profile Picture -->
                    <div class="form-group">
                        <label for="profile-pic">Profile Picture</label>
                        <input type="file" name="profile_pic" id="profile-pic" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" required >
                    </div>
                    <div class="form-group password-container">
                       <label for="password">Password</label>
                       <input type="password" id="password" name="password" class="form-control" required>
                       <ion-icon id="togglePassword" name="eye-off-outline"></ion-icon>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" >
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="emergency">Emergency Contact</label>
                        <input type="text" id="emergency" name="emergency" placeholder="Enter emergency contact" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Enter residential address" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="school">School</label>
                        <select id="school" name="school" class="form-control" >
                            <option value="">Select School</option>
                        <?php foreach (getSchoolsWP() as $school): ?>
                <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <input type="submit" name="submit" value="Submit" class="btn btn-success">
                        <button type="button" id="cancelButton" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>
            <div class="sorting-controls mb-3">
    <form action="" method="get" class="form-inline">
        <div class="form-group mr-2">
            <label for="sort_school" class="mr-2">Sort by School:</label>
            <select name="sort_school" id="sort_school" class="form-control">
            <option value="">All Schools</option>
    <?php foreach ($schools as $school): ?>
        <option value="<?php echo $school['id']; ?>" <?php echo $sortSchool == $school['id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($school['school_name']); ?>
        </option>
    <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mr-2">
            <label for="sort_order" class="mr-2">Order:</label>
            <select name="sort_order" id="sort_order" class="form-control">
                <option value="asc" <?php echo $sortOrder === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                <option value="desc" <?php echo $sortOrder === 'DESC' ? 'selected' : ''; ?>>Descending</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Apply Sorting</button>
    </form>
</div>
            <!-- Table displaying educators -->
            <table class="table table-striped mt-5" id="educatorTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>School</th>
                        <th>Action</th>
                        <th>Profile Pic</th>
                    </tr>
                </thead>
                <tbody>

<?php foreach ($educators as $educator): ?>
<tr>
    <td><?php echo htmlspecialchars($educator->name); ?></td>
    <td><?php echo htmlspecialchars($educator->phone_number); ?></td>
    <td><?php echo htmlspecialchars($educator->email); ?></td>
    <td><?php echo htmlspecialchars($educator->school_name); ?></td>
    <td>
    <?php if (!empty($educator->profile_pic)): ?>
        <img src="<?php echo htmlspecialchars($educator->profile_pic); ?>" alt="Profile Picture" style="width: 50px; height: auto;">
    <?php else: ?>
        No Picture
    <?php endif; ?>
    </td>
    <td>
        <a href="educator_profile.php?id=<?php echo $educator->id; ?>" class="btn btn-info btn-sm">View</a>
        <button class="btn btn-primary btn-sm edit-btn" data-id="<?php echo $educator->id; ?>">Edit</button>
        <form action="educators.php" method="post" style="display:inline;">
            <input type="hidden" name="id" value="<?php echo $educator->id; ?>">
            <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this educator?');">Delete</button>
        </form>
    </td>
</tr>

<!-- Edit Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="editModal<?php echo $educator->id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $educator->id; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel<?php echo $educator->id; ?>">Edit Educator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="educators.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $educator->id; ?>">
                    <div class="form-group">
                        <label for="edit_name<?php echo $educator->id; ?>">Name</label>
                        <input type="text" class="form-control" id="edit_name<?php echo $educator->id; ?>" name="edit_name" value="<?php echo htmlspecialchars($educator->name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone<?php echo $educator->id; ?>">Phone Number</label>
                        <input type="tel" class="form-control" id="edit_phone<?php echo $educator->id; ?>" name="edit_phone" value="<?php echo htmlspecialchars($educator->phone_number); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_schools<?php echo $educator->id; ?>">Schools</label>
                        <select name="edit_schools[]" id="edit_schools<?php echo $educator->id; ?>" class="form-control select2" multiple required>
                            <?php 
                            // Get currently assigned schools
                            $assigned_schools = getEducatorSchools($educator->id);
                            foreach (getSchoolsWP() as $school): 
                                $selected = in_array($school['id'], array_column($assigned_schools, 'school_id')) ? 'selected' : '';
                            ?>
                                <option value="<?php echo htmlspecialchars($school['id']); ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($school['school_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal<?php echo $educator->id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $educator->id; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel<?php echo $educator->id; ?>">Delete Educator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this educator?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form id="deleteForm<?php echo $educator->id; ?>" action="educators.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $educator->id; ?>">
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php 
        $queryParams = $_GET;
        for ($i = 1; $i <= $totalPages; $i++): 
            $queryParams['page'] = $i;
            $queryString = http_build_query($queryParams);
        ?>
            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                <a class="page-link" href="?<?php echo $queryString; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="assets/js/educators.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>

<?php if (isset($_SESSION['toastr'])): ?>
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
        toastr.<?php echo $_SESSION['toastr']['type']; ?>('<?php echo $_SESSION['toastr']['message']; ?>');
        <?php unset($_SESSION['toastr']); // Clear the session after displaying the message ?>
    <?php endif; ?>

$(document).ready(function() {
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        $('#editModal' + id).modal('show');
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const sortForm = document.querySelector('.sorting-controls form');
    const applyButton = sortForm.querySelector('button[type="submit"]');

    applyButton.addEventListener('click', function(e) {
        e.preventDefault();
        sortForm.submit();
    });
});


passwordVisibility('togglePassword')

function passwordVisibility(id){
   document.getElementById(id).addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this;

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.setAttribute('name', 'eye-outline'); // Change icon to closed eye
        } else {
            passwordField.type = 'password';
            icon.setAttribute('name', 'eye-off-outline'); // Change icon to open eye
        }
    });  
    }
    </script>
</body>
</html>
