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
        
        $this->visit_duration = $_POST['visit_duration'];
        $this->total_slots = $_POST['total_slots'];
        $this->visit_start_time = $_POST['visit_start_time'];
        $this->ticket_count = $_POST['ticket_count'];
        //$this->visit_date = $_POST['visit_date'];
        $this->visit_date = date("Y-m-d", strtotime($_POST['visit_date']));
        $this->visit_slot = $_POST['visit_slot'];
        $this->visit_id = $_POST['visit_id'];
        
        $this->employee_id = $_POST['employee_id'];
        $this->employee_code = $_POST['employee_code'];
        $this->employee_name = $_POST['employee_name'];
        $this->employee_contact_no = $_POST['employee_contact_no'];
        
        $this->employee_count = $_POST['employee_count'];
        $this->leadr_emp_id = $_POST['leadr_emp_id'];
        $this->total_slots = $_POST['total_slots'];
        $this->remarks = $this->varDBConnection->real_escape_string($_POST['remarks']);
        $this->status = $_POST['status'];
         $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
         $this->cancel_reason = $this->varDBConnection->real_escape_string($_POST['cancel_reason']);
         
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
       
         $array[0] = "select distinct(ticket_ref_code) as ticket_ref_code,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i:%s') as created_date_time,customer_id,customer_code,customer_name,location_code,location_name,building_code,building_name,ticket_priority,location_id,building_id,ticket_ref_no  from  tbl_tickets where ticket_status='Scheduled'  group by ticket_ref_code order by YEAR(created_date_time) desc,MONTH(created_date_time) desc,DAY(created_date_time) desc,HOUR(created_date_time) desc,MINUTE(created_date_time) desc,SECOND(created_date_time) desc";
         $array[1] = "select * from  tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."' and ticket_status='Scheduled'";
         $array[2] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits,DATE_FORMAT(date_of_visits, '%Y-%m-%d') as date_of_visits1 from  view_ticket_visits where amc_tkt_ref_no='".$this->ticket_ref_code."' and ticket_status='Scheduled'";
         $array[3] = "select * from  tbl_ticket_services where ticket_id=".$this->ticket_id." ";
         $array[4] = "select *, DATE_FORMAT(date_of_visits,'%d-%m-%Y') as date_of_visits,DATE_FORMAT(date_of_visits, '%Y-%m-%d') as date_of_visits1 from   tbl_visits where amc_tkt_id=".$this->ticket_id." and amc_ticket='TKT' and amc_visit_status  in ('Scheduled') ";
         
         
           $array[21] ="UPDATE tbl_tickets set ticket_status='Cancelled',cancelled_by_id=". $this->user_id.",cancelled_by_name='".$this->username."',cancelled_reason='".$this->remarks."',cancelled_date_time='".$this->createddatetime."' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[22] ="UPDATE  tbl_ticket_services set ticket_service_status='Cancelled' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[23] ="UPDATE tbl_tickets set ticket_status='Closed',closed_by_id=".$this->user_id.",closed_by_name='".$this->username."',closed_reason='".$this->remarks."',closed_on='".$this->createddatetime."',closed_by_name='".$this->username."' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[24] ="UPDATE  tbl_ticket_services set ticket_service_status='Closed' where amc_ticket='TKT' and ticket_ref_code='".$this->ticket_ref_code."'";
            $array[25] ="UPDATE  tbl_visits set amc_visit_status='Cancelled',amc_schedule_color='#B23CFD' where amc_ticket='TKT' and amc_tkt_ref_no='".$this->ticket_ref_code."'";
             $array[26] ="UPDATE  tbl_visits set amc_visit_status='Closed',amc_schedule_color='#4CAF50' where amc_ticket='TKT' and amc_tkt_ref_no='".$this->ticket_ref_code."'";
             
             
             $array[27] ="UPDATE  tbl_visits set amc_visit_status='Cancelled', amc_schedule_color='#B23CFD' where amc_ticket='TKT' and amc_tkt_id=".$this->ticket_id;
              $array[28] ="UPDATE tbl_tickets set ticket_status='Cancelled',cancelled_by_id=". $this->user_id.",cancelled_by_name='".$this->username."',cancelled_reason='".$this->cancel_reason."',cancelled_date_time='".$this->createddatetime."' where ticket_id=".$this->ticket_id;
             
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
         
             
              case 'list_not_assigned_ticket':
        
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
              case 'list_of_schedules':
         
                 $this->varModelObj->ListFromTable($var[4]);
             break;
             
               case 'update_schedules':
                  for ($i=0;$i<$this->ticket_count; $i++) {
              
                    mysqli_query($this->varDBConnection,"update tbl_visits set date_of_visits='".$this->visit_date."',time_of_visit='".$this->visit_slot."',additional_slots=".$this->visit_duration.",amc_visit_status='Scheduled',amc_schedule_color='#39C0ED',visit_start_time='".$this->visit_start_time."' where amc_ticket='TKT' and  amc_visit_id=".$this->visit_id[$i]);
                  
                  }
                 echo 'Success';
             break;
               case 'assign_ticket_visit':
      
                for ($k=0;$k<$this->ticket_count; $k++) {
              
               
               $result =  mysqli_query($this->varDBConnection,"select customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name from tbl_tickets where  ticket_id=".$this->ticket_id[$k]);
                    while($row=mysqli_fetch_assoc($result)) { 
                      $this->customer_id= $row['customer_id'];
                      $this->customer_code= $row['customer_code'];
                      $this->customer_name= $row['customer_name'];
                      $this->location_id= $row['location_id'];
                      $this->location_code= $row['location_code'];
                      $this->location_name= $row['location_name'];
                      $this->building_id= $row['building_id'];
                      $this->building_code= $row['building_code'];
                      $this->building_name= $row['building_name'];
                        
                    }
               
                
                  
                     
                 for ($i=0;$i<$this->employee_count; $i++) {
                  
                  mysqli_query($this->varDBConnection,'insert into  tbl_ticket_teams(ticket_id,ticket_ref_no,visit_id,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_date,visit_time,employee_id,employee_code,employee_name,is_leader,additional_slots,visit_start_time,employee_contact_no) values('.$this->ticket_id[$k].',"'.$this->ticket_ref_code.'",'.$this->visit_id[$k].','.$this->customer_id.',"'.$this->customer_code.'","'.$this->customer_name.'",'.$this->location_id.',"'.$this->location_code.'","'.$this->location_name.'",'.$this->building_id.',"'.$this->building_code.'","'.$this->building_name.'","'.$this->visit_date.'","'.$this->visit_slot.'",'.$this->employee_id[$i].',"'.$this->employee_code[$i].'","'.$this->employee_name[$i].'","No",'.$this->visit_duration.',"'.$this->visit_start_time.'","'.$this->employee_contact_no[$i].'")');
                 
             
                  $result_slot =  mysqli_query($this->varDBConnection,'select count(slot_ids) as count_slot ,slot_ids from tbl_technician_slots where employee_id='.$this->employee_id[$i].' and   slot_date="'.$this->visit_date.'"');
                        while($row_slot=mysqli_fetch_assoc($result_slot)) {
                            if($row_slot['count_slot']==0)
                            {
                            // echo 'insert into  tbl_technician_slots (employee_id,employee_code,employee_name,slot_date,employee_contact_no) values ('.$this->employee_id[$i].',"'.$this->employee_code[$i].'","'.$this->employee_name[$i].'","'.$this->visit_date.'","'.$this->employee_contact_no[$i].'")';
                              mysqli_query($this->varDBConnection,'insert into  tbl_technician_slots (employee_id,employee_code,employee_name,slot_date,employee_contact_no) values ('.$this->employee_id[$i].',"'.$this->employee_code[$i].'","'.$this->employee_name[$i].'","'.$this->visit_date.'","'.$this->employee_contact_no[$i].'")');
                              
                               
                              $result_last_id =  mysqli_query($this->varDBConnection,'SELECT LAST_INSERT_ID() as last_ids');
                               
                                while($row_last_id=mysqli_fetch_assoc($result_last_id)) {
                                    $this->techslot_insert_id=$row_last_id['last_ids'];
                               }
                                   
                                    for($j=$this->visit_slot;$j<=$this->total_slots;$j++)
                                     {
                                          
                                         mysqli_query($this->varDBConnection,'update  tbl_technician_slots set slot_'.$j.'="'.$this->ticket_ref_code.'" where slot_ids='.$this->techslot_insert_id);
                                          
                                     }
                                     
                                
                            }
                               else
                            {
                             
                              for($m=$this->visit_slot;$m<=$this->total_slots;$m++)
                                     {
                                          
                                          mysqli_query($this->varDBConnection,'update  tbl_technician_slots set slot_'.$m.'="'.$this->ticket_ref_code.'" where slot_ids='.$row_slot['slot_ids']);
                                          
                                     }
                              
                            }
                       }//While loop $row_slot
                
                 
                 
                     }//loop of techs
                     
                     mysqli_query($this->varDBConnection,'update tbl_ticket_teams set is_leader="Yes" where visit_id='.$this->visit_id[$k].' and employee_id='.$this->leadr_emp_id );
                 
                   mysqli_query($this->varDBConnection,'update tbl_visits set amc_visit_status="Assigned",amc_schedule_color="#3F51B5" where amc_visit_id='.$this->visit_id[$k] );
                    
                mysqli_query($this->varDBConnection,'update tbl_tickets set ticket_status="Assigned" where ticket_id='.$this->ticket_id[$k] );
                       
                  }//ticket for loop
                echo 'Success';
              
              
             break; 
              case 'change_status_ticket':
              if($this->status=='Cancelled')
              {
                    $this->varModelObj->UpdateTable($var[21]);
                    $this->varModelObj->UpdateTable($var[22]);
                    $this->varModelObj->UpdateTable($var[25]);
              }
              else
              {
                 
                   $this->varModelObj->UpdateTable($var[23]);
                   $this->varModelObj->UpdateTable($var[24]);
                   $this->varModelObj->UpdateTable($var[26]);
              }
                
                
             break;
              
              case 'cancel_ticket_entry':
                 
                   $this->varModelObj->UpdateTable($var[27]);
                   $this->varModelObj->UpdateTable($var[28]);
                
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