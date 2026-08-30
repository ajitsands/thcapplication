
<?PHP 
    include_once(__DIR__ . '/../../model/db_connection/connection.php');
    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
   	$result = mysqli_query($varDBConnection,"Select customer_id,customer_name from tbl_customers ");
   	$result_category = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
?>

<div class="content">
   <div class="card shadow-sm border-0">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="icon-stats-bars2 mr-2 text-primary"></i>
            Work Order Analytics Dashboard
        </h5>

    </div>

    <div class="card-body">

        <!-- Main Filters -->
        <div class="row">

    <div class="col-lg-2 col-md-6 mb-3">
        <label><strong>Filter From</strong></label>
        <input type="date" id="startDate" class="form-control">
    </div>

    <div class="col-lg-2 col-md-6 mb-3">
        <label><strong>Filter To</strong></label>
        <input type="date" id="endDate" class="form-control">
    </div>

    <div class="col-lg-4 col-md-12 mb-3">
        <label><strong>Customer</strong></label>
        <select id="select_customer" class="form-control form-control-select2">
            <option value="All">All Customers</option>

            <?php while($row=mysqli_fetch_assoc($result)){ ?>
                <option value="<?php echo $row['customer_id']; ?>">
                    <?php echo $row['customer_name']; ?>
                </option>
            <?php } ?>

        </select>
    </div>
    <div class="col-lg-2 col-md-6 mb-3">
        <label><strong>Service Request</strong></label>
        <select class="form-control form-control-select2" id="sel_service_request">
            <option>All</option>
            <option>Hard FM</option>
            <option>Soft FM</option>
            <option>Others</option>
        </select>
    </div>
 <div class="col-lg-2 col-md-6 mb-3">
        <label><strong>Priority</strong></label>
        <select class="form-control form-control-select2" id="sel_ticket_priority">
            <option>All</option>
            <option>Emergency</option>
            <option>Urgent</option>
            <option>Normal</option>
        </select>
    </div>
</div>

<div class="row align-items-end">

    

   

    <div class="col-lg-4 col-md-6 mb-3" id="div_category_select">
        <label><strong>Category</strong></label>
         <select class="form-control form-control-select2 " id="select_category" name="select_category" data-placeholder="Select Category">
        	    <option value="All" selected>All</option>
        	    
        	    <?PHP 	while($row_category=mysqli_fetch_assoc($result_category)) { ?>
        	    <option value="<?PHP echo $row_category['category_id']; ?>" ><?PHP echo $row_category['category_name']; ?></option>
                <?PHP } ?>
              </select>
        </div>
    
    <div class="col-lg-2 col-md-6 mb-3">
        <label><strong>Status</strong></label>
        <select class="form-control form-control-select2" id="sel_status">
            <option>All</option>
            <option>Pending</option>
            <option>Completed</option>
            <option>Closed</option>
        </select>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">

        <button type="button" class="btn btn-search mr-2 btn-ladda btn-ladda-spinner" data-style="zoom-in" data-spinner-color="#fff" data-spinner-size="20" id="btn_search">
        <span class="ladda-label"><i class="icon-search4"></i> Search</span>
    </button>



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

        <!-- Tabs Header Bar with Right-Aligned Export Button -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-0 pb-0 border-bottom">
            <ul class="nav nav-pills thc-nav-pills mb-0" id="workorderTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#ppm">
                        <i class="icon-calendar3 mr-2"></i> PPM
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#reactive">
                        <i class="icon-hammer-wrench mr-2"></i> Reactive
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#other">
                        <i class="icon-stack2 mr-2"></i> Other
                    </a>
                </li>
            </ul>

            <div class="tab-export-actions ml-auto">
                <button class="btn btn-export-excel tab-export-btn" id="btnExportPPM">
                    <i class="icon-file-excel mr-1"></i> EXPORT TO EXCEL
                </button>
                <button class="btn btn-export-excel tab-export-btn d-none" id="btnExportReactive" style="display: none !important;">
                    <i class="icon-file-excel mr-1"></i> EXPORT TO EXCEL
                </button>
                <button class="btn btn-export-excel tab-export-btn d-none" id="btnExportOther" style="display: none !important;">
                    <i class="icon-file-excel mr-1"></i> EXPORT TO EXCEL
                </button>
            </div>
        </div>

        <div class="tab-content">

            <!-- PPM -->
            <div class="tab-pane fade show active" id="ppm">
                <div class="table-responsive">
                    <table id="tbl_ppm_list" 
                           class="table table-bordered table-striped table-hover">
        
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Work Order No.</th>
                                <th>Date</th>
                                <th>Slot</th>
                                <th>Customer & Facility</th>
                                <th>Status</th>
                                <th>Complaint Description</th>
                                <th>Request</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Technician Remarks</th>
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
                    <table id="tbl_reactive_list" 
                           class="table table-bordered table-striped table-hover">
        
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Work Order No.</th>
                                <th>Date</th>
                                <th>Slot</th>
                                <th>Customer & Facility</th>
                                <th>Status</th>
                                <th>Complaint Description</th>
                                <th>Request</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Technician Remarks</th>
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
                    <table id="tbl_other_list" 
                           class="table table-bordered table-striped table-hover">
        
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Work Order No.</th>
                                <th>Date</th>
                                <th>Slot</th>
                                <th>Customer & Facility</th>
                                <th>Status</th>
                                <th>Complaint Description</th>
                                <th>Request</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Technician Remarks</th>
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

</div>

<script>
$(document).ready(function(){
    function updateExportButtonVisibility() {
        var activeTab = $('#workorderTabs a.active').attr("href");
        $('.tab-export-btn').addClass('d-none').attr('style', 'display: none !important;');
        if (activeTab === '#ppm') {
            $('#btnExportPPM').removeClass('d-none').removeAttr('style');
        } else if (activeTab === '#reactive') {
            $('#btnExportReactive').removeClass('d-none').removeAttr('style');
        } else if (activeTab === '#other') {
            $('#btnExportOther').removeClass('d-none').removeAttr('style');
        }
    }
    
    // Initial check
    updateExportButtonVisibility();

    // On tab switch
    $('#workorderTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        updateExportButtonVisibility();
    });
});
</script>

