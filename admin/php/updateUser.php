<?php
require_once "../../common/php/authentication.php";

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    // $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE users SET name = ?, email = ?, type = ?";
    if (!empty($password)) {
        $sql .= ", password = ?";
    }
    $sql .= " WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!empty($password)) {
        $stmt->bind_param("ssssi", $username, $email, $type, $hashed_password, $userId);
    } else {
        $stmt->bind_param("sssi", $username, $email, $type, $userId);
    }

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
