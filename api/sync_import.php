<?php
/**
 * THC Data Sync Importer (Runs on New Server: https://portal.thcfm.com/api/sync_import.php)
 * Real-time AJAX & CLI sync from Old Server (https://sianlab.com/thc/api/sync_export.php) to thcfm_application_db.
 */

define('SYNC_SECURITY_TOKEN', 'thc_sync_secure_key_2026_x89');
define('DEFAULT_OLD_SERVER_URL', 'https://sianlab.com/thc/api/sync_export.php');

ini_set('memory_limit', '1024M');
if (function_exists('set_time_limit')) {
    @set_time_limit(600);
}

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

// Check Authentication
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
$action = $_GET['action'] ?? $_POST['action'] ?? 'ui';

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
        return ['status' => 'error', 'message' => "Invalid JSON from Old Server. Response: " . substr(strip_tags($response), 0, 300)];
    }
    
    return $json;
}

// 1. API: List Tables from Old Server
if ($action === 'list_tables') {
    header('Content-Type: application/json');
    $res = fetch_from_old_server($old_server_url, ['action' => 'list_tables']);
    echo json_encode($res);
    exit;
}

// 2. API: Sync a Single Table
if ($action === 'sync_single_table') {
    header('Content-Type: application/json');
    $tbl_name = $_GET['table'] ?? $_POST['table'] ?? '';
    if (empty($tbl_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing table parameter']);
        exit;
    }

    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
    mysqli_query($con, "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");

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
                mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");
                echo json_encode([
                    'status' => 'error',
                    'table' => $tbl_name,
                    'message' => mysqli_error($con),
                    'synced' => $synced_for_table
                ]);
                exit;
            }
            $synced_for_table += $batch_count;
        }

        $has_more = $batch_res['has_more'] ?? false;
        $offset += $batch_count;
    }

    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");

    echo json_encode([
        'status' => 'success',
        'table' => $tbl_name,
        'records_synced' => $synced_for_table
    ]);
    exit;
}

// 3. Full CLI/Background Sync
if ($action === 'run_sync' && $is_cli) {
    // CLI execution
    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 0");
    $list_res = fetch_from_old_server($old_server_url, ['action' => 'list_tables']);
    $total_records = 0;
    $total_tables = 0;
    if ($list_res['status'] === 'success') {
        foreach ($list_res['tables'] as $t) {
            $tbl = $t['name'];
            $offset = 0;
            $has_more = true;
            while ($has_more) {
                $batch_res = fetch_from_old_server($old_server_url, ['action' => 'export_table', 'table' => $tbl, 'offset' => $offset, 'limit' => 1000]);
                if ($batch_res['status'] !== 'success' || empty($batch_res['rows'])) break;
                $rows = $batch_res['rows'];
                $count = count($rows);
                if ($count > 0) {
                    $cols = '`' . implode('`, `', array_keys($rows[0])) . '`';
                    $vals = [];
                    foreach ($rows as $row) {
                        $esc = array_map(function($v) use ($con) { return $v === null ? 'NULL' : "'" . mysqli_real_escape_string($con, $v) . "'"; }, array_values($row));
                        $vals[] = "(" . implode(", ", $esc) . ")";
                    }
                    mysqli_query($con, "REPLACE INTO `$tbl` ($cols) VALUES " . implode(", ", $vals));
                    $total_records += $count;
                }
                $has_more = $batch_res['has_more'] ?? false;
                $offset += $count;
            }
            $total_tables++;
        }
    }
    mysqli_query($con, "SET FOREIGN_KEY_CHECKS = 1");
    echo json_encode(['status' => 'success', 'tables' => $total_tables, 'records' => $total_records]);
    exit;
}

