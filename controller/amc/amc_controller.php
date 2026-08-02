<?php

require ('../../model/common/common_functions.php');

session_start();


class apartmentController
{
    var $varModelObj,$varDBConnection;
    public $actionevents,$ctrl_name,$product_category_id, $product_category_name,$product_type_id,$product_type_name, $product_item_name,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        
        $this->amc_cust_id = $_POST['v_amc_cust_id'];
        $this->amc_cust_code = $_POST['v_amc_cust_code'];
        $this->amc_cust_name = $_POST['v_amc_cust_name'];
        $this->amc_contract_type_id = $_POST['v_amc_contract_type_id'];
        $this->amc_contract_type_name = $_POST['v_amc_contract_type_name'];
        $this->amc_signed_date = $_POST['v_amc_signed_date'];
        $this->amc_start_date = $_POST['v_amc_start_date'];
        
        $this->amc_end_date = $_POST['v_amc_end_date'];
        $this->amc_amount = $_POST['v_amc_amount'];
        $this->amc_vat_percentage = $_POST['v_amc_vat_percentage'];
        $this->amc_vat_per_amount = $_POST['v_amc_vat_per_amount'];
        $this->amc_is_rfp = $_POST['v_amc_is_rfp'];
        $this->amc_description = $_POST['v_amc_description'];
        $this->amc_first_desc = $_POST['v_amc_first_desc'];
        $this->amc_second_desc = $_POST['v_amc_second_desc'];
        $this->amc_third_desc = $_POST['v_amc_third_desc'];
        
         $this->total_payable_amt = $_POST['v_total_payable_amt'];
        $this->first_attachment = $_POST['v_first_attachment'];
        
        $this->second_attachment = $_POST['v_second_attachment'];
        $this->third_attachment = $_POST['v_third_attachment'];
        
        $this->amc_status = $_POST['v_amc_status'];
        $this->amc_staus_description = $_POST['v_amc_staus_description'];
        
        $this->amc_ref_no=$_POST['v_amc_ref_no'];
        
        $this->amc_cust_id_edit = $_POST['v_amc_cust_id_edit'];
        $this->amc_cust_code_edit = $_POST['v_amc_cust_code_edit'];
		$this->amc_cust_name_edit = $_POST['v_amc_cust_name_edit'];
        $this->amc_contract_type_id_edit = $_POST['v_amc_contract_type_id_edit'];
        $this->amc_contract_type_name_edit = $_POST['v_amc_contract_type_name_edit'];
        $this->amc_signed_date_edit = $_POST['v_amc_signed_date_edit'];
        
		$this->amc_start_date_edit = $_POST['v_amc_start_date_edit'];
        $this->amc_end_date_edit = $_POST['v_amc_end_date_edit'];
        $this->amc_amount_edit = $_POST['v_amc_amount_edit'];
        $this->amc_vat_percentage_edit = $_POST['v_amc_vat_percentage_edit'];
		$this->amc_vat_per_amount_edit = $_POST['v_amc_vat_per_amount_edit'];
        $this->amc_is_rfp_edit = $_POST['v_amc_is_rfp_edit'];
        $this->amc_description_edit = $_POST['v_amc_description_edit'];
        $this->first_attachment_edit = $_POST['v_first_attachment_edit'];
		$this->second_attachment_edit = $_POST['v_second_attachment_edit'];
        $this->third_attachment_edit = $_POST['v_third_attachment_edit'];
        $this->amc_first_desc_edit = $_POST['v_amc_first_desc_edit'];
        $this->amc_second_desc_edit = $_POST['v_amc_second_desc_edit'];
		$this->amc_third_desc_edit = $_POST['v_amc_third_desc_edit'];
        $this->amc_hidden_id = $_POST['v_amc_hidden_id'];
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        $this->total_amc_amnt = $_POST['v_total_amc_amnt'];
        
      
        
