<?php
include('model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

// 1. Find all active roles
$roles = [];
$r = mysqli_query($conn, "SELECT id FROM roles");
while ($row = mysqli_fetch_assoc($r)) {
    $roles[] = $row['id'];
}

// 2. Grant permissions to Role 1 (assuming it's Admin)
// Material permissions: 61, 62, 191
$perms = [61, 62, 191];
foreach ($perms as $p) {
    mysqli_query($conn, "INSERT IGNORE INTO role_permissions (role_id, permission_id, module_id) VALUES (1, $p, 10)");
    mysqli_query($conn, "INSERT IGNORE INTO role_permissions_v1 (role_id, permission_id, module_id) VALUES (1, $p, 10)");
}

echo "Permissions granted to Role 1.\n";
?>
