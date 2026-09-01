<!-- Modal: Edit Employee Attachment & Expiry Date -->
<div id="modal_edit_employee_attachment" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white py-2">
				<h6 class="modal-title font-weight-semibold mb-0">
					<i class="icon-pencil7 mr-2"></i> Edit Employee Document & Expiry
				</h6>
				<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
			</div>

			<form id="form_edit_employee_attachment" method="POST" enctype="multipart/form-data" onsubmit="return false;">
				<input type="hidden" id="edit_attach_id" name="attachment_id" value="">
				<input type="hidden" id="edit_attach_emp_id" name="employee_id" value="">

				<div class="modal-body py-3">
					<!-- Employee Info Display -->
					<div class="alert alert-light border-primary p-2 mb-3 d-flex align-items-center">
						<i class="icon-user-check text-primary icon-2x mr-2"></i>
						<div>
							<div class="small text-muted font-weight-bold">Employee:</div>
							<div class="font-weight-semibold text-primary" id="edit_attach_emp_display">-</div>
						</div>
					</div>

					<!-- Document Type -->
					<div class="form-group">
						<label class="font-weight-bold text-dark">
							Document Type / Name <span class="text-danger">*</span>
						</label>
						<select id="edit_attach_doc_name" name="document_type" class="form-control" required>
							<option value="Passport">Passport</option>
							<option value="Driving License">Driving License</option>
							<option value="CPR Card">CPR Card</option>
							<option value="Visa / Work Permit">Visa / Work Permit</option>
							<option value="Insurance Policy">Insurance Policy</option>
							<option value="Contract / Agreement">Contract / Agreement</option>
							<option value="Educational Certificate">Educational Certificate</option>
							<option value="Other Document">Other Document</option>
						</select>
					</div>

					<!-- Expiry Date -->
					<div class="form-group">
						<label class="font-weight-bold text-dark">
							Expiry Date
						</label>
						<input type="date" class="form-control" id="edit_attach_expiry_date" name="expiry_date">
						<small class="form-text text-muted">
							<i class="icon-info22 mr-1"></i> Changing expiry for <strong>CPR Card</strong> or <strong>Visa / Work Permit</strong> will automatically update the employee's CPR and Visa Expiry records.
						</small>
					</div>

					<!-- Remarks -->
					<div class="form-group">
						<label class="font-weight-bold text-dark">
							Remarks / Document Notes
						</label>
						<input type="text" class="form-control" id="edit_attach_remarks" name="remarks" placeholder="Optional reference or document notes...">
					</div>

					<!-- Current File & Replace Document File -->
					<div class="form-group mb-0">
						<label class="font-weight-bold text-dark d-flex justify-content-between align-items-center">
							<span>Replace Document File <span class="text-muted font-weight-normal">(Optional)</span></span>
							<span id="edit_attach_current_file_preview"></span>
						</label>
						<input type="file" class="form-control-file" id="edit_attach_doc_file" name="doc_file" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" style="width:100%;">
						<small class="form-text text-muted">Leave empty to keep the existing document file.</small>
					</div>
				</div>

				<div class="modal-footer bg-light py-2">
					<button type="button" class="btn btn-light" data-dismiss="modal">
						<i class="icon-cross2 mr-1"></i> Cancel
					</button>
					<button type="submit" id="btn_save_edit_attachment" class="btn bg-teal-400 font-weight-semibold">
						<b><i class="icon-checkmark3 mr-1"></i></b> Update Document
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
