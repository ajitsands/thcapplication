<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
date_default_timezone_set('Asia/Bahrain');

$emp_type_id = isset($_GET["v_employee_type_id"]) ? trim($_GET["v_employee_type_id"]) : 'All';
$tech_type_name = isset($_GET["v_emp_tech_type_name"]) ? trim($_GET["v_emp_tech_type_name"]) : '';
$expertise_id = isset($_GET["v_expertise_id"]) ? trim($_GET["v_expertise_id"]) : '';

$where_clauses = [];

if ($emp_type_id != 'All' && $emp_type_id != '') {
    $emp_type_id_esc = mysqli_real_escape_string($varDBConnection, $emp_type_id);
    $where_clauses[] = "employee_type_id = '$emp_type_id_esc'";
}

if ($tech_type_name != '' && $tech_type_name != 'Both' && $tech_type_name != 'All') {
    $tech_type_name_esc = mysqli_real_escape_string($varDBConnection, $tech_type_name);
    $where_clauses[] = "technician_type = '$tech_type_name_esc'";
}

if ($expertise_id != '' && $expertise_id != 'All') {
    $expertise_id_esc = mysqli_real_escape_string($varDBConnection, $expertise_id);
    $where_clauses[] = "employee_id IN (SELECT employee_id FROM `tbl_technician_expertise` WHERE `expertise_id` IN ('$expertise_id_esc') AND (status != 'Deleted' OR status IS NULL OR status = ''))";
}

$where_sql = count($where_clauses) > 0 ? " WHERE " . implode(" AND ", $where_clauses) : "";
$query_sql = "SELECT *, 
    DATE_FORMAT(joining_date, '%d-%m-%Y') as formatted_joining_date,
    DATE_FORMAT(cpr_expiry_date, '%d-%m-%Y') as formatted_cpr_expiry_date,
    DATE_FORMAT(visa_validity_on, '%d-%m-%Y') as formatted_visa_validity 
FROM view_employee_expertiser_list 
$where_sql 
ORDER BY employee_name ASC";

