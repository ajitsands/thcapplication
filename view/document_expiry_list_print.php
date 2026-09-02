<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

date_default_timezone_set('Asia/Bahrain');

$from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
$to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
$days_filter = isset($_GET['days_filter']) ? trim($_GET['days_filter']) : 'all';
$custom_days = isset($_GET['custom_days']) ? intval($_GET['custom_days']) : 0;
$doc_name = isset($_GET['doc_name']) ? mysqli_real_escape_string($varDBConnection, trim($_GET['doc_name'])) : 'all';
$emp_type_id = isset($_GET['emp_type_id']) ? mysqli_real_escape_string($varDBConnection, trim($_GET['emp_type_id'])) : 'all';
$emp_status = isset($_GET['emp_status']) ? mysqli_real_escape_string($varDBConnection, trim($_GET['emp_status'])) : 'Active';

$where = array();
$where[] = "a.status = 'Active'";
$where[] = "a.expiry_date IS NOT NULL";
$where[] = "a.expiry_date != '0000-00-00'";
$where[] = "a.expiry_date != '1970-01-01'";

$filter_desc = array();

// Date Range Filter
if (!empty($from_date) && !empty($to_date)) {
    $from_esc = mysqli_real_escape_string($varDBConnection, $from_date);
    $to_esc = mysqli_real_escape_string($varDBConnection, $to_date);
    $where[] = "a.expiry_date BETWEEN '$from_esc' AND '$to_esc'";
    $filter_desc[] = "Date Range: " . date("d-m-Y", strtotime($from_date)) . " to " . date("d-m-Y", strtotime($to_date));
} elseif (!empty($from_date)) {
    $from_esc = mysqli_real_escape_string($varDBConnection, $from_date);
    $where[] = "a.expiry_date >= '$from_esc'";
    $filter_desc[] = "From Date: " . date("d-m-Y", strtotime($from_date));
} elseif (!empty($to_date)) {
    $to_esc = mysqli_real_escape_string($varDBConnection, $to_date);
    $where[] = "a.expiry_date <= '$to_esc'";
    $filter_desc[] = "To Date: " . date("d-m-Y", strtotime($to_date));
}

// Days Filter
if ($days_filter == 'expired') {
    $where[] = "a.expiry_date < CURDATE()";
    $filter_desc[] = "Condition: Already Expired";
} elseif ($days_filter == '7') {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
    $filter_desc[] = "Condition: Expiring within 7 Days";
} elseif ($days_filter == '15') {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)";
    $filter_desc[] = "Condition: Expiring within 15 Days";
} elseif ($days_filter == '30') {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
    $filter_desc[] = "Condition: Expiring within 30 Days";
} elseif ($days_filter == '60') {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 60 DAY)";
    $filter_desc[] = "Condition: Expiring within 60 Days";
} elseif ($days_filter == '90') {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 90 DAY)";
    $filter_desc[] = "Condition: Expiring within 90 Days";
} elseif ($days_filter == '180') {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 180 DAY)";
    $filter_desc[] = "Condition: Expiring within 180 Days";
} elseif ($days_filter == 'custom' && $custom_days > 0) {
    $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL $custom_days DAY)";
    $filter_desc[] = "Condition: Expiring within $custom_days Days";
}

// Document Type Filter
if (!empty($doc_name) && $doc_name != 'all') {
    $where[] = "a.document_name = '$doc_name'";
    $filter_desc[] = "Document: $doc_name";
}

// Employee Type Filter
if (!empty($emp_type_id) && $emp_type_id != 'all') {
    $where[] = "e.employee_type_id = '$emp_type_id'";
}

// Employee Status Filter
if (!empty($emp_status) && $emp_status != 'all') {
    $where[] = "e.employee_status = '$emp_status'";
    $filter_desc[] = "Emp Status: $emp_status";
}

$whereClause = implode(" AND ", $where);

$sql = "SELECT 
    a.attachment_id,
    a.employee_id,
    a.employee_code,
    a.document_name,
    a.expiry_date,
    a.file_path,
    a.original_file_name,
    a.remarks,
    a.created_at,
    e.employee_name,
    e.employee_type_name,
    e.employee_type_id,
    e.employee_image,
    e.employee_contact_no,
    e.employee_status,
    e.cpr_no,
    DATE_FORMAT(a.expiry_date, '%d-%m-%Y') AS formatted_expiry_date,
    DATE_FORMAT(a.created_at, '%d-%m-%Y') AS formatted_created_at,
    DATEDIFF(a.expiry_date, CURDATE()) AS days_to_expire,
    CASE 
        WHEN a.expiry_date < CURDATE() THEN 'Expired'
        WHEN DATEDIFF(a.expiry_date, CURDATE()) <= 30 THEN 'Expiring Soon'
        ELSE 'Valid'
    END AS expiry_status_label
FROM tbl_employee_attachments a
LEFT JOIN tbl_employees e ON a.employee_id = e.employee_id
WHERE $whereClause
ORDER BY a.expiry_date ASC, e.employee_name ASC";

