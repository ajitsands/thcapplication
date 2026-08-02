<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
        var $varModelObj,$varDBConnection;
      public $actionevents,$action_status,$location_name_customer_location_code,$customer_location_id,$ctrl_name,$customer_id_customer_location, $customer_name_customer_location,$location_id_customer_location,$location_name_customer_location, $building_name_customer_location,$building_address_customer_location,$contact_person_name_customer_location,$contact_person_number_customer_location,$customer_location_status;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        
		$this->building_id = $_POST['v_building_id'];
		$this->customer_id = $_POST['v_customer_id'];
		$this->category_id = $_POST['v_category_id'];
		
		$this->action_status = $_POST['v_action_status'];
		
        
    } 
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        $array[0] = "select * from  tbl_assets where customer_id='".$this->customer_id."' and building_id='".$this->building_id."' and asset_category_id='".$this->category_id."' and asset_status='Active' ";
        $array[1] = "select asset_ref_no from  tbl_assets ";
        $array[2] = "select * from  tbl_assets where building_id='".$this->building_id."' and asset_category_id='".$this->category_id."' and asset_status='Active'";
        $array[3] = "select * from  tbl_assets where customer_id='".$this->customer_id."' and asset_category_id='".$this->category_id."' and asset_status='Active'";
        $array[4] = "select * from  tbl_assets where customer_id='".$this->customer_id."' and building_id='".$this->building_id."' and asset_status='Active'";
        $array[5] = "select * from  tbl_assets where  asset_status='Active'";
        $array[6] = "select * from  tbl_assets where customer_id='".$this->customer_id."' and asset_status='Active'";
        $array[7] = "select * from  tbl_assets where asset_category_id='".$this->category_id."' and asset_status='Active'";
        $array[8] = "select * from  tbl_assets where building_id='".$this->building_id."' and asset_status='Active'";
       /*  $array[3] = "update tbl_customer_location set building_code='".$this->contact_person_building_code."', customer_id='".$this->customer_id_customer_location."',customer_name='".$this->customer_name_customer_location."',location_id='".$this->location_id_customer_location."',location_name='".$this->location_name_customer_location."',building_name='".$this->building_name_customer_location."',building_address='".$this->building_address_customer_location."',contact_person_name='".$this->contact_person_name_customer_location."',contact_person_no='".$this->contact_person_number_customer_location."',customer_location_status='".$this->customer_location_status."' where customer_location_id='".$this->customer_location_id."' ";
       
        $array[4] ="update tbl_customer_location set customer_location_status ='Deactive' where customer_location_id='".$this->customer_location_id."' ";
        $array[5] ="update tbl_customer_location set customer_location_status ='Active' where customer_location_id='".$this->customer_location_id."' ";
         $array[6] = "select customer_location_id from tbl_customer_location where building_code='".$this->contact_person_building_code."' ";
         $array[7] = "select building_address from   tbl_building where building_id=".$this->building_id;
         $array[1] = "INSERT INTO tbl_customer_location( customer_id,customer_name,location_id,location_name,location_code,building_name,building_code,building_address,contact_person_name, contact_person_no, customer_location_status,customer_code,building_id) VALUES ('".$this->customer_id_customer_location."','".$this->customer_name_customer_location."',".$this->location_id_customer_location.",'".$this->location_name_customer_location."','".$this->location_name_customer_location_code."','".$this->building_name_customer_location."','".$this->contact_person_building_code."','". $this->building_address_customer_location."','".$this->contact_person_name_customer_location ."','".$this->contact_person_number_customer_location."','Active','".$this->customer_name_customer_location_code."','".$this->building_id."')";
        */
        
        return $array;
    }
    
    
    
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            
            
             case 'asset_code_list':
                 //echo "Q :".$var[0];
                $this->varModelObj->DataWithQR($var[1],"../../httpdocs/qr_lib/asset_qr/download_asset/",'asset_ref_no',2,2);
                if ($this->customer_id == 'All' && $this->category_id != 'All' && $this->building_id != 'All') {
                    $this->fetchData($this->varModelObj, $var[2]);
                } elseif ($this->building_id == 'All' && $this->category_id != 'All' && $this->customer_id != 'All') {
                    $this->fetchData($this->varModelObj, $var[3]);
                } elseif ($this->category_id == 'All' && $this->customer_id != 'All' && $this->building_id != 'All') {
                    $this->fetchData($this->varModelObj, $var[4]);
                } elseif ($this->building_id == 'All' && $this->category_id == 'All' && $this->customer_id == 'All') {
                    $this->fetchData($this->varModelObj, $var[5]);
                    
                } elseif ($this->building_id == 'All' && $this->category_id == 'All' && $this->customer_id != 'All') {
                    $this->fetchData($this->varModelObj, $var[6]);
                } elseif ($this->building_id == 'All' && $this->category_id != 'All' && $this->customer_id == 'All') {
                    $this->fetchData($this->varModelObj, $var[7]);
                } elseif ($this->building_id != 'All' && $this->category_id == 'All' && $this->customer_id == 'All') {
                    $this->fetchData($this->varModelObj, $var[8]);
                } else {
                    $this->fetchData($this->varModelObj, $var[0]);
                }
                 
                 
             break;

          /*  case 'update_customer_location':
            //echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
            
            
            case 'change_customer_location_status':
			//echo $this->action_status;
                if($this->action_status=='Active')
                {
                    //echo $var[5];
                  $this->varModelObj->UpdateTable($var[5]);
                }
                else
                {
                    //echo $var[4];
                  $this->varModelObj->UpdateTable($var[4]);  
                }
            break;
             case 'check_building_code':
             //  echo $var[6];
                if($this->varModelObj->ReturnCountValue($var[6])==0)
                  {
                      echo "not exist";
                  }
                else
                  {
                    echo 1;
                  }
            break;
               case 'select_building_address':
           // echo $var[7];
                 $this->varModelObj->ListFromTable($var[7]);
             break;
             case 'add_customer_location':
          // echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;*/
           
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
    
    function fetchData($varModelObj, $varIndex)
    {
        $this->jsondata = $varModelObj->ListFromJSONWithReturn($varIndex);
    
        if ($this->jsondata == '[]') {
            $nodat = [
                'asset_id' => 'NA',
                'asset_ref_no' => 'NA',
                'asset_category_name' => 'NA',
                'asset_type_name' => 'NA',
                'customer_name' => 'NA',
                'asset_location' => 'NA',
                'location_code' => 'NA',
                'customer_code' => 'NA',
                'building_code' => 'NA',
                'asset_building' => 'NA'
            ];
            $data = [$nodat];
            $jsonObject = ["data" => $data];
            $jsonString = json_encode($jsonObject, JSON_PRETTY_PRINT);
            echo $jsonString;
        } else {
            echo $this->jsondata;
        }
    }
}//end of class

$obj = new apartmentController();
$obj->RequestAccept($obj->actionevents);
?>