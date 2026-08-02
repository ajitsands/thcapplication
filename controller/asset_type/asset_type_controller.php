<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$exp_id, $exp_name,$exp_status;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->category_name = $_POST['v_category_name'];
        $this->category_id = $_POST['v_category_id'];
		$this->asset_name = $_POST['v_asset_name'];
		$this->asset_id = $_POST['v_asset_id'];
        $this->asset_status = $_POST['v_asset_status'];
        $this->action_status = $_POST['v_action_status'];
      
        //v_asset_status
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_asset_type` (`asset_type_name`,`category_id`,`category_name`,`asset_type_status`) VALUES ('".$this->asset_name."','".$this->category_id."','".$this->category_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_asset_type order by asset_type_id desc";
        
      
         $array[3] ="update tbl_asset_type set `asset_type_status`='Active' where asset_type_id='".$this->asset_id."'";
        
         $array[4] ="update tbl_asset_type set `asset_type_status`='Deactive' where asset_type_id='".$this->asset_id."'";
         
         $array[5] = "update tbl_asset_type set asset_type_name='".$this->asset_name."',category_id='".$this->category_id."',category_name='".$this->category_name."' where asset_type_id='".$this->asset_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_asset_type':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_asset_type':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_asset_type':
                echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_asset_type_status':
               // echo $this->action_status;
                if($this->action_status=='Active')
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