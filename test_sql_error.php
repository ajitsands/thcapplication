<?php
include('model/db_connection/connection.php');
$conn = (new DBConnection())->ConnectToMYSQL();

$sql = "SELECT c.checklist_name, c.status, 
        (SELECT COUNT(DISTINCT category_name) FROM tbl_janitor_checklist_items WHERE checklist_id = c.id) as category_count,
        (SELECT COUNT(id) FROM tbl_janitor_checklist_items WHERE checklist_id = c.id) as point_count
        FROM tbl_janitor_checklists c 
        WHERE c.id = 1";

$res = mysqli_query($conn, $sql);
if (!$res) {
    echo "Error: " . mysqli_error($conn) . "\n";
} else {
    print_r(mysqli_fetch_assoc($res));
}
?>
