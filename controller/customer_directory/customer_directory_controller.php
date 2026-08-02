<?php

require ('../../model/common/common_functions.php');



class customerController
{
       var $varModelObj,$varDBConnection;
	   public $actionevents,$ctrl_name,$customer_id, $customer_name,$customer_password, $customer_number,$customer_email_id,$customer_po_box,$customer_location,$contact_person,$contact_person_number,$cpr_cr_number,$vat_number,$customer_address,$customer_description,$customer_status,$customer_action;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
		
        $this->customer_id = $_POST['v_customer_id'];
        
            
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();

        $array[0] = "select * from 	tbl_customers where customer_id='".$this->customer_id."'";
        
		$array[1] = "select * from  tbl_customer_location where customer_id='".$this->customer_id."'";
		
		$array[2] = "select * from  tbl_assets where customer_id='".$this->customer_id."'";
		
		//$array[3] = "select * from  tbl_amc_master where customer_id='".$this->customer_id."'";
		$array[3]="select *,date_format(amc_signed_date,'%d-%m-%Y') as amc_signed_date ,date_format(amc_start_date,'%d-%m-%Y') as amc_start_date,date_format(amc_end_date,'%d-%m-%Y') as amc_end_date,date_format(cancelled_on,'%d-%m-%Y') as cancelled_on from tbl_amc_master where customer_id='".$this->customer_id."' ";
		
		$array[4] = "select *,date_format(created_date_time,'%d-%m-%Y') as created_date_time from  tbl_tickets where customer_id='".$this->customer_id."' order by ticket_status desc";
		
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'fetch_customer_details':
               // echo $var[0];
            		$this->varModelObj->ListFromTable($var[0]);
            break;
            
            case 'list_customer_facilities':
               // echo $var[1];
            		$this->varModelObj->ListFromTable($var[1]);
            break;
            
            case 'list_customer_assets':
               // echo $var[2];
            		$this->varModelObj->ListFromTable($var[2]);
            break;
            case 'list_customer_amc':
               // echo $var[3];
            		$this->varModelObj->ListFromTable($var[3]);
            break;
            case 'list_customer_ticket':
              //  echo $var[4];
            		$this->varModelObj->ListFromTable($var[4]);
            break;
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new customerController();
$obj->RequestAccept($obj->actionevents);
?>