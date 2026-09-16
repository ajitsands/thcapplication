<?php
include('model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

echo "tbl_app_modules:\n";
$res = mysqli_query($conn, "SELECT * FROM tbl_app_modules");
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['ids'] . " - " . $row['module_name'] . " - " . $row['module_status'] . "\n";
}

echo "\nmodule_permissions:\n";
$res2 = mysqli_query($conn, "SELECT * FROM module_permissions WHERE module_id IN (16,20) OR module_permission_name LIKE '%Material%'");
while ($row = mysqli_fetch_assoc($res2)) {
    echo $row['ids'] . " - " . $row['module_permission_name'] . " - mod_id:" . $row['module_id'] . " - " . $row['module_status'] . "\n";
}
?>
