<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
    }
    input[type='file'] {
        width: 95px;
    }
</style>

<div class="card">
    <div class="card-body" style="overflow:auto;">
        
<h6 class="font-weight-semibold text-primary mb-2 mt-2"><i class="icon-wrench3 mr-2"></i>1. Configure Services</h6>
        <div class="p-3 bg-light border rounded mb-3">
            <div class="form-group row mb-2">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3" id="div_cate_select">
                    <label class="font-weight-semibold text-muted mb-1">Category <span class="text-danger">*</span></label>
                    <select class="form-control select-search" id="select_category" data-placeholder="Select Category" data-fouc>
                        <option value="0">Select Category</option>
                        <?PHP 
                        include(__DIR__ . '/../../model/db_connection/connection.php');
                        $DBConn = new DBConnection();
                        $varDBConnection = $DBConn->ConnectToMYSQL();
                        $result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
                        while($row=mysqli_fetch_assoc($result)) { ?>
                          <option value="<?PHP echo $row['category_id']; ?>"><?PHP echo $row['category_name']; ?></option>
                        <?PHP } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-3" id="div_assettype_select"></div>
            </div>
            
            <div class="table-responsive bg-white border rounded">
                <table class="table datatable-selection-multiple" id="list_of_services">
                    <thead class="bg-light">
                        <tr>
                            <th width="10%">#</th>
                            <th>Services</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <h6 class="font-weight-semibold text-primary mb-1 mt-4"><i class="icon-list2 mr-2"></i>2. Select Work Orders</h6>
        <div class="table-responsive mb-2">
            <table class="table datatable-selection-multiple" id="list_of_amc_schedules">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>WO.Ref.No.</th>
                        <th>Asset Code</th>
                        <th>Date</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
        <div class="row mt-3"> 
            <div class="col-12 text-right">
                <button type="button" class="btn btn-primary btn-sm" id="btn_amc_assign_services">
                    <i class="icon-checkmark4 mr-2"></i>Assign Services
                </button>		
            </div>
        </div>
        
    </div>
</div>
<script>
$(document).ready(function() {
    $('#select_category').select2({
        minimumResultsForSearch: 0
    });
});
</script>