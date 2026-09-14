<div id="modal_backdrop_amc_payments1" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg" style="max-width:70%">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" id="amc_no_view_head_amc_payments"></h5>
								<button type="button" class="close" data-dismiss="modal" id="btn_close" >&times;</button>
							</div>

							<div class="modal-body">
								<!-- Hidden inputs -->
                                <input class="form-control" type="hidden" id="txt_amc_id_amc_payments">
                                <input class="form-control" type="hidden" id="txt_amc_ref_no_payments"> 
                                <input class="form-control" type="hidden" id="txt_cust_id_amc_payments"> 
                                <input class="form-control" type="hidden" id="txt_cust_ref_no_payments">
							    <input class="form-control" type="hidden" id="txt_amc_payable_amt"> 
								<input class="form-control" type="hidden" id="txt_amc_payable_amt_for_update"> 
                                <input class="form-control" type="hidden" id="txt_amc_payable_vat_amt">

								<div class="form-group row">
									<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted"><font color="black">Date &nbsp;<span style="color:red;">*</span></font></span>
										<input class="form-control form-control-sm" type="date" name="txt_amc_cust_payment_date" id="txt_amc_cust_payment_date">
									</div>
									<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted"><font color="black">Amount &nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" id="txt_amc_cust_payment_amount" class="form-control form-control-sm text-center" placeholder="Amount" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" autocomplete="off">
									</div>
									<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted"><font color="black">VAT % &nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" id="txt_amc_cust_payment_vat_per" class="form-control form-control-sm text-center" placeholder="VAT %" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" autocomplete="off">
									</div>
									<div class="col-lg-3 col-md-6 col-sm-6 mb-3">
										<span class="form-text text-muted"><font color="black">VAT Amount</font></span>
										<input type="text" id="txt_amc_cust_payment_vat_amount" class="form-control form-control-sm text-center" placeholder="0.000" autocomplete="off" disabled>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-6 mb-3">
										<span class="form-text text-muted"><font color="black">Total</font></span>
										<input type="text" id="txt_amc_cust_payment_total_amount" class="form-control form-control-sm text-center" placeholder="0.000" autocomplete="off" disabled>
									</div>

									<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted"><font color="black">Invoice Ref No</font></span>
										<input class="form-control form-control-sm" type="text" name="txt_amc_cust_invoice_ref_no" id="txt_amc_cust_invoice_ref_no" placeholder="Invoice No">
									</div>
									<div class="col-lg-5 col-md-8 col-sm-12 mb-3">
										<span class="form-text text-muted"><font color="black">Description</font></span>
										<textarea rows="1" class="form-control form-control-sm elastic" placeholder="Description" id="txt_amc_cust_payment_description"></textarea>
									</div>
									<div class="col-lg-2 col-md-4 col-sm-6 mb-3 d-flex align-items-center mt-3">
										<div class="form-check">
											<label class="form-check-label font-weight-bold">
												<input type="checkbox" class="form-check-input" id="check_closing_entry"> Closing Entry
											</label>
										</div>
									</div>
									
									<div class="col-lg-3 col-md-8 col-sm-12 mb-3 d-flex align-items-end justify-content-end">
										<button type="button" class="btn btn-primary btn-sm mr-2" id="btn_submit_payment"><i class="icon-checkmark3 mr-1"></i>Submit</button>
										<button type="button" class="btn btn-primary btn-sm mr-2" id="btn_update_payment"><i class="icon-sync mr-1"></i>Update</button>
										<button type="button" class="btn btn-warning btn-sm" id="btn_new_payment"><i class="icon-plus3 mr-1"></i>New</button>
									</div>
								</div>
								
								<hr style="border-top: 1px solid #ddd; margin: 5px 0 15px 0;">

					            <div class="row">
							        <div class="col-lg-12 col-md-12 col-sm-12" >
					                        <?PHP 
					                            include_once("amc_payment_list.php");
					                        ?>
					                </div>
					            </div>
					            
							</div>

							<div class="modal-footer">
								<!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
								<button type="button" class="btn bg-danger" data-dismiss="modal" id="btn_close_payment" >Close</button>
								
							</div>
						</div>
					</div>
				</div>