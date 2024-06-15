<?php
require_once "../../common/php/authentication.php";

// Disable error reporting output (display errors)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

$response = array('success' => false, 'message' => '');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['userId'])) {
            throw new Exception('User ID not provided');
        }

        $userId = $_POST['userId'];

        // Check for existing reports
        $stmt = $conn->prepare("SELECT COUNT(*) as reportCount FROM reports WHERE reported_id = ?");
        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . $conn->error);
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['reportCount'] > 0) {
            $response['message'] = 'Cannot delete user: This user has been reported. Please see the reports for more details.';
        } else {
            // Perform deletion
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            if (!$stmt) {
                throw new Exception('Failed to prepare statement: ' . $conn->error);
            }

            $stmt->bind_param("i", $userId);

            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                throw new Exception('Error deleting user: ' . $stmt->error);
            }
        }

        $stmt->close();
    } else {
        throw new Exception('Invalid request method.');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
