<?PHP
include "model/db_connection/connection.php" ;


class memberController 
{
   // var $varModelObj;
    public $actionevents,$uri,$check_comm2,$check_comm,$username,$password;
   
   
  
    function __construct()
	{
	    $DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
		
	    $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri.$check_comm2";
        
       
        date_default_timezone_set("Asia/Calcutta");
       
         $requestType = $_SERVER['REQUEST_METHOD'];

            //Switch statement
            switch (trim($requestType)) {
                case 'POST':
                        $this->actionevents = $_GET['action'];
                        $this->notype = $_GET['notype'];
                        $this->roll_number = $_GET['roll_number'];
                        $this->api_key = $_GET['api_key'];
                        
                        //$this->params = $OBJ->URLDecode(trim($_POST['APIKEY']));
                break;
                case 'GET':
                  
                  
                        $this->actionevents = $_GET['action'];
                        $this->notype = $_GET['notype'];
                        $this->roll_number = $_GET['roll_number'];
                        $this->api_key = $_GET['api_key']; 
                
                  break;
               
                default:
                  //request type that isn't being handled.
                  break;
            }
           echo $requestType;
            
            file_put_contents("/home/sianlab/public_html/thc/log/thc/test_thc_api_response1_" . date("d-m-Y") . ".txt", "\n" . date("h:i a"). " CONSTRUCTOR : " . $check_comm, FILE_APPEND | LOCK_EX);


    }
    function SQLArray()
    {
        $array =  array();
       
        $array[0] = "SELECT ";
       
        return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
        
   
        switch ($FunctionEvents)
        {
           
            case 'get_member_details':
               
                $this->member_result = $this->ListFromTable($var[0]);
               
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
    
    
		public function ListFromTable($SQL)
	{
		//echo $SQL;
	//	$statSQL= 'SET CHARACTER SET utf8'; 
		$temp = array();
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$temp['data'][] = $row;
		}
		$this->flag=1;
		echo json_encode($temp);
		
	}
    
}

$obj = new memberController();
$obj->RequestAccept($obj->actionevents);

?>

  


