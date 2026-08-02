<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$team_name, $team_leader_id,$team_leader_code,$team_leader_name,$tech_name,$tech_id,$tech_id_length;
        public $tech_name_arr, $tech_id_arr;
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
       
        $this->team_name = $_POST['v_team_name'];
        $this->team_leader_id = $_POST['v_team_leader_id'];
        $this->team_leader_code = $_POST['v_team_leader_code'];
        $this->team_leader_name = $_POST['v_team_leader_name'];
        
        $this->tech_name = $_POST['v_tech_name'];
        $this->tech_id = $_POST['v_tech_id'];
        $this->tech_name_arr = explode ("^", $this->tech_name);
        $this->tech_id_arr = explode ("^", $this->tech_id);
        
       
       // echo $this->tech_name_arr[0];
       // echo $this->tech_name_arr[1];
       // echo $this->tech_id_arr[0];
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        $this->tech_id_length=sizeof($this->tech_id_arr);
        
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_team` (`team_name`, `employee_id`, `employee_code`, `employee_name`, `employee_type_id`, `employee_type_name`, `team_status`) VALUES ('".$this->team_name."','".$this->team_leader_id."','".$this->team_leader_code."','".$this->team_leader_name."',7,'Team Leader','Active' )";
        $array[2] = "INSERT INTO `tbl_team` (`team_name`, `employee_id`, `employee_code`, `employee_name`, `employee_type_id`, `employee_type_name`,`expertise_name`, `team_status`) VALUES ('".$this->team_name."','".$this->tech_id."','".$this->tech_code."','".$this->tech_name."',8,'Technician','".$this->tech_expertise."','Active' )";
        $array[3] = "SELECT * FROM tbl_team WHERE team_status='Active'";
        
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
           
           
            
            
             case 'add_team_members':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
                
               
                  if($this->tech_id_length>0)
              {
                  for($this->x = 0; $this->x < $this->tech_id_length-1; $this->x++){
                      
                     $this->tech_id_arr1= $this->tech_id_arr[$this->x];
                     $this->tech_id_code = explode ("-->", $this->tech_id_arr1);
                     $this->tech_id=$this->tech_id_code[0];
                     $this->tech_code=$this->tech_id_code[1];
                     $this->tech_name_arr1= $this->tech_name_arr[$this->x];
                     $this->tech_name_arr2 = explode ("-->", $this->tech_name_arr1);
                     $this->tech_name=$this->tech_name_arr2[0];
                     $this->tech_expertise=$this->tech_name_arr2[1];
                     $var =  $this->SQLArray();
                     $this->varModelObj->AddToTable($var[2]);
                  }
              }
            break;
             case 'list_of_team':
                 $this->varModelObj->ListFromTable($var[3]);
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