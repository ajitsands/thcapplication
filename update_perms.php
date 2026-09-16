<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$mod_perms = [
    "JanitorModule" => 21,
    "ChecklistMaster" => 21,
    "JanitorAssignment" => 21
];

foreach ($mod_perms as $perm_name => $mod_id) {
    mysqli_query($conn, "UPDATE role_permissions_v1 SET sub_module_name = '$perm_name', module_name = 'Janitor Operations' WHERE permission_id IN (SELECT ids FROM module_permissions WHERE module_permission_name = '$perm_name')");
}
echo "Permissions updated in v1.\n";
?>
