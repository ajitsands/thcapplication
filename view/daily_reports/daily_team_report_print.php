<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
date_default_timezone_set('Asia/Bahrain');

$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($varDBConnection, $_GET['start_date']) : date('Y-m-d');
$ids = isset($_GET['ids']) ? mysqli_real_escape_string($varDBConnection, $_GET['ids']) : '0';
$emp_ids = isset($_GET['Emp_id']) ? mysqli_real_escape_string($varDBConnection, $_GET['Emp_id']) : '0';

$display_date = date('d-m-Y', strtotime($start_date));

$result_cn = mysqli_query($varDBConnection, "SELECT DISTINCT(GROUP_CONCAT(employee_contact_no)) as employee_contact_no, GROUP_CONCAT(employee_name) as Emp_name FROM tbl_employees WHERE employee_id IN (".$emp_ids.")");
$Emp_name = '';
$employee_contact_no = '';
if ($result_cn) {
    while ($row_cn = mysqli_fetch_assoc($result_cn)) {
        $Emp_name = $row_cn['Emp_name'];
        $employee_contact_no = $row_cn['employee_contact_no'];
    }
}

$result_entries = mysqli_query($varDBConnection, "SELECT ticket_id, amc_ticket, ticket_ref_no, visit_id FROM tbl_ticket_teams WHERE visit_date = '".$start_date."' AND ticket_team_ids IN (".$ids.") AND ticket_team_status='Active' GROUP BY ticket_id");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daily Team Report - <?PHP echo $display_date; ?></title>
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
            font-size: 11.5px;
            color: #1e293b;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px 0 40px 0;
        }

        .report-container {
            width: 1050px;
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
            padding: 8px 8px;
            font-size: 10.5px;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            border: 1px solid #2e2e79;
            vertical-align: middle;
        }

        table.tbl-report td {
            border: 1px solid #cbd5e1;
            padding: 8px 8px;
            font-size: 11px;
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
            font-size: 10.5px;
            font-family: monospace;
            white-space: nowrap;
        }

        .badge-tech {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            padding: 1px 5px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 2px;
        }

        .badge-status {
            display: inline-block;
            border-radius: 4px;
            padding: 2px 6px;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            text-align: center;
            white-space: nowrap;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }

        .status-start {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }

        .status-other {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 14px;
            text-align: center;
        }

        .stat-num {
            font-size: 16px;
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

        .team-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #2e2e79;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 16px;
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
            margin-top: 25px;
        }

        .sig-box {
            border-top: 1px dashed #94a3b8;
            padding-top: 6px;
            text-align: center;
            font-weight: 600;
            color: #334155;
            font-size: 11px;
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
            Document: <strong>Daily Team Summary Report</strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-action btn-excel" onclick="exportToExcel();">
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
                    <img src="../global_assets/images/logo_print.png" alt="THC Logo" style="max-height: 70px; height: auto;" />
                </td>
                <td style="border: none; padding: 0; width: 50%; text-align: right; vertical-align: middle;">
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">DAILY TEAM REPORT</div>
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
                <td class="stat-box" style="width: 33.33%;">
                    <div class="stat-num"><?PHP echo $display_date; ?></div>
                    <div class="stat-lbl">Report Date</div>
                </td>
                <td class="stat-box" style="width: 33.33%;">
                    <div class="stat-num" style="font-size: 13px; font-weight: 600; padding-top: 3px;"><?PHP echo date("l", strtotime($start_date)); ?></div>
                    <div class="stat-lbl">Day of Week</div>
                </td>
                <td class="stat-box" style="width: 33.33%;">
                    <div class="stat-num" style="font-size: 13px; padding-top: 3px;">Active Team</div>
                    <div class="stat-lbl">Report Status</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Team Members Card -->
    <div class="team-box page-break-inside-avoid">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div>
                <strong style="color: #2e2e79;">&#128101; Team Members:</strong> 
                <span style="font-weight: 600; color: #1e293b;"><?PHP echo htmlspecialchars($Emp_name ? $Emp_name : 'N/A'); ?></span>
            </div>
            <div>
                <strong style="color: #2e2e79;">&#9742; Contact Numbers:</strong> 
                <span style="color: #475569;"><?PHP echo htmlspecialchars($employee_contact_no ? $employee_contact_no : 'N/A'); ?></span>
            </div>
        </div>
    </div>

    <!-- Main Data Table -->
    <div id="main_table">
        <table class="tbl-report">
            <thead>
                <tr>
                    <th style="width: 35px; text-align: center;">SL</th>
                    <th style="width: 125px; text-align: left;">WO No.</th>
                    <th style="text-align: left;">Tasks / Services</th>
                    <th style="width: 80px; text-align: center;">Status</th>
                    <th style="width: 140px; text-align: left;">Service Start</th>
                    <th style="width: 140px; text-align: left;">Service End</th>
                    <th style="width: 85px; text-align: center;">Duration</th>
                    <th style="width: 130px; text-align: left;">Remarks</th>
                    <th style="width: 85px; text-align: center;">SR No.</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                $has_entries = false;
                $j = 0;
                if ($result_entries) {
                    while ($row_entries = mysqli_fetch_assoc($result_entries)) {
                        if ($row_entries['amc_ticket'] == 'TKT') {
                            $result_services = mysqli_query($varDBConnection, "SELECT ticket_id, ticket_ref_code, service_description, tech_remarks, ticket_service_status, service_start_by_emp_code, service_complete_cancel_by_emp_code, tech_audio_file, DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1, DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1, FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24) as days_cnt, FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt, FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr, MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr, CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), 'd ', FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), 'h ', FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), 'm') AS difference, CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), 'h ', FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), 'm') AS difference_hrs, CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), 'm ', MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), 's') AS difference_mins FROM tbl_ticket_services WHERE ticket_id=".$row_entries['ticket_id']);
                            $result_job_description = mysqli_query($varDBConnection, "SELECT * FROM tbl_tickets WHERE ticket_id=".$row_entries['ticket_id']);
                            $job_description = '';
                            $service_report_no = '';
                            while ($row_job_description = mysqli_fetch_assoc($result_job_description)) {
                                $job_description = $row_job_description['complaints_description'];
                                $service_report_no = $row_job_description['service_report_no'];
                            }
                        } else {
                            $result_services = mysqli_query($varDBConnection, "SELECT amc_visit_id as ticket_id, amc_ref_code as ticket_ref_code, service_description, tech_remarks, amc_service_status as ticket_service_status, service_start_by_emp_code, service_complete_cancel_by_emp_code, tech_audio_file, DATE_FORMAT(service_start_date_time,'%d-%m-%Y %H:%i') as service_start_date_time1, DATE_FORMAT(service_complete_cancel_date_time,'%d-%m-%Y %H:%i') as service_complete_cancel_date_time1, FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24) as days_cnt, FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600) as hrs_cnt, FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60) as min_ctr, MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60) as sec_ctr, CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time) / 3600 / 24), 'd ', FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), 'h ', FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), 'm') AS difference, CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600 * 24) / 3600), 'h ', FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), 'm') AS difference_hrs, CONCAT(FLOOR(MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 3600) / 60), 'm ', MOD(TIMESTAMPDIFF(SECOND, service_start_date_time, service_complete_cancel_date_time), 60), 's') AS difference_mins FROM tbl_amc_services WHERE amc_visit_id=".$row_entries['visit_id']);
                            $result_job_description = mysqli_query($varDBConnection, "SELECT amc_description FROM tbl_amc_master WHERE mc_ref_no='".$row_entries['ticket_ref_no']."'");
                            $job_description = '';
                            $service_report_no = '';
                            while ($row_job_description = mysqli_fetch_assoc($result_job_description)) {
                                $job_description = $row_job_description['amc_description'];
                                $service_report_no = '';
                            }
                        }

                        if ($result_services) {
                            while ($row_services = mysqli_fetch_assoc($result_services)) {
                                $has_entries = true;
                                $j++;
                                $wo_label = ($row_entries['amc_ticket'] == 'AMC') ? 'WO-' . $row_services['ticket_ref_code'] . '-' . $row_entries['visit_id'] : 'WO-' . $row_services['ticket_ref_code'] . '-' . $row_services['ticket_id'];

                                // Status Badge
                                $status_val = $row_services['ticket_service_status'];
                                $status_badge = '<span class="badge-status status-other">' . htmlspecialchars($status_val ? $status_val : '-') . '</span>';
                                switch ($status_val) {
                                    case 'Completed':
                                        $status_badge = '<span class="badge-status status-completed">Completed</span>';
                                        break;
                                    case 'Start':
                                    case 'In Progress':
                                        $status_badge = '<span class="badge-status status-start">In Progress</span>';
                                        break;
                                    case 'Pending':
                                        $status_badge = '<span class="badge-status status-pending">Pending</span>';
                                        break;
                                    case 'Cancelled':
                                        $status_badge = '<span class="badge-status status-cancelled">Cancelled</span>';
                                        break;
                                }

                                // Duration
                                $dur = '-';
                                if ($row_services['service_complete_cancel_by_emp_code'] != "NA" && $row_services['service_start_by_emp_code'] != "NA" && !empty($row_services['service_start_date_time1']) && !empty($row_services['service_complete_cancel_date_time1'])) {
                                    if ($row_services['days_cnt'] != 0) {
                                        $dur = $row_services['difference'];
                                    } else if ($row_services['hrs_cnt'] != 0) {
                                        $dur = $row_services['difference_hrs'];
                                    } else {
                                        $dur = $row_services['difference_mins'];
                                    }
                                }

                                $start_display = '-';
                                if ($row_services['service_start_by_emp_code'] != "NA" && !empty($row_services['service_start_date_time1'])) {
                                    $start_display = '<span>' . htmlspecialchars($row_services['service_start_date_time1']) . '</span><br><span class="badge-tech">' . htmlspecialchars($row_services['service_start_by_emp_code']) . '</span>';
                                }

                                $end_display = '-';
                                if ($row_services['service_complete_cancel_by_emp_code'] != "NA" && !empty($row_services['service_complete_cancel_date_time1'])) {
                                    $end_display = '<span>' . htmlspecialchars($row_services['service_complete_cancel_date_time1']) . '</span><br><span class="badge-tech">' . htmlspecialchars($row_services['service_complete_cancel_by_emp_code']) . '</span>';
                                }
                                ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $j; ?></td>
                                    <td><span class="badge-ref"><?PHP echo htmlspecialchars($wo_label); ?></span></td>
                                    <td><strong><?PHP echo htmlspecialchars($row_services['service_description']); ?></strong></td>
                                    <td style="text-align: center;"><?PHP echo $status_badge; ?></td>
                                    <td><?PHP echo $start_display; ?></td>
                                    <td><?PHP echo $end_display; ?></td>
                                    <td style="text-align: center; font-weight: 600; font-size: 10.5px;"><?PHP echo htmlspecialchars($dur); ?></td>
                                    <td style="font-size: 10.5px; color: #475569;"><?PHP echo htmlspecialchars($row_services['tech_remarks'] ? $row_services['tech_remarks'] : '-'); ?></td>
                                    <td style="text-align: center; font-size: 10.5px;"><?PHP echo ($row_entries['amc_ticket'] == 'TKT') ? htmlspecialchars($service_report_no) : '-'; ?></td>
                                </tr>
                                <?PHP 
                            }
                        }
                    }
                }

                if (!$has_entries) {
                    ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 24px; color: #64748b; font-style: italic;">
                            No daily team tasks recorded for the selected date.
                        </td>
                    </tr>
                    <?PHP 
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Signatures / Review Block -->
    <table style="width: 100%; border: none; border-collapse: separate; border-spacing: 24px 0; margin-top: 30px;" class="page-break-inside-avoid">
        <tbody>
            <tr>
                <td style="width: 50%; border: none; vertical-align: bottom;">
                    <div class="sig-box">
                        SUPERVISOR SIGNATURE &amp; DATE
                    </div>
                </td>
                <td style="width: 50%; border: none; vertical-align: bottom;">
                    <div class="sig-box">
                        OPERATIONS COORDINATOR SIGNATURE &amp; DATE
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

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
                        <img src="../global_assets/images/a.png" alt="THC Emblem" style="max-height: 38px;" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
function exportToExcel() {
    var filename = "Daily_Team_Report_" + <?php echo json_encode(date("d_m_Y")); ?> + ".xls";
    var tab_text = "<table border='1px' style='font-family: Arial, sans-serif;'>";
    tab_text += "<tr><th colspan='9' style='background:#2e2e79;color:#ffffff;font-size:15px;padding:8px;'>DAILY TEAM REPORT (" + <?php echo json_encode($display_date); ?> + ")</th></tr>";

    var tab = document.getElementById('main_table');
    if (tab) {
        var table = tab.getElementsByTagName('table')[0];
        if (table) {
            for (var j = 0; j < table.rows.length; j++) {
                tab_text += "<tr>" + table.rows[j].innerHTML + "</tr>";
            }
        }
    }

    tab_text += "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
    tab_text = tab_text.replace(/<button[^>]*>.*?<\/button>/gi, "");
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, "");

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        var txtArea1 = document.createElement("iframe");
        document.body.appendChild(txtArea1);
        txtArea1.contentWindow.document.open("txt/html", "replace");
        txtArea1.contentWindow.document.write(tab_text);
        txtArea1.contentWindow.document.close();
        txtArea1.focus();
        txtArea1.document.execCommand("SaveAs", true, filename);
        document.body.removeChild(txtArea1);
    } else {
        var link = document.createElement('a');
        link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>

</body>
</html>