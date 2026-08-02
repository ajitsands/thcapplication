	
			
				<div id="modal_emp_view_schedule" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><b>Employee : <span  id="span_employee_schedule_details"></span></b>
    							  </h5>
    							          
								<div id="selected_items" style="font-size:15px;color:red;padding-top:2px;"></div>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
						<input type="hidden" id="txt_emp_id_cur_sch"/>
								<div class="row">
								     <div class="col-lg-12">
							            	
							            	<table  class="table  table datatable-selection-single " id="tbl_employee_cur_schedules" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							   
													 <th>No</th>
                        							    <th>Location</th>
                        							    <th>Building</th>
                        							    <th>Date of Visit</th>
                        							    <th>Time of Visit</th>
                        								
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							         </div>
				<br><br>
					       <div class="row">
					           <div class="col-lg-3 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_visit_date_search_sch" id="txt_visit_date_search_sch" >
        										<span class="form-text text-muted">Visit Date</span>
							        </div>
							      
        				        <div class="col-lg-1">
        				             <button type="button" class="btn bg-slate" data-popup="tooltip" title="Search Visit Schedules" data-placement="bottom" id="btn_search_emp_sch"><i class="icon-search4"></i></button>
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
		
				