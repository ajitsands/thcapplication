
	<div class="card" >
		<div class="card-header header-elements-inline">
			<h5 class="card-title">
				Login & Logout Details
			</h5>
		</div>
		<div class="card-body"> 
			<div class="row"> 
				<?PHP include("username_combo.php"); ?>
				<div class="col-lg-3 col-md-3 col-sm-3">
					<span class="form-text text-muted font-weight-bold"><font color="black">Start Date&nbsp;<span style="color:red;">*</span></font></span>
						<input class="form-control" type="date" id="login_start_date" tabindex="" value="<?php echo date('Y-m-d'); ?>">
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3">
					<span class="form-text text-muted font-weight-bold"><font color="black">End Date&nbsp;<span style="color:red;">*</span></font></span>
						<input class="form-control" type="date" id="login_end_date" tabindex="" value="<?php echo date('Y-m-d'); ?>">
				</div> 
				<div class="col-lg-2 col-md-2 col-sm-2" style="margin-top:27px;">
					<button type="button" id="btn_user_search" class="btn bg-teal-400 " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Search</button>
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
			 
				<table style="width:100%" class="table table-bordered table-hover datatable-highlight display" id="tbl_login_logout_log" style="padding-right:10px;padding-left:10px;">
					<thead>
						<tr>
							<th>ID</th>
							<th>Event</th>
							<th>Username</th>
							<th>Date</th>
							<th>IP Address</th>
							<th>Module</th>
						</tr>
					</thead>
					 
					<tbody></tbody>
					
				</table>
		
			</div>
				
	