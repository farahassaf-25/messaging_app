<?php
include_once "../../common/php/authentication.php";

// Get report ID from POST data
$reportId = $_POST['reportId'];

// Check if reportId is valid
if (!$reportId) {
    echo json_encode(array('success' => false, 'message' => 'Invalid report ID.'));
    exit;
}

// Prepare the DELETE query
$sql = "DELETE FROM reports WHERE report_id = ?";

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $reportId);

    if ($stmt->execute()) {
        $response = array('success' => true, 'deletedReportId' => $reportId); // Include deleted report ID (optional)
    } else {
        $response = array('success' => false, 'message' => 'Failed to delete report: ' . $stmt->error);
    }
    $stmt->close();
} else {
    $response = array('success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error);
}

$conn->close();
echo json_encode($response);
