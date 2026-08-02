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
		//include_once('template/head.inc');
	?>
	<title>TOTAL HOME CARE - TCH</title>

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
        /*Calender Click Popup*/
        
        
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
	<script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<script src="global_assets/js/demo_pages/components_popups.js"></script>

	<script src="global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/core/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/daygrid/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/timegrid/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/list/main.min.js"></script>
	<script src="global_assets/js/plugins/ui/fullcalendar/interaction/main.min.js"></script>
	
    <script src="global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="../httpdocs/user_js/calender/moment.min.js"></script>
	<script src="../httpdocs/user_js/calender/fullcalendar.min.js"></script>
	
    <script src="../httpdocs/user_js/calender/corner-popup.min.js"></script>
	<!--<script src="../httpdocs/user_js/calender/moment.min.js"></script>-->
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>    

	<!--<script src="assets/js/app.js"></script>-->
	
    
   <script type="text/javascript">	
   
$(document).ready(function(){
     var team_list_table = $('#list_of_team_members').DataTable({"destroy": true});
     
 $(document).on('click',"#btn_view_click",function () {
    //   var v_amc_assign_asset_list_table = $('#tbl_amc_asset_list_display_for_schedule').DataTable({"destroy": true});
     var amc_no=$("#txt_amc_no_hidden").val();
     var visit_id=$("#txt_visit_id_hidden").val();
     var cust_name=$("#txt_customer_name_hidden").val();
     var amc_ticket=$("#txt_amc_ticket_hidden").val();
     
    alert(amc_ticket);
     $("#div_cust_name").html(cust_name+'  [ '+ amc_no +' ]');
    
      if(amc_ticket=='AMC')
      {
         $('#modal_amc_Customer_details').modal('show');
      }
      else
      {
         $('#modal_tkt_Customer_details').modal('show');
      }
       $('.popover').not(this).popover('hide');
       
      
   });
   
    $(document).on('click',"#btn_view_team",function () {
    
     var amc_no=$("#txt_amc_no_hidden").val();
     var visit_id=$("#txt_visit_id_hidden").val();
     var cust_name=$("#txt_customer_name_hidden").val();
     var amc_ticket=$("#txt_amc_ticket_hidden").val();
    
     $("#div_cust_name").html(cust_name+'  [ '+ amc_no +' ]');
    

      $('#modal_team_details').modal('show');
      
       $('.popover').not(this).popover('hide');
     
         load_data_to_grid_team(visit_id);  
      
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
                                
                                 { "data": "employee_contact_no"},
                                
                                 
                               
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
                             
                             "initComplete": function( settings, json ) {
             
                              },
                              
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                             } ,
                             
                            "displayLength": 25,
                           
                         });
                 
                }
                
                
     
                   function load_data_to_grid_asset_details(visit_id)
                 {
                     team_list_table.destroy();
                         
                     team_list_table = $('#tbl_amc_asset_list_display_for_schedule').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/calender/calender_controller.php',
                                 'data': {
                                    action: 'list_of_amc_details',
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
                                
                                 { "data": "employee_contact_no"},
                                
                                 
                               
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
                             
                             "initComplete": function( settings, json ) {
             
                              },
                              
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                             } ,
                             
                            "displayLength": 25,
                           
                         });
                 
                }
   
   
   
   
 $(document).on('click',"#modal_close",function () {
      $('.popover').not(this).popover('hide');
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

    <?PHP include(__DIR__ . '/../model/db_connection/connection.php');
    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select amc_tkt_ref_no,amc_ticket,customer_code,customer_name,date_of_visits,time_of_visit,amc_visit_status from tbl_visits group by amc_tkt_ref_no,date_of_visits,time_of_visit");
    $Scheduled = '#0B9CF4';
    $Assigned = '#A5B20B';
    $Completed = '#FF5733';
    $Closed = '#581845';
    
?>
  
       
        var events = [
            <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
            {
                title: '<?PHP echo $row['amc_tkt_ref_no'];?>',
                url: '<?PHP echo 'event_details.php?customer_id='.$row["customer_code"].'&amc_tktno='.$row["amc_tkt_ref_no"] ;?>',
                start: '<?PHP echo $row['date_of_visits'].'T'.$row['time_of_visit'];?>',
                color: '<?PHP 
                    switch(trim($row["amc_visit_status"]))
                    {
                        case "Scheduled":
                            echo $Scheduled; 
                        break;
                        case "Assigned":
                            echo $Assigned;
                        break;
                        case "Completed":
                            echo $Completed;
                        break;
                        case "Closed":
                            echo $Closed;
                        break;    
                    }
                
                ?>'
            },
            <?PHP } ?>
        ];
    // Basic calendar
    var _componentFullCalendarBasic = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

       
       
        var calendarBasicViewElement = document.querySelector('.fullcalendar-basic');

       
       
       
        var fullCalendar = function(){
            
             var popTemplate = [
                '<div class="popover" style="max-width:1000px;" >',
                '<div class="arrow"></div>',
                '<div class="popover-header ">',
                '<div class="row "><div class="col-10"></div><div class="2" ><a href="#" id="modal_close"><i class="icon-cross"></i></a></div></div>',
                '<h2 class="popover-title" ></h2>',
                '</div>',
                '<div class="popover-content"></div>',
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
                    eventSources: {url: "assets/ajax_fullcalendar.php"},
                    droppable: true,
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDay) {
                        var title = prompt('Event Title:');
                        if (title) {
                            calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true
                            );
                        }
                        calendar.fullCalendar('unselect');
                        
                    },
					
					  
				// 	   eventDrop:function(event,start)
				// 	 {
						
						
				// 		var start=moment(event.start).format('YYYY-MM-DD HH:mm:ss');
				// 		var todayDate = $('#calendar').fullCalendar('getDate');
				// 		var today_newformatDate = todayDate.format("YYYY-MM-DD HH:mm:ss");
				// 		if(start < today_newformatDate)
				// 		{
				// 			swal("Warning!", "Can not move previous dates.",  "warning");
				// 		    return false;
				// 		}
				// 		else
				// 		{
				// 		     var id = event.id;
    //                          var status=event.amc_status;
    //                          alert(status);
    //                          if(status=='Completed' || status=='Close')
    //                          {       
    //                                  swal("Warning!", "Can not move this ticket ",  "warning");
    //                                  calendar.fullCalendar('refetchEvents');
    //                                  return;
    //                          }
    //                          else
    //                          {
				// 		     swal({
    //                               title: "Do you want to change the schedule?",
                                  
    //                               icon: "warning",
    //                               buttons: [
    //                                 'No, cancel it!',
    //                                 'Yes, I am sure!'
    //                               ],
    //                               dangerMode: true,
    //                             }).then(function(isConfirm) {
    //                               if (isConfirm) {
    //                                 $.ajax({
    //         						  url:"assets/update.php",
    //         						  type:"POST",
    //         						  data:{ start:start, id:id},
    //         						  success:function()
    //         						  {
    //         						   calendar.fullCalendar('refetchEvents');
    //         							 swal("Moved!", "Selected Schedule has been Moved to "+start,  "success");
    //         						  }
    //         						 });
    //                               } else {
                                    
    //                               }
    //                             })
                           	
    //                          }
				// 		}
				// 	 },
					 
			
                
    //                 eventClick: function (event, jsEvent, view,) {
    //                      //closePopovers();
    //                      popoverElement = $(jsEvent.currentTarget);
    //                      $("#txt_visit_id_hidden").val(event.id);
    //                      $("#txt_amc_no_hidden").val(event.title);
    //                      var cust_details=event.customer_name+'   '+event.customer_code;
    //                      $("#txt_customer_name_hidden").val(cust_details);
    //                      $("#txt_amc_ticket_hidden").val(event.amc_ticket);
                         
    //                 },
                
                    eventRender: function (event, element) {
                        
                                           $.post("../controller/calender/calender_controller.php",{action:'count_team_members',},function(result,status){
                                               
                                           })    
                        
                                            $.post("../controller/amc_asset_schedule/amc_asset_schedule_controller.php",{action:'check_asset_schedule',v_amc_ref_no:event.title}
                        							, function(result,status)
                                					 { 
                                						var obj = jQuery.parseJSON(result);
                                						
                                					
                                					
        					                element.popover({
        					                //title: event.title,    
                                            content: function () {
                                                  
                                                $("#cust_name").html(obj.data[0].customer_name);
                                                $("#customer_name_amc").html(obj.data[0].customer_name +'   ('+obj.data[0].customer_code+')');
                                                $("#txt_additional_slots_hidden").val(obj.data[0].additional_slots);
                                                $("#start_date_amc").html(obj.data[0].start_date);
                                                $("#end_date_amc").html(obj.data[0].end_date);
                                                $("#description_amc").html(obj.data[0].visit_mode);
                                                $("#title_sub_head").html(obj.data[0].visit_mode+" </br> From :"+obj.data[0].start_date+"</br> TO   :"+obj.data[0].end_date);
                                                $("#time_slots").html(obj.data[0].time_of_visit);
                                               
                                                var amc_ticket=obj.data[0].amc_tkt_id;
                                                var amc_or_ticket=obj.data[0].amc_ticket;
                                                
                                                if(amc_or_ticket==$.trim("AMC"))
                                                {
                                                        $("#ticket_priority").html("");
                                                        $("#service_request").html("");
                                                        $("#job_category").html("");
                                                        
                                                }
                                                else
                                                {
                                                       
                                                   $.post("../controller/amc_asset_schedule/amc_asset_schedule_controller.php",{action:'check_ticket_details',v_ticket_id:amc_ticket}
                        							, function(result,status)
                                					 { 
                                					     
                                					     var obj_tkt = jQuery.parseJSON(result);     
                                					     //console.log(obj_tkt);
                                                        $("#ticket_priority").html(obj_tkt.data[0].ticket_priority);
                                                        $("#service_request").html(obj_tkt.data[0].service_request);
                                                        $("#job_category").html(obj_tkt.data[0].job_category); 
                                                        $("#location_amc").html(obj_tkt.data[0].location_name);
                                                        $("#building_amc").html(obj_tkt.data[0].building_name);
                                					 });
                                					
                                                }
                                					 
                                                 //$("#div_add_time_slots").html(function(index, curContent){
                                            //     var additional_badge="";
                                            //     var time_of_visit=obj.data[0].time_of_visit;
                                            //     var add_slots_count=obj.data[0].additional_slots;
                                            //     if(add_slots_count>0)
                                            //     {
                                            //         for(i=0;i<=add_slots_count;i++)
                                            // 		{
                                            // 		    var time_slots=parseFloat(time_of_visit)+parseFloat(i);
                                            		    
                                            //             additional_badge=additional_badge+"<span class='badge bg-pink-400 ml-auto'>"+time_slots+"</span>";
                                            //             $("#div_add_time_slots").html(additional_badge+"<span class='badge bg-pink-400 ml-auto'>"+time_slots+"</span>");
                                            // 		}
                                            // 		//$("#div_add_time_slots").html(additional_badge);
                                            // 		//return additional_badge;
                                            //     }
                                            		
                                               // });
                                                
                                                 return $("#popoverContent").html();
                                				
                                            },
                                            template: popTemplate,
                                            placement: 'left',
                                            html: 'true',
                                            trigger: 'click',
                                            animation: 'true',
                                            container: 'body'
                                        });
                                         
                                 });
                                 
                    },
					  editable:true,
					  
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
        
        
        
                
      
      
        // Initialize
        if(calendarAgendaViewElement) {
            var calendarAgendaViewInit = new FullCalendar.Calendar(calendarAgendaViewElement, {
                plugins: [ 'dayGrid', 'timeGrid', 'interaction' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                defaultDate: '<?PHP echo date('Y-m-d');?>',
                defaultView: 'timeGridWeek',
                editable: true,
                businessHours: true,
                events: events
            }).render();
        }


        //
        // List view
        //

        // Define element
        var calendarListViewElement = document.querySelector('.fullcalendar-list');

        // Initialize
        if(calendarListViewElement) {
            var calendarListViewInit = new FullCalendar.Calendar(calendarListViewElement, {
                plugins: [ 'list', 'interaction' ],
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listDay,listWeek,listMonth'
                },
                views: {
                    listDay: { buttonText: 'Day' },
                    listWeek: { buttonText: 'Week' },
                    listMonth: { buttonText: 'Month' }
                },
                defaultView: 'listMonth',
                defaultDate: '2014-11-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: events
            }).render();
        }
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




	</div>
	<!-- /page content -->
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