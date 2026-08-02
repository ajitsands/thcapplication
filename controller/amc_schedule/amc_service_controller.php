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
         $this->category_id= $_POST['category_id']; 
         $this->type_id= $_POST['type_id']; 
        
         
         $this->tech_code= $_POST['tech_code']; 
         $this->amc_child_id= $_POST['amc_child_id'];
         $this->total_slots= $_POST['total_slots'];
         
         $this->visit_idarray= $_POST['visit_idarray'];
         $this->amc_tkt_idarray= $_POST['amc_tkt_idarray'];
         $this->amc_ref_noarray= $_POST['amc_ref_noarray'];
         $this->asset_idarray= $_POST['asset_idarray'];
         $this->asset_codearray= $_POST['asset_codearray'];
         $this->serviceidarray= $_POST['serviceidarray'];
         $this->service_desearray= $_POST['service_desearray'];
         $this->ticket_count= $_POST['ticket_count'];
         $this->service_selected_count= $_POST['service_selected_count'];
         
         $this->amc_service_id= $_POST['amc_service_id'];
       
  
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
  
		$array[0] ="SELECT *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date ,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment1) as amc_attachment1,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment2) as amc_attachment2,CONCAT('http://thc.sianlab.com/httpdocs/images/amc_attachements/',amc_attachment3) as amc_attachment3 FROM `tbl_amc_master` where amc_status='Active' and amc_ref_no in (select amc_tkt_ref_no from tbl_visits where amc_ticket='AMC' and amc_visit_status in ('Scheduled','Assigned')) order by amc_id desc";
		$array[1] ="SELECT * FROM `tbl_amc_child` where amc_child_status='Active' and amc_master_id=".$this->amc_id;
		$array[2] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits FROM `view_amc_visits` where  amc_ref_no='".$this->amc_ref_nos."' and amc_visit_status in ('Scheduled','Assigned') order by year(date_of_visits),month(date_of_visits),date(date_of_visits) asc";
		$array[4] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits FROM `view_amc_visits` where  amc_ref_no='".$this->amc_ref_nos."' and category_id=".$this->category_id." and asset_type_id=".$this->type_id." and amc_visit_status in ('Scheduled','Assigned') order by year(date_of_visits),month(date_of_visits),date(date_of_visits) asc";
		$array[5] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits FROM `view_amc_visits` where  amc_ref_no='".$this->amc_ref_nos."' and category_id=".$this->category_id." and amc_visit_status in ('Scheduled','Assigned') order by year(date_of_visits),month(date_of_visits),date(date_of_visits) asc";
		$array[3] ="SELECT * FROM `tbl_services` where  service_status='Active' and category_id=".$this->category_id." and asset_type_id=".$this->type_id;
		
		
	
		$array[8] ="SELECT * FROM `tbl_amc_services` where  amc_ref_code='".$this->amc_ref_nos."' and amc_child_id=".$this->amc_child_id." and amc_visit_id=".$this->amc_visit_id;
		
		$array[9] ="SELECT *,DATE_FORMAT(date_of_visits, '%d-%m-%Y') as date_of_visits,date_of_visits as date_of_visits1 FROM `view_amc_visits` where amc_visit_status='Assigned' and amc_ref_no='".$this->amc_ref_nos."' order by date_of_visits desc";
		
		$array[10] ="SELECT * FROM `tbl_ticket_teams` where  ticket_ref_no='".$this->amc_ref_nos."' and ticket_id=".$this->amc_child_id." and visit_id=".$this->amc_visit_id." and amc_ticket='AMC' and ticket_team_status='Active'";
		
			$array[11] ="delete  FROM `tbl_amc_services` where   amc_service_id=".$this->amc_service_id;
		
		 $array[30] = "select expertise_name from tbl_technician_expertise where  employee_code='".$this->tech_code."' and status='Active'";
          
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
            
            if($this->category_id!=0 && $this->type_id!=0)
            {
                $this->varModelObj->ListFromTable($var[4]);
            }
             if($this->category_id!=0 && $this->type_id==0)
            {
                $this->varModelObj->ListFromTable($var[5]);
            } 
           if($this->category_id==0 && $this->type_id==0)
            {
                $this->varModelObj->ListFromTable($var[2]);
            }
            break;
           case 'amc_list_services':
          
                $this->varModelObj->ListFromTable($var[3]);
            break;
          
          
          
          
          
          
             case 'amc_list_schedules_for_assign':
            
                $this->varModelObj->ListFromTable($var[5]);
            break;
           
           
               case 'list_tech_expertises':
          
                 $this->varModelObj->ListFromTable($var[30]);
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
             case 'delete_services':
          
                 $this->varModelObj->DeleteRow($var[11]);
             break;
              case 'assign_services':
      
                
              
                 for ($k=0;$k<$this->ticket_count; $k++) {
              
                     
                 for ($i=0;$i<$this->service_selected_count; $i++) {
               
                  mysqli_query($this->varDBConnection,'insert into  tbl_amc_services(amc_visit_id,amc_child_id,amc_ref_code,asset_id,asset_code,service_id,service_description,amc_service_status) values('.$this->visit_idarray[$k].','.$this->amc_tkt_idarray[$k].',"'.$this->amc_ref_noarray[$k].'",'.$this->asset_idarray[$k].',"'.$this->asset_codearray[$k].'",'.$this->serviceidarray[$i].',"'.$this->service_desearray[$i].'","Pending")');
                  
                     }//loop of service
                     
                       
                  }//ticket for loop
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