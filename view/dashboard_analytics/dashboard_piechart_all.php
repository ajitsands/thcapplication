
<?php 
  	   
   include_once(__DIR__ . '/../../model/db_connection/connection.php');

    $DBConn = new DBConnection();
    $varDBConnection = $DBConn->ConnectToMYSQL();
    
   
    ?>
<?php
    $Query = "SELECT c.category_id, c.category_name, IFNULL(COUNT(t.category_id), 0) AS count_wo FROM tbl_category c LEFT JOIN tbl_tickets t ON c.category_id = t.category_id AND t.ticket_status != 'Cancelled' AND t.ticket_priority NOT IN ('Emergency', 'Urgent') AND DATE_FORMAT(t.created_date_time, '%Y-%m') = '".$_GET['yearmonth']."' GROUP BY c.category_id";
	
	$resultCategories = mysqli_query($varDBConnection,$Query);

    function generateRandomColor() 
    {
        $red = mt_rand(0, 255);
        $green = mt_rand(0, 255);
        $blue = mt_rand(0, 255);
        $hexColor = sprintf("#%02x%02x%02x", $red, $green, $blue);
        return $hexColor;
   }
?>
<style>
.legend-container {
    margin-top: 20px;
}

.legend {
    /* This is where legend items will be appended */
}

.legend-item {
    margin-bottom: 3px; /* Adjust the margin to reduce space between legend items */
    display: flex;
    align-items: center;
}

.legend-color {
    width: 15px; /* Reduce the width of the color indicator */
    height: 15px; /* Reduce the height of the color indicator */
    margin-right: 5px;
    display: inline-block;
}

.legend-label {
    margin-right: 5px; /* Adjust the margin between label and value */
    font-size: 15px; /* Reduce the font size of the label */
}

.legend-value {
    font-size: 15px; /* Reduce the font size of the value */
    font-weight: bold;
}

</style>
<!------ PIE CHART FOR ALL -------->
<div class="card-body text-center" id="modal_pie_chart">
    <div class="svg-center" id="pie_basic_forAll"></div>
    <div id="legendContainer" class="legend-container">
        <div class="legend"></div>
    </div>
</div>    
<script type="application/javascript">
$(document).ready(function(){
var StatisticWidgetsForAll = function() {
    var _animatedPie = function(element, size) {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        if (element) {
            var originalData = [
                <?php foreach($resultCategories as $category) { ?>
                {
                    "status": "<?php echo $category['category_name'] ?>",
                    "indicator": "<?php echo $category['indicator'] ?>", // Assuming you have an indicator field in your data
                    "value": <?php echo $category['count_wo'] ?>,
                    "color": "<?php echo generateRandomColor(); ?>"
                },
                <?php } ?>
            ];

            // Filter data with value greater than 0
            var data = originalData.filter(function(category) {
                return category.value > 0;
            });

            var d3Container = d3.select(element),
                distance = 2,
                radius = (size / 2) - distance,
                sum = d3.sum(data, function(d) {
                    return d.value;
                });

            var tip = d3.tip()
                .attr('class', 'd3-tip')
                .offset([-10, 0])
                .direction('e')
                .html(function(d) {
                    return "<ul class='list-unstyled mb-1'>" +
                        "<li>" + "<div class='font-size-base my-1'>" + d.data.indicator + "</div>" + "</li>" +
                        "<li>" + "Total: &nbsp;" + "<span class='font-weight-semibold float-right'>" + d.value + "</span>" + "</li>" +
                        "</ul>";
                });

            var container = d3Container.append("svg").call(tip);

            var svg = container
                .attr("width", size)
                .attr("height", size)
                .append("g")
                .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");

            var pie = d3.layout.pie()
                .sort(null)
                .startAngle(Math.PI)
                .endAngle(3 * Math.PI)
                .value(function(d) {
                    return d.value;
                });

            var arc = d3.svg.arc()
                .outerRadius(radius);

            var arcGroup = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g")
                .attr("class", "d3-arc d3-slice-border")
                .style({
                    'cursor': 'pointer'
                });

            var arcPath = arcGroup
                .append("path")
                .style("fill", function(d) {
                    return d.data.color;
                });

            // Add tooltip
            arcPath
                .on('mouseover', function(d, i) {
                    // Transition on mouseover
                    d3.select(this)
                        .transition()
                        .duration(500)
                        .ease('elastic')
                        .attr('transform', function(d) {
                            d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                            var x = Math.sin(d.midAngle) * distance;
                            var y = -Math.cos(d.midAngle) * distance;
                            return 'translate(' + x + ',' + y + ')';
                        });
                })
                .on("mousemove", function(d) {
                    // Show tooltip on mousemove
                    tip.show(d)
                        .style("top", (d3.event.pageY - 40) + "px")
                        .style("left", (d3.event.pageX + 30) + "px");
                })
                .on('mouseout', function(d, i) {
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
                .delay(function(d, i) {
                    return i * 500;
                })
                .duration(500)
                .attrTween("d", function(d) {
                    var interpolate = d3.interpolate(d.startAngle, d.endAngle);
                    return function(t) {
                        d.endAngle = interpolate(t);
                        return arc(d);
                    };
                });

            arcPath.on('click', function(d, i) {
                console.log("Clicked on division:", d.data.status);
                console.log("Value:", d.data.value);
                console.log("Color:", d.data.color);
            });

            // Append legend element
            var legend = d3Container.append('div')
                .attr('class', 'legend');
        
            var legendItems = legend.selectAll('.legend-item')
                .data(data)
                .enter()
                .append('div')
                .attr('class', 'legend-item');
        
            // Append color indicators
            legendItems.append('span')
                .attr('class', 'legend-color')
                .style('background-color', function(d) {
                    return d.color;
                });
        
            // Append category names and indicators
            legendItems.append('span')
                .attr('class', 'legend-label')
                .html(function(d) {
                    return d.indicator + " - " + d.status; // Display both indicator and status
            });
        
            // Append total values
            legendItems.append('span')
                .attr('class', 'legend-value')
                .text(function(d) {
                    return d.value;
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
        init: function() {
            _animatedPie("#pie_basic_forAll", 200); // Increase the size to 300
        }
    };
}();
StatisticWidgetsForAll.init();
});
</script>