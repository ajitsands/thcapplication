<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$query = "ALTER TABLE tbl_janitor_assignments 
    ADD COLUMN customer_id INT AFTER checklist_id,
    ADD COLUMN location_id INT AFTER customer_id,
    ADD COLUMN building_id INT AFTER location_id";

if (mysqli_query($conn, $query)) {
    echo "Successfully altered tbl_janitor_assignments.\n";
} else {
    echo "Error: " . mysqli_error($conn) . "\n";
}
?>
