$(document).ready(function(){
 		   
					   	$("#a_today").click(function(){
							
							$(".span_select").html('Today');
							 $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_today',criteria:'opened'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_open_wo").html(obj.data[0].today_wo_opened);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_today',criteria:'closed'}
									, function(result,status)
							  { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_close_wo").html(obj.data[0].today_wo_closed);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_today',criteria:'pending'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_pending_wo").html(obj.data[0].today_wo_pending);
							 });
							
						});
							$("#a_this_week").click(function(){
							
							$(".span_select").html('This Week');
							 $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_week',criteria:'opened'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_open_wo").html(obj.data[0].week_wo_opened);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_week',criteria:'closed'}
									, function(result,status)
							  { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_close_wo").html(obj.data[0].week_wo_closed);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_week',criteria:'pending'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_pending_wo").html(obj.data[0].week_wo_pending);
							 });
							
						});
							$("#a_this_month").click(function(){
							
							$(".span_select").html('This Month');
							 $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_month',criteria:'opened'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_open_wo").html(obj.data[0].month_wo_opened);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_month',criteria:'closed'}
									, function(result,status)
							  { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_close_wo").html(obj.data[0].month_wo_closed);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_month',criteria:'pending'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_pending_wo").html(obj.data[0].month_wo_pending);
							 });
							
						});
							$("#a_this_year").click(function(){
							
							$(".span_select").html('This Year');
							 $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_year',criteria:'opened'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_open_wo").html(obj.data[0].year_wo_opened);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_year',criteria:'closed'}
									, function(result,status)
							  { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_close_wo").html(obj.data[0].year_wo_closed);
							 });
							  $.post("../controller/dashboard/dashboard_controller.php",{action:'check_wo_year',criteria:'pending'}
									, function(result,status)
							 { 
							        var obj = jQuery.parseJSON(result);
			                        $("#span_pending_wo").html(obj.data[0].year_wo_pending);
							 });
							
						});
						
 
var mm,yy;
function graph_load(mm,yy)
{
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
}

$("#select_month").change(function () {
   
    var months= $("#select_month").val();
    var years= $("#select_year").val();
    var month_text=$("#select_month option:selected").text();
    
    if(months!=0 && years!=0 && years!=null && months!=null)
    {
       
        $("#graph_title").html(month_text+' '+years);
         $("#pie_basic").remove();
        
          $("#pie_card").prepend('<div class="svg-center" id="pie_basic"></div>');
       graph_load(months,years);
    }
    else
    {
        return false;
    }
 });
 $("#select_year").change(function () {

    var months= $("#select_month").val();
    var years= $("#select_year").val();
   var month_text=$("#select_month option:selected").text();
    if(months!=0 && years!=0 && years!=null && months!=null)
    {
        
         
       $("#graph_title").html(month_text+' '+years);
        $("#pie_basic").remove();
          $("#pie_card").prepend('<div class="svg-center" id="pie_basic"></div>');
       graph_load(months,years); 
    }
    else
    {
        return false;
    }
     
 });
 

					  
});