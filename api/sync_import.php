<?php
/**
 * THC Data Sync Importer (Runs on New Server: https://portal.thcfm.com/api/sync_import.php)
 * Pulls latest records from Old Server (https://sianlab.com/thc/api/sync_export.php) and updates thcfm_application_db.
 */

define('SYNC_SECURITY_TOKEN', 'thc_sync_secure_key_2026_x89');
define('DEFAULT_OLD_SERVER_URL', 'https://sianlab.com/thc/api/sync_export.php');

ini_set('memory_limit', '1024M');
set_time_limit(600);

require_once __DIR__ . '/../model/db_connection/connection.php';
$db_obj = new DBConnection();
$con = $db_obj->ConnectToMYSQL();

if (!$con) {
    die("Database connection failed on New Server: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");

// Auto-create sync history table if not exists
mysqli_query($con, "CREATE TABLE IF NOT EXISTS `tbl_sync_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sync_date` DATETIME NOT NULL,
    `source_url` VARCHAR(255) NOT NULL,
    `tables_synced` INT DEFAULT 0,
    `total_records_synced` INT DEFAULT 0,
    `status` VARCHAR(50) DEFAULT 'Success',
    `details` LONGTEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Check Authentication if invoked via Webhook or Cron
$is_cli = (php_sapi_name() === 'cli');
$provided_token = $_GET['token'] ?? $_POST['token'] ?? '';
$is_admin_session = false;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['username']) || !empty($_SESSION['loggedin'])) {
    $is_admin_session = true;
}

if (!$is_cli && !$is_admin_session && $provided_token !== SYNC_SECURITY_TOKEN) {
    http_response_code(403);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized: Please log in or provide valid ?token=' . SYNC_SECURITY_TOKEN
    ]);
    exit;
}

$old_server_url = $_GET['source_url'] ?? $_POST['source_url'] ?? DEFAULT_OLD_SERVER_URL;
$specific_table = $_GET['table'] ?? $_POST['table'] ?? '';
$action = $_GET['action'] ?? $_POST['action'] ?? 'run_sync';

// Helper function to fetch data via cURL
function fetch_from_old_server($url, $params = []) {
    $params['token'] = SYNC_SECURITY_TOKEN;
    $full_url = $url . '?' . http_build_query($params);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_USERAGENT, 'THC-Sync-Client/2.0');
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($response === false || !empty($error)) {
        return ['status' => 'error', 'message' => "cURL Error: $error (HTTP $http_code)"];
    }
    
    $json = json_decode($response, true);
    if (!$json) {
        return ['status' => 'error', 'message' => "Invalid JSON from Old Server. Response snippet: " . substr(strip_tags($response), 0, 300)];
    }
    
    return $json;
}

// 1. If Action is list tables
if ($action === 'list_tables') {
    header('Content-Type: application/json');
    $res = fetch_from_old_server($old_server_url, ['action' => 'list_tables']);
    echo json_encode($res);
    exit;
}

