<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/../../model/db_connection/connection.php');

if (!isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'No action provided.']);
    exit;
}

$action = $_POST['action'];
$conn = (new DBConnection())->ConnectToMYSQL();

if ($action == 'get_work_orders') {
    $ticket_ref_code = isset($_POST['ticket_ref_code']) ? $conn->real_escape_string($_POST['ticket_ref_code']) : '';
    
    if (empty($ticket_ref_code)) {
        echo json_encode(['success' => false, 'message' => 'Missing ticket reference code.']);
        exit;
    }
    
    // Fetch all work orders (entries) for this ticket reference code
    $sql = "SELECT ticket_id, category_name, type_name, asset_code 
            FROM tbl_tickets 
            WHERE ticket_ref_code = '$ticket_ref_code' 
            ORDER BY ticket_id ASC";
            
    $res = $conn->query($sql);
    $data = [];
    if ($res) {
        while($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
} 
elseif ($action == 'get_requests') {
    $ticket_id = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : 0;
    
    if ($ticket_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Missing work order ID.']);
        exit;
    }
    
    // Fetch material requests for this specific work order
    $sql = "SELECT id as request_id, request_date, status, attachment_path 
            FROM tbl_spare_parts_requests 
            WHERE workorder_id = $ticket_id 
            ORDER BY id ASC";
            
    $res = $conn->query($sql);
    $data = [];
    if ($res) {
        while($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
}
elseif ($action == 'get_request_items') {
    $request_id = isset($_POST['request_id']) ? (int)$_POST['request_id'] : 0;
    
    if ($request_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Missing request ID.']);
        exit;
    }
    
    // Fetch material request items with issued quantities
    $sql = "SELECT ri.id as request_item_id, ri.quantity as requested_qty, ri.unit, ri.remarks, 
                   m.item_code, m.item_name, m.category as category_name, 
                   COALESCE(SUM(iss.issued_qty), 0) as issued_qty
            FROM tbl_spare_parts_request_items ri
            LEFT JOIN tbl_spare_parts_master m ON ri.item_id = m.id
            LEFT JOIN tbl_spare_parts_issues iss ON ri.id = iss.request_item_id
            WHERE ri.request_id = $request_id
            GROUP BY ri.id
            ORDER BY ri.id ASC";
            
    $res = $conn->query($sql);
    $data = [];
    if ($res) {
        while($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
} 
else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}

$conn->close();
?>
