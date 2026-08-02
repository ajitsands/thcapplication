<?PHP
include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_location = mysqli_query($varDBConnection,"select distinct(location) as location from  tbl_project_entries where location IS NOT NULL");
 	$result_place = mysqli_query($varDBConnection,"select distinct(place) as place from  tbl_project_entries where place IS NOT NULL");
 	$result_parts = mysqli_query($varDBConnection,"select distinct(parts) as parts from  tbl_project_entries where parts IS NOT NULL");
 	$result_category = mysqli_query($varDBConnection,"select distinct(category) as category from  tbl_project_entries where category IS NOT NULL");
 	$result_priority = mysqli_query($varDBConnection,"select distinct(priority) as priority from  tbl_project_entries where priority IS NOT NULL");
 	
 	if($_SESSION["user_type"]=='Administrator')
 	{
 	    $result_technician = mysqli_query($varDBConnection,"select employee_id,employee_name from  tbl_employees where employee_type_name in ('Administrator','Technician')");
 	}
 	else
 	{
 	    
 	    $result_technician = mysqli_query($varDBConnection,"select employee_id,employee_name from  tbl_employees where employee_id=".$_SESSION["user_id"]);
 	}
 	
	
?>
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
									   
										
									<div class="col-lg-3 col-md-3 col-sm-12" id="div_project_select_report">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Project &nbsp;</font></span>
                                        
            				        </div>
            				        <div class="col-lg-3 col-md-3 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">From Date&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="txt_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d");?>" tabindex=6>
        										
        									
        								</div>
            				       <div class="col-lg-3 col-md-3 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">To Date&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="txt_todate" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d");?>" tabindex=6>
        										
        									
        								    </div>
        								</div>
        								<div class="form-group row">
        									<div class="col-lg-3 col-md-3 col-sm-12" id="">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Location &nbsp;</font></span>
            				           	<select class="form-control form-control-select2 " id="select_location" name="select_location" data-placeholder="Select Location" data-fouc>
                                	    <option value="0" selected>All</option>
                                	    
                                	    <?PHP 	while($row_location=mysqli_fetch_assoc($result_location)) { ?>
                                          <option value="<?PHP echo $row_location['location']; ?>" ><?PHP echo $row_location['location']; ?></option>
                                        <?php } ?>
                                      </select>
                                        
            				        </div>
            				        	<div class="col-lg-3 col-md-3 col-sm-12" id="">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Place &nbsp;</font></span>
            				           	<select class="form-control form-control-select2 " id="select_place" name="select_place" data-placeholder="Select Place" data-fouc>
                                	    <option value="0" selected>All</option>
                                	    
                                	    <?PHP 	while($row_place=mysqli_fetch_assoc($result_place)) { ?>
                                          <option value="<?PHP echo $row_place['place']; ?>" ><?PHP echo $row_place['place']; ?></option>
                                        <?php } ?>
                                      </select>
                                        
            				        </div>
            				        	<div class="col-lg-3 col-md-3 col-sm-12" id="">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Part &nbsp;</font></span>
                                        <select class="form-control form-control-select2 " id="select_parts" name="select_parts" data-placeholder="Select Part" data-fouc>
                                	    <option value="0" selected>All</option>
                                	    
                                	    <?PHP 	while($row_parts=mysqli_fetch_assoc($result_parts)) { ?>
                                          <option value="<?PHP echo $row_parts['parts']; ?>" ><?PHP echo $row_parts['parts']; ?></option>
                                        <?php } ?>
                                      </select>
            				        </div>
            				        	<div class="col-lg-3 col-md-3 col-sm-12" id="">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Category &nbsp;</font></span>
                                        <select class="form-control form-control-select2 " id="select_category" name="select_category" data-placeholder="Select Category" data-fouc>
                                	    <option value="0" selected>All</option>
                                	    
                                	    <?PHP 	while($row_category=mysqli_fetch_assoc($result_category)) { ?>
                                          <option value="<?PHP echo $row_category['category']; ?>" ><?PHP echo $row_category['category']; ?></option>
                                        <?php } ?>
                                      </select>
            				        </div>
            				        <div class="col-lg-3 col-md-3 col-sm-12" id="">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Priority &nbsp;</font></span>
                                        <select class="form-control form-control-select2 " id="select_priority" name="select_priority" data-placeholder="Select Priority" data-fouc>
                                	    <option value="0" selected>All</option>
                                	    
                                	    <?PHP 	while($row_priority=mysqli_fetch_assoc($result_priority)) { ?>
                                          <option value="<?PHP echo $row_priority['priority']; ?>" ><?PHP echo $row_priority['priority']; ?></option>
                                        <?php } ?>
                                      </select>
            				        </div>
            				        <?php if($_SESSION["user_type"]=='Administrator') { ?>
            				         <div class="col-lg-3 col-md-3 col-sm-12" id="">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Technician &nbsp;</font></span>
                                        <select class="form-control form-control-select2 " id="select_technician" name="select_technician" data-placeholder="Select Technician" data-fouc>
                                	    <option value="0" selected>All</option>
                                	    
                                	    <?PHP 	while($row_technician=mysqli_fetch_assoc($result_technician)) { ?>
                                          <option value="<?PHP echo $row_technician['employee_id']; ?>" ><?PHP echo $row_technician['employee_name']; ?></option>
                                        <?php } ?>
                                      </select>
            				        </div>
            				        <?php }
            				        else
            				        {?>
            				        <div class="col-lg-3 col-md-3 col-sm-12" style="display:none">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Technician &nbsp;</font></span>
                                        <select class="form-control form-control-select2 " id="select_technician" name="select_technician" data-placeholder="Select Technician" data-fouc>
                                	    <?PHP 	while($row_technician=mysqli_fetch_assoc($result_technician)) { ?>
                                          <option value="<?PHP echo $row_technician['employee_id']; ?>" selected><?PHP echo $row_technician['employee_name']; ?></option>
                                        <?php } ?>
                                      </select>
            				        </div>
            				        <?php }?>
				                </div>
				                <div class="form-group row">
    										<div class="col-lg-12 col-md-12 col-sm-12" style="padding-top:30px">
    									
    										<button type="button" id="btn_project_view" class="btn btn-primary " ><b></b>View</button>
    										
    										<?php if($_SESSION["user_type"]=='Administrator')
    										{
    										?>
              
    										<button type="button" id="btn_project_export" class="btn btn-success"  ><b> Export</button>
    										<?php }?>
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
								<button type="button" id="btn_project_add_entries" class="btn btn-dark " ><b></b>Add New</button>
	                	</div>
					</div>

				

					<table class="table datatable-responsive-row-control" id="list_of_project_entries">
						<thead>
							<tr>
						
							    <th>Sl. No.</th>
							    <th>Action</th>
							    <th>Project</th>
				                <th>Description</th>
				                <th>Location</th>
				                <th>Place</th>
				                <th>Parts</th>
				                <th>Category</th>
				                <th>Comments</th>
				                <th>Priority</th>
				                <th>Technician</th>
				                <th>Pic</th>
				                
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						
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
        <img src="" id="imagepreview" style="width: 400px; height: 264px;" class="button_img_download" >
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
									<div class="col-lg-4 col-md-4 col-sm-12" id="div_project_select_edit" >
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
					
