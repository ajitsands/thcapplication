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
$OBJ->URLEncode('head=dashboard');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?PHP 
		include_once('template/head.inc');
	?>

	 
	<style>
/* Complaint Description & Child row styling */
.complaint-list-items {
    margin: 4px 0 0 0;
    padding-left: 20px;
    list-style-type: disc;
    text-align: left;
}
.complaint-list-items li {
    margin-bottom: 4px;
    line-height: 1.45;
    color: #334155;
}
.complaint-list-items li:last-child {
    margin-bottom: 0;
}
.complaint-intro {
    font-weight: 600;
    margin-bottom: 5px;
    color: #0f172a;
}

tr.complaint-child-row {
    background-color: #f8fafc !important;
}
tr.complaint-child-row > td {
    padding: 6px 14px 10px 14px !important;
    border-top: none !important;
    background-color: #f8fafc !important;
}
tr.shown > td {
    border-bottom: none !important;
}
.complaint-child-container {
    padding: 0 4px;
}
.complaint-child-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #1e88e5;
    border-radius: 6px;
    padding: 9px 14px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.complaint-child-header {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
.complaint-child-badge {
    display: inline-flex;
    align-items: center;
    background-color: #e3f2fd;
    color: #1565c0;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 3px 8px;
    border-radius: 4px;
}
.complaint-child-body {
    color: #334155;
    font-size: 13px;
    line-height: 1.5;
}
td.details-control {
    cursor: pointer;
    user-select: none;
}
.toggle-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    cursor: pointer;
    vertical-align: middle;
    transition: transform 0.15s ease;
}
.toggle-icon:hover {
    transform: scale(1.15);
}
	</style>

	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- Data Table -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	<!--<script src="global_assets/js/demo_pages/datatables_api.js"></script>-->
	

	
	
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	<!-- sweet alert -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	 <script src="../httpdocs/spinner/spinner.js"></script>
   	 <script src="global_assets/js/fileupload_ns.js"></script>
	 <script src="../httpdocs/user_js/login.js"></script>
	 <script src="../httpdocs/user_js/wo_types.js?v=<?php echo time(); ?>"></script>
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
</head>
    <?PHP 
		include_once('template/date_time.inc');
	?>
<body class="navbar-top">

	


	


			<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

			<!-- Page header -->
			<?PHP 
				//include_once('template/header_bellow_title.inc');
			?>
			
			<!-- /page header -->


			<!-- Content area -->
			<div class="content pt-0">

				<!-- Large navbar -->
				
				<?PHP 
					include_once('work_order_types/emergency_work_order_body.php');
				?>
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
				include_once('template/reset_password_modal.php');
			?>

			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	

</body>
</html>
<?PHP }
	
	else{
		?>
		<script>

	window.location="login.php"
</script>
<?PHP
	}
	?>