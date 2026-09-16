<?php
include('model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

// 1. Show Material Requisition
mysqli_query($conn, "UPDATE module_permissions SET module_status = 'Yes' WHERE ids = 191");
echo "Material Requisition shown.\n";

// 2. Hide Quotation
mysqli_query($conn, "UPDATE module_permissions SET module_status = 'No' WHERE module_id = 16");
echo "Quotation hidden.\n";

// 3. Hide LocalPO
mysqli_query($conn, "UPDATE module_permissions SET module_status = 'No' WHERE module_id = 20");
echo "LocalPO hidden.\n";

?>
