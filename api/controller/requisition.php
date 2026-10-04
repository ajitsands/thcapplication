<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include_once(__DIR__ . '/../../model/db_connection/connection.php');
include_once(__DIR__ . '/../../view/template/includes/en_de_header.inc');

$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$OBJ = new URLEncription();
$api_key_input = isset($_REQUEST['APIKEY']) ? $_REQUEST['APIKEY'] : '';
$api_key = $OBJ->KEYDecode(trim($api_key_input));

if(trim($api_key) != 'thcauthentication') {
    echo json_encode(['status' => 'error', 'message' => 'api_key_error']);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// 1. getCatogory
if ($action === 'getCatogory') {
    $sql = "SELECT category_id AS id, category_name AS name FROM tbl_category WHERE category_status = 'Active'";
    $result = $conn->query($sql);
    
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
    exit;
}

// 2. getItemList
if ($action === 'getItemList') {
    $category = isset($_REQUEST['category']) ? $conn->real_escape_string($_REQUEST['category']) : '';
    
    if (empty($category)) {
        echo json_encode(['status' => 'error', 'message' => 'Category is required']);
        exit;
    }
    
    $sql = "SELECT id, item_code, item_name, type_name, description FROM tbl_spare_parts_master WHERE category = '$category' AND status = 'Active'";
    $result = $conn->query($sql);
    
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
    exit;
}

// 3. bookRequestion
if ($action === 'bookRequestion') {
    $customer_id = isset($_POST['customer_id']) ? (int)$_POST['customer_id'] : 0;
    $workorder_id = isset($_POST['workorder_id']) ? (int)$_POST['workorder_id'] : 0;
    
    // Items can be passed as JSON string from Mobile App, or array
    $itemsRaw = isset($_POST['items']) ? $_POST['items'] : '';
    $items = [];
    
    if (is_array($itemsRaw)) {
        $items = $itemsRaw;
    } else if (is_string($itemsRaw)) {
        $items = json_decode($itemsRaw, true);
    }
    
    $created_by = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1; 

    if ($customer_id <= 0 || $workorder_id <= 0 || empty($items)) {
        echo json_encode(['status' => 'error', 'message' => 'customer_id, workorder_id, and items are required']);
        exit;
    }

    $attachment_path = NULL;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../httpdocs/uploads/request_attachments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['attachment']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
            $attachment_path = $conn->real_escape_string($filename);
        }
    }

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
        
        echo json_encode(['status' => 'success', 'message' => 'Requisition booked successfully', 'request_id' => $request_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save requisition', 'error' => $conn->error]);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
?>
