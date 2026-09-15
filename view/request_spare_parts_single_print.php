<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

date_default_timezone_set('Asia/Bahrain');

$request_id = isset($_GET['request_id']) ? (int)$_GET['request_id'] : 0;

if ($request_id <= 0) {
    die("Invalid Request ID");
}

// Fetch Request Details
$sqlReq = "SELECT r.id, r.customer_id, c.customer_name, t.ticket_id, t.ticket_ref_code, t.ticket_ref_no, r.request_date, r.status, r.attachment_path 
            FROM tbl_spare_parts_requests r 
            LEFT JOIN tbl_customers c ON r.customer_id = c.customer_id 
            LEFT JOIN tbl_tickets t ON r.workorder_id = t.ticket_id 
            WHERE r.id = $request_id";
$resReq = mysqli_query($varDBConnection, $sqlReq);
$reqData = mysqli_fetch_assoc($resReq);

if (!$reqData) {
    die("Material Request not found.");
}

$req_id_format = "THC-MREQ-" . $reqData['id'];
$wo_format = "-";
if (!empty($reqData['ticket_id'])) {
    $wo_format = "WO-" . $reqData['ticket_ref_code'] . "-" . $reqData['ticket_id'];
}

$status = $reqData['status'];
if ($status == 'Completed') {
    $status_badge = '<span class="badge-status-completed">Completed</span>';
} elseif ($status == 'Partial Issue') {
    $status_badge = '<span class="badge-status-partial">Partial Issue</span>';
} elseif ($status == 'Pending') {
    $status_badge = '<span class="badge-status-pending">Pending</span>';
} else {
    $status_badge = '<span class="badge-status-closed">Closed</span>';
}

// Fetch Request Line Items
$sqlItems = "SELECT ri.*, m.item_code, m.item_name, m.category as category_name,
                    COALESCE(SUM(iss.issued_qty), 0) as issued_qty
             FROM tbl_spare_parts_request_items ri
             LEFT JOIN tbl_spare_parts_master m ON ri.item_id = m.id
             LEFT JOIN tbl_spare_parts_issues iss ON ri.id = iss.request_item_id
             WHERE ri.request_id = $request_id 
             GROUP BY ri.id
             ORDER BY ri.id ASC";
$resItems = mysqli_query($varDBConnection, $sqlItems);
$items_list = array();
if ($resItems) {
    while ($row = mysqli_fetch_assoc($resItems)) {
        $items_list[] = $row;
    }
}
$total_items = count($items_list);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Material Request Details - <?PHP echo $req_id_format; ?></title>
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
            display: inline-block; background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe;
            border-radius: 4px; padding: 2px 7px; font-weight: 700; font-size: 11px; font-family: monospace;
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

        .details-grid {
            display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;
            background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 16px;
        }
        .details-item { width: calc(33.333% - 15px); }
        .details-item label { display: block; font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; }
        .details-item .val { font-size: 13px; font-weight: 600; color: #0f172a; }

        .btn-action {
            background: #2e2e79; color: #ffffff; border: none; padding: 7px 15px; border-radius: 5px;
            cursor: pointer; font-weight: 600; font-size: 11.5px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-action:hover { background: #1e1e59; }
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
            Document: <strong>Material Request Details</strong>
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
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">MATERIAL REQUEST DETAILS</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Request Details Grid -->
    <div class="details-grid page-break-inside-avoid">
        <div class="details-item">
            <label>Request ID</label>
            <div class="val"><span class="badge-ref"><?PHP echo htmlspecialchars($req_id_format); ?></span></div>
        </div>
        <div class="details-item">
            <label>Customer Name</label>
            <div class="val"><?PHP echo htmlspecialchars($reqData['customer_name']); ?></div>
        </div>
        <div class="details-item">
            <label>Workorder / Ticket</label>
            <div class="val"><?PHP echo htmlspecialchars($wo_format); ?></div>
        </div>
        <div class="details-item">
            <label>Request Date</label>
            <div class="val"><?PHP echo date('d-m-Y h:i A', strtotime($reqData['request_date'])); ?></div>
        </div>
        <div class="details-item">
            <label>Request Status</label>
            <div class="val"><?PHP echo $status_badge; ?></div>
        </div>
    </div>

    <!-- Line Items Data Table -->
    <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 10px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">Requested Line Items (<?PHP echo $total_items; ?>)</div>
    
    <div id="main_table">
        <table class="tbl-report">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">SL</th>
                    <th style="width: 150px; text-align: left;">Category</th>
                    <th style="text-align: left;">Material Item</th>
                    <th style="width: 100px; text-align: center;">Req. Qty</th>
                    <th style="width: 100px; text-align: center;">Iss. Qty</th>
                    <th style="width: 80px; text-align: center;">Unit</th>
                    <th style="width: 150px; text-align: left;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                if ($total_items > 0) {
                    $ctr = 1;
                    foreach ($items_list as $item) {
                        $itemName = $item['item_code'] . " - " . $item['item_name'];
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $ctr; ?></td>
                            <td><?PHP echo htmlspecialchars($item['category_name']); ?></td>
                            <td><strong><?PHP echo htmlspecialchars($itemName); ?></strong></td>
                            <td style="text-align: center; font-weight: 700; color: #0f172a;"><?PHP echo (int)$item['quantity']; ?></td>
                            <td style="text-align: center; font-weight: 700; color: #16a34a;"><?PHP echo (int)$item['issued_qty']; ?></td>
                            <td style="text-align: center;"><?PHP echo htmlspecialchars($item['unit'] ?? '-'); ?></td>
                            <td><?PHP echo htmlspecialchars($item['remarks'] ?? '-'); ?></td>
                        </tr>
                        <?PHP 
                        $ctr++;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 24px; color: #64748b; font-style: italic;">
                            No line items found for this material request.
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
