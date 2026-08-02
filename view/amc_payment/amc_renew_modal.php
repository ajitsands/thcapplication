	<div id="modal_amc_renew" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><span id="amc_no_view_renew"></span></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    
            							  <div class="form-group row">
            							    <div class="col-lg-6 col-md-5 col-sm-12" >
            					                <div class="input-group">
            										
            										<input type="text" class="form-control daterange-single" value="<?PHP echo date('%m-%d-%Y');?>" id="txt_amc_renewal_signed_date">
            										<span class="input-group-prepend">
            											<span class="input-group-text"><i class="icon-calendar22"></i></span>
            										</span>
            									</div>
            									<span class="form-text text-muted"><font color="black">AMC Signed Date &nbsp;<span style="color:red;">*</span></font></span>
            						         </div>
            						         
            						         
            						          <div class="col-lg-6 col-md-5 col-sm-12" >
            						            
            						             
            						              
            						            <div class="input-group">
            						                
            						               	<input type="text" id="txt_amc_renewal_start_end_date" class="form-control daterange-left" value="<?PHP echo date('%m-%d-%Y');?> - <?PHP echo  date("%m-%d-%Y", strtotime("+1 years"));?>"> 
            										
            										<span class="input-group-append">
            											<span class="input-group-text"><i class="icon-calendar22"></i></span>
            										</span>
            									</div>
            									 <span class="form-text text-muted"><font color="black">AMC Start & End Date&nbsp;<span style="color:red;">*</span></font></span>
            									
            						    </div>
            						    
            						    </div>
            						    
            						    
            						    <div class="form-group row"> 
                    						    <div class="col-lg-4 col-md-5 col-sm-12" >
                    						                        <div class="input-group">
                    													<input type="text" id="txt_amc_renewal_amount" class="form-control form-control-lg text-center" placeholder="AMC Amount" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" align="center" autocomplete="off">
                    												
                    												</div>
                    												<span class="form-text text-muted"><font color="black">AMC Amount&nbsp;<span style="color:red;">*</span></font></span>
                    						    </div>
                    						    
                    				    	    <div class="col-lg-4 col-md-5 col-sm-12" >
                    					                <div class="input-group">
                    													<input type="text" id="txt_vat_renewal_percentage"  class="form-control form-control-lg text-center" placeholder="VAT %" align="center" autocomplete="off">
                    												
                    								    </div>
                    									<span class="form-text text-muted"><font color="black">VAT % &nbsp;<span style="color:red;">*</span></font></span>
                    						    </div>
                    						    <div class="col-lg-4 col-md-5 col-sm-12" >
                    						            <div class="input-group">
                    													<input type="text" id="txt_amc_renewal_vat_amount" class="form-control form-control-lg text-center" placeholder="VAT Amount" align="center" autocomplete="off" disabled>
                    												
                    								    </div>
                    									 <span class="form-text text-muted"><font color="black">VAT Amount&nbsp;<span style="color:red;">*</span></font></span>
                    										<input type="hidden" id="txt_amc_end_date_renew" class="form-control form-control-lg text-center" >
                    												
                    						    </div>
            						         
            							</div>
            							
                        </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-success" id="btn_renewal_amc">Save changes</button>
							</div>
						</div>
					</div>
				</div>