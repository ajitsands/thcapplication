<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
}
</style>
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Track Assets</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
							<!-- Single row selection -->
			
						<div class="row">
							    	    
					            	    <div class="col-lg-4 col-md-12 col-sm-12" >
        										<input class="form-control" type="input" name="txt_asset_barcode" id="txt_asset_barcode" placeholder="Asset Barcode">
        										<span class="form-text text-muted">Asset  &nbsp;<i class="icon-barcode2 mr-3 icon-2x"></i></span>
							        </div>
								
							        <!--<div class="col-lg-3 col-md-12 col-sm-12" >-->
        							<!--			<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">-->
        							<!--			<span class="form-text text-muted">To Date</span>-->
							        <!--</div>-->
							         <div class="col-lg-2 col-md-12 col-sm-12 " >
							        	<button type="button" id="btn_search_assets" class="btn bg-info"  >Go</button>
							        </div>
					       </div>
				</div>
				<!-- /single row selection -->
			
				
					
					
	</div>
	
	
	<?php //include("track_assets/track_assets_primary_info.php");?>

		<div id="div_asset_basic_info" ></div>
	
	