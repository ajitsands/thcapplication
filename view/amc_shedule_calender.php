<?PHP
require_once __DIR__ . '/../model/common/session_init.php';

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
		//include_once('template/head.inc');
		include_once('user_permission/permission_class/class_permission.php');
	?>
	<title>THC-FMS</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	  <link rel="stylesheet" href="assets/css/bootstrap_popover.css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
   
	
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	
		<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files-->
	<script src="global_assets/js/main/jquery.min.js"></script> 

 
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	

	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/ui/prism.min.js"></script>
	<script src="global_assets/js/plugins/notifications/bootbox.min.js"></script>
   	<script src="global_assets/js/demo_pages/components_modals.js"></script>
	<script src="assets/js/app.js"></script>
	<!-- /theme JS files -->
	
	
	
	
   
    <link rel="stylesheet" href="assets/fullcalendar/fullcalendar.css">
    <link rel="stylesheet" href="../httpdocs/user_js/calender/corner-popup.min.css">
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
   
 
   
    #popoverContent{
          width: 100% !important;
          max-width: 400px !important;
    }

    /* Calendar Entry Popover Styling & Viewport Protection */
    .popover.calendar-entry-popover,
    .popover {
        width: 380px !important;
        max-width: 420px !important;
        min-width: 300px !important;
        z-index: 104000 !important;
        border-radius: 8px !important;
        border: 1px solid rgba(0, 0, 0, 0.15) !important;
        box-shadow: 0 12px 32px rgba(15, 23, 42, 0.25) !important;
        background: #ffffff !important;
    }
    .popover .popover-header {
        border-top-left-radius: 7px !important;
        border-top-right-radius: 7px !important;
    }
    .popover .popover-content,
    .popover .popover-body {
        padding: 0 !important;
        max-height: 80vh;
        overflow-y: auto;
    }
    .popover .card {
        margin-bottom: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }
    .popover .card-body {
        padding: 14px 16px !important;
    }
    .popover .list-group-item {
        padding: 10px 16px !important;
        font-size: 13px !important;
    }
   
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
      .fc-event {
          font-size: 13px;
          padding: 3px 5px;
          text-align: center;
        }
      
      
      
      /*Calender BG*/
      .selectedDate
        {
          background-color: #E1F177 !important;
        }

      /* Calendar Status Legend Colors */
      .card-header .card-title .calendar-legend-scheduled,
      .card-title .calendar-legend-scheduled,
      .calendar-legend-scheduled {
          color: #39c0ed !important;
      }
      .card-header .card-title .calendar-legend-assigned,
      .card-title .calendar-legend-assigned,
      .calendar-legend-assigned {
          color: #3f51b5 !important;
      }
      .card-header .card-title .calendar-legend-completed,
      .card-title .calendar-legend-completed,
      .calendar-legend-completed {
          color: #795548 !important;
      }
      .card-header .card-title .calendar-legend-closed,
      .card-title .calendar-legend-closed,
      .calendar-legend-closed {
          color: #4caf50 !important;
      }
      .card-header .card-title .calendar-legend-cancelled,
      .card-title .calendar-legend-cancelled,
      .calendar-legend-cancelled {
          color: #b23cfd !important;
      }
      .card-header .card-title .calendar-legend-extended,
      .card-title .calendar-legend-extended,
      .calendar-legend-extended {
          color: #ffc107 !important;
      }

      /* Modals & Backdrops high z-index and visibility to appear in front of FullCalendar, Corner Popup, and Popovers */
      .modal {
          z-index: 105000 !important;
      }
      .modal.in,
      .modal.show,
      .modal[style*="display: block"] {
          display: block !important;
          opacity: 1 !important;
          visibility: visible !important;
          z-index: 105000 !important;
      }
      .modal.fade.in,
      .modal.fade.show {
          opacity: 1 !important;
          visibility: visible !important;
      }
      .modal.in .modal-dialog,
      .modal.show .modal-dialog,
      .modal[style*="display: block"] .modal-dialog {
          -webkit-transform: none !important;
          -ms-transform: none !important;
          -o-transform: none !important;
          transform: none !important;
          opacity: 1 !important;
          visibility: visible !important;
          z-index: 105001 !important;
      }
      .modal-backdrop {
          z-index: 104990 !important;
      }
      .modal-backdrop.in,
      .modal-backdrop.show {
          opacity: 0.5 !important;
          filter: alpha(opacity=50) !important;
          display: block !important;
          z-index: 104990 !important;
      }
      #modal_amc_Customer_details,
      #modal_tkt_Customer_details,
      #modal_team_details,
      #modal_change_status {
          z-index: 105000 !important;
      }
      #modal_tkt_Customer_details .modal-dialog,
      #modal_amc_Customer_details .modal-dialog {
          width: 95% !important;
          max-width: 95% !important;
          margin: 20px auto !important;
      }
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<script src="global_assets/js/demo_pages/components_popups.js"></script>

	<script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="../httpdocs/user_js/calender/moment.min.js"></script>
	<script src="../httpdocs/user_js/calender/fullcalendar.min.js"></script>
	
    <script src="../httpdocs/user_js/calender/corner-popup.min.js"></script>
	<!--<script src="../httpdocs/user_js/calender/moment.min.js"></script>-->
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>    

	<!--<script src="assets/js/app.js"></script>-->
	
    
   <script type="text/javascript">	
   
