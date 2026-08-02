<?php
require ('../common/common_functions.php');
include('../../view/template/includes/en_de_header.inc');
class api1Controller 
{
    var $varModelObj;
    public $actionevents,$api_key,$ipaddress,$server_ip,$emp_code,$visit_date,$visit_id,$slot_no,$requestType,$myObj;
    public $error_str,$ticket_ref_no,$ticket_id,$amc_ticket_condition,$amc_ticket_visit_id_condition,$service_id,$createddatetime;
    public $tech_remarks,$asset_code,$service_image,$ticket_service_id,$tech_audio,$tech_audio_file_name,$cate_id,$type_id,$asset_id;
    public $service_description,$emp_id,$emp_name,$service_image_file_name;
    public $domain_path,$ticket_team_ids;
  
    function __construct()
	{
        $this->domain_path="http://thc.sianlab.com/httpdocs/";
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        
        $OBJ = new URLEncription();
		$this->APIKEY = $OBJ->URLEncode('thcauthentication');
		
        $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri$check_comm2";
        
        $requestType = $_SERVER['REQUEST_METHOD'];
        
        date_default_timezone_set("Asia/Bahrain");
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->server_ip = $_SERVER['SERVER_ADDR'];
        $this->curmonth = date('m');
       
      
        
        switch ($requestType) {
                case 'POST':
                    
                    
                    $this->actionevents = $_POST['action'];
                    //echo "POST VALUE FOR ACTION : -----  ".$this->actionevents."  -----";
                    $this->api_key =  $OBJ->KEYDecode(trim($_POST['APIKEY']));
                    //$this->api_key ='thcauthentication';
                    $this->emp_code = $_POST['emp_code'];
                    $this->visit_date = $_POST['visit_date'];
                    $this->ticket_id = $_POST['ticket_id'];
                    $this->slot_no = $_POST['slot_no'];
                    $this->visit_id = $_POST['visit_id'];
                    $this->amc_ticket_ref_no = $_POST['amc_ticket_ref_no'];
                    $this->amc_tkt_id = $_POST['amc_tkt_id'];
                    $this->amc_ticket = $_POST['amc_ticket'];
                    $this->service_id = $_POST['service_id'];
                    $this->tech_remarks = $_POST['tech_remarks'];
                    // $this->service_image = $_FILES['file']['tmp_name'];
                    $this->service_image = $_POST['service_image'];
                    $this->asset_code = $_POST['asset_code'];
                    $this->ticket_service_id = $_POST['ticket_service_id'];
                    $this->tech_audio = $_POST['tech_audio'];
                    $this->service_description = $_POST['service_description'];
                    $this->asset_id = $_POST['asset_id'];
                    $this->emp_id = $_POST['emp_id'];
                    $this->emp_code = $_POST['emp_code'];
                    $this->service_image_file_name = $_POST['service_image_file_name'];
                    $this->ticket_team_ids = $_POST['ticket_team_ids'];
                    
                    
                  break;
                case 'GET':
                   
                  
                    $this->actionevents = $_GET['action'];
                    $this->api_key =  $OBJ->KEYDecode(trim($_GET['APIKEY']));
                    //$this->api_key ='thcauthentication';
                    $this->emp_code = $_GET['emp_code'];
                    $this->visit_date = $_GET['visit_date'];
                    $this->ticket_id = $_GET['ticket_id'];
                    $this->slot_no = $_GET['slot_no'];
                    $this->visit_id = $_GET['visit_id'];
                    $this->amc_ticket_ref_no = $_GET['amc_ticket_ref_no'];
                    $this->amc_tkt_id = $_GET['amc_tkt_id'];
                    $this->amc_ticket = $_GET['amc_ticket'];
                    $this->service_id = $_GET['service_id'];
                    $this->tech_remarks = $_GET['tech_remarks'];
                    // $this->service_image = $_FILES['file']['tmp_name'];
                    $this->service_image = $_GET['service_image'];
                    $this->asset_code = $_GET['asset_code'];
                    $this->ticket_service_id = $_GET['ticket_service_id'];
                    $this->tech_audio = $_GET['tech_audio'];
                    $this->service_description = $_GET['service_description'];
                    $this->asset_id = $_GET['asset_id'];
                    $this->emp_id = $_GET['emp_id'];
                    $this->emp_code = $_GET['emp_code'];
                    $this->service_image_file_name = $_GET['service_image_file_name'];
                    $this->ticket_team_ids = $_GET['ticket_team_ids'];
                    
                  break;
               
                default:
                  //request type that isn't being handled.
                break;
            }
           
           //echo "Imaefile".$this->service_image;
           
        // file_put_contents("/home/sianlab/public_html/thc/api/log/api_response_in_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  $uri, FILE_APPEND | LOCK_EX);

        
        
        
    }
    function SQLArray()
    {
        $array =  array();
        $array[0] = "select visit_date from  tbl_ticket_teams where employee_code='".$this->emp_code."' and visit_date  between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-01') + INTERVAL 90 DAY and ticket_team_status='Active' group by visit_date";
        
        $array[1] = "select * from tbl_technician_slots where employee_code='".$this->emp_code."' and slot_status='Active' and slot_date='".$this->visit_date."'" ;
       
        $array[2] = "select ticket_id,ticket_ref_code,customer_code,customer_id,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,category_name,type_name,asset_code,additional_info,complaints_description,ticket_priority,CONCAT('".$this->domain_path."images/ticket_book_image/',ticket_image) as ticket_image,CONCAT('".$this->domain_path."images/ticket_book_image/',ticket_image2) as second_ticket_image,service_request,job_category,'TKT' as amc_ticket,'NA' as customer_contact_no,ticket_status as ticket_status from tbl_tickets where ticket_ref_code='".$this->amc_ticket_ref_no."' and ticket_id in (select ticket_id from tbl_ticket_teams where visit_date='".$this->visit_date."' and employee_code='".$this->emp_code."')" ;
        $array[3] = "select ticket_team_ids,is_attend,ticket_ref_no,ticket_id,employee_id,employee_code,employee_name,is_leader,employee_contact_no from tbl_ticket_teams where  visit_date='".$this->visit_date."' and ticket_team_status='Active' and visit_id=";
        $array[4] = "select ticket_service_id,ticket_id,ticket_ref_code,asset_id,asset_code,service_id,service_description,ticket_service_status from tbl_ticket_services where ticket_id=".$this->amc_tkt_id;
        $array[5] = "select time_of_visit as start_slot,additional_slots,visit_start_time as start_time,amc_visit_status as amc_visit_status from tbl_visits where amc_ticket='TKT' and date_of_visits='".$this->visit_date."' and amc_tkt_id=".$this->amc_tkt_id." and amc_visit_status!='Cancelled'";
        $array[6] = "select CONCAT('".$this->domain_path."images/service_images/',service_image_name) as service_image_name  from tbl_service_images where amc_ticket='TKT' and ticket_amc_id=".$this->amc_tkt_id;
        $array[7] = "select CONCAT('".$this->domain_path."images/service_images/',service_image_name) as service_image_name  from tbl_service_images where amc_ticket='AMC' and ticket_amc_id=".$this->amc_tkt_id;
        $array[8] = "update tbl_ticket_services set service_start_date_time='".$this->createddatetime."',service_start_by_emp_code='".$this->emp_code."',ticket_service_status='Start' where  ticket_service_id=".$this->ticket_service_id;
        $array[9] = "update tbl_ticket_services set ticket_service_status='Pending' where  ticket_service_id=".$this->ticket_service_id;
        $array[10] = "update tbl_ticket_services set service_complete_date_time='".$this->createddatetime."',service_complete_by_emp_code='".$this->emp_code."',tech_remarks='".$this->tech_remarks."',ticket_service_status='Completed' where  ticket_service_id=".$this->ticket_service_id;
        $array[11] = "update tbl_ticket_services set service_complete_cancel_date_time='".$this->createddatetime."',service_complete_cancel_by_emp_code='".$this->emp_code."',tech_remarks='".$this->tech_remarks."',ticket_service_status='Cancelled' where  ticket_service_id=".$this->ticket_service_id;
        $array[12] = "update tbl_ticket_services set service_complete_cancel_date_time='".$this->createddatetime."',service_complete_cancel_by_emp_code='".$this->emp_code."',tech_remarks='".$this->tech_remarks."',ticket_service_status='Completed' where  ticket_service_id=".$this->ticket_service_id;
   
        $array[13] = "select CONCAT('".$this->domain_path."audios/',tech_audio_file) as tech_audio_file,tech_remarks,ticket_service_status  from tbl_ticket_services where ticket_service_id=".$this->ticket_service_id." and ticket_id=".$this->amc_tkt_id." and ticket_ref_code='".$this->amc_ticket_ref_no."'";
        $array[14] ="insert into tbl_ticket_services (ticket_id,ticket_ref_code,asset_id,asset_code,service_id,service_description,ticket_service_status) values(".$this->amc_tkt_id.",'".$this->amc_ticket_ref_no."',".$this->asset_id.",'".$this->asset_code."',".$this->ticket_service_id.",'".$this->service_description."','Pending')";
        $array[15] = "select type_name,ticket_status as status from tbl_tickets where ticket_id=".$this->amc_tkt_id;
        $array[16] = "delete from tbl_ticket_services where ticket_service_id=".$this->ticket_service_id;
        $array[17] = "update tbl_tickets set closed_by_id=".$this->emp_id.",closed_on='".$this->createddatetime."',closed_by_name='".$this->emp_name."',closed_reason='Closed by technician',ticket_status='Closed' where  ticket_id=".$this->amc_tkt_id." and ticket_ref_code='".$this->amc_ticket_ref_no."'";
        $array[18] = "update tbl_visits set amc_schedule_color='#4CAF50',amc_visit_status='Closed' where amc_ticket='TKT' and date_of_visits='".$this->visit_date."' and  amc_tkt_id=".$this->amc_tkt_id." and amc_tkt_ref_no='".$this->amc_ticket_ref_no."'";
        $array[19] = "update tbl_tickets set closed_by_id=".$this->emp_id.",closed_on='".$this->createddatetime."',closed_by_name='".$this->emp_name."',completed_by_id=".$this->emp_id.",completed_date_time='".$this->createddatetime."',closed_reason='Completed by technician',ticket_status='Completed' where  ticket_id=".$this->amc_tkt_id." and ticket_ref_code='".$this->amc_ticket_ref_no."'";
        $array[20] = "update tbl_visits set amc_schedule_color='#795548',amc_visit_status='Completed' where amc_ticket='TKT' and date_of_visits='".$this->visit_date."' and  amc_tkt_id=".$this->amc_tkt_id." and amc_tkt_ref_no='".$this->amc_ticket_ref_no."'";
        $array[21] = "update tbl_tickets set closed_by_id=".$this->emp_id.",closed_on='".$this->createddatetime."',closed_by_name='".$this->emp_name."',closed_reason='Extended by technician',ticket_status='Extended' where  ticket_id=".$this->amc_tkt_id." and ticket_ref_code='".$this->amc_ticket_ref_no."'";
        $array[22] = "update tbl_visits set amc_schedule_color='#ffc107',amc_visit_status='Extended' where amc_ticket='TKT' and date_of_visits='".$this->visit_date."' and  amc_tkt_id=".$this->amc_tkt_id." and amc_tkt_ref_no='".$this->amc_ticket_ref_no."'";
        $array[23] = "select asset_ref_no,asset_category_name,asset_type_name,customer_code,customer_name,location_code,asset_location,building_code,asset_building,zone_floor,flat_area_code,room_no,asset_sp_des,asset_serial_no,asset_brand,asset_capacity,asset_cost,is_warentee,warentee_end_date,asset_description,asset_status,CONCAT('".$this->domain_path."images/amc_attachements/',asset_attachment) as asset_attachment from tbl_assets where asset_ref_no='".$this->asset_code."'";
        $array[24] = "select ticket_service_id,service_description,tech_remarks,CONCAT('".$this->domain_path."audios/',tech_audio_file) as tech_audio_file,service_complete_cancel_date_time as completed_date,'TKT' as amc_ticket from tbl_ticket_services where ticket_service_status in ('Completed','Closed') and asset_code='".$this->asset_code."' union select amc_service_id as ticket_service_id,service_description,tech_remarks,CONCAT('".$this->domain_path."audios/',tech_audio_file) as tech_audio_file,service_complete_cancel_date_time as completed_date,'AMC' as amc_ticket from tbl_amc_services where amc_service_status in ('Completed','Closed') and asset_code='".$this->asset_code."' ";
        $array[25] = "select CONCAT('".$this->domain_path."images/service_images/',service_image_name) as service_image_name from tbl_service_images where status in ('Active') and asset_code='".$this->asset_code."' ORDER BY service_image_id DESC LIMIT 7";
        $array[26] = "select tel_no as thc_cust_care_no from tbl_thc_details";
        $array[27] = "update tbl_ticket_services set ticket_service_status='Start' ,tech_remarks='', tech_audio_file='',service_complete_cancel_date_time='',service_complete_cancel_by_emp_code='' where  ticket_service_id=".$this->ticket_service_id;
        $array[28] = "select tech_remarks,CONCAT('".$this->domain_path."audios/',tech_audio_file) as tech_audio_file from tbl_ticket_services where  ticket_service_id=".$this->ticket_service_id."";
        
        $array[29] = "update tbl_ticket_teams set is_attend='Yes' ,attend_mark_by_empcode='".$this->emp_code."', attend_mark_date_time='".$this->createddatetime."' where  ticket_team_ids=".$this->ticket_team_ids;
        $array[30] = "select CONCAT('".$this->domain_path."images/service_report_images/',service_report_image) as service_report_image from tbl_tickets where  ticket_id=".$this->amc_tkt_id;
        
        
        
        
         $array[31] = "select amc_child_id as ticket_id,amc_ref_no as ticket_ref_code,customer_code,customer_id,customer_name,location_id,location_code,asset_location as location_name,building_id,building_code,asset_building as building_name,category_name,asset_type_name as type_name,asset_ref_no as asset_code,asset_sp_des as additional_info,asset_description as complaints_description,'Normal' as ticket_priority,CONCAT('".$this->domain_path."images/amc_attachements/',asset_attachment) as ticket_image,CONCAT('".$this->domain_path."images/amc_attachements/','default.jpg') as second_ticket_image,'AMC' as service_request,CONCAT(asset_brand,' , ',asset_serial_no) as job_category,'AMC' as amc_ticket,'NA' as customer_contact_no,'NA' as ticket_status from view_amc_asset_details where amc_ref_no='".$this->amc_ticket_ref_no."' and amc_child_id in (select ticket_id from tbl_ticket_teams where visit_date='".$this->visit_date."' and employee_code='".$this->emp_code."')" ;
         
          $array[32] = "select ticket_team_ids,is_attend,ticket_ref_no,ticket_id,employee_id,employee_code,employee_name,is_leader,employee_contact_no from tbl_ticket_teams where  visit_date='".$this->visit_date."' and ticket_team_status='Active' and visit_id=";
          $array[33] = "select amc_service_id as ticket_service_id,amc_service_id as ticket_id, amc_service_id as ticket_ref_code,asset_id,asset_code,service_id,service_description,amc_service_status as ticket_service_status from  tbl_amc_services where amc_child_id=".$this->amc_tkt_id." and amc_visit_id=";
          $array[34] = "select time_of_visit as start_slot,additional_slots,visit_start_time as start_time,amc_visit_status as amc_visit_status from tbl_visits where amc_ticket='AMC' and date_of_visits='".$this->visit_date."' and amc_tkt_id=".$this->amc_tkt_id." and amc_visit_status!='Cancelled'";
         
       // $array[35] = "select asset_type_name  as type_name,amc_visit_status as status from  view_amc_visits where amc_child_id=".$this->amc_tkt_id." and amc_visit_id=";
        $array[35] = "select asset_type_name  as type_name,'Assigned' as status from  tbl_amc_child where amc_child_id=".$this->amc_tkt_id;
        
        $array[36] = "select CONCAT('".$this->domain_path."audios/',tech_audio_file) as tech_audio_file,tech_remarks,amc_service_status as ticket_service_status  from tbl_amc_services where amc_service_id=".$this->ticket_service_id." and amc_child_id=".$this->amc_tkt_id." and amc_ref_code='".$this->amc_ticket_ref_no."'";
        $array[37] = "update tbl_amc_services set service_start_date_time='".$this->createddatetime."',service_start_by_emp_code='".$this->emp_code."',amc_service_status='Start' where  amc_service_id=".$this->ticket_service_id;
        $array[38] = "update tbl_amc_services set amc_service_status='Pending' where  amc_service_id=".$this->ticket_service_id;
        $array[39] = "update tbl_amc_services set amc_service_status='Start' ,tech_remarks='', tech_audio_file='',service_complete_cancel_date_time='',service_complete_cancel_by_emp_code='' where  amc_service_id=".$this->ticket_service_id;
        
         $array[40] = "update tbl_amc_services set service_complete_cancel_date_time='".$this->createddatetime."',service_complete_cancel_by_emp_code='".$this->emp_code."',tech_remarks='".$this->tech_remarks."',amc_service_status='Cancelled' where  amc_service_id=".$this->ticket_service_id;
         
          $array[41] = "update tbl_amc_services set service_complete_cancel_date_time='".$this->createddatetime."',service_complete_cancel_by_emp_code='".$this->emp_code."',tech_remarks='".$this->tech_remarks."',amc_service_status='Completed' where  amc_service_id=".$this->ticket_service_id;
           $array[42] ="insert into tbl_amc_services (amc_child_id,amc_ref_code,asset_id,asset_code,service_id,service_description,amc_service_status,amc_visit_id) values(".$this->amc_tkt_id.",'".$this->amc_ticket_ref_no."',".$this->asset_id.",'".$this->asset_code."',".$this->ticket_service_id.",'".$this->service_description."','Pending',";
           $array[43] = "delete from tbl_amc_services where amc_service_id=".$this->ticket_service_id;
           
          
         $array[44] = "update tbl_visits set amc_schedule_color='#4CAF50',amc_visit_status='Closed' where amc_ticket='AMC' and date_of_visits='".$this->visit_date."' and  amc_tkt_id=".$this->amc_tkt_id." and amc_tkt_ref_no='".$this->amc_ticket_ref_no."'";
         $array[45] = "update tbl_visits set amc_schedule_color='#795548',amc_visit_status='Completed' where amc_ticket='AMC' and date_of_visits='".$this->visit_date."' and  amc_tkt_id=".$this->amc_tkt_id." and amc_tkt_ref_no='".$this->amc_ticket_ref_no."'";
         $array[46] = "update tbl_visits set amc_schedule_color='#ffc107',amc_visit_status='Extended' where amc_ticket='AMC' and date_of_visits='".$this->visit_date."' and  amc_tkt_id=".$this->amc_tkt_id." and amc_tkt_ref_no='".$this->amc_ticket_ref_no."'";
         
         $array[47] = "select tech_remarks,CONCAT('".$this->domain_path."audios/',tech_audio_file) as tech_audio_file from tbl_amc_services where  amc_service_id=".$this->ticket_service_id."";
        return $array;
    }
    
