<?php
include_once(__DIR__ . '/../model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$sql1 = "ALTER TABLE tbl_spare_parts_requests ADD COLUMN attachment_path VARCHAR(255) DEFAULT NULL";
if ($conn->query($sql1)) {
    echo "Added attachment_path to tbl_spare_parts_requests.\n";
} else {
    echo "Error 1: " . $conn->error . "\n";
}

$sql2 = "ALTER TABLE tbl_spare_parts_request_items ADD COLUMN unit VARCHAR(50) DEFAULT NULL";
if ($conn->query($sql2)) {
    echo "Added unit to tbl_spare_parts_request_items.\n";
} else {
    echo "Error 2: " . $conn->error . "\n";
}

$sql3 = "ALTER TABLE tbl_spare_parts_request_items ADD COLUMN remarks VARCHAR(255) DEFAULT NULL";
if ($conn->query($sql3)) {
    echo "Added remarks to tbl_spare_parts_request_items.\n";
} else {
    echo "Error 3: " . $conn->error . "\n";
}
?>
