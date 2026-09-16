<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();
$tables = ['tbl_customer_location', 'tbl_building'];
foreach($tables as $t) {
    echo "\nTable: $t\n";
    $r = mysqli_query($conn, "DESCRIBE $t");
    if($r) {
        while($row=mysqli_fetch_assoc($r)) echo $row['Field'].' - '.$row['Type']."\n";
    }
}
?>
