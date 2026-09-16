<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();
$res = mysqli_query($conn, "SHOW TABLES LIKE '%location%'");
while($r = mysqli_fetch_row($res)) echo $r[0] . "\n";
$res2 = mysqli_query($conn, "SHOW TABLES LIKE '%building%'");
while($r = mysqli_fetch_row($res2)) echo $r[0] . "\n";
?>
