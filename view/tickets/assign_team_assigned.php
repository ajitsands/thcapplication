<div id="modal_assign_ticket_multiple" class="modal fade" data-backdrop="false" tabindex="-1" >
    <div class="modal-dialog modal-lg " style="max-width:90%">
		<div class="modal-content">
		    	<div class="modal-header bg-info">
					<h5 class="modal-title"><b>Assign WO. : <span id="span_ticket_ref_no_assign_ticket_multiple"></span><span id="span_customer_assign_ticket_multiple" data-popup="popover" data-placement="bottom" title="Popover title" ></span><span id="span_customer_assign_location_multiple"></span><span id="span_customer_assign_building_multiple" data-popup="popover" data-placement="bottom" title="Popover title" data-content=""></span></b>
    							  </h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
				      <div class="row">
                             	<input type="hidden" id="txt_hidden_ticket_ref_code_assign_ticket_multiple1"/>
                             	<!--<input type="hidden" id="txt_ticket_id_assign_hidden_multiple"/>-->
                             	<!--<input type="hidden" id="txt_visit_date_assign_hidden_multiple"/>-->
                             	<!--<input type="hidden" id="txt_visit_slot_assign_hidden_multiple"/>-->
                             	<!--<input type="hidden" id="txt_visit_slot_assign_hidden_for_sch_multiple"/>-->
                             	<!--<input type="hidden" id="txt_visit_added_slot_multiple"/>-->
                             	<!--<input type="hidden" id="txt_customer_id_assign_hidden_multiple"/>-->
                             	<!--<input type="hidden" id="txt_customer_code_assign_hidden_multiple"/>-->
                             	<!--<input type="hidden" id="txt_customer_name_assign_hidden_multiple"/>-->
                             	<!--<input type="hidden" id="txt_vist_start_time_hidden_multiple"/>-->
                             	  <div class="col-lg-12 col-md-12 col-sm-12" >
                        			 <table class="table  table-hover datatable-highlight display" id="tbl_ticket_assign_category_list_multiple_extended" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							    <th></th>
                        							    <th>Work Order No.</th>
                        							    <th>Category</th>
                        								<th>Type</th>
                        								<th>Visit Date</th>
                        								<th>Time Slot</th>
                        								<th>Hours Req.</th>
                        								<th >Actions</th>
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div><!--div_col-->
					   </div><!--div_row-->
					            
                                <br>
            				 
								<div class="row" id="div_team_list" >
							
								  <div class="col-lg-8 col-md-12 col-sm-12" >
                        			  <table class="table datatable-selection-single" id="tbl_assigned_team_list" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							     <th>SL No.</th>
                        							    <th>Code</th>
                        							    <th>Name</th>
                        							    <th>Contact No</th>
                        							    <th>Team Leader</th>
                        							</tr>
                        						</thead>
                        						
                        				</table>
							        </div>
								</div>
				    
				</div><!--div_modal_body-->
				
				<div class="modal-footer">
									<!--<button type="button" id="btn_assign_team" class="btn bg-teal"  >Assign </button>-->
								<button type="button" class="btn bg-danger" data-dismiss="modal">Close</button>
								
								
				</div><!--div_modal_footer-->
		</div><!--div_modal_content-->
	</div><!--div_modal_dialog-->
</div><!--div_main-->