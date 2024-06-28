<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include_once "../../../common/php/authentication.php";
session_start();

if (isset($_POST['userIds']) && is_array($_POST['userIds'])) {
    $userIds = $_POST['userIds'];
    $deletedUsers = [];
    $usersWithFeedback = [];
    $usersWithReports = [];
    $usersReportedByOthers = [];

    foreach ($userIds as $userId) {
        $userId = intval($userId);

        // check for feedback
        $feedbackResult = $conn->query("SELECT COUNT(*) FROM feedback WHERE user_id = $userId");
        $feedbackCount = $feedbackResult->fetch_row()[0];
        if ($feedbackCount > 0) {
            $usersWithFeedback[] = $userId;
            continue;
        }

        // check for reports made by the user
        $reportResult = $conn->query("SELECT COUNT(*) FROM reports WHERE reporter_id = $userId");
        $reportCount = $reportResult->fetch_row()[0];
        if ($reportCount > 0) {
            $usersWithReports[] = $userId;
            continue;
        }

        // check for reports against the user
        $reportedResult = $conn->query("SELECT COUNT(*) FROM reports WHERE reported_id = $userId");
        $reportedCount = $reportedResult->fetch_row()[0];
        if ($reportedCount > 0) {
            $usersReportedByOthers[] = $userId;
            continue;
        }

        // delete the user if no dependencies found
        if ($conn->query("DELETE FROM users WHERE id = $userId") === TRUE) {
            $deletedUsers[] = $userId;
        }
    }

    echo json_encode([
        'success' => true,
        'deletedUsers' => $deletedUsers,
        'issueDetails' => [
            'usersWithFeedback' => $usersWithFeedback,
            'usersWithReports' => $usersWithReports,
            'usersReportedByOthers' => $usersReportedByOthers
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input'
    ]);
}
