<?php
require_once "../../common/php/authentication.php";

$response = array('success' => false, 'message' => '', 'report' => '');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];

        $stmt = $conn->prepare("SELECT reporter_id, report FROM reports WHERE report_id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $stmt->bind_result($reportId, $report);
            if ($stmt->fetch()) {
                $response['success'] = true;
                $response['report'] = $report;
                $response['report_id'] = $reportId;
            } else {
                $response['message'] = 'No report found for this user.';
            }
        } else {
            $response['message'] = 'Error executing SQL query: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'User ID parameter is missing.';
    }

    $conn->close();
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
