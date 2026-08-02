	<!-- Disabled backdrop Change Status -->
<?php 
$sql_1="SELECT response_text FROM feedback_text_responses WHERE question_id =".$ids;
?>
				<div id="modal_question_comments" class="modal fade" data-backdrop="false" >
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h5 class="modal-title" >View Responses</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
								
								<div class="row">
						
    									    											
						          	<div class="col-lg-12 col-md-12 col-sm-12" >
										  
										    <table class="table  table-hover datatable-highlight" id="tbl_question_responses" style="padding-right:10px;padding-left:10px;">
                        						<thead>
                        							<tr>
                        							    
                        							    <th>Responses</th>
                        							   
                        							</tr>
                        						</thead>
                        						
                        				</table>
    											
    								
    									</div>
    								
							        
							        </div>
							        
						        </div>
						        
							

							<div class="modal-footer">
							    
								<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
								
							</div>
							</div>
					</div>
				</div>
			
				<!-- /disabled backdrop Change Status -->
			