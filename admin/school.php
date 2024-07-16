

<?php
require_once 'function.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<?php include_once('includes/side_bar.php');?>

    <div class="container mt-5">
        
        <div id="schoolForm" class="mb-4">
    <h2>Create School</h2>
    <form onsubmit="createSchool(event)" enctype="multipart/form-data">
        <input type="text" name="schoolName" placeholder="School Name" required class="form-control mb-2">
        <input type="text" name="region" placeholder="Region" required class="form-control mb-2">
        <input type="text" name="town" placeholder="Town" required class="form-control mb-2">
        <input type="text" name="educator" placeholder="Educator" required class="form-control mb-2">
        <input type="file" name="logo" required class="form-control mb-2">
        <button type="submit" class="btn btn-success">Create School</button>
    </form>
</div>

<div id="classForm" class="mb-4">
            <h2>Create Class</h2>
            <form onsubmit="createClass(event)">
                <select name="schoolId" required class="form-control mb-2">
                    <option value="">Select School</option>
                    <?php foreach (getSchools() as $school): ?>
                        <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="className" placeholder="Class Name" required class="form-control mb-2">
                <button type="submit" class="btn btn-success">Create Class</button>
            </form>
        </div>


<!-- STUDENT FORM -->

<!-- <div id="studentForm" class="mb-4">
    <h2>Create Student</h2>
    <form onsubmit="createStudent(event)" enctype="multipart/form-data">
        
        <select name="schoolId" onchange="loadClasses(this.value)" required class="form-control mb-2">
            <option value="">Select School</option>
            <?php foreach (getSchools() as $school): ?>
                <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="classId" required class="form-control mb-2" disabled>
            <option value="">Select Class</option>
        </select>
      
        <input type="text" name="name" placeholder="Student Name" required class="form-control mb-2">
        <input type="date" name="dob" required class="form-control mb-2">
        <select name="gender" required class="form-control mb-2">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <select name="hand" required class="form-control mb-2">
            <option value="">Select Hand</option>
            <option value="Right">Right</option>
            <option value="Left">Left</option>
            <option value="Ambidextrous">Ambidextrous</option>
        </select>
        <select name="foot" required class="form-control mb-2">
            <option value="">Select Foot</option>
            <option value="Right">Right</option>
            <option value="Left">Left</option>
        </select>
        <input type="text" name="eye_sight" placeholder="Eye Sight" required class="form-control mb-2">
        <textarea name="medical_condition" placeholder="Medical Condition" class="form-control mb-2"></textarea>
        <input type="number" name="height" placeholder="Height (cm)" required class="form-control mb-2">
        <input type="number" name="weight" placeholder="Weight (kg)" required class="form-control mb-2">
        <input type="text" name="parent_name" placeholder="Parent/Guardian Name" required class="form-control mb-2">
        <input type="tel" name="parent_phone" placeholder="Parent/Guardian Phone" required class="form-control mb-2">
        <input type="tel" name="parent_whatsapp" placeholder="Parent/Guardian WhatsApp" class="form-control mb-2">
        <input type="email" name="parent_email" placeholder="Parent/Guardian Email" class="form-control mb-2">
        <input type="file" name="passport_picture"  class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
        <button type="submit" class="btn btn-success">Create Student</button>
    </form>
</div> -->

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

        <!-- TOGGLE -->
        <div class="mb-3">
            <button class="btn btn-primary" onclick="showTable('schools')">Schools</button>
            <button class="btn btn-primary" onclick="showTable('classes')">Classes</button>
            <button class="btn btn-primary" onclick="showTable('students')">Students</button>
        </div>
        <div id="tableContainer"></div>
        <nav>
        <ul class="pagination">
            
        </ul>
    </nav>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>

