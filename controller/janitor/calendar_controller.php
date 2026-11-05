<?php
require_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

// -------------------------------------------------------------
// 1. GET ALL JANITORS (FOR SELECTOR DROPDOWN & SUMMARY)
// -------------------------------------------------------------
if ($action === 'get_janitors') {
    $janitors = [];
    $sql = "SELECT e.employee_id, e.employee_name, e.employee_code, e.employee_contact_no, e.employee_email_id,
                   (SELECT COUNT(*) FROM tbl_janitor_assignments a 
                    WHERE a.status = 'Active' 
                      AND (FIND_IN_SET(e.employee_id, a.employee_id) OR a.employee_id = e.employee_id OR a.employee_id = e.employee_code)
                   ) as active_assignments_count
            FROM tbl_employees e
            WHERE e.employee_type_name LIKE '%Janitor%' 
               OR e.employee_type_id IN (SELECT user_type_id FROM tbl_user_types WHERE user_type_name LIKE '%Janitor%')
            ORDER BY e.employee_name ASC";
            
    $res = mysqli_query($conn, $sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $janitors[] = $row;
        }
    }
    echo json_encode(["status" => "success", "data" => $janitors]);
    exit;
}

// -------------------------------------------------------------
// 2. GET JANITOR PROFILE & ACTIVE ASSIGNMENTS OVERVIEW
// -------------------------------------------------------------
else if ($action === 'get_janitor_overview') {
    $employee_id = (int)($_REQUEST['employee_id'] ?? 0);
    if ($employee_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid Janitor ID"]);
        exit;
    }

    $emp_res = mysqli_query($conn, "SELECT employee_id, employee_name, employee_code, employee_contact_no, employee_email_id, employee_type_name FROM tbl_employees WHERE employee_id = $employee_id LIMIT 1");
    $employee = mysqli_fetch_assoc($emp_res);
    if (!$employee) {
        echo json_encode(["status" => "error", "message" => "Janitor not found"]);
        exit;
    }

    $emp_code = $employee['employee_code'];

    // Get active assignments
    $sql_a = "SELECT a.id as assignment_id, a.assignment_ref_no, a.frequency, a.slots, a.slots_detail,
                     a.start_date, a.end_date, a.status,
                     c.checklist_name,
                     ast.asset_ref_no, ast.asset_description,
                     b.building_name,
                     cust.customer_name,
                     loc.location_name
              FROM tbl_janitor_assignments a
              LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
              LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
              LEFT JOIN tbl_building b ON a.building_id = b.building_id
              LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
              LEFT JOIN tbl_location loc ON a.location_id = loc.location_id
              WHERE a.status = 'Active'
                AND (FIND_IN_SET('$employee_id', a.employee_id) OR a.employee_id = '$employee_id' OR a.employee_id = '$emp_code')
              ORDER BY a.id DESC";

    $res_a = mysqli_query($conn, $sql_a);
    $assignments = [];
    if ($res_a) {
        while ($ra = mysqli_fetch_assoc($res_a)) {
            $assignments[] = $ra;
        }
    }

    echo json_encode([
        "status" => "success",
        "employee" => $employee,
        "assignments" => $assignments
    ]);
    exit;
}

