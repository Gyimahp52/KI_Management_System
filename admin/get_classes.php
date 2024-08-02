<?php
$schoolId = $_GET['school_id'];

// Database connection
$host = 'localhost';
$db = 'ki_db';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$query = $pdo->prepare("SELECT class_id, class_name FROM classes WHERE school_id = ?");
$query->execute([$schoolId]);
$classes = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($classes);
?>
