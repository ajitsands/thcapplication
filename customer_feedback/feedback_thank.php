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
    height: 130%;
  }
  
 
</style>
</head>

<body style="font-size:25px;">
<div class="container-lg" >
	<div class="row" style="padding:10px;">
		<div class="col-12 d-flex align-items-center justify-content-center" >
			<img src="https://sianlab.com/thc/view/global_assets/images/logo_print.png" height="200"  alt="..."> 
		</div>
		<!--<div class="col-12 d-flex align-items-center justify-content-center">-->
		<!--	<span style="font-size:50px;font-weight:700;">Customer Feedback</span>-->
		<!--</div>-->
	
	</div>

        <div class="card shadow " >
            <div class="card-body text-center bg-body-tertiary rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                <div class="row">
                    <div class="col-12">   
                        <h1 class="display-4">Thank You!</h1>
                    </div>
                    <div class="col-12">
                         <p class="lead">We appreciate your interaction.</p>
                    </div>
                    <div class="col-4 mx-auto" >
                        <button type="button" class="btn btn-primary btn-sm" style="font-size:25px;" id="btn_back"><i class="bi bi-chevron-double-left mr-4"></i>Back</button> 
                    </div>
                </div>
                
            </div>
        </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn_back').click(function(){
                window.location.href = "index.php";
            
        });
    });
</script>
</body>
</html>