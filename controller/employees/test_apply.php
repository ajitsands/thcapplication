<?php
$_POST['action'] = 'apply_leave';
$_POST['leave_emp_id'] = 1;
$_POST['leave_emp_code'] = 'EMP01';
$_POST['leave_emp_name'] = 'Test';
$_POST['leave_type'] = 'Sick Leave';
$_POST['leave_start_date'] = '2026-10-10';
$_POST['leave_end_date'] = '2026-10-11';
$_POST['leave_duration'] = 'Full Day';
$_POST['leave_reason'] = 'Test';
require 'employees_controller.php';
$obj = new apartmentController();
$obj->RequestAccept($_POST);
?>
