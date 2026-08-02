	
			
				<div id="modal_assign_assets" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-xl">
						<div class="modal-content">
							<div class="modal-header bg-info">
							<h5 class="modal-title"><span id="span_location_cust_amcno_assign_assets"></span></h5>
								<!--<h5 class="modal-title">Assign Assets to  [AMC No : <b><span id="span_location_cust_amcno_assign_assets"></span></b>]  Name : <span id="span_location_cust_name_assign_assets"></span>&nbsp;[<span id="span_location_cust_code_assign_assets"></span>] 
    							            </h5>-->
    							          
								<div id="selected_items" style="font-size:15px;color:red;padding-top:2px;"></div>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<input type="hidden" class="form-control" id="txt_amc_category_id">
								<input type="hidden" class="form-control" id="txt_amc_category_name">
									<input type="hidden" class="form-control" id="txt_amc_type_id">
								<input type="hidden" class="form-control" id="txt_amc_type_name">
							   <input type="hidden" class="form-control" id="txt_amc_master_id_assign">  
							</div>

							<div class="modal-body">
									<?PHP include("add_new_assets_assign_assets_modal.php");?>
									 <?php include("add_assets_new_location_modal.php");?>
	                                <?php include("add_assets_new_building_modal.php");?>
	                                <?php include("add_assets_new_category_modal.php");?>
	                                <?php include("add_assets_new_asset_type_modal.php");?>
								<div class="row">
								   <div class="col-lg-10 col-md-10 col-sm-10" ></div>
								   <div class="col-lg-2 col-md-2 col-sm-2" >
								       <button id="btn_add_new_asset_assign_assets" type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modal_add_assets_assign_assets_to_amc"><i class="icon-add"></i> Add New Asset</button>
								       
								       
								   </div>
    						    
    						   
								</div>
								
								<div class="row">
								    
									<div class="col-lg-5 col-md-5 col-sm-12" id="div_location_select_assign_assets"></div>
									<div class="col-lg-5 col-md-5 col-sm-12" id="div_building_select_assign_assets"></div>
									
							        <div class="col-md-2 col-sm-12" style="padding-top:30px">
								   
									<button type="button" class="btn bg-primary" id="assign_asset_search">SEARCH</button>
									</div>
							    </div>
								
								
								<div class="row">
								    
							        
							        <div class="col-lg-12">
							            
							            	<table  class="table  table-hover datatable-highlight display datatable-select-multiple " id="tbl_amc_asset_list_display_for_assign" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
														 <th >SL.No.</th>
                        							    <th>Asset Ref.No.</th>
                        							    <th>Category</th>
                        							    <th>Type</th>
                        								<th >Asset Brand</th>
                        								<th>Asset Description</th>
                        								
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							            
						        </div>
								

<!--Second table-->

	            
                               
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_assign_assets">ASSIGN ASSETS</button>
							</div>
						</div>
					</div>
				</div>
		
				