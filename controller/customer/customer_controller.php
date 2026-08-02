<?php

require ('../../model/common/common_functions.php');



class customerController
{
       var $varModelObj,$varDBConnection;
	   public $actionevents,$ctrl_name,$customer_id, $customer_name,$customer_password, $customer_number,$customer_email_id,$customer_po_box,$customer_location,$contact_person,$contact_person_number,$cpr_cr_number,$vat_number,$customer_address,$customer_description,$customer_status,$customer_action,$customer_code,$customer_code_new;
       public $expertise_id=array();
        
    function __construct()
	{
	  
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->ctrl_name = $_POST['v_ctrl_name'];
		
        $this->customer_id = $_POST['v_customer_id'];
        $this->customer_name =$this->varDBConnection->real_escape_string($_POST['v_customer_name']);
        $this->customer_code_new = $_POST['v_customer_code'];
        //$this->customer_password = $_POST['v_customer_pwd'];
        $this->customer_number = $_POST['v_customer_contact_no'];
        $this->customer_email_id = $_POST['v_customer_email_id'];
        $this->customer_po_box= $_POST['v_customer_po_box'];
        $this->customer_location = $this->varDBConnection->real_escape_string($_POST['v_customer_location']);
        $this->contact_person = $this->varDBConnection->real_escape_string($_POST['v_contact_person']);
        $this->contact_person_number = $_POST['v_contact_person_number'];
        $this->cpr_cr_number = $_POST['v_cpr_cr_number'];
        $this->vat_number = $_POST['v_vat_number'];
        $this->customer_address = $this->varDBConnection->real_escape_string($_POST['v_customer_address']);
        $this->customer_description = $this->varDBConnection->real_escape_string($_POST['v_description']);
         $this->alternate_contact_no = $this->varDBConnection->real_escape_string($_POST['v_alternate_contact_no']);
        $this->customer_status = $_POST['v_customer_status'];
         $this->customer_action = $_POST['v_customer_action'];
          $this->question_ids = $_POST['question_ids'];
           $this->customer_code = $_POST['customer_code'];
            $this->customer_password = $_POST['customer_password'];
          
            
        date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
        
    }
    
    
    
