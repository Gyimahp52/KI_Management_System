<?php
session_start();
require_once 'db_connection.php';
require_once 'manage_sel_functions.php';

$schools = getSchools();
$assigned_themes = getAssignedThemes();
$sel_themes = getAllSELThemes();
$current_term_info = getCurrentTermInfo();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_theme'])) {
        $theme_name = $_POST['theme_name'];
        $competency = $_POST['competency'];
        $character_strength = $_POST['character_strength'];
        createSELTheme($theme_name, $competency, $character_strength);
    } elseif (isset($_POST['assign_themes'])) {
        $school_id = $_POST['school_id'];
        $theme_ids = $_POST['theme_ids'] ?? [];
        if ($school_id == 'all') {
            assignThemesToAllSchools($theme_ids);
        } else {
            assignThemesToSchool($school_id, $theme_ids);
        }
    } elseif (isset($_POST['start_new_term'])) {
        $academic_year_id = $_POST['academic_year_id'];
        $term_number = $_POST['term_number'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $new_term_info = startNewTerm($academic_year_id, $term_number, $start_date, $end_date);
        if ($new_term_info) {
            $current_term_info = $new_term_info;
        }
    } elseif (isset($_POST['delete_theme'])) {
        $school_id = $_POST['school_id'];
        $term_id = $_POST['term_id'];
        deleteAssignedThemes($school_id, $term_id);
    }elseif (isset($_POST['delete_themes'])) {
        $theme_ids = $_POST['theme_ids'];
        foreach ($theme_ids as $theme_id) {
            deleteSELTheme($theme_id);
        }
        $_SESSION['toast_message'] = 'Selected SEL Themes deleted successfully.';
        $_SESSION['toast_type'] = 'success';

    }
     // Redirect to the same page to reload
     header('Location: ' . $_SERVER['PHP_SELF']);
     exit();
}


// if (isset($_SESSION['toast_message'])) {
//   echo "toastr." . $_SESSION['toast_type'] . "('" . $_SESSION['toast_message'] . "');";
//   unset($_SESSION['toast_message']);
//   unset($_SESSION['toast_type']);
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEL Themes Management</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <style>
        .btn-flex{
            display: flex;
            gap: 0.2rem;
        }
        .as-check{
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <!--Side bar-->
<?php include_once('includes/side_bar.php');?>

<div class="container">
    <h1 class="mb-4">SEL Themes Management</h1>

    <?php if ($current_term_info): ?>
        <div class="alert alert-info">
            <strong>Current Term:</strong> Term <?php echo htmlspecialchars($current_term_info['term_number']); ?>, Academic Year <?php echo htmlspecialchars($current_term_info['year_name']); ?>
        </div>
    <?php endif; ?>

    <div class="grid-container">
        <div class="grid-item">
            <h2>Create SEL Theme</h2>
            <?php include 'create_theme_form.php'; ?>
        </div>

        <div class="grid-item">
            <h2>Start New Term</h2>
            <?php include 'start_new_term_form.php'; ?>
        </div>

        <div class="grid-item">
            <h2>Assign SEL Themes to School</h2>
            <?php include 'assign_themes_form.php'; ?>
        </div>

        <div class="grid-item full-width">
            <h2>Assigned SEL Themes</h2>
            <?php include 'assigned_themes_table.php'; ?>
        </div>
    </div>
</div>

<?php include 'modal.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- <script src="script.js"></script> -->
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

function showThemes(themes) {
  document.getElementById('modalBody').textContent = themes;
  $('#themesModal').modal('show');
}

// Prevent form resubmission on page reload
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

// Prevent form resubmission on page reload
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Display toasts
<?php
if (isset($_SESSION['toast_message']) && isset($_SESSION['toast_type'])) {
  echo "toastr." . $_SESSION['toast_type'] . "('" . $_SESSION['toast_message'] . "');";
  unset($_SESSION['toast_message']);
  unset($_SESSION['toast_type']);
}



?>
</script>
<script src="assets/js/adminDashboard.js"></script>
<script src="assets/js/scripts.j"></script>
<script src="/admin/assets/js/adminDashboard.js"></script>

</body>
</html>