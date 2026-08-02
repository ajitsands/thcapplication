<?php

require ('../../model/common/common_functions.php');



class subcontractorController
{
      var $varModelObj,$varDBConnection;
      public $actionevents,$ctrl_name;
      public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
        $this->subcontractor_name = $_POST['v_sub_name'];
        $this->subcontractor_cr_no = $_POST['v_sub_cr_no'];
        $this->subcontractor_address = $_POST['v_sub_address'];
        $this->subcontratcor_contact_person_name = $_POST['v_sub_contact_person_name'];
        $this->contact_no1 = $_POST['v_sub_contact_no1'];
        $this->contact_no2 = $_POST['v_sub_contact_no2'];
        $this->vendor_reg_form = $_POST['v_subcontractor_reg_form'];
		$this->subcontractor_id = $_POST['v_subcontractor_id'];	
		$this->subcontractor_action = $_POST['v_subcontractor_action'];
        
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
        
        $array[0] = "INSERT INTO `tbl_subcontractors`(`subcontractor_name`, `subcontractor_cr_no`, `subcontractor_address`, `subcontratcor_contact_person_name`, `contact_no1`, `contact_no2`, `vendor_reg_form`) VALUES 
													 ('".$this->subcontractor_name."', '".$this->subcontractor_cr_no."', '".$this->subcontractor_address."', '".$this->subcontratcor_contact_person_name."', '".$this->contact_no1."', '".$this->contact_no2."', '".$this->vendor_reg_form."' )";
        $array[1] = "SELECT * FROM tbl_subcontractors ";
        
        $array[2] ="UPDATE tbl_subcontractors SET `subcontactor_status`='Deactive' WHERE subcontractor_ids='".$this->subcontractor_id."'";
        
        $array[3] ="UPDATE tbl_subcontractors SET `subcontactor_status`='Active' WHERE subcontractor_ids='".$this->subcontractor_id."'";
       
        $array[4] ="UPDATE tbl_subcontractors SET `subcontractor_name`='".$this->subcontractor_name."', `subcontractor_cr_no`='".$this->subcontractor_cr_no."',`subcontractor_address`='".$this->subcontractor_address."',`subcontratcor_contact_person_name`='".$this->subcontratcor_contact_person_name."',`contact_no1`='".$this->contact_no1."',`contact_no2`='".$this->contact_no2."',`vendor_reg_form`='".$this->vendor_reg_form."'  WHERE subcontractor_ids='".$this->subcontractor_id."' ";
        
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
     
        switch ($FunctionEvents)
        {
            case 'add_subcontractor':
              $this->varModelObj->AddToTable($var[0]);
            break;
            
            case 'subcontractors_list_view':
                $this->varModelObj->ListFromTable($var[1]);
            break;
           
            case 'update_subcontractor':
                 $this->varModelObj->UpdateTable($var[4]);
            break;
            
            case 'change_subcontractor_status':
                if($this->subcontractor_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[3]);
                }
                else
                {
                  $this->varModelObj->UpdateTable($var[2]);  
                }
            break;
            
            default:
				echo 'No Action Found...!';
            break;
            
        }

    }
}//end of class

$obj = new subcontractorController();
$obj->RequestAccept($obj->actionevents);
?>