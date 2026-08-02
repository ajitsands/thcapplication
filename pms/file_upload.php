<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>THC-FMS</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files-->
	<script src="global_assets/js/main/jquery.min.js"></script> 

 
	 

	 <script src="global_assets/js/fileupload_ns.js"></script>
	

</head>
<script type="text/javascript">
 $('#session_image').change(function (e) {
                         
                            v_session_image = $("#session_image").val();
                            randomNum = Math.ceil(Math.random() * 999999);
                            if(v_session_image=="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                             v_session_image=$.trim(randomNum+'_'+doc_file1);
                            var success = upload.doUpload("https://thc.sianlab.com/httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum);
                        }  
              });
              
                    
</script>
<body>
   <style>
    input[type='file'] {
  width: 95px;
 }
</style>

	<div class="card">
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
						
						
						  <br><br>
					<div class="row"></div>
							
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									    </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									
    										<button type="button" id="btn_employee_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_employee_edit" class="btn bg-warning-400 "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_employee_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
					
					
	</div>
				
		
</body>
</html>
 