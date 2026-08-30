<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
require_once(__DIR__ . '/../../model/db_connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = isset($_POST['request_id']) ? (int)$_POST['request_id'] : 0;
    
    if ($request_id > 0) {
        $conn = (new DBConnection())->ConnectToMYSQL();
        $stmt = $conn->prepare("UPDATE tbl_spare_parts_requests SET status = 'Closed' WHERE id = ?");
        $stmt->bind_param("i", $request_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Request closed successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error.']);
        }
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request ID.']);
    }
}
?>
