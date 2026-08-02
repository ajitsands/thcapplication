<?php

include('../model/db_connection/connection.php');

class AddModules
{
    public $conn;
    function __construct()
    {
        $connection = new DBConnection();
        $this->conn = $connection->ConnectToMYSQL();
    }
    
    function actionEvents($event)
    {
       switch($event)
       {
           case"insert_module_name":
               $query="SELECT * FROM module_permissions WHERE module_permission_name='".$_POST['moduleName']."' AND module_id='".$_POST['moduleId']."' AND role_id='".$_POST['rollId']."'";
               $numRows = $this->checkData($query, $this->conn);
               if($numRows==0)
               {
                    $insertQuery = "INSERT INTO module_permissions (module_permission_name, module_id, module_status, role_id) VALUES ('".$_POST['moduleName']."', '".$_POST['moduleId']."', 'No', '".$_POST['rollId']."')";
                    $result = mysqli_query($this->conn,$insertQuery);
                    if($result)
                    {
                        echo "data inserted";
                        $lastInsertedId = mysqli_insert_id($this->conn);
                        $insertQuery2 = "INSERT INTO role_permissions_v1(role_id,permission_id,module_id,sub_module_name,module_name) VALUES('".$_POST['rollId']."','".$lastInsertedId."','".$_POST['moduleId']."','".$_POST['moduleName']."','Yes')";
                        mysqli_query($this->conn,$insertQuery2);
                    }
                    else
                    {
                        echo "inserton failed";
                    }
               }
           break;
           
           case "delete_module_name":
                $query="SELECT * FROM module_permissions WHERE module_permission_name='".$_POST['moduleName']."' AND module_id='".$_POST['moduleId']."'";
                $numRows = $this->checkData($query, $this->conn);
                if($numRows>=1)
                {
                    $deleteQuery = "DELETE FROM module_permissions WHERE module_permission_name='".$_POST['moduleName']."' AND module_id='".$_POST['moduleId']."' AND role_id='".$_POST['rollId']."'";
                    $result = mysqli_query($this->conn,$deleteQuery);
                    if($result)
                    {
                        echo "data deleted";
                        $deleteQuery2="DELETE FROM role_permissions_v1 WHERE role_id='".$_POST['rollId']."' AND module_id='".$_POST['moduleId']."' AND sub_module_name='".$_POST['moduleName']."'";
                        mysqli_query($this->conn,$deleteQuery2);
                    }
                    else
                    {
                        echo "deletion failed";
                    }
                }
           break;       
           
           default: 
               echo "No Action Found!";
           break;
       }
    }
    
    function checkData($SQL, $conn)
    {
       $result = mysqli_query($conn, $SQL);
       return  mysqli_num_rows($result);
    }
    
    
   
    
}

$obj = new AddModules();
$obj->actionEvents($_POST['action']);

?>
