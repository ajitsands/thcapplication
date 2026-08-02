<?PHP session_start(); ?>
<?php
require ('../common/common_functions.php');
include('../../view/template/includes/en_de_header.inc');
class api1Controller 
{
    var $varModelObj;
    public $actionevents,$api_key,$emp_code,$old_password,$new_password,$password_count;
  
    function __construct()
	{
        
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        
        $OBJ = new URLEncription();
	//	$this->APIKEY = $OBJ->URLEncode('thcauthentication');
		
        $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri.$check_comm2";
        
        $requestType = $_SERVER['REQUEST_METHOD'];
        
        date_default_timezone_set("Asia/Bahrain");
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->server_ip = $_SERVER['SERVER_ADDR'];
        $this->curmonth = date('m');
       
      
        
        switch ($requestType) {
                case 'POST':
                    
                    
                    $this->actionevents = $_GET['action'];
                    $this->api_key =  $OBJ->KEYDecode(trim($_GET['APIKEY']));
                    $this->emp_code = $_GET['emp_code'];
                    $this->employee_contact_no = $_GET['employee_contact_no'];
                    $this->employee_address = $_GET['employee_address']; 
                    $this->native_number = $_GET['native_number'];
                    $this->native_address = $_GET['native_address'];
                    $this->emergency_contact_no = $_GET['emergency_contact_no'];
                    $this->old_password=$_GET['old_password'];
                    $this->new_password=$_GET['new_password'];
                  break;
                case 'GET':
                   
                  
                    $this->actionevents = $_GET['action'];
                    $this->api_key =  $OBJ->KEYDecode(trim($_GET['APIKEY']));
                    $this->emp_code = $_GET['emp_code'];
                    $this->employee_contact_no = $_GET['employee_contact_no'];
                    $this->employee_address = $_GET['employee_address']; 
                    $this->native_number = $_GET['native_number'];
                    $this->native_address = $_GET['native_address'];
                    $this->emergency_contact_no = $_GET['emergency_contact_no'];
                    $this->old_password=$_GET['old_password'];
                    $this->new_password=$_GET['new_password'];
                  break;
               
                default:
                  //request type that isn't being handled.
                break;
            }
            
        //   echo $this->old_password;
         file_put_contents("/home/sianlab/public_html/thc/api/log/requisition/api_response_in_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  $check_comm, FILE_APPEND | LOCK_EX);

        
        
        
    }
    function SQLArray()
    {
        $array =  array();
         $array[0] = "Select employee_name,employee_contact_no,employee_address,native_number,native_address,emergency_contact_no from tbl_employees where employee_code='".$this->emp_code."'";
         
         $array[1] = "Update  tbl_employees set employee_contact_no='".$this->employee_contact_no."',employee_address='".$this->employee_address."',native_number='".$this->native_number."',native_address='".$this->native_address."',emergency_contact_no='".$this->emergency_contact_no."' where employee_code='".$this->emp_code."'";
         
         $array[3] = "SELECT * FROM  tbl_employees where employee_password='".$this->old_password."' and  employee_code='".$this->emp_code."' ";
        
         $array[4] = "UPDATE tbl_employees set employee_password='".$this->new_password."' where employee_code='".$this->emp_code."' ";
         $array[5] = "select customer_care_number from tbl_customer_care order by ids desc limit 1 ";
        
        return $array;
		
    }
    function validate()
    {               
        
                  
                   
                  
                    if(trim($this->api_key)!='thcauthentication')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '101';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='WRONG API KEY';
    					$error_str = 'api_key_error';
    					return $error_str;
    					    
                    }
                  
                    if(trim($this->emp_code)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '102';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='EMPLOYEE NOT FOUND';
    					$error_str = 'emp_code_error';
    					return $error_str;
    					    
                    }
                   
                  
                    
    }
    //  function validate_profile_details()
    // {               
        
                  
                   
                  
    //                 if(trim($this->employee_contact_no)=='')
    //                 {
    //                     $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
    //                     $this->myObj->error_code = '103';
    // 					$this->myObj->status = 'Failed';
    // 					$this->myObj->api_message ='CONTACT NUMBER NOT FOUND';
    // 					$error_str = 'emp_contact_no_error';
    // 					return $error_str;
    					    
    //                 }
                  
    //                 if(trim($this->employee_address)=='')
    //                 {
    //                     $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
    //                     $this->myObj->error_code = '104';
    // 					$this->myObj->status = 'Failed';
    // 					$this->myObj->api_message ='EMPLOYEE ADDRESS NOT FOUND';
    // 					$error_str = 'emp_address_error';
    // 					return $error_str;
    					    
    //                 }
    //                 if(trim($this->native_number)=='')
    //                 {
    //                     $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
    //                     $this->myObj->error_code = '105';
    // 					$this->myObj->status = 'Failed';
    // 					$this->myObj->api_message ='NATIVE NUMBER NOT FOUND';
    // 					$error_str = 'native_contact_no_error';
    // 					return $error_str;
    					    
    //                 }
                  
    //                 if(trim($this->native_address)=='')
    //                 {
    //                     $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
    //                     $this->myObj->error_code = '106';
    // 					$this->myObj->status = 'Failed';
    // 					$this->myObj->api_message ='NATIVE ADDRESS NOT FOUND';
    // 					$error_str = 'native_address_error';
    // 					return $error_str;
    					    
    //                 }
                   
                    
                    
    // }
    
    //  function validate_reset_password
    //  {
         
         
    //  }
   
    
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch (trim($FunctionEvents))
        {
            
            case 'view_profile_details':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        
                        default:
                           
                            $this->varModelObj->ListFromTable($var[0]);
                        break;
                        
                    }
                    
            break;
            case 'update_profile_details':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        
                        default:
                          
                            $this->varModelObj->UpdateTable($var[1]);
                        break;
                        
                    }
                    
            break;
            
            case 'reset_password':
                
                switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_password_error':
                            echo json_encode($this->myObj);
                        break;
                        
                        default:
                         
                            
                            $this->count=$this->varModelObj->ReturnCountValue($var[3]); 
                            if($this->count>0)
                            {
                            $this->varModelObj->UpdateTable($var[4]);
                            }
                            else
                            {
                                 $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                                    $this->myObj->error_code = '103';
                					$this->myObj->status = 'Failed';
                					$this->myObj->api_message ='OLD PASSWORD NOT FOUND';
                					echo json_encode($this->myObj);
                            }
                        break;
                        
                    }
                
                
            break;
                
            case 'call_customer_care':   
                  
                    switch($this->validate())
                    {
                        
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                          
                            $this->varModelObj->ListFromTable($var[5]);
                        break;
                        
                    }
                    
            break;
              
            
            default:
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '200';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='ACTION VALUE REQUIRED or NOT FOUND';
    					echo json_encode($this->myObj);
           break;
           
        }
         file_put_contents("/home/sianlab/public_html/thc/api/log/api_response_out_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  json_encode($this->myObj), FILE_APPEND | LOCK_EX);

    }


}

$obj = new api1Controller();
$obj->RequestAccept($obj->actionevents);