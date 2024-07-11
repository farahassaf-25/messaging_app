<?php
require_once "../../../common/php/authentication.php";

// get report ID from POST data
$reportId = $_POST['reportId'];

// check if reportId is valid
if (!$reportId) {
    echo json_encode(array('success' => false, 'message' => 'Invalid report ID.'));
    exit;
}

$sql = "DELETE FROM reports WHERE report_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $reportId);

    if ($stmt->execute()) {
        $response = array('success' => true, 'deletedReportId' => $reportId);
    } else {
        $response = array('success' => false, 'message' => 'Failed to delete report: ' . $stmt->error);
    }
    $stmt->close();
} else {
    $response = array('success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error);
}

$conn->close();
echo json_encode($response);
