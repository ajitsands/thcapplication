<?PHP session_start(); ?>
<?php
require ('../common/common_functions.php');
include('../../view/template/includes/en_de_header.inc');
class api1Controller 
{
    var $varModelObj;
    public $actionevents,$api_key,$emp_code,$product_category_id,$product_type_id,$asset_code,$customer_name,$building_name,$location_name,$building_id,$location_id,$customer_id,$requisition_mode,$v_requisition_serial_no,$product_category_name,$product_type_name,$product_item_name,$product_item_id,$product_unit_rate,$product_quantity,$product_total,$amc_tkt_ref;
  
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
                    $this->category_id=$_GET['category_id'];
                    $this->product_type_id=$_GET['product_type_id'];
                    
                    $this->employee_id = $_GET['employee_id'];
                    $this->employee_name = $_GET['employee_name'];
                    $this->asset_code = $_GET['asset_code'];
                    $this->customer_name = $_GET['customer_name'];
                    $this->building_name = $_GET['building_name'];
                    $this->location_name = $_GET['location_name'];
                    $this->building_id = $_GET['building_id'];
                    $this->location_id = $_GET['location_id'];
                    $this->customer_id = $_GET['customer_id'];
                    $this->requisition_mode = $_GET['requisition_mode'];
                    $this->v_requisition_serial_no = $_GET['requisition_serial_no'];
                    $this->product_category_name = $_GET['product_category_name'];
                    $this->product_category_id = $_GET['product_category_id'];
                    $this->product_type_name = $_GET['product_type_name'];
                    $this->product_type_id = $_GET['product_type_id'];
                    $this->product_item_name = $_GET['product_item_name'];
                    $this->product_item_id = $_GET['product_item_id'];
                    $this->product_unit_rate = $_GET['product_unit_rate'];
                    $this->product_quantity = $_GET['product_quantity'];
                    $this->product_total = $_GET['product_total'];
                    $this->amc_ref_no = $_GET['amc_tkt_ref'];
                    $this->v_amc_ticket_ids = $_GET['amc_tkt_id'];
                    $this->v_requisition_child_id = $_GET['requisition_child_id'];
                    
                  break;
                case 'GET':
                   
                  
                    $this->actionevents = $_GET['action'];
                    $this->api_key =  $OBJ->KEYDecode(trim($_GET['APIKEY']));
                    $this->emp_code = $_GET['emp_code'];
                    $this->category_id=$_GET['category_id'];
                    $this->product_type_id=$_GET['product_type_id'];
                    
                    $this->employee_id = $_GET['employee_id'];
                    $this->employee_name = $_GET['employee_name'];
                    $this->asset_code = $_GET['asset_code'];
                    $this->customer_name = $_GET['customer_name'];
                    $this->building_name = $_GET['building_name'];
                    $this->location_name = $_GET['location_name'];
                    $this->building_id = $_GET['building_id'];
                    $this->location_id = $_GET['location_id'];
                    $this->customer_id = $_GET['customer_id'];
                    $this->requisition_mode = $_GET['requisition_mode'];
                    $this->v_requisition_serial_no = $_GET['requisition_serial_no'];
                    $this->product_category_name = $_GET['product_category_name'];
                    $this->product_category_id = $_GET['product_category_id'];
                    $this->product_type_name = $_GET['product_type_name'];
                    $this->product_type_id = $_GET['product_type_id'];
                    $this->product_item_name = $_GET['product_item_name'];
                    $this->product_item_id = $_GET['product_item_id'];
                    $this->product_unit_rate = $_GET['product_unit_rate'];
                    $this->product_quantity = $_GET['product_quantity'];
                    $this->product_total = $_GET['product_total'];
                    $this->amc_ref_no = $_GET['amc_tkt_ref'];
                    $this->v_amc_ticket_ids = $_GET['amc_tkt_id'];
                    $this->v_requisition_child_id = $_GET['requisition_child_id'];
                  break;
               
