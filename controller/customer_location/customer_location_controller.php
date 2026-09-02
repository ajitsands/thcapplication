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
        $this->customer_id_customer_location = $_POST['v_customer_id_customer_location'];
        $this->customer_name_customer_location = $_POST['v_customer_name_customer_location'];
        $this->location_id_customer_location = $_POST['v_location_id_customer_location'];
        $this->location_name_customer_location = $_POST['v_location_name_customer_location'];
        $this->building_name_customer_location = $_POST['v_building_name_customer_location'];
        $this->building_address_customer_location = $_POST['v_building_address_customer_location'];
        $this->contact_person_building_code = strtoupper($_POST['v_contact_person_building_code']);
         $this->location_name_customer_location_code = strtoupper($_POST['v_location_name_customer_location_code']);
         $this->customer_name_customer_location_code = strtoupper($_POST['v_customer_name_customer_location_code']);
         $raw_img = isset($_POST['v_building_image']) ? trim($_POST['v_building_image']) : '';
         if (!empty($raw_img) && $raw_img != 'null' && $raw_img != 'NA') {
             $clean_img = basename(str_replace('\\', '/', $raw_img));
             $this->building_image = preg_replace('/[^a-zA-Z0-9._-]/', '_', $clean_img);
         } else {
             $this->building_image = 'default.jpg';
         }
        
        
        
        $this->contact_person_name_customer_location = $_POST['v_contact_person_name_customer_location'];
        $this->contact_person_number_customer_location = $_POST['v_contact_person_number_customer_location'];
        $this->customer_location_status = $_POST['v_customer_location_status'];
		$this->customer_location_id = $_POST['v_customer_location_id'];
		$this->building_id = $_POST['v_building_id'];
		
		
		$this->action_status = $_POST['v_action_status'];
		
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO tbl_customer_location( customer_id,customer_name,location_id,location_name,location_code,building_name,building_code,building_address, building_image,contact_person_name, contact_person_no, customer_location_status,customer_code,building_id) VALUES ('".$this->customer_id_customer_location."','".$this->customer_name_customer_location."',".$this->location_id_customer_location.",'".$this->location_name_customer_location."','".$this->location_name_customer_location_code."','".$this->building_name_customer_location."','".$this->contact_person_building_code."','". $this->building_address_customer_location."','". $this->building_image."','".$this->contact_person_name_customer_location ."','".$this->contact_person_number_customer_location."','Active','".$this->customer_name_customer_location_code."','".$this->building_id."')";
        
        
        $array[2] = "select * from  tbl_customer_location order by customer_location_id desc";
        
         $array[3] = "update tbl_customer_location set building_code='".$this->contact_person_building_code."', customer_id='".$this->customer_id_customer_location."',customer_name='".$this->customer_name_customer_location."',location_id='".$this->location_id_customer_location."',location_name='".$this->location_name_customer_location."',location_code='".$this->location_name_customer_location_code."',building_name='".$this->building_name_customer_location."',building_address='".$this->building_address_customer_location."',contact_person_name='".$this->contact_person_name_customer_location."',contact_person_no='".$this->contact_person_number_customer_location."',customer_location_status='".$this->customer_location_status."',building_image='".$this->building_image."' where customer_location_id='".$this->customer_location_id."' ";
       
       
       
        $array[4] ="update tbl_customer_location set customer_location_status ='Deactive' where customer_location_id='".$this->customer_location_id."' ";
        $array[5] ="update tbl_customer_location set customer_location_status ='Active' where customer_location_id='".$this->customer_location_id."' ";
         $array[6] = "select customer_location_id from tbl_customer_location where building_code='".$this->contact_person_building_code."' ";
         $array[7] = "select building_address from   tbl_building where building_id=".$this->building_id;
         $array[8] = "select customer_contact_person_name,customer_contact_person_no from tbl_customers where customer_id=".$this->customer_id_customer_location;
         
         
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'add_customer_location':
           echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
            
             case 'customer_location_list_view':
            
                 $this->varModelObj->ListFromTable($var[2]);
             break;

            case 'update_customer_location':
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
             case 'select_contact_person_details':
           // echo $var[7];
                 $this->varModelObj->ListFromTable($var[8]);
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