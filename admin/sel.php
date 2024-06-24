<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <link rel="stylesheet" href="/admin/SEL_Themes/sel.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <title>SEL THEMES</title>
    </head>
<body>
    
<!--Side bar-->
<div class="sidebar">
    <!--logo on sidebar-->
    <img src="/images/ki_logo.png" alt="Logo" class="logo">

   <!--Dashboard button-->
    <ul class="menu-item ">
        <li >
            <a href="/admin/adminDashboard.html">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <!--Educators button-->
    <ul class="menu-item ">
        <li >
            <a href="/admin/educator/educators.html">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Educators</span>
            </a>
        </li>
    </ul>

     <!--SEL Themes button-->
     <ul class="menu-item ">
        <li class="active">
            <a href="/admin/SEL Themes/sel.html">
                <i class="fas fa-book"></i>
                <span>SEL Themes</span>
            </a>
        </li>
    </ul>

     <!--Schools button-->
     <ul class="menu-item ">
        <li >
            <a href="/admin/school/school.html">
                <i class="fas fa-school"></i>
                <span>Schools</span>
            </a>
        </li>
    </ul>

     <!--Students button-->
     <ul class="menu-item ">
        <li class="active">
            <a href="/admin/student/student.html">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>
        </li>
    </ul>

     <!--Reports button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/report/report.html">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>

     <!--Assign role button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/manage user/manageUser.html">
                <i class="fas fa-user-cog"></i>
                <span>Assign Role</span>
            </a>
        </li>
    </ul>

     <!--Reports button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/settings/settings.html">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

     <!--Logout button-->
     <ul class="menu-item ">
        <li>
            <a href="/login/login.html">
                <i class="fas fa-sign-out-alt"></i>
                <span>Log Out</span>
            </a>
        </li>
    </ul>
      
</div>

<!--main content space-->
<div class="main-content">
    <div class="header">
        <div class="nav">
           
            <span>Admin</span>
            <h2>Dashboard</h2>
            
            <!--search bar-->
            <div class="search">
                <i class="fa-solid fa-search"></i>
                
                    <input type="text"  placeholder="Search...">
         
            </div>

           <!--admin profile picture-->
            <img src="/images/user.png" alt="Admin"/>

            
        </div>
    </div>

   
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

        



<script src="/admin/SEL Themes/sel.js"></script>

</body>
</html>
