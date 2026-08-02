
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
						    
							<div class="col-md-6 col-lg-6 border-right border-color" >
							   
									   <div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Customer Name&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										    <?PHP include("customer_combo.php"); ?>
										</div>
									   </div>
    								    <div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">PO Box&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										     <input type="text" class="form-control " id="txt_customer_po_box" placeholder="Customer PO Box" tabindex=2>
    											<span class="form-text text-muted"></span>
										</div>
									   </div>	
    									<div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Address</font></label>
										<div class="col-lg-9">
										     <textarea cols="1" class="form-control " id="txt_customer_address" placeholder="Customer Address" tabindex=3></textarea>
        											<span class="form-text text-muted"></span>
										</div>
									   </div>
									   <div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Contact Number&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										    <input type="text" class="form-control " id="txt_customer_contact_no" placeholder="Customer Contact Number" tabindex=4>
        											<span class="form-text text-muted"></span>
										</div>
									   </div>
    									
    								   
								
								
							
							</div>
							
							<div class="col-md-6 col-lg-6">
    							   
    							       
    							       
									   
									   <div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Quotation Number&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										    <input type="text" class="form-control " id="txt_quotation_number" placeholder="Quotation Number" disabled  tabindex=5>
										    <input type="hidden" class="form-control " id="txt_ref_no_edit" value="<?PHP echo $reference_no;?>">
    											<span class="form-text text-muted"></span> 
										</div>
									   </div>
									   
    								     <div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Attention&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										    <input type="text" class="form-control " id="txt_attension" placeholder="Attention" tabindex=6>
    											<span class="form-text text-muted"></span> 
										</div>
									   </div>
    									<div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Date&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										    <input class="form-control" type="date" id="quotation_date" tabindex=7>
    											<span class="form-text text-muted"></span>
    											<input type="hidden" class="form-control " id="txt_created_by_id" value="<?PHP echo $_SESSION['user_id'];?>">
    											<input type="hidden" class="form-control " id="txt_created_by_name" value="<?PHP echo $_SESSION['username'];?>">
										</div>
									   </div>
                                        <div class="form-group row">
										<label class="col-lg-3 col-form-label"><font color="black">Vat Content %&nbsp;<span style="color:red;">*</span></font></label>
										<div class="col-lg-9">
										   <select data-placeholder="Select Vat Content" id="select_vat_content" class="form-control form-control-select2" data-fouc tabindex=8>
                                             <option value="5">5</option>
                                              <option value="0">0</option>
                                          
                                          </select>
                                         	<span class="form-text text-muted"></span>
										</div>
									   </div>
    								
							
						</div>
						</div>
						<div class="form-group row">
										<label class="col-lg-1 col-form-label">Subject</label>
										<div class="col-lg-11">
										   	<textarea cols="1" class="form-control" id="txt_quotation_subject" placeholder="Subject" tabindex=9></textarea>
    											<span class="form-text text-muted"><font color="black">Subject</font></span> 
										</div>
						</div>
						
				</div>

				
	</div>


		
		<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Items</h5>
						<div class="header-elements">
							
	                	</div>
					</div>	

		
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">

									<div class="col-lg-12 col-md-6 col-sm-12">
										<input type="hidden" class="form-control " id="txt_quotation_child_id">
										<input type="hidden" class="form-control " id="txt_quotation_master_id">
										<input type="hidden" class="form-control " id="txt_quotation_ref_no">
										<textarea cols="1" class="form-control" id="txt_quotation_description" placeholder="Description" tabindex=10></textarea>
    											<span class="form-text text-muted"><font color="black">Description</font></span>    
    									
									</div>
										
								</div>
								
								<div class="form-group row">
                                
									<div class="col-lg-3 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_quantity" placeholder="0" tabindex=11>
											<span class="form-text text-muted"><font color="black">Quantity&nbsp;<span style="color:red;">*</span></font></span>    
									</div>

									<div class="col-lg-3 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_unit" placeholder="Unit" tabindex=12>
											<span class="form-text text-muted"><font color="black">Unit&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
									
									<div class="col-lg-3 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_rate" placeholder="0.000" tabindex=13>
											<span class="form-text text-muted"><font color="black">Unit Price (BD)&nbsp;<span style="color:red;">*</span></font></span>    
									</div>
									
									<!--<div class="col-lg-2 col-md-6 col-sm-12">-->
									<!--	 <input type="text" class="form-control " id="txt_discount" placeholder="0.000">-->
									<!--		<span class="form-text text-muted"><font color="black">DISCOUNT(%)</font></span>    -->
									<!--</div>-->
									
									<!--<div class="col-lg-2 col-md-6 col-sm-12">-->
									<!--	 <input type="text" class="form-control " id="txt_tax" placeholder="0.000">-->
									<!--		<span class="form-text text-muted"><font color="black">TAX(%)&nbsp;<span style="color:red;">*</span></font></span>    -->
									<!--</div>-->
									
									<div class="col-lg-3 col-md-6 col-sm-12">
										 <input type="text" class="form-control " id="txt_grand_total" placeholder="0.000" tabindex=14>
											<span class="form-text text-muted"><font color="black"> Total Price</font></span>    
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
									
										<button type="button" id="btn_quotation_add" class="btn btn-primary"><b><i class="icon-floppy-disk" tabindex=15></i></b>&nbsp;&nbsp;&nbsp; ADD</button>
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
						
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_quotation">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Description</th>
								<th>Quantity</th>
				                <th>Unit</th>
				                <th>Unit Price</th>
				                <th>Amount</th>
				    <!--            <th>Dis(%)</th>-->
				                <!--<th>Discount Amt</th>-->
								<!--<th>Tax(%)</th>-->
								<!--<th>Net Total</th>-->
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
                                <!--<th></th>-->
                                <!--<th></th>-->
                                <!--<th></th>-->
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
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_quotation_edit">
						<thead>
							<tr>
							    
							    <th>Sl No</th>
							    <th>Description</th>
								<th>Qty</th>
				                <th>Unit</th>
				                <th>Unit Price</th>
				                <th>Amount</th>
				    <!--            <th>Dis(%)</th>-->
				                
								<!--<th>Tax(%)</th>-->
								<!--<th>Net Total</th>-->
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
                                <!--<th></th>-->
                                <!--<th></th>-->
                                <!--<th></th>-->
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
		         <div class="card-header header-elements-inline">
						<h5 class="card-title">Terms and Conditions</h5>
						
					</div>
		               <div class="card-body">
						
							<div class="mb-3">
						   
							<textarea name="editor-full" id="txt_terms_and_condition" rows="1" cols="1"><p class="MsoPlainText" style="margin-top:8px"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><b><u><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;">Terms and Condition:</span></span></span></u></b></span></span></span></span></p>

