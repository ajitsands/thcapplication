<?PHP
include_once(__DIR__ . '/../../model/db_connection/connection.php');
                                    $DBConn = new DBConnection();
                                    $varDBConnection = $DBConn->ConnectToMYSQL();
                                    
                                    
                                    $result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
                                     	
                                    ?>

	<!-- Disabled backdrop Change Status -->
				<div id="modal_add_assets" class="modal fade" data-backdrop="false" >
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Customer Assets</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
							        <div class="col-lg-6 col-md-6 col-sm-12">
											    <span class="form-text text-muted font-weight-bold"><font color="black">Zone/Floor No </font></span>
									    <input type="text" class="form-control" id="txt_zone_or_floor_no" placeholder="Zone/ Floor No">
										
										
									</div>
						    	    <div  class="col-lg-6 col-md-6 col-sm-12" > 
										<span class="form-text text-muted font-weight-bold"><font color="black">Flat No/Area Code </font></span>
									    <input type="text" class="form-control" id="txt_flat_area_no" placeholder="Flat Number/Area Code">
										
										
									</div>
									
										<div  class="col-lg-6 col-md-6 col-sm-12" > 
										<span class="form-text text-muted font-weight-bold"><font color="black">Room Number </font></span>
									<input type="text" class="form-control" id="txt_room_no" placeholder="Room Number">
										
									</div>
									
								
								    	<div class="col-lg-6 col-md-6 col-sm-12">
								    	    <span class="form-text text-muted font-weight-bold"><font color="black">Specify if any&nbsp;</font></span>
									   <textarea rows="1" cols="1" class="form-control" id="txt_specify_if_any" placeholder="Specify if any"></textarea>
							           	
										
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12" >	
								        <span class="form-text text-muted font-weight-bold"><font color="black">Asset Category&nbsp;<span style="color:red;">*</span> </font></span>

     
                                         <select class="form-control form-control-select2" id="select_category_add_assets" data-placeholder="Select Category" data-fouc>
                                    	    <option value="Select Category">Select Category</option>
                                    	    
                                    	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
                                              <option value="<?PHP echo $row['category_id']; ?>"><?PHP echo $row['category_name']; ?></option>
                                            
                                            <?PHP } ?>
                                          </select>
									</div>
							    
							  	<div class="col-lg-6 col-md-6 col-sm-12" id="div_asset_type_select">	
									<?PHP // include_once('assets_type_combo.php');?>
							       </div>
								    	
								    <div class="col-lg-6 col-md-6 col-sm-12" >
							            <div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Brand  </font></span>
        								    <input type="text" class="form-control" id="txt_brand" placeholder="Brand" >
        									
        								</div>

							               
							        </div>
							        
								     <div class="col-lg-6 col-md-6 col-sm-12" >
										<div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Model Number</font></span>
        								    <input type="text" class="form-control" id="txt_modal_no" placeholder="Model Number">
        									
        								</div>
									</div> 
									<div class="col-lg-6 col-md-6 col-sm-12" >
										<div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Warrantee/Guarantee </font></span>
        								    <select class="form-control select" id="txt_is_warrantee" data-fouc>
        									        <option value="NA">NA</option>
        											<option value="YES">YES</option>
        											<option value="NO">NO</option>
        									</select>
        									
        								</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12" >
										<div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Warrantee/Guarantee Upto</font></span>
        								    <input class="form-control" type="date" name="date" id="warrantee_date">
        									
        								</div>
									</div>
								
									<div class="col-lg-6 col-md-6 col-sm-12" >
							               <div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Capacity</font></span>
        								    <input type="text" class="form-control" id="txt_capacity" placeholder="Capacity">
        									
        								</div>
        				
							        </div>
							        
								<div class="col-lg-6 col-md-6 col-sm-12" >
							               <div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Cost</font></span>
        								    <input type="number" class="form-control" id="txt_cost" placeholder="Cost">
        									
        								</div>
        				
							        </div>
							        <div class="col-lg-6 col-md-12 col-sm-12" >
								        <span class="form-text text-muted font-weight-bold"><font color="black">Asset Description &nbsp;</font></span>
							           <textarea rows="1"  class="form-control" id="txt_des" placeholder="Asset Description"></textarea>
							           	
							        </div>
							         <div class="col-lg-1 col-md-1 col-sm-12" style="padding-top:25px;">
								         <button type="button" class="btn btn-primary btn-sm"  id="btn_generate_barcode" style="padding-right:4px;adding-left:0px;"><i class="icon-barcode2 mr-2"></i></button>
								         </div>
								      <div class="col-lg-5 col-md-5 col-sm-12" >
										<div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Asset Code &nbsp;<span style="color:red;">*</span></font></span>
        								    <input type="text" class="form-control text-left" id="barcodeValue" placeholder="Asset Code" disabled>
        								    <input type="hidden" class="form-control text-left" id="txt_barcode_generate_values"  disabled>
        									
        									
        								</div>
									</div>
						     	
							        	<div class="col-lg-6 col-md-6 col-sm-12" >
										<div class="form-group" style="padding-top:20px;">
									           <input type="file" class="form-input-styled"  id="assets_attachment"  title="&nbsp;" data-fouc=""/>
												<p id="assets_img_name"></p>
												<div id="img_assets_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
									    </div>
									</div>
								    
							
						
							        
						        </div>
						        
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary"  id="btn_add_assets_tickets" name="btn_add_assets_tickets" data-dismiss="modal">Add</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			