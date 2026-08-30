
			<div class="navbar navbar-expand-lg navbar-light" >
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text"><font color="white">
						&copy; <?PHP echo date('Y');?> - <?PHP echo date('Y', strtotime('+1 year'));?>. </font><a href="#" style="color: white;"><i>Designed & Developed By    </i></a>  <a href="http://www.syskodetechnologies.com" target="_blank" style="color: white;"><i>Syskode Technologies</i></a>
					</span>

					<ul class="navbar-nav ml-lg-auto">
					<!--	<li class="nav-item"><a href="" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
						<li class="nav-item"><a href="" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
						<li class="nav-item"><a href="" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li> -->
					</ul>
				</div>
			</div>
            <?php
                $currentPage = basename($_SERVER['PHP_SELF']);
                if ($currentPage !== 'login.php') 
                {
            ?>
			<script src="user_permission/js/settings.js?timestamp=<?php echo time(); ?>"></script>
			<script src="user_permission/js/permission.js?timestamp=<?php echo time(); ?>"></script>
            <script src="user_permission/js/validations.js?timestamp=<?php echo time(); ?>"></script>
            <script type="text/javascript" src="user_permission/js/messagedropdown.js?timestamp=<?php echo time(); ?>"></script>
            <?php
                   include_once('datatable_setting.php');
                }
            ?>