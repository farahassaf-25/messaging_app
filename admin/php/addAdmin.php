<?php
require_once "../../common/php/authentication.php";

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : '';
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Handle file upload if imageUrl is not provided
    if (empty($imageUrl) && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $uploadDir = '../../uploads/';
        $imageUrl = $uploadDir . $imageName;

        if (!move_uploaded_file($imageTmpPath, $imageUrl)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
            exit;
        }

        // Save relative URL to imageUrl in database
        $relativeImageUrl = 'uploads/' . $imageName;
    } elseif (!empty($imageUrl)) {
        $relativeImageUrl = $imageUrl; // Use provided URL
    } else {
        echo json_encode(['success' => false, 'message' => 'Image upload failed or no image provided']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, imageUrl, type) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $relativeImageUrl);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add admin']);
        }
    }

    $stmt->close();
}
$conn->close();
