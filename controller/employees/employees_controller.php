<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
        var $varModelObj,$varDBConnection;
      public $actionevents,$ctrl_name,$employee_type_id, $employee_type_name,$employee_code,$emp_cnt, $employee_password,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1,$employee_action;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'] ?? '';
        $this->ctrl_name = $_POST['v_ctrl_name'] ?? '';
        $this->employee_type_id = $_POST['v_employee_type_id'] ?? '';
        $this->employee_type_name = $_POST['v_employee_type_name'] ?? '';
        $this->employee_code = $_POST['v_employee_code'] ?? '';
        $this->employee_password = $_POST['v_employee_password'] ?? '';
        $this->employee_name = $_POST['v_employee_name'] ?? '';
        $this->employee_contact_no = $_POST['v_employee_contact_no'] ?? '';
        $this->employee_email_id = $_POST['v_employee_email_id'] ?? '';
        $this->employee_address = $_POST['v_employee_address'] ?? '';
        $this->employee_image = $_POST['v_employee_image'] ?? '';
        $this->employee_status = $_POST['v_employee_status'] ?? '';
        $this->employee_id = $_POST['v_employee_id'] ?? '';
        $this->expertise_id = $_POST['v_expertise_id'] ?? [];
        $this->expertise_name = $_POST['v_expertise_name'] ?? [];
        $this->expertise_length = is_array($this->expertise_id) ? count($this->expertise_id) : 0;
        
        
        $this->employee_cpr_number = $_POST['v_emp_cpr_number'] ?? '';
        $this->employee_blood_group= $_POST['v_emp_blood_group'] ?? '';
        $this->employee_passport_number = $_POST['v_emp_passport_no'] ?? '';
        $this->employee_joining_date= $_POST['v_emp_joining_date'] ?? '';
        $this->employee_cpr_expiry_date = $_POST['v_emp_cpr_expiry_date'] ?? '';
        $this->employee_visa_validity = $_POST['v_emp_visa_validity'] ?? '';
        $this->employee_is_driving_licence = $_POST['v_checked_val'] ?? '';
        $this->employee_tech_type_name = $_POST['v_emp_tech_type_name'] ?? '';
        
        $this->employee_native_number = $_POST['v_emp_native_no'] ?? '';
		$this->employee_native_address = $_POST['v_emp_native_address'] ?? '';
		$this->employee_visa_type= $_POST['v_emp_visa_type'] ?? '';
        
        $this->employee_action = $_POST['v_employee_action'] ?? '';
        
        // Leave variables
        $this->leave_emp_id = $_POST['leave_emp_id'] ?? '';
        $this->leave_emp_code = $_POST['leave_emp_code'] ?? '';
        $this->leave_emp_name = $_POST['leave_emp_name'] ?? '';
        $this->leave_type = $_POST['leave_type'] ?? '';
        $this->leave_start_date = $_POST['leave_start_date'] ?? '';
        $this->leave_end_date = $_POST['leave_end_date'] ?? '';
        $this->leave_duration = $_POST['leave_duration'] ?? '';
        $this->leave_reason = $_POST['leave_reason'] ?? '';
        
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        //$array[1]="call proc_add_employee_details('".$this->employee_type_id."','".$this->employee_type_name."','".$this->employee_code."','".$this->employee_password."','".$this->employee_name."','".$this->employee_contact_no."','".$this->employee_email_id."','".$this->employee_address."','".$this->employee_image."','". $this->expertise_id1."','".$this->expertise_name1."','". $this->employee_cpr_number."','".$this->employee_blood_group."','".$this->employee_passport_number."','".$this->employee_joining_date."','".$this->employee_cpr_expiry_date."','". $this->employee_visa_validity."','".$this->employee_is_driving_licence ."','".$this->employee_tech_type_name."','".$this->employee_native_number."','".$this->employee_native_address."','".$this->employee_visa_type."',@msg )";
         $array[1]="call proc_add_employee_details_v1('".$this->employee_type_id."','".$this->employee_type_name."','".$this->employee_password."','".$this->employee_name."','".$this->employee_contact_no."','".$this->employee_email_id."','".$this->employee_address."','".$this->employee_image."','". $this->expertise_id1."','".$this->expertise_name1."','". $this->employee_cpr_number."','".$this->employee_blood_group."','".$this->employee_passport_number."','".$this->employee_joining_date."','".$this->employee_cpr_expiry_date."','". $this->employee_visa_validity."','".$this->employee_is_driving_licence ."','".$this->employee_tech_type_name."','".$this->employee_native_number."','".$this->employee_native_address."','".$this->employee_visa_type."',@msg )";
        $array[2] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date_format,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date_format,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on_format from view_employee_expertiser_list where employee_id !=1 order by employee_id desc";
        
      
        $array[3]="call proc_edit_employee_details('".$this->employee_type_id."','".$this->employee_type_name."','".$this->employee_code."','".$this->employee_password."','".$this->employee_name."','".$this->employee_contact_no."','".$this->employee_email_id."','".$this->employee_address."','".$this->employee_image."','". $this->expertise_id1."','".$this->expertise_name1."','".$this->employee_id."','". $this->employee_cpr_number."','".$this->employee_blood_group."','".$this->employee_passport_number."','".$this->employee_joining_date."','".$this->employee_cpr_expiry_date."','". $this->employee_visa_validity."','".$this->employee_is_driving_licence ."','".$this->employee_tech_type_name."','".$this->employee_native_number."','".$this->employee_native_address."','".$this->employee_visa_type."',@msg )";
        
        
        $array[4] ="update tbl_employees set `employee_status`='Deactive' where employee_id='".$this->employee_id."'";
        
        $array[5] ="update tbl_employees set `employee_status`='Active' where employee_id='".$this->employee_id."'";
       
        $array[6] = "select employee_code from tbl_employees where employee_id =(SELECT employee_id FROM tbl_employees ORDER BY employee_id DESC LIMIT 1)";
        $array[7] ="SELECT expertise_id,expertise_name FROM tbl_technician_expertise where employee_id='".$this->employee_id."'";
        $array[8] ="Delete from tbl_technician_expertise where employee_id='".$this->employee_id."'";
        $array[9] ="Select employee_code from tbl_employees  where employee_code='".$this->employee_code."'";
        $array[10] ="update tbl_employees set `employee_code`='".$this->employee_code ."' where employee_id='".$this->employee_id."'";
        $array[11] ="call proc_add_employee_short_leave('".$this->leave_emp_id."','".$this->leave_emp_code."','".$this->leave_emp_name."','".$this->leave_type."','".$this->leave_start_date."','".$this->leave_end_date."','".$this->leave_duration."','".$this->leave_reason."',@msg )";
        $array[12] ="SELECT CONCAT(employee_name, ' - ', leave_type) AS title, leave_start_date AS start, DATE_ADD(leave_end_date, INTERVAL 1 DAY) AS end, CASE leave_type WHEN 'Sick Leave' THEN '#ef5350' WHEN 'Casual Leave' THEN '#42a5f5' WHEN 'Annual Leave' THEN '#66bb6a' WHEN 'Emergency Leave' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_short_leave UNION ALL SELECT CONCAT(employee_name, ' - ', leave_type) AS title, DATE(start_time) AS start, DATE_ADD(DATE(end_time), INTERVAL 1 DAY) AS end, CASE leave_type WHEN 'Sick Leave' THEN '#ef5350' WHEN 'Casual Leave' THEN '#42a5f5' WHEN 'Annual Leave' THEN '#66bb6a' WHEN 'Emergency Leave' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_leave";
        
        return $array;
    }
    public function insertEmployee()
    {
        $conn = $this->varDBConnection;

        $emp_type_id = intval($this->employee_type_id);
        $emp_type_name = mysqli_real_escape_string($conn, $this->employee_type_name);
        $emp_password = mysqli_real_escape_string($conn, $this->employee_password);
        $emp_name = mysqli_real_escape_string($conn, $this->employee_name);
        $emp_contact = mysqli_real_escape_string($conn, $this->employee_contact_no);
        $emp_email = mysqli_real_escape_string($conn, $this->employee_email_id);
        $emp_address = mysqli_real_escape_string($conn, $this->employee_address);
        $emp_image = !empty($this->employee_image) ? mysqli_real_escape_string($conn, $this->employee_image) : 'default.jpg';
        if (strpos($emp_image, 'fakepath') !== false || empty(trim($emp_image))) {
            $emp_image = 'default.jpg';
        }
        $cpr_no = mysqli_real_escape_string($conn, $this->employee_cpr_number);
        $blood_group = mysqli_real_escape_string($conn, $this->employee_blood_group);
        $passport_no = mysqli_real_escape_string($conn, $this->employee_passport_number);
        $joining_date = (!empty($this->employee_joining_date) && $this->employee_joining_date != '0000-00-00') ? mysqli_real_escape_string($conn, $this->employee_joining_date) : '1970-01-01';
        $cpr_expiry = (!empty($this->employee_cpr_expiry_date) && $this->employee_cpr_expiry_date != '0000-00-00') ? mysqli_real_escape_string($conn, $this->employee_cpr_expiry_date) : '1970-01-01';
        $visa_validity = (!empty($this->employee_visa_validity) && $this->employee_visa_validity != '0000-00-00') ? mysqli_real_escape_string($conn, $this->employee_visa_validity) : '1970-01-01';
        $is_driving = !empty($this->employee_is_driving_licence) ? mysqli_real_escape_string($conn, $this->employee_is_driving_licence) : 'No';
        $tech_type = mysqli_real_escape_string($conn, $this->employee_tech_type_name);
        $native_no = mysqli_real_escape_string($conn, $this->employee_native_number);
        $native_addr = mysqli_real_escape_string($conn, $this->employee_native_address);
        $visa_type = mysqli_real_escape_string($conn, $this->employee_visa_type);

        // 1. Insert into tbl_employees
        $sql_emp = "INSERT INTO `tbl_employees` (
            `employee_type_id`, `employee_type_name`, `employee_password`, `employee_name`,
            `employee_contact_no`, `employee_email_id`, `employee_address`, `employee_image`,
            `cpr_no`, `blood_group`, `passport_no`, `joining_date`, `cpr_expiry_date`,
            `visa_validity_on`, `is_driving_license`, `technician_type`, `native_number`,
            `native_address`, `visa_type`, `employee_status`
        ) VALUES (
            '$emp_type_id', '$emp_type_name', '$emp_password', '$emp_name',
            '$emp_contact', '$emp_email', '$emp_address', '$emp_image',
            '$cpr_no', '$blood_group', '$passport_no', '$joining_date', '$cpr_expiry',
            '$visa_validity', '$is_driving', '$tech_type', '$native_no',
            '$native_addr', '$visa_type', 'Active'
        )";

        $insert_res = mysqli_query($conn, $sql_emp);
        if (!$insert_res) {
            echo "Error: " . mysqli_error($conn);
            return;
        }

        $last_id = mysqli_insert_id($conn);

        // 2. Generate employee_code
        if ($last_id >= 0 && $last_id <= 9) {
            $v_employee_code = 'CG-THC-000' . $last_id;
        } else if ($last_id >= 10 && $last_id <= 99) {
            $v_employee_code = 'CG-THC-00' . $last_id;
        } else if ($last_id >= 100 && $last_id <= 999) {
            $v_employee_code = 'CG-THC-0' . $last_id;
        } else {
            $v_employee_code = 'CG-THC-' . $last_id;
        }

        // 3. Update employee_code in tbl_employees
        mysqli_query($conn, "UPDATE `tbl_employees` SET `employee_code`='$v_employee_code' WHERE `employee_id`='$last_id'");

        // 4. Insert into users table for login
        mysqli_query($conn, "INSERT INTO `users` (`username`, `password`, `role_id`) VALUES ('$v_employee_code', '$emp_password', 1)");

        // 5. Insert all selected expertise items into tbl_technician_expertise
        if ($this->employee_type_name == 'Technician' && is_array($this->expertise_id) && count($this->expertise_id) > 0) {
            for ($i = 0; $i < count($this->expertise_id); $i++) {
                $exp_id = intval($this->expertise_id[$i]);
                $exp_name = isset($this->expertise_name[$i]) ? mysqli_real_escape_string($conn, $this->expertise_name[$i]) : 'NA';
                if ($exp_id > 0) {
                    mysqli_query($conn, "INSERT INTO `tbl_technician_expertise` (
                        `employee_id`, `employee_code`, `employee_name`, `expertise_id`, `expertise_name`, `status`
                    ) VALUES (
                        '$last_id', '$v_employee_code', '$emp_name', '$exp_id', '$exp_name', 'Active'
                    )");
                }
            }
        }

        echo "success";
    }

    public function modifyEmployee()
    {
        $conn = $this->varDBConnection;

        $emp_id = intval($this->employee_id);
        if ($emp_id <= 0) {
            echo "Error: Invalid Employee ID";
            return;
        }

        $emp_type_id = intval($this->employee_type_id);
        $emp_type_name = mysqli_real_escape_string($conn, $this->employee_type_name);
        $emp_code = mysqli_real_escape_string($conn, $this->employee_code);
        $emp_password = mysqli_real_escape_string($conn, $this->employee_password);
        $emp_name = mysqli_real_escape_string($conn, $this->employee_name);
        $emp_contact = mysqli_real_escape_string($conn, $this->employee_contact_no);
        $emp_email = mysqli_real_escape_string($conn, $this->employee_email_id);
        $emp_address = mysqli_real_escape_string($conn, $this->employee_address);
        $emp_image = !empty($this->employee_image) ? mysqli_real_escape_string($conn, $this->employee_image) : 'default.jpg';
        if (strpos($emp_image, 'fakepath') !== false || empty(trim($emp_image))) {
            $emp_image = 'default.jpg';
        }
        $cpr_no = mysqli_real_escape_string($conn, $this->employee_cpr_number);
        $blood_group = mysqli_real_escape_string($conn, $this->employee_blood_group);
        $passport_no = mysqli_real_escape_string($conn, $this->employee_passport_number);
        $joining_date = (!empty($this->employee_joining_date) && $this->employee_joining_date != '0000-00-00') ? mysqli_real_escape_string($conn, $this->employee_joining_date) : '1970-01-01';
        $cpr_expiry = (!empty($this->employee_cpr_expiry_date) && $this->employee_cpr_expiry_date != '0000-00-00') ? mysqli_real_escape_string($conn, $this->employee_cpr_expiry_date) : '1970-01-01';
        $visa_validity = (!empty($this->employee_visa_validity) && $this->employee_visa_validity != '0000-00-00') ? mysqli_real_escape_string($conn, $this->employee_visa_validity) : '1970-01-01';
        $is_driving = !empty($this->employee_is_driving_licence) ? mysqli_real_escape_string($conn, $this->employee_is_driving_licence) : 'No';
        $tech_type = mysqli_real_escape_string($conn, $this->employee_tech_type_name);
        $native_no = mysqli_real_escape_string($conn, $this->employee_native_number);
        $native_addr = mysqli_real_escape_string($conn, $this->employee_native_address);
        $visa_type = mysqli_real_escape_string($conn, $this->employee_visa_type);

        // 1. Update tbl_employees
        $sql_upd = "UPDATE `tbl_employees` SET
            `employee_type_id` = '$emp_type_id',
            `employee_type_name` = '$emp_type_name',
            `employee_code` = '$emp_code',
            `employee_password` = '$emp_password',
            `employee_name` = '$emp_name',
            `employee_contact_no` = '$emp_contact',
            `employee_email_id` = '$emp_email',
            `employee_address` = '$emp_address',
            `employee_image` = '$emp_image',
            `cpr_no` = '$cpr_no',
            `blood_group` = '$blood_group',
            `passport_no` = '$passport_no',
            `joining_date` = '$joining_date',
            `cpr_expiry_date` = '$cpr_expiry',
            `visa_validity_on` = '$visa_validity',
            `is_driving_license` = '$is_driving',
            `technician_type` = '$tech_type',
            `native_number` = '$native_no',
            `native_address` = '$native_addr',
            `visa_type` = '$visa_type'
        WHERE `employee_id` = '$emp_id'";

        $upd_res = mysqli_query($conn, $sql_upd);
        if (!$upd_res) {
            echo "Error: " . mysqli_error($conn);
            return;
        }

        // 2. Delete existing expertise for this employee
        mysqli_query($conn, "DELETE FROM `tbl_technician_expertise` WHERE `employee_id` = '$emp_id'");

        // 3. Re-insert all selected expertise items
        if ($this->employee_type_name == 'Technician' && is_array($this->expertise_id) && count($this->expertise_id) > 0) {
            for ($i = 0; $i < count($this->expertise_id); $i++) {
                $exp_id = intval($this->expertise_id[$i]);
                $exp_name = isset($this->expertise_name[$i]) ? mysqli_real_escape_string($conn, $this->expertise_name[$i]) : 'NA';
                if ($exp_id > 0) {
                    mysqli_query($conn, "INSERT INTO `tbl_technician_expertise` (
                        `employee_id`, `employee_code`, `employee_name`, `expertise_id`, `expertise_name`, `status`
                    ) VALUES (
                        '$emp_id', '$emp_code', '$emp_name', '$exp_id', '$exp_name', 'Active'
                    )");
                }
            }
        }

        echo "success";
    }

    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
     
        switch ($FunctionEvents)
        {
        
            case 'employee_code_check':
                if($this->varModelObj->ReturnCountValue($var[9])==0)
                {
                    echo "not exist";
                }
                else
                {
                    echo 1;
                }
            break;

            case 'add_employee':
                $this->insertEmployee();
            break;

            case 'update_employee':
                $this->modifyEmployee();
            break;
            
            case 'employee_list_view':
           // echo $var[2];
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            case 'apply_leave':
                $this->varModelObj->ExecuteProcedure($var[11]);
            break;
            
            case 'fetch_leave_calendar':
                $emp_type = isset($_POST['emp_type']) ? $_POST['emp_type'] : 'all';
                $leave_type = isset($_POST['leave_type']) ? $_POST['leave_type'] : 'all';
                $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';
                $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';

                $where1 = " WHERE 1=1";
                $where2 = " WHERE 1=1";

                if ($emp_type !== 'all' && !empty($emp_type)) {
                    $emp_type_esc = $this->varDBConnection->real_escape_string($emp_type);
                    $where1 .= " AND e.employee_type_id = '$emp_type_esc'";
                    $where2 .= " AND e.employee_type_id = '$emp_type_esc'";
                }
                if ($leave_type !== 'all' && !empty($leave_type)) {
                    $leave_type_esc = $this->varDBConnection->real_escape_string($leave_type);
                    $where1 .= " AND s.leave_type = '$leave_type_esc'";
                    $where2 .= " AND l.leave_reason LIKE '%$leave_type_esc%'";
                }
                if (!empty($from_date) && !empty($to_date)) {
                    $from_date_esc = $this->varDBConnection->real_escape_string($from_date);
                    $to_date_esc = $this->varDBConnection->real_escape_string($to_date);
                    $where1 .= " AND s.leave_start_date <= '$to_date_esc' AND s.leave_end_date >= '$from_date_esc'";
                    $where2 .= " AND DATE(l.start_time) <= '$to_date_esc' AND DATE(l.end_time) >= '$from_date_esc'";
                } else {
                    if (!empty($from_date)) {
                        $from_date_esc = $this->varDBConnection->real_escape_string($from_date);
                        $where1 .= " AND s.leave_end_date >= '$from_date_esc'";
                        $where2 .= " AND DATE(l.end_time) >= '$from_date_esc'";
                    }
                    if (!empty($to_date)) {
                        $to_date_esc = $this->varDBConnection->real_escape_string($to_date);
                        $where1 .= " AND s.leave_start_date <= '$to_date_esc'";
                        $where2 .= " AND DATE(l.start_time) <= '$to_date_esc'";
                    }
                }

                $sql = "SELECT CONCAT(s.employee_name, ' - ', s.leave_type) AS title, s.leave_start_date AS start, DATE_ADD(s.leave_end_date, INTERVAL 1 DAY) AS end, CASE s.leave_type WHEN 'Sick Leave' THEN '#ef5350' WHEN 'Casual Leave' THEN '#42a5f5' WHEN 'Annual Leave' THEN '#66bb6a' WHEN 'Emergency Leave' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_short_leave s LEFT JOIN tbl_employees e ON (s.employee_code = e.employee_code OR s.employee_id = e.employee_id) $where1 UNION ALL SELECT CONCAT(COALESCE(e.employee_name, l.employee_name), ' - ', CASE WHEN l.leave_type IS NOT NULL AND l.leave_type != 'NA' AND l.leave_type != '' AND l.leave_type != 'select' THEN l.leave_type WHEN l.leave_reason LIKE '%Sick%' THEN 'Sick Leave' WHEN l.leave_reason LIKE '%Casual%' THEN 'Casual Leave' WHEN l.leave_reason LIKE '%Annual%' THEN 'Annual Leave' WHEN l.leave_reason LIKE '%Emergency%' THEN 'Emergency Leave' WHEN l.leave_reason LIKE '%Privilege%' THEN 'Privilege Leave' ELSE 'Leave' END) AS title, DATE(l.start_time) AS start, DATE_ADD(DATE(l.end_time), INTERVAL 1 DAY) AS end, CASE WHEN l.leave_type = 'Sick Leave' OR l.leave_reason LIKE '%Sick%' THEN '#ef5350' WHEN l.leave_type = 'Casual Leave' OR l.leave_reason LIKE '%Casual%' THEN '#42a5f5' WHEN l.leave_type = 'Annual Leave' OR l.leave_reason LIKE '%Annual%' THEN '#66bb6a' WHEN l.leave_type = 'Emergency Leave' OR l.leave_reason LIKE '%Emergency%' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_leave l LEFT JOIN tbl_employees e ON (l.employee_code = e.employee_code OR l.employee_name = e.employee_name) $where2";

                $events = array();
                $result = mysqli_query($this->varDBConnection, $sql);
                if($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $events[] = $row;
                    }
                }
                echo json_encode($events);
            break;
            
            case 'fetch_active_employees':
                $employees = array();
                $result = mysqli_query($this->varDBConnection, "SELECT employee_id, employee_name, employee_code FROM tbl_employees WHERE employee_status = 'Active'");
                if($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $employees[] = $row;
                    }
                }
                echo json_encode($employees);
            break;
            
             case 'select_expertise_names':
                 $this->varModelObj->ListFromTable($var[7]);
             break;
            
            case 'change_employee_status':
                if($this->employee_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[5]);
                }
                else
                {
                  $this->varModelObj->UpdateTable($var[4]);  
                }
            break;
             case 'update_employee_code':
            
                $this->varModelObj->UpdateTable($var[10]);
            break;

            case 'save_employee_attachment':
                $emp_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;
                $doc_name = isset($_POST['document_type']) ? trim($_POST['document_type']) : '';
                $exp_date = isset($_POST['expiry_date']) && !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : NULL;
                $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

                if ($emp_id <= 0 || empty($doc_name) || !isset($_FILES['doc_file']) || $_FILES['doc_file']['error'] != 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Please select employee, document type, and valid file attachment.']);
                    exit;
                }

                $emp_code = '';
                $res_emp = mysqli_query($this->varDBConnection, "SELECT employee_code FROM tbl_employees WHERE employee_id = '$emp_id'");
                if ($res_emp && $row_e = mysqli_fetch_assoc($res_emp)) {
                    $emp_code = $row_e['employee_code'];
                }

                $uploadDir = __DIR__ . '/../../view/uploads/employee_documents/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $origName = $_FILES['doc_file']['name'];
                $ext = pathinfo($origName, PATHINFO_EXTENSION);
                $newFileName = 'emp_doc_' . $emp_id . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $targetFile = $uploadDir . $newFileName;
                $relFilePath = 'uploads/employee_documents/' . $newFileName;

                if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $targetFile)) {
                    $emp_code_esc = $this->varDBConnection->real_escape_string($emp_code);
                    $doc_name_esc = $this->varDBConnection->real_escape_string($doc_name);
                    $remarks_esc = $this->varDBConnection->real_escape_string($remarks);
                    $origName_esc = $this->varDBConnection->real_escape_string($origName);
                    $exp_date_sql = $exp_date ? "'".$this->varDBConnection->real_escape_string($exp_date)."'" : "NULL";

                    $insertSql = "INSERT INTO `tbl_employee_attachments` (`employee_id`, `employee_code`, `document_name`, `expiry_date`, `file_path`, `original_file_name`, `remarks`, `status`, `created_at`) VALUES ('$emp_id', '$emp_code_esc', '$doc_name_esc', $exp_date_sql, '$relFilePath', '$origName_esc', '$remarks_esc', 'Active', NOW())";

                    if (mysqli_query($this->varDBConnection, $insertSql)) {
                        echo json_encode(['status' => 'success', 'message' => 'Document attachment uploaded successfully!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($this->varDBConnection)]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save uploaded file.']);
                }
            break;

            case 'list_employee_attachments':
                $emp_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;
                $sql = "SELECT a.*, e.employee_name FROM tbl_employee_attachments a LEFT JOIN tbl_employees e ON a.employee_id = e.employee_id WHERE a.status = 'Active'";
                if ($emp_id > 0) {
                    $sql .= " AND a.employee_id = '$emp_id'";
                }
                $sql .= " ORDER BY a.attachment_id DESC";

                $res = mysqli_query($this->varDBConnection, $sql);
                $data = [];
                if ($res) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $row['expiry_date_format'] = (!empty($row['expiry_date']) && $row['expiry_date'] != '0000-00-00') ? date('d-m-Y', strtotime($row['expiry_date'])) : 'N/A';
                        $row['created_at_format'] = date('d-m-Y H:i', strtotime($row['created_at']));
                        $data[] = $row;
                    }
                }
                echo json_encode(['data' => $data]);
            break;

            case 'delete_employee_attachment':
                $att_id = isset($_POST['attachment_id']) ? intval($_POST['attachment_id']) : 0;
                if ($att_id > 0) {
                    mysqli_query($this->varDBConnection, "UPDATE tbl_employee_attachments SET status = 'Deleted' WHERE attachment_id = '$att_id'");
                    echo json_encode(['status' => 'success', 'message' => 'Attachment deleted successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid attachment ID.']);
                }
            break;
             
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new apartmentController();
$obj->RequestAccept($obj->actionevents);