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
	<?PHP 
		include_once('template/head.inc');
	?>

</head>
    <?PHP 
		include_once('template/date_time.inc');
	?>
   	<!-- Core JS files -->
 <script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
	<script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>



	 
	<script src="global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
   <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

	<script src="global_assets/js/demo_pages/form_select2.js"></script>
	<!--<script src="assets/js/app.js"></script>-->
	<script src="global_assets/js/demo_pages/components_buttons.js"></script>
	<!--<script src="global_assets/js/demo_pages/widgets_stats.js"></script>-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>	

	<script src="../httpdocs/user_js/dashboard.js"></script>
    <script src="../httpdocs/user_js/login.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

	<script src="assets/js/app.js"></script>
	<script src="global_assets/js/demo_charts/google/light/bars/column.js"></script>



<style>
    .custom-box
    {
        height:75pt;
        width:100%;
        background-color:#ffcc00; 
        color:#262626;
        font-weight:bold;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding:10px;
        padding-top:20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.10);
    }
    .custom-box-1
    {
        height:75pt;
        width:100%;
        background-color:#00001a; 
        color:white;
        font-weight:bold;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding:10px;
        padding-top:20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.10);
    }
    
    .custom-box-2
    {
        height:75pt;
        width:100%;
        background-color:#ffdb4d; 
        color:#262626;
        font-weight:bold;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding:10px;
        padding-top:20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.10);
    }
    .custom-box-3
    {
        height:75pt;
        width:100%;
        background-color:#29293d; 
        color:white;
        font-weight:bold;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        padding:10px;
        padding-top:20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 15px 0 rgba(0, 0, 0, 0.10);
    }
    
    
</style>	
<script type="application/javascript">
//$(document).ready(function(){

setTimeout(function() {
  location.reload();
}, 120000);

var a,b,c;
var StatisticWidgets = function() {
   
      // Simple pie
    var _animatedPie = function(element, size,a,b,c) {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }
 
        // Initialize chart only if element exsists in the DOM
        if(element) {

            // Add data set
            var data = [
                {
                    "status": "Normal tickets",
                    "icon": "<i class='icon-history text-blue mr-2'></i>",
                    "value": a,
                    "color": "#29B6F6"
                }, {
                    "status": "Urgent tickets",
                    "icon": "<i class='icon-history text-warning mr-2'></i>",
                    "value": b,
                    "color": "#ff6700"
                }, {
                    "status": "Emergency tickets",
                    "icon": "<i class='icon-history text-danger mr-2'></i>",
                    "value": c,
                    "color": "#EF5350"
                }
            ];

            // Main variables
            var d3Container = d3.select(element),
                distance = 2, // reserve 2px space for mouseover arc moving
                radius = (size/2) - distance,
                sum = d3.sum(data, function(d) { return d.value; });


            // Tooltip
            // ------------------------------

            var tip = d3.tip()
                .attr('class', 'd3-tip')
                .offset([-10, 0])
                .direction('e')
                .html(function (d) {
                    return "<ul class='list-unstyled mb-1'>" +
                        "<li>" + "<div class='font-size-base my-1'>" + d.data.icon + d.data.status + "</div>" + "</li>" +
                        "<li>" + "Total: &nbsp;" + "<span class='font-weight-semibold float-right'>" + d.value + "</span>" + "</li>" +
                        // "<li>" + "Share: &nbsp;" + "<span class='font-weight-semibold float-right'>" + (100 / (sum / d.value)).toFixed(2) + "%" + "</span>" + "</li>" +
                    "</ul>";
                });


            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append("svg").call(tip);
            
            // Add SVG group
            var svg = container
                .attr("width", size)
                .attr("height", size)
                .append("g")
                    .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");  


            // Construct chart layout
            // ------------------------------

            // Pie
            var pie = d3.layout.pie()
                .sort(null)
                .startAngle(Math.PI)
                .endAngle(3 * Math.PI)
                .value(function (d) { 
                    return d.value;
                }); 

            // Arc
            var arc = d3.svg.arc()
                .outerRadius(radius);


            //
            // Append chart elements
            //

            // Group chart elements
            var arcGroup = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g") 
                    .attr("class", "d3-arc d3-slice-border")
                    .style({
                        'cursor': 'pointer'
                    });
            
            // Append path
            var arcPath = arcGroup
                .append("path")
                .style("fill", function (d) {
                    return d.data.color;
                });

            // Add tooltip
            arcPath
                .on('mouseover', function (d, i) {

                    // Transition on mouseover
                    d3.select(this)
                    .transition()
                        .duration(500)
                        .ease('elastic')
                        .attr('transform', function (d) {
                            d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                            var x = Math.sin(d.midAngle) * distance;
                            var y = -Math.cos(d.midAngle) * distance;
                            return 'translate(' + x + ',' + y + ')';
                        });
                })
                .on("mousemove", function (d) {
                    
                    // Show tooltip on mousemove
                    tip.show(d)
                        .style("top", (d3.event.pageY - 40) + "px")
                        .style("left", (d3.event.pageX + 30) + "px");
                })
                .on('mouseout', function (d, i) {

                    // Mouseout transition
                    d3.select(this)
                    .transition()
                        .duration(500)
                        .ease('bounce')
                        .attr('transform', 'translate(0,0)');

                    // Hide tooltip
                    tip.hide(d);
                });

            // Animate chart on load
            arcPath
                .transition()
                    .delay(function(d, i) { return i * 500; })
                    .duration(500)
                    .attrTween("d", function(d) {
                        var interpolate = d3.interpolate(d.startAngle,d.endAngle);
                        return function(t) {
                            d.endAngle = interpolate(t);
                            return arc(d);  
                        }; 
                    });


            //
            // Append counter
            //

            // Append element
            d3Container
                .append('h2')
                .attr('class', 'pt-1 mt-2 mb-1 font-weight-semibold');

            // Animate counter
            d3Container.select('h2')
                .transition()
                .duration(1500)
                .tween("text", function(d) {
                    var i = d3.interpolate(this.textContent, sum);

                    return function(t) {
                        this.textContent = d3.format(",d")(Math.round(i(t)));
                    };
                });
        }
    };
           return {
        init: function(a,b,c) {
          
            _animatedPie("#pie_basic", 150,a,b,c);
         
        }
    }
}();


