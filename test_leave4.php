<?php
require ('model/common/common_functions.php');
$model = new CommonModel();
$conn = $model->varDBConnection;

$sql2 = "select count(*) from tbl_employee_leave where employee_code IS NULL OR employee_code = '' OR start_time IS NULL OR end_time IS NULL";
$res2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_row($res2);
echo "Invalid rows: " . $row2[0] . "\n";
?>
