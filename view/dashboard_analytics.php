<?PHP

require_once __DIR__ . '/../model/common/session_init.php';
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
	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
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

.complaint-list-items {
    margin: 4px 0 0 0;
    padding-left: 20px;
    list-style-type: disc;
    text-align: left;
}
.complaint-list-items li {
    margin-bottom: 4px;
    line-height: 1.45;
    color: #334155;
}
.complaint-list-items li:last-child {
    margin-bottom: 0;
}
.complaint-intro {
    font-weight: 600;
    margin-bottom: 5px;
    color: #0f172a;
}

/* Child row styling for Complaint Description */
tr.complaint-child-row {
    background-color: #f8fafc !important;
}
tr.complaint-child-row > td {
    padding: 6px 14px 10px 14px !important;
    border-top: none !important;
    background-color: #f8fafc !important;
}
tr.shown > td {
    border-bottom: none !important;
}
.complaint-child-container {
    padding: 0 4px;
}
.complaint-child-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #1e88e5;
    border-radius: 6px;
    padding: 9px 14px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.complaint-child-header {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
.complaint-child-badge {
    display: inline-flex;
    align-items: center;
    background-color: #e3f2fd;
    color: #1565c0;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 3px 8px;
    border-radius: 4px;
}
.complaint-child-body {
    color: #334155;
    font-size: 13px;
    line-height: 1.5;
}
td.details-control {
    cursor: pointer;
    user-select: none;
}
.toggle-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    cursor: pointer;
    vertical-align: middle;
    transition: transform 0.15s ease;
}
.toggle-icon:hover {
    transform: scale(1.15);
}

</style>

<?php 
  	   
 include_once(__DIR__ . '/../model/db_connection/connection.php');

    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
    ?>


<script type="application/javascript">
function formatComplaintLines(data) {
    if (!data) return '';
    var text = String(data).trim();
    if (text === '') return '';

    if (text.indexOf('*') !== -1) {
        var parts = text.split('*');
        var intro = parts.shift().trim();
        var html = '';
        if (intro !== '') {
            html += '<div class="complaint-intro">' + $('<div>').text(intro).html().replace(/\n/g, '<br>') + '</div>';
        }
        html += '<ul class="complaint-list-items">';
        for (var idx = 0; idx < parts.length; idx++) {
            var item = parts[idx].trim();
            if (item !== '') {
                html += '<li>' + $('<div>').text(item).html().replace(/\n/g, '<br>') + '</li>';
            }
        }
        html += '</ul>';
        return html;
    } else {
        return $('<div>').text(text).html().replace(/\n/g, '<br>');
    }
}

function formatComplaintChildRow(data) {
    var contentHtml = formatComplaintLines(data);
    if (!contentHtml || $.trim(contentHtml) === '') {
        contentHtml = '<span class="text-muted font-italic" style="font-size: 12px;"><i class="icon-info22 mr-1"></i>No complaint description provided.</span>';
    }
    return '<div class="complaint-child-container">' +
               '<div class="complaint-child-card">' +
                   '<div class="complaint-child-header">' +
                       '<span class="complaint-child-badge">' +
                           '<i class="icon-file-text2 mr-1"></i> Complaint Description' +
                       '</span>' +
                   '</div>' +
                   '<div class="complaint-child-body">' +
                       contentHtml +
                   '</div>' +
               '</div>' +
           '</div>';
}

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

