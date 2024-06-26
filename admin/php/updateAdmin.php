<?php
require_once "../../common/php/authentication.php";

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : '';

    // Handle file upload if a new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadDir = '../../uploads/';
        $imageUrl = $uploadDir . $imageName;

        if (!move_uploaded_file($imageTmpPath, $imageUrl)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit;
        }

        // Save relative URL to imageUrl in database
        $relativeImageUrl = 'uploads/' . $imageName;
    } elseif (!empty($imageUrl)) {
        $relativeImageUrl = $imageUrl; // Use provided URL if no new file is uploaded
    } else {
        $relativeImageUrl = null; // No image provided or uploaded
    }

    $sql = "UPDATE users SET name = ?, email = ?, imageUrl = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $username, $email, $relativeImageUrl, $userId);

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
