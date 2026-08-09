
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">-->
	<?PHP 
		include_once('template/head.inc');
	echo '<script>var serverName = "' . $_SERVER['SERVER_NAME'] . '";</script>';
	echo '<script>var remoteAddress = "' . $_SERVER['REMOTE_ADDR'] . '";</script>';
	
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
	<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
  
  
	<!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	 
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/globalize/1.7.0/globalize.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/globalize/1.7.0/globalize/number.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/globalize/1.7.0/globalize/currency.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/globalize/1.7.0/globalize/date.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/globalize/1.7.0/globalize/plural.js"></script>-->
	 
	<script src="../httpdocs/user_js/login.js"></script>
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


	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<form class="login-form" action="index.html" id="login_form">
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
								<input type="text" class="form-control" id="txt_login_username" placeholder="Username" name="" />
								<!--style="text-transform: uppercase"-->
								<div class="form-control-feedback"> 
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" id="txt_login_password" class="form-control" placeholder="Password" />
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
						
							<div class="form-group">
								<button type="button" class="btn btn-primary btn-block" id="btn_login">Sign in<i class="icon-circle-right2 ml-2"></i></button>
							    <a class="text-right" id="a_forgot_password" style="cursor:pointer; float:right;">Forgot Password?</a>
							</div>
						

							<!--<div class="text-center">-->
							<!--	<a href="login_password_recover.html">Forgot password?</a>-->
							<!--</div>-->
						</div>
					</div>
				</form>
				
				<!-- /login form -->
				<!-- List Messages -->
            	<div id="modal_forgot_password" class="modal fade" tabindex="-1">
            		<div class="modal-dialog">
            			<div class="modal-content">
            				<div class="modal-header bg-info text-white border-0">
            					<h6 class="modal-title">Forgot Password</h6>
            					<span class="btn-close-white" data-bs-dismiss="modal" style="cursor:pointer;">X</span>
            				</div>
            
            				<div class="modal-body">
            					<div class="row">
            					    <div class="col-lg-12 col-md-12 col-sm-12">
            					        <input type="email" class="form-control" id="txt_email" placeholder="email@gmail.com">
            					        <span class="text-muted">Provide your email address. Your password will be sent to this email.</span>
            					    </div> 
            					</div>    
            				</div>
            
            				<div class="modal-footer">
            					<button type="button" class="btn btn-info" id="btn_get_password">Send</button>
            				</div>
            			</div>
            		</div>
            	</div>
            	<!-- /List Messages -->

			</div>
			<!-- /content area -->


			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	

