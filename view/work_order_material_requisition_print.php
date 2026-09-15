<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

date_default_timezone_set('Asia/Bahrain');

$ticket_id = isset($_GET['ticket_id']) ? (int)$_GET['ticket_id'] : 0;

if ($ticket_id <= 0) {
    die("Invalid Work Order ID.");
}

// 1. Fetch Work Order Details
$sqlWO = "SELECT t.ticket_ref_code, t.ticket_id, c.customer_name 
          FROM tbl_tickets t
          LEFT JOIN tbl_customers c ON t.customer_id = c.customer_id
          WHERE t.ticket_id = $ticket_id";
$resWO = mysqli_query($varDBConnection, $sqlWO);
if (!$rowWO = mysqli_fetch_assoc($resWO)) {
    die("Work Order not found.");
}
$wo_format = "WO-" . $rowWO['ticket_ref_code'] . "-" . $rowWO['ticket_id'];
$customer_name = $rowWO['customer_name'];

// 2. Fetch Material Requests
$sqlReq = "SELECT r.id, r.request_date, r.status 
           FROM tbl_spare_parts_requests r 
           WHERE r.workorder_id = $ticket_id 
           ORDER BY r.id ASC";
$resReq = mysqli_query($varDBConnection, $sqlReq);
$req_list = array();
if ($resReq) {
    while ($rowReq = mysqli_fetch_assoc($resReq)) {
        // Fetch Items for this request
        $req_id = $rowReq['id'];
        $sqlItems = "SELECT ri.quantity as requested_qty, ri.unit, ri.remarks, m.item_code, m.item_name, m.category as category_name,
                            COALESCE(SUM(iss.issued_qty), 0) as issued_qty
                     FROM tbl_spare_parts_request_items ri 
                     LEFT JOIN tbl_spare_parts_master m ON ri.item_id = m.id 
                     LEFT JOIN tbl_spare_parts_issues iss ON ri.id = iss.request_item_id
                     WHERE ri.request_id = $req_id
                     GROUP BY ri.id
                     ORDER BY ri.id ASC";
        $resItems = mysqli_query($varDBConnection, $sqlItems);
        $items = array();
        if ($resItems) {
            while ($rowItem = mysqli_fetch_assoc($resItems)) {
                $items[] = $rowItem;
            }
        }
        $rowReq['items'] = $items;
        $req_list[] = $rowReq;
    }
}
$total_requests = count($req_list);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Material Requisitions for <?PHP echo $wo_format; ?></title>
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

        .req-section {
            margin-bottom: 40px;
        }

        @media print {
            body { background: #ffffff !important; padding: 0 !important; }
            .report-container { width: 100% !important; padding: 0 !important; box-shadow: none !important; border-radius: 0 !important; }
            .no-print { display: none !important; }
            .divFooter { position: fixed; bottom: 0; width: 100%; }
            .page-break-inside-avoid { page-break-inside: avoid; }
            .req-section { page-break-inside: avoid; }
            body, table, td, th { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body>

<div class="report-container">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
        <div style="font-size: 12px; color: #64748b;">
            Document: <strong>Material Requisitions</strong>
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
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">MATERIAL REQUISITIONS</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        <b>Work Order:</b> <?PHP echo $wo_format; ?>
                    </div>
                    <div style="font-size: 11px; color: #475569; margin-top: 2px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <?php if ($total_requests > 0): ?>
        <?php foreach ($req_list as $index => $req): ?>
            <?php
            $status = $req['status'];
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
            <div class="req-section">
                <!-- Request Details Grid -->
                <div class="details-grid">
                    <div class="details-item">
                        <label>Request ID</label>
                        <div class="val"><span class="badge-ref"><?PHP echo "THC-MREQ-" . $req['id']; ?></span></div>
                    </div>
                    <div class="details-item">
                        <label>Customer Name</label>
                        <div class="val"><?PHP echo htmlspecialchars($customer_name); ?></div>
                    </div>
                    <div class="details-item">
                        <label>Workorder / Ticket</label>
                        <div class="val"><?PHP echo htmlspecialchars($wo_format); ?></div>
                    </div>
                    <div class="details-item">
                        <label>Request Date</label>
                        <div class="val"><?PHP echo date("d-m-Y h:i A", strtotime($req['request_date'])); ?></div>
                    </div>
                    <div class="details-item">
                        <label>Request Status</label>
                        <div class="val"><?PHP echo $status_badge; ?></div>
                    </div>
                </div>

                <!-- Line Items Data Table -->
                <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 10px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">Requested Line Items (<?PHP echo count($req['items']); ?>)</div>
                
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
                        <?php if (count($req['items']) > 0): ?>
                            <?php foreach ($req['items'] as $i => $item): ?>
                                <?php $itemName = $item['item_code'] . " - " . $item['item_name']; ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $i + 1; ?></td>
                                    <td><?PHP echo htmlspecialchars($item['category_name'] ?? '-'); ?></td>
                                    <td><strong><?PHP echo htmlspecialchars($itemName); ?></strong></td>
                                    <td style="text-align: center; font-weight: 700; color: #0f172a;"><?PHP echo (int)$item['requested_qty']; ?></td>
                                    <td style="text-align: center; font-weight: 700; color: #16a34a;"><?PHP echo (int)$item['issued_qty']; ?></td>
                                    <td style="text-align: center;"><?PHP echo htmlspecialchars($item['unit'] ?? '-'); ?></td>
                                    <td><?PHP echo htmlspecialchars($item['remarks'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; color: #94a3b8; font-style: italic;">No items found for this request.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="padding: 40px; text-align: center; color: #64748b; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px;">
            No material requests found for this work order.
        </div>
    <?php endif; ?>

    <div class="divFooter" style="text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; margin-top: 30px;">
        <i>THC Facilities Management System - Generated on <?PHP echo date("d-m-Y h:i A"); ?></i>
    </div>

</div>

</body>
</html>
