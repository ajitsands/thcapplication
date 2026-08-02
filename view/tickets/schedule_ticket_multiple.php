<div id="modal_schedule_ticket_multiple" class="modal fade" data-backdrop="false" tabindex="-1" >
					<div class="modal-dialog modal-lg " style="max-width:90%">
						<div class="modal-content">
							<div class="modal-header bg-info">
							<h5 class="modal-title"><b>Schedule WO. : <span id="span_ticket_ref_no_schedule_ticket_multiple"></span><span id="span_customer_schedule_ticket_multiple" data-popup="popover" data-placement="bottom" title="Popover title" ></span><span id="span_customer_schedule_location_multiple"></span><span id="span_customer_schedule_building_multiple" data-popup="popover" data-placement="bottom" title="Popover title" data-content=""></span></b>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							 
							    <div class="row">
                             	<input type="hidden" id="txt_hidden_ticket_ref_code_schedule_ticket_multiple"/>
                             	<input type="hidden" id="txt_ticket_id_assign_hidden_multiple"/>
                             	<input type="hidden" id="txt_visit_date_assign_hidden_multiple"/>
                             	<input type="hidden" id="txt_visit_slot_assign_hidden_multiple"/>
                             	<input type="hidden" id="txt_visit_slot_assign_hidden_for_sch_multiple"/>
                             	<input type="hidden" id="txt_visit_added_slot_multiple"/>
                             	<input type="hidden" id="txt_customer_id_assign_hidden_multiple"/>
                             	<input type="hidden" id="txt_customer_code_assign_hidden_multiple"/>
                             	<input type="hidden" id="txt_customer_name_assign_hidden_multiple"/>
                             	<input type="hidden" id="txt_vist_start_time_hidden_multiple"/>
                             	  <div class="col-lg-12 col-md-12 col-sm-12" >
                             	      
                             	      
                        			 <table class="table datatable-selection-single" id="tbl_ticket_schedule_category_list_multiple" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							    <th></th>
                        							    <th>Work Order No.</th>
                        							    <th>Category</th>
                        								<th>Type</th>
                        								<th>Priority</th>
                        								<th >Complaint</th>
                        								<th >Actions</th>
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div>
                                   
							       
							       
							        
					            </div>
					            
                                <br>
                                 <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12" >
                                     <label>Date of Schedule</label>
                                    <input type="date"  class="form-control "  value="<?php date_default_timezone_set('Asia/Bahrain'); echo date("Y-m-d"); ?>" id="txt_date_multiple">
                                    </div>
                                    	<div class="col-lg-2 col-md-12 col-sm-12" id="div_time_slot" >
								   <label>Time Slot</label>
								   <select  class="form-control select" id="select_slots_multiple" name="select_slots_multiple">
					                    <optgroup label="Slots">
					                        <option value="1" >Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>
                    					</optgroup>
                    				</select>
								   
									</div>
										<div class="col-lg-2 col-md-12 col-sm-12" >
								   
								    <label>Hours Required</label>
									<select  class="form-control select"   name="duration_multiple" id="duration_multiple" ><option value="0" selected>0</option><option value="1" >1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
									</div>
									<div class="col-lg-2 col-md-12 col-sm-12" style="display:none">
									     <label>Start Time</label>
									<input class="form-control "  type="time" name="time" width="50px;" value="00:00" id="txt_time_multiple">
									</div>
                                </div>
                              
								<div class="row">
							
								  <div class="col-lg-8 col-md-12 col-sm-12" >
                        			  <table class="table datatable-selection-single" id="tbl_techs_schedule_ticket_multiple" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							    
                        							    <th>Technicians available</th>
                        							
                        							<th>Leader</th>
                        							<th>Actions</th>
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div>
								</div>

					       
					            
							</div>
							
							<div class="modal-footer">
									<button type="button" id="btn_schudle_all_multiple" class="btn bg-teal"  >Schedule </button>
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								
								
							</div>
						</div>
					</div>
				</div>