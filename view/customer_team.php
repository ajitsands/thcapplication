<?PHP
if (session_status() == PHP_SESSION_NONE) {
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
	    .leader-selected {
            background-color: #fef9c3 !important; /* Soft yellow for leader */
            font-weight: 600 !important;
        }
        
        .selected {
            background-color: #e0f2fe !important; /* Soft blue for team members */
        }

        #tbl_techs_schedule_ticket_multiple_wrapper,
        #list_team_wrapper {
            width: 100% !important;
        }

        #tbl_techs_schedule_ticket_multiple_wrapper .dataTables_length,
        #list_team_wrapper .dataTables_length {
            float: left !important;
            display: inline-flex !important;
            align-items: center !important;
            margin-bottom: 12px !important;
        }

        #tbl_techs_schedule_ticket_multiple_wrapper .dataTables_filter,
        #list_team_wrapper .dataTables_filter {
            float: right !important;
            display: inline-flex !important;
            align-items: center !important;
            text-align: right !important;
            margin-bottom: 12px !important;
        }

        #tbl_techs_schedule_ticket_multiple_wrapper .dataTables_filter label,
        #list_team_wrapper .dataTables_filter label {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            margin-bottom: 0 !important;
        }

        #tbl_techs_schedule_ticket_multiple_wrapper .dataTables_info,
        #list_team_wrapper .dataTables_info {
            float: left !important;
            padding-top: 10px !important;
        }

        #tbl_techs_schedule_ticket_multiple_wrapper .dataTables_paginate,
        #list_team_wrapper .dataTables_paginate {
            float: right !important;
            text-align: right !important;
            padding-top: 6px !important;
        }

        #tbl_techs_schedule_ticket_multiple_wrapper:after,
        #list_team_wrapper:after {
            content: "" !important;
            display: table !important;
            clear: both !important;
        }
    </style>
	
	<script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="global_assets/js/demo_pages/form_select2.js"></script>
	
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- Data Table -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>

    <script src="global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	<!--<script src="global_assets/js/demo_pages/datatables_api.js"></script>-->
	
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	
	<!-- sweet alert -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="global_assets/js/fileupload_ns.js"></script>

	<script src="global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script src="global_assets/js/plugins/notifications/jgrowl.min.js"></script>

	<script src="global_assets/js/demo_pages/picker_date.js"></script>
	
	<script src="../httpdocs/barcode/jquery-barcode.js"></script>
	
	<script src="../httpdocs/user_js/customer_team.js"></script>
	<script src="../httpdocs/user_js/building.js"></script>
	<script src="../httpdocs/user_js/location.js"></script>
	<script src="../httpdocs/user_js/login.js"></script>
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

			<!-- Content area -->
			<div class="content pt-0">

				<!-- Large navbar -->
				
				<?PHP 
					include_once('customer_team/customer_asset_details.php');
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