<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
require_once(__DIR__ . '/../../model/db_connection/connection.php');

if(isset($_GET['request_id'])) {
    $request_id = intval($_GET['request_id']);
    
    $conn = (new DBConnection())->ConnectToMYSQL();
    
    $sql = "SELECT ri.quantity as req_qty, IFNULL(i.issued_qty, 0) as issued_qty, DATE_FORMAT(i.issued_date, '%d/%m/%Y %h:%i %p') as issued_date, i.issued_by_username, m.item_name, m.category 
            FROM tbl_spare_parts_request_items ri 
            JOIN tbl_spare_parts_master m ON ri.item_id = m.id 
            LEFT JOIN tbl_spare_parts_issues i ON ri.id = i.request_item_id 
            WHERE ri.request_id = ? 
            ORDER BY ri.id ASC, i.issued_date DESC";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $history = [];
    while($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    
    echo json_encode($history);
    
    $stmt->close();
    $conn->close();
}
?>
