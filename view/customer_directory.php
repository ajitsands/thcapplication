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

<link href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" rel="stylesheet" type="text/css">
	 
	<style>
	    	td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
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
	<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
	
    <script src="global_assets/js/fileupload_ns.js"></script>
	<script src="../httpdocs/user_js/customer_directory.js"></script>
	<script src="../httpdocs/user_js/login.js"></script>
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
				include_once('template/left_menu_new.inc');
					//include_once('template/left_menu.inc');
				?>
				
				
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

					<!-- Page header -->
			<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4> Customer Directory</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

				
				</div>
                    <?PHP include "../model/db_connection/connection.php" ;
                    $DBConn = new DBConnection();
                    $varDBConnection = $DBConn->ConnectToMYSQL();
                    
                     $result_customer_location = mysqli_query($varDBConnection,"Select * from tbl_customers ");
                    
                     	
                    ?>
                    	<div class="page-header-content form-group">
											<div class="row">
											    	<div class="col-md-10">
											    	    	<select data-placeholder="Select Customer" id="select_customer" class="form-control form-control-select2" data-fouc tabindex=1>
                     <option value="select">Select Customer </option>
                    <?PHP 	while($row_customer_location=mysqli_fetch_assoc($result_customer_location)) { ?>
                      <option value="<?PHP echo $row_customer_location['customer_id']; ?>"><?PHP echo $row_customer_location['customer_code'].'--'.$row_customer_location['customer_name']; ?></option>
                    
                    <?PHP } ?>
                  </select>
											    	</div>
											    	<div class="col-md-2">
											    	    	<button type="button" id="btn_customer_details_view" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;GO</button>
    				
											        </div>
											 </div>
						</div>
			
			</div>
			<!-- /page header -->
			<!-- Content area -->
			<div class="content">

				<!-- Inner container -->
				<div class="d-md-flex align-items-md-start">

					<!-- Left sidebar component -->
					<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

						<!-- Sidebar content -->
						<div class="sidebar-content">

							<!-- Navigation -->
							<div class="card">
								
								<div class="card-body p-0">
									<ul class="nav nav-sidebar mb-2">
										
										<li class="nav-item">
											<a href="#profile" class="nav-link active" data-toggle="tab">
												<i class="icon-user"></i>
												 Customer Info.
											</a>
										</li>
										<li class="nav-item">
											<a href="#schedule" class="nav-link" data-toggle="tab">
												<i class="icon-calendar3"></i>
												Facilities
												<!--<span class="badge bg-danger badge-pill ml-auto">29</span>-->
											</a>
										</li>
										<li class="nav-item">
											<a href="#inbox" class="nav-link" data-toggle="tab">
												<i class="icon-envelop2"></i>
												Assets
												<!--<span class="badge bg-danger badge-pill ml-auto">29</span>-->
											</a>
										</li>
										<li class="nav-item">
											<a href="#orders" class="nav-link" data-toggle="tab">
												<i class="icon-cart2"></i>
												AMC
												<!--<span class="badge bg-success badge-pill ml-auto">16</span>-->
											</a>
										</li>
										
										<li class="nav-item">
											<a href="#tickets" class="nav-link" data-toggle="tab">
												<i class="icon-switch2"></i>
												Non Routine Work Orders
											</a>
										</li>
										<li class="nav-item exportToPDFAction classCustomerDirectoryPDF" id="li_customer_print">
											<a href="#" class="nav-link" data-toggle="tab">
												<i class="icon-printer"></i>
												Print
											</a>
										</li>
									</ul>
								</div>
							</div>
							<!-- /navigation -->


						
						</div>
						<!-- /sidebar content -->

					</div>
					<!-- /left sidebar component -->


					<!-- Right content -->
					<div class="tab-content w-100">
						<div class="tab-pane fade active show" id="profile">

						

							<!-- Profile info -->
							<div class="card">
								<div class="card-header header-elements-inline">
									<h5 class="card-title">Customer Details</h5>
									
								</div>

								<div class="card-body">
									<form action="#">
										<div class="form-group">
											<div class="row">
											    	<div class="col-md-6">
													<label><b>Customer Code</b></label>
													<input type="text" id="txt_customer_code" class="form-control" readonly="readonly">
												</div>
												<div class="col-md-6">
													<label><b>Customer Name</b></label>
													<input type="text" id="txt_customer_name" class="form-control" readonly="readonly">
												</div>
											
											</div>
										</div>

										<div class="form-group">
											<div class="row">
											    	<div class="col-md-6">
													<label><b>Contact No.</b></label>
													<input type="text" id="txt_customer_contact_no" class="form-control" readonly="readonly">
												</div>
												<div class="col-md-6">
													<label><b>Alternat Contact No.</b></label>
													<input type="text" id="txt_alt_contact_no" class="form-control" readonly="readonly">
												</div>
												
											</div>
										</div>

										<div class="form-group">
											<div class="row">
											    <div class="col-md-6">
													<label><b>Email Id</b></label>
													<input type="text" id="txt_email_id" class="form-control" readonly="readonly">
												</div>
												<div class="col-md-6">
													<label><b>CPR/CR No.</b></label>
													<input type="text" id="txt_cpr_no" class="form-control" readonly="readonly">
												</div>
												
												
											</div>
										</div>

										<div class="form-group">
											<div class="row">
											    <div class="col-md-6">
													<label><b>VAT No.</b></label>
													<input type="text" id="txt_vat_no" class="form-control" readonly="readonly">
												</div>
											    <div class="col-md-6">
													<label><b>Contact Person Name</b></label>
													<input type="text" id="txt_contact_person_name" class="form-control" readonly="readonly">
												</div>
											
												
												
											</div>
										</div>

				                        <div class="form-group">
				                        	<div class="row">
				                        	    	<div class="col-md-6">
													<label><b>Contact Person No.</b></label>
													<input type="text" readonly="readonly" id="txt_contact_person_no" readonly="readonly" class="form-control">
												</div>
				                        		<div class="col-md-6">
													<label><b>Address</b></label>
													<input type="text" readonly="readonly" id="txt_address" class="form-control">
												</div>
				                        	

												
				                        	</div>
				                        </div>
				                         <div class="form-group">
				                        	<div class="row">
				                        	    <div class="col-md-6">
													<label><b>Status</b></label>
													<input type="text" id="txt_status" readonly="readonly" class="form-control">
													
				                        		</div>
				                        		<div class="col-md-6">
													<label><b>Other Details</b></label>
													<input type="text" id="txt_othr_dertails" readonly="readonly" class="form-control">
													
				                        		</div>

												
				                        	</div>
				                        </div>

				                        <!--<div class="text-right">-->
				                        <!--	<button type="submit" class="btn btn-primary">Save changes</button>-->
				                        <!--</div>-->
									</form>
								</div>
							</div>
							<!-- /profile info -->



					    </div>

					    <div class="tab-pane fade" id="schedule">

				    	
	<!-- My inbox -->
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Customer Facilities</h6>

								
								</div>


								<!-- Table -->
								<div class="table-responsive">
								    <table class="table datatable-selection-single" id="tbl_customer_facility">
								<!--	<table class="table table-inbox" id="tbl_customer_facility">-->
									    	<thead>
											<tr>
												<th  width="10%">Sl. No.</th>
												<th width="10%">Image</th>
												<th>Facility & Location</th>
												<th>Address & Contact Point</th>
												
											
											</tr>
										</thead>
										<tbody data-link="row" class="rowlink">
										    
									

										</tbody>
									</table>
								</div>
								<!-- /table -->

							</div>
							<!-- /my inbox -->

						

				    	</div>

					    <div class="tab-pane fade" id="inbox">

							<!-- My inbox -->
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Customer Assets</h6>

								
								</div>


								<!-- Table -->
								<div class="table-responsive">
								     <table class="table datatable-selection-single" id="tbl_customer_assets">
									<!--<table class="table table-inbox">-->
									    	<thead>
											<tr>
											    <th></th>
												<th  width="10%">Sl. No.</th>
												<th>Facility & Location</th>
												<th>Category & Type</th>
												<th>BarCode</th>
												<!--<th>Attachment</th>-->
											
											</tr>
										</thead>
										<tbody data-link="row" class="rowlink">
										

										

										</tbody>
									</table>
								</div>
								<!-- /table -->

							</div>
							<!-- /my inbox -->

				    	</div>

				    	<div class="tab-pane fade" id="orders">

							<!-- Orders history -->
							<div class="card">
								<div class="card-header header-elements-inline">
									<h6 class="card-title">List of AMC</h6>
									<div class="header-elements">
										<!--<span><i class="icon-arrow-down22 text-danger"></i> <span class="font-weight-semibold">- 29.4%</span></span>-->
			                		</div>
								</div>

							

								<div class="table-responsive">
								    <table border="0" cellspacing="5" cellpadding="5">
                                        <tbody><tr>
                                            <td>Start Date:</td>
                                            <td><input type="text" id="min" name="min"></td>
                                        </tr>
                                        <tr>
                                            <td>End Date:</td>
                                            <td><input type="text" id="max" name="max"></td>
                                        </tr>
                                    </tbody></table>
								    <table class="table datatable-selection-single" id="tbl_customer_amc_list">
									<!--<table class="table text-nowrap" id="tbl_amc_list">-->
										<thead>
											<tr>
											    <th></th>
											    <th></th>
												<th>AMC No.</th>
												<th>Type</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Status</th>
												
												<!--<th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th>-->
											</tr>
										</thead>
										<tbody>
									
										</tbody>
									</table>
								</div>
							</div>
							<!-- /orders history -->

				    	</div>
				    	 <div class="tab-pane fade" id="tickets">

							<!-- My inbox -->
							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">Non Routine Work Orders</h6>

								
								</div>


								<!-- Table -->
								<div class="table-responsive">
								     <table class="table datatable-selection-single" id="tbl_customer_tickets">
									<!--<table class="table table-inbox">-->
									    	<thead>
											<tr>
											    <th></th>
												<th  width="10%">Sl. No.</th>
												<th></th>
												<th>Date	</th>
												<th>Work Order No</th>
												<th>Location</th>
												<th>Building</th>
												
											
											</tr>
										</thead>
										<tbody data-link="row" class="rowlink">
										<!--	<tr class="unread">
												
												<td width="10%">
												    1.
												
												</td>
											
											<td class="table-inbox-message">
													Custom Snowboard
													
												</td>
												<td class="table-inbox-message">
													Electronics, AC
													
												</td>
												<td class="table-inbox-message">
													<a href="#" class="font-weight-semibold">QWERTY12345</a>
													
												</td>
											
													
											
											</tr>-->

										

										</tbody>
									</table>
								</div>
								<!-- /table -->

							</div>
							<!-- /my inbox -->

				    	</div>
					</div>
					<!-- /right content -->

				</div>
				<!-- /inner container -->

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