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

        $this->syncRolesWithUserTypes();
    }

    public function syncRolesWithUserTypes()
    {
        $chk_table = mysqli_query($this->varDBConnection, "SHOW TABLES LIKE 'roles'");
        if (!$chk_table || mysqli_num_rows($chk_table) == 0) {
            return;
        }

        // Automatically sync any active employee types in tbl_user_types that are missing from roles table
        $missing_roles = mysqli_query($this->varDBConnection, "
            SELECT ut.user_type_id, ut.user_type_name 
            FROM tbl_user_types ut 
            LEFT JOIN roles r ON (ut.user_type_id = r.id OR LOWER(TRIM(ut.user_type_name)) = LOWER(TRIM(r.name))) 
            WHERE r.id IS NULL 
              AND TRIM(ut.user_type_name) != '' 
              AND TRIM(ut.user_type_name) != 'NA'
        ");
        if ($missing_roles && mysqli_num_rows($missing_roles) > 0) {
            while ($m_row = mysqli_fetch_assoc($missing_roles)) {
                $m_id = intval($m_row['user_type_id']);
                $m_name = mysqli_real_escape_string($this->varDBConnection, trim($m_row['user_type_name']));
                $ins = @mysqli_query($this->varDBConnection, "INSERT INTO `roles` (`id`, `name`) VALUES ($m_id, '$m_name')");
                if (!$ins) {
                    @mysqli_query($this->varDBConnection, "INSERT INTO `roles` (`name`) VALUES ('$m_name')");
                }
            }
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

                $chk_desc = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_description'");
                if (!$chk_desc || mysqli_num_rows($chk_desc) == 0) {
                    @mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_description` text DEFAULT NULL");
                }
                $chk_status = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_status'");
                if (!$chk_status || mysqli_num_rows($chk_status) == 0) {
                    @mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_status` varchar(50) DEFAULT 'Active'");
                }

                $chk_desc_final = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_description'");
                
                // First synchronize/insert into roles table for User Roles & Permissions
                $chk_role = mysqli_query($this->varDBConnection, "SELECT id FROM `roles` WHERE LOWER(TRIM(`name`)) = LOWER('$this->employee_type_name')");
                $new_id = 0;
                $role_created = false;
                if ($chk_role && mysqli_num_rows($chk_role) > 0) {
                    $row_role = mysqli_fetch_assoc($chk_role);
                    $new_id = intval($row_role['id']);
                } else {
                    $sql_role = "INSERT INTO `roles` (`name`) VALUES ('$this->employee_type_name')";
                    $res_role = mysqli_query($this->varDBConnection, $sql_role);
                    if ($res_role) {
                        $new_id = mysqli_insert_id($this->varDBConnection);
                        $role_created = true;
                    } else {
                        echo "Failed to create Role mapping: " . mysqli_error($this->varDBConnection);
                        break;
                    }
                }

                $chk_id_free = ($new_id > 0) ? mysqli_query($this->varDBConnection, "SELECT user_type_id FROM tbl_user_types WHERE user_type_id = $new_id") : false;
                $can_use_shared_id = ($new_id > 0 && $chk_id_free && mysqli_num_rows($chk_id_free) == 0);

                if ($can_use_shared_id) {
                    if ($chk_desc_final && mysqli_num_rows($chk_desc_final) > 0) {
                        $sql = "INSERT INTO `tbl_user_types` (`user_type_id`, `user_type_name`, `user_type_description`, `user_type_status`) 
                                VALUES ($new_id, '$this->employee_type_name', '$this->employee_type_description', 'Active')";
                    } else {
                        $sql = "INSERT INTO `tbl_user_types` (`user_type_id`, `user_type_name`, `user_type_status`) 
                                VALUES ($new_id, '$this->employee_type_name', 'Active')";
                    }
                } else {
                    if ($chk_desc_final && mysqli_num_rows($chk_desc_final) > 0) {
                        $sql = "INSERT INTO `tbl_user_types` (`user_type_name`, `user_type_description`, `user_type_status`) 
                                VALUES ('$this->employee_type_name', '$this->employee_type_description', 'Active')";
                    } else {
                        $sql = "INSERT INTO `tbl_user_types` (`user_type_name`, `user_type_status`) 
                                VALUES ('$this->employee_type_name', 'Active')";
                    }
                }

                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    $inserted_type_id = $can_use_shared_id ? $new_id : mysqli_insert_id($this->varDBConnection);
                    if (!$can_use_shared_id && $new_id == 0) {
                        $chk_role_final = mysqli_query($this->varDBConnection, "SELECT id FROM `roles` WHERE LOWER(TRIM(`name`)) = LOWER('$this->employee_type_name')");
                        if (!$chk_role_final || mysqli_num_rows($chk_role_final) == 0) {
                            @mysqli_query($this->varDBConnection, "INSERT INTO `roles` (`id`, `name`) VALUES ($inserted_type_id, '$this->employee_type_name')");
                        }
                    }
                    echo "Success";
                } else {
                    if ($role_created && $new_id > 0) {
                        @mysqli_query($this->varDBConnection, "DELETE FROM `roles` WHERE `id` = $new_id");
                    }
                    echo "Failed to add Employee Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'list_employee_types':
                $has_desc = false;
                $chk_desc = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_description'");
                if ($chk_desc && mysqli_num_rows($chk_desc) > 0) {
                    $has_desc = true;
                } else {
                    @mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_description` text DEFAULT NULL");
                    $chk_desc2 = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_description'");
                    if ($chk_desc2 && mysqli_num_rows($chk_desc2) > 0) {
                        $has_desc = true;
                    }
                }
                $desc_col = $has_desc ? "COALESCE(ut.user_type_description, '')" : "''";

                $has_status = false;
                $chk_status = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_status'");
                if ($chk_status && mysqli_num_rows($chk_status) > 0) {
                    $has_status = true;
                } else {
                    @mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_status` varchar(50) DEFAULT 'Active'");
                    $chk_status2 = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_status'");
                    if ($chk_status2 && mysqli_num_rows($chk_status2) > 0) {
                        $has_status = true;
                    }
                }
                $status_col = $has_status ? "COALESCE(ut.user_type_status, 'Active')" : "'Active'";

                $sql = "SELECT 
                            ut.user_type_id, 
                            ut.user_type_name, 
                            $desc_col AS user_type_description,
                            $status_col AS user_type_status,
                            (SELECT COUNT(*) FROM tbl_employees WHERE employee_type_id = ut.user_type_id) AS assigned_count
                        FROM tbl_user_types ut
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

                // Retrieve old name for role update mapping
                $old_name = '';
                $old_chk = mysqli_query($this->varDBConnection, "SELECT user_type_name FROM tbl_user_types WHERE user_type_id = $this->employee_type_id");
                if ($old_chk && ($old_row = mysqli_fetch_assoc($old_chk))) {
                    $old_name = mysqli_real_escape_string($this->varDBConnection, trim($old_row['user_type_name']));
                }

                $chk_desc = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_description'");
                if ($chk_desc && mysqli_num_rows($chk_desc) > 0) {
                    $sql = "UPDATE `tbl_user_types` SET 
                            `user_type_name` = '$this->employee_type_name', 
                            `user_type_description` = '$this->employee_type_description' 
                            WHERE `user_type_id` = $this->employee_type_id";
                } else {
                    $sql = "UPDATE `tbl_user_types` SET 
                            `user_type_name` = '$this->employee_type_name' 
                            WHERE `user_type_id` = $this->employee_type_id";
                }

                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    // Update employee_type_name in tbl_employees for existing assigned employees
                    mysqli_query($this->varDBConnection, "UPDATE tbl_employees SET employee_type_name = '$this->employee_type_name' WHERE employee_type_id = $this->employee_type_id");

                    // Update roles table to keep User Roles & Permissions in sync
                    mysqli_query($this->varDBConnection, "UPDATE `roles` SET `name` = '$this->employee_type_name' WHERE `id` = $this->employee_type_id");
                    if (mysqli_affected_rows($this->varDBConnection) == 0 && !empty($old_name)) {
                        mysqli_query($this->varDBConnection, "UPDATE `roles` SET `name` = '$this->employee_type_name' WHERE LOWER(TRIM(`name`)) = LOWER('$old_name')");
                    }
                    $role_exists_chk = mysqli_query($this->varDBConnection, "SELECT id FROM `roles` WHERE LOWER(TRIM(`name`)) = LOWER('$this->employee_type_name') OR id = $this->employee_type_id");
                    if (!$role_exists_chk || mysqli_num_rows($role_exists_chk) == 0) {
                        $ins = @mysqli_query($this->varDBConnection, "INSERT INTO `roles` (`id`, `name`) VALUES ($this->employee_type_id, '$this->employee_type_name')");
                        if (!$ins) {
                            @mysqli_query($this->varDBConnection, "INSERT INTO `roles` (`name`) VALUES ('$this->employee_type_name')");
                        }
                    }

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

                $chk_status = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_status'");
                if (!$chk_status || mysqli_num_rows($chk_status) == 0) {
                    @mysqli_query($this->varDBConnection, "ALTER TABLE `tbl_user_types` ADD `user_type_status` varchar(50) DEFAULT 'Active'");
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
                $chk_assigned = mysqli_query($this->varDBConnection, "SELECT COUNT(*) AS cnt FROM tbl_employees WHERE employee_type_id = $this->employee_type_id");
                $row_cnt = mysqli_fetch_assoc($chk_assigned);
                $cnt = intval($row_cnt['cnt']);

                if ($cnt > 0) {
                    echo "Cannot delete: $cnt employee(s) are currently assigned to this Employee Type. You can deactivate it instead.";
                    break;
                }

                // Retrieve old name for roles cleanup
                $del_name = '';
                $type_res = mysqli_query($this->varDBConnection, "SELECT user_type_name FROM tbl_user_types WHERE user_type_id = $this->employee_type_id");
                if ($type_res && ($type_row = mysqli_fetch_assoc($type_res))) {
                    $del_name = mysqli_real_escape_string($this->varDBConnection, trim($type_row['user_type_name']));
                }

                $sql = "DELETE FROM `tbl_user_types` WHERE `user_type_id` = $this->employee_type_id";
                $res = mysqli_query($this->varDBConnection, $sql);
                if ($res) {
                    // Identify role ID(s) to remove and clean up permissions
                    $role_ids_to_delete = array();
                    if ($this->employee_type_id > 0) {
                        $role_ids_to_delete[] = $this->employee_type_id;
                    }
                    if (!empty($del_name)) {
                        $r_chk = mysqli_query($this->varDBConnection, "SELECT id FROM `roles` WHERE LOWER(TRIM(`name`)) = LOWER('$del_name')");
                        if ($r_chk) {
                            while ($r_row = mysqli_fetch_assoc($r_chk)) {
                                $role_ids_to_delete[] = intval($r_row['id']);
                            }
                        }
                    }
                    $role_ids_to_delete = array_unique(array_filter($role_ids_to_delete));

                    // Delete from roles table
                    if (!empty($del_name)) {
                        mysqli_query($this->varDBConnection, "DELETE FROM `roles` WHERE `id` = $this->employee_type_id OR LOWER(TRIM(`name`)) = LOWER('$del_name')");
                    } else {
                        mysqli_query($this->varDBConnection, "DELETE FROM `roles` WHERE `id` = $this->employee_type_id");
                    }

                    // Clean up orphan entries in permissions and user_roles tables
                    if (!empty($role_ids_to_delete)) {
                        $ids_str = implode(',', $role_ids_to_delete);
                        @mysqli_query($this->varDBConnection, "DELETE FROM `role_permissions` WHERE `role_id` IN ($ids_str)");
                        @mysqli_query($this->varDBConnection, "DELETE FROM `role_permissions_v1` WHERE `role_id` IN ($ids_str)");
                        @mysqli_query($this->varDBConnection, "DELETE FROM `user_roles` WHERE `role_id` IN ($ids_str)");
                        @mysqli_query($this->varDBConnection, "DELETE FROM `user_roles_v1` WHERE `role_id` IN ($ids_str)");
                    }

                    echo "Success";
                } else {
                    echo "Failed to delete Employee Type: " . mysqli_error($this->varDBConnection);
                }
                break;

            case 'get_active_employee_types':
                $has_status = false;
                $chk_status = mysqli_query($this->varDBConnection, "SHOW COLUMNS FROM `tbl_user_types` LIKE 'user_type_status'");
                if ($chk_status && mysqli_num_rows($chk_status) > 0) {
                    $sql = "SELECT user_type_id, user_type_name FROM tbl_user_types WHERE user_type_status = 'Active' ORDER BY user_type_name ASC";
                } else {
                    $sql = "SELECT user_type_id, user_type_name FROM tbl_user_types ORDER BY user_type_name ASC";
                }
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
