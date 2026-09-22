<?php
require_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'list_executions') {
        $data = [];
        
        $where_clauses = ["1=1"];
        
        if (isset($_POST['customer_id']) && $_POST['customer_id'] != '') {
            $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
            $where_clauses[] = "(a.customer_id = '$customer_id' OR ast.customer_id = '$customer_id')";
        }
        
        if (isset($_POST['asset_id']) && $_POST['asset_id'] != '') {
            $asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);
            $where_clauses[] = "l.asset_id = '$asset_id'";
        }
        
        if (isset($_POST['amc_ref_no']) && $_POST['amc_ref_no'] != '') {
            $amc_ref_no = mysqli_real_escape_string($conn, $_POST['amc_ref_no']);
            $where_clauses[] = "l.amc_ref_no = '$amc_ref_no'";
        }
        
        if (isset($_POST['employee_id']) && $_POST['employee_id'] != '') {
            $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
            $where_clauses[] = "l.employee_id = '$employee_id'";
        }
        
        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {
            $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
            $where_clauses[] = "l.executed_date >= '$from_date'";
        }
        
        if (isset($_POST['to_date']) && $_POST['to_date'] != '') {
            $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
            $where_clauses[] = "l.executed_date <= '$to_date'";
        }
        
        $where_sql = implode(" AND ", $where_clauses);

        $sql = "SELECT l.id as execution_id, l.executed_date, l.executed_slot, l.status, l.remarks, l.created_at,
                       a.assignment_ref_no, a.checklist_id,
                       c.checklist_name,
                       ast.asset_ref_no, ast.asset_description,
                       e.employee_name, e.employee_code
                FROM tbl_janitor_execution_log l
                LEFT JOIN tbl_janitor_assignments a ON l.assignment_id = a.id
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_assets ast ON l.asset_id = ast.asset_id
                LEFT JOIN tbl_employees e ON l.employee_id = e.employee_id
                WHERE $where_sql
                ORDER BY l.executed_date DESC, l.id DESC";
                
        $res = mysqli_query($conn, $sql);
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
        }
        
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'get_execution_points') {
        $execution_id = isset($_POST['execution_id']) ? (int)$_POST['execution_id'] : 0;
        
        // Fetch the points grouped by category
        $sql = "SELECT ep.id as exec_point_id, ep.is_completed, ep.remarks, ep.photo_url,
                       i.item_description, 
                       cat.category_name
                FROM tbl_janitor_execution_points ep
                LEFT JOIN tbl_janitor_checklist_items i ON ep.checklist_item_id = i.id
                LEFT JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id
                WHERE ep.execution_id = $execution_id
                ORDER BY cat.id ASC, i.id ASC";
                
        $res = mysqli_query($conn, $sql);
        
        $categories = [];
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $cat_name = $row['category_name'] ? $row['category_name'] : 'Uncategorized';
                
                if (!isset($categories[$cat_name])) {
                    $categories[$cat_name] = [];
                }
                
                $categories[$cat_name][] = [
                    'item_description' => $row['item_description'],
                    'is_completed' => $row['is_completed'],
                    'remarks' => $row['remarks'],
                    'photo_url' => $row['photo_url']
                ];
            }
        }
        
        echo json_encode(["status" => "success", "categories" => $categories]);
    }
}
?>
