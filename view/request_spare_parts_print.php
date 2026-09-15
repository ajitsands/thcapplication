<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

date_default_timezone_set('Asia/Bahrain');

$filter_customer = isset($_GET['filter_customer']) ? (int)$_GET['filter_customer'] : 0;
$filter_workorder = isset($_GET['filter_workorder']) ? (int)$_GET['filter_workorder'] : 0;
$filter_item = isset($_GET['filter_item']) ? (int)$_GET['filter_item'] : 0;
$filter_status = isset($_GET['filter_status']) ? mysqli_real_escape_string($varDBConnection, $_GET['filter_status']) : 'ExceptCompleted';
$filter_from_date = isset($_GET['filter_from_date']) ? mysqli_real_escape_string($varDBConnection, $_GET['filter_from_date']) : '';
$filter_to_date = isset($_GET['filter_to_date']) ? mysqli_real_escape_string($varDBConnection, $_GET['filter_to_date']) : '';

$where = array();
$where[] = "1=1";
$filter_desc = array();

if ($filter_customer > 0) {
    $where[] = "r.customer_id = $filter_customer";
    $resC = mysqli_query($varDBConnection, "SELECT customer_name FROM tbl_customers WHERE customer_id = $filter_customer");
    if ($rowC = mysqli_fetch_assoc($resC)) $filter_desc[] = "Customer: " . $rowC['customer_name'];
}
if ($filter_workorder > 0) {
    $where[] = "r.workorder_id = $filter_workorder";
    $resW = mysqli_query($varDBConnection, "SELECT ticket_ref_code, ticket_id FROM tbl_tickets WHERE ticket_id = $filter_workorder");
    if ($rowW = mysqli_fetch_assoc($resW)) $filter_desc[] = "Workorder: WO-" . $rowW['ticket_ref_code'] . "-" . $rowW['ticket_id'];
}
if ($filter_status == 'ExceptCompleted') {
    $where[] = "r.status != 'Completed'";
    $filter_desc[] = "Status: All Except Completed";
} elseif ($filter_status != '' && $filter_status != 'All') {
    $where[] = "r.status = '$filter_status'";
    $filter_desc[] = "Status: $filter_status";
}
if ($filter_from_date != '') {
    $where[] = "DATE(r.request_date) >= '$filter_from_date'";
    $filter_desc[] = "From: " . date("d-m-Y", strtotime($filter_from_date));
}
if ($filter_to_date != '') {
    $where[] = "DATE(r.request_date) <= '$filter_to_date'";
    $filter_desc[] = "To: " . date("d-m-Y", strtotime($filter_to_date));
}
if ($filter_item > 0) {
    $where[] = "EXISTS (SELECT 1 FROM tbl_spare_parts_request_items ri WHERE ri.request_id = r.id AND ri.item_id = $filter_item)";
    $resI = mysqli_query($varDBConnection, "SELECT item_code FROM tbl_spare_parts_master WHERE id = $filter_item");
    if ($rowI = mysqli_fetch_assoc($resI)) $filter_desc[] = "Item: " . $rowI['item_code'];
}

$whereClause = implode(" AND ", $where);

$sqlList = "SELECT r.id, r.customer_id, c.customer_name, t.ticket_id, t.ticket_ref_code, t.ticket_ref_no, r.request_date, r.status
            FROM tbl_spare_parts_requests r 
            LEFT JOIN tbl_customers c ON r.customer_id = c.customer_id 
            LEFT JOIN tbl_tickets t ON r.workorder_id = t.ticket_id 
            WHERE $whereClause
            ORDER BY r.id DESC";

