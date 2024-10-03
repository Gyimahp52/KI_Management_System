<?php
// combined_scores.php
include('includes/auth.php');

require_once 'db_connction.php';
require_once 'StudentScoreService.php';
require_once 'microservice_client.php';

$studentScoreService = new StudentScoreService($pdo);
$microserviceClient = new MicroserviceClient();

// Fetching data for student_sel_scores.php
$schools = $studentScoreService->getSchools();
$classes = [];
$students = [];
$message = '';

$term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}

if (isset($_GET['school_id'])) {
    $classes = $studentScoreService->getClasses($_GET['school_id']);
}


$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
if (isset($_GET['class_id'])) {
    $students = $studentScoreService->getStudentsWithThemesAndScores($_GET['class_id'], $searchQuery);
}

if (isset($_GET['class_id'])) {
    $students = $studentScoreService->getStudentsWithThemesAndScores($_GET['class_id'], $searchQuery);
}

// Save Scores
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['view']) && $_POST['view'] === 'enter') {
    $scores = $_POST['scores'] ?? [];
    $current_term_id = $studentScoreService->getCurrentTermId();

    if (!$current_term_id) {
        // Add debugging to see why it's not returning
        error_log("Debug: No active term ID found. Check database or term date logic.");
        $_SESSION['message'] = "Error: No active term found. Please check the term dates.";
    } else {
        try {
            $studentScoreService->saveScores($scores, $current_term_id);
            $_SESSION['message'] = "Scores saved successfully.";
        } catch (Exception $e) {
            $_SESSION['message'] = "Error: An error occurred while saving the scores: " . $e->getMessage();
            error_log("Error while saving scores: " . $e->getMessage());
        }
    }



    // Redirect to prevent form resubmission
    $redirect_url = $_SERVER['PHP_SELF'] . '?school_id=' . $_GET['school_id'] . '&class_id=' . $_GET['class_id'] . '&view=enter';
    header('Location: ' . $redirect_url);
    exit();
}

// Fetching data for view_sel_score.php
function getSchools() {
    global $pdo;
    $sql = "SELECT * FROM schools ORDER BY school_name";
    return $pdo->query($sql)->fetchAll();
}

function getClasses($school_id) {
    global $pdo;
    $sql = "SELECT * FROM classes WHERE school_id = ? ORDER BY class_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$school_id]);
    return $stmt->fetchAll();
}

function getAcademicYears() {
    global $pdo;
    $sql = "SELECT * FROM academic_years ORDER BY start_date DESC";
    return $pdo->query($sql)->fetchAll();
}

function getTerms($academic_year_id) {
    global $pdo;
    $sql = "SELECT * FROM terms WHERE academic_year_id = ? ORDER BY start_date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$academic_year_id]);
    return $stmt->fetchAll();
}


$viewSchools = getSchools();
$viewClasses = [];
$academic_years = getAcademicYears();
$terms = [];
$viewStudents = [];

if (isset($_GET['view_school_id'])) {
    $viewClasses = getClasses($_GET['view_school_id']);
}

if (isset($_GET['academic_year_id'])) {
    $terms = getTerms($_GET['academic_year_id']);
}


$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if (isset($_GET['view_class_id']) && isset($_GET['term_id'])) {
    $viewStudents = getStudents($_GET['view_class_id'], $_GET['term_id'], $searchQuery);
}

