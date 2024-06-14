<?php
require_once "../../common/php/authentication.php";

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];

    // Check if the user has reports or feedback (optional, depending on your logic)
    // For simplicity, assuming checks were already done in the previous step

    // Perform deletion
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = 'Error deleting user.';
    }

    $stmt->close();
}

$conn->close();
echo json_encode($response);
