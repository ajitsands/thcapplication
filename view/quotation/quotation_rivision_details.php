
<style>
    input[type='file'] {
  width: 95px;
 }
</style>
<?PHP 
	$reference_no = isset($_GET['RefNo']) ? $_GET['RefNo'] : '';
	//echo $reference_no;

?>
	<div class="card">
	    
	     <div class="card-header header-elements-inline">
						<h4 class="card-title">Quotation Rivision List</h4>
						<div class="header-elements">			
						
			            </div>	
		    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
							
								<div class="form-group row">
									
									<?PHP include("quotation_reference_no_combo.php"); ?>
									
									 <div class="col-lg-2 col-md-6 col-sm-12">
									 </div>
									  
		                            <div class="col-lg-2 col-md-6 col-sm-12">
									    <button type="button" id="btn_quotation_rivision_search" class="btn btn-primary" tabindex=2><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; SEARCH</button>
								    </div>
								    
								     <div class="col-lg-2 col-md-6 col-sm-12">
									 </div>
								</div>
								
					

							</div>
						</div>
					</div>
					
					 <!--<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-10 col-md-6 col-sm-12">
									</div>
									<div class="col-lg-2 col-md-6 col-sm-12">
									
										<button type="button" id="btn_quotation_rivision_search" class="btn btn-primary"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; SEARCH</button>
									
									</div>
	
								</div>
					</div>-->
					 
		</div>

				
		<!-- Single row selection -->
	<div id="quotation_rivision_master_table">
			<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Quotations Rivision</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_quotation_rivision_master">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Quotation Ref No.</th>
								<th>Customer Name</th>
				                 <th>Quotation Date</th>
				               <!-- <th>Action</th> -->
								
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						<!-- <tfoot>
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
                        </tfoot> -->
					</table>


					
					<!--text editor ends here   -->
				</div> 
				
				</div> 
				<!-- /single row selection -->
				
				
		<div id="quotation_rivision_child_table">
			<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Quotations Rivision</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_quotation_rivision_child">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Description</th>
								<th>Qty</th>
				                <th>Unit</th>
				                <th>Rate</th>
				                <th>Amount</th>
				                <th>Dis(%)</th>
				                <!--<th>Discount Amt</th>-->
								<th>Tax(%)</th>
								<th>Net Total</th>
				                <!--<th>Action</th>-->
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						<!--<tfoot>
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
                                <th></th> 
                            </tr>
                        </tfoot>-->
					</table>
	
					
					<!--text editor ends here   -->
				</div> 
				
				</div> 
				<!--   text editor starts   -->
				<!--<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">
									
									<label class="control-label">Objectives</label>
									<div class="col-md-12" id="editor">

									 </div>

								</div>
								
							</div>
							
						</div>
						
					</div>-->
					<!--   text editor ends   -->