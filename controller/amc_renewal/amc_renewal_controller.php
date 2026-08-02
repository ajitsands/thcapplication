<?php

require ('../../model/common/common_functions.php');



class amcRenewalController
{
    var $varModelObj,$varDBConnection;
      
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->search_date = $_POST['search_date'];
     
    }
    
    
     
    
    function SQLArray() 
    { 
        $array =  array();
        $array[0] = "select *,date_format(amc_signed_date,'%d/%m/%Y') as amc_signed_date ,date_format(amc_start_date,'%d/%m/%Y') as amc_start_date,date_format(amc_end_date,'%d/%m/%Y') as amc_end_date_format,date_format(cancelled_on,'%d-%m-%Y') as cancelled_on from tbl_amc_master where  renewal_status='No' and amc_status in('Active', 'Hold') and amc_end_date < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(amc_end_date) DESC, MONTH(amc_end_date) DESC, DAY(amc_end_date) DESC";
        $array[1] = "select *,date_format(amc_signed_date,'%d/%m/%Y') as amc_signed_date ,date_format(amc_start_date,'%d/%m/%Y') as amc_start_date,date_format(amc_end_date,'%d/%m/%Y') as amc_end_date_format,date_format(cancelled_on,'%d-%m-%Y') as cancelled_on from tbl_amc_master where  renewal_status='No' and amc_status in('Active', 'Hold') and amc_end_date < '".$this->search_date."' order by YEAR(amc_end_date) DESC, MONTH(amc_end_date) DESC, DAY(amc_end_date) DESC";
	    $array[2] = "select amc_ref_no from tbl_amc_master where  renewal_status='No' and amc_status in('Active', 'Hold') and amc_end_date < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(amc_end_date) DESC, MONTH(amc_end_date) DESC, DAY(amc_end_date) DESC";
        $array[3] = "SELECT *, DATE_FORMAT(amc_signed_date,'%d/%m/%Y') AS amc_signed_date, DATE_FORMAT(amc_start_date,'%d/%m/%Y') AS amc_start_date, DATE_FORMAT(amc_end_date,'%d/%m/%Y') AS amc_end_date FROM tbl_amc_master WHERE amc_status='Active' AND DATE_FORMAT(amc_end_date,'%Y-%m-%d') < DATE_FORMAT(date_add(now(), interval 1 month),'%Y-%m-%d')";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'amc_renewal_list':
            //echo $var[0];
                $this->varModelObj->DataWithQR($var[2],"../../httpdocs/qr_lib/asset_qr/amc_renew_qr/",'amc_ref_no',2,2);
                $this->varModelObj->ListFromTable($var[0]);
            break;
            case 'amc_renewal_list_search':
            //echo $var[0];
                $this->varModelObj->DataWithQR($var[2],"../../httpdocs/qr_lib/asset_qr/amc_renew_qr/",'amc_ref_no',2,2);
                $this->varModelObj->ListFromTable($var[1]);
            break;
            
            case "list_amc_renwalsDashboard":
                $this->varModelObj->ListFromTable($var[3]);
            break;    
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new amcRenewalController();
$obj->RequestAccept($obj->actionevents);
?>