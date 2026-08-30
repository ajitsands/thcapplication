<?php

require_once __DIR__ . '/../../model/common/common_functions.php';



class apartmentController
{
        var $varModelObj,$varDBConnection;
		public $quotation_rivision_ref_no,$quotation_rivision_no_length,$actionevents,$ctrl_name,$current_date;
		public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = isset($_POST['action']) ? $_POST['action'] : '';
        $this->ctrl_name = isset($_POST['v_ctrl_name']) ? $_POST['v_ctrl_name'] : '';
		
        //$this->customer_id = $_POST['v_customer_id'];
		$ref_no = isset($_POST['v_quotation_ref_no']) ? trim($_POST['v_quotation_ref_no']) : '';
		if ($ref_no === 'undefined' || $ref_no === 'null') {
			$ref_no = '';
		}
		$this->quotation_rivision_ref_no = $ref_no;
		$this->quotation_rivision_no_length = strlen($this->quotation_rivision_ref_no);
		
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
       
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();
		
		//$array[0] ="select * from tbl_quotation_master_riv group by quotation_ref_no";
		
		$array[0] ="select * from tbl_quotation_master_riv where MONTH(`date`)=MONTH(now()) and YEAR(`date`)=YEAR(now()) order by `quotation_id` desc";
 
        $array[1] ="Select * from tbl_quotation_child_riv  where quotation_ref_no='".$this->quotation_rivision_ref_no."'";
        
		$array[2] ="Select * from tbl_quotation_master_riv  where quotation_ref_no='".$this->quotation_rivision_ref_no."'";
		
					
		
		return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'quotation_rivision_master_view':
                //echo $this->quotation_rivision_no_length;
                if($this->quotation_rivision_no_length==0)
                {
                   	 //echo $var[0];
                    $this->varModelObj->ListFromTable($var[0]); 
                    
                }
                else
                {
				     //echo $var[2];
                    $this->varModelObj->ListFromTable($var[2]);
                }
            break;
	
			case 'quotation_rivision_child_details_view':  
				 //echo $var[1];
                $this->varModelObj->ListFromTable($var[1]);
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