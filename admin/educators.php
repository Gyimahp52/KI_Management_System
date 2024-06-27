<?php
session_start();

include('includes/dbconnection.php');   

if (!isset($_SESSION['user_id']) || strlen($_SESSION['user_id']) == 0) {
    header('location:logout.php');
    exit();
}

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


if (isset($_POST['submit'])) {
    // Check if all required fields are set
    $required_fields = ['name', 'phone', 'emergency', 'email', 'gender', 'dob', 'location', 'school'];
    $missing_fields = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        echo '<script>alert("Missing fields: ")</script>';
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

                    $LastInsertId = $dbh->lastInsertId();
                    if ($LastInsertId > 0) {
                        echo '<script>alert("Teacher detail has been added.")</script>';
                        header('Location: educators.php');
                    } else {
                        echo '<script>alert("Something Went Wrong. Please try again")</script>';
                        header('Location: educators.php');
                    }
                } else {
                    echo "<script>alert('Email-id, Employee Id, or Mobile Number already exists. Please try again');</script>";
                }
            } catch (PDOException $e) {
                // Handle exceptions
                echo '<script>alert("Database error occurred: ' . $e->getMessage() . '")</script>';
                // Logged error to a file
                // error_log($e->getMessage(), 3, '/var/tmp/my-errors.log');
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/educators.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>Information Collection Form</title>
</head>
<body>

<!-- Side bar -->
<?php include_once('includes/side_bar.php'); ?>

<!-- Main content space -->
<div class="main-content">
    <?php include_once('includes/header.php'); ?>

    <div class="stats-grid">

        <!-- Data collection -->
        <div class="form-container">
            <h2>Educator's details</h2>
            <div class="passport-picture"></div>
            <input type="file" id="passport" name="passport" accept="image/*">

            <form action="educators.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
                </div>

                <div class="form-group">
                    <label for="emergency">Emergency Contact</label>
                    <input type="text" id="emergency" name="emergency" placeholder="Enter emergency contact" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" required>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                </div>

                <div class="form-group">
                    <label for="address">Location</label>
                    <input type="text" id="address" name="location" placeholder="Enter residential address" required>
                </div>

                <div class="form-group">
                    <label for="school">School</label>
                    <select id="school" name="school" required>
                        <option value="">Select School</option>
                        <option value="school1">School 1</option>
                        <option value="school2">School 2</option>
                        <option value="school3">School 3</option>
                    </select>
                </div>

                <input type="submit" name="submit" value="Submit">
            </form>

        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>School</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be dynamically added here -->
            </tbody>
        </table>

    </div>
</div>

<script src="educators.js"></script>

</body>
</html>