$result = mysqli_query($varDBConnection, $sql);
$doc_list = array();
$total_expired = 0;
$total_soon = 0;
$total_valid = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $doc_list[] = $row;
        $days = intval($row['days_to_expire']);
        if ($days < 0) {
            $total_expired++;
        } elseif ($days <= 30) {
            $total_soon++;
        } else {
            $total_valid++;
        }
    }
}
$total_documents = count($doc_list);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Employee Document Expiry Report - Total (<?PHP echo $total_documents; ?>)</title>
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

        .badge-doc-pill {
            display: inline-block;
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 600;
            font-size: 11px;
        }

        .badge-status-expired {
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

        .badge-status-soon {
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

        .badge-status-valid {
            display: inline-block;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
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
            Document: <strong>Employee Document Expiry Report Summary</strong>
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
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">EMPLOYEE DOCUMENT EXPIRY REPORT</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                    <?php if (!empty($filter_desc)) { ?>
                        <div style="font-size: 10.5px; color: #475569; margin-top: 2px;">
                            <b>Filter:</b> <?PHP echo htmlspecialchars(implode(" | ", $filter_desc)); ?>
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
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #2e2e79;"><?PHP echo $total_documents; ?></div>
                    <div class="stat-lbl">Total Documents</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #b91c1c;"><?PHP echo $total_expired; ?></div>
                    <div class="stat-lbl">Already Expired</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #b45309;"><?PHP echo $total_soon; ?></div>
                    <div class="stat-lbl">Expiring &le; 30 Days</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #15803d;"><?PHP echo $total_valid; ?></div>
                    <div class="stat-lbl">Valid (&gt; 30 Days)</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Main Data Table -->
    <div id="main_table">
        <table class="tbl-report">
            <thead>
                <tr>
                    <th style="width: 35px; text-align: center;">SL</th>
                    <th style="width: 45px; text-align: center;">Pic</th>
                    <th style="width: 85px; text-align: left;">Emp. Code</th>
                    <th style="text-align: left;">Employee Name</th>
                    <th style="width: 120px; text-align: left;">Designation</th>
                    <th style="width: 130px; text-align: left;">Document Name</th>
                    <th style="width: 95px; text-align: center;">Expiry Date</th>
                    <th style="width: 125px; text-align: center;">Days Remaining</th>
                    <th style="width: 85px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: left;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                if ($total_documents > 0) {
                    $ctr = 1;
                    foreach ($doc_list as $row_t) {
                        $days = intval($row_t['days_to_expire']);
                        
                        if ($days < 0) {
                            $days_badge = '<span class="badge-status-expired">Expired ' . abs($days) . ' d ago</span>';
                            $status_badge = '<span class="badge-status-expired">Expired</span>';
                        } elseif ($days == 0) {
                            $days_badge = '<span class="badge-status-soon">Expires Today</span>';
                            $status_badge = '<span class="badge-status-soon">Expiring</span>';
                        } elseif ($days <= 30) {
                            $days_badge = '<span class="badge-status-soon">' . $days . ' days left</span>';
                            $status_badge = '<span class="badge-status-soon">Expiring Soon</span>';
                        } else {
                            $days_badge = '<span class="badge-status-valid">' . $days . ' days left</span>';
                            $status_badge = '<span class="badge-status-valid">Valid</span>';
                        }

                        $emp_code = !empty($row_t['employee_code']) ? htmlspecialchars($row_t['employee_code']) : '';
                        $emp_name = htmlspecialchars($row_t['employee_name']);
                        $emp_type = !empty($row_t['employee_type_name']) ? htmlspecialchars($row_t['employee_type_name']) : '-';
                        $doc_name_txt = htmlspecialchars($row_t['document_name']);
                        $exp_date_txt = htmlspecialchars($row_t['formatted_expiry_date']);
                        $remarks = !empty($row_t['remarks']) ? htmlspecialchars($row_t['remarks']) : '-';

                        $empImg = (!empty($row_t['employee_image']) && $row_t['employee_image'] != 'null' && strpos($row_t['employee_image'], 'fakepath') === false) 
                            ? trim($row_t['employee_image']) 
                            : 'default.jpg';
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $ctr; ?></td>
                            <td style="text-align: center; padding: 4px;">
                                <img src="../httpdocs/images/employee_image/<?PHP echo htmlspecialchars($empImg); ?>" width="32" height="32" style="border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1;" alt="" onerror="this.src='../httpdocs/images/employee_image/default.jpg';" />
                            </td>
                            <td>
                                <span class="badge-ref"><?PHP echo $emp_code; ?></span>
                            </td>
                            <td>
                                <strong><?PHP echo $emp_name; ?></strong>
                            </td>
                            <td><?PHP echo $emp_type; ?></td>
                            <td>
                                <span class="badge-doc-pill"><?PHP echo $doc_name_txt; ?></span>
                            </td>
                            <td style="text-align: center; font-weight: 600;"><?PHP echo $exp_date_txt; ?></td>
                            <td style="text-align: center;"><?PHP echo $days_badge; ?></td>
                            <td style="text-align: center;"><?PHP echo $status_badge; ?></td>
                            <td style="font-size: 11px; color: #475569;"><?PHP echo $remarks; ?></td>
                        </tr>
                        <?PHP 
                        $ctr++;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 24px; color: #64748b; font-style: italic;">
                            No document expiry records found in the system matching the criteria.
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
    tab_text += "<tr><th colspan='10' style='background:#2e2e79;color:#ffffff;font-size:16px;padding:8px;'>EMPLOYEE DOCUMENT EXPIRY REPORT - " + <?php echo json_encode(date("d-m-Y")); ?> + "</th></tr>";
    
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
    tab_text = tab_text.replace(/<img[^>]*>/gi, "");

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        var txtArea1 = document.createElement("iframe");
        document.body.appendChild(txtArea1);
        txtArea1.contentWindow.document.open("txt/html", "replace");
        txtArea1.contentWindow.document.write(tab_text);
        txtArea1.contentWindow.document.close();
        txtArea1.contentWindow.focus();
        txtArea1.contentWindow.document.execCommand("SaveAs", true, "Employee_Document_Expiry_Report.xls");
        document.body.removeChild(txtArea1);
    } else {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
        a.href = data_type;
        a.download = "Employee_Document_Expiry_Report_" + <?php echo json_encode(date("d_m_Y")); ?> + ".xls";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
}
</script>

</body>
</html>
