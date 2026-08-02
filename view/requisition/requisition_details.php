<?PHP
$v_requ_no = $_GET['RefNo']
?>
			
		
				
	<div class="card">
	          <div class="card-header header-elements-inline">
	        	<h4 class="card-title">Material Requisitions
						    </h4>
				<div class="header-elements">			
							<button type="button" id="btn_reload" class="btn bg-blue-400 legitRipple ladda-button" data-popup="tooltip" title="" data-placement="bottom" data-original-title="Clear All" data-style="expand-right"><span class="ladda-label"><b><i class="icon-reset"></i></b></span><span class="ladda-spinner"></span><div class="legitRipple-ripple" style="left: 58%; top: 68.4211%; transform: translate3d(-50%, -50%, 0px); width: 251.205%; opacity: 0;"></div></button>
							
							
					        	</div>			
	        	</div>
				<div class="card-body">
				       <div class="row">
				        <div class="col-lg-2 col-md-2 col-sm-12" style="padding-top:25px;">   
    						 AMC <input type="radio" name="answer" value="AMC"  checked/ tabindex=1>
    						&nbsp;&nbsp;&nbsp; Work Order <input type="radio"  name="answer" value="TICKETS" / tabindex=2>
						</div>
						<div id="div_amc_ref_no" class="col-lg-4 col-md-2 col-sm-12">
						<input type="text" class="form-control " id="txt_amc_ref_no_requisition" placeholder="AMC Ref. No"  tabindex=3>
						<span class="form-text text-muted" style='font-size: 12px;' ><font color="black">AMC Ref.No &nbsp;</font></span> 
						</div>
						<div id="div_tkts_ref_no" class="col-lg-4 col-md-2 col-sm-12">
						<input type="text" class="form-control " id="txt_tkt_ref_no_requisition" placeholder="Work Order No" tabindex=4 >
						<span class="form-text text-muted" style='font-size: 12px;'><font color="black">Work Order No &nbsp;</font></span> 
						</div>
						<div class="col-lg-1 col-md-2 col-sm-12" style="padding-top:20px;" >
						    <button type="button" id="btn_ref_search" class="btn btn-primary legitRipple ladda-button" data-popup="tooltip" title="" data-placement="bottom" data-original-title="Search" data-style="expand-right"><span class="ladda-label"><b><i class="fa fa-search"></i></b></span><span class="ladda-spinner"></span><div class="legitRipple-ripple" style="left: 58%; top: 68.4211%; transform: translate3d(-50%, -50%, 0px); width: 251.205%; opacity: 0;"></div></button>
							<!--<button type="button" id="btn_ref_search" class="btn btn-primary" style="height:27px; width:40px;" style="padding-bottom:25px;"><i class="fa fa-search" > </i></button>-->
					
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12">
						
						<input type="text" class="form-control " id="txt_requisition_serial_no" style='font-size: 14px;font-weight: bold;' placeholder="Requisition Serial No" disabled >
								 <span class="form-text text-muted"><font color="black">Requisition Serial No &nbsp;</font></span> 
	                	</div>
	                	
	                	</div>
				</div>


				<div class="card-body" id="tbl_amc">
					<input type="hidden" class="form-control" id="txt_hidden_amc_ref_no">
					<input type="hidden" class="form-control" id="txt_hidden_tckt_ref_no">
					 <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details"></span><span class="badge bg-teal" id="span_location_details"></span><span class="badge bg-teal" id="span_building_details"></span></h5>
						<!-- Single row selection -->
				<div style="overflow:auto;">
					
					
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_amc_asset_requisition_new">
						<thead>
							<tr>
							    
							 
				                <th>SI NO</th>
								<th>Asset Code</th>
								<th>Category</th>
								<th>Type</th>
								
							
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
					
					
					
					
					
				</div>
				<!-- /single row selection -->
	
					</div>
				
					<div class="card-body" id="tbl_tickets">
					
					
					 <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details_tickets"></span><span class="badge bg-teal" id="span_location_details_tickets"></span><span class="badge bg-teal" id="span_building_details_tickets"></span></h5>
						<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_tickets_asset_requisition">
						<thead>
							<tr>
				                <th>SI No</th>
								<th>Work Order Code</th>
								<th>Category</th>
								<th>Type</th>
								<th>Complaint</th>
								
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				</div>
				<!-- /single row selection -->
	
					</div>
					           <input type="hidden" class="form-control " id="txt_requsition_no_hidden" value=<?PHP echo $v_requ_no ?> >
					           
								<input type="hidden" class="form-control " id="txt_asset_code_amc" placeholder="ASSET CODE" >
								<input type="hidden" class="form-control " id="txt_tickets_amc" placeholder="ASSET CODE" >
							    <input type="hidden" class="form-control " id="txt_amc_child_id" placeholder="ASSET CODE" >	
							
								<input type="hidden"  class="form-control text-uppercase" id="txt_customer_code_amc" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" placeholder="CUSTOMER NAME">
							
								<input type="hidden" class="form-control " id="txt_building_name_amc" placeholder="BUILDING NAME" >
								 
								<input type="hidden"  class="form-control text-uppercase" id="txt_location_name_amc" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" placeholder="LOCATION">
							
    							<input type="hidden" class="form-control" id="txt__hidden_amc_location_id">	
    							<input type="hidden" class="form-control" id="txt__hidden_amc_building_id">	
    							<input type="hidden" class="form-control" id="txt__hidden_amc_customer_id">	
								<input type="hidden" class="form-control" id="txt_hidden_requisition_child_id">	
				                <input type="hidden" class="form-control" id="txt_hidden_requisition_mode">	
				<!-- /large navbar -->


			</div>
			
			
				<div class="card">
					<div class="card-body">
					
					
						
							<div class="row">
							    <div class="col-lg-3 col-md-3 col-sm-12" id="div_select_product_category_for_master">
						     	<?PHP include_once("requisition/select_product_category_requisition_combo.php"); ?>
						     		
						     	</div>
						     	<div  class="col-lg-3 col-md-3 col-sm-12"  id="div_list_product_type_master">
						     	        <select data-placeholder="Select Product Type" id="" class="form-control form-control-select2" data-fouc tabindex=6>
                                            <option value="select">Select Product Type</option>
                                        </select>
     	                                <span class="form-text text-muted"><font color="black">Product Type&nbsp;<span style="color:red;">*</span></font>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_type_req1"><i class="icon-plus22"></i></button></span>
						        </div>
								<div  class="col-lg-3 col-md-3 col-sm-12"  id="div_list_product_item">
						     	
						     	       <select data-placeholder="Select Product Item" id="" class="form-control form-control-select2" data-fouc tabindex=7>
                                         <option value="select">Select Product Item</option>
                                        
                                      </select>
     	                                <span class="form-text text-muted"><font color="black">Product Item&nbsp;<span style="color:red;">*</span></font>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_item_req"><i class="icon-plus22"></i></button></span>
						        </div>
						        <div  class="col-lg-3 col-md-3 col-sm-12"  id="div_list_product_brand">
						     	
						     	       <select data-placeholder="Select Brand" id="" class="form-control form-control-select2" data-fouc tabindex=8>
                                         <option value="select">Select Brand</option>
                                        
                                      </select>
     	                                <span class="form-text text-muted"><font color="black">Brand&nbsp;<span style="color:red;"></span></font>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn bg-blue-400 btn-icon rounded-round" id="btn_add_brand_req"><i class="icon-plus22"></i></button></span>
						        </div>
						
						</div>
						
						<div class="row">
							    
						     <div class="col-lg-3 col-md-3 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="number" class="form-control" id="txt_product_unit_rate" placeholder="Product Unit Rate" tabindex=9 >
    									<span class="form-text text-muted" style="color:black;"><font color="black">Product Unit Rate&nbsp;<span style="color:red;">*</span></font></span>
    								 
                					</div>
                				
							    </div>
							    <div class="col-lg-3 col-md-3 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_product_unit" placeholder="Product Unit" tabindex=10 >
    									<span class="form-text text-muted" style="color:black;"><font color="black">Product Unit&nbsp;<span style="color:red;">*</span></font></span>
    								 
                					</div>
                				
							    </div>
							    <div class="col-lg-3 col-md-3 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="number" class="form-control" id="txt_product_quantity" placeholder="Product Quantity" tabindex=11>
    									<span class="form-text text-muted" style="color:black;"><font color="black">Product Quantity &nbsp;<span style="color:red;">*</span></font></span>
    								 
                					</div>
                					
							    </div>
						     	<div class="col-lg-3 col-md-3 col-sm-12">
                					<div class="card-body" >
                					     <input type="number" class="form-control" id="txt_product_grant_total" placeholder="Grant Total" disabled tabindex=12>
    									<span class="form-text text-muted" style="color:black;"><font color="black">Grant Total &nbsp;<span style="color:red;">*</span></font></span>
    								 
                					   	
                					</div>
                					
							    </div>
								
								 </div>
								
								
								<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">
								
								 </div>
								<div class="col-lg-2 col-md-6 col-sm-12">
						            <button type="button" id="btn_requisition_add" class="btn btn-primary"  tabindex=13><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
							    </div>
							    <div class="col-lg-2 col-md-6 col-sm-12">
						              <button type="button" id="btn_edit_requisition" class="btn btn-warning" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save Changes</button>
							    </div>
								<div class="col-lg-2 col-md-6 col-sm-12">
						            <button type="button" id="btn_requisition_new" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;New</button>
                					
							    </div>
						  </div>
						</div>
		
					</div>
					
					
					
				<div class="card">
						<div class="card-body" id="tbl_child">
					
					
					 <!--<h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details_tickets"></span><span class="badge bg-teal" id="span_location_details_tickets"></span><span class="badge bg-teal" id="span_building_details_tickets"></span></h5>
						<!-- Single row selection -->
				<div style="overflow:auto;">
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_requisition_child">
						<thead>
							<tr>
							    
							 
				                <th>SI No</th>
								<th>Asset Code</th>
								<th>Category</th>
								<th>Type</th>
								<th>Item</th>
								<th>Unit</th>
								<th>Quantity</th>
								<th>Total</th>
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
								<th>Total</th>
								<th></th>
								<th></th>
				            </tr>
						</tfoot>
					</table>
				</div>
				<!-- /single row selection -->
					<div class="row">
        					<div class="col-lg-2 col-md-6 col-sm-12">
        					<button type="button" id="btn_print_requisition" class="btn btn-info" ><b><i class="icon-printer2"></i></b>&nbsp;&nbsp;&nbsp;PRINT</button>
        						
        					</div>
        					<div class="col-lg-7 col-md-6 col-sm-12">
        						
        					</div>
            				<div class="col-lg-3 col-md-6 col-sm-12">
            				
            					<button type="button" id="btn_requisition_generate" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;GENERATE REQUISITION</button>
            				    <button type="button" id="btn_requisition_edit" class="btn btn-warning" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;EDIT REQUISITION</button>
            							
            				</div>
				  </div>
					</div>
					
				</div>	
					
				<!--  ADD CATEGORY -->
				<div id="add_new_category_req" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<h5 class="modal-title">Add Category</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    <div class="card-body">
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
						</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
									<button type="button" id="btn_product_category_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
							</div>
						</div>
					</div>
				</div>
				<!-- /ADD CATEGORY -->
				
				<!--  ADD PRODUCT TYPE -->
				<div id="add_new_type_req" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="modal-header bg-primary ">
								<h5 class="modal-title">Add Type</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
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
				
						</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" id="btn_prdt_type_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    												
							</div>
						</div>
					</div>
				</div>
				<!-- /ADD PRODUCT TYPE -->
			
			   <!--  ADD PRODUCT ITem -->
				<div id="add_new_item_req" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg ">
						<div class="modal-content">
							<div class="modal-header bg-primary ">
								<h5 class="modal-title">Add Product Item</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							   <div class="card-body">
					
					
						
							<div class="row">
							    
						     	<?PHP include_once("product_category_combo_item.php"); ?>
						     	<div  class="col-lg-4 col-md-4 col-sm-12"  id="div_list_product_type">
						     	 <select data-placeholder="Select Product Type" id="" class="form-control form-control-select2" data-fouc>
                                            <option value="select">SELECT PRODUCT TYPE</option>
                                  </select>
     	                                <span class="form-text text-muted"><font color="black">PRODUCT TYPE&nbsp;<span style="color:red;">*</span></font></span>
						     	       
						        </div>
								<div class="col-lg-4 col-md-4 col-sm-12">
                					
                					     
                					   	<input type="text" class="form-control" id="txt_product_item_name" placeholder="Product Item Name">
    									<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT ITEM NAME</font></span>
    								 
                				
                					<input type="hidden" id="txt_product_item_id"/>
							    </div>
						
						</div>
						
						
						
					</div>
				
						</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" id="btn_product_item_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    															
							</div>
						</div>
					</div>
				</div>
				<!-- /ADD PRODUCT ITem -->
				
				
				 <!--  ADD PRODUCT Master -->
				<div id="add_new_master_req" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg ">
						<div class="modal-content">
							<div class="modal-header bg-primary ">
								<h5 class="modal-title">Add Product Brand</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							   	<div class="card-body">
					
					
						
							<div class="row">
							    
						     	<?PHP include_once("product_category_combo_master.php"); ?>
						     	<div  class="col-lg-4 col-md-6 col-sm-12"  id="div_list_product_type_req">
						     	        <select data-placeholder="Select Product Type" id="" class="form-control form-control-select2" data-fouc>
                                            <option value="select">SELECT PRODUCT TYPE</option>
                                        </select>
     	                                <span class="form-text text-muted"><font color="black">PRODUCT TYPE&nbsp;<span style="color:red;">*</span></font></span>
						        </div>
								<div  class="col-lg-4 col-md-6 col-sm-12"  id="div_list_product_item_req">
						     	
						     	       <select data-placeholder="Select Product Item" id="" class="form-control form-control-select2" data-fouc>
                                         <option value="select">SELECT PRODUCT ITEM</option>
                                        
                                      </select>
     	                                <span class="form-text text-muted"><font color="black">PRODUCT ITEM&nbsp;<span style="color:red;">*</span></font></span>
						        </div>
						
						</div>
						
						<div class="row">
							    
						     <div class="col-lg-4 col-md-4 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_product_unit_rate_req" placeholder="Product Unit Rate">
    									<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT UNIT RATE&nbsp;<span style="color:red;">*</span></font></span>
    								 
                					</div>
                				
							    </div>
							    <div class="col-lg-4 col-md-4 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_product_unit_req" placeholder="Product Unit">
    									<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT UNIT&nbsp;<span style="color:red;">*</span></font></span>
    								 
                					</div>
                				
							    </div>
							    <div class="col-lg-4 col-md-4 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_product_brand_name" placeholder="Product Brand Name">
    									<span class="form-text text-muted" style="color:black;"><font color="black">PRODUCT BRAND NAME&nbsp;<span style="color:red;">*</span></font></span>
    								 
                					</div>
                					<input type="hidden" id="txt_product_master_id"/>
							    </div>
						     	
						
						</div>
						
						
						
						
					</div>
				
						</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								<button type="button" id="btn_product_master_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    																		
							</div>
						</div>
					</div>
				</div>
				<!-- /ADD PRODUCT Master -->
			
		