<?php

require ('../../model/common/common_functions.php');



class ticketController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$customer_id,$ticket_ref_code_new,$ticket_ref_no_new,$ticket_id_new,$inserted_id,$idsinsert,$techslot_insert_id,$ticket_count,$count_slots;
         
    function __construct()
	{
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->createddate = date('Y-m-d');
        $this->customer_id = $_POST['customer_id'];
        $this->location_id = $_POST['location_id'];
        $this->building_id = $_POST['building_id'];
        $this->category_id = $_POST['category_id'];
        $this->category_name = $this->varDBConnection->real_escape_string($_POST['category_name']);
        $this->type_id = $_POST['type_id'];
        $this->type_name = $this->varDBConnection->real_escape_string($_POST['type_name']); 
          
        $this->customer_code = $_POST['customer_code'];
        $this->customer_name = $this->varDBConnection->real_escape_string($_POST['customer_name']);
        $this->location_id = $_POST['location_id'];
        $this->location_code = $_POST['location_code'];
        $this->location_name = $this->varDBConnection->real_escape_string($_POST['location_name']);
        $this->building_id = $_POST['building_id'];
        $this->building_code = strtoupper($_POST['building_code']);
        $this->building_name = $this->varDBConnection->real_escape_string($_POST['building_name']);
        $this->asset_id = $_POST['asset_id'];
        $this->asset_code = $_POST['asset_code'];
        
        $this->additional_info = $this->varDBConnection->real_escape_string($_POST['additional_info']);
        $this->complaint_description = $this->varDBConnection->real_escape_string($_POST['complaint_description']);
        $this->priority_val = $_POST['priority_val'];
        $this->quote_val = $_POST['quote_val'];
        $this->service_table_selected_count = $_POST['service_table_selected_count'];
        $this->serviceidarray = $_POST['serviceidarray'];
        $this->servicedesarray = $_POST['servicedesarray'];
        $this->ticket_ref_val = $_POST['ticket_ref_val'];
        $this->ticket_ref_code = $this->varDBConnection->real_escape_string($_POST['ticket_ref_code']);
        $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
       // $this->user_id=1;
      // $this->username='Ancy';
        $this->building_address = $this->varDBConnection->real_escape_string($_POST['building_address']);
        $this->conact_person_name = $this->varDBConnection->real_escape_string($_POST['conact_person_name']);
        $this->contact_person_no = $_POST['contact_person_no'];
         $this->ticket_id = $_POST['ticket_id'];
         $this->visit_date = $_POST['visit_date'];
          $this->visit_slot = $_POST['visit_slot'];
         $this->visit_time = $_POST['visit_time'];
        $this->cancel_reason = $this->varDBConnection->real_escape_string($_POST['cancel_reason']);
        $this->SQLString = $_POST['SQLString'];
		
         $this->service_id = $_POST['service_id'];
         $this->remarks = $this->varDBConnection->real_escape_string($_POST['remarks']);
         $this->status = $_POST['status'];
         $this->service_request = $_POST['service_request'];
         $this->job_category = $_POST['job_category'];
         $this->quote_date = $_POST['quote_date'];
         $this->date_needed = $_POST['date_needed'];
         $this->v_session_image = $_POST['v_session_image'];
          $this->v_session_image2 = $_POST['v_session_image2'];
         $this->expertise_array = $_POST['expertise_array'];
         $this->check_date = $_POST['check_date'];
         $this->slot = $_POST['slot'];
         
         
         $this->tech_table_selected_count = $_POST['tech_table_selected_count'];
         $this->empidarray = $_POST['empidarray'];
         $this->empcodearray = $_POST['empcodearray'];
         $this->empnamearray = $_POST['empnamearray'];
         $this->empcontactnoarray = $_POST['empcontactnoarray'];
         
         $this->leadr_emp_id = $_POST['leadr_emp_id'];
         $this->visit_slot_update = $_POST['visit_slot_update'];
          $this->visit_duration = $_POST['visit_duration'];
          $this->total_slots = $_POST['total_slots'];
          $this->visit_start_time = $_POST['visit_start_time'];
          $this->ticket_count = $_POST['ticket_count'];
          $this->tech_code = $_POST['tech_code'];
          $this->quote_ref_no = $_POST['quote_ref_no'];
          
          $this->customer_contact_no = $_POST['customer_contact_no'];
         
          
         
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO tbl_customer_location( customer_id,customer_name,customer_code,location_id,location_code,location_name,building_code,building_name,building_address,contact_person_name, contact_person_no, customer_location_status) VALUES (".$this->customer_id.",'".$this->customer_name."','".$this->customer_code."',".$this->location_id.",'".$this->location_code."','".$this->location_name."','".$this->building_code."','". $this->building_name."','". $this->building_address."','".$this->conact_person_name ."','".$this->contact_person_no."','Active')";
        $array[2] = "select * from  tbl_customer_location where customer_id=".$this->customer_id;
        $array[3] = "select * from  tbl_customer_location where building_code='".$this->building_code."'";
        $array[4] = "select * from   tbl_location where location_status='Active'";
        $array[5] = "select * from   tbl_building where building_status='Active'";
        $array[6] = "select * from   tbl_assets where asset_status='Active' and customer_id=".$this->customer_id." and location_id=".$this->location_id." and building_id=".$this->building_id;
        $array[7] = "select * from   tbl_services where service_status='Active' and category_id=".$this->category_id." and asset_type_id=".$this->type_id;
        
       
         $array[8] = "call acc_proc_book_ticket (".$this->customer_id.",'".$this->customer_code."','".$this->customer_name."',".$this->location_id.",'".$this->location_code."','".$this->location_name."',".$this->building_id.",'".$this->building_code."','".$this->building_name."',".$this->asset_id.",'".$this->asset_code."',".$this->category_id.",'".$this->category_name."',".$this->type_id.",'". $this->type_name."','".$this->additional_info."','".$this->complaint_description."','".$this->priority_val."','".$this->quote_val."',".$this->ticket_ref_val.",'".$this->ticket_ref_code."','".$this->createddate."','".$this->createddatetime."',".$this->user_id.",'".$this->username."','".$this->service_request."','".$this->job_category."','".$this->quote_date."','".$this->date_needed."','".$this->v_session_image."','".$this->quote_ref_no."','".$this->v_session_image2."','".$this->customer_contact_no."',@msg,@p_ids,@t_ids)";
         $array[9] = "select distinct(ticket_ref_code) as ticket_ref_code,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i:%s') as created_date_time,customer_id,customer_code,customer_name,location_code,location_name,building_code,building_name,ticket_priority,location_id,building_id,ticket_ref_no  from  tbl_tickets where ticket_status='Opened'  group by ticket_ref_code order by YEAR(created_date_time) asc,MONTH(created_date_time) asc,DAY(created_date_time) asc,HOUR(created_date_time) asc,MINUTE(created_date_time) asc,SECOND(created_date_time) asc";
         $array[10] = "select * from  tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."'";
         $array[11] = "select *,CURDATE() as cur_date,'select' as cur_time,DATE_FORMAT(date_needed, '%d-%m-%Y') as date_needed,DATE_FORMAT(quote_date, '%d-%m-%Y') as quote_date,ticket_id from  tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."' and ticket_status='Opened'";
         $array[12] = "select * from  tbl_ticket_services where ticket_id=".$this->ticket_id." and ticket_service_status='Pending'";
          $array[13] = "INSERT INTO tbl_visits( amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time) VALUES (".$this->ticket_id.",'".$this->ticket_ref_code."','TKT',".$this->customer_id.",'".$this->customer_code."','".$this->customer_name."','YSD','".$this->visit_date."','".$this->visit_slot."',".$this->visit_duration.",'Scheduled','#0B9CF4','".$this->visit_start_time."')";
          $array[14] ="UPDATE tbl_tickets set ticket_status='Scheduled' where ticket_id=".$this->ticket_id;
          $array[15] ="UPDATE tbl_tickets set ticket_status='Cancelled',cancelled_by_id=". $this->user_id.",cancelled_by_name='".$this->username."',cancelled_reason='".$this->cancel_reason."',cancelled_date_time='".$this->createddatetime."' where ticket_id=".$this->ticket_id;
          $array[16] ="UPDATE  tbl_ticket_services set ticket_service_status='Cancelled' where ticket_id=".$this->ticket_id;
          $array[17] = "select * from   tbl_services where service_status='Active' and category_id=".$this->category_id." and asset_type_id=".$this->type_id." and service_id not in (select service_id from tbl_ticket_services where ticket_id=".$this->ticket_id." and ticket_service_status!='Cancelled')";
          $array[18] = "select * from  tbl_ticket_services where ticket_id=".$this->ticket_id." and ticket_service_status!='Cancelled'";
          $array[19] ="UPDATE  tbl_tickets set additional_info='".$this->additional_info."',complaints_description='".$this->complaint_description."',ticket_priority='".$this->priority_val."',quote_required='".$this->quote_val."',service_request='".$this->service_request."',job_category='".$this->job_category."',quote_date='".$this->quote_date."',date_needed='".$this->date_needed."',ticket_image='".$this->v_session_image."',ticket_image2='".$this->v_session_image2."',quote_ref_no='".$this->quote_ref_no."' where ticket_id=".$this->ticket_id;
           $array[20] ="delete from  tbl_ticket_services  where ticket_id=".$this->ticket_id." and service_id=".$this->service_id;
           $array[21] ="UPDATE tbl_tickets set ticket_status='Cancelled',cancelled_by_id=". $this->user_id.",cancelled_by_name='".$this->username."',cancelled_reason='".$this->remarks."',cancelled_date_time='".$this->createddatetime."' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[22] ="UPDATE  tbl_ticket_services set ticket_service_status='Cancelled' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[23] ="UPDATE tbl_tickets set ticket_status='Closed',closed_by_id=".$this->user_id.",closed_by_name='".$this->username."',closed_reason='".$this->remarks."',closed_on='".$this->createddatetime."',closed_by_name='".$this->username."' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[24] ="UPDATE  tbl_ticket_services set ticket_service_status='Closed' where ticket_ref_code='".$this->ticket_ref_code."'";
           $array[25] = "INSERT INTO tbl_visits( amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,visit_mode,date_of_visits,time_of_visit,amc_visit_status) (select ticket_id,ticket_ref_code,'TKT',customer_id,customer_code,customer_name,'YSD','".$this->visit_date."','".$this->visit_time."','Scheduled' from tbl_tickets where ticket_ref_code='".$this->ticket_ref_code."' and ticket_status='Opened')";
            $array[26] ="UPDATE tbl_tickets set ticket_status='Scheduled' where ticket_ref_code='".$this->ticket_ref_code."'";
            $array[27] = "select employee_id,employee_code,employee_name from tbl_technician_slots where slot_date='".$this->check_date."' and slot_".$this->slot."=0 and employee_id in (select employee_id from tbl_technician_expertise where expertise_id =".$this->expertise_array." ) and employee_id in (select employee_id from tbl_employees where employee_status='Active') union select employee_id,employee_code,employee_name from tbl_employees where employee_type_name='Technician' and employee_status='Active' and employee_id in (select employee_id from tbl_technician_expertise where expertise_id =".$this->expertise_array." ) and employee_id not in (select employee_id from tbl_technician_slots where slot_date='".$this->check_date."') group by employee_id";
            $visit_slot_clause = (!empty($this->visit_slot) && trim($this->visit_slot) != '') ? " and " . $this->visit_slot . " " : "";
            $visit_date_val = (!empty($this->visit_date) && $this->visit_date != 'undefined') ? $this->visit_date : date('Y-m-d');
            $array[28] = "select employee_id,employee_code,employee_name,employee_contact_no from tbl_technician_slots where slot_date='".$visit_date_val."' " . $visit_slot_clause . " and employee_id in (select employee_id from tbl_employees where employee_status='Active') union select employee_id,employee_code,employee_name,employee_contact_no from tbl_employees where employee_type_name in ('Technician','Team Leader','Supervisor') and employee_status='Active' and employee_id not in (select employee_id from tbl_technician_slots where slot_date='".$visit_date_val."') group by employee_id";
            $array[29] = "select customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name from tbl_tickets where  ticket_id=".$this->ticket_id;
            $array[30] = "select expertise_name from tbl_technician_expertise where  employee_code='".$this->tech_code."' and status='Active'";
            $array[31] = "select count(slot_ids) as count_slots from tbl_technician_slots where  employee_code='".$this->tech_code."' and slot_date='".$this->visit_date."' and slot_status='Active'";
            $array[32] = "select DATE_FORMAT(slot_date,'%d-%m-%Y') AS slot_date,slot_1,slot_2,slot_3,slot_4,slot_5,slot_6,slot_7,slot_8,slot_9,slot_10,slot_11,slot_12,slot_13,slot_14,slot_15,slot_16,slot_17,slot_18,slot_19,slot_20,slot_21,slot_22,slot_23,slot_24 from tbl_technician_slots where  employee_code='".$this->tech_code."' and slot_date='".$this->visit_date."' and slot_status='Active'";
            
          $array[33] = "select  DATE_FORMAT('".$this->visit_date."','%d-%m-%Y') AS slot_date,0 as slot_1,0 as slot_2,0 as slot_3,0 as slot_4,0 as slot_5,0 as slot_6,0 as slot_7,0 as slot_8,0 as slot_9,0 as slot_10,0 as slot_11,0 as slot_12,0 as slot_13,0 as slot_14,0 as slot_15,0 as slot_16,0 as slot_17,0 as slot_18,0 as slot_19,0 as slot_20,0 as slot_21,0 as slot_22,0 as slot_23,0 as slot_24";
            $array[34] = "select * from  tbl_customer_location where customer_id=".$this->customer_id;
			
		  $array[35] = "select *,DATE_FORMAT(created_date_time,'%d-%m-%Y %H:%i:%s') AS created_date_time from tbl_tickets where customer_id='".$this->customer_id."' and location_id='".$this->location_id."' and building_id='".$this->building_id."'";
		  $array[36] = "select *,DATE_FORMAT(created_date_time,'%d-%m-%Y %H:%i:%s') AS created_date_time from tbl_tickets where customer_id='".$this->customer_id."' and location_id='".$this->location_id."' and building_id='".$this->building_id."' and  asset_id='".$this->asset_id."' ";
       return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'add_customer_location':
        
                $this->varModelObj->AddToTable($var[1]);
            break;
            
             case 'customer_location_list_view':
            
                 $this->varModelObj->ListFromTable($var[2]);
             break;
              case 'list_customer_building':
            
                $this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[34]);
				if($this->jsondata == '[]')
				{
					echo "NoData";  
				}
				else
				{
					echo $this->jsondata;
				}
             break;

            
             case 'check_building_code':
            
                if($this->varModelObj->ReturnCountValue($var[3])==0)
                  {
                      echo "not exist";
                  }
                else
                  {
                    echo 1;
                  }
            break;
            case 'list_location':
           
                 $this->varModelObj->ListFromTable($var[4]);
             break;
             case 'list_building':
            
                 $this->varModelObj->ListFromTable($var[5]);
             break;
            case 'list_assets':
            
                $this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[6]);
				if($this->jsondata == '[]')
				{
					echo "NoData";  
				}
				else
				{
					echo $this->jsondata;
				}
             break; 
             case 'list_services':
          
                 $this->varModelObj->ListFromTable($var[7]);
             break; 
             case 'book_complaint':
     
               mysqli_query($this->varDBConnection,$var[8]);
                 $result =  mysqli_query($this->varDBConnection,'SELECT @msg,@p_ids,@t_ids');
                while($row=mysqli_fetch_assoc($result)) { 
                   $this->ticket_ref_code_new= $row['@msg'];
                   $this->ticket_ref_no_new= $row['@p_ids'];
                    $this->ticket_id_new= $row['@t_ids'];
                    
                }
              
                for ($i=0;$i<$this->service_table_selected_count; $i++) {
                  
                    mysqli_query($this->varDBConnection,'insert into  tbl_ticket_services(ticket_id,ticket_ref_code,asset_id,asset_code,service_id,service_description) values('.$this->ticket_id_new.',"'.$this->ticket_ref_code_new.'",'.$this->asset_id.',"'.$this->asset_code.'",'.$this->serviceidarray[$i].',"'.$this->servicedesarray[$i].'");');
                       
                    }
               echo $this->ticket_ref_no_new.'@'.$this->ticket_ref_code_new.'@'.$this->ticket_id_new;
 
             break; 
             
              case 'list_open_ticket':
          
                $this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[9]);
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
          
                 $this->varModelObj->ListFromTable($var[10]);
             break;
              case 'schedule_ticket_category_list':
          
                 $this->varModelObj->ListFromTable($var[11]);
             break;
             case 'list_assigned_services':
          
                 $this->varModelObj->ListFromTable($var[12]);
             break;
            
           
           case 'cancel_ticket_entry':
          
                 $this->varModelObj->UpdateTable($var[15]);
                 $this->varModelObj->UpdateTable($var[16]);
             break;
              case 'list_all_services_except_selected':
         // echo $var[17];
                 $this->varModelObj->ListFromTable($var[17]);
             break;
              case 'list_selected_services':
          
                 $this->varModelObj->ListFromTable($var[18]);
             break;
              case 'update_ticket_entry':
         
                 $this->varModelObj->UpdateTable($var[19]);
                 if($this->SQLString!='')
                 {
                     $this->varModelObj->AddToTable($this->SQLString);
                 }
               
             break;
              case 'cancel_ticket_entry_services':
          
                 $this->varModelObj->DeleteRow($var[20]);
             break;
             case 'change_status_ticket':
              if($this->status=='Cancelled')
              {
                    $this->varModelObj->UpdateTable($var[21]);
                    $this->varModelObj->UpdateTable($var[22]);
              }
              else
              {
                 
                   $this->varModelObj->UpdateTable($var[23]);
                   $this->varModelObj->UpdateTable($var[24]);
              }
                
                
             break;
            //  case 'schedule_ticket_visit_all_entries':
         
            //      $this->varModelObj->AddToTable($var[25]);
            //      $this->varModelObj->UpdateTable($var[26]);
            //  break;
             case 'list_technicians':
         
                 $this->varModelObj->ListFromTable($var[27]);
             break;
             case 'list_avail_tech_in_schedule_ticket':
         //echo $var[28];
                 $this->varModelObj->ListFromTable($var[28]);
             break;
              case 'schedule_ticket_visit_entries':
        
                 $this->inserted_id= $this->varModelObj->AddToTable($var[13]);
                 if($this->inserted_id!=''|| $this->inserted_id!=0)
                 {
                      $this->varModelObj->UpdateTable($var[14]);
                      echo 'Success';
                 }
                 else
                 {
                     echo 'Error';
                 }
             break;
             case 'schedule_ticket_visit_entries_multiple':
                  for ($i=0;$i<$this->ticket_count; $i++) {
               
               $result =  mysqli_query($this->varDBConnection,"select customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name from tbl_tickets where  ticket_id=".$this->ticket_id[$i]);
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
                    mysqli_query($this->varDBConnection,"INSERT INTO tbl_visits( amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time,building_id,building_code,building_name,location_id,location_code,location_name) VALUES (".$this->ticket_id[$i].",'".$this->ticket_ref_code."','TKT',".$this->customer_id.",'".$this->customer_code."','".$this->customer_name."','YSD','".$this->visit_date."','".$this->visit_slot."',".$this->visit_duration.",'Scheduled','#39C0ED','".$this->visit_start_time."',".$this->building_id.",'".$this->building_code."','".$this->building_name."',".$this->location_id.",'".$this->location_code."','".$this->location_name."')");
                    mysqli_query($this->varDBConnection,"UPDATE tbl_tickets set ticket_status='Scheduled' where ticket_id=".$this->ticket_id[$i]);
                  
                    
                  }
                 echo 'Success';
             break;
             
              case 'schedule_assign_ticket_visit':
      
                $this->inserted_id= $this->varModelObj->AddToTable($var[13]);
                 if($this->inserted_id!=''|| $this->inserted_id!=0)
                 {
                   
                    $result =  mysqli_query($this->varDBConnection,$var[29]);
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
              
                    for ($i=0;$i<$this->tech_table_selected_count; $i++) {
                
                    mysqli_query($this->varDBConnection,'insert into  tbl_ticket_teams(ticket_id,ticket_ref_no,visit_id,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_date,visit_time,employee_id,employee_code,employee_name,is_leader,additional_slots,visit_start_time,employee_contact_no) values('.$this->ticket_id.',"'.$this->ticket_ref_code.'",'.$this->inserted_id.','.$this->customer_id.',"'.$this->customer_code.'","'.$this->customer_name.'",'.$this->location_id.',"'.$this->location_code.'","'.$this->location_name.'",'.$this->building_id.',"'.$this->building_code.'","'.$this->building_name.'","'.$this->visit_date.'","'.$this->visit_slot.'",'.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","No",'.$this->visit_duration.',"'.$this->visit_start_time.'","'.$this->empcontactnoarray[$i].'")');
                  
                    $result_slot =  mysqli_query($this->varDBConnection,'select count(slot_ids) as count_slot ,slot_ids from tbl_technician_slots where employee_id='.$this->empidarray[$i].' and   slot_date="'.$this->visit_date.'"');
                        while($row_slot=mysqli_fetch_assoc($result_slot)) {
                            if($row_slot['count_slot']==0)
                            {
                             
                               mysqli_query($this->varDBConnection,'insert into  tbl_technician_slots (employee_id,employee_code,employee_name,slot_date) values ('.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","'.$this->visit_date.'")');
                              
                               
                               $result_last_id =  mysqli_query($this->varDBConnection,'SELECT LAST_INSERT_ID() as last_ids');
                               
                                while($row_last_id=mysqli_fetch_assoc($result_last_id)) {
                                    $this->techslot_insert_id=$row_last_id['last_ids'];
                                }
                                   // mysqli_query($this->varDBConnection,'update  tbl_technician_slots set '.$this->visit_slot_update.' where slot_ids='.$row_last_id['last_ids']);
                                    for($j=$this->visit_slot;$j<=$this->total_slots;$j++)
                                     {
                                          
                                          mysqli_query($this->varDBConnection,'update  tbl_technician_slots set slot_'.$j.'="'.$this->ticket_ref_code.'" where slot_ids='.$this->techslot_insert_id);
                                          
                                     }
                                     
                                
                            }
                            else
                            {
                             
                               for($k=$this->visit_slot;$k<=$this->total_slots;$k++)
                                     {
                                          
                                          mysqli_query($this->varDBConnection,'update  tbl_technician_slots set slot_'.$k.'="'.$this->ticket_ref_code.'" where slot_ids='.$row_slot['slot_ids']);
                                          
                                     }
                               // mysqli_query($this->varDBConnection,'update  tbl_technician_slots set '.$this->visit_slot_update.' where slot_ids='.$row_slot['slot_ids']);
                            }
                        }
                       
                    }
                    mysqli_query($this->varDBConnection,'update tbl_ticket_teams set is_leader="Yes" where visit_id='.$this->inserted_id.' and employee_id='.$this->leadr_emp_id );
                 
                    mysqli_query($this->varDBConnection,'update tbl_visits set amc_visit_status="Assigned",amc_schedule_color="#3F51B5" where amc_visit_id='.$this->inserted_id );
                    
                    mysqli_query($this->varDBConnection,'update tbl_tickets set ticket_status="Assigned" where ticket_id='.$this->ticket_id );
                    echo 'Success'; 
                 }
             else
             {
                 echo 'Error';
             }
              
 
             break; 
             
              case 'schedule_assign_ticket_visit_multiple':
      
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
               
                  $this->inserted_id=$this->varModelObj->AddToTable("INSERT INTO tbl_visits( amc_tkt_id,amc_tkt_ref_no,amc_ticket,customer_id,customer_code,customer_name,visit_mode,date_of_visits,time_of_visit,additional_slots,amc_visit_status,amc_schedule_color,visit_start_time,building_id,building_code,building_name,location_id,location_code,location_name) VALUES (".$this->ticket_id[$k].",'".$this->ticket_ref_code."','TKT',".$this->customer_id.",'".$this->customer_code."','".$this->customer_name."','YSD','".$this->visit_date."','".$this->visit_slot."',".$this->visit_duration.",'Scheduled','#0B9CF4','".$this->visit_start_time."',".$this->building_id.",'".$this->building_code."','".$this->building_name."',".$this->location_id.",'".$this->location_code."','".$this->location_name."')");
                  
                     
                 for ($i=0;$i<$this->tech_table_selected_count; $i++) {
                  
                  mysqli_query($this->varDBConnection,'insert into  tbl_ticket_teams(ticket_id,ticket_ref_no,visit_id,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_date,visit_time,employee_id,employee_code,employee_name,is_leader,additional_slots,visit_start_time,employee_contact_no) values('.$this->ticket_id[$k].',"'.$this->ticket_ref_code.'",'.$this->inserted_id.','.$this->customer_id.',"'.$this->customer_code.'","'.$this->customer_name.'",'.$this->location_id.',"'.$this->location_code.'","'.$this->location_name.'",'.$this->building_id.',"'.$this->building_code.'","'.$this->building_name.'","'.$this->visit_date.'","'.$this->visit_slot.'",'.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","No",'.$this->visit_duration.',"'.$this->visit_start_time.'","'.$this->empcontactnoarray[$i].'")');
                 
                 
                  $result_slot =  mysqli_query($this->varDBConnection,'select count(slot_ids) as count_slot ,slot_ids from tbl_technician_slots where employee_id='.$this->empidarray[$i].' and   slot_date="'.$this->visit_date.'"');
                        while($row_slot=mysqli_fetch_assoc($result_slot)) {
                            if($row_slot['count_slot']==0)
                            {
                             
                              mysqli_query($this->varDBConnection,'insert into  tbl_technician_slots (employee_id,employee_code,employee_name,slot_date,employee_contact_no) values ('.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","'.$this->visit_date.'","'.$this->empcontactnoarray[$i].'")');
                              
                               
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
                     
                      mysqli_query($this->varDBConnection,'update tbl_ticket_teams set is_leader="Yes" where visit_id='.$this->inserted_id.' and employee_id='.$this->leadr_emp_id );
                 
                   mysqli_query($this->varDBConnection,'update tbl_visits set amc_visit_status="Assigned",amc_schedule_color="#3F51B5" where amc_visit_id='.$this->inserted_id );
                    
                mysqli_query($this->varDBConnection,'update tbl_tickets set ticket_status="Assigned" where ticket_id='.$this->ticket_id[$k] );
                       
                  }//ticket for loop
                echo 'Success';
              
              
             break; 
            
            case 'list_tech_expertises':
          
                 $this->varModelObj->ListFromTable($var[30]);
             break;
             
             case 'list_tech_schedules':
                
                    $result_sch_count =mysqli_query($this->varDBConnection,$var[31]);
                        while($row_sch_count=mysqli_fetch_assoc($result_sch_count)) {
                           $this->count_slots=$row_sch_count['count_slots'];
                        }
                            if($this->count_slots==0)
                            {
                               
                                $this->varModelObj->ListFromTable($var[33]);
                            }
                            else
                            {
                                
                                $this->varModelObj->ListFromTable($var[32]);
                            }
             break;
			 case 'list_previous_workorder_building':
                 $this->varModelObj->ListFromTable($var[35]);
             break; 
			case 'list_previous_workorder_asset':
                 $this->varModelObj->ListFromTable($var[36]);
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