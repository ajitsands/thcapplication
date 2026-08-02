	<!-- Disabled backdrop Change Status -->
				<div id="modal_building" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Building</h5>
								<button type="button" class="close" id="btn_x_new_bldg">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
						        	<div class="col-md-12">
						        	    
							        	<div class="form-group row">
							        	    	<div class="col-lg-6 col-md-6 col-sm-12" >
							        	    	    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Building Code &nbsp;<span style="color:red;">*</span></font></span>
            									<input type="text" class="form-control text-uppercase " id="txt_building_code"  onKeyPress="if(this.value.length==4) return false;">
            									
            										
            							
            								</div>
                    						<div class="col-lg-6 col-md-6 col-sm-12" >
                    						    	<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Building Name &nbsp;<span style="color:red;">*</span></font></span>
                								<input type="text" class="form-control" id="txt_building_name" >
                								
                								
                						
                							</div>
            
            							
            
            								<div class="col-lg-12 col-md-12 col-sm-12" style="display:none">
            									<textarea rows="1" value="NA" class="form-control" id="txt_building_address" placeholder="Address"></textarea>
            										<span class="form-text text-muted"><font color="black">Building Address &nbsp;<span style="color:red;">*</span></font></span>    
            								</div>
							        	</div>
								
							        </div>
							        
						        </div>
						        
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" id="btn_close_new_bldg">Close</button>
								<button type="button" class="btn bg-primary" id="btn_building_add" >Add</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			