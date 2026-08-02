<input type="hidden" value="<?php echo $_GET['amcnumber']; ?>" id="txt_amcnumber" />
<div class="row">
    <div class="card col-md-12">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                AMC Renewal
            </h5>
        </div>

        <!-- Highlighting rows and columns -->
        <div class="card">
            <div class="row" style="margin-left: 10px;">
                <div id="div_tkts_ref_no" class="col-lg-4 col-md-3 col-sm-12">
                    <input type="date" class="form-control" id="txt_end_date" placeholder="End Date" />
                    <span class="form-text text-muted" style="font-size: 12px;"><font color="black">End Date</font></span>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-12">
                    <button type="button" id="btn_amc_renewal_search" class="btn btn-primary" style="height: 40px; width: 100px;"><i class="fa fa-search"></i>SEARCH</button>
                    <button type="button" id="btn_test" class="btn btn-primary" style="height: 40px; width: 100px;"><i class="fa fa-search"></i>Test</button>
                    <span class="form-text text-muted" style="font-size: 16px;"><font color="black"></font></span>
                </div>
                <!--<div class="col-lg-6 col-md-6 col-sm-12 text-right mt-1">
                    <button type="button" id="btn_amcrenewal_excell" class="btn bg-primary legitRipple" tabindex="6" fdprocessedid="zkd5x">EXCEL</button>
                </div>-->
            </div>

            <table style="width: 100%;" class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_renewal_list" style="padding-right: 10px; padding-left: 10px;">
                <thead>
                    <tr>
                        <th>SI No</th> <!--0-->
                        <th>ID</th> <!--1-->
                        <th>AMC NO</th> <!--2-->
                        <th>AMC No</th> <!--3-->
                        <th>QR</th> <!--4-->
                        <th>Customer Name</th> <!--5-->
                        <th>Type</th> <!--6-->
                        <th>Sign Date</th> <!--7-->
                        <th>Start & End Date</th> <!--8-->
                        <th>Status</th> <!--9-->
                        <th class="text-center">Actions</th> <!--10-->
                        
                        <th>Amount</th> <!--11-->
                        <th>VAT %</th> <!--12-->
                        <th>NET Amount</th> <!--13-->
                        <th>Description</th> <!--14-->
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <input type="hidden" id="txt_amc_ref_no" class="form-control" />
        </div>
    </div>
</div>
<!-- /highlighting rows and columns -->

 

<?PHP  include('amc_renew_modal.php') ?>
