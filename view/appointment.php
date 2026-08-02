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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="path/to/daterangepicker.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="path/to/moment.min.js"></script>
    <script src="path/to/daterangepicker.js"></script>
	<?PHP 
		include_once('template/head.inc');
	?>

	 
	<style>
       /* ================================
           Document Container Styling
        ================================ */
        #document_container {
            /*background: #f9f9f9;*/
            border-radius: 8px;
            padding: 15px;
        }
        
        /* ================================
           Employee Docs Preview Grid
        ================================ */
        #employeeDocsPreview,
        .document_preview {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;              /* space between cards */
            margin-top: 12px;
        }
        
        /* ================================
           Preview Card (Grid Style)
        ================================ */
        .preview-card {
            position: relative;
            width: 140px;           /* fixed width for grid look */
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 8px;
            text-align: center;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s ease-in-out;
        }
        .preview-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        
        /* Thumbnail Area */
        .preview-card .preview-thumb {
            width: 100%;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 6px;
        }
        .preview-card img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }
        
        /* File Name */
        .preview-card .file-name {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Delete Button (for cards & list) */
        .preview-card .delete-file,
        .preview-item .delete-file {
            margin-left: 5px;       /* updated */
            cursor: pointer;
            font-size: 16px;
            color: red;
            font-weight: bold;      /* updated */
        }
        
        /* ================================
           PDF & Other File Previews
        ================================ */
        .pdf-preview {
            width: 100%;
            height: 90px;
            border: 1px solid #ccc;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-align: center;
            border-radius: 4px;
        }
        
        /* ================================
           Document Upload Rows
        ================================ */
        .document_row {
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            padding: 10px;
        }
        .document_file {
            display: block;
            margin-bottom: 20px;
            color: pink;
        }
        
        /* ================================
           Buttons & Inputs
        ================================ */
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 0 4px 4px 0;
        }
        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }
        .btn-dark {
            background: #343a40;
            border-color: #343a40;
        }
        
        /* ================================
           DataTables Expand Icons
        ================================ */
        td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
        }
        
        /* ================================
           Simple List Preview (Alternative)
        ================================ */
        .preview-item {
            display: inline-block;  /* updated */
            margin-right: 10px;     /* updated */
            vertical-align: top;    /* updated */
            padding: 5px;
            background: #f8f8f8;
            border-radius: 4px;
        }
        .preview-item a {
            color: #333;
            text-decoration: none;
        }
        .preview-item a:hover {
            text-decoration: underline;
        }
        
        /* ================================
           Attachment Icon
        ================================ */
        .icon-attachment {
            font-size: 20px;
            cursor: pointer;
            color: #666;
        }
        .icon-attachment:hover {
            color: #007bff;
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
	<!--<script src="global_assets/js/moment.min.js"></script>-->
   	 <script src="global_assets/js/fileupload_ns.js"></script>
	<script src="../httpdocs/user_js/appointment.js"></script>
	<!--<script src="../httpdocs/user_js/login.js"></script>-->
</head>
    <?PHP 
		include_once('template/date_time.inc');
	?>
<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-light navbar-static fixed-top">

		<!-- Header with logos -->
		<?PHP 
				include_once('template/header_with_logo.inc');
		?>
	
		<!-- /header with logos -->
	

		<!-- Mobile controls -->
		<?PHP 
				include_once('template/mobile_view.inc');
		?>
		<!-- /mobile controls -->


		<!-- Navbar content -->
		<?PHP 
				include_once('template/navigation.inc');
		?>
		
		
		<!-- /navbar content -->
		
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			
			<?PHP 
				include_once('template/mobile_toggler.inc');
			?>
			
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">
				
				<!-- User menu -->
				<?PHP 
					include_once('template/user_menu.inc');
				?>
				
				<!-- /user menu -->

				
				<!-- Main navigation -->
				<?PHP 
					//include_once('template/left_menu.inc');
					include_once('template/left_menu_new.inc');  
				?>
				
				
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?PHP 
				//include_once('template/header_bellow_title.inc');
			?>
			
			<!-- /page header -->


			<!-- Content area -->
			<div class="content pt-0">

				<!-- Large navbar -->
				
				<?PHP 
					include_once('appointment/appointment_body.php');
				?>
				<!--<button class="classGivePermission">Test Button</button>-->
				
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

	</div>
	<!-- /page content -->

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