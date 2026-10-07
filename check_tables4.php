<?php
include('model/db_connection/connection.php');
$db = new DBConnection();
$conn = $db->ConnectToMYSQL();
$res = $conn->query('SHOW TABLES');
print_r($res->fetch_all());
