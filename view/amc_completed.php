<?PHP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if($_SESSION["loggedin"] ==true)
	{
include('template/includes/en_de_header.inc');
$OBJ = new URLEncription();
$OBJ->URLEncode('head=dashboard');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?PHP 
		include_once('template/head.inc');
	?>

	<style>
	    	td.details-control {
            background: url('../httpdocs/images/plus.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../httpdocs/images/minus.png') no-repeat center center;
        }

	</style>
	
	
	<style>
   
      #config{
          overflow: auto;
          margin-bottom: 10px;
      }
      .config{
          float: left;
          width: 200px;
          height: 250px;
          border: 1px solid #000;
          margin-left: 10px;
      }
      .config .title{
          font-weight: bold;
          text-align: center;
      }
      .config .barcode2D,
      #miscCanvas{
        display: none;
      }
      #submit{
          clear: both;
      }
      #barcodeTarget,
      #canvasTarget{
        margin-top: 0px;
      }        
    </style>
	
	
	

	<script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="global_assets/js/demo_pages/form_select2.js"></script>
	
	
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- Data Table -->
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="global_assets/js/demo_pages/datatables_basic.js"></script>

    

    <script src="global_assets/js/plugins/uploaders/dropzone.min.js"></script>
	<!--<script src="global_assets/js/demo_pages/datatables_api.js"></script>-->
	

	<!--<script src="global_assets/js/demo_pages/datatables_advanced.js"></script>-->
	
	<!-- Ladda -->
	<script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>
	
	<script src="assets/js/barcode/jquery-barcode.js" type="text/javascript"></script>
	
	<!-- sweet alert -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="global_assets/js/fileupload_ns.js"></script>

	<script src="global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script src="global_assets/js/plugins/notifications/jgrowl.min.js"></script>

	<script src="global_assets/js/demo_pages/picker_date.js"></script>

	
    <script src="global_assets/js/fileupload_ns.js"></script>
	
	<!--<script src="../httpdocs/user_js/ticket_customer.js"></script>-->
    <script src="../httpdocs/user_js/amc_completed.js"></script>
	<script src="../httpdocs/user_js/login.js"></script>

	
	
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	
	
	
	<script src="global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="global_assets/js/demo_pages/editor_summernote.js"></script>
    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="global_assets/js/demo_pages/form_select2.js"></script>
	<script src="global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
    
 <script type="text/javascript">
    
        var ID = function () {
          
           var d = new Date();
           var UniqueCode = 'THC'+d.getDay()+''+d.getMonth()+''+d.getYear()+''+d.getHours()+''+d.getMinutes()+''+d.getSeconds()+''+(Math.random().toString(36).substr(2, 5)).toUpperCase();
           return UniqueCode;
        
        };
        
      function generateBarcode(){
         var timestamp = ID();
         $("#barcodeValue").val(timestamp);
        var value = $("#barcodeValue").val();
        var btype = $("input[name=btype]:checked").val();
        var renderer = $("input[name=renderer]:checked").val();

        var settings = {
          output:renderer,
          bgColor: $("#bgColor").val(),
          color: $("#color").val(),
          barWidth: $("#barWidth").val(),
          barHeight: $("#barHeight").val(),
          moduleSize: $("#moduleSize").val(),
          posX: $("#posX").val(),
          posY: $("#posY").val(),
          addQuietZone: $("#quietZoneSize").val()
        };
        if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){
          value = {code:value, rect: true};
        }
        if (renderer == 'canvas'){
          clearCanvas();
          $("#barcodeTarget").hide();
          $("#canvasTarget").show().barcode(value, btype, settings);
        } else {
          $("#canvasTarget").hide();
          $("#barcodeTarget").html("").show().barcode(value, btype, settings);
        }
      }
          
      function showConfig1D(){
        $('.config .barcode1D').show();
        $('.config .barcode2D').hide();
      }
      
      function showConfig2D(){
        $('.config .barcode1D').hide();
        $('.config .barcode2D').show();
      }
      
      function clearCanvas(){
        var canvas = $('#canvasTarget').get(0);
        var ctx = canvas.getContext('2d');
        ctx.lineWidth = 1;
        ctx.lineCap = 'butt';
        ctx.fillStyle = '#FFFFFF';
        ctx.strokeStyle  = '#000000';
        ctx.clearRect (0, 0, canvas.width, canvas.height);
        ctx.strokeRect (0, 0, canvas.width, canvas.height);
      }
      
      $(function(){
        $('input[name=btype]').click(function(){
          if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();
        });
        $('input[name=renderer]').click(function(){
          if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();
        });
       
      });
      
      
      
  
    </script>

<script>
    $(document).ready(function() {
      
        
        // $('.summernote-height').summernote({
        //   toolbar: [
        //     // [groupName, [list of button]]
        //     ['style', ['bold', 'italic', 'underline', 'clear']],
        //     ['font', ['strikethrough', 'superscript', 'subscript']],
        //     ['fontsize', ['fontsize']],
        //     ['color', ['color']],
        //     ['para', ['ul', 'ol', 'paragraph']],
        //     ['height', ['height']]
        //   ]
        // });
            
    });
</script>
</head>
    <?PHP 
		include_once('template/date_time.inc');
	?>
<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-light navbar-static fixed-top">

		<!-- Header with logos -->
		<?PHP 
				include_once('template/header_with_logo.inc');
		?>
	
		<!-- /header with logos -->
	

		<!-- Mobile controls -->
		<?PHP 
				include_once('template/mobile_view.inc');
		?>
		<!-- /mobile controls -->


		<!-- Navbar content -->
		<?PHP 
				include_once('template/navigation.inc');
		?>
		
		
		<!-- /navbar content -->
		
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			
			<?PHP 
				include_once('template/mobile_toggler.inc');
			?>
			
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">
				
				<!-- User menu -->
				<?PHP 
					include_once('template/user_menu.inc');
				?>
				
				<!-- /user menu -->

				
				<!-- Main navigation -->
				<?PHP  
				    include_once('template/left_menu_new.inc');
					//include_once('template/left_menu.inc');
				?>
				
				
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?PHP 
				//include_once('template/header_bellow_title.inc');
			?>
			
			<!-- /page header -->


			<!-- Content area -->
			<div class="content pt-0">

				<!-- Large navbar -->
				
				<?PHP 
					//include_once('amc/amc_details.php');
					include_once('amc_completed/amc_completed_body.php');
				?>
				
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
				include_once('template/reset_password_modal.php');
				//include("amc/amc_location_building_modal.php");
			?>

			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>

<?PHP }
	
	else{
		?>
		<script>

	window.location="login.php"
</script>
<?PHP
	}
	?>