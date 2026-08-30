<?php

require_once __DIR__ . '/../../model/common/common_functions.php';



class apartmentController
{
        var $varModelObj,$varDBConnection;
       public $actionevents,$ctrl_name,$employee_type_id, $employee_type_name,$employee_code,$emp_cnt, $employee_password,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1,$employee_action,
       $customer_id,$customer_name,$po_box,$address,$contact_no,$attension,$quotation_date,$subject,$description,$quantity,$unit,$rate,$vat_content,$quotation_number,$total,$grand_total,$terms_and_condition,$created_by_id,$created_by_name,$approved_by_id,$approved_by_name,$reference_number_date,$quotation_child_id,$quotation_master_id,$quotation_list_child_id,$quotation_start_date,$quotation_end_date,$quotation_customer_id,$quotation_number_rivision,$current_date;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = isset($_POST['action']) ? $_POST['action'] : '';
        $this->ctrl_name = isset($_POST['v_ctrl_name']) ? $_POST['v_ctrl_name'] : '';
		
        $this->customer_id = isset($_POST['v_customer_id']) ? $_POST['v_customer_id'] : '';
		$this->customer_name = isset($_POST['v_customer_name']) ? $_POST['v_customer_name'] : '';
		$this->po_box = isset($_POST['v_po_box']) ? $_POST['v_po_box'] : '';
		$this->address = isset($_POST['v_address']) ? $_POST['v_address'] : '';
		$this->contact_no = isset($_POST['v_contact_no']) ? $_POST['v_contact_no'] : '';
		$this->attension = isset($_POST['v_attension']) ? $_POST['v_attension'] : '';
		$this->quotation_date = isset($_POST['v_quotation_date']) ? $_POST['v_quotation_date'] : '';
		$this->subject = isset($_POST['v_subject']) ? $_POST['v_subject'] : '';
		$this->description = isset($_POST['v_description']) ? $_POST['v_description'] : '';
		$this->quantity = isset($_POST['v_quantity']) ? $_POST['v_quantity'] : '';
		$this->unit = isset($_POST['v_unit']) ? $_POST['v_unit'] : '';
		$this->rate = isset($_POST['v_rate']) ? $_POST['v_rate'] : '';
		$this->vat_content = isset($_POST['v_vat_content']) ? $_POST['v_vat_content'] : '';
	
		$this->quotation_number = isset($_POST['v_quotation_number']) ? $_POST['v_quotation_number'] : '';
		$this->total = isset($_POST['v_total']) ? $_POST['v_total'] : '';
		$this->grand_total = isset($_POST['v_grand_total']) ? $_POST['v_grand_total'] : '';  
        $this->terms_and_condition = isset($_POST['v_terms_and_condition']) ? $_POST['v_terms_and_condition'] : '';
        $this->created_by_id = isset($_POST['v_created_by_id']) ? $_POST['v_created_by_id'] : '';
		$this->created_by_name = isset($_POST['v_created_by_name']) ? $_POST['v_created_by_name'] : '';
		$this->approved_by_id = isset($_POST['v_approved_by_id']) ? $_POST['v_approved_by_id'] : '';
		$this->approved_by_name = isset($_POST['v_approved_by_name']) ? $_POST['v_approved_by_name'] : '';  
		$this->reference_number_date = isset($_POST['reference_number_date']) ? $_POST['reference_number_date'] : '';
		$this->quotation_child_id = isset($_POST['v_quotation_child_id']) ? $_POST['v_quotation_child_id'] : '';
		$this->quotation_master_id = isset($_POST['v_quotation_master_id']) ? $_POST['v_quotation_master_id'] : '';
		$this->quotation_list_child_id = isset($_POST['v_quotation_child_list_id']) ? $this->varDBConnection->real_escape_string($_POST['v_quotation_child_list_id']) : '';
		
        $this->employee_action = isset($_POST['v_employee_action']) ? $_POST['v_employee_action'] : '';
        
        $this->quotation_start_date = isset($_POST['v_quotation_start_date']) ? $_POST['v_quotation_start_date'] : '';
        $this->quotation_end_date = isset($_POST['v_quotation_end_date']) ? $_POST['v_quotation_end_date'] : '';
        $this->quotation_customer_id = isset($_POST['v_quotation_customer_id']) ? $_POST['v_quotation_customer_id'] : '';
        
        $this->quotation_number_rivision = isset($_POST['v_quotation_number_rivision']) ? $_POST['v_quotation_number_rivision'] : '';
        
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
 
        $array[0] ="Select * from tbl_customers  where customer_id='".$this->customer_id."'";
        
		$array[1] =" call proc_add_quotation ('".$this->customer_id."','".$this->customer_name."','".$this->po_box."','".$this->address."','".$this->contact_no."','".$this->attension."','".$this->quotation_date."','".$this->subject."','".$this->description."','".$this->created_by_id."','".$this->created_by_name."','".$this->approved_by_id."','".$this->approved_by_name."','".$this->quotation_number."','".$this->quantity."','".$this->unit."','".$this->rate."','".$this->total."','".$this->vat_content."','".$this->reference_number_date ."',@msg)";
        
