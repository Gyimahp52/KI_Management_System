<?php
// function dbConnect() {
//     $host = 'localhost';
//     $db = 'ki_db';
//     $user = 'root';
//     $pass = '';
//     $charset = 'utf8mb4';

//     $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//     $options = [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::ATTR_EMULATE_PREPARES => false,
//     ];

//     try {
//         return new PDO($dsn, $user, $pass, $options);
//     } catch (PDOException $e) {
//         throw new PDOException($e->getMessage(), (int)$e->getCode());
//     }
// }
?>

<?php
// Database credentials
$host = 'localhost'; // or the appropriate database server address
$dbname = 'ki_db';
$username = 'root';
$password = '';

try {
    // Create a PDO instance
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException $e) {
    // Handle connection errors
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>
