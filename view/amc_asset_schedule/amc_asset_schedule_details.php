<div class="row">
	<div class="card col-md-12" >
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Schedule AMC Assets</h5>
						<div class="header-elements">
						
	                	</div>
					</div>
	<div class="form-group row">
	     <?PHP include_once("amc_asset_schedule/customer_schedule_combo.php");?>
	       <div class="col-lg-4 col-md-4 col-sm-6" id="div_amc_schedule_combo">
	           <select data-placeholder="Select AMC" class="form-control form-control-select2" data-fouc>
	           </select>
	           
		    <?PHP //include_once("amc_asset_schedule/amc_combo.php");?>	
	      </div>
		  <div class="col-lg-4 col-md-4 col-sm-6" id="div_location_schedule_combo">
		      <select class="form-control form-control-select2" id="select_location_for_schedule" data-placeholder="Select Location" data-fouc>
	           </select>
		    <?PHP //include_once("amc_asset_schedule/location_schedule_combo.php");?>	
	      </div>
	</div>
    
	<div class="form-group row"> 
	    <div class="col-lg-4 col-md-4 col-sm-3" id="div_building_combo_for_schedule">
	        <select class="form-control form-control-select2" id="select_building_for_schedule" data-placeholder="Select Building" data-fouc>
	           </select>
		    <?PHP //include_once("amc_asset_schedule/building_schedule_combo.php");?>	
		</div>
        <div class="col-lg-4 col-md-4 col-sm-6" id="div_assets_type_schedule_combo">
             <select class="form-control form-control-select2" id="select_asset_type_for_schedule" data-placeholder="Select Type" data-fouc>
	           </select>
		    <?PHP //include_once("amc/asset_type_schedule_combo.php");?>	
	    </div>
	    <div class="col-lg-4 col-md-4 col-sm-6" id="div_category_schedule_combo">
	        <select class="form-control form-control-select2" id="select_category_for_schedule" data-placeholder="Select Category" data-fouc>
	           </select>
		    <?PHP //include_once("amc/category_service_combo.php");?>	
		</div>
	                </div>
	
	                     <div class="form-group row"> 
	                        <div class="col-md-10 col-sm-12" >
	                            <input type="hidden" id="txt_amc_start_date">
	                            <input type="hidden" id="txt_amc_end_date">
							</div>
	                        <div class="col-md-2 col-sm-12">
							    <button type="button" class="btn bg-primary" id="schedule_search">SEARCH</button>
							</div>
					</div>
