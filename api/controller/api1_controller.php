<?PHP session_start(); ?>
<?php
require ('../common/common_functions.php');
include('../../view/template/includes/en_de_header.inc');
class api1Controller 
{
    var $varModelObj;
    public $actionevents,$api_key,$ipaddress,$server_ip,$emp_code,$visit_date,$visit_id,$slot_no,$requestType,$myObj,$error_str;
  
    function __construct()
	{
        
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        
        $OBJ = new URLEncription();
	//	$this->APIKEY = $OBJ->URLEncode('thcauthentication');
		
        $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri$check_comm2";
        
        $requestType = $_SERVER['REQUEST_METHOD'];
        
        date_default_timezone_set("Asia/Bahrain");
       
        $this->server_ip = $_SERVER['SERVER_ADDR'];
        $this->curmonth = date('m');
       
      
        
        switch ($requestType) {
                case 'POST':
                    
                    
                    $this->actionevents = $_POST['action'];
                    $this->emp_code = $_POST['emp_code'];
                    $this->visit_date = $_POST['visit_date'];
                    $this->visit_id = $_POST['visit_id'];
                    $this->slot_no = $_POST['slot_no'];
                    $this->api_key =  $OBJ->KEYDecode(trim($_POST['APIKEY']));
                    
                    
                  break;
                case 'GET':
                   
                  
                    $this->actionevents = $_GET['action'];
                    $this->api_key =  $OBJ->KEYDecode(trim($_GET['APIKEY']));
                    $this->emp_code = $_GET['emp_code'];
                    $this->visit_date = $_GET['visit_date'];
                    $this->ticket_id = $_GET['ticket_id'];
                    $this->slot_no = $_GET['slot_no'];
                    $this->visit_id = $_GET['visit_id'];
                    
                  break;
               
                default:
                  //request type that isn't being handled.
                break;
            }
           
           echo "TEXT".$this->visit_id;
         file_put_contents("/home/sianlab/public_html/thc/api/log/api_response_in_" . date("d-m-Y") . ".txt", "\n" . date("h:i a").  $check_comm, FILE_APPEND | LOCK_EX);

        
        
        
    }
    function SQLArray()
    {
        $array =  array();
         $array[0] = "select visit_date from  tbl_ticket_teams where employee_code='".$this->emp_code."' and visit_date  between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND DATE_FORMAT(NOW() ,'%Y-%m-01') + INTERVAL 90 DAY and ticket_team_status='Active' group by visit_date";
        
        $array[1] = "select * from tbl_technician_slots where employee_code='".$this->emp_code."' and slot_status='Active' and slot_date='".$this->visit_date."'" ;
       
        $array[2] = "select ticket_id,ticket_ref_no,customer_code,customer_name,location_code,location_name,building_code,building_name,category_name,type_name,asset_code,additional_info,complaints_description,ticket_priority,ticket_image,service_request,job_category from tbl_tickets where ticket_id=" ;
        $array[3] = "select ticket_ref_no,ticket_id,employee_id,employee_code,employee_name,is_leader from tbl_ticket_teams where  and visit_date='".$this->visit_date."' and ticket_team_status='Active' and visit_id=".$this->visit_id ;
         $array[4] = "select ticket_id,ticket_ref_code,service_description,ticket_service_status from tbl_ticket_services where   ticket_service_status!='Cancelled' and ticket_id=";
      //$array[2] = "select ips_ids from api_ips where ips='".$this->server_ip."' and status='Active' and api_key='".$this->api_key."'" ;
      
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
     function validatedate()
    {               
        
                  
                
                    if(trim($this->visit_date)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '103';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='DATE IS MISSING';
    					$error_str = 'date_error';
    					return $error_str;
    					    
                    }
                   
                    
                    
    }
     function validatevisit()
    {               
        
                  
                
                    if(trim($this->visit_id)=='')
                    {
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '104';
    					$this->myObj->status = 'Failed';
    					$this->myObj->api_message ='VISIT ID IS MISSING';
    					$error_str = 'visit_id_error';
    					return $error_str;
    					    
                    }
                    
                    
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();

        switch (trim($FunctionEvents))
        {
            
            case 'get_schedule_dates':   
                  
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
            case 'get_date_slots':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        default:
                            switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                     $this->varModelObj->ListFromTable($var[1]);
                                 break;
                            }
                            
                               
                        break;
                        
                    }
            break;
              case 'get_amc_ticket_details':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                        case 'emp_code_error':
                            echo json_encode($this->myObj);
                        break;
                      
                        
                        default:
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                
                              default:
                                    switch($this->validatevisit())
                                        {
                                            case 'visit_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id from tbl_visits where amc_visit_id='.$this->visit_id);
                                            while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                    if($row_amc_tkt['amc_ticket']=='TKT')
                                                    {
                                                        $this->varModelObj->ListFromTable($var[2].$row_amc_tkt['amc_tkt_id']);
                                                        
                                                    }
                                                    else
                                                    {
                                                        //GEt Amc Details
                                                    }
                                                }
                                                
                                             break;
                                        }
                                    
                                 break;
                            }  
                        break;
                    }
            break;  
              case 'get_team_of_visit':
                 switch($this->validate())
                    {
                       
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validatevisit())
                                        {
                                            case 'visit_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id from tbl_visits where amc_visit_id='.$this->visit_id);
                                            while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                    if($row_amc_tkt['amc_ticket']=='TKT')
                                                    {
                                                        $this->varModelObj->ListFromTable($var[3]);
                                                        
                                                    }
                                                    else
                                                    {
                                                        //GEt Amc Details
                                                    }
                                                }
                                                
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;
            case 'get_visit_services':
                 switch($this->validate())
                    {
                      
                        case 'api_key_error':
                            echo json_encode($this->myObj);
                        break;
                       
                        
                        default:
                             switch($this->validatedate())
                            {
                                case 'date_error':
                                    echo json_encode($this->myObj);
                                 break;
                                 default:
                                    switch($this->validatevisit())
                                        {
                                            case 'visit_id_error':
                                                echo json_encode($this->myObj);
                                             break;
                                             default:
                                                 $result_amc_tkt =  mysqli_query($this->varDBConnection,'select amc_ticket,	amc_tkt_id from tbl_visits where amc_visit_id='.$this->visit_id);
                                            while($row_amc_tkt=mysqli_fetch_assoc($result_amc_tkt)) {
                                                    if($row_amc_tkt['amc_ticket']=='TKT')
                                                    {
                                                        $this->varModelObj->ListFromTable($var[4].$row_amc_tkt['amc_tkt_id']);
                                                        
                                                    }
                                                    else
                                                    {
                                                        //GEt Amc Details
                                                    }
                                                }
                                                
                                             break;
                                        }
                                    
                                 break;
                            }
                               
                        break;
                        
                    }
            break;      
           
             
            default:
                        $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $this->myObj->error_code = '110';
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