if (typeof formatComplaintHtmlBullets !== 'function') {
    function formatComplaintHtmlBullets(text) {
        if (!text) return '<div align="center">NA</div>';
        var str = String(text);
        if ($.trim(str) === '' || $.trim(str) === '0' || $.trim(str) === 'NA') {
            return '<div align="center">NA</div>';
        }

        if (str.indexOf('*') !== -1) {
            var parts = str.split('*');
            var intro = $.trim(parts.shift());
            var html = '<div style="text-align: left; padding: 4px 8px; line-height: 1.45;">';
            if (intro !== '') {
                html += '<div style="margin-bottom: 4px; font-weight: 500;">' + $('<div>').text(intro).html().replace(/\n/g, '<br>') + '</div>';
            }
            html += '<ul style="margin: 0; padding-left: 20px; list-style-type: disc; text-align: left;">';
            for (var i = 0; i < parts.length; i++) {
                var item = $.trim(parts[i]);
                if (item !== '') {
                    html += '<li style="margin-bottom: 3px;">' + $('<div>').text(item).html().replace(/\n/g, '<br>') + '</li>';
                }
            }
            html += '</ul></div>';
            return html;
        } else {
            var escaped = $('<div>').text(str).html().replace(/\n/g, '<br>');
            return '<div style="text-align: left; padding: 4px 8px; line-height: 1.45;">' + escaped + '</div>';
        }
    }
}
window.formatComplaintHtmlBullets = formatComplaintHtmlBullets;