<!-- Highlighting rows and columns -->
				<div class="card">
					
                    
					<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_asset_schedule_list" style="padding-right:10px;padding-left:10px;">
						<thead>
							<tr>
							    <th>SI No </th>
							    <th>ID </th>
								<th>Asset Ref. No.</th>
								<th>Brand</th>
								<th>Capacity</th>
								<th>Cost</th>
								<th>Attachment</th>
							    <th>Description</th>
								
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
			
			      <input type="hidden" id="txt_amc_ref_no" class="form-control">
				</div>
				<div class="row">
				    <div class="col-lg-6 col-md-6 col-sm-12" >
							                <div style="border-bottom: 1px solid #ccc!important;">
        										<select  class="form-control select" multiple="multiple" data-fouc id="select_visit_frequency" name="select_visit_frequency">
        										    <optgroup label="Every Day">
            											<option value="ED-All">Every Day</option>
            										</optgroup>
            										<optgroup label="Every Week">
            											<option value="EW-Sunday">Every Week Sunday</option>
            											<option value="EW-Monday">Every Week Monday</option>
            											<option value="EW-Tuesday">Every Week Tuesday </option>
            											<option value="EW-Wednesday">Every Week Wednesday </option>
            											<option value="EW-Thursday">Every Week Thursday </option>
            											<option value="EW-Friday">Every Week Friday </option>
														<option value="EW-Saturday">Every Week Saturday </option>
            											
            										</optgroup>
            										<optgroup label="Every Month First Week">
            											<option value="FW-Sunday">First Week Sunday</option>
            											<option value="FW-Monday">First Week Monday</option>
            											<option value="FW-Tuesday">First Week Tuesday </option>
            											<option value="FW-Wednesday">First Week Wednesday </option>
            											<option value="FW-Thursday">First Week Thursday </option>
            											<option value="FW-Friday">First Week Friday </option>
														<option value="FW-Saturday">First Week Saturday </option>
            										</optgroup>
            											<optgroup label="Every Month Second Week">
            											<option value="SW-Sunday">Second Week Sunday</option>
            											<option value="SW-Monday">Second Week Monday</option>
            											<option value="SW-Tuesday">Second Week Tuesday </option>
            											<option value="SW-Wednesday">Second Week Wednesday </option>
            											<option value="SW-Thursday">Second Week Thursday </option>
            											<option value="SW-Friday">Second Week Friday </option>
														<option value="SW-Saturday">Second Week Saturday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Every Month Third Week">
            											<option value="TW-Sunday">Third Week Sunday</option>
            											<option value="TW-Monday">Third Week Monday</option>
            											<option value="TW-Tuesday">Third Week Tuesday </option>
            											<option value="TW-Wednesday">Third Week Wednesday </option>
            											<option value="TW-Thursday">Third Week Thursday </option>
            											<option value="TW-Friday">Third Week Friday </option>
														<option value="TW-Saturday">Third Week Saturday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Every Month Fourth Week">
            											<option value="FRW-Sunday">Fourth Week Sunday</option>
            											<option value="FRW-Monday">Fourth Week Monday</option>
            											<option value="FRW-Tuesday">Fourth Week Tuesday </option>
            											<option value="FRW-Wednesday">Fourth Week Wednesday </option>
            											<option value="FRW-Thursday">Fourth Week Thursday </option>
            											<option value="FRW-Friday">Fourth Week Friday </option>
														<option value="FRW-Saturday">Fourth Week Saturday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Specific Date">
            											<option value="YSD">Specific Date</option>
            										
            										</optgroup>
            									</select>
            									</div>
            									<span class="form-text text-muted"> Frequency of Visit <i>(For Specific Date option the Start Date will consider)</i> </span>
							        </div>
							        
							        <div class="col-lg-2 col-md-12 col-sm-12" id="div_from_date">
        										<input class="form-control" type="date" name="date" id="txt_from_date">
        										<span class="form-text text-muted">Start Date</span>
							        </div>
							        <div class="col-lg-2 col-md-12 col-sm-12" id="div_to_date">
        										<input class="form-control" type="date" name="number" id="txt_to_date">
        										<span class="form-text text-muted">End Date</span>
							        </div>
									<!-- <div class="col-lg-2 col-md-12 col-sm-12" id="div_specific_date" >
        										<input class="form-control" type="date" name="number" id="txt_selected_date">
        										<span class="form-text text-muted">Select Date</span>
							        </div> -->
							        <div class="col-lg-2 col-md-12 col-sm-12 pull-right" >
        								<input class="form-control" type="time" name="time" id="time">
										<span class="form-text text-muted">Select Time</span>
							        </div>
							</div>
                    <br>
							<div class="row">
								<div class="col-lg-9 col-md-12 col-sm-12 pull-right" ></div>
									<div class="col-lg-3 col-md-12 col-sm-12 pull-right" >
        								<button type="button" class="btn bg-primary" id="btn_generate_schedule" style="float-right;">GENERATE SCHEDULE</button>		
							        </div>
									
							</div>
				    <br>
				
			</div>		
		</div>	
				<!-- /highlighting rows and columns -->
				
				
				
				<div id="modal_change_status" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" ><span id="amc_no_view_head">Change Status [AMC No : <b>100001</b>]</span></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_active" value="1" class="form-check-input-styled-success" checked data-fouc>
													Active
												</label>
											</div>
							        </div>
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							                <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_cancelled" value="2" class="form-check-input-styled-danger"  data-fouc>
													Cancelled	
												</label>
											</div>
							        </div>
							        <div class="col-lg-3 col-md-6 col-sm-12" >
							            <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_hold" value="3" class="form-check-input-styled-primary"  data-fouc>
													Hold
												</label>
											</div>
							        </div>
							       <div class="col-lg-3 col-md-6 col-sm-12" >
							            <div class="form-check">
												<label class="form-check-label">
													<input type="radio" name="radio-styled-color" id="radio_completed" value="4" class="form-check-input-styled-info"  data-fouc>
													Completed
												</label>
											</div>
							        </div>
							        
							    </div>
								
								<hr>

                                <div class="form-group row">
									<label class="col-form-label col-lg-2">Description</label>
									<div class="col-lg-12">
										<textarea rows="3" cols="3" class="form-control" placeholder="Description"></textarea>
									</div>
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_change_status">Change Status</button>
							</div>
						</div>
					</div>
				</div>
				<?PHP // include("amc_change_status_modal.php");?>
				<!-- /disabled backdrop Change Status -->
			
			    
		        <!-- Disabled Assets -->
				<div id="modal_add_assets" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Assects to  [AMC No : <b><span id="span_cust_amcno"></span></b>]  Name : <span id="span_cust_name"></span>&nbsp;[<span id="span_cust_code"></span>] 
    							            </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								
								
							<div class="form-group row">
								    
									<div  class="col-lg-3 col-md-6 col-sm-12"  id="div_cust_location">   
									</div>
									
									<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:5px;">
								        <button type="button" class="btn btn-primary btn-sm" id="bootbox_custom" >+</button></td>
								    </div>
									
									<div  class="col-lg-3 col-md-6 col-sm-12"  id="div_cust_building">   
									</div>
									
									<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:5px;">
								        <button type="button" class="btn btn-primary btn-sm" id="bootbox_custom" >+</button></td>
								    </div>
									<div class="col-lg-4">
									    <input type="text" class="form-control" id="txt_flat_area_no">
										<span class="form-text text-muted"><font color="black">FLAT NO/ AREA CODE &nbsp;<span style="color:red;">*</span> </font></span>
										
									</div>
							        
							    </div>
								
								<div class="form-group row">
									
									<?PHP include_once('category_combo.php');?>
									<?PHP include_once('assets_type_combo.php');?>
							       
							        <div class="col-lg-4 col-md-6 col-sm-12" >
							            <div class="form-group">
        								
        								    <input type="text" class="form-control" id="txt_brand" >
        									<span class="form-text text-muted"><font color="black">BRAND  </font></span>
        								</div>

							               
							        </div>
							        
									
								</div>
							
							    <div class="form-group row">
								
									<div class="col-lg-3 col-md-6 col-sm-12" >
										<div class="form-group">
        								
        								    <input type="text" class="form-control" id="txt_modal_no">
        									<span class="form-text text-muted"><font color="black">MODEL NUMBER</font></span>
        								</div>
									</div>
									<div class="col-lg-2 col-md-6 col-sm-12" >
										<div class="form-group">
        								
        								    <select class="form-control select" id="txt_is_warrantee" data-fouc>
        									        <option value="NA">NA</option>
        											<option value="YES">YES</option>
        											<option value="NO">NO</option>
        									</select>
        									<span class="form-text text-muted"><font color="black">WARRANTEE/GUARANTEE</font></span>
        								</div>
									</div>
									<div class="col-lg-3 col-md-6 col-sm-12" >
										<div class="form-group">
        								
        								    <input class="form-control" type="date" name="date" id="warrantee_date">
        									<span class="form-text text-muted"><font color="black">WARRANTEE/GUARANTEE UPTO</font></span>
        								</div>
									</div>
								
									<div class="col-lg-4 col-md-6 col-sm-12" >
							               
							               <select class="form-control select" id="select_type" data-fouc>
        										<optgroup label="Select Type">
        											<option value="EL">Specific</option>
        											<option value="PL">General</option>
        										</optgroup>
        										
        									</select>
        									<span class="form-text text-muted"><font color="black">TYPE &nbsp;<span style="color:red;">*</span></font></span>
							        </div>
							        
				            </div>
						    	<div class=" form-group row">
									 <div class="col-lg-4 col-md-6 col-sm-12" >
							            <div class="form-group">
        								
        								    <input type="text" class="form-control" id="txt_capacity">
        									<span class="form-text text-muted"><font color="black">CAPACITY</font></span>
        								</div>

							               
							        </div>
							        <div class="col-lg-4 col-md-6 col-sm-12" >
							            <div class="form-group">
        								
        								    <input type="number" class="form-control" id="txt_cost">
        									<span class="form-text text-muted"><font color="black">COST</font></span>
        								</div>

							               
							        </div>
							        <div class="col-lg-4">
										<textarea rows="3" cols="3" class="form-control" id="txt_type_des" placeholder="Type Description"></textarea>
									</div>
								</div>	
								
								
								<div class=" form-group row">	
									<div class="col-lg-6 col-md-6 col-sm-12" >
										<div class="form-group">
									            <input type="file" class="form-input-styled"  id="assets_attachment"  title="&nbsp;" data-fouc=""/>
									    </div>
									</div>
									
									
									<div class="col-lg-5 col-md-6 col-sm-12" >
										<div class="form-group">
        								
        								    <input type="text" class="form-control text-center" id="barcodeValue">
        									<span class="form-text text-muted"><font color="black">ASSET CODE &nbsp;<span style="color:red;">*</span></font></span>
        									
        								</div>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1" style="padding-top:5px;">
								        <button type="button" class="btn btn-primary btn-sm" onclick="generateBarcode();" id="btn_generate_barcode" style="padding-right:4px;adding-left:0px;"><i class="icon-barcode2 mr-2"></i></button></td>
								    </div>
									
								</div>
								
								

                                <div class="form-group row">
								    <div class="col-lg-6 col-md-6 col-sm-12" >
										<div class="form-group">
										   
                                             <div id="barcodeTarget" class="barcodeTarget"></div>
                                            <canvas id="canvasTarget" width="150" height="150"></canvas> 
        									<span class="form-text text-muted"><font color="black">BARCODE</font></span>
        									
        								</div>
									</div>
									<div class="col-lg-6">
										<textarea rows="3" cols="3" class="form-control" id="txt_des" placeholder="Description"></textarea>
									</div>
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_add_assets" >Add Assets</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled Assets -->
			
				
			
				
				<!-- Disabled backdrop Schedule-->
				<div id="modal_backdrop_amc_schedule" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">AMC [12562] Schedule </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    <div class="row">
							        
							        <div class="col-lg-2 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="date">
        										<span class="form-text text-muted">Start Date</span>
							        </div>
							        <div class="col-lg-2 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="number">
        										<span class="form-text text-muted">End Date</span>
							        </div>
							       
							        <div class="col-lg-4 col-md-12 col-sm-12" >
							                <div style="border-bottom: 1px solid #ccc!important;">
        										<select multiple="multiple" class="form-control select"  data-fouc>
        										    <optgroup label="Every Day">
            											<option value="ED-All">Every Day</option>
            										</optgroup>
            										<optgroup label="Every Week">
            											<option value="EW-Sunday">Every Week Sunday</option>
            											<option value="EW-Monday">Every Week Monday</option>
            											<option value="EW-Tuesday">Every Week Tuesday </option>
            											<option value="EW-Wednesday">Every Week Wednesday </option>
            											<option value="EW-Thursday">Every WeekThursday </option>
            											<option value="EW-Friday">Every Week Friday </option>
            											
            										</optgroup>
            										<optgroup label="Every Month First Week">
            											<option value="FW-Sunday">First Week Sunday</option>
            											<option value="FW-onday">First Week Monday</option>
            											<option value="FW-Tuesday">First Week Tuesday </option>
            											<option value="FW-Wednesday">First Week Wednesday </option>
            											<option value="FW-Thursday">First Week Thursday </option>
            											<option value="FW-Friday">First Week Friday </option>
            										</optgroup>
            											<optgroup label="Every Month Second Week">
            											<option value="SW-Sunday">Second Week Sunday</option>
            											<option value="SW-Monday">Second Week Monday</option>
            											<option value="SW-Tuesday">Second Week Tuesday </option>
            											<option value="SW-Wednesday">Second Week Wednesday </option>
            											<option value="SW-Thursday">Second Week Thursday </option>
            											<option value="SW-Friday">Second Week Friday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Every Month Third Week">
            											<option value="TW-Sunday">Third Week Sunday</option>
            											<option value="TW-Monday">Third Week Monday</option>
            											<option value="TW-Tuesday">Third Week Tuesday </option>
            											<option value="TW-Wednesday">Third Week Wednesday </option>
            											<option value="TW-Thursday">Third Week Thursday </option>
            											<option value="TW-Friday">Third Week Friday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Every Month Fourth Week">
            											<option value="FW-Sunday">Fourth Week Sunday</option>
            											<option value="FW-Monday">Fourth Week Monday</option>
            											<option value="FW-Tuesday">Fourth Week Tuesday </option>
            											<option value="FW-Wednesday">Fourth Week Wednesday </option>
            											<option value="FW-Thursday">Fourth Week Thursday </option>
            											<option value="FW-Friday">Fourth Week Friday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Yearly Once">
            											<option value="YSD">Selected Date</option>
            										
            										</optgroup>
            									</select>
            									</div>
            									<span class="form-text text-muted">Every</span>
							        </div>
							        <div class="col-lg-2 col-md-12 col-sm-12 pull-right" >
        								<input class="form-control" type="time" name="time">
										<span class="form-text text-muted">Select Time</span>
							        </div>
							        <div class="col-lg-2 col-md-12 col-sm-12 pull-right" >
        								<button type="button" class="btn bg-primary">GENERATE</button>		
							        </div>
							        
					            </div>
					            
					            <div class="row">
							        
							        <div class="col-lg-12 col-md-12 col-sm-12" >
					            
					                        <?PHP 
					                            include_once("amc_date_list.php");
					                        ?>
					            
					                </div>
					            </div>
					            
							</div>

							<div class="modal-footer">
								<!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-success">Save changes</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Schedule-->	
				
				
					<!-- backdrop Barcode-->
				<div id="modal_backdrop_1" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Barcode Generator</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
					
					
					
					
    <div id="generator">
      <!--Please fill in the code : <input type="text" id="barcodeValue" value="12345670">-->
      <div id="config">
        <div class="config">
          <div class="title">Type</div>
          <input type="radio" name="btype" id="ean8" value="ean8" ><label for="ean8">EAN 8</label><br />
		  <input type="radio" name="btype" id="ean13" value="ean13"><label for="ean13">EAN 13</label><br />
		  <input type="radio" name="btype" id="upc" value="upc"><label for="upc">UPC</label><br />
          <input type="radio" name="btype" id="std25" value="std25"><label for="std25">standard 2 of 5 (industrial)</label><br />
          <input type="radio" name="btype" id="int25" value="int25"><label for="int25">interleaved 2 of 5</label><br />
          <input type="radio" name="btype" id="code11" value="code11"><label for="code11">code 11</label><br />
          <input type="radio" name="btype" id="code39" value="code39"><label for="code39">code 39</label><br />
          <input type="radio" name="btype" id="code93" value="code93"><label for="code93">code 93</label><br />
          <input type="radio" name="btype" id="code128" value="code128" checked="checked"><label for="code128">code 128</label><br />
          <input type="radio" name="btype" id="codabar" value="codabar"><label for="codabar">codabar</label><br />
          <input type="radio" name="btype" id="msi" value="msi"><label for="msi">MSI</label><br />
          <input type="radio" name="btype" id="datamatrix" value="datamatrix"><label for="datamatrix">Data Matrix</label><br /><br />
        </div>
            
        <div class="config">
          <div class="title">Misc</div>
            Background : <input type="text" id="bgColor" value="#FFFFFF" size="7"><br />
            "1" Bars : <input type="text" id="color" value="#000000" size="7"><br />
          <div class="barcode1D">
            bar width: <input type="text" id="barWidth" value="1" size="3"><br />
            bar height: <input type="text" id="barHeight" value="50" size="3"><br />
          </div>
          <div class="barcode2D">
            Module Size: <input type="text" id="moduleSize" value="5" size="3"><br />
            Quiet Zone Modules: <input type="text" id="quietZoneSize" value="1" size="3"><br />
            Form: <input type="checkbox" name="rectangular" id="rectangular"><label for="rectangular">Rectangular</label><br />
          </div>
          <div id="miscCanvas">
            x : <input type="text" id="posX" value="10" size="3"><br />
            y : <input type="text" id="posY" value="20" size="3"><br />
          </div>
        </div>
            
        <div class="config">
          <div class="title">Format</div>
          <input type="radio" id="css" name="renderer" value="css" checked="checked"><label for="css">CSS</label><br />
          <input type="radio" id="bmp" name="renderer" value="bmp"><label for="bmp">BMP (not usable in IE)</label><br />
          <input type="radio" id="svg" name="renderer" value="svg"><label for="svg">SVG (not usable in IE)</label><br />
          <input type="radio" id="canvas" name="renderer" value="canvas"><label for="canvas">Canvas (not usable in IE)</label><br />
        </div>
      </div>
        
      <!--<div id="submit">-->
      <!--  <input type="button" onclick="generateBarcode();" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Generate the barcode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">-->
      <!--</div>-->
        
    </div>
    
  
					
					
					
					
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Renew-->	
				
				
				
				