<?php
require_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = $_POST['action'] ?? $_GET['action'];

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
                       l.scan_lat, l.scan_lng, l.asset_lat, l.asset_lng, l.distance_meters,
                       a.assignment_ref_no, a.checklist_id,
                       c.checklist_name,
                       ast.asset_ref_no, ast.asset_description, ast.latitude as ast_lat, ast.longitude as ast_lng,
                       b.building_name, b.latitude as bldg_lat, b.longitude as bldg_lng,
                       e.employee_name, e.employee_code
                FROM tbl_janitor_execution_log l
                LEFT JOIN tbl_janitor_assignments a ON l.assignment_id = a.id
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_assets ast ON l.asset_id = ast.asset_id
                LEFT JOIN tbl_building b ON ast.building_id = b.building_id
                LEFT JOIN tbl_employees e ON l.employee_id = e.employee_id
                WHERE $where_sql
                ORDER BY l.executed_date DESC, l.id DESC";
                
        $res = mysqli_query($conn, $sql);
        if($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                // Determine effective asset coordinates
                $row['effective_asset_lat'] = !empty($row['asset_lat']) ? $row['asset_lat'] : (!empty($row['ast_lat']) ? $row['ast_lat'] : $row['bldg_lat']);
                $row['effective_asset_lng'] = !empty($row['asset_lng']) ? $row['asset_lng'] : (!empty($row['ast_lng']) ? $row['ast_lng'] : $row['bldg_lng']);
                $data[] = $row;
            }
        }
        
        echo json_encode(["data" => $data]);
        exit;
    }

    else if ($action == 'list_scan_tracking') {
        $data = [];
        $where_clauses = ["1=1"];

        if (isset($_POST['employee_id']) && $_POST['employee_id'] != '') {
            $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
            $where_clauses[] = "(att.employee_id = '$employee_id' OR e.employee_id = '$employee_id')";
        }

        if (isset($_POST['asset_id']) && $_POST['asset_id'] != '') {
            $asset_id = mysqli_real_escape_string($conn, $_POST['asset_id']);
            $where_clauses[] = "att.asset_id = '$asset_id'";
        }

        if (isset($_POST['scan_status']) && $_POST['scan_status'] != '') {
            $scan_status = mysqli_real_escape_string($conn, $_POST['scan_status']);
            $where_clauses[] = "att.scan_status = '$scan_status'";
        }

        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {
            $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
            $where_clauses[] = "att.attendance_date >= '$from_date'";
        }

        if (isset($_POST['to_date']) && $_POST['to_date'] != '') {
            $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
            $where_clauses[] = "att.attendance_date <= '$to_date'";
        }

        $where_sql = implode(" AND ", $where_clauses);

        $sql = "SELECT att.id as scan_id, att.employee_id, att.attendance_date, att.attendance_time, att.attendance_status, att.scan_status,
                       att.janitor_lat as scan_lat, att.janitor_lng as scan_lng,
                       att.asset_lat, att.asset_lng, att.building_lat, att.building_lng,
                       att.distance_meters, att.created_at,
                       att.asset_code,
                       ast.asset_description,
                       b.building_name,
                       COALESCE(e.employee_name, 'Janitor') as employee_name,
                       COALESCE(att.employee_code, e.employee_code) as employee_code
                FROM tbl_janitor_attendance att
                LEFT JOIN tbl_employees e ON (att.employee_id = e.employee_id OR att.employee_code = e.employee_code)
                LEFT JOIN tbl_assets ast ON (att.asset_id = ast.asset_id OR att.asset_code = ast.asset_ref_no)
                LEFT JOIN tbl_building b ON att.building_id = b.building_id
                WHERE $where_sql
                ORDER BY att.id DESC";

        $res = mysqli_query($conn, $sql);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $eff_asset_lat = !empty($row['asset_lat']) ? $row['asset_lat'] : $row['building_lat'];
                $eff_asset_lng = !empty($row['asset_lng']) ? $row['asset_lng'] : $row['building_lng'];
                $row['effective_asset_lat'] = $eff_asset_lat;
                $row['effective_asset_lng'] = $eff_asset_lng;
                
                // Map links
                $row['scan_map_url'] = (!empty($row['scan_lat']) && !empty($row['scan_lng'])) 
                    ? "https://www.google.com/maps?q={$row['scan_lat']},{$row['scan_lng']}" 
                    : "";
                $row['asset_map_url'] = (!empty($eff_asset_lat) && !empty($eff_asset_lng)) 
                    ? "https://www.google.com/maps?q={$eff_asset_lat},{$eff_asset_lng}" 
                    : "";

                $data[] = $row;
            }
        }

        echo json_encode(["data" => $data]);
        exit;
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

        // Also fetch GPS coordinates and details for this execution
        $geo_info = null;
        $geo_q = mysqli_query($conn, "SELECT l.scan_lat, l.scan_lng, l.asset_lat, l.asset_lng, l.distance_meters,
                                             ast.asset_ref_no, ast.asset_description,
                                             b.building_name, b.latitude as bldg_lat, b.longitude as bldg_lng,
                                             e.employee_name, e.employee_code
                                      FROM tbl_janitor_execution_log l
                                      LEFT JOIN tbl_assets ast ON l.asset_id = ast.asset_id
                                      LEFT JOIN tbl_building b ON ast.building_id = b.building_id
                                      LEFT JOIN tbl_employees e ON l.employee_id = e.employee_id
                                      WHERE l.id = $execution_id LIMIT 1");
        if ($geo_q && mysqli_num_rows($geo_q) > 0) {
            $geo_info = mysqli_fetch_assoc($geo_q);
            $geo_info['effective_asset_lat'] = !empty($geo_info['asset_lat']) ? $geo_info['asset_lat'] : $geo_info['bldg_lat'];
            $geo_info['effective_asset_lng'] = !empty($geo_info['asset_lng']) ? $geo_info['asset_lng'] : $geo_info['bldg_lng'];
        }
        
        echo json_encode(["status" => "success", "categories" => $categories, "geo_info" => $geo_info]);
        exit;
    }

    else if ($action == 'get_janitor_month_history') {
        $employee_id = isset($_POST['employee_id']) ? mysqli_real_escape_string($conn, trim($_POST['employee_id'])) : '';
        $month = isset($_POST['month']) ? mysqli_real_escape_string($conn, trim($_POST['month'])) : date('Y-m');
        
        if (empty($month)) {
            $month = date('Y-m');
        }
        $from_date = $month . '-01';
        $to_date = date('Y-m-t', strtotime($from_date));

        $where_clauses = ["att.attendance_date BETWEEN '$from_date' AND '$to_date'"];
        
        if (!empty($employee_id)) {
            $where_clauses[] = "(att.employee_id = '$employee_id' OR e.employee_id = '$employee_id' OR att.employee_code = '$employee_id' OR e.employee_code = '$employee_id')";
        }

        $where_sql = implode(" AND ", $where_clauses);

        $sql = "SELECT att.id as scan_id, att.employee_id, att.attendance_date, att.attendance_time, att.attendance_status, att.scan_status,
                       att.janitor_lat as scan_lat, att.janitor_lng as scan_lng,
                       att.asset_lat, att.asset_lng, att.building_lat, att.building_lng,
                       att.distance_meters, att.created_at,
                       att.asset_code,
                       ast.asset_description,
                       b.building_name,
                       COALESCE(e.employee_name, 'Janitor') as employee_name,
                       COALESCE(att.employee_code, e.employee_code) as employee_code
                FROM tbl_janitor_attendance att
                LEFT JOIN tbl_employees e ON (att.employee_id = e.employee_id OR att.employee_code = e.employee_code)
                LEFT JOIN tbl_assets ast ON (att.asset_id = ast.asset_id OR att.asset_code = ast.asset_ref_no)
                LEFT JOIN tbl_building b ON att.building_id = b.building_id
                WHERE $where_sql
                ORDER BY att.attendance_date DESC, att.attendance_time DESC";

        $res = mysqli_query($conn, $sql);
        $scans = [];
        $total_scans = 0;
        $verified_scans = 0;
        $mismatch_scans = 0;
        $bypassed_scans = 0;
        $total_dist = 0;
        $valid_dist_count = 0;

        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $total_scans++;
                $dist = ($row['distance_meters'] !== null) ? (float)$row['distance_meters'] : 0.0;
                $status = $row['scan_status'] ?? $row['attendance_status'];

                if ($status === 'Verified' || $status === 'Present') {
                    $verified_scans++;
                } else if ($status === 'Bypassed') {
                    $bypassed_scans++;
                } else {
                    $mismatch_scans++;
                }

                if ($row['distance_meters'] !== null) {
                    $total_dist += $dist;
                    $valid_dist_count++;
                }

                $eff_asset_lat = !empty($row['asset_lat']) ? $row['asset_lat'] : $row['building_lat'];
                $eff_asset_lng = !empty($row['asset_lng']) ? $row['asset_lng'] : $row['building_lng'];
                $row['effective_asset_lat'] = $eff_asset_lat;
                $row['effective_asset_lng'] = $eff_asset_lng;

                $scans[] = $row;
            }
        }

        $avg_distance = $valid_dist_count > 0 ? round($total_dist / $valid_dist_count, 1) : 0;

        echo json_encode([
            "status" => "success",
            "month" => $month,
            "from_date" => $from_date,
            "to_date" => $to_date,
            "summary" => [
                "total_scans" => $total_scans,
                "verified_scans" => $verified_scans,
                "mismatch_scans" => $mismatch_scans,
                "bypassed_scans" => $bypassed_scans,
                "avg_distance" => $avg_distance
            ],
            "data" => $scans
        ]);
        exit;
    }
}
?>
