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
						<h5 class="card-title">Activity Log Report</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
							<!-- Single row selection -->
			
						<div class="row">
							    	    
					            	    <div class="col-lg-3 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_start_date" id="txt_start_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        										<span class="form-text text-muted"> Date</span>
							        </div>
								
							        <div class="col-lg-3 col-md-12 col-sm-12" style="display:none">
        										<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        										<span class="form-text text-muted">To Date</span>
							        </div>
							        <div class="col-lg-3 col-md-12 col-sm-12" >
        										<select class="form-control form-control-select2" id="select_status" data-placeholder="Select Status" data-fouc tabindex=1>
                                        	    <option value="All" selected>All</option>
                                        	    <option value="Pending" >Pending</option>
                                        	    <option value="Completed" >Completed</option>
                                        	    
                                        	    
                                              </select>
        										<span class="form-text text-muted">Status</span>
							        </div>
							         <div class="col-lg-2 col-md-12 col-sm-12 " >
							        	<button type="button" id="btn_go" class="btn bg-info">Go</button>
							        
							        	<button type="button" id="btn_print" class="btn bg-success classWOReportsDailyActivityLogPDF classExportToPDF">
						 			<i class="icon-printer4"></i>
					 			</button>
							        </div>
					       </div>
				</div>
				<!-- /single row selection -->
			
		
					
					
	</div>
	
			    
			   <!-- Single row selection -->
				<div class="card" style="overflow:auto;" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Services</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table  responsive bkgrnd  display"  style="width:100%" id="list_of_services">
						<thead>
							<tr>
						        <th width="10px"></th>
							   <td width="10px" style="text-align:center"><b>WO.No. </b></td>
                    		    <td  width="10px" style="text-align:center"><b>Tasks </b></td>
                    		    <td width="10px" style="text-align:center"><b>Status </b></td>
                    		    <td width="30px" style="text-align:center"><b>Service Start </b></td>
                    		    <td width="30px" style="text-align:center"><b>Service End </b></td>
                    		    <td width="10px" style="text-align:center"><b>Duration </b></td>
                    		    <td width="10px"  style="text-align:center"><b>Remarks </b></td>
				               
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						
					</table>
				</div>
				<!-- /single row selection --> 
		

		<!--<div id="div_list_teams" ></div>-->
	
	