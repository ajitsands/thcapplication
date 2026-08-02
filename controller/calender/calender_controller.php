<?php

require ('../../model/common/common_functions.php');




class calenderController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$visit_id;
        public $tech_name_arr, $tech_id_arr;
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->visit_id = $_POST['visit_id'];
        $this->amc_ref_no=$_POST['v_amc_ref_no'];
        $this->amc_tkt_id=$_POST['v_amc_tkt_id'];
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        
        $this->amc_no=$_POST['amc_no'];
        $this->visit_date=$_POST['visit_date'];
        $this->visit_time=$_POST['visit_time'];
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "SELECT * FROM tbl_tickets WHERE ticket_ref_code='".$this->amc_no."' and ticket_id in (select amc_tkt_id from  tbl_visits where amc_tkt_ref_no='".$this->amc_no."' and date_of_visits='".$this->visit_date."' and visit_start_time='".$this->visit_time."')";
        $array[3] = "SELECT * FROM tbl_ticket_teams WHERE visit_id='".$this->visit_id."'";
        $array[2] ="SELECT  DISTINCT `customer_name`,`customer_code`,`visit_mode`,time_of_visit,additional_slots,amc_ticket,amc_tkt_id, date_format(MIN(`date_of_visits`),'%M ,%d %Y') as start_date ,date_format(MAX(`date_of_visits`),'%M ,%d %Y') as end_date,building_name,location_name,visit_start_time FROM `tbl_visits` WHERE `amc_tkt_ref_no`='".$this->amc_ref_no."' group by visit_mode,time_of_visit,date_of_visits";
	    $array[4] ="SELECT  ticket_priority,service_request,job_category,building_name,location_name FROM `tbl_tickets` WHERE `ticket_id`='".$this->ticket_id."'";
	    $array[5] ="SELECT asset_location,asset_building,category_name,asset_type_name,asset_ref_no FROM  view_amc_asset_details WHERE amc_child_id in (select amc_tkt_id from  tbl_visits where amc_tkt_ref_no='".$this->amc_no."' and date_of_visits='".$this->visit_date."' and visit_start_time='".$this->visit_time."')";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
            case 'check_ticket_details':
            //echo $var[4];
                $this->varModelObj->ListFromTable($var[4]);
            break;
             case 'list_of_team':
                 
                 $this->varModelObj->ListFromTable($var[3]);
                 break;
              case 'check_asset_schedule':
           
             $this->varModelObj->ListFromTable($var[2]);
             break;
            case 'list_of_tkt_asset_details':
              
                 $this->varModelObj->ListFromTable($var[1]);
                 break;
               case 'list_of_amc_asset_details':  
                  
                 $this->varModelObj->ListFromTable($var[5]);
                 break;
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new calenderController();
$obj->RequestAccept($obj->actionevents);
?>