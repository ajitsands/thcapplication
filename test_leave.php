<?php
require ('model/common/common_functions.php');
$model = new CommonModel();
$conn = $model->varDBConnection;

$visit_date_val = date('Y-m-d');
$sql = "select employee_code from tbl_employee_leave where DATE(start_time) <= '".$visit_date_val."' and DATE(end_time) >= '".$visit_date_val."'";
$res = mysqli_query($conn, $sql);
echo "Leave SQL: " . $sql . "\n";
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
echo "Null check:\n";
$sql2 = "select count(*) from tbl_employee_leave where employee_code IS NULL";
$res2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_row($res2);
echo "Null codes: " . $row2[0] . "\n";
?>
