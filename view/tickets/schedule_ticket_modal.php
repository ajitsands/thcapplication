<div id="modal_schedule_ticket" class="modal fade" data-backdrop="false" tabindex="-1" >
					<div class="modal-dialog modal-lg" style="max-width:90%">
						<div class="modal-content">
							<div class="modal-header">
							<h5 class="modal-title"><b>Schedule Ticket : <span id="span_ticket_ref_no_schedule_ticket"></span><span id="span_customer_schedule_ticket" data-popup="popover" data-placement="bottom" title="Popover title" ></span><span id="span_customer_schedule_location"></span><span id="span_customer_schedule_building" data-popup="popover" data-placement="bottom" title="Popover title" data-content=""></span></b>
    							  </h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							 
							    <div class="row">
                             	<input type="hidden" id="txt_hidden_ticket_ref_code_schedule_ticket"/>
                             	<input type="hidden" id="txt_ticket_id_assign_hidden"/>
                             	<input type="hidden" id="txt_visit_date_assign_hidden"/>
                             	<input type="hidden" id="txt_visit_slot_assign_hidden"/>
                             	<input type="hidden" id="txt_visit_slot_assign_hidden_for_sch"/>
                             	<input type="hidden" id="txt_visit_added_slot"/>
                             	<input type="hidden" id="txt_customer_id_assign_hidden"/>
                             	<input type="hidden" id="txt_customer_code_assign_hidden"/>
                             	<input type="hidden" id="txt_customer_name_assign_hidden"/>
                             	<input type="hidden" id="txt_vist_start_time_hidden"/>
                             	  <div class="col-lg-12 col-md-12 col-sm-12" >
                             	      
                             	      
                        			 <table class="table  table-hover datatable-highlight" id="tbl_ticket_schedule_category_list" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							    <th></th>
                        							    <th>Work Order No.</th>
                        							    <th>Category</th>
                        								<th>Type</th>
                        								<th>Priority</th>
                        								<th>Date Needed</th>
                        								<th>Visit Date</th>
                        								<th>Visit Slot</th>
                        								<th>Added Slots</th>
                        								<th>Start Time</th>
                        								<th >Actions</th>
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div>
                                   
							       
							       
							        
					            </div>
					            
                                <br>
								<div class="row">
								<!--     <div class="form-group">-->
								<!--<div class="col-lg-6 col-md-12 col-sm-12" >-->
								   
								<!--    <label>Select Slots</label>-->
								<!--	<select multiple="multiple" class="form-control select-fixed-multiple" data-fouc id="select_slots" name="select_slots">-->
								<!--		<optgroup label="Slots">-->
								<!--			<option value="1" selected>Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option>-->
								<!--		</optgroup>-->
								<!--	</select>-->
								<!--	</div>-->
								<!--</div>-->
								  <div class="col-lg-6 col-md-12 col-sm-12" >
                        			  <table class="table datatable-selection-single" id="tbl_techs_schedule_ticket" style="padding-right:10px;padding-left:10px;">
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
									<button type="button" id="btn_schudle_all" class="btn bg-teal"  >Schedule </button>
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								
								
							</div>
						</div>
					</div>
				</div>