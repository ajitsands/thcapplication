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
         $this->visit_date = $_POST['visit_date'];
         $this->schedule_time = $_POST['schedule_time'];
         $this->start_slot = $_POST['start_slot'];
         $this->add_slot = $_POST['add_slot'];
         $this->visit_slot = $_POST['visit_slot'];
         $this->tech_type = $_POST['tech_type'];
         
         $this->visitidarray = $_POST['visitidarray'];
         $this->amc_tkt_idarray = $_POST['amc_tkt_idarray'];
         $this->amc_ref_noarray = $_POST['amc_ref_noarray'];
         $this->customer_idarray = $_POST['customer_idarray'];
         $this->customer_codearray = $_POST['customer_codearray'];
         $this->customer_namearray = $_POST['customer_namearray'];
         $this->location_idarray = $_POST['location_idarray'];
         $this->location_codearray = $_POST['location_codearray'];
         $this->location_namearray = $_POST['location_namearray'];
         $this->building_idarray = $_POST['building_idarray'];
         $this->building_codearray = $_POST['building_codearray'];
         $this->building_namearray = $_POST['building_namearray'];
         $this->visit_date_array = $_POST['visit_date_array'];
         $this->startslot_array = $_POST['startslot_array'];
         $this->additional_slotsarray = $_POST['additional_slotsarray'];
         $this->visit_start_timearray = $_POST['visit_start_timearray'];
         $this->empidarray = $_POST['empidarray']; 
         $this->empcodearray = $_POST['empcodearray'];
         $this->empcodearray = $_POST['empcodearray'];
         $this->empnamearray = $_POST['empnamearray'];
         $this->empcontactnoarray = $_POST['empcontactnoarray'];
         $this->leadr_emp_id = $_POST['leadr_emp_id'];
         $this->totalslot_array = $_POST['totalslot_array'];
         $this->emp_count = $_POST['emp_count'];
         $this->ticket_count = $_POST['ticket_count'];
         
         $this->tech_code= $_POST['tech_code']; 
         $this->amc_child_id= $_POST['amc_child_id'];
         $this->total_slots= $_POST['total_slots'];
      
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
  
		$array[0] ="SELECT *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date ,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment1) as amc_attachment1,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment2) as amc_attachment2,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment3) as amc_attachment3 FROM `tbl_amc_master` where amc_status='Active' and amc_ref_no in (select amc_tkt_ref_no from tbl_visits where amc_ticket='AMC' and amc_visit_status='Scheduled') order by amc_id desc";
		$array[1] ="SELECT * FROM `tbl_amc_child` where amc_child_status='Active' and amc_master_id=".$this->amc_id;
		$array[2] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits,date_of_visits as date_of_visits1 FROM `view_amc_visits` where amc_visit_status='Scheduled' and amc_ref_no='".$this->amc_ref_nos."' order by year(date_of_visits),month(date_of_visits),date(date_of_visits) asc";
		$array[3] ="delete from  tbl_visits  where amc_visit_id=".$this->amc_visit_id;
		$array[4] ="update tbl_visits set visit_mode='YSD',date_of_visits='".$this->visit_date."',time_of_visit='".$this->start_slot."',additional_slots=".$this->add_slot.",visit_start_time='".$this->schedule_time."' where amc_visit_id=".$this->amc_visit_id;
	
		$array[5] ="SELECT * FROM `view_amc_visits` where amc_visit_status='Scheduled' and amc_ref_no='".$this->amc_ref_nos."' and date_of_visits='".$this->visit_date."' and time_of_visit='".$this->start_slot."' and additional_slots=".$this->add_slot." ";
		
		$array[6] = "select employee_id,employee_code,employee_name,employee_contact_no from   tbl_technician_slots where slot_date='".$this->visit_date."' and ".$this->visit_slot." and  employee_id in (select employee_id from tbl_employees where employee_status='Active' and technician_type in ('Floating','NA')) union select employee_id,employee_code,employee_name,employee_contact_no from    tbl_employees where employee_type_name in ('Technician','Team Leader') and employee_status='Active' and technician_type  in ('Floating','NA') and employee_id not in (select employee_id from   tbl_technician_slots where slot_date='".$this->visit_date."') group by employee_id";
		
		$array[7] = "select employee_id,employee_code,employee_name,employee_contact_no from   tbl_technician_slots where slot_date='".$this->visit_date."' and ".$this->visit_slot." and  employee_id in (select employee_id from tbl_employees where employee_status='Active' and technician_type not in ('Floating','NA')) union select employee_id,employee_code,employee_name,employee_contact_no from    tbl_employees where employee_type_name in ('Technician','Team Leader') and employee_status='Active' and technician_type not in ('Floating','NA') and employee_id not in (select employee_id from   tbl_technician_slots where slot_date='".$this->visit_date."') group by employee_id";
		
		$array[8] ="SELECT * FROM `tbl_amc_services` where  amc_ref_code='".$this->amc_ref_nos."' and amc_child_id=".$this->amc_child_id." and amc_visit_id=".$this->amc_visit_id;
		
		$array[9] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits,date_of_visits as date_of_visits1 FROM `view_amc_visits` where amc_visit_status='Assigned' and amc_ref_no='".$this->amc_ref_nos."' order by date_of_visits desc";
		
		$array[10] ="SELECT * FROM `tbl_ticket_teams` where  ticket_ref_no='".$this->amc_ref_nos."' and ticket_id=".$this->amc_child_id." and visit_id=".$this->amc_visit_id." and amc_ticket='AMC' and ticket_team_status='Active'";
		
		
		
		 $array[30] = "select expertise_name from tbl_technician_expertise where  employee_code='".$this->tech_code."' and status='Active'";
            $array[31] = "select count(slot_ids) as count_slots from tbl_technician_slots where  employee_code='".$this->tech_code."' and slot_date='".$this->visit_date."' and slot_status='Active'";
            $array[32] = "select DATE_FORMAT(slot_date,'%d-%m-%Y') AS slot_date,slot_1,slot_2,slot_3,slot_4,slot_5,slot_6,slot_7,slot_8,slot_9,slot_10,slot_11,slot_12,slot_13,slot_14,slot_15,slot_16,slot_17,slot_18,slot_19,slot_20,slot_21,slot_22,slot_23,slot_24 from tbl_technician_slots where  employee_code='".$this->tech_code."' and slot_date='".$this->visit_date."' and slot_status='Active'";
            $array[33] = "select  DATE_FORMAT('".$this->visit_date."','%d-%m-%Y') AS slot_date,0 as slot_1,0 as slot_2,0 as slot_3,0 as slot_4,0 as slot_5,0 as slot_6,0 as slot_7,0 as slot_8,0 as slot_9,0 as slot_10,0 as slot_11,0 as slot_12,0 as slot_13,0 as slot_14,0 as slot_15,0 as slot_16,0 as slot_17,0 as slot_18,0 as slot_19,0 as slot_20,0 as slot_21,0 as slot_22,0 as slot_23,0 as slot_24";
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
            case 'cancel_visit':
            
                $this->varModelObj->DeleteRow($var[3]);
            break;
             case 'update_visits':
           
                $this->varModelObj->UpdateTable($var[4]);
            break;
             case 'amc_list_schedules_for_assign':
            
                $this->varModelObj->ListFromTable($var[5]);
            break;
            case 'list_avail_tech_in_schedule_ticket':
                  if($this->tech_type==1)
                  {
                      $this->varModelObj->ListFromTable($var[6]);
                  }
                  else
                  {
                      $this->varModelObj->ListFromTable($var[7]);
                  }
                
             break;
               case 'assign_technician':
      
                for ($k=0;$k<$this->ticket_count; $k++) {
              
               
              
                     
                 for ($i=0;$i<$this->emp_count; $i++) {
                  
                  mysqli_query($this->varDBConnection,'insert into  tbl_ticket_teams(ticket_id,ticket_ref_no,visit_id,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,visit_date,visit_time,employee_id,employee_code,employee_name,is_leader,additional_slots,visit_start_time,employee_contact_no,amc_ticket) values('.$this->amc_tkt_idarray[$k].',"'.$this->amc_ref_noarray[$k].'",'.$this->visitidarray[$k].','.$this->customer_idarray[$k].',"'.$this->customer_codearray[$k].'","'.$this->customer_namearray[$k].'",'.$this->location_idarray[$k].',"'.$this->location_codearray[$k].'","'.$this->location_namearray[$k].'",'.$this->building_idarray[$k].',"'.$this->building_codearray[$k].'","'.$this->building_namearray[$k].'","'.$this->visit_date_array[$k].'","'.$this->startslot_array[$k].'",'.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","No",'.$this->additional_slotsarray[$k].',"'.$this->visit_start_timearray[$k].'","'.$this->empcontactnoarray[$i].'","AMC")');
                                
         
                 
                 
                  $result_slot =  mysqli_query($this->varDBConnection,'select count(slot_ids) as count_slot ,slot_ids from tbl_technician_slots where employee_id='.$this->empidarray[$i].' and   slot_date="'.$this->visit_date_array[$k].'"');
                        while($row_slot=mysqli_fetch_assoc($result_slot)) {
                            if($row_slot['count_slot']==0)
                            {
                             
                              mysqli_query($this->varDBConnection,'insert into  tbl_technician_slots (employee_id,employee_code,employee_name,slot_date,employee_contact_no) values ('.$this->empidarray[$i].',"'.$this->empcodearray[$i].'","'.$this->empnamearray[$i].'","'.$this->visit_date_array[$k].'","'.$this->empcontactnoarray[$i].'")');
                              
                               
                              $result_last_id =  mysqli_query($this->varDBConnection,'SELECT LAST_INSERT_ID() as last_ids');
                               
                                while($row_last_id=mysqli_fetch_assoc($result_last_id)) {
                                    $this->techslot_insert_id=$row_last_id['last_ids'];
                                }
                                   
                                    for($j=$this->startslot_array[$k];$j<=$this->totalslot_array[$k];$j++)
                                     {
                                          
                                          mysqli_query($this->varDBConnection,'update  tbl_technician_slots set slot_'.$j.'="'.$this->amc_ref_noarray[$k].'" where slot_ids='.$this->techslot_insert_id);
                                          
                                     }
                                     
                                
                            }
                               else
                            {
                             
                              for($m=$this->startslot_array[$k];$m<=$this->totalslot_array[$k];$m++)
                                     {
                                          
                                          mysqli_query($this->varDBConnection,'update  tbl_technician_slots set slot_'.$m.'="'.$this->amc_ref_noarray[$k].'" where slot_ids='.$row_slot['slot_ids']);
                                          
                                     }
                              
                            }
                       }//While loop $row_slot
                
                 
                 
                     }//loop of techs
                     
                      mysqli_query($this->varDBConnection,'update tbl_ticket_teams set is_leader="Yes" where visit_id='.$this->visitidarray[$k].' and employee_id='.$this->leadr_emp_id );
                
                   mysqli_query($this->varDBConnection,'update tbl_visits set amc_visit_status="Assigned",amc_schedule_color="#3F51B5" where amc_visit_id='.$this->visitidarray[$k] );
                    
                
                       
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
               case 'list_services':
          
                 $this->varModelObj->ListFromTable($var[8]);
             break;
             
             case 'amc_list_assigned_visits':
          
                 $this->varModelObj->ListFromTable($var[9]);
             break;
             case 'list_assign_team':
          
                 $this->varModelObj->ListFromTable($var[10]);
             break;
              case 'remove_team':
        
                    for($l=$this->start_slot;$l<=$this->total_slots;$l++)
                    {
                      
                       $result =  mysqli_query($this->varDBConnection,"select count(amc_visit_id) as visit_count from tbl_visits  where amc_visit_status='Assigned' and amc_visit_id!=".$this->amc_visit_id." and  date_of_visits='".$this->visit_date."' and time_of_visit='".$this->start_slot."' and  amc_tkt_ref_no='".$this->amc_ref_nos."' and additional_slots =".$this->add_slot);
                       while($row=mysqli_fetch_assoc($result)) {
                           if($row['visit_count']==0)
                           {
                                mysqli_query($this->varDBConnection,'update tbl_technician_slots set slot_'.$l.'="0" where slot_'.$l.'="'.$this->amc_ref_nos.'" and slot_date="'.$this->visit_date.'"');
                           }
                       }
                       
                        
                    }
                    
                     mysqli_query($this->varDBConnection,"update tbl_visits set  amc_schedule_color='#39C0ED',amc_visit_status='Scheduled' where amc_ticket='AMC' and  amc_visit_id=".$this->amc_visit_id);
                       
                   mysqli_query($this->varDBConnection,"delete  FROM `tbl_ticket_teams` where  ticket_ref_no='".$this->amc_ref_nos."'  and visit_id=".$this->amc_visit_id." and amc_ticket='AMC'");
                   
                 
                 echo 'Success';
                 
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