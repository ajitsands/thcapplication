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
									<span id="user_name" style="display:none;"><?PHP echo $_SESSION['username'];?></span>  
								</div>
						
						</div>
					</div>
				</div>
			</div>	
				<!-- /vertical form modal 
				
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>	-->	
<?PHP 
	echo '<script>var serverName = "' . $_SERVER['SERVER_NAME'] . '";</script>';
	echo '<script>var remoteAddress = "' . $_SERVER['REMOTE_ADDR'] . '";</script>';
?>	
<script>
    $(document).ready(function () {
		
		$('#log_out').on('click', function (e) {
            e.preventDefault(); 
			var user_name = $('#user_name').text();
			JSONPost(document.getElementById('logout_form'),'Login','Logout',user_name);
			window.location.href = 'logout.php';
			
        });
    });
	
	function JSONPost(formName,moduleName,event,userName)
	{
		var formData = new FormData(formName);
			formData.append('module', moduleName);
			formData.append('event', event);
			formData.append('v_username', userName);
			formData.append('action', 'login_log');
 	
		
		$.ajax({
            type: 'POST',
            url: '../controller/login/login_controller.php',
            data: formData,
			contentType: false, // Ensure that the content type is set to false for FormData
            processData: false, // Prevent jQuery from processing the data
            success: function (response) {
                console.log(response); // Display a success message or handle as needed
            },
            error: function (error) {
                console.log(error);
                alert('Error inserting data'); // Display an error message
            }
        });
	}
</script>