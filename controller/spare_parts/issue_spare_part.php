<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
require_once(__DIR__ . '/../../model/db_connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_item_id = isset($_POST['request_item_id']) ? (int)$_POST['request_item_id'] : 0;
    $request_id = isset($_POST['request_id']) ? (int)$_POST['request_id'] : 0;
    $issue_qty = isset($_POST['issue_qty']) ? (int)$_POST['issue_qty'] : 0;
    
    // Check multiple potential session variable names for username
    $issued_by_username = 'System';
    if(isset($_SESSION['username'])) $issued_by_username = $_SESSION['username'];
    else if(isset($_SESSION['user_name'])) $issued_by_username = $_SESSION['user_name'];
    else if(isset($_SESSION['name'])) $issued_by_username = $_SESSION['name'];

    if ($request_item_id > 0 && $issue_qty > 0 && $request_id > 0) {
        $conn = (new DBConnection())->ConnectToMYSQL();
        
        $check_sql = "SELECT i.quantity, COALESCE((SELECT SUM(issued_qty) FROM tbl_spare_parts_issues WHERE request_item_id = i.id), 0) as issued_qty 
                      FROM tbl_spare_parts_request_items i WHERE i.id = $request_item_id";
        $check_res = $conn->query($check_sql);
        if ($check_res && $check_row = $check_res->fetch_assoc()) {
            $total_requested = (int)$check_row['quantity'];
            $currently_issued = (int)$check_row['issued_qty'];
            
            if ($currently_issued + $issue_qty > $total_requested) {
                echo json_encode(['success' => false, 'message' => 'Cannot issue more than the requested quantity.']);
                exit;
            }
            
            $stmt = $conn->prepare("INSERT INTO tbl_spare_parts_issues (request_item_id, request_id, issued_qty, issued_date, issued_by_username) VALUES (?, ?, ?, NOW(), ?)");
            $stmt->bind_param("iiis", $request_item_id, $request_id, $issue_qty, $issued_by_username);
            
            if ($stmt->execute()) {
                $status_sql = "SELECT 
                                SUM(i.quantity) as total_req, 
                                COALESCE((SELECT SUM(issued_qty) FROM tbl_spare_parts_issues WHERE request_id = $request_id), 0) as total_iss 
                               FROM tbl_spare_parts_request_items i 
                               WHERE i.request_id = $request_id";
                $status_res = $conn->query($status_sql);
                if ($status_res && $status_row = $status_res->fetch_assoc()) {
                    $new_status = 'Partial Issue';
                    if ((int)$status_row['total_iss'] >= (int)$status_row['total_req']) {
                        $new_status = 'Completed';
                    }
                    $conn->query("UPDATE tbl_spare_parts_requests SET status = '$new_status' WHERE id = $request_id");
                }
                
                echo json_encode(['success' => true, 'message' => 'Quantity issued successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error while issuing.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request item.']);
        }
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
