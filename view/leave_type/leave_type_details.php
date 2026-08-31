<div class="row">
    <div class="card col-md-12">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-semibold"><i class="icon-color-sampler mr-2"></i> Leave Type Master</h5>
        </div>

        <div class="card-body">
            <input type="hidden" id="txt_leave_type_id" />

            <div class="row">
                <!-- Leave Type Name -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="font-weight-semibold text-muted">Leave Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="txt_leave_type_name" placeholder="e.g. Sick Leave, Maternity Leave" />
                    </div>
                </div>

                <!-- Leave Type Color Picker -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="font-weight-semibold text-muted">Leave Color Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <input type="color" id="input_leave_type_color" value="#26a69a" class="form-control p-1" style="width: 45px; height: 38px; cursor: pointer;" />
                            </div>
                            <input type="text" class="form-control" id="txt_leave_type_color_hex" value="#26a69a" placeholder="#26a69a" />
                            <div class="input-group-append">
                                <span class="input-group-text p-1">
                                    <span id="color_preview_badge" style="display:inline-block; width: 22px; height: 22px; border-radius: 4px; background-color: #26a69a;"></span>
                                </span>
                            </div>
                        </div>
                        <!-- Preset Color Quick Palette -->
                        <div class="mt-1 d-flex flex-wrap" style="gap: 5px;">
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#ef5350" style="background-color:#ef5350; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Coral Red"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#42a5f5" style="background-color:#42a5f5; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Sky Blue"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#66bb6a" style="background-color:#66bb6a; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Emerald Green"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#ffa726" style="background-color:#ffa726; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Amber Orange"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#ab47bc" style="background-color:#ab47bc; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Purple"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#26a69a" style="background-color:#26a69a; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Teal"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#ec407a" style="background-color:#ec407a; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Pink"></button>
                            <button type="button" class="btn btn-sm p-0 preset-color-btn" data-color="#78909c" style="background-color:#78909c; width:20px; height:20px; border-radius:3px; border:1px solid #fff;" title="Blue Grey"></button>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label class="font-weight-semibold text-muted">Description / Notes</label>
                        <input type="text" class="form-control" id="txt_leave_type_description" placeholder="Brief description of leave policy" />
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-2" style="gap: 10px;">
                <button type="button" id="btn_leave_type_add" class="btn bg-teal-400 font-weight-semibold">
                    <i class="icon-floppy-disk mr-1"></i> Save Leave Type
                </button>
                <button type="button" id="btn_leave_type_edit" class="btn bg-warning-400 font-weight-semibold" style="display:none;">
                    <i class="icon-database-edit2 mr-1"></i> Update
                </button>
                <button type="button" id="btn_leave_type_new" class="btn btn-light font-weight-semibold" style="display:none;">
                    <i class="icon-reload-alt mr-1"></i> New
                </button>
            </div>
        </div>
    </div>
</div>

<!-- List of Leave Types Card -->
<div class="row">
    <div class="card col-md-12">
        <div class="card-header header-elements-inline">
            <h5 class="card-title font-weight-semibold"><i class="icon-list mr-2"></i> Configured Leave Types</h5>
        </div>

        <div class="card-body" style="overflow: auto;">
            <table class="table datatable-selection-single table-hover" id="list_of_leave_types" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>ID</th>
                        <th>Leave Type</th>
                        <th>Color</th>
                        <th>Description</th>
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
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
