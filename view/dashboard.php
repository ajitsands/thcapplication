<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
	<!--<script src="assets/js/app.js"></script>-->
   
	<script src="../httpdocs/user_js/dashboard.js"></script>
    <script src="../httpdocs/user_js/login.js"></script>

  

<style>
    .custom-box, .custom-box-1, .custom-box-2, .custom-box-3 {
        min-height: 105px;
        width: 100%;
        border-radius: 12px;
        padding: 16px 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 20px;
    }

    /* Primary Navy Black Card (custom-box-1) */
    .custom-box-1 {
        background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-left: 5px solid #ffffff;
        box-shadow: 0 10px 25px -5px rgba(10, 25, 47, 0.4), 0 8px 10px -6px rgba(10, 25, 47, 0.2);
    }
    .custom-box-1:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 30px -10px rgba(10, 25, 47, 0.6);
        border-color: rgba(255, 255, 255, 0.35);
    }

    /* Secondary Dark Card (custom-box-3) */
    .custom-box-3 {
        background: linear-gradient(135deg, #112240 0%, #0a192f 100%);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-left: 5px solid #64ffda;
        box-shadow: 0 10px 25px -5px rgba(10, 25, 47, 0.4);
    }
    .custom-box-3:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 30px -10px rgba(10, 25, 47, 0.6);
    }

    /* Navy Blue Accent Card (custom-box) */
    .custom-box {
        background: linear-gradient(135deg, #0f233f 0%, #1e3a8a 100%);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-left: 5px solid #93c5fd;
        box-shadow: 0 10px 25px -5px rgba(15, 35, 63, 0.4);
    }
    .custom-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 30px -10px rgba(15, 35, 63, 0.6);
    }

    /* Deep Navy Card (custom-box-2) */
    .custom-box-2 {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-left: 5px solid #38bdf8;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.4);
    }
    .custom-box-2:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.6);
    }

    /* Card Title & Value Typography */
    .custom-box .row, .custom-box-1 .row, .custom-box-2 .row, .custom-box-3 .row {
        color: #ffffff !important;
    }
    .custom-box div[class*="col-"], .custom-box-1 div[class*="col-"], .custom-box-2 div[class*="col-"], .custom-box-3 div[class*="col-"] {
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.5px !important;
        text-transform: uppercase !important;
        opacity: 0.9 !important;
    }
    
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5); 
        z-index: 1;
    }
</style>

<?php 
  	   
 include_once(__DIR__ . '/../model/db_connection/connection.php');

    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
    ?>

<script>

