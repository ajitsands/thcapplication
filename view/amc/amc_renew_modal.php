	<!--<div id="modal_amc_renew" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title"><span id="amc_no_view_renew"></span></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    
            							  <div class="form-group row">
            							    <div class="col-lg-6 col-md-5 col-sm-12" >
            					                <div class="input-group">
            										
            										<input type="text" class="form-control daterange-single" value="<?PHP //echo date('%m-%d-%Y');?>" id="txt_amc_renewal_signed_date">
            										<span class="input-group-prepend">
            											<span class="input-group-text"><i class="icon-calendar22"></i></span>
            										</span>
            									</div>
            									<span class="form-text text-muted"><font color="black">AMC Signed Date &nbsp;<span style="color:red;">*</span></font></span>
            						         </div>
            						         
            						         
            						          <div class="col-lg-6 col-md-5 col-sm-12" >
            						            
            						             
            						              
            						            <div class="input-group">
            						                
            						               	<input type="text" id="txt_amc_renewal_start_end_date" class="form-control daterange-left" value="<?PHP //echo date('%m-%d-%Y');?> - <?PHP //echo  date("%m-%d-%Y", strtotime("+1 years"));?>"> 
            										
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
            							 <div class="form-group row">
									<div class="col-lg-6 col-md-6 col-sm-12">
    				    
                					    <input type="file" class="form-input-styled"  id="session_image_close" accept="image/*" title="&nbsp;" data-fouc=""/>
                				        <b><i id="btn_remove_ticket_image_close" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
                    					 
    				                </div>
				        
                                     <div class="col-lg-1 col-md-1 col-sm-4">
        								<div class="d-flex align-items-center" style="padding-top:10px">
        									<i class="icon-image4 mr-3 icon-2x" id="i_image" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
        									<input type="hidden" name="txt_hidden_ticket_image_close" id="txt_hidden_ticket_image_close" >
        									
        								</div>
						        	</div>
						        	
						        	</div>
						        	<div class="form-group row">
						        	    	<div class="col-lg-12 col-md-12 col-sm-12">
							    	   
							    	    	<textarea rows="1" cols="3" class="form-control" id="txt_renew_remarks" placeholder="Renewal Notes"></textarea>
							    	    	<span class="form-text text-muted"><font color="black">Renewal Notes&nbsp;</font></span>
							    	    	 
							    	</div>
						        	</div>
            							
                        </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-success" id="btn_renewal_amc">Renew</button>
							</div>
						</div>
					</div>
				</div>-->
				
				


<style>
    .daterangepicker {
        z-index: 106000 !important;
    }
    .picker {
        z-index: 106000 !important;
    }
