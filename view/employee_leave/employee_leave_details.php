
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
										<div class="col-lg-4 col-md-4 col-sm-12" id="div_employee_select">
    										<?PHP include_once("employee_leave/employee_combo.php");?>
    									</div>
    									
    								<div class="col-lg-4 col-md-4 col-sm-12">
    								    <span class="form-text text-muted font-weight-bold"><font color="black">Start Date</font></span> 
    										 	<input class="form-control" type="datetime-local" name="date" id="txt_leave_from_date">
        										   
    									</div>
    									
						                <div class="col-lg-4 col-md-4 col-sm-12">
						                    <span class="form-text text-muted font-weight-bold"><font color="black">End Date</font></span>
    										 <input class="form-control" type="datetime-local" name="number" id="txt_leave_to_date">
        										   
    									</div>
						               <div class="col-lg-4 col-md-4 col-sm-12">
						                   <span class="form-text text-muted font-weight-bold"><font color="black">Type of Leave</font></span> 
    										 <select data-placeholder="Select Type of Leave" id="select_type_of_leave" class="form-control form-control-select2" data-fouc>
    										    <option value="select">Select </option>
    										    <option value="Sick Leave">Sick Leave</option>
    										    <option value="Casual Leave">Casual Leave</option>
                								<option value="Annual Leave">Annual Leave</option>
                								<option value="Emergency Leave">Emergency Leave</option>
                								<option value="Privilege Leave">Privilege Leave</option>
    										 </select>    
        										  
    									</div>
								        <div class="col-lg-4 col-md-4 col-sm-12" id="div_reason_select">
								            <div style="border-bottom: 1px solid #ccc!important;">
								                	<span class="form-text text-muted font-weight-bold"><font color="black"> Reason For Leave </font> </span>
        										<select  class="form-control select" data-fouc id="select_reason_for_leave" name="select_reason_for_leave">
            										        <option value="select">Select </option>
                									        <option value="1">Sir, I am not well today. I am Sick</option>
                											<option value="2">I have an dentist appointment</option>
                											<option value="3">Family member is not well</option>
                											<option value="4">Parent’s doctor appointment</option>
                											<option value="5">Virtual relative’s death</option>
                											<option value="6">Stuck in traffic! What to do</option>
    														<option value="7">Adverse House Situations</option>
                											<option value="8">Purchasing important things</option>
    														<option value="9">Bad Weather</option>
    														<option value="10">Relative’s wedding</option>
    														<option value="add_reason">Other Reason</option>
                								</select>
                							</div>
            								
            									  
    									</div>
    									 <div class="col-lg-4 col-md-4 col-sm-12" id="div_reason_for_leave">
            									        <span class="form-text text-muted font-weight-bold"><font color="black"> If others,specify the reason for leave</font>  </span>
                							            <input type="text" class="form-control form-control-sm" placeholder="" id="txt_reason_for_leave" >
                							           
                							       </div>
								
								</div>
								
								
							</div>
						</div>
					
							
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									    </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									
    										 <button type="button" id="btn_employee_leave_add" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_employee_edit" class="btn bg-warning-400 " style="display:none"><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_employee_new" class="btn btn-primary" style="display:none"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
					
	</div>
				
				
				
	 <!--Single row selection -->
				<div class="card" style="overflow:auto;">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Employees On Leave <button type="button" class="btn bg-indigo-400 ml-3" id="btn_leave_calendar"><i class="icon-calendar3 mr-2"></i> View Leave Calendar</button></h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_employees_on_leave">
						<thead>
							<tr>
							    <th>Sl. No.</th>
							    <th>Emp.Code</th>
				                <th>Emp.Name</th>
				                <th>Leave Reason</th>
				                <th>Start Date</th>
							    <th>End Date</th>
				                <th></th>
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
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection -->
				
				
				