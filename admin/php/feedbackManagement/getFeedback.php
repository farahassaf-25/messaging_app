<?php

require_once "../../../common/php/authentication.php";

$response = array('success' => false, 'message' => '', 'feedback' => '');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET['userId'];

    $stmt = $conn->prepare("SELECT feedback_id, feedback FROM feedback WHERE user_id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $stmt->bind_result($feedbackId, $feedback);
        if ($stmt->fetch()) {
            $response['success'] = true;
            $response['feedback'] = $feedback;
            $response['feedback_id'] = $feedbackId;
        } else {
            $response['success'] = true;
        }
    } else {
        $response['message'] = 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
