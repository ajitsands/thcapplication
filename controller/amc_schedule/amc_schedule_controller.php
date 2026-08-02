<?php

require ('../../model/common/common_functions.php');



class amcscheduleController
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
        $this->customer_name =$this->varDBConnection->real_escape_string($_POST['v_customer_name']);
        $this->amc_ref_nos =$this->varDBConnection->real_escape_string($_POST['amc_ref_nos']);
         $this->amc_visit_id = $_POST['amc_visit_id'];
        
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
  
		$array[0] ="SELECT *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date ,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment1) as amc_attachment1,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment2) as amc_attachment2,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment3) as amc_attachment3,amc_start_date as amc_start_dates,amc_end_date as amc_end_dates FROM `tbl_amc_master` where amc_status='Active' order by amc_id desc";
		$array[5] ="SELECT *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date ,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment1) as amc_attachment1,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment2) as amc_attachment2,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment3) as amc_attachment3,amc_start_date as amc_start_dates,amc_end_date as amc_end_dates FROM `tbl_amc_master` where amc_status in ('Active','Completed') order by amc_id desc";
		$array[1] ="SELECT * FROM `tbl_amc_child` where amc_child_status='Active' and amc_master_id=".$this->amc_id;
		$array[2] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits FROM `view_amc_visits` where amc_visit_status='Scheduled' and amc_ref_no='".$this->amc_ref_nos."' order by year(date_of_visits),month(date_of_visits),date(date_of_visits) asc";
		 $array[3] ="delete from  tbl_visits  where amc_visit_id=".$this->amc_visit_id;
		 $array[4] ="delete from  tbl_visits  where amc_ticket='AMC' and amc_tkt_ref_no='".$this->amc_ref_nos."' and amc_visit_status='Scheduled'";
	
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
             case 'amc_list_new':
            
                $this->varModelObj->ListFromTable($var[5]);
            break;
             case 'amc_child_list':
            
                $this->varModelObj->ListFromTable($var[1]);
            break;
             case 'amc_list_schedules':
            
                $this->varModelObj->ListFromTable($var[2]);
            break;
            case 'cancel_visit':
            
                $this->varModelObj->DeleteRow($var[3]);
            break;
            case 'cancel_all_visit':
            
                $this->varModelObj->DeleteRow($var[4]);
            break;
            
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new amcscheduleController();
$obj->RequestAccept($obj->actionevents);
?>