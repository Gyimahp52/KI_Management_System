<?php
// view_historical_scores.php
include('includes/auth.php');
require_once 'db_connction.php';

// Fetching data for the page
$schools = [];
$classes = [];
$students = [];
$message = '';

$term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}

// Fetch schools
function getSchools() {
    global $pdo;
    $sql = "SELECT * FROM schools ORDER BY school_name";
    return $pdo->query($sql)->fetchAll();
}

// Fetch classes for a specific school
function getClasses($school_id) {
    global $pdo;
    $sql = "SELECT * FROM classes WHERE school_id = ? ORDER BY class_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$school_id]);
    return $stmt->fetchAll();
}

// Fetch academic years
function getAcademicYears() {
    global $pdo;
    $sql = "SELECT * FROM academic_years ORDER BY start_date DESC";
    return $pdo->query($sql)->fetchAll();
}

// Fetch terms for a specific academic year
function getTerms($academic_year_id) {
    global $pdo;
    $sql = "SELECT * FROM terms WHERE academic_year_id = ? ORDER BY start_date";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$academic_year_id]);
    return $stmt->fetchAll();
}

// Fetch students for a specific class and term
function getStudents($class_id, $term_id, $searchQuery = '') {
    global $pdo;
    $sql = "
        SELECT DISTINCT s.student_id, s.name, t.term_number, t.id as term_id, ay.year_name
        FROM students s
        JOIN terms t ON t.id = ?
        JOIN academic_years ay ON t.academic_year_id = ay.id
        WHERE s.class_id = ? AND (s.student_id LIKE ? OR s.name LIKE ?)
        ORDER BY s.name
    ";
    $stmt = $pdo->prepare($sql);
    $searchParam = '%' . $searchQuery . '%';
    $stmt->execute([$term_id, $class_id, $searchParam, $searchParam]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch data based on GET parameters
$schools = getSchools();
$academic_years = getAcademicYears();
$terms = [];
$students = [];

if (isset($_GET['school_id'])) {
    $classes = getClasses($_GET['school_id']);
}

if (isset($_GET['academic_year_id'])) {
    $terms = getTerms($_GET['academic_year_id']);
}

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if (isset($_GET['class_id']) && isset($_GET['term_id'])) {
    $students = getStudents($_GET['class_id'], $_GET['term_id'], $searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Historical Scores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="style.css">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/images/site.webmanifest">

    <style>
    .search-bar {
        margin-bottom: 15px;
        display: flex;
        justify-content: flex-end;
    }

    .search-input {
        width: 250px;
        margin-right: 5px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
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
    </style>
</head>

<body>
    <?php include_once('includes/side_bar.php'); ?>
    <div class="container mt-5 main-contnt">
        <?php include_once('includes/header.php'); ?>
        <h1 class="mb-4">View Historical Scores</h1>
        <div class="d-flex">
            <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, 'Error') === 0 ? 'alert-danger' : 'alert-success'; ?>"
                role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>

            <form method="GET" class="mb-3">
                <div class="d-flex row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="school_id" class="col-form-label">Select School:</label>
                    </div>
                    <div class="col-auto">
                        <select name="school_id" id="school_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select School</option>
                            <?php foreach ($schools as $school): ?>
                            <option value="<?php echo $school['id']; ?>"
                                <?php echo (isset($_GET['school_id']) && $_GET['school_id'] == $school['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($school['school_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>

            <?php if (!empty($classes)): ?>
            <form method="GET" class="mb-3">
                <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id']); ?>">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="class_id" class="col-form-label">Select Class:</label>
                    </div>
                    <div class="col-auto">
                        <select name="class_id" id="class_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Class</option>
                            <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['class_id']; ?>"
                                <?php echo (isset($_GET['class_id']) && $_GET['class_id'] == $class['class_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($class['class_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
            <?php endif; ?>

            <?php if (!empty($academic_years)): ?>
            <form method="GET" class="mb-3">
                <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id'] ?? ''); ?>">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($_GET['class_id'] ?? ''); ?>">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="academic_year_id" class="col-form-label">Select Academic Year:</label>
                    </div>
                    <div class="col-auto">
                        <select name="academic_year_id" id="academic_year_id" class="form-select"
                            onchange="this.form.submit()">
                            <option value="">Select Academic Year</option>
                            <?php foreach ($academic_years as $year): ?>
                            <option value="<?php echo $year['id']; ?>"
                                <?php echo (isset($_GET['academic_year_id']) && $_GET['academic_year_id'] == $year['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($year['year_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
            <?php endif; ?>

            <?php if (!empty($terms)): ?>
            <form method="GET" class="mb-3">
                <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id'] ?? ''); ?>">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($_GET['class_id'] ?? ''); ?>">
                <input type="hidden" name="academic_year_id"
                    value="<?php echo htmlspecialchars($_GET['academic_year_id'] ?? ''); ?>">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="term_id" class="col-form-label">Select Term:</label>
                    </div>
                    <div class="col-auto">
                        <select name="term_id" id="term_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Select Term</option>
                            <?php foreach ($terms as $term): ?>
                            <option value="<?php echo $term['id']; ?>"
                                <?php echo (isset($_GET['term_id']) && $_GET['term_id'] == $term['id']) ? 'selected' : ''; ?>>
                                Term <?php echo htmlspecialchars($term['term_number']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
            <?php endif; ?>

            <?php if (!empty($students)): ?>
            <form method="GET" class="search-bar">
                <input type="hidden" name="school_id" value="<?php echo htmlspecialchars($_GET['school_id'] ?? ''); ?>">
                <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($_GET['class_id'] ?? ''); ?>">
                <input type="hidden" name="academic_year_id"
                    value="<?php echo htmlspecialchars($_GET['academic_year_id'] ?? ''); ?>">
                <input type="hidden" name="term_id" value="<?php echo htmlspecialchars($_GET['term_id'] ?? ''); ?>">
                <input type="text" name="search" class="form-control search-input" placeholder="Search by ID or Name"
                    value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Term</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['year_name']); ?></td>
                        <td>Term <?php echo htmlspecialchars($student['term_number']); ?></td>
                        <td>
                            <!-- View Button -->
                            <a href="view_historical_report.php?student_id=<?php echo $student['student_id']; ?>&term_id=<?php echo $student['term_id']; ?>"
                                class="btn btn-primary action-button">View</a>
                            <!-- Generate Button -->
                            <button
                                id="generate-<?php echo $student['student_id']; ?>-<?php echo $student['term_id']; ?>"
                                onclick="generateReport('<?php echo $student['student_id']; ?>', <?php echo $student['term_id']; ?>)"
                                class="btn btn-secondary action-button">Generate</button>
                            <!-- Download Button -->
                            <button
                                id="download-<?php echo $student['student_id']; ?>-<?php echo $student['term_id']; ?>"
                                onclick="downloadReport('<?php echo $student['student_id']; ?>', <?php echo $student['term_id']; ?>)"
                                class="btn btn-success action-button" disabled>Download</button>
                            <!-- Send Button -->
                            <button
                                id="whatsApp-<?php echo $student['student_id']; ?>-<?php echo $student['term_id']; ?>"
                                onclick="sendWhatsApp('<?php echo $student['student_id']; ?>', <?php echo $student['term_id']; ?>)"
                                class="btn btn-warning action-button" disabled>Send</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="assets/js/adminDashboard.js"></script>
    <script src="assets/js/scripts.j"></script>
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
        downloadButton.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        downloadButton.disabled = true;

        fetch(`generate_report.php?student_id=${encodeURIComponent(studentId)}&term_id=${encodeURIComponent(termId)}`)
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                if (data.status === 'success') {
                    checkPdfStatus(studentId, termId);
                } else {
                    console.error('Error:', data.message);
                    alert('Failed to start PDF generation: ' + data.message);
                    downloadButton.textContent = 'Download'; // Revert the button
                    downloadButton.disabled = true; // Keep disabled on failure
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.warning('An error occurred while generating the report');
                downloadButton.textContent = 'Download'; // Revert the button
                downloadButton.disabled = true; // Keep disabled on error
            });
    }

    function checkPdfStatus(studentId, termId) {
        const downloadButton = document.getElementById(`download-${studentId}-${termId}`);
        const whatsAppButton = document.getElementById(`whatsApp-${studentId}-${termId}`);
        downloadButton.textContent = 'Generating...'; // Set to generating while checking status

        const checkStatus = () => {
            fetch(`check_pdf_status.php?student_id=${studentId}&term_id=${termId}`)
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    switch (data.status.toLowerCase()) {
                        case 'completed':
                            toastr.success('pdf generated succesfully');
                            downloadButton.textContent = 'Download';
                            downloadButton.disabled = false; // Enable when completed
                            downloadButton.style.backgroundColor = '#33b249'
                            whatsAppButton.style.backgroundColor = '#33b249'

                            break;
                        case 'generating':
                        case 'in progress':
                            setTimeout(checkStatus, 2000); // Check again after 2 seconds
                            break;
                        case 'error':
                            console.error('Error status received:', data.status);
                            alert('An error occurred while generating the PDF');
                            downloadButton.textContent = 'Download';
                            downloadButton.disabled = true; // Keep disabled on error
                            break;
                        default:
                            console.error('Unexpected status:', data.status);
                            alert('Unknown status: ' + data.status);
                            downloadButton.textContent = 'Download';
                            downloadButton.disabled = true; // Keep disabled on unknown status
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.warning('An error occurred while checking the PDF status');
                    downloadButton.textContent = 'Download';
                    downloadButton.disabled = true; // Keep disabled on error
                });
        };

        checkStatus();
    }

    function downloadReport(studentId, termId) {
        window.location.href = `download_report.php?student_id=${studentId}&term_id=${termId}`;
    }



    function sendWhatsApp(studentId, termId) {
        const whatsAppButton = document.getElementById(`whatsApp-${studentId}-${termId}`);
        whatsAppButton.innerHTML =
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'; // Show spinner
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
                return response.text(); // Parse as text first to handle any potential malformed JSON
            })
            .then(text => {
                console.log('Response text:', text);
                try {
                    return JSON.parse(text); // Attempt to parse the text response into JSON
                } catch (error) {
                    console.error('Failed to parse JSON:', error);
                    throw new Error('Invalid JSON response from server');
                }
            })
            .then(data => {
                if (data.status === 'success') {
                    data.data.forEach(result => {
                        if (result.success) {
                            whatsAppButton.innerHTML = 'Sent'; // Update button on success
                            toastr.success('WhatsApp message sent successfully');
                        } else {
                            whatsAppButton.innerHTML =
                                'Try again'; // If sending failed, change text to 'Try again'
                            toastr.error('Failed to send WhatsApp message: ' + (result.error ||
                                'Unknown error'));
                        }
                    });
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                whatsAppButton.innerHTML = 'Try again'; // Handle error by setting button text to 'Try again'
                toastr.error('An error occurred while sending WhatsApp messages: ' + error.message);
            });
    }

    document.getElementById('bulk-whatsapp').addEventListener('click', function() {
        const selectedStudents = Array.from(document.querySelectorAll('.student-select:checked')).map(
            checkbox => checkbox.value);
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
                    downloadButton.style.backgroundColor =
                        '#33b249'; // Green color for successful download availability

                    // Set WhatsApp button to green when PDF exists
                    whatsAppButton.style.backgroundColor = '#33b249'; // Green for PDF existence
                } else {

                    generateButton.disabled = false;
                    downloadButton.disabled = true;
                    downloadButton.style.backgroundColor = ''; // Reset to default if no PDF

                    // Reset WhatsApp button if no PDF
                    whatsAppButton.style.backgroundColor = ''; // Reset to default if no PDF exists
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

    document.addEventListener('DOMContentLoaded', function() {
        const scoreInputs = document.querySelectorAll('.validate-score');

        scoreInputs.forEach(input => {
            input.addEventListener('input', validateScore);
            input.addEventListener('change', validateScore);
        });

        function validateScore(event) {
            const input = event.target;
            const value = input.value.trim();

            // Remove any existing error message
            const existingError = input.nextElementSibling;
            if (existingError && existingError.classList.contains('error-message')) {
                existingError.remove();
            }

            // Check if the value is empty (null) or between 2 and 9
            if (value === '' || (value >= 2 && value <= 9)) {
                input.style.borderColor = '';
                input.style.backgroundColor = '';
            } else {
                input.style.borderColor = 'red';
                input.style.backgroundColor = '#ffeeee';

                // Add error message
                const errorSpan = document.createElement('span');
                errorSpan.textContent = 'Score must be between 2 and 9 or left empty.';
                errorSpan.style.color = 'red';
                errorSpan.style.fontSize = '0.8em';
                errorSpan.classList.add('error-message');
                input.parentNode.insertBefore(errorSpan, input.nextSibling);
            }
        }

        // Validate all scores before form submission
        document.querySelector('form').addEventListener('submit', function(event) {
            let hasError = false;
            scoreInputs.forEach(input => {
                const value = input.value.trim();
                if (value !== '' && (value < 2 || value > 9)) {
                    hasError = true;
                    input.style.borderColor = 'red';
                    input.style.backgroundColor = '#ffeeee';
                }
            });

            if (hasError) {
                event.preventDefault();
                alert('Please correct the highlighted scores before submitting.');
            }
        });
    });
    </script>
</body>

</html>