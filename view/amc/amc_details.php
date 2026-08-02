<div class="card">
    <div class="card-body">
        <form id="amc_form">
            <div class="form-group row">
                <div class="col-lg-2 col-md-2 col-sm-12" style="display: none;">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Number&nbsp;</font></span>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg text-center" id="txt_amc_number" name="amc_ref_no" align="center" disabled />
                        <div class="form-control-feedback form-control-feedback-lg">
                            <i class="icon-sun3"></i>
                        </div>
                    </div>
                </div>

                <?PHP include_once("customer_combo.php");?>
                <div class="col-lg-1 col-md-1 col-sm-1" style="padding-top: 5px;">
                    <button type="button" class="btn btn-primary btn-sm" id="bootbox_customer">+</button>
                </div>
                <?PHP include_once("contract_type_combo.php");?>

                <div class="col-lg-1 col-md-1 col-sm-1" style="padding-top: 5px;">
                    <button type="button" class="btn btn-primary btn-sm" id="contract_type_add_modal">+</button>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold">
                        <font color="black">AMC Signed Date &nbsp;<span style="color: red;">*</span></font>
                    </span>
                    <div class="input-group">
                        <input type="text" class="form-control daterange-single" value="<?PHP echo date('%m-%d-%Y');?>" id="txt_amc_signed_date" name="amc_signed_date" tabindex="3" />
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                    </div>
                </div>

                <!--</div>-->

                <!--<div class="form-group row">-->

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold">
                        <font color="black">AMC Start & End Date&nbsp;<span style="color: red;">*</span></font>
                    </span>
                    <div class="input-group">
                        <input type="text" id="txt_amc_start_end_date" name="amc_start_end_date" class="form-control daterange-basic" value="<?PHP echo date('%m-%d-%Y');?>
                        -
                        <?PHP echo date("%m-%d-%Y", strtotime("+1 years"));?>" tabindex=4>

                        <span class="input-group-append">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <span class="form-text text-muted font-weight-bold">
                        <font color="black">AMC Amount&nbsp;<span style="color: red;">*</span></font>
                    </span>
                    <div class="input-group">
                        <input
                            type="text"
                            id="txt_amc_amount"
                            name="amc_amount"
                            class="form-control form-control-lg"
                            placeholder="AMC Amount"
                            onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)"
                            onpaste="return false"
                            autocomplete="off"
                            tabindex="5"
                        />
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <span class="form-text text-muted font-weight-bold">
                        <font color="black">Total AMC Amount&nbsp;<span style="color: red;">*</span></font>
                    </span>
                    <div class="input-group">
                        <input
                            type="text"
                            id="txt_total_amc_amount"
                            name="total_amc_amount"
                            class="form-control form-control-lg"
                            placeholder="Total AMC Amount"
                            autocomplete="off"
                            tabindex="5"
                            disabled
                        />
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12">
                    <span class="form-text text-muted font-weight-bold">
                        <font color="black">VAT % &nbsp;<span style="color: red;">*</span></font>
                    </span>
                    <div class="input-group">
                        <input type="text" id="txt_vat_percentage" name="vat_percentage" class="form-control form-control-lg" placeholder="VAT %" autocomplete="off" tabindex="6" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <span class="form-text text-muted font-weight-bold">
                        <font color="black">VAT Amount&nbsp;<span style="color: red;">*</span></font>
                    </span>
                    <div class="input-group">
                        <input type="text" id="txt_amc_vat_amount" name="amc_vat_amount" class="form-control form-control-lg" placeholder="VAT Amount" autocomplete="off" disabled tabindex="7" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Description</font></span>
                    <textarea rows="1" class="form-control elastic" placeholder="Description" id="txt_amc_description" name="amc_description" tabindex="8"></textarea>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 20px;">
                    <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" name="" id="custom_checkbox_inline_right_checked" checked tabindex="9" />
                        <label class="custom-control-label position-static font-weight-bold" for="custom_checkbox_inline_right_checked">Request for proposal –Yes/No </label>
                    </div>
                </div>

                <!--</div>-->

                <!--			<div class="form-group row">-->
            </div>

            <div class="form-group row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment1&nbsp;</font></span>
                    <input type="file" class="form-input-styled" id="first_attachment" name="amc_first_attachment" accept="image/*" title="&nbsp;" data-fouc=""/ tabindex=10>
                    <p id="emp_img_name"></p>

                    <span id="first_image_name" style="width: 40px; height: 40px; padding-top: 5px;"></span>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div id="img_attachment1_preview" style="width: 40px; height: 40px; padding-top: 5px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment1 Description&nbsp;</font></span>
                    <textarea rows="1" class="form-control elastic" id="txt_first_attachment_desc" name="amc_first_attachment_desc" placeholder="Description" tabindex="11"></textarea>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment2&nbsp;</font></span>
                    <input type="file" class="form-input-styled" id="second_attachment" name="amc_second_attachment" accept="image/*" title="&nbsp;" data-fouc=""/ tabindex=12>
                    <p id="emp_img_name"></p>
                    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
                    <span id="second_image_name" style="width: 40px; height: 40px; padding-top: 5px;"></span>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div id="img_attachment2_preview" style="width: 40px; height: 40px; padding-top: 5px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment2 Description&nbsp;</font></span>
                    <textarea rows="1" class="form-control elastic" id="txt_sec_attachment_desc" name="amc_second_attachment_desc" placeholder="Description" tabindex="13"></textarea>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment3 &nbsp;</font></span>
                    <input type="file" class="form-input-styled" id="third_attachment" name="amc_third_attachment" accept="image/*" title="&nbsp;" data-fouc=""/ tabindex=14>
                    <p id="emp_img_name"></p>
                    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
                    <span id="thrid_image_name" style="width: 40px; height: 40px; padding-top: 5px;"></span>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12">
                    <div id="img_attachment3_preview" style="width: 40px; height: 40px; padding-top: 5px;"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment3 Description&nbsp;</font></span>
                    <textarea rows="1" class="form-control elastic" id="txt_third_attachment_desc" name="amc_third_attachment_desc" placeholder="Description" tabindex="15"></textarea>
                </div>
            </div>
        </form>

        <div id="update"></div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12" style="text-align: right;">
                <!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
                <button type="button" id="btn_amc_add" class="btn bg-teal-400">
                    <b><i class="icon-floppy-disk" tabindex="16"></i></b>&nbsp;&nbsp;&nbsp;Save
                </button>

                <button type="button" id="btn_amc_edit" class="btn bg-warning-400">
                    <b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update
                </button>
                <button type="button" id="btn_amc_new" class="btn btn-primary">
                    <b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New
                </button>
            </div>
        </div>
    </div>

    <!-- AMC CUSTOMER ADD -->
    <!-- AMC CUSTOMER ADD -->
    <div id="add_new_customer_amc" class="modal fade" data-backdrop="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold">
                                            <font color="black">Customer Name &nbsp;<span style="color: red;">*</span></font>
                                        </span>
                                        <input type="text" class="form-control" id="txt_customer_name" placeholder="Customer Name" />

                                        <input type="hidden" class="form-control" id="txt_customer_id" />
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;">
                                            <font color="black">Contact Number &nbsp;<span style="color: red;">*</span></font>
                                        </span>
                                        <input type="text" class="form-control" id="txt_customer_contact_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" placeholder="Contact Number" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;">
                                            <font color="black">CPR/CR Number &nbsp;<span style="color: red;">*</span></font>
                                        </span>
                                        <input type="text" class="form-control text-uppercase" id="txt_cpr_cr_number" placeholder="CPR/CR Number" />
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;"><font color="black">Email Id</font></span>
                                        <input type="text" class="form-control" id="txt_customer_email_id" placeholder="Email Id" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;"><font color="black">VAT Number</font></span>
                                        <input type="text" class="form-control" id="txt_vat_number" placeholder="VAT Number" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold"><font color="black">Address </font></span>
                                        <textarea rows="1" class="form-control" id="txt_customer_address" placeholder="Address"></textarea>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;">
                                            <font color="black">PO Box &nbsp;<span style="color: red;">*</span></font>
                                        </span>
                                        <input type="text" class="form-control" id="txt_customer_po_box" placeholder="PO Box" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;">
                                            <font color="black">Customer Location &nbsp;<span style="color: red;">*</span></font>
                                        </span>
                                        <input type="text" class="form-control" id="txt_customer_location" placeholder="Customer Location" />
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;"><font color="black">Contact Person Name</font></span>
                                        <input type="text" class="form-control" id="txt_contact_person" placeholder="Contact Person Name" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold" style="color: black;"><font color="black">Contact Person Number</font></span>
                                        <input type="text" class="form-control" id="txt_contact_person_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" placeholder="Contact Person Number" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <span class="form-text text-muted font-weight-bold"><font color="black">Any Other Details </font></span>
                                        <textarea cols="1" class="form-control" id="txt_description" placeholder="Any Other Details"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-primary" id="btn_customer_add">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /AMC CUSTOMER ADD -->
    <!--contract Type Modal-->
    <div id="add_new_contract_type_amc" class="modal fade" data-backdrop="false" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title">Add Contract Type</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <span class="form-text text-muted font-weight-bold">
                                        <font color="black">Contract Type &nbsp;<span style="color: red;">*</span></font>
                                    </span>
                                    <input type="text" class="form-control" id="txt_contract_name" placeholder="Contract Type" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn bg-primary" id="btn_contract_type_add">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!--end contract type modal-->
</div>
