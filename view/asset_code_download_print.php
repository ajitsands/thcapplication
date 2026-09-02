<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
date_default_timezone_set('Asia/Bahrain');

$customer_id = isset($_GET["customer_id"]) ? trim($_GET["customer_id"]) : 'All';
$building_id = isset($_GET["building_id"]) ? trim($_GET["building_id"]) : 'All';
$category_id = isset($_GET["category_id"]) ? trim($_GET["category_id"]) : 'All';

$where = array();
$where[] = "asset_status = 'Active'";
$filter_desc = array();

// Customer filter
if ($customer_id != 'All' && !empty($customer_id)) {
    $c_id = mysqli_real_escape_string($varDBConnection, $customer_id);
    $where[] = "customer_id = '$c_id'";
    $q_cust = mysqli_query($varDBConnection, "SELECT customer_name, customer_code FROM tbl_customers WHERE customer_id = '$c_id'");
    if ($q_cust && $r_cust = mysqli_fetch_assoc($q_cust)) {
        $filter_desc[] = "Customer: " . htmlspecialchars($r_cust['customer_code'] . ' - ' . $r_cust['customer_name']);
    } else {
        $filter_desc[] = "Customer ID: " . htmlspecialchars($c_id);
    }
} else {
    $filter_desc[] = "Customer: All Customers";
}

// Building filter
if ($building_id != 'All' && !empty($building_id)) {
    $b_id = mysqli_real_escape_string($varDBConnection, $building_id);
    $where[] = "building_id = '$b_id'";
    $q_bld = mysqli_query($varDBConnection, "SELECT building_name, building_code FROM tbl_building WHERE building_id = '$b_id'");
    if ($q_bld && $r_bld = mysqli_fetch_assoc($q_bld)) {
        $filter_desc[] = "Building: " . htmlspecialchars($r_bld['building_code'] . ' - ' . $r_bld['building_name']);
    } else {
        $filter_desc[] = "Building ID: " . htmlspecialchars($b_id);
    }
} else {
    $filter_desc[] = "Building: All Buildings";
}

// Category filter
if ($category_id != 'All' && !empty($category_id)) {
    $cat_id = mysqli_real_escape_string($varDBConnection, $category_id);
    $where[] = "asset_category_id = '$cat_id'";
    $q_cat = mysqli_query($varDBConnection, "SELECT category_name FROM tbl_category WHERE category_id = '$cat_id'");
    if ($q_cat && $r_cat = mysqli_fetch_assoc($q_cat)) {
        $filter_desc[] = "Category: " . htmlspecialchars($r_cat['category_name']);
    } else {
        $filter_desc[] = "Category ID: " . htmlspecialchars($cat_id);
    }
} else {
    $filter_desc[] = "Category: All Categories";
}

$where_clause = implode(" AND ", $where);
$sql = "SELECT * FROM tbl_assets WHERE $where_clause ORDER BY asset_id DESC";
$result = mysqli_query($varDBConnection, $sql);

$assets_list = [];
$unique_categories = [];
$unique_buildings = [];
$unique_customers = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $assets_list[] = $row;
        if (!empty($row['asset_category_name'])) {
            $unique_categories[$row['asset_category_name']] = true;
        }
        if (!empty($row['asset_building'])) {
            $unique_buildings[$row['asset_building']] = true;
        }
        if (!empty($row['customer_name'])) {
            $unique_customers[$row['customer_name']] = true;
        }
    }
}

