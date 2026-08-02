<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Book Complaints </h5>
							<div class="header-elements">
    						<div class="list-icons">
    						    <!--<button type="button" data-popup="tooltip" title="Add New Category" data-placement="bottom" class="btn btn-default btn-sm" id="btn_add_new_category" data-toggle="modal" data-target="#modal_new_category">	<i class="icon-add"></i></button></td>-->
					         <!--   <button type="button" data-popup="tooltip" title="Add New Type" data-placement="bottom" class="btn btn-default btn-sm" id="btn_add_new_type" data-toggle="modal" data-target="#modal_new_type">	<i class="icon-add-to-list"></i></button></td>-->
						        <!--<button type="button" data-popup="tooltip" title="Add New Service" data-placement="bottom" class="btn btn-default btn-sm" id="btn_add_new_service" data-toggle="modal" data-target="#modal_add_services">	<i class="icon-alignment-unalign"></i></button></td>-->
    						   <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal_new_category"><i class="icon-add"></i> Add To Asset Category Master</button>
    						   <button type="button" id="btn_modal_new_type" class="btn btn-outline-info" data-toggle="modal" data-target="#modal_new_type"><i class="icon-add-to-list"></i> Add To Asset Type Master</button>
    						   <button type="button" class="btn btn-outline-info" id="btn_modal_add_services" data-toggle="modal" data-target="#modal_add_services"><i class="icon-alignment-unalign"></i> Add To Service Master</button>
					        </div>
					    </div>
					</div>
 
				<div class="card-body">
				    
				   
				    <div class="row">
				           
				           	<div class="col-lg-3 col-md-3 col-sm-12" id="div_category_select">
				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black"> Category &nbsp;</font></span>
                            
				           	</div>
				           	<div class="col-lg-3 col-md-3 col-sm-12" id="div_category_text">	
   	                        			<span class="form-text text-muted font-weight-bold" ><font color="black"> Category &nbsp;</font></span>
                            
                                	<input type="text" class="form-control" id="txt_category" placeholder="Category" disabled>
                            								
                            					
                            </div>
					     	
							<div class="col-lg-3 col-md-3 col-sm-12" id="div_asset_type_combo">
							    	<span class="form-text text-muted font-weight-bold" ><font color="black"> Type &nbsp;</font></span>
                       	</div>
							<div class="col-lg-3 col-md-3 col-sm-12" id="div_type_text">	
                                		<span class="form-text text-muted font-weight-bold" ><font color="black"> Type &nbsp;</font></span>
                       
                                	<input type="text" class="form-control" id="txt_type" placeholder="Type" disabled>
                            								
                            						
                            </div>
				        	<div class="col-lg-6 col-md-6 col-sm-12">
				        	   <span class="form-text text-muted font-weight-bold"><font color="black">Additional Location Info.  &nbsp;</font></span>    
									
									<textarea rows="1" class="form-control" id="txt_additional_info" placeholder="Additional Info"></textarea>
										
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
									<input type="radio" name="radio_service_request" class="form-check-input-styled-success" checked data-fouc value="Hard FM">
									Hard FM
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request" class="form-check-input-styled-info"  data-fouc value="Soft FM">
								Soft FM
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_service_request" class="form-check-input-styled"  data-fouc value="Others">
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
									<input type="radio" name="radio_job_category" class="form-check-input-styled-info" checked data-fouc value="PPM">
									PPM
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category" class="form-check-input-styled-success"  data-fouc value="Reactive">
								Reactive
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio_job_category" class="form-check-input-styled"  data-fouc value="Variable">
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
									<input type="radio" name="radio-styled-color" class="form-check-input-styled-danger"  data-fouc value="Emergency">
									Emergency (3 Hrs)
								</label>
							</div>
                        </div>
             	        <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color" class="form-check-input-styled-warning"  data-fouc value="Urgent">
									Urgent (24 Hrs)
								</label>
							</div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12" style="display:none">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color" class="form-check-input-styled-success"  data-fouc value="Essential">
									Essential (3 Days)
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-12" style="display:none">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color" class="form-check-input-styled-info"  data-fouc value="Normal">
									Normal (7 Days)
								</label>
							</div>
						</div>
	                   <div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-styled-color" class="form-check-input-styled" checked data-fouc value="Normal">
									Normal
								</label>
							</div>
						</div>
						
						
						
					</div>
					
				<br>
				<div class="row" >
				    <div class="col-lg-2 col-md-6 col-sm-12" >
								<span class="form-text text-muted font-weight-bold" ><font color="black"> Quote &nbsp;</font></span>
                        </div>
				    	<div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-quote" class="form-check-input-styled-success" checked data-fouc value="No">
									Quote Not Required
								</label>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-12" style="padding-top:8px">
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" name="radio-quote" class="form-check-input-styled-info"  data-fouc value="Yes">
									Quote Required 
								</label>
							</div>
                        </div>
             	       
                       
					<div class="col-lg-3 col-md-12 col-sm-12" id="div_quote_ref" >
								<input class="form-control" type="text" name="txt_quote_ref" id="txt_quote_ref" placeholder="Quotation Ref.No.">
								<!--<span class="form-text text-muted">Quote Date</span>-->
			        </div>

					  <div class="col-lg-3 col-md-12 col-sm-12" id="div_quote_date" style="display:none">
								<input class="form-control" type="date" name="txt_quote_date" id="txt_quote_date" >
								<span class="form-text text-muted">Quote Date</span>
			        </div>
					<div class="col-lg-3 col-md-12 col-sm-12" style="display:none" >
								<input class="form-control" type="date" name="txt_ticket_book_date_needed" id="txt_ticket_book_date_needed" >
								<span class="form-text text-muted">Date of Needed</span>
			        </div>
					<!--<div class="col-lg-2 col-md-12 col-sm-12" >-->
					<!--			<input class="form-control" type="date" name="txt_visit_date_search_sch" id="txt_ticket_book_visit_date" >-->
					<!--			<span class="form-text text-muted">Date of Schedule</span>-->
			  <!--      </div>-->
					</div>
					<div class="row" style="padding-top:20px;">
						<div class="col-lg-12 col-md-12 col-sm-12">
						    
								<div class="form-group">
									 	<span class="form-text text-muted font-weight-bold"><font color="black">Complaints &nbsp;</font></span>
									 	<textarea  rows="2" class="form-control" id="txt_complaints" placeholder="Type complaints here..."></textarea>
									 
						            <!--<div class="summernote-height">
						                
                        							
                					</div>-->
            					</div>
								    
						</div>
							
						
					</div>
				
						<div class="row">
				           
				        	<div class="col-lg-12 col-md-12 col-sm-12">
				        	    	<span class="form-text text-muted font-weight-bold"><font color="black">Choose services from the list below</font></span>
				        	    <table class="table datatable-selection-single" id="tbl_ticket_services">
            						<thead>
            							<tr>
            							    <th>Select Services</th>
            				            </tr>
            						</thead>
            						<tbody>
            						</tbody>
            					
            					</table>
				        	</div>
				    </div>
						
					
					<div class="row">
					 <div class="col-lg-4 col-md-6 col-sm-12">
    					<div class="card-body" >
    					     
    					    <input type="file" class="form-input-styled"  id="session_image" name="session_image" accept="image/*" />
    				        <b><i id="btn_remove_ticket_image" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
    					    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
    					   
    					</div>
				    </div>
				   <div class="col-md-2 col-sm-2">
								<div class="d-flex align-items-center" style="padding-top:30px">
									<i class="icon-image4 mr-3 icon-2x" id="i_image" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
									<input type="hidden" name="hidden_image_show" id="hidden_image_show" >
									
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-12">
    					<div class="card-body" >
    					     
    					    <input type="file" class="form-input-styled"  id="session_image2" name="session_image2" accept="image/*" />
    				        <b><i id="btn_remove_ticket_image2" data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2"></i></b>
    					    <!--<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
    					   
    					</div>
				    </div>
				   <div class="col-md-2 col-sm-2">
								<div class="d-flex align-items-center" style="padding-top:30px">
									<i class="icon-image4 mr-3 icon-2x" id="i_image2" data-popup="tooltip" title="View Image" data-placement="bottom"></i>
									<input type="hidden" name="hidden_image_show2" id="hidden_image_show2" >
									
								</div>
							</div>
					</div>
					
					  
				    <div class="row">
				        <div class="col-lg-9 col-md-9 col-sm-12"></div>
				        <div class="col-lg-3 col-md-3 col-sm-12">
				            <button type="button" id="btn_book_ticket" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Book Complaint</button>
				            
    					</div>
    				</div>
    			</div>
</div>