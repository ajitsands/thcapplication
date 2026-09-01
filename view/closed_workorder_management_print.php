<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
date_default_timezone_set('Asia/Bahrain');

$sql = "SELECT DISTINCT(ticket_ref_code) as ticket_ref_code,
            DATE_FORMAT(created_date_time, '%d-%m-%Y %h:%i %p') as created_date_time,
            customer_id, customer_code, customer_name,
            location_code, location_name,
            building_code, building_name,
            ticket_priority, location_id, building_id, ticket_ref_no, ticket_id, ticket_status 
        FROM tbl_tickets 
        WHERE ticket_status = 'Closed' 
        GROUP BY ticket_ref_code 
        ORDER BY created_date_time DESC";

$result = mysqli_query($varDBConnection, $sql);
$tickets_list = [];
$total_high = 0;
$total_medium = 0;
$total_low = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tickets_list[] = $row;
        $pri = strtolower(trim($row['ticket_priority']));
        if ($pri == 'high' || $pri == 'emergency' || $pri == 'urgent') {
            $total_high++;
        } else if ($pri == 'medium') {
            $total_medium++;
        } else {
            $total_low++;
        }
    }
}
$total_closed = count($tickets_list);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Closed Work Orders Report - Total (<?PHP echo $total_closed; ?>)</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        * {
            box-sizing: border-box;
        }

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
            width: 900px;
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
            font-size: 11.5px;
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

        table.tbl-report tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        table.tbl-report tbody tr:hover {
            background-color: #f1f5f9;
        }

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

        .badge-closed {
            display: inline-block;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 700;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .badge-priority-high {
            display: inline-block;
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 700;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .badge-priority-med {
            display: inline-block;
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 700;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .badge-priority-low {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 600;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 14px;
            text-align: center;
        }

        .stat-num {
            font-size: 18px;
            font-weight: 700;
            color: #2e2e79;
            line-height: 1.2;
        }

        .stat-lbl {
            font-size: 10px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-top: 2px;
        }

        .btn-action {
            background: #2e2e79;
            color: #ffffff;
            border: none;
            padding: 7px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 11.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .btn-action:hover {
            background: #1e1e59;
            color: #ffffff;
        }

        .btn-excel {
            background: #0f766e;
        }

        .btn-excel:hover {
            background: #115e59;
        }

        .divFooter {
            margin-top: 20px;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .report-container {
                width: 100% !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .divFooter {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
            .page-break-inside-avoid {
                page-break-inside: avoid;
            }
            body, table, td, th {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

<div class="report-container">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
        <div style="font-size: 12px; color: #64748b;">
            Document: <strong>Closed Work Orders Management Summary</strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-action btn-excel" onclick="fnExcelReport();">
                <span>&#128196;</span> Export to Excel
            </button>
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
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">CLOSED WORK ORDERS REPORT</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Quick Stats Cards (No Print / Subtle Print) -->
    <table style="width: 100%; border: none; border-collapse: separate; border-spacing: 8px 0; margin-bottom: 18px;" class="page-break-inside-avoid">
        <tbody>
            <tr>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num"><?PHP echo $total_closed; ?></div>
                    <div class="stat-lbl">Total Closed Orders</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #b91c1c;"><?PHP echo $total_high; ?></div>
                    <div class="stat-lbl">High Priority</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #b45309;"><?PHP echo $total_medium; ?></div>
                    <div class="stat-lbl">Medium Priority</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #15803d;"><?PHP echo $total_low; ?></div>
                    <div class="stat-lbl">Low / Normal</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Main Data Table -->
    <div id="main_table">
        <table class="tbl-report">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">SL</th>
                    <th style="width: 125px; text-align: left;">Date &amp; Time</th>
                    <th style="width: 120px; text-align: left;">Ref. No.</th>
                    <th style="text-align: left;">Customer</th>
                    <th style="width: 130px; text-align: left;">Location</th>
                    <th style="width: 130px; text-align: left;">Facility / Building</th>
                    <th style="width: 80px; text-align: center;">Priority</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                if ($total_closed > 0) {
                    $ctr = 1;
                    foreach ($tickets_list as $row_t) {
                        $pri = strtolower(trim($row_t['ticket_priority']));
                        $pri_badge = '<span class="badge-priority-low">' . htmlspecialchars($row_t['ticket_priority'] ? $row_t['ticket_priority'] : 'Normal') . '</span>';
                        if ($pri == 'high' || $pri == 'urgent' || $pri == 'emergency') {
                            $pri_badge = '<span class="badge-priority-high">' . htmlspecialchars($row_t['ticket_priority']) . '</span>';
                        } else if ($pri == 'medium') {
                            $pri_badge = '<span class="badge-priority-med">Medium</span>';
                        }

                        $c_code = !empty($row_t['customer_code']) ? htmlspecialchars($row_t['customer_code']) : '';
                        $c_name = htmlspecialchars($row_t['customer_name']);
                        $loc = !empty($row_t['location_name']) && $row_t['location_name'] != 'NA' ? htmlspecialchars($row_t['location_name']) : '-';
                        $bld = !empty($row_t['building_name']) && $row_t['building_name'] != 'NA' ? htmlspecialchars($row_t['building_name']) : '-';
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $ctr; ?></td>
                            <td><?PHP echo htmlspecialchars($row_t['created_date_time']); ?></td>
                            <td>
                                <span class="badge-ref"><?PHP echo htmlspecialchars($row_t['ticket_ref_code']); ?></span>
                            </td>
                            <td>
                                <strong><?PHP echo $c_name; ?></strong>
                                <?php if ($c_code) { ?>
                                    <br><span style="font-size: 10.5px; color: #64748b;">(<?PHP echo $c_code; ?>)</span>
                                <?php } ?>
                            </td>
                            <td><?PHP echo $loc; ?></td>
                            <td><?PHP echo $bld; ?></td>
                            <td style="text-align: center;"><?PHP echo $pri_badge; ?></td>
                        </tr>
                        <?PHP 
                        $ctr++;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 24px; color: #64748b; font-style: italic;">
                            No closed work orders found in the system.
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

<script>
function fnExcelReport() {
    var tab = document.getElementById('main_table');
    if (!tab) return;
    
    var tab_text = "<table border='1px' style='font-family: Arial, sans-serif;'>";
    tab_text += "<tr><th colspan='7' style='background:#2e2e79;color:#ffffff;font-size:16px;padding:8px;'>CLOSED WORK ORDERS REPORT - " + <?php echo json_encode(date("d-m-Y")); ?> + "</th></tr>";
    
    var table = tab.getElementsByTagName('table')[0];
    if (table) {
        var rows = table.rows;
        for (var j = 0; j < rows.length; j++) {
            tab_text += "<tr>" + rows[j].innerHTML + "</tr>";
        }
    }
    tab_text += "</table>";
    
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
    tab_text = tab_text.replace(/<button[^>]*>.*?<\/button>/gi, "");
    tab_text = tab_text.replace(/<input[^>]*>/gi, "");

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        var txtArea1 = document.createElement("iframe");
        document.body.appendChild(txtArea1);
        txtArea1.contentWindow.document.open("txt/html", "replace");
        txtArea1.contentWindow.document.write(tab_text);
        txtArea1.contentWindow.document.close();
        txtArea1.contentWindow.focus();
        txtArea1.contentWindow.document.execCommand("SaveAs", true, "Closed_Work_Orders_Report.xls");
        document.body.removeChild(txtArea1);
    } else {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
        a.href = data_type;
        a.download = "Closed_Work_Orders_Report_" + <?php echo json_encode(date("d_m_Y")); ?> + ".xls";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
}
</script>

</body>
</html>