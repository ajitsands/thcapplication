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
	//	$this->APIKEY = $OBJ->URLEncode('thcauthentication');
	 
	    $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri?$check_comm2";
        
       
        date_default_timezone_set("Asia/Calcutta");
       
         $requestType = $_SERVER['REQUEST_METHOD'];

            //Switch statement
            switch ($requestType) {
                case 'POST':
                        $this->actionevents = $_POST['action'];
                        $this->emp_id = $_POST['emp_id'];
                        $this->params = $OBJ->KEYDecode(trim($_POST['APIKEY']));
                  break;
                case 'GET':
                     $this->actionevents = $_GET['action'];
                     $this->params = $OBJ->KEYDecode(trim($_GET['APIKEY']));
                     $this->emp_id = $_GET['emp_id'];
                  break;
               
                default:
                  //request type that isn't being handled.
                  break;
            }
           
            file_put_contents("/home/sianlab/public_html/thc/log/thc/test_thc_api_response_" . date("d-m-Y") . ".txt", "\n" . date("h:i a"). " CONSTRUCTOR : " . $check_comm, FILE_APPEND | LOCK_EX);


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
        
        if (trim($this->params)!='thcauthentication')
        {
                    $myObj->refNo = "V508";
                    $myObj->status = 'Error';
                    $myObj->api_message = 'Invalid API KEY...';
				    echo json_encode($myObj);
				    return false;
        }
   
        switch ($FunctionEvents)
        {
           
            case 'decode':
               
              echo 'OK ';
               
            break;
                   
            default:
                    $myObj->refNo = "V509";
                    $myObj->status = 'Error';
                    $myObj->api_message = 'Unauthorized Attempt..!';
				    echo json_encode($myObj);
            break;
      
           
        }
        
     
    }
    
    

    
}

$obj = new loginController();
$obj->RequestAccept($obj->actionevents);

?>


