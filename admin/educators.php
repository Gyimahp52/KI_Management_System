
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="assets/css/educators.css">
        <link rel="stylesheet" href="assets/css/adminDashboard.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <title>Information Collection Form</title>
    </head>
<body>
    
<?php include_once('includes/side_bar.php');?>
<!--main content space-->
<div class="main-content">

<?php include_once('includes/header.php');?>

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



<script src="assets/js/educators.js"></script>

</body>
</html>
