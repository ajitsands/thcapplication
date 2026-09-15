<?php
include_once(__DIR__ . '/../model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();
if ($conn->query("ALTER TABLE tbl_spare_parts_master ADD COLUMN status ENUM('Active', 'Inactive') DEFAULT 'Active'")) {
    echo "Successfully added status column.\n";
} else {
    echo "Error adding column: " . $conn->error . "\n";
}
?>
