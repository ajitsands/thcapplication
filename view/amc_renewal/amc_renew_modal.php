	<!--<div id="modal_amc_renew" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1">
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
            							
                        </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-success" id="btn_renewal_amc">Renew</button>
							</div>
						</div>
					</div>
				</div>-->
				
				
		<div id="modal_view_amc_subcontractors_details" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-xl" style="max-width:70%">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title"><span id="span_amc_ref_no1"></span></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    
            							
                        					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_of_amc_subcontractors_details">
                        						<thead>
                        							<tr>
                        							    <th>SL. No.</th>
                        				                <th>Subcontractor Name</th>
                        								<th>Amount</th>
                        				                <th>VAT %</th>
                        				                <th>Tot. Amount</th>
                        				                <th>Date</th>
														<th>View Doc</th>
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
												</tfoot>
                        					 
                        					</table>
                        				
                        </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
							
							</div>
						</div>
					</div>
	</div>
	
	<style>
		.modal-full-screen {
			width: 100vw;
			max-width: 100%;
			margin: 0;
		}

		.modal-full-screen .modal-dialog {
			width: 100%;
			max-width: 100%;
			height: 100%;
			margin: 0;
		}

		.modal-full-screen .modal-content {
			height: 100%;
		}
    </style>


	<div id="modal_view_amc_renew" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1" style="width:100%;">
		<div class="modal-dialog modal-full-screen">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h5 class="modal-title"><span id="span_amc_renew_ref_no"></span></h5>
					<input type="hidden" id="txt_amc_parent_parent_ref_no" class="form-control form-control-lg text-center" >
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="card" style="margin:1px;">
						<div class="card-body">
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-lg-2 col-md-2 col-sm-2">
									<span class="form-text text-muted" style='font-size: 12px;'><font color="black">AMC Signed Date</font></span> 
										<input type="text" class="form-control " id="txt_amc_signed_date" disabled>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Start Date</font></span> 
										<input type="text" class="form-control " id="txt_amc_start_date" disabled>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted" style='font-size: 12px;'><font color="black">End Date</font></span> 
										<input type="text" class="form-control " id="txt_amc_end_date" disabled>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Amount</font></span> 
										<input type="text" class="form-control " id="txt_amc_amount" disabled>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted" style='font-size: 12px;'><font color="black">VAT %</font></span> 
										<input type="text" class="form-control " id="txt_amc_vat" disabled>
									</div>
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Net Amount</font></span> 
										<input type="text" class="form-control " id="txt_amc_vat_amount" disabled>
									</div>
								</div>
								<hr style="border-top: 2px solid black; margin: 10px 0; opacity: 0.2;">
								<h5><b>Renew Information</b></h5>
								<div class="form-group row">
									<div class="col-lg-3 col-md-3 col-sm-3">
										<span class="form-text text-muted"><font color="black">AMC Signed Date &nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" class="form-control daterange-single" value="<?PHP echo date('%m-%d-%Y');?>" id="txt_amc_renewal_signed_date">
										<!--<span class="input-group-prepend"> 
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>-->
									</div>
									<div class="col-lg-6 col-md-2 col-sm-2">
										<span class="form-text text-muted"><font color="black">AMC Start & End Date&nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" id="txt_amc_renewal_start_end_date" class="form-control daterange-left" value="<?PHP echo date('%m-%d-%Y');?> - <?PHP echo  date("%m-%d-%Y", strtotime("+1 years"));?>"> 
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3">
										<span class="form-text text-muted"><font color="black">AMC Amount&nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" id="txt_amc_renewal_amount" class="form-control form-control-lg" placeholder="AMC Amount" onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)' onpaste="return false" align="center" autocomplete="off">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3">
										<span class="form-text text-muted"><font color="black">VAT % &nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" id="txt_vat_renewal_percentage"  class="form-control form-control-lg" placeholder="VAT %" align="center" autocomplete="off">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3">
									 <span class="form-text text-muted"><font color="black">VAT Amount&nbsp;<span style="color:red;">*</span></font></span>
										<input type="text" id="txt_amc_renewal_vat_amount" class="form-control form-control-lg" placeholder="VAT Amount" align="center" autocomplete="off" disabled>
										<input type="hidden" id="txt_amc_end_date_renew" class="form-control form-control-lg text-center" >
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3" style="margin-top: 32px;">
										<button type="button" class="btn bg-success" id="btn_renewal_amc">Renew</button>
									</div>
								</div>
							</div>
						</div>
					</div><br>
					<div class="card" style="margin:1px;">
					<div class="card-body">
						<div class = "row">
							<div class="col-lg-6 col-md-6 col-sm-6" >
							<h5> List of Previous AMC</h5>
								<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_for_list_renew_amc">
									<thead>
										<tr>
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
							
							<div class="col-lg-6 col-md-6 col-sm-6 " >
							<h5> List of Subcontractor</h5>
								<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_two">
									<thead>
										<tr>
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
										<th></th>
										<th></th>
										<th>Total Amount </th>
										<th></th>
										<th></th>
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
						<h5 class="modal-title"><b><span id="span_amc_ref_no_new_subcontractor_details"></span><span style="display:none;" id="span_amc_ref_no_new_subcontractor"></span></h5>
						<input type="hidden"  class="form-control " id="txt_amc_id">
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>

					<div class="modal-body">
						
						<div class="row" id = "div_subcontractor_content">
							<div class="col-md-12">
								<div class="form-group row">
									<div class="col-lg-5 col-md-5 col-sm-5" id="div_subcontractors_load" >
										
									</div>
									
									<?PHP //include("subcontractor_combo.php");?>
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted font-weight-bold"><font color="black">Amount&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_amount"  placeholder="0.000" tabindex=2>
									</div>
									
									<div class="col-lg-2 col-md-2 col-sm-2">
										<span class="form-text text-muted font-weight-bold"><font color="black">VAT %&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_vat"  placeholder="0.000" tabindex=3>
									</div>
									
									<div class="col-lg-3 col-md-3 col-sm-3">
										<span class="form-text text-muted font-weight-bold"><font color="black">Total Amount&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_total_amount"  placeholder="0.000" tabindex=4 disabled>
									</div>
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									 <span class="form-text text-muted font-weight-bold"><font color="black">Start &amp; End Date&nbsp;<span style="color:red;">*</span></font></span>
										<div class="input-group">
											<input type="text" id="txt_list_contractor_start_end_date" class="form-control daterange-basic" value="%11-%07-%2023 - %11-%07-%2024" tabindex=5> 
											<span class="input-group-append">
												<span class="input-group-text"><i class="icon-calendar22"></i></span>
											</span>
										</div>
									</div>
									
									<div class="col-lg-6 col-md-6 col-sm-6">
										<span class="form-text text-muted font-weight-bold"><font color="black">Description&nbsp;</font></span> 
										<input type="text"  class="form-control " id="txt_contractor_description"  placeholder="Description" tabindex=6>
									</div>
									
									<div class="col-lg-12 col-md-12 col-sm-12">
										 <span class="form-text text-muted font-weight-bold"><font color="black">File Upload&nbsp;</font></span>	
										<input type="file" class="form-input-styled"  id="session_image" accept="image/*" title="&nbsp;" tabindex=7 data-fouc=""/><p id="amc_contractor_file_name"></p>
										<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
									</div>
									
								</div>
							</div>
						</div>
						
						
					<div class="modal-footer">
						
						<button type="button" class="btn bg-teal-400 ladda-button legitRipple" id="btn_assign_subcontractors_renew" ><i class= "icon-floppy-disk mr-2"></i>Renew</button>
						<button type="button" class="btn bg-warning-400 ladda-button legitRipple" id="btn_exit_assign_subcontractor_renew" ><i class="icon-pencil3 mr-2"></i>Exit</button>
						
					</div>
					
				<!-- assigned subcontactor list table -->
					<h5><b>List of Subcontractors of <span id="amc_old_ref_no_details"></span><span style="display:none;" id="amc_old_ref_no"></span></b></h5>			
					<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight display" id="tbl_amc_assigned_subcontractor_list" style="padding-right:5px;padding-left:5px;">
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
							<th>Total Amount </th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tfoot>
					</table><p></p>
					
				<!-- /assigned subcontactor list table -->	
				<h5><b>List of Subcontractors of <span id="amc_new_ref_no_details"></span><span style="display:none;" id="amc_new_ref_no"></span></b></h5>
				<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight display" id="tbl_amc_assigned_subcontractor_list_new" style="padding-right:5px;padding-left:5px;">
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
							<th>Total Amount </th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		
	</div>
				
<!-- /modal assign to Subcontractors -->		