        $this->amc_renewal_amount = $_POST['v_amc_renewal_amount'];
        $this->amc_renewal_vat_percentage = $_POST['v_amc_renewal_vat_percentage'];
        $this->amc_renewal_vat_per_amount = $_POST['v_amc_renewal_vat_per_amount'];
        $this->amc_renewal_start_date = $_POST['v_amc_renewal_start_date'];
        $this->v_amc_renewal_end_date = $_POST['v_amc_renewal_end_date'];
        $this->amc_renewal_signed_date = $_POST['v_amc_renewal_signed_date'];
        $this->amc_ref_no = $_POST['v_amc_ref_no'];
       
        
        $this->customer_id = $_POST['v_customer_id'];
        $this->customer_name =$this->varDBConnection->real_escape_string($_POST['v_customer_name']);
        $this->customer_code = $_POST['v_customer_code'];
        $this->customer_number = $_POST['v_customer_contact_no'];
        $this->customer_email_id = $_POST['v_customer_email_id'];
        $this->customer_po_box= $_POST['v_customer_po_box'];
        $this->customer_location = $_POST['v_customer_location'];
        $this->contact_person = $this->varDBConnection->real_escape_string($_POST['v_contact_person']);
        $this->contact_person_number = $_POST['v_contact_person_number'];
        $this->cpr_cr_number = $_POST['v_cpr_cr_number'];
        $this->vat_number = $_POST['v_vat_number']; 
        $this->customer_address = $this->varDBConnection->real_escape_string($_POST['v_customer_address']);
        $this->customer_description = $this->varDBConnection->real_escape_string($_POST['v_description']);
        $this->customer_status = $_POST['v_customer_status']; 
        $this->location_id = $_POST['v_location_id'];
        $this->building_id = $_POST['v_building_id'];
        $this->asset_type_id = $_POST['v_asset_type_id'];
        $this->category_id = $_POST['v_category_id'];
		
		$this->amc_id = $_POST['v_amc_id'];
		$this->amc_number = $_POST['v_amc_ref_no'];
		$this->subcontractor_id = $_POST['v_amc_contractor_id'];
		$this->subcontractor_name = $_POST['v_amc_contractor_name'];
		$this->contractor_description = $_POST['v_contractor_description'];
		$this->contractor_amount = $_POST['v_contractor_amount'];
		$this->contractor_vat = $_POST['v_contractor_vat'];
		$this->contractor_total_amount = $_POST['v_contractor_total_amount'];
		$this->contract_start_date = $_POST['v_amc_start_date'];
		$this->contract_end_date = $_POST['v_amc_end_date'];
		$this->file_name = $_POST['v_session_image'];
		$this->amc_subcontractor_ids = $_POST['v_amc_subcontractor_ids'];
		$this->subcontractor_action = $_POST['v_subcontractor_action'];
		$this->old_amc_ref_no = $_POST['v_old_amc_ref_no'];
		$this->amc_parent_parent_ref_no = $_POST['v_amc_parent_parent_ref_no'];
        
        $this->amc_renew_image = $_POST['amc_renew_image'];
        $this->renew_remarks = $this->varDBConnection->real_escape_string($_POST['renew_remarks']);
		$this->deactive_reason = $_POST['v_txt_deactive_reason'];
		
		$this->amc_ref_no1 = $_POST['amc_ref_no'];
		$this->module = $_POST['module'];
        $this->event = $_POST['event'];
        $this->ip_addr = $_SERVER['REMOTE_ADDR'];
        $this->formData = json_encode($_POST);
		$jsonData = $this->formData;
		$formDataArray = json_decode($jsonData, true);
		unset($formDataArray['module']);
		unset($formDataArray['event']);
		unset($formDataArray['username']);
		unset($formDataArray['action']);
		unset($formDataArray['amc_ref_no']);
		$this->formData = json_encode($formDataArray);
		
		$this->username = $_SESSION["username"];
		$this->v_username = $_POST['v_username'];
		$this->start_date = $_POST['v_start_date'];
		$this->end_date = $_POST['v_end_date'];
		
