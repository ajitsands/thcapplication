
<!doctype html>
<html>
<head><meta charset="us-ascii">
	<title>Customer Feedback</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
.btn-primary {
    background-color: #2e2e79;
    color: white;
    font-size: 40px;
    width: 100%;
  }
  
  .btn-check:focus + .btn-primary {
    background-color: #2e2e79; /* Reset to default or use another color */
    color: white;
  }
  /* Styles for the checked state */
  .btn-check:checked + .btn-primary {
    background-color: green;
  }
</style>
	
	<script src="../view/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
</head>
<body>
                             
<div class="container-lg" >
	<div class="row" style="padding:10px;">
		<div class="col-12 d-flex align-items-center justify-content-center" >
			<img src="https://sianlab.com/thc/view/global_assets/images/logo_print.png" height="200"  alt="...">
		</div>
		<div class="col-12 d-flex align-items-center justify-content-center">
			<span style="font-size:50px;font-weight:700;">Customer Feedback</span>
		</div>
	
	</div>

<div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
	  <div class="card-body">
			<div class="mb-3">
			  <label for="txt_form" class="form-label" style="font-size:40px;">Name</label>
			  <input type="text" style="font-size:40px;" class="form-control" id="customerName" placeholder="">
			</div>
			<div class="mb-3">
			  <label for="txt_email" style="font-size:40px;" class="form-label">Email address</label>
			  <input type="email" style="font-size:40px;" class="form-control" id="email" placeholder="">
			</div>
			<div class="mb-3">
			  <label for="txt_mobile" style="font-size:40px;" class="form-label">Mobile Number</label>
			  <input type="number" style="font-size:40px;" class="form-control" id="phoneNumber" placeholder="">
			</div>
			<div class="mb-12 d-flex justify-content-end">
				<button class="btn btn-primary" type="button" id="btn_next">Next <i class="bi bi-caret-right"></i></button>
			</div>
	 </div>
	</div>
</div>
<p></p>  
<p></p>
<input type="hidden"  class="form-control" id="amcrefno" value="<?php echo $decode_str=base64_decode($_GET['param']);?>">

<script>
    $(document).ready(function () {
        $('#btn_next').click(function(){
            var customerName = $('#customerName').val();
            var email = $('#email').val();
            var phoneNumber = $('#phoneNumber').val();
            
            var amc_ref_no = $('#amcrefno').val();
          //  var contract_type = 'GENERAL MAINTENANCE';
           // var customer_code = 'C0029';
          //  var customer_name = 'Denise Dennis French Almeer';
             
            
            if(customerName != '') 
            {
                window.location.href = "feedback_forms.php?customerName=" + customerName + "&email=" + email + "&phoneNumber=" + phoneNumber + "&amc_ref_no=" + amc_ref_no ;
            }
            else
            {
                swal("Warning","Please provide your name!!","warning");
            }
            
        });
    });
</script>

</body>
</html>