// Initialize module
// ------------------------------

// When content loaded
document.addEventListener('DOMContentLoaded', function() {
    var d = new Date(),

    mm = d.getMonth()+1,

    yy = d.getFullYear();
     if(mm < 10){
       mm="0"+mm;
    } 
    var normal=0;
    var urgent=0;
    var emergency=0;
    $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_normal_graph',month_val:mm,year_val:yy}
	, function(result,status)
	  { 
	        var obj = jQuery.parseJSON(result);
           normal= obj.data[0].wo_normal;
            
            $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_urgent_graph',month_val:mm,year_val:yy}
	, function(result,status)
	  { 
	        var obj = jQuery.parseJSON(result);
           urgent= obj.data[0].wo_urgent;
            
            $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_emergency_graph',month_val:mm,year_val:yy}
	, function(result,status)
	  { 
	        var obj = jQuery.parseJSON(result);
           emergency= obj.data[0].wo_emergency;
            
            StatisticWidgets.init(normal,urgent,emergency);
            
	 });
            
	 });
          
          
         
            
	 });

    });
//});
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
				
			
					<div class="content">

					<!-- Column chart -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Column chart</h5>
						</div>

						<div class="card-body">
							<p class="mb-3">A column graph is a chart that uses <code>vertical</code> bars to show comparisons among categories. One axis of the chart shows the specific categories being compared, and the other axis represents a discrete value. Like all Google charts, column charts display tooltips when the user hovers over the data. By default, text labels are hidden, but can be turned on in chart settings.</p>

							<div class="chart-container">
								<div class="chart" id="google-column"></div>
							</div>
						</div>
					</div>
					<!-- /column chart -->


					<!-- Stacked column chart -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Stacked column chart</h5>
						</div>

						<div class="card-body">
							<p class="mb-3">Stacked <code>column</code> charts present the information in the same sequence on each bar. The stacked bar chart stacks bars that represent different groups on top of each other. The height of the resulting bar shows the combined result of the groups. However, stacked bar charts are not suited to datasets where some groups have negative values. In such cases, grouped bar charts are preferable.</p>

							<div class="chart-container">
								<div class="chart" id="google-column-stacked"></div>
							</div>
						</div>
					</div>
					<!-- /stacked column chart -->


					<!-- Bar chart -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Bar chart</h5>
						</div>

						<div class="card-body">
							<p class="mb-3">A bar graph is a chart that uses <code>horizontal</code> bars to show comparisons among categories. One axis of the chart shows the specific categories being compared, and the other axis represents a discrete value. Like all Google charts, column charts display tooltips when the user hovers over the data. By default, text labels are hidden, but can be turned on in chart settings.</p>

							<div class="chart-container">
								<div class="chart" id="google-bar"></div>
							</div>
						</div>
					</div>
					<!-- /bar chart -->


					<!-- Stacked bar chart -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Stacked bar chart</h5>
						</div>

						<div class="card-body">
							<p class="mb-3">Stacked <code>column</code> charts present the information in the same sequence on each bar. The stacked bar chart stacks bars that represent different groups on top of each other. The height of the resulting bar shows the combined result of the groups. However, stacked bar charts are not suited to datasets where some groups have negative values. In such cases, grouped bar charts are preferable.</p>

							<div class="chart-container">
								<div class="chart" id="google-bar-stacked"></div>
							</div>
						</div>
					</div>
					<!-- /stacked bar chart -->


					<!-- Simple histogram -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Simple histogram</h5>
						</div>

						<div class="card-body">
							<p class="mb-3">A <code>histogram</code> is a chart that groups numeric data into bins, displaying the bins as segmented columns. They're used to depict the distribution of a dataset: how often values fall into ranges. Google Charts automatically chooses the number of bins for you. All bins are equal width and have a height proportional to the number of data points in the bin. In other respects, histograms are similar to column charts.</p>

							<div class="chart-container">
								<div class="chart" id="google-histogram"></div>
							</div>
						</div>
					</div>
					<!-- /simple histogram -->


					<!-- Combo chart -->
					<div class="card">
						<div class="card-header">
							<h5 class="mb-0">Combo chart</h5>
						</div>

						<div class="card-body">
							<p class="mb-3">Example of <code>combo</code> chart based on Google Visualization library. A chart that lets you render each series as a different marker type from the following list: line, area, bars, candlesticks, and stepped area. To assign a default marker type for series, specify the seriesType property. Use the series property to specify properties of each series individually.</p>

							<div class="chart-container">
								<div class="chart" id="google-combo"></div>
							</div>
						</div>
					</div>
					<!-- /combo chart -->

				</div>
				<!-- /content area -->
				
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