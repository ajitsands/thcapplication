<?php
/**
 * THC Facility Management - Database Permissions Setup Script
 * Activates single "Quotation" module access permission in:
 * 1. tbl_app_modules (Quotation - ID 16, Active)
 * 2. module_permissions (Quotation - module_status = 'Yes'; sub-items hidden)
 * 3. permissions (Quotation & QuotationModule)
 * 4. role_permissions_v1 (assigned to Administrator and Managers)
 *
 * Also ensures Janitor Settings & Calendar are removed from permission settings.
 *
 * Safe and idempotent: can be run repeatedly on localhost and portal.thcfm.com.
 */

include_once(__DIR__ . '/model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (!$conn || mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . "\n");
}

mysqli_set_charset($conn, 'utf8mb4');

echo "=== THC-FM Permission Setup: Quotation Module Access ===\n";

// 1. Ensure tbl_app_modules has Quotation (16) Active
$chk = mysqli_query($conn, "SELECT ids FROM tbl_app_modules WHERE ids = 16");
if ($chk && mysqli_num_rows($chk) > 0) {
    mysqli_query($conn, "UPDATE tbl_app_modules SET status = 'Active', module_name = 'Quotation' WHERE ids = 16");
    echo "[+] tbl_app_modules: Quotation module (ID 16) is Active\n";
} else {
    mysqli_query($conn, "INSERT INTO tbl_app_modules (ids, module_name, module_classview_id, status) VALUES (16, 'Quotation', 151, 'Active')");
    echo "[+] tbl_app_modules: Inserted Quotation module (ID 16)\n";
}

// 2. Hide old/unneeded Quotation sub-permissions so only 1 permission shows in tree
mysqli_query($conn, "UPDATE module_permissions SET module_status = 'No' WHERE module_id = 16 AND module_permission_name IN ('CreateQuotation', 'ViewQuotation', 'ViewQuotationRevision', 'QuotationModule')");
mysqli_query($conn, "DELETE FROM role_permissions_v1 WHERE module_id = 16 AND sub_module_name = 'QuotationModule'");
echo "[+] module_permissions: Cleaned up old sub-menus (CreateQuotation, ViewQuotation, ViewQuotationRevision, QuotationModule set to No)\n";

// Hide Janitor Settings and Janitor Calendar from permission tree
mysqli_query($conn, "UPDATE module_permissions SET module_status = 'No' WHERE module_id = 21 AND module_permission_name IN ('JanitorSettings', 'JanitorCalendar')");
mysqli_query($conn, "DELETE FROM role_permissions_v1 WHERE sub_module_name IN ('JanitorSettings', 'JanitorCalendar')");
mysqli_query($conn, "DELETE FROM permissions WHERE name IN ('JanitorSettings', 'JanitorCalendar')");
echo "[+] module_permissions: Janitor Settings & Calendar removed from permission settings\n";

// 3. Ensure single primary 'Quotation' permission is Active in module_permissions
$qRes = mysqli_query($conn, "SELECT ids FROM module_permissions WHERE module_permission_name = 'Quotation' AND module_id = 16");
if ($qRes && mysqli_num_rows($qRes) > 0) {
    $row = mysqli_fetch_assoc($qRes);
    $qPermId = (int)$row['ids'];
    mysqli_query($conn, "UPDATE module_permissions SET module_status = 'Yes' WHERE ids = $qPermId");
    echo "[+] module_permissions: Enabled 'Quotation' (ID $qPermId, status=Yes)\n";
} else {
    mysqli_query($conn, "INSERT INTO module_permissions (module_permission_name, module_id, module_status, role_id) VALUES ('Quotation', 16, 'Yes', 0)");
    $qPermId = mysqli_insert_id($conn);
    echo "[+] module_permissions: Inserted 'Quotation' (ID $qPermId, status=Yes)\n";
}

// Ensure 'permissions' table entry
mysqli_query($conn, "INSERT IGNORE INTO permissions (name, class_name, module_id) VALUES ('Quotation', 'classQuotation', 16)");
mysqli_query($conn, "INSERT IGNORE INTO permissions (name, class_name, module_id) VALUES ('QuotationModule', 'classQuotationModule', 16)");

// 4. Assign Quotation permission to Administrator (Role 1), Operation Manager (Role 5), etc.
$default_roles = [1, 5, 11, 13, 15];
foreach ($default_roles as $roleId) {
    // role_permissions_v1
    $rChk = mysqli_query($conn, "SELECT ids FROM role_permissions_v1 WHERE role_id = $roleId AND permission_id = $qPermId");
    if (!$rChk || mysqli_num_rows($rChk) == 0) {
        mysqli_query($conn, "INSERT INTO role_permissions_v1 (role_id, permission_id, module_id, sub_module_name, module_name) VALUES ('$roleId', '$qPermId', 16, 'Quotation', 'Quotation')");
    }
    // role_permissions fallback
    $rChk2 = mysqli_query($conn, "SELECT ids FROM role_permissions WHERE role_id = $roleId AND permission_id = $qPermId");
    if (!$rChk2 || mysqli_num_rows($rChk2) == 0) {
        mysqli_query($conn, "INSERT INTO role_permissions (role_id, permission_id, module_id) VALUES ($roleId, $qPermId, 16)");
    }
}
echo "[+] role_permissions_v1: Granted Quotation access to Administrator and Managers\n";

echo "=== Permission setup completed successfully! ===\n";