                default:
                  //request type that isn't being handled.
                break;
            }
            
           
         //file_put_contents("/home/sianlab/public_html/thc/api/log/requisition/api_response_in_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  $check_comm, FILE_APPEND | LOCK_EX);

        
        
        
    }
    function SQLArray()
    {
        $array =  array();
         $array[0] = "Select product_category_id,product_category_name from tbl_product_category where product_category_status='Active'";
         
         $array[1] = "select product_type_id,product_type_name from  tbl_product_type where product_type_status='Active' and product_category_id='".$this->category_id."'";
         
         $array[2] = "select product_item_id,product_item_name from  tbl_product_items where item_status='Active' and product_type_id='".$this->product_type_id."'";
         
         $array[3] = "call proc_app_insert_requisitions('".$this->asset_code."','".$this->customer_name."','".$this->building_name."','".$this->location_name."','".$this->building_id."','".$this->customer_id."','".$this->location_id."','".$this->requisition_mode."','".$this->v_requisition_serial_no."','".$this->product_category_name."','".$this->product_category_id."','".$this->product_type_name."','".$this->product_type_id."','".$this->product_item_name."','".$this->product_item_id."','".$this->product_quantity."','".$this->emp_code."','".$this->employee_name."','".$this->createddatetime."','".$this->amc_ref_no."','.$this->v_amc_ticket_ids.',@msg)";
          
         $array[4] = "Delete from tbl_requision_child where requisition_serial_no='".$this->v_requisition_serial_no."' and product_item_id='".$this->product_item_id."'";
         
         $array[5] = "SELECT tbl_ticket_teams.ticket_ref_no,DATE_FORMAT(tbl_ticket_teams.visit_date,'%d-%m-%Y') as visit_date,ticket_status FROM `tbl_ticket_teams`  JOIN  tbl_tickets ON tbl_ticket_teams.ticket_id=tbl_tickets.ticket_id  WHERE `employee_code`='".$this->emp_code."' and `visit_date` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) order by ticket_team_ids desc ";
        
        $array[6] = "SELECT  requisition_serial_no, requisition_date ,status FROM `tbl_mateial_requisition`  WHERE `prepared_by_id`='".$this->emp_code."' and `requisition_date` >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) order by requisition_id desc";
        
        $array[7] = "Select requisition_child_id,product_item_name,product_quantity from tbl_requision_child where requisition_serial_no='".$this->v_requisition_serial_no."'";
        
        $array[8] = "Update tbl_requision_child set product_quantity='".$this->product_quantity."' where requisition_child_id='".$this->v_requisition_child_id."'";
        
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
     function validate_category_id()
    {               
        
                  
                    if(trim($this->category_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '103';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='CATEGORY ID NOT FOUND';
    					$error_str = 'category_id_error';
    					return $error_str;
    					    
                    }
                   
                    
                    
    }
    
    function validate_type_id()
    {               
        
                  
                    if(trim($this->product_type_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '104';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='PRODUCT TYPE ID NOT FOUND';
    					$error_str = 'type_id_error';
    					return $error_str;
    					    
                    }
                   
                    
                    
    }
    function validate_requisition()
    {
       
       if(trim($this->product_category_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '103';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='CATEGORY ID NOT FOUND';
    					$error_str = 'category_id_error';
    					return $error_str;
    					    
                    }
         if(trim($this->product_item_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '105';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='PRODUCT ITEM ID NOT FOUND';
    					$error_str = 'item_id_error';
    					return $error_str;
    					    
                    }
        if(trim($this->product_category_name)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '106';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='CATEGORY NAME  NOT FOUND';
    					$error_str = 'category_name_error';
    					return $error_str;
    					    
                    }
        if(trim($this->product_type_name)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '107';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='TYPE NAME  NOT FOUND';
    					$error_str = 'type_name_error';
    					return $error_str;
    					    
                    }
        if(trim($this->product_item_name)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '108';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='ITEM NAME  NOT FOUND';
    					$error_str = 'item_name_error';
    					return $error_str;
    					    
                    }
                    
        if(trim($this->location_name)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '109';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='LOCATION NAME  NOT FOUND';
    					$error_str = 'location_name_error';
    					return $error_str;
    					    
                    }           
        if(trim($this->location_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '110';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='LOCATION ID  NOT FOUND';
    					$error_str = 'location_id_error';
    					return $error_str;
    					    
                    }
        if(trim($this->building_name)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '111';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='BUILDING NAME  NOT FOUND';
    					$error_str = 'building_name_error';
    					return $error_str;
    					    
                    }
        if(trim($this->building_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '112';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='BUILDING ID  NOT FOUND';
    					$error_str = 'building_id_error';
    					return $error_str;
    					    
                    }            
        if(trim($this->customer_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '113';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='CUSTOMER ID  NOT FOUND';
    					$error_str = 'customer_id_error';
    					return $error_str;
    					    
                    }
        if(trim($this->customer_name)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '114';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='CUSTOMER NAME  NOT FOUND';
    					$error_str = 'customer_name_error';
    					return $error_str;
    					    
                    }            
    }
    
    function validate_delete_requisition()
    {
         if(trim($this->product_item_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '115';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='ITEM ID  NOT FOUND';
    					$error_str = 'item_id_error';
    					return $error_str;
    					    
                    }
        if(trim($this->v_requisition_serial_no)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '116';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='REQUISITION SERIAL NO  NOT FOUND';
    					$error_str = 'requisition_no_error';
    					return $error_str;
    					    
                    } 
        
    }
    function validate_requsition_serial_no()
    {
        if(trim($this->v_requisition_serial_no)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '116';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='REQUISITION SERIAL NO  NOT FOUND';
    					$error_str = 'requisition_no_error';
    					return $error_str;
    					    
                    } 
        
    }
    function validate_update_requsition()
    {
       if(trim($this->v_requisition_child_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '117';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='REQUISITION ID NO  NOT FOUND';
    					$error_str = 'requisition_id_error';
    					return $error_str;
    					    
                    }  
       if(trim($this->v_product_quantity)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '118';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='PRODUCT QUANTITY NOT FOUND';
    					$error_str = 'product_quantity_error';
    					return $error_str;
    					    
                    }                  
    }
   
    
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
      
        switch (trim($FunctionEvents))
        {
            
            case 'get_category_details':   
                  
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
            
            case 'get_product_type':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        default:
                             switch($this->validate_category_id())
                            {
                                case 'category_id_error':
                                    echo json_encode($this->myObj);
                                 break;
                                default :
                                    
                                    $this->varModelObj->ListFromTable($var[1]);
                                break;
                            }
                               
                        break;
                        
                    }
            break;
              case 'get_item_details':
                 
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                         switch($this->validate_type_id())
                        {
                            case 'type_id_error':
                                echo json_encode($this->myObj);
                             break;
                            default :
                                $this->varModelObj->ListFromTable($var[2]);
                            break;
                        }
                           
                       break;
                           
                            
                    }
              break; 
              
              case 'get_add_item_request':
               
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                            
                         switch($this->validate_requisition())
                        {
                           
                            case 'category_id_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'type_id_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'item_id_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'category_name_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'type_name_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'item_name_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'location_name_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'location_id_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'building_name_error':
                                echo json_encode($this->myObj);
                             break;
                              case 'building_id_error':
                                echo json_encode($this->myObj);
                             break;
                              case 'customer_id_error':
                                echo json_encode($this->myObj);
                             break;
                              case 'customer_name_error':
                                echo json_encode($this->myObj);
                             break;
                             
                            default :
                                
                                 
                                $this->varModelObj->ExecuteProcedure($var[3]);
                                $this->varModelObj->ListFromTable('SELECT @msg as requisition_serial_no '); 
                            break;
                        }
                        
                            
                       break;
                           
                            
                    }
              break; 
              
              case 'delete_item_request':
                
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                         switch($this->validate_delete_requisition())
                        {
                            case 'item_id_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'requisition_no_error':
                                echo json_encode($this->myObj);
                             break;
                            default :
                               
                                $this->varModelObj->DeleteRow($var[4]);
                                
                            break;
                        }
                           
                       break;
                           
                            
                    }
              break; 
              case 'view_job_history':
                
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                                $this->varModelObj->ListFromTable($var[5]);
                        break;
                      
                           
                            
                    }
              break; 
              case 'view_requisition_history':
                
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                                $this->varModelObj->ListFromTable($var[6]);
                        break;
                           
                            
                    }
              break; 
               case 'view_item_details':
                
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                         switch($this->validate_requsition_serial_no())
                        {
                            
                             case 'requisition_no_error':
                                echo json_encode($this->myObj);
                             break;
                            default :
                                
                                $this->varModelObj->ListFromTable($var[7]);
                                
                            break;
                        }
                           
                       break;
                           
                            
                    }
              break; 
              case 'edit_item_details':
                
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                        default:
                         switch($this->validate_update_requsition())
                        {
                            
                             case 'requisition_id_error':
                                echo json_encode($this->myObj);
                             break;
                             case 'product_quantity_error':
                                echo json_encode($this->myObj);
                             break;
                            default :
                                
                                $this->varModelObj->ListFromTable($var[8]);
                                
                            break;
                        }
                           
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
        // file_put_contents("/home/sianlab/public_html/thc/api/log/api_response_out_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  json_encode($this->myObj), FILE_APPEND | LOCK_EX);

    }


}

$obj = new api1Controller();
$obj->RequestAccept($obj->actionevents);