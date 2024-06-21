<?php
// Start the session
session_start();
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

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/admin/adminDashboard.css"> Link to your CSS file 
</head>
<body>
    <header>
        <div class="user-info">
            <img src=" ?>" alt="User Photo" class="user-photo">
            <span>//</span>
        </div>
    </header>
    <nav>
    <ul>
        <li><a href="#">User Management</a></li>
        <li><a href="#" class="menu-item" id="roles-permissions">Roles & Permissions</a></li>
        <li><a href="#">System Settings</a></li>
        <li><a href="#">Reports Overview</a></li>
        <!- Add more navigation items as needed -
    </ul>
</nav>

<main>
    <h1>Welcome to the Admin Dashboard</h1>
    <!- Dashboard specific content goes here 
    <div class="roles-permissions-form">
        <h2>Roles & Permissions</h2>
        <!- Add your form elements here 
        <form>
            <!- Form fields for roles and permissions 
            <button type="submit">Save</button>
        </form>
    </div>
</main>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/adminDashboard.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <title>Admin Dashboard</title>
    </head>
<body>
    
<!--Side bar-->
<div class="sidebar">
    <!--logo on sidebar-->
    <img src="<?php echo $base_url; ?>images/ki_logo.png" alt="Logo" class="logo">

   <!--Dashboard button-->
    <ul class="menu-item ">
        <li class="active">
            <a href="admin/adminDashboard.php">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <!--Educators button-->
    <ul class="menu-item ">
        <li>
            <a href="../admin/educator/educators.php">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Educators</span>
            </a>
        </li>
    </ul>

     <!--SEL Themes button-->
     <ul class="menu-item ">
        <li>
            <a href="#">
                <i class="fas fa-book"></i>
                <span>SEL Themes</span>
            </a>
        </li>
    </ul>

     <!--Schools button-->
     <ul class="menu-item ">
        <li>
            <a href="../admin/school/school.php">
                <i class="fas fa-school"></i>
                <span>Schools</span>
            </a>
        </li>
    </ul>

     <!--Students button-->
     <ul class="menu-item ">
        <li>
            <a href="../admin/student/student.php">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>
        </li>
    </ul>

     <!--Reports button-->
     <ul class="menu-item ">
        <li>
            <a href="../admin/report/report.php">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>

     <!--Assign role button-->
     <ul class="menu-item ">
        <li>
            <a href="<?php echo $base_url; ?>admin/manageuser/manageuser.php">
                <i class="fas fa-user-cog"></i>
                <span>Assign Role</span>
            </a>
        </li>
    </ul>

     <!--Reports button-->
     <ul class="menu-item ">
        <li>
            <a href="../admin/settings/settings.php">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

     <!--Logout button-->
     <ul class="menu-item">
    <li>
        <a href="<?php echo $base_url; ?>logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
    </li>
</ul>
      
</div>

<!--main content space-->
<div class="main-content">
    <div class="header">
        <div class="nav">
           
            <span></span>
            <h2>Dashboard</h2>
            
            <div class="search">
                <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search...">
         
            </div>
            <img src="<?php echo $base_url; ?>/images/user.png" alt=""/>

            
        </div>
    </div>

    <!--Cards-->
    <div class="stats-grid">
        
        <div class="card">
            <a href="/admin/school/school.php">
             <div class="icon"><img src="<?php echo $base_url; ?>images/students.png" alt="schools"></div>
             <div class="count">500</div>
             <span><b>Students</b></span>
            </a>
        </div>

        <div class="card">
            <a href="/admin/educator/educators.php">
             <div class="icon"><img src="<?php echo $base_url; ?>images/educator.png" alt=""></div>
             <div class="count">12</div>
             <span><b>Educators</b></span>
            </a>
        </div>

        <div class="card">
            <a href="/admin/school/school.php">
              <div class="icon"><img src="<?php echo $base_url; ?>images/sch.png" alt=""></div>
              <div class="count">30</div>
              <span><b>Schools</b></span>
            </a>
        </div>


        <div class="card">
            <div class="icon"><img src="<?php echo $base_url; ?>images/sel_themes.png" alt=""></div>
            <span><b>SEL Themes</b></span>
        </div>


        <div class="card">
            <a href="/admin/report/report.php">
             <div class="icon"><img src="<?php echo $base_url; ?>images/reports.png" alt=""></div>
             <span><b>Report</b></span>
            </a>
        </div>
        <div class="card">
            <a href="/admin/settings/settings.php">
              <div class="icon"><img src="<?php echo $base_url; ?>images/settings.png" alt=""></div>
              <span><b>Settings</b></span>
            </a>
        </div>

       
    
    </div>


</div>


<!-- Modal Overlay, initially hidden -->
<div id="modalOverlay" class="modal-overlay" style="display: none;">
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

    
</div>


<script src="/admin/adminDashboard.js"></script>

</body>
</html>
