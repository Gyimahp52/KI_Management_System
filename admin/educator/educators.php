<?php 
$base_url = '/ki/KI_Management_System/';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/educators.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <title>Information Collection Form</title>
    </head>
<body>
    
<!--Side bar-->
<div class="sidebar">
    <!--logo on sidebar-->
    <img src="<?php echo $base_url; ?>images/ki_logo.png" alt="Logo" class="logo">

   <!--Dashboard button-->
    <ul class="menu-item ">
        <li >
            <a href="<?php echo $base_url; ?>admin/adminDashboard.html">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <!--Educators button-->
    <ul class="menu-item ">
        <li class="active">
            <a href="/admin/educator/educators.html">
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
            <a href="/admin/school/school.html">
                <i class="fas fa-school"></i>
                <span>Schools</span>
            </a>
        </li>
    </ul>

     <!--Students button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/student/student.html">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>
        </li>
    </ul>

     <!--Reports button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/report/report.html">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>

     <!--Assign role button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/manage user/manageUser.html">
                <i class="fas fa-user-cog"></i>
                <span>Assign Role</span>
            </a>
        </li>
    </ul>

     <!--Reports button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/settings/settings.html">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

     <!--Logout button-->
     <ul class="menu-item ">
        <li>
            <a href="/login/login.html">
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
           
            <span>Admin</span>
            <h2>Dashboard</h2>
            
            <div class="search">
                <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Find educator...">
         
            </div>
            <img src="/images/user.png" alt=""/>

            
        </div>
    </div>

    <div class="stats-grid">

        <!--add new school button-->
        <ul class="add-educator">
            <li >
                <a href="#" id="addSchoolButton">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add new Educator</span>
                </a>
            </li>
        </ul>
        

    
        <!--Data collection-->
        <div class="form-container">
            <h2>Educator's details</details></h2>
            <div class="passport-picture"></div>
            <input type="file" id="passport" name="passport" accept="image/*">
            
            <form>

                <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" required>
                </div>

                <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                </select>
                </div>
        
                <div class="form-group">
                <label for="phone">Phone Number</label>
                
                <input type="tel" id="phone" name="phone"  placeholder="Enter phone number"  required>
                
                </div>

                <div class="form-group">
                <label for="emergency">Emergency Contact</label>
                <input type="text" id="emergency" name="emergency" placeholder="Enter emergency contact" required>
                </div>

                <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
                </div>

                <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
                </div>

                <div class="form-group">
                <label for="address">Location</label>
                <input type="text" id="address" name="address" placeholder="Enter residential address" required>
                </div>


                <div class="form-group">
                <label for="school">School</label>
                <select id="school" name="school" required>
                <option value="">Select School</option>
                <option value="school1">School 1</option>
                <option value="school2">School 2</option>
                <option value="school3">School 3</option>
                </select>

                </div>
        
                <input type="submit" value="Submit">
            </form>

           

          </div>

           <!--table-->
           <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>School</th>
              </tr>
            </thead>
            <tbody>
              <!-- Rows will be dynamically added here -->
            </tbody>
          </table>


       
    
    </div>


</div>



<script src="/admin/educator/educators.js"></script>

</body>
</html>
