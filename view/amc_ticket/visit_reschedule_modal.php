	
			
				<div id="modal_visit_reschedule" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><b>Reschedule Visit : <span class="badge bg-pink" id="span_ticket_ref_no_visit_reschedule"></span></span></b>
    							  </h5>
    							          
								<div id="selected_items" style="font-size:15px;color:red;padding-top:2px;"></div>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
						<input type="hidden" id="txt_visit_id_reschedule"/>
							
					       <div class="row">
					           <div class="col-lg-6 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_visit_date_rech" id="txt_visit_date_rech" >
        										<span class="form-text text-muted">Reschedule Date</span>
							        </div>
							     <div class="col-lg-6 col-md-12 col-sm-12 pull-right" >
        								<input class="form-control" type="time" name="txt_visit_time_resch" id="txt_visit_time_resch" >
										<span class="form-text text-muted">Reschedule Time</span>
							        </div>
        				       
					       </div>
				
						
							</div>

							<div class="modal-footer">
							    <button type="button" class="btn btn-link bg-indigo" data-dismiss="modal" id="btn_resch_visit1">Reschedule</button>
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
							
							</div>
						</div>
					</div>
				</div>
		
				