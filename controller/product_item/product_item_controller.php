<?php

require ('../../model/common/common_functions.php');



class apartmentController
{
        var $varModelObj,$varDBConnection;
      public $actionevents,$ctrl_name,$product_category_id, $product_category_name,$product_type_id,$product_type_name, $product_item_name,$employee_name,$employee_contact_no,$employee_email_id,$employee_address,$employee_image,$employee_status,$expertise_length,$expertise_id1,$expertise_name1,$product_item_action;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->product_category_id = $_POST['v_product_category_id'];
        $this->product_category_name = $_POST['v_product_category_name'];
        $this->product_type_id = $_POST['v_product_type_id'];
        $this->product_type_name = $_POST['v_product_type_name'];
        $this->product_item_name = $_POST['v_product_item_name'];
        $this->product_item_id = $_POST['v_product_item_id'];
        $this->product_item_status = $_POST['v_product_item_status'];
        $this->product_item_action = $_POST['v_product_item_action'];
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_product_items` (`product_item_name`,`product_type_id`,`product_type_name`,`product_category_id`,`product_category_name`,`item_status`) VALUES ('".$this->product_item_name."','".$this->product_type_id."','".$this->product_type_name."','".$this->product_category_id."','".$this->product_category_name."','Active' )";
        
        
        $array[2] = "select * from  tbl_product_items order by product_item_id desc";
        
         $array[3] = "update tbl_product_items set product_item_name='".$this->product_item_name."',product_type_id=".$this->product_type_id.",product_type_name='".$this->product_type_name."',product_category_id='".$this->product_category_id."',product_category_name='".$this->product_category_name."' where product_item_id=".$this->product_item_id." ";
       
       
       
        $array[4] ="update tbl_product_items set `item_status`='Deactive' where product_item_id=".$this->product_item_id."";
        $array[5] ="update tbl_product_items set `item_status`='Active' where product_item_id=".$this->product_item_id."";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            
            case 'add_product_item':
            echo $var[1];
                $this->varModelObj->ExecuteProcedure($var[1]);
            break;
            
             case 'product_item_list_view':
            
                 $this->varModelObj->ListFromTable($var[2]);
             break;

            case 'update_product_item':
            echo $var[3];
                $this->varModelObj->ExecuteProcedure($var[3]);
            break;
            
            
            case 'change_product_item_status':
                if($this->product_item_action=='Active')
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