</style>
	<div id="modal_view_amc_renew" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1">
		<div class="modal-dialog modal-xl" style="max-width:80%">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h5 class="modal-title"><span id="span_amc_renew_ref_no"></span></h5>
					<input type="hidden" id="txt_amc_parent_parent_ref_no" class="form-control form-control-lg text-center" >
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">AMC Signed Date</font></span> 
									<input type="text" class="form-control form-control-sm" id="txt_amc_signed_date1" disabled>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Start Date</font></span> 
									<input type="text" class="form-control form-control-sm" id="txt_amc_start_date" disabled>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">End Date</font></span> 
									<input type="text" class="form-control form-control-sm" id="txt_amc_end_date" disabled>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Amount</font></span> 
									<input type="text" class="form-control form-control-sm" id="txt_amc_amount1" disabled>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">VAT %</font></span> 
									<input type="text" class="form-control form-control-sm" id="txt_amc_vat" disabled>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-6 mb-3">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Net Amount</font></span> 
									<input type="text" class="form-control form-control-sm" id="txt_amc_vat_amount1" disabled>
								</div>
							</div>
							
							<hr style="border-top: 1px solid #ddd; margin: 5px 0 15px 0;">
							
							<h6 class="font-weight-bold">Renew Information</h6>
							<div class="form-group row">
								<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
									<span class="form-text text-muted"><font color="black">AMC Signed Date &nbsp;<span style="color:red;">*</span></font></span>
									<div class="input-group">
										<input type="text" class="form-control form-control-sm daterange-single" value="<?PHP echo date('%m-%d-%Y');?>" id="txt_amc_renewal_signed_date">
										<span class="input-group-append" style="cursor: pointer;" onclick="$('#txt_amc_renewal_signed_date').click().focus();">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 mb-3">
									<span class="form-text text-muted"><font color="black">AMC Start & End Date&nbsp;<span style="color:red;">*</span></font></span>
									<div class="input-group">
										<input type="text" id="txt_amc_renewal_start_end_date" class="form-control form-control-sm daterange-left" value="<?PHP echo date('%m-%d-%Y');?> - <?PHP echo  date("%m-%d-%Y", strtotime("+1 years"));?>"> 
										<span class="input-group-append" style="cursor: pointer;" onclick="$('#txt_amc_renewal_start_end_date').click().focus();">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-6 col-sm-6 mb-3">
									<span class="form-text text-muted"><font color="black">AMC Amount&nbsp;<span style="color:red;">*</span></font></span>
									<input type="text" id="txt_amc_renewal_amount" class="form-control form-control-sm" placeholder="AMC Amount" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" align="center" autocomplete="off">
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 mb-3">
									<span class="form-text text-muted"><font color="black">VAT % &nbsp;<span style="color:red;">*</span></font></span>
									<input type="text" id="txt_vat_renewal_percentage"  class="form-control form-control-sm" placeholder="VAT %" align="center" autocomplete="off">
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 mb-3">
									<span class="form-text text-muted"><font color="black">VAT Amount&nbsp;<span style="color:red;">*</span></font></span>
									<input type="text" id="txt_amc_renewal_vat_amount" class="form-control form-control-sm" placeholder="VAT Amount" align="center" autocomplete="off" disabled>
									<input type="hidden" id="txt_amc_end_date_renew" class="form-control form-control-sm text-center" >
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 mb-3">
									<span class="form-text text-muted"><font color="black">Total Amount</font></span>
									<input type="text" id="txt_amc_renewal_total_amount" class="form-control form-control-sm" placeholder="Total Amount" align="center" disabled>
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 text-right">
									<button type="button" class="btn btn-primary btn-sm" id="btn_renewal_amc"><i class="icon-spinner11 mr-2"></i>Renew AMC</button>
								</div>
							</div>
						</div>
					</div>
					
					<hr style="border-top: 1px solid #ddd; margin: 10px 0 15px 0;">
					
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12">
							<h6 class="font-weight-bold">List of Previous AMC</h6>
							<div class="table-responsive">
								<table class="table datatable-selection-single table-hover datatable-highlight table-sm text-nowrap" id="tbl_for_list_renew_amc">
									<thead>
										<tr class="bg-light">
											<th>SL. No.</th> 
											<th>AMC Ref. No</th>
											<th>Date</th>
											<th>Net Amount</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									</tbody> 
								</table>
							</div>
						</div> 
						
						<div class="col-lg-6 col-md-6 col-sm-12">
							<h6 class="font-weight-bold">List of Subcontractor</h6>
							<div class="table-responsive">
								<table class="table datatable-selection-single table-hover datatable-highlight table-sm text-nowrap" id="tbl_two">
									<thead>
										<tr class="bg-light">
											<th>SL. No.</th>
											<th>Name</th>
											<th>Date</th>
											<th>Net Amount</th>
											<th>Description</th>
										</tr>
									</thead>
									<tbody>
									</tbody> 
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th>Total Amount </th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>	
</div>

