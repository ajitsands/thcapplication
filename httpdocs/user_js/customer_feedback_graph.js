$(document).ready(function(){
  
        $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
        
       
function date_covert(d)
{
var now = new Date(d);

var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);

var dates = now.getFullYear()+"-"+(month)+"-"+(day) ;

return dates;
 }

     
       $('#txt_start_date').val(date_covert($('#txt_stdate_val').val()));
       $('#txt_end_date').val(date_covert($('#txt_enddate_val').val()));
       $("#select_category").val($('#txt_cate_val').val()).trigger("change"); 
       $("#select_customer").val($('#txt_cust_id').val()).trigger("change"); 
        $('#btn_search_feedback').click(function(){
            	var cate_val=$("#select_category option:selected").val();
                var cat_text=$("#select_category option:selected").text();
		        var cust_id=$("#select_customer option:selected").val();
		        var cust_name=$("#select_customer option:selected").text();
		        var start_date=$('#txt_start_date').val();
                var end_date=$('#txt_end_date').val();
               
                if(start_date=='' || end_date=='')
            		{
            		    swal("Warning","Please specify the date range...", "warning");
                      
                        return false;  
            		}
            	if(end_date<start_date)
            		{
            		    swal("Warning","Please provide valid date range...", "warning");
                       
                        return false; 
            		}
        		else
        		{
        		    var filePath="customer_feedback_graph.php?start_date="+start_date+"&end_date="+end_date+"&cust_id="+cust_id+"&cust_name="+cust_name+"&cat_val="+cate_val+"&cat_text="+cat_text;
				    window.open(filePath, '_self');
        		}
        });
               

});