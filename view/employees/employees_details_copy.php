<style>
    input[type='file'] {
  width: 95px;
 }
.preview-item {
    position: relative;
    margin: 10px;
}
.delete-file {
    position: absolute;
    top: -5px;
    right: -5px;
    background: white;
    border-radius: 50%;
    cursor: pointer;
    font-weight: bold;
    padding: 0 5px;
}
.pdf-preview {
    border: 1px solid #ccc;
    padding: 10px;
    background: #f8f8f8;
    width: 150px;
    text-align: center;
}
</style>

	<div class="card classEmployeesModify">  
					<?PHP
					
						include('template/card_head_control.inc');

					?>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">
										<div class="col-lg-6 col-md-6 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Employee Name &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control " id="txt_emp_name" placeholder="Employee Name" tabindex=1>
    											
    								        <input type="hidden" class="form-control text-uppercase" id="txt_emp_id">
    									</div>
    								
    								<!--	<div class="col-lg-6 col-md-6 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Employee Code&nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_emp_code" placeholder="Employee Code">
    									     	   
    									</div>-->
    								
						               <div class="col-lg-6 col-md-6 col-sm-12">
    										<span class="form-text text-muted font-weight-bold"><font color="black">Employee Password&nbsp;<span style="color:red;">*</span></font></span>    
    										 <input type="text" class="form-control " id="txt_emp_password" placeholder="Employee Password" value="12345" tabindex=2>
    									     	
    									</div>
								        <div class="col-lg-6 col-md-6 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_emp_contact_no"    onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" placeholder="Contact Number" tabindex=3>
    											
    									</div>
    										<div class="col-lg-6 col-md-6 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email Id</font></span>
    										<input type="text" class="form-control" id="txt_emp_email_id" placeholder="Email Id" tabindex=4>
    											
    									</div>
    									 <div class="col-lg-6 col-md-6 col-sm-12">
    									     <span class="form-text text-muted font-weight-bold"><font color="black">Address</font></span>  
    										<textarea rows="1" class="form-control " id="txt_emp_address" placeholder="Address" tabindex=5></textarea>
    											  
    							        </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Date of Join&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_joining_date"  tabindex=6>
        										
        									
        								</div>
        								
    								<div class="col-lg-6 col-md-6 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">CPR Number&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_cpr_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="CPR Number" tabindex=7>
    											
    									</div>
    									 <div class="col-lg-6 col-md-6 col-sm-12">
        										<span class="form-text text-muted font-weight-bold"><font color="black">CPR Expiry Date&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_cpr_expiry_date" tabindex=8>
        										
        									
        								</div>
        									<div class="col-lg-6 col-md-6 col-sm-12">
    										    	<span class="form-text text-muted font-weight-bold"><font color="black">Passport Number&nbsp;<span style="color:red;">*</span></font></span>    
    										<input type="text"  class="form-control " id="txt_emp_passport_no"  placeholder="Passport Number" tabindex=9>
    										
    									</div>
    									
    									
        								<div class="col-lg-6 col-md-6 col-sm-12">
        								
        								<span class="form-text text-muted font-weight-bold"><font color="black">Visa Validity Upto&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_visa_validity" tabindex=10>
        										
        									
        								</div>
                                       <div class="col-lg-6 col-md-6 col-sm-12">	<span class="form-text text-muted font-weight-bold"><font color="black">Blood Group&nbsp;</font></span>
                                         <select data-placeholder="Select Blood Group" id="select_employee_blood_group" class="form-control form-control-select2" data-fouc tabindex=11>
                                             <option value="NA">Select</option>
                                                <option value="A+">A+</option>
                                                <option value="B+">B+</option>
                                                <option value="AB+">AB+</option>
                                                <option value="O+">O+</option>
                                                <option value="A-">A-</option>
                                                <option value="B-">B-</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O-">O-</option>
                                            
                                           
                                          </select>
                                         	
                                    </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <span class="form-text text-muted font-weight-bold"><font color="black">Native Number&nbsp;</font></span> 
									<input type="text"  class="form-control " id="txt_emp_native_no"  placeholder="Native Number" tabindex=12>
										   
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Native Address</font></span> 
									<textarea rows="1" class="form-control " id="txt_emp_native_address" placeholder="Native Address" tabindex=13></textarea>
    									   
    							</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Visa Type&nbsp;</font></span>	
									 <select data-placeholder="Select visa_type" id="select_employee_visa_type" class="form-control form-control-select2" tabindex=14 data-fouc>
										 <option value="NA">Select</option>
										 <option value="Residence Permit">Residence Permit</option>
											<!--<option value="VISA">VISA</option>-->
											<option value="FLEXI">FLEXI</option>
											<option value="OTHERS">OTHERS</option>
									  </select>
										
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Driving License&nbsp;</font></span>	
							        	<div class="form-check  " style="padding-top:-10px">
										<label class="form-check-label ">
											 
											<input type="checkbox" class="form-check-input"  id="chk_driving" name="chk_driving" tabindex=15>
											Check if the employee has valid driving license
											
										</label>
									</div>
										
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12"  style="display:none;" id="div_emp_code">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Employee Code&nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_emp_code" placeholder="Employee Code" readonly="readonly">
    									     	   
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
						      
						             <?PHP include("employee_type_combo.php"); ?>
						      
									  <div class="col-lg-6 col-md-6 col-sm-12" id="div_select_emp_tech_type">
									      	<span class="form-text text-muted font-weight-bold"><font color="black">Technician Type&nbsp;<span style="color:red;">*</span></font></span>	
                                         <select data-placeholder="Select Technician Type" id="select_emp_tech_type" class="form-control form-control-select2" data-fouc>
                                             <option value="select">Select</option>
                                                <option value="Floating">Floating</option>
                                                <option value="Resident/Stationed">Resident/Stationed</option>
                                                
                                          </select>
                                         
                                    </div>
						     	
						     	    
									
						    </div>
						    <div class="row">
						        <?PHP include("tech_expertise_combo.php"); ?>
						  </div>
					
						  	<div class="row">
							   
    									
    							    <div class="col-lg-12 col-md-12 col-sm-12">
                    					<!--<div class="card-body" >-->
                    					     <span class="form-text text-muted font-weight-bold"><font color="black">Employee Image&nbsp;</font></span>	
                    					    <input type="file" class="form-input-styled"  id="session_image" accept="image/*" title="&nbsp;" tabindex=17 data-fouc=""/><p id="emp_img_name"></p>
                    					    <div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
                    					   
                    					<!--</div>-->
    							    </div>
						     	  
						     	
						     	   
						    </div>
						   
						    <div class="row mt-3">
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <h5 class="card-title">
						Employee Documents					
						</h5>
                                    <!--<label class="form-text text-muted font-weight-bold"><font color="black">Employee Documents&nbsp;</font></label>-->
                                    <div id="document_container" class="p-2 rounded">
                                        <!-- Initial document row -->
                                        <div class="document_row  align-items-center" style="background: white; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Document Type</label>
                                                    <select class="form-control document_type" id="document_type" tabindex="18" style="border-radius: 4px;">
                                                        <option value="">Select Document Type</option>
                                                        <option value="PASSPORT">PASSPORT</option>
                                                        <option value="VISA">VISA</option>
                                                        <option value="CPR">CPR</option>
                                                        <option value="DRIVING LICENSE">DRIVING LICENSE</option>
                                                        <option value="OFFER LETTER">OFFER LETTER</option>
                                                        <option value="RESUME & CERTIFICATES">RESUME & CERTIFICATES</option>
                                                        <option value="EMPLOYMENT CONTRACT">EMPLOYMENT CONTRACT</option>
                                                        <option value="OTHERS">OTHERS</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 expiry_date_container" style="display: none;">
                                                    <label>Expiry Date</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control expiry_date" placeholder="Expiry Date" tabindex="20" style="border-radius: 4px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Remark</label>
                                                    <textarea class="form-control document_remark" placeholder="Remark" tabindex="21" rows="1" style="border-radius: 4px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="row" style="padding-top:15px;">
                                                <div class="col-md-12">
                                                    <label>Upload Document</label>
                                                   <input type="file" class="form-input-styled document_file" accept="image/*,application/pdf" multiple tabindex="19" style="border-radius: 4px;" data-fouc="">
                                                    <div class="document_preview d-flex flex-wrap" style="gap: 8px;"></div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Move the Add Another Document button outside document_container -->
                                    <button type="button" id="add_document_row" class="btn btn-primary ">
                                        <i class="bi bi-plus"></i> Add Another Document
                                    </button>
                                </div>
                            </div>
					        <div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									    </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									    <!--<button type="button"  class="btn bg-teal-400 addAction">Test Button</button>-->    
    										<button type="button" id="btn_employee_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_employee_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_employee_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Employees</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_employees">
						<thead>
							<tr>
							    <th></th>
							    <th>Sl. No.</th>
							    <th></th>
				                <th>Emp. Name</th>
				                <th>Emp. Type</th>
				                <th>Emp. Code</th>
				               
				                <th>Emp. Image</th>
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
				<!-- /single row selection -->

<!-- View Documents Modal -->
<div class="modal fade" id="viewDocsModal" tabindex="-1" role="dialog" aria-labelledby="viewDocsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewDocsModalLabel">Employee Documents</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="employeeDocsTable">
          <thead>
            <tr>
              <th>Document Type</th>
              <th>Document Name</th>
              <th>Expiry Date</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

