<div id="modal_amc_payments_completed" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="amc_no_view_head_amc_payment_completed"></h5>
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
							 
                                    
                            

					           
							        
							        <div class="col-lg-12 col-md-12 col-sm-12" >
					            
					                        <?PHP 
					                            include_once("amc_payment_completed_list.php");
					                        ?>
					            
					                </div>
					            
					            
							</div>

							<div class="modal-footer">
								<!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
								<button type="button" class="btn bg-danger" data-dismiss="modal" id="btn_close_payment" >Close</button>
								
							</div>
						</div>
					</div>
				</div>
			</div>	