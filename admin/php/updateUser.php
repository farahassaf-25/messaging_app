<?php
require_once "../../common/php/authentication.php";

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $type = $_POST['type'];

    $sql = "UPDATE users SET name = ?, email = ?, type = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $username, $email, $type, $userId);

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['message'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'Failed to prepare statement: ' . $conn->error;
    }

    $conn->close();
}

echo json_encode($response);