<ol>
	<li class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;"><span style="color:black">Payment in Advance (Cash/Cheque)</span></span></span></span></span></span></span></span></li>
	<li class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;"><span style="color:black">Validity for the quotation 15 Days.</span></span></span></span></span></span></span></span></li>
	<li class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;"><span style="color:black">Prices are valid for the above item/quantity. If there is any change in item/quantity, we reserve the right to revise prices.</span></span></span></span></span></span></span></span></li>
	<li class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;"><span style="color:black">Work Completion: Within 1-2 days from the date of confirmed order.</span></span></span></span></span></span></span></span></li>
	<li class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;"><span style="color:black">All Permits and clearances to be provided by client.</span></span></span></span></span></span></span></span></li>
	<li class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><span style="font-size:11.0pt"><span style="line-height:115%"><span style="font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;"><span style="color:black">No warranty offered for the above parts</span></span></span></span></span></span></span></span></li>
</ol>

<p class="MsoPlainText"><span style="font-size:12pt"><span style="line-height:115%"><span style="font-family:&quot;Times New Roman&quot;,serif"><span style="color:#4a442a"><v:rect fillcolor="#d8d8d8 [2732]" id="Rectangle_x0020_4" o:gfxdata="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
AAUABQBnAQAAtg0AAAAA
" style="position:absolute; margin-left:402px; margin-top:725px; width:190.05pt; height:82.8pt; z-index:-251645952; v-text-anchor:top"> <v:textbox> </v:textbox></v:rect></span></span></span></span></p>



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
			