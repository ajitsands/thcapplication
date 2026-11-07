<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/../../model/db_connection/connection.php');

if(isset($_GET['request_id'])) {
    $request_id = intval($_GET['request_id']);
    
    $conn = (new DBConnection())->ConnectToMYSQL();
    
    // Fetch Header
    $sqlHeader = "SELECT id, customer_id, workorder_id, attachment_path, status FROM tbl_spare_parts_requests WHERE id = " . $request_id;
    $resH = $conn->query($sqlHeader);
    $header = ($resH) ? $resH->fetch_assoc() : null;
    
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
            WHERE ri.request_id = " . $request_id . "
            GROUP BY ri.id";
            
    $resI = $conn->query($sqlItems);
    
    $items = [];
    if($resI) {
        while($row = $resI->fetch_assoc()) {
            $items[] = $row;
        }
    }
    
    $conn->close();
    
    echo json_encode(['success' => true, 'header' => $header, 'items' => $items]);
} else {
    echo json_encode(['success' => false, 'message' => 'Missing request ID.']);
}
?>
