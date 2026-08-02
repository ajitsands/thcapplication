<?PHP 
                            include_once "../model/db_connection/connection.php" ;
                            $DBConn = new DBConnection();
                            $varDBConnection = $DBConn->ConnectToMYSQL();
                         	$result = mysqli_query($varDBConnection,"Select count(amc_visit_id) as visit_count from  tbl_visits where  (DATE_FORMAT(date_of_visits,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')) and amc_visit_status !='Cancelled'");
                         
                         
                        	 	while($row=mysqli_fetch_assoc($result)) {
                       
?>

<div class="row" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:15px;font-weight:bold;">
                DASHBOARD
</div>
	<div class="mb-3 pt-2">
					<h6 class="mb-0 font-weight-semibold">
						Stats with progress
					</h6>
					<span class="text-muted d-block">Rounded progress bars</span>
				</div>

				<div class="row">
					<div class="col-sm-6 col-xl-3">

						<!-- Satisfaction rate -->
						<div class="card card-body text-center">
							<div class="svg-center position-relative" id="progress_icon_one"></div>
							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold">0%</h2>

							Satisfaction rate
							<div class="font-size-sm text-muted">54% average</div>
						</div>
						<!-- /satisfaction rate -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Productivity goal  -->
						<div class="card card-body text-center">
							<div class="svg-center position-relative" id="goal-progress"></div>
							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold">0%</h2>

							Productivity goal
							<div class="font-size-sm text-muted">87% average</div>
						</div>
						<!-- /productivity goal -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Orders processed -->
						<div class="card card-body text-center bg-teal-400 has-bg-image">
							<div class="svg-center position-relative" id="today-progress"></div>
							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold">0%</h2>

							Orders processed
							<div class="font-size-sm opacity-75">83 orders pending</div>
						</div>
						<!-- /orders processed -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Order shipped -->
						<div class="card card-body text-center bg-purple-400 has-bg-image">
							<div class="svg-center position-relative" id="hours-available-progress"></div>
							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold">0%</h2>

							Orders shipped
							<div class="font-size-sm opacity-75">92 orders pending</div>
						</div>
						<!-- /orders shipped -->

					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-xl-3">

						<!-- Invitation stats white -->
						<div class="card text-center">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">Invitation statistics</h6>
								<div class="text-muted mb-3">539 invites sent</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_one"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs text-muted">Accepted</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">2,483</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs text-muted">Declined</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">1,257</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs text-muted">Pending</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">8,472</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /invitation stats white -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Tickets stats white -->
						<div class="card text-center">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">Tickets statistics</h6>
								<div class="text-muted mb-3">893 tickets in total</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_two"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs text-muted">Raised</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">5,328</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs text-muted">Pending</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">2,348</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs text-muted">Closed</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">4,357</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /tickets stats white -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Invitation stats colored -->
						<div class="card text-center bg-blue-400 has-bg-image">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">Invitation statistics</h6>
								<div class="opacity-75 mb-3">539 invites sent</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_three"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs">Accepted</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">2,483</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Declined</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">1,257</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Pending</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">8,472</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /invitation stats colored -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Tickets stats colored -->
						<div class="card text-center bg-danger-400 has-bg-image">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">Tickets statistics</h6>
								<div class="opacity-75 mb-3">893 tickets in total</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_four"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs">Raised</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">5,328</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Pending</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">2,348</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Closed</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">4,357</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /tickets stats colored -->

					</div>
				</div>
				<!-- /stats with progress -->

 <?PHP } ?>

