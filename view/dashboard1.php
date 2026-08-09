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


	<!-- /global stylesheets -->
 <?PHP 
		include_once('template/date_time.inc');
	?>

	
	<!-- Core JS files -->
	<script src="global_assets/js/main/jquery.min.js"></script>
	<script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="global_assets/js/plugins/buttons/spin.min.js"></script>
	<script src="global_assets/js/plugins/buttons/ladda.min.js"></script>
	<script src="assets/js/app.js"></script>
	<script src="global_assets/js/demo_pages/components_buttons.js"></script>
	<script src="global_assets/js/demo_pages/widgets_stats.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>	
    <script src="../httpdocs/user_js/login.js"></script>
    
 
    
    
	<!-- /theme JS files -->

	<link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
</head>
<script>
var StatisticWidgets = function() {


      // Simple pie
    var _animatedPie = function(element, size) {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Initialize chart only if element exsists in the DOM
        if(element) {

            // Add data set
            var data = [
                {
                    "status": "Pending tickets",
                    "icon": "<i class='icon-history text-blue mr-2'></i>",
                    "value": 938,
                    "color": "#29B6F6"
                }, {
                    "status": "Resolved tickets",
                    "icon": "<i class='icon-checkmark3 text-success mr-2'></i>",
                    "value": 490,
                    "color": "#66BB6A"
                }, {
                    "status": "Closed tickets",
                    "icon": "<i class='icon-cross2 text-danger mr-2'></i>",
                    "value": 789,
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
                        "<li>" + "Share: &nbsp;" + "<span class='font-weight-semibold float-right'>" + (100 / (sum / d.value)).toFixed(2) + "%" + "</span>" + "</li>" +
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
        init: function() {
           
            _animatedPie("#pie_basic", 150);
         
        }
    }
}();


// Initialize module
// ------------------------------

// When content loaded
document.addEventListener('DOMContentLoaded', function() {
    StatisticWidgets.init();
});
</script>

    
<body>

	


	


			<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->

	<!-- Main content -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

			<!-- Content area -->
			<div class="content">

				<div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4> <span class="font-weight-semibold">Dashboard</span> </h4>
						<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
					</div>

					<div class="header-elements d-none">
						<div class="d-flex justify-content-center">
							<!--<a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>-->
							<!--<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>-->
							<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Calender</span></a>
						</div>
					</div>
				</div>
				</div>
				<br>

				<div class="row">
					<div class="col-sm-6 col-xl-3">

						<!-- Satisfaction rate -->
						<div class="card card-body text-center">
						    
							<div class="mr-3 align-self-center">
									<i class="icon-bag icon-3x text-success-400"></i>
								</div>

							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold">100</h2>

						Work Orders Today
							
						</div>
						<!-- /satisfaction rate -->
						<div class="card card-body text-center">
						<div class="mr-3 align-self-center">
									<i class="icon-enter6 icon-3x text-danger-400"></i>
									
								</div>
							
									
			                	
							<h2 class="progress-percentage mt-2 mb-1 font-weight-semibold">10</h2>

							High Priority Work Orders
							
						</div>

					</div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">Work Order Statistics</h6>
								<div class="header-elements">
								
									<div class="list-icons ml-3">
				                		<div class="dropdown">
				                			<a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-sync"></i> Today</a>
												<a href="#" class="dropdown-item"><i class="icon-list-unordered"></i> This Week</a>
												<a href="#" class="dropdown-item"><i class="icon-pie5"></i> This Month</a>
													<a href="#" class="dropdown-item"><i class="icon-pie5"></i> This Year</a>
												
											</div>
				                		</div>
				                	</div>
								</div>
							</div>

							<div class="card-body">
								<div class="chart mb-3" id="bullets"></div>

								<ul class="media-list">
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-alignment-unalign"></i></a>
										</div>
										
										<div class="media-body text-center">
										    Opened Work Orders 
										    <h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><span class="font-weight-semibold text-danger">120</span></h2>
											
										</div>

										
									</li>
									<hr>
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i class="icon-checkmark3"></i></a>
										</div>
										
										<div class="media-body text-center">
										    Closed Work Orders 
										    <h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><span class="font-weight-semibold text-danger">333</span></h2>
											
										</div>

										
									</li>
										<hr>
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-pink text-pink rounded-round border-2 btn-icon"><i class="icon-statistics"></i></a>
										</div>
										
										<div class="media-body text-center">
										    Pending Work Orders 
										    <h2 class="progress-percentage mt-2 mb-1 font-weight-semibold"><span class="font-weight-semibold text-danger">211</span></h2>
											
										</div>

										
									</li>

								

								</ul>
							</div>
						</div>
</div>
				<div class="col-sm-6 col-xl-6">

						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">Recent Work Orders</h6>
								<div class="header-elements">
									
									<span class="badge bg-danger-400 badge-pill">+86</span>
									&nbsp;&nbsp;
									<button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button>
								</div>
							</div>

							<div class="card-body">
								<div class="chart mb-3" id="bullets"></div>

								<ul class="media-list">
									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-pink text-pink rounded-round border-2 btn-icon"><i class="icon-statistics"></i></a>
										</div>
										
										<div class="media-body">
											Stats for July, 6: <span class="font-weight-semibold">1938</span> orders, <span class="font-weight-semibold text-danger">$4220</span> revenue
											<div class="text-muted">2 hours ago</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i class="icon-checkmark3"></i></a>
										</div>
										
										<div class="media-body">
											Invoices <a href="#">#4732</a> and <a href="#">#4734</a> have been paid
											<div class="text-muted">Dec 18, 18:36</div>
										</div>

										<div class="ml-3 align-self-center">
										<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-alignment-unalign"></i></a>
										</div>
										
										<div class="media-body">
											Affiliate commission for June has been paid
											<div class="text-muted">36 minutes ago</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-warning-400 text-warning-400 rounded-round border-2 btn-icon"><i class="icon-spinner11"></i></a>
										</div>

										<div class="media-body">
											Order <a href="#">#37745</a> from July, 1st has been refunded
											<div class="text-muted">4 minutes ago</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon"><i class="icon-redo2"></i></a>
										</div>
										
										<div class="media-body">
											Invoice <a href="#">#4769</a> has been sent to <a href="#">Robert Smith</a>
											<div class="text-muted">Dec 12, 05:46</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>
								</ul>
							</div>
						</div>

					</div>
                    <div class="col-sm-6 col-xl-3">

						<!-- Basic animated pie -->
						<div class="card card-body text-center" style="height:320px">
							<div class="svg-center" id="pie_basic"></div>

							<span class="font-weight-semibold">Orders in June</span>
							<div class="font-size-sm text-muted">+38% since 2016</div>
						</div>
						<!-- /basic animated pie -->

					</div>
				<div class="col-sm-6 col-xl-3">
				    <div class="card">
				    <div class="card-header header-elements-inline">
								<h6 class="card-title">Recent Work Orders</h6>
								<div class="header-elements">
									
									<button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button>
								</div>
							</div>
						<div class=" card-body">
							<div class="media">
								<div class="mr-3 align-self-center">
									<i class="icon-pointer icon-3x text-success-400"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="font-weight-semibold mb-0">652,549</h3>
									<span class="text-uppercase font-size-sm text-muted">Total CPR Expired</span>
								</div>
							</div>
						</div>
						</div>
						<div class="card">
				            <div class="card-header header-elements-inline">
								<h6 class="card-title">Recent Work Orders</h6>
								<div class="header-elements">
									
									<button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button>
								</div>
							</div>
						<div class=" card-body">
							<div class="media">
								<div class="mr-3 align-self-center">
									<i class="icon-enter6 icon-3x text-indigo-400"></i>
								</div>

								<div class="media-body text-right">
									<h3 class="font-weight-semibold mb-0">245,382</h3>
									<span class="text-uppercase font-size-sm text-muted">Total Visa Expired</span>
								</div>
							</div>
						</div>
						</div>
					</div>

						<div class="col-sm-6 col-xl-6">

						<div class="card">
							<div class="card-header header-elements-inline">
								<h6 class="card-title">AMC Renewals</h6>
								<div class="header-elements">
									
									<span class="badge bg-danger-400 badge-pill">+86</span>
									&nbsp;&nbsp;
									<button type="button" class="btn btn-info btn-icon"><i class="icon-link"></i></button>
								</div>
							</div>

							<div class="card-body">
								<div class="chart mb-3" id="bullets"></div>

								<ul class="media-list">
									<li class="media">
										<div class="mr-3">
														<a href="#" class="btn bg-teal-400 rounded-round btn-icon btn-sm">
															<span class="letter-icon"></span>
														</a>
										</div>
										
										<div class="media-body">
										<div>
														<a href="#" class="text-default font-weight-semibold letter-icon-title">Annabelle Doney</a>
														<div class="text-muted font-size-sm"><span class="badge badge-mark border-blue mr-1"></span> Active</div>
													</div>
											<div class="text-muted">2 hours ago</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i class="icon-checkmark3"></i></a>
										</div>
										
										<div class="media-body">
											Invoices <a href="#">#4732</a> and <a href="#">#4734</a> have been paid
											<div class="text-muted">Dec 18, 18:36</div>
										</div>

										<div class="ml-3 align-self-center">
										<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-alignment-unalign"></i></a>
										</div>
										
										<div class="media-body">
											Affiliate commission for June has been paid
											<div class="text-muted">36 minutes ago</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-warning-400 text-warning-400 rounded-round border-2 btn-icon"><i class="icon-spinner11"></i></a>
										</div>

										<div class="media-body">
											Order <a href="#">#37745</a> from July, 1st has been refunded
											<div class="text-muted">4 minutes ago</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>

									<li class="media">
										<div class="mr-3">
											<a href="#" class="btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon"><i class="icon-redo2"></i></a>
										</div>
										
										<div class="media-body">
											Invoice <a href="#">#4769</a> has been sent to <a href="#">Robert Smith</a>
											<div class="text-muted">Dec 12, 05:46</div>
										</div>

										<div class="ml-3 align-self-center">
											<span class="badge bg-success-400">Pending</span>
										</div>
									</li>
								</ul>
							</div>
						</div>

					</div>
				</div>

		
			</div>
			<!-- /content area -->


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
