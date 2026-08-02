<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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
</head>

<body style="font-size:25px;">
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
			  <input type="text" style="font-size:40px;" class="form-control" id="txt_form" placeholder="">
			</div>
			<div class="mb-3">
			  <label for="txt_email" style="font-size:40px;" class="form-label">Email address</label>
			  <input type="email" style="font-size:40px;" class="form-control" id="txt_email" placeholder="">
			</div>
			<div class="mb-3">
			  <label for="txt_mobile" style="font-size:40px;" class="form-label">Mobile Number</label>
			  <input type="number" style="font-size:40px;" class="form-control" id="txt_mobile" placeholder="">
			</div>
			<div class="mb-12 d-flex justify-content-end">
				<button class="btn btn-primary" type="button" >Next <i class="bi bi-caret-right"></i></button>
			</div>
	 </div>
	</div>

	<div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
	  <div class="card-body">
		<div class="">
			<h1>1. How do you rate the timeliness of maintenance repairs?</h1>
		  <div class="card-footer">
			<div class="row">
				<div class="col-12" style="padding-top:20px;">
					<input type="checkbox" class="btn-check" id="q1-option1" autocomplete="off">
					<label class="btn btn-primary" for="q1-option1" style="font-size:40px;width:100%;"><i class="bi bi-check"></i> Option 1 </label>
				</div>
				<div class="col-12" style="padding-top:20px;">
					<input type="checkbox" class="btn-check" id="q1-option2" autocomplete="off">
					<label class="btn btn-primary" for="q1-option2" style="font-size:40px;width:100%;">Option 2 <i class="bi bi-check"></i></label>
				</div>
				<div class="col-12" style="padding-top:20px;">
					<input type="checkbox" class="btn-check" id="q1-option3" autocomplete="off">
					<label class="btn btn-primary" for="q1-option3" style="font-size:40px;width:100%;">Option 3<i class="bi bi-check"></i></label>
				</div>
				<div class="col-12" style="padding-top:20px;">
					<input type="checkbox" class="btn-check" id="q1-option4" autocomplete="off">
					<label class="btn btn-primary" for="q1-option4" style="font-size:40px;width:100%;">Option 4<i class="bi bi-check"></i></label>
				</div>
				<div class="col-12" style="padding-top:20px;">
					<input type="checkbox" class="btn-check" id="q1-option5" autocomplete="off">
					<label class="btn btn-primary" for="q1-option5" style="font-size:40px;width:100%;">Option 5<i class="bi bi-check"></i></label>
				</div>
				<div class="col-12" style="padding-top:20px;">
					<input type="checkbox" class="btn-check" id="q1-option6" autocomplete="off">
					<label class="btn btn-primary" for="q1-option6" style="font-size:40px;width:100%;">Option 6<i class="bi bi-check"></i></label>
				</div>
			</div>
			
		  </div>
		</div>
	 </div>
	</div>
	<div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
	  <div class="card-body">
		<div class="">
			<h1>2. How do you rate the timeliness of maintenance repairs?</h1>
		  <div class="card-footer">
			<div class="row">
				<div class="col-2"> 
					<input type="radio" class="btn-check" name="q2-options" id="q2-option1" autocomplete="off">
					<label class="btn btn-primary" for="q2-option1" style="font-size:60px;"><i class="bi bi-1-circle"></i></label>
				</div>
				<div class="col-2">
					<input type="radio" class="btn-check" name="q2-options" id="q2-option2" autocomplete="off">
					<label class="btn btn-primary" for="q2-option2" style="font-size:60px;"><i class="bi bi-2-circle"></i></label>
				</div>
				<div class="col-2">
					<input type="radio" class="btn-check" name="q2-options" id="q2-option3" autocomplete="off">
					<label class="btn btn-primary" for="q2-option3" style="font-size:60px;"><i class="bi bi-3-circle"></i></label>
				</div>
				<div class="col-2">
					<input type="radio" class="btn-check" name="q2-options" id="q2-option4" autocomplete="off">
					<label class="btn btn-primary" for="q2-option4" style="font-size:60px;"><i class="bi bi-4-circle"></i></label>
				</div>
				<div class="col-2">
					<input type="radio" class="btn-check" name="q2-options" id="q2-option5" autocomplete="off">
					<label class="btn btn-primary" for="q2-option5" style="font-size:60px;"><i class="bi bi-5-circle"></i></label>
				</div>
				<div class="col-2">
					<input type="radio" class="btn-check" name="q2-options" id="q2-option6" autocomplete="off">
					<label class="btn btn-primary" for="q2-option6" style="font-size:60px;"><i class="bi bi-6-circle"></i></label>
				</div>
			</div>
			
		  </div>
		</div>
		
		
  


		  
		  
	  </div>
	   
	</div>
	
	
	<div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
	  <div class="card-body">
		<div class="">
			<h1>2. How do you rate the timeliness of maintenance repairs?</h1>
			
		  <div class="card-footer">
			<div class="row">
				<div class="col-12"> 
					
					  <label for="exampleFormControlTextarea1" class="form-label">Write your coment below</label>
					  <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
					
				</div>
			</div>
			
		  </div>
		</div>
		
		
  


		  
		  
	  </div>
	   
	</div>

</div>
</body>
</html>
