<?php
		ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
require ('../../model/common/common_functions.php');
class loginController 
{
    var $varModelObj, $varConnection;
    public $actionevents,$username,$password,$login_result,$type;

  
    function __construct()
	{
        
        $this->varModelObj = new CommonModel();
        $this->varConnection =  $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        $this->username = $_POST['v_username'];
        $this->password = $_POST['v_password'];
		$this->user_id = $_POST['v_user_id'];

		
        $this->module = $_POST['module'];
        $this->event = $_POST['event'];
        $this->ip_addr = $_SERVER['REMOTE_ADDR'];
        $this->formData = json_encode($_POST);
		
		$this->start_date = $_POST['v_start_date'];
		$this->end_date = $_POST['v_end_date'];
		
		$this->thisEmail = $_POST['thisEmail'];
		
		unset($_POST['module']);
		unset($_POST['event']);
		unset($_POST['username']);
		
		date_default_timezone_set('Asia/Bahrain');
        $this->current_date = date("Y-m-d h:i:s");
    }
    function SQLArray()
    {  
        $array =  array();
        $array[0] = "SELECT * FROM tbl_employees WHERE BINARY employee_code = '".$this->username."' ";
        $array[1] = "UPDATE `tbl_employees` SET `employee_password`='".$this->password."' WHERE employee_id='".$this->user_id."'";
	    
	    $array[2] = "INSERT INTO tbl_login_logout_log (jsondata,username,default_date,event_type,ip_address,modules) VALUES ('".$this->formData."','".$this->username."','".$this->current_date."','".$this->event."','".$this->ip_addr."','".$this->module."')";
		
        $array[3] = "SELECT *,DATE_FORMAT(default_date, '%d-%m-%Y %H:%i:%s') as default_date FROM  tbl_login_logout_log  WHERE DATE(default_date) BETWEEN '".$this->start_date."' AND '".$this->end_date."' ";
		$array[4] = "SELECT *,DATE_FORMAT(default_date, '%d-%m-%Y %H:%i:%s %p') as default_date FROM  tbl_login_logout_log WHERE username = '".$this->username."' AND DATE(default_date) BETWEEN '".$this->start_date."' AND '".$this->end_date."' ";
		$array[5] = "SELECT *,DATE_FORMAT(default_date, '%d-%m-%Y %H:%i:%s %p') as default_date FROM  tbl_login_logout_log WHERE DATE(default_date) = DATE('".$this->current_date."') ";
		$array[6] = "SELECT employee_password FROM tbl_employees WHERE employee_email_id='".$this->thisEmail."'";
		return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();

        switch ($FunctionEvents)
        {
            
            case 'login':
                //echo $var[0];
                $this->login_result = $this->varModelObj->userAuthenticationforcheck($var[0],$this->password,$this->username);  
               
                if (trim($this->login_result)=="Success")
                {
                    echo "success";
                  
                }
                else 
                {
                    echo $this->login_result;
                }
               
            break;
			
			case 'reset_password':
             
                $this->varModelObj->UpdateTable($var[1]);
            break;
           
            case 'signout':
                $this->varModelObj->SignOut();
             
            break;
			case 'login_log':
                $this->varModelObj->AddToTable($var[2]);
             
            break;
			case 'list_log':
			if($this->username === 'All')
			{
                $this->varModelObj->ListFromTable($var[3]);
			}
			else if($this->username === '')
			{
				//echo "hjd".$var[5];
				$this->varModelObj->ListFromTable($var[5]);
			}
			else 
			{
				//echo "Q1 : ".$var[4];
				$this->varModelObj->ListFromTable($var[4]);	
			}
             
            break;
            
            case "forgot_password":
                $passwordFlag='';
        		$result = mysqli_query( $this->varConnection,$var[6]);
        		while($row=mysqli_fetch_assoc($result)) {
        			$res=$row['employee_password'];
        		}
        		if($res=="")
        		{
        		    $passwordFlag = "Email not found !";
        		    echo $passwordFlag;
        		}
        		else
        		{
        		    $to = $this->thisEmail;      
            		$subject = "THC - Password";
            		$header = "From: no-reply@thc-fms.com\r\n"; 
            		$header .= "MIME-Version: 1.0\r\n";
            		$header .= "Content-type: text/html\r\n";
                    $message = '<html>
                                   <body style="font-family: Arial, sans-serif;">
                                       <table style="border-collapse: collapse; width: 50%; border: 1px solid #ccc; padding: 8px;">
                                          <thead style="background-color:#001451; color:white;">
                                            <tr>
                                               <td style="padding: 8px;">Email</td>
                                               <td style="padding: 8px;">Password</td>
                                            </tr>
                                          <thead>
                                          <tbody style="background-color:#BED1B9">
                                          <tr>
                                               <td style="padding: 8px;">'.$this->thisEmail.'</td>
                                               <td style="padding: 8px;"><b>'.$res.'</b></td>
                                            </tr>
                                          </tbody>
                                       </table>
                                   <body>
                                </html>';
        
        
            		$sendMail = mail($to , $subject, $message, $header);
            		if($sendMail)
            		{
            			$passwordFlag = "Please check Password in your email";  
            			echo $passwordFlag;
            		} 
            		else 
            		{
            			$passwordFlag = "Mail Sending Failed";
            			echo $passwordFlag;
            		}
        		}
                 
            break;    
            
            default:
                echo "No Action Found!";
            break;    
        }
    }


}

$obj = new loginController();
$obj->RequestAccept($obj->actionevents);
