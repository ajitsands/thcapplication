<style>
    .password_disable {
		pointer-events: none;
		opacity: 0.4;
}
</style>
<style>
    input[type='file'] {
  width: 95px;
 }
</style>


	<div class="card">
				<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Active AMC</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body">
					
						<!-- Single row selection -->
				<div class="card" style="overflow:auto;">
					<table class="table datatable-selection-single table-hover datatable-highlight" id="tbl_of_active_list_amc">
						<thead>
							<tr>
							    <th></th><!--0-->
							    <th>#</th><!--1-->
				                <th>AMC No</th><!--2-->
								<th>Type</th><!--3-->				                
				                <th>Customer</th><!--4-->
				                <th>Start Date</th><!--5-->
				                <th>End Date</th><!--6-->
				                <th>Amount</th><!--7-->
				                <th>Yearly AMC Amount</th><!--8-->
				                <th>Action</th><!--9-->
								<th>Description</th><!--10-->
								<th>VAT %</th><!--12-->
								<th>VAT Amount</th><!--11-->
								<th>Customer</th><!--12-->
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				</div>
				<!-- /single row selection -->
					
					
					
					
					
					
						
					</div>
				
					
					
	</div>
				
    <div id="modal_amc_customer_feedback" class="modal fade no-enforce-focus" data-backdrop="false" tabindex="-1">
    	<div class="modal-dialog modal-sm" style="max-width:30%">
    		<div class="modal-content">
    			<div class="modal-header bg-info">
    				<h5 class="modal-title"><span id=""></span>Generate Domain</h5>
    				<button type="button" class="close" data-dismiss="modal">&times;</button>
    			</div>
    
    			<div class="modal-body">
    			    <div class="col-lg-12 col-md-12 col-sm-12" >
    			        <span class="form-text">Domain Name  <span style="color:red;">*</span></span>
                        <input class="form-control" type="text" name="txt_domain_name" id="txt_domain_name">
                    </div>	
            				
                </div>
                
    			<div class="modal-footer">
    				<button type="button" class="btn btn-danger" id="generate_amc_url">Generate URL</button>
    			
    			</div>
    		</div>
    	</div>
    </div>				
				

				