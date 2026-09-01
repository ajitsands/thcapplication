
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

<div class="card">
	                            <?PHP
					
						            include('template/card_head_control.inc');
					
					            ?>
	                       <div class="card-body" id="tabs">
	                            <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#highlight-tab1" class="nav-link active" data-toggle="tab"  id="1">CPR Expiry </a></li>
									<li class="nav-item"><a href="#highlighted-tab2" class="nav-link" data-toggle="tab"  id="2">Visa Expiry</a></li>
								
								
								</ul>

								<div class="tab-content" >
									<div class="tab-pane fade show active" id="highlight-tab1">
										<div class="card" style="overflow:auto;">
                            				
                                                	<div class="card-body">
				    
						<div class="row" >
						    
						
        					
        						<div id="div_tkts_ref_no" class="col-lg-4 col-md-3 col-sm-12">
        						    <span class="form-text text-muted font-weight-bold" style='font-size: 12px;'><font color="black">Search by a date to check CPR validity</font></span>
        							<input type="date" class="form-control " id="txt_end_date" placeholder="End Date" >
        							 
        						</div>
        						
        					
        						<div class="col-lg-4 col-md-6 col-sm-12" style="padding-top:20px">
        							<button type="button" id="btn_customer_search" class="btn btn-primary" style="height:40px; width:100px;" ><i class="fa fa-search"></i>SEARCH</button>
        						
        							<button type="button" id="btn_cpr_export" class="btn btn-warning classExportToPDF classCPRExpiryPDF" style="height:40px; width:100px;" ><i class="fa fa-icon-database-edit2"></i>EXPORT</button>
        						
        						</div>
        					
						
					   </div>
				</div> 
                            				
                            	<div class="card-header header-elements-inline">
                            						<h5 class="card-title">List of Employees</h5>
                            						
                            					</div>
                            					<table class="table datatable-selection-single" id="list_of_CPR_employees" style="width:100%;">
                            						<thead>
                            							<tr>
                            							    <th style="width:30px;"></th>
                            							    <th style="width:50px;">Sl.No.</th>
                            							    <th></th>
                            				                <th style="min-width:240px;">Emp. Name</th>
                            				                <th>Emp. Type</th>
                            				                <th>Emp. Code</th>
                            				                <th>CPR Expiry Date</th>
                            				                <th>Emp. Image</th>
                            				                <th>CPR Status</th>
                            				                <th>Emp. Status</th>
                            				            </tr>
                            						</thead>
                            						<tbody>
                            							
                            				               
                            						</tbody>
                            						<tfoot>
                                                        <tr>
                                                			<th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                           <th></th>
                                                            
                                                        </tr>
                                                    </tfoot>
                            					</table>
                            				</div>
                            									    
									
									</div>

									<div class="tab-pane fade" id="highlighted-tab2">
									  <div class="card" style="overflow:auto;">
                            				
                            
                            					<div class="card-body">
				    
                            						<div class="row" >
                                    					
                                    						<div id="div_tkts_ref_no" class="col-lg-4 col-md-3 col-sm-12">
                                    						    <span class="form-text text-muted font-weight-bold" style='font-size: 12px;'><font color="black">Search by a date to check visa validity</font></span> 
                                    							<input type="date" class="form-control " id="txt_end_date_visa" placeholder="End Date" >
                                    							
                                    						</div>
                                    						
                                    					
                                    						<div class="col-lg-4 col-md-6 col-sm-12" style="padding-top:20px">
                                    							<button type="button" id="btn_customer_search_visa" class="btn btn-primary" style="height:40px; width:100px;" ><i class="fa fa-search"></i>SEARCH</button>
                                    							<button type="button" id="btn_visa_export" class="btn btn-warning classExportToPDF classVisaExpiryPDF" style="height:40px; width:100px;" ><i class="fa fa-icon-database-edit2"></i>EXPORT</button>
        						
                                    						</div>
                            						
                            					    </div>
                            				  </div> 
                            	<div class="card-header header-elements-inline">
                            						<h5 class="card-title">List of Employees</h5>
                            						
                            					</div>
                            					<table class="table datatable-selection-single" id="list_of_visa_employees" style="width:100%;">
                            						<thead>
                            							<tr>
                            							    <th style="width:30px;"></th>
                            							    <th style="width:50px;">Sl. No.</th>
                            							    <th></th>
                            				                <th style="min-width:240px;">Emp. Name</th>
                            				                <th>Emp. Type</th>
                            				                <th>Emp. Code</th>
                            				                <th>Visa Valid Upto</th>
                            				                <th>Emp. Image</th>
                            				                <th>Visa Status</th>
                            				                <th>Emp. Status</th>
                            				            </tr>
                            						</thead>
                            						<tbody>
                            							
                            				               
                            						</tbody>
                            						<tfoot>
                                                        <tr>
                                                			<th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            
                                                            
                                                        </tr>
                                                    </tfoot>
                            					</table>
                            				</div>
										
									</div>

								

									
								</div>
							</div>
						</div>
				
				
				
	<!-- Single row selection -->
			
				<!-- /single row selection -->
				