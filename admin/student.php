<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/css/adminDashboard.css">
        <link rel="stylesheet" href="assets/css/student.css">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <title>Student Registration Form</title>
    </head>
<body>
    
<!--Side bar-->
<?php include_once('includes/side_bar.php');?>

<!--main content space-->
<div class="main-content">
<?php include_once('includes/header.php');?>
    </div>

    <div class="stats-grid">


<!--add new school button-->
        <ul class="add-school">
            <li >
                <a href="#" id="addSchoolButton">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add new student</span>
                </a>
            </li>
        </ul>
        

    

        <!-- Student details collection -->
        <div id="studentFormContainer" class="container" style="display: none;">
            <h1><b>Student Registration Form</b></h1>
            <form id="student-form">
                <!-- Form Fields -->
                <fieldset>
                    <legend>Personal Information</legend>
                    <label for="passport-picture">Passport Picture:</label>
                    <input type="file" id="passport-picture" accept="image/*"><br>
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" required><br>
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" required><br>
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" required><br>
                    <label for="gender">Gender:</label>
                    <select id="gender" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select><br>
                    <label for="hand">Hand:</label>
                    <select id="hand" required>
                        <option value="">Select</option>
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select><br>
                    <label for="foot">Foot:</label>
                    <select id="foot" required>
                        <option value="">Select</option>
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select><br>
                    <label for="eyesight">Eye Sight:</label>
                    <select id="eyesight" required>
                        <option value="">Select</option>
                        <option value="normal">Normal</option>
                        <option value="short-sighted">Short-sighted</option>
                        <option value="long-sighted">Long-sighted</option>
                    </select><br>
                    <label for="medical-condition">Medical Condition:</label>
                    <input type="text" id="medical-condition" placeholder="Not available" disabled><br>
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" required><br>
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" required><br>
                </fieldset>
                <fieldset>
                    <legend>Parent/Guardian</legend>
                    <label for="guardian-name">Name:</label>
                    <input type="text" id="guardian-name" required><br>
                    <label for="guardian-phone">Phone Number:</label>
                    <input type="tel" id="guardian-phone" required><br>
                    <label for="guardian-whatsapp">WhatsApp Number:</label>
                    <input type="tel" id="guardian-whatsapp"><br>
                    <label for="guardian-email">Email Address:</label>
                    <input type="email" id="guardian-email"><br>
                </fieldset>
                <fieldset>
                    <legend>Others</legend>
                    <label for="school">School:</label>
                    <select id="school" required>
                        <option value="">Select</option>
                        <option value="A">A</option>
                        <option value="C">B</option>
                        <option value="C">C</option>
                    </select><br>
                    <label for="class">Class:</label>
                    <select id="class" required>
                        <option value="">Select</option>
                        <option value="A">KG 1</option>
                        <option value="C">KG 2</option>
                        <option value="C">KG 3</option>
                    </select><br>
                </fieldset>
                <div class="button-container">
                    <button type="submit" class="add-button">Add</button>
                    <button type="button" class="cancel-button">Cancel</button>
                    
                </div>

            </form>
        </div>
            
           <!-- Student Table -->
        <table id="studentTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>School</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
          



<script src="/admin/student/student.js"></script>

</body>
</html>