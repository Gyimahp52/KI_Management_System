<!--Side bar-->
<div class="sidebar">
    <!--logo on sidebar-->
    <img src="<?php echo $base_url; ?>images/ki_logo.png" alt="Logo" class="logo">

   <!--Dashboard button-->
    <ul class="menu-item ">
        <li >
            <a href="<?php echo $base_url; ?>admin/adminDashboard.html">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
    </ul>

    <!--Educators button-->
    <ul class="menu-item ">
        <li class="active">
            <a href="/admin/educator/educators.html">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Educators</span>
            </a>
        </li>
    </ul>

     <!--SEL Themes button-->
     <ul class="menu-item ">
        <li>
            <a href="#">
                <i class="fas fa-book"></i>
                <span>SEL Themes</span>
            </a>
        </li>
    </ul>

     <!--Schools button-->
     <ul class="menu-item ">
        <li>
            <a href="/admin/school/school.html">
                <i class="fas fa-school"></i>
                <span>Schools</span>
            </a>
        </li>
    </ul>

     <!--Students button-->
     <ul class="menu-item ">
        <li>
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
