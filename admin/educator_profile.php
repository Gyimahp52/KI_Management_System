<?php
session_start();
include('includes/dbconnection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM educators WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $educator = $query->fetch(PDO::FETCH_OBJ);

    if (!$educator) {
        echo "<script>alert('Educator not found'); window.location.href='educators.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='educators.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/educators.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Educator Profile</title>
</head>
<body>
    <?php include_once('includes/side_bar.php'); ?>
    
    <div class="main-content">
        <?php include_once('includes/header.php'); ?>
        
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h2>Educator Profile</h2>
                </div>
                <div class="card-body">
                    <h3><?php echo htmlspecialchars($educator->name); ?></h3>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($educator->gender); ?></p>
                    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($educator->phone_number); ?></p>
                    <p><strong>Emergency Contact:</strong> <?php echo htmlspecialchars($educator->emergency_contact); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($educator->email); ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($educator->dob); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($educator->location); ?></p>
                    <p><strong>School:</strong> <?php echo htmlspecialchars($educator->school); ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>