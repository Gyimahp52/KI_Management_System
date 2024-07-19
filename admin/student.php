<?php
//require_once 'function.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Student page</title>
    <style>
       .modal {
    display: none;
    position: fixed;
    z-index: 1;
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
    padding: 7px;
    border: 1px solid #888;
    max-width: 80%;
    bottom: 100px;
    left: 50px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: -16px;
    
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
                <select name="filterSchoolId" onchange="updateFilterClassSelect(this.value)" class="form-control mb-2">
                    <option value="">All Schools</option>
                    <?php foreach (getSchools() as $school): ?>
                        <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="filterClassId" class="form-control mb-2">
                    <option value="">All Classes</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div id="tableContainer"></div>
            <nav>
                <ul class="pagination">
            
                </ul>
            </nav>
        </div>
        <!-- Student Table -->
        <!-- <table id="studentTable">
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
        </table> -->
    </div>
</div>


<!-- Student Registration Modal -->
<div id="studentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Student Registration Form</h2>
        <form id="studentForm" onsubmit="createStudent(event)">
            <!-- form fields -->
            <fieldset>
                <legend>Personal Information</legend>
                <div class="row">
                    <div class="col">
                        <input type="file" name="passport_picture" accept="image/*">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        
                    </div>
                    <div class="col">
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="date" name="dob" required>
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="hand" required>
                            <option value="">Select Hand</option>
                            <option value="Right">Right</option>
                            <option value="Left">Left</option>
                            <option value="Ambidextrous">Ambidextrous</option>
                        </select>
                        <select name="foot" required>
                            <option value="">Select Foot</option>
                            <option value="Right">Right</option>
                            <option value="Left">Left</option>
                        </select>
                        <select name="eye_sight" required>
                            <option value="">Select Eye Sight</option>
                            <option value="Normal">Normal</option>
                            <option value="Glasses">Glasses</option>
                            <option value="Contact Lenses">Contact Lenses</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                   <!-- <div class="col">
                        <textarea name="medical_condition" placeholder="Not available" disabled></textarea>
                    </div> -->
                    <div class="col">
                        <input type="number" name="height" placeholder="Height (cm)" required>
                        <input type="number" name="weight" placeholder="Weight (kg)" required>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Parent/Guardian</legend>
                <div class="row">
                    <div class="col">
                        <input type="text" name="parent_name" placeholder="Parent/Guardian Name" required>
                        <input type="tel" name="parent_phone" placeholder="Phone Number" required>
                    </div>
                    <div class="col">
                        <input type="tel" name="parent_whatsapp" placeholder="WhatsApp Number">
                        <input type="email" name="parent_email" placeholder="Email Address">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Others</legend>
                <div class="row">
                    <div class="col">
                        <select name="schoolId" onchange="loadClasses(this.value)" required>
                            <option value="">Select School</option>
                            <!-- php codes here-->
                        </select>
                    </div>
                    <div class="col">
                        <select name="classId" required disabled>
                            <option value="">Select Class</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col">
                    <button class="add-button" type="submit">Add</button>
                </div>
                <div class="col">
                    <button class="cancel-button" type="button" onclick="closeModal()">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
  <!-- EDIT MODAL -->

  <div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" onsubmit="updateStudent(event)">
                    <!-- Form fields will be dynamically populated -->
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    // Get the modal
    var modal = document.getElementById("studentModal");

    // Get the button that opens the modal
    var btn = document.getElementById("addStudentBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        closeModal();
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    function closeModal() {
        modal.style.display = "none";
        document.getElementById("studentForm").reset();
    }

   

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
                alert(response);
                if (response.includes("successfully")) {
                    closeModal();
                    showTable('students');
                }
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

    // Add other necessary functions (showTable, editStudent, deleteStudent, etc.) here
    function deleteStudent(studentId) {
    if (confirm("Are you sure you want to delete this student?")) {
        $.post('ajax_handlers.php', { action: 'deleteStudent', studentId: studentId }, function(response) {
            alert(response);
            showTable('students');
        });
    }
}


// function showTable(type, page = 1) {
//     $.get('ajax_handlers.php', { action: 'getTable', type: type, page: page }, function(response) {
//         $('#tableContainer').html(response);
//     });
// }

function editStudent(studentId) {
    $.get('ajax_handlers.php', { action: 'getStudent', studentId: studentId }, function(response) {
        var student = JSON.parse(response);
        if (student.error) {
            alert(student.error);
            return;
        }
        
        // Populate the modal with student data
        $('#editStudentModal').modal('show');
        $('#editStudentForm').html(`
            <input type="hidden" name="studentId" value="${student.student_id}">
            <input type="text" name="name" value="${student.name}" required class="form-control mb-2">
            <input type="date" name="dob" value="${student.dob}" required class="form-control mb-2">
            <select name="gender" required class="form-control mb-2">
                <option value="Male" ${student.gender === 'Male' ? 'selected' : ''}>Male</option>
                <option value="Female" ${student.gender === 'Female' ? 'selected' : ''}>Female</option>
                <option value="Other" ${student.gender === 'Other' ? 'selected' : ''}>Other</option>
            </select>
            <select name="hand" required class="form-control mb-2">
                <option value="Right" ${student.hand === 'Right' ? 'selected' : ''}>Right</option>
                <option value="Left" ${student.hand === 'Left' ? 'selected' : ''}>Left</option>
                <option value="Ambidextrous" ${student.hand === 'Ambidextrous' ? 'selected' : ''}>Ambidextrous</option>
            </select>
            <select name="foot" required class="form-control mb-2">
                <option value="Right" ${student.foot === 'Right' ? 'selected' : ''}>Right</option>
                <option value="Left" ${student.foot === 'Left' ? 'selected' : ''}>Left</option>
            </select>
            <input type="text" name="eye_sight" value="${student.eye_sight}" required class="form-control mb-2">
            <textarea name="medical_condition" class="form-control mb-2">${student.medical_condition}</textarea>
            <input type="number" name="height" value="${student.height}" required class="form-control mb-2">
            <input type="number" name="weight" value="${student.weight}" required class="form-control mb-2">
            <input type="text" name="parent_name" value="${student.parent_name}" required class="form-control mb-2">
            <input type="tel" name="parent_phone" value="${student.parent_phone}" required class="form-control mb-2">
            <input type="tel" name="parent_whatsapp" value="${student.parent_whatsapp}" class="form-control mb-2">
            <input type="email" name="parent_email" value="${student.parent_email}" class="form-control mb-2">
            <button type="submit" class="btn btn-primary">Update Student</button>
        `);
    });
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

        function filterStudents(event) {
            event.preventDefault();
            const schoolId = event.target.filterSchoolId.value;
            const classId = event.target.filterClassId.value;
            $.get('ajax_handlers.php', { action: 'getTable', type: 'students', schoolId: schoolId, classId: classId }, function(response) {
                $('#tableContainer').html(response);
            });
        }
</script>

</body>
</html>