<?php

require ('../../model/common/common_functions.php');


class apartmentController
{
    var $varModelObj,$varDBConnection;
    public $actionevents,$asset_ref_no,$asset_category_id,$asset_category_name,$asset_type_id,$asset_type_name,$asset_cust_id,$asset_cust_code,$asset_cust_name,$asset_location_id,$asset_location,$asset_building,$flat_area_code,$asset_serial_no,$asset_brand,$asset_capacity,$asset_cost,$asset_is_warentee,$warentee_end_date,$asset_attachment,$asset_description,$asset_spgen,$asset_sp_des,$asset_building_code,$zone_or_floor_no,$asset_roon_no,$asset_specify_description,$v_location,$v_asset_cate_combo,$v_assettype_combo,$v_asset_building_combo,$location_code,$asset_building_id,$asset_status,$customer_assets_action,$v_asset_id,$asset_location_code,$amc_id,$amc_ref_no,$amc_ed_date,$amc_st_date,$current_date;
       
     
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
       
        $this->asset_ref_no = $_POST['v_asset_ref_no'];
        $this->asset_category_id = $_POST['v_asset_category_id'];
        $this->asset_category_name = $_POST['v_asset_category_name'];
        $this->asset_type_id = $_POST['v_asset_type_id'];
		$this->asset_type_name = $_POST['v_asset_type_name'];
        $this->asset_cust_id = $_POST['v_cust_id'];
        $this->asset_cust_code = $_POST['v_cust_code'];
        $this->asset_cust_name = $_POST['v_cust_name'];
        $this->asset_location_id = $_POST['v_location_id'];
        $this->asset_location = $_POST['v_asset_location'];
        $this->asset_building = $_POST['v_asset_building'];
		$this->flat_area_code = $_POST['v_flat_area_code'];
        $this->asset_serial_no = $_POST['v_asset_serial_no'];
        $this->asset_brand = $_POST['v_asset_brand'];
        $this->asset_capacity = $_POST['v_asset_capacity'];
        $this->asset_cost = $_POST['v_asset_cost'];
        $this->asset_is_warentee = $_POST['v_is_warentee'];
        $this->warentee_end_date = $_POST['v_warentee_end_date'];
		$this->asset_attachment = $_POST['assets_attachment_file'];
        $this->asset_description = $_POST['v_asset_description'];
        $this->asset_spgen = 'NA';
        $this->asset_sp_des = 'NA';
        
         $this->asset_building_code = $_POST['v_asset_building_code'];
          $this->zone_or_floor_no = $_POST['v_zone_or_floor_no'];
		$this->asset_roon_no = $_POST['v_asset_roon_no'];
        $this->asset_specify_description = $_POST['v_asset_specify_description'];
		
        $this->v_location = $_POST['v_location_id'];
    	$this->v_asset_cate_combo= $_POST['asset_cate_combo'];
    	$this->v_assettype_combo = $_POST['assettype_combo'];
    	$this->v_asset_building_combo = $_POST['asset_building_combo'];
    	$this->location_code = $_POST['location_code'];
    	$this->asset_building_id = $_POST['v_asset_building_id'];
    	
    	$this->asset_status = $_POST['v_asset_status'];
		$this->customer_assets_action = $_POST['v_customer_assets_action'];
		$this->v_asset_id = $_POST['v_assets_id'];
		$this->asset_location_code= $_POST['v_asset_location_code'];
	
        $this->amc_id = $_POST['v_amc_id'];
        $this->amc_ref_no = $_POST['v_amc_ref_no'];
		$this->amc_ed_date = $_POST['v_amc_ed_date'];
		$this->amc_st_date= $_POST['v_amc_st_date'];
		
     	date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
	 $array[0]="call proc_amc_add_assets('".$this->asset_ref_no."','".$this->asset_category_id."','".$this->asset_category_name."',".$this->asset_type_id.",'".$this->asset_type_name."','".$this->asset_cust_id."','".$this->asset_cust_code."','".$this->asset_cust_name."','".$this->asset_location_id."','".$this->asset_location."','".	$this->location_code."','".$this->asset_building_id."','".$this->asset_building_code."','". $this->asset_building."','". $this->zone_or_floor_no."','".$this->flat_area_code."','".$this->asset_roon_no."','". $this->asset_specify_description."','". $this->asset_serial_no."','".$this->asset_brand."','".$this->asset_capacity."','".$this->asset_cost."','".$this->asset_is_warentee."','".$this->warentee_end_date."','".$this->asset_attachment."','".$this->asset_description."','Active',0,'NA','".$this->current_date."',0,'NA','".$this->current_date."','NA','0000-00-00','0000-00-00',0,@msg)";
     $array[1]="select * from tbl_assets where (location_id='".$this->v_location."' and asset_category_id='".$this->v_asset_cate_combo."' and asset_type_id='".$this->v_assettype_combo."')";
     $array[2]="select location_id from   tbl_customer_location where customer_id=".$this->asset_cust_id;
     $array[3]="select *,REGEXP_REPLACE(asset_description, '[^ -~]', '') AS asset_description from tbl_assets order by asset_id desc"; 																										                                          
	 $array[4] ="update tbl_assets set `asset_status`='Active' where asset_id='".$this->v_asset_id."'";   
	 $array[5] ="update tbl_assets set `asset_status`='Deactive' where asset_id='".$this->v_asset_id."'";
	 $array[6]="call proc_amc_edit_assets('".$this->v_asset_id."','".$this->asset_ref_no."','".$this->asset_category_id."','".$this->asset_category_name."',".$this->asset_type_id.",'".$this->asset_type_name."','".$this->asset_cust_id."','".$this->asset_cust_code."','".$this->asset_cust_name."','".$this->asset_location_id."','".$this->asset_location_code."','".$this->asset_location."','".$this->asset_building_id."','".$this->asset_building_code."','". $this->asset_building."','". $this->zone_or_floor_no."','".$this->flat_area_code."','".$this->asset_roon_no."','". $this->asset_specify_description."','". $this->asset_serial_no."','".$this->asset_brand."','".$this->asset_capacity."','".$this->asset_cost."','".$this->asset_is_warentee."','".$this->warentee_end_date."','".$this->asset_attachment."','".$this->asset_description."','".$this->current_date."',@msg)";	 
     $array[7]="select asset_ref_no from tbl_assets order by asset_id desc";
 
		 
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'add_amc_assets':
           
                $this->varModelObj->ExecuteProcedure($var[0]);
            break;
            case 'amc_list_service':
          
                $this->varModelObj->ListFromTable($var[1]);
            break;
            case 'check_location':
         
                if($this->varModelObj->ReturnCountValue($var[2])==0)
              {
                  echo "not exist";
              }
              else
              {
            echo 1;
              }
            break;
            
            case 'list_amc_assets':  
               
                $this->varModelObj->DataWithQR($var[7],"../../httpdocs/qr_lib/asset_qr/customer_asset/",'asset_ref_no',2,2);
                  
                 $this->varModelObj->ListFromTable($var[3]);
              
             break;
			 
			case 'change_customer_assets_status':
                if($this->customer_assets_action=='Active')
                {
				
                  $this->varModelObj->UpdateTable($var[4]);
                }
                else
                {
				
                  $this->varModelObj->UpdateTable($var[5]);  
                }
            break;
             
			case 'edit_amc_assets':
                $this->varModelObj->ExecuteProcedure($var[6]);
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