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
                        <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Janitor Operations</span> - Execution Report</h4>
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

                <!-- Filter Area -->
                <div class="card">
                    <div class="card-header bg-white header-elements-inline">
                        <h6 class="card-title">Search Filter</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label>Customer:</label>
                                <select id="filter_customer" class="form-control select2" data-placeholder="All Customers">
                                    <option value="">All Customers</option>
                                    <?php while($row = mysqli_fetch_assoc($customers)) { ?>
                                        <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label>Asset:</label>
                                <select id="filter_asset" class="form-control select2" data-placeholder="All Assets">
                                    <option value="">All Assets</option>
                                    <?php while($row = mysqli_fetch_assoc($assets)) { ?>
                                        <option value="<?php echo $row['asset_id']; ?>"><?php echo $row['asset_ref_no'] . ' - ' . $row['asset_description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label>AMC:</label>
                                <select id="filter_amc" class="form-control select2" data-placeholder="All AMCs">
                                    <option value="">All AMCs</option>
                                    <?php while($row = mysqli_fetch_assoc($amcs)) { ?>
                                        <option value="<?php echo $row['amc_ref_no']; ?>"><?php echo $row['amc_ref_no']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label>Janitor:</label>
                                <select id="filter_janitor" class="form-control select2" data-placeholder="All Janitors">
                                    <option value="">All Janitors</option>
                                    <?php while($row = mysqli_fetch_assoc($janitors)) { ?>
                                        <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name'] . ($row['employee_code'] ? ' ('.$row['employee_code'].')' : ''); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label>From Date:</label>
                                <input type="date" id="filter_from_date" class="form-control" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                <label>To Date:</label>
                                <input type="date" id="filter_to_date" class="form-control" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-2 d-flex align-items-end">
                                <button type="button" id="btn_search" class="btn bg-info"><i class="icon-search4 mr-2"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Execution Report Table -->
                <div class="card">
                    <div class="card-header bg-white header-elements-inline">
                        <h6 class="card-title">Janitor Execution Logs</h6>
                    </div>

                    <table class="table datatable-execution-report" id="tblExecutionReport">
                        <thead>
                            <tr>
                                <th>WO Number</th>
                                <th>Date</th>
                                <th>Slot</th>
                                <th>Janitor</th>
                                <th>Asset Code</th>
                                <th>Checklist</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /Execution Report Table -->

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
                    <h5 class="modal-title font-weight-semibold">Submitted Checklist Details</h5>
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

</body>
</html>
<?php } else { header('Location: index.php'); } ?>