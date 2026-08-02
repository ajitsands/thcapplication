<?php

require ('../../model/common/common_functions.php');



class ticketController
{
        var $varModelObj,$varDBConnection;
         public $actionevents,$ticket_ref_code,$ticket_id;
        //public $actionevents,$customer_id,$ticket_ref_code_new,$ticket_ref_no_new,$ticket_id_new,$inserted_id,$idsinsert,$techslot_insert_id,$ticket_count,$count_slots;
         
    function __construct()
	{
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->createddate = date('Y-m-d');
        $this->ticket_ref_code = $this->varDBConnection->real_escape_string($_POST['ticket_ref_code']);
        $this->ticket_id = $_POST['ticket_id'];
        
  
         
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
       
         $array[0] = "select distinct(ticket_ref_code) as ticket_ref_code,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i:%s') as created_date_time,customer_id,customer_code,customer_name,location_code,location_name,building_code,building_name,ticket_priority,location_id,building_id,ticket_ref_no  from  tbl_tickets where ticket_status='Extended'  group by ticket_ref_code order by YEAR(created_date_time) desc,MONTH(created_date_time) desc,DAY(created_date_time) desc,HOUR(created_date_time) desc,MINUTE(created_date_time) desc,SECOND(created_date_time) desc";
         $array[1] = "select * from  tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."' and ticket_status='Extended'";
         $array[2] = "select *,CURDATE() as cur_date,'select' as cur_time,DATE_FORMAT(date_needed, '%d-%m-%Y') as date_needed,DATE_FORMAT(quote_date, '%d-%m-%Y') as quote_date,ticket_id from  tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."' and ticket_status='Extended'";
         $array[3] = "select * from  tbl_ticket_services where ticket_id=".$this->ticket_id." ";
         $array[4] = "select *, DATE_FORMAT(requisition_date,'%d-%m-%Y') as req_date from  tbl_mateial_requisition where amc_ticket_ids=".$this->ticket_id." and requisition_mode='TKT' and status not in ('Pending') ";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
         
             
              case 'list_extended_ticket':
          
                $this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[0]);
				if($this->jsondata == '[]')
				{
					echo "NoData";  
				}
				else
				{
					echo $this->jsondata;
				}
             break;
             case 'list_ticket_entries':
          
                 $this->varModelObj->ListFromTable($var[1]);
             break;
             case 'schedule_ticket_category_list':
          
                 $this->varModelObj->ListFromTable($var[2]);
             break;
              case 'list_assigned_services':
         
                 $this->varModelObj->ListFromTable($var[3]);
             break;
              case 'list_of_requisitions':
         
                 $this->varModelObj->ListFromTable($var[4]);
             break;
             
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new ticketController();
$obj->RequestAccept($obj->actionevents);
?>