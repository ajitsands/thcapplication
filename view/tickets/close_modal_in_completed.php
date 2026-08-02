	<!-- Disabled backdrop Change Status -->
				<div id="modal_close_ticket" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog  modal-lg">
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title"><b>Ticket Ref No : <span id="span_ticket_ref_no_close"></span></b>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								 <input type="text" id="txt_close_ticket_id"/>
								 <input type="text" id="txt_close_ticket_ref_code"/>
								 
                                <div class="form-group row">
									<label class="col-form-label col-lg-2"> Close Remarks<span style="color:red"> *</span></span></label>
									<div class="col-lg-12 col-md-12 col-sm-12">
										<textarea rows="3" cols="3" class="form-control" id="txt_remarks" placeholder="Remarks"></textarea>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6 col-md-6 col-sm-12">
    				    
                					    <input type="file" class="form-input-styled"  id="session_image_close" accept="image/*" title="&nbsp;" data-fouc=""/>
                				        <b><i id="btn_remove_ticket_image_close" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
                    					 
    				                </div>
				        
                                     <div class="col-lg-1 col-md-1 col-sm-4">
        								<div class="d-flex align-items-center" style="padding-top:10px">
        									<i class="icon-image4 mr-3 icon-2x" id="i_image1" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
        									<input type="hidden" name="txt_hidden_ticket_image_close" id="txt_hidden_ticket_image_close" >
        									
        								</div>
						        	</div>
				                </div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal" id="close_ticket_st">Close Ticket </button>
								<button type="button" class="btn bg-danger" data-dismiss="modal">Exit</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			