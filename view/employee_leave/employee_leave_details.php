<?PHP
if (!isset($varDBConnection)) {
    include_once(__DIR__ . '/../../model/db_connection/connection.php');
    $DBConnLT = new DBConnection();
    $varDBConnection = $DBConnLT->ConnectToMYSQL();
}
$lt_query = mysqli_query($varDBConnection, "SELECT leave_type_id, leave_type_name, leave_type_color FROM tbl_leave_types WHERE leave_type_status='Active' ORDER BY leave_type_id ASC");
$leave_types_list = array();
if ($lt_query && mysqli_num_rows($lt_query) > 0) {
    while ($lt_row = mysqli_fetch_assoc($lt_query)) {
        $leave_types_list[] = $lt_row;
    }
} else {
    // Fallback defaults if table is freshly migrating
    $leave_types_list = array(
        array('leave_type_name' => 'Sick Leave', 'leave_type_color' => '#ef5350'),
        array('leave_type_name' => 'Casual Leave', 'leave_type_color' => '#42a5f5'),
        array('leave_type_name' => 'Annual Leave', 'leave_type_color' => '#66bb6a'),
        array('leave_type_name' => 'Emergency Leave', 'leave_type_color' => '#ffa726'),
        array('leave_type_name' => 'Privilege Leave', 'leave_type_color' => '#ab47bc')
    );
}
?>
<style>
    input[type='file'] {
        width: 95px;
    }
    #list_of_employees_on_leave_wrapper .datatable-header {
        padding: 12px 18px 8px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    #list_of_employees_on_leave_wrapper .datatable-header .dataTables_filter {
        margin: 0;
    }
    #list_of_employees_on_leave_wrapper .datatable-header .dt-buttons {
        margin: 0;
    }
    #list_of_employees_on_leave_wrapper .datatable-header .dataTables_length {
        margin: 0 0 0 auto !important;
        float: right !important;
        display: flex;
        align-items: center;
    }
    #list_of_employees_on_leave_wrapper .datatable-header .dataTables_length label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin: 0;
        font-weight: 500;
        color: #555;
    }
    #list_of_employees_on_leave_wrapper .datatable-header .dataTables_length select {
        width: auto !important;
        min-width: 60px;
        display: inline-block;
        padding: 4px 8px;
        margin: 0 4px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    #list_of_employees_on_leave_wrapper .datatable-footer {
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid #f0f0f0;
    }
    #list_of_employees_on_leave_wrapper .dataTables_info {
        font-size: 13px;
        color: #666;
        font-weight: 500;
        margin: 0;
        padding: 0;
    }
    #list_of_employees_on_leave_wrapper .dataTables_paginate {
        margin: 0 0 0 auto;
        text-align: right;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    #list_of_employees_on_leave_wrapper .dataTables_paginate .paginate_button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        margin: 0 2px;
        border-radius: 4px;
        border: 1px solid #ddd;
        background: #fff;
        color: #333 !important;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.15s ease;
    }
    #list_of_employees_on_leave_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f0f0f0 !important;
        border-color: #ccc !important;
        color: #333 !important;
    }
    #list_of_employees_on_leave_wrapper .dataTables_paginate .paginate_button.current,
    #list_of_employees_on_leave_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #26a69a !important;
        border-color: #26a69a !important;
        color: #fff !important;
        font-weight: bold;
    }
    #list_of_employees_on_leave_wrapper .dataTables_paginate .paginate_button.disabled,
    #list_of_employees_on_leave_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #bbb !important;
        background: #fbfbfb !important;
        border-color: #eee !important;
        cursor: not-allowed;
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
                        <option value="select">Select Type of Leave</option>
                        <?PHP foreach ($leave_types_list as $lt) { ?>
                            <option value="<?PHP echo htmlspecialchars($lt['leave_type_name']); ?>"><?PHP echo htmlspecialchars($lt['leave_type_name']); ?></option>
                        <?PHP } ?>
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

        <!-- Filter Card below Add Employee Leave -->
        <div class="card mt-3">
            <div class="card-header header-elements-inline">
                <h6 class="card-title font-weight-semibold"><i class="icon-filter3 mr-2"></i> Filter Leave Records</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">Employee Category / Type</font></span>
                    <select id="select_filter_emp_type" class="form-control select">
                        <option value="all">All Categories</option>
                        <?PHP
                        if (!isset($varDBConnection)) {
                            include_once(__DIR__ . '/../../model/db_connection/connection.php');
                            $DBConnFilter = new DBConnection();
                            $varDBConnFilter = $DBConnFilter->ConnectToMYSQL();
                        } else {
                            $varDBConnFilter = $varDBConnection;
                        }
                        $res_types = mysqli_query($varDBConnFilter, "SELECT user_type_id, user_type_name FROM tbl_user_types WHERE user_type_status='Active'");
                        if ($res_types) {
                            while ($r_type = mysqli_fetch_assoc($res_types)) {
                                echo '<option value="' . $r_type['user_type_id'] . '">' . htmlspecialchars($r_type['user_type_name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">Leave Type</font></span>
                    <select id="select_filter_leave_type" class="form-control select">
                        <option value="all">All Leave Types</option>
                        <?PHP foreach ($leave_types_list as $lt) { ?>
                            <option value="<?PHP echo htmlspecialchars($lt['leave_type_name']); ?>"><?PHP echo htmlspecialchars($lt['leave_type_name']); ?></option>
                        <?PHP } ?>
                    </select>
                </div>

                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">From Date</font></span>
                    <input class="form-control" type="date" id="txt_filter_from_date">
                </div>

                <div class="form-group">
                    <span class="form-text text-muted font-weight-bold"><font color="black">To Date</font></span>
                    <input class="form-control" type="date" id="txt_filter_to_date">
                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <button type="button" id="btn_apply_leave_filter" class="btn bg-teal-400 btn-block"><b><i class="icon-search4 mr-1"></i></b> Filter</button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="btn_reset_leave_filter" class="btn btn-light btn-block"><b><i class="icon-reload-alt mr-1"></i></b> Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 8 Columns: Calendar View -->
    <div class="col-lg-8 col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header header-elements-inline pb-2">
                <h6 class="card-title font-weight-semibold"><i class="icon-calendar3 mr-2"></i> Leave Calendar Schedule</h6>
            </div>
            <div class="card-body">
                <!-- Color Code Legend -->
                <div class="d-flex flex-wrap align-items-center mb-3 pb-2" style="gap: 8px; border-bottom: 1px solid #eee;">
                    <span class="font-weight-semibold text-muted mr-1" style="font-size: 12px;"><i class="icon-color-sampler mr-1"></i> Color Code:</span>
                    <?PHP foreach ($leave_types_list as $lt) { 
                        $col = !empty($lt['leave_type_color']) ? $lt['leave_type_color'] : '#26a69a';
                    ?>
                        <span class="badge badge-pill text-white px-2 py-1" style="background-color: <?PHP echo $col; ?>; font-size: 11px; font-weight: 500;"><i class="icon-primitive-dot mr-1"></i><?PHP echo htmlspecialchars($lt['leave_type_name']); ?></span>
                    <?PHP } ?>
                </div>
                <div id="leave_calendar_inline"></div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom: DataTable List of Employees On Leave with Excel Export -->
<div class="card mt-3">
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
                    <th>Emp. Type</th>
                    <th>Leave Type</th>
                    <th>Leave Reason</th>
                    <th>Start Date</th>
                    <th>End Date</th>
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
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>