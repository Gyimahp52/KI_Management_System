<?php
session_start();
include('includes/dbconnection.php');

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
        $sql = "DELETE FROM users WHERE username = :username";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $email, PDO::PARAM_STR);
        $query->execute();

        $dbh->commit();
        echo '<script>alert("Educator deleted successfully."); window.location.href="educators.php";</script>';
    } catch (PDOException $e) {
        $dbh->rollBack();
        echo '<script>alert("Error deleting educator: ' . $e->getMessage() . '");</script>';
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = sanitize_input($_POST['edit_name']);
    $phone = sanitize_input($_POST['edit_phone']);
    $school = sanitize_input($_POST['edit_school']);

    try {
        $sql = "UPDATE educators SET name = :name, phone_number = :phone, school = :school WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':school', $school, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        echo '<script>alert("Educator updated successfully."); window.location.href="educators.php";</script>';
    } catch (PDOException $e) {
        echo '<script>alert("Error updating educator: ' . $e->getMessage() . '");</script>';
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
        echo '<script>alert("Missing fields: '.implode(', ', $missing_fields).'")</script>';
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

        // Validate inputs
        if (!validate_name($name)) {
            echo '<script>alert("Invalid name format.")</script>';
        } elseif (!validate_phone($phone)) {
            echo '<script>alert("Invalid phone number format. Must be 10 digits.")</script>';
        } elseif (!validate_phone($emerg_phone)) {
            echo '<script>alert("Invalid emergency phone number format. Must be 10 digits.")</script>';
        } elseif (!validate_email($email)) {
            echo '<script>alert("Invalid email format.")</script>';
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
                    $username = strtolower(explode(' ', $name)[0]); // First word of the name

                    // Insert the new educator's details
                    $sql = "INSERT INTO educators(name, gender, phone_number, emergency_contact, email, dob, location, school) VALUES (:name, :gender, :phone, :emerg_phone, :email, :dob, :location, :school)";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':name', $name, PDO::PARAM_STR);
                    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
                    $query->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $query->bindParam(':emerg_phone', $emerg_phone, PDO::PARAM_STR);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                    $query->bindParam(':location', $location, PDO::PARAM_STR);
                    $query->bindParam(':school', $school, PDO::PARAM_STR);
                    $query->execute();

                    $educator_id = $dbh->lastInsertId();

                    // Insert into users table
                    $sql = "INSERT INTO users(username, password, role) VALUES (:username, :password, 'educator')";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':username', $username, PDO::PARAM_STR);
                    $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                    $query->execute();

                    $dbh->commit();
                    echo '<script>
                    alert("Educator detail has been added.");
                    window.location.href = "educators.php";
                    </script>';
                } else {
                    echo '<script>alert("Email or Mobile Number already exists. Please try again");
                    window.location.href = "educators.php";</script>';
                }
            } catch (PDOException $e) {
                $dbh->rollBack();
                echo '<script>alert("Database error occurred: ' . $e->getMessage() . '");</script>';
                error_log($e->getMessage(), 3, '/var/tmp/my-errors.log');
            }
        }
    }
}



// // Fetch data from the database
// // Pagination
// $recordsPerPage = 10;
// $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
// $offset = ($page - 1) * $recordsPerPage;

// // Fetch all schools
// $schoolQuery = $dbh->query("SELECT DISTINCT school FROM educators ORDER BY school");
// $schools = $schoolQuery->fetchAll(PDO::FETCH_COLUMN);

// // Handle sorting
// $sortSchool = isset($_GET['sort_school']) ? $_GET['sort_school'] : '';
// $sortOrder = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'DESC' : 'ASC';

// // Construct the main query
// $sql = "SELECT * FROM educators";
// $countSql = "SELECT COUNT(*) FROM educators";
// $params = array();

// if ($sortSchool) {
//     $sql .= " WHERE school = :sort_school";
//     $countSql .= " WHERE school = :sort_school";
//     $params[':sort_school'] = $sortSchool;
// }

// $sql .= " ORDER BY id DESC";  // Keep the newest first as default
// if ($sortSchool) {
//     $sql .= ", school $sortOrder";
// }

// // Fetch total number of educators (with filter applied if any)
// $countQuery = $dbh->prepare($countSql);
// if ($sortSchool) {
//     $countQuery->bindParam(':sort_school', $sortSchool, PDO::PARAM_STR);
// }
// $countQuery->execute();
// $total = $countQuery->fetchColumn();
// $totalPages = ceil($total / $recordsPerPage);

