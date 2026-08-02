

	<div class="card">
					<?PHP
					
						include('template/card_head_control.inc');
					
					?>

					<div class="card-body">
					
					
						
							<div class="row">
							    
						     <input type="hidden" class="form-control" id="txt_building_id">
							 
						     <div class="col-lg-6 col-md-6 col-sm-12" >
						         <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Building Name &nbsp;<span style="color:red;">*</span></font></span>
								<input type="text" class="form-control" id="txt_building_name" placeholder="Building Name">
								
									
						
							</div>

								<div class="col-lg-6 col-md-6 col-sm-12" >
								    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Building Code &nbsp;<span style="color:red;">*</span></font></span>
									<input type="text" class="form-control" id="txt_building_code" placeholder="Building Code" onKeyPress="if(this.value.length==4) return false;">
									
										
							
								</div>

								
				
						</div>
						<div class="row">
						    
						    <div class="col-lg-6 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Address &nbsp;<span style="color:red;">*</span></font></span>    
									<textarea cols="1" class="form-control" id="txt_building_address" placeholder="Address"></textarea>
										
								</div>
						    
						</div>
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									
										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:10px;color:red;">
    									    <font><b>* Above all details are mandatory</b></font>
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_building_add" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_building_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_building_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Buildings</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_building">
						<thead>
							<tr>
							   
							    <th>Sl. No.</th>
								<th></th>
								<th>Building Code</th>
				                <th>Building Name</th>
				                <th>Address </th>
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
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!--single row selection -->
				