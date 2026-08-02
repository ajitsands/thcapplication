<?php

require ('../../model/common/common_functions.php');




class locationController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name ;
        
        
    function __construct()
	{
	    
        
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
		$this->location_id = $_POST['v_location_id'];
        $this->location_status = $_POST['v_location_status'];
        $this->location_code = strtoupper($_POST['v_location_code']);
        
        
        $this->location_action = $_POST['v_location_action'];
       $this->location_name = $this->varDBConnection->real_escape_string($_POST['location_name']);
       
        
		
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
      
        $array[1] = "INSERT INTO `tbl_location` (`location_name`, location_code,`location_status`) VALUES ('".$this->location_name."', '". $this->location_code ."' ,'Active' )";
        
        
        $array[2] = "select * from 	tbl_location order by location_id desc";
        
      
         $array[3] ="update tbl_location set `location_status`='Active' where location_id='".$this->location_id."'";
        
         $array[4] ="update tbl_location set `location_status`='Deactive' where location_id='".$this->location_id."'";
         
         $array[5] = "update tbl_location set location_name='".$this->location_name."',location_code='".$this->location_code."' where location_id='".$this->location_id."' ";
       $array[6] = "select * from tbl_location where location_code='".$this->location_code."' ";
		
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

             case 'add_location':
               
                if ($this->varModelObj->ReturnCountValue($var[6])==0)
                        {
                         
                            $this->inserted_id = $this->varModelObj->AddToTable($var[1]);
                            
                        }
                        else{
                            echo 'Location Code - '.$this->location_code." -  already exists...!";
                        }
                
            break;
           
            case 'list_building':
            
                $this->varModelObj->ListFromTable($var[2]);
            break;
            case 'update_location':
              
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_location_status':
                if($this->location_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[3]);
                }
                else
                {
                   
                  $this->varModelObj->UpdateTable($var[4]);  
                }
            break;
            
            case 'check_location_code':
            
                if($this->varModelObj->ReturnCountValue($var[6])==0)
                  {
                      echo "not exist";
                  }
                else
                  {
                    echo 1;
                  }
            break;
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new locationController();
$obj->RequestAccept($obj->actionevents);
?>