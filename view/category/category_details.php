<div class="row">

   <div class="col-md-6">
         <div class="card classContractTypeAndAssetCategoryModify" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Contract Type
						    </h5>
						
					</div>
					
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
										<div class="col-lg-12 col-md-12 col-sm-12" >
										    <input type="hidden" class="form-control" id="txt_contract_id">
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contract Type&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_contract_name" placeholder="Contract Type">
    											
    								
    									</div>
    								
								
								</div>
								
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-6">
									</div>
    									<div class="col-lg-6 col-md-6 col-sm-6">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_contract_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_contract_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_contract_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
				</div>
				
				    
			    </div>	
					
					
	</div>

  </div>
  <div class="col-md-6" > 
		<div class="card classContractTypeAndAssetCategoryModify" >
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Asset Category
						    </h5>
						
					</div>
					
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
										<div class="col-lg-12 col-md-12 col-sm-12" >
										    <input type="hidden" class="form-control" id="txt_cat_id">
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Asset Category &nbsp;<span style="color:red"> *</span></font></span>
    										<input type="text" class="form-control" id="txt_cat_name" placeholder="Asset Category">
    											
    								
    									</div>
    								
								
								</div>
								
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-6">
									</div>
									
    									<div class="col-lg-6 col-md-6 col-sm-6">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_category_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_category_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_category_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
				</div>
				
				    
			    </div>	
					
					
	</div>

</div>




	<div class="col-md-6" >
				
				<div class="row">
						
			
			        <div class="col-md-12">
			    
			   <!-- Single row selection -->
				<div class="card" style="overflow:auto;" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Contract Types</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_contract">
						<thead>
							<tr>
						
							    <th>Sl. No.</th>
							    <th>ID</th>
				                <th>Contract Type</th>
				                <th>Status</th>
				                <th>Action</th>
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
                               
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection --> 
			 </div>
				    
			    </div>	
					
					
	</div>
		<div class="col-md-6" >
				
				<div class="row">
						
			
			        <div class="col-md-12">
			    
			   <!-- Single row selection -->
				<div class="card" style="overflow:auto;" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Asset Categories</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_category">
						<thead>
							<tr>
						
							    <th>Sl. No.</th>
							    <th>ID</th>
				                <th>Asset Category</th>
				                <th>Status</th>
				                <th>Action</th>
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
                               
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection --> 
			 </div>
				    
			    </div>	
					
					
	</div>
</div>	
	
				
				
	
				