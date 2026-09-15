<?php
header('Content-Type: application/json');


require_once(__DIR__ . '/../../model/db_connection/connection.php');

if(isset($_GET['request_id'])) {
    $request_id = intval($_GET['request_id']);
    
    $conn = (new DBConnection())->ConnectToMYSQL();
    
    $sql = "SELECT ri.id as request_item_id, ri.item_id, ri.quantity, ri.unit, ri.remarks, 
                   m.item_name, m.category as category_name, 
                   COALESCE(SUM(i.issued_qty), 0) as issued_qty
            FROM tbl_spare_parts_request_items ri
            LEFT JOIN tbl_spare_parts_master m ON ri.item_id = m.id
            LEFT JOIN tbl_spare_parts_issues i ON ri.id = i.request_item_id
            WHERE ri.request_id = ?
            GROUP BY ri.id";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    echo json_encode($items);
    
    $stmt->close();
    $conn->close();
}
?>
