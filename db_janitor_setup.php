<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$queries = [
    // Checklist Master
    "CREATE TABLE IF NOT EXISTS tbl_janitor_checklists (
        id INT AUTO_INCREMENT PRIMARY KEY,
        checklist_name VARCHAR(500) NOT NULL,
        category_name VARCHAR(500),
        status VARCHAR(50) DEFAULT 'Active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    
    // Checklist Items
    "CREATE TABLE IF NOT EXISTS tbl_janitor_checklist_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        checklist_id INT NOT NULL,
        item_description TEXT NOT NULL,
        status VARCHAR(50) DEFAULT 'Active'
    )",
    
    // Checklist Assignments
    "CREATE TABLE IF NOT EXISTS tbl_janitor_assignments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        checklist_id INT NOT NULL,
        employee_id INT NOT NULL,
        asset_id INT NOT NULL,
        amc_ref_no VARCHAR(500) NOT NULL,
        frequency VARCHAR(100),
        slots TEXT,
        start_date DATE,
        end_date DATE,
        status VARCHAR(50) DEFAULT 'Active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",

    // Execution Log Header (For mobile app)
    "CREATE TABLE IF NOT EXISTS tbl_janitor_execution_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        assignment_id INT NOT NULL,
        employee_id INT NOT NULL,
        asset_id INT NOT NULL,
        amc_ref_no VARCHAR(500) NOT NULL,
        executed_date DATE NOT NULL,
        executed_slot VARCHAR(200) NOT NULL,
        status VARCHAR(100) DEFAULT 'Completed',
        remarks TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",

    // Execution Log Line Items (For mobile app)
    "CREATE TABLE IF NOT EXISTS tbl_janitor_execution_points (
        id INT AUTO_INCREMENT PRIMARY KEY,
        execution_id INT NOT NULL,
        checklist_item_id INT NOT NULL,
        is_completed VARCHAR(50) DEFAULT 'Yes',
        remarks TEXT,
        photo_url VARCHAR(1000)
    )"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "Query successful.\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
}
?>
