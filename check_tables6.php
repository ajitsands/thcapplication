<?php
include('model/db_connection/connection.php');
$db = new DBConnection();
$conn = $db->ConnectToMYSQL();
$res = $conn->query('SHOW COLUMNS FROM tbl_ticket_teams');
print_r($res->fetch_all(MYSQLI_ASSOC));
