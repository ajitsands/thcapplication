<?PHP
include "../model/db_connection/connection.php" ;
class listController 
{
   // var $varModelObj;
    public $actionevents,$uri,$check_comm2,$check_comm,$username,$password;
    
  
    function __construct()
	{
	    $DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
	    //$this->varModelObj = new CommonModel();
	    $uri = $_SERVER['REQUEST_URI'];
        $check_comm2 = http_build_query($_POST);
        $check_comm = "$uri?$check_comm2";
        
       
        date_default_timezone_set("Asia/Calcutta");
       
         $requestType = $_SERVER['REQUEST_METHOD'];

            //Switch statement
            switch ($requestType) {
                case 'POST':
                        $this->actionevents = $_POST['action'];
                        $this->asset_ref_no = $_POST['asset_ref_no'];
                       
                  break;
                case 'GET':
                  
                  
                     $this->actionevents = $_GET['action'];
                     
                     $this->asset_ref_no = $_GET['asset_ref_no'];
                   
                
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
       
        $array[0] = "SELECT * FROM   tbl_assets where asset_ref_no='".$this->asset_ref_no."'  ";
       
        return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();

        switch ($FunctionEvents)
        {
            
            case 'show_amc_list':
               
                $this->login_result = $this->ListFromTable($var[0]);
               
               
               
            break;
           
           
        }
    }
    
    
		public function ListFromTable($SQL)
	{
		//echo $SQL;
		$temp = array();
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$temp['data'][] = $row;
		}
		$this->flag=1;
		echo json_encode($temp);
		
	}
    
}

$obj = new listController();
$obj->RequestAccept($obj->actionevents);

?>


