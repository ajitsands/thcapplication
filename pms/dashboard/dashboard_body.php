<?PHP 
    include_once "../model/db_connection/connection.php" ;
    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
    
    $result_wo_today = mysqli_query($varDBConnection,"SELECT count(`amc_visit_id`) as wo_today FROM `tbl_visits` WHERE `date_of_visits`=DATE_FORMAT(now(),'%Y-%m-%d') and amc_visit_status !='Cancelled'");
    while($row_wo_today=mysqli_fetch_assoc($result_wo_today)) {
        $wo_today_count=$row_wo_today["wo_today"];
    }                     
    $result_wo_today_hp = mysqli_query($varDBConnection,"SELECT count(`amc_visit_id`) as wo_today_hp FROM `tbl_visits` WHERE `date_of_visits`=DATE_FORMAT(now(),'%Y-%m-%d') and amc_visit_status !='Cancelled' and amc_tkt_id in (select ticket_id from tbl_tickets where ticket_priority='Emergency')");
    while($row_wo_today_hp=mysqli_fetch_assoc($result_wo_today_hp)) {
        $wo_today_hp_count=$row_wo_today_hp["wo_today_hp"];
    }  
                         
    $result_raised_wo_emergency = mysqli_query($varDBConnection,"select count(ticket_id) as emergency_wo_count from tbl_tickets where    ticket_status='Opened' and ticket_priority='Emergency'");
     while($row_raised_wo_emergency=mysqli_fetch_assoc($result_raised_wo_emergency)) {
        $wo_raised_wo_emergency=$row_raised_wo_emergency["emergency_wo_count"];
    } 
    $result_raised_wo_urgent = mysqli_query($varDBConnection,"select count(ticket_id) as urgent_wo_count from tbl_tickets where    ticket_status='Opened' and ticket_priority='Urgent'");
     while($row_raised_wo_urgent=mysqli_fetch_assoc($result_raised_wo_urgent)) {
        $wo_raised_wo_urgent=$row_raised_wo_urgent["urgent_wo_count"];
    } 
    $result_raised_wo_normal = mysqli_query($varDBConnection,"select count(ticket_id) as normal_wo_count from tbl_tickets where    ticket_status='Opened' and ticket_priority not in ('Emergency','Urgent')");
     while($row_raised_wo_normal=mysqli_fetch_assoc($result_raised_wo_normal)) {
        $wo_raised_wo_normal=$row_raised_wo_normal["normal_wo_count"];
    } 
    $result_cpr_expired = mysqli_query($varDBConnection,"select count(employee_id) as cpr_expiry_nos from tbl_employees where    employee_status='Active' and `cpr_expiry_date`!='0000-00-00' and `cpr_expiry_date` < DATE_FORMAT(now(),'%Y-%m-%d')");
     while($row_cpr_expired=mysqli_fetch_assoc($result_cpr_expired)) {
        $cpr_expiry_nos=$row_cpr_expired["cpr_expiry_nos"];
    } 
    $result_visa_expired = mysqli_query($varDBConnection,"select count(employee_id) as visa_expiry_nos from tbl_employees where    employee_status='Active' and `visa_validity_on`!='0000-00-00' and `visa_validity_on` < DATE_FORMAT(now(),'%Y-%m-%d')");
     while($row_visa_expired=mysqli_fetch_assoc($result_visa_expired)) {
        $visa_expiry_nos=$row_visa_expired["visa_expiry_nos"];
    } 
    $result_amc_renewals_count = mysqli_query($varDBConnection,"select count(amc_id) as amc_renewal_count from tbl_amc_master where    amc_status='Active' and  DATE_FORMAT(amc_end_date,'%Y-%m-%d') < DATE_FORMAT(date_add(now(), interval 1 month),'%Y-%m-%d')");
     while($row_amc_renewals_count=mysqli_fetch_assoc($result_amc_renewals_count)) {
        $amc_renewals_count=$row_amc_renewals_count["amc_renewal_count"];
    }
    $result_amc_renewals_date = mysqli_query($varDBConnection,"select DATE_FORMAT(date_add(now(), interval 1 month),'%d-%m-%Y') as amc_renewal_upto");
     while($row_amc_renewals_date=mysqli_fetch_assoc($result_amc_renewals_date)) {
        $amc_renewals_date=$row_amc_renewals_date["amc_renewal_upto"];
    }
    $result_opened_wo_today = mysqli_query($varDBConnection,"select count(ticket_id) as today_wo_opened from tbl_tickets where    ticket_status='Opened' and DATE_FORMAT(created_date_time,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')");
     while($row_opened_wo_today=mysqli_fetch_assoc($result_opened_wo_today)) {
        $wo_opened_today=$row_opened_wo_today["today_wo_opened"];
    } 
     $result_closed_wo_today = mysqli_query($varDBConnection,"select count(ticket_id) as today_wo_closed from tbl_tickets where    ticket_status='Closed' and DATE_FORMAT(closed_on,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')");
     while($row_closed_wo_today=mysqli_fetch_assoc($result_closed_wo_today)) {
        $wo_closed_today=$row_closed_wo_today["today_wo_closed"];
    } 
     $result_pending_wo_today = mysqli_query($varDBConnection,"select count(amc_visit_id) as today_wo_pending from tbl_visits where    amc_visit_status not in ('Closed','Opened','Cancelled') and `date_of_visits` = DATE_FORMAT(now(),'%Y-%m-%d')");
     while($row_pending_wo_today=mysqli_fetch_assoc($result_pending_wo_today)) {
        $wo_pending_today=$row_pending_wo_today["today_wo_pending"];
    } 
    
    
     $result_graph_month_year = mysqli_query($varDBConnection,"select DATE_FORMAT(now(),'%M') as graph_month,DATE_FORMAT(now(),'%Y') as graph_year");
     while($row_graph_month_year=mysqli_fetch_assoc($result_graph_month_year)) {
        $graph_month=$row_graph_month_year["graph_month"];
        $graph_year=$row_graph_month_year["graph_year"];
    }
