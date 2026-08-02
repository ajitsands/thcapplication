<?PHP
session_start();
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
   
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="assets/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files-->
	
	<script src="global_assets/js/main/jquery.min.js"></script> 
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	
   
  


	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/ui/prism.min.js"></script>

	<script src="assets/js/app.js"></script>
	<!-- /theme JS files -->
	
	
	<script src="global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
	<script src="global_assets/js/demo_pages/form_input_groups.js"></script>


	
	
   
    <!--<link rel="stylesheet" href="../httpdocs/user_js/calender/corner-popup.min.css">-->
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
	<script src="global_assets/js/demo_pages/content_cards_content.js"></script>
	<!--<script src="../httpdocs/user_js/calender/moment.min.js"></script>-->
 <!--   <script src="../httpdocs/user_js/calender/fullcalendar.min.js"></script>-->
	
    <!--<script src="../httpdocs/user_js/calender/corner-popup.min.js"></script>-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.js'></script>
	<!--<script src="../httpdocs/user_js/calender/moment.min.js"></script>-->
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>    

	<script src="assets/js/app.js"></script>
	
    
   <script type="text/javascript">	
	

// Setup Calender module
// ------------------------------

var FullCalendarBasic = function() {

     var popTemplate = [
    '<div class="popover" style="max-width:600px;" >',
    '<div class="arrow"></div>',
    '<div class="popover-header">',
    '<button id="closepopover" type="button" class="close" aria-hidden="true">&times;</button>',
    '<h3 class="popover-title"></h3>',
    '</div>',
    '<div class="popover-content"></div>',
    '</div>'].join('');
    //
    // Setup module components
    //

    // Basic calendar
    var _componentFullCalendarBasic = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }

        // Add demo events
        // ------------------------------
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
      

        // Initialization
        // ------------------------------




        //
        // Basic view
        //

        // Define element
        var calendarBasicViewElement = document.querySelector('.fullcalendar-basic');
