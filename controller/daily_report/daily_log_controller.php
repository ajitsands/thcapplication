<?php

require ('../../model/common/common_functions.php');




class logController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name ;
        
        
    function __construct()
	{
	    
        
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
		
        $this->status = $_POST['status'];
	    $this->from_date=$_POST['from_date'];
		$this->to_date=$_POST['to_date'];
		
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
                                
         //$array[0] = "select  ticket_id,ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_service_status='".$this->status."' and ticket_id in (select amc_tkt_id from tbl_visits where  date_of_visits >= '".$this->from_date."' AND date_of_visits <= '".$this->to_date."' and	amc_visit_status not in ('Cancelled') and amc_ticket='TKT') union select  amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code,service_complete_cancel_by_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%Y-%m-%d %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_service_status='".$this->status."' and amc_visit_id in (select amc_visit_id from tbl_visits where  date_of_visits >= '".$this->from_date."' AND date_of_visits <= '".$this->to_date."' and amc_visit_status not in ('Cancelled') and amc_ticket='AMC')";
         $array[0] = "select  ticket_id,ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code as start_emp_code,service_complete_cancel_by_emp_code as finish_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where  ticket_service_status='".$this->status."' and ticket_id in (select amc_tkt_id from tbl_visits where  date_of_visits = '".$this->from_date."'  and	amc_visit_status not in ('Cancelled') and amc_ticket='TKT') union select  amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code as start_emp_code,service_complete_cancel_by_emp_code as finish_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where  amc_service_status='".$this->status."' and amc_visit_id in (select amc_visit_id from tbl_visits where  date_of_visits = '".$this->from_date."'  and amc_visit_status not in ('Cancelled') and amc_ticket='AMC')";
         $array[1] =  "select  ticket_id,ticket_ref_code,service_description,tech_remarks,ticket_service_status,service_start_by_emp_code as start_emp_code,service_complete_cancel_by_emp_code as finish_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_ticket_services where   ticket_id in (select amc_tkt_id from tbl_visits where  date_of_visits = '".$this->from_date."'  and	amc_visit_status not in ('Cancelled') and amc_ticket='TKT') union select  amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code,service_description,tech_remarks,amc_service_status as ticket_service_status,service_start_by_emp_code as start_emp_code,service_complete_cancel_by_emp_code as finish_emp_code,tech_audio_file,DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1,DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1,FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24)as days_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt,FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr,MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr,CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), ' Days. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), ' Hrs. ',FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_hrs,CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), ' Min. ',MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), ' Sec.') AS difference_mins from  tbl_amc_services where   amc_visit_id in (select amc_visit_id from tbl_visits where  date_of_visits = '".$this->from_date."'  and amc_visit_status not in ('Cancelled') and amc_ticket='AMC')";
         
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
           
            case 'list_work_orders':
                switch($this->status)
                {
                    case 'All':
                       
                        $this->varModelObj->ListFromTable($var[1]);
                    break;
                   
                    default:
                      
                        $this->varModelObj->ListFromTable($var[0]);
                    break;
                        
                }
            
                
            break;
             
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new logController();
$obj->RequestAccept($obj->actionevents);
?>