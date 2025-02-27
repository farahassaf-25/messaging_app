<?php

require_once "../common/php/authentication.php";

$query = "SELECT users.id, users.name, users.email, feedback.feedback_id 
          FROM users 
          LEFT JOIN feedback ON users.id = feedback.user_id
          WHERE users.type = 0";

$sqladmin = "SELECT id, name, email, type FROM users WHERE type = 1";

$stmt = "SELECT COUNT(*) as total_users FROM users WHERE type = 0";
$stmttotalreports = "SELECT COUNT(*) as total_reports FROM reports";
$stmtadmins = "SELECT COUNT(*) as total_admins FROM users WHERE type = 1";
$sqlreports = "SELECT report_id, reporter_id, reported_id, report FROM reports";

$stmttotalfeedback = "SELECT COUNT(*) as total_feedback FROM feedback";
$resfeedback = $conn->query($stmttotalfeedback);

$result = $conn->query($query);
$resultadmin = $conn->query($sqladmin);
$resuser = $conn->query($stmt);
$resadmin = $conn->query($stmtadmins);
$resreports = $conn->query($sqlreports);

$total_users = 0;
$total_admins = 0;
$total_reports = 0;
$total_feedback = 0;

$total_users = $result->num_rows;
$total_reports = $resreports->num_rows;
$total_feedback = $resfeedback->num_rows;

// fetch totals
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

if ($resfeedback) {
    $row = $resfeedback->fetch_assoc();
    $total_feedback = $row['total_feedback'];
} else {
    die("Error executing query: " . $conn->error);
}
