<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

echo "\nTable: tbl_amc_master\n";
$r = mysqli_query($conn, "DESCRIBE tbl_amc_master");
if($r) {
    while($row=mysqli_fetch_assoc($r)) {
        echo $row['Field'].' - '.$row['Type']."\n";
    }
} else {
    echo "Table not found.\n";
}
?>
