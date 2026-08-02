<div class="row classExpertiseModify">
    <div class="card col-md-12">
        <?PHP
					
						include('template/card_head_control.inc');
					
					?>
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <span class="form-text text-muted font-weight-bold" style="color: black;"><font color="black">Expertise</font></span>
                                    <input type="hidden" class="form-control" id="txt_exp_id" />
                                    <input type="text" class="form-control" id="txt_exp_name" placeholder="Expertise" />
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 30px;">
                                    <!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
                                    <button type="button" id="btn_expertise_add" class="btn btn-primary">
                                        <b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save
                                    </button>

                                    <button type="button" id="btn_expertise_edit" class="btn btn-danger">
                                        <b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update
                                    </button>
                                    <button type="button" id="btn_expertise_new" class="btn btn-primary">
                                        <b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="card-footer">-->
                <!--			<div class="row">-->
                <!--					<div class="col-lg-6 col-md-6 col-sm-12">-->
                <!--					    </div>-->

                <!--								<div class="col-lg-6 col-md-6 col-sm-12">-->
                <!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
                <!--									<button type="button" id="btn_expertise_add" class="btn btn-primary " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>-->

                <!--									<button type="button" id="btn_expertise_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>-->
                <!--									<button type="button" id="btn_expertise_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>-->
                <!--								</div>-->

                <!--			</div>-->
                <!--</div>-->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card col-md-12">
        <!-- Single row selection -->
        <div class="" style="overflow: auto;">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">List of Expertises</h5>
                <div class="header-elements"></div>
            </div>

            <table class="table datatable-selection-single" id="list_of_expertise">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>ID</th>
                        <th>Expertise</th>
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
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /single row selection -->
    </div>
</div>
