	                   <div class="card">
	                       <div class="card-header header-elements-inline">
						<h5 class="card-title">Work Order Booking
						    </h5>
						<div class="header-elements">
							<div class="list-icons">
		                		 <button type="button" id="btn_check_availability" class="btn bg-green-400 " data-toggle="modal" data-target="#modal_check_avail" data-popup="tooltip" title="Check Availability" data-placement="bottom"><i class="icon-user-check"></i></button>
		                		<button type="button" id="btn_new_ticket" class="btn bg-blue-400 " data-popup="tooltip" title="New Ticket" data-placement="bottom" ><b><i class="icon-reset"></i></b></button>
    				            
		                	</div>
	                	</div>
					</div>
	                            
					            
					            <?php  include('check_availability_modal.php');?>
                		   
					   
	                          
                				
	                       <div class="card-body" id="tabs">
	                           
	                           <input type="hidden" class="form-control" id="txt_hidden_ticket_ref_val">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_id">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_code">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_contact_no">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_location_id">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_location_code">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_location_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_building_id">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_building_code">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_building_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_id">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_category_id">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_category_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_type_id">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_type_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_zone">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_flat">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_customer_asset_room">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_ref_val">
	                            <input type="hidden" class="form-control" id="txt_hidden_ticket_ref_code">
	                            
	                            <input type="hidden" class="form-control" id="txt_hidden_contact_person_name">
	                            <input type="hidden" class="form-control" id="txt_hidden_contact_person_no">
	                                
	                          <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details"></span><span class="badge bg-teal" id="span_location_details"></span><span class="badge bg-teal" id="span_building_details"></span><span class="badge bg-teal" id="span_asset_details"></span><span class="badge bg-pink" id="span_ticketref_code"></span><span class="badge bg-green" id="span_workorder_code"></span></h5>
	                          
	                            <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#ticket-tab1" class="nav-link active" data-toggle="tab"  id="tab_customer">Select / Create Customer</a></li>
								
									<li class="nav-item"><a href="#ticket-tab3" class="nav-link" data-toggle="tab"  id="tab_location">Select Customer Building</a></li>
									<li class="nav-item"><a href="#ticket-tab4" class="nav-link" data-toggle="tab"  id="tab_assets">Select Assets</a></li>
									<li class="nav-item"><a href="#ticket-tab5" class="nav-link" data-toggle="tab"  id="tab_book_complaints">Book </a></li>
									<li class="nav-item"><a href="#open_ticket-tab6" class="nav-link" data-toggle="tab"  id="tab_open_complaints"> WO. - Opened</a></li>
								
								</ul>

								<div class="tab-content" >
									<div class="tab-pane fade show active" id="ticket-tab1">
									 <?PHP include("tickets/customer_modal.php"); ?>
									    <?PHP include_once('tickets/customer.php');?>
									
									</div>
                                    <!--<div class="tab-pane fade" id="ticket-tab2">
										<?PHP //include_once('tickets/customer_location_details.php');?>
										
									</div>-->
									<div class="tab-pane fade" id="ticket-tab3" >
									  
									   <?PHP include_once('tickets/ticket_customer_building.php');?>
									    <?PHP include("tickets/location_modal.php"); ?>
									   <?PHP include("tickets/building_modal.php"); ?>
									   <?PHP include("tickets/customer_building_modal.php"); ?>
									   <?PHP include("tickets/previous_work_order_building_modal.php"); ?>
										<?PHP //include_once('tickets/ticket_location_building.php');?>
										
									</div>
	                                <div class="tab-pane fade" id="ticket-tab4">
									   <?PHP include("tickets/customer_assets_modal.php"); ?>
									    <?PHP include_once('tickets/amc_assets_list.php');?>
										<?PHP include("tickets/previous_work_order_asset_modal.php"); ?>
										
									</div>
									<div class="tab-pane fade" id="ticket-tab5">
									   <?php include("tickets/asset_category_modal.php");?>
				                         <?php include("tickets/asset_type_modal.php");?>
				                         <?php include("tickets/add_service_modal.php");?>
									    <?PHP include_once('tickets/ticket_priority.php');?>
										
									</div>
									
                                    <div class="tab-pane fade" id="open_ticket-tab6">
									   
									    <?PHP include_once('tickets/ticket_pending_list_body.php');?>
										
									</div>
									
								</div>
							</div>
						</div>