<?php

require ('../../model/common/common_functions.php');
class ticketController
{
        var $varModelObj,$varDBConnection;
        public $actionevents,$customer_id,$team_reference;
         
    function __construct()
	{
	    $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = $_POST['action'];
        date_default_timezone_set('Asia/Bahrain');
        $this->createddatetime = date('Y-m-d H:i:s');
        $this->createddate = date('Y-m-d');
        $this->customer_id = $_POST['customer_id'];
        $this->team_reference = $_POST['team_reference'];
    }

    function SQLArray()
    { 
        $array =  array();
        $array[0] = "SELECT `employee_id`,`employee_code`,`employee_name`,`employee_type_name` FROM `tbl_employees` WHERE `employee_type_id` in ('8','6','7')  AND `employee_status`='Active'";
        $array[1] = "SELECT tct.team_ref, tct.customer_ids, c.customer_name, c.customer_code,tct.`status`, GROUP_CONCAT(tct.ids) AS row_ids, GROUP_CONCAT(e.employee_name ORDER BY e.employee_id ASC) AS employees, (SELECT e2.employee_name FROM tbl_customer_teams t2 JOIN tbl_employees e2 ON e2.employee_id = t2.employee_ids WHERE t2.team_ref = tct.team_ref AND t2.customer_ids = tct.customer_ids AND t2.is_leader = 'Yes' LIMIT 1) AS leader FROM tbl_customer_teams tct JOIN tbl_customers c ON FIND_IN_SET(c.customer_id, tct.customer_ids) LEFT JOIN tbl_employees e ON FIND_IN_SET(e.employee_id, tct.employee_ids) GROUP BY tct.team_ref, tct.customer_ids";
        $array[2] = "UPDATE `tbl_customer_teams` SET `status`='Active' WHERE `team_ref`='".$this->team_reference."' AND `customer_ids`='".$this->customer_id."'";
        $array[3] = "UPDATE `tbl_customer_teams` SET `status`='Deactive' WHERE `team_ref`='".$this->team_reference."' AND `customer_ids`='".$this->customer_id."'";
        return $array;
    }
    function RequestAccept($FunctionEvents)
    {
        $var =  $this->SQLArray();
        switch ($FunctionEvents)
        {
            case 'list_avail_tech_in_schedule_ticket':
                $this->varModelObj->ListFromTable($var[0]);
            break;
            
            case 'get_team_list':
                $this->varModelObj->ListFromTable($var[1]);
            break;
            
            case 'active_status':
                echo $this->varModelObj->UpdateTable($var[2]);
            break;
            
            case 'deactive_status':
                echo $this->varModelObj->UpdateTable($var[3]);
            break;
            
            case 'add_team':
                $customer_id = $_POST['customer_id'];
                $team_reference = $_POST['team_reference'];
                $team_members = $_POST['team_members']; // array of employee_ids
                $leader_id = $_POST['leader_id'];
            
                $success_count = 0;
                $error = '';
            
                foreach ($team_members as $employee_id) {
                    $is_leader = ($employee_id == $leader_id) ? 'Yes' : 'No';
            
                    $sql = "INSERT INTO `tbl_customer_teams` (`team_ref`, `customer_ids`, `employee_ids`, `is_leader`) 
                            VALUES (?, ?, ?, ?)";
            
                    $stmt = $this->varDBConnection->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("ssss", $team_reference, $customer_id, $employee_id, $is_leader);
                        if ($stmt->execute()) {
                            $success_count++;
                        } else {
                            $error = "Failed to insert employee ID $employee_id";
                            break;
                        }
                        $stmt->close();
                    } else {
                        $error = "Prepare failed for employee ID $employee_id";
                        break;
                    }
                }
            
                if ($error === '') {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $error]);
                }
            break;
            
            case 'update_team':
                $hiddenids = $_POST['hiddenids']; 
                $ids = explode(',', $hiddenids);
            
                $allDeleted = true;
                foreach ($ids as $id) {
                    $id = intval($id);
                    $deleteSql = "DELETE FROM `tbl_customer_teams` WHERE `ids` = $id";
                    if (!mysqli_query($this->varDBConnection, $deleteSql)) {
                        $allDeleted = false;
                        break;
                    }
                }

                if ($allDeleted) {
                    $customer_id = $_POST['customer_id'];
                    $team_reference = $_POST['team_reference'];
                    $team_members = $_POST['team_members']; // array of employee_ids
                    $leader_id = $_POST['leader_id'];
            
                    $success_count = 0;
                    $error = '';
            
                    foreach ($team_members as $employee_id) {
                        $is_leader = ($employee_id == $leader_id) ? 'Yes' : 'No';
            
                        $sql = "INSERT INTO `tbl_customer_teams` (`team_ref`, `customer_ids`, `employee_ids`, `is_leader`) 
                                VALUES (?, ?, ?, ?)";
            
                        $stmt = $this->varDBConnection->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("ssss", $team_reference, $customer_id, $employee_id, $is_leader);
                            if ($stmt->execute()) {
                                $success_count++;
                            } else {
                                $error = "Failed to insert employee ID $employee_id";
                                break;
                            }
                            $stmt->close();
                        } else {
                            $error = "Prepare failed for employee ID $employee_id";
                            break;
                        }
                    }
            
                    if ($error === '') {
                        echo json_encode(['status' => 'success', 'message' => 'Team updated successfully.']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => $error]);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete one or more existing team members.']);
                }
            
            break;

            
            default:
                echo 'No Action Found...!';
            break;
        }
    }
}
$obj = new ticketController();
$obj->RequestAccept($obj->actionevents);
?>