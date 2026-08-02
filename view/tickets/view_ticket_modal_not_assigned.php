	
			
				<div id="modal_view_ticket" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg" style="max-width:80%">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title"><b>View WO. : <span id="span_ticket_ref_no_view_ticket"></span><span id="span_customer_view_ticket"></span><span id="span_customer_view_location"></span><span id="span_customer_view_building"></span></b>
    							  </h5>
    							          
								<div id="selected_items" style="font-size:15px;color:red;padding-top:2px;"></div>
								
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								
							
							</div>

							<div class="modal-body">
								
								<input type="hidden" id="txt_hidden_ticket_ref_code_view_ticket"/>
							<input type="hidden" id="txt_hidden_cust_id_view_ticket"/>
							<input type="hidden" id="txt_hidden_cust_code_view_ticket"/>
							<input type="hidden" id="txt_hidden_cust_name_view_ticket"/>
							<input type="hidden" id="txt_hidden_loc_id_view_ticket"/>
							<input type="hidden" id="txt_hidden_loc_code_view_ticket"/>
							<input type="hidden" id="txt_hidden_loc_name_view_ticket"/>
							<input type="hidden" id="txt_hidden_build_id_view_ticket"/>
							<input type="hidden" id="txt_hidden_build_code_view_ticket"/>
							<input type="hidden" id="txt_hidden_build_name_view_ticket"/>
								<input type="hidden" id="txt_hidden_ref_view_ticket"/>
					
								
								<div class="row">
								    
							        
							        <div class="col-lg-12">
							            
							            	<table  class="table  table-hover datatable-highlight display  " id="tbl_ticket_entries" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							   
														<th >SL. No</th>
														<th>Work Order No.</th>
                        							    <th>Category</th>
                        								<th >Type</th>
                        								<th>Asset</th>
                        								<th>Priority</th>
                        								<th>Status</th>
                        								<th>Action</th>
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							            
						        </div>
								