// function showTable(type, page = 1) {
//         $.get('ajax_handlers.php', { action: 'getTable', type: type, page: page }, function(response) {
//             $('#tableContainer').html(response);
//         });
//     }
  
        // function createClass(event) {
        //     event.preventDefault();
        //     const schoolId = event.target.schoolId.value;
        //     const className = event.target.className.value;
        //     $.post('ajax_handlers.php', { action: 'createClass', schoolId: schoolId, name: className }, function(response) {
        //         alert(response);
        //         showTable('classes');
        //     });
        // }
        function createClass(event) {
    event.preventDefault();
    const schoolId = event.target.schoolId.value;
    const className = event.target.className.value;
    $.post('ajax_handlers.php', { action: 'createClass', schoolId: schoolId, name: className }, function(response) {
        alert(response);
        if (response.includes("successfully")) {
            // Reset the form
            $('#classForm form')[0].reset();
            showTable('classes');
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


  function editSchool(schoolId) {
        const newName = prompt("Enter new school name:");
        if (newName) {
            $.post('ajax_handlers.php', { action: 'updateSchool', schoolId: schoolId, name: newName }, function(response) {
                alert(response);
                showTable('schools');
            });
        }
    }

    function deleteSchool(schoolId) {
        if (confirm("Are you sure you want to delete this school?")) {
            $.post('ajax_handlers.php', { action: 'deleteSchool', schoolId: schoolId }, function(response) {
                alert(response);
                showTable('schools');
            });
        }
    }

    function editClass(classId) {
        const newName = prompt("Enter new class name:");
        if (newName) {
            $.post('ajax_handlers.php', { action: 'updateClass', classId: classId, name: newName }, function(response) {
                alert(response);
                showTable('classes');
            });
        }
    }

    function deleteClass(classId) {
        if (confirm("Are you sure you want to delete this class?")) {
            $.post('ajax_handlers.php', { action: 'deleteClass', classId: classId }, function(response) {
                alert(response);
                showTable('classes');
            });
        }
    }

        function filterStudents(event) {
            event.preventDefault();
            const schoolId = event.target.filterSchoolId.value;
            const classId = event.target.filterClassId.value;
            $.get('ajax_handlers.php', { action: 'getTable', type: 'students', schoolId: schoolId, classId: classId }, function(response) {
                $('#tableContainer').html(response);
            });
        }


// function createSchool(event) {
//     event.preventDefault();
//     var formData = new FormData(event.target);
//     formData.append('action', 'createSchool');
//     $.ajax({
//         url: 'ajax_handlers.php',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//             alert(response);
//             showTable('schools');
//         }
//     });
// }

function createSchool(event) {
    event.preventDefault();
    var formData = new FormData(event.target);
    formData.append('action', 'createSchool');
    $.ajax({
        url: 'ajax_handlers.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert(response);
            if (response.includes("successfully")) {
                // Reset the form
                $('#schoolForm form')[0].reset();
                // Clear the file input
                $('#schoolForm input[type="file"]').val('');
                showTable('schools');
            }
        }
    });
}



// function createStudent(event) {
//     event.preventDefault();
//     var formData = new FormData(event.target);
//     formData.append('action', 'createStudent');
//     $.ajax({
//         url: 'ajax_handlers.php',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function(response) {
//             alert(response);
//             showTable('students');
//         }
//     });
// }
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
                // Reset the form
                $('#studentForm form')[0].reset();
                // Clear the file input
                $('#studentForm input[type="file"]').val('');
                // Disable the class select
                $('select[name="classId"]').prop('disabled', true);
                showTable('students');
            }
        }
    });
}


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

function deleteStudent(studentId) {
    if (confirm("Are you sure you want to delete this student?")) {
        $.post('ajax_handlers.php', { action: 'deleteStudent', studentId: studentId }, function(response) {
            alert(response);
            showTable('students');
        });
    }
}


function showTable(type, page = 1) {
    $.get('ajax_handlers.php', { action: 'getTable', type: type, page: page }, function(response) {
        $('#tableContainer').html(response);
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

    </script>
</body>
</html>