/*
        // Initialize
        if(calendarBasicViewElement) {
            var calendarBasicViewInit = new FullCalendar.Calendar(calendarBasicViewElement, {
                plugins: [ 'dayGrid', 'interaction' ],
                eventClick: function(event, element) {

                    event.title = "CLICKED!";
                
                    $('#calendar').fullCalendar('updateEvent', event);
                
                 },
                dateClick: function(info) {
                    
                    // console.log('Clicked on: ' + info.dateStr);
                    // console.log('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    // console.log('Current view: ' + info.view.type);
                    // console.log('Clicked on: ' + info.dateStr);
                    // console.log('Title: ' + info.title);
               
                    // change the day's background color just for fun
                   // info.dayEl.style.backgroundColor = '#E1F177';
                      var days = document.querySelectorAll(".selectedDate");
                      days.forEach(function(day) {
                        day.classList.remove("selectedDate");
                      });
                      info.dayEl.classList.add("selectedDate");
                      
                     var dates = info.dateStr.split('-');
                    $.fn.cornerpopup({
                        variant: 9,
                        slide: 1,
                        slideTop: 1,
                        header: dates[2]+'-'+dates[1]+'-'+dates[0],
                        shadow: 1,
                        borderColor :'#d6d6d6',
                        closeBtn: 1,
                        button1: 1,
                        text2 : 'Do you like to add an event for this  selected date ?<br> Click <b>OK</b> to Continue or press <b>Esc</b> to close.',
                        escClose: 1,
                        btnColor: '#b5ad06',
                        timeOut: 3000,
                        btnTextColor: '#ffffff',
                        onBtnClick: function() {
                            alert('OK CLICKED');
                        }
                  
                    
                    });
                   
                    
                },
                eventDrop: function(event,start)
                {
                  var dat = new Date();
                  var d = dat.getDate();
                  var new_start=moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                  var today = $('#calender').fullCalendar('getDate');
                  
                  console.log(new_start);
                  //refetchEvents();
                  
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                defaultDate: '<?PHP echo date('Y-m-d');?>',
                editable: true,
                events: events,
                eventLimit: true
            }).render();
        }

       
  */  
  

       
        var fullCalendar = function(){
            var popTemplate = [
                '<div class="popover" style="max-width:600px;" >',
                '<div class="arrow"></div>',
                '<div class="popover-header">',
                '<button id="closepopover" type="button" class="close" aria-hidden="true">&times;</button>',
                '<h2 class="popover-title" ></h2>',
                '</div>',
                '<div class="popover-content"></div>',
                '</div>'].join('');
            
        var calendar = function(){
            
            if($("#calendar").length > 0){
                
                function prepare_external_list(){
                    
                    $('#external-events .external-event').each(function() {
                            var eventObject = {title: $.trim($(this).text())};

                            $(this).data('eventObject', eventObject);
                            $(this).draggable({
                                    zIndex: 999,
                                    revert: true,
                                    revertDuration: 0,
                            });
                    });                    
                    
                }
                
                
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
				// 	 eventClick:function(event)
	   //                   {
				// 			// $('#modal_change_status').modal('show');
						    
					
				// 	      },
					  editable:true,
					  
					   eventDrop:function(event,start)
					 {
						
						
						var start=moment(event.start).format('YYYY-MM-DD HH:mm:ss');
						var todayDate = $('#calendar').fullCalendar('getDate');
						var today_newformatDate = todayDate.format("YYYY-MM-DD HH:mm:ss");
						if(start < today_newformatDate)
						{
							swal("Warning!", "Can not move previous dates.",  "warning");
						    return false;
						}
						else
						{
						     var id = event.id;
                             var status=event.amc_status;
                             alert(status);
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
            							 swal("Moved!", "Selected Schedule has been Moved to "+start,  "success");
            						  }
            						 });
                                  } else {
                                    
                                  }
                                })
                           	
                             }
						}
					 },
					 select: function (start, end, jsEvent) {
                        closePopovers();
                        popoverElement = $(jsEvent.target);
                        $(jsEvent.target).popover({
                            title: 'the title',
                            content: function () {
                                return $("#popoverContent").html();
                            },
                            template: popTemplate,
                            placement: 'left',
                            html: 'true',
                            trigger: 'click',
                            animation: 'true',
                            container: 'body'
                        }).popover('show');
                    },
                
                    eventClick: function (event, jsEvent, view,) {
                        //closePopovers();
                        popoverElement = $(jsEvent.currentTarget);
                         
                      
                        
                    },
                
                    eventRender: function (event, element) {
                         element.popover({
                            title: 'the title',
                            content: function () {
                                return $("#popoverContent").html();
                            },
                            template: popTemplate,
                            placement: 'left',
                            html: 'true',
                            trigger: 'click',
                            animation: 'true',
                            container: 'body'
                        });
                                    
    //                      $.post("../controller/amc_asset_schedule/amc_asset_schedule_controller.php",{action:'check_asset_schedule',v_amc_ref_no:event.title}
				// 			, function(result,status)
    //     					 { 
    //     						var obj = jQuery.parseJSON(result);
        						
    //     						 if(obj.data[0].visit_mode==event.visit_mode)
    //     						{
    //     						    alert(event.backgroundColor);
    //     						   $(".popover-title") .css( "background-color", event.backgroundColor)
        						   
    //     						}
            					
    //     					 });
        		   
                        
                    },


				// 	eventRender: function(event, element) {
					   
    //                      $(element).popover({title: event.title, content: event.amc_status, trigger: 'hover', placement: 'auto right', delay: {"hide": 300 }});             
                       
                     
    //                 },
					  
					  
                    drop: function(date, allDay) {

                        var originalEventObject = $(this).data('eventObject');

                        var copiedEventObject = $.extend({}, originalEventObject);

                        copiedEventObject.start = date;
                        copiedEventObject.allDay = allDay;

                        //$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);


                        if ($('#drop-remove').is(':checked')) {
                            $(this).remove();
                        }

                    }
                });
                
                $("#new-event").on("click",function(){
                    var et = $("#new-event-text").val();
                    if(et != ''){
                        $("#external-events").prepend('<a class="list-group-item external-event">'+et+'</a>');
                        prepare_external_list();
                    }
                });
                
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
                
                function closePopovers() {
                    $('.popover').not(this).popover('hide');
                }
                
                
                $('body').on('click', function (e) {
                    // close the popover if: click outside of the popover || click on the close button of the popover
                    if (popoverElement && ((!popoverElement.is(e.target) && popoverElement.has(e.target).length === 0 && $('.popover').has(e.target).length === 0) || (popoverElement.has(e.target) && e.target.id === 'closepopover'))) {
                
                        ///$('.popover').popover('hide'); --> works
                        closePopovers();
                    }
                });
       
       
        //
        // Agenda view
        //

        // Define element
        var calendarAgendaViewElement = document.querySelector('.fullcalendar-agenda');

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
       
       
       
       // Calender Right Click
     
        $('#calendar:not(".fc-event")').on('contextmenu', function (e) {
           
            e.preventDefault()
        })
       //calender Right Click 
       
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
					include_once('template/left_menu.inc');
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
