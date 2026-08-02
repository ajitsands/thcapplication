<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$product_category_id, $product_category_name,$product_category_status,$product_cate_action;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->product_category_name = $_POST['v_product_category_name'];
        $this->product_category_id = $_POST['v_product_category_id'];
        $this->product_category_status = $_POST['v_product_category_status'];
      
        $this->product_cate_action = $_POST['v_product_cate_action'];
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_product_category` (`product_category_name`, `product_category_status`) VALUES ('".$this->product_category_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_product_category order by product_category_id desc";
        
      
         $array[3] ="update tbl_product_category set `product_category_status`='Active' where product_category_id='".$this->product_category_id."'";
        
         $array[4] ="update tbl_product_category set `product_category_status`='Deactive' where product_category_id='".$this->product_category_id."'";
         
         $array[5] = "update tbl_product_category set product_category_name='".$this->product_category_name."' where product_category_id='".$this->product_category_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_product_category':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_product_category':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_product_category':
                echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_product_category_status':
                if($this->product_cate_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[3]);
                }
                else
                {
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