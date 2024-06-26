<?php

include "authentication.php";

$user = isAuthenticated();
if (!($user instanceof User)) {
    header("Content-Type: application/json");
    http_response_code($user["code"]);
    echo json_encode(["error" => $user["error"]]);
    return;
}

// Get all emails and images except the current user's
$stmt = $conn->prepare("SELECT email, imageURL FROM users WHERE email != ?");
$stmt->bind_param("s", $user->email);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}

echo json_encode($members);

$stmt->close();
$conn->close();
