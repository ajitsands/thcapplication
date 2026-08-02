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
						<h5 class="card-title">Daily Team Report</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
							<!-- Single row selection -->
			
						<div class="row">
							    	    
					            	    <div class="col-lg-3 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_start_date" id="txt_start_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        										<span class="form-text text-muted">Specify Date</span>
							        </div>
								
							        <!--<div class="col-lg-3 col-md-12 col-sm-12" >-->
        							<!--			<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">-->
        							<!--			<span class="form-text text-muted">To Date</span>-->
							        <!--</div>-->
							         <div class="col-lg-2 col-md-12 col-sm-12 " >
							        	<button type="button" id="btn_go" class="btn bg-info"  >Go</button>
							        </div>
					       </div>
				</div>
				<!-- /single row selection -->
			
				
					
					
	</div>
	

		<div id="div_list_teams" ></div>
	
	