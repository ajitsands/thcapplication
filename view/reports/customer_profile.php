<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
date_default_timezone_set('Asia/Bahrain');

$cust_id = isset($_GET["cust_id"]) ? intval($_GET["cust_id"]) : 0;
if ($cust_id <= 0) {
    die("<div style='font-family: Montserrat, sans-serif; text-align:center; padding:50px; color:#c62828;'><h3>Invalid Customer ID</h3></div>");
}

$sql_cust = "SELECT *, 
    DATE_FORMAT(date_active, '%d-%m-%Y') as date_active1, 
    DATE_FORMAT(date_deactive, '%d-%m-%Y') as date_deactive1 
FROM tbl_customers 
WHERE customer_id = $cust_id LIMIT 1";

$result = mysqli_query($varDBConnection, $sql_cust);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("<div style='font-family: Montserrat, sans-serif; text-align:center; padding:50px; color:#c62828;'><h3>Customer record not found.</h3></div>");
}

// Fetch Customer Facilities
$result_facilities = mysqli_query($varDBConnection, "SELECT * FROM tbl_customer_location WHERE customer_id = $cust_id ORDER BY customer_location_id ASC");
$facilities_list = [];
if ($result_facilities) {
    while ($rf = mysqli_fetch_assoc($result_facilities)) {
        $facilities_list[] = $rf;
    }
}
$total_facilities = count($facilities_list);

