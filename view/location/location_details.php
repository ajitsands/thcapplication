<div class="row">
	<div class="card col-md-6" >
					<?PHP
					
						include('template/card_head_control.inc');
					
					?>
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
										<div class="col-lg-12 col-md-12 col-sm-12" >
										    
										    <input type="hidden" class="form-control" id="txt_location_id">
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Location Name&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_location_name" placeholder="Location Name">
    											
    								
    									</div>
    									
								
								</div>
									<div class="form-group row">
									   
										
										<div class="col-lg-12 col-md-12 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Location Code&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_location_code" placeholder="Location Code" maxlength="2" >
    											
    								
    									</div>
    									
								
								</div>
								
								
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									    <div class="col-lg-6 col-md-6 col-sm-12">
										</div>
									
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_location_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_location_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_location_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
				</div>
				
				    
			    </div>	
					
					
	</div>
	
	<div class="col-md-6" >
				
				<div class="row">
						
			
			        <div class="col-md-12">
			    
			   <!-- Single row selection -->
				<div class="card" style="overflow:auto;" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of location</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_location">
						<thead>
							<tr>
						
							    <th>Sl. No.</th>
							    <th>ID</th>
				                <th>Loc. Name</th>
				                 <th>Loc. Code</th>
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
                               
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection --> 
			 </div>
				    
			    </div>	
					
					
	</div>
				
</div>				
				
	
				