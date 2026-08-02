

	<!-- Disabled backdrop Change Status -->
				<div id="btn_add_new_customer_building" class="modal fade" data-backdrop="false" >
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Customer Facilities</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
						  
								<div class="col-lg-6 col-md-6 col-sm-12" id="div_customer_location_details">	
								

									<input type="hidden" class="form-control" id="txt_contact_person_building_code" maxlength="4" style="text-transform: uppercase"   placeholder="Building Code">
    								
							    </div>
						     <div class="col-lg-6 col-md-6 col-sm-12" id="div_select_building">	
                                
                                </div>
								
				                 <div class="col-lg-6 col-md-6 col-sm-12">
                					       <span class="form-text text-muted font-weight-bold"><font color="black">Facility  Address </font></span>    
    										<textarea rows="1" class="form-control" id="txt_Building_address" placeholder="Facility Address"></textarea>
    											
								</div>
							    
							    <div class="col-lg-6 col-md-6 col-sm-12">
                					
                					     <!--<div class="card-body" >-->
                					         <span class="form-text text-muted font-weight-bold"><font color="black">Contact Person Name </font>  
                					   	<input type="text" class="form-control" id="txt_contact_person_name" placeholder="Contact Person Name">
    									 
    								 
                					 <!--</div>-->
                					<input type="hidden" id="txt_customer_location_id"/>
							    </div>
						     	
								 <div class="col-lg-6 col-md-6 col-sm-12">
                				<!--	<div class="card-body" >-->
                					    <span class="form-text text-muted font-weight-bold"><font color="black">Contact Person Number </font>      
                					   	<input type="text" class="form-control" id="txt_contact_person_number_build" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false"  placeholder="Contact Person Number">
    									
    								 
                					<!-- </div>-->

							    </div>
						
						         <div class="col-lg-6 col-md-6 col-sm-12">
                    					<!--<div class="card-body" >-->
                    					     <span class="form-text text-muted font-weight-bold"><font color="black">Facility Image&nbsp;</font></span>	
                    					    <input type="file" class="form-input-styled"  id="building_session_image" accept="image/*" title="&nbsp;" data-fouc=""/><p id="building_img_name"></p>
                    					    <div id="building_img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
                    					   
                    					<!--</div>-->
    							    </div>
							        
						        </div>
						        
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" data-dismiss="modal" id="btn_customer_location_add">Add</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			
