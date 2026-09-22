<?php
require 'model/db_connection/connection.php';
$db = new DBConnection();
$conn = $db->ConnectToMYSQL();

function descTable($conn, $table) {
    echo "TABLE: $table\n";
    $res = mysqli_query($conn, "DESCRIBE $table");
    if($res) {
        while($row = mysqli_fetch_assoc($res)) {
            echo $row['Field'] . " - " . $row['Type'] . "\n";
        }
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
    echo "--------------------------\n";
}

descTable($conn, 'tbl_assets');
descTable($conn, 'tbl_janitor_execution_log');
descTable($conn, 'tbl_janitor_assignments');
descTable($conn, 'tbl_employees');
descTable($conn, 'tbl_amc_schedule_master');
descTable($conn, 'tbl_amc_master');
descTable($conn, 'tbl_customers');
