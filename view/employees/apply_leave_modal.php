<!-- Apply Leave Modal -->
<div id="modal_apply_leave" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg" style="max-width: 750px;">
        <div class="modal-content">
            <div class="modal-header bg-teal-400">
                <h6 class="modal-title">Apply Leave</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 font-weight-semibold">Employee Name <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select id="leave_emp_name" class="form-control form-control-select2" data-placeholder="Select Employee">
                        </select>
                        <input type="hidden" id="leave_emp_id">
                        <input type="hidden" id="leave_emp_code">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3 font-weight-semibold">Leave Type <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select id="leave_type" class="form-control form-control-select2" data-placeholder="Select or Add Leave Type">
                            <option value=""></option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Annual Leave">Annual Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Privilege Leave">Privilege Leave</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3 font-weight-semibold">Start Date <span class="text-danger">*</span></label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="leave_start_date">
                    </div>
                    <label class="col-form-label col-lg-3 font-weight-semibold">End Date <span class="text-danger">*</span></label>
                    <div class="col-lg-3">
                        <input type="date" class="form-control" id="leave_end_date">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3 font-weight-semibold">Duration <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select id="leave_duration" class="form-control form-control-select2" data-placeholder="Select Duration">
                            <option value="Full Day">Full Day</option>
                            <option value="Half Day">Half Day</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3 font-weight-semibold">Reason <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea id="leave_reason" class="form-control" rows="3" placeholder="Enter reason for leave"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                <button type="button" id="btn_submit_leave" class="btn bg-teal-400 btn-ladda" data-style="zoom-in">Submit Leave</button>
            </div>
        </div>
    </div>
</div>
<!-- /Apply Leave Modal -->