$(document).on('click', '#tbl_ppm_list tbody td.details-control, #tbl_reactive_list tbody td.details-control, #tbl_other_list tbody td.details-control', function (e) {
    if ($(e.target).is('a, button, input')) return;

    var tr = $(this).closest('tr');
    var tableEl = $(this).closest('table');
    var tableId = tableEl.attr('id');
    var dt = (tableId === 'tbl_ppm_list') ? tbl_ppm_list : ((tableId === 'tbl_reactive_list') ? tbl_reactive_list : tbl_other_list);
    if (!dt) return;
    var row = dt.row(tr);
    if (!row || !row.data()) return;

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
        tr.find('.toggle-icon i')
            .removeClass('icon-minus-circle2 text-primary')
            .addClass('icon-plus-circle2 text-muted');
    } else {
        var data = row.data();
        if (data) {
            row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
            tr.addClass('shown');
            tr.find('.toggle-icon i')
                .removeClass('icon-plus-circle2 text-muted')
                .addClass('icon-minus-circle2 text-primary');
        }
    }
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
    var btn = this;
    var laddaBtn = Ladda.create(btn);
    laddaBtn.start();

    var tablesLoaded = 0;
    function checkLoaded() {
        tablesLoaded++;
        if (tablesLoaded >= 3) {
            laddaBtn.stop();
            $(document).off('xhr.dt.ladda');
        }
    }

    $(document).off('xhr.dt.ladda');
    $(document).on('xhr.dt.ladda', function ( e, settings, json, xhr ) {
        if (settings.nTable.id === 'tbl_ppm_list' || settings.nTable.id === 'tbl_reactive_list' || settings.nTable.id === 'tbl_other_list') {
            checkLoaded();
        }
    });

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

        responsive:false,

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

                orderable:false,

                className:"details-control text-center",

                render:function(data,type,row,meta){

                    if (type === 'display') {
                        return '<span class="toggle-icon cursor-pointer mr-1" title="Toggle complaint description">' +
                               '<i class="icon-minus-circle2 text-primary" style="font-size: 13px; vertical-align: middle;"></i>' +
                               '</span> ' + (meta.row + 1);
                    }
                    return meta.row + 1;

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

                data:"complaints_description",
                visible:false,
                render: function(data, type, row) {
                    if (type === 'export' && data && String(data).indexOf('*') !== -1) {
                        var parts = String(data).split('*');
                        var intro = parts.shift().trim();
                        var lines = [];
                        if (intro) lines.push(intro);
                        for (var i = 0; i < parts.length; i++) {
                            var item = parts[i].trim();
                            if (item) lines.push("• " + item);
                        }
                        return lines.join("\n");
                    }
                    return data ? data : '';
                }

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


        drawCallback: function (settings) {
            var api = this.api();
            api.rows({ page: 'current' }).every(function () {
                var row = this;
                var data = row.data();
                if (data) {
                    row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
                    $(row.node()).addClass('shown');
                    $(row.node()).find('.toggle-icon i')
                        .removeClass('icon-plus-circle2 text-muted')
                        .addClass('icon-minus-circle2 text-primary');
                }
            });
        },

        columnDefs:[

            {

                targets:0,

                width:"55px",

                className:"details-control text-center"

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

        responsive:false,

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

                orderable:false,

                className:"details-control text-center",

                render:function(data,type,row,meta){

                    if (type === 'display') {
                        return '<span class="toggle-icon cursor-pointer mr-1" title="Toggle complaint description">' +
                               '<i class="icon-minus-circle2 text-primary" style="font-size: 13px; vertical-align: middle;"></i>' +
                               '</span> ' + (meta.row + 1);
                    }
                    return meta.row + 1;

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

                data:"complaints_description",
                visible:false,
                render: function(data, type, row) {
                    if (type === 'export' && data && String(data).indexOf('*') !== -1) {
                        var parts = String(data).split('*');
                        var intro = parts.shift().trim();
                        var lines = [];
                        if (intro) lines.push(intro);
                        for (var i = 0; i < parts.length; i++) {
                            var item = parts[i].trim();
                            if (item) lines.push("• " + item);
                        }
                        return lines.join("\n");
                    }
                    return data ? data : '';
                }

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


        drawCallback: function (settings) {
            var api = this.api();
            api.rows({ page: 'current' }).every(function () {
                var row = this;
                var data = row.data();
                if (data) {
                    row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
                    $(row.node()).addClass('shown');
                    $(row.node()).find('.toggle-icon i')
                        .removeClass('icon-plus-circle2 text-muted')
                        .addClass('icon-minus-circle2 text-primary');
                }
            });
        },

        columnDefs:[

            {

                targets:0,

                width:"55px",

                className:"details-control text-center"

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

        responsive:false,

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

                orderable:false,

                className:"details-control text-center",

                render:function(data,type,row,meta){

                    if (type === 'display') {
                        return '<span class="toggle-icon cursor-pointer mr-1" title="Toggle complaint description">' +
                               '<i class="icon-minus-circle2 text-primary" style="font-size: 13px; vertical-align: middle;"></i>' +
                               '</span> ' + (meta.row + 1);
                    }
                    return meta.row + 1;

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

                data:"complaints_description",
                visible:false,
                render: function(data, type, row) {
                    if (type === 'export' && data && String(data).indexOf('*') !== -1) {
                        var parts = String(data).split('*');
                        var intro = parts.shift().trim();
                        var lines = [];
                        if (intro) lines.push(intro);
                        for (var i = 0; i < parts.length; i++) {
                            var item = parts[i].trim();
                            if (item) lines.push("• " + item);
                        }
                        return lines.join("\n");
                    }
                    return data ? data : '';
                }

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


        drawCallback: function (settings) {
            var api = this.api();
            api.rows({ page: 'current' }).every(function () {
                var row = this;
                var data = row.data();
                if (data) {
                    row.child(formatComplaintChildRow(data.complaints_description), 'complaint-child-row').show();
                    $(row.node()).addClass('shown');
                    $(row.node()).find('.toggle-icon i')
                        .removeClass('icon-plus-circle2 text-muted')
                        .addClass('icon-minus-circle2 text-primary');
                }
            });
        },

        columnDefs:[

            {

                targets:0,

                width:"55px",

                className:"details-control text-center"

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