$(document).ready(function(){
     // Move modals to body so they are not trapped inside calendar card stacking context
     $('#modal_amc_Customer_details, #modal_tkt_Customer_details, #modal_team_details, #modal_change_status').appendTo("body");

     $('.modal').on('show.bs.modal', function () {
         $(this).addClass('show in').css({'z-index': 105000, 'display': 'block', 'opacity': 1, 'visibility': 'visible'});
         setTimeout(function() {
             $('.modal-backdrop').not('.modal-stack').css({'z-index': 104990, 'opacity': 0.5, 'display': 'block'}).addClass('modal-stack show in');
         }, 0);
     });

     $('.modal').on('hidden.bs.modal', function () {
         $(this).removeClass('show in').css({'display': 'none'});
         $('.modal-backdrop').remove();
         $('body').removeClass('modal-open').css('padding-right', '');
     });

     $(document).on('click', '.modal [data-dismiss="modal"]', function (e) {
         var $m = $(this).closest('.modal');
         $m.modal('hide');
         $m.removeClass('show in').css({'display': 'none'});
         $('.modal-backdrop').remove();
         $('body').removeClass('modal-open').css('padding-right', '');
     });

     var team_list_table = $('#list_of_team_members').DataTable({"destroy": true});
     var v_amc_assign_asset_list_table = $('#tbl_tkt_asset_list_display_for_schedule').DataTable({"destroy": true});

 $(document).on('click',"#btn_view_click",function (e) {
     if(e) e.preventDefault();
    
     var amc_no=$("#txt_amc_no_hidden").val();
     var visit_id=$("#txt_visit_id_hidden").val();
     var cust_name=$("#txt_customer_name_hidden").val();
     var amc_ticket=$.trim($("#txt_amc_ticket_hidden").val()).toUpperCase();
     var amc_tkt_id=$("#txt_tkt_amc_id_hidden").val();
     
     var amc_visit_date=$("#txt_tkt_amc_visit_date_hidden").val();
     var amc_visit_time=$("#txt_tkt_amc_visit_time_hidden").val();
     
     var amc_visit_date_display=$("#txt_tkt_dt_hidden").val();
     var amc_start_slot=$("#txt_tkt_strat_slot_hidden").val();
     var amc_add_slots=$("#txt_tkt_add_slots_hidden").val();
     var amc_vt_date_val=$("#txt_tkt_dt_val_hidden").val();
        
     $("#div_cust_name").html(cust_name+'  [ '+ amc_no +' ]');
    
      if(amc_ticket=='AMC')
      {
         var $modal = $('#modal_amc_Customer_details');
         $modal.appendTo('body');
         $modal.modal('show');
         $modal.addClass('show in').css({'display': 'block', 'opacity': 1, 'visibility': 'visible'});
         $modal.find('.modal-dialog').css({'opacity': 1, 'visibility': 'visible', 'transform': 'none'});

         $("#amc_ref_no").html(amc_no);
         $("#date_amc").html(amc_visit_date_display);
         $("#slots_amc").html(amc_start_slot+' ( +'+amc_add_slots+' )');
         $("#time_amc").html(amc_visit_time);
          
         try {
             load_data_to_grid_amc_asset_details(amc_no,amc_vt_date_val,amc_visit_time);
         } catch(err) {
             console.error('load_data_to_grid_amc_asset_details error:', err);
         }
      }
      else
      {
         var $modal = $('#modal_tkt_Customer_details');
         $modal.appendTo('body');
         $modal.modal('show');
         $modal.addClass('show in').css({'display': 'block', 'opacity': 1, 'visibility': 'visible'});
         $modal.find('.modal-dialog').css({'opacity': 1, 'visibility': 'visible', 'transform': 'none'});

         $("#tkt_ref_no").html(amc_no);
         $("#tkt_visit_date").html(amc_visit_date_display);
         $("#mode_of_visit").html(amc_start_slot+' ( +'+amc_add_slots+' )');
         $("#start_date_tkt").html(amc_visit_time);
         
         try {
             load_data_to_grid_asset_details(amc_no,amc_vt_date_val,amc_visit_time);
         } catch(err) {
             console.error('load_data_to_grid_asset_details error:', err);
         }
      }
      $('.fc-event').popover('hide');
   });
   
    $(document).on('click',"#btn_view_team",function (e) {
     if(e) e.preventDefault();
    
     var amc_no=$("#txt_amc_no_hidden").val();
     var visit_id=$("#txt_visit_id_hidden").val();
     var cust_name=$("#txt_customer_name_hidden").val();
     var amc_ticket=$("#txt_amc_ticket_hidden").val();
    
     $("#div_cust_name").html(cust_name+'  [ '+ amc_no +' ]');

     var $modal = $('#modal_team_details');
     $modal.appendTo('body');
     $modal.modal('show');
     $modal.addClass('show in').css({'display': 'block', 'opacity': 1, 'visibility': 'visible'});
     $modal.find('.modal-dialog').css({'opacity': 1, 'visibility': 'visible', 'transform': 'none'});
      
     $('.fc-event').popover('hide');
     
     try {
         load_data_to_grid_team(visit_id);
     } catch(err) {
         console.error('load_data_to_grid_team error:', err);
     }
   });
   
   
    
                  function load_data_to_grid_team(visit_id)
                 {
                     team_list_table.destroy();
                         
                     team_list_table = $('#list_of_team_members').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/calender/calender_controller.php',
                                 'data': {
                                    action: 'list_of_team',
                                    visit_id: visit_id
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                             "order": [[ 0, "desc" ]],
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                             "columns": [
                                  { "data": null},
                                
                                 { "data": "employee_name",
                                 
                                     render: function ( data, type, rows, meta ) {
                                         if(rows['is_leader']=='Yes')
                                         {
                                          str_emp_name = rows['employee_name']+' [ Leader ] ';
                                          
                                         } 
                                         else
                                         {
                                           str_emp_name = rows['employee_name']  
                                         }
                                         return str_emp_name;
                                      }   
                                 },
                                
                                 { "data": "employee_contact_no"}
                                
                                 
                               
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
                             
                             "initComplete": function( settings, json ) {
             
                              },
                              
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 $("td", nRow).css("vertical-align", "top");
                                 return nRow;
                             } ,
                             
                            "displayLength": 25,
                           
                         });
                 
                }
                
                
     
                   function load_data_to_grid_asset_details(amc_no,visit_date,visit_time)
                 {
                   
                     v_amc_assign_asset_list_table.destroy();
                         
                     v_amc_assign_asset_list_table = $('#tbl_tkt_asset_list_display_for_schedule').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/calender/calender_controller.php',
                                 'data': {
                                    action: 'list_of_tkt_asset_details',
                                    amc_no:amc_no,visit_date:visit_date,visit_time:visit_time
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                             "order": [[ 0, "desc" ]],
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                             "columns": [
                                 { "data": null, "width": "4%" },
                                 
                                 { "data": "category_name", "width": "12%" },
                                 { "data": "type_name", "width": "12%" },
                                 { 
                                     "data": "complaints_description",
                                     "width": "36%",
                                     render: function ( data, type, rows, meta ) {
                                         return formatComplaintHtmlBullets(data);
                                     }
                                 },
                                 { "data": "additional_info", "width": "16%" },
                                 { "data": "asset_code", "width": "10%" },
                                 { "data": "ticket_status", "width": "10%" },
                                 
                               
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
                             
                             "initComplete": function( settings, json ) {
             
                              },
                              
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 $("td", nRow).css("vertical-align", "top");
                                 return nRow;
                             } ,
                             
                            "displayLength": 25,
                           
                         });
                 
                }
     var v_amc_child_list_table = $('#tbl_amc_asset_list_display_for_schedule').DataTable({"destroy": true});
   function load_data_to_grid_amc_asset_details(amc_no,visit_date,visit_time)
                 {
                  
                     v_amc_child_list_table.destroy();
                         
                     v_amc_child_list_table = $('#tbl_amc_asset_list_display_for_schedule').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/calender/calender_controller.php',
                                 'data': {
                                    action: 'list_of_amc_asset_details',
                                    amc_no:amc_no,visit_date:visit_date,visit_time:visit_time
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                             "order": [[ 0, "desc" ]],
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                             "columns": [
                                 { "data": null},
                                 
                                 { "data": "asset_location" },
                                 { "data": "asset_building"},
                                 { "data": "category_name"},
                                 { "data": "asset_type_name"},
                                 { "data": "asset_ref_no" }
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
                             
                             "initComplete": function( settings, json ) {
             
                              },
                              
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 $("td", nRow).css("vertical-align", "top");
                                 return nRow;
                             } ,
                             
                            "displayLength": 25,
                           
                         });
                 
                }
   
   
   
 $(document).on('click', "#modal_close, .popover-header #modal_close, #modal_close a, #modal_close i", function (e) {
      if (e) e.preventDefault();
      $('.fc-event').popover('hide');
 });

 $(document).on('click', function (e) {
      if (!$(e.target).closest('.popover, .fc-event, .modal, .sweet-alert, .swal-overlay').length) {
          $('.fc-event').popover('hide');
      }
 });

 $(document).on('shown.bs.popover', function (e) {
      var $popover = $('.popover.in, .popover.show, .popover');
      if ($popover.length) {
          var offset = $popover.offset();
          if (!offset) return;
          var popWidth = $popover.outerWidth();
          var winWidth = $(window).width();
          
          // Never allow cut off on the left edge
          if (offset.left < 15) {
              $popover.css('left', '15px');
          } else if (offset.left + popWidth > winWidth - 15) {
              var newLeft = Math.max(15, winWidth - popWidth - 15);
              $popover.css('left', newLeft + 'px');
          }
          if (offset.top < 60) {
              $popover.css('top', '60px');
          }
      }
 });
   
   
