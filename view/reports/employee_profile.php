<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
date_default_timezone_set('Asia/Bahrain');

$employee_id = isset($_GET["employee_id"]) ? intval($_GET["employee_id"]) : 0;
if ($employee_id <= 0) {
    die("Invalid Employee ID");
}

$sql_emp = "SELECT *, 
    DATE_FORMAT(joining_date,'%d-%m-%Y') as formatted_joining_date,
    DATE_FORMAT(cpr_expiry_date,'%d-%m-%Y') as formatted_cpr_expiry_date,
    DATE_FORMAT(visa_validity_on,'%d-%m-%Y') as formatted_visa_validity 
FROM tbl_employees 
WHERE employee_id = $employee_id LIMIT 1";

$result = mysqli_query($varDBConnection, $sql_emp);
$row = mysqli_fetch_assoc($result);
if (!$row) {
    die("Employee record not found.");
}

// Fetch all expertise for technician from tbl_technician_expertise
$expertise_list = [];
if ($row['employee_type_name'] == 'Technician') {
    $exp_query = mysqli_query($varDBConnection, "SELECT expertise_name FROM tbl_technician_expertise WHERE employee_id = $employee_id AND status = 'Active' ORDER BY technician_expertise_id ASC");
    if ($exp_query) {
        while ($exp = mysqli_fetch_assoc($exp_query)) {
            if (!empty($exp['expertise_name']) && $exp['expertise_name'] != 'NA') {
                $expertise_list[] = htmlspecialchars($exp['expertise_name']);
            }
        }
    }
}

