<?php

require ('../../model/common/common_functions.php');



class LocalpoController
{
    var $varModelObj,$varDBConnection;
    public $v_vendor_name,$v_po_box,$v_vat_no,$v_tele_ph,$v_lpo_date,$v_lpo_subject,$v_item_name,$v_item_qty,$v_item_unit,$v_fax_no,$v_qtn_ref_no,$v_discount_percent,$v_tax_percent,$v_total_amount,$v_vendor_id_val,$v_lpo_ref_no,$v_grand_total,$v_vat_percent,$v_vendor_id,$v_lpo_child_id,$v_description,$v_quantity,$v_unit,$v_unit_price,$v_discount,$v_tax,$v_vat,$v_lpo_ref,$v_unit_rate,$v_lpo_child_id_delete,$v_lpo_list_child_id,$v_list_description,$v_list_quantity,$v_list_unit,$list_unit_price,$v_list_discount,$v_list_tax,$v_list_grand_total,$v_lpo_child_second_id,$v_reference,$var_vendor_id_val,$var_vendor_name,$var_vat_no,$var_qtn_ref_no,$var_po_box,$var_lpo_date,$var_tele_ph,$var_fax_no,$var_lpo_subject,$var_terms_cond,$vr_terms_and_condition,$vr_reference_no,$vr_vendor_id,$vr_vendor_name,$vr_vat_no,$vr_qtn_ref_no,$vr_lpo_po,$vr_tel_no,$vr_fax_no,$vr_subject,$vr_lpo_date,$vendor_list_id,$lpo_end_date,$lpo_start_date,$total,$prepared_by_id,$prepared_by_name;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
		
		
		$this->v_vendor_id = $_POST['v_vendor_id'];
        $this->v_vendor_id_val = $_POST['vendor_id_val'];
        $this->v_vendor_name = $_POST['vendor_name'];
		$this->v_lpo_ref_no = $_POST['lpo_ref_no'];
        $this->v_po_box = $_POST['po_box'];
        $this->v_vat_no = $_POST['vat_no'];
        $this->v_tele_ph = $_POST['tele_ph'];
		$this->v_lpo_date = $_POST['lpo_date'];
        $this->v_lpo_subject = $_POST['lpo_subject'];
        $this->v_item_name = $_POST['item_name'];
        $this->v_item_qty = $_POST['item_qty'];
        $this->v_item_unit = $_POST['item_unit'];
        $this->v_unit_price = $_POST['unit_price'];
        $this->v_discount_percent = $_POST['discount_percent'];
		$this->v_tax_percent = $_POST['tax_percent'];
		$this->v_vat_percent = $_POST['vat_percent'];
        $this->v_total_amount = $_POST['total_amount'];
		$this->v_grand_total = $_POST['v_grand_total'];
		$this->v_lpo_child_id = $_POST['v_lpo_child_id'];
		$this->v_lpo_child_id_delete =$this->varDBConnection->real_escape_string($_POST['v_lpo_child_id_delete']); 
		$this->v_description = $_POST['v_description'];
		$this->v_quantity = $_POST['v_quantity'];
		$this->v_unit = $_POST['v_unit'];
		// $this->v_unit_rate = $_POST['unit_price'];
		$this->v_discount = $_POST['v_discount'];
		$this->v_tax = $_POST['v_tax'];
		//$this->v_vat = $_POST['v_vat'];
		
		$this->v_lpo_ref = $_POST['lpo_ref'];
		
		$this->v_lpo_list_child_id = $_POST['v_lpo_list_child_id'];
        $this->v_list_description = $_POST['v_list_description'];
        $this->v_list_quantity = $_POST['v_list_quantity'];
		$this->v_list_unit = $_POST['v_list_unit'];
        $this->list_unit_price = $_POST['list_unit_price'];
        $this->v_list_discount = $_POST['v_list_discount'];
        $this->v_list_tax = $_POST['v_list_tax'];
		$this->v_list_grand_total = $_POST['v_list_grand_total'];
		$this->total = $_POST['v_total'];
		
