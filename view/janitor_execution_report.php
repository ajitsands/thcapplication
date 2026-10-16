<?php
if (session_status() == PHP_SESSION_NONE) {
    $savePath = session_save_path();
    if (empty($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
{
include('template/includes/en_de_header.inc');
$OBJ = new URLEncription();
$params = isset($_GET['param']) ? $OBJ->URLDecode($_GET['param']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>THC - Janitor Execution & Location Tracking Report</title>
    <?php include_once('template/head.inc'); ?>
    <?php include_once('template/date_time.inc'); ?>
    <link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
    
    <!-- Data Table & Select2 -->
    <script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
    <script src="global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
    <script src="global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
    
    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    
    <!-- Ladda & SweetAlert -->
    <script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
    <script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
    <script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <style>
        .map-legend-badge {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 4px;
        }
        .map-dot-red {
            width: 12px;
            height: 12px;
            background-color: #e53935;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 3px rgba(0,0,0,0.3);
        }
        .map-dot-blue {
            width: 12px;
            height: 12px;
            background-color: #1e88e5;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 3px rgba(0,0,0,0.3);
        }
        .leaflet-popup-content {
            font-family: inherit;
            font-size: 13px;
            line-height: 1.5;
        }
        .history-timeline-item {
            border-left: 3px solid #ddd;
            padding-left: 12px;
            margin-bottom: 12px;
            transition: all 0.2s;
        }
        .history-timeline-item:hover {
            border-left-color: #2196f3;
            background-color: #f8f9fa;
        }
    </style>

    <!-- Custom JS -->
    <script src="../httpdocs/user_js/janitor_execution_report.js"></script>
</head>
<body class="navbar-top">

    <!-- ===== THC Horizontal Top Navigation ===== -->
    <?php include_once('template/top_menu_new.inc'); ?>
    <!-- ===== /THC Horizontal Top Navigation ===== -->

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-light">
                <div class="page-header-content header-elements-md-inline">
                    <div class="page-title d-flex">
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Janitor Operations</span> - Execution &amp; Location Tracking Report</h4>
                    </div>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">

                <?php 
                require_once(__DIR__ . '/../model/db_connection/connection.php');
                $DBConn = new DBConnection();
                $varDBConnection = $DBConn->ConnectToMYSQL();

                $customers = mysqli_query($varDBConnection, "SELECT customer_id, customer_name FROM tbl_customers WHERE customer_status != 'Deleted' ORDER BY customer_name ASC");
                $amcs = mysqli_query($varDBConnection, "SELECT amc_ref_no FROM tbl_amc_master WHERE amc_status != 'Deleted' ORDER BY amc_ref_no ASC");
                $assets = mysqli_query($varDBConnection, "SELECT asset_id, asset_ref_no, asset_description FROM tbl_assets WHERE asset_status != 'Deleted' ORDER BY asset_ref_no ASC");
                $janitors = mysqli_query($varDBConnection, "SELECT employee_id, employee_name, employee_code FROM tbl_employees WHERE employee_status != 'Deleted' ORDER BY employee_name ASC");
                ?>

                <!-- Nav Tabs for Reports -->
                <div class="card">
                    <div class="card-header bg-white header-elements-inline pb-0 border-bottom-0">
                        <ul class="nav nav-tabs nav-tabs-bottom mb-0">
                            <li class="nav-item">
                                <a href="#tab_scan_tracking" class="nav-link active font-weight-semibold" data-toggle="tab">
                                    <i class="icon-qrcode mr-2 text-success"></i>QR Scan &amp; Location Tracking Report
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab_monthly_map_history" class="nav-link font-weight-semibold" data-toggle="tab" id="nav_tab_monthly_history">
                                    <i class="icon-map5 mr-2 text-warning"></i>Monthly Janitor Pin History Map
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tab_executions" class="nav-link font-weight-semibold" data-toggle="tab">
                                    <i class="icon-file-check mr-2 text-primary"></i>Checklist Execution Logs
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content card-body p-0">
                        
                        <!-- TAB 1: QR Scan & Location Tracking -->
                        <div class="tab-pane fade show active p-3" id="tab_scan_tracking">
                            <!-- Filter Area -->
                            <div class="card card-body bg-light border-0 mb-3">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                        <label class="font-weight-semibold">Customer:</label>
                                        <select id="filter_customer" class="form-control select2" data-placeholder="All Customers">
                                            <option value="">All Customers</option>
                                            <?php 
                                            mysqli_data_seek($customers, 0);
                                            while($row = mysqli_fetch_assoc($customers)) { ?>
                                                <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                        <label class="font-weight-semibold">Asset:</label>
                                        <select id="filter_asset" class="form-control select2" data-placeholder="All Assets">
                                            <option value="">All Assets</option>
                                            <?php 
                                            mysqli_data_seek($assets, 0);
                                            while($row = mysqli_fetch_assoc($assets)) { ?>
                                                <option value="<?php echo $row['asset_id']; ?>"><?php echo $row['asset_ref_no'] . ' - ' . $row['asset_description']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <label class="font-weight-semibold">Janitor:</label>
                                        <select id="filter_janitor" class="form-control select2" data-placeholder="All Janitors">
                                            <option value="">All Janitors</option>
                                            <?php 
                                            mysqli_data_seek($janitors, 0);
                                            while($row = mysqli_fetch_assoc($janitors)) { ?>
                                                <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name'] . ($row['employee_code'] ? ' ('.$row['employee_code'].')' : ''); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <label class="font-weight-semibold">Scan Status:</label>
                                        <select id="filter_scan_status" class="form-control select2" data-placeholder="All Scan Status">
                                            <option value="">All Scan Status</option>
                                            <option value="Verified">Verified (Within Radius)</option>
                                            <option value="Mismatch">Mismatch (Outside Radius)</option>
                                            <option value="Bypassed">Bypassed (Test Mode)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <label class="font-weight-semibold">From Date:</label>
                                        <input type="date" id="filter_from_date" class="form-control" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 mb-2">
                                        <label class="font-weight-semibold">To Date:</label>
                                        <input type="date" id="filter_to_date" class="form-control" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 mb-2 d-flex align-items-end">
                                        <button type="button" id="btn_search" class="btn btn-primary mr-2"><i class="icon-search4 mr-1"></i> Filter Scans</button>
                                        <button type="button" id="btn_reset_filters" class="btn btn-light"><i class="icon-reset mr-1"></i> Reset</button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="text-muted font-size-sm">
                                    <i class="icon-info22 mr-1 text-info"></i>
                                    Click <strong>Compare</strong> on any row to open the visual map showing 🔴 <strong>Asset Pin (Red)</strong> vs 🔵 <strong>Janitor Scan Pin (Blue)</strong>.
                                </div>
                                <div>
                                    <span class="map-legend-badge bg-light mr-2"><span class="map-dot-red"></span> Red: Asset Pin</span>
                                    <span class="map-legend-badge bg-light"><span class="map-dot-blue"></span> Blue: Scanned Pin</span>
                                </div>
                            </div>

                            <table class="table table-hover datatable-scan-tracking" id="tblScanTracking" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Scan Date &amp; Time</th>
                                        <th>Janitor</th>
                                        <th>Asset Code &amp; Details</th>
                                        <th>Building</th>
                                        <th>Asset Location</th>
                                        <th>Scanned Location</th>
                                        <th>Distance</th>
                                        <th>Scan Status</th>
                                        <th class="text-center">Map Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <!-- TAB 2: Monthly Janitor Pin History Map -->
                        <div class="tab-pane fade p-3" id="tab_monthly_map_history">
                            <div class="card card-body bg-light border-0 mb-3">
                                <div class="row align-items-end">
                                    <div class="col-lg-4 col-md-6 mb-2">
                                        <label class="font-weight-semibold"><i class="icon-user mr-1 text-primary"></i>Select Janitor: <span class="text-danger">*</span></label>
                                        <select id="history_janitor" class="form-control select2" data-placeholder="Select Janitor to Inspect...">
                                            <option value="">-- Choose Janitor --</option>
                                            <?php 
                                            mysqli_data_seek($janitors, 0);
                                            while($row = mysqli_fetch_assoc($janitors)) { ?>
                                                <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name'] . ($row['employee_code'] ? ' ('.$row['employee_code'].')' : ''); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-2">
                                        <label class="font-weight-semibold"><i class="icon-calendar mr-1 text-warning"></i>Select Month: <span class="text-danger">*</span></label>
                                        <input type="month" id="history_month" class="form-control" value="<?php echo date('Y-m'); ?>">
                                    </div>
                                    <div class="col-lg-3 col-md-4 mb-2">
                                        <button type="button" id="btn_load_month_history" class="btn btn-primary btn-block">
                                            <i class="icon-map5 mr-1"></i> Load Month Pin History
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Metrics Counters -->
                            <div class="row mb-3" id="history_metrics_row" style="display: none;">
                                <div class="col-lg-3 col-6 mb-2">
                                    <div class="card card-body bg-light border-left-3 border-left-primary mb-0 p-2">
                                        <div class="text-uppercase font-size-xs text-muted">Total Scans</div>
                                        <h4 class="font-weight-bold mb-0 text-primary" id="metric_total_scans">0</h4>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6 mb-2">
                                    <div class="card card-body bg-light border-left-3 border-left-success mb-0 p-2">
                                        <div class="text-uppercase font-size-xs text-muted">Verified Scans</div>
                                        <h4 class="font-weight-bold mb-0 text-success" id="metric_verified_scans">0</h4>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6 mb-2">
                                    <div class="card card-body bg-light border-left-3 border-left-danger mb-0 p-2">
                                        <div class="text-uppercase font-size-xs text-muted">Location Mismatches</div>
                                        <h4 class="font-weight-bold mb-0 text-danger" id="metric_mismatch_scans">0</h4>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6 mb-2">
                                    <div class="card card-body bg-light border-left-3 border-left-info mb-0 p-2">
                                        <div class="text-uppercase font-size-xs text-muted">Average Distance</div>
                                        <h4 class="font-weight-bold mb-0 text-info" id="metric_avg_distance">0 m</h4>
                                    </div>
                                </div>
                            </div>

                            <!-- Map and Scan List Split Container -->
                            <div class="row">
                                <div class="col-lg-8 mb-3">
                                    <div class="card mb-0 shadow-sm">
                                        <div class="card-header bg-white header-elements-inline py-2">
                                            <h6 class="card-title font-weight-bold mb-0">
                                                <i class="icon-compass mr-1 text-primary"></i>Interactive Scan History Map
                                            </h6>
                                            <div class="header-elements">
                                                <!-- Map Language Toggle -->
                                                <div class="btn-group btn-group-sm mr-2" id="monthly_map_lang_group">
                                                    <button type="button" class="btn btn-primary active btn-map-lang" data-lang="en" title="English Map Labels"><i class="icon-sphere mr-1"></i> English</button>
                                                    <button type="button" class="btn btn-light btn-map-lang" data-lang="ar" title="Arabic Map Labels (عربي)"><i class="icon-sphere mr-1"></i> عربي</button>
                                                </div>
                                                <div class="btn-group btn-group-sm mr-2" id="monthly_pin_filter_group">
                                                    <button type="button" class="btn btn-primary active btn-filter-pins" data-filter="all"><i class="icon-eye mr-1"></i>All Pins</button>
                                                    <button type="button" class="btn btn-light btn-filter-pins" data-filter="verified"><span class="map-dot-blue"></span>Verified</button>
                                                    <button type="button" class="btn btn-light btn-filter-pins" data-filter="mismatch"><span class="map-dot-red"></span>Mismatches</button>
                                                </div>
                                                <span class="map-legend-badge bg-light mr-2"><span class="map-dot-red"></span> Red: Asset</span>
                                                <span class="map-legend-badge bg-light"><span class="map-dot-blue"></span> Blue: Scanned</span>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div id="monthly_history_map" style="height: 520px; width: 100%; border-radius: 0 0 4px 4px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <div class="card mb-0 shadow-sm" style="height: 575px;">
                                        <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                            <h6 class="card-title font-weight-bold mb-0">
                                                <i class="icon-list2 mr-1 text-dark"></i>Scans in Month
                                            </h6>
                                            <span class="badge badge-primary" id="timeline_count_badge">0 Scans</span>
                                        </div>
                                        <div class="card-body p-3" id="monthly_scans_timeline" style="overflow-y: auto; height: 520px;">
                                            <div class="text-center text-muted p-4">
                                                <i class="icon-pin-alt icon-2x text-muted mb-2"></i>
                                                <p>Please select a Janitor and click <strong>Load Month Pin History</strong> to visualize scan pins on the map.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: Execution Logs -->
                        <div class="tab-pane fade p-3" id="tab_executions">
                            <table class="table table-hover datatable-execution-report" id="tblExecutionReport" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>WO Number</th>
                                        <th>Date</th>
                                        <th>Slot</th>
                                        <th>Janitor</th>
                                        <th>Asset Code</th>
                                        <th>Checklist</th>
                                        <th>GPS Verification</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- Modal for Viewing Checklist Details -->
    <div id="modal_view_execution" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-semibold"><i class="icon-clipboard3 mr-2"></i>Submitted Checklist Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" id="div_execution_details_body">
                    <div class="text-center p-3"><i class="icon-spinner2 spinner"></i> Loading...</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Map Location Comparison with Dual Colored Pins -->
    <div id="modal_map_compare" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light py-2">
                    <h5 class="modal-title font-weight-semibold"><i class="icon-location4 mr-2 text-danger"></i>QR Scan Location Comparison</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <div class="modal-body p-3" id="modal_map_compare_body">
                    <!-- Populated dynamically via JS -->
                </div>
                
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php } else { header('Location: index.php'); } ?>