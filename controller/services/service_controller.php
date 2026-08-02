<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
        var $varModelObj,$varDBConnection;
      public $actionevents,$ctrl_name,$employee_type_id, $employee_type_name,$employee_code,$emp_cnt, $employee_password,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1,$services_action;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->category_type_id = $_POST['v_category_type_id'];
        $this->category_type_name = $_POST['v_category_type_name'];
        $this->category_asset_type_id = $_POST['v_category_asset_type_id'];
        $this->category_asset_type_name = $_POST['v_category_asset_type_name'];
        $this->service_desc = $_POST['v_service_desc'];
        $this->service_id = $_POST['v_service_id'];
        $this->v_service_status = $_POST['v_service_status'];
        
        $this->services_action = $_POST['v_services_action'];
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        $array[1]="call proc_add_service_details(".$this->category_type_id.",'".$this->category_type_name."',".$this->category_asset_type_id.",'".$this->category_asset_type_name."','".$this->service_desc."',@msg )";
        $array[2] = "select * from  tbl_services order by service_id desc";
        $array[3]="call proc_edit_service_details(".$this->service_id.",'".$this->service_desc."',".$this->category_type_id.",'".$this->category_type_name."',".$this->category_asset_type_id.",'".$this->category_asset_type_name."')";
        $array[4] ="update tbl_services set `service_status`='Deactive' where service_id=".$this->service_id."";
        $array[5] ="update tbl_services set `service_status`='Active' where service_id=".$this->service_id."";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'add_service':
            echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
            
             case 'service_list_view':
            
                 $this->varModelObj->ListFromTable($var[2]);
             break;

            case 'update_service':
            echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
            
            
            case 'change_service_status':
                if($this->services_action=='Active')
                {
                    //echo $var[4];
                  $this->varModelObj->UpdateTable($var[5]);
                }
                else
                {
                    //echo $var[5];
                  $this->varModelObj->UpdateTable($var[4]);  
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