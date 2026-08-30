<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . "/../model/db_connection/connection.php";

class listController 
{
    public $actionevents, $asset_ref_no, $varDBConnection, $result, $flag;
  
    function __construct()
	{
	    $DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
        date_default_timezone_set("Asia/Calcutta");
       
        $raw_input = file_get_contents('php://input');
        $json_input = !empty($raw_input) ? json_decode($raw_input, true) : null;

        if (is_array($json_input)) {
            $this->actionevents = isset($json_input['action']) ? trim($json_input['action']) : '';
            $this->asset_ref_no = isset($json_input['asset_ref_no']) ? trim($json_input['asset_ref_no']) : '';
        }

        if (empty($this->actionevents)) {
            $this->actionevents = isset($_GET['action']) ? trim($_GET['action']) : (isset($_POST['action']) ? trim($_POST['action']) : (isset($_REQUEST['action']) ? trim($_REQUEST['action']) : ''));
        }
        if (empty($this->asset_ref_no)) {
            $this->asset_ref_no = isset($_GET['asset_ref_no']) ? trim($_GET['asset_ref_no']) : (isset($_POST['asset_ref_no']) ? trim($_POST['asset_ref_no']) : (isset($_REQUEST['asset_ref_no']) ? trim($_REQUEST['asset_ref_no']) : ''));
        }
    }

    function SQLArray()
    {
        $array = array();
        $safe_asset = $this->varDBConnection ? mysqli_real_escape_string($this->varDBConnection, (string)$this->asset_ref_no) : addslashes((string)$this->asset_ref_no);
        $array[0] = "SELECT * FROM tbl_assets WHERE asset_ref_no='" . $safe_asset . "'";
        return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var = $this->SQLArray();

        switch ($FunctionEvents)
        {
            case 'show_amc_list':
                $this->ListFromTable($var[0]);
                break;
            default:
                echo json_encode(['data' => []]);
                break;
        }
    }
    
	public function ListFromTable($SQL)
	{
		$temp = array('data' => array());
        if ($this->varDBConnection) {
            $this->result = mysqli_query($this->varDBConnection, $SQL);
            if ($this->result) {
                while ($row = mysqli_fetch_assoc($this->result)) {
                    $temp['data'][] = $row;
                }
            }
        }
		$this->flag = 1;
		echo json_encode($temp);
	}
}

$obj = new listController();
$obj->RequestAccept($obj->actionevents);
