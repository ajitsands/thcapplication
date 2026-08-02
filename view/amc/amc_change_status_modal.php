	<!-- Disabled backdrop Change Status -->
				<div id="modal_change_status" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" ><span id="amc_no_view_head"></span></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							
							<div class="modal-body">
								
								<div class="row">
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_active" value="1" class="form-check-input-styled-success" checked data-fouc>
													Active
												</label>
											</div>
							        </div>
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_cancelled" value="2" class="form-check-input-styled-danger"  data-fouc>
													Cancelled	
												</label>
											</div>
							        </div>
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							            <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_hold" value="3" class="form-check-input-styled-primary"  data-fouc>
													Hold
												</label> 
											</div>
							        </div>
							       <div class="col-lg-3 col-md-6 col-sm-12" >
							            <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_completed" value="4" class="form-check-input-styled-info"  data-fouc>
													Completed
												</label>
											</div>
							        </div>
							        
							    </div>
								
								<hr>

                                <div class="form-group row">
									<label class="col-form-label col-lg-2">Description</label>
									<div class="col-lg-12">
										<textarea rows="3" cols="3" class="form-control" id="txt_status_description" placeholder="Description"></textarea>
									</div>
								</div>
								
							</div>
							
							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_change_status">Change Status</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			