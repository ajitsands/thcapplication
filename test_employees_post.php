<?php
$_POST['action'] = 'employee_list_view';
$_POST['v_ctrl_name'] = '';
$_POST['v_employee_type_id'] = '';
$_POST['v_employee_type_name'] = '';
$_POST['v_employee_code'] = '';
$_POST['v_employee_password'] = '';
$_POST['v_employee_name'] = '';
$_POST['v_employee_contact_no'] = '';
$_POST['v_employee_email_id'] = '';
$_POST['v_employee_address'] = '';
$_POST['v_employee_image'] = '';
$_POST['v_employee_status'] = '';
$_POST['v_employee_id'] = '';
$_POST['v_expertise_id'] = [];
$_POST['v_expertise_name'] = [];
$_POST['v_emp_cpr_number'] = '';
$_POST['v_emp_blood_group'] = '';
$_POST['v_emp_passport_no'] = '';
$_POST['v_emp_joining_date'] = '';
$_POST['v_emp_cpr_expiry_date'] = '';
$_POST['v_emp_visa_validity'] = '';
$_POST['v_checked_val'] = '';
$_POST['v_emp_tech_type_name'] = '';
$_POST['v_emp_native_no'] = '';
$_POST['v_emp_native_address'] = '';
$_POST['v_emp_visa_type'] = '';
$_POST['v_employee_action'] = '';

ob_start();
require('controller/employees/employees_controller.php');
$output = ob_get_clean();
echo "OUTPUT LENGTH: " . strlen($output) . "\n";
echo "OUTPUT BEGIN\n";
echo substr($output, 0, 1000) . "...\n";
echo "OUTPUT END\n";
?>
