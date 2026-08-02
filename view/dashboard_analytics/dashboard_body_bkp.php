
<?PHP 
    include_once "../model/db_connection/connection.php" ;
    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
   	$result = mysqli_query($varDBConnection,"Select customer_id,customer_name from tbl_customers ");
?>

<div class="content">
   <div class="card shadow-sm border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="icon-stats-bars2 mr-2"></i>
            Work Order Analytics Dashboard
        </h5>

    </div>

    <div class="card-body">

        <!-- Main Filters -->
        <div class="row align-items-end">

            <div class="col-lg-2">
                <label><b>Filter From</b></label>
                <input type="date" id="startDate" class="form-control">
            </div>

            <div class="col-lg-2">
                <label><b>Filter To</b></label>
                <input type="date" id="endDate" class="form-control">
            </div>

            <div class="col-lg-4">
                <label><b>Customer</b></label>

                <select id="select_customer"
                        class="form-control form-control-select2">

                    <option value="All">All Customers</option>

                    <?php while($row=mysqli_fetch_assoc($result)){ ?>

                    <option value="<?php echo $row['customer_id']; ?>">

                        <?php echo $row['customer_name']; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <div class="col-lg-4 text-right">

                <button class="btn bg-info" id="btnSearch">
                    <i class="icon-search4"></i>
                    Search
                </button>

                <button class="btn btn-light" id="btnAdvanced">
                    <i class="icon-equalizer2"></i>
                    Advanced Filters for Export
                </button>

                <button class="btn bg-success" id="btnExport">
                    <i class="icon-file-excel"></i>
                    Export
                </button>

            </div>

        </div>

        <!-- Advanced Filters -->

        <div id="advancedFilterPanel" style="display:none;">

            <hr>

            <div class="row">

                <div class="col-lg-3">

                    <label><b>Service Request</b></label>

                    <select class="form-control form-control-select2">

                        <option>All</option>
                        <option>Hard FM</option>
                        <option>Soft FM</option>
                        <option>Others</option>

                    </select>

                </div>

                <div class="col-lg-3">

                    <label><b>Job Category</b></label>

                    <select class="form-control form-control-select2">

                        <option>All</option>
                        <option>PPM</option>
                        <option>Reactive</option>
                        <option>Variable</option>

                    </select>

                </div>

                <div class="col-lg-3">

                    <label><b>Priority</b></label>

                    <select class="form-control form-control-select2">

                        <option>All</option>
                        <option>Emergency</option>
                        <option>Urgent</option>
                        <option>Normal</option>

                    </select>

                </div>

                <div class="col-lg-3">

                    <label><b>Quote</b></label>

                    <select class="form-control form-control-select2">

                        <option>All</option>
                        <option>Quoted</option>
                        <option>Not Quoted</option>

                    </select>

                </div>

            </div>

        </div>

    </div>

</div>
    <br />
    <div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom">
        <h5 class="mb-0">
            <i class="icon-list mr-2 text-primary"></i>
            Work Order List
        </h5>
    </div>

    <div class="card-body">

        <!-- Tabs -->
        <ul class="nav nav-pills nav-fill mb-4" id="workorderTabs">

            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#ppm">
                    <i class="icon-calendar3 mr-2"></i>
                    PPM
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#reactive">
                    <i class="icon-hammer-wrench mr-2"></i>
                    Reactive
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#other">
                    <i class="icon-stack2 mr-2"></i>
                    Other
                </a>
            </li>

        </ul>

        <div class="tab-content">

            <!-- PPM -->
            <div class="tab-pane fade show active" id="ppm">

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tbl_ppm">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>WO No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Details</th>
                            <th>Team</th>
                            <th>Tech Remarks</th>
                            <th>Status</th>
                            
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>

                    </table>
                </div>

            </div>

            <!-- Reactive -->
            <div class="tab-pane fade" id="reactive">

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tbl_reactive">
                        <thead class="bg-success text-white">
                        <tr>
                            <th>WO No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Details</th>
                            <th>Team</th>
                            <th>Tech Remarks</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>

                    </table>
                </div>

            </div>

            <!-- Other -->
            <div class="tab-pane fade" id="other">

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="tbl_other">
                        <thead class="bg-info text-white">
                        <tr>
                             <th>WO No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Details</th>
                            <th>Team</th>
                            <th>Tech Remarks</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    </div>
</div>
<div class="card shadow-sm border-0">
    <div class="card-body py-2">

        <div class="row text-center align-items-center g-0">

            <div class="col border-end">
                <div class="fw-bold text-dark">TOTAL</div>
                <h3 class="text-primary mb-0 font-weight-bold" id="lblTotal">0</h3>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Emergency</div>
                <h5 class="text-danger mb-0" id="lblEmergency">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Urgent</div>
                <h5 class="text-warning mb-0" id="lblUrgent">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Normal</div>
                <h5 class="text-success mb-0" id="lblNormal">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Hard FM</div>
                <h5 class="mb-0" id="lblHardFM">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Soft FM</div>
                <h5 class="mb-0" id="lblSoftFM">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Others</div>
                <h5 class="mb-0" id="lblOthers">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">PPM</div>
                <h5 class="text-info mb-0" id="lblPPM">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Reactive</div>
                <h5 class="text-primary mb-0" id="lblReactive">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Variable</div>
                <h5 class="mb-0" id="lblVariable">0</h5>
            </div>

            <div class="col border-end">
                <div class="fw-bold">Quoted</div>
                <h5 class="text-success mb-0" id="lblQuoted">0</h5>
            </div>

            <div class="col">
                <div class="fw-bold">Not Quoted</div>
                <h5 class="text-danger mb-0" id="lblNotQuoted">0</h5>
            </div>

        </div>

    </div>
</div>
<div class="row">
    
<div class="col-lg-6 col-xl-3">

    <div class="card shadow-sm border-0 dashboard-card">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="icon-stack2 mr-2"></i>
                Raised Work Orders
            </h6>

            <span class="badge badge-light text-primary px-3 py-2" id="lblRaisedTotal">0
            </span>
        </div>

        <div class="card-body">

            <small class="text-uppercase text-muted font-weight-bold">
                Priority
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>🔴 Emergency</span>
                <strong id="lblRaisedEmergency">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>🟠 Urgent</span>
                <strong id="lblRaisedUrgent">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>🟢 Normal</span>
                <strong id="lblRaisedNormal">0</strong>
            </div>

            <hr>
           


            <small class="text-uppercase text-muted font-weight-bold">
                Service Request
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Hard FM</span>
                 <strong id="lblRaisedHardFM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Soft FM</span>
                <strong id="lblRaisedSoftFM">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Others</span>
                <strong id="lblRaisedOthers">0</strong>
            </div>

            <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Job Category
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>PPM</span>
                <strong id="lblRaisedPPM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Reactive</span>
                <strong id="lblRaisedReactive">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Variable</span>
               <strong id="lblRaisedVariable">0</strong>
            </div>
            
             <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Quote
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Quoted </span>
               <strong id="lblRaisedQuoted">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Not Quoted</span>
                <strong id="lblRaisedNotQuoted">0</strong>
            </div>

           
        </div>

    </div>

</div>
<div class="col-lg-6 col-xl-3">

    <div class="card shadow-sm border-0 dashboard-card">

        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="icon-stack2 mr-2"></i>
                Pending Work Orders
            </h6>

            <span class="badge badge-light text-danger px-3 py-2" id="lblPendingTotal">0
            </span>
        </div>

         <div class="card-body">

            <small class="text-uppercase text-muted font-weight-bold">
                Priority
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>🔴 Emergency</span>
                <strong id="lblPendingEmergency">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>🟠 Urgent</span>
                <strong id="lblPendingUrgent">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>🟢 Normal</span>
                <strong id="lblPendingNormal">0</strong>
            </div>

            <hr>
           


            <small class="text-uppercase text-muted font-weight-bold">
                Service Request
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Hard FM</span>
                 <strong id="lblPendingHardFM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Soft FM</span>
                <strong id="lblPendingSoftFM">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Others</span>
                <strong id="lblPendingOthers">0</strong>
            </div>

            <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Job Category
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>PPM</span>
                <strong id="lblPendingPPM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Reactive</span>
                <strong id="lblPendingReactive">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Variable</span>
               <strong id="lblPendingVariable">0</strong>
            </div>
            
             <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Quote
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Quoted </span>
               <strong id="lblPendingQuoted">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Not Quoted</span>
                <strong id="lblPendingNotQuoted">0</strong>
            </div>

           
        </div>

    </div>

</div>
<div class="col-lg-6 col-xl-3">

    <div class="card shadow-sm border-0 dashboard-card">

        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="icon-stack2 mr-2"></i>
                Completed Work Orders
            </h6>

            <span class="badge badge-light text-info px-3 py-2" id="lblCompletedTotal">
                0
            </span>
        </div>

        <div class="card-body">

            <small class="text-uppercase text-muted font-weight-bold">
                Priority
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>🔴 Emergency</span>
                <strong id="lblCompletedEmergency">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>🟠 Urgent</span>
                <strong id="lblCompletedUrgent">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>🟢 Normal</span>
                <strong id="lblCompletedNormal">0</strong>
            </div>

            <hr>
           


            <small class="text-uppercase text-muted font-weight-bold">
                Service Request
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Hard FM</span>
                 <strong id="lblCompletedHardFM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Soft FM</span>
                <strong id="lblCompletedSoftFM">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Others</span>
                <strong id="lblCompletedOthers">0</strong>
            </div>

            <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Job Category
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>PPM</span>
                <strong id="lblCompletedPPM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Reactive</span>
                <strong id="lblCompletedReactive">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Variable</span>
               <strong id="lblCompletedVariable">0</strong>
            </div>
            
             <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Quote
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Quoted </span>
               <strong id="lblCompletedQuoted">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Not Quoted</span>
                <strong id="lblCompletedNotQuoted">0</strong>
            </div>

           
        </div>

    </div>

</div>
<div class="col-lg-6 col-xl-3">

    <div class="card shadow-sm border-0 dashboard-card">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="icon-stack2 mr-2"></i>
                Closed Work Orders
            </h6>

            <span class="badge badge-light text-success px-3 py-2" id="lblClosedTotal">
                0
            </span>
        </div>

        <div class="card-body">

            <small class="text-uppercase text-muted font-weight-bold">
                Priority
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>🔴 Emergency</span>
                <strong id="lblClosedEmergency">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>🟠 Urgent</span>
                <strong id="lblClosedUrgent">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>🟢 Normal</span>
                <strong id="lblClosedNormal">0</strong>
            </div>

            <hr>
           


            <small class="text-uppercase text-muted font-weight-bold">
                Service Request
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Hard FM</span>
                 <strong id="lblClosedHardFM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Soft FM</span>
                <strong id="lblClosedSoftFM">0</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Others</span>
                <strong id="lblClosedOthers">0</strong>
            </div>

            <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Job Category
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>PPM</span>
                <strong id="lblClosedPPM">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Reactive</span>
                <strong id="lblClosedReactive">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Variable</span>
               <strong id="lblClosedVariable">0</strong>
            </div>
            
             <hr>

            <small class="text-uppercase text-muted font-weight-bold">
                Quote
            </small>

            <div class="d-flex justify-content-between mt-2">
                <span>Quoted </span>
               <strong id="lblClosedQuoted">0</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Not Quoted</span>
                <strong id="lblClosedNotQuoted">0</strong>
            </div>

           
        </div>

    </div>

</div>
</div>
</div>

