<?php
/**
 * THC Facility Management - Database Permissions Setup Script
 * Activates Quotation Module and Janitor Operations permissions in:
 * 1. tbl_app_modules
 * 2. module_permissions
 * 3. permissions
 * 4. role_permissions & role_permissions_v1
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

echo "=== THC-FM Permission Setup: Quotation & Janitor Operations ===\n";

// 1. Ensure tbl_app_modules has Quotation (16) and Janitor Operations (21)
$modules = [
    16 => 'Quotation',
    21 => 'Janitor Operations'
];

foreach ($modules as $id => $name) {
    $chk = mysqli_query($conn, "SELECT ids FROM tbl_app_modules WHERE ids = $id");
    if ($chk && mysqli_num_rows($chk) > 0) {
        mysqli_query($conn, "UPDATE tbl_app_modules SET status = 'Active', module_name = '$name' WHERE ids = $id");
        echo "[+] tbl_app_modules: Updated module '$name' (ID $id) to Active\n";
    } else {
        mysqli_query($conn, "INSERT INTO tbl_app_modules (ids, module_name, module_classview_id, status) VALUES ($id, '$name', 0, 'Active')");
        echo "[+] tbl_app_modules: Inserted module '$name' (ID $id)\n";
    }
}

// 2. Define permissions list
$perm_definitions = [
    // Module 16: Quotation
    ['name' => 'Quotation', 'mod_id' => 16, 'class' => 'classQuotation', 'parent_title' => 'Quotation'],
    ['name' => 'QuotationModule', 'mod_id' => 16, 'class' => 'classQuotationModule', 'parent_title' => 'Quotation'],
    ['name' => 'CreateQuotation', 'mod_id' => 16, 'class' => 'classCreateQuotation', 'parent_title' => 'Quotation'],
    ['name' => 'ViewQuotation', 'mod_id' => 16, 'class' => 'classViewQuotation', 'parent_title' => 'Quotation'],
    ['name' => 'ViewQuotationRevision', 'mod_id' => 16, 'class' => 'classViewQuotationRevision', 'parent_title' => 'Quotation'],

    // Module 21: Janitor Operations
    ['name' => 'JanitorModule', 'mod_id' => 21, 'class' => 'classJanitorModule', 'parent_title' => 'Janitor Operations'],
    ['name' => 'ChecklistMaster', 'mod_id' => 21, 'class' => 'classChecklistMaster', 'parent_title' => 'Janitor Operations'],
    ['name' => 'JanitorAssignment', 'mod_id' => 21, 'class' => 'classJanitorAssignment', 'parent_title' => 'Janitor Operations'],
    ['name' => 'JanitorExecutionReport', 'mod_id' => 21, 'class' => 'classJanitorExecutionReport', 'parent_title' => 'Janitor Operations'],
    ['name' => 'JanitorSettings', 'mod_id' => 21, 'class' => 'classJanitorSettings', 'parent_title' => 'Janitor Operations'],
    ['name' => 'JanitorCalendar', 'mod_id' => 21, 'class' => 'classJanitorCalendar', 'parent_title' => 'Janitor Operations']
];

// Roles to grant permissions to by default:
// 1 = Administrator, 5 = Operation Manager, 11 = Operations Manager (Maintenance), 13 = Facilities Manager, 15 = Director
$default_admin_roles = [1, 5, 11, 13, 15];

foreach ($perm_definitions as $p) {
    $pName = mysqli_real_escape_string($conn, $p['name']);
    $modId = (int)$p['mod_id'];
    $pClass = mysqli_real_escape_string($conn, $p['class']);
    $parentTitle = mysqli_real_escape_string($conn, $p['parent_title']);

    // Check module_permissions
    $res = mysqli_query($conn, "SELECT ids FROM module_permissions WHERE module_permission_name = '$pName' AND module_id = $modId");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $perm_id = (int)$row['ids'];
        mysqli_query($conn, "UPDATE module_permissions SET module_status = 'Yes' WHERE ids = $perm_id");
        echo "[+] module_permissions: Enabled '$pName' (ID $perm_id, status=Yes)\n";
    } else {
        mysqli_query($conn, "INSERT INTO module_permissions (module_permission_name, module_id, module_status, role_id) VALUES ('$pName', $modId, 'Yes', 0)");
        $perm_id = mysqli_insert_id($conn);
        echo "[+] module_permissions: Inserted '$pName' (ID $perm_id, status=Yes)\n";
    }

    // Check permissions table
    $pChk = mysqli_query($conn, "SELECT id FROM permissions WHERE name = '$pName'");
    if (!$pChk || mysqli_num_rows($pChk) == 0) {
        mysqli_query($conn, "INSERT INTO permissions (name, class_name, module_id) VALUES ('$pName', '$pClass', $modId)");
        echo "[+] permissions table: Inserted '$pName'\n";
    }

    // Assign to roles
    foreach ($default_admin_roles as $roleId) {
        // role_permissions_v1
        $rChk1 = mysqli_query($conn, "SELECT ids FROM role_permissions_v1 WHERE role_id = $roleId AND permission_id = $perm_id");
        if (!$rChk1 || mysqli_num_rows($rChk1) == 0) {
            mysqli_query($conn, "INSERT INTO role_permissions_v1 (role_id, permission_id, module_id, sub_module_name, module_name) VALUES ('$roleId', '$perm_id', '$modId', '$pName', '$parentTitle')");
        }

        // role_permissions (V1 fallback)
        $rChk2 = mysqli_query($conn, "SELECT ids FROM role_permissions WHERE role_id = $roleId AND permission_id = $perm_id");
        if (!$rChk2 || mysqli_num_rows($rChk2) == 0) {
            mysqli_query($conn, "INSERT INTO role_permissions (role_id, permission_id, module_id) VALUES ($roleId, $perm_id, $modId)");
        }
    }
}

echo "=== Permission setup completed successfully! ===\n";
