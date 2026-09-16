<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$r = mysqli_query($conn, 'DESCRIBE tbl_janitor_checklist_items');
while($row=mysqli_fetch_assoc($r)) echo $row['Field'].' - '.$row['Type']."\n";
?>
