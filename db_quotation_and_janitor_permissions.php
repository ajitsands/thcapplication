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

// 37-40: Clean up legacy and redundant sub-permissions from module_permissions & role_permissions_v1
mysqli_query($conn, "UPDATE module_permissions SET module_status = 'No' WHERE module_id = 16 AND module_permission_name IN ('CreateQuotation', 'ViewQuotation', 'ViewQuotationRevision', 'QuotationModule')");
mysqli_query($conn, "DELETE FROM role_permissions_v1 WHERE module_id = 16 AND sub_module_name IN ('CreateQuotation', 'ViewQuotation', 'ViewQuotationRevision', 'QuotationModule')");
echo "[+] module_permissions & role_permissions_v1: Cleaned up legacy sub-menus\n";

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

// 4. Assign Quotation permission STRICTLY to: Administrator, Operation Manager, Operations Manager, and Operation Coordinator ONLY
$targetRoleNames = [
    'Administrator',
    'Operation Coordinator',
    'Operations Coordinator',
    'Operation Manager',
    'Operations Manager',
    'Operations Manager (Maintenance)'
];

$allowedRoleIds = [];
$escNames = "'" . implode("','", array_map(function($n) use ($conn) { return mysqli_real_escape_string($conn, $n); }, $targetRoleNames)) . "'";

// Query roles table for exact IDs
$roleRes = mysqli_query($conn, "SELECT id, name FROM roles WHERE name IN ($escNames)");
if ($roleRes) {
    while ($r = mysqli_fetch_assoc($roleRes)) {
        $allowedRoleIds[] = (int)$r['id'];
        echo "[+] Found role in 'roles': {$r['name']} (ID: {$r['id']})\n";
    }
}

// Fallback known IDs in THC FM: 1 (Administrator), 2 (Operation Coordinator), 5 (Operation Manager), 11 (Operations Manager Maintenance)
$allowedRoleIds = array_values(array_unique(array_merge($allowedRoleIds, [1, 2, 5, 11])));
$allowedIdsStr = implode(',', $allowedRoleIds);

// 4a. Revoke Quotation permission from ALL other roles (so it is accessible ONLY to the allowed roles)
mysqli_query($conn, "DELETE FROM role_permissions_v1 WHERE (module_id = 16 OR sub_module_name IN ('Quotation', 'QuotationModule')) AND role_id NOT IN ($allowedIdsStr)");
mysqli_query($conn, "DELETE FROM role_permissions WHERE module_id = 16 AND role_id NOT IN ($allowedIdsStr)");
echo "[+] Revoked Quotation permission from all other roles (strictly restricted to Roles: $allowedIdsStr)\n";

// 4b. Grant Quotation permission strictly to the allowed roles
foreach ($allowedRoleIds as $roleId) {
    // role_permissions_v1
    $rChk = mysqli_query($conn, "SELECT ids FROM role_permissions_v1 WHERE role_id = $roleId AND permission_id = $qPermId AND sub_module_name = 'Quotation'");
    if (!$rChk || mysqli_num_rows($rChk) == 0) {
        mysqli_query($conn, "INSERT INTO role_permissions_v1 (role_id, permission_id, module_id, sub_module_name, module_name) VALUES ('$roleId', '$qPermId', 16, 'Quotation', 'Quotation')");
    }
    // role_permissions fallback
    $rChk2 = mysqli_query($conn, "SELECT ids FROM role_permissions WHERE role_id = $roleId AND permission_id = $qPermId");
    if (!$rChk2 || mysqli_num_rows($rChk2) == 0) {
        mysqli_query($conn, "INSERT INTO role_permissions (role_id, permission_id, module_id) VALUES ($roleId, $qPermId, 16)");
    }
}
echo "[+] role_permissions_v1: Granted Quotation access strictly to Administrator, Operation Manager, Operations Manager, and Operation Coordinator (Roles: " . implode(', ', $allowedRoleIds) . ")\n";

echo "=== Permission setup completed successfully! ===\n";
