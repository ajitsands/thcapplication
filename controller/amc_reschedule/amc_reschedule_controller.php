<?php

require ('../../model/common/common_functions.php');



class amcclosedController
{
    var $varModelObj,$varDBConnection;
    public $actionevents;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
        $this->amc_id = $_POST['amc_id'];
       
        $this->amc_ref_nos =$this->varDBConnection->real_escape_string($_POST['amc_ref_nos']);
         $this->amc_visit_id = $_POST['amc_visit_id'];
       $this->close_image =$this->varDBConnection->real_escape_string($_POST['close_image']);
        $this->service_report_no =$this->varDBConnection->real_escape_string($_POST['service_report_no']);
        $this->closed_reason =$this->varDBConnection->real_escape_string($_POST['closed_reason']);
        $this->amc_child_id = $_POST['amc_child_id'];
       
        
  
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
  
		$array[0] ="SELECT *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date ,CONCAT('../httpdocs/images/amc_attachements/',amc_attachment1) as amc_attachment1,CONCAT('../httpdocs/images/amc_attachements/',amc_attachment2) as amc_attachment2,CONCAT('../httpdocs/images/amc_attachements/',amc_attachment3) as amc_attachment3 FROM `tbl_amc_master` where amc_status='Active' and amc_ref_no in (select amc_tkt_ref_no from tbl_visits where amc_ticket='AMC' and amc_visit_status='Extended') order by amc_id asc";
		$array[1] ="SELECT * FROM `tbl_amc_child` where amc_child_status='Active' and amc_master_id=".$this->amc_id;
		$array[2] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits, DATE_FORMAT(amc_close_date_time, '%d-%m-%Y') as amc_close_date_time FROM `view_amc_visits` where  amc_ref_no='".$this->amc_ref_nos."' and amc_visit_status='Extended' order by year(date_of_visits),month(date_of_visits),date(date_of_visits) asc";
	
		$array[3] ="SELECT * FROM `tbl_services` where  service_status='Active' and category_id=".$this->category_id." and asset_type_id=".$this->type_id;
		
	
		$array[10] ="SELECT * FROM `tbl_ticket_teams` where  ticket_ref_no='".$this->amc_ref_nos."' and ticket_id=".$this->amc_child_id." and visit_id=".$this->amc_visit_id." and amc_ticket='AMC' and ticket_team_status='Active'";
		
		
          
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
           
            case 'amc_list':
            
                $this->varModelObj->ListFromTable($var[0]);
            break;
             case 'amc_child_list':
            
                $this->varModelObj->ListFromTable($var[1]);
            break;
             case 'amc_list_schedules':
            
           $this->varModelObj->ListFromTable($var[2]);
            break;
           case 'amc_list_services':
          
                $this->varModelObj->ListFromTable($var[3]);
            break;
          
             case 'list_assign_team':
          
                 $this->varModelObj->ListFromTable($var[10]);
             break;
          
             
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new amcclosedController();
$obj->RequestAccept($obj->actionevents);
?>