<?php
require_once(__DIR__ . '/../../model/common/common_functions.php');

class EmployeeTypeController
{
    var $varModelObj, $varDBConnection;
    public $actionevents, $employee_type_id, $employee_type_name, $employee_type_description, $employee_type_status, $employee_type_action;

    function __construct()
    {
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->ensureTableStructure();

        $this->actionevents = isset($_POST['action']) ? $_POST['action'] : '';
        $this->employee_type_id = isset($_POST['v_employee_type_id']) ? intval($_POST['v_employee_type_id']) : 0;
        $this->employee_type_name = isset($_POST['v_employee_type_name']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_employee_type_name'])) : '';
        $this->employee_type_description = isset($_POST['v_employee_type_description']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_employee_type_description'])) : '';
        $this->employee_type_status = isset($_POST['v_employee_type_status']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_employee_type_status'])) : 'Active';
        $this->employee_type_action = isset($_POST['v_employee_type_action']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_employee_type_action'])) : '';
    }

    private function ensureTableStructure()
    {
        $table_check = "CREATE TABLE IF NOT EXISTS `tbl_user_types` (
            `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
            `user_type_name` varchar(200) DEFAULT 'NA',
            `user_type_status` varchar(50) DEFAULT 'Active',
            `user_type_description` text DEFAULT NULL,
            PRIMARY KEY (`user_type_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
        mysqli_query($this->varDBConnection, $table_check);

        // Check if user_type_status column exists
        $col_check_status = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_status'");
        if (mysqli_num_rows($col_check_status) == 0) {
            mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_status` varchar(50) DEFAULT 'Active'");
        }

        // Check if user_type_description column exists
        $col_check_desc = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_description'");
        if (mysqli_num_rows($col_check_desc) == 0) {
            mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_description` text DEFAULT NULL");
        }
    }

    function RequestAccept($FunctionEvents)
    {
        switch ($FunctionEvents) {
            case 'add_employee_type':
                if (empty($this->employee_type_name)) {
                    echo "Please provide Employee Type Name.";
                    break;
                }

                $chk = mysqli_query($this->varDBConnection, "SELECT user_type_id FROM tbl_user_types WHERE LOWER(TRIM(user_type_name)) = LOWER('$this->employee_type_name')");
                if (mysqli_num_rows($chk) > 0) {
                    echo "Employee Type '$this->employee_type_name' already exists.";
                    break;
                }

                $sql = "INSERT INTO `tbl_user_types` (`user_type_name`, `user_type_description`, `user_type_status`) 
                        VALUES ('$this->employee_type_name', '$this->employee_type_description', 'Active')";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    echo "Success";
                } else {
                    echo "Failed to add Employee Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'list_employee_types':
                $sql = "SELECT 
                            ut.user_type_id, 
                            ut.user_type_name, 
                            COALESCE(ut.user_type_description, '') AS user_type_description,
                            COALESCE(ut.user_type_status, 'Active') AS user_type_status,
                            COUNT(e.employee_id) AS assigned_count
                        FROM tbl_user_types ut
                        LEFT JOIN tbl_employees e ON (e.employee_type_id = ut.user_type_id OR (e.employee_type_id IS NULL AND e.employee_type_name = ut.user_type_name))
                        GROUP BY ut.user_type_id, ut.user_type_name, ut.user_type_description, ut.user_type_status
                        ORDER BY ut.user_type_id DESC";
                $this->varModelObj->ListFromTable($sql);
                break;

            case 'update_employee_type':
                if ($this->employee_type_id <= 0 || empty($this->employee_type_name)) {
                    echo "Invalid parameters for updating Employee Type.";
                    break;
                }

                $chk = mysqli_query($this->varDBConnection, "SELECT user_type_id FROM tbl_user_types WHERE LOWER(TRIM(user_type_name)) = LOWER('$this->employee_type_name') AND user_type_id != $this->employee_type_id");
                if (mysqli_num_rows($chk) > 0) {
                    echo "Another Employee Type with name '$this->employee_type_name' already exists.";
                    break;
                }

                $sql = "UPDATE `tbl_user_types` SET 
                        `user_type_name` = '$this->employee_type_name', 
                        `user_type_description` = '$this->employee_type_description' 
                        WHERE `user_type_id` = $this->employee_type_id";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    // Also synchronize employee_type_name in tbl_employees for existing assigned employees
                    mysqli_query($this->varDBConnection, "UPDATE tbl_employees SET employee_type_name = '$this->employee_type_name' WHERE employee_type_id = $this->employee_type_id");
                    echo "Success";
                } else {
                    echo "Failed to update Employee Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'change_employee_type_status':
                if ($this->employee_type_id <= 0) {
                    echo "Invalid Employee Type ID.";
                    break;
                }

                $new_status = ($this->employee_type_action == 'Active') ? 'Active' : 'Deactive';
                $sql = "UPDATE `tbl_user_types` SET `user_type_status` = '$new_status' WHERE `user_type_id` = $this->employee_type_id";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    echo "Success";
                } else {
                    echo "Failed to update status: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'delete_employee_type':
                if ($this->employee_type_id <= 0) {
                    echo "Invalid Employee Type ID.";
                    break;
                }

                // Check if any employees are currently assigned
                $chk_assigned = mysqli_query($this->varDBConnection, "SELECT COUNT(*) AS cnt FROM tbl_employees WHERE employee_type_id = $this->employee_type_id OR employee_type_name = (SELECT user_type_name FROM tbl_user_types WHERE user_type_id = $this->employee_type_id)");
                $row_cnt = mysqli_fetch_assoc($chk_assigned);
                $cnt = intval($row_cnt['cnt']);

                if ($cnt > 0) {
                    echo "Cannot delete: $cnt employee(s) are currently assigned to this Employee Type. You can deactivate it instead.";
                    break;
                }

                $sql = "DELETE FROM `tbl_user_types` WHERE `user_type_id` = $this->employee_type_id";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    echo "Success";
                } else {
                    echo "Failed to delete Employee Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'get_active_employee_types':
                $sql = "SELECT user_type_id, user_type_name, COALESCE(user_type_description, '') AS user_type_description FROM tbl_user_types WHERE user_type_status = 'Active' ORDER BY user_type_name ASC";
                $res = mysqli_query($this->varDBConnection, $sql);
                $types = array();
                if ($res) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $types[] = $row;
                    }
                }
                echo json_encode($types);
                break;

            default:
                echo 'No Action Found...!';
                break;
        }
    }
}

$obj = new EmployeeTypeController();
$obj->RequestAccept($obj->actionevents);
?>
