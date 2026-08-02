<div id="modal_close_wo" class="modal fade" data-backdrop="false" tabindex="-1" >
					<div class="modal-dialog modal-lg" style="max-width:80%" >
						<div class="modal-content">
							<div class="modal-header bg-info">
							<h5 class="modal-title"><b>Ref No:<span id="span_amc_ref_no_close_modal"></span></b>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
<input type="hidden" id="txt_amc_ref_no_close"/>
<input type="hidden" id="txt_amc_visit_id_close"/>


							<div class="modal-body">
							   
								<div class="form-group row">
							    	<div class="col-lg-5 col-md-5 col-sm-12">
							    	    <label style="font-weight:bold;"> Service Report No<span style="color:red;"> *</span></label>
							    	    	<input type="text" name="txt_service_report_no" id="txt_service_report_no" class="form-control">
							    	</div>
							    	<div class="col-lg-7 col-md-7 col-sm-12">
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
				                </div>
					            
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link"  id="close_ticket_st" data-dismiss="modal">Close Work Order </button>
								<button type="button" class="btn bg-danger" data-dismiss="modal">Exit</button>
								
							</div>
						</div>
					</div>
				</div>