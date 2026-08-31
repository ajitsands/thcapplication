<?php

require('../../model/common/common_functions.php');

class LeaveTypeController
{
    var $varModelObj, $varDBConnection;
    public $actionevents, $leave_type_id, $leave_type_name, $leave_type_color, $leave_type_description, $leave_type_status, $leave_type_action;

    function __construct()
    {
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->ensureTableExists();

        $this->actionevents = isset($_POST['action']) ? $_POST['action'] : '';
        $this->leave_type_id = isset($_POST['v_leave_type_id']) ? intval($_POST['v_leave_type_id']) : 0;
        $this->leave_type_name = isset($_POST['v_leave_type_name']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_leave_type_name'])) : '';
        $this->leave_type_color = isset($_POST['v_leave_type_color']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_leave_type_color'])) : '#26a69a';
        $this->leave_type_description = isset($_POST['v_leave_type_description']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_leave_type_description'])) : '';
        $this->leave_type_status = isset($_POST['v_leave_type_status']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_leave_type_status'])) : 'Active';
        $this->leave_type_action = isset($_POST['v_leave_type_action']) ? mysqli_real_escape_string($this->varDBConnection, trim($_POST['v_leave_type_action'])) : '';
    }

    private function ensureTableExists()
    {
        $table_check = "CREATE TABLE IF NOT EXISTS `tbl_leave_types` (
            `leave_type_id` int(11) NOT NULL AUTO_INCREMENT,
            `leave_type_name` varchar(100) NOT NULL,
            `leave_type_color` varchar(20) NOT NULL DEFAULT '#26a69a',
            `leave_type_description` text DEFAULT NULL,
            `leave_type_status` enum('Active','Deactive') NOT NULL DEFAULT 'Active',
            PRIMARY KEY (`leave_type_id`),
            UNIQUE KEY `uniq_leave_type_name` (`leave_type_name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        mysqli_query($this->varDBConnection, $table_check);

        // Seed defaults if empty
        $cnt_res = mysqli_query($this->varDBConnection, "SELECT COUNT(*) as cnt FROM tbl_leave_types");
        if ($cnt_res) {
            $r = mysqli_fetch_assoc($cnt_res);
            if ($r['cnt'] == 0) {
                $seed = "INSERT INTO `tbl_leave_types` (`leave_type_name`, `leave_type_color`, `leave_type_description`, `leave_type_status`) VALUES
                    ('Sick Leave', '#ef5350', 'Leave taken due to illness or medical appointment', 'Active'),
                    ('Casual Leave', '#42a5f5', 'Short-term casual leave for personal matters', 'Active'),
                    ('Annual Leave', '#66bb6a', 'Paid annual leave entitlement', 'Active'),
                    ('Emergency Leave', '#ffa726', 'Leave taken due to sudden family or urgent emergency', 'Active'),
                    ('Privilege Leave', '#ab47bc', 'Privileged leave earned over duration of service', 'Active');";
                mysqli_query($this->varDBConnection, $seed);
            }
        }
    }

    function RequestAccept($FunctionEvents)
    {
        switch ($FunctionEvents) {
            case 'add_leave_type':
                if (empty($this->leave_type_name)) {
                    echo "Please provide Leave Type Name.";
                    break;
                }
                $chk = mysqli_query($this->varDBConnection, "SELECT leave_type_id FROM tbl_leave_types WHERE leave_type_name = '$this->leave_type_name'");
                if (mysqli_num_rows($chk) > 0) {
                    echo "Leave Type '$this->leave_type_name' already exists.";
                    break;
                }
                $sql = "INSERT INTO `tbl_leave_types` (`leave_type_name`, `leave_type_color`, `leave_type_description`, `leave_type_status`) 
                        VALUES ('$this->leave_type_name', '$this->leave_type_color', '$this->leave_type_description', 'Active')";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    echo "Success";
                } else {
                    echo "Failed to add Leave Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'list_leave_types':
                $sql = "SELECT leave_type_id, leave_type_name, leave_type_color, COALESCE(leave_type_description, '') AS leave_type_description, leave_type_status FROM tbl_leave_types ORDER BY leave_type_id DESC";
                $this->varModelObj->ListFromTable($sql);
                break;

            case 'update_leave_type':
                if ($this->leave_type_id <= 0 || empty($this->leave_type_name)) {
                    echo "Invalid leave type parameters.";
                    break;
                }
                $chk = mysqli_query($this->varDBConnection, "SELECT leave_type_id FROM tbl_leave_types WHERE leave_type_name = '$this->leave_type_name' AND leave_type_id != $this->leave_type_id");
                if (mysqli_num_rows($chk) > 0) {
                    echo "Another Leave Type with name '$this->leave_type_name' already exists.";
                    break;
                }
                $sql = "UPDATE `tbl_leave_types` SET 
                        `leave_type_name` = '$this->leave_type_name', 
                        `leave_type_color` = '$this->leave_type_color', 
                        `leave_type_description` = '$this->leave_type_description' 
                        WHERE `leave_type_id` = $this->leave_type_id";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    echo "Success";
                } else {
                    echo "Failed to update Leave Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'change_leave_type_status':
                if ($this->leave_type_id <= 0) {
                    echo "Invalid leave type ID.";
                    break;
                }
                $new_status = ($this->leave_type_action == 'Active') ? 'Active' : 'Deactive';
                $sql = "UPDATE `tbl_leave_types` SET `leave_type_status` = '$new_status' WHERE `leave_type_id` = $this->leave_type_id";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    echo "Success";
                } else {
                    echo "Failed to update status: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'get_active_leave_types':
                $sql = "SELECT leave_type_id, leave_type_name, leave_type_color, leave_type_description FROM tbl_leave_types WHERE leave_type_status = 'Active' ORDER BY leave_type_name ASC";
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

$obj = new LeaveTypeController();
$obj->RequestAccept($obj->actionevents);
?>
