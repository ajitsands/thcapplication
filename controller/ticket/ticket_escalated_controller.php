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
        $this->remarks = $this->varDBConnection->real_escape_string($_POST['remarks']);
        $this->servive_escalated_close = $this->varDBConnection->real_escape_string($_POST['servive_escalated_close']);
        $this->foc = $_POST['foc'];
        $this->close_image = $_POST['close_image'];
        $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
        
        $this->ticket_count=$_POST['ticket_count'];
        $this->domain_path="http://thc.sianlab.com/httpdocs/";
        $this->service_report_no = $this->varDBConnection->real_escape_string($_POST['service_report_no']);
        
         
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
       
         $array[0] = "select distinct(ticket_ref_code) as ticket_ref_code,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i:%s') as created_date_time,customer_id,customer_code,customer_name,location_code,location_name,building_code,building_name,ticket_priority,location_id,building_id,ticket_ref_no,ticket_status  from  tbl_tickets where ticket_status not in ('Opened','Closed','Cancelled') and ticket_id  in (select amc_tkt_id from tbl_visits where DATE_FORMAT(date_of_visits, '%Y-%m-%d')>='2026-01-01' and DATE_FORMAT(date_of_visits, '%Y-%m-%d') < CURDATE())  group by ticket_ref_code order by YEAR(created_date_time) desc,MONTH(created_date_time) desc,DAY(created_date_time) desc,HOUR(created_date_time) desc,MINUTE(created_date_time) desc,SECOND(created_date_time) desc";
         $array[1] = "select * ,DATE_FORMAT(date_needed, '%d-%m-%Y') as date_needed, DATE_FORMAT(quote_date, '%d-%m-%Y') as quote_date,CONCAT('".$this->domain_path."images/ticket_close_image/',service_report_image) as service_report_image from  tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."' and ticket_status not in ('Closed','Cancelled','Opened')";
         $array[5] = "select * from   tbl_ticket_teams where ticket_id=".$this->ticket_id." and visit_id=".$this->visit_id." and amc_ticket='TKT' and ticket_team_status  in ('Active') ";
         $array[4] = "select *, DATE_FORMAT(date_of_visits,'%d-%m-%Y') as date_of_visits from   tbl_visits where amc_tkt_id=".$this->ticket_id." and amc_ticket='TKT' and amc_visit_status not in ('Completed','Closed','Cancelled') ";
         
         $array[6] = "update tbl_tickets set ticket_status='Opened',escalated_status='Yes',escalated_reason='".$this->remarks."',escalated_id='".$this->user_id."',escalated_date_time='".$this->createddatetime."' where ticket_id ='".$this->ticket_id."' ";
         $array[7] = "update  tbl_ticket_teams set 	ticket_team_status='Deactive',escalated_status='Yes' where ticket_id ='".$this->ticket_id."' and amc_ticket='TKT' ";
         $array[8] = "update  tbl_visits set amc_visit_status='Cancelled',escalated_status='Yes',amc_schedule_color='#B23CFD' where amc_tkt_id ='".$this->ticket_id."' and amc_ticket='TKT' ";
      
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
         
             
              case 'list_escalated_ticket':
      
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
				//echo "Q  :".$var[1];
                 $this->varModelObj->ListFromTable($var[1]);
             break;
              case 'list_ticket_team':
          
                 $this->varModelObj->ListFromTable($var[5]);
             break;
             case 'list_ticket_visits':
         
                 $this->varModelObj->ListFromTable($var[4]);
             break;
              case 'close_ticket':
                    if($this->close_image!='NA')
                    {
                        mysqli_query($this->varDBConnection,"update  tbl_tickets set closed_reason='".$this->remarks."', service_report_image='".$this->close_image."',closed_by_id=".$this->user_id.",closed_by_name='".$this->username."', closed_on='".$this->createddatetime."',ticket_status='Closed',service_report_no='".$this->service_report_no."',service_report_upload_by_code='".$this->username."',service_report_upload_date_time='".$this->createddatetime."',foc='".$this->foc."', service_report_remarks='".$this->servive_escalated_close."' where ticket_id=".$this->ticket_id);
                        mysqli_query($this->varDBConnection,"update  tbl_visits set amc_visit_status='Closed',amc_schedule_color='#4CAF50' where amc_ticket='TKT' and amc_tkt_id=".$this->ticket_id);
                        
                    }
                    else
                    { 
                        mysqli_query($this->varDBConnection,"update  tbl_tickets set closed_reason='".$this->remarks."',foc='".$this->foc."',closed_by_id=".$this->user_id.",closed_by_name='".$this->username."', closed_on='".$this->createddatetime."',ticket_status='Closed',service_report_no='".$this->service_report_no."', service_report_remarks='".$this->servive_escalated_close."' where ticket_id=".$this->ticket_id);
                        mysqli_query($this->varDBConnection,"update  tbl_visits set amc_visit_status='Closed',amc_schedule_color='#4CAF50' where amc_ticket='TKT' and amc_tkt_id=".$this->ticket_id);
                           
                    }
           
             break;
             
            case 'cancel_ticket': 
                
                mysqli_query($this->varDBConnection,"update  tbl_tickets set cancelled_reason='".$this->remarks."',cancelled_by_id=".$this->user_id.",cancelled_by_name='".$this->username."', cancelled_date_time='".$this->createddatetime."',ticket_status='Cancelled' where ticket_id=".$this->ticket_id);
                mysqli_query($this->varDBConnection,"update  tbl_visits set amc_visit_status='Cancelled',amc_schedule_color='#B23CFD' where amc_ticket='TKT' and amc_tkt_id=".$this->ticket_id);
                       
            break; 
             
            case 'reopen_ticket':
                $this->varModelObj->UpdateTable($var[6]);
                $this->varModelObj->UpdateTable($var[7]);
                $this->varModelObj->UpdateTable($var[8]);
               
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