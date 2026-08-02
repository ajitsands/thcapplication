<?php

require ('../../model/common/common_functions.php');



class amcAssetScheduleController
{
    var $varModelObj,$varDBConnection;
    public $actionevents,$location_id,$building_id,$asset_type_id,$category_id,$customer_id,$amc_ref_no;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        
     
        $this->location_id = $_POST['v_location_id'];
        $this->building_id = $_POST['v_building_id'];
        $this->asset_type_id = $_POST['v_asset_type_id'];
        $this->category_id = $_POST['v_category_id'];
        $this->customer_id = $_POST['v_customer_id'];
        $this->amc_ref_no = $_POST['v_amc_ref_no'];
        $this->amc_visit_id = $_POST['v_visit_id'];
        $this->ticket_id = $_POST['v_ticket_id'];
        
        //$this->combo_on_change = $_POST['combo_on_change'];
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
        if($_POST['combo_on_change']=='btn_search')
        {
            $array[0] ="SELECT * FROM `tbl_assets` where customer_id='".$this->customer_id."' and amc_ref_no='".$this->amc_ref_no."' and location_id='".$this->location_id."' and building_id='".$this->building_id."' and asset_type_id='".$this->asset_type_id."' and asset_category_id='".$this->category_id."'";
        }
        else if($_POST['combo_on_change']=='amc')
        {
            $array[0] ="SELECT * FROM `tbl_assets` where customer_id='".$this->customer_id."' and amc_ref_no='".$this->amc_ref_no."'";
        }
        else if($_POST['combo_on_change']=='location')
        {
            $array[0] ="SELECT * FROM `tbl_assets` where customer_id='".$this->customer_id."' and amc_ref_no='".$this->amc_ref_no."' and location_id='".$this->location_id."'";
        }
        else if($_POST['combo_on_change']=='building')
        {
            $array[0] ="SELECT * FROM `tbl_assets` where customer_id='".$this->customer_id."' and amc_ref_no='".$this->amc_ref_no."' and location_id='".$this->location_id."' and building_id='".$this->building_id."'";
        }
        else if($_POST['combo_on_change']=='asset_type')
        {
            $array[0] ="SELECT * FROM `tbl_assets` where customer_id='".$this->customer_id."' and amc_ref_no='".$this->amc_ref_no."' and location_id='".$this->location_id."' and building_id='".$this->building_id."' and asset_type_id='".$this->asset_type_id."'";
        }
        else
        {
            $array[0] ="SELECT * FROM `tbl_assets` where customer_id='".$this->customer_id."' and amc_ref_no='".$this->amc_ref_no."' and location_id='".$this->location_id."' and building_id='".$this->building_id."' and asset_type_id='".$this->asset_type_id."' and asset_category_id='".$this->category_id."'";
        }
		
		$array[1] ="SELECT amc_start_date,amc_end_date FROM `tbl_amc_master` where amc_ref_no='".$this->amc_ref_no."'";
		
		$array[2] ="SELECT  DISTINCT `customer_name`,`customer_code`,`visit_mode`,time_of_visit,additional_slots,amc_ticket,amc_tkt_id, date_format(MIN(`date_of_visits`),'%M ,%d %Y') as start_date ,date_format(MAX(`date_of_visits`),'%M ,%d %Y') as end_date FROM `tbl_visits` WHERE `amc_tkt_ref_no`='".$this->amc_ref_no."' group by visit_mode";
		
        $array[3] ="SELECT asset_code,building_name,location_name,category_name,asset_type_name FROM `tbl_asset_schedule` where visit_id='".$this->amc_visit_id."'";
		
		$array[4] ="SELECT  ticket_priority,service_request,job_category,building_name,location_name FROM `tbl_tickets` WHERE `ticket_id`='".$this->ticket_id."'";
		
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'amc_asset_schedule_list_view':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[0]);
            break;
            case 'start_date_end_date_list':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[1]);
            break;
            case 'check_asset_schedule':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[2]);
            break;
            case 'select_asset_details':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[3]);
            break;
            case 'check_ticket_details':
            //echo $var[4];
                $this->varModelObj->ListFromTable($var[4]);
            break;
            
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new amcAssetScheduleController();
$obj->RequestAccept($obj->actionevents);
?>