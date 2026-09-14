<div class="card">
    <div class="card-body">
        <form id="amc_form">
            <div class="form-group row" style="display: none;">
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <span class="form-text text-muted font-weight-bold"><font color="black">AMC Number&nbsp;</font></span>
                    <div class="input-group">
                        <input type="text" class="form-control text-center" id="txt_amc_number" name="amc_ref_no" align="center" disabled />
                        <div class="form-control-feedback">
                            <i class="icon-sun3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                #contract_details_fieldset .combo-container > div {
                    flex: 1 1 auto;
                    max-width: 100%;
                    padding-right: 0 !important;
                    padding-left: 0 !important;
                }
            </style>
            <fieldset id="contract_details_fieldset" class="mb-3 border p-3 rounded">
                <legend class="text-uppercase font-size-sm font-weight-bold w-auto px-2" style="color: #333;">Contract Details</legend>
                
                <div class="row mb-2">
                    <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-end mb-2 mb-lg-0">
                        <div class="combo-container flex-grow-1">
                            <?PHP include_once("customer_combo.php");?>
                        </div>
                        <div class="ml-2 mb-1">
                            <button type="button" class="btn btn-primary btn-icon rounded-round btn-sm shadow-sm d-flex align-items-center justify-content-center" id="bootbox_customer" style="width: 36px; height: 36px; padding: 0;" title="Add Customer"><i class="icon-plus22"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 d-flex align-items-end mb-2 mb-lg-0">
                        <div class="combo-container flex-grow-1">
                            <?PHP include_once("contract_type_combo.php");?>
                        </div>
                        <div class="ml-2 mb-1">
                            <button type="button" class="btn btn-primary btn-icon rounded-round btn-sm shadow-sm d-flex align-items-center justify-content-center" id="contract_type_add_modal" style="width: 36px; height: 36px; padding: 0;" title="Add Contract Type"><i class="icon-plus22"></i></button>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <span class="form-text text-muted font-weight-bold">
                            <font color="black">AMC Signed Date &nbsp;<span style="color: red;">*</span></font>
                        </span>
                        <div class="input-group">
                            <input type="text" class="form-control daterange-single" value="<?PHP echo date('%m-%d-%Y');?>" id="txt_amc_signed_date" name="amc_signed_date" tabindex="3" />
                            <span class="input-group-append" style="cursor: pointer;" onclick="$('#txt_amc_signed_date').click()">
                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <span class="form-text text-muted font-weight-bold">
                            <font color="black">AMC Start & End Date&nbsp;<span style="color: red;">*</span></font>
                        </span>
                        <div class="input-group">
                            <input type="text" id="txt_amc_start_end_date" name="amc_start_end_date" class="form-control daterange-basic" value="<?PHP echo date('%m-%d-%Y');?> - <?PHP echo date("%m-%d-%Y", strtotime("+1 years"));?>" tabindex=4>
                            <span class="input-group-append" style="cursor: pointer;" onclick="$('#txt_amc_start_end_date').click()">
                                <span class="input-group-text"><i class="icon-calendar22"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2 pb-1">
                        <div class="custom-control custom-control-right custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="" id="custom_checkbox_inline_right_checked" checked tabindex="9" />
                            <label class="custom-control-label position-static font-weight-bold" for="custom_checkbox_inline_right_checked">Request for proposal –Yes/No </label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-3 border p-3 rounded">
                <legend class="text-uppercase font-size-sm font-weight-bold w-auto px-2" style="color: #333;">Financials & Description</legend>
                <div class="form-group row">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <span class="form-text text-muted font-weight-bold">
                            <font color="black">AMC Amount&nbsp;<span style="color: red;">*</span></font>
                        </span>
                        <div class="input-group">
                            <input type="text" id="txt_amc_amount" name="amc_amount" class="form-control" placeholder="AMC Amount" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" onpaste="return false" autocomplete="off" tabindex="5"/>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <span class="form-text text-muted font-weight-bold">
                            <font color="black">VAT % &nbsp;<span style="color: red;">*</span></font>
                        </span>
                        <div class="input-group">
                            <input type="text" id="txt_vat_percentage" name="vat_percentage" class="form-control" placeholder="VAT %" autocomplete="off" tabindex="6" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <span class="form-text text-muted font-weight-bold">
                            <font color="black">VAT Amount&nbsp;<span style="color: red;">*</span></font>
                        </span>
                        <div class="input-group">
                            <input type="text" id="txt_amc_vat_amount" name="amc_vat_amount" class="form-control" placeholder="VAT Amount" autocomplete="off" disabled tabindex="7" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <span class="form-text text-muted font-weight-bold">
                            <font color="black">Total AMC Amount&nbsp;<span style="color: red;">*</span></font>
                        </span>
                        <div class="input-group">
                            <input type="text" id="txt_total_amc_amount" name="total_amc_amount" class="form-control" placeholder="Total AMC Amount" autocomplete="off" tabindex="5" disabled/>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <span class="form-text text-muted font-weight-bold"><font color="black">AMC Description</font></span>
                        <textarea rows="2" class="form-control elastic" placeholder="Description" id="txt_amc_description" name="amc_description" tabindex="8"></textarea>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-3 border p-3 rounded">
                <legend class="text-uppercase font-size-sm font-weight-bold w-auto px-2" style="color: #333;">Attachments</legend>
                <div class="form-group row align-items-center mb-2">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment 1&nbsp;</font></span>
                        <div class="d-flex align-items-center">
                            <div style="flex-grow: 1;">
                                <input type="file" class="form-input-styled" id="first_attachment" name="amc_first_attachment" accept="image/*,.pdf,.doc,.docx" title="&nbsp;" data-fouc="" tabindex="10">
                            </div>
                            <div id="img_attachment1_preview" class="ml-2" style="width: 40px; height: 40px; min-width: 40px; border-radius: 4px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f8f8; display: none;"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12 mt-2 mt-md-0">
                        <span class="form-text text-muted font-weight-bold"><font color="black">Description&nbsp;</font></span>
                        <input type="text" class="form-control" id="txt_first_attachment_desc" name="amc_first_attachment_desc" placeholder="Description" tabindex="11">
                    </div>
                </div>
                <div class="form-group row align-items-center mb-2">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment 2&nbsp;</font></span>
                        <div class="d-flex align-items-center">
                            <div style="flex-grow: 1;">
                                <input type="file" class="form-input-styled" id="second_attachment" name="amc_second_attachment" accept="image/*,.pdf,.doc,.docx" title="&nbsp;" data-fouc="" tabindex="12">
                            </div>
                            <div id="img_attachment2_preview" class="ml-2" style="width: 40px; height: 40px; min-width: 40px; border-radius: 4px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f8f8; display: none;"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12 mt-2 mt-md-0">
                        <span class="form-text text-muted font-weight-bold"><font color="black">Description&nbsp;</font></span>
                        <input type="text" class="form-control" id="txt_sec_attachment_desc" name="amc_second_attachment_desc" placeholder="Description" tabindex="13">
                    </div>
                </div>
                <div class="form-group row align-items-center mb-2">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <span class="form-text text-muted font-weight-bold"><font color="black">AMC Attachment 3&nbsp;</font></span>
                        <div class="d-flex align-items-center">
                            <div style="flex-grow: 1;">
                                <input type="file" class="form-input-styled" id="third_attachment" name="amc_third_attachment" accept="image/*,.pdf,.doc,.docx" title="&nbsp;" data-fouc="" tabindex="14">
                            </div>
                            <div id="img_attachment3_preview" class="ml-2" style="width: 40px; height: 40px; min-width: 40px; border-radius: 4px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f8f8; display: none;"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-sm-12 mt-2 mt-md-0">
                        <span class="form-text text-muted font-weight-bold"><font color="black">Description&nbsp;</font></span>
                        <input type="text" class="form-control" id="txt_third_attachment_desc" name="amc_third_attachment_desc" placeholder="Description" tabindex="15">
                    </div>
                </div>
            </fieldset>
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
