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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
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
	
	<script src="../httpdocs/user_js/requisition_list.js"></script>
    
	<script src="../httpdocs/user_js/login.js"></script>
	
	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> 
	

	<script src="global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="global_assets/js/demo_pages/editor_summernote.js"></script>
	

    



	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
</head>
    <?PHP 
		include_once('template/date_time.inc');
	?>
<body class="navbar-top">

	


	


			<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

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
					include_once('amc_event_log/amc_event_log_details.php');
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

	
	
<script>
	$(document).ready(function() {
		 var v_tbl_login_logout_log = $('#tbl_amc_log').DataTable({});  
		 
		 var v_btn_user_search = $('#btn_user_search').ladda();
		 
			load_login_logout_data(null);	
			function load_login_logout_data(v_username,v_txt_start_date,v_txt_end_date)
			{		
				 v_tbl_login_logout_log.destroy();
								 
				 v_tbl_login_logout_log = $('#tbl_amc_log').DataTable( {
					   
						 "ajax": {
							 'type': 'POST',
							 'url': '../controller/amc/amc_controller.php',
							 'data': {
								action: 'list_amc_event_log',
								v_username:v_username,
								v_start_date:v_txt_start_date,
								v_end_date:v_txt_end_date
							 }
						 },
						 "language": {
							 "zeroRecords": "No records available",
							 "infoEmpty": "No records available",
						  },
						"order": [[ 3, "desc" ]],
					   
						"Paginate": true,
						"bLengthChange": true, 
						"bFilter": true,
						"bInfo": true,
						"autoWidth": false,
						
					
						"columns": [
							
							{ "data": null, "className":"text-center"},
							{ "data": 'jsondata' ,"className":"text-center",
								render: function (data, type, row) 
								{
									return '<button class="btn alpha-primary text-primary-800 btn-icon rounded-round ml-2 showChildTableBtn"><i class="icon-select2"></i></button>';
								}
							},
							{ "data": "event_type", "className":"text-center"},
							{ "data": "default_date", "className":"text-center"},
							{ "data": "amc_ref_no", "className":"text-center"},
							{ "data": "username", "className":"text-center"},
							
							
							{ "data": "ip_address", "className":"text-center"}
							 
				   
						 ],
						 pageLength: 20,
						 searching: true,
						 responsive: true,
						 
						 // "aoColumnDefs": [
							// { "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
							
						// ],
						
						
						 "initComplete": function( settings, json ) {
								
						   
		 
						  },
						 
							"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
							 return nRow;
						  },
						  "drawCallback": function () {
							   
							},
							 
				 }); 
			} 
				 
				 $('#tbl_amc_log tbody').on('click', 'button.showChildTableBtn', function () {
					var cell = $(this).closest('td');
					var rowIndex = v_tbl_login_logout_log.cell(cell).index().row;
					var rowData = v_tbl_login_logout_log.row(rowIndex).data();
					
					if (rowData) {
						
						toggleChildTable(rowData.jsondata, cell);
					}
				});
				 
				 
				 
				v_btn_user_search.click(function (e) {
					
					v_btn_user_search.ladda( 'start' );			 
					var v_username=$("#select_username option:selected").val();
					var v_txt_start_date=$("#amc_start_date").val();
					var v_txt_end_date=$("#amc_end_date").val();
					if($.trim(v_txt_start_date)===""||$.trim(v_txt_end_date)==="")
					{
						swal("Warning","Please provide all the details ....", "warning");
                        v_btn_user_search.ladda( 'stop' );
                        return false;
					}
					else
					{
						load_login_logout_data(v_username,v_txt_start_date,v_txt_end_date);
						//alert(v_username+v_txt_start_date+v_txt_end_date);
						v_btn_user_search.ladda( 'stop' );
					}
				});
	
	});
	
	
			function toggleChildTable(jsonData, cell) {
			
			var mainTableRow = $(cell).closest('tr');
			var childRow = mainTableRow.next('tr.child');

			// If child row is visible, hide it; otherwise, show it
			//if (childRow.length) {
				
				if (childRow.is(':visible')) {
					childRow.hide();
					mainTableRow.removeClass('shown');
				} else {
					displayChildTable(jsonData, cell);
					mainTableRow.addClass('shown');
				}
			//}
		}

		function displayChildTable(jsonData, cell) {
			// Parse JSON data
			var parsedData = JSON.parse(jsonData);

			// Create HTML for child table
			var childTable = '<tr class="child"><td colspan="7"><table style="width:100%;max-width:1000px; border: 1px solid #636363;" class="table table-bordered table-hover datatable-highlight display childTable table-responsive">';
			childTable += '<thead><tr>';
			
			// Add headers with keys
			for (var key in parsedData) {
				childTable += '<th style="background-color: #D6EAF8;border: 1px solid #636363 ;width:50%">' + key + '</th>';  
			}
			
			childTable += '</tr></thead><tbody><tr>';
			 
			// Add values in rows
			for (var key in parsedData) {
				childTable += '<td>' + parsedData[key] + '</td>';
			}
			
			childTable += '</tr></tbody></table></td></tr>';

			// Insert the child table row after the main table row
			var mainTableRow = $(cell).closest('tr');
			mainTableRow.after(childTable);
		}
	

</script>
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