
<style>
    input[type='file'] {
  width: 95px;
 }
</style>

	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">Employee List</h5>
						    </div>

					<div class="card-body">
					
						  <div class="row">
						      
						             <?PHP include("employee_type_combo_report.php"); ?>
						      
									  <div class="col-lg-6 col-md-6 col-sm-12" id="div_select_emp_tech_type">
									      	<span class="form-text text-muted font-weight-bold"><font color="black">Technician Type&nbsp;<span style="color:red;">*</span></font></span>	
                                         <select data-placeholder="Select Technician Type" id="select_emp_tech_type" class="form-control form-control-select2" data-fouc>
                                             <option value="Both">Both</option>
                                                <option value="Floating">Floating</option>
                                                <option value="Resident/Stationed">Resident/Stationed</option>
                                                
                                                
                                          </select>
                                         
                                    </div>
						     	
						     	    
									
						    </div>
						    <div class="row">
						        <?PHP include("tech_expertise_combo.php"); ?>
						  </div>
					
						  
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									    </div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    									
    										<button type="button" id="btn_employee_search" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Search</button>
    										
    										<button type="button" id="btn_employee_download" class="btn bg-warning-400 exportToPDFAction classEmployeeListPDF"><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Export</button>
    										
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
							    <th>Sl.No.</th>
							    <th></th>
							    <th>Emp.Image</th>
							    <th>Emp.Code</th>
				                <th>Emp.Name</th>
				                <th>Emp.Type</th>
				                <th>Emp.Contact No.</th>
				                <th>Emp.CPR No.</th>
				                <th>Status</th>
				                
				               
				                
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
                               
                                
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection -->
				