<?php

require ('../../model/common/common_functions.php');




class buildingController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$building_id, $building_name, $building_address,$building_status ;
        
        
    function __construct()
	{
	    
        
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
		
        $this->building_id = $_POST['v_building_id'];
		$this->building_code = strtoupper($_POST['v_building_code']);
        $this->building_name = $this->varDBConnection->real_escape_string($_POST['v_building_name']);
        $this->building_address =$this->varDBConnection->real_escape_string($_POST['v_building_address']);
        $this->building_status=$_POST['v_building_status'];
		$this->building_action=$_POST['v_building_action'];
		
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
      
        $array[0] = "INSERT INTO `tbl_building`(`building_name`, `building_address`, `building_status`) VALUES ('".$this->building_name."','".$this->building_address."','Active')";
        $array[1] = "select * from 	tbl_building  order by building_id desc";
        $array[2] ="update tbl_building set `building_code`='".$this->building_code."',`building_name`='".$this->building_name."',`building_address`='".$this->building_address."' where building_id='".$this->building_id."'";
        $array[3] ="update tbl_building set `building_status`='Deactive' where building_id='".$this->building_id."'";
        $array[4] ="update tbl_building set `building_status`='Active' where building_id='".$this->building_id."'";
        $array[5] = "select * from 	tbl_building where building_code='".$this->building_code."'";
		$array[6] ="update tbl_building set `building_code`='".$this->building_code ."' where building_id='".$this->building_id."'";
		 $array[7] = "INSERT INTO `tbl_building`( building_code,`building_name`, `building_address`, `building_status`) VALUES ('".$this->building_code."','".$this->building_name."','".$this->building_address."','Active')";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            case 'add_building':
               // if ($this->varModelObj->ReturnCountValue($var[5])==0)
                     //   {
                        
                            $this->inserted_id =  $this->varModelObj->AddToTable($var[0]);
                            
                      //  }
                     //   else{
                     //       echo 'Building Code - '.$this->building_code." -  already exists...!";
                     //   }
                
            break;
            case 'add_building_loc':
                $this->varModelObj->AddToTable($var[7]);
                break;
            case 'list_building':
            
                $this->varModelObj->ListFromTable($var[1]);
            break;
             case 'edit_building':
                //echo $var[2];
                $this->varModelObj->UpdateTable($var[2]);
            break;
             case 'change_building_status':
                if($this->building_action=='Active')
                {
                $this->varModelObj->UpdateTable($var[4]);
                }
                else
                {
                    //echo $var[3];
                 $this->varModelObj->UpdateTable($var[3]);   
                }
            break; 
            case 'check_building_code':
            
                $this->varModelObj->ListFromTable($var[5]);
            break;
            case 'update_building_code':
            
                $this->varModelObj->UpdateTable($var[6]);
            break;
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new buildingController();
$obj->RequestAccept($obj->actionevents);
?>