    function validate()
    {               
        
                  
                   
                  
                    if(trim($this->api_key)!='thcauthentication')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '101';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='WRONG API KEY';
    					$error_str = 'api_key_error';
    					return $error_str;
    					    
                    }
                  
                    if(trim($this->emp_code)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '102';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='EMPLOYEE NOT FOUND';
    					$error_str = 'emp_code_error';
    					return $error_str;
    					    
                    }
                   
                    
                    
    }
     function validatedate()
    {               
        
                  
                
                    if(trim($this->visit_date)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '103';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='DATE IS MISSING';
    					$error_str = 'date_error';
    					return $error_str;
    					    
                    }
                   
                    
                    
    }
     function validatevisit()
    {               
        
                  
                
                    if(trim($this->visit_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '104';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='VISIT ID IS MISSING';
    					$error_str = 'visit_id_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
    
    function validateamcticketrefno()
    {               
        
                  
                
                    if(trim($this->amc_ticket_ref_no)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '105';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='TICKET/AMC REF NO IS MISSING';
    					$error_str = 'amc_ticket_ref_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
    
     function validateamcticketid()
    {               
        
                  
                
                    if(trim($this->amc_tkt_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '106';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='AMC/TICKET ID IS MISSING';
    					$error_str = 'amc_ticket_id_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
     function validateamcticket()
    {               
        
                  
                
                    if(trim($this->amc_ticket)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '107';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='AMC/TICKET TOKEN IS MISSING';
    					$error_str = 'amc_ticket_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
     function validateserviceid()
    {               
        
                  
                
                    if(trim($this->ticket_service_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '108';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='SERVICE ID IS MISSING';
    					$error_str = 'amc_ticket_service_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
    
    function validateasset_code()
    {               
        
                  
                
                    if(trim($this->asset_code)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '109';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='ASSET CODE IS MISSING';
    					$error_str = 'asset_code_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
    
      function validate_ticket_team_ids()
    {               
        
                  
                
                    if(trim($this->ticket_team_ids)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '111';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='TICKET TEAM ID IS MISSING';
    					$error_str = 'amc_ticket_team_id_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
    
    function validate_upload_image()
    {               
        
                  
                
                    if(trim($this->asset_code)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '109';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='ASSET CODE IS MISSING';
    					$error_str = 'asset_code_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
  
    
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();

        switch (trim($FunctionEvents))
        {
            
            case 'get_schedule_dates':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        
                        default:
                             
                            $this->varModelObj->ListFromTable($var[0]);
                        break;
                        
                    }
                    
            break;
            case 'get_date_slots':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        default:
                            switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                     $this->varModelObj->ListFromTable($var[1]);
                                 break;
                            }
                            
                               
                        break;
                        
                    }
            break;
              case 'get_amc_ticket_details':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                      
                        
                        default:
                           
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                
                              default:
                                   
                                    switch($this->validateamcticketrefno())
                                        {
                                            case 'amc_ticket_ref_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 
                                                 $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id,amc_visit_id from tbl_visits where amc_tkt_ref_no="'.$this->amc_ticket_ref_no.'"');
                                            while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                
                                                $this->amc_ticket_condition=$row_amc_tkt['amc_ticket'];
                                            }
                                                    if($this->amc_ticket_condition=='TKT')
                                                    {
                                                      
                                                      echo  $this->varModelObj->ListFromTable($var[2]);
                                                       
                                                        
                                                    }
                                                    else
                                                    {
                                                        //GEt Amc Details
                                                         echo  $this->varModelObj->ListFromTable($var[31]);
                                                         
                                                    }
                                               
                                                
                                             break;
                                        }
                                    
                                 break;
                            }  
                        break;
                    }
            break;  
              case 'get_team_of_visit':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketrefno())
                                        {
                                            case 'amc_ticket_ref_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                              //  $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id,amc_visit_id from tbl_visits where amc_tkt_ref_no="'.$this->amc_ticket_ref_no.'" and date_of_visits="'.$this->visit_date.'"');
                                                $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id,amc_visit_id from tbl_visits where amc_tkt_ref_no="'.$this->amc_ticket_ref_no.'" and date_of_visits="'.$this->visit_date.'" and amc_tkt_id="'.$this->amc_tkt_id.'"');
                                            while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                
                                                $this->amc_ticket_condition=$row_amc_tkt['amc_ticket'];
                                                $this->amc_ticket_visit_id_condition=$row_amc_tkt['amc_visit_id'];
                                                
                                            }
                                                    if($this->amc_ticket_condition=='TKT')
                                                    {
                                                     
                                                        $this->varModelObj->ListFromTable($var[3].$this->amc_ticket_visit_id_condition);
                                                        
                                                    }
                                                    else
                                                    {
                                                         $this->varModelObj->ListFromTable($var[32].$this->amc_ticket_visit_id_condition);
                                                        //GEt Amc Details
                                                    }
                                               
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;
            
            
             case 'mark_emp_attendance':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        
                        default:
                            switch($this->validateamcticket())
                                 {
                                    case 'amc_ticket_error':
                                        echo json_encode($this->myObj);
                                    break;
                                    default:
                                        switch($this->validate_ticket_team_ids())
                                             {
                                                case 'amc_ticket_team_id_error':
                                                    echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                     $this->varModelObj->UpdateTable($var[29]); 
                                                break;
                                             }
                                        
                                    break;
                                 }
                             
                           
                        break;
                        
                    }
                    
            break;
            
            
            
            
            
            case 'get_visit_services':
                 switch($this->validate())
                    {
                      
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                  switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->ListFromTable($var[4]);
                                                     
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                                   $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_visit_id from tbl_visits where  date_of_visits="'.$this->visit_date.'" and amc_tkt_id="'.$this->amc_tkt_id.'" and amc_ticket="AMC"');
                                                        while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                            
                                                            
                                                            $this->amc_ticket_visit_id_condition=$row_amc_tkt['amc_visit_id'];
                                                            
                                                        }//Close While
                                                        $this->varModelObj->ListFromTable($var[33].$this->amc_ticket_visit_id_condition);
                                                 }
                                              break;
                                                }
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;      
            case 'get_slot_details_services':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                  switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->ListFromTable($var[5]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->ListFromTable($var[34]); 
                                                 }
                                              break;
                                                }
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;   
            
               case 'get_service_report_image':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                       
                        
                        default:
                              switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                  switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->ListFromTable($var[30]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                    // $this->varModelObj->ListFromTable($var[30]); 
                                                 }
                                              break;
                                                }
                                             break;
                                        }
                        break;
                        
                    }
            break;
            
            
             case 'get_service_images':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                       
                        
                        default:
                              switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                  switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->ListFromTable($var[6]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     $this->varModelObj->ListFromTable($var[7]); 
                                                 }
                                              break;
                                                }
                                             break;
                                        }
                        break;
                        
                    }
            break;
             case 'get_ticket_category_type':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                       
                        
                        default:
                              switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                  switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->ListFromTable($var[15]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                    //AMC Type
                                                    
                                                  //   $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id,amc_visit_id from tbl_visits where amc_ticket="AMC" and  date_of_visits="'.$this->visit_date.'" and amc_tkt_id="'.$this->amc_tkt_id.'"');
                                          //  while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                              
                                             //   $this->amc_ticket_visit_id_condition=$row_amc_tkt['amc_visit_id'];
                                                
                                           // }
                                                   
                                                   $this->varModelObj->ListFromTable($var[35]);   
                                                 //   $this->varModelObj->ListFromTable($var[35].$this->amc_ticket_visit_id_condition); 
                                                 }
                                              break;
                                                }
                                             break;
                                        }
                        break;
                        
                    }
            break;
            case 'get_service_status_details':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    //echo $var[13];
                                                     $this->varModelObj->ListFromTable($var[13]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                      $this->varModelObj->ListFromTable($var[36]); 
                                                 }
                                              break;
                                                }
                                                    break;
                                                 }
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;    
             case 'service_start':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    
                                                     $this->varModelObj->UpdateTable($var[8]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->UpdateTable($var[37]); 
                                                 }
                                              break;
                                                }
                                                    break;
                            break;                     }
                    }
            break;    
             case 'service_stop':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    
                                                     $this->varModelObj->UpdateTable($var[9]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->UpdateTable($var[38]); 
                                                 }
                                              break;
                                                }
                                                    break;
                            break;                     }
                    }
            break;    
            
             case 'undo_service_after_complete_close':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    
                                                     $this->varModelObj->UpdateTable($var[27]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->UpdateTable($var[39]); 
                                                 }
                                              break;
                                                }
                                                    break;
                            break;                     }
                    }
            break;    
             case 'service_cancel':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                  
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                  if(isset($_FILES['tech_audio'])){
                                                     $file_name = $_FILES['tech_audio']['name'];
                                                      $file_size = $_FILES['tech_audio']['size'];
                                                      $file_tmp = $_FILES['tech_audio']['tmp_name'];
                                                      $file_type = $_FILES['tech_audio']['type'];
                                                      $file_ext=strtolower(end(explode('.',$_FILES['tech_audio']['name'])));
                                                      
                                                       $this->tech_audio_file_name=$this->emp_code.'-'.$this->ticket_service_id.'-'.rand(10,100).'-'.$file_name;
                                                      
                                                     
                                                     
                                                     $extensions= array("mp3","mp4");
                                                        $maxsize = 2097152;
                                                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                                                        if (!in_array($ext, $extensions)) {
                                                            echo '0';
                                                //                 $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '301';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Wrong File Extension';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                       
                                                       else if (($file_size > $maxsize) || ($file_size == 0)){
                                                           echo '0';
                                                //              $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '302';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Max size is 2MB';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                        else
                                                        {
                                                             move_uploaded_file($file_tmp,"../../httpdocs/audios/".$this->tech_audio_file_name);
                                                //               $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '303';
                                            				// 	$this->myObj->status = 'Success';
                                            				// 	$this->myObj->api_message ='File Uploaded Successfully';
                                            				// echo json_encode($this->myObj);
                                            				$this->varModelObj->UpdateTableNoResponse("update tbl_ticket_services set tech_audio_file='".$this->tech_audio_file_name."' where  ticket_service_id=".$this->ticket_service_id);
                                            				echo '1';
                                                        }

                                                        }
                                                 
                                                    else
                                                    {
                                                         $this->tech_audio_file_name='NA';
                                                         echo '2';
                                                    }  
                                                     $this->varModelObj->UpdateTableNoResponse($var[11]); 
                                                            
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                       if(isset($_FILES['tech_audio'])){
                                                     $file_name = $_FILES['tech_audio']['name'];
                                                      $file_size = $_FILES['tech_audio']['size'];
                                                      $file_tmp = $_FILES['tech_audio']['tmp_name'];
                                                      $file_type = $_FILES['tech_audio']['type'];
                                                      $file_ext=strtolower(end(explode('.',$_FILES['tech_audio']['name'])));
                                                      
                                                       $this->tech_audio_file_name=$this->emp_code.'-'.$this->ticket_service_id.'-'.rand(10,100).'-'.$file_name;
                                                      
                                                     
                                                     
                                                     $extensions= array("mp3","mp4");
                                                        $maxsize = 2097152;
                                                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                                                        if (!in_array($ext, $extensions)) {
                                                            echo '0';
                                                //                 $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '301';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Wrong File Extension';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                       
                                                       else if (($file_size > $maxsize) || ($file_size == 0)){
                                                           echo '0';
                                                //              $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '302';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Max size is 2MB';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                        else
                                                        {
                                                             move_uploaded_file($file_tmp,"../../httpdocs/audios/".$this->tech_audio_file_name);
                                                //               $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '303';
                                            				// 	$this->myObj->status = 'Success';
                                            				// 	$this->myObj->api_message ='File Uploaded Successfully';
                                            				// echo json_encode($this->myObj);
                                            				 $this->varModelObj->UpdateTableNoResponse("update  tbl_amc_services set tech_audio_file='".$this->tech_audio_file_name."' where  amc_service_id=".$this->ticket_service_id);
                                            				 echo '1';
                                                        }

                                                        }
                                                 
                                                    else
                                                    {
                                                         $this->tech_audio_file_name='NA';
                                                         echo '2';
                                                    }  
                                                       $this->varModelObj->UpdateTableNoResponse($var[40]); 
                                                  
                                                 }
                                              break;
                                                }
                                                    break;
                            break;                     }
                    }
            break;    
             
              case 'service_complete':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                   
                                                    if(isset($_FILES['tech_audio'])){
                                                     $file_name = $_FILES['tech_audio']['name'];
                                                      $file_size = $_FILES['tech_audio']['size'];
                                                      $file_tmp = $_FILES['tech_audio']['tmp_name'];
                                                      $file_type = $_FILES['tech_audio']['type'];
                                                      $file_ext=strtolower(end(explode('.',$_FILES['tech_audio']['name'])));
                                                      
                                                       $this->tech_audio_file_name=$this->emp_code.'-'.$this->ticket_service_id.'-'.rand(10,100).'-'.$file_name;$file_name;
                                                      
                                                     
                                                     
                                                     $extensions= array("mp3","mp4");
                                                        $maxsize = 2097152;
                                                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                                                        if (!in_array($ext, $extensions)) {
                                                             echo '0';
                                                //                 $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '301';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Wrong File Extension';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                       else if (($file_size > $maxsize) || ($file_size == 0)){
                                                            echo '0';
                                                //              $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '302';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Max size is 2MB';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                        else
                                                        {
                                                             move_uploaded_file($file_tmp,"../../httpdocs/audios/".$this->tech_audio_file_name);
                                                             
                                                //               $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '303';
                                            				// 	$this->myObj->status = 'Success';
                                            				// 	$this->myObj->api_message ='File Uploaded Successfully';
                                            				// echo json_encode($this->myObj);
                                            				$this->varModelObj->UpdateTableNoResponse("update tbl_ticket_services set tech_audio_file='".$this->tech_audio_file_name."' where  ticket_service_id=".$this->ticket_service_id); 
                                            				 echo '1';
                                                        }
                                             
                                                        }
                                                   
                                                    else
                                                    {
                                                         $this->tech_audio_file_name='NA';
                                                         $this->varModelObj->UpdateTableNoResponse("update tbl_ticket_services set tech_audio_file='".$this->tech_audio_file_name."' where  ticket_service_id=".$this->ticket_service_id); 
                                                         echo '2';
                                                //           $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '303-1';
                                            				// 	$this->myObj->status = 'Success';
                                            				// 	$this->myObj->api_message ='Request Updated';
                                            				// echo json_encode($this->myObj);
                                                    }
                                                     $this->varModelObj->UpdateTableNoResponse($var[12]); 
                                                           
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                          if(isset($_FILES['tech_audio'])){
                                                     $file_name = $_FILES['tech_audio']['name'];
                                                      $file_size = $_FILES['tech_audio']['size'];
                                                      $file_tmp = $_FILES['tech_audio']['tmp_name'];
                                                      $file_type = $_FILES['tech_audio']['type'];
                                                      $file_ext=strtolower(end(explode('.',$_FILES['tech_audio']['name'])));
                                                      
                                                       $this->tech_audio_file_name=$this->emp_code.'-'.$this->ticket_service_id.'-'.rand(10,100).'-'.$file_name;$file_name;
                                                      
                                                     
                                                     
                                                     $extensions= array("mp3","mp4");
                                                        $maxsize = 2097152;
                                                        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                                                        if (!in_array($ext, $extensions)) {
                                                             echo '0';
                                                //                 $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '301';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Wrong File Extension';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                       else if (($file_size > $maxsize) || ($file_size == 0)){
                                                            echo '0';
                                                //              $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '302';
                                            				// 	$this->myObj->status = 'Failed';
                                            				// 	$this->myObj->api_message ='Max size is 2MB';
                                            				// echo json_encode($this->myObj);
                                                           
                                                        }
                                                        else
                                                        {
                                                             move_uploaded_file($file_tmp,"../../httpdocs/audios/".$this->tech_audio_file_name);
                                                //               $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '303';
                                            				// 	$this->myObj->status = 'Success';
                                            				// 	$this->myObj->api_message ='File Uploaded Successfully';
                                            				// echo json_encode($this->myObj);
                                            				$this->varModelObj->UpdateTableNoResponse("update tbl_amc_services set tech_audio_file='".$this->tech_audio_file_name."' where  amc_service_id=".$this->ticket_service_id); 
                                            				 echo '1';
                                                        }
                                             
                                                        }
                                                   
                                                    else
                                                    {
                                                         $this->tech_audio_file_name='NA';
                                                         $this->varModelObj->UpdateTableNoResponse("update tbl_amc_services set tech_audio_file='".$this->tech_audio_file_name."' where  amc_service_id=".$this->ticket_service_id); 
                                                          echo '2';
                                                //          $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                //                 $this->myObj->error_code = '303-2';
                                            				// 	$this->myObj->status = 'Success';
                                            				// 	$this->myObj->api_message ='Request Updated';
                                            				// echo json_encode($this->myObj);
                                                    }
                                                     $this->varModelObj->UpdateTableNoResponse($var[41]); 
                                                 
                                                     
                                                 }
                                              break;
                                                }
                                                    break;
                            break;                     }
                    }
            break;  
                case 'get_list_of_services_for_addition':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    
                                                      $result_cate_type =  mysqli_query($this->varDBConnection,'select category_id,type_id,asset_id,asset_code from tbl_tickets where ticket_ref_code="'.$this->amc_ticket_ref_no.'" and ticket_id='.$this->amc_tkt_id);
                                            while($row_cate_type=mysqli_fetch_assoc($result_cate_type)) {
                                                
                                                $this->cate_id=$row_cate_type['category_id'];
                                                $this->type_id=$row_cate_type['type_id'];
                                                $this->asset_id=$row_cate_type['asset_id'];
                                                $this->asset_code=$row_cate_type['asset_code'];
                                                
                                            }
                                              
                                             
                                              
                                              $this->varModelObj->ListFromTable('select service_id,service_description,'.$this->asset_id.' as asset_id,"'.$this->asset_code.'" as asset_code,"'.$this->amc_ticket_ref_no.'" as amc_ticket_ref_no,'.$this->amc_tkt_id.' as amc_tkt_id,"'.$this->amc_ticket.'" as amc_ticket  from tbl_services where category_id='.$this->cate_id.' and asset_type_id='.$this->type_id.' and service_status="Active"');       
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $result_cate_type =  mysqli_query($this->varDBConnection,'select category_id,asset_type_id as type_id,asset_id,asset_ref_no as asset_code from tbl_amc_child where amc_ref_no="'.$this->amc_ticket_ref_no.'" and amc_child_id='.$this->amc_tkt_id);
                                            while($row_cate_type=mysqli_fetch_assoc($result_cate_type)) {
                                                
                                                $this->cate_id=$row_cate_type['category_id'];
                                                $this->type_id=$row_cate_type['type_id'];
                                                $this->asset_id=$row_cate_type['asset_id'];
                                                $this->asset_code=$row_cate_type['asset_code'];
                                                
                                            }
                                              
                                             
                                              
                                              $this->varModelObj->ListFromTable('select service_id,service_description,'.$this->asset_id.' as asset_id,"'.$this->asset_code.'" as asset_code,"'.$this->amc_ticket_ref_no.'" as amc_ticket_ref_no,'.$this->amc_tkt_id.' as amc_tkt_id,"'.$this->amc_ticket.'" as amc_ticket  from tbl_services where category_id='.$this->cate_id.' and asset_type_id='.$this->type_id.' and service_status="Active"');  
                                                 }
                                              break;
                                                }
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break; 
            
              case 'add_new_services':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                    switch($this->validateamcticketrefno())
                                                        {
                                                            case 'amc_ticket_ref_error':
                                                                echo json_encode($this->myObj);
                                                             break;
                                                             default:
                                                                switch($this->validateamcticketid())
                                                                    {
                                                                        case 'amc_ticket_id_error':
                                                                            echo json_encode($this->myObj);
                                                                         break;
                                                                         default:
                                                                             switch($this->validateamcticket())
                                                                             {
                                                                             case 'amc_ticket_error':
                                                                            echo json_encode($this->myObj);
                                                                            break;
                                                                            default:
                                                                                
                                                                             if($this->amc_ticket=='TKT')
                                                                             {
                                                                          
                                                                              mysqli_query($this->varDBConnection,$var[14]);  
                                                                              $this->varModelObj->ListFromTable('SELECT LAST_INSERT_ID() as service_insert_ids'); 
                                                                           
                                                                             }
                                                                             else
                                                                             {
                                                                                 //AMC Services
                                             $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_visit_id from tbl_visits where  date_of_visits="'.$this->visit_date.'" and amc_tkt_id="'.$this->amc_tkt_id.'" and amc_ticket="AMC"');
                                                        while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                            
                                                            
                                                            $this->amc_ticket_visit_id_condition=$row_amc_tkt['amc_visit_id'];
                                                            
                                                        }
                                                        mysqli_query($this->varDBConnection,$var[42].$this->amc_ticket_visit_id_condition.')');  
                                                                              $this->varModelObj->ListFromTable('SELECT LAST_INSERT_ID() as service_insert_ids'); 
                                                                             }
                                                                          break;
                                                                            }
                                                                              
                                                                        break;
                                                                    }
                                                                
                                                            break;
                                                        }
                               
                                                    break;
                           
                                                }
                        break; 
                    }
            break;
              case 'remove_new_services':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                      
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                    echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->DeleteRow($var[16]); 
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->DeleteRow($var[43]); 
                                                 }
                                                break;
                                                }
                                                    break;
                            break;                     }
                    }
            break; 
             case 'close_ticket':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 switch($this->validatedate())
                                                 {
                                                    case 'date_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    $this->varModelObj->UpdateTable($var[17]); 
                                                    $this->varModelObj->UpdateTable($var[18]); 
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                      $this->varModelObj->UpdateTable($var[44]);
                                                 }
                                              break;
                                                }
                                                    break;
                                                 }
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;    
            case 'complete_ticket':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 switch($this->validatedate())
                                                 {
                                                    case 'date_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                   
                                                   $result_img = mysqli_query($this->varDBConnection,"select service_report_image from tbl_tickets where  ticket_id=".$this->amc_tkt_id." and ticket_ref_code='".$this->amc_ticket_ref_no."'");
                                                     if (mysqli_num_rows($result_img) > 0) {
                                         
                                          while($row_img = mysqli_fetch_assoc($result_img)) {
                                           if($row_img["service_report_image"]!='NA' || $row_img["service_report_image"]=='')
                                           {
                                               $this->varModelObj->UpdateTable($var[19]); 
                                                    $this->varModelObj->UpdateTable($var[20]); 
                                           }
                                           else
                                           {
                                                $result_img_ser = mysqli_query($this->varDBConnection,"select service_image_id  from tbl_service_images where amc_ticket='TKT' and  ticket_amc_id=".$this->amc_tkt_id." and ticket_amc_ref_code='".$this->amc_ticket_ref_no."'");
                                                 if (mysqli_num_rows($result_img_ser) > 0) {
                                                    $this->varModelObj->UpdateTable($var[19]); 
                                                    $this->varModelObj->UpdateTable($var[20]);     
                                                 }// Close of num rows $result_img_ser
                                             }  //Close of else 
                                            }// Close of while
                                            }// Close of num rows
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->UpdateTable($var[45]);
                                                 }
                                              break;
                                                }
                                                    break;
                                                 }
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;
             case 'extend_ticket':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 switch($this->validatedate())
                                                 {
                                                    case 'date_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                    $this->varModelObj->UpdateTable($var[21]); 
                                                    $this->varModelObj->UpdateTable($var[22]); 
                                                    
                                                    
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                      $this->varModelObj->UpdateTable($var[46]);
                                                 }
                                              break;
                                                }
                                                    break;
                                                 }
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;
              case 'upload_ticket_service_report_image':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                      case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                              
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                        //  upload images                                  
                                         if(isset($_FILES['service_image'])){
                                             $file_name = $_FILES['service_image']['name'];
                                              $file_size = $_FILES['service_image']['size'];
                                              $file_tmp = $_FILES['service_image']['tmp_name'];
                                              $file_type = $_FILES['service_image']['type'];
                                              $file_ext=strtolower(end(explode('.',$_FILES['service_image']['name'])));
                                              $this->service_image_file_name=$this->emp_code.'-'.$this->amc_tkt_id.'-'.rand(10,100).'-'.$file_name;
                                              $extensions= array("jpeg","jpg","png");
                                                $maxsize = 2097152;
                                                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                                                if (!in_array($ext, $extensions)) {
                                                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                        $this->myObj->error_code = '301';
                                    					$this->myObj->status = 'Failed';
                                    					$this->myObj->api_message ='Wrong File Extension';
                                    				echo json_encode($this->myObj);
                                                   
                                                }
                                              else if (($file_size > $maxsize) || ($file_size == 0)){
                                                     $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                        $this->myObj->error_code = '302';
                                    					$this->myObj->status = 'Failed';
                                    					$this->myObj->api_message ='Max size is 2MB';
                                    				echo json_encode($this->myObj);
                                                   
                                                }
                                                else
                                                {
                                                     move_uploaded_file($file_tmp,"../../httpdocs/images/service_report_images/".$this->service_image_file_name);
                                                      $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                                $this->myObj->error_code = '303';
                                            					$this->myObj->status = 'Success';
                                            					$this->myObj->api_message ='File Uploaded Successfully';
                                            				echo json_encode($this->myObj);
                                                }
                                             
                                                }
                                              
                                                    else
                                                    {
                                                         $this->service_image_file_name='NA';
                                                    }
                                                     mysqli_query($this->varDBConnection,"update  tbl_tickets set service_report_image='".$this->service_image_file_name."',service_report_upload_by_code='".$this->emp_code."',service_report_upload_date_time='".$this->createddatetime."' where ticket_ref_code='".$this->amc_ticket_ref_no."' and ticket_id=".$this->amc_tkt_id);
                                                    
                                                    
                                                
                                              break;
                                                }
                                                  
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;    
            
            case 'upload_ticket_service_images':
                //echo 'Upload images';
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                      case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                             switch($this->validateamcticketrefno())
                            {
                                case 'amc_ticket_ref_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validateamcticketid())
                                        {
                                            case 'amc_ticket_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                              
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                         //upload images  
                                       
                                         if(isset($_FILES['service_image'])){
                                             $file_name = $_FILES['service_image']['name'];
                                              $file_size = $_FILES['service_image']['size'];
                                              $file_tmp = $_FILES['service_image']['tmp_name'];
                                              $file_type = $_FILES['service_image']['type'];
                                              $file_ext=strtolower(end(explode('.',$_FILES['service_image']['name'])));
                                              $this->service_image_file_name=$this->emp_code.'-'.$this->amc_tkt_id.'-'.rand(10,100).'-'.$file_name;
                                              $extensions= array("jpeg","jpg","png");
                                                $maxsize = 2097152;
                                                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                                                if (!in_array($ext, $extensions)) {
                                                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                        $this->myObj->error_code = '301';
                                    					$this->myObj->status = 'Failed';
                                    					$this->myObj->api_message ='Wrong File Extension';
                                    				echo json_encode($this->myObj);
                                                   
                                                }
                                              else if (($file_size > $maxsize) || ($file_size == 0)){
                                                     $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                        $this->myObj->error_code = '302';
                                    					$this->myObj->status = 'Failed';
                                    					$this->myObj->api_message ='Max size is 2MB';
                                    				echo json_encode($this->myObj);
                                                   
                                                }
                                                else
                                                {
                                                     move_uploaded_file($file_tmp,"../../httpdocs/images/service_images/".$this->service_image_file_name);
                                                      $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                                                $this->myObj->error_code = '303';
                                            					$this->myObj->status = 'Success';
                                            					$this->myObj->api_message ='File Uploaded Successfully';
                                            				echo json_encode($this->myObj);
                                                }
                                             
                                                }
                                              
                                                    else
                                                    {
                                                         $this->service_image_file_name='NA';
                                                    }
                                                     mysqli_query($this->varDBConnection,"insert into tbl_service_images (amc_ticket,ticket_amc_ref_code,ticket_amc_id,asset_code,uploaded_user_code,uploaded_date_time,service_image_name) values ('".$this->amc_ticket."','".$this->amc_ticket_ref_no."',".$this->amc_tkt_id.",'".$this->asset_code."','".$this->emp_code."','".$this->createddatetime."','".$this->service_image_file_name."')");
                                                    
                                        
                                                
                                              break;
                                                }
                                                  
                                                  
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;    
            case 'get_asset_basic_details':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validateasset_code())
                                {
                                    case 'asset_code_error':
                                        echo json_encode($this->myObj);
                                    break;
                                    default:
                                         $this->varModelObj->ListFromTable($var[23]);
                                    break;
                                }
                           
                        break;
                        
                    }
                    
            break;
            case 'get_asset_service_details':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validateasset_code())
                                {
                                    case 'asset_code_error':
                                        echo json_encode($this->myObj);
                                    break;
                                    default:
                                      
                                         $this->varModelObj->ListFromTable($var[24]);
                                    break;
                                }
                           
                        break;
                        
                    }
                    
            break;
            
             case 'get_asset_service_images':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validateasset_code())
                                {
                                    case 'asset_code_error':
                                        echo json_encode($this->myObj);
                                    break;
                                    default:
                                      
                                         $this->varModelObj->ListFromTable($var[25]);
                                    break;
                                }
                           
                        break;
                        
                    }
                    
            break;
             case 'get_customer_care_no':   
                  
                    $this->varModelObj->ListFromTable($var[26]);
                    
            break;
            
             case 'get_service_description_against_service':
                 switch($this->validate())
                    {
                      
                      case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                      
                        
                        default:
                             switch($this->validateserviceid())
                                                 {
                                                    case 'amc_ticket_service_error':
                                                         echo json_encode($this->myObj);
                                                    break;
                                                    default:
                                                        switch($this->validateamcticket())
                                                 {
                                                 case 'amc_ticket_error':
                                                    echo json_encode($this->myObj);
                                                break;
                                                default:
                                                    
                                                 if($this->amc_ticket=='TKT')
                                                 {
                                                     $this->varModelObj->ListFromTable($var[28]); 
                                                 }
                                                 else
                                                 {
                                                     //AMC Services
                                                     $this->varModelObj->ListFromTable($var[47]);
                                                 }
                                                break;
                                                }
                                                    break;
                            break;                     }
                    }
            break; 
            
            default:
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '110';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='ACTION VALUE REQUIRED or NOT FOUND';
    					echo json_encode($this->myObj);
           break;
           
        }
         //file_put_contents("/home/sianlab/public_html/thc/api/log/api_response_out_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  json_encode($this->myObj), FILE_APPEND | LOCK_EX);

    }


}

$obj = new api1Controller();
$obj->RequestAccept($obj->actionevents);
