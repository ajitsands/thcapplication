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
	    td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
        }
        #list_of_location_wrapper .dataTables_length,
        #list_of_building_wrapper .dataTables_length {
            float: left !important;
            display: inline-flex !important;
            align-items: center !important;
            margin-bottom: 12px !important;
        }
        #list_of_location_wrapper .dataTables_filter,
        #list_of_building_wrapper .dataTables_filter {
            float: right !important;
            display: inline-flex !important;
            align-items: center !important;
            text-align: right !important;
            margin-bottom: 12px !important;
        }
        #list_of_location_wrapper .dataTables_filter label,
        #list_of_building_wrapper .dataTables_filter label {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
            margin-bottom: 0 !important;
        }
        #list_of_location_wrapper:after,
        #list_of_building_wrapper:after {
            content: "" !important;
            display: table !important;
            clear: both !important;
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

	<!-- Leaflet CSS and JS -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <!-- Leaflet Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- Leaflet Fullscreen -->
    <link href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>
	
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

			<!-- Page header -->
			<?PHP 
				//include_once('template/header_bellow_title.inc');
			?>
			
			<!-- /page header -->


			<!-- Content area -->
			<div class="content pt-0">

				<!-- Large navbar -->
				
				<?PHP 
					include_once('location/location_build_details.php');
				?>
				
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
				include_once('template/reset_password_modal.php');
			?>

			<!-- Map Modal -->
			<div id="map_modal" class="modal fade" tabindex="-1">
				<div class="modal-dialog modal-xl" style="max-width: 90% !important; width: 90% !important;">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white">
							<h5 class="modal-title" id="map_modal_title">Pin Facility Location</h5>
							<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
                            <input type="hidden" id="map_building_id">
                            
                            <div class="form-group row mb-2">
                                <div class="col-lg-6">
                                    <label><strong>Latitude:</strong></label>
                                    <input type="text" id="map_latitude" class="form-control" readonly>
                                </div>
                                <div class="col-lg-6">
                                    <label><strong>Longitude:</strong></label>
                                    <input type="text" id="map_longitude" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-form-label col-lg-2"><strong>Search Location:</strong></label>
                                <div class="col-lg-10">
                                    <div class="input-group">
                                        <input type="text" id="map_search_input" class="form-control" placeholder="Type location, building, or address...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="btn_map_search">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted">You can search for a location above, or click on the map to place/move the pin.</p>
							<div id="facility_map" style="height: 75vh; width: 100%; z-index: 1;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
							<button type="button" id="btn_save_map_location" class="btn btn-success">Save Location</button>
						</div>
					</div>
				</div>
			</div>
			<!-- /Map Modal -->

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