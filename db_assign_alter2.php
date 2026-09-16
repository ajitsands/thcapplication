<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$query = "ALTER TABLE tbl_janitor_assignments MODIFY employee_id VARCHAR(500)";

if (mysqli_query($conn, $query)) {
    echo "Successfully altered employee_id to VARCHAR(500).\n";
} else {
    echo "Error: " . mysqli_error($conn) . "\n";
}
?>
