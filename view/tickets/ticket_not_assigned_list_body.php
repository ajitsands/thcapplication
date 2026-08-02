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
<?php include('view_ticket_modal_not_assigned.php');?>
<?php include('view_ticket_modal_cancel_modal.php');?>
<?php include('change_status_ticket_modal.php');?>
<?php include('ticket_entry_cancel_modal.php');?>
<?php //include('view_services_modal.php');?>
<?php include('schedule_ticket_not_assigned.php');?>
<?php include('assign_team_not_assigned.php');?>
<?php //include('view_schedules_not_assigned_modal.php');?>
<?php include('view_service_modal_extended.php');?>
<?php include('view_tech_expertise_modal_multiple.php');?>
<?php include('technician_schedules_modal_multiple.php');?>

	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Scheduled - Not Assigned Work Orders</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
					
						<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_of_not_assigned_tickets">
						<thead>
							<tr>
							    
							    <th>SL. No.</th>
				                <th>Date & Time</th>
								<th>Ref. No.</th>				                
				                <th>Customer</th>
				                <th>Location</th>
				                <th>Building</th>
				                <th>Priority</th>
				                <th>Action</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				</div>
				<!-- /single row selection -->
					
					
					
					
					
					
						
					</div>
				
					
					
	</div>
				
				
				

				