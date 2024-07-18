<?php include('includes/dbconnection.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System - Reports</title>
    <!-- Links -->
    <link rel="stylesheet" href="assets/css/report.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
</head>
<body>
<!-- side bar -->
<?php include_once('includes/side_bar.php');?>

<div class="main-container">
    <header>
        <h1>Progress Reports</h1>
    </header>

    <section class="summary">
    <?php 
                        
                        $sql1 ="SELECT * from  schools";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $totschools=$query1->rowCount();
                        ?>
        <div class="card">Total Schools: <span id="totalSchools"><?php echo htmlentities($totschools);?></span></div>
        <?php 
                        
                        $sql1 ="SELECT * from  students";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $toteducators=$query1->rowCount();
                        ?>
        <div class="card">Total Students: <span id="totalStudents"><?php echo htmlentities($toteducators);?></span></div>
    </section>

    <section class="tabs">
        <button class="tab-button active" onclick="openTab('enterScores')">Enter Scores</button>
        <button class="tab-button" onclick="openTab('generateReports')">View Reports</button>
    </section>

    <div class="tab-content active" id="enterScores">
        <h2>Enter Scores</h2>
        <div class="selection-panel">
            <!--<div class="dropdown-container">
                <label for="academicYear">Select Academic Year:</label>
                <select id="academicYear" class="dropdown">
                    <option value="">--Select Academic Year--</option>
                    <option value="2023">2023-2024</option>
                    <option value="2024">2024-2025</option>
                    <option value="2025">2025-2026</option>
                    <option value="2026">2026-2027</option>
                    <option value="2027">2027-2028</option>
                </select>
            </div>-->
            <div class="dropdown-container">
                <label for="school">Select School:</label>
                <select id="school" class="dropdown">
                    <option value="">--Select School--</option>
                    <!-- Add school options dynamically -->
                </select>
            </div>
            <div class="dropdown-container">
                <label for="class">Select Class:</label>
                <select id="class" class="dropdown">
                    <option value="">--Select Class--</option>
                    <!-- Add class options dynamically -->
                </select>
            </div>
            <div class="dropdown-container">
                <label for="term">Select Term:</label>
                <select id="term" class="dropdown">
                    <option value="">--Select Term--</option>
                    <option value="1">Term 1</option>
                    <option value="2">Term 2</option>
                    <option value="3">Term 3</option>
                </select>
            </div>
        </div>
        <div class="students-list" id="students-list">
            <!-- Students and score fields will be populated here -->
        </div>
        <div class="report-actions">
            <button id="save-scores" class="button">Save Scores</button>
        </div>
    </div>

    <div class="tab-content" id="generateReports">
        <h2>Termly Reports</h2>
        <div class="selection-panel">
            <div class="dropdown-container">
                <label for="reportAcademicYear">Select Academic Year:</label>
                <select id="reportAcademicYear" class="dropdown">
                    <option value="">--Select Academic Year--</option>
                    <option value="2023">2023-2024</option>
                    <option value="2024">2024-2025</option>
                    <option value="2025">2025-2026</option>
                    <option value="2026">2026-2027</option>
                    <option value="2027">2027-2028</option>
                </select>
            </div>
            <div class="dropdown-container">
                <label for="reportSchool">Select School:</label>
                <select id="reportSchool" class="dropdown">
                    <option value="">--Select School--</option>
                    <!-- Add school options dynamically -->
                </select>
            </div>
            <div class="dropdown-container">
                <label for="reportClass">Select Class:</label>
                <select id="reportClass" class="dropdown">
                    <option value="">--Select Class--</option>
                    <!-- Add class options dynamically -->
                </select>
            </div>
            <div class="dropdown-container">
                <label for="reportTerm">Select Term:</label>
                <select id="reportTerm" class="dropdown">
                    <option value="">--Select Term--</option>
                    <option value="1">Term 1</option>
                    <option value="2">Term 2</option>
                    <option value="3">Term 3</option>
                </select>
            </div>
            <button id="loadReports" class="btn-load-report">Load</button>
        </div>
        <button id="downloadSelectedReports" class="button">Download Selected Reports</button>
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Term</th>
                    <th>Report</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentList">
                <!-- Student list will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Report view container (initially hidden) -->
<div id="report-view" class="modal">
    <div class="report-container">
        <button class="close-btn" onclick="closeReport()"><strong>X</strong></button>
        <div class="faded-text"><strong>KI EDUCATION</strong></div>
        <h1><u>KIE STUDENT PROGRESS REPORT</u></h1>
        <p> Kinesthetic Intelligence Education personal progress report for <strong> <span id="student-name"></span></strong> at <span id="student-school"></span>. This term we practiced eleven soft skills for character development. The focus is not on the marks we emphasize on marginal improvement over time and creating cognizance of these strengths for students.</p>
        
        <div class="container">
            <div class="left-side">
              <h2>Personal Information</h2>
              <p><strong>Name:</strong> <span id="student-name-info"></span></p>
              <p><strong>Age:</strong> 2 YEARS</p>
              <p><strong>School:</strong> <span id="student-school-info"></span></p>
              <p><strong>Class:</strong> <span id="student-class-info"></span></p>
              <p><strong>Height:</strong></p>
              <p><strong>Weight:</strong></p>
            </div>
            
            <div class="right-side">
              <p><strong>Foot:</strong> RIGHT FOOT DOMINANT</p>
              <p><strong>Hand:</strong> RIGHT-HANDED</p>
              <p><strong>Eyesight:</strong> NORMAL</p>
              <p><strong>Heart Rate:</strong> NOT AVAILABLE</p>
              <p><strong>Medical Condition:</strong> NOT AVAILABLE</p>
            </div>
          </div>

        <section class="data-tables">
            <h2>1. Student KEQ Field Data</h2>
            <table>
                <tr>
                    <th>Metrics</th>
                    <th>Dec. Ma.</th>
                    <th>Teamwk.</th>
                    <th>Deter.</th>
                    <th>Pro. Sol.</th>
                    <th>No Fail.</th>
                    <th>Curiou.</th>
                    <th>Optim.</th>
                    <th>Self-Con.</th>
                    <th>Hone.</th>
                    <th>Exper.</th>
                    <th>Kindne.</th>
                </tr>
                <tr>
                    <td>KEQ</td>
                    <td id="keq-1">8</td>
                    <td id="keq-2">9</td>
                    <td id="keq-3">9</td>
                    <td id="keq-4">4</td>
                    <td id="keq-5">8</td>
                    <td id="keq-6">5</td>
                    <td id="keq-7">7</td>
                    <td id="keq-8">9</td>
                    <td id="keq-9">9</td>
                    <td id="keq-10">5</td>
                    <td id="keq-11">7</td>
                </tr>
            </table>
        </section>

        <section class="graphs">
            <div class="graph-description">
                <h3>GRAPH DESCRIPTION</h3>
                <ul>
                    <li>Each student starts from the green base line of 50% and work their way up.</li>
                    <li>The blue area represents the marginal percentage improvement this term.</li>
                    <li>The yellow area represents the target they are working towards over a period.</li>
                    <li>Students are expected to have a termly marginal improvement over a period.</li>
                </ul>
            </div><br>

            <canvas id="keqBarChart"></canvas>
        
            <h3>RESULTS ANALYSIS</h3>
            <ul>
                <li><strong>Strength Recognition:</strong>  Keep an eye on 8% - 10% marginal improvement. This is one of your ward’s strengths. Be aware of this skill especially in challenging situations at home. We will keep working on it.</li>
                <li><strong>Skill Development:</strong>  Next keep an eye on 5% - 7% marginal improvement. Your ward has some ability in this skill but with more practice we could get better.</li>
                <li><strong>Developmental Focus:</strong>  Now look at 2% - 4% marginal improvement. This skill will take your ward more time to develop and strengthen. The K.I coach will focus more attention to help your ward to develop this skill.</li>
            </ul>

            <h2>Social Emotional Learning Competencies (SEL)</h2>
            <table>
                <tr>
                    <th>Metrics</th>
                    <th>Dec. Ma.</th>
                    <th>Teamwk.</th>
                    <th>Deter.</th>
                    <th>Pro. Sol.</th>
                    <th>No Fail.</th>
                    <th>Curiou.</th>
                    <th>Optim.</th>
                    <th>Self-Con.</th>
                    <th>Hone.</th>
                    <th>Exper.</s</th>
                    <th>Kindne.</th>
                </tr>
                <tr>
                    <td>KEQ</td>
                    <td>8</td>
                    <td>9</td>
                    <td>9</td>
                    <td>4</td>
                    <td>8</td>
                    <td>5</td>
                    <td>7</td>
                    <td>9</td>
                    <td>9</td>
                    <td>5</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>SEL</td>
                    <td>RDM</td>
                    <td>RS</td>
                    <td>SM</td>
                    <td>RDM</td>
                    <td>SEA</td>
                    <td>SM</td>
                    <td>SM</td>
                    <td>SEA</td>
                    <td>SOA</td>
                    <td>RS</td>
                    <td>SOA</td>
                </tr>
            </table>
            <canvas id="selPieChart"></canvas>

            <h3>RESULTS ANALYSIS</h3>
            <ul>
                <li><strong>Thematic Exposure:</strong>  Each term students explore a minimum of two character development themes related to the five SEL competencies.</li>
                <li><strong>Metric Evaluation:</strong>  Internal metrics assess their performance on each competency with a maximum achievable score of 20% for each totaling 100%.</li>
                <li><strong>Focus on Improvement:</strong>  The emphasis is on fostering continuous marginal improvement each term rather than solely achieving high scores.</li>
                <li><strong>Understanding Scores:</strong>  An SEL score above 15 indicates robust emotional intelligence while a score below 10 signals opportunities for ongoing improvement.</li>
            </ul>

            <h2>Character Strengths (CS)</h2>
            <table>
                <tr>
                    <th>Metrics</th>
                    <th>Dec. Ma.</th>
                    <th>Teamwk.</th>
                    <th>Deter.</th>
                    <th>Pro. Sol.</th>
                    <th>No Fail.</th>
                    <th>Curiou.</th>
                    <th>Optim.</th>
                    <th>Self-Con.</th>
                    <th>Hone.</th>
                    <th>Exper.</th>
                    <th>Kindne.</th>
                </tr>
                <tr>
                    <td>KEQ</td>
                    <td>8</td>
                    <td>9</td>
                    <td>9</td>
                    <td>4</td>
                    <td>8</td>
                    <td>5</td>
                    <td>7</td>
                    <td>9</td>
                    <td>9</td>
                    <td>5</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>CS</td>
                    <td>SM</td>
                    <td>SH</td>
                    <td>SW</td>
                    <td>SM</td>
                    <td>SW</td>
                    <td>SM</td>
                    <td>SM</td>
                    <td>SW</td>
                    <td>SH</td>
                    <td>SM</td>
                    <td>SH</td>
                </tr>
            </table>
            <canvas id="csBarChart"></canvas>

            <h3>RESULTS ANALYSIS</h3>
            <ul>
                <li>Your child is actively developing their character strengths of Will Heart and Mind aiming for a maximum score of 10 points in each category over time.</li>
                <li>Achieving a score between 8 - 10 signifies high strength in the respective area. Encourage your child to keep honing these strengths as they play a vital role in academic success and overall personal development.</li>
                <li>Scores falling within 5 - 7 indicate a medium level of strength. Your child possesses some ability in these areas and with consistent effort and practice they can further enhance their capabilities.</li>
                <li>A score of 2 – 4 is positive feedback. The K.I coach will provide additional attention to support your child in developing these character strengths more fully. Your engagement and encouragement are crucial during this developmental process.</li>
            </ul>
        </section>

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="assets/js/report.js"></script>
<script src="assets/js/results.js"></script>
</body>
</html>
