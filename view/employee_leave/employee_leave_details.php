<style>
    input[type='file'] {
        width: 95px;
    }
</style>

<div class="row">
    <!-- 4 Columns: Add Employee Leave Form -->
    <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title font-weight-semibold"><i class="icon-user-plus mr-2"></i> Add Employee Leave</h6>
            </div>

            <div class="card-body">
                <div class="form-group" id="div_employee_select">
                    <?PHP include_once("employee_leave/employee_combo.php");?>
                </div>

                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">Start Date <span style="color:red;">*</span></font></span> 
                    <input class="form-control" type="datetime-local" name="date" id="txt_leave_from_date">
                </div>

                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">End Date <span style="color:red;">*</span></font></span>
                    <input class="form-control" type="datetime-local" name="number" id="txt_leave_to_date">
                </div>

                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">Type of Leave <span style="color:red;">*</span></font></span> 
                    <select data-placeholder="Select Type of Leave" id="select_type_of_leave" class="form-control form-control-select2" data-fouc>
                        <option value="select">Select </option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Casual Leave">Casual Leave</option>
                        <option value="Annual Leave">Annual Leave</option>
                        <option value="Emergency Leave">Emergency Leave</option>
                        <option value="Privilege Leave">Privilege Leave</option>
                    </select>    
                </div>

                <div class="form-group" id="div_reason_select">
                    <div style="border-bottom: 1px solid #ccc!important;">
                        <span class="form-text text-muted font-weight-bold"><font color="black"> Reason For Leave </font> </span>
                        <select class="form-control select" data-fouc id="select_reason_for_leave" name="select_reason_for_leave">
                            <option value="select">Select </option>
                            <option value="1">Sir, I am not well today. I am Sick</option>
                            <option value="2">I have an dentist appointment</option>
                            <option value="3">Family member is not well</option>
                            <option value="4">Parent’s doctor appointment</option>
                            <option value="5">Virtual relative’s death</option>
                            <option value="6">Stuck in traffic! What to do</option>
                            <option value="7">Adverse House Situations</option>
                            <option value="8">Purchasing important things</option>
                            <option value="9">Bad Weather</option>
                            <option value="10">Relative’s wedding</option>
                            <option value="add_reason">Other Reason</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="div_reason_for_leave" style="display:none;">
                    <span class="form-text text-muted font-weight-bold"><font color="black"> If others, specify the reason for leave</font> </span>
                    <input type="text" class="form-control form-control-sm" placeholder="" id="txt_reason_for_leave" >
                </div>
            </div>

            <div class="card-footer">
                <button type="button" id="btn_employee_leave_add" class="btn bg-teal-400 btn-block" ><b><i class="icon-floppy-disk mr-2"></i></b> Save Employee Leave</button>
                <button type="button" id="btn_employee_edit" class="btn bg-warning-400 btn-block" style="display:none"><b><i class="icon-database-edit2 mr-2"></i></b> Update</button>
                <button type="button" id="btn_employee_new" class="btn btn-primary btn-block" style="display:none"><b><i class="icon-book mr-2"></i></b> New</button>
            </div>
        </div>
    </div>

    <!-- 8 Columns: Calendar View -->
    <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title font-weight-semibold"><i class="icon-calendar3 mr-2"></i> Leave Calendar Schedule</h6>
            </div>
            <div class="card-body">
                <div id="leave_calendar_inline"></div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom: DataTable List of Employees On Leave with Excel Export -->
<div class="card mt-3" style="overflow:auto;">
    <div class="card-header header-elements-inline">
        <h5 class="card-title font-weight-semibold"><i class="icon-list mr-2"></i> List of Employees On Leave</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table datatable-selection-single" id="list_of_employees_on_leave" style="width: 100%;">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Emp. Code</th>
                    <th>Emp. Name</th>
                    <th>Leave Reason</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
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