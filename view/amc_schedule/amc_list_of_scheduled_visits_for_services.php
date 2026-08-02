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
			


					<div class="card-body" style="overflow:auto;">
					    
					  <div class="form-group row">
								
									<div class="col-lg-6 col-md-6 col-sm-12" id="div_cate_select">
									    	<span class="form-text text-muted font-weight-bold"><font color="black">Category&nbsp;<span style="color:red;">*</span> </font></span>
									     <select class="form-control form-control-select2" id="select_category" data-placeholder="Select Category" data-fouc>
                                	    <option value="0">Select Category</option>
                                	    
                                	    <?PHP 
                                	   include "../model/db_connection/connection.php" ;
                                        $DBConn = new DBConnection();
                                        $varDBConnection = $DBConn->ConnectToMYSQL();
                                	    $result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
                                	    while($row=mysqli_fetch_assoc($result)) { ?>
                                          <option value="<?PHP echo $row['category_id']; ?>"><?PHP echo $row['category_name']; ?></option>
                                        
                                        <?PHP } ?>
                                      </select>
                                     
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12" id="div_assettype_select"></div>
								
								</div>
					    
					    
					    
			
				    	<div class="card-header header-elements-inline">
						    <h5 class="card-title">List of Services</h5>
					    </div>
				     <table class="table datatable-selection-single" id="list_of_services">
						<thead>
							<tr>
							   
							    <th>#</th>
				                <th>Services</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
				    
					
						<!-- Single row selection -->
			
				   	<div class="card-header header-elements-inline">
						    <h5 class="card-title">List of WOs.</h5>
					    </div>
					<table class="table datatable-selection-single" id="list_of_amc_schedules">
						<thead>
							<tr>
							   
							    <th>#</th>
							    <th>WO.Ref.No.</th>
				                <th>Asset Code</th>
				                
				                <th>Date</th>
				                 <th>Slot</th>
				                <th>Status</th>
				                <th>Actions</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
					
					</table>
			
				<!-- /single row selection -->
					
					
					
						 <div class="row"> 
                	<div class="col-lg-9 col-md-12 col-sm-12 pull-right" ></div>
                	<div class="col-lg-3 col-md-12 col-sm-12 pull-right" >
        								<button type="button" class="btn bg-primary" id="btn_amc_assign_services">Assign Services</button>		
							        </div>
				</div>
					
					
					
						
						
									
						
					</div>
					
				
				
					
					
	</div>
				
				
				

				