// 2. Perform Synchronization
if ($action === 'run_sync') {
    // Disable Foreign Key Checks during bulk upsert
    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
    mysqli_query($con, "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");

    $list_res = fetch_from_old_server($old_server_url, ['action' => 'list_tables']);
    if ($list_res['status'] !== 'success') {
        if (!empty($_GET['json']) || $is_cli) {
            header('Content-Type: application/json');
            echo json_encode($list_res);
            exit;
        } else {
            die("<h3 style='color:red;'>Sync Error: " . htmlspecialchars($list_res['message'] ?? 'Could not connect to Old Server.') . "</h3><p>Make sure <code>api/sync_export.php</code> is uploaded to <b>$old_server_url</b>.</p>");
        }
    }

    $tables_to_sync = $list_res['tables'];
    if (!empty($specific_table)) {
        $tables_to_sync = array_filter($tables_to_sync, function($t) use ($specific_table) {
            return $t['name'] === $specific_table;
        });
    }

    $summary = [];
    $total_records_inserted = 0;
    $total_tables_synced = 0;

    foreach ($tables_to_sync as $tbl_info) {
        $tbl_name = $tbl_info['name'];
        $old_total = $tbl_info['rows'];

        // Skip non-data or internal cache tables if needed
        if ($tbl_name === 'tbl_sync_history') continue;

        $offset = 0;
        $limit = 1000;
        $synced_for_table = 0;
        $has_more = true;

        while ($has_more) {
            $batch_res = fetch_from_old_server($old_server_url, [
                'action' => 'export_table',
                'table' => $tbl_name,
                'offset' => $offset,
                'limit' => $limit
            ]);

            if ($batch_res['status'] !== 'success' || empty($batch_res['rows'])) {
                break;
            }

            $rows = $batch_res['rows'];
            $batch_count = count($rows);

            if ($batch_count > 0) {
                // Construct REPLACE INTO batch
                $columns = array_keys($rows[0]);
                $col_names = '`' . implode('`, `', $columns) . '`';
                
                $val_chunks = [];
                foreach ($rows as $row) {
                    $escaped = array_map(function($v) use ($con) {
                        if ($v === null) return 'NULL';
                        return "'" . mysqli_real_escape_string($con, $v) . "'";
                    }, array_values($row));
                    $val_chunks[] = "(" . implode(", ", $escaped) . ")";
                }

                $query = "REPLACE INTO `$tbl_name` ($col_names) VALUES " . implode(", ", $val_chunks);
                $exec = mysqli_query($con, $query);
                if (!$exec) {
                    $summary[$tbl_name] = [
                        'status' => 'error',
                        'error' => mysqli_error($con),
                        'synced' => $synced_for_table
                    ];
                    break;
                }
                $synced_for_table += $batch_count;
                $total_records_inserted += $batch_count;
            }

            $has_more = $batch_res['has_more'] ?? false;
            $offset += $batch_count;
        }

        $total_tables_synced++;
        if (!isset($summary[$tbl_name])) {
            $summary[$tbl_name] = [
                'status' => 'success',
                'records_synced' => $synced_for_table,
                'source_total' => $old_total
            ];
        }
    }

    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

    // Save to sync history
    $details_json = mysqli_real_escape_string($con, json_encode($summary));
    $now = date('Y-m-d H:i:s');
    mysqli_query($con, "INSERT INTO `tbl_sync_history` (`sync_date`, `source_url`, `tables_synced`, `total_records_synced`, `status`, `details`) 
        VALUES ('$now', '$old_server_url', $total_tables_synced, $total_records_inserted, 'Success', '$details_json')");

    $result_payload = [
        'status' => 'success',
        'message' => "Successfully synchronized $total_records_inserted records across $total_tables_synced tables from Old Server.",
        'sync_time' => $now,
        'source_url' => $old_server_url,
        'total_tables_synced' => $total_tables_synced,
        'total_records_synced' => $total_records_inserted,
        'details' => $summary
    ];

    if (!empty($_GET['json']) || $is_cli) {
        header('Content-Type: application/json');
        echo json_encode($result_payload, JSON_PRETTY_PRINT);
        exit;
    }

    // HTML Output for Browser View
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Database Sync from Old Server - THC Portal</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body { background: #f4f6f9; padding: 30px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
            .card { border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
            .badge-success { background-color: #28a745; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">🔄 Database Synchronization Completed</h3>
                    <a href="../view/dashboard.php" class="btn btn-outline-secondary">Go to Dashboard</a>
                </div>
                <div class="alert alert-success">
                    <strong>Sync Status:</strong> <?php echo $result_payload['message']; ?><br>
                    <small><b>Timestamp:</b> <?php echo $now; ?> | <b>Source:</b> <?php echo htmlspecialchars($old_server_url); ?></small>
                </div>
                
                <div class="row text-center mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <h4 class="text-primary mb-0"><?php echo $total_tables_synced; ?></h4>
                            <small class="text-muted">Tables Synchronized</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <h4 class="text-success mb-0"><?php echo number_format($total_records_inserted); ?></h4>
                            <small class="text-muted">Total Records Updated / Inserted</small>
                        </div>
                    </div>
                </div>

                <h5>Table-by-Table Sync Summary:</h5>
                <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                    <table class="table table-bordered table-sm table-striped">
                        <thead class="thead-dark" style="position: sticky; top: 0;">
                            <tr>
                                <th>Table Name</th>
                                <th>Source Total</th>
                                <th>Synced Rows</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($summary as $tname => $tdata): ?>
                            <tr>
                                <td><code><?php echo htmlspecialchars($tname); ?></code></td>
                                <td><?php echo isset($tdata['source_total']) ? number_format($tdata['source_total']) : '-'; ?></td>
                                <td><?php echo isset($tdata['records_synced']) ? number_format($tdata['records_synced']) : ($tdata['synced'] ?? 0); ?></td>
                                <td>
                                    <?php if ($tdata['status'] === 'success'): ?>
                                        <span class="badge badge-success">OK</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><?php echo htmlspecialchars($tdata['error'] ?? 'Error'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <a href="sync_import.php?token=<?php echo SYNC_SECURITY_TOKEN; ?>" class="btn btn-primary btn-lg">🔄 Run Sync Again Now</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}
