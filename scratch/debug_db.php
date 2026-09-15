<?php
include('d:/Projects/thcfm/model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();
$res = $conn->query("SELECT * FROM tbl_spare_parts_requests WHERE workorder_id = 8782");
echo "Requests:\n";
while($row = $res->fetch_assoc()) {
    print_r($row);
    $req_id = $row['id'];
    $resItems = $conn->query("SELECT * FROM tbl_spare_parts_request_items WHERE request_id = $req_id");
    echo "Items for Request $req_id:\n";
    while($item = $resItems->fetch_assoc()) {
        print_r($item);
    }
}
