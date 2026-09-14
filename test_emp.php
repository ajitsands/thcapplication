<?php
require 'api/db_connection/connection.php';
$stmt = $con->prepare("SELECT employee_code, employee_name, employee_status, employee_type_name FROM tbl_employees WHERE employee_code='CG-THC-0228'");
$stmt->execute();
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt2 = $con->prepare("SELECT * FROM tbl_employee_leave WHERE employee_code='CG-THC-0228'");
$stmt2->execute();
echo "\nLeaves:\n";
print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
?>
