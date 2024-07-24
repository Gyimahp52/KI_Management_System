<?php
$schoolId = $_GET['school_id'];

// Database connection
$host = 'localhost';
$db = 'school_management';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$query = $pdo->prepare("SELECT id, name FROM classes WHERE school_id = ?");
$query->execute([$schoolId]);
$classes = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($classes);
?>