<!-- modal assign to Subcontractors -->	    
				
		<div id="modal_assign_to_subcontractors_renew" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-xl" style="max-width:70%">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h5 class="modal-title"><b><span id="span_amc_ref_no_new_subcontractor1_details"></span><span style="display:none;" id="span_amc_ref_no_new_subcontractor1"></span></h5>
						<input type="hidden"  class="form-control " id="txt_amc_id1">
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>

					<div class="modal-body">
						
						<div class="row" id = "div_subcontractor_content">
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3" id="div_subcontractors_load1" >
										
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted font-weight-bold"><font color="black">Amount&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_amount1"  placeholder="0.000" tabindex=2>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted font-weight-bold"><font color="black">VAT %&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_vat1"  placeholder="0.000" tabindex=3>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-6 mb-3">
										<span class="form-text text-muted font-weight-bold"><font color="black">Total Amount&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_total_amount1"  placeholder="0.000" tabindex=4 disabled>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									 <span class="form-text text-muted font-weight-bold"><font color="black">Start &amp; End Date&nbsp;<span style="color:red;">*</span></font></span>
										<div class="input-group">
											<input type="text" id="txt_list_contractor_start_end_date1" class="form-control daterange-basic" value="%11-%07-%2023 - %11-%07-%2024" tabindex=5> 
					 						<span class="input-group-append" style="cursor: pointer;" onclick="$('#txt_list_contractor_start_end_date1').click().focus();">
												<span class="input-group-text"><i class="icon-calendar22"></i></span>
											</span>
										</div>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-6 mb-3">
					 					<span class="form-text text-muted font-weight-bold"><font color="black">Description&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_description1"  placeholder="Description" tabindex=6>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
										 <span class="form-text text-muted font-weight-bold"><font color="black">File Upload&nbsp;</font></span>	
										<input type="file" class="form-input-styled"  id="session_image1" accept="image/*" title="&nbsp;" tabindex=7 data-fouc=""/>
									</div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 mb-3 d-flex align-items-center mt-4">
                                        <div id="img_preview1" style="width:40px;height:40px;border-radius:4px;border:1px solid #ddd;display:none;background:#f5f5f5;align-items:center;justify-content:center;overflow:hidden;margin-right:10px;"></div>
                                        <span id="amc_contractor_file_name1" class="text-muted text-truncate" style="max-width: 200px;"></span>
                                    </div>
								</div>
							</div>
						</div>
						
						
					<div class="modal-footer">
						
						<button type="button" class="btn bg-teal-400 ladda-button legitRipple" id="btn_assign_subcontractors_renew1" ><i class="icon-floppy-disk mr-2"></i>Renew</button>
						<button type="button" class="btn bg-warning-400 ladda-button legitRipple" id="btn_exit_assign_subcontractor_renew" ><i class="icon-pencil3 mr-2"></i>Exit</button>
						
					</div>
					
				<!-- assigned subcontactor list table -->	
				<h4><b>List of Subcontractors of <span id="amc_old_ref_no_details"></span><span style="display:none;" id="amc_old_ref_no"></span></b></h4>	
					<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight display" id="tbl_amc_assigned_subcontractor_list1" style="padding-right:5px;padding-left:5px;">
						<thead>
							<tr>
								
								<th >SL.No.</th>
								<th>Subcontractor </th>
								<th>Amount </th>
								<th>VAT %</th>
								<th>Total Amount</th>
								<th>Description</th>
								<th>Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th>Total : </th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tfoot>
					</table>
					
				<!-- /assigned subcontactor list table -->	
				
				<!-- assigned subcontactor list table -->	
				<h4><b>List of Subcontractors of <span id="amc_new_ref_no_details"></span><span style="display:none;" id="amc_new_ref_no"></span></b></h4>
					<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight display" id="tbl_amc_assigned_subcontractor_list1_new" style="padding-right:5px;padding-left:5px;">
						<thead>
							<tr>
								
								<th >SL.No.</th>
								<th>Subcontractor </th>
								<th>Amount </th>
								<th>VAT %</th>
								<th>Total Amount</th>
								<th>Description</th>
								<th>Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th>Total : </th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tfoot>
					</table>
					
				<!-- /assigned subcontactor list table -->	
				</div>
			</div>
		</div>
		
	</div>
				
<!-- /modal assign to Subcontractors -->		