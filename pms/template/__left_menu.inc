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
								<li class="nav-item"><a href="building.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=1&title=building');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='1'){ echo 'active';} ?>">Building</a></li>
								<li class="nav-item"><a href="apartment.php?param=<?PHP echo $OBJ->URLEncode('head=master&open=2&title=apartment');?>" class="nav-link <?PHP if(trim($_GET['param'])!=''){ $params = $OBJ->URLDecode(trim($_GET['param']));} if($params['open']=='2' ){ echo 'active';} ?>">Apartment</a></li>
								</ul>
						</li>
					
						
						
					
					
						<!-- /layout -->
							
					</ul>
				</div>