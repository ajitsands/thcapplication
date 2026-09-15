<?php
require ('model/common/common_functions.php');
$model = new CommonModel();
$conn = $model->varDBConnection;

$visit_date_val = '2026-09-14';
$visit_slot_clause = "";

$sql = "select employee_id,employee_code,employee_name,employee_contact_no from tbl_technician_slots where slot_date='".$visit_date_val."' " . $visit_slot_clause . " and employee_id in (select employee_id from tbl_employees where employee_status='Active') union select employee_id,employee_code,employee_name,employee_contact_no from tbl_employees where employee_type_name in ('Technician','Team Leader','Supervisor') and employee_status='Active' and employee_id not in (select employee_id from tbl_technician_slots where slot_date='".$visit_date_val."') group by employee_id";

$res = mysqli_query($conn, $sql);
echo "Count without leave filter: " . mysqli_num_rows($res) . "\n";
while($row = mysqli_fetch_assoc($res)) {
    if ($row['employee_code'] == 'CG-THC-0228') {
        echo "FOUND CG-THC-0228 without leave filter!\n";
    }
}
?>
