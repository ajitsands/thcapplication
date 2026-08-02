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
       
        $this->employee_name = $_POST['v_employee_name'];
        $this->employee_code = $_POST['v_employee_code'];
        $this->start_date = $_POST['start_date'];
        $this->end_date = $_POST['end_date'];
        $this->type_of_leave = $_POST['type_of_leave'];
        $this->reason_for_leave = $_POST['reason_for_leave'];
        $this->reason_for_leave = $this->varDBConnection->real_escape_string(($this->reason_for_leave));
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
            //echo $var[1];
                $this->varModelObj->ListFromTable($var[1]);
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