<?php

require ('../../model/common/common_functions.php');



class searchamcController
{
        var $varModelObj,$varDBConnection;
        public $actionevents;
         
    function __construct()
	{
	     //$this->domain_path="http://thc.sianlab.com/httpdocs/";
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->createddate = date('Y-m-d');
       
        $this->amc_ref_no = $_POST['amc_ref_no'];
       
        $this->user_id=$_SESSION["user_id"];
        $this->username=$_SESSION["username"];
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        
        
        $array[0] = "select count(amc_id) as count_active from  tbl_amc_master where   amc_status='Active' ";
         $array[1] = "select count(amc_id) as count_hold from  tbl_amc_master where   amc_status='Hold' ";
         $array[2] = "select count(amc_id) as count_complete from  tbl_amc_master where   amc_status='Completed' ";
         $array[3] = "select count(amc_id) as count_cancel from  tbl_amc_master where   amc_status='Cancelled' ";
        
        
      
         
        $array[9] = "select *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date1,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date1, concat(DATE_FORMAT(amc_start_date, '%d-%m-%Y'),' - ',DATE_FORMAT(amc_end_date, '%d-%m-%Y')) as amc_dates,amc_amount+amc_vat_amt as amc_total_amt from  tbl_amc_master where amc_status='Active'  order by amc_id asc";
         $array[5] = "select *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date1,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date1, concat(DATE_FORMAT(amc_start_date, '%d-%m-%Y'),' - ',DATE_FORMAT(amc_end_date, '%d-%m-%Y')) as amc_dates,amc_amount+amc_vat_amt as amc_total_amt from  tbl_amc_master where amc_status='Hold'  order by amc_id asc";
         
         $array[6] = "select *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date, DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date1,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date1,concat(DATE_FORMAT(amc_start_date, '%d-%m-%Y'),' - ',DATE_FORMAT(amc_end_date, '%d-%m-%Y')) as amc_dates,amc_amount+amc_vat_amt as amc_total_amt from  tbl_amc_master where amc_status='Completed'  order by amc_id asc";
         
         $array[7] = "select *,DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date,DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date1,DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date1,DATE_FORMAT(cancelled_on, '%d-%m-%Y') as cancelled_on, concat(DATE_FORMAT(amc_start_date, '%d-%m-%Y'),' - ',DATE_FORMAT(amc_end_date, '%d-%m-%Y')) as amc_dates,amc_amount+amc_vat_amt as amc_total_amt from  tbl_amc_master where amc_status='Cancelled'  order by amc_id asc";
        
       
        
        $array[8] = "select *,DATE_FORMAT(warentee_end_date, '%d-%m-%Y') as warentee_end_date from   view_amc_asset_details where amc_ref_no='".$this->amc_ref_no."' and amc_child_status='Active' order by amc_child_id asc";
        $array[11] ="call delete_amc('".$this->amc_ref_no."')";
        $array[10] = "UPDATE tbl_amc_master set amc_status='Active' where amc_ref_no='".$this->amc_ref_no."'";
         
        $array[12] = "SELECT *,DATE_FORMAT(contract_start_date, '%d-%m-%Y') as contract_start_date,DATE_FORMAT(contract_end_date, '%d-%m-%Y') as contract_end_date  FROM  tbl_amc_subcontractors WHERE amc_subcontractor_status='Active' AND amc_number = '".$this->amc_ref_no."' ";
        //$array[13] = "select amc_ref_no from  tbl_amc_master where amc_status='Active'  order by amc_id asc";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
 
             case 'action_count_active':
     
                $this->varModelObj->ListFromTable($var[0]);
            break;
             case 'action_count_hold':
   
                $this->varModelObj->ListFromTable($var[1]);
            break;
            case 'action_count_completed':
     
                $this->varModelObj->ListFromTable($var[2]);
            break;
             case 'action_count_cancelled':
     
                $this->varModelObj->ListFromTable($var[3]);
            break;
          case 'list_amc_active':
    
                $this->varModelObj->ListFromTable($var[9]);
         break;
            case 'list_hold_amc':
     
                $this->varModelObj->ListFromTable($var[5]);
            break;
            case 'list_completed_amc':
     
                $this->varModelObj->ListFromTable($var[6]);
            break;
            case 'list_cancelled_amc':
     
                $this->varModelObj->ListFromTable($var[7]);
            break;
            case 'action_view_amc_child_details':
   
                $this->varModelObj->ListFromTable($var[8]);
            break;
            case 'amc_delete':
   
                 $this->varModelObj->ExecuteProcedure($var[11]);
            break;
             case 'active_status':
    
                $this->varModelObj->UpdateTable($var[10]);
            break;
			
			case 'action_view_amc_subcontractors_details':
   
                $this->varModelObj->ListFromTable($var[12]);
            break;
          
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new searchamcController();
$obj->RequestAccept($obj->actionevents);
?>