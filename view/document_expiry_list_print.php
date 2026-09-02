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
    DATE_FORMAT(a.expiry_date, '%d/%m/%Y') AS formatted_expiry_date,
    DATE_FORMAT(a.created_at, '%d/%m/%Y') AS formatted_created_at,
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
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Document Expiry Report</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        body, td, th {
            font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-size: 11px;
            color: #000000;
        }

        table.bordered-table, table.bordered-table th, table.bordered-table td {
            border: 1px solid #4E4E4E;
            border-collapse: collapse;
            padding: 5px 6px;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        .btn-action {
            display: inline-block;
            padding: 6px 14px;
            background-color: #2e2e79;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            margin: 4px;
        }
        .btn-action:hover {
            background-color: #1b1b50;
        }
        .btn-excel {
            background-color: #15803d;
        }
        .btn-excel:hover {
            background-color: #14532d;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            div.divFooter {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Print / Export Bar -->
    <div class="no-print" style="text-align: right; padding: 10px 40px; background-color: #f1f5f9; border-bottom: 1px solid #cbd5e1; margin-bottom: 15px;">
        <button type="button" class="btn-action" onclick="window.print();">&#128438; Print Report</button>
        <button type="button" class="btn-action btn-excel" onclick="fnExcelReport();">&#128190; Export to Excel</button>
    </div>

    <!-- Header / Logo -->
    <table align="center" style="border: none; width: 1000px;">
        <tbody>
            <tr style="border: none;">
                <td style="border: none;" width="200">
                    <img src="global_assets/images/backgrounds/thc_logo.png" height="70" width="70" alt="Logo" onerror="this.style.display='none';" />
                </td>
                <td style="border: none; text-align: center;" width="600">
                    <h2 style="margin: 0; color: #1b2441; font-size: 18px; font-weight: 700;">EMPLOYEE DOCUMENT EXPIRY REPORT</h2>
                    <div style="font-size: 11px; color: #555; margin-top: 4px;">
                        <?php 
                        if (!empty($filter_desc)) {
                            echo "<b>Filtered By:</b> " . implode(" | ", $filter_desc);
                        } else {
                            echo "<b>All Document Expiries</b>";
                        }
                        ?>
                    </div>
                </td>
                <td style="border: none; text-align: right; font-size: 11px; color: #555;" width="200">
                    <b>Report Date:</b><br><?php echo date("d-m-Y H:i"); ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="height: 10px;"></div>

    <!-- Main Table -->
    <table align="center" width="1000" id="main_table" class="bordered-table">
        <thead>
            <tr bgcolor="#1b2441" style="color: #daa505; font-weight: bold; text-align: center;">
                <th width="35">Sl.</th>
                <th width="45">Pic</th>
                <th width="75">Code</th>
                <th width="160">Employee Name</th>
                <th width="110">Designation / Type</th>
                <th width="130">Document Name</th>
                <th width="85">Expiry Date</th>
                <th width="110">Days Remaining</th>
                <th width="75">Status</th>
                <th width="110">Remarks</th>
                <th width="65">Emp Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            $expired_total = 0;
            $soon_total = 0;
            $valid_total = 0;

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $count++;
                    $days = intval($row['days_to_expire']);
                    
                    if ($days < 0) {
                        $expired_total++;
                        $days_text = "<font color='red'><b>Expired " . abs($days) . " d ago</b></font>";
                        $status_badge = "<font color='red'><b>Expired</b></font>";
                    } elseif ($days == 0) {
                        $soon_total++;
                        $days_text = "<font color='orange'><b>Expires Today</b></font>";
                        $status_badge = "<font color='orange'><b>Expiring</b></font>";
                    } elseif ($days <= 30) {
                        $soon_total++;
                        $days_text = "<font color='#b45309'><b>" . $days . " days left</b></font>";
                        $status_badge = "<font color='#b45309'><b>Expiring Soon</b></font>";
                    } else {
                        $valid_total++;
                        $days_text = "<font color='green'>" . $days . " days left</font>";
                        $status_badge = "<font color='green'>Valid</font>";
                    }

                    $empImg = (!empty($row['employee_image']) && $row['employee_image'] != 'null' && strpos($row['employee_image'], 'fakepath') === false) 
                        ? trim($row['employee_image']) 
                        : 'default.jpg';
            ?>
            <tr>
                <td class="text-center"><?php echo $count; ?></td>
                <td class="text-center">
                    <img src="../httpdocs/images/employee_image/<?php echo htmlspecialchars($empImg); ?>" width="35" height="35" style="border-radius: 50%; object-fit: cover;" alt="" onerror="this.src='../httpdocs/images/employee_image/default.jpg';" />
                </td>
                <td class="text-center font-weight-bold"><b><?php echo htmlspecialchars($row['employee_code']); ?></b></td>
                <td><b><?php echo htmlspecialchars($row['employee_name']); ?></b></td>
                <td><?php echo htmlspecialchars($row['employee_type_name']); ?></td>
                <td><b><?php echo htmlspecialchars($row['document_name']); ?></b></td>
                <td class="text-center"><b><?php echo $row['formatted_expiry_date']; ?></b></td>
                <td class="text-center"><?php echo $days_text; ?></td>
                <td class="text-center"><?php echo $status_badge; ?></td>
                <td style="font-size: 10px;"><?php echo !empty($row['remarks']) ? htmlspecialchars($row['remarks']) : '-'; ?></td>
                <td class="text-center">
                    <?php if ($row['employee_status'] == 'Active') { ?>
                        <font color="green">Active</font>
                    <?php } else { ?>
                        <font color="red">Inactive</font>
                    <?php } ?>
                </td>
            </tr>
            <?php 
                }
            } else {
            ?>
            <tr>
                <td colspan="11" class="text-center" style="padding: 20px; color: #888; font-style: italic;">
                    No document expiry records found matching the specified criteria.
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="height: 15px;"></div>

    <!-- Summary Counts Table -->
    <table align="center" width="1000" style="border: 1px solid #4E4E4E; border-collapse: collapse;">
        <tr bgcolor="#f1f5f9">
            <td style="padding: 8px; border: 1px solid #4E4E4E; font-weight: 600;" width="250">
                Total Documents with Expiry: <b><?php echo $count; ?></b>
            </td>
            <td style="padding: 8px; border: 1px solid #4E4E4E; font-weight: 600; color: #b91c1c;" width="250">
                Expired: <b><?php echo $expired_total; ?></b>
            </td>
            <td style="padding: 8px; border: 1px solid #4E4E4E; font-weight: 600; color: #b45309;" width="250">
                Expiring in &le; 30 Days: <b><?php echo $soon_total; ?></b>
            </td>
            <td style="padding: 8px; border: 1px solid #4E4E4E; font-weight: 600; color: #15803d;" width="250">
                Valid (> 30 Days): <b><?php echo $valid_total; ?></b>
            </td>
        </tr>
    </table>

    <div style="height: 25px;"></div>

    <!-- Footer -->
    <div class="divFooter" style="padding-top: 15px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="1000" style="border: none; padding: 15px 0;">
            <tr style="border: none; background-color: #f9df5c; padding: 15px;">
                <td style="border: none; padding-left: 20px; font-size: 10px;" width="500">
                    C.R. 88982-1, Bldg 155, Road 1703, Block 317<br>
                    Entrance 144, Diplomatic Area, Kingdom of Bahrain
                </td>
                <td style="border: none; text-align: right; padding-right: 20px; font-size: 10px;" width="500">
                    Tele: <strong>+973 17 100 190</strong> Fax: +973 77 226 060<br>
                    info@thc.com.bh <strong>www.thc.com.bh</strong>
                </td>
            </tr>
        </table>
    </div>

</body>
<script>
function fnExcelReport()
{
    var tab_text="<table border='2px' ><tr bgcolor='#1b2441' style='color:#FFFFFF;'>";
    var j=0;
    var tab = document.getElementById('main_table');

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
    }

    tab_text = tab_text + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");
    tab_text = tab_text.replace(/<img[^>]*>/gi, "");
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, "");

    var sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
    return (sa);
}
</script>
</html>
