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
	 <script>
        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>
    
	
	

        <link href="calendar/css/mobiscroll.jquery.min.css" rel="stylesheet" />
        <script src="calendar/js/mobiscroll.jquery.min.js"></script>


	 <style type="text/css">
    body {
        margin: 0;
        padding: 0;
    }

    body,
    html {
        height: 100%;
    }
    
    .md-custom-event-img {
    width: 30px;
    height: 30px;
}

.mbsc-custom-event-name {
    padding: 0 10px;
}

.md-custom-event-cont {
    display: flex;
    align-items: center;
    padding-top: 10px;
    font-size: 13px;
}

.md-custom-event-btn.mbsc-button {
    position: absolute;
    right: 10px;
    bottom: 8px;
    line-height: 20px;
    padding: 0px 6px;
}

.custom-event-popover.mbsc-material .mbsc-popover-list .mbsc-event {
    padding: 10px 14px;
}

.custom-event-popover.mbsc-ios .mbsc-popover-list {
    width: 340px;
}

.custom-event-popover.mbsc-material .mbsc-popover-list {
    width: 320px;
}

.custom-event-popover.mbsc-windows .mbsc-popover-list {
    width: 340px;
}

    </style>
   

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
				<div>
                    <div id="demo-custom-event-popover"></div>
                </div>
				
				<!-- /large navbar -->


			</div>
			<!-- /content area -->
            <?PHP 
				include_once('template/reset_password_modal.php');
			?>

			<!-- Footer -->
			
			<?PHP 
					include_once('template/footer.inc');
			?>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	
	
	

<script>

       mobiscroll.setOptions({
        locale: mobiscroll.localeEn,                // Specify language like: locale: mobiscroll.localePl or omit setting to use default
        theme: 'ios',                               // Specify theme like: theme: 'ios' or omit setting to use default
            themeVariant: 'light'                   // More info about themeVariant: https://docs.mobiscroll.com/5-1-1/eventcalendar#opt-themeVariant
    });
    
    $(function () {
    
        var inst = $('#demo-custom-event-popover').mobiscroll().eventcalendar({
            
            view: {                   // More info about view: https://docs.mobiscroll.com/5-1-1/eventcalendar#opt-view
                calendar: {
                    popover: true,
                    popoverClass: 'custom-event-popover'
                }
            },
            renderEventContent: function (data) {   // More info about renderEventContent: https://docs.mobiscroll.com/5-1-1/eventcalendar#opt-renderEventContent
                return '<div">' + data.title + '</div>' +
                    '<div class="md-custom-event-cont">' +
                    '<div class="mbsc-custom-event-name">'+'Anisha'+ '</div>' +
                    '<div class="mbsc-custom-event-name">'+data.start + '</div>' +
                    '<button mbsc-button class="md-custom-event-btn" data-color="primary" data-variant="outline">Add participant</button>' +
                    '</div>';
            },
            onEventClick: function (event, inst) {  // More info about onEventClick: https://docs.mobiscroll.com/5-1-1/eventcalendar#event-onEventClick
                if (event.domEvent.target.classList.contains('md-custom-event-btn')) {
                    event.domEvent.stopPropagation();
                    mobiscroll.toast({ 
                        
                        message: 'event clicked'
                    });
                }
            }
        }).mobiscroll('getInst');
    
        function getParticipant(id) {
            switch (id) {
                case 1:
                    return {
                        img: 'https://img.mobiscroll.com/demos/m1.png',
                        name: 'Barry L.'
                    };
                case 2:
                    return {
                        img: 'https://img.mobiscroll.com/demos/f1.png',
                        name: 'Hortense T.'
                    };
                case 3:
                    return {
                        img: 'https://img.mobiscroll.com/demos/m2.png',
                        name: 'Carl H.'
                    };
            }
        }
    
        $.getJSON('../controller/amc/app_calendar.php', function (events) {
            inst.setEvents(events);
        }, 'jsonp');
    
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