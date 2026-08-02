<div class="row">
	<div class="card col-md-12" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">
					AMC Payment
						</h5>
						
					</div>
			
					
	
<!-- Highlighting rows and columns -->
				<div class="card">
				    
				     <div class="card-body" id="tabs">
	                            <ul class="nav nav-tabs nav-tabs-highlight" style="padding-top:2px;margin-bottom: 0.00rem;">
									<li class="nav-item"><a href="#highlight-tab1" class="nav-link active" data-toggle="tab"  id="1">AMC Payment</a></li>
									<li class="nav-item"><a href="#highlighted-tab2" class="nav-link" data-toggle="tab"  id="2">Payment Copmleted</a></li>
								
								
								</ul>

								<div class="tab-content" >
									<div class="tab-pane fade show active" id="highlight-tab1">
									
								<!--	   	<div class="row" style= "margin-left:10px;">-->
						    
						
        					
        <!--						<div id="div_tkts_ref_no" class="col-lg-4 col-md-3 col-sm-12">-->
        <!--							<input type="date" class="form-control " id="txt_end_date" placeholder="End Date" >-->
        <!--							<span class="form-text text-muted" style='font-size: 12px;'><font color="black">End Date</font></span> -->
        <!--						</div>-->
        						
        					
        <!--						<div class="col-lg-2 col-md-3 col-sm-12">-->
        <!--							<button type="button" id="btn_amc_renewal_search" class="btn btn-primary" style="height:40px; width:100px;" ><i class="fa fa-search"></i>SEARCH</button>-->
        <!--							<span class="form-text text-muted" style='font-size: 16px;'><font color="black"></font></span> -->
        <!--						</div>-->
						
					   <!--</div>-->
                 
					<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_payment" style="padding-right:10px;padding-left:10px;">
						<thead>
							<tr>
							    <th>SI No </th>
							    <th>ID </th>
								<th>AMC No </th>
								<!--<th>Customer Name</th>-->
								
								<!--<th>Sign Date</th>-->
								<!--<th>Start & End Date</th>-->
								<th>AMC Amount</th>
								<th>VAT Amount</th>
								<th>Net Amount</th>
								<th>Paid Amount</th>
								<th>Paid VAT Amount</th>
								<th>Total Paid</th>
								<th>Balance</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
			
			      <input type="hidden" id="txt_amc_ref_no" class="form-control">
									
									</div>

					<div class="tab-pane fade" id="highlighted-tab2">
									
                         
        					<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_amc_completed_payment" style="padding-right:10px;padding-left:10px;">
        						<thead>
        							<tr>
        							    <th>SI No </th>
        							    <th>ID </th>
        							    
        								<th>AMC No </th>
        								<th>Customer Name</th>
        								<th>Contact Number</th>
        								<th>AMC Amount</th>
        								<th>VAT Amount</th>
        								<th>Paid Amount</th>
        								<th class="text-center">Actions</th>
        							</tr>
        						</thead>
        						<tbody>
        							
        						</tbody>
        					</table>
        			
        			      <input type="hidden" id="txt_amc_ref_no" class="form-control">
										
				</div>

									

									
								</div>
							</div>
				    
				    
				    
				    
				 
				
				</div>
				
				
		</div>		
		</div>		<!-- /highlighting rows and columns -->
				
		<?PHP include('amc_payments.php') ?>
		<?PHP include('amc_payments_completed.php') ?>
				
			
			    
	
			
				
			
				
				
				
				