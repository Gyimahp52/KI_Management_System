<?php
// Start the session
session_start();
include('includes/dbconnection.php');
$base_url = '/ki/KI_Management_System/';
// Check if the user is logged in and has the role of 'admin'.
// Redirect to login page if not.
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.html');
//     exit;
// }
//  echo htmlspecialchars($photoUrl);
//  echo htmlspecialchars($username); 

// $username = $_SESSION['username']; // Assuming the username is stored in the session
// $photoUrl = $_SESSION['photo_url']; // Assuming the photo URL is stored in the session


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="assets/css/adminDashboard.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <title>Admin Dashboard</title>
    </head>
<body>
    
<!--Side bar-->
<?php include_once('includes/side_bar.php');?>

<!--main content space-->
<div class="main-content">
<?php include_once('includes/header.php');?>

    <!--Cards-->
    <div class="stats-grid">
        
        <div class="card">
            <a href="student.php">
             <div class="icon"><img src="assets/images/students.png" alt="schools"></div>

            <a href="student.php">
            <?php 
                        
                        $sql1 ="SELECT * from  students";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $totstudents=$query1->rowCount();
                        ?>
             <div class="count"><?php echo htmlentities($totstudents);?></div>

            

             <span><b>Students</b></span>
            </a>
        </div>

        <div class="card">
            <a href="educators.php">
             <div class="icon"><img src="assets/images/educator.png" alt=""></div>

            <a href="educators.php">
            <?php 
                        
                        $sql1 ="SELECT * from  educators";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $toteducators=$query1->rowCount();
                        ?>
             <div class="count"><?php echo htmlentities($toteducators);?></div>

            
            
        

             <span><b>Educators</b></span>
            </a>
        </div>

        <div class="card">
            <a href="school.php">
              <div class="icon"><img src="assets/images/sch.png" alt=""></div>

            <a href="school.php">
            <?php 
                        
                        $sql1 ="SELECT * from  schools";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $totschools=$query1->rowCount();
                        ?>
              <div class="count"><?php echo htmlentities($totschools);?></div>

            
            

              <span><b>Schools</b></span>
            </a>
        </div>


        <div class="card">
            <a href="sel.php">
            <div class="icon"><img src="assets/images/sel_themes.png" alt=""></div>
            <span><b>SEL Themes</b></span>
            </a>
        </div>


        <div class="card">
            <a href="report.php">
             <div class="icon"><img src="assets/images/reports.png" alt=""></div>
            
            
             <span><b>Report</b></span>
            </a>
        </div>
        <div class="card">
            <a href="settings.php">
              <div class="icon"><img src="assets/images/settings.png" alt=""></div>
              <span><b>Settings</b></span>
            </a>
        </div>

       
    
    </div>


</div>


<!-- Modal Overlay, initially hidden -->
<!--<div id="modalOverlay" class="modal-overlay" style="display: none;">
    <div id="modalContent" class="modal-content">
        <div class="signup-container">
           
            <form id="signup-form">
              <h2>Add User Form</h2>
              <div class="input-group">
                <i class="icon-user"></i>
                <input type="text" placeholder="Enter Username" name="username" required>
              </div>
              <div class="input-group">
                <i class="icon-lock"></i>
                <input type="password" placeholder="Create Password" name="password" required>
              </div>
              <div class="input-group">
                <i class="icon-lock"></i>
                <input type="password" placeholder="Retype Password" name="confirm_password" required>
              </div>
              <div class="input-group">
                <select name="user_type" required>
                  <option value="" disabled selected>Select role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Educator</option>
                  <option value="accountant">Accountant</option>
                </select>
              </div>
              <button type="submit">Add</button>
            </form>
          </div>
    </div> 
</div> -->






 
<script src="assets/js/adminDashboard.js"></script>
<script src="assets/js/scripts.j"></script>
<script src="/admin/assets/js/adminDashboard.js"></script>

</body>
</html>

