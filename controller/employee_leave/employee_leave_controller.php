<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
         var $varModelObj,$varDBConnection;
         public $actionevents,$ctrl_name,$employee_type_id, $start_date,$end_date,$type_of_leave,$reason_for_leave,$employee_code,$employee_name,$employee_status,$employee_action;
         public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        //$this->ctrl_name = $_POST['v_ctrl_name'];
       
        $this->employee_name = isset($_POST['v_employee_name']) ? $_POST['v_employee_name'] : '';
        $this->employee_code = isset($_POST['v_employee_code']) ? $_POST['v_employee_code'] : '';
        $this->start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $this->end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
        $this->type_of_leave = isset($_POST['type_of_leave']) ? $_POST['type_of_leave'] : '';
        $this->reason_for_leave = isset($_POST['reason_for_leave']) ? $_POST['reason_for_leave'] : '';
        $this->reason_for_leave = $this->varDBConnection->real_escape_string($this->reason_for_leave);
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        $array[0]="call proc_add_employee_leave('".$this->employee_code."','".$this->employee_name."','".$this->type_of_leave."','".$this->reason_for_leave."','".$this->start_date."','".$this->end_date."')";
        //$array[1] ="SELECT * FROM `tbl_employee_leave` where end_time>'".$this->current_date."'";
        $array[1] ="SELECT * FROM `tbl_employee_leave` WHERE `employee_code` IN(SELECT `employee_code` from `tbl_employees` WHERE `employee_status`='Deactive')";
        $array[2] ="UPDATE `tbl_employees` SET `employee_status`='Active' WHERE `employee_code`='".$this->employee_code."'";
         
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'add_leave_for_employee':
            //echo $var[0];
                $this->varModelObj->ExecuteProcedure($var[0]);
            break;
            case 'employee_on_leave_list':
                $emp_type = isset($_POST['emp_type']) ? $_POST['emp_type'] : 'all';
                $leave_type = isset($_POST['leave_type']) ? $_POST['leave_type'] : 'all';
                $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : '';
                $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : '';

                $query = "SELECT l.* FROM tbl_employee_leave l LEFT JOIN tbl_employees e ON l.employee_code = e.employee_code WHERE e.employee_status='Deactive'";

                if ($emp_type !== 'all' && !empty($emp_type)) {
                    $emp_type_esc = $this->varDBConnection->real_escape_string($emp_type);
                    $query .= " AND e.user_type_id = '$emp_type_esc'";
                }
                if ($leave_type !== 'all' && !empty($leave_type)) {
                    $leave_type_esc = $this->varDBConnection->real_escape_string($leave_type);
                    $query .= " AND l.leave_reason LIKE '%$leave_type_esc%'";
                }
                if (!empty($from_date)) {
                    $from_date_esc = $this->varDBConnection->real_escape_string($from_date);
                    $query .= " AND DATE(l.start_time) >= '$from_date_esc'";
                }
                if (!empty($to_date)) {
                    $to_date_esc = $this->varDBConnection->real_escape_string($to_date);
                    $query .= " AND DATE(l.end_time) <= '$to_date_esc'";
                }

                $this->varModelObj->ListFromTable($query);
            break;
            case 'change_employee_leave_status':
            //echo $var[1];
                $this->varModelObj->UpdateTable($var[2]);
            break;
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new apartmentController();
$obj->RequestAccept($obj->actionevents);
?>