<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4>Add Entries</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        
      </div>
      <div class="modal-body" >
          <div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
									<div class="col-lg-4 col-md-4 col-sm-12" id="div_project_select">
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Project &nbsp;</font></span>
                                        
            				        </div>
            				         <div class="col-lg-4 col-md-4 col-sm-12" style="display:none">
    									    <span class="form-text text-muted font-weight-bold"><font color="black"> Date&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="txt_add_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d");?>" tabindex=6>
        										
        									
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
                                	    <option value="NA" selected >Select Category</option>
                                	    
                                	    
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
									    
									<!--	<input  type="text" class="form-control" id="txt_category" placeholder="Category">-->
											
								
									<!--</div>-->
    									<div class="col-lg-4 col-md-4 col-sm-12" >
            				           	    	<span class="form-text text-muted font-weight-bold" ><font color="black">Select Priority &nbsp;</font></span>
            				           	    	  <select class="form-control form-control-select2 " id="select_priority" name="select_priority" data-placeholder="Select Priority" data-fouc>
                                	    <option value="select">Select Priority</option>
                                	    
                                	    
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
						
				
    										
								
								</div>
								
								
								
								
							</div>
						</div>
       
      </div>
      <div class="modal-footer">
          	<button type="button" id="btn_project_add" class="btn btn-primary " ><b></b>Add</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>					
			