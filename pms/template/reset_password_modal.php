     <!-- Vertical form modal -->
				<div id="modal_form_vertical" class="modal fade" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Reset Password</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-4">
												<label>Old Password</label>
												<input type="text" id="txt_old_password" placeholder="Old password" class="form-control"  >
												<span id="txt_error_msg" style="color:red;"></span>
												<input type="hidden" id="txt_user_id" class="form-control"  value="<?PHP echo $_SESSION['user_id'];?>">
											    <input type="hidden" id="txt_hidden_old_pswd" class="form-control"  value="<?PHP echo $_SESSION['password'];?>">
											</div>

											<div class="col-sm-4">
												<label>New Password</label>
												<input type="password" id="txt_new_password" placeholder="New password" class="form-control">
											</div>
											
											<div class="col-sm-4">
												<label>Confirm Password</label>
												<input type="password" id="txt_confirm_password" placeholder="Confirm password" class="form-control">
											</div>
										</div>
									</div>

								<div class="modal-footer">
								
									<button type="button" class="btn bg-primary" id="btn_reset_password">Submit</button>
								</div>
						
						</div>
					</div>
				</div>
			</div>	
				<!-- /vertical form modal -->