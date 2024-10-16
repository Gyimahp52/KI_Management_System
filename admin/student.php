<?php
include('includes/auth.php');
require_once 'db_connction.php';
require_once 'function.php';
require_once 'StudentScoreService.php';

$studentScoreService = new StudentScoreService($pdo);

$schools = $studentScoreService->getSchools();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <!-- <link rel="stylesheet" href="assets/css/student.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/images/site.webmanifest">
    <title>Student page</title>
    <style>
    .modal {
    display: none;
    position: fixed;
    z-index: 1055;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    max-width: 30%;
    bottom: 100px;
    left: 50px;
    /* overflow: scroll; */
}

.modal-content-edit {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    max-width: 50%;
    bottom: 100px;
    left: 50px;
    z-index: 10;
    /* overflow: scroll; */
}
.row {
    display: flex;
    flex-wrap: wrap;
    margin: -16px;
    align-items: center;
    align-content: center;
    
}

.col {
    flex: 1px;
    padding: 10px;
}

input, select, textarea {
    width: 100%;
    margin-bottom: 10px;
}

    .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: red;
            text-decoration: none;
            cursor: pointer;
        }
        select.option{
            color: black;
        }



        .table td, .table th {
    /* padding: 4px; */
    /* vertical-align: top; */
    border-top: 1px solid #dee2e6;
}

.table td{
    /* padding: 2px;  */
    padding-top: 10px;
}
tbody{
    /* display: flex;
    flex-direction: column; */
}
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
        background-color: #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    .table tr:hover {
        background-color: #f5f5f5;
    }
    .table .btn {
        padding: 5px 10px;
        font-size: 0.8rem;
    }
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }
    #filterForm {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    #studentSearch {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .modal-backdrop.show {
    opacity: .5;
}

/* .modal-backdrop {
    z-index: 1050;
} */
body.no-scroll {
    overflow: hidden;
}


/* Modal overlay */
.modal {
  display: none; /* Hidden by default */
  position: fixed;
  z-index: 1000; /* High z-index to appear above everything */
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
}

/* Modal content */
.modal-content {
  background-color: white;
  margin: 10% auto;
  padding: 20px;
  width: 50%;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  position: relative;
}

