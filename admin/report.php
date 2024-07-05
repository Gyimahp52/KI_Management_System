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
   
</head>
<body>
<!-- side bar -->
<?php include_once('includes/side_bar.php');?>

<div class="container">
    <header>
        <h1>Progress Reports</h1>
    </header>

    <section class="summary">
        <div class="card">Total Schools: <span id="totalSchools">10</span></div>
        <div class="card">Total Students: <span id="totalStudents">5000</span></div>
    </section>

    <section class="tabs">
        <button class="tab-button active" onclick="openTab('enterScores')">Enter Scores</button>
        <button class="tab-button" onclick="openTab('generateReports')">View Reports</button>
    </section>

    <div class="tab-content active" id="enterScores">
        <h2>Enter Scores</h2>
        <div class="selection-panel">
            <div class="dropdown-container">
                <label for="academicYear">Select Academic Year:</label>
                <select id="academicYear" class="dropdown">
                    <option value="">--Select Academic Year--</option>
                    <option value="2023">2023-2024</option>
                    <option value="2024">2024-2025</option>
                    <option value="2025">2025-2026</option>
                    <option value="2026">2026-2027</option>
                    <option value="2027">2027-2028</option>
                </select>
            </div>
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
            <button id="loadReports" class="btn-load-report">Load Reports</button>
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
<script src="assets/js/report.js"></script>
</body>
</html>
