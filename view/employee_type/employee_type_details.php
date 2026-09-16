<div class="row">
    <div class="card col-md-12">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-semibold"><i class="icon-users4 mr-2"></i> Employee Type Master</h5>
        </div>

        <div class="card-body">
            <input type="hidden" id="txt_employee_type_id" />

            <div class="row">
                <!-- Employee Type Name -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="font-weight-semibold text-muted">Employee Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="txt_employee_type_name" placeholder="e.g. Technician, Supervisor" />
                    </div>
                </div>

                <!-- Description -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="font-weight-semibold text-muted">Description / Notes</label>
                        <input type="text" class="form-control" id="txt_employee_type_description" placeholder="Brief description of the employee type" />
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: 10px;">
                <button type="button" id="btn_employee_type_add" class="btn bg-teal-400 font-weight-semibold">
                    <i class="icon-floppy-disk mr-1"></i> Save Employee Type
                </button>
                <button type="button" id="btn_employee_type_edit" class="btn bg-warning-400 font-weight-semibold" style="display:none;">
                    <i class="icon-database-edit2 mr-1"></i> Update
                </button>
                <button type="button" id="btn_employee_type_new" class="btn btn-light font-weight-semibold" style="display:none;">
                    <i class="icon-reload-alt mr-1"></i> New
                </button>
            </div>
        </div>
    </div>
</div>

<!-- List of Employee Types Card -->
<div class="row">
    <div class="card col-md-12">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-semibold"><i class="icon-list mr-2"></i> Configured Employee Types</h5>
        </div>

        <div class="card-body" style="overflow: auto;">
            <table class="table datatable-selection-single table-hover" id="list_of_employee_types" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Employee Type Name</th>
                        <th>Description</th>
                        <th>Assigned Count</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
