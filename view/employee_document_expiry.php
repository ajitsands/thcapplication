<?PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION["loggedin"] == true) {
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
	<title>Document Expiry Report</title>
	<?PHP 
		include_once('template/head.inc');
	?>

	<style>
	    td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
        }
        #tbl_document_expiries th,
        #tbl_document_expiries td {
            vertical-align: middle !important;
        }
        .col-employee-name {
            min-width: 200px !important;
            white-space: nowrap !important;
            font-weight: 600;
        }
        .badge-expired {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge-soon {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fcd34d;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge-valid {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge-doc-name {
            background-color: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
        }
        .stat-card {
            border-radius: 8px;
            padding: 14px 18px;
            color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            transition: transform 0.15s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .stat-card .stat-number {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.2;
        }
        .stat-card .stat-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
            font-weight: 600;
        }
	</style>
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- Data Table -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	<!-- sweet alert -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
	
    <script src="global_assets/js/fileupload_ns.js"></script>
	<script src="../httpdocs/user_js/document_expiry.js"></script>
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

			<?PHP 
				include_once('expiry/document_expiry_details.php');
			?>

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
<?PHP 
} else {
?>
<script>
	window.location="login.php"
</script>
<?PHP
}
?>
