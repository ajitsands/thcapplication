<!-- Highlighting rows and columns -->
			<div class="card" style="overflow:auto;">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">List of LPO</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" id="lpo_list_reload" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
						
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
							
								<div class="form-group row">
				
									<div class="col-lg-3 col-md-6 col-sm-12">
											<input class="form-control" type="date" id="lpo_start_date" tabindex=1>
											<span class="form-text text-muted"><font color="black"> START DATE&nbsp;<span style="color:red;">*</span></font></span>
											
									</div>
									
									
									<div class="col-lg-3 col-md-6 col-sm-12">
											<input class="form-control" type="date" id="lpo_end_date" tabindex=2>
											<span class="form-text text-muted"><font color="black">END DATE&nbsp;<span style="color:red;">*</span></font></span>
											
									</div>
									
									<?PHP include("lpo_vendor_combo.php"); ?>
									
									<div class="col-lg-2 col-md-6 col-sm-12">
										<button type="button" id="btn_lpo_list_search" class="btn btn-primary" tabindex=4><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; SEARCH</button>
										
									</div>
								
								</div>
			
							</div>
						</div>
					</div>
				
				<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_lpo_list" style="padding-right:5px;padding-left:5px;">
						<thead>
							<tr>
							    <th >SI</th>
								<th>LPO Ref.No</th>
							    <th>Vendor</th>
								<th>Date</th>
								
								
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
			
			      
				</div>
				<!-- /highlighting rows and columns -->
	<div id="modal_lpo_renew"  class="modal fade" data-backdrop="false" tabindex="-1" >
	<div class="modal-dialog modal-lg" >
		<div class="modal-content" width="80%">
			<div class="modal-header">
				
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