    function SQLArray()
    { 
        $array =  array();

        
		//$array[1] = "INSERT INTO `tbl_customers`(`customer_name`, `customer_contact_no`, `customer_email_id`, `customer_po_box`, `customer_location`, `customer_contact_person_name`, `customer_contact_person_no`, `customer_cpr_cr_no`, `customer_vat_no`, `customer_address`, `customer_description`, `customer_status`) VALUES('".$this->customer_name."','".$this->customer_number."','".$this->customer_email_id."','".$this->customer_po_box."','".$this->customer_location."','".$this->contact_person."','".$this->contact_person_number."','".$this->cpr_cr_number."','".$this->vat_number."','".$this->customer_address."','".$this->customer_description."','Active')";
		
		$array[1] = "INSERT INTO `tbl_customers`(`customer_name`, `customer_contact_no`, `customer_email_id`, `customer_location`, `customer_contact_person_name`, `customer_contact_person_no`, `customer_cpr_cr_no`, `customer_vat_no`, `customer_address`, `customer_description`, `customer_status`,date_active) VALUES('".$this->customer_name."','".$this->customer_number."','".$this->customer_email_id."','".$this->alternate_contact_no."','".$this->contact_person."','".$this->contact_person_number."','".$this->cpr_cr_number."','".$this->vat_number."','".$this->customer_address."','".$this->customer_description."','Active','".$this->current_date."')";
		
        $array[2] = "select *,DATE_FORMAT(date_active, '%d-%m-%Y') as date_active1,DATE_FORMAT(date_deactive, '%d-%m-%Y') as date_deactive1 from tbl_customers order by customer_id desc";
        
		$array[3] = "UPDATE `tbl_customers` SET `customer_name`='".$this->customer_name."',`customer_contact_no`='".$this->customer_number."',`customer_email_id`='".$this->customer_email_id."',`customer_location`='".$this->alternate_contact_no."',`customer_contact_person_name`='".$this->contact_person."',`customer_contact_person_no`='".$this->contact_person_number."',`customer_cpr_cr_no`='".$this->cpr_cr_number."',`customer_vat_no`='".$this->vat_number."',`customer_address`='".$this->customer_address."',`customer_description`='".$this->customer_description."' WHERE `customer_id`='".$this->customer_id."'";
        
		$array[4] ="update tbl_customers set `customer_status`='Active',date_active='".$this->current_date."' where customer_id='".$this->customer_id."'";
        
		$array[5] ="update tbl_customers set `customer_status`='Deactive',date_deactive='".$this->current_date."' where customer_id='".$this->customer_id."'";
		 
		$array[6] ="update tbl_customers set `customer_code`='".$this->customer_code_new."' where customer_id='".$this->customer_id."'";
        $array[7] = "select * from tbl_customers where customer_contact_no='".$this->customer_number."'";
		
        $array[8] = "select * from 	tbl_customers where customer_cpr_cr_no='".$this->cpr_cr_number."'";
        $array[9] = "select * from tbl_customers where customer_contact_no='".$this->customer_number."' and customer_id!='".$this->customer_id."' ";
		
        $array[10] = "select * from 	tbl_customers where customer_cpr_cr_no='".$this->cpr_cr_number."' and customer_id!='".$this->customer_id."' and customer_cpr_cr_no!='' ";
        $array[11] = "select * from tbl_assets where `customer_id`='".$this->customer_id."'";
        $array[12] = "select * from  tbl_tickets where `customer_id`='".$this->customer_id."'";
        $array[13] = "delete from  tbl_customer_location where `customer_id`='".$this->customer_id."'";
        $array[14] = "delete from  tbl_customers where `customer_id`='".$this->customer_id."'";
        $array[15] = "select *,DATE_FORMAT(date_active, '%d-%m-%Y') as date_active1,DATE_FORMAT(date_deactive, '%d-%m-%Y') as date_deactive1 from tbl_customers where customer_status='Active' order by customer_id desc";
        
        $array[16] ="update tbl_customers set `customer_password`='".$this->customer_password."' where customer_code='".$this->customer_code."'";
        $array[17] = "select customer_password,customer_email_id from 	tbl_customers where customer_code='".$this->customer_code."'";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch ($FunctionEvents)
        {
        
            case 'check_contact_person_number':
               // echo $var[7];
            		$this->varModelObj->ListFromTable($var[7]);
            break;
            	
            case 'check_cpr_cr_number':
               // echo $var[8];
            		$this->varModelObj->ListFromTable($var[8]);
            break;
         
            case 'add_customer':
                 if ($this->varModelObj->ReturnCountValue($var[7])==0)
                    {
                        if($this->cpr_cr_number!="")
                        {
                           if ($this->varModelObj->ReturnCountValue($var[8])==0)
                            {
                             
                                $this->inserted_id =  $this->varModelObj->AddToTable($var[1]);
                                
                            }
                            else{
                                echo 'CPR/CR No - '.$this->cpr_cr_number." -  already exists...!";
                            } 
                        }
                        else
                        {
                             $this->inserted_id =  $this->varModelObj->AddToTable($var[1]);
                        }
                        
                      
                    }
                    else
                    {
                        echo 'Contact No - '.$this->customer_number." -  already exists...!";
                    }
               
            break;
		   
         
            case 'list_customer':
           // echo $var[2];
                $this->varModelObj->ListFromTable($var[2]);
            break;
             case 'list_customer_complaint':
           // echo $var[2];
                $this->jsondata = $this->varModelObj->ListFromJSONWithReturn($var[15]);
				if($this->jsondata == '[]')
				{
					echo "NoData";  
				}
				else
				{
					echo $this->jsondata;
				}
            break;
            
			
			case 'update_customer':
               if ($this->varModelObj->ReturnCountValue($var[9])==0)
                    {
                        if ($this->varModelObj->ReturnCountValue($var[10])==0)
                        {
                         
                             $this->varModelObj->UpdateTable($var[3]);
                            
                        }
                        else{
                            echo 'CPR/CR No - '.$this->cpr_cr_number." -  already exists...!";
                        }
                      
                    }
                    else
                    {
                        echo 'Contact No - '.$this->customer_number." -  already exists...!";
                    }
               
            break;
			
			case 'update_customer_code':
              
                $this->varModelObj->UpdateTable($var[6]);
            break;
            case 'reset_password':
               
                $this->varModelObj->UpdateTable($var[16]);
            break;
            case 'retrive_email_pass':
          
                $this->varModelObj->ListFromTable($var[17]);
            break;
            
            case 'change_customer_status':
                if($this->customer_action=='Active')
                {
                  $this->varModelObj->UpdateTable($var[4]);
                }
                else
                {
                  $this->varModelObj->UpdateTable($var[5]);  
                }
            break;
            
             case 'delete_customers':
                  if(($this->varModelObj->ReturnCountValue($var[11]))==0)
                {
                    if(($this->varModelObj->ReturnCountValue($var[12]))==0)
                    {
                         $this->varModelObj->DeleteRow($var[13]);
                         $this->varModelObj->DeleteRow($var[14]);
                    }
                    else
                    {
                        echo "exist";
                    }
                  
                }
                else
                {
                    echo "exist";
                }
                
             break;
           	case 'question_feedback':
           	    if($this->customer_code=='All')
           	    {
           	        $this->varModelObj->ListFromTable("SELECT response_text FROM feedback_text_responses WHERE question_id =".$this->question_ids);
           	    }
           	    else
           	    {
           	        $this->varModelObj->ListFromTable("SELECT response_text FROM feedback_text_responses WHERE main_customer_code ='".$this->customer_code."' and question_id =".$this->question_ids);
           	    }
               
                
            break;
            default:
             echo 'No Action Found...!';
             break;
            
        }

    }
}//end of class

$obj = new customerController();
$obj->RequestAccept($obj->actionevents);
?>