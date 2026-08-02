<?PHP
include "../model/db_connection/connection.php" ;
include('../view/template/includes/en_de_header.inc');
class loginController 
{
   // var $varModelObj;
    public $actionevents,$uri,$check_comm2,$check_comm,$username,$password;
    public $emp_id,$emp_name, $emp_type,$emp_status,$emp_code ,$APIKEY;
  
    function __construct()
	{
	    $DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
		$OBJ = new URLEncription();
		$this->APIKEY = $OBJ->URLEncode('thcauthentication');
	 
	    $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri$check_comm2";
        
       
        date_default_timezone_set("Asia/Calcutta");
       
         $requestType = $_SERVER['REQUEST_METHOD'];

            //Switch statement
            switch (trim($requestType)) {
                case 'POST':
                        $this->actionevents = $_GET['action'];
                        $this->username = $_GET['username'];
                        $this->password = $_GET['password'];
                       
                        //$this->params = $OBJ->URLDecode(trim($_POST['APIKEY']));
                break;
                case 'GET':
                  
                  
                     $this->actionevents = $_GET['action'];
                     //$this->params = $OBJ->URLDecode(trim($_GET['APIKEY']));
                     $this->username = $_GET['username'];
                     $this->password = $_GET['password']; 
                     
                    
                
                  break;
               
                default:
                  //request type that isn't being handled.
                  break;
            }
           
            
           // file_put_contents("/home/sianlab/public_html/thc/log/thc/test_thc_api_response_" . date("d-m-Y") . ".txt", "\n" . date("h:i a"). " CONSTRUCTOR : " . $check_comm, FILE_APPEND | LOCK_EX);


    }
    function SQLArray()
    {
        $array =  array();
       
        $array[0] = "SELECT employee_name,employee_id,employee_status,employee_type_name,employee_code FROM  tbl_employees where employee_code='".$this->username."' and employee_password='".$this->password."' ";
       
        return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
        
   
        switch ($FunctionEvents)
        {
           
            case 'login':
               
                $this->login_result = $this->userAuthenticationforcheck($var[0],$this->password);
               
                if (trim($this->login_result)=="Success")
                {
                    
                    $myObj->refNo = "V504";
                    $myObj->status = 'Success';
                    $myObj->api_message = 'Authenticated';
                    
                    $myObj->employee_id = $this->emp_id ;
                    $myObj->employee_name = $this->emp_name;
            	    $myObj->employee_code = $this->emp_code;
                    $myObj->APIKEY = $this->APIKEY;
				    echo json_encode($myObj);
                  
                }
                else
                {
                    
                    $myObj->refNo = "V505";
                    $myObj->status = 'Error';
                    $myObj->api_message = $this->login_result;
				    echo json_encode($myObj);
                }
               
            break;
                   
            default:
                    $myObj->refNo = "V506";
                    $myObj->status = 'Error';
                    $myObj->api_message = 'Unauthorized Attempt..!';
				    echo json_encode($myObj);
            break;
      
           
        }
        
     
    }
    
    
	public function userAuthenticationforcheck($SQL,$password)
	{
	
        $user_username;
		$user_password;
        $return_string="";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		$row_count = mysqli_num_rows($this->result);
		
		if($row_count>=1)
		{
           // $temp = array();
            while($row=mysqli_fetch_assoc($this->result))
             {
			
				$this->emp_id =$row['employee_id'];
                $this->emp_name =$row['employee_name'];
        	    $this->emp_code =$row['employee_code'];
        	    $this->emp_type =$row['employee_type_name'];
                $this->emp_status =$row['employee_status'];
                
                //$temp['data'][] = $row;
               
			 }
			 if($this->emp_type=='Technician' || $this->emp_type=='Team Leader' || $this->emp_type=='Supervisor')
			{
			
        			if($this->emp_status=='Active')
        			{
        			   
        				return 'Success';
        			}
        			else
        			{
        				return 'Your Login is not active, Please contact your administrator..!';
        			}
			}
			else
			{
			   return 'Only Technician/Team Leader/Supervisor can login...!'; 
			}
		
		}
		else
		{
			return 'Username/Password does not Exists...!';
		//	return $row_count;
		
		}
		
		
		
		$this->flag=1;
		
		
	}
    
}

$obj = new loginController();
$obj->RequestAccept($obj->actionevents);

?>

  


