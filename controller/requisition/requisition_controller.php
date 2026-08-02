<?php
session_start();
require ('../../model/common/common_functions.php');



class requisitionController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$hidden_amc_ref,$hidden_ticket_ref,$amc_customer_name,$amc_asset_code,$v_txt_requisition_serial_no,
		$amc_building_name,$amc_location_name,$v_requisition_serial_no,$v_requisition_id,$tickets_code,$v_requisition_status,
		$amc_location_id,$amc_building_id,$amc_customer_id,$requisition_mode,$product_category_id_requisition,$amc_ref_requisition,
		$product_category_name_requisition,$product_type_id_requisition,$hidden_amc_ref_tckt,$product_type_name_requisition,$product_item_id_requisition,
		$product_item_name_requisition,$amc_edit,$tck_ref_requisition_edit,$amc_ref_tckt_requisition_edit,$product_unit_rate_requisition,$product_quantity_requisition,$amc_ref_requisition_edit,$product_total_requisition,$tck_ref_requisition,
		$update_requisition_id,$product_category_id_requisition_edit,$product_category_name_requisition_edit,
		$product_type_id_requisition_edit,$requisition_view_id,$product_type_name_requisition_edit,$product_item_id_requisition_edit,
		$product_item_name_requisition_edit,$product_unit_rate_requisition_edit,$product_quantity_requisition_edit,$requisition_child_id,
		$product_total_requisition_edit,$requisition_id,$amc_child_idd,$v_start_date,$v_select_customer_id,$v_end_date,$product_unit_requisition;
         
    function __construct()
	{
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
		date_default_timezone_set('Asia/Bahrain');
         $this->current_date = date("Y-m-d h:i:s");
		 $this->hidden_amc_ref = $_POST['hidden_amc_ref'];
		 $this->hidden_ticket_ref = $_POST['hidden_ticket_ref'];
		 $this->amc_customer_name = $_POST['amc_customer_name'];
		 $this->amc_building_name = $_POST['amc_building_name'];
		 $this->amc_location_name = $_POST['amc_location_name'];
		 
		 $this->amc_location_id = $_POST['amc_location_id'];
		 $this->amc_building_id = $_POST['amc_building_id'];
		 $this->amc_customer_id = $_POST['amc_customer_id'];
		 $this->requisition_mode = $_POST['v_requisition_mode'];
		 
		 $this->amc_ref_requisition = $_POST['v_amc_ref_requisition'];
		 $this->tck_ref_requisition_edit = $_POST['v_tck_ref_requisition_edit'];
		 $this->tck_ref_requisition = $_POST['v_tck_ref_requisition'];
		 $this->amc_ref_requisition_edit = $_POST['v_amc_ref_requisition_edit'];
		 $this->amc_ref_tckt_requisition_edit = $_POST['v_amc_ref_tckt_requisition_edit'];
		 $this->amc_edit = $_POST['v_amc_edit'];
		 $this->amc_child_idd = $_POST['v_amc_child_idd'];
		 $this->requisition_id_modal = $_POST['requisition_id_modal'];
		 $this->hidden_amc_ref_tckt = $_POST['hidden_amc_ref_tckt'];
		 
		 $this->v_requisition_serial_no = $_POST['v_requisition_serial_no'];
		 $this->v_requisition_id = $_POST['v_requisition_id'];
		 $this->amc_asset_code = $_POST['amc_asset_code'];
		 $this->v_txt_requisition_serial_no = $_POST['v_txt_requisition_serial_no'];
		 $this->v_requisition_status = $_POST['v_requisition_status'];
		 $this->product_category_id_requisition = $_POST['v_product_category_id_requisition'];
		 $this->product_category_name_requisition = $_POST['v_product_category_name_requisition'];
		 $this->product_type_id_requisition = $_POST['v_product_type_id_requisition'];
		 $this->product_type_name_requisition = $_POST['v_product_type_name_requisition'];
		 $this->product_item_id_requisition = $_POST['v_product_item_id_requisition'];
		 $this->product_item_name_requisition = $_POST['v_product_item_name_requisition'];
		 $this->product_unit_rate_requisition = $_POST['v_product_unit_rate_requisition'];
		 $this->product_quantity_requisition = $_POST['v_product_quantity_requisition'];
		 $this->product_total_requisition = $_POST['v_product_total_requisition'];
		 $this->requisition_child_id = $_POST['requisition_child_id'];
		 $this->requisition_view_id = $_POST['requisition_view_id'];
		 $this->update_requisition_id = $_POST['update_requisition_id'];
		 $this->product_category_id_requisition_edit = $_POST['v_product_category_id_requisition_edit'];
		 $this->product_unit_requisition = $_POST['v_product_unit_requisition'];
		 $this->product_master_requisition_id = $_POST['v_product_master_requisition_id'];
		 $this->product_brand = $_POST['v_product_brand'];
		  
		 
		 $this->v_start_date = $_POST['v_start_date'];
		 $this->v_end_date = $_POST['v_end_date'];
		  
		 $this->v_select_customer_id = $_POST['v_select_customer_id'];
		 
		 $this->product_category_name_requisition_edit = $_POST['v_product_category_name_requisition_edit'];
		 $this->product_type_id_requisition_edit = $_POST['v_product_type_id_requisition_edit'];
		 $this->product_type_name_requisition_edit = $_POST['v_product_type_name_requisition_edit'];
		 $this->product_item_id_requisition_edit = $_POST['v_product_item_id_requisition_edit'];
		 $this->product_item_name_requisition_edit = $_POST['v_product_item_name_requisition_edit'];
	     $this->product_unit_rate_requisition_edit = $_POST['v_product_unit_rate_requisition_edit'];
		 $this->product_quantity_requisition_edit = $_POST['v_product_quantity_requisition_edit'];
		 $this->product_total_requisition_edit = $_POST['v_product_total_requisition_edit'];
		
		 $this->requisition_id=$this->varDBConnection->real_escape_string($_POST['requisition_id']);
		
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
		
        $array[1] = "select asset_ref_no,amc_ref_no,amc_child_id,customer_name,asset_building,asset_location,customer_code,location_id,building_id,customer_id,category_id,category_name,asset_type_id,asset_type_name,location_code,building_code from view_amc_asset_details where amc_ref_no='".$this->amc_ref_requisition."'";
		
		$array[2] = "select ticket_ref_code,ticket_ref_no,type_name,category_name,customer_name,building_name,location_name,location_id,building_id,customer_id,customer_code,location_code,building_code,ticket_id,complaints_description from tbl_tickets where ticket_ref_code='".$this->tck_ref_requisition."'";
        
        $array[3]="call proc_insert_requisitions('".$this->amc_asset_code."','".$this->amc_customer_name."','".$this->amc_building_name."','".$this->amc_location_name."','".$this->amc_building_id."','".$this->amc_customer_id."','".$this->amc_location_id."','".$this->requisition_mode."','".$this->v_requisition_serial_no."','".$this->product_category_name_requisition."','".$this->product_category_id_requisition."','".$this->product_type_name_requisition."','".$this->product_type_id_requisition."','".$this->product_item_name_requisition."','".$this->product_item_id_requisition."','".$this->product_unit_rate_requisition."','".$this->product_quantity_requisition."','".$this->product_total_requisition."','".$this->current_date."','".$this->hidden_amc_ref_tckt."','".$this->amc_child_idd."','".$this->product_unit_requisition."','".$_SESSION['user_name']."','".$_SESSION['username']."','".$this->product_brand."',@msg)";
		
		$array[4] = "Select * from tbl_requision_child where requisition_serial_no='".$this->v_requisition_serial_no."'";
		
		$array[5] ="update tbl_mateial_requisition set `status`='Generated' where requisition_serial_no='".$this->v_requisition_serial_no."'";
	
		$array[6] = " SELECT * FROM tbl_mateial_requisition WHERE `requisition_date` BETWEEN '".$this->v_start_date."' AND '".$this->v_end_date."' AND `customer_id`='".$this->v_select_customer_id."' and status='Generated' ORDER BY requisition_id desc";
		
		$array[7] = "select * from tbl_mateial_requisition where amc_tkt_ref_no='".$this->amc_edit."'";
		
		$array[8] = "select * from tbl_requision_child where requisition_id='".$this->requisition_id_modal."'";
		
		$array[9] =" update tbl_requision_child set product_category_name='".$this->product_category_name_requisition_edit."',product_category_id='".$this->product_category_id_requisition_edit."',product_type_name='".$this->product_type_name_requisition_edit."',product_type_id='".$this->product_type_id_requisition_edit."',product_item_name='".$this->product_item_name_requisition_edit."',product_item_id='".$this->product_item_id_requisition_edit."',product_unit_rate='".$this->product_unit_rate_requisition_edit."',product_quantity='".$this->product_quantity_requisition_edit."',grant_total='".$this->product_total_requisition_edit."' where requisition_id='".$this->update_requisition_id."'";
		
		$array[10]= " Update tbl_mateial_requisition set status='Cancelled' where where requisition_id='".$this->requisition_id."'";
		
		$array[11] = "select * from tbl_mateial_requisition where amc_tkt_ref_no='".$this->amc_edit."'";
		
		$array[12] = "select * from tbl_requision_child where requisition_id='".$this->requisition_view_id."'";
		
		$array[13] = "Delete from tbl_requision_child where requisition_child_id='".$this->requisition_child_id."'";
		
		$array[14] = "select * from tbl_amc_child";
		
		$array[15] ="select * , DATE_FORMAT(requisition_date, '%d-%m-%Y') as requisition_date from tbl_mateial_requisition where MONTH(`requisition_date`)=MONTH(now()) and YEAR(`requisition_date`)=YEAR(now()) and status='Generated' ORDER BY requisition_id desc ";
		
		$array[16] = "select * from tbl_mateial_requisition where requisition_date between '".$this->v_start_date."' and '".$this->v_end_date."'";
		
		$array[17]="update tbl_requision_child set asset_ref_no='".$this->amc_asset_code."',amc_ticket_ids='".$this->amc_child_idd."',location_id='".$this->amc_location_id."',location_name='".$this->amc_location_name."',building_id='".$this->amc_building_id."',building_name='".$this->amc_building_name."',product_category_name='".$this->product_category_name_requisition."',product_category_id='".$this->product_category_id_requisition."',product_type_name='".$this->product_type_name_requisition."',product_type_id='".$this->product_type_id_requisition."',product_item_name='".$this->product_item_name_requisition."',product_item_id='".$this->product_item_id_requisition."',product_unit_rate='".$this->product_unit_rate_requisition."',product_quantity='".$this->product_quantity_requisition."',grant_total='".$this->product_total_requisition."' where requisition_child_id='".$this->requisition_child_id."' ";
		
		$array[18] = "SELECT count(status) as requisition_count,requisition_id,requisition_serial_no FROM tbl_mateial_requisition WHERE status='Pending' ";
        
        $array[19] = "select * from tbl_mateial_requisition where status='Pending'";
        
        $array[20]= "Update tbl_mateial_requisition set status='Cancelled' where requisition_serial_no='".$this->v_requisition_serial_no."'";
        
        $array[21] = "select * from tbl_mateial_requisition where requisition_serial_no='".$this->v_requisition_serial_no."'";
        
        $array[22]= "select * from tbl_mateial_requisition where requisition_serial_no='".$this->v_requisition_serial_no."'";
        
        $array[23] = "SELECT status as req_status FROM tbl_mateial_requisition WHERE requisition_serial_no='".$this->v_requisition_serial_no."' ";
        
        $array[24] = "SELECT product_unit_rate,product_unit  FROM  tbl_product_master WHERE product_master_id='".$this->product_master_requisition_id."' ";
		
			return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'list_amc_asset':
				//echo $var[1]; 
                $this->varModelObj->ListFromTable($var[1]);
            break; 
			  case 'list_tickets_asset':
				//echo $var[2];
                 $this->varModelObj->ListFromTable($var[2]);
             break;
			case 'add_requisitions':
				//echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
			 case 'list_requisition_child':
				//echo $var[4];
                 $this->varModelObj->ListFromTable($var[4]);
             break;
            case 'requisitions_status_generated':
				//echo $var[5];
                 $this->varModelObj->UpdateTable($var[5]);
             break;
			  /*  case 'list_requisition_details':
				//echo $var[6];
                 $this->varModelObj->ListFromTable($var[6]);
             break; */
			 
			  case 'list_requisition_edit_amc_tckt_details':
				//echo $var[6];
                 $this->varModelObj->ListFromTable($var[7]);
             break;
			   case 'amc_ref_child_details':
				//echo $var[8];
                 $this->varModelObj->ListFromTable($var[8]);
             break;
			 
			   case 'update_requisitions_modal':
				//echo $var[9];
                 $this->varModelObj->UpdateTable($var[9]);
             break;
			  case 'delete_requisition':
				//echo $var[10];
                 $this->varModelObj->DeleteRow($var[10]);
             break;
			 case 'list_requisition_view_amc_tckt_details':
			//	echo $var[11];
                 $this->varModelObj->ListFromTable($var[11]);
             break;
			 case 'amc_ref_view_details':
				//echo $var[12];
                 $this->varModelObj->ListFromTable($var[12]);
             break;
              case 'delete_requisition_child':
				//echo $var[13];
                 $this->varModelObj->DeleteRow($var[13]);
             break;
			  case 'amc_child_id_details':
				//echo $var[14];
                 $this->varModelObj->ListFromTable($var[14]);
             break;
				
			case 'list_requisition_details': 
			    if( $this->v_start_date==null||$this->v_end_date==null|| $this->v_select_customer_id == null)
			        {
			            //echo $var[15];
			            $this->varModelObj->ListFromTable($var[15]);
			            
			        }
			     else 
			     {
                    $this->varModelObj->ListFromTable($var[6]);
			     }
				 
			     
            break;
            case 'edit_requisition_child': 
                echo $var[17];
				 $this->varModelObj->UpdateTable($var[17]); 
				
            break;
             case 'check_requsition_status': 
               
                $this->varModelObj->ListFromTable($var[18]);
            break;
            case 'select_requisition_pending_data': 
               
                $this->varModelObj->ListFromTable($var[19]);
            break;
             case 'cancel_requisition_list': 
               
                $this->varModelObj->UpdateTable($var[20]);
            break;
            case 'list_requisition_master':
				//echo $var[6];
                 $this->varModelObj->ListFromTable($var[21]);
             break;
             case 'select_requisition_edit_data':
				//echo $var[6];
                 $this->varModelObj->ListFromTable($var[22]);
             break;
            case 'check_requsition_status_for_print':
				
                 $this->varModelObj->ListFromTable($var[23]);
             break;
             case 'find_product_unit_price':
			    
                 $this->varModelObj->ListFromTable($var[24]);
             break;
			
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new requisitionController();
$obj->RequestAccept($obj->actionevents);
?>