<?php
include('model/db_connection/connection.php');
$conn = new DBConnection();
$db = $conn->ConnectToMYSQL();
$res = mysqli_query($db, "SHOW CREATE PROCEDURE proc_add_employee_leave");
while($row = mysqli_fetch_array($res)) {
    echo $row['Create Procedure'] . "\n";
}
?>
