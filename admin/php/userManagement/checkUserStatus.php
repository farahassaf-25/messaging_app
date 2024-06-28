<?php
require_once "../../../common/php/authentication.php";

$response = array('success' => false, 'message' => '', 'hasReport' => false, 'hasFeedback' => false);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET['userId'];

    // check if the user has reports
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reports WHERE reporter_id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $stmt->bind_result($reportCount);
        $stmt->fetch();
        if ($reportCount > 0) {
            $response['hasReport'] = true;
        }
    }
    $stmt->close();

    // check if the user has feedback
    $stmt = $conn->prepare("SELECT COUNT(*) FROM feedback WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $stmt->bind_result($feedbackCount);
        $stmt->fetch();
        if ($feedbackCount > 0) {
            $response['hasFeedback'] = true;
        }
    }
    $stmt->close();

    $response['success'] = true;
}

$conn->close();
echo json_encode($response);
