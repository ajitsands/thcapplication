<!-- Highlighting rows and columns -->
				<div class="card">
					

					<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_list" style="padding-right:5px;padding-left:5px;">
						<thead>
							<tr>
							    <th >SI</th>
							    <th>ID </th>
								<th>AMC No </th>
								<th>Customer</th>
								<th>Type</th>
								<th >Sign Date</th>
								<th>Start & End Date</th>
								<th>Status</th>
								<th></th>
								<th></th>
								<th></th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
			
			      <input type="hidden" id="txt_amc_ref_no" class="form-control">
				</div>
				<!-- /highlighting rows and columns -->
				
				
			   	<!-- /disabled backdrop Change Status -->
				<?PHP include("amc_change_status_modal.php");?>
				<!-- /disabled backdrop Change Status -->
			
			    
		<!-- Disabled Assets -->
			
				<div id="modal_add_assets" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Assets to  [AMC No : <b><span id="span_cust_amcno"></span></b>]  Name : <span id="span_cust_name"></span>&nbsp;[<span id="span_cust_code"></span>] 
    							            </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
				                    <?PHP include("amc_add_assets_modal.php");?>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg-primary" id="btn_add_assets" >Add Assets</button>
							</div>
						</div>
					</div>
				</div>
				
			
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