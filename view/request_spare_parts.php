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
	<?PHP include_once('template/head.inc'); ?>
    <?PHP include_once('template/date_time.inc'); ?>
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<!-- DataTables Export Buttons -->
	<script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.print.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script>
		var categoryOptionsHtml = '<option value="">-- Select Category --</option>';
		<?php
		include_once(__DIR__ . '/../model/db_connection/connection.php');
		$conn = (new DBConnection())->ConnectToMYSQL();
		$resCatJS = $conn->query("SELECT category_name FROM tbl_category WHERE category_status = 'Active'");
		if($resCatJS) {
			while($rowCatJS = $resCatJS->fetch_assoc()) {
				echo "categoryOptionsHtml += '<option value=\'".addslashes($rowCatJS['category_name'])."\'>".addslashes($rowCatJS['category_name'])."</option>';\n";
			}
		}
		?>
	</script>
	<script src="../httpdocs/user_js/request_spare_parts.js"></script>
	<style>
		/* Compact Table Styles for Line Items */
		.table-compact th, .table-compact td {
			padding: 0.5rem 0.75rem !important;
			vertical-align: middle !important;
		}
		.table-compact th {
			font-weight: 600;
		}
		.table-compact .form-control {
			height: calc(1.5em + 0.5rem + 2px);
			padding: 0.25rem 0.5rem;
			font-size: 0.8125rem;
		}
		.table-compact .select2-container .select2-selection--single {
			height: calc(1.5em + 0.5rem + 2px) !important;
			padding: 0.25rem 0 !important;
		}
		.table-compact .select2-container .select2-selection--single .select2-selection__rendered {
			line-height: calc(1.5em + 0.5rem) !important;
			padding-left: 0.5rem !important;
		}
		.table-compact .select2-container .select2-selection--single .select2-selection__arrow {
			height: calc(1.5em + 0.5rem) !important;
		}
		
		/* Custom Print Button to match template */
		.btn-template-print {
			background-color: #2e2e79 !important;
			color: #ffffff !important;
			border-radius: 5px !important;
			font-weight: 600 !important;
			border: none !important;
		}
		.btn-template-print:hover {
			background-color: #1e1e59 !important;
			color: #ffffff !important;
		}
		.table-compact .btn-sm {
			padding: 0.25rem 0.5rem;
			font-size: 0.75rem;
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
						<h5 class="card-title">Request Material</h5>
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
										<div class="col-md-4">
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
										<div class="col-md-4">
											<div class="form-group">
												<label>Select Workorder <span class="text-danger">*</span></label>
												<select class="form-control select2" id="workorder_id" name="workorder_id" required disabled>
													<option value="">-- Select Workorder --</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Attachment (Optional)</label>
												<input type="file" class="form-control" id="request_attachment" name="request_attachment" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx">
											</div>
										</div>
									</div>

									<div class="row align-items-end mb-3">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-primary btn-sm mr-2" id="btn_add_item"><i class="icon-plus2 mr-1"></i> Add Line Item</button>
											<button type="button" class="btn btn-outline-info btn-sm" id="btn_add_spare_part"><i class="icon-cube mr-1"></i> Create New Material</button>
										</div>
									</div>

									<div class="table-responsive border rounded mb-3">
										<table class="table table-bordered table-compact" id="tbl_items">
											<thead class="bg-light">
												<tr>
													<th style="width: 20%;">Category</th>
													<th style="width: 25%;">Item</th>
													<th style="width: 10%;">Quantity</th>
													<th style="width: 15%;">Unit</th>
													<th style="width: 20%;">Remarks</th>
													<th style="width: 10%;">Action</th>
												</tr>
											</thead>
											<tbody>
												<!-- Dynamic rows will be appended here -->
											</tbody>
										</table>
									</div>

									<div class="mt-3 text-right">
										<button type="submit" class="btn btn-primary" id="btn_save_request">Save Request <i class="icon-paperplane ml-2"></i></button>
									</div>
								</form>
							</div>

							<div class="tab-pane fade" id="bottom-tab2">
                                <!-- Filter Panel -->
                                <div class="card card-body bg-light mb-3">
                                    <form id="frm_filters">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Customer</label>
                                                    <select class="form-control select2" id="filter_customer" name="filter_customer">
                                                        <option value="">All</option>
                                                        <?php
                                                        $resC = $conn->query("SELECT customer_id, customer_name FROM tbl_customers WHERE customer_status = 'Active'");
                                                        while($rowC = $resC->fetch_assoc()) {
                                                            $sel = (isset($_GET['filter_customer']) && $_GET['filter_customer'] == $rowC['customer_id']) ? 'selected' : '';
                                                            echo "<option value='".$rowC['customer_id']."' $sel>".$rowC['customer_name']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Workorder</label>
                                                    <select class="form-control select2" id="filter_workorder" name="filter_workorder" disabled>
                                                        <option value="">All</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Line Item</label>
                                                    <select class="form-control select2" id="filter_item" name="filter_item">
                                                        <option value="">All</option>
                                                        <?php
                                                        $resI = $conn->query("SELECT id, item_name, item_code FROM tbl_spare_parts_master WHERE status = 'Active'");
                                                        while($rowI = $resI->fetch_assoc()) {
                                                            $sel = (isset($_GET['filter_item']) && $_GET['filter_item'] == $rowI['id']) ? 'selected' : '';
                                                            echo "<option value='".$rowI['id']."' $sel>".$rowI['item_code']." - ".$rowI['item_name']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control select2" id="filter_status" name="filter_status">
                                                        <option value="ExceptCompleted" <?php echo (!isset($_GET['filter_status']) || $_GET['filter_status'] == 'ExceptCompleted') ? 'selected' : ''; ?>>All Except Completed</option>
                                                        <option value="All" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'All') ? 'selected' : ''; ?>>All</option>
                                                        <option value="Pending" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Partial Issue" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Partial Issue') ? 'selected' : ''; ?>>Partial Issue</option>
                                                        <option value="Completed" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                                                        <option value="Closed" <?php echo (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>From Date</label>
                                                    <input type="date" class="form-control" id="filter_from_date" name="filter_from_date" value="<?php echo isset($_GET['filter_from_date']) ? htmlspecialchars($_GET['filter_from_date']) : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <input type="date" class="form-control" id="filter_to_date" name="filter_to_date" value="<?php echo isset($_GET['filter_to_date']) ? htmlspecialchars($_GET['filter_to_date']) : ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-right mt-4">
                                                <button type="button" class="btn btn-primary btn-sm mt-1" id="btn_apply_filter"><i class="icon-filter4 mr-1"></i> Apply Filter</button>
                                                <button type="button" class="btn btn-light btn-sm mt-1 ml-2" id="btn_clear_filter"><i class="icon-reset mr-1"></i> Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

								<table class="table table-hover table-striped datatable-basic" id="tbl_requests_list">
									<thead class="bg-light">
										<tr>
											<th>Request ID</th>
											<th>Customer</th>
											<th>Workorder</th>
											<th>Date</th>
											<th>Attachment</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                        $filter_customer = isset($_GET['filter_customer']) ? (int)$_GET['filter_customer'] : 0;
                                        $filter_workorder = isset($_GET['filter_workorder']) ? (int)$_GET['filter_workorder'] : 0;
                                        $filter_item = isset($_GET['filter_item']) ? (int)$_GET['filter_item'] : 0;
                                        $filter_status = isset($_GET['filter_status']) ? $conn->real_escape_string($_GET['filter_status']) : 'ExceptCompleted';
                                        $filter_from_date = isset($_GET['filter_from_date']) ? $conn->real_escape_string($_GET['filter_from_date']) : '';
                                        $filter_to_date = isset($_GET['filter_to_date']) ? $conn->real_escape_string($_GET['filter_to_date']) : '';

                                        $where = "1=1";
                                        if ($filter_customer > 0) $where .= " AND r.customer_id = $filter_customer";
                                        if ($filter_workorder > 0) $where .= " AND r.workorder_id = $filter_workorder";
                                        
                                        if ($filter_status == 'ExceptCompleted') {
                                            $where .= " AND r.status != 'Completed'";
                                        } elseif ($filter_status != '' && $filter_status != 'All') {
                                            $where .= " AND r.status = '$filter_status'";
                                        }

                                        if ($filter_from_date != '') $where .= " AND DATE(r.request_date) >= '$filter_from_date'";
                                        if ($filter_to_date != '') $where .= " AND DATE(r.request_date) <= '$filter_to_date'";
                                        if ($filter_item > 0) {
                                            $where .= " AND EXISTS (SELECT 1 FROM tbl_spare_parts_request_items ri WHERE ri.request_id = r.id AND ri.item_id = $filter_item)";
                                        }

										$sqlList = "SELECT r.id, r.customer_id, c.customer_name, t.ticket_id, t.ticket_ref_code, t.ticket_ref_no, r.request_date, r.status, r.attachment_path 
													FROM tbl_spare_parts_requests r 
													LEFT JOIN tbl_customers c ON r.customer_id = c.customer_id 
													LEFT JOIN tbl_tickets t ON r.workorder_id = t.ticket_id 
                                                    WHERE $where
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
											
											$req_id_format = "<a href='request_spare_parts_single_print.php?request_id=".$rowList['id']."' target='_blank' class='font-weight-semibold text-primary' title='Print Request Details'>THC-MREQ-" . $rowList['id'] . "</a>";

											$attachment_html = "-";
											if (!empty($rowList['attachment_path'])) {
												$attachment_html = "<a href='../httpdocs/uploads/request_attachments/".$rowList['attachment_path']."' target='_blank' class='btn btn-sm btn-outline-primary' title='Download Attachment'><i class='icon-download mr-1'></i> Download</a>";
											}

											echo "<tr>
													<td>".$req_id_format."</td>
													<td>".$rowList['customer_name']."</td>
													<td>".$wo_format."</td>
													<td><span style='display:none;'>".strtotime($rowList['request_date'])."</span>".date('d/m/Y h:i A', strtotime($rowList['request_date']))."</td>
													<td>".$attachment_html."</td>
													<td><span class='badge ".$status_class."'>".$rowList['status']."</span></td>
													<td class='text-center'>
														<div class='btn-group'>
															<button type='button' class='btn btn-outline-primary btn_view_items' data-id='".$rowList['id']."' title='View Items' style='padding: 2px 6px; font-size: 12px;'>
																<i class='icon-list3'></i>
															</button>
															";
											if ($rowList['status'] == 'Pending' || $rowList['status'] == 'Partial Issue') {
												echo "
															<button type='button' class='btn btn-outline-success btn_edit_request' data-id='".$rowList['id']."' title='Edit Request' style='padding: 2px 6px; font-size: 12px;'>
																<i class='icon-pencil7'></i>
															</button>
												";
											}
											if ($rowList['status'] != 'Pending') {
												echo "
															<button type='button' class='btn btn-outline-info btn_view_history' data-id='".$rowList['id']."' title='View Issue History' style='padding: 2px 6px; font-size: 12px;'>
																<i class='icon-history'></i>
															</button>
												";
											}
											if ($rowList['status'] != 'Closed' && $rowList['status'] != 'Completed') {
												echo "
															<button type='button' class='btn btn-outline-danger btn_close_request' data-id='".$rowList['id']."' title='Close Request' style='padding: 2px 6px; font-size: 12px;'>
																<i class='icon-cross2'></i>
															</button>
												";
											}
											echo "
														</div>
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
						<h6 class="modal-title">Requested Material</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
						<div class="row mb-3">
							<div class="col-md-4">
								<h6 class="font-weight-semibold mb-0">Request No</h6>
								<span id="view_req_no" class="text-muted"></span>
							</div>
							<div class="col-md-4">
								<h6 class="font-weight-semibold mb-0">Customer</h6>
								<span id="view_customer" class="text-muted"></span>
							</div>
							<div class="col-md-4">
								<h6 class="font-weight-semibold mb-0">Workorder</h6>
								<span id="view_workorder" class="text-muted"></span>
							</div>
						</div>
						<div class="table-responsive">
							<input type="hidden" id="current_modal_request_id" value="">
							<table class="table table-bordered table-striped" id="tbl_modal_items">
								<thead>
									<tr>
										<th>Category</th>
										<th>Item Name</th>
										<th>Unit</th>
										<th>Remarks</th>
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
						<div class="row mb-3">
							<div class="col-md-4">
								<h6 class="font-weight-semibold mb-0">Request No</h6>
								<span id="hist_req_no" class="text-muted"></span>
							</div>
							<div class="col-md-4">
								<h6 class="font-weight-semibold mb-0">Customer</h6>
								<span id="hist_customer" class="text-muted"></span>
							</div>
							<div class="col-md-4">
								<h6 class="font-weight-semibold mb-0">Workorder</h6>
								<span id="hist_workorder" class="text-muted"></span>
							</div>
						</div>
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

		<!-- Modal for Add/Edit Material -->
		<div id="modal_spare_part" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<form id="frm_spare_part">
						<div class="modal-header bg-primary">
							<h5 class="modal-title" id="modal_title">Add Material</h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body">
							<input type="hidden" id="part_id" name="part_id" value="">
							<input type="hidden" id="action" name="action" value="add_spare_part">

							<div class="form-group">
								<label>Category <span class="text-danger">*</span></label>
								<select class="form-control select2" id="modal_category" name="category" required>
									<option value="">-- Select Category --</option>
									<?php
									$resCat2 = $conn->query("SELECT category_name FROM tbl_category WHERE category_status = 'Active'");
									if($resCat2) {
										while($rowCat2 = $resCat2->fetch_assoc()) {
											echo "<option value='".$rowCat2['category_name']."'>".$rowCat2['category_name']."</option>";
										}
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Item Code <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="item_code" name="item_code" required>
							</div>

							<div class="form-group">
								<label>Item Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="item_name" name="item_name" required>
							</div>

							<div class="form-group">
								<label>Type <span class="text-danger">*</span></label>
								<select class="form-control select2" id="type_name" name="type_name" required>
									<option value="">-- Select Type --</option>
									<option value="Goods">Goods</option>
									<option value="Products">Products</option>
									<option value="Both">Both</option>
								</select>
							</div>

							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" id="description" name="description" rows="3"></textarea>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary" id="btn_save_spare_part">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Modal for Add/Edit Material -->

		<!-- Edit Request Modal -->
		<div id="modal_edit_request" class="modal fade" tabindex="-1">
			<div class="modal-dialog" style="max-width: 90%;">
				<div class="modal-content">
					<form id="frm_edit_request" action="#">
						<div class="modal-header bg-primary">
							<h5 class="modal-title">Edit Request <span id="edit_request_id_display"></span></h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<div class="modal-body">
							<input type="hidden" id="edit_request_id" name="request_id" value="">
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Customer</label>
										<input type="text" class="form-control" id="edit_customer_name" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Workorder</label>
										<input type="text" class="form-control" id="edit_workorder_name" readonly>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Update Attachment (Optional)</label>
										<input type="file" class="form-control" id="edit_request_attachment" name="request_attachment" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx">
										<small id="edit_current_attachment_link" class="form-text text-muted"></small>
									</div>
								</div>
							</div>

							<div class="row align-items-end mb-3 mt-2">
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-primary btn-sm mr-2" id="btn_edit_add_item"><i class="icon-plus2 mr-1"></i> Add Line Item</button>
								</div>
							</div>

							<div class="table-responsive border rounded mb-3">
								<table class="table table-bordered table-compact" id="tbl_edit_items">
									<thead class="bg-light">
										<tr>
											<th style="width: 20%;">Category</th>
											<th style="width: 25%;">Item</th>
											<th style="width: 10%;">Quantity</th>
											<th style="width: 15%;">Unit</th>
											<th style="width: 15%;">Remarks</th>
											<th style="width: 10%;">Issued</th>
											<th style="width: 5%;">Action</th>
										</tr>
									</thead>
									<tbody>
										<!-- Populated by JS -->
									</tbody>
								</table>
							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="btn_update_request">Update Request <i class="icon-checkmark4 ml-2"></i></button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Edit Request Modal -->

		<?PHP include_once('template/footer.inc'); ?>
	<!-- /main content -->
</body>
</html>
<?PHP } else { ?>
	<script>window.location="login.php"</script>
<?PHP } ?>
