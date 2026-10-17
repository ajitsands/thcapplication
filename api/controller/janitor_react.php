<?php
/**
 * THC-FM Janitor Mobile Application API Controller
 * Supports React Native / Mobile endpoints as documented in JANITOR_MOBILE_API_DOCUMENTATION.md
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once(__DIR__ . '/../../model/db_connection/connection.php');
require_once(__DIR__ . '/../../view/template/includes/en_de_header.inc');

$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (!$conn) {
    echo json_encode(["status" => "Failed", "error_code" => "500", "api_message" => "Database connection failed"]);
    exit;
}

date_default_timezone_set("Asia/Bahrain");

// Helper: Haversine Distance in meters
function haversineDistanceMeters($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371000; // in meters
    $latFrom = deg2rad((float)$lat1);
    $lonFrom = deg2rad((float)$lon1);
    $latTo = deg2rad((float)$lat2);
    $lonTo = deg2rad((float)$lon2);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    return round($angle * $earthRadius, 2);
}

// 1. Authenticate APIKEY
$OBJ = new URLEncription();
$raw_key = $_REQUEST['APIKEY'] ?? '';
$decoded_key = $OBJ->KEYDecode(trim($raw_key));

if (trim($decoded_key) !== 'thcauthentication') {
    echo json_encode(["status" => "Failed", "error_code" => "101", "api_message" => "WRONG API KEY"]);
    exit;
}

// 2. Fetch Active Settings from tbl_janitor_settings
$min_radius_setting = 200.0;
$late_time_setting = 15;
$allow_gps_bypass_setting = 'NO';

$res_set = mysqli_query($conn, "SELECT min_radius_meters, late_time_minutes, allow_gps_bypass FROM tbl_janitor_settings ORDER BY id ASC LIMIT 1");
if ($res_set && mysqli_num_rows($res_set) > 0) {
    $set_row = mysqli_fetch_assoc($res_set);
    $min_radius_setting = (float)$set_row['min_radius_meters'];
    $late_time_setting = (int)$set_row['late_time_minutes'];
    $allow_gps_bypass_setting = strtoupper($set_row['allow_gps_bypass'] ?? 'NO');
}

$action = $_REQUEST['action'] ?? '';

// =========================================================================
// ACTION 0: get_janitor_settings
// =========================================================================
if ($action === 'get_janitor_settings' || $action === 'get_settings') {
    echo json_encode([
        "status" => "Success",
        "settings" => [
            "min_radius_meters" => (float)$min_radius_setting,
            "late_time_minutes" => (int)$late_time_setting,
            "allow_gps_bypass" => $allow_gps_bypass_setting
        ]
    ]);
    exit;
}
if ($action === 'janitor_login' || $action === 'get_janitor_profile') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    if (empty($emp_code)) {
        echo json_encode(["status" => "Failed", "error_code" => "102", "api_message" => "EMPLOYEE NOT FOUND"]);
        exit;
    }

    $sql = "SELECT e.employee_id, e.employee_code, e.employee_name, e.employee_contact_no, 
                   e.employee_email_id, e.employee_type, e.employee_status, e.employee_image
            FROM tbl_employees e
            WHERE e.employee_code = '$emp_code' AND e.employee_status != 'Deleted' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $emp_type_name = 'Janitor';
        if (!empty($row['employee_type'])) {
            $t_res = mysqli_query($conn, "SELECT employee_type FROM tbl_employee_type WHERE employee_type_id = " . (int)$row['employee_type']);
            if ($t_res && mysqli_num_rows($t_res) > 0) {
                $emp_type_name = mysqli_fetch_row($t_res)[0];
            }
        }

        echo json_encode([
            "status" => "Success",
            "data" => [
                "employee_id" => (string)$row['employee_id'],
                "employee_code" => $row['employee_code'],
                "employee_name" => $row['employee_name'],
                "employee_contact_no" => $row['employee_contact_no'] ?? '',
                "employee_email_id" => $row['employee_email_id'] ?? '',
                "employee_type_name" => $emp_type_name,
                "employee_status" => $row['employee_status'],
                "employee_image" => !empty($row['employee_image']) ? "https://portal.thcfm.com/httpdocs/images/employee_images/" . $row['employee_image'] : "https://portal.thcfm.com/httpdocs/images/employee_images/default.jpg"
            ],
            "settings" => [
                "min_radius_meters" => $min_radius_setting,
                "late_time_minutes" => $late_time_setting,
                "allow_gps_bypass" => $allow_gps_bypass_setting
            ]
        ]);
    } else {
        echo json_encode(["status" => "Failed", "error_code" => "102", "api_message" => "EMPLOYEE NOT FOUND"]);
    }
    exit;
}

// =========================================================================
// ACTION 2: get_schedule_dates / get_calendar_dates
// =========================================================================
if ($action === 'get_schedule_dates' || $action === 'get_calendar_dates') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    $emp_id_res = mysqli_query($conn, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$emp_code' LIMIT 1");
    $employee_id = ($emp_id_res && mysqli_num_rows($emp_id_res) > 0) ? (int)mysqli_fetch_row($emp_id_res)[0] : 0;

    $month = $_REQUEST['month'] ?? date('Y-m');
    if (strlen($month) <= 2) {
        $month = date('Y') . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
    }
    $from_date = $_REQUEST['from_date'] ?? ($month . '-01');
    $to_date = $_REQUEST['to_date'] ?? date('Y-m-t', strtotime($from_date));

    // Find assignments where employee_id matches
    $assign_sql = "SELECT a.*, c.checklist_name, ast.asset_ref_no, ast.asset_description
                   FROM tbl_janitor_assignments a
                   LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                   LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
                   WHERE a.status = 'Active' 
                     AND (FIND_IN_SET('$employee_id', a.employee_id) OR a.employee_id = '$employee_id' OR a.employee_id = '$emp_code')
                     AND a.start_date <= '$to_date' AND a.end_date >= '$from_date'";
    
    $assign_res = mysqli_query($conn, $assign_sql);
    $assignments = [];
    if ($assign_res) {
        while ($a_row = mysqli_fetch_assoc($assign_res)) {
            $assignments[] = $a_row;
        }
    }

    $data = [];
    $marked_dates = [];

    // Schedule projection for dates in range
    $cur = strtotime($from_date);
    $end = strtotime($to_date);
    while ($cur <= $end) {
        $d_str = date('Y-m-d', $cur);
        
        // Count assignments active on this specific day
        $tasks_on_day = 0;
        foreach ($assignments as $a_item) {
            if ($d_str >= $a_item['start_date'] && $d_str <= $a_item['end_date']) {
                $tasks_on_day++;
            }
        }

        if ($tasks_on_day > 0) {
            // Count executions for this day
            $exec_cnt = 0;
            $exec_chk = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_janitor_execution_log WHERE (employee_id = '$employee_id' OR employee_id = '$emp_code') AND executed_date = '$d_str'");
            if ($exec_chk) {
                $exec_cnt = (int)mysqli_fetch_row($exec_chk)[0];
            }

            $status = ($exec_cnt > 0) ? 'Completed' : ($d_str === date('Y-m-d') ? 'Scheduled' : ($d_str < date('Y-m-d') ? 'Pending' : 'Scheduled'));
            $color = ($status === 'Completed') ? '#4CAF50' : (($status === 'Scheduled') ? '#39C0ED' : '#F44336');

            $data[] = [
                "visit_date" => $d_str,
                "date" => $d_str,
                "status" => $status,
                "status_color" => $color,
                "total_tasks" => $tasks_on_day,
                "is_fully_completed" => ($status === 'Completed') ? 'Yes' : 'No'
            ];

            $marked_dates[$d_str] = [
                "marked" => true,
                "dotColor" => $color,
                "activeColor" => $color,
                "selectedColor" => $color,
                "status" => $status
            ];
        }
        $cur = strtotime('+1 day', $cur);
    }

    echo json_encode([
        "status" => "Success",
        "from_date" => $from_date,
        "to_date" => $to_date,
        "total_scheduled_dates" => count($data),
        "data" => $data,
        "marked_dates" => $marked_dates
    ]);
    exit;
}

// =========================================================================
// ACTION 3: get_schedules_by_date / get_janitor_assignments / get_date_slots
// =========================================================================
if ($action === 'get_schedules_by_date' || $action === 'get_janitor_assignments' || $action === 'get_date_slots' || $action === 'get_slots') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    $emp_id_res = mysqli_query($conn, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$emp_code' LIMIT 1");
    $employee_id = ($emp_id_res && mysqli_num_rows($emp_id_res) > 0) ? (int)mysqli_fetch_row($emp_id_res)[0] : 0;
    
    $date = mysqli_real_escape_string($conn, trim($_REQUEST['date'] ?? $_REQUEST['visit_date'] ?? date('Y-m-d')));

    $sql = "SELECT a.id as assignment_id, a.assignment_ref_no, a.checklist_id, a.customer_id, 
                   a.location_id, a.building_id, a.asset_id, a.amc_ref_no, a.frequency, a.slots,
                   a.start_date, a.end_date,
                   c.checklist_name,
                   ast.asset_ref_no, ast.asset_description, ast.asset_category_name, ast.asset_type_name,
                   ast.asset_sp_des, ast.zone_floor, ast.flat_area_code, ast.room_no, ast.asset_attachment,
                   ast.latitude as asset_latitude, ast.longitude as asset_longitude,
                   b.building_name, b.building_code, b.building_address, b.latitude as building_latitude, b.longitude as building_longitude,
                   cust.customer_name, cust.customer_code,
                   loc.location_name, loc.location_code
            FROM tbl_janitor_assignments a
            LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
            LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
            LEFT JOIN tbl_building b ON a.building_id = b.building_id
            LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
            LEFT JOIN tbl_location loc ON a.location_id = loc.location_id
            WHERE a.status = 'Active'
              AND (FIND_IN_SET('$employee_id', a.employee_id) OR a.employee_id = '$employee_id' OR a.employee_id = '$emp_code')
              AND a.start_date <= '$date' AND a.end_date >= '$date'";

    $res = mysqli_query($conn, $sql);
    $data = [];

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $assign_id = (int)$row['assignment_id'];
            
            // Parse slots
            $raw_slots = array_filter(array_map('trim', explode(',', $row['slots'] ?? '')));
            $slots_list = [];
            $completed_slots = 0;

            $total_raw_slots = count($raw_slots);
            $s_idx = 0;
            foreach ($raw_slots as $slot_item) {
                // Check if executed
                $exec_sql = "SELECT id, status, remarks, created_at FROM tbl_janitor_execution_log 
                             WHERE assignment_id = $assign_id AND executed_date = '$date' AND executed_slot = '" . mysqli_real_escape_string($conn, $slot_item) . "' LIMIT 1";
                $exec_res = mysqli_query($conn, $exec_sql);
                $is_done = ($exec_res && mysqli_num_rows($exec_res) > 0);
                $exec_row = $is_done ? mysqli_fetch_assoc($exec_res) : null;

                if ($is_done) {
                    $completed_slots++;
                }

                // Standard slot timings
                $computed_start = '08:00';
                $computed_end = '12:00';
                if ($total_raw_slots == 1) {
                    $computed_start = '08:00';
                    $computed_end = '18:00';
                } elseif ($total_raw_slots == 2) {
                    $computed_start = ($s_idx == 0) ? '08:00' : '14:00';
                    $computed_end = ($s_idx == 0) ? '14:00' : '20:00';
                } elseif ($total_raw_slots == 3) {
                    $computed_start = ($s_idx == 0) ? '08:00' : (($s_idx == 1) ? '12:00' : '16:00');
                    $computed_end = ($s_idx == 0) ? '12:00' : (($s_idx == 1) ? '16:00' : '20:00');
                } else {
                    $start_h = 8 + ($s_idx * 2);
                    $end_h = $start_h + 2;
                    $computed_start = sprintf('%02d:00', min(22, $start_h));
                    $computed_end = sprintf('%02d:00', min(23, $end_h));
                }
                $s_idx++;

                $slots_list[] = [
                    "slot_time" => $slot_item,
                    "slot_name" => $slot_item,
                    "start_time" => $computed_start,
                    "end_time" => $computed_end,
                    "has_rule" => 1,
                    "is_completed" => $is_done ? "Yes" : "No",
                    "execution_id" => $exec_row ? (int)$exec_row['id'] : null,
                    "execution_status" => $exec_row ? $exec_row['status'] : "Pending",
                    "remarks" => $exec_row ? $exec_row['remarks'] : "",
                    "executed_at" => $exec_row ? $exec_row['created_at'] : null
                ];
            }

            $total_slots = count($slots_list);
            $work_status = ($total_slots > 0 && $completed_slots === $total_slots) ? 'Completed' : (($completed_slots > 0) ? 'Partially Completed' : 'Scheduled');
            $work_color = ($work_status === 'Completed') ? '#4CAF50' : (($work_status === 'Partially Completed') ? '#FF9800' : '#39C0ED');

            // Effective coordinate
            $eff_lat = !empty($row['asset_latitude']) ? $row['asset_latitude'] : (!empty($row['building_latitude']) ? $row['building_latitude'] : '0');
            $eff_lng = !empty($row['asset_longitude']) ? $row['asset_longitude'] : (!empty($row['building_longitude']) ? $row['building_longitude'] : '0');

            $row['latitude'] = $eff_lat;
            $row['longitude'] = $eff_lng;
            $row['total_slots'] = $total_slots;
            $row['completed_slots'] = $completed_slots;
            $row['pending_slots'] = $total_slots - $completed_slots;
            $row['is_fully_completed'] = ($work_status === 'Completed') ? 'Yes' : 'No';
            $row['work_status'] = $work_status;
            $row['work_status_color'] = $work_color;
            $row['slots_list'] = $slots_list;

            $data[] = $row;
        }
    }

    echo json_encode([
        "status" => "Success",
        "date" => $date,
        "total_schedules" => count($data),
        "data" => $data,
        "settings" => [
            "min_radius_meters" => (float)$min_radius_setting,
            "late_time_minutes" => (int)$late_time_setting,
            "allow_gps_bypass" => $allow_gps_bypass_setting
        ]
    ]);
    exit;
}

// =========================================================================
// ACTION 4: scan_asset_and_verify_location (QR Scan & Geolocation Tracking)
// =========================================================================
if ($action === 'scan_asset_and_verify_location' || $action === 'scan_asset') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    $asset_code = mysqli_real_escape_string($conn, trim($_REQUEST['asset_code'] ?? ''));
    $scan_lat = isset($_REQUEST['latitude']) ? (float)$_REQUEST['latitude'] : null;
    $scan_lng = isset($_REQUEST['longitude']) ? (float)$_REQUEST['longitude'] : null;
    
    // Configured minimum radius threshold
    $allowed_radius = isset($_REQUEST['allowed_radius_meters']) && (float)$_REQUEST['allowed_radius_meters'] > 0 
        ? (float)$_REQUEST['allowed_radius_meters'] 
        : $min_radius_setting;

    // Strict Date Restriction: Janitors can only scan tasks for today's current date
    $req_date = trim($_REQUEST['date'] ?? $_REQUEST['visit_date'] ?? $_REQUEST['selected_date'] ?? '');
    if (!empty($req_date) && $req_date !== date('Y-m-d')) {
        echo json_encode([
            "status" => "Failed",
            "error_code" => "405",
            "rule_status" => "FAILED",
            "api_message" => "DATE RESTRICTION: Janitors are only permitted to scan tasks for the current date (" . date('Y-m-d') . "). Scanning for past or future dates (" . $req_date . ") is not allowed."
        ]);
        exit;
    }

    if (empty($asset_code)) {
        echo json_encode(["status" => "Failed", "error_code" => "109", "api_message" => "ASSET CODE REQUIRED"]);
        exit;
    }
    if ($scan_lat === null || $scan_lng === null) {
        echo json_encode(["status" => "Failed", "error_code" => "400", "api_message" => "DEVICE LOCATION REQUIRED"]);
        exit;
    }

    // Lookup employee
    $emp_id = 0;
    $emp_q = mysqli_query($conn, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$emp_code' LIMIT 1");
    if ($emp_q && mysqli_num_rows($emp_q) > 0) {
        $emp_id = (int)mysqli_fetch_row($emp_q)[0];
    }

    // Lookup asset and building coordinates
    $asset_sql = "SELECT a.asset_id, a.asset_ref_no, a.asset_description, a.asset_category_name, a.asset_type_name,
                         a.zone_floor, a.flat_area_code, a.room_no, a.building_id, a.latitude as asset_lat, a.longitude as asset_lng,
                         b.building_name, b.latitude as building_lat, b.longitude as building_lng,
                         loc.location_name
                  FROM tbl_assets a
                  LEFT JOIN tbl_building b ON a.building_id = b.building_id
                  LEFT JOIN tbl_location loc ON a.location_id = loc.location_id
                  WHERE a.asset_ref_no = '$asset_code' LIMIT 1";
    $asset_res = mysqli_query($conn, $asset_sql);

    if (!$asset_res || mysqli_num_rows($asset_res) === 0) {
        $today_date = date('Y-m-d');
        $cur_time = date('H:i:s');
        $req_assign_id = isset($_REQUEST['assignment_id']) ? (int)$_REQUEST['assignment_id'] : 0;
        mysqli_query($conn, "INSERT INTO tbl_janitor_attendance (
            employee_id, employee_code, assignment_id, asset_code, janitor_lat, janitor_lng,
            attendance_date, attendance_time, attendance_status, scan_status, created_at
        ) VALUES (
            '$emp_id', '$emp_code', '$req_assign_id', '$asset_code', '$scan_lat', '$scan_lng',
            '$today_date', '$cur_time', 'Mismatch', 'Invalid Asset', NOW()
        )");
        echo json_encode(["status" => "Failed", "error_code" => "201", "api_message" => "INVALID ASSET: Code '$asset_code' does not exist."]);
        exit;
    }

    $asset = mysqli_fetch_assoc($asset_res);
    $asset_id = (int)$asset['asset_id'];
    $building_id = (int)$asset['building_id'];
    $building_name = $asset['building_name'] ?? 'Assigned Location';

    // Target coordinates: priority to asset coordinates, fallback to building coordinates
    $target_lat = !empty($asset['asset_lat']) ? (float)$asset['asset_lat'] : (!empty($asset['building_lat']) ? (float)$asset['building_lat'] : (float)($_REQUEST['asset_latitude'] ?? $scan_lat));
    $target_lng = !empty($asset['asset_lng']) ? (float)$asset['asset_lng'] : (!empty($asset['building_lng']) ? (float)$asset['building_lng'] : (float)($_REQUEST['asset_longitude'] ?? $scan_lng));

    // Calculate distance
    $distance = haversineDistanceMeters($scan_lat, $scan_lng, $target_lat, $target_lng);

    // Check geo-fence radius
    $is_within_radius = ($distance <= $allowed_radius);
    $is_bypassed = ($allowed_radius >= 10000); // large radius flag indicates test mode / bypass

    $attendance_status = $is_within_radius ? 'Present' : 'Mismatch';
    $scan_status = $is_within_radius ? 'Verified' : ($is_bypassed ? 'Bypassed' : 'Rejected');
    $today_date = date('Y-m-d');
    $cur_time = date('H:i:s');

    // Get active assignment ID for this asset & janitor
    $assignment_id = isset($_REQUEST['assignment_id']) ? (int)$_REQUEST['assignment_id'] : 0;
    $assignment = null;
    if ($assignment_id <= 0) {
        $assign_chk = mysqli_query($conn, "SELECT id, checklist_id, slots, frequency FROM tbl_janitor_assignments 
                                            WHERE asset_id = $asset_id AND status = 'Active' 
                                              AND (FIND_IN_SET('$emp_id', employee_id) OR employee_id = '$emp_id' OR employee_id = '$emp_code') 
                                            ORDER BY id DESC LIMIT 1");
        if ($assign_chk && mysqli_num_rows($assign_chk) > 0) {
            $assignment = mysqli_fetch_assoc($assign_chk);
            $assignment_id = (int)$assignment['id'];
        }
    }

    // RECORD SCAN TRACKING IN tbl_janitor_attendance
    $insert_scan = "INSERT INTO tbl_janitor_attendance (
        employee_id, employee_code, assignment_id, asset_id, asset_code,
        building_id, building_name,
        janitor_lat, janitor_lng,
        asset_lat, asset_lng,
        building_lat, building_lng,
        distance_meters,
        attendance_date, attendance_time,
        attendance_status, scan_status, created_at
    ) VALUES (
        '$emp_id', '$emp_code', '$assignment_id', '$asset_id', '$asset_code',
        '$building_id', '" . mysqli_real_escape_string($conn, $building_name) . "',
        '$scan_lat', '$scan_lng',
        '$target_lat', '$target_lng',
        '" . ($asset['building_lat'] ?? $target_lat) . "', '" . ($asset['building_lng'] ?? $target_lng) . "',
        '$distance',
        '$today_date', '$cur_time',
        '$attendance_status', '$scan_status', NOW()
    )";
    mysqli_query($conn, $insert_scan);
    $attendance_id = mysqli_insert_id($conn);

    if (!$is_within_radius && !$is_bypassed) {
        echo json_encode([
            "status" => "Failed",
            "error_code" => "403",
            "rule_status" => "FAILED",
            "api_message" => "LOCATION MISMATCH: Your location is " . number_format($distance, 1) . "m away from '$building_name' (allowed limit: " . $allowed_radius . "m).",
            "action_required" => "auto_logout",
            "auto_logout" => true,
            "can_proceed" => false,
            "distance_meters" => $distance,
            "allowed_radius_meters" => $allowed_radius,
            "building_name" => $building_name,
            "asset_ref_no" => $asset_code,
            "janitor_coordinates" => ["latitude" => $scan_lat, "longitude" => $scan_lng],
            "asset_coordinates" => ["latitude" => $target_lat, "longitude" => $target_lng],
            "building_coordinates" => ["latitude" => (float)($asset['building_lat'] ?? $target_lat), "longitude" => (float)($asset['building_lng'] ?? $target_lng)],
            "settings" => [
                "min_radius_meters" => (float)$min_radius_setting,
                "late_time_minutes" => (int)$late_time_setting,
                "allow_gps_bypass" => $allow_gps_bypass_setting
            ]
        ]);
        exit;
    }

    // Success response
    echo json_encode([
        "status" => "Success",
        "rule_status" => "MATCHED",
        "attendance_marked" => "Yes",
        "can_proceed" => true,
        "auto_logout" => false,
        "api_message" => "Location verified successfully! Attendance marked as Present. You may now proceed with cleaning.",
        "distance_meters" => $distance,
        "allowed_radius_meters" => $allowed_radius,
        "settings" => [
            "min_radius_meters" => (float)$min_radius_setting,
            "late_time_minutes" => (int)$late_time_setting,
            "allow_gps_bypass" => $allow_gps_bypass_setting
        ],
        "attendance" => [
            "attendance_id" => $attendance_id,
            "attendance_date" => $today_date,
            "attendance_time" => $cur_time,
            "attendance_status" => $attendance_status,
            "scan_status" => $scan_status
        ],
        "asset" => [
            "asset_id" => $asset_id,
            "asset_ref_no" => $asset['asset_ref_no'],
            "asset_description" => $asset['asset_description'],
            "asset_category_name" => $asset['asset_category_name'],
            "asset_type_name" => $asset['asset_type_name'],
            "zone_floor" => $asset['zone_floor'],
            "flat_area_code" => $asset['flat_area_code'],
            "room_no" => $asset['room_no'],
            "building_id" => $building_id,
            "building_name" => $building_name,
            "location_name" => $asset['location_name'] ?? '',
            "asset_latitude" => $target_lat,
            "asset_longitude" => $target_lng
        ],
        "janitor_scan_location" => [
            "latitude" => $scan_lat,
            "longitude" => $scan_lng
        ],
        "assignment" => $assignment ? [
            "assignment_id" => (int)$assignment['id'],
            "checklist_id" => (int)$assignment['checklist_id'],
            "slots" => $assignment['slots'],
            "frequency" => $assignment['frequency']
        ] : null
    ]);
    exit;
}

// =========================================================================
// ACTION 5: get_checklist_items
// =========================================================================
if ($action === 'get_checklist_items') {
    $checklist_id = (int)($_REQUEST['checklist_id'] ?? 0);
    $assignment_id = (int)($_REQUEST['assignment_id'] ?? 0);
    $date = mysqli_real_escape_string($conn, trim($_REQUEST['date'] ?? date('Y-m-d')));

    if ($checklist_id <= 0 && $assignment_id > 0) {
        $c_chk = mysqli_query($conn, "SELECT checklist_id FROM tbl_janitor_assignments WHERE id = $assignment_id LIMIT 1");
        if ($c_chk && mysqli_num_rows($c_chk) > 0) {
            $checklist_id = (int)mysqli_fetch_row($c_chk)[0];
        }
    }

    if ($checklist_id <= 0) {
        echo json_encode(["status" => "Failed", "error_code" => "106", "api_message" => "CHECKLIST ID REQUIRED"]);
        exit;
    }

    $c_meta = mysqli_query($conn, "SELECT id, checklist_name, status FROM tbl_janitor_checklists WHERE id = $checklist_id LIMIT 1");
    $checklist = ($c_meta && mysqli_num_rows($c_meta) > 0) ? mysqli_fetch_assoc($c_meta) : ["id" => $checklist_id, "checklist_name" => "Checklist", "status" => "Active"];

    $cat_res = mysqli_query($conn, "SELECT id, category_name FROM tbl_janitor_checklist_categories WHERE checklist_id = $checklist_id ORDER BY id ASC");
    $categories_data = [];

    if ($cat_res) {
        while ($cat = mysqli_fetch_assoc($cat_res)) {
            $cat_id = (int)$cat['id'];
            $items_res = mysqli_query($conn, "SELECT id as item_id, item_description, status FROM tbl_janitor_checklist_items WHERE checklist_category_id = $cat_id AND status = 'Active' ORDER BY id ASC");
            $items = [];
            if ($items_res) {
                while ($it = mysqli_fetch_assoc($items_res)) {
                    $items[] = $it;
                }
            }
            $categories_data[] = [
                "category_id" => (string)$cat_id,
                "category_name" => $cat['category_name'],
                "items" => $items
            ];
        }
    }

    // Query executed points for each slot on this date
    $executions_by_slot = [];
    if ($assignment_id > 0) {
        $exec_q = mysqli_query($conn, "SELECT id, executed_slot, status, remarks, created_at FROM tbl_janitor_execution_log WHERE assignment_id = $assignment_id AND executed_date = '$date' ORDER BY id ASC");
        if ($exec_q) {
            while ($ex = mysqli_fetch_assoc($exec_q)) {
                $ex_id = (int)$ex['id'];
                $slot_key = trim($ex['executed_slot']);
                $pts_q = mysqli_query($conn, "SELECT checklist_item_id, is_completed, remarks, photo_url FROM tbl_janitor_execution_points WHERE execution_id = $ex_id");
                $pts_map = [];
                if ($pts_q) {
                    while ($pt = mysqli_fetch_assoc($pts_q)) {
                        $it_id = (string)$pt['checklist_item_id'];
                        $pts_map[$it_id] = [
                            "item_id" => $it_id,
                            "is_completed" => $pt['is_completed'],
                            "remarks" => $pt['remarks'] ?? "",
                            "photo_url" => $pt['photo_url'] ?? ""
                        ];
                    }
                }
                $executions_by_slot[$slot_key] = [
                    "execution_id" => $ex_id,
                    "slot" => $slot_key,
                    "status" => $ex['status'],
                    "remarks" => $ex['remarks'],
                    "executed_at" => $ex['created_at'],
                    "points" => $pts_map
                ];
                if (preg_match('/^slot\s*(\d+)$/i', $slot_key, $sm)) {
                    $executions_by_slot[$sm[1]] = &$executions_by_slot[$slot_key];
                } elseif (is_numeric($slot_key)) {
                    $executions_by_slot['Slot ' . $slot_key] = &$executions_by_slot[$slot_key];
                }
            }
        }
    }

    echo json_encode([
        "status" => "Success",
        "checklist" => $checklist,
        "data" => $categories_data,
        "date" => $date,
        "executions_by_slot" => $executions_by_slot,
        "settings" => [
            "min_radius_meters" => (float)$min_radius_setting,
            "late_time_minutes" => (int)$late_time_setting,
            "allow_gps_bypass" => $allow_gps_bypass_setting
        ]
    ]);
    exit;
}

// =========================================================================
// ACTION 6: upload_execution_photo
// =========================================================================
if ($action === 'upload_execution_photo') {
    $upload_dir = __DIR__ . '/../../httpdocs/images/janitor_execution/';
    if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, 0777, true);
    }

    $filename = 'jan_' . time() . '_' . rand(1000, 9999) . '.jpg';
    $target_file = $upload_dir . $filename;
    $uploaded = false;

    if (!empty($_FILES['photo']['tmp_name'])) {
        $uploaded = @move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } elseif (!empty($_REQUEST['photo_base64'])) {
        $base64_str = $_REQUEST['photo_base64'];
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_str, $type)) {
            $base64_str = substr($base64_str, strpos($base64_str, ',') + 1);
        }
        $data = base64_decode($base64_str);
        if ($data !== false) {
            $uploaded = (@file_put_contents($target_file, $data) !== false);
        }
    }

    if ($uploaded) {
        $photo_url = "https://portal.thcfm.com/httpdocs/images/janitor_execution/" . $filename;
        echo json_encode([
            "status" => "Success",
            "photo_url" => $photo_url,
            "filename" => $filename
        ]);
    } else {
        echo json_encode([
            "status" => "Failed",
            "api_message" => "Photo upload failed or invalid file format"
        ]);
    }
    exit;
}

// =========================================================================
// ACTION 7: submit_checklist_execution
// =========================================================================
if ($action === 'submit_checklist_execution') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    $assignment_id = (int)($_REQUEST['assignment_id'] ?? 0);
    $slot = mysqli_real_escape_string($conn, trim($_REQUEST['slot'] ?? ''));
    $date = mysqli_real_escape_string($conn, trim($_REQUEST['date'] ?? date('Y-m-d')));
    $status = mysqli_real_escape_string($conn, trim($_REQUEST['status'] ?? 'Completed'));
    $remarks = mysqli_real_escape_string($conn, trim($_REQUEST['remarks'] ?? ''));
    
    // GPS Tracking parameters
    $scan_lat = isset($_REQUEST['scan_lat']) ? mysqli_real_escape_string($conn, $_REQUEST['scan_lat']) : null;
    $scan_lng = isset($_REQUEST['scan_lng']) ? mysqli_real_escape_string($conn, $_REQUEST['scan_lng']) : null;
    $asset_lat = isset($_REQUEST['asset_lat']) ? mysqli_real_escape_string($conn, $_REQUEST['asset_lat']) : null;
    $asset_lng = isset($_REQUEST['asset_lng']) ? mysqli_real_escape_string($conn, $_REQUEST['asset_lng']) : null;
    $distance_meters = isset($_REQUEST['distance_meters']) ? (float)$_REQUEST['distance_meters'] : null;

    if ($assignment_id <= 0) {
        echo json_encode(["status" => "Failed", "error_code" => "105", "api_message" => "ASSIGNMENT ID IS REQUIRED"]);
        exit;
    }
    if (empty($slot)) {
        echo json_encode(["status" => "Failed", "error_code" => "107", "api_message" => "SLOT REQUIRED"]);
        exit;
    }

    // Strict Date Restriction: Submissions are only permitted for today's date
    if ($date !== date('Y-m-d')) {
        echo json_encode([
            "status" => "Failed",
            "error_code" => "405",
            "rule_status" => "FAILED",
            "api_message" => "DATE RESTRICTION: Janitors can only execute and submit tasks for today's current date (" . date('Y-m-d') . "). Submissions for past or upcoming dates (" . $date . ") are not permitted."
        ]);
        exit;
    }

    // Lookup assignment & asset
    $assign_q = mysqli_query($conn, "SELECT a.*, ast.asset_ref_no, ast.latitude as a_lat, ast.longitude as a_lng,
                                            b.latitude as b_lat, b.longitude as b_lng
                                     FROM tbl_janitor_assignments a
                                     LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
                                     LEFT JOIN tbl_building b ON a.building_id = b.building_id
                                     WHERE a.id = $assignment_id LIMIT 1");
    if (!$assign_q || mysqli_num_rows($assign_q) === 0) {
        echo json_encode(["status" => "Failed", "api_message" => "Assignment not found"]);
        exit;
    }
    $assign = mysqli_fetch_assoc($assign_q);
    $asset_id = (int)$assign['asset_id'];
    $amc_ref_no = mysqli_real_escape_string($conn, $assign['amc_ref_no'] ?? '');

    // Slot Window Timing Enforcement
    // A janitor cannot submit upcoming windows (before start_time) or late slots past end_time + late_time_setting
    $req_start = trim($_REQUEST['start_time'] ?? '');
    $req_end = trim($_REQUEST['end_time'] ?? '');

    $slot_start = $req_start;
    $slot_end = $req_end;

    if (empty($slot_start) || empty($slot_end) || $slot_end === '0') {
        $raw_slots = array_values(array_filter(array_map('trim', explode(',', $assign['slots'] ?? ''))));
        $total_raw_slots = count($raw_slots);
        $found_idx = -1;
        foreach ($raw_slots as $idx => $r_slot) {
            if (strcasecmp($r_slot, $slot) === 0 || 
                strcasecmp("Slot " . $r_slot, $slot) === 0 || 
                strcasecmp($r_slot, str_replace('Slot ', '', $slot)) === 0) {
                $found_idx = $idx;
                break;
            }
        }
        if ($found_idx === -1 && preg_match('/(\d+)/', $slot, $m)) {
            $slot_num = (int)$m[1];
            if ($slot_num >= 1 && $slot_num <= $total_raw_slots) {
                $found_idx = $slot_num - 1;
            }
        }
        if ($found_idx === -1) {
            $found_idx = 0;
        }

        if ($total_raw_slots == 1) {
            $slot_start = '08:00';
            $slot_end = '18:00';
        } elseif ($total_raw_slots == 2) {
            $slot_start = ($found_idx == 0) ? '08:00' : '14:00';
            $slot_end = ($found_idx == 0) ? '14:00' : '20:00';
        } elseif ($total_raw_slots == 3) {
            $slot_start = ($found_idx == 0) ? '08:00' : (($found_idx == 1) ? '12:00' : '16:00');
            $slot_end = ($found_idx == 0) ? '12:00' : (($found_idx == 1) ? '16:00' : '20:00');
        } else {
            $start_h = 8 + ($found_idx * 2);
            $end_h = $start_h + 2;
            $slot_start = sprintf('%02d:00', min(22, $start_h));
            $slot_end = sprintf('%02d:00', min(23, $end_h));
        }
    }

    $now_ts = time();
    $start_ts = strtotime(date('Y-m-d') . ' ' . $slot_start);
    $end_ts = strtotime(date('Y-m-d') . ' ' . $slot_end);
    $late_grace_secs = ($late_time_setting > 0 ? $late_time_setting : 15) * 60;
    $deadline_ts = $end_ts ? ($end_ts + $late_grace_secs) : 0;

    // Rule 1: Upcoming Window Check (cannot submit before start_time)
    if ($start_ts && $now_ts < $start_ts) {
        echo json_encode([
            "status" => "Failed",
            "error_code" => "406",
            "rule_status" => "UPCOMING_WINDOW",
            "api_message" => "SLOT WINDOW RESTRICTION: Upcoming time slot (" . htmlspecialchars($slot) . ") cannot be submitted yet. Scheduled window is " . $slot_start . " - " . $slot_end . ". Submissions open at " . $slot_start . "."
        ]);
        exit;
    }

    // Rule 2: Late Expired Check (cannot submit after end_time + late_time_setting allowed by administrator)
    if ($deadline_ts && $now_ts > $deadline_ts) {
        $deadline_str = date('H:i', $deadline_ts);
        echo json_encode([
            "status" => "Failed",
            "error_code" => "407",
            "rule_status" => "SLOT_EXPIRED",
            "api_message" => "SLOT WINDOW EXPIRED: This slot (" . htmlspecialchars($slot) . ") ended at " . $slot_end . " (+" . $late_time_setting . "m late allowance). The deadline was " . $deadline_str . ". Submissions beyond the allowed late threshold are strictly prohibited."
        ]);
        exit;
    }

    $emp_id = 0;
    $emp_chk = mysqli_query($conn, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$emp_code' LIMIT 1");
    if ($emp_chk && mysqli_num_rows($emp_chk) > 0) {
        $emp_id = (int)mysqli_fetch_row($emp_chk)[0];
    }

    // If coordinates not sent directly, retrieve latest verified scan from tbl_janitor_attendance
    if ($scan_lat === null || $scan_lng === null) {
        $att_q = mysqli_query($conn, "SELECT janitor_lat, janitor_lng, asset_lat, asset_lng, distance_meters 
                                      FROM tbl_janitor_attendance 
                                      WHERE asset_id = $asset_id AND (employee_id = $emp_id OR employee_code = '$emp_code') AND attendance_date = '$date'
                                      ORDER BY id DESC LIMIT 1");
        if ($att_q && mysqli_num_rows($att_q) > 0) {
            $att_row = mysqli_fetch_assoc($att_q);
            $scan_lat = $att_row['janitor_lat'];
            $scan_lng = $att_row['janitor_lng'];
            $asset_lat = $att_row['asset_lat'] ?? $assign['a_lat'] ?? $assign['b_lat'];
            $asset_lng = $att_row['asset_lng'] ?? $assign['a_lng'] ?? $assign['b_lng'];
            $distance_meters = (float)$att_row['distance_meters'];
        }
    }

    // Parse checklist points & determine whether slot is Completed or Partially Completed
    $raw_points = $_REQUEST['points'] ?? '[]';
    $points = is_array($raw_points) ? $raw_points : json_decode($raw_points, true);

    $has_issue = false;
    $completed_points_count = 0;
    $total_points_count = 0;

    if (is_array($points)) {
        $total_points_count = count($points);
        foreach ($points as $pt) {
            $is_c = trim($pt['is_completed'] ?? 'Yes');
            if ($is_c === 'No') {
                $has_issue = true;
            } else {
                $completed_points_count++;
            }
        }
    }

    // "IN the List Of task have Groups Each Group has to Complete all The List , Then Only That Slot cosider s Completed Else Partialy Completed"
    $base_status = ($has_issue || ($total_points_count > 0 && $completed_points_count < $total_points_count))
        ? 'Partially Completed'
        : 'Completed';

    $requested_status = trim($_REQUEST['status'] ?? '');
    if (stripos($requested_status, 'Late') !== false) {
        if (preg_match('/Late by [^)]+/', $requested_status, $m)) {
            $final_status = $base_status . ' (' . $m[0] . ')';
        } else {
            $final_status = $base_status . ' (Late)';
        }
    } else {
        $final_status = $base_status;
    }

    // Clean up any old duplicate execution for this assignment, slot, and date
    $old_exec = mysqli_query($conn, "SELECT id FROM tbl_janitor_execution_log WHERE assignment_id = $assignment_id AND executed_date = '$date' AND executed_slot = '$slot'");
    if ($old_exec && mysqli_num_rows($old_exec) > 0) {
        while ($o = mysqli_fetch_assoc($old_exec)) {
            $old_id = (int)$o['id'];
            mysqli_query($conn, "DELETE FROM tbl_janitor_execution_points WHERE execution_id = $old_id");
            mysqli_query($conn, "DELETE FROM tbl_janitor_execution_log WHERE id = $old_id");
        }
    }

    // Insert Execution Header
    $sql_hdr = "INSERT INTO tbl_janitor_execution_log (
        assignment_id, employee_id, asset_id, amc_ref_no, executed_date, executed_slot, status, remarks,
        scan_lat, scan_lng, asset_lat, asset_lng, distance_meters, created_at
    ) VALUES (
        '$assignment_id', '$emp_id', '$asset_id', '$amc_ref_no', '$date', '$slot', '$final_status', '$remarks',
        " . ($scan_lat !== null ? "'$scan_lat'" : "NULL") . ",
        " . ($scan_lng !== null ? "'$scan_lng'" : "NULL") . ",
        " . ($asset_lat !== null ? "'$asset_lat'" : "NULL") . ",
        " . ($asset_lng !== null ? "'$asset_lng'" : "NULL") . ",
        " . ($distance_meters !== null ? "'$distance_meters'" : "NULL") . ",
        NOW()
    )";

    if (!mysqli_query($conn, $sql_hdr)) {
        echo json_encode(["status" => "Failed", "api_message" => "Database error: " . mysqli_error($conn)]);
        exit;
    }
    $execution_id = mysqli_insert_id($conn);

    // Insert checklist points
    if (is_array($points)) {
        foreach ($points as $pt) {
            $item_id = (int)($pt['checklist_item_id'] ?? 0);
            $is_comp = mysqli_real_escape_string($conn, $pt['is_completed'] ?? 'Yes');
            $pt_rem = mysqli_real_escape_string($conn, $pt['remarks'] ?? '');
            $pt_photo = mysqli_real_escape_string($conn, $pt['photo_url'] ?? '');

            if ($item_id > 0) {
                mysqli_query($conn, "INSERT INTO tbl_janitor_execution_points 
                    (execution_id, checklist_item_id, is_completed, remarks, photo_url) 
                    VALUES ($execution_id, $item_id, '$is_comp', '$pt_rem', '$pt_photo')");
            }
        }
    }

    echo json_encode([
        "status" => "Success",
        "api_message" => "Execution submitted successfully",
        "execution_id" => $execution_id,
        "scan_tracking" => [
            "scan_latitude" => $scan_lat,
            "scan_longitude" => $scan_lng,
            "asset_latitude" => $asset_lat,
            "asset_longitude" => $asset_lng,
            "distance_meters" => $distance_meters
        ]
    ]);
    exit;
}

// =========================================================================
// ACTION 7.5: get_execution_points / get_execution_details
// =========================================================================
if ($action === 'get_execution_points' || $action === 'get_execution_details') {
    $execution_id = (int)($_REQUEST['execution_id'] ?? 0);
    if ($execution_id <= 0) {
        echo json_encode(["status" => "Failed", "api_message" => "EXECUTION ID REQUIRED"]);
        exit;
    }

    $exec_q = mysqli_query($conn, "SELECT * FROM tbl_janitor_execution_log WHERE id = $execution_id LIMIT 1");
    if (!$exec_q || mysqli_num_rows($exec_q) === 0) {
        echo json_encode(["status" => "Failed", "api_message" => "Execution not found"]);
        exit;
    }
    $exec = mysqli_fetch_assoc($exec_q);

    $pts_q = mysqli_query($conn, "SELECT checklist_item_id, is_completed, remarks, photo_url FROM tbl_janitor_execution_points WHERE execution_id = $execution_id");
    $pts_map = [];
    $points_list = [];
    if ($pts_q) {
        while ($pt = mysqli_fetch_assoc($pts_q)) {
            $it_id = (string)$pt['checklist_item_id'];
            $pt_data = [
                "item_id" => $it_id,
                "checklist_item_id" => $it_id,
                "is_completed" => $pt['is_completed'],
                "remarks" => $pt['remarks'] ?? "",
                "photo_url" => $pt['photo_url'] ?? ""
            ];
            $pts_map[$it_id] = $pt_data;
            $points_list[] = $pt_data;
        }
    }

    echo json_encode([
        "status" => "Success",
        "execution_id" => $execution_id,
        "execution" => $exec,
        "points" => $pts_map,
        "points_list" => $points_list
    ]);
    exit;
}

// =========================================================================
// ACTION 8: get_execution_history
// =========================================================================
if ($action === 'get_execution_history') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    $emp_chk = mysqli_query($conn, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$emp_code' LIMIT 1");
    $emp_id = ($emp_chk && mysqli_num_rows($emp_chk) > 0) ? (int)mysqli_fetch_row($emp_chk)[0] : 0;

    $where = ["(l.employee_id = $emp_id OR l.employee_id = '$emp_code')"];
    if (!empty($_REQUEST['from_date'])) {
        $where[] = "l.executed_date >= '" . mysqli_real_escape_string($conn, $_REQUEST['from_date']) . "'";
    }
    if (!empty($_REQUEST['to_date'])) {
        $where[] = "l.executed_date <= '" . mysqli_real_escape_string($conn, $_REQUEST['to_date']) . "'";
    }
    $where_sql = implode(' AND ', $where);

    $sql = "SELECT l.id as execution_id, l.assignment_id, l.executed_date, l.executed_slot, l.status, l.remarks, l.created_at,
                   l.scan_lat, l.scan_lng, l.asset_lat, l.asset_lng, l.distance_meters,
                   a.assignment_ref_no,
                   c.checklist_name,
                   ast.asset_ref_no, ast.asset_description,
                   cust.customer_name,
                   b.building_name,
                   loc.location_name
            FROM tbl_janitor_execution_log l
            LEFT JOIN tbl_janitor_assignments a ON l.assignment_id = a.id
            LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
            LEFT JOIN tbl_assets ast ON l.asset_id = ast.asset_id
            LEFT JOIN tbl_building b ON ast.building_id = b.building_id
            LEFT JOIN tbl_customers cust ON ast.customer_id = cust.customer_id
            LEFT JOIN tbl_location loc ON ast.location_id = loc.location_id
            WHERE $where_sql
            ORDER BY l.executed_date DESC, l.id DESC";

    $res = mysqli_query($conn, $sql);
    $data = [];
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $data[] = $r;
        }
    }

    echo json_encode(["status" => "Success", "data" => $data]);
    exit;
}

// =========================================================================
// ACTION 9: get_janitor_attendance
// =========================================================================
if ($action === 'get_janitor_attendance') {
    $emp_code = mysqli_real_escape_string($conn, trim($_REQUEST['emp_code'] ?? ''));
    $emp_chk = mysqli_query($conn, "SELECT employee_id FROM tbl_employees WHERE employee_code = '$emp_code' LIMIT 1");
    $emp_id = ($emp_chk && mysqli_num_rows($emp_chk) > 0) ? (int)mysqli_fetch_row($emp_chk)[0] : 0;

    $where = ["(employee_id = $emp_id OR employee_code = '$emp_code')"];
    if (!empty($_REQUEST['from_date'])) {
        $where[] = "attendance_date >= '" . mysqli_real_escape_string($conn, $_REQUEST['from_date']) . "'";
    }
    if (!empty($_REQUEST['to_date'])) {
        $where[] = "attendance_date <= '" . mysqli_real_escape_string($conn, $_REQUEST['to_date']) . "'";
    }
    $where_sql = implode(' AND ', $where);

    $sql = "SELECT * FROM tbl_janitor_attendance WHERE $where_sql ORDER BY attendance_date DESC, id DESC";
    $res = mysqli_query($conn, $sql);
    $data = [];
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $data[] = $r;
        }
    }

    echo json_encode(["status" => "Success", "total_records" => count($data), "data" => $data]);
    exit;
}

echo json_encode(["status" => "Failed", "error_code" => "110", "api_message" => "ACTION VALUE REQUIRED or NOT FOUND"]);
exit;
?>
