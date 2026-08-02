<?php

require ('../../model/common/common_functions.php');




class apartmentController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$ctrl_name,$exp_id, $exp_name,$exp_status;
    
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
     
        $this->prdt_category_name = $_POST['v_prdt_category_name'];
        $this->prdt_category_id = $_POST['v_prdt_category_id'];
		$this->prdt_type_name = $_POST['v_product_name'];
		$this->v_product_type_id = $_POST['v_product_type_id'];
        $this->v_product_type_status = $_POST['v_product_type_status'];
      
        $this->v_product_cate_type_action = $_POST['v_product_cate_type_action'];
       
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        $array[1] = "INSERT INTO `tbl_product_type` (`product_type_name`,`product_category_id`,`product_category_name`,`product_type_status`) VALUES ('".$this->prdt_type_name."','".$this->prdt_category_id."','".$this->prdt_category_name."','Active' )";
        
        
        $array[2] = "select * from 	tbl_product_type order by product_type_id desc";
        
      
         $array[3] ="update tbl_product_type set `product_type_status`='Active' where product_type_id='".$this->v_product_type_id."'";
        
         $array[4] ="update tbl_product_type set `product_type_status`='Deactive' where product_type_id='".$this->v_product_type_id."'";
         
         $array[5] = "update tbl_product_type set product_type_name='".$this->prdt_type_name."',product_category_id='".$this->prdt_category_id."',product_category_name='".$this->prdt_category_name."' where product_type_id='".$this->v_product_type_id."' ";
       
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {

            
            
           
            case 'add_product_type':
                echo $var[1];
                $this->varModelObj->AddToTable($var[1]);
            break;
            
            
            
            case 'list_product_type':
             
                $this->varModelObj->ListFromTable($var[2]);
            break;
            
            
            
             case 'update_product_type':
                echo $var[5];
                $this->varModelObj->UpdateTable($var[5]);
            break;
            
            case 'change_product_type_status':
                if($this->v_product_cate_type_action=='Active')
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