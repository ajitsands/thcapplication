
<div class="row">
	<div class="card col-md-12" >
					<?PHP
					
						include('template/card_head_control.inc');
					
					?>
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
									<div class="col-lg-4 col-md-4 col-sm-12" id="div_project_select">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Project &nbsp;</font></span>
                                        
            				        </div>
            				        <div class="col-lg-4 col-md-4 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Description</font></span>
										    
    										<textarea rows="1" type="text" class="form-control" id="txt_description" placeholder="Description"></textarea>
    											
    								
    									</div>
									 <div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Location</font></span>
									    
										<input  type="text" class="form-control" id="txt_location" placeholder="Location">
											
								
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Place</font></span>
									    
										<input  type="text" class="form-control" id="txt_place" placeholder="Place">
											
								
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Part</font></span>
									    
										<input  type="text" class="form-control" id="txt_part" placeholder="Part">
											
								
									</div>
									 <div class="col-lg-4 col-md-4 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">THC Comments</font></span>
										    
    										<textarea rows="1" type="text" class="form-control" id="txt_comments" placeholder="THC Comments"></textarea>
    											
    								
    									</div>
    									<div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Category</font></span>
									    <select class="form-control form-control-select2 " id="txt_category" name="txt_category" data-placeholder="Select Category" data-fouc>
                                	    <option value="NA" selected>Select Category</option>
                                	    
                                	    
                                          <option value="Civil" >Civil</option>
                                          <option value="Electrical" >Electrical</option>
                                          <option value="Mechanical" >Mechanical</option>
                                          <option value="Plumbing" >Plumbing </option>
                                          <option value="HVAC" >HVAC</option>
                                          <option value="Fire" >Fire</option>
                                          <option value="IT" >IT</option>
                                          <option value="Others" >Others</option>
                                      
                                      </select>
										<!--<input  type="text" class="form-control" id="txt_category" placeholder="Category">-->
											
								
									</div>
    									<div class="col-lg-4 col-md-4 col-sm-12" >
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Priority &nbsp;</font></span>
            				           	    	  <select class="form-control form-control-select2 " id="select_priority" name="select_priority" data-placeholder="Select Priority" data-fouc>
                                	    
                                          <option value="Minor" selected>Minor</option>
                                          <option value="Major" >Major</option>
                                      
                                      </select>
                                        
            				        </div>
            				            
            				        
                                       
					 <div class="col-lg-6 col-md-6 col-sm-12" id="parent_file_card">
    					<div id="file_card"> 
    					      <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Pic</font></span>
    					              
    					    <input type="file" class="form-input-styled"  id="session_image" name="session_image" accept="image/png, image/gif, image/jpeg" onchange="readURL(this);"/>
    				        </div>
    				       
    					  
    					   
    				
				    </div>
				   <div class="col-lg-6 col-md-6 col-sm-12" id="div_preview">
								<div class="d-flex align-items-center" style="padding-top:30px">
								
									 <img id="preview" src="#"  width="300" height="300"/>
									 
									<input type="hidden" name="hidden_image_show" id="hidden_image_show" >
									
								</div>
								<br>
									 <b><i  data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2 img_remove"></i></b>
							</div>
						
				
    										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:30px">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_project_add" class="btn btn-primary " ><b></b>Add</button>
    										
    										
    										<button type="button" id="btn_project_new" class="btn btn-success"  ><b></b>Reset</button>
    									</div>
    								
								
								</div>
								
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
				
				</div>
				
				    
			    </div>	
			    	
					
				
	</div>
	

				
</div>				
				
<div class="row">
						
			
			        <div class="card col-md-12">
			    
			   <!-- Single row selection -->
				<div class="" style="overflow:auto;" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title" id="h5_project_title"></h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-responsive-row-control" id="list_of_project_entries">
						<thead>
							<tr>
						
							    <th>Sl. No.</th>
							    <th>Action</th>
				                <th>Description</th>
				                <th>Location</th>
				                <th>Place</th>
				                <th>Parts</th>
				                <th>Category</th>
				                <th>Comments</th>
				                <th>Priority</th>
				                <th>Pic</th>
				                
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
                               
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection --> 
			 </div>
				    
			    </div>
				
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4>View Pic</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        
      </div>
      <div class="modal-body" style="overflow:scroll;">
        <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	

