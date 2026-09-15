<?php
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
	<?php include_once('template/head.inc'); ?>
    <?php include_once('template/date_time.inc'); ?>
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
	
	<!-- Data Table & Select2 -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	
	<!-- DataTables Export Buttons -->
	<script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
	
	<!-- Ladda & SweetAlert -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<!-- Custom JS -->
	<script src="../httpdocs/user_js/spare_parts_master.js"></script>
</head>
<body class="navbar-top">

	<!-- ===== THC Horizontal Top Navigation ===== -->
	<?php include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

		<!-- Content area -->
		<div class="content pt-0">
			<?php include_once('spare_parts/spare_parts_master_details.php'); ?>
		</div>
		<!-- /content area -->

		<?php include_once('template/reset_password_modal.php'); ?>

		<!-- Footer -->
		<?php include_once('template/footer.inc'); ?>
		<!-- /footer -->

	</div>
	<!-- /main content -->

</body>
</html>
<?php 
}
else {
?>
<script>
window.location="login.php"
</script>
<?php
}
?>
