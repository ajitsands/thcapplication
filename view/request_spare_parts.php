<?PHP
if (session_status() == PHP_SESSION_NONE) {
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
	<?PHP include_once('template/head.inc'); ?>
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="../httpdocs/user_js/request_spare_parts.js"></script>
	<style>
		/* Fix DataTable alignment */
		#bottom-tab2 .datatable-header,
		#bottom-tab2 .datatable-footer {
			display: flex !important;
			justify-content: space-between !important;
			align-items: center !important;
		}
		#bottom-tab2 .datatable-header {
			padding-top: 0px !important;
			padding-bottom: 0px !important;
			margin-bottom: 0px !important;
		}
		#bottom-tab2 .datatable-footer {
			padding-top: 15px !important;
		}
		#bottom-tab2 .datatable-header::before,
		#bottom-tab2 .datatable-header::after,
		#bottom-tab2 .datatable-footer::before,
		#bottom-tab2 .datatable-footer::after {
			display: none !important;
			content: none !important;
		}
		#bottom-tab2 .dataTables_filter,
		#bottom-tab2 .dataTables_length,
		#bottom-tab2 .dataTables_info,
		#bottom-tab2 .dataTables_paginate {
			float: none !important;
			margin: 0 !important;
		}
		#bottom-tab2 .datatable-scroll {
			margin-top: 5px !important;
		}
	</style>
