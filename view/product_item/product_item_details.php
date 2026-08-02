

	<div class="card">
					<?PHP
					
						include('template/card_head_control.inc');
					
					?>

					<div class="card-body">
					
					
						
							<div class="row">
							    
						     	<?PHP include_once("product_category_combo.php"); ?>
						     	<div  class="col-lg-3 col-md-6 col-sm-12"  id="div_list_product_type">
						     	
						     	       
						        </div>
								<div class="col-lg-6 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_product_item_name" placeholder="Product Item Name" tabindex=2>
    									<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT ITEM NAME</font></span>
    								 
                					</div>
                					<input type="hidden" id="txt_product_item_id"/>
							    </div>
						
						</div>
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									
										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:10px;color:red;">
    									    <font><b>* Above all details are mandatory</b></font>
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_product_item_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_product_item_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_product_item_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Product Item</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_product_item">
						<thead>
							<tr>
							   
							    <th>Sl No</th>
							    <th></th>
							    <th></th>
				                <th>Product Category</th>
				                <th></th>
				                <th>Product Type</th>
				                <th>Product Item </th>
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
                                <th></th>
                                <th></th>
                                <th></th>
                               
                               
                               
                                
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!--single row selection -->
				