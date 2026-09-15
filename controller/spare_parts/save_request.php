<?php
include_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0;
    $workorder_id = isset($_POST['workorder_id']) ? (int)$_POST['workorder_id'] : 0;
    $items = isset($_POST['items']) ? $_POST['items'] : []; // Array of {item_id: x, quantity: y, unit: z, remarks: w}
    
    // In a real application, you'd get the user ID from the session
    $created_by = 1; 

    $attachment_path = NULL;
    if (isset($_FILES['request_attachment']) && $_FILES['request_attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../httpdocs/uploads/request_attachments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['request_attachment']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['request_attachment']['tmp_name'], $targetFile)) {
            $attachment_path = $conn->real_escape_string($filename);
        }
    }

    if ($customer_id > 0 && $workorder_id > 0 && !empty($items)) {
        $attachment_sql = $attachment_path ? "'$attachment_path'" : "NULL";
        $sql = "INSERT INTO tbl_spare_parts_requests (customer_id, workorder_id, request_date, status, created_by, attachment_path) 
                VALUES ($customer_id, $workorder_id, NOW(), 'Pending', $created_by, $attachment_sql)";
        
        if ($conn->query($sql)) {
            $request_id = $conn->insert_id;
            
            foreach ($items as $item) {
                $item_id = isset($item['item_id']) ? (int)$item['item_id'] : 0;
                $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                $unit = isset($item['unit']) ? $conn->real_escape_string($item['unit']) : '';
                $remarks = isset($item['remarks']) ? $conn->real_escape_string($item['remarks']) : '';
                
                if ($item_id > 0 && $quantity > 0) {
                    $sql_item = "INSERT INTO tbl_spare_parts_request_items (request_id, item_id, quantity, unit, remarks) 
                                 VALUES ($request_id, $item_id, $quantity, '$unit', '$remarks')";
                    $conn->query($sql_item);
                }
            }
            
            echo json_encode(['success' => true, 'message' => 'Material request saved successfully.']);
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