// getStudents function to including the search functionality
function getStudents($class_id, $term_id, $searchQuery = '') {
    global $pdo;
    $sql = "
        SELECT DISTINCT s.student_id, s.name, t.term_number, t.id as term_id, ay.year_name
        FROM students s
        JOIN student_scores ss ON s.student_id = ss.student_id
        JOIN terms t ON ss.term_id = t.id
        JOIN academic_years ay ON t.academic_year_id = ay.id
        WHERE s.class_id = ? AND t.id = ? AND (s.student_id LIKE ? OR s.name LIKE ?)
        ORDER BY s.name
    ";
    $stmt = $pdo->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $stmt->execute([$class_id, $term_id, $searchParam, $searchParam]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$view = isset($_GET['view']) ? $_GET['view'] : 'enter'; // Default view is 'enter'

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student SEL Scores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" integrity="sha512-oe8OpYjBaDWPt2VmSFR+qYOdnTjeV9QPLJUeqZyprDEQvQLJ9C5PCFclxwNuvb/GQgQngdCXzKSFltuHD3eCxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .score-input {
            width: 60px;
        }
        .previous-score {
            font-size: 0.8em;
            color: #6c757d;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-button {
            margin-right: 5px;
        }
        .search-bar {
            margin-bottom: 15px;
            display: flex;
            justify-content: flex-end;
        }
        .search-input {
            width: 250px;
            margin-right: 5px;
        }
        .spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: .25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border .75s linear infinite;
}

@keyframes spinner-border {
    to { transform: rotate(360deg); }
}
    </style>
    <script>
        function toggleView(view) {
            document.getElementById('enter-scores-view').style.display = view === 'enter' ? 'block' : 'none';
            document.getElementById('view-scores-view').style.display = view === 'view' ? 'block' : 'none';
            document.getElementById('current-view').value = view;
        }

    function updateTerms() {
    var academicYearSelect = document.getElementById('academic_year_id');
    var termSelect = document.getElementById('term_id');
    var selectedAcademicYear = academicYearSelect.value;

    // Clear existing options
    termSelect.innerHTML = '<option value="">Select Term</option>';

    if (selectedAcademicYear) {
        // Use AJAX to fetch terms for the selected academic year
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    try {
                        var response = JSON.parse(this.responseText);
                        if (response.error) {
                            console.error('Error:', response.error);
                        } else {
                            response.forEach(function(term) {
                                var option = document.createElement('option');
                                option.value = term.id;
                                option.textContent = term.term_number;
                                termSelect.appendChild(option);
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                } else {
                    console.error('HTTP error:', this.status, this.statusText);
                }
            }
        };
        xhr.open('GET', 'get_terms.php?academic_year_id=' + selectedAcademicYear, true);
        xhr.send();
    }
}

        window.onload = function() {
            toggleView('<?php echo $view; ?>');
        }
    </script>
</head>
<body>

<?php include_once('includes/side_bar.php');?>

    <div class="container mt-5 main-contnt">

        <?php include_once('includes/header.php');?>

        <h1 class="mb-4">Student SEL Scores</h1>

        <div class="mb-3">
            <button class="btn btn-primary" onclick="toggleView('enter')">Enter Scores</button>
            <button class="btn btn-secondary" onclick="toggleView('view')">View Scores</button>
        </div>

        <input type="hidden" id="current-view" name="view" value="<?php echo htmlspecialchars($view); ?>">

        <div id="enter-scores-view" style="display: none;">
            <?php if ($message): ?>
                <div class="alert <?php echo strpos($message, 'Error') === 0 ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="GET" class="mb-3">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="school_id" class="col-form-label">Select School:</label>
                    </div>
                    <div class="col-auto">
                        <select name="school_id" id="school_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select School</option>
                            <?php foreach ($schools as $school): ?>
                                <option value="<?php echo $school['id']; ?>" <?php echo (isset($_GET['school_id']) && $_GET['school_id'] == $school['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($school['school_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="view" value="enter">
                    </div>
                </div>
            </form>

            <?php if (!empty($classes)): ?>
                <form method="GET" class="mb-3">
                    <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id']); ?>">
                    <input type="hidden" name="view" value="enter">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="class_id" class="col-form-label">Select Class:</label>
                        </div>
                        <div class="col-auto">
                            <select name="class_id" id="class_id" class="form-select" onchange="this.form.submit()">
                                <option value="">Select Class</option>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?php echo $class['class_id']; ?>" <?php echo (isset($_GET['class_id']) && $_GET['class_id'] == $class['class_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

            <?php if (!empty($students)): ?>
                <form method="GET" class="search-bar">
                    <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id']); ?>">
                    <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($_GET['class_id']); ?>">
                    <input type="hidden" name="view" value="enter">
                    <input type="text" name="search" class="form-control search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="view" value="enter">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <?php 
                                    $first_student = reset($students);
                                    foreach ($first_student as $theme) {
                                        echo "<th>" . htmlspecialchars($theme['theme_name']) . "</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student_id => $themes): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student_id); ?></td>
                                        <td><?php echo htmlspecialchars($themes[0]['name']); ?></td>
                                        <?php foreach ($themes as $theme): ?>
                                            <td>
                                                <input type="number" name="scores[<?php echo $student_id; ?>][<?php echo $theme['theme_id']; ?>]" min="2" max="9" step="1" class="form-control score-input" value="<?php echo $theme['score'] !== null ? htmlspecialchars(round($theme['score'])) : ''; ?>">
                                                <?php if ($theme['score'] !== null): ?>
                                                    <div class="previous-score">
                                                        Last updated: <?php echo htmlspecialchars($theme['date_assessed']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Scores</button>
                </form>
            <?php endif; ?>
        </div>

        <div id="view-scores-view" style="display: none;">
        <form method="GET">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <select class="form-select" name="view_school_id" id="view_school_id">
                <option value="">Select School</option>
                <?php foreach ($viewSchools as $school): ?>
                    <option value="<?php echo $school['id']; ?>" <?php echo (isset($_GET['view_school_id']) && $_GET['view_school_id'] == $school['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($school['school_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-auto">
            <select name="view_class_id" id="view_class_id" class="form-select">
                <option value="">Select Class</option>
                <?php foreach ($viewClasses as $class): ?>
                    <option value="<?php echo $class['class_id']; ?>" <?php echo (isset($_GET['view_class_id']) && $_GET['view_class_id'] == $class['class_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($class['class_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-auto">
            <select class="form-select" name="academic_year_id" id="academic_year_id" onchange="updateTerms()">
                <option value="">Select Academic Year</option>
                <?php foreach ($academic_years as $year): ?>
                    <option value="<?php echo $year['id']; ?>" <?php echo (isset($_GET['academic_year_id']) && $_GET['academic_year_id'] == $year['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($year['year_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-auto">
            <select class="form-select" name="term_id" id="term_id">
                <option value="">Select Term</option>
            </select>
        </div>

        <div class="col-auto">
        <input type="text" name="search" id="student-search" class="form-control search-input" placeholder="Search by ID or Name" value="<?php echo htmlspecialchars($searchQuery); ?>">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-primary">View Students</button>
    </div>
    </div>
    <input type="hidden" name="view" value="view">
</form>

<?php if (!empty($viewStudents)): ?>
    <div id="students-table-container">
        <table id="students-table">
                    <tr>
                    <th><input type="checkbox" id="select-all"></th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Term</th>
                        <th>Report</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($viewStudents as $student): ?>
                        <tr>
                        <td><input type="checkbox" class="student-select" value="<?php echo $student['student_id']; ?>"></td>
                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['year_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['term_number']); ?></td>
                            <td>
                                <a target="_blank" rel="noopener noreferrer" href="view_report.php?student_id=<?php echo $student['student_id']; ?>&term_id=<?php echo $term_id; ?>">View</a>
                            </td>
                            <td>
                                <button id="generate-<?php echo $student['student_id']; ?>-<?php echo $term_id; ?>" onclick="generateReport('<?php echo $student['student_id']; ?>', <?php echo $term_id; ?>)" class="action-button">Generate</button>
                                <button id="download-<?php echo $student['student_id']; ?>-<?php echo $term_id; ?>" onclick="downloadReport('<?php echo $student['student_id']; ?>', <?php echo $term_id; ?>)" class="action-button" disabled>Download</button>
                                <button id="whatsApp-<?php echo $student['student_id']; ?>-<?php echo $term_id; ?>" onclick="sendWhatsApp('<?php echo $student['student_id']; ?>', <?php echo $term_id; ?>)" disabled>WhatsApp</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
        </table>
    </div>
    <input type="hidden" name="term_id" value="<?php echo $term_id; ?>">
                <button id="bulk-whatsapp">Send Selected via WhatsApp</button>
        <button type="submit" formaction="batch_download.php">Download Selected</button>
<?php endif; ?>
</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <sript src="assets/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

// Call this function when the page loads
window.addEventListener('load', initializeButtonStates);

function generateReport(studentId, termId) {
    console.log(`Generating report for Student ID: ${studentId}, Term ID: ${termId}`);

    // Disable the download button immediately and change the label
    const downloadButton = document.getElementById(`download-${studentId}-${termId}`);
    downloadButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    downloadButton.disabled = true;
    
    fetch(`generate_report.php?student_id=${encodeURIComponent(studentId)}&term_id=${encodeURIComponent(termId)}`)
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            if (data.status === 'success') {
                checkPdfStatus(studentId, termId);
            } else {
                console.error('Error:', data.message);
                alert('Failed to start PDF generation: ' + data.message);
                downloadButton.textContent = 'Download';  // Revert the button
                downloadButton.disabled = true;  // Keep disabled on failure
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.warning('An error occurred while generating the report');
            downloadButton.textContent = 'Download';  // Revert the button
            downloadButton.disabled = true;  // Keep disabled on error
        });
}

function checkPdfStatus(studentId, termId) {
    const downloadButton = document.getElementById(`download-${studentId}-${termId}`);
    const whatsAppButton = document.getElementById(`whatsApp-${studentId}-${termId}`);
    downloadButton.textContent = 'Generating...';  // Set to generating while checking status

    const checkStatus = () => {
        fetch(`check_pdf_status.php?student_id=${studentId}&term_id=${termId}`)
            .then(response => response.json())  // Parse the JSON response
            .then(data => {
                switch (data.status.toLowerCase()) {
                    case 'completed':
                        toastr.success('pdf generated succesfully');
                        downloadButton.textContent = 'Download';
                        downloadButton.disabled = false;  // Enable when completed
                        downloadButton.style.backgroundColor = '#33b249'
                        whatsAppButton.style.backgroundColor = '#33b249'
                        
                        break;
                    case 'generating':
                    case 'in progress':
                        setTimeout(checkStatus, 2000);  // Check again after 2 seconds
                        break;
                    case 'error':
                        console.error('Error status received:', data.status);
                        alert('An error occurred while generating the PDF');
                        downloadButton.textContent = 'Download';
                        downloadButton.disabled = true;  // Keep disabled on error
                        break;
                    default:
                        console.error('Unexpected status:', data.status);
                        alert('Unknown status: ' + data.status);
                        downloadButton.textContent = 'Download';
                        downloadButton.disabled = true;  // Keep disabled on unknown status
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.warning('An error occurred while checking the PDF status');
                downloadButton.textContent = 'Download';
                downloadButton.disabled = true;  // Keep disabled on error
            });
    };

    checkStatus();
}

function downloadReport(studentId, termId) {
        window.location.href = `download_report.php?student_id=${studentId}&term_id=${termId}`;
    }



function sendWhatsApp(studentId, termId) {
    const whatsAppButton = document.getElementById(`whatsApp-${studentId}-${termId}`);
    whatsAppButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'; // Show spinner
    sendWhatsAppMessages([studentId], termId, whatsAppButton);
}

function sendWhatsAppMessages(studentIds, termId, whatsAppButton) {
    fetch('send_whatsapp.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `student_id=${studentIds.join(',')}&term_id=${termId}`
    })
    .then(response => {
        console.log('Raw response:', response);
        return response.text();  // Parse as text first to handle any potential malformed JSON
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            return JSON.parse(text);  // Attempt to parse the text response into JSON
        } catch (error) {
            console.error('Failed to parse JSON:', error);
            throw new Error('Invalid JSON response from server');
        }
    })
    .then(data => {
        if (data.status === 'success') {
            data.data.forEach(result => {
                if (result.success) {
                    whatsAppButton.innerHTML = 'Sent';  // Update button on success
                    toastr.success('WhatsApp message sent successfully');
                } else {
                    whatsAppButton.innerHTML = 'Try again';  // If sending failed, change text to 'Try again'
                    toastr.error('Failed to send WhatsApp message: ' + (result.error || 'Unknown error'));
                }
            });
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        whatsAppButton.innerHTML = 'Try again';  // Handle error by setting button text to 'Try again'
        toastr.error('An error occurred while sending WhatsApp messages: ' + error.message);
    });
}

document.getElementById('bulk-whatsapp').addEventListener('click', function() {
    const selectedStudents = Array.from(document.querySelectorAll('.student-select:checked')).map(checkbox => checkbox.value);
    if (selectedStudents.length > 0) {
        sendWhatsAppMessages(selectedStudents, <?php echo $term_id; ?>);
    } else {
        toastr.warning('Please select at least one student.');
    }
});

// event listener for select all checkbox
document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.student-select').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});


function updateButtonStates(studentId, termId) {
    const generateButton = document.getElementById(`generate-${studentId}-${termId}`);
    const downloadButton = document.getElementById(`download-${studentId}-${termId}`);
    const whatsAppButton = document.getElementById(`whatsApp-${studentId}-${termId}`);
    
    fetch(`check_pdf_exists.php?student_id=${studentId}&term_id=${termId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }

            // Handle PDF existence logic
            if (data.pdfExists) {
                console.log('PDF exists:', data.pdfExists);
                generateButton.disabled = true;
                downloadButton.disabled = false;
                downloadButton.style.backgroundColor = '#33b249'; // Green color for successful download availability
                
                // Set WhatsApp button to green when PDF exists
                whatsAppButton.style.backgroundColor = '#33b249'; // Green for PDF existence
            } else {

                generateButton.disabled = false;
                downloadButton.disabled = true;
                downloadButton.style.backgroundColor = ''; // Reset to default if no PDF
                
                // Reset WhatsApp button if no PDF
                whatsAppButton.style.backgroundColor = '';  // Reset to default if no PDF exists
            }

            // Handle WhatsApp button state based on sendStatus
            if (data.sendStatus === 'sent') {
                whatsAppButton.disabled = false;
                whatsAppButton.innerHTML = 'Sent (Resend)'; 
            } else if (data.sendStatus === 'fail') {
                whatsAppButton.disabled = false;
                whatsAppButton.innerHTML = 'Try Again'; 
            } else {
                whatsAppButton.disabled = false;
                whatsAppButton.innerHTML = 'WhatsApp'; 
            }
        })
        .catch(error => {
            console.error('Error checking PDF or send status:', error);

            // Set default state in case of error
            generateButton.disabled = false;
            downloadButton.disabled = true;
            whatsAppButton.disabled = false;
            whatsAppButton.style.backgroundColor = '';
            whatsAppButton.innerHTML = 'Send via WhatsApp'; 
        });
}


function initializeButtonStates() {
    const buttons = document.querySelectorAll('[id^="generate-"]');
    buttons.forEach(button => {
        const [, studentId, termId] = button.id.split('-');
        updateButtonStates(studentId, termId);
    });
}


document.addEventListener('DOMContentLoaded', function() {
    var studentSearch = document.getElementById('student-search');
    var studentsTable = document.getElementById('students-table');

    if (studentSearch && studentsTable) {
        studentSearch.addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            var rows = studentsTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var studentId = rows[i].cells[0].textContent.toLowerCase();
                var studentName = rows[i].cells[1].textContent.toLowerCase();

                if (studentId.includes(searchQuery) || studentName.includes(searchQuery)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    }
});
// Add event listeners for cascading dropdowns
document.getElementById('view_school_id').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('view_class_id').addEventListener('change', function() {
    document.getElementById('academic_year_id').value = '';
    document.getElementById('term_id').innerHTML = '<option value="">Select Term</option>';
});

</script>
</body>
</html>
