<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
    var $varModelObj,$varDBConnection,$v_location,$v_asset_cate_combo,$v_assettype_combo,$v_asset_building_combo,$v_amc_ref_no,$v_ser_id,$v_asset_name,$v_asset_type_id,$v_asset_cate_name,$v_asset_cate_id,$v_asset_id,$v_ser_descri,$v_asset_child_id,$v_asset_child_ref_no,$v_building_id,$v_cust_id;
	var $SQLString;
    public $actionevents;
       
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->v_location = $_POST['location_id'];
    	$this->v_asset_cate_combo= $_POST['asset_cate_combo'];
    	$this->v_assettype_combo = $_POST['assettype_combo'];
    	$this->v_asset_building_combo = $_POST['asset_building_combo'];
		$this->v_asset_id = $_POST['v_asset_id'];
		$this->v_asset_cate_id = $_POST['v_asset_cate_id'];
		$this->v_asset_cate_name = $_POST['v_asset_cate_name'];
		$this->v_asset_type_id = $_POST['v_asset_type_id'];
		$this->v_asset_name = $_POST['v_asset_name'];
		$this->v_ser_id = $_POST['v_ser_id'];
		$this->v_ser_descri = $_POST['v_ser_descri'];
		$this->v_amc_ref_no = $_POST['v_amc_ref_no'];
		$this->v_asset_child_ref_no = $_POST['v_asset_child_ref_no'];
		$this->v_asset_child_id = $_POST['v_asset_child_id'];
		$this->v_cust_id = $_POST['v_cust_id'];
		$this->v_building_id = $_POST['v_building_id'];
		
		$this->SQLString = $_POST['sql_string'];
		$this->sql_string2 = $_POST['sql_string2'];
		
    }
    
    
    
    
    function SQLArray()
    { 
        $array =  array();
         $array[0]="select * from tbl_assets where 	location_id =".'1'." and asset_building ='".'Building name 1'."'";
         $array[1]="select * from tbl_amc_child where ( asset_category_id='".$this->v_asset_cate_combo."' and asset_type_id='".$this->v_assettype_combo."' and amc_ref_no='".$this->v_amc_ref_no."')";
		 $array[2]="select * from tbl_services where (service_status='Active' and category_id='".$this->v_asset_cate_combo."' and asset_type_id='".$this->v_assettype_combo."')";
		 $array[3]="call proc_add_child_amc_new ('".$this->SQLString."',@msg)";
		 //$array[4]="select * from tbl_assets where (location_id='".$this->v_location."' and customer_id='".$this->v_cust_id."' and building_id='".$this->v_building_id."')";
		 $array[4]="select * from tbl_assets where (location_id='".$this->v_location."' and customer_id='".$this->v_cust_id."' and building_id='".$this->v_building_id."') and amc_ref_no='NA'";
         $array[5]= $this->SQLString;
         $array[6]= "INSERT INTO `tbl_amc_child` (`amc_master_id`, `amc_ref_no`, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `asset_id`, `asset_ref_no`) values ".$this->sql_string2."  ";
		    
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'amc_asset_service_list':
          
                $this->varModelObj->ListFromTable($var[0]);
            break;
           case 'amc_list_service':
          
                $this->varModelObj->ListFromTable($var[1]);
            break;
			
			case 'amc_list_service_category':
          
                $this->varModelObj->ListFromTable($var[2]);
            break;
			
			case 'add_amc_child':
				//echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
            case 'amc_list_asset_for_assign':
              
                $this->varModelObj->ListFromTable($var[4]);
               
                
                
            break;
            case 'assign_asset_for_amc':
			//	echo $var[6];
                $this->varModelObj->UpdateTable($var[5]);
                 $this->varModelObj->AddToTable($var[6]);
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