<div class="row">
    <div class="col-md-6" >
       
						
			
		
	<div class="card" >
	    	<?PHP
					
						include('template/card_head_control.inc');
					
					?>
				
				<div class="row">
						
			
			        <div class="col-md-12">
			    
			   <!-- Single row selection -->
			   


					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										
										<div class="col-lg-12 col-md-12 col-sm-12" >
										    <input type="hidden" class="form-control" id="txt_product_category_id">
    										<input type="text" class="form-control" id="txt_product_category_name" placeholder="Product Category Name">
    											<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT CATEGORY NAME</font></span>
    								
    									</div>
    								
								
								</div>
								
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									
									
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_product_category_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_product_category_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_product_category_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
				</div>	
				</div>
				
				    
			    </div>
		
	</div>				
					
    <div class="col-md-6" >
        
	<div class="card" >
	    	<?PHP
					
						include('template/card_head_control1.inc');
					
					?>
				
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
										<?PHP include_once("product_category_combo.php"); ?>
    								
								
							
									   
										
										<div class="col-lg-6 col-md-6 col-sm-12" >
										    <input type="hidden" class="form-control" id="txt_product_category_type_id">
    										<input type="text" class="form-control" id="txt_product_type" placeholder="Product Type">
    											<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT TYPE</font></span>
    								
    									</div>
    								
								
								</div>
								
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									
									
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_prdt_type_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_prdt_type_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_prdt_type_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
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
						<h5 class="card-title">List of Product Category</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_product_category">
						<thead>
							<tr>
						
							    <th>Sl No</th>
							    <th>ID</th>
				                <th>Name</th>
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
						<h5 class="card-title">List of Product Category</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_prdt_category_type">
						<thead>
							<tr>
						
							    <th>Sl No</th>
							     <th></th>
							    <th>Product Category</th>
				                <th>Type</th>
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
				
	
				