<?php
/**
 * THC Data Sync Exporter (Deploy on Old Server: https://sianlab.com/thc/api/sync_export.php)
 * This script securely exports database tables in JSON batches for the new server.
 */

// Define the shared secret token
define('SYNC_SECURITY_TOKEN', 'thc_sync_secure_key_2026_x89');

ini_set('memory_limit', '512M');
set_time_limit(300);
header('Content-Type: application/json; charset=utf-8');

// 1. Verify Security Token
$provided_token = $_GET['token'] ?? $_POST['token'] ?? $_SERVER['HTTP_X_SYNC_TOKEN'] ?? '';
if (empty($provided_token) || $provided_token !== SYNC_SECURITY_TOKEN) {
    http_response_code(403);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized: Invalid or missing security token.'
    ]);
    exit;
}

// 2. Database Connection
// Check local or sianlab credentials
$host = "localhost";
$user = "sianlab_thc_user";
$pass = "s@nds1@b";
$db   = "sianlab_db_thc";

// Fallback for localhost / new server if running in other environments
$con = @mysqli_connect($host, $user, $pass, $db);
if (!$con) {
    // Try root / localhost
    $con = @mysqli_connect("localhost", "root", "S@nds1@b", "db_thc");
}
if (!$con) {
    // Try thcfm credentials
    $con = @mysqli_connect("localhost", "thcfm_application_user", "S@nds1@b", "thcfm_application_db");
}

if (!$con) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed on export server: ' . mysqli_connect_error()
    ]);
    exit;
}

mysqli_set_charset($con, "utf8mb4");

$action = $_GET['action'] ?? 'list_tables';

// ACTION: LIST TABLES & ROW COUNTS
if ($action === 'list_tables') {
    $tables = [];
    $res = mysqli_query($con, "SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
    while ($row = mysqli_fetch_row($res)) {
        $tbl_name = $row[0];
        $cnt_res = mysqli_query($con, "SELECT COUNT(*) FROM `$tbl_name`");
        $cnt = $cnt_res ? mysqli_fetch_row($cnt_res)[0] : 0;
        $tables[] = [
            'name' => $tbl_name,
            'rows' => (int)$cnt
        ];
    }
    
    echo json_encode([
        'status' => 'success',
        'server_time' => date('Y-m-d H:i:s'),
        'total_tables' => count($tables),
        'tables' => $tables
    ]);
    exit;
}

// ACTION: EXPORT TABLE DATA BATCH
if ($action === 'export_table') {
    $table = $_GET['table'] ?? '';
    $offset = (int)($_GET['offset'] ?? 0);
    $limit = (int)($_GET['limit'] ?? 1000);
    if ($limit > 5000) $limit = 5000;
    if ($limit < 1) $limit = 1000;

    // Validate table name to prevent SQL injection
    $check_res = mysqli_query($con, "SHOW TABLES LIKE '" . mysqli_real_escape_string($con, $table) . "'");
    if (!$check_res || mysqli_num_rows($check_res) === 0) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid table name: ' . htmlspecialchars($table)
        ]);
        exit;
    }

    $total_res = mysqli_query($con, "SELECT COUNT(*) FROM `$table`");
    $total_rows = $total_res ? (int)mysqli_fetch_row($total_res)[0] : 0;

    $query = "SELECT * FROM `$table` LIMIT $offset, $limit";
    $data_res = mysqli_query($con, $query);
    
    $rows = [];
    if ($data_res) {
        while ($row = mysqli_fetch_assoc($data_res)) {
            $rows[] = $row;
        }
    }

    echo json_encode([
        'status' => 'success',
        'table' => $table,
        'offset' => $offset,
        'limit' => $limit,
        'batch_count' => count($rows),
        'total_rows' => $total_rows,
        'has_more' => ($offset + count($rows)) < $total_rows,
        'rows' => $rows
    ]);
    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Invalid action specified. Supported actions: list_tables, export_table'
]);
