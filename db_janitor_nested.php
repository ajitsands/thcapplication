<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

// Delete existing records to avoid foreign key issues or orphans
mysqli_query($conn, "TRUNCATE TABLE tbl_janitor_checklists");
mysqli_query($conn, "TRUNCATE TABLE tbl_janitor_checklist_items");
mysqli_query($conn, "TRUNCATE TABLE tbl_janitor_assignments");

$queries = [
    // Remove category_name from checklists
    "ALTER TABLE tbl_janitor_checklists DROP COLUMN category_name",
    
    // Create new categories table
    "CREATE TABLE IF NOT EXISTS tbl_janitor_checklist_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        checklist_id INT NOT NULL,
        category_name VARCHAR(500) NOT NULL
    )",

    // Update items table to reference category instead of checklist
    "ALTER TABLE tbl_janitor_checklist_items CHANGE checklist_id checklist_category_id INT NOT NULL"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "Query successful.\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
}
?>
