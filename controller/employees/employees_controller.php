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
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
     
        switch ($FunctionEvents)
        {
        
            case 'employee_code_check':
                //echo $var[9];
              // $this->varModelObj->ReturnCountValue($var[9]);
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
                
                if($this->expertise_length>0)
              {
                  for($this->x = 0; $this->x < $this->expertise_length; $this->x++){
                      //echo "if";
                     // echo $var[1];
                     $this->str[] = "('{$this->expertise_id[$this->x]}','{$this->expertise_name[$this->x]}')";
                     $this->expertise_id1= $this->expertise_id[$this->x];
                     $this->expertise_name1= $this->expertise_name[$this->x];
                     $var =  $this->SQLArray();
                     $this->varModelObj->ExecuteProcedure($var[1]);
                  }
              }
              else
              {
                  //echo $var[1];
                    //echo "else";
                    $this->expertise_id1=0;
                    $this->expertise_name1='NA';
                    $this->varModelObj->ExecuteProcedure($var[1]);   
              }
              //echo $var[1];
               
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
                    $where1 .= " AND e.user_type_id = '$emp_type_esc'";
                    $where2 .= " AND e.user_type_id = '$emp_type_esc'";
                }
                if ($leave_type !== 'all' && !empty($leave_type)) {
                    $leave_type_esc = $this->varDBConnection->real_escape_string($leave_type);
                    $where1 .= " AND s.leave_type = '$leave_type_esc'";
                    $where2 .= " AND l.leave_reason LIKE '%$leave_type_esc%'";
                }
                if (!empty($from_date)) {
                    $from_date_esc = $this->varDBConnection->real_escape_string($from_date);
                    $where1 .= " AND s.leave_start_date >= '$from_date_esc'";
                    $where2 .= " AND DATE(l.start_time) >= '$from_date_esc'";
                }
                if (!empty($to_date)) {
                    $to_date_esc = $this->varDBConnection->real_escape_string($to_date);
                    $where1 .= " AND s.leave_end_date <= '$to_date_esc'";
                    $where2 .= " AND DATE(l.end_time) <= '$to_date_esc'";
                }

                $sql = "SELECT CONCAT(s.employee_name, ' - ', s.leave_type) AS title, s.leave_start_date AS start, DATE_ADD(s.leave_end_date, INTERVAL 1 DAY) AS end, CASE s.leave_type WHEN 'Sick Leave' THEN '#ef5350' WHEN 'Casual Leave' THEN '#42a5f5' WHEN 'Annual Leave' THEN '#66bb6a' WHEN 'Emergency Leave' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_short_leave s LEFT JOIN tbl_employees e ON s.employee_code = e.employee_code $where1 UNION ALL SELECT CONCAT(l.employee_name, ' - ', l.leave_reason) AS title, DATE(l.start_time) AS start, DATE_ADD(DATE(l.end_time), INTERVAL 1 DAY) AS end, CASE WHEN l.leave_reason LIKE '%Sick%' THEN '#ef5350' WHEN l.leave_reason LIKE '%Casual%' THEN '#42a5f5' WHEN l.leave_reason LIKE '%Annual%' THEN '#66bb6a' WHEN l.leave_reason LIKE '%Emergency%' THEN '#ffa726' ELSE '#ab47bc' END AS color FROM tbl_employee_leave l LEFT JOIN tbl_employees e ON l.employee_code = e.employee_code $where2";

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


             case 'update_employee':
                 
                  $this->varModelObj->DeleteRow($var[8]);
                 if($this->expertise_length >0)
                 {
                  for($this->x = 0; $this->x < $this->expertise_length; $this->x++){
                      
                     $this->str[] = "('{$this->expertise_id[$this->x]}','{$this->expertise_name[$this->x]}')";
                     $this->expertise_id1= $this->expertise_id[$this->x];
                     $this->expertise_name1= $this->expertise_name[$this->x];
                     $var =  $this->SQLArray();
                     echo $this->expertise_name1;
                     echo $var[3];
                     $this->varModelObj->ExecuteProcedure($var[3]);
                     }
                  }
                  else
                  {
                      //echo 'else';
                  $this->expertise_id1=0;
                  $this->expertise_name1='NA';
                  //echo $var[3];
                  $this->varModelObj->ExecuteProcedure($var[3]);   
                  }
               
              // $this->varModelObj->UpdateTable($var[3]);
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
             
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new apartmentController();
$obj->RequestAccept($obj->actionevents);