// // Add pagination to the main query
// $sql .= " LIMIT :offset, :limit";

// // Prepare and execute the main query
// $query = $dbh->prepare($sql);
// foreach ($params as $key => $value) {
//     $query->bindValue($key, $value, PDO::PARAM_STR);
// }
// $query->bindParam(':offset', $offset, PDO::PARAM_INT);
// $query->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
// $query->execute();
// $educators = $query->fetchAll(PDO::FETCH_OBJ);
// Fetch data from the database
// Pagination
$recordsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Fetch all schools
$schoolQuery = $dbh->query("SELECT DISTINCT school FROM educators ORDER BY school");
$schools = $schoolQuery->fetchAll(PDO::FETCH_COLUMN);

// Handle sorting
$sortSchool = isset($_GET['sort_school']) ? $_GET['sort_school'] : '';
$sortOrder = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'DESC' : 'ASC';
$isSorting = isset($_GET['sort_school']) || isset($_GET['sort_order']);

// Construct the main query
$sql = "SELECT * FROM educators";
$countSql = "SELECT COUNT(*) FROM educators";
$params = array();

if ($sortSchool) {
    $sql .= " WHERE school = :sort_school";
    $countSql .= " WHERE school = :sort_school";
    $params[':sort_school'] = $sortSchool;
}

if ($isSorting) {
    if ($sortSchool) {
        $sql .= " ORDER BY school $sortOrder, id DESC";
    } else {
        $sql .= " ORDER BY id DESC";
    }
} else {
    $sql .= " ORDER BY id DESC";  // Default sorting
}

// Fetch total number of educators (with filter applied if any)
$countQuery = $dbh->prepare($countSql);
if ($sortSchool) {
    $countQuery->bindParam(':sort_school', $sortSchool, PDO::PARAM_STR);
}
$countQuery->execute();
$total = $countQuery->fetchColumn();
$totalPages = ceil($total / $recordsPerPage);

// Add pagination to the main query
$sql .= " LIMIT :offset, :limit";

// Prepare and execute the main query
$query = $dbh->prepare($sql);
foreach ($params as $key => $value) {
    $query->bindValue($key, $value, PDO::PARAM_STR);
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
    <title>Information Collection Form</title>
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
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" required>
                    </div>
                    <div class="form-group">
                       <label for="password">Password</label>
                       <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" required>
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
                        <input type="text" id="emergency" name="emergency" placeholder="Enter emergency contact" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Enter residential address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="school">School</label>
                        <select id="school" name="school" class="form-control" required>
                            <option value="">Select School</option>
                            <option value="school1">School 1</option>
                            <option value="school2">School 2</option>
                            <option value="school3">School 3</option>
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
                    <option value="<?php echo htmlspecialchars($school); ?>" <?php echo $sortSchool === $school ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($school); ?>
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
                        <th>School</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

<?php foreach ($educators as $educator): ?>
<tr>
    <td><?php echo htmlspecialchars($educator->name); ?></td>
    <td><?php echo htmlspecialchars($educator->phone_number); ?></td>
    <td><?php echo htmlspecialchars($educator->school); ?></td>
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
                        <label for="edit_school<?php echo $educator->id; ?>">School</label>
                        <input type="text" class="form-control" id="edit_school<?php echo $educator->id; ?>" name="edit_school" value="<?php echo htmlspecialchars($educator->school); ?>" required>
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
    <script src="assets/js/educators.js"></script>
    <script>

$(document).ready(function() {
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        $('#editModal' + id).modal('show');
    });
});

// document.addEventListener('DOMContentLoaded', function() {
//     const sortSchool = document.getElementById('sort_school');
//     const sortOrder = document.getElementById('sort_order');
//     const sortForm = sortSchool.closest('form');

//     sortSchool.addEventListener('change', function() {
//         sortForm.submit();
//     });

//     sortOrder.addEventListener('change', function() {
//         sortForm.submit();
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    const sortForm = document.querySelector('.sorting-controls form');
    const applyButton = sortForm.querySelector('button[type="submit"]');

    applyButton.addEventListener('click', function(e) {
        e.preventDefault();
        sortForm.submit();
    });
});

    </script>
</body>
</html>
