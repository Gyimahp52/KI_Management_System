<?php
session_start();
include('includes/dbconnection.php');
//delete_educators.php
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM educators WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $_SESSION['success'] = "Educator deleted successfully";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error deleting educator: " . $e->getMessage();
    }

    header("Location: educators.php");
    exit();
}