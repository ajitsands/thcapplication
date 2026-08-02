<style>
.advisorsExportButton
{
    color:green;
position: absolute;
left: 1000px;
bottom: 16px;

}


</style>
<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
}
#btn_asset_qr_pdf, #btn_asset_code_excel, #btn_asset_code_pdf{
    margin: 5px;
}
</style>
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Assets</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
							<!-- Single row selection -->
			
						<div class="row">
							    	    
			            		<div class="col-lg-3 col-md-3 col-sm-12" id="div_customer_details">	
									<?PHP include_once("asset_customer_combo.php"); ?>
									<input type="hidden" class="form-control" id="txt_contact_person_building_code" maxlength="4" style="text-transform: uppercase"   placeholder="Building CODE">
    								
							    </div>
						     
						         
						        <?PHP include_once("location_combo_customer_building.php"); ?>
								<div class="col-lg-3 col-md-3 col-sm-12" id="div_customer_category_details">
						         
						         <?PHP include_once("asset_category_combo.php"); ?>
						         </div>
							    	
							         <div class="col-lg-2 col-md-12 col-sm-12 " style="padding-top:25px">
							        	<button type="button" id="btn_search_asset_codes" class="btn bg-info"  >Go</button>
							        </div>
				       </div>
				</div>
				<!-- /single row selection -->
			
				
					
					
	</div>
	
		<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Asset Details</h5>
						<div class="header-elements">
						    <button type="button" id="btn_asset_qr_pdf" class="btn bg-success classDownloadAssetsPrintQR">Print QR Code</button>
						    <button type="button" id="btn_asset_code_excel" class="btn bg-primary exportToExcelAction classDownloadAndAssetsExcel">EXCEL</button>	
						    <button type="button" id="btn_asset_code_pdf" class="btn bg-warning exportToPDFAction classDownloadAndAssetsPDF">PDF</button>
	                	</div>
					</div>
                   
					<table class="table datatable-selection-single" id="list_of_asset_codes">
						<thead>
							<tr>
							   
							    <th width="1%">SL.No.</th>
							    <th width="20%">Asset Code</th>
							    <th width="8%">QR</th>
							    <th width="10%">Category</th>
				                <th width="10%">Type</th>
							    <th width="25%">Customer</th>
							    <th width="10%">Location</th>
				                <th width="20%">Building</th>
			                    
				                
				                 
				               
				                
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				</div>
	
	
	<?php //include("track_assets/track_assets_primary_info.php");?>

	<!--	<div id="div_asset_basic_info" ></div>-->
	
	