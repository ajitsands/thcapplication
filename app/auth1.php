<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . "/../model/db_connection/connection.php";
if (file_exists(__DIR__ . '/../view/template/includes/en_de_header.inc')) {
    require_once __DIR__ . '/../view/template/includes/en_de_header.inc';
}

class loginController 
{
    public $actionevents, $uri, $check_comm2, $check_comm, $username, $password;
    public $emp_id, $emp_name, $emp_type, $emp_status, $emp_code, $APIKEY;
    public $login_result, $flag, $varDBConnection, $result;
  
    function __construct()
	{
	    $DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
        if (class_exists('URLEncription')) {
            $OBJ = new URLEncription();
            $this->APIKEY = $OBJ->URLEncode('thcauthentication');
        } else {
            $this->APIKEY = base64_encode('thcauthentication');
        }
	 
        date_default_timezone_set("Asia/Calcutta");
       
        $raw_input = file_get_contents('php://input');
        $json_input = !empty($raw_input) ? json_decode($raw_input, true) : null;

        if (is_array($json_input)) {
            $this->actionevents = isset($json_input['action']) ? trim($json_input['action']) : '';
            $this->username = isset($json_input['username']) ? trim($json_input['username']) : '';
            $this->password = isset($json_input['password']) ? trim($json_input['password']) : '';
        }

        if (empty($this->actionevents)) {
            $this->actionevents = isset($_GET['action']) ? trim($_GET['action']) : (isset($_POST['action']) ? trim($_POST['action']) : (isset($_REQUEST['action']) ? trim($_REQUEST['action']) : ''));
        }
        if (empty($this->username)) {
            $this->username = isset($_GET['username']) ? trim($_GET['username']) : (isset($_POST['username']) ? trim($_POST['username']) : (isset($_REQUEST['username']) ? trim($_REQUEST['username']) : ''));
        }
        if (empty($this->password)) {
            $this->password = isset($_GET['password']) ? trim($_GET['password']) : (isset($_POST['password']) ? trim($_POST['password']) : (isset($_REQUEST['password']) ? trim($_REQUEST['password']) : ''));
        }
    }

    function SQLArray()
    {
        $array = array();
        $safe_user = $this->varDBConnection ? mysqli_real_escape_string($this->varDBConnection, (string)$this->username) : addslashes((string)$this->username);
        $safe_pass = $this->varDBConnection ? mysqli_real_escape_string($this->varDBConnection, (string)$this->password) : addslashes((string)$this->password);
        $array[0] = "SELECT employee_name,employee_id,employee_status,employee_type_name,employee_code FROM tbl_employees WHERE employee_code='" . $safe_user . "' AND employee_password='" . $safe_pass . "'";
        return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var = $this->SQLArray();
        $myObj = new stdClass();
        
        switch ($FunctionEvents)
        {
            case 'login':
                $this->login_result = $this->userAuthenticationforcheck($var[0], $this->password);
               
                if (trim($this->login_result) == "Success")
                {
                    $myObj->refNo = "V504";
                    $myObj->status = 'Success';
                    $myObj->api_message = 'Authenticated';
                    $myObj->employee_id = $this->emp_id;
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
    
	public function userAuthenticationforcheck($SQL, $password)
	{
        if (!$this->varDBConnection) {
            return 'Database Connection Failed';
        }

		$this->result = mysqli_query($this->varDBConnection, $SQL);
        if (!$this->result) {
            return 'Query execution failed: ' . mysqli_error($this->varDBConnection);
        }

		$row_count = mysqli_num_rows($this->result);
		if ($row_count >= 1)
		{
            while ($row = mysqli_fetch_assoc($this->result))
            {
				$this->emp_id = $row['employee_id'];
                $this->emp_name = $row['employee_name'];
        	    $this->emp_code = $row['employee_code'];
        	    $this->emp_type = $row['employee_type_name'];
                $this->emp_status = $row['employee_status'];
			}

			if (strcasecmp($this->emp_type, 'Technician') === 0 || strcasecmp($this->emp_type, 'Team Leader') === 0 || strcasecmp($this->emp_type, 'Supervisor') === 0)
			{
        		if (strcasecmp($this->emp_status, 'Active') === 0)
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
		}
		
		$this->flag = 1;
	}
}

$obj = new loginController();
$obj->RequestAccept($obj->actionevents);