<script>
$(document).ready(function() {
    
    $('#txt_login_username, #txt_login_password').attr('autocomplete', true);
    
    //forgot passsword
    $('#a_forgot_password').click(function(){
       $('#modal_forgot_password').modal("show");
    });
    $('.btn-close-white').click(function(){
       $('#modal_forgot_password').modal("hide");
    });
    
    $('#btn_get_password').click(function(){
        $(this).text("Please wait...");
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var thisEmail = $('#txt_email').val();
	    thisEmail = $.trim(thisEmail);
        thisEmail = thisEmail.replace(/\s+/g, '');  
        if(thisEmail=="")
        {
            swal("Provide Email Address","Email field is empty !","warning");
            $(this).text("Send");
            return;
        }
        if (emailRegex.test(thisEmail))
        {
            $.post("../controller/login/login_controller.php", 
            { action:"forgot_password", thisEmail:thisEmail },
            function(result){
                result = $.trim(result);
                if(result=="Mail Sending Failed" || result=="Email not found !" || result=="")
                {
                    $('#btn_get_password').text("Send");
                    swal("Failed",result,"warning");
                }
                else
                {
                   $('#btn_get_password').text("Send");
                    swal("Password Send Successfully",result,"success");
                    $('#txt_email').val('');
                }
            });
        }
        else
        {
            $('#btn_get_password').text("Send");
            swal("Invalid Email","Your Email address is Invalid !","warning");
            return;
        }
    });
	

		 // $.getJSON(filePathSettings('Login'), function (data) {
                //Get unique keys from all rows
                // var allKeys = Array.from(new Set(data.flatMap(entry => Object.keys(entry))));

                //Dynamically update headers
                // $('thead tr').empty();
                // allKeys.forEach(function (key) {
                    // $('thead tr').append('<th>' + key + '</th>');
                // });

                //Initialize DataTable
                // var dataTable = $('#myTable').DataTable({
                    // data: data,
                    // columns: allKeys.map(function (key) {
                        // return {
                            // data: key,
                            // title: key,
							// defaultContent: '',
                            // render: function (data, type, row) {
                                // if (typeof row[key] === 'object' && 'FILENAME' in row[key]) {
                                    // return row[key].FILENAME;
                                // } else {
                                    // return row[key];
                                // }
                            // }
                        // };
                    // })
                // });
            // });
			     // $.getJSON(, function (data) {
                //Get keys from the first object
                // var keys = Object.keys(data[0]);

                //Create DataTable with dynamic columns
                // var columns = keys.map(function (key) {
                    // if (typeof data[0][key] === 'object') {
                        //Handle nested property
                        // return {
                            // data: key + '.FILENAME',
                            // title: key + ' Filename',
                            // render: function (data, type, row) {
                                // return row[key] ? row[key].FILENAME : '';
                            // }
                        // };
                    // } else {
                        //Regular column
                        // return { data: key, title: key };
                    // }
                // });
				
				


                // Dynamically update headers
                // $('thead tr').empty();
                // keys.forEach(function (key) {
                    // $('thead tr').append('<th>' + key + '</th>');
                // });

                //Initialize DataTable
                // var dataTable = $('#myTable').DataTable({
                    // data: data,
                    // columns: columns
                // });
            // });
	// function filePathSettings(fileName)		
	// {
		// var timestamp = new Date().getTime();
		// var date = new Date(timestamp);
		// var month = date.getMonth() + 1;
		// var day = date.getDate();
		// var year = date.getFullYear();
		// var jsonFilePath = "../controller/login/logs/"+year+'-'+month+'/'+fileName+"^"+year+'-'+month+"-"+day+".json";
		// var updatedJsonFilePath = jsonFilePath + "?timestamp=" + timestamp;
		// return updatedJsonFilePath;
	// }
	
	
	// function GetData($dataStatus,$moduleName,$userName,$formName)
	// {
		
		// var date = new Date();

		//Set the locale (e.g., 'en-US' for English, 'fr-FR' for French)
			// var locale = 'en-BH';

		//Format the date using toLocaleString
			// var formattedDate = date.toLocaleString(locale);
			//var formData = $($formName).serializeArray();

			// Convert form data to JSON
			// var formDataJSON = {};
			// $.each(formData, function (index, field) {
				// let column = field.name.toUpperCase();
			  // formDataJSON[column] = field.value;
			// });
			// console.log($formName);
			// var formData = new FormData($("#"+$formName)[0]);
			// formData.append('module', $moduleName);
			// formData.append('status', $dataStatus);
			// formData.append('datetime', formattedDate);
			// formData.append('name', $userName);
			
			
			
			//Convert JSON to string
			//var jsonString = JSON.stringify(formData, null, 2);
			
			// $.ajax({
			  // url: '../controller/login/event_log.php',
			  // type: 'POST',
			  // data: formData,
			  // processData: false,
			  // contentType: false,
			  // success: function(response) {
				//Handle the response from the server
				// console.log(response);
				
			  // }
			// });

			
	// }
	
	// var clickedButtonId = null;
	// var formId = null;
	// $('form').on('click', 'button[type="submit"]', function () {
	  // formId = $(this).closest('form').attr('id');
	  //alert(formId+ ' '+this.id);
      // clickedButtonId = this.id;
    // });
	
	// $('#form_login').submit(function(event) {
		// event.preventDefault();
		//alert('Clicked Button ID:', clickedButtonId);
		// switch(clickedButtonId)
		// {
			// case 'btn_login':
				//Type OF Event, Module Name ,  UserName , Form Name to Submit
				// GetData('Login', 'Login','anisha',formId);
			// break;
			// case 'btn_new':
				// GetData('Save', 'Login','anisha',formId);
			// break;
			// case 'btn_delete':
				// GetData('Delete', 'Login','anisha',formId);
			// break;
			
		// }
			
	// });


  
});
</script>
</body>
</html>
