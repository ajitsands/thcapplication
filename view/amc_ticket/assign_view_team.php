	
			
				<div id="modal_visit_team" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><b>Assign / View Team : <span class="badge bg-pink" id="span_ticket_ref_no_assign_tem"></span></b>
    							  </h5>
    							          
								<div id="selected_items" style="font-size:15px;color:red;padding-top:2px;"></div>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<input type="hidden" id="txt_hidden_ticket_ref_code_assign_team"/>
								<input type="hidden" id="txt_hidden_ticket_id_assign_team"/>
								<input type="hidden" id="txt_hidden_date_assign_team"/>
								<input type="hidden" id="txt_hidden_time_assign_team"/>
								<input type="hidden" id="txt_hidden_visit_id_assign_team"/>
								
							<div class="row">
					            <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details_assign_team"></span><span class="badge bg-teal" id="span_location_details_assign_team"></span><span class="badge bg-teal" id="span_building_details_assign_team"></span><span class="badge bg-teal" id="span_date_assign_team"></span><span class="badge bg-teal" id="span_time_assign_team"></span></h5>
					        </div>
					      
								<div class="row">
								     <div class="col-lg-12">
							            <span class="card-title" style="color:purple;"><h6>List of team members assigned to the visit</h6></span>	
							            	<table  class="table   datatable-selection-single table-hover datatable-highlight " id="tbl_assigned_team" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							   
														<th > No</th>
                        							    <th>Employee</th>
                        							    <th>Leader/Technician</th>
                        								<th>Actions</th>
                        								
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							         </div>
							         <br><br>
							        <div class="row">
							        <div class="col-lg-12">
							             <span class="card-title" style="color:purple;"><h6>For assigning team, select technicians from the list below and click Assign button</h6></span>	
							            	<table  class="table datatable-selection-single" id="tbl_employee" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							   
														<th > No</th>
                        							    <th>Employee</th>
                        							    <th>Contact No</th>
                        								<th>Actions</th>
                        								
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							        
						        </div>

				    <br>
				   <div class="row">
				        <div class="col-lg-10"></div>
				        <div class="col-lg-2">
				             <button type="button" class="btn bg-purple"  id="btn_assign">Assign</button>
					    </div>	
					</div>
					
				
				
						<br>
			
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
							
							</div>
						</div>
					</div>
				</div>
		
				