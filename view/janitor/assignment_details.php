<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">Assign Janitor Checklist</h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <style>
            /* Ensure Select2 multi-select has a visible border in Limitless */
            .select2-container--default .select2-selection--multiple {
                border: 1px solid #ddd !important;
                border-radius: 4px;
                min-height: 36px;
            }
        </style>
        <form id="frmAssignment">
            <input type="hidden" name="action" value="save_assignment">
            <input type="hidden" name="assignment_id" id="assignment_id" value="0">
            
            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Cascading Filters</legend>
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

            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Assignment Details</legend>
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

                <div class="row">
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
                            <label>Service Slots <small class="text-muted">(comma separated)</small></label>
                            <input type="text" class="form-control" name="slots" id="slots" placeholder="e.g. Morning, Evening  or  10 AM, 11 AM  or  Slot 1, Slot 2">
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

            <fieldset class="mb-3">
                <legend class="text-uppercase font-size-sm font-weight-bold">Assign Janitors</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Select Janitors <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="employee_id[]" id="employee_id" multiple="multiple" required data-placeholder="Select Janitor(s)...">
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div class="text-right">
                <button type="button" class="btn btn-light" id="btnReset">Reset</button>
                <button type="submit" class="btn btn-primary" id="btnSaveAssignment">Submit <i class="icon-paperplane ml-2"></i></button>
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