<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4>Edit Entries</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        
      </div>
      <div class="modal-body" >
          <div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										<input type="hidden" name="hidden_project_entries_id_edit" id="hidden_project_entries_id_edit" >
									<div class="col-lg-4 col-md-4 col-sm-12" id="div_project_select_edit" style="display:none">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Project &nbsp;</font></span>
                                        
            				        </div>
            				        <div class="col-lg-4 col-md-4 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Description</font></span>
										    
    										<textarea rows="1" type="text" class="form-control" id="txt_description_edit" placeholder="Description"></textarea>
    											
    								
    									</div>
									 <div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Location</font></span>
									    
										<input  type="text" class="form-control" id="txt_location_edit" placeholder="Location">
											
								
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Place</font></span>
									    
										<input  type="text" class="form-control" id="txt_place_edit" placeholder="Place">
											
								
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Part</font></span>
									    
										<input  type="text" class="form-control" id="txt_part_edit" placeholder="Part">
											
								
									</div>
									 <div class="col-lg-4 col-md-4 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">THC Comments</font></span>
										    
    										<textarea rows="1" type="text" class="form-control" id="txt_comments_edit" placeholder="THC Comments"></textarea>
    											
    								
    									</div>
    									<div class="col-lg-4 col-md-4 col-sm-12" >
									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Category</font></span>
									    <select class="form-control form-control-select2 " id="txt_category_edit" name="txt_category_edit" data-placeholder="Select Category" data-fouc>
                                	    <option value="NA" >Select Category</option>
                                	    
                                	    
                                          <option value="Civil" >Civil</option>
                                          <option value="Electrical" >Electrical</option>
                                          <option value="Mechanical" >Mechanical</option>
                                          <option value="Plumbing" >Plumbing </option>
                                          <option value="HVAC" >HVAC</option>
                                          <option value="Fire" >Fire</option>
                                          <option value="IT" >IT</option>
                                          <option value="Others" >Others</option>
                                      
                                      </select>
									
									</div>
    					<!--				<div class="col-lg-4 col-md-4 col-sm-12" >-->
									<!--    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Category</font></span>-->
									    
									<!--	<input  type="text" class="form-control" id="txt_category_edit" placeholder="Category">-->
											
								
									<!--</div>-->
    									<div class="col-lg-4 col-md-4 col-sm-12" >
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Priority &nbsp;</font></span>
            				           	    	  <select class="form-control form-control-select2 " id="select_priority_edit" name="select_priority_edit" data-placeholder="Select Priority" data-fouc>
                                	    <option value="select">Select Priority</option>
                                	    
                                	    
                                          <option value="Minor" selected>Minor</option>
                                          <option value="Major" >Major</option>
                                      
                                      </select>
                                        
            				        </div>
            				            
            				        
                                       
					 <div class="col-lg-6 col-md-6 col-sm-12" id="parent_file_card_edit">
    					<div id="file_card_edit"> 
    					      <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Pic</font></span>
    					              
    					    <input type="file" class="form-input-styled"  id="session_image_edit" name="session_image_edit" accept="image/png, image/gif, image/jpeg" onchange="readURLedit(this);"/>
    				        </div>
    				       
    					  
    					   
    				
				    </div>
				   <div class="col-lg-6 col-md-6 col-sm-12" id="div_preview_edit">
								<div class="d-flex align-items-center" style="padding-top:30px">
								
									 <img id="preview_edit" src="#"  width="300" height="300"/>
									 
									<input type="hidden" name="hidden_image_show_edit" id="hidden_image_show_edit" >
									<input type="hidden" name="hidden_image_show_edit_old" id="hidden_image_show_edit_old" >
									
								</div>
								<br>
									 <b><i  data-popup="tooltip" title="Remove Image" data-placement="bottom" class="icon-cancel-circle2 img_remove_edit"></i></b>
							</div>
						
				
								
								</div>
								
								
								
								
							</div>
						</div>
       
      </div>
      <div class="modal-footer">
          	<button type="button" id="btn_project_edit" class="btn btn-danger "  ><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	


					
				
			