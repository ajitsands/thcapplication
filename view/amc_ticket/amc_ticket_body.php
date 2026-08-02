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
<?php include('assign_view_team.php');?>
<?php include('employee_expertise_modal.php');?>
<?php include('employee_current_schedule_modal.php');?>
<?php include('visit_reschedule_modal.php');?>

	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title"><?php if($_GET['type']=='ticket'){echo 'Ticket';} else {echo 'AMC';}?> Ref No - <span id="span_ticket_ref" class="badge bg-pink"><?php echo $_GET['ticket_amc_code'];?></span></h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
					<input type="hidden" value="<?php echo $_GET['ticket_amc_code'];?>" id="txt_ref_code"/>
					
					 <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details"></span><span class="badge bg-teal" id="span_location_details"></span><span class="badge bg-teal" id="span_building_details"></span></h5>
						<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_entries_ref_no">
						<thead>
							<tr>
							    
							     <th></th>
				                <th>Date of Schedule</th>
								<th>Time of Schedule</th>
								<th>Category</th>
				                <th>Type</th>
				                <th>Asset</th>
				                <th>Visit Status</th>
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
				
				
				

				