// -------------------------------------------------------------
// 3. GET CALENDAR EVENTS & KPI STATS FOR A JANITOR & DATE RANGE
// -------------------------------------------------------------
else if ($action === 'get_calendar_events') {
    $employee_id = (int)($_REQUEST['employee_id'] ?? 0);
    $start_req = trim($_REQUEST['start'] ?? '');
    $end_req = trim($_REQUEST['end'] ?? '');

    if ($employee_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Please select a Janitor", "events" => [], "kpis" => []]);
        exit;
    }

    // Parse start and end dates (YYYY-MM-DD)
    $start_date = !empty($start_req) ? substr($start_req, 0, 10) : date('Y-m-01');
    $end_date = !empty($end_req) ? substr($end_req, 0, 10) : date('Y-m-t');

    // Get Janitor Settings (late tolerance, min radius)
    $sett_q = mysqli_query($conn, "SELECT min_radius_meters, late_time_minutes FROM tbl_janitor_settings LIMIT 1");
    $sett = ($sett_q && mysqli_num_rows($sett_q) > 0) ? mysqli_fetch_assoc($sett_q) : ['min_radius_meters' => 200, 'late_time_minutes' => 15];
    $late_time_minutes = (int)($sett['late_time_minutes'] ?? 15);

    // Get employee code
    $emp_res = mysqli_query($conn, "SELECT employee_code, employee_name FROM tbl_employees WHERE employee_id = $employee_id LIMIT 1");
    $emp_row = mysqli_fetch_assoc($emp_res);
    $emp_code = $emp_row ? $emp_row['employee_code'] : '';

    // Fetch active assignments that overlap with the requested date range
    $sql_assign = "SELECT a.id as assignment_id, a.assignment_ref_no, a.checklist_id, a.customer_id, 
                          a.location_id, a.building_id, a.asset_id, a.amc_ref_no, a.frequency, a.slots, a.slots_detail,
                          a.start_date, a.end_date,
                          c.checklist_name,
                          ast.asset_ref_no, ast.asset_description,
                          ast.latitude as asset_latitude, ast.longitude as asset_longitude,
                          b.building_name, b.latitude as building_latitude, b.longitude as building_longitude,
                          cust.customer_name,
                          loc.location_name
                   FROM tbl_janitor_assignments a
                   LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
                   LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
                   LEFT JOIN tbl_building b ON a.building_id = b.building_id
                   LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
                   LEFT JOIN tbl_location loc ON a.location_id = loc.location_id
                   WHERE a.status = 'Active'
                     AND (FIND_IN_SET('$employee_id', a.employee_id) OR a.employee_id = '$employee_id' OR a.employee_id = '$emp_code')
                     AND a.start_date <= '$end_date' AND a.end_date >= '$start_date'";

    $res_assign = mysqli_query($conn, $sql_assign);
    $assignments = [];
    if ($res_assign) {
        while ($row = mysqli_fetch_assoc($res_assign)) {
            $assignments[] = $row;
        }
    }

    // Pre-fetch all execution logs for this janitor in the date range
    $exec_map = [];
    $sql_execs = "SELECT id, assignment_id, employee_id, asset_id, executed_date, executed_slot, status, remarks, created_at,
                         scan_lat, scan_lng, asset_lat, asset_lng, distance_meters
                  FROM tbl_janitor_execution_log
                  WHERE (employee_id = $employee_id OR employee_id = '$emp_code')
                    AND executed_date >= '$start_date' AND executed_date <= '$end_date'";
                    
    $res_execs = mysqli_query($conn, $sql_execs);
    if ($res_execs) {
        while ($re = mysqli_fetch_assoc($res_execs)) {
            $a_id = (int)$re['assignment_id'];
            $d = $re['executed_date'];
            $s = trim($re['executed_slot']);
            $exec_map[$a_id][$d][$s] = $re;
        }
    }

    $events = [];
    $today_str = date('Y-m-d');
    $current_time = date('H:i');

    // KPI Counters
    $kpi_total_slots = 0;
    $kpi_completed_ontime = 0;
    $kpi_completed_late = 0;
    $kpi_completed_partial = 0;
    $kpi_missed = 0;
    $kpi_active = 0;
    $kpi_upcoming = 0;

    foreach ($assignments as $a) {
        $assign_id = (int)$a['assignment_id'];
        $a_start = max($start_date, $a['start_date']);
        $a_end = min($end_date, $a['end_date']);

        // Parse slots configuration
        $slots_config = [];
        $slots_detail_arr = !empty($a['slots_detail']) ? json_decode($a['slots_detail'], true) : null;
        
        if (is_array($slots_detail_arr) && count($slots_detail_arr) > 0) {
            foreach ($slots_detail_arr as $idx => $sd) {
                $sname = trim($sd['name'] ?? ("Slot " . ($idx + 1)));
                $stime = (!empty($sd['start_time']) && $sd['start_time'] !== '0') ? $sd['start_time'] : '';
                $etime = (!empty($sd['end_time']) && $sd['end_time'] !== '0') ? $sd['end_time'] : '';
                
                // If timings are not set in slots_detail, fallback to default calculations
                if (empty($stime) || empty($etime)) {
                    $total_s = count($slots_detail_arr);
                    if ($total_s == 1) {
                        $stime = '08:00'; $etime = '18:00';
                    } elseif ($total_s == 2) {
                        $stime = ($idx == 0) ? '08:00' : '14:00';
                        $etime = ($idx == 0) ? '14:00' : '20:00';
                    } elseif ($total_s == 3) {
                        $stime = ($idx == 0) ? '08:00' : (($idx == 1) ? '12:00' : '16:00');
                        $etime = ($idx == 0) ? '12:00' : (($idx == 1) ? '16:00' : '20:00');
                    } else {
                        $sh = 8 + ($idx * 2);
                        $stime = sprintf('%02d:00', min(22, $sh));
                        $etime = sprintf('%02d:00', min(23, $sh + 2));
                    }
                }

                $slots_config[] = [
                    'name' => $sname,
                    'start_time' => $stime,
                    'end_time' => $etime
                ];
            }
        } else {
            // Fallback: parse comma-separated slots string
            $raw_slots = array_filter(array_map('trim', explode(',', $a['slots'] ?? '')));
            $total_raw = count($raw_slots);
            foreach ($raw_slots as $idx => $r_slot) {
                if ($total_raw == 1) {
                    $stime = '08:00'; $etime = '18:00';
                } elseif ($total_raw == 2) {
                    $stime = ($idx == 0) ? '08:00' : '14:00';
                    $etime = ($idx == 0) ? '14:00' : '20:00';
                } elseif ($total_raw == 3) {
                    $stime = ($idx == 0) ? '08:00' : (($idx == 1) ? '12:00' : '16:00');
                    $etime = ($idx == 0) ? '12:00' : (($idx == 1) ? '16:00' : '20:00');
                } else {
                    $sh = 8 + ($idx * 2);
                    $stime = sprintf('%02d:00', min(22, $sh));
                    $etime = sprintf('%02d:00', min(23, $sh + 2));
                }

                $slots_config[] = [
                    'name' => $r_slot,
                    'start_time' => $stime,
                    'end_time' => $etime
                ];
            }
        }

        if (empty($slots_config)) {
            // Default 1 slot if none specified
            $slots_config[] = [
                'name' => 'General Slot',
                'start_time' => '08:00',
                'end_time' => '17:00'
            ];
        }

        // Iterate through each date in the assignment's overlap with the range
        $cur_ts = strtotime($a_start);
        $end_ts = strtotime($a_end);

        while ($cur_ts <= $end_ts) {
            $cur_date_str = date('Y-m-d', $cur_ts);

            foreach ($slots_config as $sc) {
                $sname = $sc['name'];
                $stime = $sc['start_time'];
                $etime = $sc['end_time'];

                // Check execution in preloaded map
                $exec = $exec_map[$assign_id][$cur_date_str][$sname] ?? null;

                // Calculate late threshold time
                $etime_ts = strtotime("{$cur_date_str} {$etime}");
                $late_deadline_ts = $etime_ts + ($late_time_minutes * 60);
                $late_deadline_time = date('H:i', $late_deadline_ts);

                $status = '';
                $status_code = '';
                $color = '';
                $badge_class = '';
                $icon_class = '';

                if ($exec) {
                    $exec_status = $exec['status'];
                    if (stripos($exec_status, 'Late') !== false) {
                        $status = 'Completed (Late)';
                        $status_code = 'COMPLETED_LATE';
                        $color = '#f59e0b'; // Amber / Orange
                        $badge_class = 'badge-warning';
                        $icon_class = 'icon-alarm-check';
                        $kpi_completed_late++;
                    } elseif (stripos($exec_status, 'Partial') !== false) {
                        $status = 'Partially Completed';
                        $status_code = 'PARTIAL';
                        $color = '#8b5cf6'; // Purple
                        $badge_class = 'badge-purple';
                        $icon_class = 'icon-checkmark-circle';
                        $kpi_completed_partial++;
                    } else {
                        $status = 'Completed';
                        $status_code = 'COMPLETED';
                        $color = '#10b981'; // Emerald Green
                        $badge_class = 'badge-success';
                        $icon_class = 'icon-checkmark3';
                        $kpi_completed_ontime++;
                    }
                } else {
                    // Not executed yet
                    if ($cur_date_str < $today_str) {
                        $status = 'Missed';
                        $status_code = 'MISSED';
                        $color = '#ef4444'; // Red
                        $badge_class = 'badge-danger';
                        $icon_class = 'icon-cross2';
                        $kpi_missed++;
                    } elseif ($cur_date_str === $today_str) {
                        $cur_now_ts = strtotime("{$today_str} {$current_time}");
                        $stime_ts = strtotime("{$today_str} {$stime}");

                        if ($cur_now_ts > $late_deadline_ts) {
                            $status = 'Missed / Expired';
                            $status_code = 'MISSED';
                            $color = '#ef4444'; // Red
                            $badge_class = 'badge-danger';
                            $icon_class = 'icon-cross2';
                            $kpi_missed++;
                        } elseif ($cur_now_ts >= $stime_ts && $cur_now_ts <= $late_deadline_ts) {
                            $status = 'Active (In Window)';
                            $status_code = 'ACTIVE';
                            $color = '#2563eb'; // Vibrant Blue
                            $badge_class = 'badge-primary';
                            $icon_class = 'icon-play';
                            $kpi_active++;
                        } else {
                            $status = 'Upcoming (Today)';
                            $status_code = 'UPCOMING';
                            $color = '#0284c7'; // Sky Blue
                            $badge_class = 'badge-info';
                            $icon_class = 'icon-alarm';
                            $kpi_upcoming++;
                        }
                    } else {
                        // Future date
                        $status = 'Upcoming';
                        $status_code = 'UPCOMING';
                        $color = '#64748b'; // Slate
                        $badge_class = 'badge-secondary';
                        $icon_class = 'icon-calendar';
                        $kpi_upcoming++;
                    }
                }

                $kpi_total_slots++;

                $start_iso = "{$cur_date_str}T{$stime}:00";
                $end_iso = "{$cur_date_str}T{$etime}:00";

                $events[] = [
                    'id' => "slot_{$assign_id}_{$cur_date_str}_" . preg_replace('/[^a-zA-Z0-9]/', '', $sname),
                    'title' => "{$sname} • {$a['asset_ref_no']}",
                    'start' => $start_iso,
                    'end' => $end_iso,
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'assignment_id' => $assign_id,
                        'assignment_ref_no' => $a['assignment_ref_no'],
                        'date' => $cur_date_str,
                        'slot_name' => $sname,
                        'start_time' => $stime,
                        'end_time' => $etime,
                        'late_deadline' => $late_deadline_time,
                        'status' => $status,
                        'status_code' => $status_code,
                        'status_color' => $color,
                        'status_badge' => $badge_class,
                        'status_icon' => $icon_class,
                        'customer_name' => $a['customer_name'] ?? 'N/A',
                        'location_name' => $a['location_name'] ?? 'N/A',
                        'building_name' => $a['building_name'] ?? 'N/A',
                        'asset_id' => (int)$a['asset_id'],
                        'asset_ref_no' => $a['asset_ref_no'],
                        'asset_description' => $a['asset_description'],
                        'checklist_id' => (int)$a['checklist_id'],
                        'checklist_name' => $a['checklist_name'],
                        'execution_id' => $exec ? (int)$exec['id'] : null,
                        'executed_at' => $exec ? $exec['created_at'] : null,
                        'distance_meters' => $exec ? $exec['distance_meters'] : null,
                        'scan_lat' => $exec ? $exec['scan_lat'] : null,
                        'scan_lng' => $exec ? $exec['scan_lng'] : null,
                        'remarks' => $exec ? $exec['remarks'] : null,
                    ]
                ];
            }

            $cur_ts = strtotime('+1 day', $cur_ts);
        }
    }

    $total_done = $kpi_completed_ontime + $kpi_completed_late + $kpi_completed_partial;
    $completion_rate = $kpi_total_slots > 0 ? round(($total_done / $kpi_total_slots) * 100, 1) : 0;
    $ontime_rate = $total_done > 0 ? round(($kpi_completed_ontime / $total_done) * 100, 1) : 0;

    echo json_encode([
        "status" => "success",
        "employee_id" => $employee_id,
        "employee_name" => $emp_row['employee_name'] ?? '',
        "employee_code" => $emp_code,
        "start_date" => $start_date,
        "end_date" => $end_date,
        "total_events" => count($events),
        "events" => $events,
        "kpis" => [
            "total_slots" => $kpi_total_slots,
            "completed_ontime" => $kpi_completed_ontime,
            "completed_late" => $kpi_completed_late,
            "completed_partial" => $kpi_completed_partial,
            "total_completed" => $total_done,
            "missed" => $kpi_missed,
            "active" => $kpi_active,
            "upcoming" => $kpi_upcoming,
            "completion_rate" => $completion_rate,
            "ontime_rate" => $ontime_rate
        ]
    ]);
    exit;
}