/* Close button */
.close-btn {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

/* Close button hover effect */
.close-btn:hover {
  color: black;
}

/* Save button */
.save-btn {
  padding: 10px 20px;
  background-color: #28a745;
  color: white;
  border: none;
  cursor: pointer;
}

.password-container {
            position: relative;
            width: 100%;
        }

        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        .password-container ion-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .btn{
            margin-top: 5px;
            padding: 5px 20px;
        }

        .scrollable-select {
    max-height: 200px;  /* Adjust height based on how many options you want visible */
    overflow-y: auto;   /* Enable vertical scroll */
}

    </style>
</head>
<body>

<?php include_once('includes/side_bar.php');?>

<div class="main-content">
    <?php include_once('includes/header.php');?>

    <div class="stats-grid">

    
        <button id="addStudentBtn" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i>
            Add new student
        </button>



        <!-- FILTER -->
        <div id="filterForm" class="mb-4">
    <h2>Filter Students</h2>
    <form onsubmit="filterStudents(event)">
        <select name="filterSchoolId" onchange="updateFilterClassSelect(this.value)" class="form-control mb-2 scrollable-select">
            <option value="">All Schools</option>
            <?php foreach ($schools as $school): ?>
                <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="filterClassId" class="form-control mb-2">
            <option value="">All Classes</option>
        </select>
        <input type="text" id="studentSearch" placeholder="Search students..." class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>
        <div id="tableContainer"></div>
            <nav>
                <ul class="pagination">
            
                </ul>
            </nav>
        </div>

    </div>
    
</div>


<!-- Student Registration Modal -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Student Registration Form</h2>
        <form id="studentForm" onsubmit="createStudent(event)" class="form-group">
            <!-- form fields -->
            <fieldset>
                <legend>Personal Information</legend>

                <input class="form-control" type="file" name="passport_picture" accept="image/*" >
                
            <div class="form-floating">
                <input id="student-name" class="form-control" type="text" name="name" placeholder="Name" required>
                <label for="student-name">Name</label>
            </div>
        <div class="password-container form-floating">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
            <label for="password">Password</label>
            <ion-icon id="togglePassword" name="eye-off-outline"></ion-icon>
        </div>
        <div class="form-floating">
            <input id="std-dob" class="form-control" type="date" name="dob" >
            <label for="std-dob">D-O-B</label>
        </div>
        
        <div class="form-floating">            
            <select id="gender" class="form-control" name="gender" >
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <label for="gender"></label>
        </div>

      
        <div class="form-floating">                
            <select id="hand" class="form-control" name="hand" >
                <option value="">Select Hand</option>
                <option value="Right">Right</option>
                <option value="Left">Left</option>
                <option value="Ambidextrous">Ambidextrous</option>
            </select>
            <label for="hand">Hand</label>
        </div>
        <div class="form-floating">                
            <select id="foot" class="form-control" name="foot" >
                <option value="">Select Foot</option>
                <option value="Right">Right</option>
                <option value="Left">Left</option>
            </select>
            <label for="foot"></label>
        </div>
        <div class="form-floating">                
            <select id="eye-sight" class="form-control" name="eye_sight" >
                <option value="">Select Eye Sight</option>
                <option value="Normal">Normal</option>
                <option value="Glasses">Glasses</option>
                <option value="Contact Lenses">Contact Lenses</option>
            </select>
            <label for="eye-sight"></label>
        </div>
<br>
        <div class="form-floating">
            <label for="medical-condition">Medical Condition</label>
            <textarea id="medical-condition" class="form-control" name="medical_condition" placeholder="Not available" disabled></textarea>
        </div><br>
        <div class="form-floating"> 
            <input id="weight" class="form-control" type="number" name="weight" placeholder="Weight (kg)" >            
            <label for="weight">Weight</label>           
        </div>
        <div class="form-floating">
            <input id="height" class="form-control" type="number" name="height" placeholder="Height (cm)" >
            <label for="height">Height</label>
        </div>
    </fieldset>
    <fieldset>
            <legend>Parent/Guardian</legend>
            <div class="row">
                <div class="col">
                <div class="form-floating">
                    <input id="parent-name" class="form-control" type="text" name="parent_name" placeholder="Parent/Guardian Name" >
                    <label for="parent-name">Parent Name</label>
                </div>

                <div class="form-floating">
                    <input id="phone-number" class="form-control" type="tel" name="parent_phone" placeholder="Phone Number" >
                    <label for="phone-number">Phone Number</label>
                </div>
                        
                        
                </div>
                <div class="col">
                <div class="form-floating">
                    <input id="whats-number" class="form-control" type="tel" name="parent_whatsapp" placeholder="WhatsApp Number">
                    <label for="whats-number">WhatsApp Number</label>
                </div>

                <div class="form-floating">
                    <input id="email" class="form-control" type="email" name="parent_email" placeholder="Email Address">
                    <label for="email">Email</label>
                </div>
                        
                        
                </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Others</legend>
    <div class="row">
            <div class="col">

        <select class="form-control" name="schoolId" onchange="loadClasses(this.value)" required class="form-control mb-2">
            <option value="">Select School</option>
            <?php foreach ($schools as $school): ?>
                <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>


            <div class="col">
                <select class="form-control" name="classId" required class="form-control mb-2" disabled>
            <option value="">Select Class</option>
        </select>
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col">
                    <button class="add-button btn btn-success" type="submit">Add</button>
                </div>
                <div class="col">
                    <button  class="cancel-button btn btn-danger" type="button" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
  <!-- EDIT MODAL -->
<!-- Custom Modal Structure -->

<div id="customModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h2>Edit Student</h2>
    <form id="editStudentForm"></form> <!-- Form dynamically populated -->
  </div>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    <?php
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        echo "toastr.{$flash['type']}('{$flash['message']}');";
        unset($_SESSION['flash']);
    }
    ?>

function filterStudents(event) {
    event.preventDefault();
    const schoolId = $('select[name="filterSchoolId"]').val();
    const classId = $('select[name="filterClassId"]').val();
    const searchTerm = $('#studentSearch').val();
    showTable('students', 1, schoolId, classId, searchTerm);
}
    // Get the modal
    var modal2 = document.getElementById("studentModal");

    // Get the button that opens the modal
    var btn2 = document.getElementById("addStudentBtn");

    // Get the <span> element that closes the modal
    var span2 = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn2.onclick = function() {
        modal2.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span2.onclick = function() {
        closeModal();
    }

    // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function(event) {
    //     if (event.target == modal) {
    //         closeModal();
    //     }
    // }

    function closeModal() {
        modal2.style.display = "none";
        document.getElementById("studentForm").reset();
    }

   //PASSWORD VISIBILTY
   document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this;

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.setAttribute('name', 'eye-outline'); // Change icon to closed eye
        } else {
            passwordField.type = 'password';
            icon.setAttribute('name', 'eye-off-outline'); // Change icon to open eye
        }
    });

