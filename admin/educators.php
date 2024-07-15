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

$form_submitted = false;
if (isset($_POST['submit'])) {
    $required_fields = ['name', 'phone', 'emergency', 'email', 'gender', 'dob', 'location', 'school'];
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
                $ret = "SELECT email FROM educators WHERE email=:email OR phone_number=:phone";
                $query = $dbh->prepare($ret);
                $query->bindParam(':phone', $phone, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() == 0) {
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
                    $form_submitted = true;
                    echo '<script>
                    alert("Educator detail has been added.");
                    window.location.href = "educators.php";
                    </script>';
                } else {
                    echo '<script>alert("Email or Mobile Number already exists. Please try again");
                    window.location.href = "educators.php";</script>';
                }
            } catch (PDOException $e) {
                echo '<script>alert("Database error occurred: ' . $e->getMessage() . '");</script>';
                error_log($e->getMessage(), 3, '/var/tmp/my-errors.log');
            }
        }
    }
}

// Fetch data from the database
$sql = "SELECT * FROM educators";
$query = $dbh->prepare($sql);
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
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('editForm<?php echo $educator->id; ?>').submit();">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="if(confirm('Are you sure you want to delete this educator?')) document.getElementById('deleteForm<?php echo $educator->id; ?>').submit();">Delete</button>
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
            <form id="editForm<?php echo $educator->id; ?>" action="educators.php" method="post">
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
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/educators.js"></script>
</body>
</html>
