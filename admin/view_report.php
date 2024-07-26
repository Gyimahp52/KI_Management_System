<?php
// view_report.php

require_once 'db_connection.php';

// Check if student_id and term_id are provided
if (!isset($_GET['student_id']) || !isset($_GET['term_id'])) {
    die("Student ID and Term ID are required.");
}

$student_id = intval($_GET['student_id']);
$term_id = intval($_GET['term_id']);

// Fetch student information
$stmt = $pdo->prepare("
    SELECT s.*, c.class_name, sc.school_name
    FROM students s
    JOIN classes c ON s.class_id = c.class_id
    JOIN schools sc ON c.school_id = sc.id
    WHERE s.student_id = ?
");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}

// Fetch assigned SEL themes and scores
$stmt = $pdo->prepare("
    SELECT st.theme_name, st.competency, st.character_strength, ss.score
    FROM sel_themes st
    JOIN student_scores ss ON st.id = ss.theme_id
    WHERE ss.student_id = ? AND ss.term_id = ?
");
$stmt->execute([$student_id, $term_id]);
$sel_themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate KEQ (assuming it's the average of all scores)
$keq = array_sum(array_column($sel_themes, 'score')) / count($sel_themes);

$calcAge = $student['dob'];
$dob = new DateTime($calcAge);
$today = new DateTime('now');  
$age = $today->diff($dob)->y;  

// echo "Age: $age";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress Report</title>
    <link rel="stylesheet" href="assets/css/report.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <style>
        body { display: block; }
        ul { padding: 0; margin: 0; line-height: 1.5em; }
        li { padding: 0.2em; margin: 10px; }
    </style>
</head>
<body>
<div id="report-view" class="modal">
    <div class="report-container">
        <button class="close-btn" onclick="closeReport()"><strong>X</strong></button>
        <div class="faded-text"><strong>KI EDUCATION</strong></div>

        <!-- Page 1 -->
        <div id="report-page-1">
            <h1><u>KIE STUDENT PROGRESS REPORT</u></h1>
            <p>Kinesthetic Intelligence Education personal progress report for <strong><span id="student-name"><?php echo htmlspecialchars($student['name']); ?></span></strong> at <span id="student-school"><?php echo htmlspecialchars($student['school_name']); ?></span>. This term we practiced eleven soft skills for character development. The focus is not on the marks we emphasize on marginal improvement over time and creating cognizance of these strengths for students.</p>
            
            <div class="container">
                <div class="left-side">
                    <h2>Personal Information</h2>
                    <p><strong>Name:</strong> <span id="student-name-info"><?php echo htmlspecialchars($student['name']); ?></span></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($age ?? 'N/A'); ?> YEARS</p>
                    <p><strong>School:</strong> <span id="student-school-info"><?php echo htmlspecialchars($student['school_name']); ?></span></p>
                    <p><strong>Class:</strong> <span id="student-class-info"><?php echo htmlspecialchars($student['class_name']); ?></span></p>
                    <p><strong>Height:</strong> <?php echo htmlspecialchars($student['height'] ?? 'N/A'); ?></p>
                    <p><strong>Weight:</strong> <?php echo htmlspecialchars($student['weight'] ?? 'N/A'); ?></p>
                </div>
                
                <div class="right-side">
                    <p><strong>Foot:</strong> <?php echo htmlspecialchars($student['foot'] ?? 'N/A'); ?> </p>
                    <p><strong>Hand:</strong> <?php echo htmlspecialchars($student['hand'] ?? 'N/A'); ?></p>
                    <p><strong>Eyesight:</strong> <?php echo htmlspecialchars($student['eye_sight'] ?? 'N/A'); ?></p>
                    <p><strong>Heart Rate:</strong> <?php echo htmlspecialchars($student['heart_rate'] ?? 'N/A'); ?></p>
                    <p><strong>Medical Condition:</strong> <?php echo htmlspecialchars($student['medical_condition'] ?? 'N/A'); ?></p>
                </div>
            </div>
            <section class="data-tables">
    <h2>1. Student KEQ Field Data</h2>
    <table>
        <tr>
            <th>Metrics</th>
            <?php foreach ($sel_themes as $theme): ?>
                <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>KEQ</td>
            <?php foreach ($sel_themes as $theme): ?>
                <td><?php echo htmlspecialchars($theme['score']); ?></td>
            <?php endforeach; ?>
        </tr>
    </table>
</section>
            <div class="graph-description">
                <h3>GRAPH DESCRIPTION</h3>
                <ul>
                    <li>Each student starts from the green base line of 50% and work their way up.</li>
                    <li>The blue area represents the marginal percentage improvement this term.</li>
                    <li>The yellow area represents the target they are working towards over a period.</li>
                    <li>Students are expected to have a termly marginal improvement over a period.</li>
                </ul>
            </div>
            <br>
            <!-- Placeholder for KEQ Bar Chart -->
            <div id="keqBarChart"></div>
        </div>

        <!-- Page 2 -->
        <div id="report-page-2">
            <h3>RESULTS ANALYSIS</h3>
            <ul>
                <li><strong>Strength Recognition:</strong> Keep an eye on 8% - 10% marginal improvement. This is one of your ward's strengths. Be aware of this skill especially in challenging situations at home. We will keep working on it.</li>
                <li><strong>Skill Development:</strong> Next keep an eye on 5% - 7% marginal improvement. Your ward has some ability in this skill but with more practice we could get better.</li>
                <li><strong>Developmental Focus:</strong> Now look at 2% - 4% marginal improvement. This skill will take your ward more time to develop and strengthen. The K.I coach will focus more attention to help your ward to develop this skill.</li>
            </ul>

            <h2>Social Emotional Learning Competencies (SEL)</h2>
            <table>
            <tr>
            <th>Metrics</th>
            <?php foreach ($sel_themes as $theme): ?>
                <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>KEQ</td>
            <?php foreach ($sel_themes as $theme): ?>
                <td><?php echo htmlspecialchars($theme['score']); ?></td>
            <?php endforeach; ?>
        </tr>
              <tr>
            <td>SEL</td>
            <?php foreach ($sel_themes as $theme): ?>
                <td><?php echo htmlspecialchars($theme['competency']); ?></td>
            <?php endforeach; ?>
        </tr>   
        
            </table>
            <!-- Placeholder for SEL Pie Chart -->
            <div id="selPieChart"></div>

            <h3>RESULTS ANALYSIS</h3>
            <ul>
                <li><strong>Thematic Exposure:</strong> Each term students explore a minimum of two character development themes related to the five SEL competencies.</li>
                <li><strong>Metric Evaluation:</strong> Internal metrics assess their performance on each competency with a maximum achievable score of 20% for each totaling 100%.</li>
                <li><strong>Focus on Improvement:</strong> The emphasis is on fostering continuous marginal improvement each term rather than solely achieving high scores.</li>
                <li><strong>Understanding Scores:</strong> An SEL score above 15 indicates robust emotional intelligence while a score below 10 signals opportunities for ongoing improvement.</li>
            </ul>
        </div>

        <!-- Page 3 -->
        <div id="report-page-3">
            <h2>Character Strengths (CS)</h2>
            <table>
                <tr>
                    <th>Metrics</th>
                    <?php foreach ($sel_themes as $theme): ?>
                <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td>KEQ</td>
            <?php foreach ($sel_themes as $theme): ?>
                <td><?php echo htmlspecialchars($theme['score']); ?></td>
            <?php endforeach; ?>
        </tr>
              <tr>
            <td>SEL</td>
            <?php foreach ($sel_themes as $theme): ?>
                <td><?php echo htmlspecialchars($theme['character_strength']); ?></td>
            <?php endforeach; ?>
        </tr> 
            </table>
            <!-- Placeholder for CS Bar Chart -->
            <div id="csBarChart"></div>

            <h3>RESULTS ANALYSIS</h3>
            <ul>
                <li>Your child is actively developing their character strengths of Will Heart and Mind aiming for a maximum score of 10 points in each category over time.</li>
                <li>Achieving a score between 8 - 10 signifies high strength in the respective area. Encourage your child to keep honing these strengths as they play a vital role in academic success and overall personal development.</li>
                <li>Scores falling within 5 - 7 indicate a medium level of strength. Your child possesses some ability in these areas and with consistent effort and practice they can further enhance their capabilities.</li>
                <li>A score of 2 – 4 is positive feedback. The K.I coach will provide additional attention to support your child in developing these character strengths more fully. Your engagement and encouragement are crucial during this developmental process.</li>
            </ul>

            <footer>
                <p><strong>Joseph A. Adams</strong> <br><strong>Founder, K.I. Education LLC</strong></p>
                <div class="contact-info">
                    <p class="link"><strong>hi@kiedu.net</strong></p>
                    <p class="ki_number">054 396 1150</p>
                    <p class="ki_link"><strong>www.kiedu.net</strong></p>
                </div>
            </footer>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/results.js"></script>
<script src="assets/js/report.js"></script>
</body>
</html>