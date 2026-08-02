<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
        var $varModelObj,$varDBConnection;
      public $actionevents,$ctrl_name,$product_category_id, $product_category_name,$product_type_id,$product_type_name, $product_item_name,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1,$product_master_action;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->product_category_id = $_POST['v_product_category_id_master'];
        $this->product_category_name = $_POST['v_product_category_name_master'];
        $this->product_type_id = $_POST['v_product_type_id_master'];
        $this->product_type_name = $_POST['v_product_type_name_master'];
        $this->product_item_id = $_POST['v_product_item_id_master'];
        $this->product_item_name = $_POST['v_product_item_name_master'];
        
        $this->product_brand_name = $_POST['v_product_brand_name'];
        $this->product_unit_rate = $_POST['v_product_unit_rate'];
        $this->product_unit = $_POST['v_product_unit'];
        $this->product_master_status = $_POST['v_product_master_status'];
        $this->product_master_id = $_POST['v_product_master_id'];
        $this->product_master_action = $_POST['v_product_master_action'];
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_product_master`( `product_brand_name`, `product_unit_rate`,`product_unit`, `product_item_id`, `product_item_name`, `product_type_id`, `product_type_name`, `product_category_id`, `product_category_name`, `status`) VALUES ('".$this->product_brand_name."','".$this->product_unit_rate."','".$this->product_unit."',".$this->product_item_id.",'".$this->product_item_name."',".$this->product_type_id.",'". $this->product_type_name."',".$this->product_category_id .",'".$this->product_category_name."','Active')";
        
        
        $array[2] = "select * from  tbl_product_master order by product_master_id desc";
        
         $array[3] = "update tbl_product_master set product_brand_name='".$this->product_brand_name."',product_unit_rate=".$this->product_unit_rate.",product_unit='".$this->product_unit."',product_item_id=".$this->product_item_id.",product_item_name='".$this->product_item_name."',product_type_id='".$this->product_type_id."',product_type_name='".$this->product_type_name."',product_category_id='".$this->product_category_id."',product_category_name='".$this->product_category_name."' where product_master_id=".$this->product_master_id." ";
       
       
       
        $array[4] ="update tbl_product_master set `status`='Deactive' where product_master_id=".$this->product_master_id."";
        $array[5] ="update tbl_product_master set `status`='Active' where product_master_id=".$this->product_master_id."";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'add_product_master':
            echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
            
             case 'product_master_list_view':
            
                 $this->varModelObj->ListFromTable($var[2]);
             break;

            case 'update_product_master':
            echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
            
            
            case 'change_product_master_status':
                if($this->product_master_action=='Active')
                {
                    //echo $var[4];
                  $this->varModelObj->UpdateTable($var[5]);
                }
                else
                {
                    //echo $var[5];
                  $this->varModelObj->UpdateTable($var[4]);  
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