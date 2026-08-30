<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . "/../model/db_connection/connection.php";
if (file_exists(__DIR__ . '/../view/template/includes/en_de_header.inc')) {
    require_once __DIR__ . '/../view/template/includes/en_de_header.inc';
}

class decodeController 
{
    public $actionevents, $uri, $emp_id, $username, $password, $params, $varDBConnection;
  
    function __construct()
	{
	    $DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
		$OBJ = class_exists('URLEncription') ? new URLEncription() : null;
	 
        date_default_timezone_set("Asia/Calcutta");
       
        $raw_input = file_get_contents('php://input');
        $json_input = !empty($raw_input) ? json_decode($raw_input, true) : null;

        $apikey_raw = '';
        if (is_array($json_input)) {
            $this->actionevents = isset($json_input['action']) ? trim($json_input['action']) : '';
            $this->emp_id = isset($json_input['emp_id']) ? trim($json_input['emp_id']) : '';
            $apikey_raw = isset($json_input['APIKEY']) ? trim($json_input['APIKEY']) : '';
        }

        if (empty($this->actionevents)) {
            $this->actionevents = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
        }
        if (empty($this->emp_id)) {
            $this->emp_id = isset($_REQUEST['emp_id']) ? trim($_REQUEST['emp_id']) : '';
        }
        if (empty($apikey_raw)) {
            $apikey_raw = isset($_REQUEST['APIKEY']) ? trim($_REQUEST['APIKEY']) : '';
        }

        if ($OBJ && !empty($apikey_raw)) {
            $this->params = $OBJ->KEYDecode($apikey_raw);
        } else {
            $this->params = $apikey_raw;
        }
    }

    function RequestAccept($FunctionEvents)
    {
        $myObj = new stdClass();
        if (trim($this->params) != 'thcauthentication')
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
                $myObj->refNo = "V200";
                $myObj->status = 'Success';
                $myObj->api_message = 'OK';
                echo json_encode($myObj);
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

$obj = new decodeController();
$obj->RequestAccept($obj->actionevents);
