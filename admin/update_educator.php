<?php
session_start();
// include('includes/dbconnection.php');
include('db_config2.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = sanitize_input($_POST['name']);
    $phone = sanitize_input($_POST['phone']);
    $email = sanitize_input($_POST['email']);
    $school = sanitize_input($_POST['school']);

    // Validate inputs
    if (!validate_name($name)) {
        echo '<script>alert("Invalid name format.")</script>';
    } elseif (!validate_phone($phone)) {
        echo '<script>alert("Invalid phone number format. Must be 10 digits.")</script>';
    } elseif (!validate_email($email)) {
        echo '<script>alert("Invalid email format.")</script>';
    } else {
        try {
            // Update educator details
            $sql = "UPDATE educators SET name=:name, phone_number=:phone, email=:email, school=:school WHERE id=:id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':phone', $phone, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':school', $school, PDO::PARAM_STR);
            $query->execute();

            echo '<script>
            alert("Educator details have been updated.");
            window.location.href = "educators.php";
            </script>';
        } catch (PDOException $e) {
            echo '<script>alert("Database error occurred: ' . $e->getMessage() . '");</script>';
            error_log($e->getMessage(), 3, '/var/tmp/my-errors.log');
        }
    }
}

function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validate_name($name) {
    return preg_match("/^[a-zA-Z-' ]*$/", $name);
}

function validate_phone($phone) {
    return preg_match("/^[0-9]{10}$/", $phone);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>
