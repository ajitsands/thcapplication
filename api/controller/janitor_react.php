<?php
if (!headers_sent()) {
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

// Handle preflight OPTIONS requests
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once(__DIR__ . '/../db_connection/connection.php');
require_once(__DIR__ . '/../common/common_functions.php');
include_once(__DIR__ . '/../../view/template/includes/en_de_header.inc');

if (!class_exists('janitorApiController')) {
class janitorApiController
{
    var $varModelObj;
    var $varDBConnection;
    public $actionevents, $api_key, $emp_code, $emp_id, $date, $month, $year, $from_date, $to_date;
    public $assignment_id, $checklist_id, $execution_id, $slot, $remarks, $status, $points_json, $createddatetime;
    public $asset_code, $janitor_lat, $janitor_lng, $allowed_radius;
    public $domain_path, $myObj, $upload_dir;

    function __construct()
    {
        $this->domain_path = "https://portal.thcfm.com/httpdocs/";
        $this->upload_dir = __DIR__ . '/../../httpdocs/images/janitor_execution/';
        
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;

        $OBJ = new URLEncription();

        // Support JSON payload in POST request body as well as standard form-data / query string
        $raw_input = file_get_contents('php://input');
        $json_data = json_decode($raw_input, true);
        if (is_array($json_data)) {
            $_REQUEST = array_merge($_REQUEST, $json_data);
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $_POST = array_merge($_POST, $json_data);
            }
        }

        date_default_timezone_set("Asia/Bahrain");
        $this->createddatetime = date('Y-m-d H:i:s');

        // Extract action & API key
        $this->actionevents = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
        
        $api_key_param = isset($_REQUEST['APIKEY']) ? trim($_REQUEST['APIKEY']) : '';
        $this->api_key = $OBJ->KEYDecode($api_key_param);

        // Employee identification
        $this->emp_code = isset($_REQUEST['emp_code']) ? trim($_REQUEST['emp_code']) : (isset($_REQUEST['employee_code']) ? trim($_REQUEST['employee_code']) : '');
        $this->emp_id = isset($_REQUEST['emp_id']) ? (int)$_REQUEST['emp_id'] : (isset($_REQUEST['employee_id']) ? (int)$_REQUEST['employee_id'] : 0);

        // Date parameters for calendar & schedule list
        $this->date = isset($_REQUEST['date']) && !empty($_REQUEST['date']) 
            ? trim($_REQUEST['date']) 
            : (isset($_REQUEST['visit_date']) && !empty($_REQUEST['visit_date']) 
                ? trim($_REQUEST['visit_date']) 
                : (isset($_REQUEST['slot_date']) && !empty($_REQUEST['slot_date']) 
                    ? trim($_REQUEST['slot_date']) 
                    : date('Y-m-d')));

        $this->month = isset($_REQUEST['month']) ? trim($_REQUEST['month']) : '';
        $this->year = isset($_REQUEST['year']) ? trim($_REQUEST['year']) : '';
        $this->from_date = isset($_REQUEST['from_date']) ? trim($_REQUEST['from_date']) : '';
        $this->to_date = isset($_REQUEST['to_date']) ? trim($_REQUEST['to_date']) : '';

        // Entity IDs & fields
        $this->assignment_id = isset($_REQUEST['assignment_id']) ? (int)$_REQUEST['assignment_id'] : 0;
        $this->checklist_id = isset($_REQUEST['checklist_id']) ? (int)$_REQUEST['checklist_id'] : 0;
        $this->execution_id = isset($_REQUEST['execution_id']) ? (int)$_REQUEST['execution_id'] : 0;
        $this->slot = isset($_REQUEST['slot']) ? trim($_REQUEST['slot']) : (isset($_REQUEST['slot_name']) ? trim($_REQUEST['slot_name']) : (isset($_REQUEST['slot_time']) ? trim($_REQUEST['slot_time']) : ''));
        $this->remarks = isset($_REQUEST['remarks']) ? trim($_REQUEST['remarks']) : '';
        $this->status = isset($_REQUEST['status']) ? trim($_REQUEST['status']) : 'Completed';
        $this->points_json = isset($_REQUEST['points']) ? $_REQUEST['points'] : '';

        // Scanning & Geo-fence parameters
        $this->asset_code = isset($_REQUEST['asset_code']) ? trim($_REQUEST['asset_code']) : (isset($_REQUEST['asset_ref_no']) ? trim($_REQUEST['asset_ref_no']) : '');
        $this->janitor_lat = isset($_REQUEST['latitude']) ? trim($_REQUEST['latitude']) : (isset($_REQUEST['lat']) ? trim($_REQUEST['lat']) : (isset($_REQUEST['janitor_lat']) ? trim($_REQUEST['janitor_lat']) : ''));
        $this->janitor_lng = isset($_REQUEST['longitude']) ? trim($_REQUEST['longitude']) : (isset($_REQUEST['lng']) ? trim($_REQUEST['lng']) : (isset($_REQUEST['long']) ? trim($_REQUEST['long']) : (isset($_REQUEST['janitor_lng']) ? trim($_REQUEST['janitor_lng']) : '')));
        $this->allowed_radius = isset($_REQUEST['allowed_radius_meters']) ? (float)$_REQUEST['allowed_radius_meters'] : (isset($_REQUEST['allowed_radius']) ? (float)$_REQUEST['allowed_radius'] : 200.0);

        // If emp_id is not given but emp_code is given, resolve employee_id
        if ($this->emp_id <= 0 && !empty($this->emp_code)) {
            $safe_code = mysqli_real_escape_string($this->varDBConnection, $this->emp_code);
            $res = mysqli_query($this->varDBConnection, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$safe_code' LIMIT 1");
            if ($res && $row = mysqli_fetch_assoc($res)) {
                $this->emp_id = (int)$row['employee_id'];
            }
        }
    }

    function validateKey()
    {
        if (trim($this->api_key) != 'thcauthentication') {
            $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
            $this->myObj->error_code = '101';
            $this->myObj->status = 'Failed';
            $this->myObj->api_message = 'WRONG API KEY';
            return 'api_key_error';
        }
        return 'valid';
    }

    function validate()
    {
        if (trim($this->api_key) != 'thcauthentication') {
            $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
            $this->myObj->error_code = '101';
            $this->myObj->status = 'Failed';
            $this->myObj->api_message = 'WRONG API KEY';
            return 'api_key_error';
        }

        if (empty($this->emp_code) && $this->emp_id <= 0) {
            $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
            $this->myObj->error_code = '102';
            $this->myObj->status = 'Failed';
            $this->myObj->api_message = 'EMPLOYEE NOT FOUND';
            return 'emp_code_error';
        }

        return 'valid';
    }

    function RequestAccept($actionevents)
    {
        // 1. Validate API Key for all incoming actions
        if ($this->validateKey() === 'api_key_error') {
            echo json_encode($this->myObj);
            return;
        }

        switch ($actionevents) {
            // Profile / login
            case 'get_janitor_profile':
            case 'janitor_login':
            case 'getJanitorDetails':
                $this->getJanitorProfile();
                break;

            // Calendar dates marking endpoint (for highlighting scheduled dates with status & color badges)
            case 'get_schedule_dates':
            case 'get_calendar_dates':
            case 'get_janitor_calendar':
                if ($this->validate() === 'emp_code_error') {
                    echo json_encode($this->myObj);
                    return;
                }
                $this->getJanitorCalendarDates();
                break;

            // When user clicks a specific date on the calendar:
            // Lists all schedules for that date with asset, building, location, customer, checklist, and work status
            case 'get_schedules_by_date':
            case 'get_janitor_assignments':
            case 'get_date_slots':
                if ($this->validate() === 'emp_code_error') {
                    echo json_encode($this->myObj);
                    return;
                }
                $this->getJanitorAssignments();
                break;

            // Get detailed info for a single assignment
            case 'get_assignment_details':
                $this->getAssignmentDetails();
                break;

            // Get checklist items structured by category
            case 'get_checklist_items':
                $this->getChecklistItems();
                break;

            // Submit execution report with item points
            case 'submit_checklist_execution':
                if ($this->validate() === 'emp_code_error') {
                    echo json_encode($this->myObj);
                    return;
                }
                $this->submitChecklistExecution();
                break;

            // Get past execution history
            case 'get_execution_history':
                if ($this->validate() === 'emp_code_error') {
                    echo json_encode($this->myObj);
                    return;
                }
                $this->getExecutionHistory();
                break;

            // Get execution details by execution_id
            case 'get_execution_details':
                $this->getExecutionDetails();
                break;

            // Upload image file
            case 'upload_execution_photo':
                $this->uploadPhoto();
                break;

            // Scan physical asset code & verify janitor location against building coordinates
            // Auto log out if out of premises, or mark attendance and proceed if within premises
            case 'scan_asset':
            case 'scan_asset_location':
            case 'scan_asset_and_verify_location':
            case 'verify_location_and_scan':
                if ($this->validate() === 'emp_code_error') {
                    echo json_encode($this->myObj);
                    return;
                }
                $this->scanAssetAndVerifyLocation();
                break;

            // Janitor attendance records
            case 'get_janitor_attendance':
            case 'get_attendance_history':
                if ($this->validate() === 'emp_code_error') {
                    echo json_encode($this->myObj);
                    return;
                }
                $this->getJanitorAttendanceHistory();
                break;

            default:
                $this->myObj = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
                $this->myObj->error_code = '110';
                $this->myObj->status = 'Failed';
                $this->myObj->api_message = 'ACTION VALUE REQUIRED or NOT FOUND';
                echo json_encode($this->myObj);
                break;
        }
    }

    private function getJanitorProfile()
    {
        $where = "";
        if (!empty($this->emp_code)) {
            $safe_code = mysqli_real_escape_string($this->varDBConnection, $this->emp_code);
            $where = "employee_code = '$safe_code'";
        } else if ($this->emp_id > 0) {
            $where = "employee_id = " . $this->emp_id;
        } else {
            echo json_encode([
                "error_code" => "102",
                "status" => "Failed",
                "api_message" => "EMPLOYEE CODE OR ID REQUIRED"
            ]);
            return;
        }

        $sql = "SELECT employee_id, employee_code, employee_name, employee_contact_no, 
                       employee_email_id, employee_type_name, employee_status,
                       CONCAT('" . $this->domain_path . "images/employee_images/', employee_image) as employee_image
                FROM tbl_employees 
                WHERE $where AND employee_status = 'Active' LIMIT 1";

        $res = mysqli_query($this->varDBConnection, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode([
                "status" => "Success",
                "data" => $row
            ]);
        } else {
            echo json_encode([
                "error_code" => "200",
                "status" => "Failed",
                "api_message" => "JANITOR NOT FOUND OR INACTIVE"
            ]);
        }
    }

    /**
     * Calendar Dates Highlighting:
     * Returns all scheduled dates for the janitor within a month or date range,
     * along with work status (Completed, Partially Completed, Scheduled, Pending) and color codes.
     */
    private function getJanitorCalendarDates()
    {
        $emp_id_val = $this->emp_id;
        $today = date('Y-m-d');

        // Fetch active assignments for this janitor
        $sql = "SELECT id, start_date, end_date, frequency, slots 
                FROM tbl_janitor_assignments 
                WHERE status = 'Active' AND FIND_IN_SET('$emp_id_val', employee_id)";
        $res = mysqli_query($this->varDBConnection, $sql);

        $assignments = [];
        $min_assign_start = null;
        $max_assign_end = null;

        while ($row = mysqli_fetch_assoc($res)) {
            $assignments[] = $row;
            if (!empty($row['start_date']) && $row['start_date'] != '0000-00-00') {
                if ($min_assign_start === null || $row['start_date'] < $min_assign_start) {
                    $min_assign_start = $row['start_date'];
                }
            }
            if (!empty($row['end_date']) && $row['end_date'] != '0000-00-00') {
                if ($max_assign_end === null || $row['end_date'] > $max_assign_end) {
                    $max_assign_end = $row['end_date'];
                }
            }
        }

        // Determine date filter window
        $window_start = $this->from_date;
        $window_end = $this->to_date;

        if (empty($window_start)) {
            if (!empty($this->month)) {
                if (strpos($this->month, '-') !== false) {
                    $window_start = $this->month . '-01';
                    $window_end = date('Y-m-t', strtotime($window_start));
                } else {
                    $y = !empty($this->year) ? $this->year : date('Y');
                    $window_start = sprintf('%04d-%02d-01', $y, (int)$this->month);
                    $window_end = date('Y-m-t', strtotime($window_start));
                }
            } else {
                // If no filter given, cover active assignments range or default 30 days back to 90 days ahead
                $default_start = date('Y-m-01');
                $default_end = date('Y-m-d', strtotime('+90 days'));
                
                $window_start = ($min_assign_start && $min_assign_start < $default_start) ? $min_assign_start : $default_start;
                $window_end = ($max_assign_end && $max_assign_end > $default_end) ? $max_assign_end : $default_end;
            }
        }

        if (empty($window_end)) {
            $window_end = date('Y-m-d', strtotime('+90 days'));
        }

        // Also retrieve any dates with existing executions for this janitor
        $exec_dates_res = mysqli_query($this->varDBConnection, "SELECT DISTINCT executed_date FROM tbl_janitor_execution_log WHERE employee_id = $emp_id_val");
        $executed_dates = [];
        if ($exec_dates_res) {
            while ($erow = mysqli_fetch_assoc($exec_dates_res)) {
                $executed_dates[] = $erow['executed_date'];
            }
        }

        $dates_map = [];

        // Add execution dates that fall within the query window
        foreach ($executed_dates as $ed) {
            if ($ed >= $window_start && $ed <= $window_end) {
                $dates_map[$ed] = true;
            }
        }

        // Generate schedule dates from active assignments
        foreach ($assignments as $as) {
            $s_date = (!empty($as['start_date']) && $as['start_date'] != '0000-00-00') ? $as['start_date'] : $window_start;
            $e_date = (!empty($as['end_date']) && $as['end_date'] != '0000-00-00') ? $as['end_date'] : $window_end;

            $act_start = max(strtotime($s_date), strtotime($window_start));
            $act_end = min(strtotime($e_date), strtotime($window_end));

            if ($act_start > $act_end) continue;

            $cur = $act_start;
            $freq = strtolower(trim($as['frequency']));

            while ($cur <= $act_end) {
                $d_str = date('Y-m-d', $cur);

                if ($freq === 'weekly') {
                    if (date('w', $cur) === date('w', strtotime($s_date))) {
                        $dates_map[$d_str] = true;
                    }
                } else if ($freq === 'monthly') {
                    if (date('j', $cur) === date('j', strtotime($s_date))) {
                        $dates_map[$d_str] = true;
                    }
                } else {
                    // Daily or one-off
                    $dates_map[$d_str] = true;
                }
                $cur = strtotime('+1 day', $cur);
            }
        }

        ksort($dates_map);

        $result_dates = [];
        $marked_dates = [];

        // For each active date, calculate work status
        foreach (array_keys($dates_map) as $date_str) {
            $day_tasks = 0;
            $day_total_slots = 0;
            $day_completed_slots = 0;

            foreach ($assignments as $as) {
                $as_id = (int)$as['id'];
                $s_date = (!empty($as['start_date']) && $as['start_date'] != '0000-00-00') ? $as['start_date'] : $date_str;
                $e_date = (!empty($as['end_date']) && $as['end_date'] != '0000-00-00') ? $as['end_date'] : $date_str;

                if ($date_str >= $s_date && $date_str <= $e_date) {
                    $slots_arr = array_filter(array_map('trim', explode(',', $as['slots'])));
                    $slot_cnt = count($slots_arr) > 0 ? count($slots_arr) : 1;
                    $day_tasks++;
                    $day_total_slots += $slot_cnt;

                    // Query executed logs for this assignment on this date
                    $ex_q = mysqli_query($this->varDBConnection, "SELECT COUNT(*) as cnt FROM tbl_janitor_execution_log WHERE assignment_id = $as_id AND executed_date = '$date_str'");
                    if ($ex_q && $ex_row = mysqli_fetch_assoc($ex_q)) {
                        $day_completed_slots += (int)$ex_row['cnt'];
                    }
                }
            }

            // Determine status and calendar color badge
            if ($day_total_slots > 0 && $day_completed_slots >= $day_total_slots) {
                $status = 'Completed';
                $color = '#4CAF50'; // Green
            } else if ($day_completed_slots > 0) {
                $status = 'Partially Completed';
                $color = '#FF9800'; // Orange
            } else if ($date_str < $today) {
                $status = 'Pending';
                $color = '#F44336'; // Red
            } else {
                $status = 'Scheduled';
                $color = '#39C0ED'; // Sky Blue
            }

            $pending_slots = max(0, $day_total_slots - $day_completed_slots);

            $result_dates[] = [
                "visit_date" => $date_str, // Compatible with schedule_details_react.php
                "date" => $date_str,
                "status" => $status,
                "status_color" => $color,
                "total_tasks" => $day_tasks,
                "total_slots" => $day_total_slots,
                "completed_slots" => $day_completed_slots,
                "pending_slots" => $pending_slots,
                "is_fully_completed" => ($day_total_slots > 0 && $day_completed_slots >= $day_total_slots) ? "Yes" : "No"
            ];

            // Direct support for React Native Calendars markedDates
            $marked_dates[$date_str] = [
                "marked" => true,
                "dotColor" => $color,
                "activeColor" => $color,
                "selectedColor" => $color,
                "status" => $status
            ];
        }

        echo json_encode([
            "status" => "Success",
            "from_date" => $window_start,
            "to_date" => $window_end,
            "total_scheduled_dates" => count($result_dates),
            "data" => $result_dates,
            "marked_dates" => $marked_dates
        ]);
    }

    /**
     * Clicked Date Schedules:
     * When user clicks a particular date on the calendar, lists all schedules for that date
     * with respect to assets, buildings, locations, customer, checklist, and work status.
     */
    private function getJanitorAssignments()
    {
        $target_date = mysqli_real_escape_string($this->varDBConnection, $this->date);
        $emp_id_val = $this->emp_id;
        $today = date('Y-m-d');

        // Query assignments active on this target date for this employee
        $sql = "SELECT 
                    a.id as assignment_id,
                    a.assignment_ref_no,
                    a.checklist_id,
                    c.checklist_name,
                    a.customer_id,
                    cust.customer_name,
                    cust.customer_code,
                    a.location_id,
                    loc.location_name,
                    loc.location_code,
                    a.building_id,
                    loc.building_name,
                    loc.building_code,
                    loc.building_address,
                    COALESCE(NULLIF(b.latitude, ''), NULLIF(b_ast.latitude, ''), '') as latitude,
                    COALESCE(NULLIF(b.longitude, ''), NULLIF(b_ast.longitude, ''), '') as longitude,
                    COALESCE(NULLIF(b.latitude, ''), NULLIF(b_ast.latitude, ''), '') as building_latitude,
                    COALESCE(NULLIF(b.longitude, ''), NULLIF(b_ast.longitude, ''), '') as building_longitude,
                    loc.contact_person_name,
                    loc.contact_person_no,
                    a.asset_id,
                    ast.asset_ref_no,
                    ast.asset_description,
                    ast.asset_category_name,
                    ast.asset_type_name,
                    ast.asset_sp_des,
                    ast.zone_floor,
                    ast.flat_area_code,
                    ast.room_no,
                    ast.asset_status,
                    CONCAT('" . $this->domain_path . "images/amc_attachements/', ast.asset_attachment) as asset_attachment,
                    a.amc_ref_no,
                    a.frequency,
                    a.slots,
                    a.slots_detail,
                    a.start_date,
                    a.end_date,
                    a.status as assignment_status,
                    (SELECT COUNT(id) FROM tbl_janitor_checklist_categories WHERE checklist_id = a.checklist_id) as total_categories,
                    (SELECT COUNT(i.id) FROM tbl_janitor_checklist_items i JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id WHERE cat.checklist_id = a.checklist_id) as total_points
                FROM tbl_janitor_assignments a
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
                LEFT JOIN tbl_building b ON a.building_id = b.building_id
                LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
                LEFT JOIN tbl_building b_ast ON ast.building_id = b_ast.building_id
                LEFT JOIN (
                    SELECT customer_id, location_id, building_id, 
                           MAX(location_name) as location_name, 
                           MAX(location_code) as location_code, 
                           MAX(building_name) as building_name, 
                           MAX(building_code) as building_code, 
                           MAX(building_address) as building_address, 
                           MAX(contact_person_name) as contact_person_name, 
                           MAX(contact_person_no) as contact_person_no
                    FROM tbl_customer_location
                    GROUP BY customer_id, location_id, building_id
                ) loc ON (a.customer_id = loc.customer_id AND a.location_id = loc.location_id AND a.building_id = loc.building_id)
                WHERE a.status = 'Active'
                  AND FIND_IN_SET('$emp_id_val', a.employee_id)
                  AND (a.start_date IS NULL OR a.start_date <= '$target_date' OR a.start_date = '0000-00-00')
                  AND (a.end_date IS NULL OR a.end_date >= '$target_date' OR a.end_date = '0000-00-00')
                ORDER BY a.id DESC";

        $res = mysqli_query($this->varDBConnection, $sql);
        if (!$res || mysqli_num_rows($res) === 0) {
            echo json_encode([
                "error_code" => "200",
                "status" => "Failed",
                "api_message" => "NO SCHEDULES FOUND FOR DATE: " . $target_date,
                "date" => $target_date,
                "data" => []
            ]);
            return;
        }

        $assignments = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $assignment_id = (int)$row['assignment_id'];

            // Parse slots and determine execution status for today
            $slots_raw = $row['slots'];
            $slots_arr = array_filter(array_map('trim', explode(',', $slots_raw)));
            if (empty($slots_arr)) {
                $slots_arr = ['Standard Slot'];
            }

            // Map slots_detail if available
            $slots_detail_map = [];
            if (!empty($row['slots_detail'])) {
                $decoded_slots = json_decode($row['slots_detail'], true);
                if (is_array($decoded_slots)) {
                    foreach ($decoded_slots as $sd) {
                        if (isset($sd['name'])) {
                            $slots_detail_map[$sd['name']] = $sd;
                        }
                    }
                }
            }
            
            // Query executed logs for this assignment on this target date
            $exec_sql = "SELECT id, executed_slot, status, remarks, created_at 
                         FROM tbl_janitor_execution_log 
                         WHERE assignment_id = $assignment_id AND executed_date = '$target_date'";
            $exec_res = mysqli_query($this->varDBConnection, $exec_sql);
            $executed_slots = [];
            $execution_logs = [];

            if ($exec_res) {
                while ($exec_row = mysqli_fetch_assoc($exec_res)) {
                    $executed_slots[$exec_row['executed_slot']] = $exec_row;
                    $execution_logs[] = $exec_row;
                }
            }

            // Build detailed slot breakdown
            $slot_details = [];
            foreach ($slots_arr as $slot_item) {
                $is_executed = isset($executed_slots[$slot_item]);
                $s_start = isset($slots_detail_map[$slot_item]['start_time']) ? (string)$slots_detail_map[$slot_item]['start_time'] : '0';
                $s_end = isset($slots_detail_map[$slot_item]['end_time']) ? (string)$slots_detail_map[$slot_item]['end_time'] : '0';
                $has_time_rule = ($s_start !== '0' && $s_start !== '' && $s_end !== '0' && $s_end !== '');
                $time_rule = $has_time_rule ? ($s_start . ' - ' . $s_end) : 'No Rule';

                $slot_details[] = [
                    "slot_name" => $slot_item,
                    "slot_time" => $slot_item,
                    "start_time" => $s_start,
                    "end_time" => $s_end,
                    "has_time_rule" => $has_time_rule,
                    "time_rule" => $time_rule,
                    "is_completed" => $is_executed ? "Yes" : "No",
                    "execution_id" => $is_executed ? (int)$executed_slots[$slot_item]['id'] : null,
                    "execution_status" => $is_executed ? $executed_slots[$slot_item]['status'] : "Pending",
                    "remarks" => $is_executed ? $executed_slots[$slot_item]['remarks'] : "",
                    "executed_at" => $is_executed ? $executed_slots[$slot_item]['created_at'] : null
                ];
            }

            $total_slots = count($slots_arr);
            $completed_slots = count($executed_slots);
            $pending_slots = max(0, $total_slots - $completed_slots);

            // Calculate overall work status for this schedule on this date
            if ($total_slots > 0 && $completed_slots >= $total_slots) {
                $work_status = 'Completed';
                $work_status_color = '#4CAF50'; // Green
            } else if ($completed_slots > 0) {
                $work_status = 'Partially Completed';
                $work_status_color = '#FF9800'; // Orange
            } else if ($target_date < $today) {
                $work_status = 'Pending';
                $work_status_color = '#F44336'; // Red
            } else {
                $work_status = 'Scheduled';
                $work_status_color = '#39C0ED'; // Sky Blue
            }

            // Attach computed attributes
            $row['work_status'] = $work_status;
            $row['work_status_color'] = $work_status_color;
            $row['total_slots'] = $total_slots;
            $row['completed_slots'] = $completed_slots;
            $row['pending_slots'] = $pending_slots;
            $row['is_fully_completed'] = ($total_slots > 0 && $completed_slots >= $total_slots) ? "Yes" : "No";
            $row['slots_list'] = $slot_details;
            $row['execution_logs'] = $execution_logs;

            $assignments[] = $row;
        }

        echo json_encode([
            "status" => "Success",
            "date" => $target_date,
            "total_schedules" => count($assignments),
            "data" => $assignments
        ]);
    }

    private function getAssignmentDetails()
    {
        if ($this->assignment_id <= 0) {
            echo json_encode([
                "error_code" => "105",
                "status" => "Failed",
                "api_message" => "ASSIGNMENT ID IS REQUIRED"
            ]);
            return;
        }

        $as_id = $this->assignment_id;
        $sql = "SELECT 
                    a.*,
                    c.checklist_name,
                    cust.customer_name,
                    cust.customer_code,
                    loc.location_name,
                    loc.location_code,
                    loc.building_name,
                    loc.building_code,
                    loc.building_address,
                    COALESCE(NULLIF(b.latitude, ''), NULLIF(b_ast.latitude, ''), '') as latitude,
                    COALESCE(NULLIF(b.longitude, ''), NULLIF(b_ast.longitude, ''), '') as longitude,
                    COALESCE(NULLIF(b.latitude, ''), NULLIF(b_ast.latitude, ''), '') as building_latitude,
                    COALESCE(NULLIF(b.longitude, ''), NULLIF(b_ast.longitude, ''), '') as building_longitude,
                    loc.contact_person_name,
                    loc.contact_person_no,
                    ast.asset_ref_no,
                    ast.asset_description,
                    ast.asset_category_name,
                    ast.asset_type_name,
                    ast.asset_sp_des,
                    ast.zone_floor,
                    ast.flat_area_code,
                    ast.room_no,
                    ast.asset_status,
                    CONCAT('" . $this->domain_path . "images/amc_attachements/', ast.asset_attachment) as asset_attachment
                FROM tbl_janitor_assignments a
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
                LEFT JOIN tbl_building b ON a.building_id = b.building_id
                LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
                LEFT JOIN tbl_building b_ast ON ast.building_id = b_ast.building_id
                LEFT JOIN (
                    SELECT customer_id, location_id, building_id, 
                           MAX(location_name) as location_name, 
                           MAX(location_code) as location_code, 
                           MAX(building_name) as building_name, 
                           MAX(building_code) as building_code, 
                           MAX(building_address) as building_address, 
                           MAX(contact_person_name) as contact_person_name, 
                           MAX(contact_person_no) as contact_person_no
                    FROM tbl_customer_location
                    GROUP BY customer_id, location_id, building_id
                ) loc ON (a.customer_id = loc.customer_id AND a.location_id = loc.location_id AND a.building_id = loc.building_id)
                WHERE a.id = $as_id LIMIT 1";

        $res = mysqli_query($this->varDBConnection, $sql);
        if ($res && $row = mysqli_fetch_assoc($res)) {
            $chk_id = (int)$row['checklist_id'];
            $categories = $this->fetchChecklistHierarchy($chk_id);
            $row['checklist_categories'] = $categories;

            echo json_encode([
                "status" => "Success",
                "data" => $row
            ]);
        } else {
            echo json_encode([
                "error_code" => "200",
                "status" => "Failed",
                "api_message" => "ASSIGNMENT NOT FOUND"
            ]);
        }
    }

    private function getChecklistItems()
    {
        $chk_id = $this->checklist_id;

        // If checklist_id not given directly, check if assignment_id was provided
        if ($chk_id <= 0 && $this->assignment_id > 0) {
            $as_res = mysqli_query($this->varDBConnection, "SELECT checklist_id FROM tbl_janitor_assignments WHERE id = " . $this->assignment_id);
            if ($as_res && $as_row = mysqli_fetch_assoc($as_res)) {
                $chk_id = (int)$as_row['checklist_id'];
            }
        }

        if ($chk_id <= 0) {
            echo json_encode([
                "error_code" => "106",
                "status" => "Failed",
                "api_message" => "CHECKLIST ID OR ASSIGNMENT ID IS REQUIRED"
            ]);
            return;
        }

        $chk_info = null;
        $chk_res = mysqli_query($this->varDBConnection, "SELECT id, checklist_name, status FROM tbl_janitor_checklists WHERE id = $chk_id");
        if ($chk_res && $row = mysqli_fetch_assoc($chk_res)) {
            $chk_info = $row;
        }

        $categories = $this->fetchChecklistHierarchy($chk_id);

        echo json_encode([
            "status" => "Success",
            "checklist" => $chk_info,
            "data" => $categories
        ]);
    }

    private function fetchChecklistHierarchy($checklist_id)
    {
        $categories = [];
        $cat_sql = "SELECT id as category_id, category_name 
                    FROM tbl_janitor_checklist_categories 
                    WHERE checklist_id = $checklist_id 
                    ORDER BY id ASC";
        $cat_res = mysqli_query($this->varDBConnection, $cat_sql);

        if ($cat_res) {
            while ($cat_row = mysqli_fetch_assoc($cat_res)) {
                $cat_id = (int)$cat_row['category_id'];
                
                $points = [];
                $pt_sql = "SELECT id as item_id, item_description, status 
                           FROM tbl_janitor_checklist_items 
                           WHERE checklist_category_id = $cat_id AND status = 'Active' 
                           ORDER BY id ASC";
                $pt_res = mysqli_query($this->varDBConnection, $pt_sql);
                if ($pt_res) {
                    while ($pt_row = mysqli_fetch_assoc($pt_res)) {
                        $points[] = $pt_row;
                    }
                }
                $cat_row['items'] = $points;
                $categories[] = $cat_row;
            }
        }
        return $categories;
    }

    private function submitChecklistExecution()
    {
        if ($this->assignment_id <= 0) {
            echo json_encode([
                "error_code" => "105",
                "status" => "Failed",
                "api_message" => "ASSIGNMENT ID IS REQUIRED"
            ]);
            return;
        }

        if (empty($this->slot)) {
            echo json_encode([
                "error_code" => "107",
                "status" => "Failed",
                "api_message" => "EXECUTED SLOT TIME IS REQUIRED"
            ]);
            return;
        }

        // Fetch assignment details
        $as_res = mysqli_query($this->varDBConnection, "SELECT asset_id, amc_ref_no FROM tbl_janitor_assignments WHERE id = " . $this->assignment_id);
        if (!$as_res || mysqli_num_rows($as_res) === 0) {
            echo json_encode([
                "error_code" => "200",
                "status" => "Failed",
                "api_message" => "INVALID ASSIGNMENT ID"
            ]);
            return;
        }
        $as_row = mysqli_fetch_assoc($as_res);
        $asset_id = (int)$as_row['asset_id'];
        $amc_ref_no = mysqli_real_escape_string($this->varDBConnection, $as_row['amc_ref_no']);

        $executed_date = mysqli_real_escape_string($this->varDBConnection, $this->date);
        $executed_slot = mysqli_real_escape_string($this->varDBConnection, $this->slot);
        $status = mysqli_real_escape_string($this->varDBConnection, $this->status);
        $remarks = mysqli_real_escape_string($this->varDBConnection, $this->remarks);
        $employee_id = $this->emp_id;

        mysqli_autocommit($this->varDBConnection, FALSE);

        try {
            // Check if record already exists for this assignment, slot and date
            $check_res = mysqli_query($this->varDBConnection, "SELECT id FROM tbl_janitor_execution_log WHERE assignment_id = " . $this->assignment_id . " AND executed_date = '$executed_date' AND executed_slot = '$executed_slot' LIMIT 1");
            
            if ($check_res && $check_row = mysqli_fetch_assoc($check_res)) {
                $execution_id = (int)$check_row['id'];
                // Update header
                $upd_sql = "UPDATE tbl_janitor_execution_log SET 
                                employee_id = $employee_id, 
                                status = '$status', 
                                remarks = '$remarks',
                                created_at = '" . $this->createddatetime . "'
                            WHERE id = $execution_id";
                if (!mysqli_query($this->varDBConnection, $upd_sql)) {
                    throw new Exception(mysqli_error($this->varDBConnection));
                }
                // Clear existing points
                mysqli_query($this->varDBConnection, "DELETE FROM tbl_janitor_execution_points WHERE execution_id = $execution_id");
            } else {
                // Insert new execution header
                $ins_sql = "INSERT INTO tbl_janitor_execution_log 
                            (assignment_id, employee_id, asset_id, amc_ref_no, executed_date, executed_slot, status, remarks, created_at)
                            VALUES (" . $this->assignment_id . ", $employee_id, $asset_id, '$amc_ref_no', '$executed_date', '$executed_slot', '$status', '$remarks', '" . $this->createddatetime . "')";
                if (!mysqli_query($this->varDBConnection, $ins_sql)) {
                    throw new Exception(mysqli_error($this->varDBConnection));
                }
                $execution_id = mysqli_insert_id($this->varDBConnection);
            }

            // Insert line items
            $points_array = [];
            if (is_array($this->points_json)) {
                $points_array = $this->points_json;
            } else if (!empty($this->points_json)) {
                $decoded = json_decode($this->points_json, true);
                if (is_array($decoded)) {
                    $points_array = $decoded;
                }
            }

            if (!empty($points_array)) {
                foreach ($points_array as $pt) {
                    $item_id = isset($pt['item_id']) ? (int)$pt['item_id'] : (isset($pt['checklist_item_id']) ? (int)$pt['checklist_item_id'] : 0);
                    $is_comp = isset($pt['is_completed']) ? mysqli_real_escape_string($this->varDBConnection, $pt['is_completed']) : 'Yes';
                    $pt_rem = isset($pt['remarks']) ? mysqli_real_escape_string($this->varDBConnection, $pt['remarks']) : '';
                    $photo = isset($pt['photo_url']) ? mysqli_real_escape_string($this->varDBConnection, $pt['photo_url']) : '';

                    if ($item_id > 0) {
                        $pt_sql = "INSERT INTO tbl_janitor_execution_points 
                                   (execution_id, checklist_item_id, is_completed, remarks, photo_url)
                                   VALUES ($execution_id, $item_id, '$is_comp', '$pt_rem', '$photo')";
                        if (!mysqli_query($this->varDBConnection, $pt_sql)) {
                            throw new Exception(mysqli_error($this->varDBConnection));
                        }
                    }
                }
            }

            mysqli_commit($this->varDBConnection);

            echo json_encode([
                "status" => "Success",
                "api_message" => "Execution submitted successfully",
                "execution_id" => $execution_id
            ]);

        } catch (Exception $e) {
            mysqli_rollback($this->varDBConnection);
            echo json_encode([
                "error_code" => "500",
                "status" => "Failed",
                "api_message" => $e->getMessage()
            ]);
        }
    }

    private function getExecutionHistory()
    {
        $emp_id_val = $this->emp_id;
        $where_clauses = ["l.employee_id = $emp_id_val"];

        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) {
            $f_date = mysqli_real_escape_string($this->varDBConnection, $_REQUEST['from_date']);
            $where_clauses[] = "l.executed_date >= '$f_date'";
        }
        if (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) {
            $t_date = mysqli_real_escape_string($this->varDBConnection, $_REQUEST['to_date']);
            $where_clauses[] = "l.executed_date <= '$t_date'";
        }

        $where_sql = implode(" AND ", $where_clauses);

        $sql = "SELECT 
                    l.id as execution_id,
                    l.assignment_id,
                    a.assignment_ref_no,
                    c.checklist_name,
                    ast.asset_ref_no,
                    ast.asset_description,
                    cust.customer_name,
                    loc.building_name,
                    loc.location_name,
                    l.executed_date,
                    l.executed_slot,
                    l.status,
                    l.remarks,
                    l.created_at,
                    (SELECT COUNT(ep.id) FROM tbl_janitor_execution_points ep WHERE ep.execution_id = l.id) as total_points,
                    (SELECT COUNT(ep.id) FROM tbl_janitor_execution_points ep WHERE ep.execution_id = l.id AND ep.is_completed = 'Yes') as completed_points
                FROM tbl_janitor_execution_log l
                LEFT JOIN tbl_janitor_assignments a ON l.assignment_id = a.id
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_assets ast ON l.asset_id = ast.asset_id
                LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
                LEFT JOIN (
                    SELECT customer_id, location_id, building_id, 
                           MAX(location_name) as location_name, 
                           MAX(building_name) as building_name 
                    FROM tbl_customer_location 
                    GROUP BY customer_id, location_id, building_id
                ) loc ON (a.customer_id = loc.customer_id AND a.location_id = loc.location_id AND a.building_id = loc.building_id)
                WHERE $where_sql
                ORDER BY l.executed_date DESC, l.id DESC
                LIMIT 50";

        $res = mysqli_query($this->varDBConnection, $sql);
        $data = [];
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
        }

        echo json_encode([
            "status" => "Success",
            "data" => $data
        ]);
    }

    private function getExecutionDetails()
    {
        if ($this->execution_id <= 0) {
            echo json_encode([
                "error_code" => "108",
                "status" => "Failed",
                "api_message" => "EXECUTION ID IS REQUIRED"
            ]);
            return;
        }

        $ex_id = $this->execution_id;
        $sql = "SELECT l.*, a.assignment_ref_no, c.checklist_name, ast.asset_ref_no, ast.asset_description,
                       cust.customer_name, loc.building_name, loc.location_name
                FROM tbl_janitor_execution_log l
                LEFT JOIN tbl_janitor_assignments a ON l.assignment_id = a.id
                LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                LEFT JOIN tbl_assets ast ON l.asset_id = ast.asset_id
                LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
                LEFT JOIN (
                    SELECT customer_id, location_id, building_id, 
                           MAX(location_name) as location_name, 
                           MAX(building_name) as building_name 
                    FROM tbl_customer_location 
                    GROUP BY customer_id, location_id, building_id
                ) loc ON (a.customer_id = loc.customer_id AND a.location_id = loc.location_id AND a.building_id = loc.building_id)
                WHERE l.id = $ex_id LIMIT 1";

        $res = mysqli_query($this->varDBConnection, $sql);
        if (!$res || mysqli_num_rows($res) === 0) {
            echo json_encode([
                "error_code" => "200",
                "status" => "Failed",
                "api_message" => "EXECUTION NOT FOUND"
            ]);
            return;
        }

        $header = mysqli_fetch_assoc($res);

        // Fetch execution points
        $pt_sql = "SELECT ep.*, i.item_description, cat.category_name
                   FROM tbl_janitor_execution_points ep
                   LEFT JOIN tbl_janitor_checklist_items i ON ep.checklist_item_id = i.id
                   LEFT JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id
                   WHERE ep.execution_id = $ex_id
                   ORDER BY cat.id ASC, i.id ASC";
        $pt_res = mysqli_query($this->varDBConnection, $pt_sql);
        $points = [];
        if ($pt_res) {
            while ($pt_row = mysqli_fetch_assoc($pt_res)) {
                $points[] = $pt_row;
            }
        }

        $header['points'] = $points;

        echo json_encode([
            "status" => "Success",
            "data" => $header
        ]);
    }

    private function uploadPhoto()
    {
        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0777, true);
        }

        $filename = '';

        // Option A: Multipart file upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            if (empty($ext)) $ext = 'jpg';
            $filename = 'jan_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
            $target = $this->upload_dir . $filename;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                $url = $this->domain_path . 'images/janitor_execution/' . $filename;
                echo json_encode(["status" => "Success", "photo_url" => $url, "filename" => $filename]);
                return;
            }
        }

        // Option B: Base64 string
        if (isset($_REQUEST['photo_base64']) && !empty($_REQUEST['photo_base64'])) {
            $base64_str = $_REQUEST['photo_base64'];
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_str, $type)) {
                $base64_str = substr($base64_str, strpos($base64_str, ',') + 1);
                $ext = strtolower($type[1]);
            } else {
                $ext = 'jpg';
            }
            $data = base64_decode($base64_str);
            if ($data !== false) {
                $filename = 'jan_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                $target = $this->upload_dir . $filename;
                file_put_contents($target, $data);
                $url = $this->domain_path . 'images/janitor_execution/' . $filename;
                echo json_encode(["status" => "Success", "photo_url" => $url, "filename" => $filename]);
                return;
            }
        }

        echo json_encode([
            "error_code" => "109",
            "status" => "Failed",
            "api_message" => "PHOTO UPLOAD FAILED OR NO PHOTO PROVIDED"
        ]);
    }

    /**
     * Scan physical asset code & verify janitor location against building coordinates.
     * Rule:
     * - If janitor location and building location mismatch (> allowed_radius, e.g. 200m):
     *   Logs violation, rejects scan, instructs mobile app to auto logout, and blocks access.
     * - If location matches (within premises):
     *   Marks attendance for janitor as 'Present' with timestamp and allows janitor to proceed.
     */
    private function scanAssetAndVerifyLocation()
    {
        if (empty($this->asset_code)) {
            echo json_encode([
                "error_code" => "109",
                "status" => "Failed",
                "rule_status" => "FAILED",
                "api_message" => "ASSET CODE IS REQUIRED FOR SCANNING",
                "auto_logout" => false,
                "can_proceed" => false
            ]);
            return;
        }

        $safe_asset_code = mysqli_real_escape_string($this->varDBConnection, $this->asset_code);
        $emp_id_val = $this->emp_id;
        $today = date('Y-m-d');
        $time = date('H:i:s');

        // Look up asset and its building coordinates
        $asset_sql = "SELECT 
                        ast.asset_id, ast.asset_ref_no, ast.asset_description, ast.asset_category_name, ast.asset_type_name,
                        ast.zone_floor, ast.flat_area_code, ast.room_no, ast.asset_status, ast.building_id, ast.asset_building,
                        ast.location_id, ast.asset_location, ast.customer_id,
                        b.building_name, b.building_code, b.building_address, b.latitude as bld_lat, b.longitude as bld_lng,
                        loc.location_name
                      FROM tbl_assets ast
                      LEFT JOIN tbl_building b ON ast.building_id = b.building_id
                      LEFT JOIN (
                          SELECT customer_id, location_id, building_id, MAX(location_name) as location_name 
                          FROM tbl_customer_location GROUP BY customer_id, location_id, building_id
                      ) loc ON (ast.customer_id = loc.customer_id AND ast.location_id = loc.location_id AND ast.building_id = loc.building_id)
                      WHERE ast.asset_ref_no = '$safe_asset_code' OR ast.asset_id = '$safe_asset_code'
                      LIMIT 1";

        $asset_res = mysqli_query($this->varDBConnection, $asset_sql);
        if (!$asset_res || mysqli_num_rows($asset_res) === 0) {
            echo json_encode([
                "error_code" => "201",
                "status" => "Failed",
                "rule_status" => "FAILED",
                "api_message" => "INVALID ASSET: Scanned asset '$safe_asset_code' was not found in the system.",
                "auto_logout" => false,
                "can_proceed" => false
            ]);
            return;
        }

        $asset_row = mysqli_fetch_assoc($asset_res);
        $asset_id = (int)$asset_row['asset_id'];
        $asset_ref_no = $asset_row['asset_ref_no'];

        // Look up assignment for this janitor
        $assign_sql = "SELECT a.id as assignment_id, a.checklist_id, c.checklist_name, a.frequency, a.slots, a.slots_detail,
                              b.latitude as assign_bld_lat, b.longitude as assign_bld_lng, b.building_name as assign_bld_name,
                              loc.location_name as assign_loc_name
                       FROM tbl_janitor_assignments a
                       LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                       LEFT JOIN tbl_building b ON a.building_id = b.building_id
                       LEFT JOIN (
                           SELECT customer_id, location_id, building_id, MAX(location_name) as location_name 
                           FROM tbl_customer_location GROUP BY customer_id, location_id, building_id
                       ) loc ON (a.customer_id = loc.customer_id AND a.location_id = loc.location_id AND a.building_id = loc.building_id)
                       WHERE a.status = 'Active' 
                         AND FIND_IN_SET('$emp_id_val', a.employee_id)
                         AND a.asset_id = $asset_id
                       ORDER BY a.id DESC LIMIT 1";

        $assign_res = mysqli_query($this->varDBConnection, $assign_sql);
        $assign_row = ($assign_res && mysqli_num_rows($assign_res) > 0) ? mysqli_fetch_assoc($assign_res) : null;

        // Determine building coordinates
        $bld_lat = !empty($asset_row['bld_lat']) ? trim($asset_row['bld_lat']) : (!empty($assign_row['assign_bld_lat']) ? trim($assign_row['assign_bld_lat']) : '');
        $bld_lng = !empty($asset_row['bld_lng']) ? trim($asset_row['bld_lng']) : (!empty($assign_row['assign_bld_lng']) ? trim($assign_row['assign_bld_lng']) : '');

        $building_id = !empty($asset_row['building_id']) ? (int)$asset_row['building_id'] : (isset($assign_row['building_id']) ? (int)$assign_row['building_id'] : 0);
        $building_name = !empty($asset_row['building_name']) ? $asset_row['building_name'] : (!empty($assign_row['assign_bld_name']) ? $assign_row['assign_bld_name'] : $asset_row['asset_building']);
        $location_name = !empty($asset_row['location_name']) ? $asset_row['location_name'] : (!empty($assign_row['assign_loc_name']) ? $assign_row['assign_loc_name'] : $asset_row['asset_location']);

        $has_building_coords = (!empty($bld_lat) && !empty($bld_lng) && is_numeric($bld_lat) && is_numeric($bld_lng) && (float)$bld_lat != 0);
        $has_janitor_coords = (!empty($this->janitor_lat) && !empty($this->janitor_lng) && is_numeric($this->janitor_lat) && is_numeric($this->janitor_lng));

        // If building coordinates are set, janitor MUST provide device GPS
        if ($has_building_coords && !$has_janitor_coords) {
            echo json_encode([
                "error_code" => "400",
                "status" => "Failed",
                "rule_status" => "GPS_REQUIRED",
                "api_message" => "DEVICE LOCATION REQUIRED: Please enable GPS/location services on your device to verify your presence at the building premises.",
                "auto_logout" => false,
                "can_proceed" => false
            ]);
            return;
        }

        $distance = 0.0;
        if ($has_building_coords && $has_janitor_coords) {
            $distance = $this->haversineDistance((float)$this->janitor_lat, (float)$this->janitor_lng, (float)$bld_lat, (float)$bld_lng);
        }

        $safe_bld_name = mysqli_real_escape_string($this->varDBConnection, $building_name);
        $safe_asset_ref = mysqli_real_escape_string($this->varDBConnection, $asset_ref_no);
        $safe_emp_code = mysqli_real_escape_string($this->varDBConnection, $this->emp_code);
        $assign_id_val = $assign_row ? (int)$assign_row['assignment_id'] : 0;

        // RULE CHECK: If building coordinates exist and distance is greater than allowed radius
        if ($has_building_coords && $distance > $this->allowed_radius) {
            // Log security mismatch in tbl_janitor_attendance
            $ins_mismatch = "INSERT INTO tbl_janitor_attendance 
                (employee_id, employee_code, assignment_id, asset_id, asset_code, building_id, building_name, janitor_lat, janitor_lng, building_lat, building_lng, distance_meters, attendance_date, attendance_time, attendance_status, scan_status, created_at)
                VALUES ($emp_id_val, '$safe_emp_code', $assign_id_val, $asset_id, '$safe_asset_ref', $building_id, '$safe_bld_name', '{$this->janitor_lat}', '{$this->janitor_lng}', '$bld_lat', '$bld_lng', $distance, '$today', '$time', 'Mismatch', 'Rejected', '{$this->createddatetime}')";
            mysqli_query($this->varDBConnection, $ins_mismatch);

            echo json_encode([
                "status" => "Failed",
                "error_code" => "403",
                "rule_status" => "FAILED",
                "api_message" => "LOCATION MISMATCH: Your location is " . number_format($distance, 1) . "m away from the assigned building '$building_name' (allowed limit: " . $this->allowed_radius . "m). You cannot proceed from a different location and will be logged out.",
                "action_required" => "auto_logout",
                "auto_logout" => true,
                "can_proceed" => false,
                "distance_meters" => $distance,
                "allowed_radius_meters" => $this->allowed_radius,
                "building_name" => $building_name,
                "asset_ref_no" => $asset_ref_no,
                "janitor_coordinates" => [
                    "latitude" => (float)$this->janitor_lat,
                    "longitude" => (float)$this->janitor_lng
                ],
                "building_coordinates" => [
                    "latitude" => (float)$bld_lat,
                    "longitude" => (float)$bld_lng
                ]
            ]);
            return;
        }

        // RULE MATCHED: Janitor is in premises (or building coordinates not yet configured)
        // Mark attendance as Present
        $scan_status = $has_building_coords ? 'Verified' : 'Verified (Coords Pending)';
        $ins_attend = "INSERT INTO tbl_janitor_attendance 
            (employee_id, employee_code, assignment_id, asset_id, asset_code, building_id, building_name, janitor_lat, janitor_lng, building_lat, building_lng, distance_meters, attendance_date, attendance_time, attendance_status, scan_status, created_at)
            VALUES ($emp_id_val, '$safe_emp_code', $assign_id_val, $asset_id, '$safe_asset_ref', $building_id, '$safe_bld_name', '{$this->janitor_lat}', '{$this->janitor_lng}', '$bld_lat', '$bld_lng', $distance, '$today', '$time', 'Present', '$scan_status', '{$this->createddatetime}')";
        mysqli_query($this->varDBConnection, $ins_attend);
        $attendance_id = mysqli_insert_id($this->varDBConnection);

        echo json_encode([
            "status" => "Success",
            "rule_status" => "MATCHED",
            "attendance_marked" => "Yes",
            "can_proceed" => true,
            "auto_logout" => false,
            "api_message" => "Location verified successfully! Attendance marked as Present. You may now proceed with cleaning.",
            "distance_meters" => $distance,
            "allowed_radius_meters" => $this->allowed_radius,
            "attendance" => [
                "attendance_id" => $attendance_id,
                "attendance_date" => $today,
                "attendance_time" => $time,
                "attendance_status" => "Present",
                "scan_status" => $scan_status
            ],
            "asset" => [
                "asset_id" => $asset_id,
                "asset_ref_no" => $asset_row['asset_ref_no'],
                "asset_description" => $asset_row['asset_description'],
                "asset_category_name" => $asset_row['asset_category_name'],
                "asset_type_name" => $asset_row['asset_type_name'],
                "zone_floor" => $asset_row['zone_floor'],
                "flat_area_code" => $asset_row['flat_area_code'],
                "room_no" => $asset_row['room_no'],
                "building_id" => $building_id,
                "building_name" => $building_name,
                "location_name" => $location_name
            ],
            "assignment" => $assign_row ? [
                "assignment_id" => (int)$assign_row['assignment_id'],
                "checklist_id" => (int)$assign_row['checklist_id'],
                "checklist_name" => $assign_row['checklist_name'],
                "slots" => $assign_row['slots'],
                "slots_detail" => !empty($assign_row['slots_detail']) ? json_decode($assign_row['slots_detail'], true) : [],
                "frequency" => $assign_row['frequency']
            ] : null
        ]);
    }

    /**
     * Haversine formula to compute great-circle distance between two GPS coordinates in meters
     */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // in meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }

    /**
     * Fetch attendance records for the janitor
     */
    private function getJanitorAttendanceHistory()
    {
        $emp_id_val = $this->emp_id;
        $where = "employee_id = $emp_id_val";

        if (!empty($this->from_date)) {
            $f_date = mysqli_real_escape_string($this->varDBConnection, $this->from_date);
            $where .= " AND attendance_date >= '$f_date'";
        }
        if (!empty($this->to_date)) {
            $t_date = mysqli_real_escape_string($this->varDBConnection, $this->to_date);
            $where .= " AND attendance_date <= '$t_date'";
        }

        $sql = "SELECT * FROM tbl_janitor_attendance WHERE $where ORDER BY attendance_date DESC, id DESC LIMIT 50";
        $res = mysqli_query($this->varDBConnection, $sql);
        $data = [];
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
        }

        echo json_encode([
            "status" => "Success",
            "total_records" => count($data),
            "data" => $data
        ]);
    }
}
}

// Execute controller if invoked directly or included
$obj = new janitorApiController();
$obj->RequestAccept($obj->actionevents);
?>
