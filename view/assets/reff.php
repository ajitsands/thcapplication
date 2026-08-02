<?PHP
session_start();
if($_SESSION["LOGIN"] == '')
{
	ob_start();
    header('Location: login.php');
    ob_end_flush();
    die();
}
else
{
	include(__DIR__ . '/../controller/connection.php');
	
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Creative Online invoice # <?PHP echo $_GET['inv_no'];?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  
 <!-- fullCalendar -->
  <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="../bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
  <!--Sweet-->
  <link rel="stylesheet" href="../plugins/sweetalert/sweetalert.css">
  
  <!-- daterange picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  
    <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
 <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

  <link rel="icon" href="../dist/img/login_logo.png" type="image/gif" sizes="16x16">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style>
table.dataTable thead th.sorting,
table.dataTable thead th.sorting_asc,
table.dataTable thead th.sorting_desc {
  background: none;
  padding: 4px 5px;
}
.dataTable > thead > tr > th[class*="sort"]:after{
    content: "" !important;
}

table.dataTable.table-sm>thead>tr>th { 
    padding-right: inherit !important; 
}

tr.selected {
  text-decoration: line-through;
}
</style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
	
	 <?PHP include('template/logo.php'); ?>
   

    <!-- Header Navbar -->
	<?PHP include('template/drop_down_menu.php'); ?>
  
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
   <?PHP include('template/left_menu.php'); ?>

    <!-- /.sidebar -->
  </aside>




  <!-- Content Wrapper. Contains page content -->
   <?PHP include('template/schedule_calender.php'); ?>
 
  <!-- /.content-wrapper -->

  <?PHP include('template/footer.php'); ?>


  

  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- fullCalendar -->
<!-- date-range-picker -->
<script src="../bower_components/moment/min/moment.min.js"></script>
<script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<!--Sweet-->
<script src="../plugins/sweetalert/sweetalert.js"></script>

<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {


	/*$('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Tomorrow'   : [moment().subtract(-1, 'days'), moment().subtract(-1, 'days')],
		  'Day After Tomorrow'   : [moment().subtract(-2, 'days'), moment().subtract(-2, 'days')],
		  'Next Week'   : [moment().subtract(-7, 'days'), moment().subtract(-7, 'days')],
		  'After 10 Days'   : [moment().subtract(-10, 'days'), moment().subtract(-10, 'days')],
		  'After 30 Days'   : [moment().subtract(-30, 'days'), moment().subtract(-30, 'days')],
         },
        startDate: moment().subtract(-29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(  start.format('MM/D/YYYY') + ' - ' + end.format('M/D/YYYY'))
      }
    )*/

 $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'YYYY-MM-DD hh:mm A' }})


 $('.my-colorpicker2').colorpicker('#000000');
 
 
 function getTwentyFourHourTime(amPmString) { 

        var d = new Date(amPmString); 
		var mon = d.getMonth()+1;
        return d.getFullYear()+'-'+mon+'-'+d.getDate()+' '+d.getHours() + ':' + d.getMinutes(); 
  }
 
 $('#but_save_appointment').click( function(){
	
	 var v_title = $('#txt_app_name').val();
	 var v_start_end = $('#reservationtime').val();
	 
	 v_start_end = v_start_end.split(" - ");
	 var v_app_color =  $('#txt_appointment_color').val();
	 
	
	 $.ajax({
		   url:"calender_events/insert.php",
		   type:"POST",
		   data:{title:v_title, start:getTwentyFourHourTime(v_start_end[0] ), end:getTwentyFourHourTime(v_start_end[1] ),bgColor:v_app_color},
		   success:function()
		   {
			$('#calendar').fullCalendar('refetchEvents');
			 
		   }
	 
	});
 });




	var all_hl_btns = $('#highlightButtons > button');
    all_hl_btns.click(function(){
        var value = $(this).val();
        $('#txt_appointment_color').val(value);
		$('#txt_appointment_color').colorpicker({color : value});
		$('#txt_appointment_color').colorpicker('setValue', value);
		$('#txt_app_name').val($(this).text());
    });


    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    var calendar = $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
	  events: 'calender_events/load.php',
      /*events    : [
        {
          title          : 'All Day Event',
          start          : new Date(y, m, 3),
		  allDay         : true,
          backgroundColor: '#f56954', //red
          borderColor    : '#f56954' //red
        },
        {
          title          : 'Long Event',
          start          : new Date(y, m, d - 5),
          end            : new Date(y, m, d - 2),
          backgroundColor: '#f39c12', //yellow
          borderColor    : '#f39c12' //yellow
        },
        {
          title          : 'Meeting',
          start          : new Date(y, m, d, 14, 30),
          allDay         : false,
          backgroundColor: '#0073b7', //Blue
          borderColor    : '#0073b7' //Blue
        },
        {
          title          : 'Lunch',
          start          : new Date(y, m, d, 12, 0),
          end            : new Date(y, m, d, 14, 0),
          allDay         : false,
          backgroundColor: '#00c0ef', //Info (aqua)
          borderColor    : '#00c0ef' //Info (aqua)
        },
        {
          title          : 'Birthday Party',
          start          : new Date(y, m, d + 1, 19, 0),
          end            : new Date(y, m, d + 1, 22, 30),
          allDay         : false,
          backgroundColor: '#00a65a', //Success (green)
          borderColor    : '#00a65a' //Success (green)
        },
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 28),
          end            : new Date(y, m, 29),
          url            : 'http://google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ],*/
      editable  : true,
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      },
	  eventClick:function(event)
	  {
		
		swal({
			  title: "Are you sure to remove the item?",
			  text: "Item will be removed permanently from the list.",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes, delete it!",
			  closeOnConfirm: false
			},
			function(){
				
					  var id = event.id;
					   
					  $.ajax({
					   url:"calender_events/delete.php",
					   type:"POST",
					   data:{id:id},
					   success:function()
					   {
						calendar.fullCalendar('refetchEvents');
						swal("Removed!", "Selected Appointment has been removed.", "success");
					   }
					  })
				
				
			 
		   });
		
		
		
		
		 
		 
	  },
	  editable:true,
	  eventResize:function(event)
      {
		 var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
		 var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss") || start;
		 var title = event.title;
		 var id = event.id;
		 $.ajax({
		  url:"calender_events/update.php",
		  type:"POST",
		  data:{title:title, start:start, end:end, id:id},
		  success:function(){
		   calendar.fullCalendar('refetchEvents');
		   swal("Moved!", "Selected Appointment has been Moved to "+start, "success");
		  }
		 })
     },
	 editable:true,
	 eventDrop:function(event,end,status)
     {
		 var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
		 var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss") || start;
		 //var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
		
		 var title = event.title;
		 var id = event.id;
	
		 $.ajax({
		  url:"calender_events/update.php",
		  type:"POST",
		  data:{title:title, start:start, end:end, id:id},
		  success:function()
		  {
		   calendar.fullCalendar('refetchEvents');
		     swal("Moved!", "Selected Appointment has been Moved to "+start,  "success");
		  }
		 });
     }
	  
	  
	  
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }


	// Add Events to DataBase
		

	  var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"calender_events/insert.php",
       type:"POST",
       data:{title:val, start:start, end:end, bgColor:currColor},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Added Successfully");
       }
      })


	// Event Add to Database END



      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

	  //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })
  })
</script>
</body>
</html>