<?php
include_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = isset($_POST['request_id']) ? (int)$_POST['request_id'] : 0;
    $items = isset($_POST['items']) ? $_POST['items'] : [];
    
    if ($request_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid Request ID.']);
        exit;
    }

    // Check status
    $resStatus = $conn->query("SELECT status FROM tbl_spare_parts_requests WHERE id = $request_id");
    $rowStatus = $resStatus->fetch_assoc();
    if (!$rowStatus || in_array($rowStatus['status'], ['Completed', 'Closed'])) {
        echo json_encode(['success' => false, 'message' => 'Cannot edit a Completed or Closed request.']);
        exit;
    }

    // Handle attachment
    $attachment_query_part = "";
    if (isset($_FILES['request_attachment']) && $_FILES['request_attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../httpdocs/uploads/request_attachments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['request_attachment']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['request_attachment']['tmp_name'], $targetFile)) {
            $attachment_path = $conn->real_escape_string($filename);
            $attachment_query_part = ", attachment_path = '$attachment_path'";
        }
    }

    // Update request header (if attachment changed)
    if (!empty($attachment_query_part)) {
        $conn->query("UPDATE tbl_spare_parts_requests SET request_date = request_date $attachment_query_part WHERE id = $request_id");
    }

    // Get current items and their issued quantities
    $currentItems = [];
    $resItems = $conn->query("
        SELECT ri.id, COALESCE(SUM(i.issued_qty), 0) as issued_qty 
        FROM tbl_spare_parts_request_items ri 
        LEFT JOIN tbl_spare_parts_issues i ON ri.id = i.request_item_id 
        WHERE ri.request_id = $request_id 
        GROUP BY ri.id
    ");
    while($row = $resItems->fetch_assoc()) {
        $currentItems[$row['id']] = $row['issued_qty'];
    }

    $submittedItemIds = [];

    // Process submitted items
    foreach ($items as $item) {
        $req_item_id = isset($item['request_item_id']) && $item['request_item_id'] !== 'new' ? (int)$item['request_item_id'] : 0;
        $item_id = isset($item['item_id']) ? (int)$item['item_id'] : 0;
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
        $unit = isset($item['unit']) ? $conn->real_escape_string($item['unit']) : '';
        $remarks = isset($item['remarks']) ? $conn->real_escape_string($item['remarks']) : '';

        if ($item_id > 0 && $quantity > 0) {
            if ($req_item_id > 0 && isset($currentItems[$req_item_id])) {
                $submittedItemIds[] = $req_item_id;
                // Only update if not issued at all
                if ($currentItems[$req_item_id] == 0) {
                    $sql_update = "UPDATE tbl_spare_parts_request_items 
                                   SET item_id = $item_id, quantity = $quantity, unit = '$unit', remarks = '$remarks' 
                                   WHERE id = $req_item_id";
                    $conn->query($sql_update);
                }
            } else {
                // New item
                $sql_insert = "INSERT INTO tbl_spare_parts_request_items (request_id, item_id, quantity, unit, remarks) 
                               VALUES ($request_id, $item_id, $quantity, '$unit', '$remarks')";
                $conn->query($sql_insert);
            }
        }
    }

    // Delete removed items (only if issued_qty == 0)
    foreach ($currentItems as $id => $issued_qty) {
        if (!in_array($id, $submittedItemIds)) {
            if ($issued_qty == 0) {
                $conn->query("DELETE FROM tbl_spare_parts_request_items WHERE id = $id");
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Material request updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