// -------------------------------------------------------------
// 4. GET SLOT FULL DETAILS & CHECKLIST POINTS BREAKDOWN
// -------------------------------------------------------------
else if ($action === 'get_slot_details') {
    $assignment_id = (int)($_REQUEST['assignment_id'] ?? 0);
    $date = mysqli_real_escape_string($conn, trim($_REQUEST['date'] ?? ''));
    $slot_name = mysqli_real_escape_string($conn, trim($_REQUEST['slot_name'] ?? ''));
    $execution_id = (int)($_REQUEST['execution_id'] ?? 0);

    if ($assignment_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid assignment ID"]);
        exit;
    }

    // Load assignment details
    $sql_a = "SELECT a.*, 
                     c.checklist_name,
                     ast.asset_ref_no, ast.asset_description, ast.asset_category_name, ast.asset_type_name,
                     ast.asset_sp_des, ast.zone_floor, ast.flat_area_code, ast.room_no,
                     ast.latitude as asset_latitude, ast.longitude as asset_longitude,
                     b.building_name, b.building_code, b.building_address, b.latitude as building_latitude, b.longitude as building_longitude,
                     cust.customer_name, cust.customer_code,
                     loc.location_name
              FROM tbl_janitor_assignments a
              LEFT JOIN tbl_janitor_checklists c ON a.checklist_id = c.id
              LEFT JOIN tbl_assets ast ON a.asset_id = ast.asset_id
              LEFT JOIN tbl_building b ON a.building_id = b.building_id
              LEFT JOIN tbl_customers cust ON a.customer_id = cust.customer_id
              LEFT JOIN tbl_location loc ON a.location_id = loc.location_id
              WHERE a.id = $assignment_id LIMIT 1";

    $res_a = mysqli_query($conn, $sql_a);
    $assignment = mysqli_fetch_assoc($res_a);
    if (!$assignment) {
        echo json_encode(["status" => "error", "message" => "Assignment record not found"]);
        exit;
    }

    // Determine effective asset coordinates
    $eff_asset_lat = !empty($assignment['asset_latitude']) ? $assignment['asset_latitude'] : $assignment['building_latitude'];
    $eff_asset_lng = !empty($assignment['asset_longitude']) ? $assignment['asset_longitude'] : $assignment['building_longitude'];
    $assignment['effective_asset_lat'] = $eff_asset_lat;
    $assignment['effective_asset_lng'] = $eff_asset_lng;

    // Load execution record if not specified by ID
    $execution = null;
    if ($execution_id > 0) {
        $exec_q = mysqli_query($conn, "SELECT * FROM tbl_janitor_execution_log WHERE id = $execution_id LIMIT 1");
        if ($exec_q && mysqli_num_rows($exec_q) > 0) {
            $execution = mysqli_fetch_assoc($exec_q);
        }
    } else if (!empty($date) && !empty($slot_name)) {
        $exec_q = mysqli_query($conn, "SELECT * FROM tbl_janitor_execution_log WHERE assignment_id = $assignment_id AND executed_date = '$date' AND executed_slot = '$slot_name' ORDER BY id DESC LIMIT 1");
        if ($exec_q && mysqli_num_rows($exec_q) > 0) {
            $execution = mysqli_fetch_assoc($exec_q);
        }
    }

    // Load checklist items
    $checklist_categories = [];

    if ($execution) {
        // Fetch executed points with completion state, remarks, and photos
        $exec_id = (int)$execution['id'];
        $sql_points = "SELECT ep.id as exec_point_id, ep.is_completed, ep.remarks, ep.photo_url,
                              i.item_description,
                              COALESCE(cat.category_name, 'General Checklist') as category_name
                       FROM tbl_janitor_execution_points ep
                       LEFT JOIN tbl_janitor_checklist_items i ON ep.checklist_item_id = i.id
                       LEFT JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id
                       WHERE ep.execution_id = $exec_id
                       ORDER BY cat.id ASC, i.id ASC";

        $res_points = mysqli_query($conn, $sql_points);
        if ($res_points) {
            while ($rp = mysqli_fetch_assoc($res_points)) {
                $cname = $rp['category_name'];
                if (!isset($checklist_categories[$cname])) {
                    $checklist_categories[$cname] = [];
                }
                $checklist_categories[$cname][] = [
                    'item_description' => $rp['item_description'],
                    'is_completed' => $rp['is_completed'],
                    'remarks' => $rp['remarks'],
                    'photo_url' => $rp['photo_url']
                ];
            }
        }

        // Map link
        $execution['scan_map_url'] = (!empty($execution['scan_lat']) && !empty($execution['scan_lng'])) 
            ? "https://www.google.com/maps?q={$execution['scan_lat']},{$execution['scan_lng']}" 
            : "";
        $execution['asset_map_url'] = (!empty($eff_asset_lat) && !empty($eff_asset_lng)) 
            ? "https://www.google.com/maps?q={$eff_asset_lat},{$eff_asset_lng}" 
            : "";
    } else {
        // Not executed: Load checklist template items so supervisor can see what tasks are expected
        $chk_id = (int)$assignment['checklist_id'];
        if ($chk_id > 0) {
            $sql_tpl = "SELECT i.id as item_id, i.item_description,
                               COALESCE(cat.category_name, 'General Checklist') as category_name
                        FROM tbl_janitor_checklist_items i
                        JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id
                        WHERE cat.checklist_id = $chk_id
                        ORDER BY cat.id ASC, i.id ASC";

            $res_tpl = mysqli_query($conn, $sql_tpl);
            if ($res_tpl) {
                while ($rt = mysqli_fetch_assoc($res_tpl)) {
                    $cname = $rt['category_name'];
                    if (!isset($checklist_categories[$cname])) {
                        $checklist_categories[$cname] = [];
                    }
                    $checklist_categories[$cname][] = [
                        'item_description' => $rt['item_description'],
                        'is_completed' => 'Pending',
                        'remarks' => 'Not executed yet',
                        'photo_url' => null
                    ];
                }
            }
        }
    }

    echo json_encode([
        "status" => "success",
        "assignment" => $assignment,
        "execution" => $execution,
        "checklist_categories" => $checklist_categories
    ]);
    exit;
}

else {
    echo json_encode(["status" => "error", "message" => "Unknown action"]);
    exit;
}
