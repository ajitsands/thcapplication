<input type="hidden"  id="txt_amc_id" >
<input type="hidden"  id="txt_amc_ref_no" >
  <?php  include('update_schedule_modal.php');?> 
  <?php  include('view_expertise_modal.php');?> 
  <?php  include('view_schedules_modal.php');?> 
    <?php  include('view_services_modal.php');?> 
    <?php  include('view_team_modal.php');?> 
	                   <div class="card">
	                       <div class="card-header header-elements-inline">
						<h5 class="card-title">Assign Technicians To AMC WO.
						    </h5>
						<div class="header-elements">
							<div class="list-icons">
		                		 <button type="button" id="btn_check_availability" class="btn bg-green-400 " data-toggle="modal" data-target="#modal_check_avail" data-popup="tooltip" title="Check Availability" data-placement="bottom"><i class="icon-user-check"></i></button>
		                		<button type="button" id="btn_reload" class="btn bg-blue-400 " data-popup="tooltip" title="Reload Page" data-placement="bottom" ><b><i class="icon-reset"></i></b></button>
    				            
		                	</div>
	                	</div>
					</div>
	                            
					            
					            <?php  include('check_availability_modal.php');?>
                		   
					   
	                       
                				
	                       <div class="card-body" id="tabs">
	                           
	                          
	                                
	                          <h5 class="card-title"> <span class="badge bg-teal" id="span_amc_details"></span></h5>
	                          
	                            <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#ticket-tab1" class="nav-link active" data-toggle="tab"  id="tab_customer">Select AMC</a></li>
								
								
									<li class="nav-item"><a href="#ticket-tab4" class="nav-link" data-toggle="tab"  id="tab_scheduled_visits">List of Scheduled WO.</a></li>
									<li class="nav-item"><a href="#ticket-tab6" class="nav-link" data-toggle="tab"  id="tab_assign_tech">Assign Technician</a></li>
									<li class="nav-item"><a href="#ticket-tab5" class="nav-link" data-toggle="tab"  id="tab_assigned_list">List of Assigned WO.</a></li>
								
								
								</ul>

								<div class="tab-content" >
									<div class="tab-pane fade show active" id="ticket-tab1">
									
									    <?PHP include_once('amc_schedule/amc_list_in_assign.php');?>
									
									</div>
                                   
								
	                                <div class="tab-pane fade" id="ticket-tab4">
									   
									    <?PHP include_once('amc_schedule/amc_list_of_scheduled_visits.php');?>
										
									</div>
									<div class="tab-pane fade" id="ticket-tab5">
									   
									    <?PHP include_once('amc_schedule/amc_assigned_list.php');?>
										
									</div>
									<div class="tab-pane fade" id="ticket-tab6">
									   
									    <?PHP include_once('amc_schedule/amc_assign_team.php');?>
										
									</div>
                                   
									
								</div>
							</div>
						</div>