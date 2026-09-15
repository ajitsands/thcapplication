<?php
include_once(__DIR__ . '/../model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

echo "=== tbl_spare_parts_requests ===\n";
$res = $conn->query("DESCRIBE tbl_spare_parts_requests");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\n=== tbl_spare_parts_request_items ===\n";
$res = $conn->query("DESCRIBE tbl_spare_parts_request_items");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
