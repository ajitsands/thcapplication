<?php
include_once(__DIR__ . '/model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (!$conn) {
    die("Database connection failed.\n");
}

echo "Starting database schema updates for Janitor Settings and Scan Tracking...\n";

// 1. Create tbl_janitor_settings
$sql1 = "CREATE TABLE IF NOT EXISTS tbl_janitor_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    min_radius_meters DECIMAL(10,2) NOT NULL DEFAULT 200.00,
    late_time_minutes INT NOT NULL DEFAULT 15,
    allow_gps_bypass VARCHAR(10) NOT NULL DEFAULT 'NO',
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by VARCHAR(255) DEFAULT 'System'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (mysqli_query($conn, $sql1)) {
    echo "tbl_janitor_settings verified/created.\n";
} else {
    echo "Error creating tbl_janitor_settings: " . mysqli_error($conn) . "\n";
}

// Ensure at least one default row in tbl_janitor_settings
$chk = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_janitor_settings");
$count = $chk ? (int)mysqli_fetch_row($chk)[0] : 0;
if ($count === 0) {
    mysqli_query($conn, "INSERT INTO tbl_janitor_settings (min_radius_meters, late_time_minutes, allow_gps_bypass, updated_by) VALUES (200.00, 15, 'NO', 'Admin')");
    echo "Default settings inserted into tbl_janitor_settings.\n";
} else {
    echo "Settings row already exists ($count rows).\n";
}

// Helper function to add column if not exists
function add_column_if_not_exists($conn, $table, $column, $definition) {
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    if ($res && mysqli_num_rows($res) === 0) {
        $alter = "ALTER TABLE `$table` ADD COLUMN `$column` $definition";
        if (mysqli_query($conn, $alter)) {
            echo "Added `$column` to `$table`.\n";
        } else {
            echo "Failed adding `$column` to `$table`: " . mysqli_error($conn) . "\n";
        }
    } else {
        echo "`$column` already exists in `$table`.\n";
    }
}

// 2. Add asset_lat, asset_lng to tbl_janitor_attendance
add_column_if_not_exists($conn, 'tbl_janitor_attendance', 'asset_lat', 'VARCHAR(50) DEFAULT NULL');
add_column_if_not_exists($conn, 'tbl_janitor_attendance', 'asset_lng', 'VARCHAR(50) DEFAULT NULL');

// 3. Add scan_lat, scan_lng, asset_lat, asset_lng, distance_meters to tbl_janitor_execution_log
add_column_if_not_exists($conn, 'tbl_janitor_execution_log', 'scan_lat', 'VARCHAR(50) DEFAULT NULL');
add_column_if_not_exists($conn, 'tbl_janitor_execution_log', 'scan_lng', 'VARCHAR(50) DEFAULT NULL');
add_column_if_not_exists($conn, 'tbl_janitor_execution_log', 'asset_lat', 'VARCHAR(50) DEFAULT NULL');
add_column_if_not_exists($conn, 'tbl_janitor_execution_log', 'asset_lng', 'VARCHAR(50) DEFAULT NULL');
add_column_if_not_exists($conn, 'tbl_janitor_execution_log', 'distance_meters', 'DECIMAL(10,2) DEFAULT NULL');

// 4. Add latitude, longitude to tbl_assets
add_column_if_not_exists($conn, 'tbl_assets', 'latitude', 'VARCHAR(100) DEFAULT NULL');
add_column_if_not_exists($conn, 'tbl_assets', 'longitude', 'VARCHAR(100) DEFAULT NULL');

echo "Database schema update completed successfully.\n";
?>
