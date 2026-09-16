<?php
include('model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$query1 = "SHOW CREATE PROCEDURE proc_amc_add_assets";
$result1 = mysqli_query($varDBConnection, $query1);
$row1 = mysqli_fetch_assoc($result1);
echo "PROCEDURE 1:\n";
echo $row1['Create Procedure'] . "\n\n";

$query2 = "SHOW CREATE PROCEDURE proc_amc_edit_assets";
$result2 = mysqli_query($varDBConnection, $query2);
$row2 = mysqli_fetch_assoc($result2);
echo "PROCEDURE 2:\n";
echo $row2['Create Procedure'] . "\n\n";
?>
