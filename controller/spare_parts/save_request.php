<?php
include_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0;
    $workorder_id = isset($_POST['workorder_id']) ? (int)$_POST['workorder_id'] : 0;
    $items = isset($_POST['items']) ? $_POST['items'] : []; // Array of {item_id: x, quantity: y}
    
    // In a real application, you'd get the user ID from the session
    $created_by = 1; 

    if ($customer_id > 0 && $workorder_id > 0 && !empty($items)) {
        $sql = "INSERT INTO tbl_spare_parts_requests (customer_id, workorder_id, request_date, status, created_by) 
                VALUES ($customer_id, $workorder_id, NOW(), 'Pending', $created_by)";
        
        if ($conn->query($sql)) {
            $request_id = $conn->insert_id;
            
            foreach ($items as $item) {
                $item_id = (int)$item['item_id'];
                $quantity = (int)$item['quantity'];
                if ($item_id > 0 && $quantity > 0) {
                    $sql_item = "INSERT INTO tbl_spare_parts_request_items (request_id, item_id, quantity) 
                                 VALUES ($request_id, $item_id, $quantity)";
                    $conn->query($sql_item);
                }
            }
            
            echo json_encode(['success' => true, 'message' => 'Spare parts request saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save request.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