?>

<div class="content">

				<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4> <span class="font-weight-semibold">Dashboard</span> </h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<!--<a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>-->
							<!--<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>-->
							<a target="_blank" href="amc_shedule_calender.php?param=<?PHP echo $OBJ->URLEncode('title=amc_calendar');?>" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Calender</span></a>
						</div>
					</div>
				</div>
				</div>
				<br>

				<div class="row">
					<div class="col-sm-6 col-xl-3">

						<!-- Satisfaction rate -->
						<div class="card card-body text-center">
						    
							<div class="mr-3 align-self-center">
									<i class="icon-bag icon-3x text-success-400"></i>
								</div>

							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><?php echo $wo_today_count;?></h2>

						Work Orders Today
							
						</div>
						<!-- /satisfaction rate -->
						<div class="card card-body text-center">
						<div class="mr-3 align-self-center">
									<i class="icon-enter6 icon-3x text-danger-400"></i>
									
								</div>
							
									
			                	
							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><?php echo $wo_today_hp_count;?></h2>

							High Priority Work Orders
							
						</div>

					</div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
							<div class="card-header header-elements-inline" style="height:8px">
								<h6 class="card-title">&nbsp;&nbsp;</h6>
								<div class="header-elements">
								
									<div class="list-icons ml-3">
									    <div class="btn-group ml-1">
			                    	<button type="button" class="btn btn-outline bg-purple-300 text-purple-800 btn-icon dropdown-toggle" data-toggle="dropdown">
				                    	<i class="icon-link"></i>
			                    	</button>

			                    	<div class="dropdown-menu dropdown-menu-right">
										<a href="#" class="dropdown-item" id="a_today"><i class="icon-menu7" ></i>Today</a>
										<a href="#" class="dropdown-item" id="a_this_week"><i class="icon-screen-full" ></i>This Week</a>
										<a href="#" class="dropdown-item" id="a_this_month"><i class="icon-screen-full" ></i>This Month</a>
										<a href="#" class="dropdown-item" id="a_this_year"><i class="icon-screen-full"></i>This Year</a>
										
									</div>
								</div>
				      
				                	</div>
								</div>
							</div>

							<div class="card-body">
								<div class="chart mb-3" id="bullets"></div>

								<ul class="media-list">
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-alignment-unalign"></i></a>
										</div>
										
										<div class="media-body text-center">
										    Opened Work Orders 
										    <h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><span id="span_open_wo" class="font-weight-semibold text-primary"><?php echo $wo_opened_today;?></span>&nbsp;<span class="font-size-sm text-muted span_select">Today </span></h2>
										    	
											
										</div>

										
									</li>
									<hr>
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i class="icon-checkmark3"></i></a>
										</div>
										
										<div class="media-body text-center">
										    Closed Work Orders 
										    <h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><span id="span_close_wo" class="font-weight-semibold text-success"><?php echo $wo_closed_today;?></span>&nbsp;<span class="font-size-sm text-muted span_select">Today </span></h2>
											
										</div>

										
									</li>
										<hr>
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-pink text-pink rounded-round border-2 btn-icon"><i class="icon-statistics"></i></a>
										</div>
										
										<div class="media-body text-center">
										    Pending Work Orders 
										    <h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><span id="span_pending_wo" class="font-weight-semibold text-pink"><?php  echo $wo_pending_today;?></span>&nbsp;<span class="font-size-sm text-muted span_select">Today </span></h2>
											
										</div>

										
									</li>

								

								</ul>
							</div>
						</div>
