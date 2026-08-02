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
						<h5 class="card-title">Assign Technician To WO.</h5>
						<div class="header-elements">
						
	                	</div>
					</div>


					<div class="card-body" style="">
					   <div class="row">
				          
                                    <div class="col-lg-3 col-md-12 col-sm-12" id="div_from_date">
        										<input class="form-control" type="date" name="date" id="txt_visit_date_asg" value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>">
        										<span class="form-text text-muted">Visit Date</span>
							        </div>
							       	<div class="col-lg-3 col-md-12 col-sm-12" >
								   
								   
									<select  class="form-control select" id="select_slots_asg" name="select_slots_asg">
										<optgroup label="Slots">
											<option value="1" selected>Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>
										</optgroup>
									</select>
									<span class="form-text text-muted">Select Slots</span>
									</div>
									
									<div class="col-lg-2 col-md-12 col-sm-12" >
								   
								   
									<select  class="form-control select"   name="duration_asg" id="duration_asg" ><option value="0" selected>0</option><option value="1" >1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
									<span class="form-text text-muted">Additional Slots</span>
									</div>
									<div class="col-lg-3 col-md-12 col-sm-12" >
								   
								   
									<select  class="form-control select" id="select_tech_type_asg" name="select_tech_type_asg">
										<optgroup label="Type">
											<option value="1" selected>Floating</option><option value="2">Resident/Stationed</option>
										</optgroup>
									</select>
									<span class="form-text text-muted">Technician Type</span>
									</div>
									 <!--<div class="col-lg-2 col-md-12 col-sm-12 pull-right" >-->
        		<!--						<button type="button" class="btn bg-primary" id="btn_search_schedule">Search</button>		-->
							   <!--     </div>-->
							 </div>
						<!-- Single row selection -->
				<!--<div class="card" style="overflow:auto;">-->
				    
							       </br></br>
					<div class="row">  
					    <div class="col-lg-12 col-md-12 col-sm-12" >
					        		<h5 class="card-title">List of WOs</h5>
                					<table class="table datatable-selection-single" id="list_of_amc_assets_schs">
                						<thead>
                							<tr>
                							    <th>#</th>
                							    <th>WO.Ref.No.</th>
                				                <th>Asset Code</th>
                				                <th>Category</th>
                								<th>Type</th>
                								<th>Actions</th>
                				            </tr>
                						</thead>
                						<tbody>
                							
                				               
                						</tbody>
                					
                					</table>
                		</div>
                		
                		 </br></br>
                		
                		<div class="col-lg-12 col-md-12 col-sm-12" >
                		    	<h5 class="card-title">Available Technicians</h5>
                					<table class="table datatable-selection-single" id="list_of_techs_avail_agn">
                						<thead>
                							<tr>
                							    <th>#</th>
                							     <th>Technician</th>
                				                <th>Leader</th>
                				                <th>Actions</th>
                				            </tr>
                						</thead>
                						<tbody>
                							
                				               
                						</tbody>
                					
                					</table>
                		</div>
                	</div>
                <div class="row"> 
                	<div class="col-lg-10 col-md-12 col-sm-12 pull-right" ></div>
                	<div class="col-lg-2 col-md-12 col-sm-12 pull-right" >
        								<button type="button" class="btn bg-primary" id="btn_amc_assign">Assign</button>		
							        </div>
				</div>
				<!-- /single row selection -->
					
					
					
					
					
					
					
						
						
									
						
					</div>
					
				
					
					
					
	</div>
				
				
				

				