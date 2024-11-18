<?php
include('includes/auth.php');
include 'function.php';
include 'includes/dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/images/site.webmanifest">
</head>
<body>

<?php include_once('includes/side_bar.php');?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="showForm('schoolForm')">Create School</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showForm('classForm')">Create Class</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Create School Form -->
    <div id="schoolForm" class="mb-4">
        <h2>Create School</h2>
        <form onsubmit="createSchool(event)" enctype="multipart/form-data">
            <input type="text" name="schoolName" placeholder="School Name" required class="form-control mb-2">
            <input type="text" name="region" placeholder="Region" required class="form-control mb-2">
            <input type="text" name="town" placeholder="Town" required class="form-control mb-2">
            <input type="file" name="logo" class="form-control mb-2">
            <button type="submit" class="btn btn-success">Create School</button>
        </form>
    </div>

    <!-- Create Class Form -->
    <div id="classForm" class="mb-4" style="display: none;">
        <h2>Create Class</h2>
        <form onsubmit="createClass(event)">
            <select name="schoolId" required class="form-control mb-2">
                <option value="">Select School</option>
                <?php foreach (getSchoolsWP() as $school): ?>
                    <option value="<?= $school['id'] ?>"><?= $school['school_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="className" placeholder="Class Name" required class="form-control mb-2">
            <button type="submit" class="btn btn-success">Create Class</button>
        </form>
    </div>
    <div class="mb-3">
            <button class="btn btn-primary" onclick="showTable('schools')">Schools</button>
            <button class="btn btn-primary" onclick="showTable('classes')">Classes</button>
        </div>
        <div id="tableContainer"></div>
<nav>
    <ul class="pagination"></ul>
</nav>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

function showForm(formId) {
    const schoolForm = document.getElementById('schoolForm');
    const classForm = document.getElementById('classForm');

    if (formId === 'schoolForm') {
        schoolForm.style.display = 'block';
        classForm.style.display = 'none';
    } else if (formId === 'classForm') {
        schoolForm.style.display = 'none';
        classForm.style.display = 'block';
    }

    // Update the active tab
    const tabs = document.querySelectorAll('.nav-link');
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
   
    document.querySelector(`.nav-link[onclick="showForm('${formId}')"]`).classList.add('active');
}

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
            // alert(response);
            if (response.success) {
                toastr.success(response.message);
                // Reset the form
                $('#schoolForm form')[0].reset();
                // Clear the file input
                $('#schoolForm input[type="file"]').val('');
                showTable('schools');
            }else{
                toastr.error(response.message || 'An error occured while creating school')
            }
        }
    });
}

function createClass(event) {
    event.preventDefault();
    const schoolId = event.target.schoolId.value;
    const className = event.target.className.value;
    $.post('ajax_handlers.php', { action: 'createClass', schoolId: schoolId, name: className }, function(response) {
        if(response.success){
            toastr.success(response.message);
            $('#classForm form')[0].reset();
            showTable('classes');
        }else{
            toastr.error(response.message || 'failed to create class successfully')
        }

    });
}

function deleteSchool(schoolId) {
        if (confirm("Are you sure you want to delete this school?")) {
            $.post('ajax_handlers.php', { action: 'deleteSchool', schoolId: schoolId }, function(response) {
                if(response.success){
                    toastr.success(response.message);
                    showTable('schools');
                }else{
                    toastr.error(saveResponse.message || 'An error occurred while deleting the school');
                }
            });
        }
    }
// TODO: add the form to populate
function editSchool(schoolId) {
        const newName = prompt("Enter new school name:");
        if (newName) {
            $.post('ajax_handlers.php', { action: 'updateSchool', schoolId: schoolId, name: newName }, function(response) {
                if(response.success){
                    toastr.success(response.message);
                   showTable('schools'); 
                }else{
                    toastr.error(saveResponse.message || 'An error occurred while updating school the school');  
                }
                
            });
        }
    }

// FIXME: add the form to populate
function editClass(classId) {
        const newName = prompt("Enter new class name:");
        if (newName) {
            $.post('ajax_handlers.php', { action: 'updateClass', classId: classId, name: newName }, function(response) {
                if(response.success){
                    showTable('classes');
                }
            
                
            });
        }
    }

    function deleteClass(classId) {
        if (confirm("Are you sure you want to delete this class?")) {
            $.post('ajax_handlers.php', { action: 'deleteClass', classId: classId }, function(response) {
                if(response.success){
                    toastr.success(response.message);
                    showTable('classes');
                }else{
                    toastr.error(saveResponse.message || 'An error occurred while deleting the class');
                }

            });
        }
    }


function showTable(type, page = 1) {
    $.get('ajax_handlers.php', { action: 'getTable', type: type, page: page }, function(response) {
        $('#tableContainer').html(response);
    });
}
</script>
</body>
</html>
