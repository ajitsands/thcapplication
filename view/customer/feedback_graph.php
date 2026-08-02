
<div class="row">
	<div class="card col-md-12" >
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Customer Feedback
						    </h5>
						
					</div>
				<div class="row">
						
					<div class="col-md-12">

					<div class="card-body"  >
					
						<div class="row">
						
							<div class="col-md-12">
								
								<input type="hidden" value="<?php echo $_GET['cust_id'];?>" id="txt_cust_id">
								<input type="hidden" value="<?php echo $_GET['cust_name'];?>" id="txt_cust_name">
								<input type="hidden" value="<?php echo $_GET['cat_val'];?>" id="txt_cate_val">
								<input type="hidden" value="<?php echo $_GET['cat_text'];?>" id="txt_cate_text">
								<input type="hidden" value="<?php echo $_GET['start_date'];?>" id="txt_stdate_val">
								<input type="hidden" value="<?php echo $_GET['end_date'];?>" id="txt_enddate_val">
								<div class="form-group row">
    								    																	
										<div class="col-lg-2 col-md-12 col-sm-12">
										    <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">From&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" name="txt_start_date" id="txt_start_date" value="2024-02-05" tabindex="1">
        									
							            </div>
    								   <div class="col-lg-2 col-md-12 col-sm-12">
    								       <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">To&nbsp;<span style="color:red;">*</span></font></span>
        										<input class="form-control" type="date" name="txt_end_date" id="txt_end_date" value="2024-02-05" tabindex="2">
        									
							        </div>
							        	<?PHP include("customer_combo_feedback.php"); ?>
							        	</div>
							        <div class="form-group row">
							        <div class="col-lg-12 col-md-12 col-sm-12 " style="text-align: right;">
							        	<button type="button" id="btn_search_feedback" class="btn bg-info legitRipple ladda-button" tabindex="4" data-style="expand-right" fdprocessedid="mqx0bj"><span class="ladda-label">Search</span><span class="ladda-spinner"></span></button>
							        </div>
								</div>
								
							
								
							</div>
						</div>
					
						
						
						
					</div>
				
				</div>
				
				    
			    </div>	
					
					
	</div>
	
	<div class="col-md-12" >
				
				<div class="row">
						
			
			       	<div class="col-sm-12 col-xl-12" >
                       <!--<div id="div_wo_graph"></div>-->
                        <?php include("feedback_bar_chart.php");?>
						
					</div>
				    
			    </div>	
					
					
	</div>
				
</div>				
				
	
				