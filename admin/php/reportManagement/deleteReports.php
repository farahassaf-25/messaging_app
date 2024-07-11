<?php

require_once "../../../common/php/authentication.php";

if (isset($_POST['report_ids'])) {
    $reportIds = $_POST['report_ids'];
    $ids = implode(',', array_map('intval', $reportIds));

    $sql = "DELETE FROM reports WHERE report_id IN ($ids)";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'No report IDs provided']);
}
