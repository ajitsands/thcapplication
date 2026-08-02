

	<div class="card">
	    <div class="card-header header-elements-inline">
				<h4 class="card-title">Local Purchase Order</h4>
					<div class="header-elements">			
							<button type="button" id="btn_reload_lpo" class="btn bg-blue-400 legitRipple ladda-button" data-popup="tooltip" title="" data-placement="bottom" data-original-title="Clear All" data-style="expand-right"><span class="ladda-label"><b><i class="icon-reset"></i></b></span><span class="ladda-spinner"></span><div class="legitRipple-ripple" style="left: 58%; top: 68.4211%; transform: translate3d(-50%, -50%, 0px); width: 251.205%; opacity: 0;"></div></button>
			
			            </div>
			</div>
				
					<div class="row">
                   
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

        								    <input class="form-control" type="date" name="date" id="lpo_date" tabindex=1>
        									<span class="form-text text-muted"><font color="black">DATE</font>&nbsp;<span style="color:red;">*</span>
    								 
                					</div>
                					
							    </div>
	
						</div>
						<div class="row">
							   <?PHP include_once("vendor_name_combo.php"); ?>
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

        								    <input class="form-control" type="text" name="lpo_qtn_ref_no" id="lpo_qtn_ref_no" placeholder="Qtn Reference No" tabindex=3>
        									<span class="form-text text-muted"><font color="black">QTN REFERENCE NO</font>&nbsp;<span style="color:red;">*</span>
    								 
                					</div>
                					
                					
							    </div>
						</div>
						<div class="row">
							    
						     	<div class="col-lg-12 col-md-6 col-sm-12">
                					<div class="card-body" >
                					     
                					   	<input type="text" class="form-control" id="txt_subject" placeholder="Subject" tabindex=4>
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
								<div class="card-body" >
								   <div class="row">
								
										<div class="col-md-12 col-sm-12">
											
							<input type="text" class="form-control" id="txt_descri_name" name="txt_descri_name" placeholder="Description" tabindex=5>
									<span class="form-text text-muted" style="color:black;"><font color="black">DESCRIPTION</font>&nbsp;<span style="color:red;">*</span>
											</div>
										
								</div>
								<div class="row">
										<div class="col-md-2 col-sm-12">
											
							<input type="text" class="form-control" id="txt_quantity" name="txt_quantity" placeholder="0.000" tabindex=6>
									<span class="form-text text-muted" style="color:black;"><font color="black">QUANTITY</font>&nbsp;<span style="color:red;">*</span>
										
										</div>
										
										<div class="col-md-2 col-sm-12">
									
							        <input type="text" class="form-control" id="txt_unit" name="txt_unit" placeholder="Unit" tabindex=7>
									<span class="form-text text-muted" style="color:black;"><font color="black">UNIT</font>&nbsp;<span style="color:red;">*</span>
										
										</div>
										
									<div class="col-md-2 col-sm-12">
									
							        <input type="text" class="form-control" id="txt_unit_price" name="txt_unit_price" placeholder="0.000" tabindex=8>
									<span class="form-text text-muted" style="color:black;"><font color="black">UNIT PRICE</font>&nbsp;<span style="color:red;">*</span>
										
										</div>
										
									<div class="col-md-2 col-sm-12">
									
							        <input type="text" class="form-control" id="txt_discount" name="txt_discount" placeholder="0.000" tabindex=9>
									<span class="form-text text-muted" style="color:black;"><font color="black">DISCOUNT (%) </font></span>
										
										</div>

										<div class="col-md-2 col-sm-12">
									
							        <input type="text" class="form-control" id="txt_tax" name="txt_tax" placeholder="0.000" tabindex=10>
									<span class="form-text text-muted" style="color:black;"><font color="black">TAX (%) </font>&nbsp;<span style="color:red;">*</span>
										
										</div>
										<div class="col-md-2 col-sm-12">
									
							        <input type="text" class="form-control" id="txt_grand_total" name="txt_grand_total" placeholder="0" readonly="readonly">
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
										
				 <button type="button"  class="btn btn-success" id="add_des" style="height:40px; width:65px;" tabindex=11>Add</button>
				 <button type="button" id="btn_lpo_edit" class="btn btn-warning"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; UPDATE</button>
											</div>
											</div>
										</div>
										
										
										
									</div>
									
									<div id="unit_id">
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
				

					<table class="table datatable-selection-single" id="list_data">
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
								<button type="button" id="btn_lpo_generates" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; GENERATE LPO</button>	
							</div>

						</div>
					</div>
					
					<!--text editor ends here   -->
				</div> 
				<!--single row selection -->
				