<!--Second table-->
   <div class="row">
				           	<input type="hidden" id="txt_hidden_ticket_id_view_ticket"/>
				           		<input type="hidden" id="txt_hidden_category_id_view_ticket"/>
				           			<input type="hidden" id="txt_hidden_type_id_view_ticket"/>
				           
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        	   	<span class="form-text text-muted font-weight-bold"><font color="black">Additional Info &nbsp;</font></span>    
									<textarea rows="1" class="form-control" id="txt_additional_info1" placeholder="Additional Info"></textarea>
										
								
				        	</div>
				        	<div class="col-lg-4 col-md-6 col-sm-12">
    					<div class="card-body" >
    					     
    					    <input type="file" class="form-input-styled"  id="session_image1" accept="image/*" title="&nbsp;" data-fouc=""/>
    				        <b><i id="btn_remove_ticket_image1" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
        					    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
        					  
        					  
        					</div>
    				    </div>
				        
                            <div class="col-md-1 col-sm-4">
								<div class="d-flex align-items-center" style="padding-top:30px">
									<i class="icon-image4 mr-3 icon-2x" id="i_image1" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
									<input type="hidden" name="txt_hidden_ticket_image" id="txt_hidden_ticket_image" >
									
								</div>
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
    					<div class="card-body" >
    					     
    					    <input type="file" class="form-input-styled"  id="session_image2" accept="image/*" title="&nbsp;" data-fouc=""/>
    				        <b><i id="btn_remove_ticket_image2" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
        					    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
        					  
        					  
        					</div>
    				    </div>
				        
                            <div class="col-md-1 col-sm-4">
								<div class="d-flex align-items-center" style="padding-top:30px">
									<i class="icon-image4 mr-3 icon-2x" id="i_image2" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
									<input type="hidden" name="txt_hidden_ticket_image2" id="txt_hidden_ticket_image2" >
									
								</div>
							</div>
				        
				    </div>
				      <br>
				      <div class="row">
				          <div class="col-lg-2 col-md-6 col-sm-12" >
								<span class="form-text text-muted font-weight-bold" ><font color="black"> Service Request &nbsp;</font></span>
                        </div>
						<div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request1" class="form-check-input"  value="Hard FM">
									Hard FM
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request1" class="form-check-input"  value="Soft FM">
								Soft FM
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request1" class="form-check-input"  value="Others">
									Others
								</label>
							</div>
						</div>
					
	                  
						
					</div>
					
				<br>
				 <div class="row">
				      <div class="col-lg-2 col-md-6 col-sm-12" >
								<span class="form-text text-muted font-weight-bold" ><font color="black"> Job Category &nbsp;</font></span>
                        </div>
						<div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category1" class="form-check-input" checked="" value="PPM">
									PPM
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category1" class="form-check-input" checked="" value="Reactive">
								Reactive
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category1" class="form-check-input" checked="" value="Variable">
									Variable
								</label>
							</div>
						</div>
					
	                  
						
					</div>
				    <br>
				   <div class="row">
				       <div class="col-lg-2 col-md-6 col-sm-12" >
								<span class="form-text text-muted font-weight-bold" ><font color="black"> Priority &nbsp;</font></span>
                        </div>
						<div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color1" class="form-check-input" checked=""  value="Emergency">
									Emergency ( 1 - 3 Hrs)
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color1" class="form-check-input" checked="" value="Urgent">
									Urgent ( Within 24 Hrs)
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="display:none">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color1" class="form-check-input" checked="" value="Essential">
									Essential (3 Days)
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-12" style="display:none">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color1" class="form-check-input" checked="" value="Normal1">
									Normal (7 Days)
								</label>
							</div>
						</div>

						 <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color1" class="form-check-input" checked=""  value="Normal">
									Normal ( 24 - 48 Hrs)
								</label>
							</div>
						</div>
						
						
					</div>
					
				
				
						<br>
							<div class="row">
						     <div class="col-lg-2 col-md-6 col-sm-12" >
								<span class="form-text text-muted font-weight-bold" ><font color="black"> Quote &nbsp;</font></span>
                        </div>
						    	<div class="col-lg-3 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
								    <input type="radio" class="form-check-input"  name="radio-quote1" value="Yes"  checked="">
								
									Quote Required 
								</label>
							</div>
                        </div>
             	       
                       
						<div class="col-lg-3 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
								    <input type="radio" class="form-check-input"  name="radio-quote1" value="No"  checked="">
								
									Quote Not Required
								</label>
							</div>
						</div>
						<div class="col-lg-3 col-md-12 col-sm-12"  style="padding-top:0px">
        								<input class="form-control" type="text" name="txt_quote_ref_nos" id="txt_quote_ref_nos" >
        								<span class="form-text text-muted">Quote Ref. No.</span>
        			        </div>
						<div class="col-lg-3 col-md-12 col-sm-12" style="display:none">
								<input class="form-control" type="date" name="txt_quote_date1" id="txt_quote_date1" >
								<span class="form-text text-muted">Quote Date</span>
        			        </div>
        			        
        					<div class="col-lg-3 col-md-12 col-sm-12" style="display:none" >
        								<input class="form-control" type="date" name="txt_ticket_book_date_needed1" id="txt_ticket_book_date_needed1" >
        								<span class="form-text text-muted">Date of Needed</span>
        			        </div>
						</div>
						<br>
					<div class="row">
					
							<div class="col-lg-12 col-md-12 col-sm-12">
				        	   		<span class="form-text text-muted font-weight-bold"><font color="black">Complaints&nbsp;</font></span> 
									<textarea rows="2" class="form-control" id="txt_complaints1" name="txt_complaints1" placeholder="Complaints"></textarea>
									   
								
				        	</div>
				        	
						
						
					</div>
						<br>
					
					  <div class="row">
				           
				        	<div class="col-lg-6 col-md-6 col-sm-12">
				        	    <table class="table datatable-selection-single" id="tbl_ticket_all_services">
            						<thead>
            							<tr>
            							    <th>Select Services from the list to add to the ticket (if any)</th>
            							    
            				            </tr>
            						</thead>
            						<tbody>
            						</tbody>
            					
            					</table>
				        	</div>
				        	<div class="col-lg-6 col-md-6 col-sm-12">
				        	    <table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_selected_ticket_services">
            						<thead>
            							<tr>
            							    <th>Selected Services</th>
            							    <th></th>
            				            </tr>
            						</thead>
            						<tbody>
            						</tbody>
            					
            					</table>
				        	</div>
				    </div>
				    
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_update_ticket_entries">Update</button>
							</div>
						</div>
					</div>
				</div>
		
				