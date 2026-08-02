
	<div class="card" >
		<div class="card-header header-elements-inline">
			<h5 class="card-title">
				Customers Feedback Details
			</h5>
		</div>
		<div class="card-body"> 
			<div class="row"> 
				
				<div class="col-lg-3 col-md-3 col-sm-3">
					<span class="form-text text-muted font-weight-bold"><font color="black">Start Date&nbsp;<span style="color:red;">*</span></font></span>
						<input class="form-control" type="date" id="feedback_start_date" tabindex="" value="<?php echo date('Y-m-d'); ?>">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3">
					<span class="form-text text-muted font-weight-bold"><font color="black">End Date&nbsp;<span style="color:red;">*</span></font></span>
						<input class="form-control" type="date" id="feedback_end_date" tabindex="" value="<?php echo date('Y-m-d'); ?>">
				</div>
				<?php include('feedback_customer_combo.php') ; ?>
				<div class="col-lg-2 col-md-2 col-sm-2" style="margin-top:27px;">
					<button type="button" id="btn_feedback_search" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Search</button>
				</div>
			</div>
			
		</div>	
	</div>
		<!--<div class="card-footer">
			<div class="row">
				<div class="col-lg-2 col-md-2 col-sm-2">
					<button type="button" id="btn_employee_search" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Search</button>
				</div>
			</div>
		</div>-->
			
	
			<div class="card">
			 
				<table style="width:100%" class="table datatable-selection-single table-hover datatable-highlight" id="tbl_customer_feedback_list" >
					<thead>
						<tr>
							<th>SL.No</th>
							<th>AMC No</th>
							<th>Main Customer</th>
							<th>Contract Type</th>
							<th>Name</th>
							<th>Contact</th>
							<th>Email</th>
							<th>View</th>
							<th>Analysis Result</th>
						</tr>
					</thead>
					 
					<tbody></tbody>
					
				</table>
		
			</div>
				
	