</head>
<body class="navbar-top">
	<?PHP include_once('template/top_menu_new.inc'); ?>

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">
		<div class="content pt-0">
				
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Request Spare Parts</h5>
					</div>

					<div class="card-body">
						<ul class="nav nav-tabs nav-tabs-bottom">
							<li class="nav-item"><a href="#bottom-tab1" class="nav-link active" data-toggle="tab">Request Form</a></li>
							<li class="nav-item"><a href="#bottom-tab2" class="nav-link" data-toggle="tab">Requested Items List</a></li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane fade show active" id="bottom-tab1">
								<form id="frm_request_spare_parts" action="#">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Select Customer <span class="text-danger">*</span></label>
												<select class="form-control select2" id="customer_id" name="customer_id" required>
													<option value="">-- Select Customer --</option>
													<?php
													include_once(__DIR__ . '/../model/db_connection/connection.php');
													$conn = (new DBConnection())->ConnectToMYSQL();
													$res = $conn->query("SELECT customer_id, customer_name FROM tbl_customers WHERE customer_status = 'Active'");
													while($row = $res->fetch_assoc()) {
														echo "<option value='".$row['customer_id']."'>".$row['customer_name']."</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Select Workorder <span class="text-danger">*</span></label>
												<select class="form-control select2" id="workorder_id" name="workorder_id" required disabled>
													<option value="">-- Select Workorder --</option>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Select Category</label>
												<select class="form-control select2" id="category" name="category">
													<option value="">-- Select Category --</option>
													<?php
													$resCat = $conn->query("SELECT name FROM tbl_spare_parts_categories");
													while($rowCat = $resCat->fetch_assoc()) {
														echo "<option value='".$rowCat['name']."'>".$rowCat['name']."</option>";
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>&nbsp;</label>
												<button type="button" class="btn btn-primary d-block" id="btn_add_item">Add Item</button>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-bordered" id="tbl_items">
											<thead>
												<tr>
													<th>Category</th>
													<th>Item</th>
													<th>Quantity</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<!-- Dynamic rows will be appended here -->
											</tbody>
										</table>
									</div>

									<div class="mt-3 text-right">
										<button type="submit" class="btn btn-success" id="btn_save_request">Save Request <i class="icon-paperplane ml-2"></i></button>
									</div>
								</form>
							</div>

							<div class="tab-pane fade" id="bottom-tab2">
								<table class="table datatable-basic" id="tbl_requests_list">
									<thead>
										<tr>
											<th>Request ID</th>
											<th>Customer</th>
											<th>Workorder</th>
											<th>Date</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sqlList = "SELECT r.id, r.customer_id, c.customer_name, t.ticket_id, t.ticket_ref_code, t.ticket_ref_no, r.request_date, r.status 
													FROM tbl_spare_parts_requests r 
													LEFT JOIN tbl_customers c ON r.customer_id = c.customer_id 
													LEFT JOIN tbl_tickets t ON r.workorder_id = t.ticket_id 
													ORDER BY r.id DESC";
										$resList = $conn->query($sqlList);
										while($rowList = $resList->fetch_assoc()) {
											$status_class = 'badge-info';
											if ($rowList['status'] == 'Pending') {
												$status_class = 'badge-warning';
											} else if ($rowList['status'] == 'Partial Issue') {
												$status_class = 'badge-primary';
											} else if ($rowList['status'] == 'Completed') {
												$status_class = 'badge-success';
											} else if ($rowList['status'] == 'Closed') {
												$status_class = 'badge-secondary';
											}
											
											$wo_format = "";
											if (!empty($rowList['ticket_id'])) {
												$wo_format = "WO-" . $rowList['ticket_ref_code'] . "-" . $rowList['ticket_id'];
											}
											
											$req_id_format = "THC-MREQ-" . $rowList['id'];

											echo "<tr>
													<td>".$req_id_format."</td>
													<td>".$rowList['customer_name']."</td>
													<td>".$wo_format."</td>
													<td><span style='display:none;'>".strtotime($rowList['request_date'])."</span>".date('d/m/Y h:i A', strtotime($rowList['request_date']))."</td>
													<td><span class='badge ".$status_class."'>".$rowList['status']."</span></td>
													<td>
														<button type='button' class='btn btn-sm btn-primary btn_view_items' data-id='".$rowList['id']."' title='View Items'>
															<i class='icon-eye'></i> View
														</button>
														";
											if ($rowList['status'] != 'Pending') {
												echo "
														<button type='button' class='btn btn-sm btn-info btn_view_history' data-id='".$rowList['id']."' title='View Issue History'>
															<i class='icon-history'></i> History
														</button>
												";
											}
											if ($rowList['status'] != 'Closed' && $rowList['status'] != 'Completed') {
												echo "
														<button type='button' class='btn btn-sm btn-danger btn_close_request' data-id='".$rowList['id']."' title='Close Request'>
															<i class='icon-cross2'></i> Close
														</button>
												";
											}
											echo "
													</td>
												  </tr>";
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- Items Modal -->
		<div id="modal_view_items" class="modal fade" tabindex="-1">
			<div class="modal-dialog" style="max-width: 80%;">
				<div class="modal-content">
					<div class="modal-header bg-primary">
						<h6 class="modal-title">Requested Spare Parts</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<div class="table-responsive">
							<input type="hidden" id="current_modal_request_id" value="">
							<table class="table table-bordered table-striped" id="tbl_modal_items">
								<thead>
									<tr>
										<th>Category</th>
										<th>Item Name</th>
										<th>Req Qty</th>
										<th>Issued Qty</th>
										<th>Issue Action</th>
									</tr>
								</thead>
								<tbody>
									<!-- Populated by JS -->
								</tbody>
							</table>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Items Modal -->

		<!-- History Modal -->
		<div id="modal_issue_history" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Issuance History</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="tbl_modal_history">
								<thead>
									<tr>
										<th>Category</th>
										<th>Item Name</th>
										<th>Req Qty</th>
										<th>Issued Qty</th>
										<th>Date & Time</th>
										<th>Issued By</th>
									</tr>
								</thead>
								<tbody>
									<!-- Populated by JS -->
								</tbody>
							</table>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /History Modal -->

		<?PHP include_once('template/footer.inc'); ?>
	<!-- /main content -->
</body>
</html>
<?PHP } else { ?>
	<script>window.location="login.php"</script>
<?PHP } ?>
