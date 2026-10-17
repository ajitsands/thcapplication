<?php
if (session_status() == PHP_SESSION_NONE) {
    $savePath = session_save_path();
    if (empty($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
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
    <title>THC - Janitor Job Schedule &amp; Slot Status Calendar</title>
    
    <?php include_once('template/head.inc'); ?>
    <?php include_once('template/date_time.inc'); ?>
    <link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">

    <!-- FullCalendar v4 Stylesheets -->
    <link href="global_assets/js/plugins/ui/fullcalendar/core/main.min.css" rel="stylesheet" type="text/css">
    <link href="global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.css" rel="stylesheet" type="text/css">
    <link href="global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.css" rel="stylesheet" type="text/css">
    <link href="global_assets/js/plugins/ui/fullcalendar/list/main.min.css" rel="stylesheet" type="text/css">

    <!-- FullCalendar v4 Core & Plugins -->
    <script src="global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
    <script src="global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
    <script src="global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
    <script src="global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
    <script src="global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>

    <!-- SweetAlert -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Custom View Styles -->
    <style>
        .janitor-hero-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .kpi-card-metric {
            background: #ffffff;
            border-radius: 10px;
            padding: 16px 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.25s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        .kpi-card-metric:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .kpi-card-metric::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }
        .kpi-total::before { background: #4f46e5; }
        .kpi-completed::before { background: #10b981; }
        .kpi-late::before { background: #f59e0b; }
        .kpi-missed::before { background: #ef4444; }
        .kpi-upcoming::before { background: #0284c7; }
        .kpi-rate::before { background: #8b5cf6; }

        .kpi-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .kpi-number {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }
        .kpi-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Calendar Aesthetics */
        .calendar-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .fc-header-toolbar {
            margin-bottom: 20px !important;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }
        .fc-toolbar-title {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #1e293b;
        }
        .fc-button-primary {
            background-color: #3b82f6 !important;
            border-color: #2563eb !important;
            font-weight: 500 !important;
            text-transform: capitalize !important;
            padding: 6px 14px !important;
            border-radius: 6px !important;
        }
        .fc-button-primary:hover, .fc-button-primary:focus {
            background-color: #2563eb !important;
        }
        .fc-button-active {
            background-color: #1d4ed8 !important;
            border-color: #1e40af !important;
        }
        .fc-dayGridMonth-view .fc-event {
            border-radius: 4px;
            padding: 3px 6px;
            margin-bottom: 3px;
            cursor: pointer;
            transition: transform 0.15s ease;
        }
        .fc-dayGridMonth-view .fc-event:hover {
            transform: scale(1.02);
            filter: brightness(1.05);
        }
        .fc-day-today {
            background: rgba(59, 130, 246, 0.05) !important;
        }
        .fc-day-number {
            font-weight: 600;
            color: #475569;
            padding: 4px 8px !important;
        }

        /* Legend Badges */
        .legend-pill {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 6px;
        }
        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
        }

        /* Modal Styles */
        .modal-header-custom {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: #ffffff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .modal-header-custom .close {
            color: #ffffff;
            opacity: 0.8;
        }
        .detail-label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            color: #64748b;
        }
        .detail-value {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }
    </style>

    <!-- Calendar Frontend Script -->
    <script src="../httpdocs/user_js/janitor_schedule_calendar.js"></script>
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
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Janitor Operations</span> - Job Schedule &amp; Slot Status Calendar</h4>
                    </div>
                    <div class="header-elements d-none py-0 mb-3 mb-md-0">
                        <button type="button" class="btn btn-outline-primary btn-sm font-weight-semibold" id="btn_refresh_calendar">
                            <i class="icon-sync mr-1"></i> Refresh Calendar
                        </button>
                    </div>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">

                <!-- TOP CONTROL BAR: JANITOR SELECTOR & PROFILE SUMMARY -->
                <div class="card janitor-hero-card p-3 mb-3">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                            <label class="text-white-50 text-uppercase font-weight-semibold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">
                                <i class="icon-user-check mr-1 text-primary"></i> Select Janitor to View Schedule
                            </label>
                            <select class="form-control select2" id="select_janitor">
                                <option value="">Loading Janitors list...</option>
                            </select>
                        </div>
                        <div class="col-lg-7 col-md-6">
                            <div class="d-flex align-items-center justify-content-md-end flex-wrap">
                                <div class="d-flex align-items-center mr-4 py-1">
                                    <div class="bg-primary-400 rounded-circle d-flex align-items-center justify-content-center text-white mr-2" style="width: 38px; height: 38px; font-size: 18px;">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-white" id="badge_janitor_name">--</div>
                                        <div class="text-white-50 small" id="badge_janitor_code">Code: --</div>
                                    </div>
                                </div>
                                <div class="mr-4 py-1">
                                    <div class="text-white-50 small">Contact No</div>
                                    <div class="font-weight-semibold text-white" id="badge_janitor_phone">--</div>
                                </div>
                                <div class="py-1">
                                    <div class="text-white-50 small">Active Job Assignments</div>
                                    <span class="badge badge-success px-2 py-1 font-weight-bold" id="badge_active_jobs_count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KPI METRICS SUMMARY BAR -->
                <div class="row mb-3">
                    <!-- Total Slots -->
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card-metric kpi-total">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-title">Total Slots</div>
                                    <div class="kpi-number" id="kpi_total_slots">0</div>
                                </div>
                                <div class="kpi-icon-wrap bg-indigo-50 text-indigo">
                                    <i class="icon-calendar52 text-indigo"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed (On-Time) -->
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card-metric kpi-completed">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-title">Completed (On-Time)</div>
                                    <div class="kpi-number text-success" id="kpi_completed_ontime">0</div>
                                </div>
                                <div class="kpi-icon-wrap bg-success-50 text-success">
                                    <i class="icon-checkmark3 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed (Late) -->
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card-metric kpi-late">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-title">Completed (Late)</div>
                                    <div class="kpi-number text-warning-800" id="kpi_completed_late">0</div>
                                </div>
                                <div class="kpi-icon-wrap bg-warning-50 text-warning-800">
                                    <i class="icon-alarm-check text-warning-800"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Missed / Expired -->
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card-metric kpi-missed">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-title">Missed / Expired</div>
                                    <div class="kpi-number text-danger" id="kpi_missed">0</div>
                                </div>
                                <div class="kpi-icon-wrap bg-danger-50 text-danger">
                                    <i class="icon-cross2 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming / Active -->
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card-metric kpi-upcoming">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="kpi-title">Upcoming / Open</div>
                                    <div class="kpi-number text-info" id="kpi_upcoming_active">0</div>
                                </div>
                                <div class="kpi-icon-wrap bg-info-50 text-info">
                                    <i class="icon-clock2 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- On-Time Compliance Rate -->
                    <div class="col-xl-2 col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card-metric kpi-rate">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <div class="kpi-title">On-Time Rate</div>
                                    <div class="kpi-number text-purple" id="kpi_ontime_rate">0%</div>
                                </div>
                                <div class="kpi-icon-wrap bg-purple-50 text-purple">
                                    <i class="icon-stats-growth text-purple"></i>
                                </div>
                            </div>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-purple" id="kpi_ontime_progress" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CALENDAR CARD -->
                <div class="calendar-card position-relative mb-4">

                    <!-- Loading overlay -->
                    <div id="calendar_loader" style="display: none; position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(255,255,255,0.7); z-index: 100; border-radius: 12px;" class="d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <i class="icon-spinner2 spinner text-primary icon-2x mb-2"></i>
                            <div class="font-weight-semibold text-muted">Updating Janitor Schedule...</div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap pb-2 mb-3 border-bottom">
                        <div class="font-weight-bold text-dark mb-2 mb-md-0">
                            <i class="icon-calendar mr-1 text-primary"></i> Monthly Job Schedule &amp; Execution Calendar
                        </div>
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="legend-pill bg-light border text-success">
                                <span class="legend-dot" style="background-color: #10b981;"></span> Completed (On-Time)
                            </span>
                            <span class="legend-pill bg-light border text-warning-800">
                                <span class="legend-dot" style="background-color: #f59e0b;"></span> Completed (Late)
                            </span>
                            <span class="legend-pill bg-light border text-danger">
                                <span class="legend-dot" style="background-color: #ef4444;"></span> Missed / Expired
                            </span>
                            <span class="legend-pill bg-light border text-primary">
                                <span class="legend-dot" style="background-color: #2563eb;"></span> Active Window (Today)
                            </span>
                            <span class="legend-pill bg-light border text-muted">
                                <span class="legend-dot" style="background-color: #64748b;"></span> Upcoming / Scheduled
                            </span>
                        </div>
                    </div>

                    <!-- FullCalendar Mount Point -->
                    <div id="janitor_calendar"></div>
                </div>

            </div>
            <!-- /content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- ============================================================== -->
    <!-- MODAL: SLOT DETAILS & CHECKLIST BREAKDOWN -->
    <!-- ============================================================== -->
    <div id="modal_slot_details" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">

                <!-- Header -->
                <div class="modal-header modal-header-custom py-2 px-3 align-items-center">
                    <h6 class="modal-title font-weight-bold mb-0">
                        <i class="icon-calendar52 mr-2"></i>
                        <span id="modal_slot_name">Slot Details</span> • <span id="modal_slot_date" class="text-white-50"></span>
                    </h6>
                    <div class="ml-auto d-flex align-items-center">
                        <div id="modal_status_badge" class="mr-3"></div>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body p-3">

                    <!-- Section 1: Job & Asset Specifications -->
                    <div class="card card-body bg-light p-3 mb-3 border">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="detail-label">Assignment Ref</div>
                                <div class="detail-value text-primary" id="detail_assignment_ref">--</div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="detail-label">Customer</div>
                                <div class="detail-value" id="detail_customer_name">--</div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="detail-label">Building / Location</div>
                                <div class="detail-value" id="detail_building_name">--</div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="detail-label">Scheduled Window</div>
                                <div class="detail-value text-dark" id="detail_slot_window">--</div>
                            </div>
                            <div class="col-md-6 col-12 mb-2 mb-md-0">
                                <div class="detail-label">Asset (QR Target)</div>
                                <div class="detail-value font-weight-bold">
                                    <span id="detail_asset_ref">--</span>
                                    <span class="text-muted small ml-1" id="detail_asset_desc"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="detail-label">Checklist Applied</div>
                                <div class="detail-value text-success font-weight-bold" id="detail_checklist_name">--</div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Execution & Geolocation Verification -->
                    <div class="mb-3" id="slot_execution_info_container">
                        <!-- Populated dynamically via JS -->
                    </div>

                    <!-- Section 3: Task Checklist Breakdown & Photos -->
                    <div class="mt-2">
                        <h6 class="font-weight-bold text-dark mb-2">
                            <i class="icon-clipboard3 mr-1 text-primary"></i> Checklist Tasks &amp; Proof Photos
                        </h6>
                        <div id="slot_checklist_container">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light py-2 px-3 border-top">
                    <button type="button" class="btn btn-secondary btn-sm font-weight-semibold" data-dismiss="modal">
                        <i class="icon-cross2 mr-1"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
<?php
} else {
    header("location:login.php");
}
?>
