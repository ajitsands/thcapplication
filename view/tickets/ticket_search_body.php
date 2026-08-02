
<input type="hidden" value="<?php echo $_GET['workordrnumber']; ?>" id="txt_workordrnumber" />
<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
}
</style>
<style>
    input[type='file'] {
  width: 95px;
 }
</style>
<?php include('modal_ticket_search_all_details.php');?>
<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Search Work Orders</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
							<!-- Single row selection -->
			
						<div class="row">
							    	    
					            	    <div class="col-lg-3 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_start_date" id="txt_start_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        										<span class="form-text text-muted">From Date</span>
							        </div>
								
							        <div class="col-lg-3 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        										<span class="form-text text-muted">To Date</span>
							        </div>
									<?PHP include("customer_combo.php"); ?>
							         <div class="col-lg-2 col-md-12 col-sm-12 " >
							        	<button type="button" id="btn_search_tickets" class="btn bg-info"  >Search</button>
							        </div>
					                </div>
				</div>
				<!-- /single row selection -->
			
				
					
					
	</div>
	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Work Orders</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body"  id="tabs">
						 <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#ticket-tab1" class="nav-link active" data-toggle="tab"  id="tab_tickets_not_assigned"><span class="badge badge-info badge-pill mr-2" id="span_count_not_assigned">0</span>Scheduled</a></li>
									<li class="nav-item"><a href="#ticket-tab2" class="nav-link" data-toggle="tab"  id="tab_tickets_assigned"><span class="badge bg-indigo badge-pill mr-2"id="span_count_assigned">0</span>Assigned </a></li>
    								<li class="nav-item"><a href="#ticket-tab3" class="nav-link" data-toggle="tab"  id="tab_tickets_extended"><span class="badge bg-orange badge-pill mr-2" id="span_count_extended">0</span>Request For Extend</a></li>
    								<li class="nav-item"><a href="#ticket-tab4" class="nav-link" data-toggle="tab"  id="tab_tickets_completed"><span class="badge bg-brown badge-pill mr-2" id="span_count_completed">0</span> Completed</a></li>
    								<li class="nav-item"><a href="#ticket-tab5" class="nav-link" data-toggle="tab"  id="tab_tickets_closed"><span class="badge bg-green badge-pill mr-2" id="span_count_closed">0</span>Closed</a></li>
    								<li class="nav-item"><a href="#ticket-tab6" class="nav-link" data-toggle="tab"  id="tab_tickets_cancelled"><span class="badge badge-secondary badge-pill mr-2"id="span_count_cancelled">0</span>Cancelled</a></li>
								</ul>
								<div class="tab-content" >
									<div class="tab-pane fade show active" id="ticket-tab1">
									 
									    <?PHP include_once('tickets/tickets_not_assigned_list.php');?>
									
									</div>
                                  
									<div class="tab-pane fade" id="ticket-tab2" style="padding-top:20px;">
									  
										<?PHP include_once('tickets/ticket_assigned_list.php');?>
										
									</div>
	                               <div class="tab-pane fade" id="ticket-tab3" style="padding-top:20px;">
									  
										<?PHP include_once('tickets/ticket_extended_list.php');?>
										
									</div>
									 <div class="tab-pane fade" id="ticket-tab4" style="padding-top:20px;">
									  
										<?PHP include_once('tickets/ticket_completed_list.php');?>
										
									</div>
									<div class="tab-pane fade" id="ticket-tab5" style="padding-top:20px;">
									  
										<?PHP include_once('tickets/ticket_closed_list.php');?>
										
									</div>
									<div class="tab-pane fade" id="ticket-tab6" style="padding-top:20px;">
									  
										<?PHP include_once('tickets/ticket_cancelled_list.php');?>
										
									</div>
								
								</div>
			
					
					
					
					
					
					
						
					</div>
				
					
					
	</div>
				
				
				

				