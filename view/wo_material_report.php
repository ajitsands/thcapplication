<?PHP
if (session_status() == PHP_SESSION_NONE) {
    $savePath = session_save_path();
    if (empty($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}

if($_SESSION["loggedin"] ==true)
{
    include('template/includes/en_de_header.inc');
    $OBJ = new URLEncription();
    $OBJ->URLEncode('head=requisition');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?PHP 
        include_once('template/head.inc');
        include_once('template/date_time.inc');
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css">
    
    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    
    <!-- Export libraries -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    
    <script src="../httpdocs/user_js/wo_material_report.js"></script>
    <script src="../httpdocs/user_js/login.js"></script>
    <link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
</head>
<body class="navbar-top">

    <!-- ===== THC Horizontal Top Navigation ===== -->
    <?PHP include_once('template/top_menu_new.inc'); ?>
    <!-- ===== /THC Horizontal Top Navigation ===== -->

    <!-- Main content -->
    <div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

        <!-- Content area -->
        <div class="content pt-0">

            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">WO Material Report</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Customer Combo -->
                        <?PHP include("tickets/customer_combo.php"); ?>
                        
                        <div class="col-lg-3 col-md-4 col-sm-4">
                            <select data-placeholder="Select Work Order" id="select_workorder" class="form-control form-control-select2" data-fouc>
                                <option value="All">All</option>
                            </select>
                            <span class="form-text text-muted">Work Order Number</span> 
                        </div>
                        
                        <div class="col-lg-3 col-md-4 col-sm-4">
                            <select data-placeholder="Select Material" id="select_material" class="form-control form-control-select2" data-fouc>
                                <option value="All">All</option>
                            </select>
                            <span class="form-text text-muted">Material List</span> 
                        </div>
                        
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <button type="button" id="btn_search_report" class="btn bg-info">Search</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Consolidated Report</h5>
                </div>
                <div class="card-body">
                    <table class="table datatable-basic" id="table_wo_material_report">
                        <thead>
                            <tr>
                                <th style="width: 40px"></th>
                                <th>S.No</th>
                                <th>Customer Name</th>
                                <th>Work Order Ref</th>
                                <th>Request ID</th>
                                <th>Material Code</th>
                                <th>Material Name</th>
                                <th>Requested Qty</th>
                                <th>Delivered Qty</th>
                                <th>Request Date</th>
                                <th>Request Status</th>
                                <th>Delivery Logs</th>
                                <th>Description / Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- /content area -->

        <?PHP include_once('template/reset_password_modal.php'); ?>

        <!-- Footer -->
        <?PHP include_once('template/footer.inc'); ?>
        <!-- /footer -->

    </div>
    <!-- /main content -->
</body>
</html>
<?PHP 
} else {
?>
<script>
    window.location="login.php"
</script>
<?PHP
}
?>
