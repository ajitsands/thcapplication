<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

// Insert Janitor Module into tbl_app_modules
mysqli_query($conn, "INSERT IGNORE INTO tbl_app_modules (ids, module_name) VALUES (21, 'Janitor Operations')");

// Insert into module_permissions
$mod_perms = [
    "JanitorModule" => 21,
    "ChecklistMaster" => 21,
    "JanitorAssignment" => 21
];

foreach ($mod_perms as $perm_name => $mod_id) {
    // Check if exists
    $res = mysqli_query($conn, "SELECT ids FROM module_permissions WHERE module_permission_name = '$perm_name'");
    if (mysqli_num_rows($res) == 0) {
        mysqli_query($conn, "INSERT INTO module_permissions (module_permission_name, module_id, module_status) VALUES ('$perm_name', $mod_id, 'Yes')");
        $perm_id = mysqli_insert_id($conn);
    } else {
        $row = mysqli_fetch_assoc($res);
        $perm_id = $row['ids'];
    }
    
    // Also insert into permissions for fallback
    mysqli_query($conn, "INSERT IGNORE INTO permissions (name, class_name) VALUES ('$perm_name', 'class$perm_name')");
    
    // Assign to Admin (Role 1)
    mysqli_query($conn, "INSERT IGNORE INTO role_permissions (role_id, permission_id, module_id) VALUES (1, $perm_id, $mod_id)");
    mysqli_query($conn, "INSERT IGNORE INTO role_permissions_v1 (role_id, permission_id, module_id) VALUES (1, $perm_id, $mod_id)");
}

echo "Janitor permissions set up successfully.\n";
?>
