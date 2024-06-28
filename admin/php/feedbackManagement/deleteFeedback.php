<?php
require_once "../../../common/php/authentication.php";

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedbackId = $_POST['feedbackId'];

    $stmt = $conn->prepare("DELETE FROM feedback WHERE feedback_id = ?");
    $stmt->bind_param("i", $feedbackId);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
