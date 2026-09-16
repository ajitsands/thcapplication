<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">AMC Log Details</h5>
            </div>
            <div class="card-body">
                <div class="row form-group"> 
                    <?php include("thc_login/username_combo.php"); ?>
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <label class="font-weight-bold text-dark">Start Date <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" id="amc_start_date" tabindex="" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <label class="font-weight-bold text-dark">End Date <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" id="amc_end_date" tabindex="" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 d-flex align-items-end mt-3 mt-lg-0">
                        <button type="button" id="btn_user_search" class="btn bg-teal-400"><i class="icon-search4 mr-2"></i> Search</button>
                    </div>
                </div>
            </div>	
        </div>
        
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover datatable-highlight" id="tbl_amc_log">
                    <thead>
                        <tr>
                            <th class="text-center">Sl No</th>
                            <th class="text-center">Data</th>
                            <th class="text-center">Event</th>
                            <th class="text-center" style="min-width: 150px;">Date</th>
                            <th class="text-center">AMC No</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">IP Address</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>