$result = mysqli_query($varDBConnection, $sqlList);
$req_list = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $req_list[] = $row;
    }
}
$total_requests = count($req_list);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Material Requests Report - Total (<?PHP echo $total_requests; ?>)</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        * { box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-size: 12px;
            color: #1e293b;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px 0 40px 0;
        }
        .report-container {
            width: 950px;
            margin: 0 auto;
            background: #ffffff;
            padding: 28px;
            border-radius: 8px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        }
        table.tbl-report {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #ffffff;
        }
        table.tbl-report th {
            background-color: #2e2e79 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 9px 10px;
            font-size: 11px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border: 1px solid #2e2e79;
            vertical-align: middle;
        }
        table.tbl-report td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            font-size: 11.5px;
            vertical-align: middle;
        }
        table.tbl-report tbody tr:nth-child(even) { background-color: #f8fafc; }
        table.tbl-report tbody tr:hover { background-color: #f1f5f9; }

        .badge-ref {
            display: inline-block;
            background-color: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 700;
            font-size: 11px;
            font-family: monospace;
        }

        .badge-status-completed {
            display: inline-block; background-color: #dcfce7; color: #15803d;
            border: 1px solid #86efac; border-radius: 4px; padding: 2px 7px; font-weight: 600; font-size: 10.5px;
        }
        .badge-status-partial {
            display: inline-block; background-color: #e0e7ff; color: #3730a3;
            border: 1px solid #c7d2fe; border-radius: 4px; padding: 2px 7px; font-weight: 600; font-size: 10.5px;
        }
        .badge-status-pending {
            display: inline-block; background-color: #fef3c7; color: #b45309;
            border: 1px solid #fde68a; border-radius: 4px; padding: 2px 7px; font-weight: 600; font-size: 10.5px;
        }
        .badge-status-closed {
            display: inline-block; background-color: #f1f5f9; color: #475569;
            border: 1px solid #cbd5e1; border-radius: 4px; padding: 2px 7px; font-weight: 600; font-size: 10.5px;
        }

        .stat-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; text-align: center; }
        .stat-num { font-size: 18px; font-weight: 700; color: #2e2e79; line-height: 1.2; }
        .stat-lbl { font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; margin-top: 2px; }

        .btn-action {
            background: #2e2e79; color: #ffffff; border: none; padding: 7px 15px; border-radius: 5px;
            cursor: pointer; font-weight: 600; font-size: 11.5px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-action:hover { background: #1e1e59; }
        .btn-excel { background: #0f766e; }
        .btn-excel:hover { background: #115e59; }
        .divFooter { margin-top: 20px; }

        @media print {
            body { background: #ffffff !important; padding: 0 !important; }
            .report-container { width: 100% !important; padding: 0 !important; box-shadow: none !important; border-radius: 0 !important; }
            .no-print { display: none !important; }
            .divFooter { position: fixed; bottom: 0; width: 100%; }
            .page-break-inside-avoid { page-break-inside: avoid; }
            body, table, td, th { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body>

<div class="report-container">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
        <div style="font-size: 12px; color: #64748b;">
            Document: <strong>Material Requests Report</strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-action" onclick="window.print();">
                <span>&#128438;</span> Print Report
            </button>
        </div>
    </div>

    <!-- Brand & Report Header -->
    <table style="width: 100%; border: none; border-collapse: collapse; margin-bottom: 16px;">
        <tbody>
            <tr>
                <td style="border: none; padding: 0; width: 50%; vertical-align: middle;">
                    <img src="global_assets/images/logo_print.png" alt="THC Logo" style="max-height: 70px; height: auto;" />
                </td>
                <td style="border: none; padding: 0; width: 50%; text-align: right; vertical-align: middle;">
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">MATERIAL REQUESTS REPORT</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                    <?php if (!empty($filter_desc)) { ?>
                        <div style="font-size: 10.5px; color: #475569; margin-top: 2px;">
                            <b>Filter:</b> <?PHP echo htmlspecialchars(implode(" | ", $filter_desc)); ?>
                        </div>
                    <?php } else { ?>
                        <div style="font-size: 10.5px; color: #475569; margin-top: 2px;">
                            <b>Filter:</b> All Records
                        </div>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Quick Stats Cards (No Print / Subtle Print) -->
    <table style="width: 100%; border: none; border-collapse: separate; border-spacing: 8px 0; margin-bottom: 18px;" class="page-break-inside-avoid">
        <tbody>
            <tr>
                <td class="stat-box" style="width: 100%;">
                    <div class="stat-num" style="color: #2e2e79;"><?PHP echo $total_requests; ?></div>
                    <div class="stat-lbl">Total Requests Found</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Main Data Table -->
    <div id="main_table">
        <table class="tbl-report">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">SL</th>
                    <th style="width: 120px; text-align: left;">Request ID</th>
                    <th style="text-align: left;">Customer</th>
                    <th style="width: 150px; text-align: left;">Workorder</th>
                    <th style="width: 150px; text-align: center;">Date</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                if ($total_requests > 0) {
                    $ctr = 1;
                    foreach ($req_list as $row_t) {
                        $req_id_format = "THC-MREQ-" . $row_t['id'];
                        
                        $wo_format = "-";
                        if (!empty($row_t['ticket_id'])) {
                            $wo_format = "WO-" . $row_t['ticket_ref_code'] . "-" . $row_t['ticket_id'];
                        }

                        $status = $row_t['status'];
                        if ($status == 'Completed') {
                            $status_badge = '<span class="badge-status-completed">Completed</span>';
                        } elseif ($status == 'Partial Issue') {
                            $status_badge = '<span class="badge-status-partial">Partial Issue</span>';
                        } elseif ($status == 'Pending') {
                            $status_badge = '<span class="badge-status-pending">Pending</span>';
                        } else {
                            $status_badge = '<span class="badge-status-closed">Closed</span>';
                        }

                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $ctr; ?></td>
                            <td><span class="badge-ref"><?PHP echo htmlspecialchars($req_id_format); ?></span></td>
                            <td><strong><?PHP echo htmlspecialchars($row_t['customer_name']); ?></strong></td>
                            <td><?PHP echo htmlspecialchars($wo_format); ?></td>
                            <td style="text-align: center;"><?PHP echo date('d-m-Y h:i A', strtotime($row_t['request_date'])); ?></td>
                            <td style="text-align: center;"><?PHP echo $status_badge; ?></td>
                        </tr>
                        <?PHP 
                        $ctr++;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 24px; color: #64748b; font-style: italic;">
                            No material requests found matching the criteria.
                        </td>
                    </tr>
                    <?PHP 
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Official THC Footer -->
    <div class="divFooter page-break-inside-avoid">
        <table style="width: 100%; border: none; border-collapse: collapse; background-color: #2e2e79; border-radius: 6px; overflow: hidden;">
            <tbody>
                <tr>
                    <td style="border: none; padding: 12px 18px; color: #ffffff; line-height: 1.5; width: 68%;">
                        <div style="font-size: 11px;">
                            <small>Tele:</small> +973 17 100 190 &nbsp;|&nbsp; info@thc.com.bh &nbsp;|&nbsp; <strong>www.thc.com.bh</strong><br>
                            CR. <strong>88982-1</strong> &nbsp;|&nbsp; Level 14, Entrance 143/144, Bldg 155, Road 1703, Block 317<br>
                            <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
                        </div>
                    </td>
                    <td style="border: none; text-align: right; padding: 12px 18px; width: 32%; vertical-align: middle;">
                        <img src="global_assets/images/a.png" alt="THC Emblem" style="max-height: 38px;" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