$result = mysqli_query($varDBConnection, $query_sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Employee List Report - THC Portal</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 12px;
            color: #2b2b2b;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px 15px 40px;
        }

        .report-wrapper {
            width: 98%;
            max-width: 1400px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        /* Header Styles */
        .report-header {
            width: 100%;
            border-bottom: 2px solid #2e2e79;
            padding-bottom: 15px;
            margin-bottom: 18px;
        }

        .report-header table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }

        .report-header td {
            border: none;
            padding: 0;
        }

        .report-title {
            font-size: 20px;
            font-weight: 700;
            color: #2e2e79;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .report-subtitle {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }

        /* Action Buttons */
        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-print {
            background-color: #2e2e79;
            color: #ffffff;
        }

        .btn-print:hover {
            background-color: #1f1f58;
        }

        .btn-excel {
            background-color: #2e7d32;
            color: #ffffff;
        }

        .btn-excel:hover {
            background-color: #1b5e20;
        }

        /* Main Data Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table.main-report-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d1d5db;
            font-size: 11.5px;
        }

        table.main-report-table th {
            background-color: #2e2e79;
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            padding: 9px 6px;
            border: 1px solid #232360;
            white-space: nowrap;
            letter-spacing: 0.2px;
        }

        table.main-report-table td {
            border: 1px solid #e5e7eb;
            padding: 7px 6px;
            vertical-align: middle;
        }

        table.main-report-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        table.main-report-table tbody tr:hover {
            background-color: #f0f4ff;
        }

        /* Custom Tags & Badges */
        .emp-thumb {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 1.5px solid #d1d5db;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .badge-code {
            font-weight: 700;
            color: #2e2e79;
            letter-spacing: 0.3px;
        }

        .badge-type {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 10.5px;
            font-weight: 600;
            background-color: #e8ecfa;
            color: #2e2e79;
            border: 1px solid #c2cde8;
            white-space: nowrap;
        }

        .badge-exp {
            display: inline-block;
            background-color: #f1f5f9;
            color: #334155;
            border-radius: 3px;
            padding: 1.5px 5px;
            margin: 1px;
            font-size: 10px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10.5px;
            font-weight: 600;
            text-align: center;
        }

        .status-active {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .status-deactive {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        /* Footer */
        .divFooter {
            margin-top: 25px;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .divFooter table {
            width: 100%;
            background-color: #2e2e79;
            border-radius: 6px;
            border: none;
            border-collapse: collapse;
        }

        .divFooter td {
            border: none;
            padding: 12px 18px;
            color: #ffffff;
            font-size: 11px;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
                font-size: 10px;
            }

            .report-wrapper {
                width: 100%;
                max-width: 100%;
                box-shadow: none;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            table.main-report-table {
                font-size: 9.5px;
            }

            table.main-report-table th {
                background-color: #2e2e79 !important;
                color: #ffffff !important;
                padding: 5px 3px;
            }

            table.main-report-table td {
                padding: 4px 3px;
            }

            .emp-thumb {
                width: 32px;
                height: 32px;
            }

            div.divFooter {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                margin: 0;
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<div class="report-wrapper">

    <!-- Action Bar (Buttons) -->
    <div class="action-bar no-print">
        <button class="btn-action btn-excel" onclick="fnExcelReport();" id="export_excel_but">
            <b>&#128196;</b> Export to Excel
        </button>
        <button class="btn-action btn-print" onclick="window.print();">
            <b>&#128438;</b> Print Report
        </button>
    </div>

    <!-- Header / Brand -->
    <div class="report-header">
        <table>
            <tr>
                <td style="width: 50%; vertical-align: middle;">
                    <img src="global_assets/images/logo_print.png" alt="THC Logo" style="max-height: 65px; height: auto;" />
                </td>
                <td style="width: 50%; text-align: right; vertical-align: middle;">
                    <h1 class="report-title">EMPLOYEE DIRECTORY LIST</h1>
                    <div class="report-subtitle">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?> | <b>Total Employees:</b> <?PHP echo $result ? mysqli_num_rows($result) : 0; ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Main Data Table Container -->
    <div class="table-container">
        <table class="main-report-table" id="main_table">
            <thead>
                <tr>
                    <th style="width: 35px;">Sl.</th>
                    <th style="width: 50px;">Photo</th>
                    <th style="width: 85px;">Code</th>
                    <th style="width: 160px; text-align: left; padding-left: 8px;">Employee Name</th>
                    <th style="width: 110px;">Type</th>
                    <th style="min-width: 140px; text-align: left; padding-left: 8px;">Expertise / Skills</th>
                    <th style="width: 105px;">Contact No.</th>
                    <th style="width: 85px;">Joining Date</th>
                    <th style="width: 95px;">CPR No.</th>
                    <th style="width: 95px;">Passport No.</th>
                    <th style="width: 85px;">Visa Type</th>
                    <th style="width: 70px;">Blood</th>
                    <th style="width: 75px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                $count = 1;
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $emp_img = (!empty($row['employee_image']) && $row['employee_image'] != 'null' && strpos($row['employee_image'], 'fakepath') === false) ? trim($row['employee_image']) : 'default.jpg';
                        $emp_type_display = htmlspecialchars($row['employee_type_name']);
                        if ($row['employee_type_name'] == 'Technician' && !empty($row['technician_type']) && $row['technician_type'] != 'select') {
                            $emp_type_display .= ' (' . htmlspecialchars($row['technician_type']) . ')';
                        }

                        // Format Expertise List
                        $exp_html = '-';
                        if (!empty($row['expertise_name']) && $row['expertise_name'] != 'NA') {
                            $exp_items = explode(',', $row['expertise_name']);
                            $exp_badges = [];
                            foreach ($exp_items as $item) {
                                $item = trim($item);
                                if (!empty($item) && $item != 'NA') {
                                    $exp_badges[] = '<span class="badge-exp">' . htmlspecialchars($item) . '</span>';
                                }
                            }
                            if (count($exp_badges) > 0) {
                                $exp_html = implode(' ', $exp_badges);
                            }
                        }

                        $joining = (!empty($row['joining_date']) && $row['joining_date'] != '0000-00-00' && !empty($row['formatted_joining_date'])) ? $row['formatted_joining_date'] : '-';
                        $cpr = !empty($row['cpr_no']) ? htmlspecialchars($row['cpr_no']) : '-';
                        $passport = !empty($row['passport_no']) ? htmlspecialchars($row['passport_no']) : '-';
                        $visa = !empty($row['visa_type']) ? htmlspecialchars($row['visa_type']) : '-';
                        $blood = !empty($row['blood_group']) ? htmlspecialchars($row['blood_group']) : '-';
                        $status_class = ($row['employee_status'] == 'Active') ? 'status-active' : 'status-deactive';
                ?>
                <tr>
                    <td style="text-align: center; font-weight: 600; color: #555;"><?PHP echo $count; ?></td>
                    <td style="text-align: center;">
                        <img src="../httpdocs/images/employee_image/<?PHP echo htmlspecialchars($emp_img); ?>" 
                             onerror="this.onerror=null;this.src='../httpdocs/images/employee_image/default.jpg';" 
                             class="emp-thumb" 
                             alt="Emp Photo" />
                    </td>
                    <td style="text-align: center;"><span class="badge-code"><?PHP echo htmlspecialchars($row['employee_code']); ?></span></td>
                    <td style="text-align: left; padding-left: 8px;">
                        <a href="reports/employee_profile.php?employee_id=<?php echo $row['employee_id']; ?>" target="_blank" style="color: #2e2e79; font-weight: 600; text-decoration: none;">
                            <?PHP echo htmlspecialchars($row['employee_name']); ?>
                        </a>
                    </td>
                    <td style="text-align: center;"><span class="badge-type"><?PHP echo $emp_type_display; ?></span></td>
                    <td style="text-align: left; padding-left: 8px;"><?PHP echo $exp_html; ?></td>
                    <td style="text-align: center; font-weight: 500;"><?PHP echo !empty($row['employee_contact_no']) ? htmlspecialchars($row['employee_contact_no']) : '-'; ?></td>
                    <td style="text-align: center;"><?PHP echo $joining; ?></td>
                    <td style="text-align: center;"><?PHP echo $cpr; ?></td>
                    <td style="text-align: center;"><?PHP echo $passport; ?></td>
                    <td style="text-align: center;"><?PHP echo $visa; ?></td>
                    <td style="text-align: center; font-weight: 600;"><?PHP echo $blood; ?></td>
                    <td style="text-align: center;">
                        <span class="status-badge <?PHP echo $status_class; ?>">
                            <?PHP echo htmlspecialchars($row['employee_status']); ?>
                        </span>
                    </td>
                </tr>
                <?PHP 
                        $count++;
                    }
                } else {
                ?>
                <tr>
                    <td colspan="13" style="text-align: center; color: #777; font-style: italic; padding: 25px;">
                        No employee records found for the selected criteria.
                    </td>
                </tr>
                <?PHP } ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="divFooter">
        <table>
            <tr>
                <td style="width: 60%;">
                    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>
                    CR. <strong>88982-1</strong> | Level 14, Entrance 143/144, Bldg 155, Road 1703, Block 317<br>
                    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
                </td>
                <td style="width: 40%; text-align: right;">
                    <img src="global_assets/images/a.png" alt="THC Logo" style="max-height: 40px;" />
                </td>
            </tr>
        </table>
    </div>

</div>

<script>
function fnExcelReport()
{
    var tab = document.getElementById('main_table');
    
    var excelFile = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>";
    excelFile += "<head><meta charset='utf-8'><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>THC Employee Directory</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:Worksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>";
    excelFile += "<body>";
    excelFile += "<table border='1' style='border-collapse:collapse;'>";
    
    for (var j = 0; j < tab.rows.length; j++) 
    {     
        excelFile += "<tr>" + tab.rows[j].innerHTML + "</tr>";
    }
    
    excelFile += "</table></body></html>";
    
    excelFile = excelFile.replace(/<a[^>]*>(.*?)<\/a>/gi, "$1");
    excelFile = excelFile.replace(/<img[^>]*>/gi, "");
    excelFile = excelFile.replace(/<input[^>]*>|<\/input>/gi, "");
    excelFile = excelFile.replace(/<button[^>]*>|<\/button>/gi, "");

    // Format current date: DD-MM-YYYY
    var d = new Date();
    var day = String(d.getDate()).padStart(2, '0');
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var year = d.getFullYear();
    var exportDate = day + "-" + month + "-" + year;
    var filename = "THCEmployeeDirectory-" + exportDate + ".xlsx";

    var blob = new Blob([excelFile], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8' });
    
    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        var link = document.createElement("a");
        var url = URL.createObjectURL(blob);
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        setTimeout(function() {
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        }, 200);
    }
}
</script>

</body>
</html>