<?php session_start();
// Check if user is logged in and is an admin
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../index.php');
  exit();
}
?>