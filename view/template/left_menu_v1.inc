	
				
				
				
				
		    	<!---Old Left Nav without using privilleage pulgin--->	
			
			
			
			
			
			
				
					<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
						<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Coordinator' || $_SESSION['user_type']=='Operation Manager') {?>
						
						 
						
					<li class="nav-item">
							<a href="dashboard.php?wo=m&param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='dashboard'){ echo 'active legitRipple';} ?>">
								<i class="icon-home4"></i>
								<span>	Dashboard	</span>
							</a>
						</li>
						 <?php }?>
						<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Coordinator' || $_SESSION['user_type']=='Operation Manager') {?>
						<li class="nav-item">
							<a href="amc_shedule_calender.php?param=<?PHP echo $OBJ->URLEncode('title=amc_calendar');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='amc_calendar'){ echo 'active legitRipple';} ?>">
								<i class="icon-calendar3"></i>
								<span>	Calendar	</span>
							</a>
					    </li>
				        <?php }?>
						<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='HR Manager' ) {?>	
					<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='hr'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-users"></i> <span>HR Module</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							<li class="nav-item"><a href="expertise.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=2&title=expertise');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2' ){ echo 'active';} ?>">Expertise</a></li>
							<li class="nav-item"><a href="employees.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=1&title=employees');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active';} ?>">Employees</a></li>
							<!--<li class="nav-item"><a href="employee_leave.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=17&title=employee_leave');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='17' ){ echo 'active';} ?>">Employee Leave</a></li>-->
								<li class="nav-item"><a href="employee_report.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=3&title=employees');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3'){ echo 'active';} ?>">Employee List</a></li>
								<li class="nav-item"><a href="employee_expiry.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=18&title=employee_expiry');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='18' ){ echo 'active';} ?>">CPR/Visa Expiry</a></li>
						
						
							
							</ul>
					</li>
					<?php }?>
					<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director'  ) {?>	
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='master'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-target2"></i> <span>Assets & Services Master</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
						
						<li class="nav-item"><a href="location.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=13&title=location');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='13' ){ echo 'active';} ?>">Location / Facilities </a></li>
						<!--	<li class="nav-item"><a href="buildings.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=14&title=buildings');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='14' ){ echo 'active';} ?>">Building Details</a></li>-->
							<li class="nav-item"><a href="category.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=4&title=contract&title1=category');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='4' ){ echo 'active';} ?>">Contract Type / Asset Category</a></li>
							<li class="nav-item"><a href="asset_type.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=5&title=asset_type');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='5' ){ echo 'active';} ?>">Asset Type</a></li>
							<li class="nav-item"><a href="services.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=6&title=services');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='6' ){ echo 'active';} ?>">Services</a></li>
					    
							
							</ul>
					</li>
					<?php }?>
					<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director'  ) {?>
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='customer_master'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-vcard"></i> <span>Customers & Assets</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
						
						
						
						
					    	<li class="nav-item"><a href="customer.php?param=<?PHP echo $OBJ->URLEncode('head=customer_master&open=8&title=customer');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='8' ){ echo 'active';} ?>">Customer</a></li>
							
							
							<li class="nav-item"><a href="customer_asset_details.php?param=<?PHP echo $OBJ->URLEncode('head=customer_master&open=15&title=customer_asset');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='15' ){ echo 'active';} ?>">Customer Facilities </a></li>
							<li class="nav-item"><a href="amc_assets.php?param=<?PHP echo $OBJ->URLEncode('head=customer_master&open=16&title=customer_amc_asset');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='16' ){ echo 'active';} ?>">Customer Assets</a></li>
						
						<li class="nav-item"><a href="customer_directory.php?param=<?PHP echo $OBJ->URLEncode('head=customer_master&open=19&title=customer_directory');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='19' ){ echo 'active';} ?>">Customer Directory</a></li>
						
						
						<li class="nav-item"><a href="asset_tracking.php?param=<?PHP echo $OBJ->URLEncode('head=customer_master&open=20&title=asset_tracking');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='20' ){ echo 'active';} ?>">Track Asset Services</a></li>
						<li class="nav-item"><a href="asset_code_download.php?param=<?PHP echo $OBJ->URLEncode('head=customer_master&open=21&title=asset_download');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='21' ){ echo 'active';} ?>">Download Assets</a></li>
							</ul>
					</li>
					<?php }?>
				<!--<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='complaints'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-hour-glass"></i>
								<span>	Complaint Booking	</span>	</a>
								
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							
							   		
								</ul>
						
							
							
							
						</li>-->	
					<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Coordinator' || $_SESSION['user_type']=='Operation Manager'  ) {?>
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='tickets'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-shutter"></i>
								<span>Work Order Management	</span>	</a>
								
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="tickets.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=1&title=ticket');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Book Work Order </a></li>
							   	<li class="nav-item"><a href="tickets_pending_list.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=2&title=ticket_pending');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">Work Orders - Opened </a></li>
							   	
							   	<li class="nav-item"><a href="tickets_not_assigned.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=6&title=ticket_schedule');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='6'){ echo 'active legitRipple';} ?>">Work Orders - Scheduled </a></li>
							   	<li class="nav-item"><a href="tickets_assigned.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=8&title=ticket_assigned');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='8'){ echo 'active legitRipple';} ?>">Work Orders - Assigned</a></li>
							   		<li class="nav-item"><a href="reschedule_pending_complaints.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=5&title=ticket_reschedule');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='5'){ echo 'active legitRipple';} ?>">Work Orders - Request for extension</a></li>
							   		<li class="nav-item"><a href="tickets_completed.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=7&title=ticket_completed');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='7'){ echo 'active legitRipple';} ?>">Work Orders - Completed</a></li>
									<li class="nav-item"><a href="tickets_closed.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=9&title=ticket_closed');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='9'){ echo 'active legitRipple';} ?>">Work Orders - Closed</a></li>
									<li class="nav-item"><a href="tickets_cancelled.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=10&title=ticket_cancelled');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='10'){ echo 'active legitRipple';} ?>">Work Orders - Cancelled</a></li>
									<li class="nav-item"><a href="tickets_escalated.php?param=<?PHP  echo $OBJ->URLEncode('head=tickets&open=11&title=ticket_escalated');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='11'){ echo 'active legitRipple';} ?>">Work Orders - Escalated</a></li>
							   		 
								</ul>
						
							
							
							
						</li>	
						<?php }?>
						<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Coordinator' || $_SESSION['user_type']=='Operation Manager'  ) {?>
							<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='daily_reports'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-hour-glass"></i>
								<span>	Work Order Reports	</span>	</a>
								
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="tickets_search.php?param=<?PHP  echo $OBJ->URLEncode('head=daily_reports&open=4&title=ticket_scheduled');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='4'){ echo 'active legitRipple';} ?>">Work Orders </a></li>
								<li class="nav-item"><a href="track_complaints.php?param=<?PHP  echo $OBJ->URLEncode('head=daily_reports&open=3&title=ticket_track');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3'){ echo 'active legitRipple';} ?>">Track Work Order</a></li>
								<li class="nav-item"><a href="daily_team_report.php?param=<?PHP  echo $OBJ->URLEncode('head=daily_reports&open=1&title=team_report');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Daily Team Report</a></li>
							   	<li class="nav-item"><a href="daily_activity_log.php?param=<?PHP  echo $OBJ->URLEncode('head=daily_reports&open=2&title=activity_log');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">Daily Activity Log</a></li>
							   
							   	
								</ul>
						
							
						</li>	
					<!--	<li class="nav-item">
							<a href="asset_tracking.php?param=<?PHP echo $OBJ->URLEncode('title=asset_tracking');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='asset_tracking'){ echo 'active legitRipple';} ?>">
								<i class="icon-puzzle"></i>
								<span>	Track Asset Services </span>
							</a>
					</li>-->	
					<?php }?>
						<!--<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Manager'  ) {?>
						<li class="nav-item">
							<a href="asset_code_download.php?param=<?PHP echo $OBJ->URLEncode('title=asset_download');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='asset_download'){ echo 'active legitRipple';} ?>">
								<i class="icon-file-download2"></i>
								<span>	Download Assets </span>
							</a>
					    </li>
					    <?php }?>-->
					    	<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Coordinator' || $_SESSION['user_type']=='Operation Manager'  ) {?>
							<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='amc'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-calculator3"></i>
								<span>	AMC	</span>	</a>
								
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="subcontractors.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=3&title=amc');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3'){ echo 'active legitRipple';} ?>"> Subcontractors </a></li>
							    <li class="nav-item"><a href="amc.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=1&title=amc');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>"> Book AMC </a></li>
    						
    							
							    
							   
							  
						
							      	<li class="nav-item"><a href="search_amc.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=2&title=amc_list');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">Search AMC</a></li>
							   <!--  <li class="nav-item"><a href="amc_schedule_assets.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=4&title=asset_schedule');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='4'){ echo 'active legitRipple';} ?>">Schedule AMC Assets </a></li>-->
							      <li class="nav-item"><a href="amc_schedule.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=5&title=asset_schedule1');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='5'){ echo 'active legitRipple';} ?>">Schedule AMC WO</a></li>
							    <li class="nav-item"><a href="amc_services.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=7&title=amc_services');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='7'){ echo 'active legitRipple';} ?>">Assign Services to AMC WO</a></li>
							    <li class="nav-item"><a href="amc_assign_team.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=6&title=amc_assign');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='6'){ echo 'active legitRipple';} ?>">Assign Technician to AMC WO</a></li>
							    
							     <li class="nav-item"><a href="amc_reschedule.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=11&title=amc_extend_list');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='11'){ echo 'active legitRipple';} ?>">Request to Reschedule WO</a></li>
							      <li class="nav-item"><a href="amc_completed.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=9&title=amc_completed_list');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='9'){ echo 'active legitRipple';} ?>">Completed AMC WO</a></li>
							      <li class="nav-item"><a href="amc_closed.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=10&title=amc_closed_list');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='10'){ echo 'active legitRipple';} ?>">Closed AMC WO</a></li> 
								</ul>
						
							
							
							 
						</li>
						<?php }?>
						<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Operation Manager'  ) {?>
					    <li class="nav-item">
							<a href="amc_renewal.php?param=<?PHP echo $OBJ->URLEncode('title=amc_renewal');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='amc_renewal'){ echo 'active legitRipple';} ?>">
								<i class="icon-folder-open3"></i>
								<span>	AMC Renewal </span>
							</a>
					    </li>
					    <?php }?>
					    <!-- <li class="nav-item">
							<a href="amc_payment.php?param=<?PHP echo $OBJ->URLEncode('title=amc_payment');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='amc_payment'){ echo 'active legitRipple';} ?>">
								<i class="icon-calculator4"></i>
								<span>	AMC Payment </span>
							</a>
					    </li> -->
					    <!--	<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='pdt_master'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-shield2"></i> <span>Products & Vendors</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
						
							<li class="nav-item"><a href="product_category.php?param=<?PHP echo $OBJ->URLEncode('head=pdt_master&open=9&title=product_category&title1=product_type');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='9' ){ echo 'active';} ?>">Product Category / Type</a></li>
							<li class="nav-item"><a href="product_item.php?param=<?PHP echo $OBJ->URLEncode('head=pdt_master&open=10&title=product_item&title1=product_item');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='10' ){ echo 'active';} ?>">Product Item</a></li>
							
							<li class="nav-item"><a href="product_master.php?param=<?PHP echo $OBJ->URLEncode('head=pdt_master&open=11&title=product_master&title1=product_master');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='11' ){ echo 'active';} ?>">Product Master</a></li>
							<li class="nav-item"><a href="vendor_master.php?param=<?PHP echo $OBJ->URLEncode('head=pdt_master&open=12&title=vendor_master');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='12' ){ echo 'active';} ?>">Vendor Details</a></li>
						
							
							</ul>
					</li> -->
					<?php if($_SESSION['user_type']=='Administrator' || $_SESSION['user_type']=='Director' || $_SESSION['user_type']=='Sales Manager'  ) {?>
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='requisition'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-folder-plus2"></i>
								<span>Material Requisition	</span>	</a>
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="requisition.php?param=<?PHP  echo $OBJ->URLEncode('head=requisition&open=1&title=add_requisition');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Create Requisition</a></li>
							   	<li class="nav-item"><a href="requisition_list.php?param=<?PHP  echo $OBJ->URLEncode('head=requisition&open=2&title=view_requisition');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">View Requisition</a></li>
								
							   	</ul>
							
						
						</li>
						
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='feedback'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-comments"></i>
								<span>Customer Feedback</span>	</a>
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="feedback_questions.php?param=<?PHP  echo $OBJ->URLEncode('head=feedback&open=1&title=view_log');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Questions</a></li>
							    <li class="nav-item"><a href="feedback_report.php?param=<?PHP  echo $OBJ->URLEncode('head=feedback&open=2&title=feedback');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">Feedback</a></li>
							   	</ul>
							
						
						</li> 
						
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='log'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-spinner9"></i>
								<span>Logs</span>	</a>
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="admin_log.php?param=<?PHP  echo $OBJ->URLEncode('head=log&open=1&title=view_log');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Login & Logout</a></li>
								<li class="nav-item"><a href="amc_event_log.php?param=<?PHP  echo $OBJ->URLEncode('head=log&open=2&title=view_log');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">AMC</a></li>
								
							   
							   	</ul>
							
						
						</li> 
						 <!--<li class="nav-item">
							<a href="admin_log.php?param=<?PHP echo $OBJ->URLEncode('title=admin_log');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='admin_log'){ echo 'active legitRipple';} ?>">
								<i class="icon-folder-open3"></i>
								<span>	LOG </span>
							</a>
					    </li>-->
						<?php }?>
					<!--	<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='quotation'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-stack3"></i>
								<span>	Quotation	</span>	</a>
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="quotation.php?param=<?PHP  echo $OBJ->URLEncode('head=quotation&open=1&title=add_quotation');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Create Quotation</a></li>
							   	<li class="nav-item"><a href="quotation_list.php?param=<?PHP  echo $OBJ->URLEncode('head=quotation&open=2&title=view_quotation');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">View Quotation</a></li>
							   	<li class="nav-item"><a href="quotation_rivision.php?param=<?PHP  echo $OBJ->URLEncode('head=quotation&open=3&title=view_quotation_rivision');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3'){ echo 'active legitRipple';} ?>">View Quotation Revision</a></li>
							   
							   	</ul>
						
						</li>
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='localpo'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-clipboard3"></i>
								<span>	Local PO	</span>	</a>
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="localpo.php?param=<?PHP  echo $OBJ->URLEncode('head=localpo&open=1&title=add_localpo');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">Create Local PO</a></li>
							   	<li class="nav-item"><a href="localpo_list.php?param=<?PHP  echo $OBJ->URLEncode('head=localpo&open=2&title=view_localpo');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">View Local PO</a></li>
							   	</ul>
						
						</li> -->
						
					
					    	
						<!-- /layout -->
							
					</ul>
				</div>