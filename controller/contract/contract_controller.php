<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$exp_id, $exp_name,$exp_status,$contr_action_status;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->contract_name = $_POST['v_contract_type_name'];
        $this->contract_id = $_POST['v_contract_type_id'];
        $this->contract_status = $_POST['v_contract_type_status'];
      
          $this->contr_action_status = $_POST['v_contr_action_status'];
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_contract_types` (`contract_type_name`, `contract_type_status`) VALUES ('".$this->contract_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_contract_types order by contract_type_id desc";
        
      
         $array[3] ="update tbl_contract_types set `contract_type_status`='Active' where contract_type_id='".$this->contract_id."'";
        
         $array[4] ="update tbl_contract_types set `contract_type_status`='Deactive' where contract_type_id='".$this->contract_id."'";
         
         $array[5] = "update tbl_contract_types set contract_type_name='".$this->contract_name."' where contract_type_id='".$this->contract_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_contract':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_contract':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_contract':
                echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_contract_status':
                if($this->contr_action_status=='Active')
                {
                  $this->varModelObj->UpdateTable($var[3]);
                }
                else
                {
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