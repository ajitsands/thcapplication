<div id="modal_update_schedule" class="modal fade" data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" id="amc_no_view_head_update_visit"></h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							    <div class="row">
                                <input class="form-control" type="hidden" id="txt_amc_visit_id_hidden"> 
                                <input class="form-control" type="hidden" id="txt_amc_refno_update_hidden"> 
							       
							        
								
							        
							        
					            </div>
  <div class="row">
							        
							        <div class="col-lg-3 col-md-12 col-sm-12" id="div_from_date">
        										<input class="form-control" type="date" name="date" id="txt_visit_date_update">
        										<span class="form-text text-muted">Visit Date</span>
							        </div>
							        	<div class="col-lg-3 col-md-12 col-sm-12" >
								   
								   
									<select  class="form-control select" id="select_slots_updated" name="select_slots_updated">
										<optgroup label="Slots">
											<option value="1" selected>Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>
										</optgroup>
									</select>
									<span class="form-text text-muted">Select Slots</span>
									</div>
										<div class="col-lg-2 col-md-12 col-sm-12" >
								   
								   
									<select  class="form-control select"   name="duration_update" id="duration_update" ><option value="0" selected>0</option><option value="1" >1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
									<span class="form-text text-muted">Additional Slots</span>
									</div>
									<div class="col-lg-2 col-md-12 col-sm-12" style="display:none">
									    
									<input class="form-control "  type="time" name="time" width="50px;" value="00:00" id="txt_time_update">
									<span class="form-text text-muted">Start Time</span>
									</div>
									 
							        
						</div>
	</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_change_schedule">Change Schedule</button>
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								
							</div>
						</div>
					</div>
				</div>