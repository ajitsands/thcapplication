		<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Customer Locations & Buildings </h5>
					
					</div>

				

					<table class="table datatable-selection-single" id="list_of_customer_location_building">
						<thead>
							<tr>
							   
							    <th>Sl No</th>
				                <th>Location</th>
				                <th>Building</th>
				                 <th>Building Address</th>
				                <th>Contact Name</th>
				                <th>Contact #</th>
				                 <th>Status</th>
				               
				                
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				</div>
				<!--single row selection -->
							


    	<div class="card">
	            	<div class="card-header header-elements-inline">
						<h5 class="card-title">New Location & Building </h5>
					
					</div>
					

					<div class="card-body">
					    <?PHP //include("location_modal.php"); ?>
					
							<div class="row">
							    
							   
								<div class="col-lg-4 col-md-6 col-sm-12" id="div_customer_location_details">	
									<?PHP include("location_combo.php"); ?>
							    </div>
							   <div class="col-md-1 col-sm-1">
							       <button type="button" class="btn btn-primary btn-sm" id="btn_refresh_location" data-toggle="modal" data-target="#modal_location1">	<i class="icon-plus-circle2"></i></button></td>
							
							</div>
						                    
									<div  class="col-lg-2 col-md-2 col-sm-12">
						     	
						     	       
                					     
                					   	<select data-placeholder="Select Type" id="sel_new_existing" name="sel_new_existing" class="form-control form-control-select2" data-fouc>
                                        
                                         <option value="select">Select Type</option>
                                             <option value="New">New</option>
                                             <option value="Existing">Existing</option>
                                            
                                          </select>
    								
                					
						        </div>
						         <div class="col-lg-2 col-md-6 col-sm-12" id="div_building_code">
                					
                					     
                					   	<input type="text" class="form-control" id="txt_building_code" maxlength="4"   placeholder="Building Code">
    									<span class="form-text text-muted"><font color="black">Building Code &nbsp;<span style="color:red;">*</span></font></span>    
    								 
                					 

							    </div>
							     <div class="col-lg-3 col-md-6 col-sm-12" id="div_building_name">
                				
                					   	<input type="text" class="form-control" id="txt_building_name"   placeholder="Building Name">
    									<span class="form-text text-muted"><font color="black">Building Name &nbsp;<span style="color:red;">*</span></font></span>    
								

							    </div>
						    	<?PHP include_once("customer_building.php"); ?>
						        
							
						
						</div>
						
						<div class="row">
							     
							    
						    
                					
                					   <div class="col-lg-6 col-md-6 col-sm-12">
    										<textarea cols="1" class="form-control" id="txt_building_address" name="txt_building_address" placeholder="Building Address"></textarea>
    											<span class="form-text text-muted"><font color="black">Building Address &nbsp;<span style="color:red;">*</span></font></span>    
    									</div>
    								 
                					
                				
							    
							    <div class="col-lg-3 col-md-6 col-sm-12">
                					
                					     <div class="card-body" >
                					   	<input type="text" class="form-control" id="txt_contact_person_name" placeholder="Contact Person Name">
    									<span class="form-text text-muted"><font color="black">Contact Person Name &nbsp;</font></span>    
    								 
                					 </div>
                					<input type="hidden" id="txt_customer_location_id"/>
							    </div>
						     	
								 <div class="col-lg-3 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_contact_person_number_build" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false"  placeholder="Contact person No.">
    									<span class="form-text text-muted"><font color="black">Contact Person No. &nbsp;</font></span>    
    								 
                					 </div>

							    </div>
						
						</div>
						
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									
										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:10px;color:red;">
    									    
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_customer_location_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
