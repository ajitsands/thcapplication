
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

	
				
	<!-- Single row selection -->
			<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Quotations</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
							
								<div class="form-group row">
				
									<div class="col-lg-3 col-md-6 col-sm-12">
											<input class="form-control" type="date" id="quotation_start_date" tabindex=1>
											<span class="form-text text-muted"><font color="black"> START DATE&nbsp;<span style="color:red;">*</span></font></span>
											
									</div>
									
									
									<div class="col-lg-3 col-md-6 col-sm-12">
											<input class="form-control" type="date" id="quotation_end_date" tabindex=2>
											<span class="form-text text-muted"><font color="black">END DATE&nbsp;<span style="color:red;">*</span></font></span>
											
									</div>
									
									<?PHP include("quotation_customer_combo.php"); ?>
									
									<div class="col-lg-2 col-md-6 col-sm-12">
										<button type="button" id="btn_quotation_search" class="btn btn-primary" tabindex=4><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; SEARCH</button>
										
									</div>
								
								</div>
			
							</div>
						</div>
					</div>

					<table class="table datatable-selection-single" id="list_of_quotation_view11">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Quotation Ref No.</th>
								<th>Customer Name</th>
				                 <th>Quotation Date</th>
				                <th>Action</th> 
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
                                <th></th>
                            </tr>
                        </tfoot>-->
					</table>
			</div>		
			