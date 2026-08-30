<?php
header('Content-Type: application/json');


require_once(__DIR__ . '/../../model/db_connection/connection.php');

if(isset($_GET['request_id'])) {
    $request_id = intval($_GET['request_id']);
    
    $conn = (new DBConnection())->ConnectToMYSQL();
    
    $sql = "SELECT i.id as request_item_id, i.quantity, m.item_name, m.category AS category_name,
                   COALESCE((SELECT SUM(issued_qty) FROM tbl_spare_parts_issues WHERE request_item_id = i.id), 0) as issued_qty 
            FROM tbl_spare_parts_request_items i 
            JOIN tbl_spare_parts_master m ON i.item_id = m.id 
            WHERE i.request_id = ?";
            
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