<div class="row" style="padding-top:30px;">
    
    <?PHP 
		$result_payments = mysqli_query($varDBConnection,"Select sum(paid_amount) as total_collections from  tbl_customer_payments where  (DATE_FORMAT(date_of_payment,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')) group by amc_payments_ids");
                         
                          $total_collection=0;
                        	 	while($row_payment=mysqli_fetch_assoc($result_payments)) {
                        	 	    $total_collection=$total_collection+$row_payment['total_collections'];
                        	 	}
	  ?>
	   <div  class="col-lg-6 col-md-6 col-sm-12"  >   
        <div class="custom-box" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     TODAY'S COLLECTIONS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                 <?PHP if (is_null( $total_collection)){
                     echo 0.000; 
                 }
                  else
                  {
                  echo  $total_collection;
                  }?> 
              <small style="font-size:12px;padding-top:30px;">&nbsp; BHD</small>
            </div>
        </div> 
	</div>
	  
   
		<?PHP 
		$result_payments_total = mysqli_query($varDBConnection,"Select sum(total_payable_amt) as total_payable_amount, sum(total_paid_amt) as total_paid_amount from  tbl_customer_payments  ");
                         
                         
                        	 	while($row_payment_total=mysqli_fetch_assoc($result_payments_total)) {
                        	 	
	
	?>
	<div  class="col-lg-6 col-md-6 col-sm-12"  >   
    
        <div class="custom-box-1" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     TODAY'S PENDING COLLECTIONS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                 <?PHP echo $row_payment_total['total_payable_amount']- $row_payment_total['total_paid_amount'] ?><small style="font-size:12px;padding-top:30px;">&nbsp; BHD</small>
            </div>
        </div> 
    </div>
    
    <?PHP } ?>


</div>






