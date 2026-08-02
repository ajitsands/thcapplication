	<!-- Disabled backdrop Change Status -->
				<div id="modal_customer_add" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >Add Customer</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
						            <div class="col-lg-6 col-md-6 col-sm-12">
						                	<span class="form-text text-muted font-weight-bold"><font color="black">Customer Name &nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_customer_name" placeholder="Customer Name" >
    									     
											  <input type="hidden" class="form-control" id="txt_customer_id">
    									</div>  
										
										<div class="col-lg-6 col-md-6 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_customer_contact_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Contact Number">
    									
    											
    								
    									</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email Id</font></span>
    										<input type="text" class="form-control" id="txt_customer_email_id" placeholder="Email Id">
    									
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12" >
										     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Alternate Contact Number</font></span>
    										<input type="text"  class="form-control" id="txt_alternate_contact_no" placeholder="Alternate Contact Number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
    									
    									</div>
										
						        	     <!--<div class="col-lg-6 col-md-6 col-sm-12" >
						        	         <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Customer Location &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control" id="txt_customer_location" placeholder="Customer Location"  >
    									
    											
    								
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12" >
    									    
    											<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">PO Box &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_customer_po_box" placeholder="PO Box" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" >
    										
    								
    									</div>-->
    									 <div class="col-lg-6 col-md-6 col-sm-12" >
    									     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">CPR/CR Number </font></span>
    										<input type="text"  class="form-control" id="txt_cpr_cr_number"  placeholder="CPR/CR Number" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
    									
    											
    								
    									</div>
    									
    										<div class="col-lg-6 col-md-6 col-sm-12" >
    										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">VAT Number &nbsp;</font></span>
    										<input type="text" class="form-control" id="txt_vat_number" placeholder="VAT Number">
    										
    											
    								
    									</div>
    								    <div class="col-lg-6 col-md-6 col-sm-12" >
    								        <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Person Name</font></span>
    										<input type="text" class="form-control" id="txt_contact_person" placeholder="Contact Person Name">
    										
    											
    								
    									</div>
								        <div class="col-lg-6 col-md-6 col-sm-12" >
								            <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Person Number</font></span>
    										<input type="text" class="form-control" id="txt_contact_person_number"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"  placeholder="Contact Person Number" >
    										
    											
    								
    									</div>
							        
							        </div>
							        
						        </div>
						        
							

							<div class="modal-footer">
							    <button type="button" class="btn bg-info" id="btn_customer_add">Add</button>
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
							</div>
					</div>
				</div>
			
				<!-- /disabled backdrop Change Status -->
			