<div id="modal_view_ticket_details_search" class="modal fade" data-backdrop="false" tabindex="-1" >
					<div class="modal-dialog modal-lg"style="max-width:85%" >
						<div class="modal-content">
							<div class="modal-header bg-info">
							<h5 class="modal-title"><b>Work Order No : </b> <span id="span_ticket_ref_no_view_ticket_search"></span>
    							  </h5>
    							  	
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    
						<!-- Collapsible with different card styling -->
					
                        
                        <input type="hidden" id="txt_tkt_id"/>
                        <input type="hidden" id="txt_visit_id"/>
						<div>
							<div class="card">
								<div class="card-header header-elements-inline bg-success">
									<h6 class="card-title">
										<a data-toggle="collapse" class="text-white" href="#collapsible-styled-group1">View Details</a>
									</h6>
									<div class="header-elements">
										<div class="list-icons">
					                		<a id="a_workorder_print" class="list-icons-item" ><i class="icon-printer4"></i></a>
					                		
					                	</div>
				                	</div>
								</div>
								<div id="collapsible-styled-group1" class="collapse show">
									<div class="card-body">
									    	<div class="row">
            								    <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Priority:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_priority"></span>
            								  </div>
            								  <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Service Request:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_service_request"></span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black"> Category:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_job_category"></span>
            								  </div>
            								    
            								    
            								 <input type="hidden" id="txt_tkt_image_url"/>  
            								   
            							</div><!--row-->
            							<br>
									    <div class="row">
            								  
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Location:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_loc_details"></span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Building:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_build_details"></span>
            								  </div>
            								   <div class="col-lg-1 col-md-6 col-sm-6" ><span class="font-weight-black">Quote:</span>
            								  </div>
            								   <div class="col-lg-3 col-md-6 col-sm-6"  ><span id="span_quote_details"></span>
            								  </div>
            								 
            							</div><!--row-->
            							<br>
            						<div class="row">
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Add. Info :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_add_info"></span>
            								  </div>
            								  <div class="col-lg-2 col-md-6 col-sm-6" style="display:none"><span class="font-weight-black">Required Date:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" style="display:none"><span id="span_req_date"></span>
            								  </div>
            								  
            								   
            								    
            								   
            							</div><!--row-->
            							<br>
            							<div class="row">
            							     <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Customer:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_cust_details"></span>
            								  </div>
            								  <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Complaint :</span>
            								  </div>
            								   <div class="col-lg-4 col-md-6 col-sm-6" ><span id="span_complaint"></span>
            								  </div>
            								   <div class="col-lg-1 col-md-1 col-sm-1" ><span id="span_ticket_image"data-popup="tooltip" title="Complaint Image 1" data-placement="bottom"><i class="icon-attachment mr-3 icon-2x"></i></span>
            								  </div>
            								  
            								   <div class="col-lg-1 col-md-1 col-sm-1" ><span id="span_ticket_image2"data-popup="tooltip" title="Complaint Image 2" data-placement="bottom"><i class="icon-attachment mr-3 icon-2x"></i></span>
            								  </div>
            								  
            							</div><!--row-->
            								<br>
            							<div class="row">
            							    <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Book Date:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_booked_date"></span>
            								  </div>
            								  <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Visit Date:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_visit_date"> </span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Time Slots :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_visit_slots"></span>
            								  </div>
            								   
            								   <div class="col-lg-1 col-md-6 col-sm-6" style="display:none" ><span class="font-weight-black">Time :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" style="display:none" ><span id="span_visit_start_time"></span>
            								  </div>
            								  
            							</div><!--row-->
            						
            							<br>
            							<div class="row" id="div_close">
            								  <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Closed On:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_close_on"> </span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Closed By :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_close_by"></span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Remarks :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_close_remarks"></span>
            								  </div>
            								  
            							</div><!--row-->
            							<br>
            							<div class="row" id="div_close_service_report">
            								 <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Ser.Report#:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_report_no"></span>
            								  </div>
            								    <div class="col-lg-1 col-md-1 col-sm-1" ><span id="span_service_report_image"  data-popup="tooltip" title="Service Report" data-placement="bottom"><i class="icon-attachment mr-3 icon-2x"></i></span>
            								  </div>
            								    
            								 <input type="hidden" id="txt_tkt_service_reportimage_url"/>  
            								  
            							</div><!--row-->
            						
            								<br>
            							<div class="row" id="div_cancel">
            								  <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Cancel On:</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_cancel_on"> </span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Cancel By :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_cancel_by"></span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span class="font-weight-black">Remarks :</span>
            								  </div>
            								   <div class="col-lg-2 col-md-6 col-sm-6" ><span id="span_cancel_remarks"></span>
            								  </div>
            								  
            								  
            							</div><!--row-->
									</div>
								</div>
							</div>
                    	
							<div class="card">
								<div class="card-header bg-primary">
									<h6 class="card-title">
										<a class="collapsed text-white" data-toggle="collapse" href="#collapsible-styled-group2" id="a_view_team">View Team</a>
									</h6>
								</div>
								<div id="collapsible-styled-group2" class="collapse">
									<div class="card-body">
											<div class="row">
            								  <div class="col-lg-12 col-md-12 col-sm-12" >
                                    			 <table class="table table-hover datatable-highlight" id="tbl_view_team_search" style="padding-right:10px;padding-left:10px;">
                                    						<thead>
                                    							<tr>
                                    							    <th>#</th>
                                    							    <th>Emp. Code</th>
                                    							    <th>Emp. Name</th>
                                    							    <th>Contact No</th>
                                    							    <th>Team Leader</th>
                                    							    <th>Attend</th>
                                    							
                                    							</tr>
                                    						</thead>
                                    						
                                    				</table>
            							        </div>
            								</div>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header bg-purple">
									<h6 class="card-title">
										<a class="collapsed text-white" data-toggle="collapse" href="#collapsible-styled-group3" id="a_view_services">View Services</a>
									</h6>
								</div>
								<div id="collapsible-styled-group3" class="collapse">
									<div class="card-body">
										<div class="row">
        								  <div class="col-lg-12 col-md-12 col-sm-12" >
                                			    <div id="div_services_list"></div>
        							        </div>
        								</div>

									</div>
								</div>
							</div>
						</div>
						<!-- /collapsible with different card styling -->

							</div>

							<div class="modal-footer">
								<!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								
							</div>
						</div>
					</div>
				</div>
			