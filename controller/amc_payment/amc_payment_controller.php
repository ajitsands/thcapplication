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
        $array[0] = "select *,sum(`total_payable_amt`) as total_payable_amt, date_format(amc_signed_date,'%d-%m-%Y') as amc_signed_date ,date_format(amc_start_date,'%d-%m-%Y') as amc_start_date,date_format(amc_end_date,'%d-%m-%Y') as amc_end_date_format,sum(`total_paid_amt`) as total_paid_amt,sum(`paid_amount`) as paid_amount, sum(`paid_vat_amt`) as paid_vat_amt  FROM `view_amc_payment_report` as a where (select sum(`total_payable_amt`) as total_payable_amt from view_amc_payment_report as b where a.amc_id=b.amc_id) -(select sum(`paid_amount`) as paid_amount from view_amc_payment_report as c where a.amc_id=c.amc_id)>0 group by`amc_id` ";
        $array[1] = "select *,sum(`total_payable_amt`) as total_payable_amt, date_format(amc_signed_date,'%d-%m-%Y') as amc_signed_date ,date_format(amc_start_date,'%d-%m-%Y') as amc_start_date,date_format(amc_end_date,'%d-%m-%Y') as amc_end_date_format,sum(`total_paid_amt`) as total_paid_amt,sum(`paid_amount`) as paid_amount, sum(`paid_vat_amt`) as paid_vat_amt  FROM `view_amc_payment_report` as a where (select sum(`total_payable_amt`) as total_payable_amt from view_amc_payment_report as b where a.amc_id=b.amc_id) -(select sum(`paid_amount`) as paid_amount from view_amc_payment_report as c where a.amc_id=c.amc_id)=0 group by`amc_id`";
		
	
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'amc_payment_list':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[0]);
            break;
            case 'amc_payment_completed_list':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[1]);
            break;
            case 'amc_payment_list_search':
            //echo $var[0];
                $this->varModelObj->ListFromTable($var[1]);
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