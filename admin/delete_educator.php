<?php
session_start();
include('db_config2.php');
//include('includes/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Delete educator
        $sql = "DELETE FROM educators WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        echo '<script>
        alert("Educator has been deleted.");
        window.location.href = "educators.php";
        </script>';
    } catch (PDOException $e) {
        echo '<script>alert("Database error occurred: ' . $e->getMessage() . '");</script>';
        error_log($e->getMessage(), 3, '/var/tmp/my-errors.log');
    }
}
?>