		// unset($_POST['module']);
		// unset($_POST['event']);
		// unset($_POST['username']);
        
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
        //proc_add_amc_details_v1
        //'".$this->total_amc_amnt."',
         $array[1]="call proc_add_amc_details_v2('".$this->amc_cust_id."', '".$this->amc_cust_name."', '".$this->amc_cust_code."', '".$this->amc_contract_type_id."', '".$this->amc_contract_type_name."', '".$this->amc_signed_date."', '".$this->amc_start_date."', '".$this->amc_end_date."', '".$this->amc_amount."', '".$this->total_amc_amnt."', '".$this->amc_vat_percentage."', '".$this->amc_vat_per_amount."', '". $this->amc_is_rfp."', '".$this->amc_description."', 'Active', 'NA',0,0,0,'NA',0, '".$this->first_attachment."', '".$this->amc_first_desc."', '".$this->second_attachment."', '".$this->amc_second_desc."', '".$this->third_attachment."', '".$this->amc_third_desc."',@msg,'PPM',0,0,0,'".$this->total_payable_amt."',0,0,0,0,0,'Active')";
         $array[2]="select *,date_format(amc_signed_date,'%d-%m-%Y') as amc_signed_date ,date_format(amc_start_date,'%d-%m-%Y') as amc_start_date,date_format(amc_end_date,'%d-%m-%Y') as amc_end_date,date_format(cancelled_on,'%d-%m-%Y') as cancelled_on,amc_start_date as amc_start_date1,amc_end_date as amc_end_date1 from tbl_amc_master where amc_status='Hold' or amc_status='Active'"; 
         $array[3]="Update tbl_amc_master set amc_status='".$this->amc_status."',hold_description='".$this->amc_staus_description."' where amc_ref_no='".$this->amc_ref_no."' ";
         $array[4]="Update tbl_amc_master set amc_status='".$this->amc_status."',cancelled_description='".$this->amc_staus_description."',cancelled_on='".$this->current_date."' where amc_ref_no='".$this->amc_ref_no."' ";
         $array[5]="Update tbl_amc_master set amc_status='".$this->amc_status."' where amc_ref_no='".$this->amc_ref_no."' ";
        
         $array[6]="call proc_update_amc_v1(".$this->amc_cust_id_edit.",'".$this->amc_cust_name_edit."','".$this->amc_cust_code_edit."',".$this->amc_contract_type_id_edit.",'".$this->amc_contract_type_name_edit."','".$this->amc_signed_date_edit."','".$this->amc_start_date_edit."','".$this->amc_end_date_edit."','".$this->amc_amount_edit."','". $this->amc_vat_percentage_edit."','".$this->amc_vat_per_amount_edit."','". $this->amc_is_rfp_edit."','".$this->amc_description_edit."','Active','NA',0,0,0,'NA',0,'".$this->first_attachment_edit."','".$this->amc_first_desc_edit."','".$this->second_attachment_edit."','".$this->amc_second_desc_edit."','".$this->third_attachment_edit."','".$this->amc_third_desc_edit."','".$this->amc_hidden_id."','".$this->total_payable_amt."','".$this->total_amc_amnt."')";
         $array[7]="select *,date_format(amc_signed_date,'%d-%m-%Y') as amc_signed_date ,date_format(amc_start_date,'%d-%m-%Y') as amc_start_date,date_format(amc_end_date,'%d-%m-%Y') as amc_end_date,date_format(cancelled_on,'%d-%m-%Y') as cancelled_on from tbl_amc_master where amc_status='Cancelled' or amc_status='Completed' ";
        
