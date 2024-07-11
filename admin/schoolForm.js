$(document).ready(function () {
  // Validate forms
  function validateForm(form) {
    if (form[0].checkValidity() === false) {
      form.addClass('was-validated');
      return false;
    }
    return true;
  }

  // Handle School Form submission
  $('#schoolForm').on('submit', function (e) {
    e.preventDefault();
    if (!validateForm($(this))) {
      return;
    }

    var formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: 'db_config2.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#result').html(response);
        $('#schoolForm')[0].reset();
        $('#schoolForm').removeClass('was-validated');
        location.reload(); // Reload the page to update the list of schools
      },
    });
  });

  // Handle Add Class Modal show event
  $('#addClassModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var schoolId = button.data('school-id'); // Extract school ID from data-* attributes
    var modal = $(this);
    modal.find('#schoolIdForClass').val(schoolId); // Update the modal's input field with the school ID
  });

  // Handle Class Form submission
  $('#classForm').on('submit', function (e) {
    e.preventDefault();
    if (!validateForm($(this))) {
      return;
    }

    var formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: 'db_config2.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#result').html(response);
        $('#classForm')[0].reset();
        $('#classForm').removeClass('was-validated');
        $('#addClassModal').modal('hide');
        location.reload(); // Reload the page to update the list of classes
      },
    });
  });

  // Handle Add Student Modal show event
  $('#addStudentModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var classId = button.data('class-id'); // Extract class ID from data-* attributes
    var modal = $(this);
    modal.find('#classIdForStudent').val(classId); // Update the modal's input field with the class ID
  });

  // Handle Student Form submission
  $('#studentForm').on('submit', function (e) {
    e.preventDefault();
    if (!validateForm($(this))) {
      return;
    }

    var formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: 'db_config2.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#result').html(response);
        $('#studentForm')[0].reset();
        $('#studentForm').removeClass('was-validated');
        $('#addStudentModal').modal('hide');
        location.reload(); // Reload the page to update the list of students
      },
    });
  });
});
