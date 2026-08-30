<?php
include_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

$customer_id = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;

$workorders = [];
if ($customer_id > 0) {
    $sql = "SELECT ticket_id, ticket_ref_code, ticket_ref_no FROM tbl_tickets WHERE customer_id = $customer_id AND ticket_status NOT IN ('Closed', 'Cancelled', 'Completed')";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $workorders[] = [
                'id' => $row['ticket_id'],
                'text' => 'WO-' . $row['ticket_ref_code'] . '-' . $row['ticket_id']
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($workorders);
?>