        $this->v_lpo_child_second_id = $_POST['v_lpo_child_second_id'];
		
        $this->v_reference = $_POST['v_reference'];
		$this->var_vendor_id_val = $_POST['var_vendor_id_val'];
		$this->var_vendor_name = $_POST['var_vendor_name'];
		$this->var_vat_no = $_POST['var_vat_no'];
		$this->var_qtn_ref_no = $_POST['var_qtn_ref_no'];
		$this->var_po_box = $_POST['var_po_box'];
		$this->var_lpo_date = $_POST['var_lpo_date'];
		$this->var_tele_ph = $_POST['var_tele_ph'];
		$this->var_fax_no = $_POST['var_fax_no'];
		$this->var_lpo_subject = $_POST['var_lpo_subject'];
		$this->var_terms_cond = $_POST['var_terms_cond'];

		
        $this->vr_reference_no = $_POST['v_reference_no'];
        $this->vr_terms_and_condition = $_POST['v_terms_and_condition'];
        $this->vr_vendor_id = $_POST['v_vendor_id'];
        $this->vr_vendor_name = $_POST['v_vendor_name'];
        $this->vr_vat_no = $_POST['v_vat_no'];
		$this->vr_qtn_ref_no = $_POST['v_qtn_ref_no'];
		$this->vr_lpo_po = $_POST['v_lpo_po'];
        $this->vr_tel_no = $_POST['v_tel_no'];
		$this->vr_fax_no = $_POST['v_fax_no'];
		$this->vr_lpo_date = $_POST['v_lpo_date'];
		$this->vr_subject = $_POST['v_subject'];
		$this->v_lpo_child_second_id =$this->varDBConnection->real_escape_string($_POST['v_lpo_child_second_id']);
		
		
		$this->lpo_start_date = $_POST['v_lpo_start_date'];
        $this->lpo_end_date = $_POST['v_lpo_end_date'];
        $this->vendor_list_id = $_POST['v_vendor_list_id'];
        
		
		$this->v_fax_no = $_POST['fax_no'];
        $this->v_qtn_ref_no = $_POST['qtn_ref_no'];
        
        $this->prepared_by_id = $_POST['v_prepared_by_id'];
        $this->prepared_by_name = $_POST['v_prepared_by_name'];
     	date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();

	     $array[0]="select * from tbl_vendors  where vendor_id='".$this->v_vendor_id."'";																								
		 $array[1]="call proc_add_lpo('".$this->v_vendor_id_val."','".$this->v_vendor_name."','".$this->v_lpo_ref_no."','".$this->v_po_box."','".$this->v_fax_no."','".$this->v_vat_no."','".$this->v_qtn_ref_no."',".$this->v_tele_ph.",'".$this->v_lpo_date."','".$this->v_lpo_subject."','".$this->v_item_name."','".$this->v_item_qty."','".$this->v_item_unit."','".$this->v_unit_price."','".$this->v_discount_percent."','".$this->v_tax_percent."','".$this->v_total_amount."','".$this->v_grand_total."','".$this->prepared_by_id."','".$this->prepared_by_name."',@msg)";
		 
		 $array[2] ="select * from tbl_lpo_child where lpo_ref_no='".$this->v_lpo_ref."' order by lpo_child_id desc";
		 
		 $array[3]="call proc_edit_lpo('".$this->v_description."','".$this->v_quantity."','".$this->v_unit."','".$this->v_unit_price."','".$this->total."','".$this->v_discount."','".$this->v_tax."','".$this->v_grand_total."','".$this->v_lpo_child_id."')";
			
		 $array[4] ="delete from tbl_lpo_child where lpo_child_id='".$this->v_lpo_child_id_delete."'";
			