function createStudent(event) {
    event.preventDefault();
    var formData = new FormData(event.target);
    formData.append('action', 'createStudent');
    $.ajax({
        url: 'ajax_handlers.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                document.getElementById("studentForm").reset();
                showTable('students');
            } else {
                toastr.error(response.message || "Failed to create student");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            toastr.error("An error occurred while processing your request: " + errorThrown);
        }
    });
}

    function loadClasses(schoolId) {
        if (schoolId) {
            $.get('ajax_handlers.php', { action: 'getClasses', schoolId: schoolId }, function(response) {
                var classSelect = $('select[name="classId"]');
                classSelect.html(response);
                classSelect.prop('disabled', false);
            });
        } else {
            var classSelect = $('select[name="classId"]');
            classSelect.html('<option value="">Select Class</option>');
            classSelect.prop('disabled', true);
        }
    }



function deleteStudent(studentId) {
    if (confirm("Are you sure you want to delete this student?")) {
        $.ajax({
            url: 'ajax_handlers.php',
            type: 'POST',
            data: { action: 'deleteStudent', studentId: studentId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    // showTable('students');
                } else {
                    toastr.error(response.message || "Failed to delete student");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                toastr.error("An error occurred while deleting the student: " + errorThrown);
            }
        });
    }
}


function updateStudent(event) {
    event.preventDefault();
    var formData = new FormData(event.target);
    formData.append('action', 'updateStudent');
    $.ajax({
        url: 'ajax_handlers.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert(response);
            $('#editStudentModal').modal('hide');
            showTable('students');
        }
    });
}

  
function updateClassSelect(schoolId) {
            $.get('ajax_handlers.php', { action: 'getClasses', schoolId: schoolId }, function(response) {
                $('select[name="classId"]').html(response);
            });
        }

        function updateFilterClassSelect(schoolId) {
            $.get('ajax_handlers.php', { action: 'getClasses', schoolId: schoolId }, function(response) {
                $('select[name="filterClassId"]').html(response);
            });
            }



function searchStudents() {
    var searchTerm = $('#studentSearch').val();
    var schoolId = $('select[name="filterSchoolId"]').val();
    var classId = $('select[name="filterClassId"]').val();
    showTable('students', 1, schoolId, classId, searchTerm);
}


function showTable(type, page = 1, schoolId = null, classId = null, search = null) {
    console.log('showTable parameters:', { type, page, schoolId, classId, search });

    const params = {
        action: 'getTable',
        type: type,
        page: page,
        schoolId: schoolId,
        classId: classId,
        search: search
    };

    // Remove null or undefined values
    Object.keys(params).forEach(key => params[key] == null && delete params[key]);

    $.get('ajax_handlers.php', params, function(response) {
        $('#tableContainer').html(response);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX request failed:', textStatus, errorThrown);
    });
}




// FORM EDIT DIALOG


// Get modal and elements
var modal = document.getElementById('customModal');
var closeModalBtn = document.getElementsByClassName('close-btn')[0];

// Close modal when the close button is clicked
closeModalBtn.onclick = function() {
  modal.style.display = 'none';
  document.body.classList.remove('no-scroll');
};

// Close modal when clicking outside the modal content
// window.onclick = function(event) {
//   if (event.target == modal) {
//     modal.style.display = 'none';
//     document.body.classList.remove('no-scroll');
//   }
// };