        $array[8]  = "call proc_renewal_amc('".$this->amc_renewal_amount."','".$this->amc_renewal_vat_percentage."','".$this->amc_renewal_vat_per_amount."','".$this->amc_renewal_start_date."','".$this->v_amc_renewal_end_date."','".$this->amc_renewal_signed_date."','".$this->amc_ref_no."','".$this->amc_renew_image."','".$this->renew_remarks."',@msg,@p_ids)";
        $array[9] = "INSERT INTO `tbl_customers`(`customer_name`, `customer_contact_no`, `customer_email_id`, `customer_po_box`, `customer_location`, `customer_contact_person_name`, `customer_contact_person_no`, `customer_cpr_cr_no`, `customer_vat_no`, `customer_address`, `customer_description`, `customer_status`) VALUES('".$this->customer_name."','".$this->customer_number."','".$this->customer_email_id."','".$this->customer_po_box."','".$this->customer_location."','".$this->contact_person."','".$this->contact_person_number."','".$this->cpr_cr_number."','".$this->vat_number."','".$this->customer_address."','".$this->customer_description."','Active')";
		$array[10] ="update tbl_customers set `customer_code`='".$this->customer_code ."' where customer_id='".$this->customer_id."'";
		$array[11] ="update tbl_amc_master set renewal_status='YES', amc_status = 'Completed' where amc_ref_no='".$this->amc_ref_no."'";
	//	$array[12] ="SELECT * FROM `tbl_assets` where customer_id='".$this->amc_cust_id."' and amc_ref_no='".$this->amc_ref_no."' and location_id='".$this->location_id."' and building_id='".$this->building_id."' and asset_type_id='".$this->asset_type_id."' and asset_category_id='".$this->category_id."'";
		$array[12] ="SELECT * FROM `tbl_assets` order by asset_id desc";
		$array[13] ="Select customer_id,customer_name,customer_code from tbl_amc_master where amc_ref_no='".$this->amc_ref_no."'";
        
		$array[14] ="SELECT *,date_format(contract_start_date,'%d-%m-%Y') as contract_start_date ,date_format(contract_end_date,'%d-%m-%Y') as contract_end_date FROM `tbl_amc_subcontractors` WHERE amc_id = '".$this->amc_id."' ";
		$array[15] = "INSERT INTO `tbl_amc_subcontractors`(`amc_id`, `amc_number`, `subcontractor_id`, `subcontractor_name`, `contractor_description`, `contract_amount`, `contract_vat`, `contract_total_amount`, `contract_start_date`, `contract_end_date`, `file_name`) VALUES('".$this->amc_id."','".$this->amc_number."','".$this->subcontractor_id."','".$this->subcontractor_name."', '".$this->contractor_description."','".$this->contractor_amount."','".$this->contractor_vat."','".$this->contractor_total_amount."','".$this->contract_start_date."','".$this->contract_end_date."','".$this->file_name."')";

		$array[16] = "UPDATE `tbl_amc_subcontractors` SET `amc_id`='".$this->amc_id."',`amc_number`='".$this->amc_number."',`subcontractor_id`='".$this->subcontractor_id."',`subcontractor_name`='".$this->subcontractor_name."', contractor_description = '".$this->contractor_description."', `contract_amount`='".$this->contractor_amount."',`contract_vat`='".$this->contractor_vat."',`contract_total_amount`='".$this->contractor_total_amount."',`contract_start_date`='".$this->contract_start_date."',`contract_end_date`='".$this->contract_end_date."',`file_name`='".$this->file_name."' WHERE amc_subcontractor_ids = '".$this->amc_subcontractor_ids."' ";
        $array[17] = "UPDATE tbl_amc_subcontractors SET `amc_subcontractor_status`='Deactive' WHERE amc_subcontractor_ids='".$this->amc_subcontractor_ids."'";
        
        $array[18] = "UPDATE tbl_amc_subcontractors SET `amc_subcontractor_status`='Active', contractor_deactive_reason = '', contractor_deactive_date = '' WHERE amc_subcontractor_ids='".$this->amc_subcontractor_ids."' "; 
		$array[19] = "DELETE FROM tbl_amc_subcontractors WHERE amc_subcontractor_ids='".$this->amc_subcontractor_ids."'  ";

