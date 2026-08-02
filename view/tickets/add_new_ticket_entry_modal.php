	
			
				<div id="modal_add_entries" class="modal fade" data-backdrop="false" >
					<div class="modal-dialog modal-lg" style="max-width:70%">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title"><b>Add New Entries  <span id="span_ticket_ref_no_add_new_entries_ticket"></span><span id="span_customer_add_new_entries_ticket"></span><span id="span_customer_add_new_entries_location"></span><span id="span_customer_add_new_entries_building"></span></b>
    							  </h5>
    							          
								
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								
							
							</div>

							<div class="modal-body">
								
								<input type="hidden" id="txt_hidden_ticket_ref_code_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_cust_id_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_cust_code_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_cust_name_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_loc_id_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_loc_code_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_loc_name_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_build_id_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_build_code_add_new_entries_ticket"/>
								<input type="hidden" id="txt_hidden_build_name_add_new_entries_ticket"/>
							<input type="hidden" id="txt_hidden_ticket_customer_asset_category_id_add_entries"/>
							<input type="hidden" id="txt_hidden_ticket_customer_asset_category_name_add_entries"/>
							<input type="hidden" id="txt_hidden_ticket_customer_asset_type_id_add_entries"/>
							<input type="hidden" id="txt_hidden_ticket_customer_asset_type_name_add_entries"/>
							<input type="hidden" id="txt_hidden_ref_add_entries"/>
					
					
				 <div class="row">
				           	
				           	<div class="col-lg-3 col-md-3 col-sm-12" id="div_category_select_add_entries"></div>
				           	
						
							<div class="col-lg-3 col-md-3 col-sm-12" id="div_asset_type_combo_add_entries">	</div>
							
							<div class="col-lg-6 col-md-6 col-sm-12" id="div_assets_combo_add_entries">	</div>
							
				        	
				    </div>				
							
					<br>			

<!--Second table-->
   <div class="row">
				           	
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        	   	<span class="form-text text-muted font-weight-bold"><font color="black">Additional Info &nbsp;</font></span>
									<textarea rows="1" class="form-control" id="txt_additional_info_add_entries" placeholder="Additional Info"></textarea>
										    
								
				        	</div>
				        	<div class="col-lg-4 col-md-6 col-sm-12">
    					<div class="card-body" >
    					     
    					    <input type="file" class="form-input-styled"  id="session_image_add_entries" accept="image/*" title="&nbsp;" data-fouc="" />
    				        <b><i id="btn_remove_ticket_image_add_entries" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
        					    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
        					  
        					  
        					</div>
    				    </div>
				        
                            <div class="col-md-1 col-sm-4">
								<div class="d-flex align-items-center" style="padding-top:30px">
									<i class="icon-image4 mr-3 icon-2x" id="i_image_add_entries" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
								
									<input type="hidden" name="hidden_image_show_add_entries" id="hidden_image_show_add_entries" >
								</div>
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
    					<div class="card-body" >
    					     
    					    <input type="file" class="form-input-styled"  id="session_image_add_entries2" accept="image/*" title="&nbsp;" data-fouc=""/>
    				        <b><i id="btn_remove_ticket_image_add_entries2" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
        					    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
        					  
        					  
        					</div>
    				    </div>
				        
                            <div class="col-md-1 col-sm-4">
								<div class="d-flex align-items-center" style="padding-top:30px">
									<i class="icon-image4 mr-3 icon-2x" id="i_image_add_entries2" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
								
									<input type="hidden" name="hidden_image_show_add_entries2" id="hidden_image_show_add_entries2" >
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
									<input type="radio" name="radio_service_request_add_entries" class="form-check-input" checked="" value="Hard FM">
									Hard FM
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request_add_entries" class="form-check-input" checked="" value="Soft FM">
								Soft FM
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request_add_entries" class="form-check-input" checked="" value="Others">
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
									<input type="radio" name="radio_job_category_add_entries" class="form-check-input" checked="" value="PPM">
									PPM
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category_add_entries" class="form-check-input" checked="" value="Reactive">
								Reactive
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px" >
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category_add_entries" class="form-check-input" checked="" value="Variable">
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
									<input type="radio" name="radio-styled-color_add_entries" class="form-check-input" checked=""  value="Emergency">
									Emergency ( 1 - 3 Hrs)
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color_add_entries" class="form-check-input"  value="Urgent">
									Urgent ( Within 24 Hrs)
								</label>
							</div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12" style="display:none">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color_add_entries" class="form-check-input"  value="Essential">
									Essential (3 Days)
								</label>
							</div>
						</div>
						

						 <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px" >
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color_add_entries" class="form-check-input" checked  value="Normal">
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
								    <input type="radio" class="form-check-input"  name="radio-quote_add_entries" value="No"  checked>
								
									Quote Not Required
								</label>
							</div>
						</div>
						    	<div class="col-lg-3 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
								    <input type="radio" class="form-check-input"  name="radio-quote_add_entries" value="Yes"  >
								
									Quote Required 
								</label>
							</div>
                        </div>
             	       
                       	<div class="col-lg-3 col-md-12 col-sm-12" id="div_quote_ref_no">
								<input class="form-control" type="text" name="quote_ref_no_add_entries" id="quote_ref_no_add_entries" placeholder="Quotation Ref.No.">
								
        			        </div>
						
						<div class="col-lg-3 col-md-12 col-sm-12" style="display:none">
								<input class="form-control" type="date" name="txt_quote_date_add_entries" id="txt_quote_date_add_entries" >
								<span class="form-text text-muted">Quote Date</span>
        			        </div>
        					<div class="col-lg-3 col-md-12 col-sm-12" style="display:none">
        								<input class="form-control" type="date" name="txt_ticket_book_date_needed_add_entries" id="txt_ticket_book_date_needed_add_entries" >
        								<span class="form-text text-muted">Date of Needed</span>
        			        </div>
						</div>
						<br>
					<div class="row">
					
							<div class="col-lg-12 col-md-12 col-sm-12">
				        	   	<span class="form-text text-muted font-weight-bold"><font color="black">Complaints&nbsp;</font></span>
									<textarea rows="2" class="form-control" id="txt_complaints_add_entries" name="txt_complaints_add_entries" placeholder="Complaints"></textarea>
										    
								
				        	</div>
				        	
						
						
					</div>
						<br>
					
					  <div class="row">
				           
				        	<div class="col-lg-6 col-md-6 col-sm-12">
				        	    <table class="table datatable-selection-single" id="tbl_ticket_all_services_add_entries">
            						<thead>
            							<tr>
            							    <th>Select Services from the list to add to the ticket</th>
            							    
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
								<button type="button" class="btn bg-primary" id="btn_submit_new_tkt_entries">Add</button>
							</div>
						</div>
					</div>
				</div>
		
				