//     $("txt_additional_slots_hidden").change(function(){
        
//         var add_slots_count=$("#txt_additional_slots_hidden").val();
//         console.log("add");
//         for(i=0;i<=add_slots_count;i++)
// 		{
//         additional_badge="<span class='badge bg-pink-400 ml-auto' id='time_slots'></span>";
// 		}
// 		return additional_badge;
//     });

});
// Setup Calender module
// ------------------------------

var FullCalendarBasic = function() {
    var events = [];

    // Basic calendar
    var _componentFullCalendarBasic = function() {
        if (typeof $.fn.fullCalendar === 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

        var fullCalendar = function(){
            
             var popTemplate = [
                '<div class="popover calendar-entry-popover" role="tooltip" style="max-width:420px; z-index:104000;">',
                '<div class="arrow"></div>',
                '<div class="popover-header" style="position:relative;background:#f8fafc;padding:8px 12px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;">',
                '<span style="font-weight:600;font-size:13px;color:#1e293b;"><i class="icon-calendar3 mr-1 text-primary"></i> Visit Details</span>',
                '<a href="javascript:void(0);" id="modal_close" style="color:#64748b;font-size:16px;text-decoration:none;line-height:1;display:inline-block;padding:2px 4px;" title="Close"><i class="icon-cross"></i></a>',
                '</div>',
                '<h2 class="popover-title" style="display:none;"></h2>',
                '<div class="popover-content popover-body" style="padding:0;"></div>',
                '</div>'].join('');
                
        var calendar = function(){
            
            if($("#calendar").length > 0){
                
              
                
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();

              

                var calendar = $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: true,
                    lazyFetching: true,
                    eventSources: [{
                        url: "assets/ajax_fullcalendar.php"
                    }],
                    droppable: true,
                    selectable: true,
                    selectHelper: true,
                    loading: function(isLoading) {
                        if (isLoading) {
                            if (typeof $.blockUI === 'function') {
                                $('#calendar').block({
                                    message: '<i class="icon-spinner2 spinner mr-2"></i> Loading schedule...',
                                    overlayCSS: { backgroundColor: '#fff', opacity: 0.6, cursor: 'wait' },
                                    css: { border: '1px solid #c2daeb', padding: '10px 16px', backgroundColor: '#0a4174', color: '#fff', borderRadius: '8px', width: 'auto' }
                                });
                            }
                        } else {
                            if (typeof $.unblockUI === 'function') {
                                $('#calendar').unblock();
                            }
                        }
                    },
					eventDrop: function(event, start)
					 {
						
						
						var start=moment(event.start).format('YYYY-MM-DD HH:mm:ss');
						var todayDate = $('#calendar').fullCalendar('getDate');
						var today_newformatDate = todayDate.format("YYYY-MM-DD HH:mm:ss");
						if(start < today_newformatDate)
						{
							swal("Warning!", "Please schedule to forward date",  "warning");
							   calendar.fullCalendar('refetchEvents');
						    return false;
						}
						else
						{
						     var id = event.id;
                             var status=event.amc_status;
                            // alert(status);
                             if(status=='Completed' || status=='Close')
                             {       
                                     swal("Warning!", "Can not move this ticket ",  "warning");
                                     calendar.fullCalendar('refetchEvents');
                                     return;
                             }
                             else
                             {
						     swal({
                                  title: "Do you want to change the schedule?",
                                  
                                  icon: "warning",
                                  buttons: [
                                    'No, cancel it!',
                                    'Yes, I am sure!'
                                  ],
                                  dangerMode: true,
                                }).then(function(isConfirm) {
                                  if (isConfirm) {
                                    $.ajax({
            						  url:"assets/update.php",
            						  type:"POST",
            						  data:{ start:start, id:id},
            						  success:function()
            						  {
            						   calendar.fullCalendar('refetchEvents');
            							 swal("Moved!", "Selected Schedule has been moved to "+start,  "success");
            						  }
            						 });
                                  } else {
                                    
                                  }
                                })
                           	
                             }
						}
					 },
					 
			
                
                    eventClick: function (event, jsEvent, view) {
                         // Close any other open popovers, but do NOT close or remove this event's popover
                         $('.fc-event').not(jsEvent.currentTarget).popover('hide');
                         popoverElement = $(jsEvent.currentTarget);
                         $("#txt_visit_id_hidden").val(event.id);
                         $("#txt_amc_no_hidden").val(event.title);
                         var cust_details=event.customer_name+'   '+event.customer_code;
                         $("#txt_customer_name_hidden").val(cust_details);
                         $("#txt_amc_ticket_hidden").val(event.amc_ticket);
                        
                         $("#txt_tkt_amc_id_hidden").val(event.amc_tkt_id);
                         
                         $("#txt_tkt_amc_visit_date_hidden").val(event.end);
                         $("#txt_tkt_amc_visit_time_hidden").val(event.visit_start_time);
                         $("#txt_tkt_strat_slot_hidden").val(event.start_slot);
                         $("#txt_tkt_add_slots_hidden").val(event.additional_slots);
                         $("#txt_tkt_dt_hidden").val(event.date_of_visits1);
                          $("#txt_tkt_dt_val_hidden").val(event.date_of_visits_val);
                         
                        
                    },
                
                    eventRender: function (event, element) {
                        element.popover({
                            content: function () {
                                var custWithCode = (event.customer_name || '') + (event.customer_code ? ' (' + event.customer_code + ')' : '');
                                var dateDisplay = event.date_of_visits1 || event.end || '';
                                var startSlotDisplay = event.start_slot || event.visit_start_time || '';

                                $("#cust_name").text(event.customer_name || '');
                                $("#customer_name_tkt").text(custWithCode);
                                $("#start_date_tkt").text(event.visit_start_time || startSlotDisplay);
                                $("#mode_of_visit").text(event.visit_mode || '');
                                $("#location_tkt, #location_amc").text(event.location_name || '');
                                $("#building_tkt, #building_amc").text(event.building_name || '');

                                $("#customer_name_amc").text(custWithCode);
                                $("#txt_additional_slots_hidden").val(event.additional_slots || '');

                                $("#start_date_amc").text(dateDisplay);
                                $("#end_date_amc").text(dateDisplay);
                                $("#description_amc").text(event.visit_mode || '');
                                $("#title_sub_head").html((event.visit_mode || '') + (dateDisplay ? "<br>Date: " + dateDisplay : ""));
                                $("#time_slots").text(startSlotDisplay);

                                // Populate hidden inputs for modals (View Details & View Team)
                                $("#txt_visit_id_hidden").val(event.id || '');
                                $("#txt_amc_no_hidden").val(event.title || '');
                                $("#txt_customer_name_hidden").val(custWithCode);
                                $("#txt_amc_ticket_hidden").val(event.amc_ticket || '');
                                $("#txt_tkt_amc_id_hidden").val(event.amc_tkt_id || '');
                                $("#txt_tkt_amc_visit_date_hidden").val(event.end || '');
                                $("#txt_tkt_amc_visit_time_hidden").val(event.visit_start_time || '');
                                $("#txt_tkt_strat_slot_hidden").val(event.start_slot || '');
                                $("#txt_tkt_add_slots_hidden").val(event.additional_slots || '');
                                $("#txt_tkt_dt_hidden").val(dateDisplay);
                                $("#txt_tkt_dt_val_hidden").val(event.date_of_visits_val || event.end || '');

                                var isAmc = ($.trim(String(event.amc_ticket)).toUpperCase() === 'AMC');
                                if (isAmc) {
                                    $("#ticket_priority").text('');
                                    $("#service_request").text('');
                                    $("#job_category").text('');
                                } else {
                                    $("#ticket_priority").text('...');
                                    $("#service_request").text('');
                                    $("#job_category").text('');

                                    var tktId = event.amc_tkt_id;
                                    if (tktId) {
                                        $.post("../controller/amc_asset_schedule/amc_asset_schedule_controller.php", {
                                            action: 'check_ticket_details',
                                            v_ticket_id: tktId
                                        }, function(result) {
                                            try {
                                                var obj_tkt = (typeof result === 'object') ? result : jQuery.parseJSON(result);
                                                if (obj_tkt && obj_tkt.data && obj_tkt.data.length > 0) {
                                                    var tkt = obj_tkt.data[0];
                                                    $('.popover #ticket_priority, #ticket_priority').text(tkt.ticket_priority || '');
                                                    $('.popover #service_request, #service_request').text(tkt.service_request || '');
                                                    $('.popover #job_category, #job_category').text(tkt.job_category || '');
                                                    if (tkt.location_name) {
                                                        $('.popover #location_tkt, .popover #location_amc').text(tkt.location_name);
                                                    }
                                                    if (tkt.building_name) {
                                                        $('.popover #building_tkt, .popover #building_amc').text(tkt.building_name);
                                                    }
                                                }
                                            } catch(e) {
                                                console.warn('Error fetching ticket details:', e);
                                            }
                                        });
                                    }
                                }

                                return $("#popoverContent").html();
                            },
                            template: popTemplate,
                            placement: function (tip, element) {
                                try {
                                    var winWidth = $(window).width();
                                    if (winWidth < 768) return 'bottom';
                                    var $el = element ? $(element) : (this && this.$element ? this.$element : null);
                                    if ($el && $el.length) {
                                        var offset = $el.offset();
                                        if (offset && typeof offset.left === 'number') {
                                            return (offset.left < (winWidth / 2)) ? 'right' : 'left';
                                        }
                                    }
                                } catch (e) {
                                    console.warn('Popover placement error:', e);
                                }
                                return 'auto left';
                            },
                            html: true,
                            trigger: 'click',
                            animation: true,
                            container: 'body'
                        });
                    },
                    editable: true,
                    
                    drop: function(date, allDay) {

                        var originalEventObject = $(this).data('eventObject');

                        var copiedEventObject = $.extend({}, originalEventObject);

                        copiedEventObject.start = date;
                        copiedEventObject.allDay = allDay;

                        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);


                        if ($('#drop-remove').is(':checked')) {
                            $(this).remove();
                        }

                    }
                });
                
                // $("#new-event").on("click",function(){
                //     var et = $("#new-event-text").val();
                //     if(et != ''){
                //         $("#external-events").prepend('<a class="list-group-item external-event">'+et+'</a>');
                //         prepare_external_list();
                //     }
                // });
                
            }            
        }
        
        return {
            init: function(){
                calendar();
            }
        }
    }();
	 fullCalendar.init();
        var popoverElement;
        
        
        
                
      
      
            };

    //
// Return objects assigned to module
    //

    return {
        init: function() {
            _componentFullCalendarBasic();
        }
    }
}();


// Initialize module
// ------------------------------



 


document.addEventListener('DOMContentLoaded', function() {
    FullCalendarBasic.init();
});

//Calender Starts

	
	
</script>	 
    

    
 







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
					include_once('amc/amc_shedule_calender.php');
				
				?>
				
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
               include_once('amc/amc_change_status_modal.php');
				include_once('template/reset_password_modal.php');
				
			?>

			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->




	
<!--Popup Div-->
      
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