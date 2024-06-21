<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            .sidebar:hover {
                width: 250px;
            }
            .main-content {
                width: calc(100% - 80px);
            }
            .main-content .header {
                width: calc(100% - 80px);
            }
        }
        * {
            margin: 0;
            padding: 0;
            border: none;
            outline: none;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
        }
        .sidebar {
            background-color: #34495e;
            color: white;
            height: 100vh;
            width: 117px;
            position: sticky;
            top: 0;
            left: 0;
            bottom: 0;
            overflow: hidden;
            padding: 0 1.7rem;
            transition: all 0.3s linear;
            background: 113, 99, 186. 255;
            z-index: 2;
        }
        .sidebar:hover {
            width: 310px;
            transition: 0.5s;
        }
        .logo {
            position: sticky;
            height: 80px;
            padding: 12px;
        }
        .menu-item {
            border-radius: 20px;
            padding: 15px 12px;
            border-bottom: 1px solid #2c3e50;
            cursor: pointer;
            text-decoration: none;
            color: white;
            display: block;
            position: relative;
            list-style: none;
        }
        .menu-item li {
            padding: 0;
            margin: 1px 0;
            border-radius: 8px;
            transition: all 0.5s ease-in-out;
        }
        .menu-item :hover,
        .active {
            background-color: #2980b9;
            border-radius: 10px;
        }
        .menu-item a {
            font-size: 17px;
            align-items: center;
            text-decoration: none;
            color: white;
            display: flex;
            gap: 1.5rem;
        }
        .menu-item a span {
            overflow: hidden;
        }
        .menu-item a i {
            font-size: 1.2rem;
        }

        .main-content {
            width: calc(100% - 117px);
            padding: 1rem;
            background: #ecf0f1;
            position: relative;
        }
        .main-content .header {
            position: fixed;
            top: 0;
            right: 5;
            width: 76vw;
            height: 10vh;
            background: white;
            display: flex;
            align-items: normal;
            justify-content: normal;
            box-shadow: 0 30px 8px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 25px;
        }
        .main-content .header .nav {
            width: 100%;
            display: flex;
            align-items: center;
        }
        .main-content .header .nav .search {
            flex: 3;
            display: flex;
            justify-content: center;
        }
        .main-content .header .nav .search i {
            padding: 15px;
            margin-right: 2px;
        }
        .main-content .header .nav .search input[type=text] {
            border: none;
            background: #f1f1f1;
            padding: 12px;
            width: 400px;
            border-radius: 12px;
            position: sticky;
        }
        .main-content .header .nav img {
            width: 50px;
            height: 50px;
            cursor: pointer;
            border-radius: 50%;
        }
        .container {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 10vh;
            background-color: rgb(216, 212, 200);
        }
        .form-section {
            margin-bottom: 20px;
        }
        .class-list {
            margin-top: 10px;
        }
        .class-list-item {
            margin-bottom: 5px;
        }
        .table-container {
            margin-top: 20px;
        }
        .toast-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        .landscape-form {
            max-height: 60vh;
            overflow-y: auto;
        }
        .landscape-form .form-row {
            display: flex;
            flex-wrap: nowrap;
        }
        .landscape-form .form-group {
            flex: 1;
            padding: 5px;
        }
    </style>
    
    <title>School Registration Form</title>
