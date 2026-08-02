	
			
				<div id="modal_add_services" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Services to  [AMC No : <b><span id="span_location_cust_amcno"></span></b>]  Name : <span id="span_location_cust_name"></span>&nbsp;[<span id="span_location_cust_code"></span>] 
    							            </h5>
    							          
								<div id="selected_items" style="font-size:15px;color:red;padding-top:2px;"></div>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								
								
								<!--<div class="row">-->
								    
								<!--	<div class="col-lg-6 col-md-6 col-sm-12" id="div_location_select"></div>-->
								<!--	<div class="col-lg-6 col-md-6 col-sm-12" id="div_building_select"></div>-->
									
							        
							 <!--   </div>-->
								<div class="form-group row">
								 </div>
								
								<div class="form-group row">
								
									<div class="col-lg-6 col-md-6 col-sm-12" id="div_cate_select"></div>
									<div class="col-lg-6 col-md-6 col-sm-12" id="div_assettype_select"></div>
									
								</div>
								<br/>
								<div class="form-group row">
								<div class="col-md-10 col-sm-12" >
								   </div>
								  
								   <div class="col-md-2 col-sm-12">
								   
									<button type="button" class="btn bg-primary" id="asset_search">SEARCH</button>
									</div>
								</div>
								
								<div class="row">
								    
							        
							        <div class="col-lg-12">
							            
							            	<table  class="table table-bordered table-hover datatable-highlight display datatable-select-multiple " id="tbl_amc_asset_list_display" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
														 <th >SI No</th>
                        							    <th>Asset Ref.No</th>
                        								<th >Asset Brand</th>
                        								<th>Asset Cost</th>
                        								<th>Asset Description</th>
                        								
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							            
						        </div>
								

<!--Second table-->

	<div class="row">
								    
							        
							        <div class="col-lg-12">
							            
							            	<table  class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_serviceslist_display" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
													   <th >SI No</th>
                        							   <!-- <th >Category Name</th>
                        								<th>Category Type</th>-->
                        							    <th>Service Description</th>
                        							
                        								
                        								
                        							</tr>
                        						</thead>
                        						<tbody>
                        							
                        						</tbody>
                        					</table>
							            
							        </div>
							            
						        </div>
                               
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_add_child">SAVE</button>
							</div>
						</div>
					</div>
				</div>
		
				