	<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item">
							<a href="index.php?param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='dashboard'){ echo 'active legitRipple';} ?>">
								<i class="icon-home4"></i>
								<span>	Dashboard	</span>
							</a>
						</li>
						
						
					
					<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='master'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Master</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							<li class="nav-item"><a href="employees.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=1&title=employees');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active';} ?>">Employees</a></li>
							<li class="nav-item"><a href="expertise.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=2&title=expertise');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2' ){ echo 'active';} ?>">Expertise</a></li>
						<!--	<li class="nav-item"><a href="teams.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=3&title=teams');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3' ){ echo 'active';} ?>">Team Details</a></li>-->
							<li class="nav-item"><a href="category.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=4&title=contract&title1=category');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='4' ){ echo 'active';} ?>">Contract Type / Asset Category</a></li>
							
							<li class="nav-item"><a href="asset_type.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=5&title=asset_type');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='5' ){ echo 'active';} ?>">Asset Type</a></li>
							<li class="nav-item"><a href="services.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=6&title=services');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='6' ){ echo 'active';} ?>">Services</a></li>
					    	<li class="nav-item"><a href="customer.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=8&title=customer');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='8' ){ echo 'active';} ?>">Customer</a></li>
							<li class="nav-item"><a href="product_category.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=9&title=product_category&title1=product_type');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='9' ){ echo 'active';} ?>">Product Category / Type</a></li>
							<li class="nav-item"><a href="product_item.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=10&title=product_item&title1=product_item');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='10' ){ echo 'active';} ?>">Product Item</a></li>
							
							<li class="nav-item"><a href="product_master.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=11&title=product_master&title1=product_master');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='11' ){ echo 'active';} ?>">Product Master</a></li>
							<li class="nav-item"><a href="vendor_master.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=12&title=vendor_master');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='12' ){ echo 'active';} ?>">Vendor Details</a></li>
							<li class="nav-item"><a href="location.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=13&title=location');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='13' ){ echo 'active';} ?>">Location Details</a></li>
							<li class="nav-item"><a href="customer_asset_details.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=14&title=customer_asset');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='14' ){ echo 'active';} ?>">Customer Building Details</a></li>
							
							</ul>
					</li>
					<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='amc'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
							<a href="#" class="nav-link ">
								<i class="icon-calculator3"></i>
								<span>	AMC	</span>	</a>
								
								<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="amc.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=1&title=amc');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active legitRipple';} ?>">AMC Creation</a></li>
							    <li class="nav-item"><a href="amc_list_details.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=2&title=amc_list');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2'){ echo 'active legitRipple';} ?>">Cancelled/Completed List</a></li>
							   <!--<li class="nav-item"><a href="amc_shedule_calender.php?param=<?PHP  echo $OBJ->URLEncode('head=amc&open=3&title=amc_calendar');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3'){ echo 'active legitRipple';} ?>">AMC Calendar</a></li>-->
							   
								</ul>
						
							
							
							
						</li>
						
						
					
					
						<!-- /layout -->
							
					</ul>
				</div>