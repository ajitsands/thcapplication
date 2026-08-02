<?php session_start();?>
<?php 

include "../../model/db_connection/connection.php" ;
include('../../view/template/includes/en_de_header.inc');
include('../../qr/qrlib.php'); 


abstract class FunctionDefinitions
{
	abstract public function ListFromTable($SQL);
    abstract public function AddToTable($SQL);
    abstract public function ReturnCountValue($SQL);
	abstract public function CreateDropDown($SQL,$value,$text,$controlName,$title);
	abstract public function CreateDropDownForTechnicians($SQL,$value,$text,$controlName,$title);
	abstract public function returnValuefromDB($SQL,$item);
	abstract public function UpdateTable($SQL);
	abstract public function DeleteRow($SQL);
    abstract public function userAuthenticationforcheck($SQL,$password,$userName); 
    abstract public function userAuthenticationforcheckpms($SQL,$password);
    abstract public function userAuthenticationforcustomer($SQL,$password);
    
	abstract public function SignOut();
	abstract public function ExecuteProcedure($SQL);
	abstract public function CreateDropDownForSite($SQL,$value,$value1,$value2,$text,$controlName,$title);
	abstract public function ExecuteProcedureForReturnTableFormat($SQL);
	abstract public function ListFromAcntsTable($SQL);
	abstract public function CreateDropDownforProject($SQL,$value,$value1,$value2,$text,$controlName,$title);
	abstract public function CreateDropDownforSubject($SQL,$value,$value1,$text,$controlName,$title);
	abstract public function ChangePassword($SQL,$password);
	abstract public function ExecuteProcedureTwoValues($SQL);
	abstract public function ExecuteProcedureReturnMultiplevalues($SQL);
	abstract public function ListFromJSONWithReturn($SQL);
	abstract public function DataWithQR($SQL,$dir,$data_col_name,$size=3,$border=2);
}

class CommonModel extends FunctionDefinitions
{
	public $varDBConnection, $varAcntConnection;
	public $varEncode, $pmsvarEncode;
	var $result;
	var $flag=0;
	

	function __construct()
	{
		$DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
		$OBJ = new URLEncription();
		$this->varEncode = $OBJ->URLEncode('title=dashboard');
		$this->pmsvarEncode = $OBJ->URLEncode('head=project&open=2&title=project_entries');
  
	}

	public function ListFromTable($SQL)
	{
		$temp = array('data' => array());
		$this->result = mysqli_query($this->varDBConnection, $SQL);
		if ($this->result) {
			while ($row = mysqli_fetch_assoc($this->result)) {
				$temp['data'][] = $row;
			}
		}
		$this->flag = 1;
		echo json_encode($temp);
	}
	public function DataWithQR($SQL,$dir,$data_col_name,$size=3,$border=2)
	{
		//echo $SQL;
		//$temp = array();
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
		
			$this->GenerateQRCodeBasedOnData($dir,$row[$data_col_name],$row[$data_col_name],$size,$border);
		}
		$this->flag=1;
	
