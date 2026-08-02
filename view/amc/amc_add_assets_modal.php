
								
								
							<div class="form-group row">
								    
									<div  class="col-lg-6 col-md-6 col-sm-12"  id="div_cust_location">   
									</div>
									
									<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:5px;display:none" id="div_plus_location_modal">
								        <button type="button" class="btn btn-primary btn-sm" id="bootbox_location_btn" >+</button></td>
								    </div>
									
									<div  class="col-lg-6 col-md-6 col-sm-12"  id="div_cust_building" >   
									</div>
									
									<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:5px;display:none" id="div_plus_building_modal">
								        <button type="button" class="btn btn-primary btn-sm" id="bootbox_building_btn" >+</button></td>
								    </div>
								    	<div class="col-lg-6 col-md-6 col-sm-12">
								    	    <span class="form-text text-muted font-weight-bold"><font color="black">Zone/Floor No </font></span>
										
									    <input type="text" class="form-control" id="txt_zone_or_floor_no" placeholder="Zone/ Floor No">
										
									</div>
									 <input type="hidden" class="form-control" id="txt_barcode_generate_values">
								<input type="hidden" class="form-control" id="txt_amc_start_date">
								<input type="hidden" class="form-control" id="txt_amc_end_date">
							   <input type="hidden" class="form-control" id="txt_amc_master_id">       
							      
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
									
								
							     
									<div class="col-lg-6 col-md-6 col-sm-12" id="div_category_select">	
									<?PHP include_once('category_combo.php');?>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12" id="div_asset_type_select">	
									<?PHP include_once('assets_type_combo.php');?>
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
							        
				            
									 
							        <div class="col-lg-6 col-md-6 col-sm-12" >
							            	<span class="form-text text-muted font-weight-bold"><font color="black">Asset Description &nbsp;</font></span>
							           <textarea rows="1"  class="form-control" id="txt_des" placeholder="Asset Description"></textarea>
							           
							        </div>
							       
							       	<div class="col-lg-6 col-md-6 col-sm-12" >
							       	    <span class="form-text text-muted font-weight-bold"><font color="black">Asset Attachment &nbsp;</font></span>
										<div class="form-group" >
										    
									            <input type="file" class="form-input-styled"  id="assets_attachment"  title="&nbsp;" data-fouc=""/>
									    </div>
									</div>
							
									
									
									<div class="col-lg-5 col-md-5 col-sm-11" >
										<div class="form-group">
        								<span class="form-text text-muted font-weight-bold"><font color="black">Asset Code &nbsp;<span style="color:red;">*</span></font></span>
        									
        								    <input type="text" class="form-control text-center" id="barcodeValue" placeholder="Asset Code" disabled>
        									
        								</div>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:30px;">
								        <button type="button" class="btn btn-primary btn-sm" onclick="generateBarcode(document.getElementById('txt_barcode_generate_values').value);" id="btn_generate_barcode" style="padding-right:4px;adding-left:0px;"><i class="icon-barcode2 mr-2"></i></button></td>
								    </div>
									
									 <div class="col-lg-6 col-md-6 col-sm-12" style="display:none">
										<div class="form-group">
										   
                                             <div id="barcodeTarget" class="barcodeTarget"></div>
                                            <!--<canvas id="canvasTarget" width="150" height="150"></canvas> -->
        									<span class="form-text text-muted"><font color="black">BARCODE</font></span>
        									
        								</div>
									</div>
									
								</div>
								
								

						