<div class="row" style="padding-top:30px;">
    	<?PHP 
		$result_visits = mysqli_query($varDBConnection,"select count(amc_visit_id) as last_month_visit  from tbl_visits where date_of_visits > now() - interval 1 month; ");
                         
                         
                        	 	while($row_last_month_visit=mysqli_fetch_assoc($result_visits)) {
                        	 	
	
	?>
    
    <div  class="col-lg-3 col-md-6 col-sm-12"  >   
        <div class="custom-box-1" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     LAST MONTH VISITS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
               <?PHP echo $row_last_month_visit['last_month_visit'] ?>
            </div>
        </div> 
	</div>
	<?PHP } 

		$result_visits = mysqli_query($varDBConnection,"select count(amc_visit_id) as last_week_visit  from tbl_visits where date_of_visits >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
AND date_of_visits < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY ");
                         
                         
                        	 	while($row_last_week_visit=mysqli_fetch_assoc($result_visits)) {
                        	 	
	
	?>
	<div  class="col-lg-3 col-md-6 col-sm-12"  >  
	
	

        <div class="custom-box" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     LAST WEEK VISITS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                <?PHP echo $row_last_week_visit['last_week_visit']?>
            </div>
        </div> 
    </div>
    <?PHP }
    	$result_visits = mysqli_query($varDBConnection,"select count(amc_visit_id) as this_week_visit  from tbl_visits where  YEARWEEK(`date_of_visits`, 1) = YEARWEEK(CURDATE(), 1) ");
                         
                         
                        	 	while($row_this_week_visit=mysqli_fetch_assoc($result_visits)) {
                        	 	
 
    ?>
    <div  class="col-lg-3 col-md-6 col-sm-12"  >   
    
        <div class="custom-box-2" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     THIS WEEK VISITS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
              <?PHP echo $row_this_week_visit['this_week_visit']?>
            </div>
        </div> 
	</div>
	<?PHP } 
	
		$result_visits = mysqli_query($varDBConnection,"SELECT count(amc_visit_id) as next_month_visit from tbl_visits where date_of_visits BETWEEN DATE_SUB( LAST_DAY( DATE_ADD(NOW(), INTERVAL 1 MONTH)), INTERVAL DAY( LAST_DAY( DATE_ADD(NOW(), INTERVAL 1 MONTH) ) )-1 DAY)  and LAST_DAY(DATE_ADD(NOW(), INTERVAL 1 MONTH))");
                         
                         
                        	 	while($row_next_month_visit=mysqli_fetch_assoc($result_visits)) {
                        	 	

	?>
	<div  class="col-lg-3 col-md-6 col-sm-12"  >   
    
        <div class="custom-box-3" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     NEXT MONTH
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
               <?PHP echo $row_next_month_visit['next_month_visit']?>
            </div>
        </div> 
    
	</div>
	<?PHP } ?>
</div>





<div class="row" style="padding-top:30px;">
    <div  class="col-lg-3 col-md-6 col-sm-12"  >  
    	<?PHP  
	
		$result_amc_renewal_count = mysqli_query($varDBConnection,"select DATE_FORMAT((SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)),'%d-%m-%Y') as amc_upto_date , count(amc_id) as amc_count  from tbl_amc_master where  amc_end_date < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(amc_end_date) DESC, MONTH(amc_end_date) DESC, DAY(amc_end_date) DESC  ");
                         
                         
                        	 	while($row_amc_renewal=mysqli_fetch_assoc($result_amc_renewal_count)) {
                        	 	

	?>
        <div class="custom-box" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     AMC RENEWALS UPTO <?PHP echo $row_amc_renewal['amc_upto_date'] ?>
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                
               <?PHP echo $row_amc_renewal['amc_count'] ?>
               
            </div>
        </div> 
	</div>
	<?PHP } ?>
	<div  class="col-lg-3 col-md-6 col-sm-12"  >   
    	<?PHP  
	
		$result_expiry_count = mysqli_query($varDBConnection,"select count(employee_id) as cpr_expiry_count, DATE_FORMAT((SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)),'%d-%m-%Y') as cpr_upto_date from view_employee_expertiser_list where cpr_expiry_date < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(cpr_expiry_date) DESC, MONTH(cpr_expiry_date) DESC, DAY(cpr_expiry_date) DESC");
                         
                         
                        	 	while($row_visa_expiry=mysqli_fetch_assoc($result_expiry_count)) {
                        	 	

	?>
        <div class="custom-box-1" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                    CPR EXPIRY UPTO <?PHP echo $row_visa_expiry['cpr_upto_date']?>
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                <?PHP echo $row_visa_expiry['cpr_expiry_count'] ?>
            </div>
        </div> 
        
        <?PHP } ?>
    </div>
    <div  class="col-lg-3 col-md-6 col-sm-12"  >   
    	<?PHP  
	
		$result_expiry_count = mysqli_query($varDBConnection,"select count(employee_id) as visa_expiry_count, DATE_FORMAT((SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)),'%d-%m-%Y') as visa_upto_date from view_employee_expertiser_list where visa_validity_on < (SELECT DATE_ADD(CURDATE(), INTERVAL 30 DAY)) order by YEAR(visa_validity_on) DESC, MONTH(visa_validity_on) DESC, DAY(visa_validity_on) DESC");
                         
                         
                        	 	while($row_visa_expiry=mysqli_fetch_assoc($result_expiry_count)) {
                        	 	

	?>
        <div class="custom-box-1" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                   VISA EXPIRY UPTO <?PHP echo $row_visa_expiry['visa_upto_date'] ?>
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                <?PHP echo $row_visa_expiry['visa_expiry_count'] ?>
            </div>
        </div> 
         <?PHP } ?>
        
	</div>
	<div  class="col-lg-3 col-md-6 col-sm-12"  >   
    
        <div class="custom-box-2" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                  AMC  NEXT MONTH RENEWALS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
                0
            </div>
        </div> 
    
	</div>
</div>




<!--<div class="row" style="padding-top:30px;">-->
<!--    <div  class="col-lg-4 col-md-6 col-sm-12"  >   -->
<!--        <div class="custom-box-3" >-->
<!--            <div class="row" style="padding-bottom: -10px;">-->
<!--                <div  class="col-lg-12 col-md-12 col-sm-12"  >-->
<!--                     QUOTATIONS LAST MONTH GENERATED-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">-->
<!--                152 -->
<!--            </div>-->
<!--        </div> -->
<!--	</div>-->
<!--	<div  class="col-lg-4 col-md-6 col-sm-12"  >   -->
    
<!--        <div class="custom-box-2" >-->
<!--            <div class="row" style="padding-bottom: -10px;">-->
<!--                <div  class="col-lg-12 col-md-12 col-sm-12"  >-->
<!--                    QUOTATIONS LAST WEEK GENERATED-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">-->
<!--                42-->
<!--            </div>-->
<!--        </div> -->
<!--    </div>-->
<!--    <div  class="col-lg-4 col-md-6 col-sm-12"  >   -->
    
<!--        <div class="custom-box-1" >-->
<!--            <div class="row" style="padding-bottom: -10px;">-->
<!--                <div  class="col-lg-12 col-md-12 col-sm-12"  >-->
<!--                   QUOTATIONS  THIS WEEK GENERATED-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">-->
<!--                18-->
<!--            </div>-->
<!--        </div> -->
<!--	</div>-->

<!--</div>-->