<?php include_once 'php/admin_dashboard.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../common/styles/global.css">
    <link rel="stylesheet" href="styles/adminDashboard.css">
    <link rel="stylesheet" href="styles/dark_mode.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="container-fluid p-3">
        <div class="row">
            <!-- sidebar  -->
            <nav class="col-md-2 sidebar d-none">
                <div class="logo text-center">
                    <svg class="logo-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4800 4800" width="80px" height="80px">
                        <g fill="none" stroke="white" stroke-width="200">
                            <path d="M1350 3937a1693 1693 0 0 0 1050 363c396.3 0 761 -135.6 1050 -363M1900 974.7C1205.1 1188.2 700 1835.1 700 2600c0 192.5 32 377.5 91 550M2900 974.7c694.9 213.5 1200 860.4 1200 1625.3 0 192.5 -32 377.5 -91 550" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4300 3600c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 4300 3600m-2800 0c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 1500 3600m1400 -2700c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 2900 900" />
                        </g>
                    </svg>
                    <h1 class="nav-item text-white h3 mt-2">ConvoConnect</h1>
                    <p class="text-white">Admin Mode</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="#usersTab" data-bs-toggle="tab"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reportsTab" data-bs-toggle="tab"><i class="fas fa-chart-bar"></i> Reports</a>
                    </li>

                    <li class="nav-item mt-4">
                        <a href="#" class="nav-link theme-toggle"><i class="fas fa-solid fa-lightbulb"></i> Switch Mode</a>
                    </li>
                    <li class="nav-item admin-details">
                        <a href="#adminTab" class="nav-link" data-bs-toggle="tab">
                            <img class="rounded-circle" src="../assets/defaultProfile.webp" alt="Admin" width="40">
                            <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin Name'; ?>
                        </a>
                    </li>
                    <li class="nav-item logout">
                        <a class="btn nav-link text-white d-flex align-items-center" href="logout.php"><i class="fas fa-arrow-right me-2"></i> Logout</a>
                    </li>
                </ul>
            </nav>

            <nav class="col-md-2 d-none d-md-block sidebar-alt">
                <div class="logo text-center py-4">
                    <svg class="logo-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4800 4800" width="60px" height="60px">
                        <g fill="none" stroke="white" stroke-width="200">
                            <path d="M1350 3937a1693 1693 0 0 0 1050 363c396.3 0 761 -135.6 1050 -363M1900 974.7C1205.1 1188.2 700 1835.1 700 2600c0 192.5 32 377.5 91 550M2900 974.7c694.9 213.5 1200 860.4 1200 1625.3 0 192.5 -32 377.5 -91 550" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4300 3600c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 4300 3600m-2800 0c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 1500 3600m1400 -2700c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 2900 900" />
                        </g>
                    </svg>
                </div>
                <ul class="nav flex-column flex-grow-1 d-flex align-items-center justify-content-center">
                    <li class="nav-item mb-3">
                        <a class="nav-link active" href="#usersTab" data-bs-toggle="tab">
                            <i class="fas fa-users"></i>
                            <span class="nav-text">Users</span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link" href="#reportsTab" data-bs-toggle="tab">
                            <i class="fas fa-chart-bar"></i>
                            <span class="nav-text">Reports</span>
                        </a>
                    </li>
                    <li class="nav-item mt-4 theme-toggle">
                        <a href="#" class="nav-link theme-toggle-sidebar-alt"><i class="fas fa-solid fa-lightbulb"></i>
                            <span class="nav-text">Switch Mode</span>
                        </a>
                    </li>
                    <li class="nav-item admin-details">
                        <a href="#adminTab" class="nav-link" data-bs-toggle="tab">
                            <img class="rounded-circle" src="../assets/defaultProfile.webp" alt="Admin" width="40">
                            <span class="nav-text"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin Name'; ?></span>
                        </a>
                    </li>
                    <li class="nav-item logout">
                        <a class="btn nav-link text-white d-flex align-items-center" href="logout.php"><i class="fas fa-arrow-right me-2"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- bottom sidebar  -->
            <nav class="navbar sidebar-bottom fixed-bottom d-md-none" style="z-index: 10;">
                <div class="container justify-content-around">
                    <svg class="logo-img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4800 4800" width="40px" height="40px">
                        <g fill="none" stroke="white" stroke-width="200">
                            <path d="M1350 3937a1693 1693 0 0 0 1050 363c396.3 0 761 -135.6 1050 -363M1900 974.7C1205.1 1188.2 700 1835.1 700 2600c0 192.5 32 377.5 91 550M2900 974.7c694.9 213.5 1200 860.4 1200 1625.3 0 192.5 -32 377.5 -91 550" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4300 3600c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 4300 3600m-2800 0c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 1500 3600m1400 -2700c0 134.2 -52.8 256 -138.8 345.8A500 500 0 1 1 2900 900" />
                        </g>
                    </svg>
                    <a href="#usersTab" class="nav-link active" data-bs-toggle="tab"><i class="fas fa-users"></i></a>
                    <a href="#reportsTab" class="nav-link" data-bs-toggle="tab"><i class="fas fa-chart-bar"></i></a>
                    <a href="#" class="nav-link theme-toggle"><i class="fas fa-solid fa-lightbulb"></i></a>
                    <a href="#adminTab" class="nav-link" data-bs-toggle="tab"><img src="../assets/defaultProfile.webp" class="rounded-circle" width="30" alt="Admin"></a>
                    <a class="nav-link" href="logout.php"><i class="fas fa-arrow-right"></i></a>
                </div>
            </nav>

            <!-- tab content -->
            <div class="col-md-10 tab-content main-content">
                <!-- users tab  -->
                <div id="usersTab" class="tab-pane fade show active">
                    <div class="container">
                        <header class="header d-flex justify-content-center align-items-center">
                            <div class="input-group">
                                <form action="" method="GET" class="w-100">
                                    <input class="form-control border rounded-pill" type="search" name="search" placeholder="Search User" id="searchInput">
                                </form>
                            </div>
                        </header>
                        <hr class="d-none d-md-block">

                        <div class="charts mb-3 d-flex align-items-center justify-content-between">
                            <div class="chart-container bg-primary text-center p-3 rounded">
                                <h4 class="text-white h5">Total Users</h4>
                                <h2 class="text-white h3"><?php echo $total_users; ?></h2>
                            </div>
                            <div class="chart-container bg-danger text-center p-3 rounded">
                                <h4 class="text-white h5">Total Feedback</h4>
                                <h2 class="text-white h3"><?php echo $total_feedback; ?></h2>
                            </div>
                        </div>

                        <section class="user-management">
                            <div class="table-scroll">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id=""></th>
                                            <th>User Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Update</th>
                                            <th>Feedback</th>
                                            <th>Delete User</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $feedbackExists = !is_null($row['feedback_id']);
                                                $buttonClass = $feedbackExists ? 'btn-secondary' : 'btn-secondary opacity-50';
                                                echo "<tr>";
                                                echo "<td><input type='checkbox' name='' id=''></td>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>" . $row['email'] . "</td>";
                                                echo "<td><button class='btn btn-success btn-sm editUserBtn' data-bs-toggle='modal' data-bs-target='#editUserModal' data-user-id='" . $row['id'] . "' data-username='" . $row['name'] . "' data-email='" . $row['email'] . "'>Update</button></td>";
                                                echo "<td><button class='btn btn-sm viewFeedbackBtn " . $buttonClass . "' data-bs-toggle='modal' data-bs-target='#viewFeedbackModal' data-user-id='" . $row['id'] . "'>View</button></td>";
                                                echo "<td><button class='btn btn-danger btn-sm deleteUserBtn' data-user-id='" . $row['id'] . "' data-bs-toggle='modal' data-bs-target='#deleteConfirmationUserModal'>Delete</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No users found</td></tr>";
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                            <button id="deleteAllUsersBtn" class="btn btn-danger mt-2 float-end" data-bs-toggle="modal" data-bs-target="#deleteAllUsers">Delete All</button>
                        </section>
                    </div>
                </div>

                <!-- reports tab  -->
                <div id="reportsTab" class="tab-pane fade">
                    <div class="container">
                        <header class="header d-flex justify-content-center align-items-center">
                            <div class="input-group">
                                <form action="" method="GET" class="w-100">
                                    <input class="form-control border rounded-pill" type="search" name="search" placeholder="Search Report by Id" id="searchInput">
                                </form>
                            </div>
                        </header>
                        <hr class="d-none d-md-block">

                        <div class="charts mb-3 d-flex align-items-center justify-content-around">
                            <div class="chart-container bg-warning text-center p-3 rounded">
                                <h4 class="text-white h5">Total Reports</h4>
                                <h2 class="text-white h3"><?php echo $total_reports; ?></h2>
                            </div>
                        </div>

                        <section class="user-management">
                            <div class="table-scroll">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id=""></th>
                                            <th>Id</th>
                                            <th>Reporter Id</th>
                                            <th>Reported Id</th>
                                            <th>View Report</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportsTableBody">
                                        <?php
                                        if ($total_reports > 0) {
                                            while ($row = $resreports->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td><input type='checkbox' name='' id=''></td>";
                                                echo "<td>" . $row['report_id'] . "</td>";
                                                echo "<td>" . $row['reporter_id'] . "</td>";
                                                echo "<td>" . $row['reported_id'] . "</td>";
                                                echo "<td><button class='btn btn-secondary btn-sm viewReportBtn' data-bs-toggle='modal' data-bs-target='#viewReportModal' data-report-id='" . $row['report_id'] . "'>View</button></td>";
                                                echo "<td><button class='btn btn-danger btn-sm deleteReportBtn' data-report-id='" . $row['report_id'] . "'>Delete</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No Reports found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <button id="deleteAllUsersBtn" class="btn btn-danger mt-2 float-end" data-bs-toggle="modal" data-bs-target="#deleteAllUsers">Delete All</button>
                        </section>
                    </div>
                </div>


                <!-- admin tab -->
                <div id="adminTab" class="tab-pane fade">
                    <div class="container">
                        <header class="header d-flex justify-content-between align-items-center">
                            <div class="input-group">
                                <input class="form-control border rounded-pill" type="search" placeholder="Search User" id="search-input">
                            </div>
                            <button id="addAdminBtn" class="btn btn-primary custom-btn-padding" data-bs-toggle="modal" data-bs-target="#addAdmin">Add Admin</button>
                        </header>
                        <hr class="d-none d-md-block">

                        <div class="charts mb-3 d-flex align-items-center justify-content-around">
                            <div class="chart-container bg-dark text-center p-3 rounded">
                                <h4 class="text-white h5">Total Admins</h4>
                                <h2 class="text-white h3"><?php echo $total_admins; ?></h2>
                            </div>
                        </div>

                        <section class="user-management">
                            <div class="table-scroll">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id=""></th>
                                            <th>Admin Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Update</th>
                                            <th>Delete Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        <?php
                                        if ($resultadmin->num_rows > 0) {
                                            while ($row = $resultadmin->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td><input type='checkbox' name='' id=''></td>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td>" . $row['email'] . "</td>";
                                                echo "<td><button id='editAdminBtn' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#editAdminModal'>Update</button></td>";
                                                echo "<td><button class='btn btn-danger btn-sm'>Delete</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No admins found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- View Feedback Modal -->
    <div class="modal fade" id="viewFeedbackModal" tabindex="-1" aria-labelledby="viewFeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewFeedbackModalLabel">View Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="feedbackContent">Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="deleteFeedbackBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Report Modal -->
    <div class="modal fade" id="viewReportModal" tabindex="-1" aria-labelledby="viewReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReportModalLabel">Report Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="reportReason">Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this report?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationUserModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmUserDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Edit User Modal  -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="mb-3">
                            <label for="editUserUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUserUsername">
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editUserEmail">
                        </div>
                        <div class="mb-3">
                            <label for="editUserStatus" class="form-label">Status</label>
                            <select class="form-select" id="editUserStatus">
                                <option value="active">User</option>
                                <option value="inactive">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                    <button type="button" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete All Users Modal -->
    <div class="modal fade" id="deleteAllUsers" tabindex="-1" aria-labelledby="deleteAllUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAllUsersModalLabel">Delete All Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete all users?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="dashboard.php">
                        <input type="hidden" name="checkUsers" value="1">
                        <button type="submit" class="btn btn-danger" name="deleteAllUsers">Delete All</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="usersWithReportsFeedbackModal" tabindex="-1" aria-labelledby="usersWithReportsFeedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersWithReportsFeedbackModalLabel">Users with Reports or Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Some users have reports or feedback.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Add Admin Modal  -->
    <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="type" class="form-label">type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Add Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="scripts/adminDashboard.js"></script>
    <script src="scripts/updateUser.js"></script>
    <script src="scripts/userManagement.js"></script>
    <script src="scripts/switch_mode.js"></script>

    <script>
        $(document).ready(function() {
            $('#deleteAllUsersBtn').click(function() {
                // Check if there are users with reports or feedback
                var usersWithReportsFeedback = <?php echo $usersWithReportsFeedback ? 'true' : 'false'; ?>;
                if (usersWithReportsFeedback) {
                    $('#deleteAllUsersModal').modal('show');
                } else {
                    // Show alert or take appropriate action if no users with reports or feedback
                    alert('No users with reports or feedback found.');
                }
            });
        });
    </script>

</body>

</html>