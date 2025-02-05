<?php
require 'includes/dbconnection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="assets/css/adminDashboard.css">

    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/images/site.webmanifest">
    <style>
        .main-content-m2{
            display: flex;
            row-gap: 80px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-left: 200px;
        }
        .container{
            width: 500px;
        }
    </style>
</head>
<body>
    <?php include_once('includes/side_bar.php');?>
    <div class="main-content-m2">
    <div class="search-header"><?php include_once('includes/header.php');?></div>


    <div class="container mt-5">
        <h2 class="mb-4">Create User</h2>
        <form id="createUserForm" onsubmit="createUser(event)">
            <div class="row g-3">
                <!-- <div class="col-md-6">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div> -->
                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="col-md-6">
                    <select name="role" class="form-select" required>
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="educator">Educator</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="gender" placeholder="Gender">
                </div>
                <div class="col-md-6">
                    <input type="tel" class="form-control" name="phone_number" placeholder="Phone Number">
                </div>
                <div class="col-md-6">
                    <input type="tel" class="form-control" name="emergency_contact" placeholder="Emergency Contact">
                </div>
                <div class="col-md-6">
                    <input type="date" class="form-control" name="dob" placeholder="Date of Birth">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="location" placeholder="Location">
                </div>
                <div class="col-12">
                    <label for="profile_pic" class="form-label">Profile Picture</label>
                    <input type="file" class="form-control" name="profile_pic" accept="image/*">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </div>
        </form>

        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- User data will be populated here -->
            </tbody>
        </table>
                <!-- Pagination -->
                <nav aria-label="User list pagination">
            <ul class="pagination" id="pagination">
                <!-- Pagination links will be populated here -->
            </ul>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000"
    };

    function createUser(event) {
        event.preventDefault();
        var formData = new FormData(event.target);
        formData.append('action', 'createUser');
        
        $.ajax({
            url: 'ajax_handlers.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#createUserForm')[0].reset();
                } else {
                    toastr.error(response.message || 'An error occurred while creating user');
                }
            },
            error: function() {
                toastr.error('An error occurred while processing the request');
            }
        });
    }

    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: 'ajax_handlers.php',
                type: 'POST',
                data: {
                    action: 'deleteUser',
                    userId: userId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Remove user from UI or refresh user list
                    } else {
                        toastr.error(response.message || 'An error occurred while deleting user');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while processing the request');
                }
            });
        }
    }


    function updateLastActivity() {
    $.ajax({
        url: 'ajax_handlers.php',
        type: 'POST',
        data: {
            action: 'updateLastActivity'
        },
        dataType: 'json'
    });
}

// Update last activity every 5 minutes
setInterval(updateLastActivity, 5 * 60 * 1000);

    $(document).ready(function() {
        let currentPage = 1;

        function loadUsers(page) {
            $.ajax({
                url: 'ajax_handlers.php',
                type: 'GET',
                data: {
                    action: 'getUsers',
                    page: page
                },
                dataType: 'json',
                success: function(response) {
                    displayUsers(response.users);
                    displayPagination(response.pages, page);
                },
                error: function() {
                    toastr.error('Failed to load users');
                }
            });
        }

        function displayUsers(users) {
            const tableBody = $('#userTable tbody');
            tableBody.empty();

            users.forEach(user => {
                const isOnline = isUserOnline(user.last_activity);
                const row = `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>
                            <select class="form-select role-select" data-user-id="${user.id}">
                                <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                                <option value="educator" ${user.role === 'educator' ? 'selected' : ''}>Educator</option>
                                <option value="student" ${user.role === 'student' ? 'selected' : ''}>Student</option>
                            </select>
                        </td>
                        <td>${isOnline ? '<span class="badge bg-success">Online</span>' : '<span class="badge bg-secondary">Offline</span>'}</td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-user" data-user-id="${user.id}">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }

        function displayPagination(totalPages, currentPage) {
            const pagination = $('#pagination');
            pagination.empty();

            for (let i = 1; i <= totalPages; i++) {
                const li = $('<li>').addClass('page-item').toggleClass('active', i === currentPage);
                const a = $('<a>').addClass('page-link').text(i).attr('href', '#').data('page', i);
                li.append(a);
                pagination.append(li);
            }
        }

        function isUserOnline(lastActivity) {
            if (!lastActivity) return false;
            const lastActiveTime = new Date(lastActivity).getTime();
            const currentTime = new Date().getTime();
            const fiveMinutes = 5 * 60 * 1000; // 5 minutes in milliseconds
            return (currentTime - lastActiveTime) < fiveMinutes;
        }

        $(document).on('change', '.role-select', function() {
            const userId = $(this).data('user-id');
            const newRole = $(this).val();

            $.ajax({
                url: 'ajax_handlers.php',
                type: 'POST',
                data: {
                    action: 'updateRole',
                    userId: userId,
                    newRole: newRole
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success('User role updated successfully');
                    } else {
                        toastr.error('Failed to update user role');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while updating user role');
                }
            });
        });

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            currentPage = $(this).data('page');
            loadUsers(currentPage);
        });

        // Initial load
        loadUsers(currentPage);
    });
    </script>
</body>
</html>