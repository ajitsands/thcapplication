<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
}
</style>
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

	<div class="card classCustomerModify">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Customer
						    </h5>
						
					</div>

					<div class="card-body">
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
									   
									     <div class="col-lg-6 col-md-6 col-sm-12">
									         <span class="form-text text-muted font-weight-bold"><font color="black">Name &nbsp;<span style="color:red;">*</span></font></span>
    										 <input type="text" class="form-control " id="txt_customer_name" placeholder="Customer Name">
    									     	 
											   
    									</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control" id="txt_customer_contact_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  placeholder="Contact Number">
    									
    											
    								
    									</div>
										 <input type="hidden" class="form-control" id="txt_customer_id">
										 <div class="col-lg-6 col-md-6 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email ID</font></span>
    										<input type="text" class="form-control" id="txt_customer_email_id" placeholder="Email ID">
    										
    											
    								
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12" >
										     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Alternate Contact Number</font></span>
    										<input type="text"  class="form-control" id="txt_alternate_contact_no" placeholder="Alternate Contact Number" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
    									
    									</div>
										<!--<div class="col-lg-6 col-md-6 col-sm-12" >
										     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Location &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control" id="txt_customer_location" placeholder="Customer Location"  >
    									
    									</div>
    										 
    									<div class="col-lg-6 col-md-6 col-sm-12" >
    									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">PO Box &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_customer_po_box" placeholder="PO Box" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false" >
    									
    									</div>-->
    									 <div class="col-lg-6 col-md-6 col-sm-12" >
    									     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">CPR/CR Number</font></span>
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
    										<input type="text" class="form-control" id="txt_contact_person_number"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"  placeholder="Contact Number" >
    										
    										
    								
    									</div>			
										<div class="col-lg-6 col-md-6 col-sm-12">
										    <span class="form-text text-muted font-weight-bold"><font color="black">Address &nbsp;</font></span>    
    										<textarea rows="1" class="form-control" id="txt_customer_address" placeholder="Address"></textarea>
    											
    									</div>
								   
                                     <div class="col-lg-6 col-md-6 col-sm-12">
									        	<span class="form-text text-muted font-weight-bold"><font color="black">Any Other Details &nbsp;</font></span>    
    										<textarea rows="1" class="form-control" id="txt_description" placeholder="Any Other Details"></textarea>
    										
    									</div>
								
								</div>
								
							
								
							</div>
						</div>
					
						
					</div>
					
					<div class="card-footer">
								<div class="row">
									
									
										<div class="col-lg-6 col-md-6 col-sm-12" style="padding-top:10px;color:red;">
    									    
    									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_customer_add" class="btn btn-success" ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_customer_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_customer_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Customers</h5>
						<div class="header-elements">
						    
						    <button type="button" id="btn_customer_list_excel" class="btn bg-primary legitRipple exportToExcelAction classCustomersExportExcel" tabindex="6" fdprocessedid="zkd5x">EXCEL</button>	
						    
	                	</div>
						
					</div>

				

					<table class="table datatable-selection-single" id="list_of_customer">
						<thead>
							<tr>
							     <th></th>
							    <th>Sl. No.</th>
				                <th>Cust. Name</th>
								<th>Cust. Code</th>				                
				                <th>Contact No.</th>
				                <th>CPR/CR No.</th>
				                <th>Email</th>
				                <th>Status</th>
				                <th>Action</th>
				                <th style="display:none">Alternative Contact No.</th>
				                <th style="display:none">VAT No.</th>
				                <th style="display:none">Conatct Point</th>
				                <th style="display:none">Address</th>
				                <th style="display:none">Other Details</th>
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
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                               
                                
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection -->
			
				