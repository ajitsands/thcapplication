<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">Add Question</h5>
			</div>
			
			<div class="card-body">
				<div class="row form-group">
					<?php include('contract_type_combo.php');?>
					<div class="col-lg-3 col-md-6 col-sm-12">
						<label class="font-weight-bold text-dark">Question Type <span class="text-danger">*</span></label>
						<select class="form-control form-control-select2" id="select_question_type" name="select_asset_type" data-placeholder="Select Type">
							<option value="0" selected>Select Type</option>
							<option value="radio">Single Selection</option>
							<option value="checkbox">Multiple Selection</option>
							<option value="text">Text</option>
						</select>
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12">
						<label class="font-weight-bold text-dark">Question <span class="text-danger">*</span></label>
						<input type="hidden" id="txt_asset_id">
						<textarea rows="1" class="form-control" id="txt_question" placeholder="Question" tabindex="2"></textarea>
					</div>
				</div>
				
				<div class="row form-group" id="div_options">
					<div class="col-lg-2 col-md-4 col-sm-6">
						<label class="font-weight-bold text-dark">Option 1 <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="txt_question1" placeholder="" tabindex="2">
						<input type="hidden" id="txt_question1_id">
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<label class="font-weight-bold text-dark">Option 2 <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="txt_question2" placeholder="" tabindex="2">
						<input type="hidden" id="txt_question2_id">
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<label class="font-weight-bold text-dark">Option 3 <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="txt_question3" placeholder="" tabindex="2">
						<input type="hidden" id="txt_question3_id">
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<label class="font-weight-bold text-dark">Option 4 <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="txt_question4" placeholder="" tabindex="2">
						<input type="hidden" id="txt_question4_id">
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<label class="font-weight-bold text-dark">Option 5 <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="txt_question5" placeholder="" tabindex="2">
						<input type="hidden" id="txt_question5_id">
					</div>
					<div class="col-lg-2 col-md-4 col-sm-6">
						<input type="hidden" id="txt_question_id">
						<label class="font-weight-bold text-dark">Option 6 <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="txt_question6" placeholder="" tabindex="2">
						<input type="hidden" id="txt_question6_id">
					</div>
					<div class="col-12 mt-2">
						<span class="text-muted">Note: Please note that the weightage will be calculated in ascending order from Option 1 to Option 6</span>
					</div>
				</div>
			</div>
			
			<div class="card-footer d-flex justify-content-end">
				<button type="button" id="btn_question_add" class="btn btn-success ml-2"><i class="icon-floppy-disk mr-2"></i> Save</button>
				<button type="button" id="btn_question_edit" class="btn btn-danger ml-2"><i class="icon-database-edit2 mr-2"></i> Update</button>
				<button type="button" id="btn_question_new" class="btn btn-primary ml-2"><i class="icon-book mr-2"></i> New</button>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h5 class="card-title">List of Feedback Questions</h5>
			</div>
			<div class="table-responsive">
				<table class="table datatable-selection-single" id="list_of_feedback_questions">
					<thead>
						<tr>
							<th>Sl. No.</th>
							<th>ID</th>
							<th>Category</th>
							<th>Type</th>
							<th>Name</th>
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
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>