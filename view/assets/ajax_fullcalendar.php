<?php
if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

include(__DIR__ . '/../../model/db_connection/connection.php');
$connection = new DBConnection();
$conn = $connection->ConnectToMYSQL();

$data = array();

if (!$conn) {
    echo json_encode($data);
    exit;
}

$where = " WHERE 1=1 ";

// FullCalendar passes 'start' and 'end' parameters (e.g. 2026-10-25 and 2026-12-06 for month view)
if (!empty($_GET['start'])) {
    $start_raw = trim($_GET['start']);
    if (is_numeric($start_raw)) {
        $start_str = date('Y-m-d', (int)$start_raw);
    } else {
        $start_str = substr($start_raw, 0, 10);
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_str)) {
        $safe_start = mysqli_real_escape_string($conn, $start_str);
        $where .= " AND date_of_visits >= '$safe_start' ";
    }
}

if (!empty($_GET['end'])) {
    $end_raw = trim($_GET['end']);
    if (is_numeric($end_raw)) {
        $end_str = date('Y-m-d', (int)$end_raw);
    } else {
        $end_str = substr($end_raw, 0, 10);
    }
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $end_str)) {
        $safe_end = mysqli_real_escape_string($conn, $end_str);
        $where .= " AND date_of_visits <= '$safe_end' ";
    }
}

$query = "SELECT amc_visit_id, amc_tkt_id, amc_tkt_ref_no, amc_ticket, customer_code, customer_name, 
          date_of_visits, DATE_FORMAT(`date_of_visits`, '%d ,%M %Y') AS date_of_visits1, time_of_visit, 
          amc_visit_status, 
          CASE 
              WHEN amc_visit_status='Scheduled' THEN '#39C0ED' 
              WHEN amc_visit_status='Assigned' THEN '#3F51B5'  
              WHEN amc_visit_status='Completed' THEN '#795548' 
              WHEN amc_visit_status='Closed' THEN '#4CAF50' 
              WHEN amc_visit_status='Cancelled' THEN '#B23CFD' 
              WHEN amc_visit_status='Extended' THEN '#FFC107' 
              ELSE '#39C0ED' 
          END AS amc_schedule_color, 
          visit_mode, additional_slots, visit_start_time,
          building_name, location_name
          FROM tbl_visits 
          $where
          GROUP BY amc_tkt_ref_no, date_of_visits, visit_start_time";

$result = mysqli_query($conn, $query); 

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id' => $row["amc_visit_id"],
            'title' => $row["amc_tkt_ref_no"],
            'start' => $row['date_of_visits'] . 'T' . $row['visit_start_time'],
            'end' => $row["date_of_visits"],
            'backgroundColor' => $row["amc_schedule_color"],
            'borderColor' => $row["amc_schedule_color"],
            'visit_mode' => $row["visit_mode"],
            'amc_status' => $row["amc_visit_status"],
            'amc_tkt_id' => $row["amc_tkt_id"],
            'customer_name' => $row["customer_name"],
            'customer_code' => $row["customer_code"],
            'amc_ticket' => $row["amc_ticket"],
            'additional_slots' => $row["additional_slots"],
            'visit_start_time' => $row["visit_start_time"],
            'start_slot' => $row["time_of_visit"],
            'date_of_visits1' => $row["date_of_visits1"],
            'date_of_visits_val' => $row["date_of_visits"],
            'building_name' => isset($row["building_name"]) ? $row["building_name"] : '',
            'location_name' => isset($row["location_name"]) ? $row["location_name"] : '',
        );
    }
    mysqli_free_result($result);
}

echo json_encode($data);
?>
