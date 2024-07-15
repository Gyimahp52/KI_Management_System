

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
c
    <div class="container mt-5">
        <h1 class="mb-4">School Management System</h1>
        
     

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

<!-- <div id="studentForm" class="mb-4">
    <h2>Create Student</h2>
    <form onsubmit="createStudent(event)" enctype="multipart/form-data">
        <select name="classId" required class="form-control mb-2">
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
        <input type="file" name="passport_picture" required class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
        <button type="submit" class="btn btn-success">Create Student</button>
    </form>
</div> -->

<div id="studentForm" class="mb-4">
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
        <!-- Rest of the form fields remain the same -->
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
        <input type="file" name="passport_picture" required class="form-control mb-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mb-2">
        <button type="submit" class="btn btn-success">Create Student</button>
        <button type="submit" class="btn btn-success">Create Student</button>
    </form>
</div>

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

    <!-- Add this at the end of the body tag -->
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

function showTable(type, page = 1) {
        $.get('ajax_handlers.php', { action: 'getTable', type: type, page: page }, function(response) {
            $('#tableContainer').html(response);
        });
    }
        // function showTable(type) {
        //     $.get('ajax_handlers.php', { action: 'getTable', type: type }, function(response) {
        //         $('#tableContainer').html(response);
        //     });
        // }

        // function createSchool(event) {
        //     event.preventDefault();
        //     const schoolName = event.target.schoolName.value;
        //     $.post('ajax_handlers.php', { action: 'createSchool', name: schoolName }, function(response) {
        //         alert(response);
        //         showTable('schools');
        //     });
        // }

        function createClass(event) {
            event.preventDefault();
            const schoolId = event.target.schoolId.value;
            const className = event.target.className.value;
            $.post('ajax_handlers.php', { action: 'createClass', schoolId: schoolId, name: className }, function(response) {
                alert(response);
                showTable('classes');
            });
        }

        // function createStudent(event) {
        //     event.preventDefault();
        //     const classId = event.target.classId.value;
        //     const studentName = event.target.studentName.value;
        //     const studentDob = event.target.studentDob.value;
        //     $.post('ajax_handlers.php', { action: 'createStudent', classId: classId, name: studentName, dob: studentDob }, function(response) {
        //         alert(response);
        //         showTable('students');
        //     });
        // }

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
  // ... (keep existing functions)

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

        // function editStudent(studentId) {
        //     const newName = prompt("Enter new name:");
        //     const newDob = prompt("Enter new date of birth (YYYY-MM-DD):");
        //     if (newName && newDob) {
        //         $.post('ajax_handlers.php', { action: 'updateStudent', studentId: studentId, name: newName, dob: newDob }, function(response) {
        //             alert(response);
        //             showTable('students');
        //         });
        //     }
        // }

        // function deleteStudent(studentId) {
        //     if (confirm("Are you sure you want to delete this student?")) {
        //         $.post('ajax_handlers.php', { action: 'deleteStudent', studentId: studentId }, function(response) {
        //             alert(response);
        //             showTable('students');
        //         });
        //     }
        // }



//new

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
            showTable('schools');
        }
    });
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
            showTable('students');
        }
    });
}

function editStudent(studentId) {
    // Fetch student data and populate a form
    $.get('ajax_handlers.php', { action: 'getStudent', studentId: studentId }, function(student) {
        // Populate a modal or form with student data
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

// Similar functions for editing and deleting schools...

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
// ... (keep other existing functions)



    //     function showTable(type, page = 1) {
    //     $.get('ajax_handlers.php', { action: 'getTable', type: type, page: page }, function(response) {
    //         $('#tableContainer').html(response);
    //     });
    // }

    // ... (keep existing functions)

    // function editSchool(schoolId) {
    //     const newName = prompt("Enter new school name:");
    //     if (newName) {
    //         $.post('ajax_handlers.php', { action: 'updateSchool', schoolId: schoolId, name: newName }, function(response) {
    //             alert(response);
    //             showTable('schools');
    //         });
    //     }
    // }

    // function deleteSchool(schoolId) {
    //     if (confirm("Are you sure you want to delete this school?")) {
    //         $.post('ajax_handlers.php', { action: 'deleteSchool', schoolId: schoolId }, function(response) {
    //             alert(response);
    //             showTable('schools');
    //         });
    //     }
    // }

    // function editClass(classId) {
    //     const newName = prompt("Enter new class name:");
    //     if (newName) {
    //         $.post('ajax_handlers.php', { action: 'updateClass', classId: classId, name: newName }, function(response) {
    //             alert(response);
    //             showTable('classes');
    //         });
    //     }
    // }

    // function deleteClass(classId) {
    //     if (confirm("Are you sure you want to delete this class?")) {
    //         $.post('ajax_handlers.php', { action: 'deleteClass', classId: classId }, function(response) {
    //             alert(response);
    //             showTable('classes');
    //         });
    //     }
    // }

    // ... (keep existing functions)
    </script>
</body>
</html>