		 $array[5] ="update tbl_lpo_master set  vendor_id='".$this->var_vendor_id_val."',vendor_name='".$this->var_vendor_name."',vendor_vat_no='".$this->var_vat_no."',vendor_po='".$this->var_po_box."',vendor_tel='".$this->var_tele_ph."',vendor_fax='".$this->var_fax_no."',quotation_ref_no='".$this->var_qtn_ref_no."',lpo_date='".$this->var_lpo_date."',subject='".$this->var_lpo_subject."',terms_and_conditions='".$this->var_terms_cond."',lpo_status='generated' where lpo_ref_no='".$this->v_reference."'";
		 
		 
		  
		 $array[6]="select * from tbl_lpo_master WHERE `lpo_date` BETWEEN '".$this->lpo_start_date."' AND '".$this->lpo_end_date."' AND `vendor_id`='".$this->vendor_list_id."' order by `lpo_master_id` desc";
		 $array[7]="select * from tbl_lpo_child where lpo_ref_no='".$this->v_lpo_ref."' order by lpo_child_id desc"; 
		 
		 $array[8]="UPDATE tbl_lpo_child set description='".$this->v_list_description."',quantity='".$this->v_list_quantity."',unit='".$this->v_list_unit."',unit_price='".$this->list_unit_price."',total_price='".$this->total."',discount='".$this->v_list_discount."',tax='".$this->v_list_tax."',grand_total='".$this->v_list_grand_total."' where lpo_child_id='".$this->v_lpo_list_child_id."'";
		 
		 $array[9] ="delete from tbl_lpo_child where lpo_child_id='".$this->v_lpo_child_second_id."'";
		 
		 $array[10]="UPDATE tbl_lpo_master set vendor_id='".$this->vr_vendor_id."',vendor_name='".$this->vr_vendor_name."',vendor_vat_no='".$this->vr_vat_no."',vendor_po='".$this->vr_lpo_po."',vendor_tel='".$this->vr_tel_no."',vendor_fax='".$this->vr_fax_no."',quotation_ref_no='".$this->vr_qtn_ref_no."',lpo_date='".$this->vr_lpo_date."',subject='".$this->vr_subject."',terms_and_conditions='".$this->vr_terms_and_condition."',lpo_status='generated' where lpo_ref_no='".$this->vr_reference_no."'";
		 $array[11] =" select * from tbl_lpo_master order by `lpo_master_id` desc";
		 return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
			case 'vendor_list':
				// echo $var[0];
                $this->varModelObj->ListFromTable($var[0]);
            break;
		
            case 'insert_lpo_details':
            //echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
            case 'lpo_list_view':
           //echo $var[2];
                $this->varModelObj->ListFromTable($var[2]);
            break;
			 case 'update_lpo':
          //echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
			case 'delete_lpo':
          //echo $var[4];
                $this->varModelObj->DeleteRow($var[4]);
				
            break;
            case 'update_lpo_generate_status':
          //echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
				
            break;
			case 'lpo_details_list_view':
          //echo $var[5];
                if( $this->lpo_start_date==null||$this->lpo_end_date==null||$this->vendor_list_id=="SELECT VENDOR")
			        {
			            //echo $var[10];
			            $this->varModelObj->ListFromTable($var[11]);
			            
			        }
			     else
			     {
			         //echo $var[6];
                    $this->varModelObj->ListFromTable($var[6]);
			         
			     }
				
            break;
                
			case 'view_child_details':
          //echo $var[5];
                $this->varModelObj->ListFromTable($var[7]);
				
            break;
			case 'update_second_lpo':
          //echo $var[5];
                $this->varModelObj->UpdateTable($var[8]);
				
            break;
			case 'delete_second_lpo':
          //echo $var[5];
                $this->varModelObj->ListFromTable($var[9]);
				
            break;
			
			case 'update_final_lpo':
          //echo $var[5];
                $this->varModelObj->UpdateTable($var[10]);
				
            break;

            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new LocalpoController();
$obj->RequestAccept($obj->actionevents);
?>