// Fetch Customer AMC Contracts
$result_amc = mysqli_query($varDBConnection, "SELECT *, 
    DATE_FORMAT(amc_signed_date, '%d-%m-%Y') as amc_signed_date1, 
    DATE_FORMAT(amc_start_date, '%d-%m-%Y') as amc_start_date1, 
    DATE_FORMAT(amc_end_date, '%d-%m-%Y') as amc_end_date1 
FROM tbl_amc_master 
WHERE customer_id = $cust_id 
ORDER BY amc_id DESC");

$amc_list = [];
if ($result_amc) {
    while ($ra = mysqli_fetch_assoc($result_amc)) {
        $amc_list[] = $ra;
    }
}
$total_amcs = count($amc_list);

$cust_status = !empty($row['customer_status']) ? trim($row['customer_status']) : 'Active';
$is_active = (strcasecmp($cust_status, 'Active') === 0);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Customer Profile - <?PHP echo htmlspecialchars($row['customer_name']); ?></title>
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

        .profile-container {
            width: 820px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        }

        table.tbl-bordered {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-collapse: collapse;
            margin-bottom: 14px;
            background: #ffffff;
        }

        table.tbl-bordered th, table.tbl-bordered td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            font-size: 12px;
            vertical-align: middle;
        }

        .header-bg {
            background-color: #2e2e79 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 8px 12px !important;
            font-size: 12.5px;
            letter-spacing: 0.3px;
        }

        .lbl-bg {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-align: right;
            width: 140px;
        }

        .badge-status-active {
            display: inline-block;
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            border-radius: 4px;
            padding: 3px 8px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }

        .badge-status-inactive {
            display: inline-block;
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            border-radius: 4px;
            padding: 3px 8px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }

        .badge-status-hold {
            display: inline-block;
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 600;
            font-size: 11px;
        }

        .badge-code {
            display: inline-block;
            background-color: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
            border-radius: 4px;
            padding: 2px 8px;
            font-weight: 700;
            font-size: 11.5px;
            letter-spacing: 0.3px;
        }

        .badge-pill {
            display: inline-block;
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 2px 8px;
            font-weight: 600;
            font-size: 11px;
        }

        .stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            text-align: center;
        }

        .stat-num {
            font-size: 17px;
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
            padding: 7px 14px;
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

        .hero-banner {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid #c7d2fe;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 14px;
        }

        .divFooter {
            margin-top: 18px;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .profile-container {
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

<div class="profile-container">

    <!-- Top Actions (No Print) -->
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
        <div style="font-size: 12px; color: #64748b;">
            Customer Record ID: <strong>#<?PHP echo $cust_id; ?></strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-action btn-excel" onclick="fnExcelReport();">
                <span>&#128196;</span> Export to Excel
            </button>
            <button type="button" class="btn-action" onclick="window.print();">
                <span>&#128438;</span> Print Profile
            </button>
        </div>
    </div>

    <!-- Header / Brand -->
    <table style="width: 100%; border: none; border-collapse: collapse; margin-bottom: 12px;">
        <tbody>
            <tr>
                <td style="border: none; padding: 0; width: 50%;">
                    <img src="../global_assets/images/logo_print.png" alt="THC Logo" style="max-height: 70px; height: auto;" />
                </td>
                <td style="border: none; padding: 0; width: 50%; text-align: right; vertical-align: middle;">
                    <div style="font-size: 17px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">CUSTOMER PROFILE</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 3px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Hero / Summary Banner -->
    <div class="hero-banner page-break-inside-avoid">
        <table style="width: 100%; border: none; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="border: none; padding: 0; vertical-align: middle; width: 58%;">
                        <div style="font-size: 18px; font-weight: 700; color: #1e1b4b; line-height: 1.3;">
                            <?PHP echo htmlspecialchars($row['customer_name']); ?>
                        </div>
                        <div style="margin-top: 6px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <span class="badge-code"><?PHP echo htmlspecialchars($row['customer_code'] ? $row['customer_code'] : 'CUST-' . $cust_id); ?></span>
                            
                            <?php if (!empty($row['customer_cpr_cr_no']) && $row['customer_cpr_cr_no'] != 'NA') { ?>
                                <span class="badge-pill">CR: <strong><?PHP echo htmlspecialchars($row['customer_cpr_cr_no']); ?></strong></span>
                            <?php } ?>

                            <?php if (!empty($row['customer_vat_no']) && $row['customer_vat_no'] != 'NA') { ?>
                                <span class="badge-pill">VAT: <strong><?PHP echo htmlspecialchars($row['customer_vat_no']); ?></strong></span>
                            <?php } ?>

                            <?php if ($is_active) { ?>
                                <span class="badge-status-active">&#10003; Active</span>
                            <?php } else { ?>
                                <span class="badge-status-inactive">&#10007; <?PHP echo htmlspecialchars($cust_status); ?></span>
                            <?php } ?>
                        </div>
                    </td>
                    <td style="border: none; padding: 0; width: 42%; vertical-align: middle;">
                        <table style="width: 100%; border: none; border-collapse: separate; border-spacing: 6px 0;">
                            <tbody>
                                <tr>
                                    <td class="stat-card" style="width: 50%;">
                                        <div class="stat-num"><?PHP echo $total_facilities; ?></div>
                                        <div class="stat-lbl">Facilities</div>
                                    </td>
                                    <td class="stat-card" style="width: 50%;">
                                        <div class="stat-num"><?PHP echo $total_amcs; ?></div>
                                        <div class="stat-lbl">AMCs</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Main Content Table Container for Excel Export Compatibility -->
    <div id="main_table">

        <!-- SECTION 1: Customer Details -->
        <table class="tbl-bordered page-break-inside-avoid">
            <tbody>
                <tr>
                    <td colspan="4" class="header-bg">
                        <strong>1. PRIMARY CUSTOMER &amp; CONTACT DETAILS</strong>
                    </td>
                </tr>
                <tr>
                    <td class="lbl-bg">Customer Name:</td>
                    <td style="width: 260px; font-weight: 600;">
                        <?PHP echo htmlspecialchars($row['customer_name']); ?>
                    </td>
                    <td class="lbl-bg">Customer Code:</td>
                    <td style="font-weight: 700; color: #2e2e79;">
                        <?PHP echo htmlspecialchars($row['customer_code'] ? $row['customer_code'] : 'N/A'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="lbl-bg">CPR / CR No:</td>
                    <td><?PHP echo htmlspecialchars($row['customer_cpr_cr_no'] ? $row['customer_cpr_cr_no'] : 'N/A'); ?></td>
                    <td class="lbl-bg">VAT Reg. No:</td>
                    <td><?PHP echo htmlspecialchars($row['customer_vat_no'] ? $row['customer_vat_no'] : 'N/A'); ?></td>
                </tr>
                <tr>
                    <td class="lbl-bg">Primary Contact No:</td>
                    <td style="font-weight: 600;"><?PHP echo htmlspecialchars($row['customer_contact_no'] ? $row['customer_contact_no'] : 'N/A'); ?></td>
                    <td class="lbl-bg">Contact Person:</td>
                    <td>
                        <?php 
                        $cp_name = !empty($row['customer_contact_person_name']) ? htmlspecialchars($row['customer_contact_person_name']) : '';
                        $cp_no = !empty($row['customer_contact_person_no']) ? htmlspecialchars($row['customer_contact_person_no']) : '';
                        if ($cp_name || $cp_no) {
                            echo "<strong>$cp_name</strong>" . ($cp_no ? " ($cp_no)" : "");
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="lbl-bg">Email Address:</td>
                    <td>
                        <?php if (!empty($row['customer_email_id']) && $row['customer_email_id'] != 'NA') { ?>
                            <a href="mailto:<?PHP echo htmlspecialchars($row['customer_email_id']); ?>" style="color: #2e2e79; text-decoration: none; font-weight: 500;">
                                <?PHP echo htmlspecialchars($row['customer_email_id']); ?>
                            </a>
                        <?php } else { echo "N/A"; } ?>
                    </td>
                    <td class="lbl-bg">Account Status:</td>
                    <td>
                        <?php if ($is_active) { ?>
                            <span class="badge-status-active">Active</span>
                        <?php } else { ?>
                            <span class="badge-status-inactive"><?PHP echo htmlspecialchars($cust_status); ?></span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td class="lbl-bg">Date of Active:</td>
                    <td><?PHP echo !empty($row['date_active1']) && $row['date_active1'] != '00-00-0000' ? $row['date_active1'] : 'N/A'; ?></td>
                    <td class="lbl-bg">Date of Inactive:</td>
                    <td><?PHP echo !empty($row['date_deactive1']) && $row['date_deactive1'] != '00-00-0000' ? $row['date_deactive1'] : '-'; ?></td>
                </tr>
                <tr>
                    <td class="lbl-bg">Billing / Address:</td>
                    <td colspan="3"><?PHP echo !empty($row['customer_address']) ? nl2br(htmlspecialchars($row['customer_address'])) : 'N/A'; ?></td>
                </tr>
                <?php if (!empty($row['customer_description']) && $row['customer_description'] != 'NA') { ?>
                <tr>
                    <td class="lbl-bg">Notes / Remarks:</td>
                    <td colspan="3"><?PHP echo nl2br(htmlspecialchars($row['customer_description'])); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- SECTION 2: Customer Facilities -->
        <table class="tbl-bordered page-break-inside-avoid">
            <tbody>
                <tr>
                    <td colspan="5" class="header-bg">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <span><strong>2. REGISTERED FACILITIES &amp; LOCATIONS</strong></span>
                            <span style="font-size: 11px; font-weight: 600; background: rgba(255,255,255,0.25); padding: 2px 8px; border-radius: 10px;">
                                Total: <?PHP echo $total_facilities; ?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700; text-align: center; color: #334155;">
                    <td style="width: 40px;">Sl.</td>
                    <td style="width: 220px; text-align: left;">Facility / Building</td>
                    <td style="width: 170px; text-align: left;">Location</td>
                    <td style="text-align: left;">Address</td>
                    <td style="width: 180px; text-align: left;">Contact Point</td>
                </tr>
                <?php 
                if ($total_facilities > 0) {
                    $sl = 0;
                    foreach ($facilities_list as $row_fac) {
                        $sl++;
                        $b_name = htmlspecialchars($row_fac['building_name']);
                        $b_code = !empty($row_fac['building_code']) && $row_fac['building_code'] != 'NA' ? htmlspecialchars($row_fac['building_code']) : '';
                        $l_name = !empty($row_fac['location_name']) ? htmlspecialchars($row_fac['location_name']) : '-';
                        $b_addr = !empty($row_fac['building_address']) && $row_fac['building_address'] != 'NA' ? htmlspecialchars($row_fac['building_address']) : '-';
                        $cp = '';
                        if (!empty($row_fac['contact_person_name']) && $row_fac['contact_person_name'] != 'NA') {
                            $cp .= '<strong>' . htmlspecialchars($row_fac['contact_person_name']) . '</strong>';
                        }
                        if (!empty($row_fac['contact_person_no']) && $row_fac['contact_person_no'] != 'NA') {
                            $cp .= ($cp ? '<br>' : '') . '<span style="color:#64748b;">' . htmlspecialchars($row_fac['contact_person_no']) . '</span>';
                        }
                        if (!$cp) $cp = '-';
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $sl; ?></td>
                            <td>
                                <strong><?PHP echo $b_name; ?></strong>
                                <?php if ($b_code) { ?>
                                    <br><span style="font-size: 10.5px; color: #64748b;">Code: <?PHP echo $b_code; ?></span>
                                <?php } ?>
                            </td>
                            <td><?PHP echo $l_name; ?></td>
                            <td><?PHP echo $b_addr; ?></td>
                            <td><?PHP echo $cp; ?></td>
                        </tr>
                        <?php 
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; font-style: italic; padding: 14px;">
                            No registered facilities found for this customer.
                        </td>
                    </tr>
                    <?php 
                }
                ?>
            </tbody>
        </table>

        <!-- SECTION 3: AMC Details -->
        <table class="tbl-bordered page-break-inside-avoid">
            <tbody>
                <tr>
                    <td colspan="5" class="header-bg">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <span><strong>3. ANNUAL MAINTENANCE CONTRACTS (AMC)</strong></span>
                            <span style="font-size: 11px; font-weight: 600; background: rgba(255,255,255,0.25); padding: 2px 8px; border-radius: 10px;">
                                Total: <?PHP echo $total_amcs; ?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr style="background: #f1f5f9; font-weight: 700; text-align: center; color: #334155;">
                    <td style="width: 40px;">Sl.</td>
                    <td style="width: 170px; text-align: left;">AMC Ref. No.</td>
                    <td style="width: 180px; text-align: left;">Contract Type</td>
                    <td style="text-align: left;">Contract Duration</td>
                    <td style="width: 110px; text-align: center;">AMC Status</td>
                </tr>
                <?php 
                if ($total_amcs > 0) {
                    $sla = 0;
                    foreach ($amc_list as $row_amc) {
                        $sla++;
                        $amc_ref = htmlspecialchars($row_amc['amc_ref_no']);
                        $c_type = !empty($row_amc['contract_type_name']) ? htmlspecialchars($row_amc['contract_type_name']) : 'AMC Contract';
                        $start_dt = !empty($row_amc['amc_start_date1']) ? $row_amc['amc_start_date1'] : '-';
                        $end_dt = !empty($row_amc['amc_end_date1']) ? $row_amc['amc_end_date1'] : '-';
                        $amc_st = !empty($row_amc['amc_status']) ? trim($row_amc['amc_status']) : 'Active';

                        $st_badge = '<span class="badge-status-active">Active</span>';
                        if (strcasecmp($amc_st, 'Active') !== 0) {
                            if (strcasecmp($amc_st, 'Hold') === 0) {
                                $st_badge = '<span class="badge-status-hold">Hold</span>';
                            } else if (strcasecmp($amc_st, 'Completed') === 0) {
                                $st_badge = '<span class="badge-pill" style="background:#e0f2fe; color:#0369a1;">Completed</span>';
                            } else {
                                $st_badge = '<span class="badge-status-inactive">' . htmlspecialchars($amc_st) . '</span>';
                            }
                        }
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $sla; ?></td>
                            <td>
                                <span class="badge-code"><?PHP echo $amc_ref; ?></span>
                            </td>
                            <td style="font-weight: 500;"><?PHP echo $c_type; ?></td>
                            <td>
                                <span><?PHP echo $start_dt; ?></span> &rarr; <span><strong><?PHP echo $end_dt; ?></strong></span>
                            </td>
                            <td style="text-align: center;"><?PHP echo $st_badge; ?></td>
                        </tr>
                        <?php 
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; font-style: italic; padding: 14px;">
                            No AMC contracts found for this customer.
                        </td>
                    </tr>
                    <?php 
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- Company Footer -->
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
                        <img src="../global_assets/images/a.png" alt="Footer Logo" style="max-height: 38px;" />
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
    tab_text += "<tr><th colspan='5' style='background:#2e2e79;color:#ffffff;font-size:16px;padding:8px;'>CUSTOMER PROFILE - " + <?php echo json_encode($row['customer_name']); ?> + "</th></tr>";
    
    var tables = tab.getElementsByTagName('table');
    for (var t = 0; t < tables.length; t++) {
        var rows = tables[t].rows;
        for (var j = 0; j < rows.length; j++) {
            tab_text += "<tr>" + rows[j].innerHTML + "</tr>";
        }
        tab_text += "<tr><td colspan='5' style='height:15px;'></td></tr>";
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
        txtArea1.contentWindow.document.execCommand("SaveAs", true, "Customer_Profile_" + <?php echo json_encode($row['customer_code'] ? $row['customer_code'] : $cust_id); ?> + ".xls");
        document.body.removeChild(txtArea1);
    } else {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
        a.href = data_type;
        a.download = "Customer_Profile_" + <?php echo json_encode($row['customer_code'] ? $row['customer_code'] : $cust_id); ?> + ".xls";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
}
</script>

</body>
</html>