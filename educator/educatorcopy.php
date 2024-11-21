<?php
// educator_dashboard
session_start();
require_once 'includes/dbconnection.php';
require_once 'includes/functions.php';
require_once 'includes/StudentScoreService.php';
require_once 'includes/base_url.php';

$pdo = dbConnect();

$studentScoreService = new StudentScoreService($pdo);

$message = '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
// Check if the user is logged in and is an educator
if (!isset($_SESSION['user_email']) || $_SESSION['role'] !== 'educator') {
    header('Location: index.php');
    exit();
}

$educatorEmail = $_SESSION['user_email'];

// Fetch educator's profile details
$stmt = $pdo->prepare('SELECT id, profile_pic, name, gender, phone_number, emergency_contact, dob, location FROM educators WHERE email = ?');
$stmt->execute([$educatorEmail]);
$educator = $stmt->fetch(PDO::FETCH_ASSOC);

// Check for Educator
if (!$educator) {
    header('Location: error.php');
    exit();
}

$educatorId = $educator['id'];

// Fetch all schools assigned to the educator from the educator_schools table
$stmtSchools = $pdo->prepare('
    SELECT s.id, s.school_name 
    FROM schools s 
    INNER JOIN educator_schools es ON es.school_id = s.id 
    WHERE es.educator_id = ?
');
$stmtSchools->execute([$educatorId]);
$schools = $stmtSchools->fetchAll(PDO::FETCH_ASSOC);

if (!$schools) {
    $message = 'No schools assigned to you.';
    $schools = [];
}

// Handle school selection
$selectedSchoolId = isset($_GET['school_id']) ? intval($_GET['school_id']) : null;
if (!$selectedSchoolId && count($schools) > 0) {
    // Default to the first school if none selected
    $selectedSchoolId = $schools[0]['id'];
}

// Fetch the school name for the selected school
$selectedSchoolName = 'Unknown School';
foreach ($schools as $school) {
    if ($school['id'] == $selectedSchoolId) {
        $selectedSchoolName = $school['school_name'];
        break;
    }
}

$classId = isset($_GET['class_id']) ? intval($_GET['class_id']) : null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying
}

// Fetch classes for the selected school
$stmtClasses = $pdo->prepare('SELECT * FROM classes WHERE school_id = ?');
$stmtClasses->execute([$selectedSchoolId]);
$classes = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educator Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($educator['name']); ?></h1>
    
    <h2>Assigned Schools</h2>
    <form method="GET" action="">
        <label for="school_id">Select a School:</label>
        <select name="school_id" id="school_id" onchange="this.form.submit()">
            <?php foreach ($schools as $school): ?>
                <option value="<?= $school['id']; ?>" <?= $school['id'] == $selectedSchoolId ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($school['school_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <h2>Selected School: <?= htmlspecialchars($selectedSchoolName); ?></h2>

    <h3>Classes</h3>
    <?php if ($classes): ?>
        <ul>
            <?php foreach ($classes as $class): ?>
                <li>
                    <a href="class_details.php?class_id=<?= $class['id']; ?>&school_id=<?= $selectedSchoolId; ?>">
                        <?= htmlspecialchars($class['class_name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No classes found for this school.</p>
    <?php endif; ?>

    <p><?= htmlspecialchars($message); ?></p>
</body>
</html>
