
<?PHP
include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select expertise_id,expertise_name from    tbl_expertise where expertise_status='Active'");
	
?><div id="modal_check_avail" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title"><b>Check Availability </b>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    	<div class="row">
							    	     <div class="col-lg-4 col-md-12 col-sm-12" >
							                <div style="border-bottom: 1px solid #ccc!important;">
        										<select  class="form-control select"  data-fouc id="select_tech_expertise" name="select_tech_expertise">
        										     <option value="select">Select</option>
        										      <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['expertise_id']; ?>"><?PHP echo $row['expertise_name']; ?></option>
        
        <?PHP } ?>
        										  
            									</select>
            									</div>
            									<span class="form-text text-muted"> Select Expertise </span>
							        </div>
					            	    <div class="col-lg-2 col-md-12 col-sm-12" >
        										<input class="form-control" type="date" name="txt_search_date_check_avail" id="txt_search_date_check_avail" >
        										<span class="form-text text-muted">Date</span>
							        </div>
        							 <div class="col-lg-2 col-md-12 col-sm-12" >
        							     <select  class="form-control select"  data-fouc id="select_slots_check_avail" name="select_slots_check_avail">
        							         <option value="select">Select</option>
        										      <?PHP 	for($i=1;$i<=24;$i++) { ?>
                                                        <option value="<?PHP echo $i; ?>"><?PHP echo 'Slot '.$i; ?></option>
        
                                                         <?PHP } ?>
        										  
            									</select>
            									<span class="form-text text-muted"> Select Slots </span>
        						      </div> 
							         <div class="col-lg-3 col-md-12 col-sm-12 pull-right" >
							        	<button type="button" id="btn_list_techs_check_avail" class="btn bg-teal"  >List Technicians</button>
							        </div>
					                </div>
					                <br>
							    <div class="row">
                             
                             	  <div class="col-lg-12 col-md-12 col-sm-12" >
                             	      
                             	      
                        			 <table class="table  table-hover datatable-highlight" id="tbl_techs_check_avail" style="padding-right:10px;padding-left:10px;">
                        					
                        							<thead>
                        							<tr>
                        							    <th>Technicians available</th>
                        							   
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div>
                                    
							       
							       
							        
					            </div>
					            
                                
							</div>

							<div class="modal-footer">
								<!--<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>-->
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								
							</div>
						</div>
					</div>
				</div>