<?php 
  	   
		 
           	$emparray = array();
                     //$sq_emp= "SELECT count(`employee_id`) as value,'Mgnt. Staffs' as name FROM `tbl_employees` WHERE `employee_type_id` in (1,2,3,4,5,10,11,12,13,14,15,16,17) and employee_status='Active' union SELECT count(`employee_id`) as value,'Technicians' as name FROM `tbl_employees` WHERE `employee_type_id` in (6,7,8) and employee_status='Active'  union SELECT count(`employee_id`) as value,'Drivers' as name FROM `tbl_employees`  WHERE `employee_type_name`='Driver' and employee_status='Active' union SELECT count(`employee_id`) as value,'Cleaners' as name FROM `tbl_employees` WHERE `employee_type_name`='Cleaner' and employee_status='Active' union  SELECT count(`employee_id`) as value,'Others' as name FROM `tbl_employees` WHERE `employee_type_id` not in (1,2,3,4,5,10,11,12,13,14,15,16,17,6,7,8,9,18) and employee_status='Active'";
                    $sq_emp="SELECT 
                            COUNT(`employee_id`) as value,
                            'Mgnt. Staffs' as name,
                            GROUP_CONCAT(DISTINCT employee_type_id ORDER BY employee_type_id) as ids
                        FROM 
                            `tbl_employees` 
                        WHERE 
                            `employee_type_id` in (1,2,3,4,5,10,11,12,13,14,15,16,17) 
                            AND `employee_status`='Active' 
                        GROUP BY 
                            name
                        
                        UNION 
                        
                        SELECT 
                            COUNT(`employee_id`) as value,
                            'Technicians' as name,
                            GROUP_CONCAT(DISTINCT employee_type_id ORDER BY employee_type_id) as ids
                        FROM 
                            `tbl_employees` 
                        WHERE 
                            `employee_type_id` in (6,7,8) 
                            AND `employee_status`='Active' 
                        GROUP BY 
                            name
                        
                        UNION 
                        
                        SELECT 
                            COUNT(`employee_id`) as value,
                            'Drivers' as name,
                            GROUP_CONCAT(DISTINCT employee_type_id ORDER BY employee_type_id) as ids
                        FROM 
                            `tbl_employees` 
                        WHERE 
                            `employee_type_name`='Driver' 
                            AND `employee_status`='Active' 
                        GROUP BY 
                            name
                        
                        UNION 
                        
                        SELECT 
                            COUNT(`employee_id`) as value,
                            'Cleaners' as name,
                            GROUP_CONCAT(DISTINCT employee_type_id ORDER BY employee_type_id) as ids
                        FROM 
                            `tbl_employees` 
                        WHERE 
                            `employee_type_name`='Cleaner' 
                            AND `employee_status`='Active' 
                        GROUP BY 
                            name
                        
                        UNION  
                        
                        SELECT 
                            COUNT(`employee_id`) as value,
                            'Others' as name,
                            GROUP_CONCAT(DISTINCT employee_type_id ORDER BY employee_type_id) as ids
                        FROM 
                            `tbl_employees` 
                        WHERE 
                            `employee_type_id` NOT IN (
                                SELECT DISTINCT employee_type_id FROM tbl_employees WHERE employee_status='Active' AND employee_type_id IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18)
                            )
                            AND `employee_status`='Active' 
                        GROUP BY 
                            name";
                                
                    $result_sq_emp = mysqli_query($varDBConnection,$sq_emp);
                     
                    while($row_emp =mysqli_fetch_assoc($result_sq_emp)){
                        $emparray[] = $row_emp;
                    }
                    $emparray= json_encode($emparray); 
                    
           
            ?>

            var EchartsPieDonutLight = function() {


    //
    // Setup module components
    //

    // Basic donut chart
    var _scatterPieDonutLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var pie_donut_element = document.getElementById('pie_donut');


        //
        // Charts configuration
        //

if (pie_donut_element) {

    // Initialize chart
    var pie_donut = echarts.init(pie_donut_element);

    // Options
    var options = {
        // Colors
        color: [
            '#2ec7c9', '#b6a2de', '#5ab1ef', '#ffb980', '#d87a80',
            '#8d98b3', '#e5cf0d', '#97b552', '#95706d', '#dc69aa',
            '#07a2a4', '#9a7fd1', '#588dd5', '#f5994e', '#c05050',
            '#59678c', '#c9ab00', '#7eb00a', '#6f5553', '#c14089'
        ],

        // Global text styles
        textStyle: {
            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
            fontSize: 13
        },

        // Add title
        title: {
            text: 'Employee Statistics',
            subtext: 'Category Wise',
            left: 'center',
            textStyle: {
                fontSize: 17,
                fontWeight: 500
            },
            subtextStyle: {
                fontSize: 12
            }
        },

        // Add tooltip
        tooltip: {
            trigger: 'item',
            backgroundColor: 'rgba(0,0,0,0.75)',
            padding: [10, 15],
            textStyle: {
                fontSize: 13,
                fontFamily: 'Roboto, sans-serif'
            },
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },

        // Add legend
        legend: {
            orient: 'vertical',
            top: 'center',
            left: 0,
            data: ['Mgnt. Staffs', 'Technicians', 'Drivers', 'Cleaners', 'Others'],
            itemHeight: 8,
            itemWidth: 8
        },

        // Add series
        series: [{
            name: 'Employees',
            type: 'pie',
            radius: ['50%', '70%'],
            center: ['50%', '57.5%'],
            itemStyle: {
                normal: {
                    borderWidth: 1,
                    borderColor: '#fff'
                }
            },

            data: <?PHP echo $emparray;?>
        }]
    };

    // Set chart options
    pie_donut.setOption(options);

    // Click event handler
    pie_donut.on('click', function(param) {
      var clickedData = param.data.ids; 
      console.log("Clicked data:", clickedData);
      window.open("employee-type.php?ids="+clickedData, '_blank');
    });
 


}



        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            pie_donut_element && pie_donut.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelector('.sidebar-control');
        sidebarToggle && sidebarToggle.addEventListener('click', triggerChartResize);

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _scatterPieDonutLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsPieDonutLight.init();
});
       
</script>
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

           
            var data = [
                {
                    "status": "Normal tickets",
                    "icon": "<i class='icon-history mr-2' style='color:#29B6F6'></i>",
                    "value": a,
                    "color": "#29B6F6"
                }, {
                    "status": "Urgent tickets",
                    "icon": "<i class='icon-history mr-2' style='color:#ff6700'></i>",
                    "value": b,
                    "color": "#ff6700"
                }, {
                    "status": "Emergency tickets",
                    "icon": "<i class='icon-history mr-2' style='color:#EF5350'></i>",
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


            arcPath.on('click', function (d, i) { 
                console.log("Clicked on division:", d.data.status);
                console.log("Value:", d.data.value);
                console.log("Color:", d.data.color);
            });

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
    $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_normal_graph',month_val:mm,year_val:yy,category:"all"}
	, function(result,status)
	  { 
	        var obj = jQuery.parseJSON(result);
           normal= obj.data[0].wo_normal;
            
            $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_urgent_graph',month_val:mm,year_val:yy,category:"all"}
	, function(result,status)
	  { 
	        var obj = jQuery.parseJSON(result);
           urgent= obj.data[0].wo_urgent;
            
            $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_emergency_graph',month_val:mm,year_val:yy,category:"all"}
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

<?php //include_once('dashboard/dashboard_piechart_all.php'); ?>
 

<body class="navbar-top">

	<!-- ===== THC Horizontal Top Navigation ===== -->
	<?PHP include_once('template/top_menu_new.inc'); ?>
	<!-- ===== /THC Horizontal Top Navigation ===== -->


	<!-- Main content (full width, no sidebar) -->
	<div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

		<!-- Content area -->
		<div class="content pt-0">

			<?PHP include_once('dashboard/dashboard_body.php'); ?>

		</div>
		<!-- /content area -->

		<?PHP include_once('template/reset_password_modal.php'); ?>

		<!-- Footer -->
		<?PHP include_once('template/footer.inc'); ?>
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