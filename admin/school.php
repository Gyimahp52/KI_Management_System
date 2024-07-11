<?php include('db_config2.php')?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap");

      @media (max-width: 768px) {
        .sidebar {
          width: 80px;
        }
        .sidebar:hover {
          width: 250px;
        }
        .main-content {
          width: calc(100% - 80px);
        }
        .main-content .header {
          width: calc(100% - 80px);
        }
      }
      * {
        margin: 0;
        padding: 0;
        border: none;
        outline: none;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }
      body {
        display: flex;
      }
      .sidebar {
        background-color: #34495e;
        color: white;
        height: 100vh;
        width: 117px;
        position: sticky;
        top: 0;
        left: 0;
        bottom: 0;
        overflow: hidden;
        padding: 0 1.7rem;
        transition: all 0.3s linear;
        background: 113, 99, 186 255;
        z-index: 2;
      }
      .sidebar:hover {
        width: 310px;
        transition: 0.5s;
      }
      .logo {
        position: sticky;
        height: 80px;
        padding: 12px;
      }
      .menu-item {
        border-radius: 20px;
        padding: 15px 12px;
        border-bottom: 1px solid #2c3e50;
        cursor: pointer;
        text-decoration: none;
        color: white;
        display: block;
        position: relative;
        list-style: none;
      }
      .menu-item li {
        padding: 0;
        margin: 1px 0;
        border-radius: 8px;
        transition: all 0.5s ease-in-out;
      }
      .menu-item :hover,
      .active {
        background-color: #2980b9;
        border-radius: 10px;
      }
      .menu-item a {
        font-size: 17px;
        align-items: center;
        text-decoration: none;
        color: white;
        display: flex;
        gap: 1.5rem;
      }
      .menu-item a span {
        overflow: hidden;
      }
      .menu-item a i {
        font-size: 1.2rem;
      }

      .main-content {
        width: calc(100% - 117px);
        padding: 1rem;
        background: #ecf0f1;
        position: relative;
      }
      .main-content .header {
        position: fixed;
        top: 0;
        right: 5;
        width: 76vw;
        height: 10vh;
        background: white;
        display: flex;
        align-items: normal;
        justify-content: normal;
        box-shadow: 0 30px 8px 0 rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 25px;
      }
      .main-content .header .nav {
        width: 100%;
        display: flex;
        align-items: center;
      }
      .main-content .header .nav .search {
        flex: 3;
        display: flex;
        justify-content: center;
      }
      .main-content .header .nav .search i {
        padding: 15px;
        margin-right: 2px;
      }
      .main-content .header .nav .search input[type="text"] {
        border: none;
        background: #f1f1f1;
        padding: 12px;
        width: 400px;
        border-radius: 12px;
        position: sticky;
      }
      .main-content .header .nav img {
        width: 50px;
        height: 50px;
        cursor: pointer;
        border-radius: 50%;
      }
      .container {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 10vh;
        background-color: rgb(216, 212, 200);
      }
      .form-section {
        margin-bottom: 20px;
      }
      .class-list {
        margin-top: 10px;
      }
      .class-list-item {
        margin-bottom: 5px;
      }
      .table-container {
        margin-top: 20px;
      }
      .toast-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
      }
      .landscape-form {
        max-height: 60vh;
        overflow-y: auto;
      }
      .landscape-form .form-row {
        display: flex;
        flex-wrap: nowrap;
      }
      .landscape-form .form-group {
        flex: 1;
        padding: 5px;
      }
    </style>
    <title>School Registration Form</title>
  </head>
  <body>
    <?php include_once('includes/side_bar.php');?>

    <div class="container">
      <h2>School Registration Form</h2>
      <form id="schoolForm" action="db_config2.php" method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="action" value="create_school">
        <input type="hidden" id="editingSchoolId" name="schoolId" />
        <div class="form-row form-section">
          <div class="form-group col-md-3">
            <label for="region">Region</label>
            <select class="form-control" id="region" name="region" required>
              <option value="">Select Region</option>
              <?php
                $regions = ["Bono", "Ashanti", "Greater Accra", "Bono East"];
                foreach ($regions as $region) {
                  echo "<option value=\"$region\">$region</option>";
                }
              ?>
            </select>
            <div class="invalid-feedback">Region is required.</div>
          </div>
          <div class="form-group col-md-3">
            <label for="town">Town</label>
            <input type="text" class="form-control" id="town" name="town" placeholder="Enter Town" required />
            <div class="invalid-feedback">Town is required.</div>
          </div>
          <div class="form-group col-md-3">
            <label for="educator">Educator</label>
            <select class="form-control" id="educator" name="educator" required>
              <option value="">Select Educator</option>
              <?php
                $educators = ["King Luka", "Bright Adjei", "Bridget"];
                foreach ($educators as $educator) {
                  echo "<option value=\"$educator\">$educator</option>";
                }
              ?>
            </select>
            <div class="invalid-feedback">Educator is required.</div>
          </div>
        </div>
        <div class="form-row form-section">
          <div class="form-group col-md-6">
            <label for="schoolName">School Name</label>
            <input type="text" class="form-control" id="schoolName" name="schoolName" placeholder="Enter School Name" required />
            <div class="invalid-feedback">School Name is required.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="schoolLogo">School Logo</label>
            <input type="file" class="form-control-file" id="schoolLogo" name="schoolLogo" />
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Add School</button>
      </form>

      <div id="result" class="mt-4"></div>
      <div class="table-container">
        <h3>School List</h3>
        <table class="table table-striped" id="schoolTable">
          <thead>
            <tr>
              <th>School ID</th>
              <th>Region</th>
              <th>Town</th>
              <th>Educator</th>
              <th>School Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM schools";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['school_id']}</td>
                          <td>{$row['region']}</td>
                          <td>{$row['town']}</td>
                          <td>{$row['educator']}</td>
                          <td>{$row['school_name']}</td>
                          <td>
                            <button class='btn btn-primary btn-sm add-class' data-id='{$row['school_id']}'>Add Class</button>
                            <button class='btn btn-warning btn-sm edit-school' data-id='{$row['school_id']}'>Edit</button>
                            <button class='btn btn-danger btn-sm delete-school' data-id='{$row['school_id']}'>Delete</button>
                          </td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='6'>No schools found</td></tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- <?php //include_once('includes/footer.php');?> -->
    <?php include_once('modal_add_class.php');?>
    <?php include_once('modal_add_student.php');?>

    <script
      src="https://code.jquery.com/jquery-3.5.1.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="js/schoolForm.js"></script>
  </body>
</html>
