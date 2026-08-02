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
<input type="hidden"  id="txt_customer_id" >
	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Select Customer Building</h5>
						<div class="header-elements">
						<div class="list-icons">
				                		<!--<button type="button" data-popup="tooltip" title="Add New Location" data-placement="bottom" class="btn btn-default btn-sm" id="btn_add_new_location" data-toggle="modal" data-target="#modal_location">	<i class="icon-location4"></i></button></td>-->
					                 <!--  <button type="button" data-popup="tooltip" title="Add New Building" data-placement="bottom" class="btn btn-default btn-sm" id="btn_add_new_building" data-toggle="modal" data-target="#modal_building">	<i class="icon-home8"></i></button></td>-->
						                <!--<button type="button" data-popup="tooltip" title="Add New Customer Building" data-placement="bottom" class="btn btn-default btn-sm" id="btn_add_new_customer_building" data-toggle="modal" data-target="#modal_customer_building">	<i class="icon-reading"></i></button></td>-->
										
				                    	<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal_location"><i class="icon-location4"></i> Add To Location Master</button>
				                    	<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal_building"><i class="icon-home8"></i> Add To Facility Master</button>
				                		<button type="button" class="btn btn-outline-info" id="btn_assign_customer_building1" data-toggle="modal" data-target="#btn_add_new_customer_building" > <i class="icon-drawer-out"></i> Assign Facilities To Customer</button>
										
				                	</div>
									
	                	</div>
						
					</div>
					<div class="row">
						<div class="col-md-12 text-right" style="margin-top:2px;">
							<button type="button" class="btn btn-outline-info" id="btn_view_work_order_building" data-toggle="modal" data-target="#modal_previous_workorder" disabled style="margin-right: 24px;">
								<i class="icon-eye"></i> View Previous Work Order
							</button>
						</div>
					</div>

					<div class="card-body" style="">
					
						<!-- Single row selection -->
			
					<table class="table datatable-selection-single" id="list_ofticket_customer_building">
						<thead>
							<tr>
							   
							    <th width="20%">Sl. No.</th>
				                <th width="20%">Location</th>
								<th width="20%">Facility </th>				 
								<th width="40%">Contact Point</th>
				                <th width="20%">Address</th>
				                
				                <th width="20%">Status</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
			
				<!-- /single row selection -->
					
					
					
					
					
					
					
					
						
					
						
									
						
					</div>
					
				
					
					
	</div>
				
				
				

				