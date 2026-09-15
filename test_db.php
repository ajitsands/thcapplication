<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();
$res = $conn->query("DESCRIBE tbl_spare_parts_master");
while($row = $res->fetch_array()) { echo $row[0] . ' - ' . $row[1] . "\n"; }
?>
