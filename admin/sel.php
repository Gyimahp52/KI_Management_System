<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/sel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>SEL THEMES</title>
</head>
<body>
<!--Side bar-->
<?php include_once('includes/side_bar.php');?>

<!--main content space-->
<div class="main-content">
    <?php include_once('includes/header.php');?>

    <div class="stats-grid">
        <!-- SEL Theme Creation Form -->
        <div class="form-container">
            <h2>Create SEL Theme</h2>
            <form id="themeForm">
                <!-- SEL name-->
                <label for="themeName">SEL Theme Name:</label>
                <input type="text" id="themeName" name="themeName" required>

                <!-- Competencies -->
                <label for="competencies">Competencies</label>
                <select id="competencies" name="competencies" required>
                <option value="">--Select Competencies--</option>
                    <option value="1">SEA - Self Awareness</option>
                    <option value="2">RS - Relationship Skills</option>
                    <option value="3">SM - Self Management</option>
                    <option value="4">SA - Social Awareness</option>
                    <option value="5">RDM  - Responsible Decision Making</option>
                </select>

                <!-- Character Strength -->
                <label for="Character Strength">Character Strength</label>
                <select id="Character Strength" name="Character Strength" required>
                <option value="">--Select Character Strength--</option>
                    <option value="1">SH - Strength of Heart</option>
                    <option value="2">SM - Strength of Mind</option>
                    <option value="3">SW - Strength of Will</option>
                    
                </select>
                <!--create sel button -->
                <button type="submit">Create</button>
                <button type="button" id="deleteThemes" class="delete-button" disabled>Delete SEL Theme</button>
            </form>
            <div class="checkbox-group">
                <div id="themeListContainer">
                    <ul id="themeList" class="theme-list">
                        <!-- Created themes will be listed here with checkboxes -->
                    </ul>
                </div>
               
            </div>
        </div>

        <!-- Assign SEL Themes to Schools -->
        <div class="form-container">
            <h2>Assign SEL Themes to Schools</h2>
            <form id="assignForm">
                <label for="academicYear">Select Academic Year:</label>
                <select id="academicYear" name="academicYear" required>
                <option value="">--Select Academic Year--</option>
                    <option value="2023-2024">2023-2024</option>
                    <option value="2024-2025">2024-2025</option>
                    <option value="2025-2026">2025-2026</option>
                    <option value="2026-2027">2026-2027</option>
                    <option value="2027-2028">2027-2028</option>
                </select>

                <label for="schools">Select School:</label>
                <select id="schools" name="schools" required>
                    <!-- Dynamically populated -->
                </select>

                <label for="terms">Select Term:</label>
                <select id="terms" name="terms" required>
                <option value="">--Select Term--</option>
                    <option value="1">Term 1</option>
                    <option value="2">Term 2</option>
                    <option value="3">Term 3</option>
                </select>

                <button type="submit" id="assignButton" disabled>Assign SEL Themes</button>
            </form>
        </div>

        <!-- Assigned SEL Themes Table -->
        <div class="table-container">
            <h2>Assigned SEL Themes</h2>
            <table id="assignedTable">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>School</th>
                        <th>Term</th>
                        <th>SEL Themes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamically populated -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="toast" class="toast">Toast message</div>

<script src="assets/js/sel.js"></script>
</body>
</html>
