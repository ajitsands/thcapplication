<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

echo "\nTable: role_permissions_v1\n";
$r = mysqli_query($conn, "DESCRIBE role_permissions_v1");
if($r) {
    while($row=mysqli_fetch_assoc($r)) {
        echo $row['Field'].' - '.$row['Type']."\n";
    }
} else {
    echo "Table not found.\n";
}
?>
