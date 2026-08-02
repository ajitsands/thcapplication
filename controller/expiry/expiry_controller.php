<?php

require ('../../model/common/common_functions.php');



class expiryController
{
        
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->search_date = $_POST['search_date'];
        $this->search_date_visa = $_POST['search_date_visa'];
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
       
        $array[2] = "select *,DATE_FORMAT(cpr_expiry_date,'%d/%m/%Y') as cpr_expiry_date_format,date(cpr_expiry_date) as cpr_expiry_date1 from 	view_employee_expertiser_list where cpr_expiry_date < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(cpr_expiry_date) ASC, MONTH(cpr_expiry_date) ASC, DAY(cpr_expiry_date) ASC";
        $array[1] = "Select min(cpr_expiry_date) as min_cpr_expiry_date from view_employee_expertiser_list where  ";
        $array[3] = "select *,DATE_FORMAT(cpr_expiry_date,'%d/%m/%Y') as cpr_expiry_date_format from 	view_employee_expertiser_list where cpr_expiry_date < '".$this->search_date."' order by YEAR(cpr_expiry_date) ASC, MONTH(cpr_expiry_date) ASC, DAY(cpr_expiry_date) ASC";
        $array[4] = "select *,DATE_FORMAT(visa_validity_on,'%d/%m/%Y') as visa_validity_on_format from 	view_employee_expertiser_list where visa_validity_on < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(visa_validity_on) ASC, MONTH(visa_validity_on) ASC, DAY(visa_validity_on) ASC";
        $array[5] = "select *,DATE_FORMAT(visa_validity_on,'%d/%m/%Y') as visa_validity_on_format from 	view_employee_expertiser_list where visa_validity_on < '".$this->search_date_visa."' order by YEAR(visa_validity_on) ASC, MONTH(visa_validity_on) ASC, DAY(visa_validity_on) ASC";
       
        
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
     
        switch ($FunctionEvents)
        {
        
           case 'select_min_cpr_expiry_date':
           // echo $var[2];
                $this->varModelObj->ListFromTable($var[1]);
            break;
            
            case 'employee_cpr_expire_list_view':
           // echo $var[2];
                $this->varModelObj->ListFromTable($var[2]);
            break;
           
            case 'employee_cpr_expire_list_view_search_date':
            
                $this->varModelObj->ListFromTable($var[3]);
            break;
            
             case 'employee_visa_expire_list_view':
           // echo $var[2];
                $this->varModelObj->ListFromTable($var[4]);
            break;
            
             case 'employee_visa_expire_list_search':
            
                $this->varModelObj->ListFromTable($var[5]);
            break;
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new expiryController();
$obj->RequestAccept($obj->actionevents);
?>