		$array[20] ="SELECT *,date_format(amc_start_date,'%d/%m/%Y') as amc_start_date ,date_format(amc_end_date,'%d/%m/%Y') as amc_end_date FROM `tbl_amc_master` WHERE amc_ref_no = '".$this->amc_number."' "; 
		$array[21] ="SELECT *,date_format(amc_start_date,'%d/%m/%Y') as amc_start_date ,date_format(amc_end_date,'%d/%m/%Y') as amc_end_date FROM `tbl_amc_master` WHERE amc_parent_parent_ref_no = '".$this->amc_parent_parent_ref_no."' order by amc_id desc";
		// $array[22] = "INSERT INTO tbl_amc_subcontractors (`amc_id`, `amc_number`, `subcontractor_id`, `subcontractor_name`,`contractor_description`,`contract_amount`,`contract_vat`,`contract_total_amount`,`contract_start_date`,`contract_end_date`,`file_name`,`amc_subcontractor_status`) SELECT '".$this->amc_id."', '".$this->amc_ref_no."', `subcontractor_id`, `subcontractor_name`,`contractor_description`,`contract_amount`,`contract_vat`,`contract_total_amount`,CURRENT_DATE(),'0000-00-00',`file_name`,`amc_subcontractor_status` FROM tbl_amc_subcontractors WHERE amc_number='".$this->old_amc_ref_no."' ";
		
		$array[23]="Update tbl_amc_master set amc_status='Completed' where amc_ref_no='".$this->amc_ref_no."' ";
		$array[24] = "SELECT *,DATE_FORMAT(contract_start_date, '%d/%m/%Y') as contract_start_date,DATE_FORMAT(contract_end_date, '%d/%m/%Y') as contract_end_date  FROM  tbl_amc_subcontractors WHERE amc_number = '".$this->amc_ref_no."' ";
		
		$array[25] = "INSERT INTO `tbl_amc_subcontractors`(`amc_id`, `amc_number`, `subcontractor_id`, `subcontractor_name`, `contractor_description`, `contract_amount`, `contract_vat`, `contract_total_amount`, `contract_start_date`, `contract_end_date`, `file_name`) VALUES('".$this->amc_id."','".$this->amc_ref_no."','".$this->subcontractor_id."','".$this->subcontractor_name."', '".$this->contractor_description."','".$this->contractor_amount."','".$this->contractor_vat."','".$this->contractor_total_amount."','".$this->contract_start_date."','".$this->contract_end_date."','".$this->file_name."')";
		
		$array[26] = "UPDATE tbl_amc_subcontractors SET `amc_subcontractor_status`='Deactive', contractor_deactive_reason = '".$this->deactive_reason."', contractor_deactive_date = '".$this->current_date."' WHERE amc_subcontractor_ids='".$this->amc_subcontractor_ids."'";
	   
	    $array[27] = "INSERT INTO tbl_amc_log (jsondata,amc_ref_no,username,default_date,event_type,ip_address,modules) VALUES ('".$this->formData."','".$this->amc_ref_no1."','".$this->username."','".$this->current_date."','".$this->event."','".$this->ip_addr."','".$this->module."')";
		
