<?php

require ('../../model/common/common_functions.php');




class projectController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->project_name = $_POST['v_project_name'];
        $this->project_id = $_POST['v_project_id'];
        $this->project_status = $_POST['v_project_status'];
      
        $this->project_action = $_POST['v_project_action'];
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_project` (`project_name`, `project_status`) VALUES ('".$this->project_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_project order by project_id desc";
        
      
         $array[3] ="update tbl_project set `project_status`='Active' where project_id='".$this->project_id."'";
        
         $array[4] ="update tbl_project set `project_status`='Deactive' where project_id='".$this->project_id."'";
         
         $array[5] = "update tbl_project set project_name='".$this->project_name."' where project_id='".$this->project_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_project':
               
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_project':
            
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_project':
              
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_project_status':
                if($this->project_action=='Active')
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

$obj = new projectController();
$obj->RequestAccept($obj->actionevents);
?>