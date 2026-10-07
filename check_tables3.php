<?php
include('model/db_connection/connection.php');
$db = new DBConnection();
$conn = $db->ConnectToMYSQL();
$res1 = $conn->query('SHOW COLUMNS FROM tbl_spare_parts_requests');
print_r($res1->fetch_all(MYSQLI_ASSOC));
$res2 = $conn->query('SHOW COLUMNS FROM tbl_spare_parts_request_items');
print_r($res2->fetch_all(MYSQLI_ASSOC));
