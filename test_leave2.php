<?php
require ('model/common/common_functions.php');
$model = new CommonModel();
$conn = $model->varDBConnection;

$sql = "select * from tbl_employee_leave limit 5";
$res = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
