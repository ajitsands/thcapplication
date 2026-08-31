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

                $where1 = " WHERE 1=1";
                $where2 = " WHERE 1=1";

                if ($emp_type !== 'all' && !empty($emp_type)) {
                    $emp_type_esc = $this->varDBConnection->real_escape_string($emp_type);
                    $where1 .= " AND e.employee_type_id = '$emp_type_esc'";
                    $where2 .= " AND e.employee_type_id = '$emp_type_esc'";
                }
                if ($leave_type !== 'all' && !empty($leave_type)) {
                    $leave_type_esc = $this->varDBConnection->real_escape_string($leave_type);
                    $where1 .= " AND (s.leave_type = '$leave_type_esc' OR s.leave_reason LIKE '%$leave_type_esc%')";
                    $where2 .= " AND (l.leave_type = '$leave_type_esc' OR l.leave_reason LIKE '%$leave_type_esc%')";
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

                $query = "SELECT s.leave_id, 'short' AS table_source, COALESCE(e.employee_code, s.employee_code) AS employee_code, COALESCE(e.employee_name, s.employee_name) AS employee_name, s.leave_type, COALESCE(s.leave_reason, '') AS leave_reason, s.leave_start_date AS start_date_raw, s.leave_end_date AS end_date_raw, DATE_FORMAT(s.leave_start_date, '%d-%m-%Y') AS start_time, DATE_FORMAT(s.leave_end_date, '%d-%m-%Y') AS end_time, COALESCE(lt1.leave_type_color, '#26a69a') AS leave_type_color FROM tbl_employee_short_leave s LEFT JOIN tbl_employees e ON (s.employee_code = e.employee_code OR s.employee_id = e.employee_id) LEFT JOIN tbl_leave_types lt1 ON s.leave_type = lt1.leave_type_name $where1 UNION ALL SELECT l.leave_id, 'leave' AS table_source, COALESCE(e.employee_code, l.employee_code) AS employee_code, COALESCE(e.employee_name, l.employee_name) AS employee_name, CASE WHEN l.leave_type IS NOT NULL AND l.leave_type != 'NA' AND l.leave_type != '' AND l.leave_type != 'select' THEN l.leave_type WHEN l.leave_reason LIKE '%Sick%' THEN 'Sick Leave' WHEN l.leave_reason LIKE '%Casual%' THEN 'Casual Leave' WHEN l.leave_reason LIKE '%Annual%' THEN 'Annual Leave' WHEN l.leave_reason LIKE '%Emergency%' THEN 'Emergency Leave' WHEN l.leave_reason LIKE '%Privilege%' THEN 'Privilege Leave' ELSE 'Leave' END AS leave_type, COALESCE(l.leave_reason, '') AS leave_reason, DATE_FORMAT(l.start_time, '%Y-%m-%d') AS start_date_raw, DATE_FORMAT(l.end_time, '%Y-%m-%d') AS end_date_raw, DATE_FORMAT(l.start_time, '%d-%m-%Y') AS start_time, DATE_FORMAT(l.end_time, '%d-%m-%Y') AS end_time, COALESCE(lt2.leave_type_color, '#26a69a') AS leave_type_color FROM tbl_employee_leave l LEFT JOIN tbl_employees e ON (l.employee_code = e.employee_code OR CONCAT(l.employee_code, '-', l.employee_name) = e.employee_code OR e.employee_code LIKE CONCAT('%', l.employee_code, '%') OR l.employee_name = e.employee_name) LEFT JOIN tbl_leave_types lt2 ON (l.leave_type = lt2.leave_type_name) $where2 ORDER BY leave_id DESC";

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