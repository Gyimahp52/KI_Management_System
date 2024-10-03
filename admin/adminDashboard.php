<?php
// Start the session
include('includes/auth.php');

include('includes/dbconnection.php');
$base_url = '/ki/KI_Management_System/';

// Fetch admin information
function getAdminInfo($email, $dbh) {
  // $pdo = dbConnect();
  $stmt = $dbh->prepare('SELECT ui.* 
                         FROM user_info ui 
                         WHERE ui.email = ?');
  $stmt->execute([$email]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

$adminInfo = getAdminInfo($_SESSION['user_email'], $dbh);
$welcome_message = isset($_SESSION['welcome_message']) ? $_SESSION['welcome_message'] : "Welcome, " . $adminInfo['name'];
unset($_SESSION['welcome_message']);

// $_SESSION['login_toastr'] = ['type' => 'success', 'message' => 'Login successful!'];




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

<h1 style="margin-top: 200px"> <?php echo $welcome_message?> </h1>
    <!--Cards-->
    <div class="stats-grid" style="margin-top: 5vh">
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

