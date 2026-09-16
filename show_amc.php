<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();
$r = mysqli_query($conn, "SHOW TABLES LIKE '%amc%'");
while($row=mysqli_fetch_array($r)) {
    echo $row[0]."\n";
}
?>