// 4. Live Interactive UI with Progress Bar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Database Synchronization - THC Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background: #f0f2f5; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 25px; }
        .card { border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .progress { height: 26px; border-radius: 13px; font-weight: bold; font-size: 14px; }
        .status-badge { font-size: 12px; padding: 4px 8px; border-radius: 6px; }
        .table-wrap { max-height: 480px; overflow-y: auto; }
        .spinner { display: inline-block; width: 14px; height: 14px; border: 2px solid #ccc; border-top-color: #007bff; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">🔄 Old Server &rarr; New Server Database Sync</h3>
                <a href="../view/dashboard.php" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
            </div>

            <div class="alert alert-info">
                <b>Source Server:</b> <code><?php echo htmlspecialchars($old_server_url); ?></code><br>
                <b>Target Database:</b> <code>thcfm_application_db</code> on <code>portal.thcfm.com</code>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                    <span id="sync_status_text"><b>Status:</b> Ready to sync. Click "Start Sync" below.</span>
                    <span id="sync_percent_text"><b>0%</b></span>
                </div>
                <div class="progress">
                    <div id="progress_bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 0%;">0%</div>
                </div>
            </div>

            <div class="mb-3 text-center">
                <button id="btn_start_sync" class="btn btn-primary btn-lg px-5 font-weight-bold">▶ Start Live Sync</button>
            </div>

            <div class="row text-center mb-3">
                <div class="col-md-4">
                    <div class="p-2 bg-light rounded border">
                        <small class="text-muted">Total Tables</small>
                        <h4 id="stat_total_tables" class="text-primary mb-0">-</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2 bg-light rounded border">
                        <small class="text-muted">Tables Processed</small>
                        <h4 id="stat_processed_tables" class="text-info mb-0">0</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2 bg-light rounded border">
                        <small class="text-muted">Total Records Synced</small>
                        <h4 id="stat_total_records" class="text-success mb-0">0</h4>
                    </div>
                </div>
            </div>

            <h5 class="mt-3">Sync Progress Details:</h5>
            <div class="table-wrap">
                <table class="table table-sm table-bordered table-striped" id="tbl_progress">
                    <thead class="thead-dark" style="position: sticky; top: 0;">
                        <tr>
                            <th width="40%">Table Name</th>
                            <th width="20%">Old Server Rows</th>
                            <th width="20%">Synced Records</th>
                            <th width="20%">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_body">
                        <tr><td colspan="4" class="text-center text-muted">Click "Start Live Sync" to fetch tables list.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    const token = '<?php echo SYNC_SECURITY_TOKEN; ?>';
    let tablesList = [];
    let currentIndex = 0;
    let totalRecordsSynced = 0;

    $('#btn_start_sync').click(function() {
        $(this).prop('disabled', true).text('⏳ Synchronizing Data...');
        $('#sync_status_text').html('<b>Status:</b> Fetching table directory from Old Server...');
        
        $.getJSON('sync_import.php', { action: 'list_tables', token: token }, function(res) {
            if (res.status !== 'success') {
                alert('Error fetching tables: ' + (res.message || 'Unknown error'));
                $('#btn_start_sync').prop('disabled', false).text('▶ Start Live Sync');
                return;
            }

            tablesList = res.tables;
            $('#stat_total_tables').text(tablesList.length);
            $('#tbl_body').empty();

            tablesList.forEach(function(t, idx) {
                $('#tbl_body').append(
                    `<tr id="row_${idx}">
                        <td><code>${t.name}</code></td>
                        <td>${t.rows.toLocaleString()}</td>
                        <td id="synced_${idx}">-</td>
                        <td id="status_${idx}"><span class="badge badge-secondary">Pending</span></td>
                    </tr>`
                );
            });

            currentIndex = 0;
            totalRecordsSynced = 0;
            syncNextTable();
        }).fail(function(xhr) {
            alert('Failed to connect to sync server: ' + xhr.responseText);
            $('#btn_start_sync').prop('disabled', false).text('▶ Start Live Sync');
        });
    });

    function syncNextTable() {
        if (currentIndex >= tablesList.length) {
            $('#progress_bar').css('width', '100%').text('100% Complete');
            $('#sync_percent_text').html('<b>100%</b>');
            $('#sync_status_text').html('<b>Status:</b> <span class="text-success font-weight-bold">✅ Synchronization Completed Successfully!</span>');
            $('#btn_start_sync').prop('disabled', false).text('🔄 Run Sync Again');
            return;
        }

        const t = tablesList[currentIndex];
        const idx = currentIndex;

        $('#status_' + idx).html('<span class="spinner mr-1"></span> <span class="text-primary font-weight-bold">Syncing...</span>');
        $('#sync_status_text').html(`<b>Status:</b> Syncing table <code>${t.name}</code> (${idx + 1} of ${tablesList.length})...`);

        // Auto-scroll table into view
        const rowElem = document.getElementById('row_' + idx);
        if (rowElem) rowElem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        $.getJSON('sync_import.php', {
            action: 'sync_single_table',
            table: t.name,
            token: token
        }, function(res) {
            if (res.status === 'success') {
                const count = res.records_synced;
                totalRecordsSynced += count;
                $('#synced_' + idx).text(count.toLocaleString());
                $('#status_' + idx).html('<span class="badge badge-success">✓ Synced</span>');
            } else {
                $('#status_' + idx).html(`<span class="badge badge-danger" title="${res.message || 'Error'}">Error</span>`);
            }

            $('#stat_processed_tables').text(idx + 1);
            $('#stat_total_records').text(totalRecordsSynced.toLocaleString());

            const percent = Math.round(((idx + 1) / tablesList.length) * 100);
            $('#progress_bar').css('width', percent + '%').text(percent + '%');
            $('#sync_percent_text').html('<b>' + percent + '%</b>');

            currentIndex++;
            syncNextTable();
        }).fail(function() {
            $('#status_' + idx).html('<span class="badge badge-warning">Timeout/Skipped</span>');
            currentIndex++;
            syncNextTable();
        });
    }

    // Auto-start sync on page load if ?auto=1 in URL
    if (window.location.search.indexOf('auto=1') !== -1) {
        setTimeout(function() { $('#btn_start_sync').click(); }, 500);
    }
    </script>
</body>
</html>
