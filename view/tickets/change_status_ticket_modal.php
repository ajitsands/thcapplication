	<!-- Disabled backdrop Change Status -->
				<div id="modal_change_status_ticket" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
							<h5 class="modal-title"><b>WO. Ref No : <span id="span_ticket_ref_no_change_status"></span><span id="span_customer_change_status"></span><span id="span_location_change_status"></span><span id="span_building_change_status"></span></b>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
									<br>
								<div class="row">
							       	<input type="hidden" id="txt_hidden_ticket_ref_code_change_status"/>
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio_status_change_status"  value="Cancelled" class="form-check-input-styled-danger"  data-fouc >
													Cancelled	
												</label>
											</div>
							        </div>
							       
							       <div class="col-lg-3 col-md-6 col-sm-12" >
							            <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio_status_change_status"  value="Closed" class="form-check-input-styled-info"  data-fouc>
													Closed
												</label>
											</div>
							        </div>
							        
							    </div>
								
							<br>

                                <div class="form-group row">
									<label class="col-form-label col-lg-2"> Remarks</label>
									<div class="col-lg-12">
										<textarea rows="3" cols="3" class="form-control" id="txt_remarks" placeholder="Remarks"></textarea>
									</div>
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_change_ticket_status" data-dismiss="modal">Change Status</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			