
			
		
				
	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">REQUISITION LISTS</h5>
						<div class="header-elements">
						
	                	</div>
				</div>

				<div class="card-body">
				    
						<div class="row" >
						    
						
        						<div id="div_amc_ref_no" class="col-lg-3 col-md-3 col-sm-12" >
        							<input type="date" class="form-control " id="txt_start_date" placeholder="Start Date" tabindex=1>
        							<span class="form-text text-muted" style='font-size: 12px;' ><font color="black">Start Date</font></span> 
        						</div>
        						<div id="div_tkts_ref_no" class="col-lg-3 col-md-3 col-sm-12">
        							<input type="date" class="form-control " id="txt_end_date" placeholder="End Date"  tabindex=2>
        							<span class="form-text text-muted" style='font-size: 12px;'><font color="black">End Date</font></span> 
        						</div>
        						
        						<div  class="col-lg-4 col-md-3 col-sm-12">
        						
        						<?PHP include_once("requisition/select_customer_requisition_combo.php"); ?>
        	                	</div>
        						<div class="col-lg-2 col-md-3 col-sm-12">
        							<button type="button" id="btn_customer_search" class="btn btn-primary" style="height:40px; width:100px;"  tabindex=4><i class="fa fa-search"></i>SEARCH</button>
        							<span class="form-text text-muted" style='font-size: 16px;'><font color="black"></font></span> 
        						</div>
						
					   </div>
				</div> 
				
					<input type="hidden" class="form-control" id="txt__hidden_amc_ref_no">
					<input type="hidden" class="form-control" id="txt_requisition_serial_no">
					
					 <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details"></span><span class="badge bg-teal" id="span_location_details"></span><span class="badge bg-teal" id="span_building_details"></span></h5>
						<!-- Single row selection -->
			
				
					
        					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_requisition_list">
        						<thead>
        							<tr>
        							    
        							 
        				                <th>SI NO</th>
        								<th>Requisition Serial No</th>
        								<th>AMC Ref.No/Ticket Ref.no</th>
        								<th>Customer Name</th>
        								<th>Date</th>
        							
        				            </tr>
        						</thead>
        						<tbody>
        							
        				               
        						</tbody>
        					
        					</table>
					
					
					
					</div>	
					
			
				

		<!-- /list requisition details ends -->
		
		<div id="modal_requisition_view" class="modal fade" data-backdrop="false" tabindex="-1">
			<div class="modal-dialog modal-xl" >
						<div class="modal-content">
							<div class="modal-header bg-success">
								<h5 class="modal-title">REQUISITION LIST</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

                    				<div class="modal-body">
                                    	<div class="form-group row">
                                            <div class="col-lg-2">
                                            
        									<label class="col-form-label float-right " ><b>Requsition No  :</b></label>
        									
    										</div>
    										<div class="col-lg-1">
    										    	<label class="col-form-label  " ><span  id="requsition_no" ></span></label>
    										</div>
    										 <div class="col-lg-2">
    										  <label class="col-form-label float-right" ><b>AMC/TKT Ref No  :</b></label>
    									
    									   	</div>
    									   	<div class="col-lg-1">
    										  <label class="col-form-label " ><span  id="amc_tkt_ref_no" ></span></label>
    										  
    									   	</div>
    									   	 <div class="col-lg-2">
    										  <label class="col-form-label float-right" ><b>Date  :</b></label>
    									
    									   	</div>
    									   	<div class="col-lg-1">
    										  <label class="col-form-label " ><span  id="req_date" ></span></label>
    										  
    									   	</div>
    									   	<div class="col-lg-2">
    										  <label class="col-form-label float-right" ><b>Customer Name  :</b></label>
    									
    									   	</div>
    									   	<div class="col-lg-1">
    										  <label class="col-form-label " ><span  id="customer_name" ></span></label>
    										  
    									   	</div>
    									   	
									</div>
					            
							       
							       <div class="card-body" id="tbl_view_requsition_child">
                    					
                    					 <h5 class="card-title"> <span class="badge bg-teal" id="span_customer_details_edit"></span><span class="badge bg-teal" id="span_location_details"></span><span class="badge bg-teal" id="span_building_details"></span></h5>
                    						<!-- Single row selection -->
                                				<div style="overflow:auto;">
                                					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_requsition_child">
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
                                							
                                				            </tr>
                                						</thead>
                                						<tbody>
                                							
                                				               
                                						</tbody>
                                					
                                					</table>
                                					
                                				</div>
                    				<!-- /single row selection -->
                    	
                    					</div>
                                    	
					            
							       </div>
							       <div class="modal-footer">
                							   
                            							 <div class="col-lg-4 col-md-6 col-sm-12">
                                    					<button type="button" id="btn_print_requisition" class="btn btn-warning" ><b><i class="icon-printer2"></i></b>&nbsp;&nbsp;&nbsp;PRINT</button>
                                    						
                                    					</div>
                        					   
        				    	</div>
						</div>
				</div>
			</div>	