		return true;
		
	}
	public function GenerateQRCodeBasedOnData($dir,$filename,$data,$size,$border)
	{
	           
        	    $filename= $filename.".png"; 

                if (!file_exists($dir.$filename)) {
                    QRcode::png($data, $dir.$filename, QR_ECLEVEL_L, $size, $border);
                }
            
               
	}
	
		public function ListFromAcntsTable($SQL)
	{
		//echo $SQL;
		$temp = array();
		$this->result = mysqli_query($this->varAcntConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$temp['data'][] = $row;
		}
		$this->flag=1;
		echo json_encode($temp);
		
	}
	
	public function ListFromJSONWithReturn($SQL)
	{
		//echo $SQL;
		$this->varDBConnection->query("SET character_set_client=utf8");
        $this->varDBConnection->query("SET character_set_connection=utf8");
        $this->varDBConnection->query("SET character_set_results=utf8");
		$temp = array();
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$temp['data'][] = $row;
		}
		$this->flag=1;
		return json_encode($temp);
		
	}
  

    function ReturnCountValue($SQL)
	{
			$this->result = mysqli_query($this->varDBConnection,$SQL);
			$affected_status = mysqli_num_rows($this->result);
			$this->flag=0;
			return $affected_status;
	}
	

	public function CreateDropDown($SQL,$value,$text,$controlName,$title)
	{
		
		$str = "<select class='form-control form-control-sm'  id='".$controlName."' name='".$controlName."'><option value=0>".$title."</option>";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$str=$str."<option value='".trim($row[$value])."'>".trim($row[$text])."</option>";
		}

		$str = $str .'</select>';

		$this->flag=1;
		echo $str;
		
	}
	
		public function CreateDropDownForTechnicians($SQL,$value,$text,$controlName,$title)
	{
		
		$str = "<select class='form-control form-control-select2'  id='".$controlName."' name='".$controlName."' multiple='multiple'><option value=0>".$title."</option>";
	//	$str="";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$str=$str."<option value='".trim($row[$value])."'>".trim($row[$text])."</option>";
		}

		$str = $str .'</select>';

		$this->flag=1;
		echo $str;
		
	}
	
	
	
	
	public function CreateDropDownForSite($SQL,$value,$value1,$value2,$text,$controlName,$title)
	{
	
		$str = "<select class='form-control'  id='".$controlName."' name='".$controlName."'><option value='0'>".$title."</option>";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
		   
			//$str=$str."<option value=".$row[$value]."-".$row[$value1]."-".$row[$value2].">".$row[$text]."</option>";
			$str=$str."<option value=".$row[$value].">".$row[$text]."</option>";	
		}

		$str = $str .'</select>';

		$this->flag=1;
		echo $str;
		
	}
	
	
	public function CreateDropDownForSubject($SQL,$value,$value1,$text,$controlName,$title)
	{
	
		$str = "<select class='form-control'  id='".$controlName."' name='".$controlName."'><option value='0'>".$title."</option>";
	
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
		   
		$str=$str."<option value=".trim($row[$value])."-".trim($row[$value1]).">".trim($row[$text])."</option>";
			//$str=$str."<option value=".$row[$value].">".$row[$text]."</option>";	
		}

		$str = $str .'</select>';

		$this->flag=1;
		echo $str;
		
	}

		public function CreateDropDownforProject($SQL,$value,$value1,$value2,$text,$controlName,$title)
	{
	
		$str = "<select class='form-control form-control-sm'  id='".$controlName."' name='".$controlName."'><option value='0'>".$title."</option>";
		$this->result = mysqli_query($this->varAcntConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
		   
			$str=$str."<option value=".trim($row[$value])."/".trim($row[$value1]).">".$row[$text]." ( ".trim($row[$value1])." )"."</option>";
			//$str=$str."<option value=".$row[$value].">".$row[$text]."</option>";	
		}

		$str = $str .'</select>';

		$this->flag=1;
		echo $str;
		
	}
	
	
	public function returnValuefromDB($SQL,$item)
	{
		
		$res=0;
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$res=$row[$item];
		}

		$this->flag=0;
		echo $res;
		return $res;
		
	}
    
   
	public function userAuthenticationforcustomer($SQL,$password)
	{
	
        $user_username = '';
		$user_password = '';
        $return_string="";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		$row_count = mysqli_num_rows($this->result);
		
		if($row_count>=1)
		{

            while($row=mysqli_fetch_assoc($this->result))
             {
			
				$user_id =$row['customer_id'];
                $username =$row['customer_code'];
        		$user_password =$row['customer_password'];
                $user_status =$row['customer_status'];
                $user_type ='Customer';
				$user_contact_no =$row['customer_contact_no'];
				$user_name =$row['customer_name'];
                $user_cpr_no =$row['customer_cpr_cr_no'];
                $user_image ='default.jpg';
               
			 }
			
			if($user_status=='Active')
			{
			   
				if($password==$user_password)
				{
					session_start();
			  	  
									
									$_SESSION["loggedin"] = "true";
								    $_SESSION["username"] = $username;
									$_SESSION["password"] = $user_password; 
									$_SESSION["user_id"] =  $user_id; 
									
									$_SESSION["user_status"] = $user_status;
									$_SESSION['LOGINSTATUS']='true';
									$_SESSION['user_type']=$user_type;
									$_SESSION['user_contact_no']=$user_contact_no;
									$_SESSION['user_cpr_no']=$user_cpr_no;
									$_SESSION['user_image']=$user_image;
									$_SESSION['user_name']=$user_name;
									$return_string="dashboard_customer.php?param=$this->varEncode";
									return 'true'.'#'.$return_string;
				}
				else
				{
					return 'Please provide correct password...!';
				}

			}
			else
			{
				return 'Your Login is not active, Please contact your administrator..!';
			}
			
		
		}
		else
		{
			return 'Username does not Exists...!';
		}
		
		
		
		$this->flag=1;
		
		
	}

  
	public function userAuthenticationforcheck($SQL,$password,$userName)
	{
	
        $user_username = '';
		$user_password = '';
        $return_string="";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		$row_count = mysqli_num_rows($this->result);
		
		if($row_count>=1)
		{

            while($row=mysqli_fetch_assoc($this->result))
             {
			
				$user_id =$row['employee_id'];
                $username =$row['employee_code'];
        		$user_password =$row['employee_password'];
                $user_status =$row['employee_status'];
                $user_type =$row['employee_type_name'];
				$user_contact_no =$row['employee_contact_no'];
				$user_name =$row['employee_name'];
                $user_cpr_no =$row['cpr_no'];
                $user_image =$row['employee_image'];
               
			 }
			
			if($user_status=='Active')
			{
			   
				if($password==$user_password)
				{
					session_start();
					
					//$permissionSql = "SELECT id FROM users WHERE username='".$userName."' AND password='".$password."'";
					$permissionSql = "SELECT id FROM users WHERE username='".$userName."' ";
                    $permissonResult = $this->varDBConnection->query($permissionSql);
                    $permissionRow = $permissonResult->fetch_assoc();
                    if ($permissionRow) {

                        $_SESSION['USERROLLID'] = $permissionRow['id'];
                    }
			  	  
									
									$_SESSION["loggedin"] = "true";
								    $_SESSION["username"] = $username; 
									$_SESSION["password"] = $user_password; 
									$_SESSION["user_id"] =  $user_id; 
									
									$_SESSION["user_status"] = $user_status;
									$_SESSION['LOGINSTATUS']='true';
									$_SESSION['user_type']=$user_type;
									$_SESSION['user_contact_no']=$user_contact_no;
									$_SESSION['user_cpr_no']=$user_cpr_no;
									$_SESSION['user_image']=$user_image;
									$_SESSION['user_name']=$user_name;
									$return_string="dashboard.php?param=$this->varEncode";
									return 'true'.'#'.$return_string;
				}
				else
				{
					return 'Please provide correct password...!';
				}

			}
			else
			{
				return 'Your Login is not active, Please contact your administrator..!';
			}
			
		
		}
		else
		{
			return 'Username does not Exists...!';
		}
		
		
		
		$this->flag=1;
		
		
	}

	public function userAuthenticationforcheckpms($SQL,$password)
	{
	
        $user_username = '';
		$user_password = '';
        $return_string="";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		$row_count = mysqli_num_rows($this->result);
		
		if($row_count>=1)
		{

            while($row=mysqli_fetch_assoc($this->result))
             {
			
				$user_id =$row['employee_id'];
                $username =$row['employee_code'];
        		$user_password =$row['employee_password'];
                $user_status =$row['employee_status'];
                $user_type =$row['employee_type_name'];
				$user_contact_no =$row['employee_contact_no'];
				$user_name =$row['employee_name'];
                $user_cpr_no =$row['cpr_no'];
                $user_image =$row['employee_image'];
               
			 }
			
			if($user_status=='Active')
			{
			   
				if($password==$user_password)
				{
					session_start();
									
									$_SESSION["loggedin"] = "true";
								    $_SESSION["username"] = $username;
									$_SESSION["password"] = $user_password; 
									$_SESSION["user_id"] =  $user_id; 
									
									$_SESSION["user_status"] = $user_status;
									$_SESSION['LOGINSTATUS']='true';
									$_SESSION['user_type']=$user_type;
									$_SESSION['user_contact_no']=$user_contact_no;
									$_SESSION['user_cpr_no']=$user_cpr_no;
									$_SESSION['user_image']=$user_image;
									$_SESSION['user_name']=$user_name;
									$return_string="project_entries.php?param=$this->pmsvarEncode";
									return 'true'.'#'.$return_string;
				}
				else
				{
					return 'Please provide correct password...!';
				}

			}
			else
			{
				return 'Your Login is not active, Please contact your administrator..!';
			}
			
		
		}
		else
		{
			return 'Username does not Exists...!';
		}
		
		
		
		$this->flag=1;
		
		
	}

	
	
	function AddToTable($SQL)
	{
		try { 
				mysqli_query($this->varDBConnection, $SQL);
				$inserted_id = mysqli_insert_id($this->varDBConnection);
				$this->flag=0;
				echo $inserted_id;
				return $inserted_id;
		}
		catch (mysqli_sql_exception $e) { 
			return $e->errorMessage(); 
		} 
		//exit();
		
	}

	function UpdateTable($SQL)
	{
			$retval = mysqli_query($this->varDBConnection, $SQL);
			$affected_status = mysqli_affected_rows($this->varDBConnection);
			$this->flag=0;
			//echo $affected_status;
	}




	function DeleteRow($SQL)
	{
			$retval = mysqli_query($this->varDBConnection, $SQL);
			$affected_status = mysqli_affected_rows($this->varDBConnection);
			$this->flag=0;
			echo $affected_status;
	}
	

	
    
	public function SignOut()
	{
	
		session_start();
		$_SESSION = array();
		session_destroy();
	}

   public function ExecuteProcedure($SQL)
	{
			$retval = mysqli_query($this->varDBConnection, $SQL);
			if (!($res = $this->varDBConnection->query("SELECT @msg as _p_out"))) {
				echo "Fetch failed: (" . $this->varDBConnection->errno . ") " . $this->varDBConnection->error;
			} 
			$row = $res->fetch_assoc();
			$this->flag=0;
			
			echo $row['_p_out'];
			return $row['_p_out'];
		
			
	}
		function ExecuteProcedureTwoValues($SQL)
	{
		
			$retval = mysqli_query($this->varDBConnection, $SQL);
			if (!($res = $this->varDBConnection->query("SELECT @msg as msg,@p_ids as p_ids"))) {
				echo "Fetch failed: (" . $this->varDBConnection->errno . ") " . $this->varDBConnection->error;
			}
			$row = $res->fetch_assoc();
			$this->flag=0;
			return json_encode($row);

	}
	
		function ExecuteProcedureReturnMultiplevalues($SQL)
	{
		
			$retval = mysqli_query($this->varDBConnection, $SQL);
			if (!($res = $this->varDBConnection->query("SELECT @msg as msg,@p_ids as p_ids,@v_ids as v_ids"))) {
				echo "Fetch failed: (" . $this->varDBConnection->errno . ") " . $this->varDBConnection->error;
			}
			$row = $res->fetch_assoc();
			$this->flag=0;
			return json_encode($row);

	}
	function ExecuteProcedureForReturnTableFormat($SQL) 
	{	
			$temp = array();
			$this->result = mysqli_query($this->varDBConnection,$SQL);
			while($row=mysqli_fetch_assoc($this->result)) {
			
				$temp['data'][] = $row;
			}
	
			$this->flag=1;
			
			echo json_encode($temp);

	}
	function ChangePassword($SQL,$password)
	{
		$this->result = mysqli_query($this->varDBConnection,$SQL);
	
			while($row=mysqli_fetch_assoc($this->result)) {
				$old_password= $row['user_password'];
				
			}
		
			if(strcmp($old_password,$password)==0)
				{
					echo 'success';
				}
				else
				{
					echo 'Please provide correct password...!';
				}

	
		$this->flag=1;	
		
			
    }

	function __destruct() {
		if($this->flag==1)
		{
			if($this->result && !is_bool($this->result)) {
				mysqli_free_result($this->result);
			}
		}
		
		if($this->varDBConnection) {
			mysqli_close($this->varDBConnection);
		}
		if($this->varAcntConnection) {
			mysqli_close($this->varAcntConnection);
		}
		//print "Destroying " . __CLASS__ . "\n";
		
    }
	
	

}

?>