
<style>
    input[type='file'] {
  width: 95px;
 }
</style>
<?PHP 
	$reference_no=$_GET['RefNo'];
	//echo $reference_no;

?>
	<div class="card">
	    
	        <div class="card-header header-elements-inline">
						<h4 class="card-title">Quotations</h4>
						<div class="header-elements">			
							<button type="button" id="btn_reload_qtn" class="btn bg-blue-400 legitRipple ladda-button" data-popup="tooltip" title="" data-placement="bottom" data-original-title="Clear All" data-style="expand-right"><span class="ladda-label"><b><i class="icon-reset"></i></b></span><span class="ladda-spinner"></span><div class="legitRipple-ripple" style="left: 58%; top: 68.4211%; transform: translate3d(-50%, -50%, 0px); width: 251.205%; opacity: 0;"></div></button>
			
			            </div>	
		    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
							
								<div class="form-group row">
				
									<div class="col-lg-4 col-md-6 col-sm-12">
									</div>
									
									<div class="col-lg-4 col-md-6 col-sm-12">
									</div>
									
									<div class="col-lg-4 col-md-6 col-sm-12">
										<input type="hidden" class="form-control " id="txt_ref_no_edit" value="<?PHP echo $reference_no;?>">
										 <input type="text" class="form-control " id="txt_quotation_number" placeholder="Quotation Number" disabled>
											<span class="form-text text-muted"><font color="black">QUOTATION NUMBER</font></span>    
							
									</div>
								
								</div>
								<div class="form-group row">
									
									<?PHP include("customer_combo.php"); ?>
									
									<div class="col-lg-4 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_customer_po_box" placeholder="Customer PO Box">
											<span class="form-text text-muted"><font color="black">PO BOX&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
								
									<div class="col-lg-4 col-md-6 col-sm-12">
									
										 <textarea cols="1" class="form-control text-uppercase" id="txt_customer_address" placeholder="Customer Address"></textarea>
    											<span class="form-text text-muted"><font color="black">ADDRESS</font></span>    
    									</div>
									
								
								
								</div>
								
								<div class="form-group row">
								
									<div class="col-lg-4 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_customer_contact_no" placeholder="Customer Contact Number">
											<span class="form-text text-muted"><font color="black">CONTACT NUMBER&nbsp;<span style="color:red;">*</span></font></span>    
									</div>

									<div class="col-lg-4 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_attension" placeholder="Attension">
											<span class="form-text text-muted"><font color="black">ATTENSION&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
								
									<div class="col-lg-4 col-md-6 col-sm-12">
											<input class="form-control" type="date" id="quotation_date">
											<span class="form-text text-muted"><font color="black">DATE&nbsp;<span style="color:red;">*</span></font></span>
											<input type="hidden" class="form-control " id="txt_created_by_id" value="<?PHP echo $_SESSION['user_id'];?>">
											<input type="hidden" class="form-control " id="txt_created_by_name" value="<?PHP echo $_SESSION['username'];?>">
									
									</div>
									
									

										
								</div>

								<div class="form-group row">

									<div class="col-lg-12 col-md-6 col-sm-12">
										
										<textarea cols="1" class="form-control" id="txt_quotation_subject" placeholder="Subject"></textarea>
    											<span class="form-text text-muted"><font color="black">SUBJECT</font></span>    
    									
									</div>
	
								</div>
							</div>
						</div>
					</div>
		</div>


		
		<div class="card">
					<?PHP
					
						include('template/card_head_control.inc');
					
					?>

		
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">

									<div class="col-lg-12 col-md-6 col-sm-12">
										<input type="hidden" class="form-control " id="txt_quotation_child_id">
										<input type="hidden" class="form-control " id="txt_quotation_master_id">
										<input type="hidden" class="form-control " id="txt_quotation_ref_no">
										<textarea cols="1" class="form-control" id="txt_quotation_description" placeholder="Description"></textarea>
    											<span class="form-text text-muted"><font color="black">DESCRIPTION</font></span>    
    									
									</div>
										
								</div>
								
								<div class="form-group row">

									<div class="col-lg-2 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_quantity" placeholder="0">
											<span class="form-text text-muted"><font color="black">QUANTITY&nbsp;<span style="color:red;">*</span></font></span>    
									</div>

									<div class="col-lg-2 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_unit" placeholder="Unit">
											<span class="form-text text-muted"><font color="black">UNIT&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
									
									<div class="col-lg-2 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_rate" placeholder="0.000">
											<span class="form-text text-muted"><font color="black">RATE (BD)&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
									
									<div class="col-lg-2 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_discount" placeholder="0.000">
											<span class="form-text text-muted"><font color="black">DISCOUNT(%)</font></span>    
									</div>
									
									<div class="col-lg-2 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_tax" placeholder="0.000">
											<span class="form-text text-muted"><font color="black">TAX(%)&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
									
									<div class="col-lg-2 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_grand_total" placeholder="0.000">
											<span class="form-text text-muted"><font color="black">GRAND TOTAL</font></span>    
									</div>
					
								</div>
	
								
							</div>
						</div>
					</div>
					
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-10 col-md-6 col-sm-12">
									</div>
									<div class="col-lg-2 col-md-6 col-sm-12">
									
										<button type="button" id="btn_quotation_add" class="btn btn-primary"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; ADD</button>
										<button type="button" id="btn_quotation_edit" class="btn btn-warning"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; UPDATE</button>
									</div>
	
								</div>
					</div>
					
		</div>			
					

				
				
				
		<!-- Single row selection -->
	<div id="quotation_table">
			<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Items</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_quotation">
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
                                <th></th>
                                <!--<th></th>-->
                            </tr>
                        </tfoot>
					</table>
					
					<!-- text editor starts here -->
						
						
					
					
					<!--text editor ends here   -->
				</div> 
				
				</div> 
				<!-- /single row selection -->
				
				
	<div id="quotation_list_table">
			<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Items</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_quotation_edit">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Description</th>
								<th>Qty</th>
				                <th>Unit</th>
				                <th>Rate</th>
				                <th>Amount</th>
				                <th>Dis(%)</th>
				                
								<th>Tax(%)</th>
								<th>Net Total</th>
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
                                <th></th>
                                <!--<th></th>-->
                            </tr>
                        </tfoot>
					</table>
					
					<!-- text editor starts here -->
						
						
			
				</div> 
				
		</div> 
		
		<div class="card">
		    
		    <div class="card-body">
						
							<div class="mb-3">
							<span class="form-text text-muted"><font color="black">TERMS AND CONDITIONS</font></span>    
							<textarea name="editor-full" id="txt_terms_and_condition" rows="1" cols="1">Test Description
							  </textarea>
							  </div>

						</div>
		<div id="card_footer_generate">
			<div class="card-footer">
						<div class="row">
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								<button type="button" id="btn_quotation_print" class="btn btn-dark"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; PRINT</button>
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								<button type="button" id="btn_quotation_generate" class="btn btn-primary"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; GENERATE QUOTATION</button>	
							</div>
							
						</div>
			</div>
		</div>
				
		<div id="car_footer_edit">			
			<div class="card-footer">
						<div class="row">
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								<button type="button" id="btn_quotation_print" class="btn btn-dark"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; PRINT</button>
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								
							</div>
							
							<div class="col-lg-4 col-md-6 col-sm-12">
								<button type="button" id="btn_quotation_list_edit" class="btn btn-warning"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp; EDIT QUOTATION</button>	
							</div>

						</div>
			</div>
		</div>
					
					<!--text editor ends here   -->
		</div>
			