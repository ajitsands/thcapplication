<?PHP 
                            include_once(__DIR__ . '/../../model/db_connection/connection.php');
                            $DBConn = new DBConnection();
                            $varDBConnection = $DBConn->ConnectToMYSQL();
                         	$result = mysqli_query($varDBConnection,"Select count(amc_visit_id) as visit_count from  tbl_visits where  (DATE_FORMAT(date_of_visits,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')) and amc_visit_status !='Cancelled'");
                         
                         
                        	 	while($row=mysqli_fetch_assoc($result)) {
                       
?>

<div class="row" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:15px;font-weight:bold;">
                DASHBOARD
</div>
<div class="row">
    <div  class="col-lg-3 col-md-6 col-sm-12"  >   
        <div class="custom-box" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     TODAY'S VISITS
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
               <?PHP echo $row['visit_count'];?>
            </div>
        </div> 
	</div>
	<?PHP }
	$result = mysqli_query($varDBConnection,"Select count(amc_visit_id) as visit_closed_count from  tbl_visits where  (DATE_FORMAT(date_of_visits,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')) and amc_visit_status ='Closed'");
                         
                         
                        	 	while($row=mysqli_fetch_assoc($result)) {
	
	?>
	
	<div  class="col-lg-3 col-md-6 col-sm-12"  >   
    
        <div class="custom-box-1" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     TODAY'S CLOSED
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
               <?PHP echo $row['visit_closed_count'];?>
            </div>
        </div> 
    
	</div>
	
	<?PHP } 
		$result = mysqli_query($varDBConnection,"Select count(amc_visit_id) as visit_completed_count from  tbl_visits where  (DATE_FORMAT(date_of_visits,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')) and amc_visit_status ='Completed'");
                         
                         
                        	 	while($row=mysqli_fetch_assoc($result)) {
	
	?>
	<div  class="col-lg-3 col-md-6 col-sm-12"  >   
        <div class="custom-box-2" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     TODAY'S COMPLETED
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
               <?PHP echo $row['visit_completed_count'];?>
            </div>
        </div> 
    
    
    
	</div>
	<?PHP } 
		$result = mysqli_query($varDBConnection,"Select count(amc_visit_id) as visit_pending_count from  tbl_visits where  (DATE_FORMAT(date_of_visits,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')) and (amc_visit_status ='Assigned' or amc_visit_status ='Scheduled')");
                         
                         
                        	 	while($row=mysqli_fetch_assoc($result)) {
	
	?>
	
	
	<div  class="col-lg-3 col-md-6 col-sm-12"  >   
        <div class="custom-box-3" >
            <div class="row" style="padding-bottom: -10px;">
                <div  class="col-lg-12 col-md-12 col-sm-12"  >
                     TODAY'S PENDING
                </div>
            </div>
            <div class="row float-right" style="margin-top:-10px;margin-right:10px;padding:10px;font-size:40px;font-weight:bold;">
               <?PHP echo $row['visit_pending_count'];?>
            </div>
        </div> 
	</div>
</div>

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