		$array[28] = "SELECT *,DATE_FORMAT(default_date, '%d-%m-%Y %H:%i:%s') as default_date FROM  tbl_amc_log WHERE DATE(default_date) BETWEEN '".$this->start_date."' AND '".$this->end_date."'";
		$array[29] = "SELECT *,DATE_FORMAT(default_date, '%d-%m-%Y %H:%i:%s %p') as default_date FROM  tbl_amc_log WHERE username = '".$this->username."' AND DATE(default_date) BETWEEN '".$this->start_date."' AND '".$this->end_date."' ";
		$array[30] = "SELECT *,DATE_FORMAT(default_date, '%d-%m-%Y %H:%i:%s %p') as default_date FROM  tbl_amc_log WHERE DATE(default_date) = DATE('".$this->current_date."') ";
	    $array[31]="select amc_ref_no from tbl_amc_master where amc_status='Hold' or amc_status='Active' ";
	   return $array;
    }
    function RequestAccept($FunctionEvents) 
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'add_amc':
            //echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
            case 'amc_list_view': 
            //echo $var[1];
                $this->varModelObj->DataWithQR($var[31],"../../httpdocs/qr_lib/asset_qr/amc_qr/",'amc_ref_no',2,2);
                $this->varModelObj->ListFromTable($var[2]);
            break;
            case 'change_status':
                if($this->amc_status=='Hold')
                {
                $this->varModelObj->UpdateTable($var[3]);
                }
                else if($this->amc_status=='Cancelled')
                {
                $this->varModelObj->UpdateTable($var[4]);
                }
                else
                {
                 $this->varModelObj->UpdateTable($var[5]);   
                }
            break;
           case 'update_amc':
            //echo $var[6];
                $this->varModelObj->ExecuteProcedure($var[6]);
            break;
             case 'amc_list_cance_complete_view':
            //echo $var[1];
                $this->varModelObj->ListFromTable($var[7]);
            break;
            case 'renewal_amc':
                //echo "Q  ".$var[8];
                echo $this->varModelObj->ExecuteProcedureTwoValues($var[8]);
                $this->varModelObj->UpdateTable($var[11]);
			
				
            break;
             
            case 'add_customer':
                //echo $var[4];
                $this->varModelObj->AddToTable($var[9]);
            break;
		    case 'update_customer_code':
                //echo $var[5];
                $this->varModelObj->UpdateTable($var[10]);
            break;
            case 'amc_asset_schedule_list_view':
            //echo $var[12];
                $this->varModelObj->ListFromTable($var[12]);
            break;
             case 'asset_schedule_customer_list':
            //echo $var[13];
                $this->varModelObj->ListFromTable($var[13]);
            break;
			
			case 'assigned_subcontractor_list_view':
                //echo $var[14];
                $this->varModelObj->ListFromTable($var[14]);
            break;
			
			case 'assign_subcontractor':
                //echo $var[15];
                $this->varModelObj->AddToTable($var[15]);
            break;
			
			 case 'update_amc_subcontractor':
                //echo $var[16];
                $this->varModelObj->UpdateTable($var[16]);
            break;
			
			case 'change_amc_subcontractor_status':
                if($this->subcontractor_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[18]);
                }
                // else
                // {
                  // $this->varModelObj->UpdateTable($var[17]);  
                // }
            break;
			
			case 'delete_amc_subcontractor':
				//echo $var[19];
                $this->varModelObj->DeleteRow($var[19]);
            break;
			
			case 'renewal_amc_list':
			if($this->amc_parent_parent_ref_no === "0" || $this->amc_parent_parent_ref_no === "NA")
			{
				//echo "Query   :".$var[20];
				$this->varModelObj->ListFromTable($var[20]);
			}
			else 
			{
				$this->varModelObj->ListFromTable($var[21]);
			}
                 
            break;
			
			case 'add_amc_sub_renew':
                //echo $var[22]; 
                $this->varModelObj->AddToTable($var[22]);
            break;
			 
			case 'renew_complete_status':
                //echo $var[23];
                $this->varModelObj->UpdateTable($var[23]);
            break;
			
			case 'amc_subcontractor_list_view_before_renew':
                //echo $var[24];
                $this->varModelObj->ListFromTable($var[24]);
            break;
			
			case 'renew_assign_subcontractor':
                //echo $var[25]; 
                $this->varModelObj->AddToTable($var[25]);
            break;
			
			case 'deactive_amc_subcontractor_status':
                //echo $var[26];
                $this->varModelObj->UpdateTable($var[26]);
            break;
			
			case 'amc_log':
                //echo "q : ".$var[27]; 
                $this->varModelObj->AddToTable($var[27]);
            break;
			
			case 'list_amc_event_log':
            //echo $var[28];
            if($this->v_username === 'All')
			{
				//echo "d";
                $this->varModelObj->ListFromTable($var[28]);
			}
			else if($this->v_username === '')
			{
				//echo "hjd".$var[30];
				$this->varModelObj->ListFromTable($var[30]); 
			}
			else 
			{
				//echo "Q1 : ".$var[29];
				$this->varModelObj->ListFromTable($var[29]);	
			}
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