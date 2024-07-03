<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/educators.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Information Collection Form</title>
</head>
<body>
    <!-- side bar -->
    <?php include_once('includes/side_bar.php');?>
    <!--main content space-->
    <div class="main-content">
        <?php include_once('includes/header.php');?>
        
        <div class="container mt-5">
            <!--add new educator button-->
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" id="addEducatorButton" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add new Educator</span>
                    </a>
                </li>
            </ul>

            <!-- Data collection -->
            <div class="form-container card p-4 d-none">
                <h2>Educator's details</h2>
                <div class="passport-picture mb-3"></div>
                
                <form id="educatorForm" action="educators.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="emergency">Emergency Contact</label>
                        <input type="text" id="emergency" name="emergency" placeholder="Enter emergency contact" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Location</label>
                        <input type="text" id="address" name="address" placeholder="Enter residential address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="school">School</label>
                        <select id="school" name="school" class="form-control" required>
                            <option value="">Select School</option>
                            <option value="school1">School 1</option>
                            <option value="school2">School 2</option>
                            <option value="school3">School 3</option>
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <input type="submit" name="submit" value="Submit" class="btn btn-success">
                        <button type="button" id="cancelButton" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>

            <!--table-->
            <table class="table table-striped mt-5">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>School</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Popup form for editing -->
    <div class="popup-form-container d-none" id="popupFormContainer">
        <div class="popup-form card p-4">
            <h2>Edit Educator's details</h2>
            <div class="passport-picture-popup mb-3"></div>
            <input type="file" id="passportPopup" name="passportPopup" accept="image/*" class="form-control mb-3">
            <form id="editEducatorForm" action="educators.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="editIndex">
                <div class="form-group">
                    <label for="namePopup">Name</label>
                    <input type="text" id="namePopup" name="namePopup" placeholder="Enter your name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="genderPopup">Gender</label>
                    <select id="genderPopup" name="genderPopup" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phonePopup">Phone Number</label>
                    <input type="tel" id="phonePopup" name="phonePopup" placeholder="Enter phone number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="emergencyPopup">Emergency Contact</label>
                    <input type="text" id="emergencyPopup" name="emergencyPopup" placeholder="Enter emergency contact" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="emailPopup">Email Address</label>
                    <input type="email" id="emailPopup" name="emailPopup" placeholder="Enter email address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="dobPopup">Date of Birth</label>
                    <input type="date" id="dobPopup" name="dobPopup" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="addressPopup">Location</label>
                    <input type="text" id="addressPopup" name="addressPopup" placeholder="Enter residential address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="schoolPopup">School</label>
                    <select id="schoolPopup" name="schoolPopup" class="form-control" required>
                        <option value="">Select School</option>
                        <option value="school1">School 1</option>
                        <option value="school2">School 2</option>
                        <option value="school3">School 3</option>
                    </select>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <input type="submit" name="update" value="Update" class="btn btn-success">
                    <button type="button" id="cancelPopupButton" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/educators.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>