// Function to edit student and populate the modal form
function editStudent(studentId) {
  $.get('ajax_handlers.php', { action: 'getStudent', studentId: studentId }, function(response) {
    if (response.error) {
      alert(response.error);
      return;
    }

    // Populate the form inside the modal
    var formHtml = `

        <input type="hidden" name="studentId" value="${response.student_id}">

    <div class="form-floating">
        <input id="name" type="text" name="name" value="${response.name}" required class="form-control mb-2">
        <label for"name"> Name </label>
    </div>
      

    <div class="form-floating">
        <input id="dob" type="date" name="dob" value="${response.dob}" required class="form-control mb-2">
        <label for="dob">Date of Birth </label>
    </div>

      <div class="form-floating">


<label for=""> </label>
</div>
      <div class="form-floating">
  <select id="gender" name="gender" required class="form-control mb-2">
    <option value="Male" ${response.gender === 'Male' ? 'selected' : ''}>Male</option>
    <option value="Female" ${response.gender === 'Female' ? 'selected' : ''}>Female</option>
    <option value="Other" ${response.gender === 'Other' ? 'selected' : ''}>Other</option>
  </select>
  <label for="gender">Gender</label>
</div>

<div class="form-floating">
  <select id="hand" name="hand" required class="form-control mb-2">
    <option value="Right" ${response.hand === 'Right' ? 'selected' : ''}>Right</option>
    <option value="Left" ${response.hand === 'Left' ? 'selected' : ''}>Left</option>
    <option value="Ambidextrous" ${response.hand === 'Ambidextrous' ? 'selected' : ''}>Ambidextrous</option>
  </select>
  <label for="hand">Dominant Hand</label>
</div>

<div class="form-floating">
  <select id="foot" name="foot" required class="form-control mb-2">
    <option value="Right" ${response.foot === 'Right' ? 'selected' : ''}>Right</option>
    <option value="Left" ${response.foot === 'Left' ? 'selected' : ''}>Left</option>
  </select>
  <label for="foot">Dominant Foot</label>
</div>

<div class="form-floating">
  <input id="eye_sight" type="text" name="eye_sight" value="${response.eye_sight}" required class="form-control mb-2">
  <label for="eye_sight">Eye Sight</label>
</div>

<div class="form-floating">
  <textarea id="medical_condition" name="medical_condition" class="form-control mb-2" disabled>${response.medical_condition}</textarea>
  <label for="medical_condition">Medical Condition</label>
</div>

<div class="form-floating">
  <input id="height" type="number" name="height" value="${response.height}" required class="form-control mb-2">
  <label for="height">Height</label>
</div>

<div class="form-floating">
  <input id="weight" type="number" name="weight" value="${response.weight}" required class="form-control mb-2">
  <label for="weight">Weight</label>
</div>

<div class="form-floating">
  <input id="parent_name" type="text" name="parent_name" value="${response.parent_name}" required class="form-control mb-2">
  <label for="parent_name">Parent Name</label>
</div>

<div class="form-floating">
  <input id="parent_phone" type="tel" name="parent_phone" value="${response.parent_phone}" required class="form-control mb-2">
  <label for="parent_phone">Parent Phone</label>
</div>

<div class="form-floating">
  <input id="parent_whatsapp" type="tel" name="parent_whatsapp" value="${response.parent_whatsapp}" class="form-control mb-2">
  <label for="parent_whatsapp">Parent WhatsApp</label>
</div>

<div class="form-floating">
  <input id="parent_email" type="email" name="parent_email" value="${response.parent_email}" class="form-control mb-2">
  <label for="parent_email">Parent Email</label>
</div>
      <button type="button" class="save-btn">Update Student</button>
    `;

    // Set the HTML inside the form
    document.getElementById('editStudentForm').innerHTML = formHtml;

    // Display the modal
    modal.style.display = 'block';
    document.body.classList.add('no-scroll'); // Disable body scroll

    // Modify the save button event listener
    document.querySelector('.save-btn').addEventListener('click', function() {
      var formData = $('#editStudentForm').serialize() + '&action=updateStudent';

      $.ajax({
        url: 'ajax_handlers.php',
        type: 'POST',
        data: formData,
        dataType: 'json', // Explicitly expect JSON response
        success: function(saveResponse) {
          if (saveResponse.success) {
            toastr.success(saveResponse.message);
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll');
            document.getElementById('editStudentForm').reset();
            showTable('students'); // Refresh the table
          } else {
            toastr.error(saveResponse.message || 'An error occurred while updating the student');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          toastr.error('An error occurred: ' + textStatus);
          console.error('AJAX Error:', textStatus, errorThrown);
        }
      });
    });
  });
}





// function editStudent(studentId) {
//   $.get('ajax_handlers.php', { action: 'getStudent', studentId: studentId }, function(response) {
//     if (response.error) {
//       toastr.error(response.error);
//       return;
//     }

//     // ... (rest of the form population code remains the same)

//     // Modify the save button event listener
//     document.querySelector('.save-btn').addEventListener('click', function() {
//       var formData = $('#editStudentForm').serialize() + '&action=updateStudent';

//       $.ajax({
//         url: 'ajax_handlers.php',
//         type: 'POST',
//         data: formData,
//         dataType: 'json', // Explicitly expect JSON response
//         success: function(saveResponse) {
//           if (saveResponse.success) {
//             toastr.success(saveResponse.message);
//             modal.style.display = 'none';
//             document.body.classList.remove('no-scroll');
//             document.getElementById('editStudentForm').reset();
//             showTable('students'); // Refresh the table
//           } else {
//             toastr.error(saveResponse.message || 'An error occurred while updating the student');
//           }
//         },
//         error: function(jqXHR, textStatus, errorThrown) {
//           toastr.error('An error occurred: ' + textStatus);
//           console.error('AJAX Error:', textStatus, errorThrown);
//         }
//       });
//     });
//   });
// }



</script>

</body>
</html>