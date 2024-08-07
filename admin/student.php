<?php
session_start();
require_once 'function.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
    padding: 20px;
    border: 1px solid #888;
    max-width: 30%;
    bottom: 100px;
    left: 50px;
    /* overflow: scroll; */
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
        <form id="studentForm" onsubmit="createStudent(event)">
            <!-- form fields -->
            <fieldset>
                <legend>Personal Information</legend>

                <input type="file" name="passport_picture" accept="image/*">
                <!-- <input type="text" name="username" placeholder="Username" required> -->
                <input type="text" name="name" placeholder="Name" required> <br><br>
                <input type="password" name="password" placeholder="Password" required><br><br>
                <input type="date" name="dob" required>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <select name="hand" >
                    <option value="">Select Hand</option>
                    <option value="Right">Right</option>
                    <option value="Left">Left</option>
                    <option value="Ambidextrous">Ambidextrous</option>
                </select>
                <select name="foot" >
                    <option value="">Select Foot</option>
                    <option value="Right">Right</option>
                    <option value="Left">Left</option>
                </select>
                <select name="eye_sight" >
                    <option value="">Select Eye Sight</option>
                    <option value="Normal">Normal</option>
                    <option value="Glasses">Glasses</option>
                    <option value="Contact Lenses">Contact Lenses</option>
                </select><br>
                <textarea name="medical_condition" placeholder="Not available" disabled></textarea><br>
                <input type="number" name="height" placeholder="Height (cm)" required>
                <input type="number" name="weight" placeholder="Weight (kg)" required>

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
                    <select name="schoolId" onchange="loadClasses(this.value)" required class="form-control mb-2">
            <option value="">Select School</option>
            <?php foreach (getSchools() as $school): ?>
                <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
            <?php endforeach; ?>
        </select>
                    </div>
                    <div class="col">
                    <select name="classId" required class="form-control mb-2" disabled>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    <?php
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        echo "toastr.{$flash['type']}('{$flash['message']}');";
        unset($_SESSION['flash']);
    }
    ?>

    // function showTable(type, page = 1, schoolId = null, classId = null) {
    //     $.get('ajax_handlers.php', { 
    //         action: 'getTable', 
    //         type: type, 
    //         page: page,
    //         schoolId: schoolId,
    //         classId: classId
    //     }, function(response) {
    //         $('#tableContainer').html(response);
    //     });
    // }

    // function filterStudents(event) {
    //     event.preventDefault();
    //     const schoolId = event.target.filterSchoolId.value;
    //     const classId = event.target.filterClassId.value;
    //     showTable('students', 1, schoolId, classId);
    // }
//     function filterStudents(event) {
//     event.preventDefault();
//     const schoolId = event.target.filterSchoolId.value;
//     const classId = event.target.filterClassId.value;
//     const searchTerm = $('#studentSearch').val(); // Assuming you've added a search input
//     showTable('students', 1, schoolId, classId, searchTerm);
// }

// function filterStudents(event) {
//     event.preventDefault();
//     const schoolId = event.target.filterSchoolId.value;
//     const classId = event.target.filterClassId.value;
//     const searchTerm = $('#studentSearch').val();
//     showTable('students', 1, schoolId, classId, searchTerm);
// }
function filterStudents(event) {
    event.preventDefault();
    const schoolId = $('select[name="filterSchoolId"]').val();
    const classId = $('select[name="filterClassId"]').val();
    const searchTerm = $('#studentSearch').val();
    showTable('students', 1, schoolId, classId, searchTerm);
}
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

    function deleteStudent(studentId) {
    if (confirm("Are you sure you want to delete this student?")) {
        $.post('ajax_handlers.php', { action: 'deleteStudent', studentId: studentId }, function(response) {
            alert(response);
            showTable('students');
        });
    }
}


// function editStudent(studentId) {
//     $.get('ajax_handlers.php', { action: 'getStudent', studentId: studentId }, function(response) {
//         var student = JSON.parse(response);
//         if (student.error) {
//             alert(student.error);
//             return;
//         }
        
