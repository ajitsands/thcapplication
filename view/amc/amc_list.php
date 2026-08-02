

<!-- Highlighting rows and columns -->
				
				<!--	<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_list" style="padding-right:5px;padding-left:5px;">-->
				<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight display" id="tbl_amc_list" style="padding-right:5px;padding-left:5px;">
						<thead>
							<tr>
							    <th></th><!--0-->
							    <th >SL.No.</th><!--1-->
							    <th>ID </th><!--2-->
								<th>AMC No </th><!--3-->
								<th>Customer</th><!--4-->
								<th>Type</th><!--5-->
								<th>Start Date</th><!--6-->
								<th>End Date</th><!--7-->
								<th>Status</th><!--8-->
								<th>VAT %</th><!--9--> 
								<th>Amount</th><!--10-->
								<th>Yearly AMC Amount</th><!--11-->
								<th>VAT Amount</th><!--12-->
								<th>AMC Number</th><!--13-->
								<th>Description</th><!--14-->
								<th class="text-center">Actions</th><!--15-->

							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
			 
			      <input type="hidden" id="txt_amc_ref_no" class="form-control">
				
				<!-- /highlighting rows and columns -->
			
				<?PHP include("modal_amc_child_details.php");?>
			   	<!-- /disabled backdrop Change Status -->
				<?PHP include("amc_change_status_modal.php");?>
				<!-- /disabled backdrop Change Status -->
			
		<!-- modal assign to Subcontractors -->	    
				
				<div id="modal_assign_to_subcontractors" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1" aria-hidden="true" style="display: none;">
					<div class="modal-dialog modal-xl" style="max-width:70%">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title"><span id="amc_ref_no_sub"><b></b></span></h5>
								<button type="button" class="close" data-dismiss="modal">×</button>
							</div> 
							<form id="assign_sub_form">
							<div class="modal-body">
								
							    <div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<div class="col-lg-5 col-md-5 col-sm-5" id="div_subcontractors_load" >
												
											</div>
											
											<?PHP //include("subcontractor_combo.php");?>
											<div class="col-lg-2 col-md-2 col-sm-2">
												<span class="form-text text-muted font-weight-bold"><font color="black">Amount&nbsp;<span style="color:red;">*</span></font></span> 
												<input type="text"  class="form-control " id="txt_contractor_amount" name="Amount"  placeholder="0.000" tabindex=2>
											</div>
											
											<div class="col-lg-2 col-md-2 col-sm-2">
												<span class="form-text text-muted font-weight-bold"><font color="black">VAT %&nbsp;<span style="color:red;">*</span></font></span> 
												<input type="text"  class="form-control " id="txt_contractor_vat" name="VAT%"  placeholder="0.000" tabindex=3>
											</div>
											
											<div class="col-lg-3 col-md-3 col-sm-3">
												<span class="form-text text-muted font-weight-bold"><font color="black">Total Amount&nbsp;<span style="color:red;">*</span></font></span> 
												<input type="text"  class="form-control " id="txt_contractor_total_amount" name="Total Amount" placeholder="0.000" tabindex=4 disabled>
											</div>
											
											<div class="col-lg-6 col-md-6 col-sm-12">
											 <span class="form-text text-muted font-weight-bold"><font color="black">Start &amp; End Date&nbsp;<span style="color:red;">*</span></font></span>
												<div class="input-group">
													<input type="text" id="txt_list_contractor_start_end_date" class="form-control daterange-basic" value="%11-%07-%2023 - %11-%07-%2024" tabindex=5> 
													<span class="input-group-append">
														<span class="input-group-text"><i class="icon-calendar22"></i></span>
													</span>
												</div>
											</div>
											
											<div class="col-lg-6 col-md-6 col-sm-6">
												<span class="form-text text-muted font-weight-bold"><font color="black">Description&nbsp;<span style="color:red;">*</span></font></span> 
												<input type="text"  class="form-control " id="txt_contractor_description" name="Description" placeholder="Description" tabindex=6>
											</div>
											
											<div class="col-lg-12 col-md-12 col-sm-12">
												 <span class="form-text text-muted font-weight-bold"><font color="black">File Upload&nbsp;</font></span>	
												<input type="file" class="form-input-styled"  id="session_image" accept="image/*" title="&nbsp;" tabindex=7 data-fouc=""/><p id="amc_contractor_file_name"></p>
												<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
											</div>
											
										</div>
									</div>
								</div>
								
            					
							<div class="modal-footer">
								
								<button type="button" class="btn bg-teal-400 ladda-button legitRipple" id="btn_assign_subcontractors" ><i class="icon-floppy-disk mr-2"></i>Add</button>
								<button type="button" class="btn bg-warning-400 ladda-button legitRipple" id="btn_edit_assign_subcontractors" ><i class="icon-pencil3 mr-2"></i>Edit</button>
								
							</div>
							
						<!-- assigned subcontactor list table -->	
							<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight display" id="tbl_amc_assigned_subcontractor_list" style="padding-right:5px;padding-left:5px;">
								<thead>
									<tr>
										 <th ></th>
										<th >SL.No.</th>
										<th>Subcontractor </th>
										<th>Amount </th>
										<th>VAT %</th>
										<th>Total Amount</th>
										<th>Status</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
								<tfoot>
									<th ></th>
									<th ></th>
									<th ></th>
									<th ></th>
									<th >Total : </th>
									<th ></th>
									<th ></th>
									<th ></th>
								</tfoot>
							</table>
							
						<!-- /assigned subcontactor list table -->	
						</div>
						</form>
					</div>
				</div>
				
				</div>
				
		<!-- /modal assign to Subcontractors -->	
		
		<!-- Deactive reason modal -->
		<div id="modal_deactive_reason" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" ><span id="amc_ref_no_reason"></span></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
                                <div class="form-group row">
									<label class="col-form-label col-lg-4">Reason for Deactive</label>
									<div class="col-lg-12">
										<textarea rows="2" cols="2" class="form-control" id="txt_deactive_reason" placeholder="Reason"></textarea>
									</div>
								</div>
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_deactive">Deactive</button>
							</div>
						</div>
					</div>
				</div>
		<!-- /Deactive reason modal -->
		
		<!-- Disabled Assets -->
			
				<!--<div id="modal_add_assets" class="modal fade" data-backdrop="false" tabindex="-1">-->
				<!--	<div class="modal-dialog modal-lg">-->
				<!--		<div class="modal-content">-->
				<!--			<div class="modal-header bg-info">-->
				<!--				<h5 class="modal-title">Add Assets to  [AMC No : <b><span id="span_cust_amcno"></span></b>]  Name : <span id="span_cust_name"></span>&nbsp;[<span id="span_cust_code"></span>] -->
    <!--							            </h5>-->
				<!--				<button type="button" class="close" data-dismiss="modal">&times;</button>-->
				<!--			</div>-->

				<!--			<div class="modal-body">-->
				<!--                    <?PHP //include("amc_add_assets_modal.php");?>-->
				<!--			</div>-->

				<!--			<div class="modal-footer">-->
				<!--				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
				<!--				<button type="button" class="btn bg-primary" id="btn_add_assets" >Add Assets</button>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
				<!--</div>-->
				
			
				<!-- /disabled Assets -->
				
				
		
				<!--// MODAL FOR BUILDING-->
				<?PHP include("amc_location_building_modal.php");?>
				
				<!--// MODAL FOR BUILDING end -->	

			
				<!-- Disabled backdrop Renew-->
				<?PHP include("amc_renew_modal.php");?>
				<!-- /disabled backdrop Renew-->	
				
				<!-- Disabled backdrop Schedule-->
			<?php include("amc_schedule_visits.php");?>
				<!-- /disabled backdrop Schedule-->	
				
					<!-- Disabled backdrop Schedule-->
			<?php include("amc_payments.php");?>
				<!-- /disabled backdrop Schedule-->	
					<!-- backdrop Barcode-->
				<div id="modal_barcode" class="modal fade" data-backdrop="false" tabindex="-1">
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
				
				
				
		    <!-- ADD SERVICES  -->  
		    
		    <?php include("amc_add_services_modal.php");?>
		    <!-- ADD SERVICES END -->
		     <!-- ASSIGN ASSETS  -->
		    
		    <?php include("amc_assign_assets_modal.php");?>
		    <!-- ASSIGN ASSETS END -->