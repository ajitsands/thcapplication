<div class="card classCustomerAssetModify">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">Add Customer Team</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
                    <div  class="col-lg-12 col-md-12 col-sm-12"  id="div_customer_details_asset"></div>
				</div>
			</div>
			<div class="col-md-6"> 
        	    <span class="form-text text-muted font-weight-bold"><font color="black">Team Reference</font></span>    
			    <textarea rows="1" class="form-control" id="team_reference" placeholder="Team Reference"></textarea>
			    <input type="hidden" id="hidden_ids">
        	</div>
		</div>
		
		<div class="row">
			<div class="col-12" style="padding-top:10px;">
        	    <table class="table datatable-selection-single w-100" id="tbl_techs_schedule_ticket_multiple" style="width:100%;">
						<thead>
							<tr>
							    <th>Technicians available</th>
							    <th style="width: 100px; text-align: center;">Leader</th>
							</tr>
						</thead>
				</table>
			</div>
		</div>
		<div class="row mt-3">
		    <div class="col-lg-6 col-md-6 col-sm-12">
		    </div>
		    <div class="col-lg-6 col-md-6 col-sm-12 text-right">
    		    <button type="button" id="btn_team_add" class="btn btn-success ladda-button legitRipple" tabindex="11" data-style="expand-right"><span class="ladda-label"><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</span><span class="ladda-spinner"></span></button>
    			<button type="button" id="team_edit" class="btn btn-danger ladda-button legitRipple" tabindex="12" data-style="expand-right" style="display: none;"><span class="ladda-label"><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</span><span class="ladda-spinner"></span></button>
    		</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header header-elements-inline">
		<h5 class="card-title">List of Customer Teams</h5>
	</div>
	<div class="card-body">
	    <div class="row">
			<div class="col-12">
            	<table class="table datatable-selection-single w-100" id="list_team" style="width:100%;">
						<thead>
							<tr>
							    <th style="width: 60px;">Sl No.</th>
							    <th>Team Reference</th>
							    <th>Customer</th>
							    <th>Employees</th>
							    <th>Status</th>
							    <th style="width: 80px; text-align: center;">Action</th>
							</tr>
						</thead>
				</table>
			</div>
		</div>
	</div>
</div>