		$array[2] ="Select * from tbl_quotation_child where quotation_ref_no='".$this->quotation_number."' order by quotation_child_id desc";
		
		$array[3] ="call proc_generate_quotation ('".$this->customer_id."','".$this->customer_name."','".$this->po_box."','".$this->address."','".$this->contact_no."','".$this->attension."','".$this->quotation_date."','".$this->subject."','".$this->description."','".$this->quantity."','".$this->unit."','".$this->rate."','".$this->discount."','".$this->tax."','".$this->total."','".$this->grand_total."','".$this->created_by_id."','".$this->created_by_name."','".$this->approved_by_id."','".$this->approved_by_name."','".$this->quotation_number."','".$this->terms_and_condition."')";
		
		//$array[3] ="UPDATE `tbl_quotation_master` SET `terms_and_condition`='".$this->terms_and_condition."',`quotation_status`='Generated' WHERE `quotation_ref_no`='".$this->quotation_number."'";
		
		$array[4] = "DELETE from tbl_quotation_child WHERE quotation_child_id='".$this->quotation_list_child_id."'";
		
		$array[5] ="UPDATE `tbl_quotation_child` SET `quotation_id`='".$this->quotation_master_id."',`quotation_ref_no`='".$this->quotation_number."',`description`='".$this->description."',`quantity`='".$this->quantity."',`unit`='".$this->unit."',`rate`='".$this->rate."',`total`='".$this->total."',`discount`='".$this->discount."',`vat`='".$this->tax."',`grant_total`='".$this->grand_total."' WHERE quotation_child_id='".$this->quotation_child_id."'";
        
		//$array[6] ="Select * from tbl_quotation_master";
		$array[6] ="SELECT * FROM tbl_quotation_master WHERE `date` BETWEEN '".$this->quotation_start_date."' AND '".$this->quotation_end_date."' AND `customer_id`='".$this->quotation_customer_id."' order by `quotation_id` desc";
		
					
		$array[7] ="SELECT `quotation_id`,`quotation_ref_no`,`customer_id`, `customer_name`, `po_box`, `contact_no`, `address`, `attention`, `date`, `subject`, `terms_and_condition` from tbl_quotation_master where quotation_ref_no='".$this->quotation_number."'";
		
		$array[8] ="SELECT `quotation_child_id`,`quotation_id`,`description`, `quantity`, `unit`, `rate`, `discount`, `vat`,`grant_total`,`total`,`quotation_ref_no` from tbl_quotation_child where quotation_ref_no='".$this->quotation_number."'";
		
		$array[9] =" call proc_add_quotation_rivision ('".$this->customer_id."','".$this->customer_name."','".$this->po_box."','".$this->address."','".$this->contact_no."','".$this->attension."','".$this->quotation_date."','".$this->subject."','".$this->description."','".$this->created_by_id."','".$this->created_by_name."','".$this->approved_by_id."','".$this->approved_by_name."','".$this->quantity."','".$this->unit."','".$this->rate."','".$this->total."','".$this->discount."','".$this->tax."','".$this->grand_total."','".$this->quotation_number ."','".$this->terms_and_condition."','".$this->quotation_number_rivision."')";
		
		$array[10] =" select * from tbl_quotation_master where MONTH(`date`)=MONTH(now()) and YEAR(`date`)=YEAR(now()) order by `quotation_id` desc";
		
		$array[11] =" select quotation_status from tbl_quotation_master where `quotation_ref_no`='".$this->quotation_number."'";
		
		return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'customer_list_view':
				// echo $var[0];
                $this->varModelObj->ListFromTable($var[0]);
            break;
			
			case 'add_quotation':
				//echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
			
			case 'quotation_list_view':  
				 //echo $var[2];
                $this->varModelObj->ListFromTable($var[2]);
            break;
             
		   case 'generate_quotation':
				//echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
			
			 case 'cancel_quotation_item': 
				//echo $var[4];
                $this->varModelObj->DeleteRow($var[4]);
            break;

			case 'edit_quotation': 
                //echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
			
			
			case 'quotation_details_list_view': 
			    if( $this->quotation_start_date==null||$this->quotation_end_date==null||$this->quotation_customer_id=="SELECT CUSTOMER")
			        {
			            //echo $var[10];
			            $this->varModelObj->ListFromTable($var[10]);
			            
			        }
			     else
			     {
			         //echo $var[6];
                    $this->varModelObj->ListFromTable($var[6]);
			         
			     }
				
            break;
			
			
			case 'quotation_details_list_edit_master':  
				 //echo $var[7];
                $this->varModelObj->ListFromTable($var[7]);
            break;
			
			case 'quotation_details_list_edit_child':  
				 //echo $var[8];
                $this->varModelObj->ListFromTable($var[8]);
            break;
			
			
			case 'rivision_quotation_add':
				//echo $var[9];
                $this->varModelObj->ExecuteProcedure($var[9]);
            break;
            case 'check_quotation_status_for_print':
				//echo $var[9];
                $this->varModelObj->ListFromTable($var[11]);
            break;
			
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new apartmentController();
$obj->RequestAccept($obj->actionevents);
?>