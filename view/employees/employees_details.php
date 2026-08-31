
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

	<div class="card classEmployeesModify">  
					<?PHP
						include('template/card_head_control.inc');
					?>

					<div class="px-3 pt-2">
						<ul class="nav nav-pills thc-nav-pills mb-0" id="employeeMainTabs">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#tab_employee_form">
									<i class="icon-user-plus mr-2"></i> Employee Details
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab_employee_attachments">
									<i class="icon-attachment mr-2"></i> Add Attachments & Documents
								</a>
							</li>
						</ul>
					</div>

					<div class="tab-content">
						<!-- TAB 1: Add/Edit Employee Form -->
						<div class="tab-pane fade show active" id="tab_employee_form">
							<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">
										<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Employee Name &nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control " id="txt_emp_name" placeholder="Employee Name" tabindex=1>
    											
    								        <input type="hidden" class="form-control text-uppercase" id="txt_emp_id">
    									</div>
    								
 						               <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
    										<span class="form-text text-muted font-weight-bold"><font color="black">Employee Password&nbsp;<span style="color:red;">*</span></font></span>    
    										 <input type="text" class="form-control " id="txt_emp_password" placeholder="Employee Password" value="12345" tabindex=2>
    									     	
    									</div>
								        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Contact Number&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_emp_contact_no"    onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" placeholder="Contact Number" tabindex=3>
    											
    									</div>
    										<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" >
    									<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email Id</font></span>
    										<input type="text" class="form-control" id="txt_emp_email_id" placeholder="Email Id" tabindex=4>
    											
    									</div>
    									 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
    									     <span class="form-text text-muted font-weight-bold"><font color="black">Address</font></span>  
    										<textarea rows="1" class="form-control " id="txt_emp_address" placeholder="Address" tabindex=5></textarea>
    											  
    							        </div>
    									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Date of Join&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_joining_date"  tabindex=6>
        										
        									
        								</div>
        								
    								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" >
    										<span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">CPR Number&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text"  class="form-control " id="txt_cpr_no" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="CPR Number" tabindex=7>
    											
    									</div>
    									 <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        										<span class="form-text text-muted font-weight-bold"><font color="black">CPR Expiry Date&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_cpr_expiry_date" tabindex=8>
        										
        									
        								</div>
        									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
    										    	<span class="form-text text-muted font-weight-bold"><font color="black">Passport Number&nbsp;<span style="color:red;">*</span></font></span>    
    										<input type="text"  class="form-control " id="txt_emp_passport_no"  placeholder="Passport Number" tabindex=9>
    										
    									</div>
    									
    									
        								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        								
        								<span class="form-text text-muted font-weight-bold"><font color="black">Visa Validity Upto&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" id="emp_visa_validity" tabindex=10>
        										
        									
        								</div>
                                       <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">	<span class="form-text text-muted font-weight-bold"><font color="black">Blood Group&nbsp;</font></span>
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
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <span class="form-text text-muted font-weight-bold"><font color="black">Native Number&nbsp;</font></span> 
									<input type="text"  class="form-control " id="txt_emp_native_no"  placeholder="Native Number" tabindex=12>
										   
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Native Address</font></span> 
									<textarea rows="1" class="form-control " id="txt_emp_native_address" placeholder="Native Address" tabindex=13></textarea>
    									   
    							</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Visa Type&nbsp;</font></span>	
									 <select data-placeholder="Select visa_type" id="select_employee_visa_type" class="form-control form-control-select2" tabindex=14 data-fouc>
										 <option value="NA">Select</option>
										 <option value="Residence Permit">Residence Permit</option>
											<!--<option value="VISA">VISA</option>-->
											<option value="FLEXI">FLEXI</option>
											<option value="OTHERS">OTHERS</option>
									  </select>
										
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
								    <span class="form-text text-muted font-weight-bold"><font color="black">Driving License&nbsp;</font></span>	
							        	<div class="form-check  " style="padding-top:-10px">
										<label class="form-check-label ">
											 
											<input type="checkbox" class="form-check-input"  id="chk_driving" name="chk_driving" tabindex=15>
											Check if the employee has valid driving license
											
										</label>
									</div>
										
								</div>
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"  style="display:none;" id="div_emp_code">
    									    <span class="form-text text-muted font-weight-bold"><font color="black">Employee Code&nbsp;<span style="color:red;">*</span></font></span> 
    										 <input type="text" class="form-control " id="txt_emp_code" placeholder="Employee Code" readonly="readonly">
    									     	   
    									</div>
								</div>
								
								
								
								
							</div>
						</div>
						<div class="row">
						    <?PHP include("employee_type_combo.php"); ?>
						      
						    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" id="div_select_emp_tech_type">
						        <span class="form-text text-muted font-weight-bold"><font color="black">Technician Type&nbsp;<span style="color:red;">*</span></font></span>	
                                <select data-placeholder="Select Technician Type" id="select_emp_tech_type" class="form-control form-control-select2" data-fouc>
                                    <option value="select">Select</option>
                                    <option value="Floating">Floating</option>
                                    <option value="Resident/Stationed">Resident/Stationed</option>
                                </select>
                            </div>
						     	
						    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12" id="div_employee_image">
                    			<span class="form-text text-muted font-weight-bold"><font color="black">Employee Image&nbsp;</font></span>	
                    			<div class="d-flex align-items-center">
                    			    <div style="flex: 1;">
                    			        <input type="file" class="form-input-styled" id="session_image" accept="image/*" title="&nbsp;" tabindex="17" data-fouc="" />
                    			    </div>
                    			    <div id="img_preview" style="width:36px;height:36px;margin-left:8px;display:flex;align-items:center;justify-content:center;"></div>
                    			</div>
                    			<p id="emp_img_name" class="mb-0 small text-muted"></p>
    						</div>

						    <!-- Action Buttons in 4th Column -->
						    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 ml-auto text-right align-self-end pb-1" id="div_action_buttons">
						        <button type="button" id="btn_employee_add" class="btn bg-teal-400"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;Save</button>
						        <button type="button" id="btn_employee_edit" class="btn bg-warning-400"><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;Update</button>
						        <button type="button" id="btn_employee_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;New</button>
						    </div>
						</div>
						<div class="row mt-2">
						    <?PHP include("tech_expertise_combo.php"); ?>
						</div>

							</div>
						</div>

						<!-- TAB 2: Employee Attachments & Documents -->
						<div class="tab-pane fade" id="tab_employee_attachments">
							<div class="card-body">
								<form id="form_employee_attachment" method="POST" enctype="multipart/form-data">
									<div class="row align-items-end">
										<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Select Employee <span style="color:red;">*</span></font></span>
											<select id="select_attach_employee" name="employee_id" class="form-control" required>
												<option value="">Select Employee</option>
												<?PHP
												if (!isset($varDBConnection)) {
													include_once(__DIR__ . '/../../model/db_connection/connection.php');
													$DBConnAtt = new DBConnection();
													$varDBConnAtt = $DBConnAtt->ConnectToMYSQL();
												} else {
													$varDBConnAtt = $varDBConnection;
												}
												$res_emp_att = mysqli_query($varDBConnAtt, "SELECT employee_id, employee_code, employee_name FROM tbl_employees WHERE employee_status='Active' ORDER BY employee_name ASC");
												if ($res_emp_att) {
													while ($r_emp = mysqli_fetch_assoc($res_emp_att)) {
														echo '<option value="' . $r_emp['employee_id'] . '">' . htmlspecialchars($r_emp['employee_code'] . ' - ' . $r_emp['employee_name']) . '</option>';
													}
												}
												?>
											</select>
										</div>

										<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Document Type / Name <span style="color:red;">*</span></font></span>
											<select id="select_attach_doc_name" name="document_type" class="form-control" required>
												<option value="Passport">Passport</option>
												<option value="Driving License">Driving License</option>
												<option value="CPR Card">CPR Card</option>
												<option value="Visa / Work Permit">Visa / Work Permit</option>
												<option value="Insurance Policy">Insurance Policy</option>
												<option value="Contract / Agreement">Contract / Agreement</option>
												<option value="Educational Certificate">Educational Certificate</option>
												<option value="Other Document">Other Document</option>
											</select>
										</div>

										<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Expiry Date</font></span>
											<input type="date" class="form-control" id="txt_attach_expiry_date" name="expiry_date">
										</div>

										<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 form-group">
											<span class="form-text text-muted font-weight-bold"><font color="black">Attach Document File <span style="color:red;">*</span></font></span>
											<input type="file" class="form-control-file" id="file_attach_doc" name="doc_file" required accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" style="width:100%;">
										</div>

										<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 form-group mb-xl-0">
											<span class="form-text text-muted font-weight-bold"><font color="black">Remarks / Document Notes</font></span>
											<input type="text" class="form-control" id="txt_attach_remarks" name="remarks" placeholder="Optional reference or document notes...">
										</div>

										<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 form-group mb-xl-0 text-right">
											<button type="submit" id="btn_upload_attachment" class="btn bg-teal-400 btn-block">
												<b><i class="icon-upload mr-2"></i></b> Upload Attachment
											</button>
										</div>
									</div>
								</form>

								<hr class="my-3">

								<div class="d-flex align-items-center justify-content-between mb-2">
									<h6 class="font-weight-semibold mb-0"><i class="icon-files-empty mr-2"></i> Uploaded Employee Attachments & Documents</h6>
									<div class="form-inline">
										<label class="mr-2 font-weight-bold">Filter by Employee:</label>
										<select id="select_filter_attachment_emp" class="form-control form-control-sm">
											<option value="0">All Employees</option>
											<?PHP
											mysqli_data_seek($res_emp_att, 0);
											while ($r_emp = mysqli_fetch_assoc($res_emp_att)) {
												echo '<option value="' . $r_emp['employee_id'] . '">' . htmlspecialchars($r_emp['employee_code'] . ' - ' . $r_emp['employee_name']) . '</option>';
											}
											?>
										</select>
									</div>
								</div>

								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover" id="tbl_employee_attachments" style="width:100%;">
										<thead>
											<tr>
												<th>Sl. No.</th>
												<th>Emp. Code</th>
												<th>Emp. Name</th>
												<th>Document Type</th>
												<th>Expiry Date</th>
												<th>Remarks</th>
												<th>Attachment File</th>
												<th>Uploaded Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
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
				