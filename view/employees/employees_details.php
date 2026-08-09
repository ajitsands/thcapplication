
<style>
    input[type='file'] {
  width: 95px;
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
										<div class="col-lg-4 col-md-4 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Employee Name &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control " id="txt_emp_name" placeholder="Employee Name" tabindex=1>
    											
    								        <input type="hidden" class="form-control text-uppercase" id="txt_emp_id">
    									</div>
    								
 						               <div class="col-lg-4 col-md-4 col-sm-12">
    										<span class="form-text text-muted font-weight-bold"><font color="black">Employee Password&nbsp;<span style="color:red;">*</span></font></span>    
    										 <input type="text" class="form-control " id="txt_emp_password" placeholder="Employee Password" value="12345" tabindex=2>
    									     	
    									</div>
								        <div class="col-lg-4 col-md-4 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_emp_contact_no"    onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" placeholder="Contact Number" tabindex=3>
    											
    									</div>
    										<div class="col-lg-4 col-md-4 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email Id</font></span>
    										<input type="text" class="form-control" id="txt_emp_email_id" placeholder="Email Id" tabindex=4>
    											
    									</div>
    									 <div class="col-lg-4 col-md-4 col-sm-12">
    									     <span class="form-text text-muted font-weight-bold"><font color="black">Address</font></span>  
    										<textarea rows="1" class="form-control " id="txt_emp_address" placeholder="Address" tabindex=5></textarea>
    											  
    							        </div>
    									<div class="col-lg-4 col-md-4 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Date of Join&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_joining_date"  tabindex=6>
        										
        									
        								</div>
        								
    								<div class="col-lg-4 col-md-4 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">CPR Number&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_cpr_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="CPR Number" tabindex=7>
    											
    									</div>
    									 <div class="col-lg-4 col-md-4 col-sm-12">
        										<span class="form-text text-muted font-weight-bold"><font color="black">CPR Expiry Date&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_cpr_expiry_date" tabindex=8>
        										
        									
        								</div>
        									<div class="col-lg-4 col-md-4 col-sm-12">
    										    	<span class="form-text text-muted font-weight-bold"><font color="black">Passport Number&nbsp;<span style="color:red;">*</span></font></span>    
    										<input type="text"  class="form-control " id="txt_emp_passport_no"  placeholder="Passport Number" tabindex=9>
    										
    									</div>
    									
    									
        								<div class="col-lg-4 col-md-4 col-sm-12">
        								
        								<span class="form-text text-muted font-weight-bold"><font color="black">Visa Validity Upto&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_visa_validity" tabindex=10>
        										
        									
        								</div>
                                       <div class="col-lg-4 col-md-4 col-sm-12">	<span class="form-text text-muted font-weight-bold"><font color="black">Blood Group&nbsp;</font></span>
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
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <span class="form-text text-muted font-weight-bold"><font color="black">Native Number&nbsp;</font></span> 
									<input type="text"  class="form-control " id="txt_emp_native_no"  placeholder="Native Number" tabindex=12>
										   
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Native Address</font></span> 
									<textarea rows="1" class="form-control " id="txt_emp_native_address" placeholder="Native Address" tabindex=13></textarea>
    									   
    							</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Visa Type&nbsp;</font></span>	
									 <select data-placeholder="Select visa_type" id="select_employee_visa_type" class="form-control form-control-select2" tabindex=14 data-fouc>
										 <option value="NA">Select</option>
										 <option value="Residence Permit">Residence Permit</option>
											<!--<option value="VISA">VISA</option>-->
											<option value="FLEXI">FLEXI</option>
											<option value="OTHERS">OTHERS</option>
									  </select>
										
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Driving License&nbsp;</font></span>	
							        	<div class="form-check  " style="padding-top:-10px">
										<label class="form-check-label ">
											 
											<input type="checkbox" class="form-check-input"  id="chk_driving" name="chk_driving" tabindex=15>
											Check if the employee has valid driving license
											
										</label>
									</div>
										
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12"  style="display:none;" id="div_emp_code">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Employee Code&nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_emp_code" placeholder="Employee Code" readonly="readonly">
    									     	   
    									</div>
								</div>
								
								
								
								
							</div>
						</div>
						  <div class="row">
						      
						             <?PHP include("employee_type_combo.php"); ?>
						      
									  <div class="col-lg-4 col-md-4 col-sm-12" id="div_select_emp_tech_type">
									      	<span class="form-text text-muted font-weight-bold"><font color="black">Technician Type&nbsp;<span style="color:red;">*</span></font></span>	
                                         <select data-placeholder="Select Technician Type" id="select_emp_tech_type" class="form-control form-control-select2" data-fouc>
                                             <option value="select">Select</option>
                                                <option value="Floating">Floating</option>
                                                <option value="Resident/Stationed">Resident/Stationed</option>
                                                
                                          </select>
                                         
                                    </div>
						     	
						     	    <div class="col-lg-4 col-md-4 col-sm-12">
                    					<span class="form-text text-muted font-weight-bold"><font color="black">Employee Image&nbsp;</font></span>	
                    					<input type="file" class="form-input-styled"  id="session_image" accept="image/*" title="&nbsp;" tabindex=17 data-fouc=""/><p id="emp_img_name"></p>
                    					<div id="img_preview" style="width:40px;height:40px;padding-top:5px;"> </div>
    							    </div>
									
						    </div>
						    <div class="row mt-2">
						        <?PHP include("tech_expertise_combo.php"); ?>
						    </div>

						    <!-- Action Buttons after Employee Image & Expertise controls -->
						    <div class="row mt-3">
						        <div class="col-12 text-right">
						            <button type="button" id="btn_employee_add" class="btn bg-teal-400"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;Save</button>
						            <button type="button" id="btn_employee_edit" class="btn bg-warning-400"><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;Update</button>
						            <button type="button" id="btn_employee_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;New</button>
						        </div>
						    </div>

					</div>
					
					
					
					
	</div>
				
				
				
	<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Employees <button type="button" class="btn bg-indigo-400 ml-3" id="btn_leave_calendar"><i class="icon-calendar3 mr-2"></i> View Leave Calendar</button></h5>
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
				