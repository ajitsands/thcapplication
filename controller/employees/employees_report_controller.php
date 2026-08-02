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
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
        $this->employee_type_id = $_POST['v_employee_type_id'];
        $this->employee_type_name = $_POST['v_employee_type_name'];
         $this->expertise_id = $_POST['v_expertise_id'];
        $this->expertise_name = $_POST['v_expertise_name'];
        $this->employee_tech_type_name = $_POST['v_emp_tech_type_name'];
         date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        $array[0] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on from 	view_employee_expertiser_list order by employee_name asc";
        
        $array[1] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on from 	view_employee_expertiser_list where employee_type_id ='".$this->employee_type_id."' and employee_id IN(SELECT employee_id FROM `tbl_technician_expertise` WHERE `expertise_id` IN ('".$this->expertise_id."')) order by employee_name asc";
        
        $array[2] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on from 	view_employee_expertiser_list where employee_type_id ='".$this->employee_type_id."' and technician_type='".$this->employee_tech_type_name."' and employee_id IN(SELECT employee_id FROM `tbl_technician_expertise` WHERE `expertise_id` IN ('".$this->expertise_id."')) order by employee_name asc";
        
        $array[3] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on from 	view_employee_expertiser_list where employee_type_id ='".$this->employee_type_id."' order by employee_name asc";
        
        $array[4] = "select *,DATE_FORMAT(joining_date, '%d-%m-%Y') as joining_date,DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as cpr_expiry_date,DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as visa_validity_on from 	view_employee_expertiser_list where employee_type_id ='".$this->employee_type_id."' and technician_type='".$this->employee_tech_type_name."' order by employee_name asc";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
     
        switch ($FunctionEvents)
        {
        
            
            
            case 'employee_list_view':
          
           if($this->employee_type_id=='All')
           {
                // echo $var[0];
                $this->varModelObj->ListFromTable($var[0]); 
           }
           else if($this->employee_type_id=='8')
           {
               if($this->employee_tech_type_name=='Both' && $this->expertise_id!="")
               {
                    // echo $var[1];
                    $this->varModelObj->ListFromTable($var[1]); 
               }
               else if($this->employee_tech_type_name=='Both' && $this->expertise_id=="")
               {
                    // echo $var[3];
                    $this->varModelObj->ListFromTable($var[3]); 
               }
               else if($this->employee_tech_type_name!='Both' && $this->expertise_id=="")
               {
                    // echo $var[4];
                    $this->varModelObj->ListFromTable($var[4]); 
               }
               else
               {
                     //echo $var[2];
                    $this->varModelObj->ListFromTable($var[2]); 
               }
                 
           }
           else
           {
               // echo $var[3];
               $this->varModelObj->ListFromTable($var[3]); 
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
?>