<div class="modal-body">


	<div class="card">
	        <div class="card-header header-elements-inline">
						<h4 class="card-title">Local Purchase Order</h4>
					<div class="header-elements">			
							<button type="button" id="btn_reload_lpo_list" class="btn bg-blue-400 legitRipple ladda-button" data-popup="tooltip" title="" data-placement="bottom" data-original-title="Clear All" data-style="expand-right"><span class="ladda-label"><b><i class="icon-reset"></i></b></span><span class="ladda-spinner"></span><div class="legitRipple-ripple" style="left: 58%; top: 68.4211%; transform: translate3d(-50%, -50%, 0px); width: 251.205%; opacity: 0;"></div></button>
			
			            </div>
            </div>
					<div class="card-body">
					
					
						
							<div class="row">
							    
							<div class="col-lg-4 col-md-6 col-sm-12">
							</div>
							
								<div class="col-lg-4 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_lpo_ref_no" placeholder="Reference No " readonly="readonly">
    									<span class="form-text text-muted" style="color:black;"><font color="black">REFERENCE NO</font></span>
    								 
                					</div>
                					
							    </div>

								<div class="col-lg-4 col-md-6 col-sm-12">
                					<div class="card-body" >

        								    <input class="form-control" type="date" name="txt_lpo_date" id="txt_lpo_date">
        									<span class="form-text text-muted"><font color="black">DATE</font></span>
    								 
                					</div>
                				
							    </div>
	
						</div>
						<div class="row">
							   <?PHP include_once("lpo_second_vendor_combo.php"); ?>
								<div class="col-lg-4 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_vat_no" placeholder="Vat No " readonly="readonly">
    									<span class="form-text text-muted" style="color:black;"><font color="black">VAT NO</font></span>
    								 
                					</div>
                					
							    </div>
								  <div class="col-lg-4 col-md-6 col-sm-12">
                				        
                				             <div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_fax_no" placeholder="Fax No" readonly="readonly">
    									<span class="form-text text-muted" style="color:black;"><font color="black">FAX NO</font></span>
    								 
                					</div>   
							    </div>
						     	

						</div>
						<div class="row">
							    
						     	<div class="col-lg-4 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_lpo_po_box" placeholder="P.O Box " readonly="readonly">
    									<span class="form-text text-muted" style="color:black;"><font color="black">P.O BOX</font></span>
    								 
                					</div>
                					
							    </div>

								<div class="col-lg-4 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_tel_no" placeholder="Tel  No" readonly="readonly">
    									<span class="form-text text-muted" style="color:black;"><font color="black">TEL NO</font></span>
    								 
                					</div>
                					
							    </div>
								<div class="col-lg-4 col-md-6 col-sm-12">
								    	<div class="card-body" >

        								    <input class="form-control" type="text" name="lpo_qtn_ref_no" id="lpo_qtn_ref_no" placeholder="Qtn Reference No">
        									<span class="form-text text-muted"><font color="black">QTN REFERENCE NO</font></span>
    								 
                					</div>
                					
                					
							    </div>
						</div>
						<div class="row">
							    
						     	<div class="col-lg-12 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_subject" placeholder="Subject">
    									<span class="form-text text-muted" style="color:black;"><font color="black">SUBJECT</font></span>
										<input type="hidden" class="form-control " id="txt_prepared_by_id" value="<?PHP echo $_SESSION['user_id'];?>">
											<input type="hidden" class="form-control " id="txt_prepared_by_name" value="<?PHP echo $_SESSION['username'];?>">
    								 
                					</div>
                					
							    </div>
						</div>
						
					</div>
				
				</div>
				<div class="card">
								<div class="col-md-12 card-box pd-20 mb-30">
								<div class="row">
								
										<div class="col-md-12 col-sm-12">
											<div class="card-body" >	
							<input type="text" class="form-control" id="txt_descri_name" name="txt_descri_name" placeholder="Description">
									<span class="form-text text-muted" style="color:black;"><font color="black">DESCRIPTION</font></span>
											</div>
										</div>
								</div>
								<div class="row">
										<div class="col-md-2 col-sm-12">
											<div class="card-body" >	
							<input type="text" class="form-control" id="txt_quantity" name="txt_quantity" placeholder="0.000">
									<span class="form-text text-muted" style="color:black;"><font color="black">QUANTITY</font></span>
											</div>
										</div>
										
										<div class="col-md-2 col-sm-12">
									<div class="card-body" >	
							        <input type="text" class="form-control" id="txt_unit" name="txt_unit" placeholder="Unit">
									<span class="form-text text-muted" style="color:black;"><font color="black">UNIT</font></span>
											</div>
										</div>
										
									<div class="col-md-2 col-sm-12">
									<div class="card-body" >	
							        <input type="text" class="form-control" id="txt_unit_price" name="txt_unit_price" placeholder="0.000">
									<span class="form-text text-muted" style="color:black;"><font color="black">UNIT PRICE</font></span>
											</div>
										</div>
										
									<div class="col-md-2 col-sm-12">
									<div class="card-body" >	
							        <input type="text" class="form-control" id="txt_discount" name="txt_discount" placeholder="0.000">
									<span class="form-text text-muted" style="color:black;"><font color="black">DISCOUNT (%) </font></span>
										</div>
										</div>

										<div class="col-md-2 col-sm-12">
									<div class="card-body" >	
							        <input type="text" class="form-control" id="txt_tax" name="txt_tax" placeholder="0.000">
									<span class="form-text text-muted" style="color:black;"><font color="black">TAX (%) </font></span>
										</div>
										</div>
										<div class="col-md-2 col-sm-12">
									<div class="card-body" >	
							        <input type="text" class="form-control" id="txt_grand_total" name="txt_grand_total" placeholder="0" readonly="readonly" >
									<span class="form-text text-muted" style="color:black;"><font color="black">GRAND TOTAL</font></span>
										</div>
										</div>
										</div>
								<div class="form-group row">
										<div class="col-md-10 col-sm-12">
										</div>
										
										
										
										<div class="col-md-2 col-sm-12">
											<label>
											</label>
											<div class="control-group">
											<div class="controls">
										
				 <button type="button" id="btn_lpo_add" class="btn btn-warning"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; ADD</button>
				 <button type="button" id="btn_lpo_master_edit" class="btn btn-warning"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; UPDATE</button>
											</div>
											</div>
										</div>
										
										
										
									</div>
									
									
								</div>
								
							</div>
							
							</div>
		    
		  
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of LPO</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>
				<div id="localpo_ref_no"></div>
				

					<table class="table datatable-selection-single" id="tbl_list_second_child_data">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Description</th>
								<th>Quantity</th>
				                <th>Unit</th>
				                <th>Unit Price</th>
				                <th>Total</th>
				               
				                <!--<th>Discount Amt</th>-->
								<th>Tax(%)</th>
								<th>Dis(%)</th>
								<th>Grand Total</th>
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
                                <!--<th></th>-->
                            </tr>
                        </tfoot>
					</table>
					
					<!-- text editor starts here -->
						<div class="card-body">
						
							<div class="mb-3">
							<span class="form-text text-muted"><font color="black">TERMS AND CONDITIONS</font></span>    
							<textarea name="editor-full" id="txt_terms_and_condition" rows="1" cols="1">Test Description
															
							  </textarea>
							  </div>

						</div>
						
					<div class="card-footer">
						<div class="row">
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								<button type="button" id="btn_lpo_print" class="btn btn-dark"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; PRINT</button>
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								<button type="button" id="btn_lpo_update" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; UPDATE LPO</button>	
							</div>

						</div>
					</div>
					
					<!--text editor ends here   -->
				</div> 
				<!--single row selection -->
			</div>
			
						
		        </div>
		    </div>
		
