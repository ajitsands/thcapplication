<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            VISIT CALENDER &nbsp;&nbsp;
            <b>
                <span style="color: #39c0ed;">[Scheduled] </span> - <span style="color: #3f51b5;">[Assigned]</span> - <span style="color: #795548;">[Completed]</span> - <span style="color: #4caf50;">[Closed]</span> -
                <span style="color: #b23cfd;">[Cancelled]</span> - <span style="color: #ffc107;">[Extended]</span>
            </b>
        </h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="fullcalendar-basic" id="calendar"></div>
    </div>
    <div id="popoverContent" class="hide click_me" style="width: 100%;">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title" id="title_head" style="text-align: center;">Visit Details</h3>
                <p><span class="badge bg-indigo-400 badge-pill ml-auto" id="cust_name"></span></p>
                <br />
                <span class="badge bg-pink-400 ml-auto" id="ticket_priority"></span>
                <span class="badge bg-voilet-400 ml-auto" id="service_request"></span>
                <span class="badge bg-orange-400 ml-auto" id="job_category"></span>

                <!--	<span class="badge bg-pink-400 ml-auto" id="time_slots"></span>
								    <div id="div_add_time_slots">
								        
								    </div>
								<?php
								
								//for(i=0;i<=add_slots_count;i++)
								//{ ?>
								   <!--<span class="badge bg-pink-400 ml-auto" id="time_slots"></span> -->
                <?php //}
								
								?>
            </div>

            <ul class="list-group list-group-flush border-top">
                <input type="text" id="txt_visit_id_hidden" placeholder=" " />
                <input type="text" id="txt_tkt_amc_id_hidden" placeholder=" " />
                <input type="text" id="txt_amc_no_hidden" placeholder=" " />
                <input type="text" id="txt_customer_name_hidden" placeholder=" " />
                <input type="text" id="txt_amc_ticket_hidden" placeholder=" " />
                <input type="text" id="txt_additional_slots_hidden" placeholder=" " />

                <input type="hidden" id="txt_tkt_amc_visit_date_hidden" placeholder=" " />
                <input type="hidden" id="txt_tkt_amc_visit_time_hidden" placeholder=" " />
                <input type="hidden" id="txt_tkt_strat_slot_hidden" placeholder=" " />
                <input type="hidden" id="txt_tkt_add_slots_hidden" placeholder=" " />
                <input type="hidden" id="txt_tkt_dt_hidden" placeholder=" " />
                <input type="hidden" id="txt_tkt_dt_val_hidden" placeholder=" " />

                <a href="#" id="btn_view_click" data-toggle="modal" data-target="#modal_change_status" class="list-group-item list-group-item-action">
                    <span class="font-weight-semibold">
                        <i class="icon-grid mr-2"></i>
                        View Details
                    </span>
                </a>
                <a href="#" id="btn_view_team" class="list-group-item list-group-item-action">
                    <span class="font-weight-semibold">
                        <i class="icon-people mr-2"></i>
                        View Team
                    </span>
                </a>

                <li></li>
                <!--<a href="#" class="list-group-item list-group-item-action disabled">-->
                <!--	<span class="font-weight-semibold">-->
                <!--		<i class="icon-transmission mr-2"></i>-->
                <!--		Edit/Cancel Schedule-->
                <!--	</span>-->
                <!--	<span class="badge bg-dark badge-pill ml-auto">40</span>-->
                <!--</a>-->
            </ul>
        </div>
    </div>
</div>
<!--AMC Customer modal -->
<div id="modal_amc_Customer_details" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success" id="div_modal_color">
                <h5 class="modal-title">View Details [<span id="amc_ref_no"></span>]</h5>

                <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Customer Name :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="customer_name_amc"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>AMC Start Date :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="start_date_amc"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>AMC End Date :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="end_date_amc"></span></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Visit Date :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="date_amc"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Slots :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="slots_amc"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Time :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="time_amc"></span></label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <table class="table table-bordered table-hover" id="tbl_amc_asset_list_display_for_schedule" style="padding-right: 10px; padding-left: 10px; border-top: 1px solid #dddddd;">
                        <thead>
                            <tr>
                                <th>#</th>

                                <th>Building</th>
                                <th>Location</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Asset Code</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /Customer modal -->

<!--TKT Customer modal -->
<div id="modal_tkt_Customer_details" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success" id="div_modal_color">
                <h5 class="modal-title">View Details [ <span id="tkt_ref_no"></span> ]</h5>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Customer Name :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="customer_name_tkt"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Visit Date :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="tkt_visit_date"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Visit Time :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="start_date_tkt"></span></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Location :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="location_tkt"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Building :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="building_tkt"></span></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label float-right"><b>Slots :</b></label>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-form-label"><span id="mode_of_visit"></span></label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <table class="table table-bordered table-hover" id="tbl_tkt_asset_list_display_for_schedule" style="padding-right: 10px; padding-left: 10px; border-top: 1px solid #dddddd;">
                        <thead>
                            <tr>
                                <th>#</th>

                                <th>Category</th>
                                <th>Type</th>
                                <th>Complaint</th>
                                <th>Additional Info</th>
                                <th>Asset Code</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /TKT Customer modal -->

<!-- Team modal -->
<div id="modal_team_details" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary" id="div_modal_color">
                <h5 class="modal-title">Team Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover" id="list_of_team_members" style="padding-right: 10px; padding-left: 10px; border-top: 1px solid #dddddd;">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Name</th>
                                <th>Contact Number</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /team modal -->
