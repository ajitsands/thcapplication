<div id="modal_view_complaints" class="modal fade" data-backdrop="false" tabindex="-1" >
					<div class="modal-dialog modal-lg" style="max-width:80%" >
						<div class="modal-content">
							<div class="modal-header bg-info">
							<h5 class="modal-title"><b>Ref No:<span id="span_ticket_ref_no_completed_view_ticket"></span></b><br><br><span id="span_customer_completed_view_ticket" data-popup="popover" data-placement="bottom" title="Popover title" ></span><span id="span_location_completed_view_ticket"></span><span id="span_building_completed_view_ticket" data-popup="popover" data-placement="bottom" title="Popover title" data-content=""></span>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    
								<div class="row">
								  <div class="col-lg-12 col-md-12 col-sm-12" >
                        			 <table class="table datatable-selection-single" id="tbl_completed_entries" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							    <th></th>
                        							    <th>#</th>
                        							    <th>Work Order No.</th>
                        							    <th>Category</th>
                        							    <th>Type</th>
                        							    <th>Asset</th>
                        							    <th>Priority</th>
                        							    <!--<th >Service Report</th>-->
                        							    <th>Action</th>
                        							
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div>
								</div>

					       <br>
								 
        <!--                        <div class="form-group row">-->
								<!--	<label class="col-form-label col-lg-2"> Close Remarks<span style="color:red"> *</span></span></label>-->
								<!--	<div class="col-lg-12 col-md-12 col-sm-12">-->
								<!--		<textarea rows="3" cols="3" class="form-control" id="txt_remarks" placeholder="Remarks"></textarea>-->
								<!--	</div>-->
								<!--</div>-->
								<div class="form-group row">
							    	<div class="col-lg-2 col-md-2 col-sm-12">
							    	    <label style="font-weight:bold;"> Service Report No<span style="color:red;"> *</span></label>
							    	    	<input type="text" name="txt_service_report_no" id="txt_service_report_no" class="form-control">
							    	</div>
							    	<div class="col-lg-5 col-md-5 col-sm-12">
							    	    <label style="font-weight:bold">Service Report Remarks<span style="color:red;"> *</span></label>
							    	     <textarea rows="1" cols="3" class="form-control" id="txt_servive_rpt_remarks" placeholder="Remarks"></textarea>
							    	</div>
							    	<div class="col-lg-5 col-md-5 col-sm-12">
							    	    <label style="font-weight:bold"> Close Remarks</label>
							    	    	<textarea rows="1" cols="3" class="form-control" id="txt_remarks" placeholder="Remarks"></textarea>
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
						        	<div class="col-lg-3 col-md-3 col-sm-3">
						        	<div class="form-check form-check-inline form-check-right">
										<label class="form-check-label">
											FOC(Free of Charges) 
											<input type="checkbox" class="form-check-input-styled" id="check_foc" data-fouc>
										</label>
									</div>
									</div>
				                </div>
					            
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link"  id="close_ticket_st">Close Work Order </button>
								<button type="button" class="btn bg-danger" data-dismiss="modal">Exit</button>
								
							</div>
						</div>
					</div>
				</div>