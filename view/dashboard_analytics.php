<?PHP

if (session_status() == PHP_SESSION_NONE) {
    session_start();
	}
	if($_SESSION["loggedin"] ==true)
	{

include('template/session_check.php');
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
	<script src="global_assets/js/main/jquery.min.js"></script> 
	<?PHP 
		include_once('template/head.inc');
	?>
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
</head>
   
    <?PHP 
		include_once('template/date_time.inc');
	?>
   	<!-- Core JS files -->
    <script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>

   <!-- Data Table -->
   	<script src="global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="global_assets/js/demo_pages/datatables_basic.js"></script>

	<script src="global_assets/js/demo_pages/form_select2.js"></script>
	<!--<script src="assets/js/app.js"></script>-->
	<script src="global_assets/js/demo_pages/components_buttons.js"></script>
	<!--<script src="global_assets/js/demo_pages/widgets_stats.js"></script>-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>	
	<script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
   
	<script src="../httpdocs/user_js/dashboard_analytics.js"></script>
    <script src="../httpdocs/user_js/login.js"></script>

  

<style>
   
.btn-search,
.btn-export,
.btn-filter{
    border:0;
    border-radius:10px;
    padding:10px 22px;
    font-size:14px;
    font-weight:600;
    transition:all .25s ease;
    box-shadow:0 3px 10px rgba(0,0,0,.08);
}

.btn-search{
    background:#0d6efd;
    color:#fff;
}

.btn-search:hover{
    background:#0b5ed7;
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(13,110,253,.30);
}

.btn-export{
    background:#198754;
    color:#fff;
    border:none;
    border-radius:10px;
    padding:10px 18px;
    font-weight:600;
    box-shadow:0 3px 10px rgba(25,135,84,.2);
}

.btn-export:hover,
.btn-export:focus{
    background:#157347;
    color:#fff;
}

.dropdown-menu{
    border:0;
    border-radius:10px;
    padding:8px 0;
    min-width:200px;
}

.dropdown-item{
    padding:10px 18px;
    font-weight:500;
    transition:.2s;
}

.dropdown-item:hover{
    background:#f5f7fa;
}
.btn-search i,
.btn-export i,
.btn-filter i{
    margin-right:8px;
    font-size:15px;
}
.btn-export-excel{
    background: linear-gradient(135deg,#16a34a,#22c55e);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 5px 12px;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.2;
    box-shadow: 0 2px 6px rgba(34,197,94,.25);
    transition: all .2s ease;
    margin: 0;
}

.btn-export-excel:hover{
    color: #fff;
    background: linear-gradient(135deg,#15803d,#16a34a);
    box-shadow: 0 4px 10px rgba(34,197,94,.35);
    transform: translateY(-1px);
}

.btn-export-excel:focus{
    outline: none;
    box-shadow: 0 0 0 0.15rem rgba(34,197,94,.25);
}

.btn-export-excel i{
    margin-right: 5px;
    font-size: 13px;
    vertical-align: middle;
}


</style>

<?php 
  	   
 include_once "../model/db_connection/connection.php" ;

    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
    ?>


<script type="application/javascript">
//$(document).ready(function(){
document.addEventListener("DOMContentLoaded", function () {

   const today = new Date();

    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    
    // Current date
    const todayStr = `${yyyy}-${mm}-${dd}`;
    
    // First day of current month
    const startOfMonth = `${yyyy}-${mm}-01`;
    
    // Set values
    document.getElementById('startDate').value = startOfMonth;
    document.getElementById('endDate').value = todayStr;
   
   $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
    $.fn.dataTable.tables({visible:true, api:true}).columns.adjust();
});
$('#select_category').select2({
    width: '100%',
    placeholder: 'Select Category',
    allowClear: true
});
$('#select_customer').select2({
    width: '100%',
    placeholder: 'Select Customer',
    allowClear: true
});
$('#btn_search').on('click', function(){

    load_ppm_list();
     load_reactive_list();
     load_other_list();

});

 var tbl_ppm_list;
 var tbl_reactive_list;
 var tbl_other_list;
     load_ppm_list();
     load_reactive_list();
     load_other_list();


function load_ppm_list()
{

    if($.fn.DataTable.isDataTable('#tbl_ppm_list'))
    {
        tbl_ppm_list.destroy();
    }


    tbl_ppm_list=$("#tbl_ppm_list").DataTable({

        processing:true,

        destroy:true,

        responsive:true,

        autoWidth:false,

        pageLength:30,

        searching:true,

        lengthChange:false,

        dom:'Bfrtip',

        ajax:{

            url:'../controller/dashboard_analytics/dashboard_controller.php',

            type:'POST',

            data:{
                action:'list_ppm',
                start_date:$('#startDate').val(),
                end_date:$('#endDate').val(),
                customer:$('#select_customer').val(),
                service_request:$('#sel_service_request').val(),
                category_id:$('#select_category').val(),
                ticket_priority:$('#sel_ticket_priority').val(),
                sel_status:$('#sel_status').val(),
                job_category:'PPM'
            },

            dataSrc:'data'

        },


       buttons: [
{
    extend: 'excelHtml5',
    className: 'excelButton',

    title: function () {

        var heading = "PPM Work Order Report - ";

         heading += "\n Period : " + formatDate($('#startDate').val()) +
           " To " + formatDate($('#endDate').val());

        heading += "\n ,Customer : " + $.trim($('#select_customer option:selected').text());

        heading += "\n ,Service Request : " + $('#sel_service_request option:selected').text();

        heading += "\n ,Category : " + $('#select_category option:selected').text();

        heading += "\n ,Priority : " + $('#sel_ticket_priority option:selected').text();

        return heading;

    },

    filename: function () {
        return 'PPM_Work_Order_Report_' + $('#startDate').val() + '_' + $('#endDate').val();
    },

    exportOptions: {
        columns: [0,1,2,3,4,5,6,7,8,9,10]
    }
}
],


        columns:[

            {

                data:null,

                render:function(data,type,row,meta){

                    return meta.row+1;

                }

            },

            {

                data:"amc_tkt_id",

                render:function(data,type,row){

                    return '<a target="_blank" href="../view/work_order_print.php?ticket_id='+data+'">WO-'+row.amc_tkt_ref_no+'-'+data+'</a>';

                }

            },

            {

                data:"date_of_visits1"

            },

            {

                data:"time_of_visit"

            },

            {

                data:null,

                render:function(data,type,row){

                    return row.customer_name+
                    ' | '+
                    row.location_name+
                    ' | '+
                    row.building_name;

                }

            },

            {

                data:"amc_visit_status"

            },

            {

                data:"complaints_description"

            },
            {

                data:"service_request"

            },

            {

                data:"category_name"

            },

            {

                data:"ticket_priority"

            },

            {

                data:"service_details",

                defaultContent:''

            }

        ],


        columnDefs:[

            {

                targets:0,

                width:"35px",

                className:"text-center"

            },

            {

                targets:1,

                width:"170px"

            },

            {

                targets:4,

                width:"300px"

            }

        ]

    });


    $('.dt-buttons').hide();

}
   $('#btnExportPPM').click(function(){

    tbl_ppm_list.button('.excelButton').trigger();

});


function load_reactive_list()
{

    if($.fn.DataTable.isDataTable('#tbl_reactive_list'))
    {
        tbl_reactive_list.destroy();
    }


    tbl_reactive_list=$("#tbl_reactive_list").DataTable({

        processing:true,

        destroy:true,

        responsive:true,

        autoWidth:false,

        pageLength:30,

        searching:true,

        lengthChange:false,

        dom:'Bfrtip',

        ajax:{

            url:'../controller/dashboard_analytics/dashboard_controller.php',

            type:'POST',

            data:{
                action:'list_reactive',
                start_date:$('#startDate').val(),
                end_date:$('#endDate').val(),
                customer:$('#select_customer').val(),
                service_request:$('#sel_service_request').val(),
                category_id:$('#select_category').val(),
                ticket_priority:$('#sel_ticket_priority').val(),
                sel_status:$('#sel_status').val(),
                job_category:'Reactive'
            },

            dataSrc:'data'

        },


       buttons: [
{
    extend: 'excelHtml5',
    className: 'excelButton',

    title: function () {

        var heading = "Reactive Work Order Report - ";

         heading += "\n Period : " + formatDate($('#startDate').val()) +
           " To " + formatDate($('#endDate').val());

        heading += "\n ,Customer : " + $.trim($('#select_customer option:selected').text());

        heading += "\n ,Service Request : " + $('#sel_service_request option:selected').text();

        heading += "\n ,Category : " + $('#select_category option:selected').text();

        heading += "\n ,Priority : " + $('#sel_ticket_priority option:selected').text();

        return heading;

    },

    filename: function () {
        return 'Reactive_Work_Order_Report_' + $('#startDate').val() + '_' + $('#endDate').val();
    },

    exportOptions: {
        columns: [0,1,2,3,4,5,6,7,8,9,10]
    }
}
],


        columns:[

            {

                data:null,

                render:function(data,type,row,meta){

                    return meta.row+1;

                }

            },

            {

                data:"amc_tkt_id",

                render:function(data,type,row){

                    return '<a target="_blank" href="../view/work_order_print.php?ticket_id='+data+'">WO-'+row.amc_tkt_ref_no+'-'+data+'</a>';

                }

            },

            {

                data:"date_of_visits1"

            },

            {

                data:"time_of_visit"

            },

            {

                data:null,

                render:function(data,type,row){

                    return row.customer_name+
                    ' | '+
                    row.location_name+
                    ' | '+
                    row.building_name;

                }

            },

            {

                data:"amc_visit_status"

            },

            {

                data:"complaints_description"

            },
            {

                data:"service_request"

            },
            {

                data:"category_name"

            },

            {

                data:"ticket_priority"

            },

            {

                data:"service_details",

                defaultContent:''

            }

        ],


        columnDefs:[

            {

                targets:0,

                width:"35px",

                className:"text-center"

            },

            {

                targets:1,

                width:"170px"

            },

            {

                targets:4,

                width:"300px"

            }

        ]

    });


    $('.dt-buttons').hide();

}
   $('#btnExportReactive').click(function(){

    tbl_reactive_list.button('.excelButton').trigger();

});

function load_other_list()
{

    if($.fn.DataTable.isDataTable('#tbl_other_list'))
    {
        tbl_other_list.destroy();
    }


    tbl_other_list=$("#tbl_other_list").DataTable({

        processing:true,

        destroy:true,

        responsive:true,

        autoWidth:false,

        pageLength:30,

        searching:true,

        lengthChange:false,

        dom:'Bfrtip',

        ajax:{

            url:'../controller/dashboard_analytics/dashboard_controller.php',

            type:'POST',

            data:{
                action:'list_other',
                start_date:$('#startDate').val(),
                end_date:$('#endDate').val(),
                customer:$('#select_customer').val(),
                service_request:$('#sel_service_request').val(),
                category_id:$('#select_category').val(),
                ticket_priority:$('#sel_ticket_priority').val(),
                sel_status:$('#sel_status').val(),
                job_category:'Other'
            },

            dataSrc:'data'

        },


       buttons: [
{
    extend: 'excelHtml5',
    className: 'excelButton',

    title: function () {

        var heading = "Other Work Order Report - ";
       heading += "\n Period : " + formatDate($('#startDate').val()) +
           " To " + formatDate($('#endDate').val());
       
         heading += "\n ,Customer : " + $.trim($('#select_customer option:selected').text());

        heading += "\n ,Service Request : " + $('#sel_service_request option:selected').text();

        heading += "\n ,Category : " + $('#select_category option:selected').text();

        heading += "\n ,Priority : " + $('#sel_ticket_priority option:selected').text();

        return heading;

    },

    filename: function () {
        return 'Other_Work_Order_Report_' + $('#startDate').val() + '_' + $('#endDate').val();
    },

    exportOptions: {
        columns: [0,1,2,3,4,5,6,7,8,9,10]
    }
}
],


        columns:[

            {

                data:null,

                render:function(data,type,row,meta){

                    return meta.row+1;

                }

            },

            {

                data:"amc_tkt_id",

                render:function(data,type,row){

                    return '<a target="_blank" href="../view/work_order_print.php?ticket_id='+data+'">WO-'+row.amc_tkt_ref_no+'-'+data+'</a>';

                }

            },

            {

                data:"date_of_visits1"

            },

            {

                data:"time_of_visit"

            },

            {

                data:null,

                render:function(data,type,row){

                    return row.customer_name+
                    ' | '+
                    row.location_name+
                    ' | '+
                    row.building_name;

                }

            },

            {

                data:"amc_visit_status"

            },

            {

                data:"complaints_description"

            },
            {

                data:"service_request"

            },

            {

                data:"category_name"

            },

            {

                data:"ticket_priority"

            },

            {

                data:"service_details",

                defaultContent:''

            }

        ],


        columnDefs:[

            {

                targets:0,

                width:"35px",

                className:"text-center"

            },

            {

                targets:1,

                width:"170px"

            },

            {

                targets:4,

                width:"300px"

            },
             {

                targets:4,

                width:"300px"

            }

        ]

    });


    $('.dt-buttons').hide();

}
   $('#btnExportOther').click(function(){

    tbl_other_list.button('.excelButton').trigger();

});
function formatDate(dateStr)
{
    if (!dateStr) return '';

    var parts = dateStr.split('-');

    return parts[2] + '-' + parts[1] + '-' + parts[0];
}
});

</script>


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
					//include_once('template/left_menu.inc');
					include_once('template/left_menu_new.inc');
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
					include_once('dashboard_analytics/dashboard_body.php');
				?>
				
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
				include_once('template/reset_password_modal.php');
					include_once('dashboard_analytics/export_modal.php');
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