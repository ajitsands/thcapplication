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
    $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string($_POST['customer_id']) : '';
    
    if (empty($customer_id)) {
        echo json_encode(['success' => false, 'message' => 'Missing customer ID.']);
        exit;
    }
    
    // Fetch all work orders for this customer
    $sql = "SELECT ticket_id, ticket_ref_code 
            FROM tbl_tickets 
            WHERE customer_id = '$customer_id' 
            ORDER BY ticket_id DESC";
            
    $res = $conn->query($sql);
    $data = [];
    if ($res) {
        while($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
}
elseif ($action == 'get_materials') {
    // Fetch all materials for the dropdown
    $sql = "SELECT id, item_code, item_name 
            FROM tbl_spare_parts_master 
            ORDER BY item_name ASC";
            
    $res = $conn->query($sql);
    $data = [];
    if ($res) {
        while($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
    }
    echo json_encode(['success' => true, 'data' => $data]);
}
elseif ($action == 'get_report_data') {
    $customer_id = isset($_POST['customer_id']) ? $conn->real_escape_string($_POST['customer_id']) : 'All';
    $workorder_id = isset($_POST['workorder_id']) ? $conn->real_escape_string($_POST['workorder_id']) : 'All';
    $material_id = isset($_POST['material_id']) ? $conn->real_escape_string($_POST['material_id']) : 'All';
    
    $where_clauses = ["1=1"];
    
    if ($customer_id !== 'All' && $customer_id !== '') {
        $where_clauses[] = "t.customer_id = '$customer_id'";
    }
    if ($workorder_id !== 'All' && $workorder_id !== '') {
        $where_clauses[] = "t.ticket_id = '$workorder_id'";
    }
    if ($material_id !== 'All' && $material_id !== '') {
        $where_clauses[] = "m.id = '$material_id'";
    }
    
    $where_sql = implode(' AND ', $where_clauses);
    
    // Consolidated report query
    $sql = "SELECT 
                t.ticket_ref_code,
                t.ticket_id,
                c.customer_name,
                r.id AS request_id,
                DATE_FORMAT(r.request_date, '%d-%m-%Y %H:%i') AS request_date,
                m.item_code,
                m.item_name,
                ri.quantity AS requested_qty,
                COALESCE(SUM(iss.issued_qty), 0) AS issued_qty,
                ri.remarks,
                r.status AS request_status,
                GROUP_CONCAT(
                    CONCAT(
                        iss.issued_qty, 
                        ' qty on ', 
                        DATE_FORMAT(iss.issued_date, '%d-%m-%Y %H:%i'),
                        ' (',
                        iss.issued_by_username,
                        ')'
                    ) SEPARATOR '<br>'
                ) AS delivery_logs
            FROM tbl_spare_parts_request_items ri
            INNER JOIN tbl_spare_parts_requests r ON ri.request_id = r.id
            INNER JOIN tbl_tickets t ON r.workorder_id = t.ticket_id
            INNER JOIN tbl_customers c ON t.customer_id = c.customer_id
            LEFT JOIN tbl_spare_parts_master m ON ri.item_id = m.id
            LEFT JOIN tbl_spare_parts_issues iss ON ri.id = iss.request_item_id
            WHERE $where_sql
            GROUP BY ri.id
            ORDER BY r.request_date DESC";
            
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
