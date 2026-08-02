	<!-- Disabled backdrop Change Status -->
	 <?PHP 
                                 
                                include(__DIR__ . '/../../model/db_connection/connection.php'); ;
                                 $DBConn = new DBConnection();
                                 $varDBConnection = $DBConn->ConnectToMYSQL();
                                	$result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
                                
                                	
                                			
                                	
                                ?>
				<div id="modal_new_type" class="modal fade" data-backdrop="false" >
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Asset Type</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12" id="div_asset_type_add_category_combo">	
                                  
                                 
                                 	
                            </div>
    								    											
						          	<div class="col-lg-6 col-md-12 col-sm-12" >
										  
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Asset Type &nbsp;<span style="color:red"> *</span></font></span>
    										<input type="text" class="form-control" id="txt_asset_type_name" placeholder="Asset Type">
    											
    								
    									</div>
    								
							        
							        </div>
							        
						        </div>
						        
							

							<div class="modal-footer">
							    <button type="button" class="btn bg-info" id="btn_asset_type_add" data-dismiss="modal">Add</button>
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
							</div>
					</div>
				</div>
			
				<!-- /disabled backdrop Change Status -->
			