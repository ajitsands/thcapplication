<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

require_once(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (!$conn) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : 'get_settings');

if ($action == 'get_settings') {
    $res = mysqli_query($conn, "SELECT * FROM tbl_janitor_settings ORDER BY id ASC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        echo json_encode([
            "status" => "success",
            "data" => [
                "id" => (int)$row['id'],
                "min_radius_meters" => (float)$row['min_radius_meters'],
                "late_time_minutes" => (int)$row['late_time_minutes'],
                "allow_gps_bypass" => $row['allow_gps_bypass'] ?? 'NO',
                "updated_at" => $row['updated_at'],
                "updated_by" => $row['updated_by'] ?? 'System'
            ]
        ]);
    } else {
        // Fallback default
        echo json_encode([
            "status" => "success",
            "data" => [
                "id" => 1,
                "min_radius_meters" => 200.0,
                "late_time_minutes" => 15,
                "allow_gps_bypass" => 'NO',
                "updated_at" => date('Y-m-d H:i:s'),
                "updated_by" => 'System'
            ]
        ]);
    }
    exit;
}

if ($action == 'save_settings') {
    $min_radius = isset($_POST['min_radius_meters']) ? (float)$_POST['min_radius_meters'] : 200.0;
    $late_minutes = isset($_POST['late_time_minutes']) ? (int)$_POST['late_time_minutes'] : 15;
    $allow_bypass = isset($_POST['allow_gps_bypass']) && in_array(strtoupper($_POST['allow_gps_bypass']), ['YES', 'NO']) ? strtoupper($_POST['allow_gps_bypass']) : 'NO';
    
    // Validation
    if ($min_radius <= 0) {
        echo json_encode(["status" => "error", "message" => "Minimum radius must be greater than 0 meters."]);
        exit;
    }
    if ($late_minutes < 0) {
        echo json_encode(["status" => "error", "message" => "Late time minutes cannot be negative."]);
        exit;
    }

    $updated_by = isset($_SESSION['username']) ? $_SESSION['username'] : (isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin');
    $updated_by = mysqli_real_escape_string($conn, $updated_by);

    // Check if row exists
    $chk = mysqli_query($conn, "SELECT id FROM tbl_janitor_settings ORDER BY id ASC LIMIT 1");
    if ($chk && mysqli_num_rows($chk) > 0) {
        $row = mysqli_fetch_assoc($chk);
        $setting_id = (int)$row['id'];
        $sql = "UPDATE tbl_janitor_settings SET 
                    min_radius_meters = '$min_radius',
                    late_time_minutes = '$late_minutes',
                    allow_gps_bypass = '$allow_bypass',
                    updated_by = '$updated_by',
                    updated_at = NOW()
                WHERE id = $setting_id";
    } else {
        $sql = "INSERT INTO tbl_janitor_settings (min_radius_meters, late_time_minutes, allow_gps_bypass, updated_by, updated_at) 
                VALUES ('$min_radius', '$late_minutes', '$allow_bypass', '$updated_by', NOW())";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "status" => "success",
            "message" => "Janitor settings saved successfully!",
            "data" => [
                "min_radius_meters" => $min_radius,
                "late_time_minutes" => $late_minutes,
                "allow_gps_bypass" => $allow_bypass,
                "updated_by" => $updated_by,
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to save settings: " . mysqli_error($conn)
        ]);
    }
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid action specified."]);
exit;
?>
