<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$exp_id, $exp_name,$exp_status,$expertise_action;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->expertise_name = $_POST['v_expertise_name'];
        $this->expertise_id = $_POST['v_expertise_id'];
        $this->expertise_status = $_POST['v_expertise_status'];
      
        $this->expertise_action = $_POST['v_expertise_action'];
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_expertise` (`expertise_name`, `expertise_status`) VALUES ('".$this->expertise_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_expertise order by expertise_id desc";
        
      
         $array[3] ="update tbl_expertise set `expertise_status`='Active' where expertise_id='".$this->expertise_id."'";
        
         $array[4] ="update tbl_expertise set `expertise_status`='Deactive' where expertise_id='".$this->expertise_id."'";
         
         $array[5] = "update tbl_expertise set expertise_name='".$this->expertise_name."' where expertise_id='".$this->expertise_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_expertise':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_expertise':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_expertise':
                echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_expertise_status':
                if($this->expertise_action=='Active')
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