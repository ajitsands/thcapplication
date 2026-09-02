<?php

require ('../../model/common/common_functions.php');



class ticketassignController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$customer_id,$customer_code,$customer_name,$building_id,$building_code,$building_name,$location_id,$location_code,$location_name;
         
    function __construct()
	{
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->createddate = date('Y-m-d');
        $this->start_date = $_POST['start_date'];
        $this->end_date = $_POST['end_date'];
		$this->customer_id = $_POST['customer'];
        $this->ticket_ref_code = $_POST['ticket_ref_code'];
        $this->visit_id = $_POST['visit_id'];
        $this->employee_id = $_POST['employee_id'];
        $this->visit_date = $_POST['visit_date'];
        $this->ticket_id = $_POST['ticket_id'];
        $this->visit_time = $_POST['visit_time'];
        $this->emp_table_selected_count = $_POST['emp_table_selected_count'];
        $this->empidarray = $_POST['empidarray'];
        $this->empcodearray = $_POST['empcodearray'];
        $this->empnamearray = $_POST['empnamearray'];
        $this->ticket_team_ids = $_POST['ticket_team_ids'];
        $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
        //$this->user_id=1;
        //$this->username='Ancy';
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
     //  $array[1] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1, DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Scheduled' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
        $array[1] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1, DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Scheduled' order by date_of_visits asc";
      // $array[2] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1 from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Assigned' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
       $array[2] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Assigned'  order by date_of_visits asc";
       $array[3] = "select amc_visit_id,amc_tkt_id,amc_tkt_ref_no,date_of_visits as visit_date,time_of_visit as visit_time,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits,TIME_FORMAT(time_of_visit, '%H:%i') as time_of_visit,ticket_priority,amc_visit_status,additional_info,complaints_description,category_name,type_name,asset_code from view_ticket_visits where ticket_status in ('Assigned','Scheduled')  and amc_tkt_ref_no='".$this->ticket_ref_code."'";
       $array[4] = "select customer_code,customer_name,location_code,location_name,building_code,building_name from view_ticket_visits where  amc_tkt_ref_no='".$this->ticket_ref_code."' group by amc_tkt_ref_no";
       $array[5] = "select employee_id,employee_code,employee_name,employee_contact_no,employee_type_name from tbl_employees where employee_type_id in (6,7,8) and technician_type!='Resident/Stationed' and employee_status='Active' and employee_id not in (select employee_id from tbl_ticket_teams where visit_id=".$this->visit_id.") ";
       $array[6] = "select ticket_team_ids,employee_id,employee_code,employee_name,is_leader from  tbl_ticket_teams where  ticket_team_status='Active' and visit_id=".$this->visit_id;
       $array[7] = "select expertise_name from  tbl_technician_expertise where  status='Active' and employee_id=".$this->employee_id;
       $array[8] = "select location_name,building_name,TIME_FORMAT(visit_time, '%H:%i') as visit_time,DATE_FORMAT(visit_date, '%d-%m-%Y') as visit_date from  tbl_ticket_teams where  ticket_team_status='Active' and visit_date='".$this->visit_date."' and employee_id=".$this->employee_id;
        $array[9] = "select customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name from tbl_tickets where  ticket_id=".$this->ticket_id;
        $array[10] = "update tbl_ticket_teams set is_leader ='No' where ticket_team_ids=".$this->ticket_team_ids;
         $array[11] = "update tbl_ticket_teams set is_leader ='Yes' where ticket_team_ids=".$this->ticket_team_ids;
         $array[12] = "delete from tbl_ticket_teams  where ticket_team_ids=".$this->ticket_team_ids;
         $array[13] = "update tbl_visits set date_of_visits ='".$this->visit_date."', time_of_visit='".$this->visit_time."',reschedule_by_id=".$this->user_id." where amc_visit_id=".$this->visit_id;
         $array[14] = "update tbl_ticket_teams set visit_date ='".$this->visit_date."', visit_time='".$this->visit_time."' where visit_id=".$this->visit_id;
          $array[15] = "select count(amc_visit_id) as count_not_assigned from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Scheduled' ";
          $array[16] = "select count(amc_visit_id) as count_assigned from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Assigned' ";
          $array[17] = "select count(amc_visit_id) as count_completed from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Completed' ";
          $array[18] = "select count(amc_visit_id) as count_closed from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Closed'";
          $array[19] = "select count(amc_visit_id) as count_cancelled from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Cancelled' ";
          $array[20] = "select count(amc_visit_id) as count_extended from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Extended' ";
         // $array[21] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Completed' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
          $array[21] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Completed'   order by date_of_visits asc";
          //$array[22] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Closed' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
            $array[22] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Closed'   order by date_of_visits asc";
          //$array[23] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Cancelled' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
           $array[23] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Cancelled' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
          //$array[24] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Extended' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
             $array[24] = "select * ,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Extended'   order by date_of_visits asc";
           $array[25] = "select * ,DATE_FORMAT(quote_date, '%d-%m-%Y') as quote_date,DATE_FORMAT(date_needed, '%d-%m-%Y') as date_needed,DATE_FORMAT(created_date_time, '%d-%m-%Y %H:%i') as created_date_time,DATE_FORMAT(closed_on, '%d-%m-%Y %H:%i') as closed_on,DATE_FORMAT(cancelled_date_time, '%d-%m-%Y %H:%i') as cancelled_date_time, CONCAT('../httpdocs/images/ticket_book_image/',ticket_image) as ticket_image,CONCAT('../httpdocs/images/ticket_book_image/',ticket_image2) as ticket_image2,CONCAT('../httpdocs/images/ticket_close_image/',service_report_image) as service_report_image from  tbl_tickets where ticket_id=".$this->ticket_id;
           $array[26] = "select * from   tbl_ticket_teams where ticket_id=".$this->ticket_id." and visit_id=".$this->visit_id." and amc_ticket='TKT' and ticket_team_status  in ('Active') ";
		    
		   $array[27] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1, DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Scheduled' and customer_id = '".$this->customer_id."'   order by date_of_visits asc";
		   $array[28] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Assigned' and customer_id = '".$this->customer_id."' order by date_of_visits asc";
		   $array[29] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Completed' and customer_id = '".$this->customer_id."'  order by date_of_visits asc";
		   $array[30] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Closed' and customer_id = '".$this->customer_id."'  order by date_of_visits asc";
		   $array[31] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Cancelled' and customer_id = '".$this->customer_id."' group by date_of_visits, amc_tkt_ref_no  order by date_of_visits asc";
		   $array[32] = "select *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits1,DATE_FORMAT(visit_start_time, '%d-%m-%Y %H:%i')as visit_start_time from  tbl_visits where amc_ticket='TKT' and date_of_visits between '".$this->start_date."' and '".$this->end_date."' and amc_visit_status='Extended' and customer_id = '".$this->customer_id."' order by date_of_visits asc";
          
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'list_scheduled_ticket_not_assigned':
				if($this->customer_id === 'All')
				{
					$this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[1]);
					if($this->jsondata == '[]')
					{
						$nodat = [
							'date_of_visits1' => 'NA',
							'time_of_visit' => 'NA',
							'amc_tkt_id' => 'NA',
							'additional_slots' => 'NA',
							'amc_tkt_ref_no' => 'NA',
							'customer_code' => 'NA',
							'customer_name' => 'NA',
							'location_name' => 'NA',
							'building_name' => 'NA'
						];
						$data = [
							$nodat,
						];
						$jsonObject = ["data" => $data];
						
						$jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
						echo $jsonString;
					}
					else
					{
						echo $this->jsondata;
					}
				}
                else
				{
					$this->jsondata = $this->varModelObj->ListFromTable($var[27]);
					echo "Q".$this->jsondata;
					if($this->jsondata == '[]')
					{
						echo "NoData";  
					}
					else
					{
						echo $this->jsondata;
					}
				}
            break;
            case 'list_scheduled_ticket_assigned':
				if($this->customer_id == 'All')
				{
					$this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[2]);
					if($this->jsondata == '[]')
					{
						$nodat = [
							'date_of_visits1' => 'NA',
							'time_of_visit' => 'NA',
							'amc_tkt_id' => 'NA',
							'additional_slots' => 'NA',
							'amc_tkt_ref_no' => 'NA',
							'customer_code' => 'NA',
							'customer_name' => 'NA',
							'location_name' => 'NA',
							'building_name' => 'NA'
						];
						$data = [
							$nodat,
						];
						$jsonObject = ["data" => $data];
						
						$jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
						echo $jsonString;
					}
					else
					{
						echo $this->jsondata;
					}
				}
				else
				{
					$this->jsondata = $this->varModelObj->ListFromTable($var[28]);
					echo "Q".$this->jsondata;
					if($this->jsondata == '[]')
					{
						echo "NoData";  
					}
					else
					{
						echo $this->jsondata;
					}
				}
            break;
            case 'list_scheduled_ticket_completed':
				if($this->customer_id === 'All')
				{
					$this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[21]);
					if($this->jsondata == '[]')
					{
						$nodat = [
							'date_of_visits1' => 'NA',
							'time_of_visit' => 'NA',
							'amc_tkt_id' => 'NA',
							'additional_slots' => 'NA',
							'amc_tkt_ref_no' => 'NA',
							'customer_code' => 'NA',
							'customer_name' => 'NA',
							'location_name' => 'NA',
							'building_name' => 'NA'
						];
						$data = [
							$nodat,
						];
						$jsonObject = ["data" => $data];
						
						$jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
						echo $jsonString;  
					}
					else
					{
						echo $this->jsondata;
					}
				}
                else
				{
					$this->jsondata = $this->varModelObj->ListFromTable($var[29]);
					echo "Q".$this->jsondata;
					if($this->jsondata == '[]')
					{
						echo "NoData";  
					}
					else
					{
						echo $this->jsondata;
					}
				}
            break;
            case 'list_scheduled_ticket_closed':
				if($this->customer_id === 'All')
				{
					$this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[22]);
					if($this->jsondata == '[]')
					{
						$nodat = [
							'date_of_visits1' => 'NA',
							'time_of_visit' => 'NA',
							'amc_tkt_id' => 'NA',
							'additional_slots' => 'NA',
							'amc_tkt_ref_no' => 'NA',
							'customer_code' => 'NA',
							'customer_name' => 'NA',
							'location_name' => 'NA',
							'building_name' => 'NA'
						];
						$data = [
							$nodat,
						];
						$jsonObject = ["data" => $data];
						
						$jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
						echo $jsonString;  
					}
					else
					{
						echo $this->jsondata;
					}
				}
				else
				{
					$this->jsondata = $this->varModelObj->ListFromTable($var[30]);
					echo "Q".$this->jsondata;
					if($this->jsondata == '[]')
					{
						echo "NoData";  
					}
					else
					{
						echo $this->jsondata;
					}
				}
            break;
            case 'list_scheduled_ticket_cancelled':
				if($this->customer_id === 'All')
				{
					$this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[23]);
					if($this->jsondata == '[]')
					{
						$nodat = [
							'date_of_visits1' => 'NA',
							'time_of_visit' => 'NA',
							'amc_tkt_id' => 'NA',
							'additional_slots' => 'NA',
							'amc_tkt_ref_no' => 'NA',
							'customer_code' => 'NA',
							'customer_name' => 'NA',
							'location_name' => 'NA',
							'building_name' => 'NA'
						];
						$data = [
							$nodat,
						];
						$jsonObject = ["data" => $data];
						
						$jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
						echo $jsonString;
					}
					else
					{
						echo $this->jsondata;
					}
				}
                else
				{
					$this->jsondata = $this->varModelObj->ListFromTable($var[31]);
					echo "Q".$this->jsondata;
					if($this->jsondata == '[]')
					{
						echo "NoData";  
					}
					else
					{
						echo $this->jsondata;
					}
				}
            break;
            case 'list_scheduled_ticket_extended':
				if($this->customer_id === 'All')
				{
					$this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[24]);
					if($this->jsondata == '[]')
					{
						$nodat = [
							'date_of_visits1' => 'NA',
							'time_of_visit' => 'NA',
							'amc_tkt_id' => 'NA',
							'additional_slots' => 'NA',
							'amc_tkt_ref_no' => 'NA',
							'customer_code' => 'NA',
							'customer_name' => 'NA',
							'location_name' => 'NA',
							'building_name' => 'NA'
						];
						$data = [
							$nodat,
						];
						$jsonObject = ["data" => $data];
						
						$jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
						echo $jsonString; 
					}
					else
					{
						echo $this->jsondata;
					}
				}
                else
				{
					$this->jsondata = $this->varModelObj->ListFromTable($var[32]);
					echo "Q".$this->jsondata;
					if($this->jsondata == '[]')
					{
						echo "NoData";  
					}
					else
					{
						echo $this->jsondata;
					}
				}
            break;
             case 'list_ticket_entries':
       
                $this->varModelObj->ListFromTable($var[3]);
            break;
            case 'load_ticket_details':
        
                $this->varModelObj->ListFromTable($var[4]);
            break;
            case 'list_all_employees':
        
                $this->varModelObj->ListFromTable($var[5]);
            break;
            case 'list_assigned_employees':
        
                $this->varModelObj->ListFromTable($var[6]);
            break;
            case 'list_employee_expertise':
        
                $this->varModelObj->ListFromTable($var[7]);
            break;
             case 'list_employee_schedule':
        
                $this->varModelObj->ListFromTable($var[8]);
            break;
             case 'ticket_visit_assign_team':
             
                 $result =  mysqli_query($this->varDBConnection,$var[9]);
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
              
                for ($i=0;$i<$this->emp_table_selected_count; $i++) {
                 
                    mysqli_query($this->varDBConnection,'insert into  tbl_ticket_teams(ticket_id,ticket_ref_no,visit_id,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_date,visit_time,employee_id,employee_code,employee_name,is_leader) values('.$this->ticket_id.',"'.$this->ticket_ref_code.'",'.$this->visit_id.','.$this->customer_id.',"'.$this->customer_code.'","'.$this->customer_name.'",'.$this->location_id.',"'.$this->location_code.'","'.$this->location_name.'",'.$this->building_id.',"'.$this->building_code.'","'.$this->building_name.'","'.$this->visit_date.'","'.$this->visit_time.'",'.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","No");');
                       
                    }
                    mysqli_query($this->varDBConnection,'update tbl_visits set amc_visit_status="Assigned",amc_schedule_color="#A5B20B" where amc_visit_id='.$this->visit_id );
               echo 'Success';
 
             break;
             
             case 'make_technician':
      
                $this->varModelObj->UpdateTable($var[10]);
            break;
            
            case 'make_leader':
      
                $this->varModelObj->UpdateTable($var[11]);
            break;
            
            case 'delete_member_from_team':
      
                $this->varModelObj->DeleteRow($var[12]);
            break;
            case 'reschedule_ticket':
     
                $this->varModelObj->UpdateTable($var[13]);
                 $this->varModelObj->UpdateTable($var[14]);
            break;
             case 'action_count_not_assigned':
     
                $this->varModelObj->ListFromTable($var[15]);
            break;
             case 'action_count_assigned':
   
                $this->varModelObj->ListFromTable($var[16]);
            break;
            case 'action_count_completed':
     
                $this->varModelObj->ListFromTable($var[17]);
            break;
             case 'action_count_closed':
     
                $this->varModelObj->ListFromTable($var[18]);
            break;
            case 'action_count_cancelled':
     
                $this->varModelObj->ListFromTable($var[19]);
            break;
            case 'action_count_extended':
     
                $this->varModelObj->ListFromTable($var[20]);
            break;
            case 'action_view_details':
   
                $this->varModelObj->ListFromTable($var[25]);
            break;
            case 'list_ticket_team':
   
                $this->varModelObj->ListFromTable($var[26]);
            break;
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new ticketassignController();
$obj->RequestAccept($obj->actionevents);
?>