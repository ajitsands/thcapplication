	
	<div id="modal_add_assets_assign_assets_to_amc" class="modal fade" data-backdrop="false">
					<div class="modal-dialog modal-xl" style="max-width: 95% !important;">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title"><span id="span_assign_asset_add_amc_ref"></span></h5>
								<button type="button" class="close" data-dismiss="modal" id="btn_x_add_assets">&times;</button>
							</div>

							<div class="modal-body">
							   
							     <input type="hidden" class="form-control" id="txt_customer_ids_add_assets">
							     <input type="hidden" class="form-control" id="txt_customer_code_add_assets">
							     <input type="hidden" class="form-control" id="txt_customer_name_add_assets">
					                    <div class="form-group row">
								    
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									    <div class="d-flex align-items-end">
									        <div class="flex-grow-1" id="div_cust_location_assign_add_assets"></div>
									        <div class="ml-2" id="div_plus_location_modal" data-toggle="tooltip" data-placement="right" title="Add New Location">
								                <button type="button" class="btn btn-primary btn-sm" id="bootbox_location_btn" data-toggle="modal" data-target="#modal_location">+</button>
								            </div>
									    </div>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									    <div class="d-flex align-items-end">
									        <div class="flex-grow-1" id="div_cust_building_assign_add_assets"></div>
									        <div class="ml-2" id="div_plus_building_modal" data-toggle="tooltip" data-placement="right" title="Add New Building">
								                <button type="button" class="btn btn-primary btn-sm" id="bootbox_building_btn" data-toggle="modal" data-target="#modal_building">+</button>
								            </div>
									    </div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
								    	<span class="form-text text-muted font-weight-bold"><font color="black">Zone/Floor No </font></span>
									    <input type="text" class="form-control" id="txt_zone_or_floor_no" placeholder="Zone/ Floor No">
									</div>
									
									<input type="hidden" class="form-control" id="txt_barcode_generate_values">
								    <input type="hidden" class="form-control" id="txt_amc_start_date">
								    <input type="hidden" class="form-control" id="txt_amc_end_date">
							        <input type="hidden" class="form-control" id="txt_amc_master_id">       
							      
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3"> 
										<span class="form-text text-muted font-weight-bold"><font color="black">Flat No/Area Code </font></span>
									    <input type="text" class="form-control" id="txt_flat_area_no" placeholder="Flat Number/Area Code">
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									    <span class="form-text text-muted font-weight-bold"><font color="black">Room Number </font></span>
									    <input type="text" class="form-control" id="txt_room_no" placeholder="Room Number">
									</div>
									
								    <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
								    	<span class="form-text text-muted font-weight-bold"><font color="black">Specify if any&nbsp;</font></span>
									    <textarea rows="1" cols="1" class="form-control" id="txt_specify_if_any" placeholder="Specify if any"></textarea>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									    <div class="d-flex align-items-end">
									        <div class="flex-grow-1" id="div_category_select_add_assets"></div>
									        <div class="ml-2" data-toggle="tooltip" data-placement="right" title="Add New Asset Category">
								                <button type="button" class="btn btn-primary btn-sm" id="bootbox_asset_category_btn" data-toggle="modal" data-target="#modal_asset_category">+</button>
								            </div>
									    </div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									    <div class="d-flex align-items-end">
									        <div class="flex-grow-1" id="div_asset_type_select"></div>
									        <div class="ml-2">
								                <button type="button" class="btn btn-primary btn-sm" id="bootbox_asset_type_btn" data-toggle="modal" data-target="#modal_asset_type">+</button>
								            </div>
									    </div>
									</div>

							        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Brand  </font></span>
        								<input type="text" class="form-control" id="txt_brand" placeholder="Brand" >
							        </div>
							        
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Model Number</font></span>
        								<input type="text" class="form-control" id="txt_modal_no" placeholder="Model Number">
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Warrantee/Guarantee </font></span>
        								<select class="form-control select-warrantee" id="txt_is_warrantee" data-fouc>
        									<option value="NA">NA</option>
        									<option value="YES">YES</option>
        									<option value="NO">NO</option>
        								</select>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Warrantee/Guarantee Upto</font></span>
        								<input class="form-control" type="date" name="date" id="warrantee_date">
									</div>
								
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Capacity</font></span>
        								<input type="text" class="form-control" id="txt_capacity" placeholder="Capacity">
							        </div>

							        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Cost</font></span>
        								<input type="number" class="form-control" id="txt_cost" placeholder="Cost">
							        </div>
							        
							        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
							            <span class="form-text text-muted font-weight-bold"><font color="black">Asset Description &nbsp;</font></span>
							            <textarea rows="1" class="form-control" id="txt_des" placeholder="Asset Description"></textarea>
							        </div>
							       
							       	<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
							       	    <span class="form-text text-muted font-weight-bold"><font color="black">Asset Attachment &nbsp;</font></span>
										<div class="form-group">
									        <input type="file" class="form-input-styled" id="assets_attachment" title="&nbsp;" data-fouc=""/>
									    </div>
									</div>
									
									<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
									    <div class="d-flex align-items-end">
									        <div class="flex-grow-1">
        								        <span class="form-text text-muted font-weight-bold"><font color="black">Asset Code &nbsp;<span style="color:red;">*</span></font></span>
        								        <input type="text" class="form-control text-center" id="barcodeValue" placeholder="Asset Code" disabled>
        									</div>
									        <div class="ml-2">
								                <button type="button" class="btn btn-primary btn-sm" onclick="generateBarcode(document.getElementById('txt_barcode_generate_values').value);" id="btn_generate_barcode"><i class="icon-barcode2"></i></button>
								            </div>
									    </div>
									</div>
									
									 <div class="col-lg-6 col-md-6 col-sm-12" style="display:none">
										<div class="form-group">
										   
                                             <div id="barcodeTarget" class="barcodeTarget"></div>
                                            <!--<canvas id="canvasTarget" width="150" height="150"></canvas> -->
        									<span class="form-text text-muted"><font color="black">BARCODE</font></span>
        									
        								</div>
									</div>
									
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" id="btn_close_add_assets_modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_add_assets" >Add Assets</button>
							</div>
						</div>
					</div>
				</div>