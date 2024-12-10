<?php
// Strict error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require_once 'includes/dbconnection.php';

// Validate input parameters
if (!isset($_GET['student_id'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Student ID is required'
    ]);
    exit;
}

$student_id = $_GET['student_id'];
$term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : null;
var_dump($student_id, $term_id);

try {
    // Fetch student basic information
    $stmt = $pdo->prepare("
        SELECT 
            s.*, 
            c.class_name, 
            sc.school_name,
            c.class_id
        FROM students s
        JOIN classes c ON s.class_id = c.class_id
        JOIN schools sc ON c.school_id = sc.id
        WHERE s.student_id = ?
    ");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo json_encode([
            'success' => false, 
            'message' => 'Student not found'
        ]);
        exit;
    }

    // Calculate age
    $dob = new DateTime($student['dob']);
    $today = new DateTime('now');
    $age = $today->diff($dob)->y;

    // Fetch SEL themes and scores
    // Modify this query based on your actual database schema
    $stmt = $pdo->prepare("
        SELECT 
            st.theme_name, 
            st.competency, 
            st.character_strength, 
            ss.score,
            ss.term_id
        FROM sel_themes st
        JOIN student_scores ss ON st.id = ss.theme_id
        WHERE ss.student_id = ?
        " . ($term_id ? "AND ss.term_id = ?" : "") . "
    ");

    // Execute with or without term_id
    if ($term_id) {
        $stmt->execute([$student_id, $term_id]);
    } else {
        $stmt->execute([$student_id]);
    }
    $sel_themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If no themes found, provide a default message
    if (empty($sel_themes)) {
        $sel_themes = [
            [
                'theme_name' => 'No Data',
                'competency' => 'N/A',
                'character_strength' => 'N/A',
                'score' => 0
            ]
        ];
    }

    // Construct the HTML report
    ob_start();
?>
<div class="student-report-container">
    <div class="report-header">
        <h1>Student Progress Report</h1>
        <div class="student-basic-info">
            <h2><?php echo htmlspecialchars($student['name']); ?></h2>
            <p>
                <strong>School:</strong> <?php echo htmlspecialchars($student['school_name']); ?> | 
                <strong>Class:</strong> <?php echo htmlspecialchars($student['class_name']); ?> | 
                <strong>Age:</strong> <?php echo $age; ?> years
            </p>
        </div>
    </div>

    <div class="sel-themes-section">
        <h3>Social Emotional Learning (SEL) Themes</h3>
        <table class="sel-themes-table">
            <thead>
                <tr>
                    <th>Theme</th>
                    <th>Competency</th>
                    <th>Character Strength</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sel_themes as $theme): ?>
                <tr>
                    <td><?php echo htmlspecialchars($theme['theme_name']); ?></td>
                    <td><?php echo htmlspecialchars($theme['competency']); ?></td>
                    <td><?php echo htmlspecialchars($theme['character_strength']); ?></td>
                    <td><?php echo htmlspecialchars($theme['score']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="additional-student-info">
        <h3>Additional Information</h3>
        <div class="info-grid">
            <div>
                <strong>Height:</strong> <?php echo htmlspecialchars($student['height'] ?? 'N/A'); ?> cm
            </div>
            <div>
                <strong>Weight:</strong> <?php echo htmlspecialchars($student['weight'] ?? 'N/A'); ?> kg
            </div>
            <div>
                <strong>Dominant Hand:</strong> <?php echo htmlspecialchars($student['hand'] ?? 'N/A'); ?>
            </div>
            <div>
                <strong>Medical Conditions:</strong> <?php echo htmlspecialchars($student['medical_condition'] ?? 'None'); ?>
            </div>
        </div>
    </div>

    <div class="report-footer">
        <p><em>Report generated on <?php echo date('Y-m-d H:i:s'); ?></em></p>
    </div>
</div>

<?php
    $reportHtml = ob_get_clean();
    
    // Return the full HTML
    echo $reportHtml;
    exit;

} catch (PDOException $e) {
    // Detailed error logging
    error_log('Database Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Database error occurred'
    ]);
    exit;
} catch (Exception $e) {
    // Generic error handling
    error_log('Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'An unexpected error occurred'
    ]);
    exit;
}
?>