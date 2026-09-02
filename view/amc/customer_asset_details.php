<?php
if (!isset($varDBConnection) || !$varDBConnection) {
    include_once __DIR__ . '/../../model/db_connection/connection.php';
    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
}
?>
<div class="card classCustomerAssetModify">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Customer Assets
						    </h5>
						
					</div>
					<div class="card-body">
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<input type="hidden" class="form-control" id="txt_barcode_generate_values">
								<input type="hidden" class="form-control" id="txt_assets_id">	
								<input type="hidden" id="txt_asset_id">

								<div class="form-group row">
									<!-- 1. Customer Name -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="d-flex align-items-end">
												<div style="flex-grow: 1; min-width: 0;" id="div_customer_details_asset"></div>
												<button type="button" class="btn btn-primary btn-sm ml-2" id="btn_add_customer" data-toggle="modal" data-target="#modal_customer_add" style="height: 36px; min-width: 36px; padding: 0 10px; margin-bottom: 1px;">+</button>
											</div>
										</div>
									</div>

									<!-- 2. Location -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="d-flex align-items-end">
												<div style="flex-grow: 1; min-width: 0;" id="div_cust_location"></div>
												<button type="button" class="btn btn-primary btn-sm ml-2" id="bootbox_location_btn" style="height: 36px; min-width: 36px; padding: 0 10px; margin-bottom: 1px;">+</button>
											</div>
										</div>
									</div>

									<!-- 3. Building -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="d-flex align-items-end">
												<div style="flex-grow: 1; min-width: 0;" id="div_cust_building"></div>
												<button type="button" class="btn btn-primary btn-sm ml-2" id="bootbox_building_btn" style="height: 36px; min-width: 36px; padding: 0 10px; margin-bottom: 1px;">+</button>
											</div>
										</div>
									</div>

									<!-- 4. Zone/Floor No -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Zone/Floor No </font></span>
											<input type="text" class="form-control" id="txt_zone_or_floor_no" placeholder="Zone/ Floor No" tabindex=4>
										</div>
									</div>

									<!-- 5. Flat No/Area Code -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Flat No/Area Code </font></span>
											<input type="text" class="form-control" id="txt_flat_area_no" placeholder="Flat Number/Area Code" tabindex=5>
										</div>
									</div>

									<!-- 6. Room Number -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Room Number </font></span>
											<input type="text" class="form-control" id="txt_room_no" placeholder="Room Number" tabindex=6>
										</div>
									</div>

									<!-- 7. Asset Name -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Asset Name&nbsp;</font></span>
											<textarea rows="1" cols="1" class="form-control" id="txt_specify_if_any" placeholder="Asset Name" tabindex=7 style="height: 36px;"></textarea>
										</div>
									</div>

									<!-- 8. Asset Category -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="d-flex align-items-end">
												<div style="flex-grow: 1; min-width: 0;" id="div_category_select">	
													<span class="form-text text-muted font-weight-bold"><font color="black">Asset Category&nbsp;<span style="color:red;">*</span> </font></span>
													<select class="form-control form-control-select2" id="select_category" data-placeholder="Select Category" data-fouc tabindex=8>
														<option value="Select Category">Select Category</option>
														<?PHP 
														if ($varDBConnection) {
															$result_cat_init = mysqli_query($varDBConnection,"select category_id,category_name from tbl_category where category_status='Active' order by category_name asc");
															if ($result_cat_init) {
																while($row_cat_i=mysqli_fetch_assoc($result_cat_init)) { ?>
														  <option value="<?PHP echo $row_cat_i['category_id']; ?>"><?PHP echo htmlspecialchars($row_cat_i['category_name']); ?></option>
														<?PHP }
															}
														}
														?>
													</select>
												</div>
												<button type="button" class="btn btn-primary btn-sm ml-2" id="btn_add_category" data-toggle="modal" data-target="#modal_category_add" style="height: 36px; min-width: 36px; padding: 0 10px; margin-bottom: 1px;">+</button>
											</div>
										</div>
									</div>

									<!-- 9. Asset Type -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<div class="d-flex align-items-end">
												<div style="flex-grow: 1; min-width: 0;" id="div_asset_type_select">	
													<span class="form-text text-muted font-weight-bold"><font color="black">Select Asset Type&nbsp;<span style="color:red;">*</span> </font></span>
													<select class="form-control form-control-select2 asset" id="select_asset_type" data-placeholder="Select Type" data-fouc tabindex=9>
														<option value="Select Type">Select Asset Type</option>
														<?PHP 
														if ($varDBConnection) {
															$result_t_init = mysqli_query($varDBConnection,"select asset_type_id,asset_type_name from tbl_asset_type where asset_type_status='Active' order by asset_type_name asc");
															if ($result_t_init) {
																while($row_t_i=mysqli_fetch_assoc($result_t_init)) { ?>
														  <option value="<?PHP echo $row_t_i['asset_type_id']; ?>"><?PHP echo htmlspecialchars($row_t_i['asset_type_name']); ?></option>
														<?PHP }
															}
														}
														?>
													</select>
												</div>
												<button type="button" class="btn btn-primary btn-sm ml-2" id="btn_add_asset_type" data-toggle="modal" data-target="#modal_asset_type_add" style="height: 36px; min-width: 36px; padding: 0 10px; margin-bottom: 1px;">+</button>
											</div>
										</div>
									</div>

									<!-- 10. Brand -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Brand </font></span>
											<input type="text" class="form-control" id="txt_brand" placeholder="Brand" tabindex=10>
										</div>
									</div>

									<!-- 11. Model Number -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Model Number</font></span>
											<input type="text" class="form-control" id="txt_modal_no" placeholder="Model Number" tabindex=11>
										</div>
									</div> 

									<!-- 12. Warrantee/Guarantee -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Warrantee/Guarantee </font></span>
											<select class="form-control select" id="txt_is_warrantee" data-fouc tabindex=12>
												<option value="NA">NA</option>
												<option value="YES">YES</option>
												<option value="NO">NO</option>
											</select>
										</div>
									</div>

									<!-- 13. Warrantee/Guarantee Upto -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Warrantee/Guarantee Upto</font></span>
											<input class="form-control" type="date" name="date" id="warrantee_date" tabindex=13>
										</div>
									</div>

									<!-- 14. Capacity -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Capacity</font></span>
											<input type="text" class="form-control" id="txt_capacity" placeholder="Capacity" tabindex=14>
										</div>
									</div>

									<!-- 15. Cost -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Cost</font></span>
											<input type="number" class="form-control" id="txt_cost" placeholder="Cost" tabindex=15>
										</div>
									</div>

									<!-- 16. Asset Image / Attachment -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Asset Image</font></span>
											<div class="d-flex align-items-center">
												<div style="flex-grow: 1; min-width: 0;">
													<input type="file" class="form-input-styled" id="assets_attachment" title="&nbsp;" tabindex=17 data-fouc=""/>
													<p id="assets_img_name" class="mb-0 text-muted small"></p>
												</div>
												<div id="img_assets_preview" class="ml-2" style="display: flex; align-items: center; min-height: 38px;"></div>
											</div>
										</div>
									</div>

									<!-- 17. Asset Code -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Asset Code &nbsp;<span style="color:red;">*</span></font></span>
											<div class="d-flex align-items-end">
												<div style="flex-grow: 1; min-width: 0;">
													<input type="text" class="form-control text-left" id="barcodeValue" placeholder="Asset Code" disabled>
												</div>
												<button type="button" class="btn btn-primary btn-sm ml-2" onclick="generateBarcode(document.getElementById('txt_barcode_generate_values').value);" id="btn_generate_barcode" title="Generate Barcode" style="height: 36px; min-width: 36px; padding: 0 10px; margin-bottom: 1px;"><i class="icon-barcode2"></i></button>
											</div>
										</div>
									</div>

									<!-- 18. Asset Description -->
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Asset Description &nbsp;</font></span>
											<textarea rows="1" cols="1" class="form-control" id="txt_des" placeholder="Asset Description" tabindex=16 style="height: 36px; resize: vertical;"></textarea>
										</div>
									</div>
								</div>
								
								
								
								
							</div>
						</div>
						
					
									
						
					</div>
					
					<div class="card-footer">
								<div class="row">
									
									
										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:10px;color:red;">
    									    
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    								<button type="button" id="btn_add_assets" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    								<button type="button" id="btn_edit_assets" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    								<button type="button" id="btn_new_assets" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    											
							</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
					<?PHP include("tickets/location_modal.php");?>
					<?PHP include("amc/building_modal.php");?>
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Customer Assets</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_customer_asset_details">
						<thead>
							<tr>
							    <th></th>
							    <th>Sl. No.</th>
							    <th></th>
				                <th>Asset Ref. No.</th>
				                <th>QR</th>
								<th>Customer</th>				                
				                <th>Location</th>				               
				                <th>Building</th>
								 <th>Asset Category</th>				               
				                <th>Asset Type</th>
				                <th>Status</th>
				                <th>Action</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						<tfoot>
                            <tr>
                    		
                                
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection -->
				
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
				
					<div id="modal_category_add" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Category</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
						            <div class="col-lg-12 col-md-12 col-sm-12">
						                	<span class="form-text text-muted font-weight-bold"><font color="black">Category &nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_cat_name" placeholder="Category" >
    									     
											 
    									</div>  
										
									
							        
							        </div>
							        
						        </div>
						        
							

							<div class="modal-footer">
							    <button type="button" class="btn bg-info" id="btn_category_add">Add</button>
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
							</div>
					</div>
				</div>
				
				<div id="modal_asset_type_add" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Asset Types</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   						  									   
										<div class="col-lg-6 col-md-6 col-sm-12" id="">	
    
                                     <span class="form-text text-muted font-weight-bold"><font color="black">Category&nbsp;<span style="color:red;">*</span> </font></span>
                                     <select class="form-control form-control-select2" id="select_category_modal" data-placeholder="Select Category" data-fouc tabindex=1>
                                	    <option value="select">Select Category</option>
                                	    
                                 	    <?PHP 
                                 	    if ($varDBConnection) {
                                 	    	$result_cat = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active' order by category_name asc");
                                 	    	if ($result_cat) {
                                 	    		while($row_cat=mysqli_fetch_assoc($result_cat)) { ?>
                                           <option value="<?PHP echo $row_cat['category_id']; ?>"><?PHP echo $row_cat['category_name']; ?></option>
                                         <?PHP }
                                 	    	}
                                 	    }
                                 	    ?>
                                      </select>
                                     	
                                </div>
    								    																			
										<div class="col-lg-6 col-md-6 col-sm-12" >
										   
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Asset Type&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_asset_name" placeholder="Asset Type" tabindex=2>
    											
    								
    									</div>
    								
								
								</div>
								
								
								
								
							</div>
						</div>
							        
						        </div>
						        
							

							<div class="modal-footer">
							    <button type="button" class="btn bg-info" id="btn_asset_type_add">Add</button>
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
							</div>
					</div>
				</div>
				