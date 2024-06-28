<?php

require_once "../../../common/php/authentication.php";

if (isset($_GET['search_term'])) {
    $searchTerm = $_GET['search_term'];
    $likeTerm = '%' . $searchTerm . '%';

    $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE (id LIKE ? OR name LIKE ? OR email LIKE ?) and type = 1");
    $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
        echo json_encode(['success' => true, 'admins' => $admins]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No admins found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No search term provided']);
}

$conn->close();
