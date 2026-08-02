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

<!--<div class="card">-->
<!--				<div class="card-header header-elements-inline">-->
<!--						<h5 class="card-title">Search Completed Complaints </h5>-->
<!--						<div class="header-elements">-->
						
<!--	                	</div>-->
<!--					</div>-->


<!--					<div class="card-body">-->
							<!-- Single row selection -->
			
<!--						<div class="row">-->
							    	    
<!--					            	    <div class="col-lg-3 col-md-12 col-sm-12" >-->
<!--        										<input class="form-control" type="date" name="txt_start_date" id="txt_start_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">-->
<!--        										<span class="form-text text-muted">From Date</span>-->
<!--							        </div>-->
								
<!--							        <div class="col-lg-3 col-md-12 col-sm-12" >-->
<!--        										<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">-->
<!--        										<span class="form-text text-muted">To Date</span>-->
<!--							        </div>-->
<!--							         <div class="col-lg-2 col-md-12 col-sm-12 " >-->
<!--							        	<button type="button" id="btn_search_tickets" class="btn bg-info"  >Search</button>-->
<!--							        </div>-->
<!--					                </div>-->
<!--				</div>-->
				<!-- /single row selection -->
			
				
					
					
<!--	</div>-->

	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Cancelled Work Orders</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
					
						<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="row" style="margin-top: 10px;margin-left:10px;">
						<div class="col-lg-2 col-md-2 col-sm-2 ml-auto" >
							<button type="button" id="cancelled_pdf" class="btn bg-warning exportToPDFAction classWorkOrdersCancelledPDF">PDF</button>
						
							<button type="button" id="cancelled_excel" class="btn bg-primary exportToExcelAction classWorkOrdersCancelledExcel">Excel</button>
						</div>
					</div>
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_cancelled_tickets">
						<thead>
							<tr>
							    
							    <th>SL. No.</th>
				                <th>Date & Time</th>
								<th>Ref. No.</th>				                
				                <th>Customer</th>
				                <th>Location</th>
				                <th>Building</th>
				                <th>Priority</th>
				                <th>Cancelled On</th>
				                <th>Reason</th>
				                <th>Action</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				</div>
				<!-- /single row selection -->
					
					
					
					
					
					
						
					</div>
				
					
					
	</div>
				
				
				

				