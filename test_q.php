<?php
require 'model/db_connection/connection.php';
$conn = new DBConnection();
$db = $conn->ConnectToMYSQL();
$q = "SELECT CONCAT(employee_name, ' - ', leave_type) AS title, leave_start_date AS start, DATE_ADD(leave_end_date, INTERVAL 1 DAY) AS end, CASE leave_type WHEN 'Sick Leave' THEN '#ef5350' WHEN 'Casual Leave' THEN '#42a5f5' WHEN 'Annual Leave' THEN '#66bb6a' WHEN 'Emergency Leave' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_short_leave UNION ALL SELECT CONCAT(employee_name, ' - ', leave_type) AS title, DATE(start_time) AS start, DATE_ADD(DATE(end_time), INTERVAL 1 DAY) AS end, CASE leave_type WHEN 'Sick Leave' THEN '#ef5350' WHEN 'Casual Leave' THEN '#42a5f5' WHEN 'Annual Leave' THEN '#66bb6a' WHEN 'Emergency Leave' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_leave";
$res = mysqli_query($db, $q);
if (!$res) {
    echo "ERROR: " . mysqli_error($db);
} else {
    echo "OK: " . mysqli_num_rows($res);
}
?>
