<div id="modal_backdrop_amc_schedule" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="amc_no_view_head_schedule_visit"></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    <div class="row">
                                <input class="form-control" type="hidden" id="txt_amc_id_schedule_visit">
                                <input class="form-control" type="hidden" id="txt_amc_ref_no_schedule_visit">                               
							       
							        <div class="col-lg-8 col-md-12 col-sm-12" >
							                <div style="border-bottom: 1px solid #ccc!important;">
        										<select  class="form-control select" multiple="multiple" data-fouc id="select_visit_frequency" name="select_visit_frequency">
        										    <optgroup label="Every Day">
            											<option value="ED-All">Every Day</option>
            										</optgroup>
            										<optgroup label="Every Week">
            											<option value="EW-Sunday">Every Week Sunday</option>
            											<option value="EW-Monday">Every Week Monday</option>
            											<option value="EW-Tuesday">Every Week Tuesday </option>
            											<option value="EW-Wednesday">Every Week Wednesday </option>
            											<option value="EW-Thursday">Every Week Thursday </option>
            											<option value="EW-Friday">Every Week Friday </option>
														<option value="EW-Saturday">Every Week Saturday </option>
            											
            										</optgroup>
            										<optgroup label="Every Month First Week">
            											<option value="FW-Sunday">First Week Sunday</option>
            											<option value="FW-Monday">First Week Monday</option>
            											<option value="FW-Tuesday">First Week Tuesday </option>
            											<option value="FW-Wednesday">First Week Wednesday </option>
            											<option value="FW-Thursday">First Week Thursday </option>
            											<option value="FW-Friday">First Week Friday </option>
														<option value="FW-Saturday">First Week Saturday </option>
            										</optgroup>
            											<optgroup label="Every Month Second Week">
            											<option value="SW-Sunday">Second Week Sunday</option>
            											<option value="SW-Monday">Second Week Monday</option>
            											<option value="SW-Tuesday">Second Week Tuesday </option>
            											<option value="SW-Wednesday">Second Week Wednesday </option>
            											<option value="SW-Thursday">Second Week Thursday </option>
            											<option value="SW-Friday">Second Week Friday </option>
														<option value="SW-Saturday">Second Week Saturday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Every Month Third Week">
            											<option value="TW-Sunday">Third Week Sunday</option>
            											<option value="TW-Monday">Third Week Monday</option>
            											<option value="TW-Tuesday">Third Week Tuesday </option>
            											<option value="TW-Wednesday">Third Week Wednesday </option>
            											<option value="TW-Thursday">Third Week Thursday </option>
            											<option value="TW-Friday">Third Week Friday </option>
														<option value="TW-Saturday">Third Week Saturday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Every Month Fourth Week">
            											<option value="FRW-Sunday">Fourth Week Sunday</option>
            											<option value="FRW-Monday">Fourth Week Monday</option>
            											<option value="FRW-Tuesday">Fourth Week Tuesday </option>
            											<option value="FRW-Wednesday">Fourth Week Wednesday </option>
            											<option value="FRW-Thursday">Fourth Week Thursday </option>
            											<option value="FRW-Friday">Fourth Week Friday </option>
														<option value="FRW-Saturday">Fourth Week Saturday </option>
            										</optgroup>
            										</optgroup>
            											<optgroup label="Specific Date">
            											<option value="YSD">Specific Date</option>
            										
            										</optgroup>
            									</select>
            									</div>
            									<span class="form-text text-muted"> Frequency of Visit <i>(For Specific Date option the Start Date will consider)</i> </span>
							        </div>
                                    <div class="col-lg-2 col-md-12 col-sm-12" id="div_from_date">
        										<input class="form-control" type="date" name="date" id="txt_from_date">
        										<span class="form-text text-muted">Start Date</span>
							        </div>
							        <div class="col-lg-2 col-md-12 col-sm-12" id="div_to_date">
        										<input class="form-control" type="date" name="number" id="txt_to_date">
        										<span class="form-text text-muted">End Date</span>
							        </div>
									<!-- <div class="col-lg-2 col-md-12 col-sm-12" id="div_specific_date" >
        										<input class="form-control" type="date" name="number" id="txt_selected_date">
        										<span class="form-text text-muted">Select Date</span>
							        </div> -->
							        <div class="col-lg-2 col-md-12 col-sm-12 pull-right" >
        								<input class="form-control" type="time" name="time" id="time">
										<span class="form-text text-muted">Select Time</span>
							        </div>
							        
							        
					            </div>
<br>
								<div class="row">
								<div class="col-lg-8 col-md-12 col-sm-12 pull-right" ></div>
									<div class="col-lg-4 col-md-12 col-sm-12 pull-right" >
        								<button type="button" class="btn bg-primary" id="btn_generate_schedule">GENERATE SCHEDULE</button>		
							        </div>
									
								</div>

					            <div class="row">
							        
							        <div class="col-lg-12 col-md-12 col-sm-12" >
					            
					                        <?PHP 
					                            include_once("amc_date_list.php");
					                        ?>
					            
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