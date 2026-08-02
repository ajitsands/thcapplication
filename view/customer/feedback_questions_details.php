<div class="row">
	<div class="card col-md-12" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Add Question
						    </h5>
						
					</div>
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								
								<div class="form-group row">
    								    																			
										<div class="col-lg-4 col-md-4 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Question Type&nbsp;<span style="color:red;">*</span></font></span>
    										<select class="form-control form-control-select2 " id="select_question_type" name="select_asset_type" data-placeholder="Select Type">
    										    <option value="0" selected>Select Type</option>
    										    <option value="Single Selection">Single Selection</option>
    										    <option value="Multiple Selection">Multiple Selection</option>
    										    <option value="Text">Text</option>
    										</select>
    									</div>
    								    <div class="col-lg-8 col-md-8 col-sm-12" >
										    <input type="hidden" class="form-control" id="txt_asset_id">
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Question&nbsp;<span style="color:red;">*</span></font></span>
    										<textarea rows="1" class="form-control" id="txt_question" placeholder="Question " tabindex="2"></textarea>
    									</div>
								</div>
								
								<div class="form-group row" id="div_options">
									   						  									   
										<div class="col-lg-2 col-md-2 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Option 1&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_question1" placeholder="" tabindex=2>
    									</div>																
										<div class="col-lg-2 col-md-2 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Option 2&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_question2" placeholder="" tabindex=2>
    									</div>
    								    <div class="col-lg-2 col-md-2 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Option 3&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_question3" placeholder="" tabindex=2>
    									</div>
    									<div class="col-lg-2 col-md-2 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Option 4&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_question4" placeholder="" tabindex=2>
    									</div>
    									<div class="col-lg-2 col-md-2 col-sm-12" >
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Option 5&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_question5" placeholder="" tabindex=2>
    									</div>
    									<div class="col-lg-2 col-md-2 col-sm-12" >
										    <input type="hidden" class="form-control" id="txt_question_id">
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Option 6&nbsp;<span style="color:red;">*</span></font></span>
    										<input type="text" class="form-control" id="txt_question6" placeholder="" tabindex=2>
    									</div>
								        <p class="form-text text-muted " style="padding-top:20px;padding-right:10px;">Note : Please note that the weightage will be calculated in ascending order from Option 1 to Option 6</p>
								</div>
								
								
							</div>
						</div>
					
						
						
						
					</div>
					<div class="card-footer">
								<div class="row">
									
									<div class="col-lg-6 col-md-6 col-sm-12">
									</div>
    									<div class="col-lg-6 col-md-6 col-sm-12">
    										<!--<button type="button" id="btn_building_add" class="btn bg-teal-400 btn-labeled btn-labeled-left"><b><i class="icon-floppy-disk"></i></b>Save</button>-->
    										<button type="button" id="btn_question_add" class="btn btn-success " ><b><i class="icon-floppy-disk"></i></b>&nbsp;&nbsp;&nbsp;Save</button>
    										
    										<button type="button" id="btn_question_edit" class="btn btn-danger "><b><i class="icon-database-edit2"></i></b>&nbsp;&nbsp;&nbsp; Update</button>
    										<button type="button" id="btn_question_new" class="btn btn-primary"><b><i class="icon-book"></i></b>&nbsp;&nbsp;&nbsp; New</button>
    									</div>
						              
								   
								
								</div>
					</div>
				</div>
				
				    
			    </div>	
					
					
	</div>
	
	<div class="col-md-12" >
				
				<div class="row">
						
			
			        <div class="col-md-12">
			    
			   <!-- Single row selection -->
				<div class="card" style="overflow:auto;" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">List of Feedback Questions</h5>
						<div class="header-elements">
							
	                	</div>
					</div>

				

					<table class="table datatable-selection-single" id="list_of_feedback_questions">
						<thead>
							<tr>
						
							    <th>Sl. No.</th>
							    <th>ID</th>
				                <th>Type</th>
								<th>Name</th>
								<th>O1</th>
								<th>O2</th>
								<th>O3</th>
								<th>O4</th>
								<th>O5</th>
								<th>O6</th>
				                <th>Status</th>
				                <th>Action</th>
				            </tr>
						</thead>
						<tbody>
							
				               
						</tbody>
						<tfoot>
                            <tr>
                    			<th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
                               
                            </tr>
                        </tfoot>
					</table>
				</div>
				<!-- /single row selection --> 
			 </div>
				    
			    </div>	
					
					
	</div>
				
</div>				
				
	
				