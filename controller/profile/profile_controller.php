<?php

require ('../../model/common/common_functions.php');



class profileController
{
       var $varModelObj,$varDBConnection;
	   public $actionevents,$company_id,$company_name,$company_vat_no,$company_po_box,$company_email,$company_tel_no,$company_fax_no,$company_address,$company_website;
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->company_id = $_POST['v_company_id'];
		$this->company_name = $_POST['v_company_name'];
        $this->company_vat_no = $_POST['v_company_vat_no'];
		$this->company_po_box = $_POST['v_company_po_box'];
		$this->company_email = $_POST['v_company_email'];
		$this->company_tel_no = $_POST['v_company_tel_no'];
	    $this->company_fax_no = $_POST['v_company_fax_no'];
		$this->company_address = $_POST['v_company_address'];
		$this->company_website = $_POST['v_company_website'];
        //$this->customer_name =$this->varDBConnection->real_escape_string($_POST['v_customer_name']);
        
      
           
            
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();

        
		
		
        $array[1] = "select * from 	tbl_thc_details";
        
		$array[2] = "UPDATE `tbl_thc_details` SET `thc_name`='".$this->company_name."',`vat_no`='".$this->company_vat_no."',`po_box`='".$this->company_po_box."',`tel_no`='".$this->company_tel_no."',`fax_no`='".$this->company_fax_no."',`thc_address`='".$this->company_address."',`thc_email`='".$this->company_email."',`thc_website`='".$this->company_website."' WHERE `ids`='".$this->company_id."'";
        
		
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
        
		
            case 'select_company_details':
           // echo $var[1];
                $this->varModelObj->ListFromTable($var[1]);
            break;
			
			case 'update_company':
                //echo $var[2];
                $this->varModelObj->UpdateTable($var[2]);
            break;
			
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new profileController();
$obj->RequestAccept($obj->actionevents);
?>