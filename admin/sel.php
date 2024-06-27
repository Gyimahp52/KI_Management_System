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
                <label for="themeName">SEL Theme Name:</label>
                <input type="text" id="themeName" name="themeName" required>
                <button type="submit">Create SEL Theme</button>
            </form>
        </div>

        <!-- Assign SEL Themes to Schools -->
        <div class="form-container">
            <h2>Assign SEL Themes to Schools</h2>
            <form id="assignForm">
                <label for="schools">Select School:</label>
                <select id="schools" name="schools" required>
                    <!-- Dynamically populated -->
                </select>

                <label for="terms">Select Term:</label>
                <select id="terms" name="terms" required>
                    <option value="1">Term 1</option>
                    <option value="2">Term 2</option>
                    <option value="3">Term 3</option>
                </select>

                <label for="themes">Select SEL Themes:</label>
                <div id="themes" class="checkbox-group">
                    <!-- Dynamically populated -->
                </div>
                
                <button type="submit" id="assignButton" disabled>Assign SEL Themes</button>
                <button type="button" id="deleteThemes" disabled>Delete Selected SEL Themes</button>
            </form>
        </div>

        <!-- Assigned SEL Themes Table -->
        <div class="table-container">
            <h2>Assigned SEL Themes</h2>
            <table id="assignedTable">
                <thead>
                    <tr>
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
