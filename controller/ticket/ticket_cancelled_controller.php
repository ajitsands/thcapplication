<?php

require ('../../model/common/common_functions.php');



class ticketController
{
        var $varModelObj,$varDBConnection;
         public $actionevents,$ticket_ref_code,$ticket_id;
         
        
         
    function __construct()
	{
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->createddate = date('Y-m-d');
        $this->ticket_ref_code = $_POST['ticket_ref_code'];
        $this->ticket_id = $_POST['ticket_id'];
        $this->visit_id = $_POST['visit_id'];
        $this->close_remarks = $this->varDBConnection->real_escape_string($_POST['close_remarks']);
        $this->foc = $_POST['foc'];
        $this->close_image = $_POST['close_image'];
        $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
        
        $this->ticket_count=$_POST['ticket_count'];
        $this->domain_path="../httpdocs/";
        $this->service_report_no = $this->varDBConnection->real_escape_string($_POST['service_report_no']);
        
         
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
       
         $array[0] = "select distinct(ticket_ref_code) as ticket_ref_code,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i:%s') as created_date_time,customer_id,customer_code,customer_name,location_code,location_name,building_code,building_name,ticket_priority,location_id,building_id,ticket_ref_no,ticket_id,cancelled_reason,DATE_FORMAT(cancelled_date_time, '%d-%m-%Y') as cancelled_date_time1 from  tbl_tickets where ticket_status='Cancelled'  group by ticket_ref_code order by YEAR(created_date_time) desc,MONTH(created_date_time) desc,DAY(created_date_time) desc,HOUR(created_date_time) desc,MINUTE(created_date_time) desc,SECOND(created_date_time) desc";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'list_cancelled_ticket':
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
            
              
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new ticketController();
$obj->RequestAccept($obj->actionevents);
?>