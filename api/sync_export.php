<?php
/**
 * THC Data Sync Exporter (Deploy on Old Server: https://sianlab.com/thc/api/sync_export.php)
 * Works across all PHP versions (PHP 5.4 to 8.4+)
 */

// Error reporting & debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}

// Define the shared secret token
define('SYNC_SECURITY_TOKEN', 'thc_sync_secure_key_2026_x89');

ini_set('memory_limit', '512M');
if (function_exists('set_time_limit')) {
    @set_time_limit(300);
}
header('Content-Type: application/json; charset=utf-8');

// 1. Verify Security Token (PHP 5.4+ compatible)
$provided_token = '';
if (isset($_GET['token'])) {
    $provided_token = $_GET['token'];
} elseif (isset($_POST['token'])) {
    $provided_token = $_POST['token'];
} elseif (isset($_SERVER['HTTP_X_SYNC_TOKEN'])) {
    $provided_token = $_SERVER['HTTP_X_SYNC_TOKEN'];
}

if (empty($provided_token) || $provided_token !== SYNC_SECURITY_TOKEN) {
    if (function_exists('http_response_code')) {
        http_response_code(403);
    }
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Unauthorized: Invalid or missing security token.'
    ));
    exit;
}

// 2. Database Connection Attempts
$connections_to_try = array(
    array('host' => 'localhost', 'user' => 'sianlab_thc_user', 'pass' => 's@nds1@b', 'db' => 'sianlab_db_thc'),
    array('host' => 'localhost', 'user' => 'sianlab_thc_user', 'pass' => 'S@nds1@b', 'db' => 'sianlab_db_thc'),
    array('host' => '127.0.0.1', 'user' => 'sianlab_thc_user', 'pass' => 's@nds1@b', 'db' => 'sianlab_db_thc'),
    array('host' => 'localhost', 'user' => 'root', 'pass' => 'S@nds1@b', 'db' => 'db_thc'),
    array('host' => 'localhost', 'user' => 'thcfm_application_user', 'pass' => 'S@nds1@b', 'db' => 'thcfm_application_db')
);

$con = false;
$last_error = '';

foreach ($connections_to_try as $cfg) {
    $con = @mysqli_connect($cfg['host'], $cfg['user'], $cfg['pass'], $cfg['db']);
    if ($con) {
        break;
    } else {
        $last_error = mysqli_connect_error();
    }
}

if (!$con) {
    if (function_exists('http_response_code')) {
        http_response_code(500);
    }
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Database connection failed on export server: ' . $last_error
    ));
    exit;
}

mysqli_set_charset($con, "utf8mb4");

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : 'list_tables');

// ACTION: LIST TABLES & ROW COUNTS
if ($action === 'list_tables') {
    $tables = array();
    $res = mysqli_query($con, "SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
    if ($res) {
        while ($row = mysqli_fetch_row($res)) {
            $tbl_name = $row[0];
            $cnt_res = mysqli_query($con, "SELECT COUNT(*) FROM `$tbl_name`");
            $cnt = $cnt_res ? mysqli_fetch_row($cnt_res)[0] : 0;
            $tables[] = array(
                'name' => $tbl_name,
                'rows' => (int)$cnt
            );
        }
    }
    
    echo json_encode(array(
        'status' => 'success',
        'server_time' => date('Y-m-d H:i:s'),
        'total_tables' => count($tables),
        'tables' => $tables
    ));
    exit;
}

// ACTION: EXPORT TABLE DATA BATCH
if ($action === 'export_table') {
    $table = isset($_GET['table']) ? $_GET['table'] : '';
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 1000;
    if ($limit > 5000) $limit = 5000;
    if ($limit < 1) $limit = 1000;

    // Validate table name
    $check_res = mysqli_query($con, "SHOW TABLES LIKE '" . mysqli_real_escape_string($con, $table) . "'");
    if (!$check_res || mysqli_num_rows($check_res) === 0) {
        if (function_exists('http_response_code')) {
            http_response_code(400);
        }
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Invalid table name: ' . htmlspecialchars($table)
        ));
        exit;
    }

    $total_res = mysqli_query($con, "SELECT COUNT(*) FROM `$table`");
    $total_rows = $total_res ? (int)mysqli_fetch_row($total_res)[0] : 0;

    $query = "SELECT * FROM `$table` LIMIT $offset, $limit";
    $data_res = mysqli_query($con, $query);
    
    $rows = array();
    if ($data_res) {
        while ($row = mysqli_fetch_assoc($data_res)) {
            $rows[] = $row;
        }
    }

    echo json_encode(array(
        'status' => 'success',
        'table' => $table,
        'offset' => $offset,
        'limit' => $limit,
        'batch_count' => count($rows),
        'total_rows' => $total_rows,
        'has_more' => ($offset + count($rows)) < $total_rows,
        'rows' => $rows
    ));
    exit;
}

echo json_encode(array(
    'status' => 'error',
    'message' => 'Invalid action specified.'
));
