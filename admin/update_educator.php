<?php
session_start();
include('includes/dbconnection.php');
//update_educator.php
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $school = $_POST['school'];

    try {
        $sql = "UPDATE educators SET name=:name, phone_number=:phone, email=:email, school=:school WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':school', $school, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['success'] = "Educator updated successfully";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error updating educator: " . $e->getMessage();
    }

    header("Location: educators.php");
    exit();
}