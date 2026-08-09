<?php
include("model/db_connection/connection.php");
$conn = new DBConnection();
$db = $conn->ConnectToMYSQL();

$sql = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date_format,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date_format,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on_format from view_employee_expertiser_list where employee_id !=1 order by employee_id desc";
$result = mysqli_query($db, $sql);
if (!$result) {
    echo "Error: " . mysqli_error($db) . "\n";
} else {
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    echo "Found " . count($rows) . " rows.\n";
    print_r($rows);
}
?>