$total_assets = count($assets_list);
$total_categories = count($unique_categories);
$total_buildings = count($unique_buildings);
$total_customers = count($unique_customers);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>List of Customer Assets - Total (<?PHP echo $total_assets; ?>)</title>
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
            width: 1050px;
            max-width: 96%;
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
            word-break: break-all;
        }

        .badge-cat {
            display: inline-block;
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 600;
            font-size: 10.5px;
        }

        .badge-type {
            display: inline-block;
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 4px;
            padding: 2px 7px;
            font-weight: 600;
            font-size: 10.5px;
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

        .btn-toggle {
            background: #475569;
        }

        .btn-toggle:hover {
            background: #334155;
        }

        .search-box {
            padding: 6px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            font-size: 11.5px;
            font-family: inherit;
            outline: none;
            width: 180px;
            transition: border-color 0.2s;
        }

        .search-box:focus {
            border-color: #2e2e79;
        }

        .divFooter {
            margin-top: 20px;
        }

        @media print {
            @page {
                size: landscape;
                margin: 8mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .report-container {
                width: 100% !important;
                max-width: 100% !important;
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
    <div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
        <div style="font-size: 12px; color: #64748b;">
            Document: <strong>List of Customer Assets Master Report</strong>
        </div>
        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <input type="text" id="report_search" class="search-box" placeholder="Quick Search Assets..." onkeyup="filterTable();" />
            <button type="button" class="btn-action btn-toggle" id="btn_toggle_qr" onclick="toggleQRCodes();" title="Toggle QR Code display">
                <span>&#9638;</span> Toggle QR
            </button>
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
                <td style="border: none; padding: 0; width: 45%; vertical-align: middle;">
                    <img src="global_assets/images/logo_print.png" alt="THC Logo" style="max-height: 70px; height: auto;" />
                </td>
                <td style="border: none; padding: 0; width: 55%; text-align: right; vertical-align: middle;">
                    <div style="font-size: 18px; font-weight: 700; color: #2e2e79; letter-spacing: 0.5px;">LIST OF CUSTOMER ASSETS</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                        <b>Generated Date:</b> <?PHP echo date("d-m-Y h:i A"); ?>
                    </div>
                    <?php if (!empty($filter_desc)) { ?>
                        <div style="font-size: 10.5px; color: #475569; margin-top: 2px;">
                            <b>Filter:</b> <?PHP echo implode(" | ", $filter_desc); ?>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Quick Stats Cards -->
    <table style="width: 100%; border: none; border-collapse: separate; border-spacing: 8px 0; margin-bottom: 18px;" class="page-break-inside-avoid">
        <tbody>
            <tr>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #2e2e79;"><?PHP echo $total_assets; ?></div>
                    <div class="stat-lbl">Total Assets</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #0f766e;"><?PHP echo $total_categories; ?></div>
                    <div class="stat-lbl">Categories</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #b45309;"><?PHP echo $total_buildings; ?></div>
                    <div class="stat-lbl">Buildings / Facilities</div>
                </td>
                <td class="stat-box" style="width: 25%;">
                    <div class="stat-num" style="color: #15803d;"><?PHP echo $total_customers; ?></div>
                    <div class="stat-lbl">Customers</div>
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
                    <th style="width: 155px; text-align: left;">Asset Code</th>
                    <th style="width: 50px; text-align: center;" class="col-qr">QR</th>
                    <th style="width: 140px; text-align: left;">Asset Name</th>
                    <th style="width: 105px; text-align: left;">Category</th>
                    <th style="width: 105px; text-align: left;">Type</th>
                    <th style="text-align: left;">Customer</th>
                    <th style="width: 110px; text-align: left;">Location</th>
                    <th style="width: 120px; text-align: left;">Building</th>
                </tr>
            </thead>
            <tbody>
                <?PHP 
                if ($total_assets > 0) {
                    $ctr = 1;
                    foreach ($assets_list as $row_t) {
                        $ref_no = trim($row_t['asset_ref_no'] ?? '');
                        $c_code = !empty($row_t['customer_code']) ? htmlspecialchars($row_t['customer_code']) : '';
                        $c_name = htmlspecialchars($row_t['customer_name'] ?? '');
                        $loc_code = !empty($row_t['location_code']) ? htmlspecialchars($row_t['location_code']) : '';
                        $loc_name = htmlspecialchars($row_t['asset_location'] ?? '-');
                        $bld_code = !empty($row_t['building_code']) ? htmlspecialchars($row_t['building_code']) : '';
                        $bld_name = htmlspecialchars($row_t['asset_building'] ?? '-');
                        $cat_name = htmlspecialchars($row_t['asset_category_name'] ?? '-');
                        $type_name = htmlspecialchars($row_t['asset_type_name'] ?? '-');
                        $asset_name = !empty($row_t['asset_sp_des']) ? htmlspecialchars($row_t['asset_sp_des']) : (!empty($row_t['asset_description']) ? htmlspecialchars($row_t['asset_description']) : '-');
                        $qr_file = __DIR__ . '/../httpdocs/qr_lib/asset_qr/download_asset/' . $ref_no . '.png';
                        $qr_url = "../httpdocs/qr_lib/asset_qr/download_asset/" . htmlspecialchars($ref_no) . ".png";
                        ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600; color: #64748b;"><?PHP echo $ctr; ?></td>
                            <td>
                                <span class="badge-ref"><?PHP echo htmlspecialchars($ref_no); ?></span>
                            </td>
                            <td style="text-align: center;" class="col-qr">
                                <?php if ($ref_no != '' && file_exists($qr_file)) { ?>
                                    <img src="<?php echo $qr_url; ?>" style="width: 36px; height: 36px; object-fit: contain; border: 1px solid #e2e8f0; border-radius: 3px; padding: 1px; background: #fff;" alt="QR" />
                                <?php } else { ?>
                                    <span style="color: #94a3b8; font-size: 10px;">-</span>
                                <?php } ?>
                            </td>
                            <td>
                                <strong><?PHP echo $asset_name; ?></strong>
                                <?php if (!empty($row_t['asset_brand'])) { ?>
                                    <div style="font-size: 10.5px; color: #64748b; margin-top: 2px;">Brand: <?PHP echo htmlspecialchars($row_t['asset_brand']); ?></div>
                                <?php } ?>
                            </td>
                            <td>
                                <span class="badge-cat"><?PHP echo $cat_name; ?></span>
                            </td>
                            <td>
                                <span class="badge-type"><?PHP echo $type_name; ?></span>
                            </td>
                            <td>
                                <strong><?PHP echo $c_name; ?></strong>
                                <?php if ($c_code) { ?>
                                    <br><span style="font-size: 10.5px; color: #64748b;">(<?PHP echo $c_code; ?>)</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?PHP echo $loc_name; ?>
                                <?php if ($loc_code) { ?>
                                    <br><span style="font-size: 10px; color: #64748b;">[<?PHP echo $loc_code; ?>]</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?PHP echo $bld_name; ?>
                                <?php if ($bld_code) { ?>
                                    <br><span style="font-size: 10px; color: #64748b;">[<?PHP echo $bld_code; ?>]</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?PHP 
                        $ctr++;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 28px; color: #64748b; font-style: italic;">
                            No asset records found in the system for the selected criteria.
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
    tab_text += "<tr><th colspan='8' style='background:#2e2e79;color:#ffffff;font-size:16px;padding:8px;'>LIST OF CUSTOMER ASSETS - " + <?php echo json_encode(date("d-m-Y")); ?> + "</th></tr>";
    
    var table = tab.getElementsByTagName('table')[0];
    if (table) {
        var rows = table.rows;
        for (var j = 0; j < rows.length; j++) {
            var rowClone = rows[j].cloneNode(true);
            var qrCell = rowClone.querySelector('.col-qr');
            if (qrCell) {
                qrCell.remove();
            }
            tab_text += "<tr>" + rowClone.innerHTML + "</tr>";
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
        txtArea1.contentWindow.document.execCommand("SaveAs", true, "List_Of_Customer_Assets.xls");
        document.body.removeChild(txtArea1);
    } else {
        var a = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel,' + encodeURIComponent(tab_text);
        a.href = data_type;
        a.download = "List_Of_Customer_Assets_" + <?php echo json_encode(date("d_m_Y")); ?> + ".xls";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
}

function filterTable() {
    var query = document.getElementById('report_search').value.toLowerCase();
    var table = document.getElementById('main_table').getElementsByTagName('tbody')[0];
    var rows = table.getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var text = rows[i].textContent.toLowerCase();
        if (text.indexOf(query) > -1) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

function toggleQRCodes() {
    var qrCols = document.querySelectorAll('.col-qr');
    var isHidden = false;
    qrCols.forEach(function(el) {
        if (el.style.display === 'none') {
            el.style.display = '';
        } else {
            el.style.display = 'none';
            isHidden = true;
        }
    });
    var btn = document.getElementById('btn_toggle_qr');
    if (btn) {
        btn.innerHTML = isHidden ? '<span>&#9638;</span> Show QR' : '<span>&#9638;</span> Hide QR';
    }
}
</script>

</body>
</html>