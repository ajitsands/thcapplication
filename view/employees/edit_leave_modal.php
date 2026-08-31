<!-- Edit / Delete Leave Modal -->
<div id="modal_edit_leave" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-teal-400">
                <h6 class="modal-title font-weight-semibold"><i class="icon-calendar mr-2"></i> Manage Employee Leave</h6>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit_leave_id">
                <input type="hidden" id="edit_leave_table_source">
                <input type="hidden" id="edit_leave_emp_code">

                <div class="form-group row">
                    <label class="col-form-label col-lg-4 font-weight-semibold">Employee:</label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control font-weight-bold" id="edit_leave_emp_name" readonly style="background-color: #f8f9fa; color: #2e2e79;">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-4 font-weight-semibold">Leave Type <span class="text-danger">*</span>:</label>
                    <div class="col-lg-8">
                        <select id="edit_leave_type" class="form-control">
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Annual Leave">Annual Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Privilege Leave">Privilege Leave</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-4 font-weight-semibold">Start Date <span class="text-danger">*</span>:</label>
                    <div class="col-lg-8">
                        <input type="date" class="form-control" id="edit_leave_start_date">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-4 font-weight-semibold">End Date <span class="text-danger">*</span>:</label>
                    <div class="col-lg-8">
                        <input type="date" class="form-control" id="edit_leave_end_date">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-4 font-weight-semibold">Reason:</label>
                    <div class="col-lg-8">
                        <textarea id="edit_leave_reason" class="form-control" rows="3" placeholder="Enter reason for leave"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between" style="border-top: 1px solid #e5e7eb;">
                <button type="button" id="btn_delete_leave" class="btn btn-danger font-weight-semibold">
                    <i class="icon-trash mr-1"></i> Delete Leave
                </button>
                <div>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btn_update_leave" class="btn bg-teal-400 font-weight-semibold">
                        <i class="icon-checkmark2 mr-1"></i> Update Leave
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
