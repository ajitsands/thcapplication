
<?php 

include "../db_connection/connection.php" ;


abstract class FunctionDefinitions
{
	abstract public function ListFromTable($SQL);
	abstract public function AddToTable($SQL);
	abstract public function UpdateTable($SQL);
	abstract public function UpdateTableNoResponse($SQL);
	abstract public function DeleteRow($SQL);
	abstract public function ReturnCountValue($SQL);

	abstract public function userAuthentication($SQL,$password);
	abstract public function SignOut();
	abstract public function ChangePassword($SQL,$password);
	
	abstract public function ExecuteProcedure($SQL);
	
}

class CommonModel extends FunctionDefinitions
{
	var $varDBConnection;
	var $result;
	var $flag=0;
	

	function __construct()
	{
		$DBConn = new DBConnection();
		$this->varDBConnection = $DBConn->ConnectToMYSQL();
	}

	public function ListFromTable($SQL)
	{
	
		$temp = array();
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		while($row=mysqli_fetch_assoc($this->result)) {
			$temp['data'][] = $row;
		}
		$this->flag=1;
		$count = mysqli_num_rows($this->result);
		if($count==0)
		{
		                $myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                        $myObj->error_code = '200';
    					$myObj->status = 'Failed';
    					$myObj->api_message ='NO DATA FOUND';
    					echo json_encode($myObj);
    				
		}
		else
		{
		    echo json_encode($temp);
		}
		
		
		
	}

	function ExecuteProcedure($SQL)
	{
		
			$retval = mysqli_query($this->varDBConnection, $SQL);
			if (!($res = $this->varDBConnection->query("SELECT @msg as msg,@p_ids as p_ids,@v_ids as v_ids"))) {
				echo "Fetch failed: (" . $this->varDBConnection->errno . ") " . $this->varDBConnection->error;
			}
			$row = $res->fetch_assoc();
			$this->flag=0;
			return json_encode($row);

	}
	

	
	
	public function userAuthentication($SQL,$password)
	{
		
		$enc_password = "";
		$user_status; 
		$user_name;
		$user_type;
		$user_id;
		$user_loginusername;
		$user_email;
		$user_phone;
		$user_image;
		$user_loginusername;
        $return_string="";
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		$row_count = mysqli_num_rows($this->result);
		
		if($row_count>=1)
		{

            while($row=mysqli_fetch_assoc($this->result))
             {
			
				$enc_password= $row['employee_password'];
				$employee_status = $row['employee_status'];
				$user_name = $row["user_name"]; 
				$user_type = $row["user_type"]; 
				$user_id = $row["user_id"];
				$user_loginusername = $row["user_loginusername"];
				$enc_password = $row["user_password"];
				$user_email = $row["user_email"];
				$user_phone = $row["user_phone"];
				$user_image = $row["user_image"];
				$user_status = $row["user_status"];
				$user_created_on = $row["user_created_on"];
				$code_c = $row["code_c"];
				$code_m = $row["code_m"];
				$primary_member_id = $row["primary_member_id"];
				}
			
			if($user_status=='Active')
			{
				if($password==$enc_password)
				{
					session_start();
									
									// Store data in session variables
								    $_SESSION['logged_status']='true';
									$_SESSION["user_id"] = $user_id;
									$_SESSION["user_type"] = $user_type; 
									$_SESSION["user_name"] = $user_name;
									$_SESSION["user_loginusername"] = $user_loginusername;
									$_SESSION["user_password"] = $enc_password;
									$_SESSION["user_email"] = $user_email;
									$_SESSION["user_phone"] = $user_phone;
									$_SESSION["user_image"] = $user_image;
									$_SESSION["user_created_on"] = $user_created_on;
									$_SESSION["code_c"] = $code_c;
									$_SESSION["code_m"] = $code_m;
									$_SESSION["primary_member_id"] = $primary_member_id;
									

								
									return 'Success';
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
	

	public function SignOut()
	{
	
		session_start();
		$_SESSION = array();
		session_destroy();
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
			echo $affected_status;
	}
    function UpdateTableNoResponse($SQL)
	{
			$retval = mysqli_query($this->varDBConnection, $SQL);
			$affected_status = mysqli_affected_rows($this->varDBConnection);
			$this->flag=0;
		//	echo $affected_status;
	}
	function ReturnCountValue($SQL)
	{
			$this->result = mysqli_query($this->varDBConnection,$SQL);
			$affected_status = mysqli_num_rows($this->result);
			$this->flag=0;
			return $affected_status;
	}
	
	


	function DeleteRow($SQL)
	{
			$retval = mysqli_query($this->varDBConnection, $SQL);
			$affected_status = mysqli_affected_rows($this->varDBConnection);
			$this->flag=0;
			echo $affected_status;
	}

    function ChangePassword($SQL,$password)
	{
		$this->result = mysqli_query($this->varDBConnection,$SQL);
		$row_count = mysqli_num_rows($this->result);
		
			while($row=mysqli_fetch_assoc($this->result)) {
				$enc_password= $row['user_password'];
				
			}
			
			if(password_verify($password, $enc_password))
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
			mysqli_free_result($this->result);
		}
		
		mysqli_close($this->varDBConnection);
		//print "Destroying " . __CLASS__ . "\n";
		
    }
	
	

}

?>