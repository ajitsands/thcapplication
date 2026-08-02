<div id="modal_backdrop_amc_payments1" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg" style="max-width:70%">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" id="amc_no_view_head_amc_payments"></h5>
								<button type="button" class="close" data-dismiss="modal" id="btn_close" >&times;</button>
							</div>

							<div class="modal-body">
							    <div class="row">
                                <input class="form-control" type="hidden" id="txt_amc_id_amc_payments">
                                <input class="form-control" type="hidden" id="txt_amc_ref_no_payments"> 
                                <input class="form-control" type="hidden" id="txt_cust_id_amc_payments"> 
                                <input class="form-control" type="hidden" id="txt_cust_ref_no_payments">
								
							    <input class="form-control" type="hidden" id="txt_amc_payable_amt"> 
								<input class="form-control" type="hidden" id="txt_amc_payable_amt_for_update"> 
                                <input class="form-control" type="hidden" id="txt_amc_payable_vat_amt">
							 
                                    
                                  
                                    <div class="col-lg-3 col-md-12 col-sm-12" >
								
        										<input class="form-control" type="date" name="txt_amc_cust_payment_date" id="txt_amc_cust_payment_date">
												<span class="form-text text-muted"> Date &nbsp;<span style="color:red;">*</span></span>
							        </div>
							
									<div class="col-lg-2 col-md-12 col-sm-12" >
						                        <div class="input-group">
													<input type="text" id="txt_amc_cust_payment_amount" class="form-control form-control-lg text-center" placeholder="Amount" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" align="center" autocomplete="off">
												
												</div>
                                                <span class="form-text text-muted"> Amount &nbsp;<span style="color:red;">*</span> </span>
												
						    </div>
						    
				    	    <div class="col-lg-2 col-md-12 col-sm-12" >
					                <div class="input-group">
													<input type="text" id="txt_amc_cust_payment_vat_per"  class="form-control form-control-lg text-center" placeholder="VAT %" align="center" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" align="center" autocomplete="off">
												
								    </div>
                                    <span class="form-text text-muted"> VAT % &nbsp;<span style="color:red;">*</span> </span>
						    </div>
						    <div class="col-lg-2 col-md-12 col-sm-12" >
						            <div class="input-group">
													<input type="text" id="txt_amc_cust_payment_vat_amount" class="form-control form-control-lg text-center" placeholder="0.000" align="center" autocomplete="off" disabled>
												
								    </div>
                                    <span class="form-text text-muted">VAT Amount &nbsp; </span>
									
						    </div>
                            <div class="col-lg-2 col-md-12 col-sm-12" >
						            <div class="input-group">
													<input type="text" id="txt_amc_cust_payment_total_amount" class="form-control form-control-lg text-center" placeholder="0.000" align="center" autocomplete="off" disabled>
												
								    </div>
                                    <span class="form-text text-muted">Total &nbsp; </span>
									
						    </div>
							              
							        
					            </div>
                                <br>
                                <div class="form-group row">
                                <div class="col-lg-2 col-md-12 col-sm-12" style="padding-top:10px" >
					                           
                                               <div class="form-check">
                                                   <label class="form-check-label">
                                                       <input type="checkbox" class="form-check-input" id="check_closing_entry">
                                                       Closing Entry
                                                   </label>
                                               </div>
                                               </div>
    						        <div class="col-lg-2 col-md-12 col-sm-12" >
        										<input class="form-control" type="text" name="txt_amc_cust_invoice_ref_no" id="txt_amc_cust_invoice_ref_no" placeholder="Invoice Ref No">
        										<span class="form-text text-muted" placeholder="Invoice No"> Invoice Ref No</span>
							        </div>
    					                 <div class="col-lg-5 col-md-12 col-sm-12"  >
    										<textarea rows="1" class="form-control elastic" placeholder="Description" id="txt_amc_cust_payment_description"></textarea>
    										<span class="form-text text-muted">Description</span>
    						  
    									</div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 " >
        								<button type="button" class="btn bg-primary" id="btn_submit_payment">SUBMIT PAYMENT</button>
										<button type="button" class="btn bg-primary" id="btn_update_payment">UPDATE PAYMENT</button>
										<button type="button" class="btn bg-warning" id="btn_new_payment">NEW</button>
							        </div>
    					        </div>

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