</head>
<body>
    <!--Side bar-->
    <div class="sidebar">
        <!--logo on sidebar-->
        <img src="/images/ki_logo.png" alt="Logo" class="logo">
        <!--Dashboard button-->
        <ul class="menu-item ">
            <li>
                <a href="/admin/adminDashboard.html">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
        <!--Educators button-->
        <ul class="menu-item ">
            <li>
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
            <li class="active">
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
                    <input type="text" placeholder="Find student...">
                </div>
                <img src="/images/user.png" alt=""/>
            </div>
        </div>

         <!-- school form body container-->
         <div class="container">
            <h2>School Registration Form</h2>
            <form id="schoolForm" novalidate>
                <input type="hidden" id="editingSchoolId">
                <div class="form-row form-section">
                    <div class="form-group col-md-3">
                        <label for="schoolId">School ID</label>
                        <input type="text" class="form-control" id="schoolId" placeholder="Enter School ID" required>
                        <div class="invalid-feedback">School ID is required.</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="region">Region</label>
                        <select class="form-control" id="region" required>
                            <option value="">Select Region</option>
                        </select>
                        <div class="invalid-feedback">Region is required.</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="town">Town</label>
                        <input type="text" class="form-control" id="town" placeholder="Enter Town" required>
                        <div class="invalid-feedback">Town is required.</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="educator">Educator</label>
                        <select class="form-control" id="educator" required>
                            <option value="">Select Educator</option>
                        </select>
                        <div class="invalid-feedback">Educator is required.</div>
                    </div>
                </div>
                <div class="form-row form-section">
                    <div class="form-group col-md-6">
                        <label for="schoolName">School Name</label>
                        <input type="text" class="form-control" id="schoolName" placeholder="Enter School Name" required>
                        <div class="invalid-feedback">School Name is required.</div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="schoolLogo">School Logo</label>
                        <input type="file" class="form-control-file" id="schoolLogo">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add School</button>
            </form>
    
            <div id="result" class="mt-4"></div>
            <div class="table-container">
                <h3>School List</h3>
                <table class="table table-striped" id="schoolTable">
                    <thead>
                        <tr>
                            <th>School ID</th>
                            <th>Region</th>
                            <th>Town</th>
                            <th>Educator</th>
                            <th>School Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

         <!-- Toast Notification -->
         <div class="toast-container">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
            <div class="toast-header">
                <strong class="mr-auto">KI Notification</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                School added.
            </div>
        </div>
        </div>

       

           <!-- Class Form Modal -->
           <div class="modal fade" id="classFormModal" tabindex="-1" role="dialog" aria-labelledby="classFormModalLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="classFormModalLabel">Add Class</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="classForm" novalidate>
                            <input type="hidden" id="editingClassId">
                            <div class="form-group">
                                <label for="className">Class Name</label>
                                <input type="text" class="form-control" id="className" placeholder="Enter Class Name" required>
                                <div class="invalid-feedback">Class Name is required.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Class</button>
                        </form>
                        <div id="classTableContainer" class="mt-3">
                            <h5>Classes</h5>
                            <table class="table table-striped" id="classTable">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      

        <!-- Student Form Modal -->
        <div class="modal fade" id="studentFormModal" tabindex="-1" role="dialog" aria-labelledby="studentFormModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentFormModalLabel">Add Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body landscape-form">
                        <form id="studentForm" novalidate>
                            <div class="form-row">
                                <!-- passport picture -->
                                <div class="form-group col-md-6">
                                    <label for="passportPicture">Passport Picture</label>
                                    <input type="file" class="form-control-file" id="passportPicture" required>
                                    <div class="invalid-feedback">Passport Picture is required.</div>
                                </div>
                                <!-- First name -->
                                <div class="form-group col-md-6">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" required>
                                    <div class="invalid-feedback">First Name is required.</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <!-- Last name -->
                                <div class="form-group col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" required>
                                    <div class="invalid-feedback">Last Name is required.</div>
                                </div>
                                <!-- date of birth -->
                                <div class="form-group col-md-6">
                                    <label for="dateOfBirth">Date of Birth</label>
                                    <input type="date" class="form-control" id="dateOfBirth" required>
                                    <div class="invalid-feedback">Date of Birth is required.</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <!-- Gender selection-->
                                <div class="form-group col-md-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">Gender is required.</div>
                                </div>

                                <!--hand selection-->
                                <div class="form-group col-md-6">
                                    <label for="hand">Hand</label>
                                    <select class="form-control" id="hand" required>
                                        <option value="">Select</option>
                                        <option value="left">Left dominant</option>
                                        <option value="right">Right dominant</option>
                                        <div class="invalid-feedback">Hand is required.</div>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="foot">Foot</label>              
                                    <select class="form-control" id="foot" required>
                                        <option value="">Select</option>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                        <div class="invalid-feedback">Foot is required.</div>
                                    </select>
                                    
                                </div>

                                        <!--Eye sight-->
                                <div class="form-group col-md-6">
                                    <label for="eyeSight">Eye Sight</label>
                                    <select class="form-control" id="eyeSight" required>
                                        <option value="">Select</option>
                                        <option value="normal">Normal</option>
                                        <option value="short-sighted">Short-sighted</option>
                                        <option value="long-sighted">Long-sighted</option>
                                        <div class="invalid-feedback">Eye Sight is required.</div>
                                    </select>
                                    
                                   
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="height">Height (cm)</label>
                                    <input type="text" class="form-control" id="height" placeholder="Enter Height" required>
                                    <div class="invalid-feedback">Height is required.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="weight">Weight (kg)</label>
                                    <input type="text" class="form-control" id="weight" placeholder="Enter Weight" required>
                                    <div class="invalid-feedback">Weight is required.</div>
                                </div>
                            </div>


                                    <!-- Parent/Guardian information-->
                            <fieldset>
                                <legend>Parent/Guardian Information</legend>
                                <div class="form-row">
                                    <!-- name -->
                                    <div class="form-group col-md-6">
                                        <label for="guardianName">Name</label>
                                        <input type="text" class="form-control" id="guardianName" placeholder="Enter Name" required>
                                        <div class="invalid-feedback">Name is required.</div>
                                    </div>
                                    <!-- phone number -->
                                    <div class="form-group col-md-6">
                                        <label for="guardianPhoneNumber">Phone Number</label>
                                        <input type="text" class="form-control" id="guardianPhoneNumber" placeholder="Enter Phone Number" required>
                                        <div class="invalid-feedback">Phone Number is required.</div>
                                    </div>
                                </div>

                                <!-- Whatsapp number -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="guardianWhatsAppNumber">WhatsApp Number</label>
                                        <input type="text" class="form-control" id="guardianWhatsAppNumber" placeholder="Enter WhatsApp Number" required>
                                        <div class="invalid-feedback">WhatsApp Number is required.</div>
                                    </div>

                                    <!-- Email address-->
                                    <div class="form-group col-md-6">
                                        <label for="guardianEmailAddress">Email Address</label>
                                        <input type="email" class="form-control" id="guardianEmailAddress" placeholder="Enter Email Address" required>
                                        <div class="invalid-feedback">Email Address is required.</div>
                                    </div>
                                </div>
                            </fieldset>


                            <button type="submit" class="btn btn-primary">Add Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let schools = [];
            let classes = [];
            let currentSchoolId = null;
            let currentClassName = null;

            // Load regions dynamically (could be fetched from an API)
            const regions = ["Bono", "Ashanti", "Greater Accra", "Bono East"];
            regions.forEach(region => {
                $('#region').append(`<option value="${region}">${region}</option>`);
            });

            // Load educators dynamically (could be fetched from an API)
            const educators = ["King Luka", "Bright Adjei", "Bridget"];
            educators.forEach(educator => {
                $('#educator').append(`<option value="${educator}">${educator}</option>`);
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Form validation
            $('#schoolForm').on('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                const form = this;
                if (form.checkValidity() === false) {
                    $(form).addClass('was-validated');
                    return;
                }
                
                const data = {
                    schoolId: $('#schoolId').val(),
                    region: $('#region').val(),
                    town: $('#town').val(),
                    educator: $('#educator').val(),
                    schoolName: $('#schoolName').val(),
                };

                const editingSchoolId = $('#editingSchoolId').val();
                if (editingSchoolId) {
                    // Update existing school
                    schools = schools.map(school => 
                        school.schoolId === editingSchoolId ? data : school
                    );
                    $('#editingSchoolId').val('');
                    $(form).find('button[type="submit"]').text('Add School');
                } else {
                    // Add new school
                    schools.push(data);
                    // Show toast notification
                    $('.toast-body').text(`School "${data.schoolName}" added.`);
                    $('.toast').toast('show');
                }

                // Clear the form
                form.reset();
                $(form).removeClass('was-validated');

                currentSchoolId = data.schoolId;
                renderSchoolTable();
            });

            // Class form validation and submission
            $('#classForm').on('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();

                const form = this;
                if (form.checkValidity() === false) {
                    $(form).addClass('was-validated');
                    return;
                }

                const className = $('#className').val();
                const editingClassId = $('#editingClassId').val();
                if (editingClassId) {
                    // Update existing class
                    classes = classes.map(c => 
                        c.className === editingClassId ? { className, schoolId: currentSchoolId } : c
                    );
                    $('#editingClassId').val('');
                    $('button[type="submit"]').text('Add Class');
                } else {
                    // Add new class
                    classes.push({ className, schoolId: currentSchoolId });
                }

                // Clear the input field for new entries
                $('#className').val('');
                $(form).removeClass('was-validated');

                renderClassTable();
            });

            $('#addStudentYes').on('click', function() {
                $('#nextModal').modal('hide');
                $('#studentFormModal').modal('show');
            });

            $('#studentForm').on('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();
                
                const form = this;
                if (form.checkValidity() === false) {
                    $(form).addClass('was-validated');
                    return;
                }
                
                const data = {
                    passportPicture: $('#passportPicture').val(),
                    firstName: $('#firstName').val(),
                    lastName: $('#lastName').val(),
                    dateOfBirth: $('#dateOfBirth').val(),
                    gender: $('#gender').val(),
                    hand: $('#hand').val(),
                    foot: $('#foot').val(),
                    eyeSight: $('#eyeSight').val(),
                    height: $('#height').val(),
                    weight: $('#weight').val(),
                    guardianName: $('#guardianName').val(),
                    guardianPhoneNumber: $('#guardianPhoneNumber').val(),
                    guardianWhatsAppNumber: $('#guardianWhatsAppNumber').val(),
                    guardianEmailAddress: $('#guardianEmailAddress').val(),
                    className: currentClassName
                };

                // Show toast notification
                $('.toast-body').text(`Student "${data.firstName} ${data.lastName}" added.`);
                $('.toast').toast('show');

                // Clear the form for new entries
                form.reset();
                $(form).removeClass('was-validated');

                // Optionally, send student data to a backend server
                fetch('https://example.com/api/students', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(responseData => {
                    console.log('Student Added:', responseData);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            function renderSchoolTable() {
                const tbody = $('#schoolTable tbody');
                tbody.empty();
                schools.forEach(school => {
                    const row = `
                        <tr>
                            <td>${school.schoolId}</td>
                            <td>${school.region}</td>
                            <td>${school.town}</td>
                            <td>${school.educator}</td>
                            <td>${school.schoolName}</td>
                            <td>
                                <button class="btn btn-primary btn-sm add-class" data-id="${school.schoolId}">Add Class</button>
                                <button class="btn btn-warning btn-sm edit-school" data-id="${school.schoolId}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-school" data-id="${school.schoolId}">Delete</button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                $('.add-class').off('click').on('click', function() {
                    currentSchoolId = $(this).data('id');
                    $('#classFormModal').modal('show');
                });

                $('.edit-school').off('click').on('click', function() {
                    const schoolId = $(this).data('id');
                    const school = schools.find(s => s.schoolId === schoolId);
                    $('#schoolId').val(school.schoolId);
                    $('#region').val(school.region);
                    $('#town').val(school.town);
                    $('#educator').val(school.educator);
                    $('#schoolName').val(school.schoolName);
                    $('#editingSchoolId').val(school.schoolId);
                    $('button[type="submit"]').text('Update School');
                });

                $('.delete-school').off('click').on('click', function() {
                    const schoolId = $(this).data('id');
                    schools = schools.filter(s => s.schoolId !== schoolId);
                    renderSchoolTable();
                });
            }

            function renderClassTable() {
                const tbody = $('#classTable tbody');
                tbody.empty();
                classes
                    .filter(c => c.schoolId === currentSchoolId)
                    .forEach(c => {
                        const row = `
                            <tr>
                                <td>${c.className}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm add-student" data-name="${c.className}">Add Student</button>
                                    <button class="btn btn-warning btn-sm edit-class" data-name="${c.className}">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-class" data-name="${c.className}">Delete</button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });

                $('.add-student').off('click').on('click', function() {
                    currentClassName = $(this).data('name');
                    $('#studentFormModal').modal('show');
                });

                $('.edit-class').off('click').on('click', function() {
                    const className = $(this).data('name');
                    $('#className').val(className);
                    $('#editingClassId').val(className);
                    $('button[type="submit"]').text('Update Class');
                });

                $('.delete-class').off('click').on('click', function() {
                    const className = $(this).data('name');
                    classes = classes.filter(c => c.className !== className || c.schoolId !== currentSchoolId);
                    renderClassTable();
                });
            }
        });
    </script>

</body>
</html>
