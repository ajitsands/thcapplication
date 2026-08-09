
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?PHP 
		include_once('template/head.inc');
	
	?>
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	
	<script src="assets/js/extra_jgrowl_noty.js"></script>
    <script src="assets/js/jgrowl.min.js"></script>
	<script src="assets/js/noty.min.js"></script>
	
	<!--<script src="global_assets/js/plugins/notifications/pnotify.min.js"></script>-->
	<!-- sweet alert -->
	 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	 
	<script src="../httpdocs/user_js/login_customer.js"></script>
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
</head>
        <script type="text/javascript">  
        // datetime make using jquery  
        $(document)  
            .ready(function ()  
            {  
                ShowTime();  
            });  
  
        function ShowTime()  
        {  
            var dt = new Date();  
            document.getElementById("div_date_time")  
                .innerHTML = dt.toLocaleTimeString();  
            window.setTimeout("ShowTime()", 1000); // Here 1000(milliseconds) means one 1 Sec  
        }  
        </script>  
        <script>  
        // date time make only javascript  
        function startTime()  
        {  
            var today = new Date();  
            var h = today.getHours();  
            var m = today.getMinutes();  
            var s = today.getSeconds();  
            var d = new Date();  
            var n = d.getDate();  
            var month = new Array();  
            month[0] = "January";  
            month[1] = "February";  
            month[2] = "March";  
            month[3] = "April";  
            month[4] = "May";  
            month[5] = "June";  
            month[6] = "July";  
            month[7] = "August";  
            month[8] = "September";  
            month[9] = "October";  
            month[10] = "November";  
            month[11] = "December";  
            var t = month[d.getMonth()];  
            var y = d.getFullYear();  
            m = checkTime(m);  
            s = checkTime(s);  
            document.getElementById('div_date_time')  
                .innerHTML = n + "-" + t + "-" + y + " " + h + ":" + m + ":" + s;  
            var t = setTimeout(function ()  
            {  
                startTime()  
            }, 500);  
        }  
  
        function checkTime(i)  
        {  
            if(i < 10)  
            {  
                i = "0" + i  
            }; // add zero in front of numbers < 10  
            return i;  
        }  
        </script> 
<body>

	


	<!-- Page content -->
	<div class="page-content">

			<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<form class="login-form" action="index.html">
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<!--<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>-->
								<div>
								    <img src="global_assets/images/backgrounds/login_logo_tch.png" alt="THC Logo" >
								</div>
								<h5 class="mb-0">Login to your account</h5>
								<span class="d-block text-muted">Enter your credentials below</span>
							</div>

						<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" class="form-control" id="txt_login_username" placeholder="Customer Code">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" id="txt_login_password" class="form-control" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="button" class="btn btn-primary btn-block" id="btn_login">Sign in <i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<!--<div class="text-center">-->
							<!--	<a href="login_password_recover.html">Forgot password?</a>-->
							<!--</div>-->
						</div>
					</div>
				</form>
				<!-- /login form -->

			</div>
			<!-- /content area -->


			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	

</body>
</html>