</div>
				<div class="col-sm-6 col-xl-6">

						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">Raised Work Orders</h6>
								<div class="header-elements">
									
									<span class="badge bg-danger-400 badge-pill" data-placement="bottom" data-popup="tooltip" title="Emergency Work Orders"><?php echo $wo_raised_wo_emergency;?></span>
									&nbsp;&nbsp;
									<span class="badge bg-warning-400 badge-pill" data-placement="bottom" data-popup="tooltip" title="Urgent Work Orders"><?php echo $wo_raised_wo_urgent;?></span>
									&nbsp;&nbsp;
									<span class="badge bg-primary-400 badge-pill" data-placement="bottom" data-popup="tooltip" title="Normal Work Orders"><?php echo $wo_raised_wo_normal;?></span>
									&nbsp;&nbsp;
									<a href="tickets_pending_list.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=2&title=ticket_pending');?>"><button type="button" class="btn btn-info btn-icon" data-placement="bottom" data-popup="tooltip" title="View All"><i class="icon-link"></i></button></a>
								</div>
							</div>

							<div class="card-body">
								<div class="chart mb-3" id="bullets"></div>

								<ul class="media-list">
							<?php	    
							$result_raised_wo = mysqli_query($varDBConnection,"select concat('WO-',ticket_ref_code,'-',ticket_id) as wo_ref_nos,DATE_FORMAT(created_date_time,'%d/%m/%Y %H:%i:%s') as created_date_time1,concat(customer_code,' - ',customer_name) as customers,complaints_description,ticket_priority from tbl_tickets where    ticket_status='Opened' order by ticket_id desc limit 4");
							 $rowcount = mysqli_num_rows($result_raised_wo);
							 if($rowcount==0)
							 { ?>
							     <li class="media">
										<div class="media-body">
										<span class="font-weight-semibold ">No Raised Work Orders Found...</span> 
										</div>
									</li>
						    <?php }
						else
						{
                            while($row_raised_wo=mysqli_fetch_assoc($result_raised_wo)) { 
                              
                           ?>
                                 <li class="media">
										<div class="media-body">
										<span class="font-weight-semibold text-info"> <?php echo $row_raised_wo['wo_ref_nos'];?> </span><span class="font-weight-semibold ">  <?php echo $row_raised_wo['customers'];?></span> 
										<div ><?php echo $row_raised_wo['complaints_description'];?></div>
											<div class="text-muted"><?php echo $row_raised_wo['created_date_time1'];?></div>
										</div>

										<div class="ml-3 align-self-center">
										    <?php switch($row_raised_wo['ticket_priority'])
										   {
										        case 'Emergency':
										            
										  ?>
										  <span class="badge bg-danger-400">Emergency</span>
										  <?php break;
										        case 'Urgent':
										  ?>
										  <span class="badge bg-warning-400">Urgent</span>
										  <?php break;
										        default:
										  ?>
										  <span class="badge bg-primary-400">Normal</span>
										  <?php break;
										    } //Close of switch?>
											
										</div>
									</li>
                           <?php
                             } //Close of while 
                            
                            } //Close of Else
                            ?>
								

								
								
								</ul>
							</div>
						</div>

					</div>
                    <div class="col-sm-6 col-xl-3">

						<!-- Basic animated pie -->
						<div class="card card-body text-center" style="height:320px" id="pie_card">
							<div class="svg-center" id="pie_basic"></div>

							<span class="font-weight-semibold " id="graph_title"><?php echo $graph_month;?> <?php echo $graph_year;?></span>
							<!--<div class="font-size-sm text-muted">120</div>-->
							<br>
							<div class="row">
							    <div class="col-sm-6 col-xl-6">
                               
									<select id="select_month" class="form-control select select_month" data-fouc >
											<option value="0" disabled selected>Month</option>
											<option value="01">January</option>
											<option value="02">February</option>
											<option value="03">March</option>
											<option value="04">April</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">August</option>
											<option value="09">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										
									</select>
								
								</div>
								<div class="col-sm-6 col-xl-6">
                                    <select id="select_year" class="form-control select select_year" data-fouc >
											<option value="0" disabled selected>Year</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
											<option value="2024">2024</option>
											<option value="2025">2025</option>
											<option value="2026">2026</option>
											<option value="2027">2027</option>
											<option value="2028">2028</option>
											<option value="2029">2029</option>
											<option value="2030">2030</option>
											<option value="2031">2031</option>
											<option value="2032">2032</option>
											<option value="2033">2033</option>
											<option value="2034">2034</option>
											<option value="2035">2035</option>
											<option value="2036">2036</option>
											<option value="2037">2037</option>
											<option value="2038">2038</option>
											<option value="2039">2039</option>
											<option value="2040">2040</option>
										
									</select>
							   
								</div>
							    </div>
							   
						</div>
						<!-- /basic animated pie -->

					</div>
				<div class="col-sm-6 col-xl-3">
				    <div class="card">
				    <div class="card-header header-elements-inline">
								<h6 class="card-title">CPR Expired</h6>
								<div class="header-elements">
									
									<a  href="employee_expiry.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=18&title=employee_expiry');?>"><button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button></a>
								</div>
							</div>
						<div class=" card-body">
							<div class="media">
								<div class="mr-3 align-self-center">
									<i class="icon-pointer icon-3x text-pink-400"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="font-weight-semibold mb-0"><?php echo $cpr_expiry_nos;?></h3>
									<span class="font-size-sm text-muted">Nos </span>
								</div>
							</div>
						</div>
						</div>
						<div class="card">
				            <div class="card-header header-elements-inline">
								<h6 class="card-title">Visa Expired</h6>
								<div class="header-elements">
									
								<a  href="employee_expiry.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=18&title=employee_expiry');?>"><button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button></a>
								</div>
							</div>
						<div class=" card-body">
							<div class="media">
								<div class="mr-3 align-self-center">
									<i class="icon-point-up icon-3x text-danger-400"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="font-weight-semibold mb-0"><?php echo $visa_expiry_nos;?></h3>
									<span class="font-size-sm text-muted">Nos </span>
								</div>
							</div>
						</div>
						</div>
					</div>

						<div class="col-sm-6 col-xl-6">

						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">AMC Renewal Requests Upto<?php echo $amc_renewals_date; ?></h6>
								<div class="header-elements">
									
									<span data-placement="bottom" data-popup="tooltip" title="Total AMC Renewal Requests" class="badge bg-danger-400 badge-pill"><?php echo $amc_renewals_count;?></span>
									&nbsp;&nbsp;
									<a href="amc_renewal.php?param=<?PHP echo $OBJ->URLEncode('title=amc_renewal');?>"><button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button></a>
								</div>
							</div>

							<div class="card-body">
								<div class="chart mb-3" id="bullets"></div>

								<ul class="media-list">
								    
								    <?php	    
							$result_amc_renewals = mysqli_query($varDBConnection,"select contract_type_name,amc_ref_no,concat(customer_code,' - ',customer_name) as customers,concat(DATE_FORMAT(amc_start_date,'%d/%m/%Y'),'  - ',DATE_FORMAT(amc_end_date,'%d/%m/%Y')) as amc_dates,DATEDIFF(amc_end_date,now()) as expiry_days from tbl_amc_master where    amc_status='Active' and  DATE_FORMAT(amc_end_date,'%Y-%m-%d') < DATE_FORMAT(date_add(now(), interval 1 month),'%Y-%m-%d')order by YEAR(amc_end_date) DESC, MONTH(amc_end_date) DESC, DAY(amc_end_date) desc limit 4");
							 $rowcount_amc_renewals = mysqli_num_rows($result_amc_renewals);
							 if($rowcount_amc_renewals==0)
							 { ?>
							     <li class="media">
										<div class="media-body">
										<span class="font-weight-semibold ">No  AMC Renewal Requests Found...</span> 
										</div>
									</li>
						    <?php }
						else
						{
                            while($row_amc_renewals=mysqli_fetch_assoc($result_amc_renewals)) { 
                              
                           ?>
                                 <li class="media">
										<div class="media-body">
										<span class="font-weight-semibold text-info"> <?php echo $row_amc_renewals['amc_ref_no'];?> </span><span class="font-weight-semibold ">  <?php echo $row_amc_renewals['customers'];?></span> 
										<div ><?php echo $row_amc_renewals['contract_type_name'];?></div>
											<div class="text-muted"><?php echo $row_amc_renewals['amc_dates'];?></div>
										</div>

										<div class="ml-3 align-self-center">
										 
										 <?php if($row_amc_renewals['expiry_days']<=0)
										 { ?>
										  <span class="badge bg-danger-400"><?php echo 'Expired '. abs($row_amc_renewals['expiry_days']).' days before';?></span>
										 <?php } 
										 else{?>
										  <span class="badge bg-info-400"><?php echo 'Expire in '. $row_amc_renewals['expiry_days'].' days';?></span>
										 <?php }?>
										
										 
										   
										</div>
									</li>
                           <?php
                             } //Close of while 
                            
                            } //Close of Else
                            ?>
								

								

									
								</ul>
							</div>
						</div>

					</div>
				</div>

		
			</div>