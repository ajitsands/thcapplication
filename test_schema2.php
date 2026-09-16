<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

echo "checklists:\n";
$r = mysqli_query($conn, 'DESCRIBE tbl_janitor_checklists');
while($row=mysqli_fetch_assoc($r)) echo $row['Field']."\n";

echo "\ncategories:\n";
$r = mysqli_query($conn, 'DESCRIBE tbl_janitor_checklist_categories');
while($row=mysqli_fetch_assoc($r)) echo $row['Field']."\n";
?>
