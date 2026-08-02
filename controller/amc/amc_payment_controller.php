<?php

require ('../../model/common/common_functions.php');



class amc_payment_Controller
{
    var $varModelObj,$varDBConnection;
    public $actionevents,$amc_id,$amc_amc_id,$amc_ref_no,$amc_cust_id_payments,$amc_cust_ref_no_payments,$amc_payable_vat_perct,$amc_payable_amt,$amc_payable_vat_amt,$amc_cust_total_payable_amt,$amc_cust_payment_date,$amc_cust_paid_amount,$amc_cust_paid_vat_per,$amc_cust_paid_vat_amount,$amc_cust_paid_total_amount,$amc_cust_invoice_ref_no,$amc_cust_payment_description,$amc_cust_payment_check_closing_entry,$amc_amc_payments_ids;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
		
        $this->amc_id = $_POST['amc_id'];
		$this->amc_amc_ref_no = $_POST['v_amc_ref_no'];
		$this->amc_cust_id = $_POST['v_cust_id'];
		
		$this->amc_amc_id = $_POST['v_amc_id'];
		$this->amc_ref_no = $_POST['v_amc_ref_no'];
		$this->amc_cust_id_payments = $_POST['v_amc_cust_id_payments'];
		$this->amc_cust_ref_no_payments = $_POST['v_amc_cust_ref_no_payments'];
		$this->amc_payable_vat_perct = $_POST['v_amc_payable_vat_perct'];
		$this->amc_payable_amt = $_POST['v_amc_payable_amt'];
		$this->amc_payable_vat_amt = $_POST['v_amc_payable_vat_amt'];
		$this->amc_cust_total_payable_amt = $_POST['v_amc_cust_total_payable_amt'];
		$this->amc_cust_payment_date = $_POST['v_amc_cust_payment_date'];
		$this->amc_cust_paid_amount = $_POST['v_amc_cust_paid_amount'];
		$this->amc_cust_paid_vat_per = $_POST['v_amc_cust_paid_vat_per'];
		$this->amc_cust_paid_vat_amount = $_POST['v_amc_cust_paid_vat_amount'];
		$this->amc_cust_paid_total_amount = $_POST['v_amc_cust_paid_total_amount'];
		$this->amc_cust_invoice_ref_no = $_POST['v_amc_cust_invoice_ref_no'];
		$this->amc_cust_payment_description = $_POST['v_amc_cust_payment_description'];
		$this->amc_cust_payment_check_closing_entry = $_POST['v_check_closing_entry'];
		

       $this->amc_amc_payments_ids= $_POST['v_amc_payments_ids'];

  
    }

    function SQLArray()
    { 
        $array =  array();
        
        // $array[1]="select *,DATE_FORMAT(date_of_payment, '%d-%m-%Y') as date_of_payment from   tbl_customer_payments where amc_id=".$this->amc_id." order by date_of_payment asc";
		$array[1]="call proc_customer_payment_collection_report('".$this->amc_cust_id."','".$this->amc_amc_ref_no."')";
		//$array[2]="call proc_amc_add_customer_payments('".$this->amc_cust_id_payments."','".$this->amc_cust_ref_no_payments."','PPM',".$this->amc_amc_id.",'".$this->amc_ref_no."',0,0,'".$this->amc_cust_payment_date."','".$this->amc_cust_invoice_ref_no."','".$this->amc_payable_amt."','".$this->amc_payable_vat_perct."','".$this->amc_payable_vat_amt."','".$this->amc_cust_total_payable_amt."','".$this->amc_cust_paid_amount."','". $this->amc_cust_paid_vat_per."','".$this->amc_cust_paid_vat_amount."','". $this->amc_cust_paid_total_amount."','".$this->amc_cust_payment_check_closing_entry."','".$this->amc_cust_payment_description."',@msg)";
		$array[2]="call proc_amc_add_customer_payments('".$this->amc_cust_id_payments."','".$this->amc_cust_ref_no_payments."','PPM',".$this->amc_amc_id.",'".$this->amc_ref_no."',0,0,'".$this->amc_cust_payment_date."','".$this->amc_cust_invoice_ref_no."',0,0,0,0,'".$this->amc_cust_paid_amount."','". $this->amc_cust_paid_vat_per."','".$this->amc_cust_paid_vat_amount."','". $this->amc_cust_paid_total_amount."','".$this->amc_cust_payment_check_closing_entry."','".$this->amc_cust_payment_description."',@msg)";
		$array[3]="call proc_amc_update_customer_payments('".$this->amc_amc_payments_ids."','".$this->amc_cust_payment_date."','".$this->amc_cust_invoice_ref_no."','".$this->amc_cust_paid_amount."','". $this->amc_cust_paid_vat_per."','".$this->amc_cust_paid_vat_amount."','". $this->amc_cust_paid_total_amount."','".$this->amc_cust_payment_check_closing_entry."','".$this->amc_cust_payment_description."',@msg)";
		$array[4]="delete from tbl_customer_payments where amc_payments_ids =".$this->amc_amc_payments_ids;
		      return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
			
			
			
			/*case 'amc_list_payments':
               //echo $var[1];
                    $this->varModelObj->ListFromTable($var[1]);
            break;*/

             case 'amc_list_payments':
               //echo $var[1];
                    $this->varModelObj->ListFromTable($var[1]);
            break; 
			case 'add_amc_customer_payments':
                     echo $var[2];
                    $this->varModelObj->ExecuteProcedure($var[2]);
            break;
			
			case 'update_amc_customer_payments':
			     //echo $var[3];
                $this->varModelObj->UpdateTable($var[3]);
           break;
		   
			case 'delete_amc_customer_payments':
				echo $var[4];
                $this->varModelObj->DeleteRow($var[4]);
           break;
       
                
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new amc_payment_Controller();
$obj->RequestAccept($obj->actionevents);
?>