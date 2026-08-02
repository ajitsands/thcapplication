	<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
					<!--	<li class="nav-item">
							<a href="dashboard.php?param=<?PHP echo $OBJ->URLEncode('title=dashboard');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['title']=='dashboard'){ echo 'active legitRipple';} ?>">
								<i class="icon-home4"></i>
								<span>	Dashboard	</span>
							</a>
						</li>-->
					
				<?php if($_SESSION["user_type"]=='Administrator')
				{
				?>
						
					<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='hr'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-users"></i> <span>HR & Project</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							<li class="nav-item"><a href="expertise.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=2&title=expertise');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2' ){ echo 'active';} ?>">Expertise</a></li>
							<li class="nav-item"><a href="employees.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=1&title=employees');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active';} ?>">Employees</a></li>
							<li class="nav-item"><a href="projects.php?param=<?PHP echo $OBJ->URLEncode('head=hr&open=3&title=projects');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='3' ){ echo 'active';} ?>">Projects</a></li>
						
							
							
							</ul>
					</li>
					<?php }?>
				
						<li class="nav-item nav-item-submenu <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['head']=='project'){ echo 'legitRipple nav-item-expanded nav-item-open';} ?>">
					
							<a href="#" class="nav-link"><i class="icon-hour-glass2"></i> <span>Project Management</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							<li class="nav-item"><a href="project_entries.php?param=<?PHP echo $OBJ->URLEncode('head=project&open=2&title=project_entries');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2' ){ echo 'active';} ?>">Add Entries</a></li>
							<li class="nav-item"><a href="project_reports.php?param=<?PHP echo $OBJ->URLEncode('head=project&open=1&title=project_reports');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active';} ?>"><?php if($_SESSION["user_type"]=='Administrator')
				{ ?>Report<?php } else {?>Histroy <?php }?></a></li>
								
							
							</ul>
					</li>
					
						
					
						
				
					
					
					
						
					
					    	
						<!-- /layout -->
							
					</ul>
				</div>