// Fetch employee attachments from tbl_employee_attachments
$att_query = mysqli_query($varDBConnection, "SELECT *, 
    DATE_FORMAT(expiry_date, '%d-%m-%Y') as formatted_exp_date,
    DATE_FORMAT(created_at, '%d-%m-%Y') as formatted_created_at 
FROM tbl_employee_attachments 
WHERE employee_id = $employee_id AND status = 'Active' 
ORDER BY attachment_id ASC");

$emp_img = (!empty($row['employee_image']) && $row['employee_image'] != 'null' && strpos($row['employee_image'], 'fakepath') === false) ? trim($row['employee_image']) : 'default.jpg';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employee Profile - <?PHP echo htmlspecialchars($row['employee_name']); ?></title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style type="text/css">
        body, td, th {
            font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-size: 12px;
            color: #000000;
        }

        table.tbl-bordered, table.tbl-bordered th, table.tbl-bordered td {
            border: 1px solid #4E4E4E;
            border-collapse: collapse;
            padding: 6px 8px;
        }

        .header-bg {
            background-color: #2e2e79 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 7px 10px;
            font-size: 13px;
        }

        .badge-exp {
            display: inline-block;
            background-color: #e8ecfa;
            color: #2e2e79;
            border: 1px solid #c2cde8;
            border-radius: 3px;
            padding: 2px 7px;
            margin: 2px 3px 2px 0;
            font-weight: 600;
            font-size: 11px;
        }

        .badge-doc {
            display: inline-block;
            background-color: #e3f2fd;
            color: #0d47a1;
            border-radius: 3px;
            padding: 2px 6px;
            font-weight: 600;
            font-size: 11px;
        }

        .print-btn {
            background: #2e2e79;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
        }

        @media print {
            div.divFooter {
                position: fixed;
                bottom: 0;
            }
            .no-print {
                display: none !important;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

<div style="width: 800px; margin: 0 auto;">

    <!-- Top Action Buttons (No Print) -->
    <div class="no-print" style="text-align: right; margin-bottom: 10px; padding: 5px 0;">
        <button class="print-btn" onclick="window.print();"><b>&#128438;</b> Print Profile</button>
    </div>

    <!-- Header / Brand -->
    <table align="center" style="border: none; margin-bottom: 8px;" width="800">
        <tbody>
            <tr style="border: none;">
                <td style="border: none;" width="400">
                    <img src="../global_assets/images/logo_print.png" alt="THC Logo" style="max-height: 75px; height: auto;" />
                </td>
                <td style="border: none; text-align: right;" width="400">
                    <span style="font-size: 16px; font-weight: 700; color: #2e2e79;">EMPLOYEE PROFILE</span><br>
                    <span style="font-size: 11px; color: #555;"><b>Date:</b> <?PHP echo date("d-m-Y"); ?></span>
                </td>
            </tr>
        </tbody>
    </table>

    <table id="main_table" align="center" style="border: none;" width="800">
        <tbody>
            <tr style="border: none;">
                <td style="border: none; padding: 0;">

                    <!-- SECTION 1: Basic Employee Details -->
                    <table class="tbl-bordered" align="center" width="800">
                        <tbody>
                            <tr>
                                <td colspan="6" class="header-bg"><strong>1. BASIC EMPLOYEE DETAILS</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="4" align="center" valign="middle" width="160" style="background: #fafafa; padding: 8px;">
                                    <img src="../../httpdocs/images/employee_image/<?PHP echo htmlspecialchars($emp_img); ?>" 
                                         onerror="this.onerror=null;this.src='../../httpdocs/images/employee_image/default.jpg';" 
                                         width="135" height="155" style="object-fit: cover; border: 1px solid #bbb; border-radius: 4px;" alt="Employee Photo" />
                                </td>
                                <td style="text-align: right; background: #f8f9fa;" width="140"><b>Employee Name:</b></td>
                                <td width="190" style="text-align: left;"><b><?PHP echo htmlspecialchars($row['employee_name']); ?></b></td>
                                <td style="text-align: right; background: #f8f9fa;" width="140"><b>Employee Type:</b></td>
                                <td width="170" style="text-align: left;">
                                    <?php 
                                    if ($row['employee_type_name'] == 'Technician') {
                                        $tech_type_suffix = !empty($row['technician_type']) && $row['technician_type'] != 'select' ? ' (' . htmlspecialchars($row['technician_type']) . ')' : '';
                                        echo '<b>Technician' . $tech_type_suffix . '</b>';
                                    } else {
                                        echo '<b>' . htmlspecialchars($row['employee_type_name']) . '</b>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right; background: #f8f9fa;"><b>Employee Code:</b></td>
                                <td style="text-align: left; color: #2e2e79; font-weight: 700;"><?PHP echo htmlspecialchars($row['employee_code']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;"><b>CPR No:</b></td>
                                <td style="text-align: left;"><?php echo htmlspecialchars($row['cpr_no']); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; background: #f8f9fa;"><b>Contact No:</b></td>
                                <td style="text-align: left;"><?PHP echo htmlspecialchars($row['employee_contact_no']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;"><b>Passport No:</b></td>
                                <td style="text-align: left;"><?php echo htmlspecialchars($row['passport_no']); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; background: #f8f9fa;"><b>Email Id:</b></td>
                                <td style="text-align: left;"><?PHP echo htmlspecialchars($row['employee_email_id']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;"><b>Date of Join:</b></td>
                                <td style="text-align: left;"><?php echo !empty($row['formatted_joining_date']) && $row['joining_date'] != '0000-00-00' ? $row['formatted_joining_date'] : 'N/A'; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div style="height: 10px;"></div>

                    <!-- SECTION 2: Official, Visa & Personal Details -->
                    <table class="tbl-bordered" align="center" width="800">
                        <tbody>
                            <tr>
                                <td colspan="6" class="header-bg"><strong>2. OFFICIAL, VISA &amp; PERSONAL DETAILS</strong></td>
                            </tr>
                            <tr>
                                <td width="130" style="text-align: right; background: #f8f9fa;"><b>Local Address:</b></td>
                                <td width="270" colspan="2"><?php echo htmlspecialchars($row['employee_address']); ?></td>
                                <td width="130" style="text-align: right; background: #f8f9fa;"><b>CPR Expiry Date:</b></td>
                                <td width="270" colspan="2"><?php echo !empty($row['formatted_cpr_expiry_date']) && $row['cpr_expiry_date'] != '0000-00-00' ? $row['formatted_cpr_expiry_date'] : 'N/A'; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; background: #f8f9fa;"><b>Visa Type:</b></td>
                                <td colspan="2"><?php echo htmlspecialchars($row['visa_type']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;"><b>Visa Validity:</b></td>
                                <td colspan="2"><?php echo !empty($row['formatted_visa_validity']) && $row['visa_validity_on'] != '0000-00-00' ? $row['formatted_visa_validity'] : 'N/A'; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right; background: #f8f9fa;"><b>Driving License:</b></td>
                                <td width="135"><?php echo htmlspecialchars($row['is_driving_license']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;" width="135"><b>Blood Group:</b></td>
                                <td width="135"><?php echo htmlspecialchars($row['blood_group']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;" width="135"><b>Employee Status:</b></td>
                                <td width="130">
                                    <b style="color: <?php echo ($row['employee_status'] == 'Active') ? '#2e7d32' : '#c62828'; ?>;">
                                        <?php echo htmlspecialchars($row['employee_status']); ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right; background: #f8f9fa;"><b>Native Address:</b></td>
                                <td colspan="2"><?php echo htmlspecialchars($row['native_address']); ?></td>
                                <td style="text-align: right; background: #f8f9fa;"><b>Native Contact No:</b></td>
                                <td colspan="2"><?php echo htmlspecialchars($row['native_number']); ?></td>
                            </tr>

                            <?php if ($row['employee_type_name'] == 'Technician') { ?>
                            <!-- SECTION 2.1: Technician Expertise (Only for Technicians) -->
                            <tr>
                                <td style="text-align: right; background: #f0f3fa; vertical-align: middle;"><b>Technician Expertise:</b></td>
                                <td colspan="5" style="padding: 8px 10px;">
                                    <?php 
                                    if (!empty($expertise_list)) {
                                        foreach ($expertise_list as $exp_item) {
                                            echo '<span class="badge-exp">' . $exp_item . '</span>';
                                        }
                                    } else {
                                        echo '<span style="color: #888; font-style: italic;">No specific expertise assigned.</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div style="height: 10px;"></div>

                    <!-- SECTION 3: Employee Attachments & Documents -->
                    <table class="tbl-bordered" align="center" width="800">
                        <tbody>
                            <tr>
                                <td colspan="6" class="header-bg"><strong>3. EMPLOYEE ATTACHMENTS &amp; DOCUMENTS</strong></td>
                            </tr>
                            <tr style="background: #eef1f8; font-weight: 700; text-align: center;">
                                <td width="35">Sl.</td>
                                <td width="175">Document Name / Type</td>
                                <td width="105">Expiry Date</td>
                                <td width="235">Remarks / Notes</td>
                                <td width="105">Uploaded Date</td>
                                <td width="145">Attachment File</td>
                            </tr>
                            <?php
                            $att_count = 0;
                            if ($att_query && mysqli_num_rows($att_query) > 0) {
                                while ($att = mysqli_fetch_assoc($att_query)) {
                                    $att_count++;
                                    $exp_date_text = (!empty($att['expiry_date']) && $att['expiry_date'] != '0000-00-00' && !empty($att['formatted_exp_date'])) ? $att['formatted_exp_date'] : 'N/A';
                                    $upload_date_text = (!empty($att['created_at']) && !empty($att['formatted_created_at'])) ? $att['formatted_created_at'] : '-';
                                    $remarks_text = !empty($att['remarks']) ? htmlspecialchars($att['remarks']) : '-';
                                    $doc_name_text = htmlspecialchars($att['document_name']);
                                    $file_link_html = '<span style="color: #999;">No File</span>';
                                    
                                    if (!empty($att['file_path'])) {
                                        $file_link_html = '<a href="../' . htmlspecialchars($att['file_path']) . '" target="_blank" style="color: #2e2e79; font-weight: 600; text-decoration: underline;">&#128196; View Document</a>';
                                    }

                                    echo '<tr>
                                        <td style="text-align: center;">' . $att_count . '</td>
                                        <td><span class="badge-doc">' . $doc_name_text . '</span></td>
                                        <td style="text-align: center;">' . $exp_date_text . '</td>
                                        <td>' . $remarks_text . '</td>
                                        <td style="text-align: center;">' . $upload_date_text . '</td>
                                        <td style="text-align: center;">' . $file_link_html . '</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr>
                                    <td colspan="6" style="text-align: center; color: #777; font-style: italic; padding: 14px;">
                                        No attachments or documents uploaded for this employee.
                                    </td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>

    <div style="height: 20px;"></div>

    <!-- Footer -->
    <div class="divFooter" style="margin-top: 15px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border: none; padding: 15px 0;">
            <tr style="border: none; background-color: #2e2e79;">
                <td style="border: none; padding: 12px 20px; color: white;" width="500">
                    <small>Tele:</small> +973 17 100 190 | info@thc.com.bh | <strong>www.thc.com.bh</strong><br>
                    CR. <strong>88982-1</strong> | Level 14, Entrance 143/144, Bldg 155, Road 1703, Block 317<br>
                    <strong>YBA Kanoo Tower, Diplomatic Area</strong>, Kingdom of Bahrain
                </td>
                <td style="border: none; text-align: right; padding: 12px 20px;" width="300">
                    <img src="../global_assets/images/a.png" alt="Footer Logo" style="max-height: 40px;" />
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>