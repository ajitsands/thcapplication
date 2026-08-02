	<!-- Disabled backdrop Change Status -->
				<div id="modal_customer_pass" class="modal " data-backdrop="false" tabindex="-1">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header " style="background-color: #00274f;">
							<h5 class="modal-title" style="color:white"><b>Password Settings </b>
    							  </h5>
								<button type="button" class="close mdlclose" data-dismiss="modal" style="color:white">&times;</button>
							</div>

							<div class="modal-body">
									<br>
								<div class="row">
							       	<input type="hidden" id="txt_cust_code_pass_sett"/>
							       	<input type="hidden" id="txt_customer_name_reset_pass"/>
							       	
							         <h4><p ><strong><span style="color:grey" id="span_customer_details_reset_pass"></span></strong> </p></h4>
							        <div class="col-lg-12 col-md-12 col-sm-12" >
        							       <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Password</font></span>
        							      <div class="input-wrapper" style="display: flex;">
        							         
        							      <input type="text" class="form-control" id="txt_customer_pass_reset_pass" placeholder="Password"> <span data-bs-toggle="tooltip" title="Generate Password" class="reset-icon" id="span_pass_gen"><i class="icon-reset"></i></span>
        							      </div>
        							      
        							      </div>
							         <div class="col-lg-12 col-md-12 col-sm-12" >
							             <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Email ID</font></span>
        							      <input type="text" class="form-control" id="txt_customer_email_id_reset_pass" placeholder="Email ID">
        							      </div>
							    </div>
								
						
								
							</div>

							<div class="modal-footer">
							<button type="button" class="btn bg-secondary mdlclose"  data-dismiss="modal" style="align:left">Close</button>
								<button type="button" class="btn " id="btn_reset_pass_cust" data-dismiss="modal" style="background-color: #00274f; color:white">Reset Password</button>
								<button type="button" class="btn " id="btn_reset_pass_cust_send_email" data-dismiss="modal" style="background-color: #00274f; color:white">Reset & Send Email To Customer</button>
							</div>
						</div>
					</div>
				</div>
				<!-- /disabled backdrop Change Status -->
			