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
    <title>THC - Janitor Settings</title>
    <?php include_once('template/head.inc'); ?>
    <?php include_once('template/date_time.inc'); ?>
    <link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
    
    <!-- Ladda & SweetAlert -->
    <script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
    <script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
    <script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Custom JS -->
    <script src="../httpdocs/user_js/janitor_settings.js"></script>
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
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Janitor Operations</span> - Janitor Settings</h4>
                    </div>
                    <div class="header-elements d-none">
                        <div class="d-flex justify-content-center">
                            <span class="badge badge-primary font-size-sm px-3 py-2"><i class="icon-gear mr-1"></i> Global Geo & Attendance Rules</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">

                <!-- Alert container -->
                <div id="alert_placeholder"></div>

                <div class="row">
                    <!-- Main Settings Card -->
                    <div class="col-lg-8">
                        <div class="card border-top-primary">
                            <div class="card-header bg-white header-elements-inline">
                                <h6 class="card-title font-weight-bold"><i class="icon-sliders mr-2 text-primary"></i>Operational Thresholds & Rules</h6>
                                <div class="header-elements">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="btn_toggle_edit">
                                        <i class="icon-pencil5 mr-1"></i> Edit Settings
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                
                                <!-- VIEW MODE -->
                                <div id="view_mode_container">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="card card-body bg-light border-left-3 border-left-primary mb-0">
                                                <div class="d-flex align-items-center">
                                                    <i class="icon-location4 icon-2x text-primary mr-3"></i>
                                                    <div>
                                                        <h6 class="font-weight-semibold mb-0" id="lbl_view_radius">Loading...</h6>
                                                        <span class="text-muted font-size-sm">Minimum Scan Radius</span>
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-2">Maximum allowable distance between Janitor's GPS and the asset location to verify attendance.</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="card card-body bg-light border-left-3 border-left-warning mb-0">
                                                <div class="d-flex align-items-center">
                                                    <i class="icon-alarm icon-2x text-warning mr-3"></i>
                                                    <div>
                                                        <h6 class="font-weight-semibold mb-0" id="lbl_view_late_time">Loading...</h6>
                                                        <span class="text-muted font-size-sm">Late Time Threshold</span>
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-2">Grace minutes allowed after scheduled slot start before marking the task/attendance as Late.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-3">
                                            <div class="card card-body bg-light border-left-3 border-left-info mb-0">
                                                <div class="d-flex align-items-center">
                                                    <i class="icon-shield-check icon-2x text-info mr-3"></i>
                                                    <div>
                                                        <h6 class="font-weight-semibold mb-0" id="lbl_view_bypass">Loading...</h6>
                                                        <span class="text-muted font-size-sm">GPS Bypass Option</span>
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-2">Allows supervisors/testers to bypass geo-verification if physical GPS is shielded indoors.</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="card card-body bg-light border-left-3 border-left-secondary mb-0">
                                                <div class="d-flex align-items-center">
                                                    <i class="icon-history icon-2x text-secondary mr-3"></i>
                                                    <div>
                                                        <h6 class="font-weight-semibold mb-0" id="lbl_view_updated">Loading...</h6>
                                                        <span class="text-muted font-size-sm">Last Updated</span>
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-2">Updated by: <span id="lbl_view_updated_by" class="font-weight-semibold">-</span></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /VIEW MODE -->

                                <!-- EDIT MODE -->
                                <div id="edit_mode_container" style="display: none;">
                                    <form id="form_janitor_settings">
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-4 font-weight-semibold">Minimum Scan Radius: <span class="text-danger">*</span></label>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text"><i class="icon-location4"></i></span>
                                                    </span>
                                                    <input type="number" step="1" min="1" max="10000" class="form-control" name="min_radius_meters" id="input_min_radius_meters" required placeholder="e.g. 200">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text font-weight-semibold">Meters (m)</span>
                                                    </span>
                                                </div>
                                                <span class="form-text text-muted">Defines the permissible geo-fencing proximity (e.g. 50m, 200m). When Janitor scans an asset QR, the phone's GPS must be within this distance.</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-4 font-weight-semibold">Late Time Threshold: <span class="text-danger">*</span></label>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text"><i class="icon-alarm"></i></span>
                                                    </span>
                                                    <input type="number" step="1" min="0" max="720" class="form-control" name="late_time_minutes" id="input_late_time_minutes" required placeholder="e.g. 15">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text font-weight-semibold">Minutes</span>
                                                    </span>
                                                </div>
                                                <span class="form-text text-muted">Grace period in minutes. If a cleaning slot is scheduled from 08:00 AM, scanning after 08:15 AM (with 15 min setting) will be flagged as Late.</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-4 font-weight-semibold">Allow GPS Test Bypass: <span class="text-danger">*</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="allow_gps_bypass" id="input_allow_gps_bypass">
                                                    <option value="NO">NO - Strictly Enforce Proximity</option>
                                                    <option value="YES">YES - Allow Testing Bypass</option>
                                                </select>
                                                <span class="form-text text-muted">When set to YES, mobile app allows users to proceed in Test Mode if indoor GPS signal is obstructed.</span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="button" class="btn btn-light mr-2" id="btn_cancel_edit">
                                                <i class="icon-cross2 mr-1"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="btn_save_settings">
                                                <i class="icon-checkmark4 mr-1"></i> Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /EDIT MODE -->

                            </div>
                        </div>
                    </div>

                    <!-- Side Helper & Instructions Card -->
                    <div class="col-lg-4">
                        <div class="card border-top-info">
                            <div class="card-header bg-white header-elements-inline">
                                <h6 class="card-title font-weight-bold"><i class="icon-info22 mr-2 text-info"></i>How It Works</h6>
                            </div>
                            <div class="card-body">
                                <div class="list-feed">
                                    <div class="list-feed-item border-primary">
                                        <span class="font-weight-semibold">1. Asset QR Scanning</span>
                                        <div class="text-muted font-size-sm">When a Janitor scans the QR code on an asset, the Mobile App sends the device's real-time GPS coordinates (Latitude &amp; Longitude).</div>
                                    </div>
                                    <div class="list-feed-item border-warning">
                                        <span class="font-weight-semibold">2. Distance Verification</span>
                                        <div class="text-muted font-size-sm">The system computes the Haversine distance between the Janitor and the Asset/Building location. If distance &le; <span class="badge badge-light">Minimum Radius</span>, attendance is marked as <strong>Verified</strong>.</div>
                                    </div>
                                    <div class="list-feed-item border-danger">
                                        <span class="font-weight-semibold">3. Geo-Fence Violation</span>
                                        <div class="text-muted font-size-sm">If distance exceeds the radius, the scan is rejected and recorded with <strong>Location Mismatch</strong> in the Execution &amp; Scan Tracking Reports.</div>
                                    </div>
                                    <div class="list-feed-item border-success">
                                        <span class="font-weight-semibold">4. Audit &amp; Reporting</span>
                                        <div class="text-muted font-size-sm">All scan coordinates are permanently stored and visible in the <a href="janitor_execution_report.php?param=<?= $OBJ->URLEncode('head=janitor&open=3&title=janitor_execution_report') ?>">Janitor Execution Report</a> with interactive Google Map links.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>
</html>
<?php } else { header('Location: index.php'); } ?>
