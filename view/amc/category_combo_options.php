<?php
include_once __DIR__ . '/../../model/db_connection/connection.php';
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

echo '<option value="select">Select Category</option>';
if ($varDBConnection) {
    $result = mysqli_query($varDBConnection, "select category_id, category_name from tbl_category where category_status='Active' order by category_name asc");
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['category_id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
        }
    }
}
?>
