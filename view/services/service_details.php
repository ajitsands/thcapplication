

	<div class="card classServicesModify">
				 <div class="card-header header-elements-inline">
						<h5 class="card-title">Add Service
						    </h5>
						
					</div>

					<div class="card-body">
					
					
						
							<div class="row">
							    
						     	<?PHP include_once("category_combo.php"); ?>
						     	<div  class="col-lg-6 col-md-6 col-sm-12"  id="div_list_asset_type">
						     	
						     	       
						        </div>
								<div class="col-lg-6 col-md-6 col-sm-12">
                				
                					 	<span class="form-text text-muted font-weight-bold"><font color="black">Service &nbsp;<span style="color:red;">*</span></font></span>      
                					   <textarea rows="1" class="form-control" id="txt_service_desc" placeholder="Service " tabindex=2></textarea>
    										
                				
                					<input type="hidden" id="txt_service_id"/>
							    </div>
						
						</div>
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
										<div class="col-lg-6 col-md-6 col-sm-12">
										    </div>
										
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_services_add" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_services_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_services_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Services</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_services">
						<thead>
							<tr>
							   
							    <th>Sl. No.</th>
							    <th></th>
							    <th></th>
				                <th>Category Type</th>
				                <th></th>
				                <th>Asset Type</th>
				                <th>Service </th>
				                 <th>Status</th>
				                <th>Action</th>
				               
				                
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						<tfoot>
                            <tr>
                    			<th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                               
                               
                               
                                
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!--single row selection -->
				