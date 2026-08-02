	<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">Work Orders - Team Wise</h6>
								<div class="header-elements">
								<div class="row">
        								<div class="col-lg-4 col-md-12 col-sm-12" >
                										<sup>From</sup><input class="form-control" type="date" name="txt_start_date" id="txt_start_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        							        </div>
        								
        							        <div class="col-lg-4 col-md-12 col-sm-12" >
                										<sup>To</sup><input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
                									
        							        </div>
        							         <div class="col-lg-2 col-md-12 col-sm-12 " >
        							        <button type="button" class="btn btn-info" id="btn_dash_wo_search">Search</button>
        							        
        							        </div>
        							 </div>
								
								</div>
							</div>

						
                            <div id="div_load_dashboard_wos"></div>
						
						</div>