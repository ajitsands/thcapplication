
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

	<div class="card classSubContractorsModify">
					<div class = "card-header" style="font-size:25px;">Subcontractors</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row"> 
										<div class="col-lg-6 col-md-6 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Name &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control " id="txt_subcontractor_name" placeholder="Subcontractor Name" tabindex=1>
    											
    								        <input type="hidden" class="form-control text-uppercase" id="txt_emp_id">
    									</div>
    								
    								<!--	<div class="col-lg-6 col-md-6 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Employee Code&nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_emp_code" placeholder="Employee Code">
    									     	   
    									</div>-->
    								
						               <div class="col-lg-6 col-md-6 col-sm-12">
    										<span class="form-text text-muted font-weight-bold"><font color="black">CR Number&nbsp;<span style="color:red;">*</span></font></span>    
    										 <input type="text" class="form-control " id="txt_subcontractor_cr_no" placeholder="CR Number" tabindex=2>
    									     	
    									</div>
								        <div class="col-lg-6 col-md-6 col-sm-12" >
    									
    											<span class="form-text text-muted font-weight-bold"><font color="black">Address&nbsp;<span style="color:red;">*</span></font></span>  
    										<textarea rows="1" class="form-control " id="txt_subcontractor_address" placeholder="Address" tabindex=3></textarea>
    									</div>
    										<div class="col-lg-6 col-md-6 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Person Name&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_subcontratcor_contact_person_name" placeholder="Contact Person Name" tabindex=4>
    											
    									</div>
    									 <div class="col-lg-6 col-md-6 col-sm-12">
    									     <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number 1&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_contact_no1"    onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" placeholder="Contact Number" tabindex=5>
    											  
    							        </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number 2(Optional)&nbsp;</font></span>
    										<input type="text"  class="form-control " id="txt_contact_no2"    onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" placeholder="Contact Number" tabindex=6>
        										
        									
        								</div>
        								
    								
    								<!--<div class="col-lg-4 col-md-4 col-sm-12">-->
    								<!--     <span class="form-text text-muted font-weight-bold"><font color="black">Driving License&nbsp;<span style="color:red;">*</span></font></span>-->
    								<!--    </div>-->
							<!--	<div class="form-check  col-lg-6 col-md-6 col-sm-12">
										<label class="form-check-label font-weight-bold">
											 
											<input type="checkbox" class="form-check-input" id="chk_driving" name="chk_driving">
											
										</label>
									</div>-->
								</div>
								
								
								
								
							</div>
						</div>

					
						  	<div class="row">
							   
    									
    							    <div class="col-lg-12 col-md-12 col-sm-12">
                    					<!--<div class="card-body" >-->
                    					     <span class="form-text text-muted font-weight-bold"><font color="black">Vendor Registration Form&nbsp;</font></span>	
                    					    <input type="file" class="form-input-styled"  id="session_image" accept="image/*" title="&nbsp;" tabindex=17 data-fouc=""/><p id="vendor_reg_form"></p>
                    					    <div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
                    					   
                    					<!--</div>-->
    							    </div>
						     	  
						     	
						     	   
						    </div>
						
						
						  <br><br>
					<div class="row"></div>
							
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									    </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									
    										<button type="button" id="btn_subcontractor_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_subcontractor_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_employee_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Subcontractors</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_subcontractors">
						<thead>
							<tr>
							    <th></th>
							    <th>Sl. No.</th>
							    <th></th>
				                <th>Name</th>
				                <th>CR No.</th>
				                <th>Address</th>
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
                               
                                
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection -->
				