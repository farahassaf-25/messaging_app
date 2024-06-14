<?php

include_once "../common/php/authentication.php";

session_start();

// Delete all users if requested
if (isset($_POST['deleteAllUsers'])) {
    $deleteQuery = "DELETE FROM users WHERE type = 0";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "All users deleted successfully.";
    } else {
        echo "Error deleting users: " . $conn->error;
    }
}

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';


$query = "SELECT users.id, users.name, users.email, feedback.feedback_id 
          FROM users 
          LEFT JOIN feedback ON users.id = feedback.user_id
          WHERE users.type = 0";

$sqladmin = "SELECT id, name, email, type FROM users WHERE type = 1";
// $sqlreports = "SELECT report_id, reporter_id, reported_id, reason FROM reports";
$stmt = "SELECT COUNT(*) as total_users FROM users WHERE type = 0";
$stmttotalreports = "SELECT COUNT(*) as total_reports FROM reports";
$stmttotalfeedback = "SELECT COUNT(*) as total_feedback FROM feedback";
$stmtadmins = "SELECT COUNT(*) as total_admins FROM users WHERE type = 1";
$sqlreports = "SELECT report_id, reporter_id, reported_id, report FROM reports";

// Add search criteria if provided
if ($search) {
    $query .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
    $sqladmin .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

// Execute queries
$result = $conn->query($query);
$resultadmin = $conn->query($sqladmin);
$resuser = $conn->query($stmt);
$resadmin = $conn->query($stmtadmins);
$resreports = $conn->query($sqlreports);
$resfeedback = $conn->query($stmttotalfeedback);
$total_users = 0;
$total_admins = 0;
$total_reports = 0;
$total_feedback = 0;

$total_users = $result->num_rows;
$total_reports = $resreports->num_rows;
$total_feedback = $resfeedback->num_rows;

// Fetch totals
if ($resuser) {
    $row = $resuser->fetch_assoc();
    $total_users = $row['total_users'];
}

if ($resadmin) {
    $row = $resadmin->fetch_assoc();
    $total_admins = $row['total_admins'];
}


if ($resreports === FALSE) {
    die("Error executing query: " . $conn->error);
}
