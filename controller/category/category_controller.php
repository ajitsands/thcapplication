<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$exp_id, $exp_name,$exp_status,$action_cat_status;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->category_name = $_POST['v_category_name'];
        $this->category_id = $_POST['v_category_id'];
        $this->category_status = $_POST['v_category_status'];
        $this->action_cat_status = $_POST['v_action_cat_status'];
      
        
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_category` (`category_name`, `category_status`) VALUES ('".$this->category_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_category order by category_id desc";
        
      
         $array[3] ="update tbl_category set `category_status`='Active' where category_id='".$this->category_id."'";
        
         $array[4] ="update tbl_category set `category_status`='Deactive' where category_id='".$this->category_id."'";
         
         $array[5] = "update tbl_category set category_name='".$this->category_name."' where category_id='".$this->category_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_category':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_category':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_category':
                echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_category_status':
                if($this->action_cat_status=='Active')
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