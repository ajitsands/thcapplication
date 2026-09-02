

	<div class="card classCustomerFacilityModify">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Customer Facilities
						    </h5>
						
					</div>

					<div class="card-body">
					
					
						
							<div class="row">
							    
							    <div class="col-lg-5 col-md-5 col-sm-11" id="div_customer_details">	
							    </div>
						     	<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:30px;" id="div_plus_location_modal">
								        <button type="button" class="btn btn-primary btn-sm" id="btn_add_customer"  data-toggle="modal" data-target="#modal_customer_add">+</button></td>
								    </div>
								
								<div class="col-lg-5 col-md-5 col-sm-11" id="div_customer_location_details">	
									<?PHP //include_once("location_combo_customer_location.php"); ?>
								
    								
							    </div>
							    	<input type="hidden" class="form-control" id="txt_contact_person_building_code" maxlength="4" style="text-transform: uppercase"   placeholder="Building CODE">
										<input type="hidden" class="form-control" id="txt_contact_person_building_name"   placeholder="Facility Name">
						     <div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:30px;" id="div_plus_location_modal">
								        <button type="button" class="btn btn-primary btn-sm" id="bootbox_location_btn" >+</button></td>
								    </div>
								<div class="col-lg-6 col-md-6 col-sm-12" id="div_contact_person_building_name">
                					
            					     <div class="card-body" >
            					         <span class="form-text text-muted font-weight-bold"><font color="black">Facility Name &nbsp;<span style="color:red;">*</span></font></span>
                					   
    									    
								    </div>
                				

							    </div>
						
					<!--	</div>
						<div class="row">-->
						      <div class="col-lg-5 col-md-5 col-sm-11" id="div_select_building">	
                            
                               
                                </div>
						    	
							    <div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:30px;" id="div_plus_location_modal">
								        <button type="button" class="btn btn-primary btn-sm" id="bootbox_building_btn" >+</button></td>
								    </div>
							    <div class="col-lg-6 col-md-6 col-sm-12">
                					       <span class="form-text text-muted font-weight-bold"><font color="black">Facility Address </font></span>    
    										<textarea rows="1" class="form-control" id="txt_Building_address" placeholder="Facility Address" tabindex=4></textarea>
    											
								</div>
    								 
						    
						<!--</div>	
						<div class="row">-->
							     
							     
							    
							    <div class="col-lg-6 col-md-6 col-sm-12">
                					
                					     <!--<div class="card-body" >-->
                					         <span class="form-text text-muted font-weight-bold"><font color="black">Contact Person Name </font>  
                					   	<input type="text" class="form-control" id="txt_contact_person_name" placeholder="Contact Person Name">
    									 
    								 
                					 <!--</div>-->
                					<input type="hidden" id="txt_customer_location_id"/>
							    </div>
						     	
								 <div class="col-lg-6 col-md-6 col-sm-12">
                				<!--	<div class="card-body" >-->
                					    <span class="form-text text-muted font-weight-bold"><font color="black">Contact Person Number </font>      
                					   	<input type="text" class="form-control" id="txt_contact_person_number_build" onkeypress="return event.charCode >= 48 && event.charCode <= 57"   placeholder="Contact Person Number">
    									
    								 
                					<!-- </div>-->

							    </div>
							    
							    <div class="col-lg-6 col-md-6 col-sm-12">
                    					<!--<div class="card-body" >-->
                    					     <span class="form-text text-muted font-weight-bold"><font color="black">Facility Image&nbsp;</font></span>	
                    					    <input type="file" class="form-input-styled"  id="session_image" accept="image/*" title="&nbsp;" data-fouc=""/><p id="building_img_name"></p>
                    					   <!-- <div id="building_img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>-->
                    					   
                    					<!--</div>-->
    							    </div>
    							    <div class="col-lg-6 col-md-6 col-sm-12" style="padding-top: 28px;">
                    					    <div id="building_img_preview" style="display: flex; align-items: center; min-height: 38px;"> </div>
    							    </div>
						
						</div>
						
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									
										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:10px;color:red;">
    									    
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_customer_location_add" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_customer_location_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_customer_location_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Customer Facilities</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_customer_location">
						<thead>
							<tr>
							   
							    <th>Sl. No.</th>
							    <th></th>
							    <th></th>
				                <th>Customer</th>
				                <th></th>
				                <th>Location</th>
				                <th></th>
				                <th>Facility Image</th>
				                <th>Facility</th>
				                 <th>Facility Address</th>
				                <th>Contact Name</th>
				                <th>Contact Number</th>
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
				
					<?PHP include("tickets/location_modal.php");?>
					<?PHP include("amc/building_modal.php");?>
				<div id="modal_customer_add" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Customer</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
						            <div class="col-lg-6 col-md-6 col-sm-12">
						                	<span class="form-text text-muted font-weight-bold"><font color="black">Customer Name &nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_customer_name" placeholder="Customer Name" >
    									     
											  <input type="hidden" class="form-control" id="txt_customer_id">
    									</div>  
										
										<div class="col-lg-6 col-md-6 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_customer_contact_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Contact Number">
    									
    											
    								
    									</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email Id</font></span>
    										<input type="text" class="form-control" id="txt_customer_email_id" placeholder="Email Id">
    									
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12" >
										     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Alternate Contact Number</font></span>
    										<input type="text"  class="form-control" id="txt_alternate_contact_no" placeholder="Alternate Contact Number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
    									
    									</div>
										
						        	   
    									 <div class="col-lg-6 col-md-6 col-sm-12" >
    									     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">CPR/CR Number </font></span>
    										<input type="text"  class="form-control" id="txt_cpr_cr_number"  placeholder="CPR/CR Number" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
    									
    											
    								
    									</div>
    									
    										<div class="col-lg-6 col-md-6 col-sm-12" >
    										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">VAT Number &nbsp;</font></span>
    										<input type="text" class="form-control" id="txt_vat_number" placeholder="VAT Number">
    										
    											
    								
    									</div>
    								    <div class="col-lg-6 col-md-6 col-sm-12" >
    								        <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Person Name</font></span>
    										<input type="text" class="form-control" id="txt_contact_person" placeholder="Contact Person Name">
    										
    											
    								
    									</div>
								        <div class="col-lg-6 col-md-6 col-sm-12" >
								            <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Person Number</font></span>
    										<input type="text" class="form-control" id="txt_contact_person_number"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"  placeholder="Contact Person Number" >
    										
    											
    								
    									</div>
							        
							        </div>
							        
						        </div>
						        
							

							<div class="modal-footer">
							    <button type="button" class="btn bg-info" id="btn_customer_add">Add</button>
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
							</div>
					</div>
				</div>
				