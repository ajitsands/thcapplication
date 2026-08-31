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
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">

	<style>
	    td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
        }
        .card,
        .card-body,
        .dataTables_wrapper,
        .datatable-scroll,
        .datatable-scroll-wrap,
        .datatable-scroll-lg,
        .dataTables_scroll,
        .dataTables_scrollBody,
        .table-responsive {
            overflow: visible !important;
        }
        #list_of_employees tbody tr td {
            overflow: visible !important;
        }
        #list_of_employees .dropdown-menu {
            z-index: 999999 !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2) !important;
        }
        .datatable-footer {
            position: relative !important;
            z-index: 1 !important;
        }

        /* FullCalendar Navigation Buttons & Icons */
        .fc-button .fc-icon {
            font-size: 1.25rem !important;
            line-height: 1 !important;
            height: auto !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
        .fc-icon-left-single-arrow:after {
            content: "\2039" !important;
            font-size: 1.5rem !important;
            font-weight: bold !important;
            line-height: 1 !important;
            display: inline-block !important;
        }
        .fc-icon-right-single-arrow:after {
            content: "\203A" !important;
            font-size: 1.5rem !important;
            font-weight: bold !important;
            line-height: 1 !important;
            display: inline-block !important;
        }
        .fc-prev-button,
        .fc-next-button {
            min-width: 36px !important;
            height: 36px !important;
            padding: 0 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
	</style>

	<link rel="stylesheet" href="assets/fullcalendar/fullcalendar.css">
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- Data Table -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	<!-- sweet alert -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
   	<script src="global_assets/js/fileupload_ns.js"></script>
    <script src="../httpdocs/user_js/calender/moment.min.js"></script>
    <script src="../httpdocs/user_js/calender/fullcalendar.min.js"></script>
	<script src="../httpdocs/user_js/employees.js"></script>
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

			<?PHP include_once('employees/employees_details.php'); ?>

		</div>
		<!-- /content area -->

		<?PHP include_once('template/reset_password_modal.php'); ?>
		<?PHP include_once('employees/apply_leave_modal.php'); ?>
		<?PHP include_once('employees/leave_calendar_modal.php'); ?>

		<!-- Footer -->
		<?PHP include_once('template/footer.inc'); ?>
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