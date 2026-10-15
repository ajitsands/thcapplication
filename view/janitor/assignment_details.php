<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title font-weight-semibold"><i class="icon-clipboard3 mr-2 text-primary"></i>Assign Janitor Checklist</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <style>
            .select2-container--default .select2-selection--single {
                border: 1px solid #ddd !important;
                border-radius: 4px;
                min-height: 36px;
            }
            .slot-table th {
                background-color: #f8f9fa;
                font-weight: 600;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                vertical-align: middle;
            }
            .slot-table td {
                vertical-align: middle;
            }
            .slot-start-time, .slot-end-time {
                min-width: 120px;
                cursor: pointer;
            }
            .slot-time-preview {
                font-size: 10.5px;
                margin-top: 2px;
            }
        </style>
        <form id="frmAssignment">
            <input type="hidden" name="action" value="save_assignment">
            <input type="hidden" name="assignment_id" id="assignment_id" value="0">
            <input type="hidden" name="slots" id="slots_serialized" value="">
            <input type="hidden" name="slots_detail" id="slots_detail_serialized" value="">
            
            <!-- Cascading Premise Filters -->
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold text-primary border-bottom pb-1 mb-2">
                    <i class="icon-location4 mr-1"></i> Customer & Location Filters
                </legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Customer <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="customer_id" id="customer_id" required>
                                <option value="">-Select Customer-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Location <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="location_id" id="location_id" required>
                                <option value="">-Select Location-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Building <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="building_id" id="building_id" required>
                                <option value="">-Select Building-</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Contract, Asset, Janitor & Schedule Details -->
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold text-primary border-bottom pb-1 mb-2">
                    <i class="icon-calendar5 mr-1"></i> Contract, Asset & Schedule Details
                </legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label>Select AMC <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="amc_ref_no" id="amc_ref_no" required>
                                <option value="">-Select AMC-</option>
                            </select>
                        </div>
                        <div id="amc_details_card" class="alert alert-info border-0 p-1 mt-1 mb-0 d-none" style="font-size: 11px; line-height: 1.4;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong><span id="lbl_amc_ref">AMC REF</span></strong>
                                <span id="lbl_amc_status" class="badge badge-info" style="font-size: 9px; padding: 2px 4px;">Status</span>
                            </div>
                            <div class="text-muted"><i class="icon-file-empty mr-1" style="font-size: 11px;"></i><span id="lbl_amc_type">Type</span></div>
                            <div class="text-muted"><i class="icon-calendar22 mr-1" style="font-size: 11px;"></i><span id="lbl_amc_dates">01 Jan 2023 - 31 Dec 2023</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label>Select Asset <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="asset_id" id="asset_id" required>
                                <option value="">-Select Asset-</option>
                            </select>
                        </div>
                        <div id="asset_details_card" class="alert alert-info border-0 p-1 mt-1 mb-0 d-none" style="font-size: 11px; line-height: 1.4;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong><span id="lbl_asset_ref">ASSET REF</span></strong>
                                <span id="lbl_asset_status" class="badge badge-info" style="font-size: 9px; padding: 2px 4px;">Status</span>
                            </div>
                            <div class="text-muted"><i class="icon-tree6 mr-1" style="font-size: 11px;"></i><span id="lbl_asset_cat">Category</span></div>
                            <div class="text-muted"><i class="icon-stack2 mr-1" style="font-size: 11px;"></i><span id="lbl_asset_type">Type</span></div>
                            <div class="text-muted d-none" id="lbl_asset_desc_container"><i class="icon-file-text2 mr-1" style="font-size: 11px;"></i><span id="lbl_asset_desc">Description</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label>Select Checklist <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="checklist_id" id="checklist_id" required>
                                <option value="">-Select Checklist-</option>
                            </select>
                        </div>
                        <div id="checklist_details_card" class="alert alert-info border-0 p-1 mt-1 mb-0 d-none" style="font-size: 11px; line-height: 1.4;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong><span id="lbl_chk_name">CHECKLIST NAME</span></strong>
                                <span id="lbl_chk_status" class="badge badge-info" style="font-size: 9px; padding: 2px 4px;">Status</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center text-muted">
                                <div><i class="icon-list mr-1" style="font-size: 11px;"></i><span id="lbl_chk_stats">Categories & Points</span></div>
                                <button type="button" class="btn btn-sm btn-link text-info p-0 font-weight-bold" id="btn_view_checklist" style="font-size: 10px;">View</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Select Janitor <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="employee_id" id="employee_id" required data-placeholder="-Select Janitor-">
                                <option value="">-Select Janitor-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Frequency (e.g. Daily)</label>
                            <select class="form-control select2" name="frequency" id="frequency">
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="start_date" id="start_date" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="end_date" id="end_date" required>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Service Slots & Execution Time Rules Area -->
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold text-primary border-bottom pb-1 mb-2 d-flex justify-content-between align-items-center">
                    <span><i class="icon-alarm mr-1"></i> Service Slots & Execution Time Rules</span>
                    <button type="button" class="btn btn-sm btn-success py-1 px-2" id="btn_add_slot" style="font-size: 11px;">
                        <i class="icon-plus-circle2 mr-1"></i> Add Another Slot
                    </button>
                </legend>

                <div class="alert alert-light border border-info p-2 mb-2" style="font-size: 12px; line-height: 1.5; background-color: #f7fbfe;">
                    <div class="d-flex">
                        <i class="icon-info22 text-info mr-2 mt-1 font-size-base"></i>
                        <div>
                            <strong>Slot Time Rule Configuration:</strong>
                            Enter the Slot Name (e.g. <em>Morning</em>, <em>Afternoon</em>, <em>Slot 1</em>). For each slot, select the <strong>Start Time</strong> and <strong>End Time</strong> using the interactive time picker. The system automatically formats and displays the time window in standard 12-hour AM/PM format.
                            <br>
                            <span class="text-primary font-weight-semibold"><i class="icon-checkmark-circle mr-1"></i>Rule Policy:</span> Click the <strong>Anytime</strong> button (or leave blank) if <strong>no rule applies</strong>, allowing the janitor to execute that slot at any time of day.
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped slot-table" id="tblSlotsConfig">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">#</th>
                                <th style="width: 28%;">Slot Name <span class="text-danger">*</span></th>
                                <th style="width: 26%;">Start Time <small class="text-muted font-weight-normal d-block">Time Picker or Anytime</small></th>
                                <th style="width: 26%;">End Time <small class="text-muted font-weight-normal d-block">Time Picker or Anytime</small></th>
                                <th style="width: 170px;" class="text-center">Rule Status</th>
                                <th style="width: 60px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="slots_container">
                            <!-- Populated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
            </fieldset>

            <div class="text-right">
                <button type="button" class="btn btn-light" id="btnReset"><i class="icon-reload-alt mr-1"></i> Reset</button>
                <button type="submit" class="btn btn-primary" id="btnSaveAssignment">Submit <i class="icon-paperplane ml-1"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">Assigned Checklists</h6>
    </div>

    <table class="table datatable-basic" id="tblAssignments">
        <thead>
            <tr>
                <th>WO Number</th>
                <th>Janitor</th>
                <th>Checklist</th>
                <th>Asset Code</th>
                <th>AMC Ref</th>
                <th>Frequency</th>
                <th>Dates</th>
                <th>Slots</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- Modal for Viewing Points -->
<div id="modal_view_points" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Checklist Details</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body" id="div_checklist_details_body">
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