//         // Populate the modal with student data
//         $('#editStudentModal').modal('show');
//         $('#editStudentForm').html(`
//             <input type="hidden" name="studentId" value="${student.student_id}">
//             <input type="text" name="name" value="${student.name}" required class="form-control mb-2">
//             <input type="date" name="dob" value="${student.dob}" required class="form-control mb-2">
//             <select name="gender" required class="form-control mb-2">
//                 <option value="Male" ${student.gender === 'Male' ? 'selected' : ''}>Male</option>
//                 <option value="Female" ${student.gender === 'Female' ? 'selected' : ''}>Female</option>
//                 <option value="Other" ${student.gender === 'Other' ? 'selected' : ''}>Other</option>
//             </select>
//             <select name="hand" required class="form-control mb-2">
//                 <option value="Right" ${student.hand === 'Right' ? 'selected' : ''}>Right</option>
//                 <option value="Left" ${student.hand === 'Left' ? 'selected' : ''}>Left</option>
//                 <option value="Ambidextrous" ${student.hand === 'Ambidextrous' ? 'selected' : ''}>Ambidextrous</option>
//             </select>
//             <select name="foot" required class="form-control mb-2">
//                 <option value="Right" ${student.foot === 'Right' ? 'selected' : ''}>Right</option>
//                 <option value="Left" ${student.foot === 'Left' ? 'selected' : ''}>Left</option>
//             </select>
//             <input type="text" name="eye_sight" value="${student.eye_sight}" required class="form-control mb-2">
//             <textarea name="medical_condition" class="form-control mb-2">${student.medical_condition}</textarea>
//             <input type="number" name="height" value="${student.height}" required class="form-control mb-2">
//             <input type="number" name="weight" value="${student.weight}" required class="form-control mb-2">
//             <input type="text" name="parent_name" value="${student.parent_name}" required class="form-control mb-2">
//             <input type="tel" name="parent_phone" value="${student.parent_phone}" required class="form-control mb-2">
//             <input type="tel" name="parent_whatsapp" value="${student.parent_whatsapp}" class="form-control mb-2">
//             <input type="email" name="parent_email" value="${student.parent_email}" class="form-control mb-2">
//             <button type="submit" class="btn btn-primary">Update Student</button>
//         `);
//     });
// }
function editStudent(studentId) {
    $.get('ajax_handlers.php', { action: 'getStudent', studentId: studentId }, function(response) {
        if (response.error) {
            alert(response.error);
            return;
        }
        
        $('#editStudentModal').modal('show');
        $('#editStudentForm').html(`
            <input type="hidden" name="studentId" value="${response.student_id}">
            <input type="text" name="name" value="${response.name}" required class="form-control mb-2">
            <input type="date" name="dob" value="${response.dob}" required class="form-control mb-2">
            <select name="gender" required class="form-control mb-2">
                <option value="Male" ${response.gender === 'Male' ? 'selected' : ''}>Male</option>
                <option value="Female" ${response.gender === 'Female' ? 'selected' : ''}>Female</option>
                <option value="Other" ${response.gender === 'Other' ? 'selected' : ''}>Other</option>
            </select>
            <select name="hand" required class="form-control mb-2">
                <option value="Right" ${response.hand === 'Right' ? 'selected' : ''}>Right</option>
                <option value="Left" ${response.hand === 'Left' ? 'selected' : ''}>Left</option>
                <option value="Ambidextrous" ${response.hand === 'Ambidextrous' ? 'selected' : ''}>Ambidextrous</option>
            </select>
            <select name="foot" required class="form-control mb-2">
                <option value="Right" ${response.foot === 'Right' ? 'selected' : ''}>Right</option>
                <option value="Left" ${response.foot === 'Left' ? 'selected' : ''}>Left</option>
            </select>
            <input type="text" name="eye_sight" value="${response.eye_sight}" required class="form-control mb-2">
            <textarea name="medical_condition" class="form-control mb-2">${response.medical_condition}</textarea>
            <input type="number" name="height" value="${response.height}" required class="form-control mb-2">
            <input type="number" name="weight" value="${response.weight}" required class="form-control mb-2">
            <input type="text" name="parent_name" value="${response.parent_name}" required class="form-control mb-2">
            <input type="tel" name="parent_phone" value="${response.parent_phone}" required class="form-control mb-2">
            <input type="tel" name="parent_whatsapp" value="${response.parent_whatsapp}" class="form-control mb-2">
            <input type="email" name="parent_email" value="${response.parent_email}" class="form-control mb-2">
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


//         function searchStudents() {
//     var searchTerm = $('#studentSearch').val();
//     showTable('students', 1, currentSchoolId, currentClassId, searchTerm);
// }
// function searchStudents() {
//     var searchTerm = $('#studentSearch').val();
//     var schoolId = $('select[name="filterSchoolId"]').val();
//     var classId = $('select[name="filterClassId"]').val();
//     showTable('students', 1, schoolId, classId, searchTerm);
// }

function searchStudents() {
    var searchTerm = $('#studentSearch').val();
    var schoolId = $('select[name="filterSchoolId"]').val();
    var classId = $('select[name="filterClassId"]').val();
    showTable('students', 1, schoolId, classId, searchTerm);
}

// function showTable(type, page = 1, schoolId = null, classId = null, search = null) {
//     $.get('ajax_handlers.php', { 
//         action: 'getTable', 
//         type: type, 
//         page: page,
//         schoolId: schoolId,
//         classId: classId,
//         search: search
//     }, function(response) {
//         $('#tableContainer').html(response);
//     });
// }

// function showTable(params) {
//     $.get('ajax_handlers.php', { 
//         action: 'getTable', 
//         type: params.type, 
//         page: params.page,
//         schoolId: params.schoolId,
//         classId: params.classId,
//         search: params.search
//     }, function(response) {
//         $('#tableContainer').html(response);
//     });
// }

// function showTable(type, page = 1, schoolId = null, classId = null, search = null) {
//     // Log the parameters for debugging
//     console.log('showTable parameters:', { type, page, schoolId, classId, search });

//     // Ensure all parameters are defined
//     const params = {
//         action: 'getTable',
//         type: type || 'students', // Default to 'students' if type is not provided
//         page: page || 1,
//         schoolId: schoolId || '',
//         classId: classId || '',
//         search: search || ''
//     };

//     // Log the final params object
//     console.log('AJAX request params:', params);

//     $.get('ajax_handlers.php', params, function(response) {
//         $('#tableContainer').html(response);
//     }).fail(function(jqXHR, textStatus, errorThrown) {
//         console.error('AJAX request failed:', textStatus, errorThrown);
//     });
// }
// function showTable(type, page = 1, schoolId = null, classId = null, search = null) {
//     console.log('showTable parameters:', { type, page, schoolId, classId, search });

//     const params = {
//         action: 'getTable',
//         type: type,
//         page: page,
//         schoolId: schoolId,
//         classId: classId,
//         search: search
//     };

//     // Remove null or undefined values
//     Object.keys(params).forEach(key => params[key] == null && delete params[key]);

//     $.get('ajax_handlers.php', params, function(response) {
//         $('#tableContainer').html(response);
//     }).fail(function(jqXHR, textStatus, errorThrown) {
//         console.error('AJAX request failed:', textStatus, errorThrown);
//     });
// }
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
</script>

</body>
</html>