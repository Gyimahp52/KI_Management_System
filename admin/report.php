<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System - Reports</title>
    <link rel="stylesheet" href="assets/css/report.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Reports</h1>
           <!-- <div class="filters">
                <select id="schoolSelect">
                    <option value="">Select School</option>
                    <-- Add school options here --
                </select>
                <select id="classSelect">
                    <option value="">Select Class</option>
                    <-- Add class options here --
                </select>
                <select id="termSelect">
                    <option value="">Select Term</option>
                    <option value="1">Term 1</option>
                    <option value="2">Term 2</option>
                    <option value="3">Term 3</option>
                </select>
              <--  <button onclick="exportData('pdf')">Export PDF</button>
                <button onclick="exportData('excel')">Export Excel</button>
                <button onclick="exportData('csv')">Export CSV</button> --
            </div> -->
        </header>

        <section class="summary">
            <div class="card">Total Schools: <span id="totalStudents">10</span></div>
            <div class="card">Total Students: <span id="totalStudents">5000</span></div>
        </section>

        <section class="tabs">
            <button class="tab-button active" onclick="openTab('enterScores')">Enter Scores</button>
            <button class="tab-button" onclick="openTab('generateReports')">View Reports</button>
        </section>

        <div class="tab-content" id="enterScores">
            <h2>Enter Scores</h2>
            <div class="selection-panel">
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

        <div class="tab-content" id="generateReports" style="display: none;">
            <h2>Termly Reports</h2>
            <button onclick="generateReports()">Generate Reports</button>
            <table>
                <thead>
                    <tr>
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
