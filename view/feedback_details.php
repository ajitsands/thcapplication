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
	
	<script src="../httpdocs/user_js/requisition_list.js"></script>
    
	<script src="../httpdocs/user_js/login.js"></script>
	
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
	

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
					include_once('customer/feedback_details.php');
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
		 var v_tbl_customer_feedback_list = $('#tbl_customer_feedback_list').DataTable({});  
		 
		 var v_btn_feedback_search = $('#btn_feedback_search').ladda();
		 var v_txt_start_date, v_txt_end_date,v_customer;
			load_customer_feedback_data(v_txt_start_date,v_txt_end_date,v_customer);
			function load_customer_feedback_data(v_txt_start_date,v_txt_end_date,v_customer)
			{		
			    
				 v_tbl_customer_feedback_list.destroy();
								 
				 v_tbl_customer_feedback_list = $('#tbl_customer_feedback_list').DataTable( {
					   
						 "ajax": {
							 'type': 'POST',
							 'url': '../controller/customer_feedback/customer_feedback_controller.php',
							 'data': {
								action: 'list_customer_feedback',
								v_start_date:v_txt_start_date,
								v_end_date:v_txt_end_date,
								v_customer:v_customer
							 }
						 },
						 "language": {
							 "zeroRecords": "No records available",
							 "infoEmpty": "No records available",
						  },
						"order": [[ 3, "desc" ]],
					   
						"Paginate": true,
        				"bLengthChange": false,
        				"bFilter": false,
        				"bInfo": true,
        				"autoWidth": false, 
						
					 
						"columns": [
							
							{ "data": null, "className":"text-center","width":"5%"},
							{ "data": "amc_ref_no", "className":"text-center"},
							{ "data": "main_customer_code", "className":"text-center",
							    render: function ( data, type, rows, meta ) {
							        return rows['main_customer_code']+'||'+rows['main_customer_name'];
							    }
							},
							{ "data": "contract_type", "className":"text-center"},
							{ "data": "customer_name", "className":"text-center"},
							{ "data": "customer_phone", "className":"text-center"},
							{ "data": "customer_email", "className":"text-center"},
							
							{ "data": "customer_feedback_id", "className":"text-center",
							 render: function ( data, type, rows, meta ) {
							     return str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="../customer_feedback/index5.php?form_number=' + rows['form_number'] + '" class="dropdown-item" name="view_ticket" data-toggle="" data-target="" style="color:black" target="_blank"><i class="icon-eye"></i> View</a></div></div></div>';
							  
							 }
							},
							{ "data": null , "className":"text-center",
    							 render: function ( data, type, rows, meta )
    							 {
                                     return feedbackResult = '<a href="analysis_report.php?fromNumber='+rows['form_number']+'" name="view_sentimental_analysis" target="blank"><i class="icon-eye"></i></a>';
    							 }
							}
							
						 ],
						 pageLength: 20,
        				 searching: true,
                         responsive: true,
						 
				// 		  "aoColumnDefs": [
				// 			{ "bSortable": false, "aTargets": [ 0,1,2,3] }, 
							
				// 		],
						
						
						 "initComplete": function( settings, json ) {
                                  $.extend($.fn.dataTableExt.oSort, {
                                    "dom-date-pre": function(a) {
                                        return moment(a, "DD-MM-YYYY HH:mm:ss")
                                    },
                                    "dom-date-asc": function(a, b) {
                                        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                                    },
                                    "dom-date-desc": function(a, b) {
                                        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                                    }
                                });   
                               
             
                              },
						 
							"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
							 return nRow;
						  },
						  "drawCallback": function () {
							   
							}
						
				 }); 
				 
			}	 
				 
				v_btn_feedback_search.click(function (e) {
					
					v_btn_feedback_search.ladda( 'start' );			 
					v_txt_start_date=$("#feedback_start_date").val();
					v_txt_end_date=$("#feedback_end_date").val();
					v_customer=$("#select_customer_feedback option:selected").text();
					if($.trim(v_txt_start_date)===""||$.trim(v_txt_end_date)==="") 
					{
						swal("Warning","Please provide all the details ....", "warning");
                        v_btn_feedback_search.ladda( 'stop' );
                        return false;
					}
					else 
					{
						load_customer_feedback_data(v_txt_start_date,v_txt_end_date,v_customer);
						//alert(v_txt_start_date+v_txt_end_date);
						v_btn_feedback_search.ladda( 'stop' );
					}
				});
	
	});
	

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