<?php
include_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';

$items = [];
if ($category != '') {
    $sql = "SELECT id, item_name, item_code FROM tbl_spare_parts_master WHERE category = '$category'";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'id' => $row['id'],
                'text' => $row['item_code'] . ' - ' . $row['item_name']
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($items);
?>
