<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/../../model/db_connection/connection.php');

if(isset($_GET['request_id'])) {
    $request_id = intval($_GET['request_id']);
    
    $conn = (new DBConnection())->ConnectToMYSQL();
    
    // Fetch Header
    $sqlHeader = "SELECT id, customer_id, workorder_id, attachment_path, status FROM tbl_spare_parts_requests WHERE id = ?";
    $stmtH = $conn->prepare($sqlHeader);
    $stmtH->bind_param("i", $request_id);
    $stmtH->execute();
    $resH = $stmtH->get_result();
    $header = $resH->fetch_assoc();
    $stmtH->close();
    
    if (!$header) {
        echo json_encode(['success' => false, 'message' => 'Request not found.']);
        exit;
    }
    
    // Fetch Items
    $sqlItems = "SELECT ri.id as request_item_id, ri.item_id, ri.quantity, ri.unit, ri.remarks, 
                   m.item_name, m.category as category_name, 
                   COALESCE(SUM(i.issued_qty), 0) as issued_qty
            FROM tbl_spare_parts_request_items ri
            LEFT JOIN tbl_spare_parts_master m ON ri.item_id = m.id
            LEFT JOIN tbl_spare_parts_issues i ON ri.id = i.request_item_id
            WHERE ri.request_id = ?
            GROUP BY ri.id";
            
    $stmtI = $conn->prepare($sqlItems);
    $stmtI->bind_param("i", $request_id);
    $stmtI->execute();
    $resI = $stmtI->get_result();
    
    $items = [];
    while($row = $resI->fetch_assoc()) {
        $items[] = $row;
    }
    $stmtI->close();
    
    $conn->close();
    
    echo json_encode(['success' => true, 'header' => $header, 'items' => $items]);
} else {
    echo json_encode(['success' => false, 'message' => 'Missing request ID.']);
}
?>
