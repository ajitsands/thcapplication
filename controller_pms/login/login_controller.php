<?php
require ('../../model/common/common_functions.php');
class loginController 
{
    var $varModelObj;
    public $actionevents,$username,$password,$login_result,$type;

  
    function __construct()
	{
        
        $this->varModelObj = new CommonModel();
        $this->actionevents = $_POST['action'];
        $this->username = $_POST['v_username'];
        $this->password = $_POST['v_password'];
		$this->user_id = $_POST['v_user_id'];

    }
    function SQLArray()
    {
        $array =  array();
        $array[0] = "SELECT * FROM  tbl_employees where employee_code='".$this->username."' ";
        $array[1] = "UPDATE `tbl_employees` SET `employee_password`='".$this->password."' WHERE employee_id='".$this->user_id."'";
	   
        return $array;
    }

    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();

        switch ($FunctionEvents)
        {
            
            case 'login':
                //echo $var[0];
                $this->login_result = $this->varModelObj->userAuthenticationforcheckpms($var[0],$this->password);
               
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
        }
    }


}

$obj = new loginController();
$obj->RequestAccept($obj->actionevents);