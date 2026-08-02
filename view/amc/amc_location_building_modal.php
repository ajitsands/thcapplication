
					<div id="add_new_building_assets" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Location/Building Details</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">

										<!--Assets modal-body -->
										<div class="row">
											
										<div class="col-md-12">

											<div class="card-body">

												<div class="row">
													<div class="col-lg-4 col-md-6 col-sm-12" id="div_cust_load_modal">	
													</div>
													<?PHP //include_once("customer_combo_customer_location_modal.php"); ?>
													
													<div class="col-lg-4 col-md-6 col-sm-12" id="">	
													<?PHP include_once("location_combo_customer_location_modal.php"); ?>
													<input type="hidden" class="form-control" id="txt_contact_person_building_name" placeholder="Building Name">
														</div>
													
												
															 
															
															<div class="col-lg-4 col-md-6 col-sm-12" id="">	
															<?PHP include_once("select_building.php"); ?>
													</div>
													
                        						    	
						        
											
											</div>
											
											<div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12" id="div_contact_person_building_code">
                                        					<div class="card-body" >
                                        					     
                                        					   	<input type="text" class="form-control" id="txt_contact_person_building_code" maxlength="4" style="text-transform: uppercase"   placeholder="Building code">
                            									<span class="form-text text-muted"><font color="black">BUILDING CODE &nbsp;<span style="color:red;">*</span></font></span>    
                            								 
                                        					 </div>
                        
                        							    </div>
														   <div class="col-lg-3 col-md-6 col-sm-12">
																<textarea cols="1" class="form-control" id="txt_Building_address" placeholder="Building address"></textarea>
																	<span class="form-text text-muted"><font color="black">BUILDING ADDRESS &nbsp;<span style="color:red;">*</span></font></span>    
															</div>

													<div class="col-lg-3 col-md-6 col-sm-12">
														
															 <div class="card-body" >
															<input type="text" class="form-control" id="txt_contact_person_name" placeholder="Contact person name">
															<span class="form-text text-muted"><font color="black">CONTACT PERSON NAME &nbsp;<span style="color:red;">*</span></font></span>    
														 
														 </div>
														<input type="hidden" id="txt_customer_location_id"/>
													</div>
													
													<div class="col-lg-3 col-md-6 col-sm-12">
															<div class="card-body" >
																 
																<input type="text" class="form-control" id="txt_contact_person_number_build" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false"  placeholder="Contact Person Number">
																<span class="form-text text-muted"><font color="black">CONTACT PERSON NUMBER &nbsp;<span style="color:red;">*</span></font></span>    
															 
															 </div>

														</div>
											</div>
		
										</div>

									</div>
									
									</div>   

							</div> <!--building_modal-body end -->

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" id="btn_customer_location_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
								
							</div>
						</div>
					</div>
				</div>		
				