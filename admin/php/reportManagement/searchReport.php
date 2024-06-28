<?php

require_once "../../../common/php/authentication.php";

if (isset($_GET['search_term'])) {
    $searchTerm = $_GET['search_term'];

    $stmt = $conn->prepare("SELECT * FROM reports WHERE report_id LIKE ? OR reporter_id LIKE ? OR reported_id LIKE ?");
    $likeTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reports = [];
        while ($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
        echo json_encode(['success' => true, 'reports' => $reports]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No reports found']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'No search term provided']);
}
$conn->close();
